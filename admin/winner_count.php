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
<div id="page-wrapper">
  <div class="container-fluid">
  <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">경품별 당첨자 수</h1>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">
        <div class="table-responsive">
          <table id="entry_list" class="table table-hover">
            <thead>
              <tr>
                <th>DSLR 카메라(1명)</th>
                <th>하얏트 호텔 숙박권(3명)</th>
                <th>베베프람 웨건(5명)</th>
                <th>베비언스 분유 1년치(5명)</th>
                <th>베이비워터 24병(100명)</th>
                <th>메소드 핸드워시(300명)</th>
                <th>베비언스 3천원 쿠폰</th>
              </tr>
            </thead>
            <tbody>
<?php 
	$buyer_count_query = "SELECT count(*) FROM ".$_gl['voter_info_table']." WHERE 1";

	$buyer_list_query = "SELECT vote_winner, count(vote_winner) cnt FROM ".$_gl['voter_info_table']." WHERE 1 GROUP BY vote_winner";
	$res = mysqli_query($my_db, $buyer_list_query);

	while ($b_data = @mysqli_fetch_array($res))
	{
		if ($b_data['vote_winner'] == "CASH")
		{
			$winner_info[1]	= $b_data['cnt'];
		}else if ($b_data['vote_winner'] == "WASH"){
			$winner_info[2]	= $b_data['cnt'];
		}else if ($b_data['vote_winner'] == "WATER"){
			$winner_info[3]	= $b_data['cnt'];
		}else if ($b_data['vote_winner'] == "MILK"){
			$winner_info[4]	= $b_data['cnt'];
		}else if ($b_data['vote_winner'] == "WG"){
			$winner_info[5]	= $b_data['cnt'];
		}else if ($b_data['vote_winner'] == "HOTEL"){
			$winner_info[6]	= $b_data['cnt'];
		}else if ($b_data['vote_winner'] == "CAMERA"){
			$winner_info[7]	= $b_data['cnt'];
		}
	}
	if (!$winner_info[1])
		$winner_info[1] = 0;
	else if (!$winner_info[2])
		$winner_info[2] = 0;
	else if (!$winner_info[3])
		$winner_info[3] = 0;
	else if (!$winner_info[4])
		$winner_info[4] = 0;
	else if (!$winner_info[5])
		$winner_info[5] = 0;
	else if (!$winner_info[6])
		$winner_info[6] = 0;
	else if (!$winner_info[7])
		$winner_info[7] = 0;
?>
              <tr>
                <td><?php echo $winner_info[7]?></td>	<!-- No. 하나씩 감소 -->
                <td><?php echo $winner_info[6]?></td>
                <td><?php echo $winner_info[5]?></td>
                <td><?php echo $winner_info[4]?></td>
                <td><?php echo $winner_info[3]?></td>
                <td><?php echo $winner_info[2]?></td>
                <td><?php echo $winner_info[1]?></td>
              </tr>
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