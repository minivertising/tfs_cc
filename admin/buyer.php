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
</script>

<div id="page-wrapper">
  <div class="container-fluid">
  <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">이벤트 참여자 목록</h1>
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
                <option value="buyer_name" <?php if($search_type == "buyer_name"){?>selected<?php }?>>이름</option>
                <option value="buyer_phone" <?php if($search_type == "buyer_phone"){?>selected<?php }?>>전화번호</option>
              </select>
              <input type="text" name="search_txt" value="<?php echo $search_txt?>">
              <input type="text" id="sDate" name="sDate" value="<?=$sDate?>"> - <input type="text" id="eDate" name="eDate" value="<?=$eDate?>">
              <input type="submit" value="검색">
            </form>
          </ol>
          <table id="buyer_list" class="table table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>이름</th>
                <th>전화번호</th>
                <th>IP주소</th>
                <th>구매상품</th>
                <th>구매일자</th>
                <th>유입구분</th>
              </tr>
            </thead>
            <tbody>
<?php 
	$where = "";

	if ($sDate != "")
		$where	.= " AND buyer_date >= '".$sDate."' AND buyer_date <= '".$eDate." 23:59:59'";
	
	if ($search_txt != "")
		$where	.= " AND ".$search_type." like '%".$search_txt."%'";

	$buyer_count_query = "SELECT count(*) FROM ".$_gl['buyer_info_table']." WHERE 1".$where."";

	list($buyer_count) = @mysqli_fetch_array(mysqli_query($my_db, $buyer_count_query));
	$PAGE_CLASS = new Page($pg,$buyer_count,$page_size,$block_size);

	$BLOCK_LIST = $PAGE_CLASS->blockList();
	$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount;

	$buyer_list_query = "SELECT * FROM ".$_gl['buyer_info_table']." WHERE 1 ".$where." Order by idx DESC LIMIT $PAGE_CLASS->page_start, $page_size";

	$res = mysqli_query($my_db, $buyer_list_query);

	while ($buyer_data = @mysqli_fetch_array($res))
	{
    $buyer_info[] = $buyer_data; 
	}

	foreach($buyer_info as $key => $val)
	{
?>
              <tr>
                <td><?php echo $PAGE_UNCOUNT--?></td>	<!-- No. 하나씩 감소 -->
                <td><?php echo $buyer_info[$key]['buyer_name']?></td>
                <td><?php echo $buyer_info[$key]['buyer_phone']?></td>
                <td><?php echo $buyer_info[$key]['buyer_ipaddr']?></td>
                <td><?php echo $buyer_info[$key]['buyer_goods']?></td>
                <td><?php echo $buyer_info[$key]['buyer_date']?></td>
                <td><?php echo $buyer_info[$key]['buyer_gubun']?></td>
              </tr>
<?php 
	}
?>
              <tr><td colspan="7"><div class="pageing"><?php echo $BLOCK_LIST?></div></td></tr>
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