<?php

//	include_once "./include/page.class.php";

include_once "./include/db_conn.php";
include "./head.php";


$phi_num = array();
$tai_num = array();
$ind_num = array();
$sin_num = array();

?>

  <div id="page-wrapper">
    <div class="container-fluid">
    <!-- Page Heading -->
      <div class="row">
        <div class="col-lg-12">
        <h1 class="page-header">스토리 투표 국가별 집계</h1>
        </div>
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-lg-6">
          <div class="table-responsive">
            <!-- 필리핀 -->
            <div id="daily_story_vote_count_div1" style="display:block">
              <table class="table table-hover">
                <thead>
                  <tr><th rowspan="2"></th><th colspan="3">1차 투표(Style)</th><th colspan="3">2차 투표(Model)</th><th colspan="3">3차 투표(Location)</th></tr>
                  <tr><th>CUTE</th><th>FUNKY</th><th>SEXY</th><th>GENTLE</th><th>SPORTY</th><th>CASUAL</th><th>63BUILDING</th><th>HANRIVER</th><th>NAMSAN</th></tr>
                </thead>
                <tbody>
<?php
for ($i=1; $i<=4; $i++){
	$style1_query = "SELECT count(*) FROM event_topgirl_story WHERE story='cute' AND type='".$i."'";
	list($style1_count) = mysqli_fetch_array(mysqli_query($my_db, $style1_query));
	$style2_query = "SELECT count(*) FROM event_topgirl_story WHERE story='funky' AND type='".$i."'";
	list($style2_count) = mysqli_fetch_array(mysqli_query($my_db, $style2_query));
	$style3_query = "SELECT count(*) FROM event_topgirl_story WHERE story='sexy' AND type='".$i."'";
	list($style3_count) = mysqli_fetch_array(mysqli_query($my_db, $style3_query));
	$style4_query = "SELECT count(*) FROM event_topgirl_story WHERE story='gentle' AND type='".$i."'";
	list($style4_count) = mysqli_fetch_array(mysqli_query($my_db, $style4_query));
	$style5_query = "SELECT count(*) FROM event_topgirl_story WHERE story='sporty' AND type='".$i."'";
	list($style5_count) = mysqli_fetch_array(mysqli_query($my_db, $style5_query));
	$style6_query = "SELECT count(*) FROM event_topgirl_story WHERE story='casual' AND type='".$i."'";
	list($style6_count) = mysqli_fetch_array(mysqli_query($my_db, $style6_query));
	$style7_query = "SELECT count(*) FROM event_topgirl_story WHERE story='63building' AND type='".$i."'";
	list($style7_count) = mysqli_fetch_array(mysqli_query($my_db, $style7_query));
	$style8_query = "SELECT count(*) FROM event_topgirl_story WHERE story='hanriver' AND type='".$i."'";
	list($style8_count) = mysqli_fetch_array(mysqli_query($my_db, $style8_query));
	$style9_query = "SELECT count(*) FROM event_topgirl_story WHERE story='namsan' AND type='".$i."'";
	list($style9_count) = mysqli_fetch_array(mysqli_query($my_db, $style9_query));

	if ($i == '1'){
		$country = "필리핀";
		$phi_num = array($style1_count, $style2_count, $style3_count, $style4_count, $style5_count, $style6_count, $style7_count, $style8_count, $style9_count);
	}else if($i == '2'){
		$country = "대만";
		$tai_num = array($style1_count, $style2_count, $style3_count, $style4_count, $style5_count, $style6_count, $style7_count, $style8_count, $style9_count);
	}else if($i == '3'){
		$country = "인도네시아";
		$ind_num = array($style1_count, $style2_count, $style3_count, $style4_count, $style5_count, $style6_count, $style7_count, $style8_count, $style9_count);
	}else if($i == '4'){
		$country = "싱가폴";
		$sin_num = array($style1_count, $style2_count, $style3_count, $style4_count, $style5_count, $style6_count, $style7_count, $style8_count, $style9_count);
	}
?>
                <tr><th><?php echo $country?></th><td><?php echo number_format($style1_count)?></td><td><?php echo number_format($style2_count)?></td><td><?php echo number_format($style3_count)?></td><td><?php echo number_format($style4_count)?></td><td><?php echo number_format($style5_count)?></td><td><?php echo number_format($style6_count)?></td><td><?php echo number_format($style7_count)?></td><td><?php echo number_format($style8_count)?></td><td><?php echo number_format($style9_count)?></td></tr>
<?php
}
?>
				<tr><th><?php echo $sin_num[0]?></th></tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- /.row -->
		<div class="row">
<?php 
	include "chart_test.php";
?>
  		</div>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
  </div>
  <!-- /#wrapper -->

<!-- jQuery Version 1.11.0 -->
<script src="js/jquery-1.11.0.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>
