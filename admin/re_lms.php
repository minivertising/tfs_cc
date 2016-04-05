<?
	include_once "../config.php";

	//$phone	= "01027987332";
	//$phone	= $_REQUEST['mid'];
	$serial	= $_REQUEST['serial'];
	//$winner	= $_REQUEST['winner'];

	$query	= "SELECT * FROM ".$_gl['member_info_table']." WHERE mb_serial='".$serial."'";
	$res		= mysqli_query($my_db, $query);
	$data		= mysqli_fetch_array($res);

	send_lms2($data['mb_phone'], $serial, $data['mb_winner']);


?>