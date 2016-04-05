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
        <h1 class="page-header">일자별 영상 선택 수</h1>
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
                <th>남자 영상1</th>
                <th>남자 영상2</th>
                <th>남자 영상3</th>
                <th>남자 영상4</th>
                <th>여자 영상1</th>
                <th>여자 영상2</th>
                <th>여자 영상3</th>
                <th>여자 영상4</th>
                <th>합계</th>
              </tr>
            </thead>
            <tbody>
<?php 
	$date_query = "SELECT substr(mb_regdate,1,10) mb_date FROM ".$_gl['member_info_table']." WHERE mb_regdate <> '0000-00-00 00:00:00' Group by substr(mb_regdate,1,10) order by mb_regdate desc";
	$res = mysqli_query($my_db, $date_query);
	
	while ($date_data = @mysqli_fetch_array($res))
	{		
		$b_query		= "SELECT mb_movie, count(mb_movie) cnt FROM ".$_gl['member_info_table']." WHERE mb_regdate LIKE  '%".$date_data['mb_date']."%' GROUP BY mb_movie";
		$result		= mysqli_query($my_db, $b_query);
		$i = 1;
		$total_count = 0;
		while ($b_data = mysqli_fetch_array($result))
		{
			if ($b_data['mb_movie'] == "m_1")
			{
				$movie_info[1]	= $b_data['cnt'];
			}else if ($b_data['mb_movie'] == "m_2"){
				$movie_info[2]	= $b_data['cnt'];
			}else if ($b_data['mb_movie'] == "m_3"){
				$movie_info[3]	= $b_data['cnt'];
			}else if ($b_data['mb_movie'] == "m_4"){
				$movie_info[4]	= $b_data['cnt'];
			}else if ($b_data['mb_movie'] == "w_1"){
				$movie_info[5]	= $b_data['cnt'];
			}else if ($b_data['mb_movie'] == "w_2"){
				$movie_info[6]	= $b_data['cnt'];
			}else if ($b_data['mb_movie'] == "w_3"){
				$movie_info[7]	= $b_data['cnt'];
			}else if ($b_data['mb_movie'] == "w_4"){
				$movie_info[8]	= $b_data['cnt'];
			}
			$total_count			= $total_count + $b_data['cnt'];
			$i++;
		}
?>
              <tr>
                <td><?php echo $date_data['mb_date']?></td>
                <td><?php echo number_format($movie_info[1])?></td>
                <td><?php echo number_format($movie_info[2])?></td>
                <td><?php echo number_format($movie_info[3])?></td>
                <td><?php echo number_format($movie_info[4])?></td>
                <td><?php echo number_format($movie_info[5])?></td>
                <td><?php echo number_format($movie_info[6])?></td>
                <td><?php echo number_format($movie_info[7])?></td>
                <td><?php echo number_format($movie_info[8])?></td>
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