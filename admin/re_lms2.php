<?
	include_once "../config.php";

	//$phone	= "01027987332";
	$phone	= $_REQUEST['mid'];
	send_lms($phone,'re_send');


?>