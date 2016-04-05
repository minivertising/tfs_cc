<?
	include_once "config.php";

	//unset($media);
	$media	= $_REQUEST['media'];
	$testurl	= $_REQUEST['testurl'];
	$tab	= $_REQUEST['tab'];

	$_SESSION['ss_media'] = $media;
	$_SESSION['ss_testurl'] = $testurl;

	BR_InsertTrackingInfo($media, $gubun);

	if($gubun == "MOBILE")
	{
		Header("Location:http://www.belif-play.com/MOBILE/index.php?media=".$media."");
		exit;
	}else{
		Header("Location:http://www.belif-play.com/PC/index.php?media=".$media."");
		exit;
	}

?>
