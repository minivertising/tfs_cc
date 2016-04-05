<?
	// 유입매체 정보 입력
	function BR_InsertTrackingInfo($media, $gubun)
	{
		global $_gl;
		global $my_db;

		$query		= "INSERT INTO ".$_gl['tracking_info_table']."(tracking_media, tracking_refferer, tracking_ipaddr, tracking_date, tracking_gubun) values('".$media."','".$_SERVER['HTTP_REFERER']."','".$_SERVER['REMOTE_ADDR']."',now(),'".$gubun."')";
		$result		= mysqli_query($my_db, $query);
	}

	function winner_draw($mb_phone)
	{
		global $_gl;
		global $my_db;

		$first_winner				= 1000;	// 아밤 + 헝가리 워터 에센스
		$second_winner			= 3000;	// 아밤
		$third_winner			= 70000;	// 3종 샤셰

		$first_array				= array("N","N","N","N","N","N","N","N","N","N");
		$second_array			= array("Y","N");

		// 오늘의 이벤트 참여자 수 구하기
		$total_query		= "SELECT * FROM ".$_gl['member_info_table']." WHERE mb_regdate like '%".date("Y-m-d")."%'";
		$total_result		= mysqli_query($my_db, $total_query);
		$total_num		= mysqli_num_rows($total_result);

		// 중복 당첨 체크
		$dupli_query		= "SELECT * FROM ".$_gl['member_info_table']." WHERE mb_phone='".$mb_phone."' AND mb_winner like '%Y%'";
		$dupli_result		= mysqli_query($my_db, $dupli_query);
		$dupli_num		= mysqli_num_rows($dupli_result);

		// 1등 상품 당첨자 수
		$first_query		= "SELECT * FROM ".$_gl['member_info_table']." WHERE mb_winner='Y||FIRST'";
		$first_result		= mysqli_query($my_db, $first_query);
		$first_num		= mysqli_num_rows($first_result);

		// 2등 상품 당첨자 수
		$second_query		= "SELECT * FROM ".$_gl['member_info_table']." WHERE mb_winner='Y||SECOND'";
		$second_result		= mysqli_query($my_db, $second_query);
		$second_num		= mysqli_num_rows($second_result);

		// 3등 상품 당첨자 수
		$third_query 	= "SELECT * FROM ".$_gl['member_info_table']." WHERE mb_phone='".$mb_phone."' AND mb_winner like '%THIRD%'";
		$third_result 	= mysqli_query($my_db, $third_query);
		$third_cnt	= mysqli_num_rows($third_result);

		if ($dupli_num > 0)
		{
			if ($third_cnt > 0)
				$winner = "D||THIRD";
			else
				$winner = "N||THIRD";
		}else{

			shuffle($first_array);
			if ($first_array[0] == "Y")
			{
				if ($first_winner >= $first_num)
				{
					$winner = "Y||FIRST";
				}else{
					if ($third_cnt > 0)
						$winner = "D||THIRD";
					else
						$winner = "N||THIRD";
				}
			}else{
				shuffle($second_array);
				if ($second_array[0] == "Y")
				{
					if ($second_winner >= $second_num)
					{
						$winner = "Y||SECOND";
					}else{
						if ($third_cnt > 0)
							$winner = "D||THIRD";
						else
							$winner = "N||THIRD";
					}
				}else{
					if ($third_cnt > 0)
						$winner = "D||THIRD";
					else
						$winner = "N||THIRD";
				}
			}
		}
		return $winner;
	}



	function BC_getSerial()
	{
		global $_gl;
		global $my_db;

		$query		= "SELECT serial_code FROM ".$_gl['serial_info_table']." WHERE useYN='N' limit 1";
		$result		= mysqli_query($my_db, $query);
		$data			= mysqli_fetch_array($result);

		$query2		= "UPDATE ".$_gl['serial_info_table']." SET useYN='Y' WHERE serial_code='".$data['serial_code']."'";
		$result2		= mysqli_query($my_db, $query2);

		return $data['serial_code'];
	}

	// LMS 발송 
	function send_lms($phone, $serial, $winner)
	{
		global $_gl;
		global $my_db;

		$s_url		= "http://www.belif-play.com/MOBILE/coupon_page.php?serial=".$serial; // URL 변경 해야함.
		$httpmethod = "POST";
		$url = "http://api.openapi.io/ppurio/1/message/lms/minivertising";
		$clientKey = "MTAyMC0xMzg3MzUwNzE3NTQ3LWNlMTU4OTRiLTc4MGItNDQ4MS05NTg5LTRiNzgwYjM0ODEyYw==";
		$contentType = "Content-Type: application/x-www-form-urlencoded";

		if ($winner == "Y||FIRST")
			$response = sendRequest_first($httpmethod, $url, $clientKey, $contentType, $phone, $s_url);
		else if ($winner == "Y||SECOND")
			$response = sendRequest_second($httpmethod, $url, $clientKey, $contentType, $phone, $s_url);
		else
			$response = sendRequest_third($httpmethod, $url, $clientKey, $contentType, $phone, $s_url);

		$json_data = json_decode($response, true);

		/*
		받아온 결과값을 DB에 저장 및 Variation
		*/
		$query3 = "INSERT INTO sms_info(send_phone, send_status, cmid, send_regdate) values('".$phone."','".$json_data['result_code']."','".$json_data['cmid']."','".date("Y-m-d H:i:s")."')";
		$result3 		= mysqli_query($my_db, $query3);

		$query2 = "UPDATE member_info SET mb_lms='Y' WHERE mb_phone='".$phone."'";
		$result2 		= mysqli_query($my_db, $query2);

		if ($json_data['result_code'] == "200")
			$flag = "Y";
		else
			$flag = "N";

		return $flag;
	}

	// LMS 발송 
	function send_lms2($phone, $serial, $winner)
	{
		global $_gl;
		global $my_db;

		$s_url		= "http://www.belif-play.com/MOBILE/coupon_page.php?serial=".$serial; // URL 변경 해야함.
		$httpmethod = "POST";
		$url = "http://api.openapi.io/ppurio/1/message/lms/minivertising";
		$clientKey = "MTAyMC0xMzg3MzUwNzE3NTQ3LWNlMTU4OTRiLTc4MGItNDQ4MS05NTg5LTRiNzgwYjM0ODEyYw==";
		$contentType = "Content-Type: application/x-www-form-urlencoded";

		if ($winner == "Y||FIRST")
			$response = sendRequest_first($httpmethod, $url, $clientKey, $contentType, $phone, $s_url);
		else if ($winner == "Y||SECOND")
			$response = sendRequest_second($httpmethod, $url, $clientKey, $contentType, $phone, $s_url);
		else
			$response = sendRequest_third($httpmethod, $url, $clientKey, $contentType, $phone, $s_url);

		$json_data = json_decode($response, true);

		/*
		받아온 결과값을 DB에 저장 및 Variation
		*/
		$query3 = "INSERT INTO sms_info(send_phone, send_status, cmid, send_regdate) values('".$phone."','".$json_data['result_code']."','".$json_data['cmid']."','".date("Y-m-d H:i:s")."')";
		$result3 		= mysqli_query($my_db, $query3);

		$query2 = "UPDATE member_info SET mb_lms='Y' WHERE mb_phone='".$phone."'";
		$result2 		= mysqli_query($my_db, $query2);

		if ($json_data['result_code'] == "200")
			$flag = "Y";
		else
			$flag = "N";

		return $flag;
	}

	function sendRequest_first($httpMethod, $url, $clientKey, $contentType, $phone, $s_url) {

		//create basic authentication header
		$headerValue = $clientKey;
		$headers = array("x-waple-authorization:" . $headerValue);

		$params = array(
			'send_time' => '', 
			'send_phone' => '025322475', 
			'dest_phone' => $phone, 
			//'dest_phone' => '01099017644',
			'send_name' => '', 
			'dest_name' => '', 
			'subject' => '',
			'msg_body' => 
"(광고)[빌리프 선물]
축하드려요! 
빌리를 도와 빌리프 봄 친구들을 모두 찾으셨군요. 선택하신 빌리프 매장에 방문해 아래의 링크를 눌러 쿠폰을 보여주시면, 

올 봄 당신을 밝고 촉촉하게 지켜줄 빌리프 봄 선물을 드립니다.

빌리프 투명 촉촉 봄 체험키트(수분 폭탄 크림 10ml, 수분 충전 에센스 10ml) 사용하기: 
".$s_url."

▶ 수령 기간
2016년 3월 18일~4월 17일

▶ 유의사항
타 행사와 중복적용이 불가하며 매장에 따라 증정품 조기 소진될 수 있습니다. 또한, 본 쿠폰은 1인 1회에 한하여 증정됩니다.

▶쿠폰 관련 문의
bk.park@minivertising.kr
02-532-2475
(평일 10~18시)

▶매장 관련 문의
080-023-7007
(평일 10~18시)
"
		);

		//curl initialization
		$curl = curl_init();

		//create request url
		//$url = $url."?".$parameters;

		curl_setopt ($curl, CURLOPT_URL , $url);
		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt ($curl, CURLINFO_HEADER_OUT, true);
		curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);

		$response = curl_exec($curl);

		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$responseHeaders = curl_getinfo($curl, CURLINFO_HEADER_OUT);


		curl_close($curl);

		return $response;
	}

	function sendRequest_second($httpMethod, $url, $clientKey, $contentType, $phone, $s_url) {

		//create basic authentication header
		$headerValue = $clientKey;
		$headers = array("x-waple-authorization:" . $headerValue);

		$params = array(
			'send_time' => '', 
			'send_phone' => '025322475', 
			'dest_phone' => $phone, 
			//'dest_phone' => '01099017644',
			'send_name' => '', 
			'dest_name' => '', 
			'subject' => '',
			'msg_body' => 
"(광고)[빌리프 선물]
축하드려요! 
빌리를 도와 빌리프 봄 친구들을 모두 찾으셨군요. 선택하신 빌리프 매장에 방문해 아래의 링크를 눌러 쿠폰을 보여주시면, 

올 봄 당신을 밝고 촉촉하게 지켜줄 빌리프 봄 선물을 드립니다.

빌리프 촉촉 봄 체험 키트 (수분 폭탄 크림 10ml) 쿠폰 사용하기: 
".$s_url."

▶ 교환 기간
2016년 3월 18일~4월 17일

▶ 유의사항
타 행사와 중복적용이 불가하며 매장에 따라 증정품 조기 소진될 수 있습니다. 또한, 본 쿠폰은 1인 1회에 한하여 증정됩니다.

▶쿠폰 관련 문의
bk.park@minivertising.kr
02-532-2475
(평일 10~18시)

▶매장 관련 문의
080-023-7007
(평일 10~18시)
"
		);

		//curl initialization
		$curl = curl_init();

		//create request url
		//$url = $url."?".$parameters;

		curl_setopt ($curl, CURLOPT_URL , $url);
		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt ($curl, CURLINFO_HEADER_OUT, true);
		curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);

		$response = curl_exec($curl);

		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$responseHeaders = curl_getinfo($curl, CURLINFO_HEADER_OUT);


		curl_close($curl);

		return $response;
	}

	function sendRequest_third($httpMethod, $url, $clientKey, $contentType, $phone, $s_url) {

		//create basic authentication header
		$headerValue = $clientKey;
		$headers = array("x-waple-authorization:" . $headerValue);

		$params = array(
			'send_time' => '', 
			'send_phone' => '025322475', 
			'dest_phone' => $phone, 
			//'dest_phone' => '01099017644',
			'send_name' => '', 
			'dest_name' => '', 
			'subject' => '',
			'msg_body' => 
"(광고)[빌리프 선물]
축하드려요! 
빌리를 도와 빌리프 봄 친구들을 모두 찾으셨군요. 선택하신 빌리프 매장에 방문해 아래의 링크를 눌러 쿠폰을 보여주시면, 

올 봄 당신을 밝고 촉촉하게 지켜줄 빌리프 봄 선물을 드립니다.

빌리프 트리플 봄 체험 키트(수분 충전 에센스 3ml, 수분 폭탄 크림 3ml, 화이트닝 크림 3ml)쿠폰 사용하기: 
".$s_url."

▶ 교환 기간
2016년 3월 18일~4월 17일

▶ 유의사항
타 행사와 중복적용이 불가하며 매장에 따라 증정품 조기 소진될 수 있습니다. 또한, 본 쿠폰은 1인 1회에 한하여 증정됩니다.

▶쿠폰 관련 문의
bk.park@minivertising.kr
02-532-2475
(평일 10~18시)

▶매장 관련 문의
080-023-7007
(평일 10~18시)
"
		);

		//curl initialization
		$curl = curl_init();

		//create request url
		//$url = $url."?".$parameters;

		curl_setopt ($curl, CURLOPT_URL , $url);
		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt ($curl, CURLINFO_HEADER_OUT, true);
		curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);

		$response = curl_exec($curl);

		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$responseHeaders = curl_getinfo($curl, CURLINFO_HEADER_OUT);


		curl_close($curl);

		return $response;
	}

	function sendRequest_first_re($httpMethod, $url, $clientKey, $contentType, $phone, $s_url) {

		//create basic authentication header
		$headerValue = $clientKey;
		$headers = array("x-waple-authorization:" . $headerValue);

		$params = array(
			'send_time' => '', 
			'send_phone' => '025322475', 
			'dest_phone' => $phone, 
			//'dest_phone' => '01099017644',
			'send_name' => '', 
			'dest_name' => '', 
			'subject' => '',
			'msg_body' => 
"(광고) [belif 선물] 
빌리프 봄 선물을 이번 주말에 꼭!
 
선물을 교환하러 오는 발길이 이어지고 있어요.
 
이번 주말에 꼭! 선택하신 빌리프 매장에 방문하셔서 촉촉 화사한 빌리프 봄 선물을 받아 가세요.

빌리프 투명 촉촉 봄 체험키트(수분 폭탄 크림 10ml, 수분 충전 에센스 10ml) 사용하기: 
".$s_url."

▶ 수령 기간
2016년 3월 18일~4월 17일

▶ 유의사항
타 행사와 중복적용이 불가하며 매장에 따라 증정품 조기 소진될 수 있습니다. 또한, 본 쿠폰은 1인 1회에 한하여 증정됩니다.

▶쿠폰 관련 문의
bk.park@minivertising.kr
02-532-2475
(평일 10~18시)

▶매장 관련 문의
080-023-7007
(평일 10~18시)
"
		);

		//curl initialization
		$curl = curl_init();

		//create request url
		//$url = $url."?".$parameters;

		curl_setopt ($curl, CURLOPT_URL , $url);
		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt ($curl, CURLINFO_HEADER_OUT, true);
		curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);

		$response = curl_exec($curl);

		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$responseHeaders = curl_getinfo($curl, CURLINFO_HEADER_OUT);


		curl_close($curl);

		return $response;
	}

	function sendRequest_second_re($httpMethod, $url, $clientKey, $contentType, $phone, $s_url) {

		//create basic authentication header
		$headerValue = $clientKey;
		$headers = array("x-waple-authorization:" . $headerValue);

		$params = array(
			'send_time' => '', 
			'send_phone' => '025322475', 
			'dest_phone' => $phone, 
			//'dest_phone' => '01099017644',
			'send_name' => '', 
			'dest_name' => '', 
			'subject' => '',
			'msg_body' => 
"(광고) [belif 선물] 
빌리프 봄 선물을 이번 주말에 꼭!
 
선물을 교환하러 오는 발길이 이어지고 있어요.
 
이번 주말에 꼭! 선택하신 빌리프 매장에 방문하셔서 촉촉 화사한 빌리프 봄 선물을 받아 가세요.

빌리프 촉촉 봄 체험 키트 (수분 폭탄 크림 10ml) 쿠폰 사용하기: 
".$s_url."

▶ 교환 기간
2016년 3월 18일~4월 17일

▶ 유의사항
타 행사와 중복적용이 불가하며 매장에 따라 증정품 조기 소진될 수 있습니다. 또한, 본 쿠폰은 1인 1회에 한하여 증정됩니다.

▶쿠폰 관련 문의
bk.park@minivertising.kr
02-532-2475
(평일 10~18시)

▶매장 관련 문의
080-023-7007
(평일 10~18시)
"
		);

		//curl initialization
		$curl = curl_init();

		//create request url
		//$url = $url."?".$parameters;

		curl_setopt ($curl, CURLOPT_URL , $url);
		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt ($curl, CURLINFO_HEADER_OUT, true);
		curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);

		$response = curl_exec($curl);

		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$responseHeaders = curl_getinfo($curl, CURLINFO_HEADER_OUT);


		curl_close($curl);

		return $response;
	}

	function sendRequest_third_re($httpMethod, $url, $clientKey, $contentType, $phone, $s_url) {

		//create basic authentication header
		$headerValue = $clientKey;
		$headers = array("x-waple-authorization:" . $headerValue);

		$params = array(
			'send_time' => '', 
			'send_phone' => '025322475', 
			'dest_phone' => $phone, 
			//'dest_phone' => '01099017644',
			'send_name' => '', 
			'dest_name' => '', 
			'subject' => '',
			'msg_body' => 
"(광고) [belif 선물] 
빌리프 봄 선물을 이번 주말에 꼭!
 
선물을 교환하러 오는 발길이 이어지고 있어요.
 
이번 주말에 꼭! 선택하신 빌리프 매장에 방문하셔서 촉촉 화사한 빌리프 봄 선물을 받아 가세요.

빌리프 트리플 봄 체험 키트(수분 충전 에센스 3ml, 수분 폭탄 크림 3ml, 화이트닝 크림 3ml)쿠폰 사용하기: 
".$s_url."

▶ 교환 기간
2016년 3월 18일~4월 17일

▶ 유의사항
타 행사와 중복적용이 불가하며 매장에 따라 증정품 조기 소진될 수 있습니다. 또한, 본 쿠폰은 1인 1회에 한하여 증정됩니다.

▶쿠폰 관련 문의
bk.park@minivertising.kr
02-532-2475
(평일 10~18시)

▶매장 관련 문의
080-023-7007
(평일 10~18시)
"
		);

		//curl initialization
		$curl = curl_init();

		//create request url
		//$url = $url."?".$parameters;

		curl_setopt ($curl, CURLOPT_URL , $url);
		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt ($curl, CURLINFO_HEADER_OUT, true);
		curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);

		$response = curl_exec($curl);

		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$responseHeaders = curl_getinfo($curl, CURLINFO_HEADER_OUT);


		curl_close($curl);

		return $response;
	}

?>