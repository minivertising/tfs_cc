<?php

	// 설정파일
	include_once "../config.php";

/*
	if (isset($_SESSION['ss_mb_id']) == false)
	{
		//header('Location: index.php'); 
		echo "<script>location.href='index.php'</script>"; 
		exit; 
	}
*/

	include "./head.php";

	if(isset($_REQUEST['search_type']) == false)
		$search_type = "";
	else
		$search_type = $_REQUEST['search_type'];

	if(isset($_REQUEST['search_txt']) == false)
		$search_txt	= "";
	else
		$search_txt	= $_REQUEST['search_txt'];

	if(isset($_REQUEST['sDate']) == false)
		$sDate = "";
	else
		$sDate = $_REQUEST['sDate'];
	
	if(isset($_REQUEST['eDate']) == false)
		$eDate = "";
	else
		$eDate = $_REQUEST['eDate'];

	
	if(isset($_REQUEST['pg']) == false)
		$pg = "1";
	else
		$pg = $_REQUEST['pg'];
	
	if (!$pg)
		$pg = "1";
	//if(isset($pg) == false) $pg = 1;	// $pg가 없으면 1로 생성
	$page_size = 10;	// 한 페이지에 나타날 개수
	$block_size = 10;	// 한 화면에 나타낼 페이지 번호 개수

	//if (isset($search_type) == false)
	//	$search_type = "search_by_name";
?>
<script type="text/javascript">
	$(function() {
		$( "#sDate" ).datepicker();
		$( "#eDate" ).datepicker();
	});

	function checkfrm()
	{
		if ($("#sDate").val() > $("#eDate").val())
		{
			alert("검색 시작일은 종료일보다 작아야 합니다.");
			return false;
		}
	}

	function send_sms(phone)
	{
		if (confirm("LMS를 발송하시겠습니까?"))
		{
			$.ajax({
				type:"POST",
				cache: false,
				data:{
					"exec"       : "send_sms",
					"phone"    : phone
				},
				url: "./admin_exec.php",
				success: function(response){
					alert("LMS가 발송되었습니다.");
					//window.refresh();
				}
			});
		}
	}

	function all_send()
	{
		if (confirm("당첨 인원 모두에게 LMS를 발송하시겠습니까?"))
		{
			$.ajax({
				type:"POST",
				cache: false,
				data:{
					"exec"       : "all_send_sms"
				},
				url: "./admin_exec.php",
				success: function(response){
					alert(response);
					alert("당첨인원 모두에게 LMS가 발송되었습니다.");
					//window.refresh();
				}
			});
		}
	}

	function create_surl()
	{
		if (confirm("당첨 인원 모두에게 짧은 URL을 만드시겠습니까?"))
		{
			$.ajax({
				type:"POST",
				cache: false,
				data:{
					"exec"       : "insert_surl"
				},
				url: "./admin_exec.php",
				success: function(response){
					if (response == "Y")
					{
						alert("당첨인원 모두에게 짧은 URL이 발급되었습니다.");
					}else if (response == "F"){
						alert("횟수 제한. 다시해라!");
					}else{
						alert("시스템 오류!!다시해라!");
					}
					//window.refresh();
				}
			});
		}
	}

	function sel_winner()
	{
		if (confirm("당첨 인원을 선정하시겠습니까?"))
		{
			$.ajax({
				type:"POST",
				cache: false,
				data:{
					"exec"       : "sel_winner"
				},
				url: "./admin_exec.php",
				success: function(response){
					alert(response);
					if (response == "Y")
					{
						alert("당첨자 선정 완료!.");
					}else{
						alert("시스템 오류!!다시해라!");
					}
				}
			});
		}
	}

	function insert_nan()
	{
		if (confirm("난수번호를 생성하시겠습니까?"))
		{
			$.ajax({
				type:"POST",
				cache: false,
				data:{
					"exec"       : "insert_nansu"
				},
				url: "./admin_exec.php",
				success: function(response){
					alert(response);
					if (response == "Y")
					{
						alert("당첨자 선정 완료!.");
					}else{
						alert("시스템 오류!!다시해라!");
					}
				}
			});
		}
	}
</script>

