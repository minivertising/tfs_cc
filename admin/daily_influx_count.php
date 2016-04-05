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

?>

  <div id="page-wrapper">
    <div class="container-fluid">
    <!-- Page Heading -->
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">일자별 유입매체별 유입자 수 PC / Mobile</h1>
        </div>
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-lg-6">
          <div class="table-responsive">
            <!-- 필리핀 -->
            <div id="daily_applicant_count_div1" style="display:block">
              <table class="table table-hover">
                <thead>
                  <tr><th>날짜</th><th>유입매체</th><th>PC</th><th>Mobile</th><th>Total</th></tr>
                </thead>
                <tbody>
<?php
	$daily_date_query	= "SELECT tracking_date FROM ".$_gl['tracking_info_table']." WHERE tracking_ipaddr <> '121.254.252.73' Group by substr(tracking_date,1,10) ORDER BY tracking_date DESC";
	$date_res			= mysqli_query($my_db, $daily_date_query);
	while($date_daily_data = mysqli_fetch_array($date_res))
	{
		$daily_date		= substr($date_daily_data['tracking_date'],0,10);
		$media_query	= "SELECT tracking_media, COUNT( tracking_media ) media_cnt, tracking_ipaddr FROM ".$_gl['tracking_info_table']." WHERE tracking_ipaddr <> '121.254.252.73' AND tracking_date LIKE  '%".$daily_date."%' GROUP BY tracking_media";
		$media_res		= mysqli_query($my_db, $media_query);
		
		unset($media_name);
		unset($media_cnt);
		unset($pc_cnt);
		unset($mobile_cnt);
		$total_media_cnt = 0;
		$total_mobile_cnt = 0;
		$total_pc_cnt = 0;    
		while ($media_daily_data = mysqli_fetch_array($media_res))
		{
			$media_name[]	= $media_daily_data['tracking_media'];
			$media_cnt[]	= $media_daily_data['media_cnt'];
			$pc_query		= "SELECT * FROM ".$_gl['tracking_info_table']." WHERE tracking_ipaddr <> '121.254.252.73' AND tracking_date LIKE  '%".$daily_date."%' AND tracking_media='".$media_daily_data['tracking_media']."' AND tracking_gubun='PC'";
			$pc_count		= mysqli_num_rows(mysqli_query($my_db, $pc_query));
			$mobile_query	= "SELECT * FROM ".$_gl['tracking_info_table']." WHERE tracking_ipaddr <> '121.254.252.73' AND tracking_date LIKE  '%".$daily_date."%' AND tracking_media='".$media_daily_data['tracking_media']."' AND tracking_gubun='MOBILE'";
			$mobile_count	= mysqli_num_rows(mysqli_query($my_db, $mobile_query));
			$pc_cnt[]		= $pc_count;
			$mobile_cnt[]	= $mobile_count;

		}
		$rowspan_cnt =  count($media_name);
		$i = 0;
		foreach($media_name as $key => $val)
		{
?>
                  <tr>
<?
			if ($i == 0)
			{
?>
                    <td rowspan="<?=$rowspan_cnt?>"><?php echo $daily_date?></td>
<?
			}
?>
                    <td><?=$val?></td>
                    <td><?=number_format($pc_cnt[$i])?></td>
                    <td><?=number_format($mobile_cnt[$i])?></td>
                    <td><?=number_format($media_cnt[$i])?></td>
                  </tr>
<?php
			$total_media_cnt += $media_cnt[$i];
			$total_mobile_cnt += $mobile_cnt[$i];
			$total_pc_cnt += $pc_cnt[$i];                  
			$i++;
		}
?>
                  <tr bgcolor="skyblue">
                    <td colspan="2">합계</td>
                    <td><?php echo number_format($total_pc_cnt)?></td>
                    <td><?php echo number_format($total_mobile_cnt)?></td>
                    <td><?php echo number_format($total_media_cnt)?></td>
                  </tr>

<?
	}
?>
                </tbody>
              </table>
            </div>
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