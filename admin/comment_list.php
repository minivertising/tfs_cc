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

	if(isset($_REQUEST['search_type']) == false)
		$search_type = "";
	else
		$search_type = $_REQUEST['search_type'];

	if(isset($_REQUEST['search_txt']) == false)
		$search_txt	= "";
	else
		$search_txt	= $_REQUEST['search_txt'];
	
	if(isset($_REQUEST['pg']) == false)
		$pg = "1";
	else
		$pg = $_REQUEST['pg'];
	
	if (!$pg)
		$pg = "1";
	if(isset($pg) == false) $pg = 1;	// $pg가 없으면 1로 생성
	$page_size = 10;	// 한 페이지에 나타날 개수
	$block_size = 10;	// 한 화면에 나타낼 페이지 번호 개수

	//if (isset($search_type) == false)
	//	$search_type = "search_by_name";
?>
<div id="page-wrapper">
  <div class="container-fluid">
  <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">코멘트 목록</h1>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">
        <div class="table-responsive">
          <ol class="breadcrumb">
            <form name="frm_execute" method="POST" onsubmit="return checkfrm()">
              <input type="hidden" name="pg" value="1">
              <select name="search_type">
                <option value="member_name" <?php if($search_type == "member_name"){?>selected<?php }?>>이름</option>
                <option value="content" <?php if($search_type == "content"){?>selected<?php }?>>내용</option>
              </select>
              <input type="text" name="search_txt" value="<?php echo $search_txt?>">
              <input type="submit" value="검색">
            </form>
          </ol>
          <table id="entry_list" class="table table-hover">
            <thead>
              <tr>
                <th>순번</th>
                <th>IP주소</th>
                <th>댓글 내용</th>
                <th>댓글 작성자 이름</th>
                <th>댓글 URL</th>
                <th>공유한 SNS</th>
                <th>유입매체</th>
                <th>댓글 작성 시간</th>
              </tr>
            </thead>
            <tbody>
<?php 
	$where = "";
	if ($search_txt != "")
	{
		if ($search_type == "b_name")
			$where	.= " AND B.blogger_name like '%".$search_txt."%'";
		else
			$where	.= " AND A.viewYN like '%".$search_txt."%'";
	}

	$buyer_count_query = "SELECT count(*) FROM ".$_gl['comment_info_table']." WHERE 1 ".$where."";
//1을 넣는다.
	list($buyer_count) = @mysqli_fetch_array(mysqli_query($my_db, $buyer_count_query));
	$PAGE_CLASS = new Page($pg,$buyer_count,$page_size,$block_size);

	$BLOCK_LIST = $PAGE_CLASS->blockList();
	$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount;

	$buyer_list_query = "SELECT * FROM ".$_gl['comment_info_table']." WHERE 1 ".$where." Order by idx DESC LIMIT $PAGE_CLASS->page_start, $page_size";
	$res = mysqli_query($my_db, $buyer_list_query);

	while ($buyer_data = @mysqli_fetch_array($res))
	{
		$buyer_info[] = $buyer_data; 
	}

	foreach($buyer_info as $key => $val)
	{
?>
              <tr>
                <td><?php echo $PAGE_UNCOUNT--?></td>	<!-- No. 하나씩 감소 -->
                <td><?php echo $buyer_info[$key]['ip_address']?></td>
                <td><?php echo $buyer_info[$key]['content']?></td>
                <td><?php echo $buyer_info[$key]['member_name']?></td>
                <td><?php echo $buyer_info[$key]['member_url']?></td>
                <td><?php echo $buyer_info[$key]['sept_sns']?></td>
                <td><?php echo $buyer_info[$key]['comm_media']?></td>
                <td><?php echo $buyer_info[$key]['reply_regdate']?></td>
              </tr>
<?php 
	}
?>
              <tr><td colspan="7"><div class="pageing"><?php echo $BLOCK_LIST?></div></td></tr>
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

function ok_view(num, viewYN)
{
	if (confirm("해당 코멘트를 노출상태를 변경하시겠어요?"))
	{
		$.ajax({
			type:"POST",
			data:{
				"exec"			: "view_comment",
				"idx"				: num,
				"viewYN"			: viewYN
			},
			url: "./admin_exec.php",
			success: function(response){
				location.reload();
			}
		});
	}
}
</script>