<?php
	// 설정파일
	include_once "../config.belif";

	include "./head.php";
?>

<div id="page-wrapper">
  <div class="container-fluid">
  <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">일자별 공유한 응모자 수</h1>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">
        <div class="table-responsive">
          <table id="entry_list" class="table table-hover">
            <thead>
              <tr>
                <th rowspan="3">날짜</th>
                <th colspan="7">메인에서 공유</th>
                <th bgcolor="skyblue" colspan="7">이벤트 참여후 공유</th>
                <th rowspan="3">합계</th>
              </tr>
              <tr>
                <th colspan="3">PC</th>
                <th colspan="4">MOBILE</th>
                <th bgcolor="skyblue" colspan="3">PC</th>
                <th bgcolor="skyblue" colspan="4">MOBILE</th>
              </tr>
              <tr>
                <th>FB</th>
                <th>KS</th>
                <th>TW</th>
                <th>FB</th>
                <th>KS</th>
                <th>TW</th>
                <th>KT</th>
                <th bgcolor="skyblue">FB</th>
                <th bgcolor="skyblue">KS</th>
                <th bgcolor="skyblue">TW</th>
                <th bgcolor="skyblue">FB</th>
                <th bgcolor="skyblue">KS</th>
                <th bgcolor="skyblue">TW</th>
                <th bgcolor="skyblue">KT</th>
              </tr>
            </thead>
            <tbody>
