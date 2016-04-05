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
        <h1 class="page-header">일자별 히든 쿠폰 당첨자&사용자 수</h1>
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
                <!-- <th> 쿠폰 당첨자 수</th> -->
                <th>쿠폰 사용자 수</th>
              </tr>
            </thead>
            <tbody>
<?php 
	$date_query = "SELECT substr(mb_hidden_usedate,1,10) mb_date FROM ".$_gl['member_info_table']." WHERE mb_name <>'admin' Group by substr(mb_hidden_usedate,1,10) order by mb_regdate desc";
	$res = mysqli_query($my_db, $date_query);

	$pc_total_count		= 0;
	$mobile_total_count	= 0;
	$unique_total_count	= 0;
	$all_total_count			= 0;
	$coupon_total_count	= 0;
	$use_total_count		= 0;
	while ($date_data = @mysqli_fetch_array($res))
	{		
		//$coupon_query		= "SELECT mb_phone, COUNT( mb_phone ) cnt FROM ".$_gl['member_info_table']." WHERE mb_lms =  'Y' AND mb_hidden_usedate LIKE  '%".$date_data['mb_date']."%' AND mb_name <>'admin' GROUP BY mb_phone";
		//$coupon_count		= mysqli_num_rows(mysqli_query($my_db, $coupon_query));
		$use_query	= "SELECT mb_phone, COUNT( mb_phone ) cnt FROM ".$_gl['member_info_table']." WHERE mb_hidden_use =  'Y' AND mb_hidden_usedate LIKE  '%".$date_data['mb_date']."%' AND mb_name <>'admin' GROUP BY mb_phone";
		$use_count	= mysqli_num_rows(mysqli_query($my_db, $use_query));
?>
              <tr>
                <td><?php echo $date_data['mb_date']?></td>
                <td><?php echo $use_count?></td>
              </tr>
<?php
		$coupon_total_count		= $coupon_total_count;
		$use_total_count	= $use_total_count + $use_count;
	}
?>
              <tr>
                <td>합계</td>
                <!-- <td><?php echo $coupon_total_count?></td> -->
                <td><?php echo $use_total_count?></td>
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