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
        <h1 class="page-header">일자별 트래킹 접속 정보</h1>
      </div>
    </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-lg-8">
          <div class="table-responsive">
            <div id="daily_topgirl_vote_count_div1" style="display:block">
              <table class="table table-hover">
                <thead>
                  <tr><th rowspan="2">날짜</th><th colspan="2">페이스북공유 유입</th><th colspan="2">카카오톡공유 유입</th><th colspan="2">트위터공유 유입</th><th colspan="2">페이스북광고 유입</th><th colspan="2">카카오톡 푸쉬 유입</th><th colspan="2">페이스북 게시물 유입</th><th colspan="2">페이스북 동영상 유입</th><th colspan="2">기타 유입</th><th colspan="2">ALL</th><th rowspan="2">Total</th></tr>
                  <tr><th>PC</th><th>Mobile</th><th>PC</th><th>Mobile</th><th>PC</th><th>Mobile</th><th>PC</th><th>Mobile</th><th>PC</th><th>Mobile</th><th>PC</th><th>Mobile</th><th>PC</th><th>Mobile</th><th>PC</th><th>Mobile</th><th>PC</th><th>Mobile</th></tr>
                  
                </thead>
                <tbody>
<?php
	$daily_date_query	= "SELECT tracking_date FROM ".$_gl['tracking_info_table']." group by substr(tracking_date,1,10) order by tracking_date DESC";
	$date_res			= mysqli_query($my_db, $daily_date_query);
	while($date_daily_data = mysqli_fetch_array($date_res))
	{
		$daily_date			= substr($date_daily_data['tracking_date'],0,10);
		$tracking_query	= "SELECT tracking_media, COUNT( tracking_media ) tracking_cnt FROM ".$_gl['tracking_info_table']." WHERE tracking_date LIKE  '%".$daily_date."%' GROUP BY tracking_media";
		$tracking_res		= mysqli_query($my_db, $tracking_query);
		/*
		unset($buyer_goods);
		unset($buyer_cnt);
    
		unset($fb_pc_cnt);
		unset($fb_mobile_cnt);
		unset($yt_pc_cnt);
		unset($yt_mobile_cnt);
		unset($etc_pc_cnt);
		unset($etc_mobile_cnt);
		unset($all_pc_cnt);
		unset($all_mobile_cnt);
    */
		$total_fb_pc_cnt = 0;
		$total_fb_mobile_cnt = 0;
		$total_yt_pc_cnt = 0;
		$total_yt_mobile_cnt = 0;
		$total_etc_pc_cnt = 0;
		$total_etc_mobile_cnt = 0;
		$total_all_pc_cnt = 0;
		$total_all_mobile_cnt = 0;

		$total_buyer_cnt = 0;
		$i = 0;
		while ($tracking_daily_data = mysqli_fetch_array($tracking_res))
		{
			//$buyer_goods[]	= $tracking_daily_data['buyer_goods'];
			//$buyer_cnt[]	= $tracking_daily_data['buyer_cnt'];
      
			$fbs_pc_query			= "SELECT * FROM ".$_gl['tracking_info_table']." WHERE tracking_date LIKE  '%".$daily_date."%' AND tracking_gubun='PC' AND tracking_media='F01'";
			$fbs_pc_count			= @mysqli_num_rows(mysqli_query($my_db, $fbs_pc_query));
			$fbs_mobile_query	= "SELECT * FROM ".$_gl['tracking_info_table']." WHERE tracking_date LIKE  '%".$daily_date."%' AND tracking_gubun='MOBILE' AND tracking_media='F01'";
			$fbs_mobile_count	= @mysqli_num_rows(mysqli_query($my_db, $fbs_mobile_query));
			//$fbs_pc_cnt[]			= $fbs_pc_count;
			//$fbs_mobile_cnt[]		= $fbs_mobile_count;

			$kts_pc_query			= "SELECT * FROM ".$_gl['tracking_info_table']." WHERE tracking_date LIKE  '%".$daily_date."%' AND tracking_gubun='PC' AND tracking_media='K01'";
			$kts_pc_count			= @mysqli_num_rows(mysqli_query($my_db, $kts_pc_query));
			$kts_mobile_query	= "SELECT * FROM ".$_gl['tracking_info_table']." WHERE tracking_date LIKE  '%".$daily_date."%' AND tracking_gubun='MOBILE' AND tracking_media='K01'";
			$kts_mobile_count	= @mysqli_num_rows(mysqli_query($my_db, $kts_mobile_query));
			//$kts_pc_cnt[]			= $kts_pc_count;
			//$kts_mobile_cnt[]		= $kts_mobile_count;

			$tts_pc_query			= "SELECT * FROM ".$_gl['tracking_info_table']." WHERE tracking_date LIKE  '%".$daily_date."%' AND tracking_gubun='PC' AND tracking_media='T01'";
			$tts_pc_count			= @mysqli_num_rows(mysqli_query($my_db, $tts_pc_query));
			$tts_mobile_query	= "SELECT * FROM ".$_gl['tracking_info_table']." WHERE tracking_date LIKE  '%".$daily_date."%' AND tracking_gubun='MOBILE' AND tracking_media='T01'";
			$tts_mobile_count	= @mysqli_num_rows(mysqli_query($my_db, $tts_mobile_query));
			//$tts_pc_cnt[]			= $tts_pc_count;
			//$tts_mobile_cnt[]		= $tts_mobile_count;

			$fba_pc_query			= "SELECT * FROM ".$_gl['tracking_info_table']." WHERE tracking_date LIKE  '%".$daily_date."%' AND tracking_gubun='PC' AND tracking_media='FA01'";
			$fba_pc_count			= @mysqli_num_rows(mysqli_query($my_db, $fba_pc_query));
			$fba_mobile_query	= "SELECT * FROM ".$_gl['tracking_info_table']." WHERE tracking_date LIKE  '%".$daily_date."%' AND tracking_gubun='MOBILE' AND tracking_media='FA01'";
			$fba_mobile_count	= @mysqli_num_rows(mysqli_query($my_db, $fba_mobile_query));
			//$fba_pc_cnt[]			= $fba_pc_count;
			//$fba_mobile_cnt[]	= $fba_mobile_count;

			$ktp_pc_query			= "SELECT * FROM ".$_gl['tracking_info_table']." WHERE tracking_date LIKE  '%".$daily_date."%' AND tracking_gubun='PC' AND tracking_media='KM01'";
			$ktp_pc_count			= @mysqli_num_rows(mysqli_query($my_db, $ktp_pc_query));
			$ktp_mobile_query	= "SELECT * FROM ".$_gl['tracking_info_table']." WHERE tracking_date LIKE  '%".$daily_date."%' AND tracking_gubun='MOBILE' AND tracking_media='KM01'";
			$ktp_mobile_count	= @mysqli_num_rows(mysqli_query($my_db, $ktp_mobile_query));
			//$ktp_pc_cnt[]			= $ktp_pc_count;
			//$ktp_mobile_cnt[]	= $ktp_mobile_count;

			$fbg_pc_query			= "SELECT * FROM ".$_gl['tracking_info_table']." WHERE tracking_date LIKE  '%".$daily_date."%' AND tracking_gubun='PC' AND tracking_media='FB00'";
			$fbg_pc_count			= @mysqli_num_rows(mysqli_query($my_db, $fbg_pc_query));
			$fbg_mobile_query	= "SELECT * FROM ".$_gl['tracking_info_table']." WHERE tracking_date LIKE  '%".$daily_date."%' AND tracking_gubun='MOBILE' AND tracking_media='FB00'";
			$fbg_mobile_count	= @mysqli_num_rows(mysqli_query($my_db, $fbg_mobile_query));
			//$fbg_pc_cnt[]			= $fbg_pc_count;
			//$fbg_mobile_cnt[]	= $fbg_mobile_count;

			$fbm_pc_query			= "SELECT * FROM ".$_gl['tracking_info_table']." WHERE tracking_date LIKE  '%".$daily_date."%' AND tracking_gubun='PC' AND tracking_media='FA02'";
			$fbm_pc_count			= @mysqli_num_rows(mysqli_query($my_db, $fbm_pc_query));
			$fbm_mobile_query	= "SELECT * FROM ".$_gl['tracking_info_table']." WHERE tracking_date LIKE  '%".$daily_date."%' AND tracking_gubun='MOBILE' AND tracking_media='FA02'";
			$fbm_mobile_count	= @mysqli_num_rows(mysqli_query($my_db, $fbm_mobile_query));
			//$fbm_pc_cnt[]			= $fbm_pc_count;
			//$fbm_mobile_cnt[]	= $fbm_mobile_count;

			$all_pc_query			= "SELECT * FROM ".$_gl['tracking_info_table']." WHERE tracking_date LIKE  '%".$daily_date."%' AND tracking_gubun='PC'";
			$all_pc_count			= @mysqli_num_rows(mysqli_query($my_db, $all_pc_query));
			$all_mobile_query	= "SELECT * FROM ".$_gl['tracking_info_table']." WHERE tracking_date LIKE  '%".$daily_date."%' AND tracking_gubun='MOBILE'";
			$all_mobile_count	= @mysqli_num_rows(mysqli_query($my_db, $all_mobile_query));
			//$all_pc_cnt[]			= $all_pc_count;
			//$all_mobile_cnt[]		= $all_mobile_count;

			$etc_pc_count			= $all_pc_count - $fbs_pc_count - $kts_pc_count - $tts_pc_count - $fba_pc_count - $ktp_pc_count;
			$etc_mobile_count		= $all_mobile_count - $fbs_mobile_count - $kts_mobile_count - $tts_mobile_count - $fba_mobile_count - $ktp_mobile_count;

		}

		//$rowspan_cnt =  count($buyer_goods);
		$total_count = $all_pc_count + $all_mobile_count;
?>
                  <tr>
                    <td><?php echo $daily_date?></td>
                    <td><?=number_format($fbs_pc_count)?></td>
                    <td><?=number_format($fbs_mobile_count)?></td>
                    <td><?=number_format($kts_pc_count)?></td>
                    <td><?=number_format($kts_mobile_count)?></td>
                    <td><?=number_format($tts_pc_count)?></td>
                    <td><?=number_format($tts_mobile_count)?></td>
                    <td><?=number_format($fba_pc_count)?></td>
                    <td><?=number_format($fba_mobile_count)?></td>
                    <td><?=number_format($ktp_pc_count)?></td>
                    <td><?=number_format($ktp_mobile_count)?></td>
                    <td><?=number_format($fbg_pc_count)?></td>
                    <td><?=number_format($fbg_mobile_count)?></td>
                    <td><?=number_format($fbm_pc_count)?></td>
                    <td><?=number_format($fbm_mobile_count)?></td>
                    <td><?=number_format($etc_pc_count)?></td>
                    <td><?=number_format($etc_mobile_count)?></td>
                    <td><?=number_format($all_pc_count)?></td>
                    <td><?=number_format($all_mobile_count)?></td>
                    <td><?=number_format($total_count)?></td>
                  </tr>
<?
		$i++;
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