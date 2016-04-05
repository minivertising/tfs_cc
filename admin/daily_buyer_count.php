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
        <h1 class="page-header">일자별 마음 구매자 수 PC / Mobile</h1>
      </div>
    </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-lg-8">
          <div class="table-responsive">
            <div id="daily_topgirl_vote_count_div1" style="display:block">
              <table class="table table-hover">
                <thead>
                  <tr><th rowspan="2">날짜</th><th rowspan="2">구매한 마음</th><th colspan="2">페이스북광고유입</th><th colspan="2">유튜브광고유입</th><th colspan="2">기타유입</th><th colspan="2">ALL</th><th rowspan="2">Total</th></tr>
                  <tr><th>PC</th><th>Mobile</th><th>PC</th><th>Mobile</th><th>PC</th><th>Mobile</th><th>PC</th><th>Mobile</th></tr>
                  
                </thead>
                <tbody>
<?php
	$daily_date_query	= "SELECT buyer_date FROM ".$_gl['buyer_info_table']." WHERE buyer_date <> '0000-00-00' Group by substr(buyer_date,1,10)";
	$date_res			= mysqli_query($my_db, $daily_date_query);
	while($date_daily_data = mysqli_fetch_array($date_res))
	{
		$daily_date		= substr($date_daily_data['buyer_date'],0,10);
		$buyer_goods_query	= "SELECT buyer_goods, COUNT( buyer_goods ) buyer_cnt FROM ".$_gl['buyer_info_table']." WHERE buyer_date LIKE  '%".$daily_date."%' GROUP BY buyer_goods";
		$buyer_res		= mysqli_query($my_db, $buyer_goods_query);
		
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
    
		$total_fb_pc_cnt = 0;
		$total_fb_mobile_cnt = 0;
		$total_yt_pc_cnt = 0;
		$total_yt_mobile_cnt = 0;
		$total_etc_pc_cnt = 0;
		$total_etc_mobile_cnt = 0;
		$total_all_pc_cnt = 0;
		$total_all_mobile_cnt = 0;

		$total_buyer_cnt = 0;
		while ($buyer_daily_data = mysqli_fetch_array($buyer_res))
		{
			$buyer_goods[]	= $buyer_daily_data['buyer_goods'];
			$buyer_cnt[]	= $buyer_daily_data['buyer_cnt'];
      
			$fb_pc_query		= "SELECT * FROM ".$_gl['buyer_info_table']." WHERE buyer_date LIKE  '%".$daily_date."%' AND buyer_goods='".$buyer_daily_data['buyer_goods']."' AND buyer_gubun='PC' AND buyer_media='1'";
			$fb_pc_count		= mysqli_num_rows(mysqli_query($my_db, $fb_pc_query));
			$fb_mobile_query	= "SELECT * FROM ".$_gl['buyer_info_table']." WHERE buyer_date LIKE  '%".$daily_date."%' AND buyer_goods='".$buyer_daily_data['buyer_goods']."' AND buyer_gubun='MOBILE' AND buyer_media='1'";
			$fb_mobile_count	= mysqli_num_rows(mysqli_query($my_db, $fb_mobile_query));
			$fb_pc_cnt[]		= $fb_pc_count;
			$fb_mobile_cnt[]	= $fb_mobile_count;

			$yt_pc_query		= "SELECT * FROM ".$_gl['buyer_info_table']." WHERE buyer_date LIKE  '%".$daily_date."%' AND buyer_goods='".$buyer_daily_data['buyer_goods']."' AND buyer_gubun='PC' AND buyer_media='you'";
			$yt_pc_count		= mysqli_num_rows(mysqli_query($my_db, $yt_pc_query));
			$yt_mobile_query	= "SELECT * FROM ".$_gl['buyer_info_table']." WHERE buyer_date LIKE  '%".$daily_date."%' AND buyer_goods='".$buyer_daily_data['buyer_goods']."' AND buyer_gubun='MOBILE' AND buyer_media='you'";
			$yt_mobile_count	= mysqli_num_rows(mysqli_query($my_db, $yt_mobile_query));
			$yt_pc_cnt[]		= $yt_pc_count;
			$yt_mobile_cnt[]	= $yt_mobile_count;

			$all_pc_query		= "SELECT * FROM ".$_gl['buyer_info_table']." WHERE buyer_date LIKE  '%".$daily_date."%' AND buyer_goods='".$buyer_daily_data['buyer_goods']."' AND buyer_gubun='PC'";
			$all_pc_count		= mysqli_num_rows(mysqli_query($my_db, $all_pc_query));
			$all_mobile_query	= "SELECT * FROM ".$_gl['buyer_info_table']." WHERE buyer_date LIKE  '%".$daily_date."%' AND buyer_goods='".$buyer_daily_data['buyer_goods']."' AND buyer_gubun='MOBILE'";
			$all_mobile_count	= mysqli_num_rows(mysqli_query($my_db, $all_mobile_query));
			$all_pc_cnt[]		= $all_pc_count;
			$all_mobile_cnt[]	= $all_mobile_count;
      
      $etc_pc_cnt[] = $all_pc_count - $fb_pc_count - $yt_pc_count;
      $etc_mobile_cnt[] = $all_mobile_count - $fb_mobile_count - $yt_mobile_count;

		}

		$rowspan_cnt =  count($buyer_goods);
		$i = 0;
		foreach($buyer_goods as $key => $val)
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
                    <td><?=$val?>번 마음</td>
                    <td><?=number_format($fb_pc_cnt[$i])?></td>
                    <td><?=number_format($fb_mobile_cnt[$i])?></td>
                    <td><?=number_format($yt_pc_cnt[$i])?></td>
                    <td><?=number_format($yt_mobile_cnt[$i])?></td>
                    <td><?=number_format($etc_pc_cnt[$i])?></td>
                    <td><?=number_format($etc_mobile_cnt[$i])?></td>
                    <td><?=number_format($all_pc_cnt[$i])?></td>
                    <td><?=number_format($all_mobile_cnt[$i])?></td>
                    <td><?=number_format($buyer_cnt[$i])?></td>
                  </tr>
<?php
			$total_buyer_cnt += $buyer_cnt[$i];
      
			$total_fb_mobile_cnt += $fb_mobile_cnt[$i];
			$total_fb_pc_cnt += $fb_pc_cnt[$i];            
			$total_yt_mobile_cnt += $yt_mobile_cnt[$i];
			$total_yt_pc_cnt += $yt_pc_cnt[$i];            
			$total_etc_mobile_cnt += $etc_mobile_cnt[$i];
			$total_etc_pc_cnt += $etc_pc_cnt[$i];            
			$total_all_mobile_cnt += $all_mobile_cnt[$i];
			$total_all_pc_cnt += $all_pc_cnt[$i];            
			$i++;
		}
?>
                  <tr>
                    <td colspan="2">합계</td>
                    <td><?php echo number_format($total_fb_pc_cnt)?></td>
                    <td><?php echo number_format($total_fb_mobile_cnt)?></td>
                    <td><?php echo number_format($total_yt_pc_cnt)?></td>
                    <td><?php echo number_format($total_yt_mobile_cnt)?></td>
                    <td><?php echo number_format($total_etc_pc_cnt)?></td>
                    <td><?php echo number_format($total_etc_mobile_cnt)?></td>
                    <td><?php echo number_format($total_all_pc_cnt)?></td>
                    <td><?php echo number_format($total_all_mobile_cnt)?></td>
                    <td><?php echo number_format($total_buyer_cnt)?></td>
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