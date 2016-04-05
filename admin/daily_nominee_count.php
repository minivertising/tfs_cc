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
        <h1 class="page-header">일자별 항목당 후보 지원 수</h1>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">
        <div class="table-responsive">
          <table id="entry_list" class="table table-hover">
            <thead>
              <tr>
                <th rowspan="2">날짜</th>
                <th colspan="2">심쿵미소 연기상</th>
                <th colspan="2">혼신의 눈물 연기상</th>
                <th colspan="2">코믹 표정 연기상</th>
                <th colspan="2">베비언스 먹방상</th>
                <th colspan="2">폭풍숙면 연기상</th>
                <th>합계</th>
              </tr>
              <tr>
                <th>사진</th>
                <th>영상</th>
                <th>사진</th>
                <th>영상</th>
                <th>사진</th>
                <th>영상</th>
                <th>사진</th>
                <th>영상</th>
                <th>사진</th>
                <th>영상</th>
                <th>합계</th>
              </tr>
            </thead>
            <tbody>
<?php 
	$date_query = "SELECT substr(mb_regdate,1,10) mb_date FROM ".$_gl['member_info_table']." WHERE mb_regdate <> '0000-00-00 00:00:00' Group by substr(mb_regdate,1,10) order by mb_regdate desc";
	$res = mysqli_query($my_db, $date_query);
	
	while ($date_data = @mysqli_fetch_array($res))
	{		
		$daily_date		= substr($date_data['mb_date'],0,10);
		unset($nominee1_P_count);
		unset($nominee1_V_count);
		unset($nominee2_P_count);
		unset($nominee2_V_count);
		unset($nominee3_P_count);
		unset($nominee3_V_count);
		unset($nominee4_P_count);
		unset($nominee4_V_count);
		unset($nominee5_P_count);
		unset($nominee5_V_count);
		unset($total_count);
		$nominee1_P_query		= "SELECT * FROM ".$_gl['member_info_table']." WHERE mb_upload_url is not null AND mb_regdate LIKE  '%".$daily_date."%' AND mb_sel_nominees='1' AND mb_upload_flag='P'";
		$nominee1_P_count		= mysqli_num_rows(mysqli_query($my_db, $nominee1_P_query));
		$nominee1_V_query		= "SELECT * FROM ".$_gl['member_info_table']." WHERE mb_upload_url is not null AND mb_regdate LIKE  '%".$daily_date."%' AND mb_sel_nominees='1' AND mb_upload_flag='V'";
		$nominee1_V_count		= mysqli_num_rows(mysqli_query($my_db, $nominee1_V_query));
		$nominee2_P_query		= "SELECT * FROM ".$_gl['member_info_table']." WHERE mb_upload_url is not null AND mb_regdate LIKE  '%".$daily_date."%' AND mb_sel_nominees='2' AND mb_upload_flag='P'";
		$nominee2_P_count		= mysqli_num_rows(mysqli_query($my_db, $nominee2_P_query));
		$nominee2_V_query		= "SELECT * FROM ".$_gl['member_info_table']." WHERE mb_upload_url is not null AND mb_regdate LIKE  '%".$daily_date."%' AND mb_sel_nominees='2' AND mb_upload_flag='V'";
		$nominee2_V_count		= mysqli_num_rows(mysqli_query($my_db, $nominee2_V_query));
		$nominee3_P_query		= "SELECT * FROM ".$_gl['member_info_table']." WHERE mb_upload_url is not null AND mb_regdate LIKE  '%".$daily_date."%' AND mb_sel_nominees='3' AND mb_upload_flag='P'";
		$nominee3_P_count		= mysqli_num_rows(mysqli_query($my_db, $nominee3_P_query));
		$nominee3_V_query		= "SELECT * FROM ".$_gl['member_info_table']." WHERE mb_upload_url is not null AND mb_regdate LIKE  '%".$daily_date."%' AND mb_sel_nominees='3' AND mb_upload_flag='V'";
		$nominee3_V_count		= mysqli_num_rows(mysqli_query($my_db, $nominee3_V_query));
		$nominee4_P_query		= "SELECT * FROM ".$_gl['member_info_table']." WHERE mb_upload_url is not null AND mb_regdate LIKE  '%".$daily_date."%' AND mb_sel_nominees='4' AND mb_upload_flag='P'";
		$nominee4_P_count		= mysqli_num_rows(mysqli_query($my_db, $nominee4_P_query));
		$nominee4_V_query		= "SELECT * FROM ".$_gl['member_info_table']." WHERE mb_upload_url is not null AND mb_regdate LIKE  '%".$daily_date."%' AND mb_sel_nominees='4' AND mb_upload_flag='V'";
		$nominee4_V_count		= mysqli_num_rows(mysqli_query($my_db, $nominee4_V_query));
		$nominee5_P_query		= "SELECT * FROM ".$_gl['member_info_table']." WHERE mb_upload_url is not null AND mb_regdate LIKE  '%".$daily_date."%' AND mb_sel_nominees='5' AND mb_upload_flag='P'";
		$nominee5_P_count		= mysqli_num_rows(mysqli_query($my_db, $nominee5_P_query));
		$nominee5_V_query		= "SELECT * FROM ".$_gl['member_info_table']." WHERE mb_upload_url is not null AND mb_regdate LIKE  '%".$daily_date."%' AND mb_sel_nominees='5' AND mb_upload_flag='V'";
		$nominee5_V_count		= mysqli_num_rows(mysqli_query($my_db, $nominee5_V_query));
		$total_count					= $nominee1_P_count + $nominee1_V_count + $nominee2_P_count + $nominee2_V_count + $nominee3_P_count + $nominee3_V_count + $nominee4_P_count + $nominee4_V_count + $nominee5_P_count + $nominee5_V_count;
?>
              <tr>
                <td><?php echo $date_data['mb_date']?></td>
                <td><?php echo number_format($nominee1_P_count)?></td>
                <td><?php echo number_format($nominee1_V_count)?></td>
                <td><?php echo number_format($nominee2_P_count)?></td>
                <td><?php echo number_format($nominee2_V_count)?></td>
                <td><?php echo number_format($nominee3_P_count)?></td>
                <td><?php echo number_format($nominee3_V_count)?></td>
                <td><?php echo number_format($nominee4_P_count)?></td>
                <td><?php echo number_format($nominee4_V_count)?></td>
                <td><?php echo number_format($nominee5_P_count)?></td>
                <td><?php echo number_format($nominee5_V_count)?></td>
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