<div id="page-wrapper">
  <div class="container-fluid">
  <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">SMS 발송</h1>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">
        <div class="table-responsive">
          <ol class="breadcrumb">
            <form name="frm_execute" method="POST" onsubmit="return checkfrm()">
              <input type="hidden" name="pg" value="<?=$pg?>">
              <select name="search_type">
                <option value="mb_phone" <?php if($search_type == "mb_phone"){?>selected<?php }?>>전화번호</option>
              </select>
              <input type="text" name="search_txt" value="<?php echo $search_txt?>">
              <input type="text" id="sDate" name="sDate" value="<?=$sDate?>"> - <input type="text" id="eDate" name="eDate" value="<?=$eDate?>">
              <input type="submit" value="검색">
            </form>
          </ol>
          <table id="entry_list" class="table table-hover">
            <thead>
              <tr>
                <th>순번</th>
                <th>이름</th>
                <th>전화번호</th>
                <th>매장명</th>
                <th>당첨여부</th>
                <th>LMS발송여부</th>
                <th>등록일</th>
                <th>SMS발송</th>
              </tr>
            </thead>
            <tbody>
<?php 
	$where = "";

	if ($sDate != "")
		$where	.= " AND mb_regdate >= '".$sDate."' AND mb_regdate <= '".$eDate." 23:59:59'";
	
	if ($search_txt != "")
		$where	.= " AND ".$search_type." like '%".$search_txt."%'";

	//$buyer_count_query = "SELECT count(*) FROM ".$_gl['member_info_table']." WHERE mb_winner='Y' AND mb_ipaddr <> 'admin' ".$where."";
	$buyer_count_query = "SELECT count(*) FROM ".$_gl['member_info_table']." WHERE mb_ipaddr <> 'admin' ".$where."";

	list($buyer_count) = @mysqli_fetch_array(mysqli_query($my_db, $buyer_count_query));
	$PAGE_CLASS = new Page($pg,$buyer_count,$page_size,$block_size);

	$BLOCK_LIST = $PAGE_CLASS->blockList();
	$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount;

	//$buyer_list_query = "SELECT * FROM ".$_gl['member_info_table']." WHERE mb_ipaddr <> 'admin' AND mb_winner='Y' ".$where." Order by idx DESC LIMIT $PAGE_CLASS->page_start, $page_size";
	$buyer_list_query = "SELECT * FROM ".$_gl['member_info_table']." WHERE mb_ipaddr <> 'admin' ".$where." Order by idx DESC LIMIT $PAGE_CLASS->page_start, $page_size";

	$res = mysqli_query($my_db, $buyer_list_query);

	while ($buyer_data = @mysqli_fetch_array($res))
	{
    $buyer_info[] = $buyer_data; 
	}

	foreach($buyer_info as $key => $val)
	{
		$shop_query = "SELECT shop_name FROM ".$_gl['shop_info_table']." WHERE idx='".$buyer_info[$key]['shop_idx']."'";
		$res = mysqli_query($my_db, $shop_query);
		$shop_name	= @mysqli_fetch_array($res);
?>
              <tr>
                <td><?php echo $PAGE_UNCOUNT--?></td>	<!-- No. 하나씩 감소 -->
                <td><?php echo $buyer_info[$key]['mb_name']?></td>
                <td><?php echo $buyer_info[$key]['mb_phone']?></td>
                <td><?php echo $shop_name['shop_name']?></td>
                <td><?php echo $buyer_info[$key]['mb_winner']?></td>
                <td><?php echo $buyer_info[$key]['mb_lms']?></td>
                <td><?php echo $buyer_info[$key]['mb_regdate']?></td>
				<td><input type="button" value="문자 발송" onclick="send_sms('<?php echo $buyer_info[$key]['mb_phone']?>');"></td>
              </tr>
<?php 
	}
?>
              <tr><td colspan="7"><div class="pageing"><?php echo $BLOCK_LIST?></div>
			  현재 당첨 인원 : <?=$buyer_count?> 명 <input type="button" value="shorturl 생성" onclick="create_surl();"><input type="button" value="당첨자 전체 발송" onclick="all_send();"><input type="button" value="당첨자 선정하기" onclick="sel_winner();"><input type="button" value="난수번호 입력" onclick="insert_nan();"></td></tr>
            </tbody>
          </table>
        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
</body>

</html>



<script type="text/javascript">
 
	function pageRun(num)
	{
		f = document.frm_execute;
		f.pg.value = num;
		f.submit();
	}
</script>