<?php
	include_once "../config.php";
	
	include "./head.php";

	if(isset($_REQUEST['search_type']) == false)
		$search_type = "";
	else
		$search_type = $_REQUEST['search_type'];
	
	if(isset($_REQUEST['search_txt']) == false)
		$search_txt = "";
	else
		$search_txt = $_REQUEST['search_txt'];
	
	if(isset($_REQUEST['sDate']) == false)
		$sDate = "";
	else
		$sDate = $_REQUEST['sDate'];
	
	if(isset($_REQUEST['eDate']) == false)
		$eDate = "";
	else
		$eDate = $_REQUEST['eDate'];

	if(isset($_REQUEST['pg'];

	if (!$pg)
		$pg = "1";
	//if(isset($pg) == false) $pg = 1; //$pg가 없으면 1로 생성
	$page_size = 10;
	$block_size = 10;

?>
<script type="text/javascript">
	$(function()
	{
		$("#sDate").datepicker();
		$("#eDate").datepicker();
	}
	);

	function checkfrm()
	{
		if($("#sDate").val() > $("#eDate").val())
		{
			alert("검색 시작일은 종료일보다 작아야한다.);
			return false;
		}
	}
</script>

<div id="page-wrapper">
  <div class="container-fluid">
  <!--------page Heading----------->
    <div class="row">
	  <div class="col-lg-12">
	    <h1 class="page-header">이벤트 참여자 목록</h1>
	  </div>
	</div>
  <!---------row------------------->
    <div class="row">
	  <div class="col-lg-12">
	    <div class="table-responsive">
		  <ol class="breadcrumb">
		    <form name="frm_execute" method="POST" onsubmit="return checkfrm()">
			  <input type="hidden" name="pg" value="<?=$pg?>">
			    <select name="search_type">
				  <option value="buyer_name"<?php if($search_type == "buyer_name"){?>slected<?php}?>>이름</option>
				  <option value="buyer_phone"<?php if($search_type == "buyer_phone"){?>selected<?php}?>>전화번호</option>
				</select>
				<input type="text" name="search_txt" value="<?php echo $search_txt?>">
				<input type="text" name="sDate" value="<?=$sDate?>"> - <input type="text" id="edate" name="edate" value="<?=$eDate?>">
				<input type="submit" value="검색">
			</form>
		  <ol>
		  <table id="buyer_list" class="table table-hover">
		    <thead>
			  <tr>
			    <th>순번</th>
				<th>IP정보</th>
				<th>전화번호</th>
				<th>매장번호</th>
				<th>등록일</th>
			  </tr>
			</thead>
		  </table>			  
  </div>
</div>