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
        <h1 class="page-header">일자별 테스트 응모자 수 PC / Mobile</h1>
      </div>
    </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-lg-6">
          <div class="table-responsive">
            <div id="daily_topgirl_vote_count_div1" style="display:block">
              <table class="table table-hover">
                <thead>
                  <tr><th>날짜</th><th>유입매체</th><th>PC</th><th>Mobile</th><th>Share</th><th>Total</th></tr>
                </thead>
                <tbody>
<?php
	$daily_date_query	= "SELECT regdate FROM ".$_gl['tk_test_result_table']." Group by substr(regdate,1,10)";
	$date_res			= mysqli_query($my_db, $daily_date_query);
	while($date_daily_data = mysqli_fetch_array($date_res))
	{
		$daily_date		= substr($date_daily_data['regdate'],0,10);
		$media_query	= "SELECT media, COUNT( media ) media_cnt FROM ".$_gl['tk_test_result_table']." WHERE regdate LIKE  '%".$daily_date."%' GROUP BY media";
		$media_res		= mysqli_query($my_db, $media_query);
		
		unset($media_name);
		unset($media_cnt);
		unset($pc_cnt);
		unset($mobile_cnt);
		unset($share_cnt);
		$total_media_cnt = 0;
        $total_share_cnt = 0;
		while ($media_daily_data = mysqli_fetch_array($media_res))
		{
			$media_name[]	= $media_daily_data['media'];
			$media_cnt[]	= $media_daily_data['media_cnt'];
			$pc_query		= "SELECT * FROM ".$_gl['tk_test_result_table']." WHERE regdate LIKE  '%".$daily_date."%' AND media='".$media_daily_data['media']."' AND gubun='PC'";
			$pc_count		= mysqli_num_rows(mysqli_query($my_db, $pc_query));
			$mobile_query	= "SELECT * FROM ".$_gl['tk_test_result_table']." WHERE regdate LIKE  '%".$daily_date."%' AND media='".$media_daily_data['media']."' AND gubun='MOBILE'";
			$mobile_count	= mysqli_num_rows(mysqli_query($my_db, $mobile_query));
			$share_query	= "SELECT * FROM ".$_gl['tk_test_result_table']." WHERE regdate LIKE  '%".$daily_date."%' AND media='".$media_daily_data['media']."' AND share='Y'";
			$share_count	= mysqli_num_rows(mysqli_query($my_db, $mobile_query));
			$pc_cnt[]		= $pc_count;
			$mobile_cnt[]	= $mobile_count;
			$share_cnt[]	= $share_count;
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
                    <td><?=number_format($share_cnt[$i])?></td>
                    <td><?=number_format($media_cnt[$i])?></td>
                  </tr>
<?php
			$total_media_cnt += $media_cnt[$i];
			$total_share_cnt += $share_cnt[$i];
			$i++;
		}
?>
                  <tr>
                    <td colspan="4">합계</td>
                    <td><?php echo number_format($total_share_cnt)?></td>
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