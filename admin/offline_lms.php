<?
	include_once "../config.php";

	$phone	= $_REQUEST['mid'];
	send_lms_offline($phone);

?>