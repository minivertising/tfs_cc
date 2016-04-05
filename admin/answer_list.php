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
        <h1 class="page-header">답변 선택 목록</h1>
        </div>
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-lg-6">
          <div class="table-responsive">
            <div id="daily_story_vote_count_div1" style="display:block">
              <table class="table table-hover">
                <thead>
                  <tr><th width="300px">질문</th><th width="600px">답변</th><th width="100px">선택갯수</th></tr>
                </thead>
                <tbody>
<?php
	$test_query		= "SELECT * FROM ".$_gl['tk_worktest_table']." WHERE parent_idx='0'";
	$test_res		= mysqli_query($my_db, $test_query);
	$i = 0;
	while($test_data = mysqli_fetch_array($test_res))
	{
		$answer_query	= "SELECT * FROM ".$_gl['tk_worktest_table']." WHERE parent_idx='".$test_data['idx']."'";
		$answer_res		= mysqli_query($my_db, $answer_query);
		unset($answer_txt);
		while ($answer_data = mysqli_fetch_array($answer_res))
		{
			$answer_txt[]	= $answer_data['test_value'];
			$answer_cnt[$answer_data['test_value']][]	= $answer_data['select_cnt'];
		}

		$j = 0;
		foreach($answer_txt as $key => $val)
		{
?>
                  <tr>
<?
			if ($j%2 == 0)
			{
?>
                    <td rowspan="2"><?=$test_data['test_value']?></td>
<?
			}
?>
                    <td><?=$val?></td>
                    <td><?=$answer_cnt[$val][0]?></td>
                  </tr>
<?php
			$j++;
		}
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
