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
          <h1 class="page-header">공유 정보</h1>
        </div>
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-lg-6">
          <div class="table-responsive">
              <h3>SNS공유</h3>
              <table id="buyer_list" class="table table-hover">
                <thead>
                  <tr>
                      <th>공유매체</th>
                      <th>PC</th>
                      <th>Mobile</th>
                      <th>Total</th>
                  </tr>
                </thead>
                <tbody>
<?php
		$media_query	= "SELECT sns_media, COUNT( sns_media ) media_cnt FROM ".$_gl['share_info_table']." GROUP BY sns_media";
		$media_res		= mysqli_query($my_db, $media_query);

		while ($media_data = mysqli_fetch_array($media_res))
		{
			$pc_query		= "SELECT * FROM ".$_gl['share_info_table']." WHERE sns_media='".$media_data['sns_media']."' AND sns_gubun='PC'";
			$pc_count		= mysqli_num_rows(mysqli_query($my_db, $pc_query));
			$mobile_query	= "SELECT * FROM ".$_gl['share_info_table']." WHERE sns_media='".$media_data['sns_media']."' AND sns_gubun='MOBILE'";
			$mobile_count	= mysqli_num_rows(mysqli_query($my_db, $mobile_query));
			$total_count		= $pc_count + $mobile_count;

?>
                  <tr>
                    <td><?=$media_data['sns_media']?></td>
                    <td><?=number_format($pc_count)?></td>
                    <td><?=number_format($mobile_count)?></td>
                    <td><?=number_format($total_count)?></td>
                  </tr>
<?php
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