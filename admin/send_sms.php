<?php

$httpmethod = "POST";
$url = "http://api.openapi.io/ppurio_test/1/message_test/lms/minivertising";
$clientKey = "MS0xMzY1NjY2MTAyNDk0LTA2MWE4ZDgyLTZhZmMtNGU5OS05YThkLTgyNmFmYzVlOTkzZQ==";
$contentType = "Content-Type: application/x-www-form-urlencoded";

$response = sendRequest($httpmethod, $url, $parameters, $clientKey, $contentType);

//echo("<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />");
$json_data = json_decode($response, true);

//print_r($json_data);
/*
받아온 결과값을 DB에 저장 및 Variation
*/


function sendRequest($httpMethod, $url, $parameters, $clientKey, $contentType) {

		//create basic authentication header
		$headerValue = $clientKey;
		$headers = array("x-waple-authorization:" . $headerValue);

		$params = array(
			'send_time' => '', 
			'send_phone' => '01030033965', 
			'dest_phone' => '01030033965', 
			'send_name' => '', 
			'dest_name' => '', 
			'subject' => '',
			'msg_body' => '테스트'
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
