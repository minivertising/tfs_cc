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
        <h1 class="page-header">LMS 독려문자 전송</h1>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">
        <div class="table-responsive">
		  <a href="#" onclick="re_send();return false;">문자 재전송하기</a>
		  <a href="#" onclick="re_use();return false;">발송처리</a>
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
function re_send()
{
	if (confirm("모두에게 문자를 발송할까요?"))
	{
		$.ajax({
			type:"POST",
			data:{
				"exec"				: "all_send_sms"
			},
			url: "./admin_exec.php",
			success: function(response){
				alert(response);
			}
		});
	}
}

function re_use()
{
	if (confirm("모두 발송 처리할까요?"))
	{
		$.ajax({
			type:"POST",
			data:{
				"exec"				: "all_use"
			},
			url: "./admin_exec.php",
			success: function(response){
				alert(response);
			}
		});
	}
}
</script>