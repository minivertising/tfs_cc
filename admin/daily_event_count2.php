<?php

	// 설정파일
	include_once "../config.php";

	include "./head.php";

?>

<div id="page-wrapper">
  <div class="container-fluid">
  <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">일자별 투표 이벤트 참여자 수</h1>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">
        <div class="table-responsive">
          <table id="entry_list" class="table table-hover">
            <thead>
              <tr>
                <th>날짜</th>
                <th> PC</th>
                <th>MOBILE</th>
                <th>신규참여</th>
                <th>합계</th>
              </tr>
            </thead>
            <tbody>
<?php 
	$date_query = "SELECT substr(vote_regdate,1,10) mb_date FROM ".$_gl['voter_info_table']." WHERE vote_regdate <> '0000-00-00 00:00:00' Group by substr(vote_regdate,1,10) order by vote_regdate desc";
	$res = mysqli_query($my_db, $date_query);

	$pc_total_count		= 0;
	$mobile_total_count	= 0;
	$unique_total_count	= 0;
	$all_total_count			= 0;
	while ($date_data = @mysqli_fetch_array($res))
	{		
		$pc_query		= "SELECT * FROM ".$_gl['voter_info_table']." WHERE vote_regdate LIKE  '%".$date_data['mb_date']."%' AND vote_gubun='PC'";
		$pc_count		= mysqli_num_rows(mysqli_query($my_db, $pc_query));
		$mobile_query	= "SELECT * FROM ".$_gl['voter_info_table']." WHERE vote_regdate LIKE  '%".$date_data['mb_date']."%' AND vote_gubun='MOBILE'";
		$mobile_count	= mysqli_num_rows(mysqli_query($my_db, $mobile_query));
		$total_count = $pc_count + $mobile_count;
		$unique_query	= "SELECT * FROM ".$_gl['voter_info_table']." WHERE vote_regdate LIKE  '%".$date_data['mb_date']."%'";
		$unique_count	= mysqli_num_rows(mysqli_query($my_db, $unique_query));

?>
              <tr>
                <td><?php echo $date_data['mb_date']?></td>
                <td><?php echo $pc_count?></td>
                <td><?php echo $mobile_count?></td>
                <td><?php echo $unique_count?></td>
                <td><?php echo $total_count?></td>
              </tr>
<?php
		$pc_total_count		= $pc_total_count + $pc_count;
		$mobile_total_count	= $mobile_total_count + $mobile_count;
		$unique_total_count	= $unique_total_count + $unique_count;
		$all_total_count			= $pc_total_count + $mobile_total_count;
	}
?>
              <tr>
                <td>합계</td>
                <td><?php echo $pc_total_count?></td>
                <td><?php echo $mobile_total_count?></td>
                <td><?php echo $unique_total_count?></td>
                <td><?php echo $all_total_count?></td>
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