<?php 
	$daily_date_query	= "SELECT sns_regdate FROM ".$_gl['share_info_table']." Group by substr(sns_regdate,1,10) order by sns_regdate desc";
	$date_res			= mysqli_query($my_db, $daily_date_query);
	
	while ($date_data = @mysqli_fetch_array($date_res))
	{
		$daily_date		= substr($date_data['sns_regdate'],0,10);

		unset($share_main_P_fb_count);
		unset($share_main_P_ks_count);
		unset($share_main_P_tw_count);
		unset($share_main_M_fb_count);
		unset($share_main_M_ks_count);
		unset($share_main_M_tw_count);
		unset($share_main_M_kt_count);

		unset($share_nominee_P_fb_count);
		unset($share_nominee_P_ks_count);
		unset($share_nominee_P_tw_count);
		unset($share_nominee_M_fb_count);
		unset($share_nominee_M_ks_count);
		unset($share_nominee_M_tw_count);
		unset($share_nominee_M_kt_count);

		unset($share_vote_P_fb_count);
		unset($share_vote_P_ks_count);
		unset($share_vote_P_tw_count);
		unset($share_vote_M_fb_count);
		unset($share_vote_M_ks_count);
		unset($share_vote_M_tw_count);
		unset($share_vote_M_kt_count);

		unset($share_end_P_fb_count);
		unset($share_end_P_ks_count);
		unset($share_end_P_tw_count);
		unset($share_end_M_fb_count);
		unset($share_end_M_ks_count);
		unset($share_end_M_tw_count);
		unset($share_end_M_kt_count);


		unset($total_count);
		$share_main_P_fb_query		= "SELECT * FROM ".$_gl['share_info_table']." WHERE sns_regdate LIKE  '%".$daily_date."%' AND sns_flag='main' AND sns_media='fb' AND sns_gubun='PC'";
		$share_main_P_fb_count		= mysqli_num_rows(mysqli_query($my_db, $share_main_P_fb_query));
		$share_main_P_ks_query		= "SELECT * FROM ".$_gl['share_info_table']." WHERE sns_regdate LIKE  '%".$daily_date."%' AND sns_flag='main' AND sns_media='ks' AND sns_gubun='PC'";
		$share_main_P_ks_count		= mysqli_num_rows(mysqli_query($my_db, $share_main_P_ks_query));
		$share_main_P_tw_query		= "SELECT * FROM ".$_gl['share_info_table']." WHERE sns_regdate LIKE  '%".$daily_date."%' AND sns_flag='main' AND sns_media='tw' AND sns_gubun='PC'";
		$share_main_P_tw_count		= mysqli_num_rows(mysqli_query($my_db, $share_main_P_tw_query));
		$share_main_M_fb_query		= "SELECT * FROM ".$_gl['share_info_table']." WHERE sns_regdate LIKE  '%".$daily_date."%' AND sns_flag='main' AND sns_media='fb' AND sns_gubun='MOBILE'";
		$share_main_M_fb_count		= mysqli_num_rows(mysqli_query($my_db, $share_main_M_fb_query));
		$share_main_M_ks_query		= "SELECT * FROM ".$_gl['share_info_table']." WHERE sns_regdate LIKE  '%".$daily_date."%' AND sns_flag='main' AND sns_media='ks' AND sns_gubun='MOBILE'";
		$share_main_M_ks_count		= mysqli_num_rows(mysqli_query($my_db, $share_main_M_ks_query));
		$share_main_M_tw_query		= "SELECT * FROM ".$_gl['share_info_table']." WHERE sns_regdate LIKE  '%".$daily_date."%' AND sns_flag='main' AND sns_media='tw' AND sns_gubun='MOBILE'";
		$share_main_M_tw_count		= mysqli_num_rows(mysqli_query($my_db, $share_main_M_tw_query));
		$share_main_M_kt_query		= "SELECT * FROM ".$_gl['share_info_table']." WHERE sns_regdate LIKE  '%".$daily_date."%' AND sns_flag='main' AND sns_media='kt' AND sns_gubun='MOBILE'";
		$share_main_M_kt_count		= mysqli_num_rows(mysqli_query($my_db, $share_main_M_kt_query));

		$share_nominee_P_fb_query		= "SELECT * FROM ".$_gl['share_info_table']." WHERE sns_regdate LIKE  '%".$daily_date."%' AND sns_flag='nominee' AND sns_media='fb' AND sns_gubun='PC'";
		$share_nominee_P_fb_count		= mysqli_num_rows(mysqli_query($my_db, $share_nominee_P_fb_query));
		$share_nominee_P_ks_query		= "SELECT * FROM ".$_gl['share_info_table']." WHERE sns_regdate LIKE  '%".$daily_date."%' AND sns_flag='nominee' AND sns_media='ks' AND sns_gubun='PC'";
		$share_nominee_P_ks_count		= mysqli_num_rows(mysqli_query($my_db, $share_nominee_P_ks_query));
		$share_nominee_P_tw_query		= "SELECT * FROM ".$_gl['share_info_table']." WHERE sns_regdate LIKE  '%".$daily_date."%' AND sns_flag='nominee' AND sns_media='tw' AND sns_gubun='PC'";
		$share_nominee_P_tw_count		= mysqli_num_rows(mysqli_query($my_db, $share_nominee_P_tw_query));
		$share_nominee_M_fb_query		= "SELECT * FROM ".$_gl['share_info_table']." WHERE sns_regdate LIKE  '%".$daily_date."%' AND sns_flag='nominee' AND sns_media='fb' AND sns_gubun='MOBILE'";
		$share_nominee_M_fb_count		= mysqli_num_rows(mysqli_query($my_db, $share_nominee_M_fb_query));
		$share_nominee_M_ks_query		= "SELECT * FROM ".$_gl['share_info_table']." WHERE sns_regdate LIKE  '%".$daily_date."%' AND sns_flag='nominee' AND sns_media='ks' AND sns_gubun='MOBILE'";
		$share_nominee_M_ks_count		= mysqli_num_rows(mysqli_query($my_db, $share_nominee_M_ks_query));
		$share_nominee_M_tw_query		= "SELECT * FROM ".$_gl['share_info_table']." WHERE sns_regdate LIKE  '%".$daily_date."%' AND sns_flag='nominee' AND sns_media='tw' AND sns_gubun='MOBILE'";
		$share_nominee_M_tw_count		= mysqli_num_rows(mysqli_query($my_db, $share_nominee_M_tw_query));
		$share_nominee_M_kt_query		= "SELECT * FROM ".$_gl['share_info_table']." WHERE sns_regdate LIKE  '%".$daily_date."%' AND sns_flag='nominee' AND sns_media='kt' AND sns_gubun='MOBILE'";
		$share_nominee_M_kt_count		= mysqli_num_rows(mysqli_query($my_db, $share_nominee_M_kt_query));

		$share_vote_P_fb_query		= "SELECT * FROM ".$_gl['share_info_table']." WHERE sns_regdate LIKE  '%".$daily_date."%' AND sns_flag='vote' AND sns_media='fb' AND sns_gubun='PC'";
		$share_vote_P_fb_count		= mysqli_num_rows(mysqli_query($my_db, $share_vote_P_fb_query));
		$share_vote_P_ks_query		= "SELECT * FROM ".$_gl['share_info_table']." WHERE sns_regdate LIKE  '%".$daily_date."%' AND sns_flag='vote' AND sns_media='ks' AND sns_gubun='PC'";
		$share_vote_P_ks_count		= mysqli_num_rows(mysqli_query($my_db, $share_vote_P_ks_query));
		$share_vote_P_tw_query		= "SELECT * FROM ".$_gl['share_info_table']." WHERE sns_regdate LIKE  '%".$daily_date."%' AND sns_flag='vote' AND sns_media='tw' AND sns_gubun='PC'";
		$share_vote_P_tw_count		= mysqli_num_rows(mysqli_query($my_db, $share_vote_P_tw_query));
		$share_vote_M_fb_query		= "SELECT * FROM ".$_gl['share_info_table']." WHERE sns_regdate LIKE  '%".$daily_date."%' AND sns_flag='vote' AND sns_media='fb' AND sns_gubun='MOBILE'";
		$share_vote_M_fb_count		= mysqli_num_rows(mysqli_query($my_db, $share_vote_M_fb_query));
		$share_vote_M_ks_query		= "SELECT * FROM ".$_gl['share_info_table']." WHERE sns_regdate LIKE  '%".$daily_date."%' AND sns_flag='vote' AND sns_media='ks' AND sns_gubun='MOBILE'";
		$share_vote_M_ks_count		= mysqli_num_rows(mysqli_query($my_db, $share_vote_M_ks_query));
		$share_vote_M_tw_query		= "SELECT * FROM ".$_gl['share_info_table']." WHERE sns_regdate LIKE  '%".$daily_date."%' AND sns_flag='vote' AND sns_media='tw' AND sns_gubun='MOBILE'";
		$share_vote_M_tw_count		= mysqli_num_rows(mysqli_query($my_db, $share_vote_M_tw_query));
		$share_vote_M_kt_query		= "SELECT * FROM ".$_gl['share_info_table']." WHERE sns_regdate LIKE  '%".$daily_date."%' AND sns_flag='vote' AND sns_media='kt' AND sns_gubun='MOBILE'";
		$share_vote_M_kt_count		= mysqli_num_rows(mysqli_query($my_db, $share_vote_M_kt_query));

		$share_end_P_fb_count		= $share_nominee_P_fb_count + $share_vote_P_fb_count;
		$share_end_P_ks_count		= $share_nominee_P_ks_count + $share_vote_P_ks_count;
		$share_end_P_tw_count		= $share_nominee_P_tw_count + $share_vote_P_tw_count;
		$share_end_M_fb_count		= $share_nominee_M_fb_count + $share_vote_M_fb_count;
		$share_end_M_ks_count		= $share_nominee_M_ks_count + $share_vote_M_ks_count;
		$share_end_M_tw_count		= $share_nominee_M_tw_count + $share_vote_M_tw_count;
		$share_end_M_kt_count		= $share_nominee_M_kt_count + $share_vote_M_kt_count;


		$total_count					= $share_main_P_fb_count + $share_main_P_ks_count + $share_main_P_tw_count + $share_main_M_fb_count + $share_main_M_ks_count + $share_main_M_tw_count + $share_main_M_kt_count + $share_nominee_P_fb_count + $share_nominee_P_ks_count + $share_nominee_P_tw_count + $share_nominee_M_fb_count + $share_nominee_M_ks_count + $share_nominee_M_tw_count + $share_nominee_M_kt_count + $share_vote_P_fb_count + $share_vote_P_ks_count + $share_vote_P_tw_count + $share_vote_M_fb_count + $share_vote_M_ks_count + $share_vote_M_tw_count + $share_vote_M_kt_count;
?>
              <tr>
                <td><?php echo $daily_date?></td>
                <td><?php echo number_format($share_main_P_fb_count)?></td>
                <td><?php echo number_format($share_main_P_ks_count)?></td>
                <td><?php echo number_format($share_main_P_tw_count)?></td>
                <td><?php echo number_format($share_main_M_fb_count)?></td>
                <td><?php echo number_format($share_main_M_ks_count)?></td>
                <td><?php echo number_format($share_main_M_tw_count)?></td>
                <td><?php echo number_format($share_main_M_kt_count)?></td>

                <td bgcolor="skyblue"><?php echo number_format($share_end_P_fb_count)?></td>
                <td bgcolor="skyblue"><?php echo number_format($share_end_P_ks_count)?></td>
                <td bgcolor="skyblue"><?php echo number_format($share_end_P_tw_count)?></td>
                <td bgcolor="skyblue"><?php echo number_format($share_end_M_fb_count)?></td>
                <td bgcolor="skyblue"><?php echo number_format($share_end_M_ks_count)?></td>
                <td bgcolor="skyblue"><?php echo number_format($share_end_M_tw_count)?></td>
                <td bgcolor="skyblue"><?php echo number_format($share_end_M_kt_count)?></td>

                <td><?php echo number_format($total_count)?></td>
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