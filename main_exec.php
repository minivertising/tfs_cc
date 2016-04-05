<?php
include_once "config.php";

switch ($_REQUEST['exec'])
{
	case "insert_share_info" :
		$sns_media	= $_REQUEST['sns_media'];
		$sns_flag		= $_REQUEST['sns_flag'];

		$query 		= "INSERT INTO ".$_gl['share_info_table']."(sns_media, sns_ipaddr, sns_gubun, inner_media, sns_regdate) values('".$sns_media."','".$_SERVER['REMOTE_ADDR']."','".$gubun."','".$_SESSION['ss_media']."','".date("Y-m-d H:i:s")."')";
		$result 	= mysqli_query($my_db, $query);

		if ($result)
			$flag = "Y";
		else
			$flag = "N";

		echo $flag;

	break;

	case "insert_info" :
		$mb_name			= $_REQUEST['mb_name'];
		$mb_phone			= $_REQUEST['mb_phone'];
		$mb_shop			= $_REQUEST['mb_shop'];
		$media				= $_SESSION['ss_media'];

		$dupli_query 	= "SELECT * FROM ".$_gl['member_info_table']." WHERE mb_phone='".$mb_phone."' AND mb_winner = 'Y||FIRST' AND mb_winner = 'Y||SECOND' AND mb_winner = 'N||THIRD'";
		$dupli_result 	= mysqli_query($my_db, $dupli_query);
		$dupli_cnt	= mysqli_num_rows($dupli_result);

		if ($dupli_cnt > 0)
		{
			$flag	= "D||THIRD";
		}else{
			$serial		= BC_getSerial();
			$winner	= winner_draw($mb_phone);
			$query 	= "INSERT INTO ".$_gl['member_info_table']."(mb_ipaddr,mb_name,mb_phone,mb_shop,mb_regdate,mb_winner,mb_serial,mb_gubun,mb_media) values('".$_SERVER['REMOTE_ADDR']."','".$mb_name."','".$mb_phone."','".$mb_shop."','".date("Y-m-d H:i:s")."','".$winner."','".$serial."','".$gubun."','".$media."')";
			$result 	= mysqli_query($my_db, $query);

			if ($winner == "D||THIRD")
			{
				$flag	= "D||THIRD";
			}else{
				send_lms($mb_phone, $serial, $winner);
				if ($result)
					$flag	= $winner;
				else
					$flag	= "N||ERROR";
			}
		}
		echo $flag;
	break;

	case "use_coupon" :
		$mb_serial			= $_REQUEST['mb_serial'];

		$query 	= "UPDATE ".$_gl['member_info_table']." SET mb_use='Y', mb_usedate='".date("Y-m-d H:i:s")."' WHERE mb_serial='".$mb_serial."'";
		$result 	= mysqli_query($my_db, $query);

		if ($result)
			$flag	= "Y";
		else
			$flag	= "N";
		
		echo $flag;
	break;

	case "use_coupon_hidden" :
		$mb_serial			= $_REQUEST['mb_serial'];

		$query 	= "UPDATE ".$_gl['member_info_table']." SET mb_hidden_use='Y', mb_hidden_usedate='".date("Y-m-d H:i:s")."' WHERE mb_serial='".$mb_serial."'";
		$result 	= mysqli_query($my_db, $query);

		if ($result)
			$flag	= "Y";
		else
			$flag	= "N";
		
		echo $flag;
	break;

}
?>