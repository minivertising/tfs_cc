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

  // if(isset($_REQUEST['pg']) == false)
  //   $pg = "1";
  // else
  //   $pg = $_REQUEST['pg'];

  if (!$pg)
    $pg = 1;
	//if(isset($pg) == false) $pg = 1;	// $pg가 없으면 1로 생성
	$page_size = 20;	// 한 페이지에 나타날 개수
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
        <h1 class="page-header">상품별 당첨 정보</h1>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-4">
        <div class="table-responsive">
          <table id="winner_list" class="table table-hover">
            <thead>
              <tr>
                <th>상품명</th>
                <th>당첨갯수</th>
              </tr>
            </thead>
            <tbody>
<?php
		$goods_query	= "SELECT * FROM ".$_gl['goods_info_table']."";
		$goods_res		= mysqli_query($my_db, $goods_query);

		while ($goods_data = mysqli_fetch_array($goods_res))
		{
?>
                  <tr>
                    <td><?=$goods_data['goods_name']?></td>
                    <td><?=$goods_data['goods_selcount']?></td>
                  </tr>
<?php
        }
?>
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