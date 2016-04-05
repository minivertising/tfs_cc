<?php

	// 설정파일
	include_once "../config.php";
	include "./head.php";

	if(isset($_REQUEST['sDate']) == false)
		$sDate = "";
	else
		$sDate = $_REQUEST['sDate'];
	
	if(isset($_REQUEST['eDate']) == false)
		$eDate = "";
	else
		$eDate = $_REQUEST['eDate'];
?>
<script>
	$(function() {
		$( "#sDate" ).datepicker();
		$( "#eDate" ).datepicker();
	});

	function checkfrm()
	{
		if ($("#sDate").val() > $("#eDate").val())
		{
			alert("검색 시작일은 종료일보다 작아야 합니다.");
			return false;
		}

		if ($("#sDate").val() == "" || $("#eDate").val() == "")
		{
			alert("검색 시작일과 종료일은 모두 포함 되어야 합니다.");
			return false;
		}
	}

</script>

<div id="page-wrapper">
  <div class="container-fluid">
  <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">유입경로별 접속자 수</h1>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">
        <div class="table-responsive">
          <ol class="breadcrumb">
            <form name="frm_execute" method="POST" onsubmit="return checkfrm()">
              기간 검색 : <input type="text" id="sDate" name="sDate" value="<?=$sDate?>"> - <input type="text" id="eDate" name="eDate" value="<?=$eDate?>">
              <input type="submit" value="검색">
            </form>
          </ol>
          <table id="buyer_list" class="table table-hover">
            <thead>
              <tr>
                <th>매체</th>
                <th>PC</th>
                <th>MOBILE</th>
                <th>합계</th>
              </tr>
            </thead>
            <tbody>
<?php 
    $where = "";
    
	if ($sDate != "")
		$where	= " AND reg_date >= '".$sDate."' AND reg_date <= '".$eDate." 23:59:59'";
	$media_query = "SELECT * FROM ".$_gl['tk_tracking_info_table']." WHERE 1 ".$where." GROUP BY media";
	$media_res = mysqli_query($my_db, $media_query);

	while($media_data = mysqli_fetch_array($media_res))
	{
		$pc_result_query	= "SELECT * FROM ".$_gl['tk_tracking_info_table']." WHERE media='".$media_data['media']."' ".$where." AND gubun='PC'";
		$pc_count			= mysqli_num_rows(mysqli_query($my_db, $pc_result_query));
		$mobile_result_query= "SELECT * FROM ".$_gl['tk_tracking_info_table']." WHERE media='".$media_data['media']."' ".$where." AND gubun='MOBILE'";
		$mobile_count		= mysqli_num_rows(mysqli_query($my_db, $mobile_result_query));
		$total_count		= $pc_count + $mobile_count;
?>
              <tr>
                <td><?=$media_data['media']?></td>	<!-- No. 하나씩 감소 -->
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
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
</body>

</html>