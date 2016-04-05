<?php
include_once "./include/page.class.php"; 			//페이징 클래스
include_once "./include/db_conn.php"; 			//DB 접속정보
include "./head.php";

$search_type = $_REQUEST['search_type'];
$search_txt = $_REQUEST['search_txt'];
$pg = $_REQUEST['pg'];

##-- 페이지 조건
if(!$pg) $pg = 1;
$page_size = 20;
$block_size = 10;
?>
          <table id="vote_winner_list" class="table table-hover">
          <thead>
            <tr>
              <th>No</th>
              <th>이름</th>
              <th>전화번호</th>
              <th>이메일</th>
              <th>국가</th>
              <th>당첨날짜</th>
            </tr>
          </thead>
          <tbody>
<?php

$where = " WHERE win_name LIKE '%".$search_txt."%'";

if($search_type == "search_by_name"){
	$where = " WHERE win_name LIKE '%".$search_txt."%'";
}else if($search_type == "search_by_phone"){
	$where = " WHERE win_phone LIKE '%".$search_txt."%'";
}else if($search_type == "search_by_country"){
	if($search_txt == "필리핀"){
		$where = " WHERE type = '1'";
	}else if($search_txt == "대만"){
		$where = " WHERE type = '2'";
	}else if($search_txt == "인도네시아"){
		$where = " WHERE type = '3'";
	}else if($search_txt == "싱가폴"){
		$where = " WHERE type = '4'";
	}
}	

// 사용자 이름 검색 쿼리
$applicant_list_count_query = "SELECT count(*) FROM event_topgirl_winner $where";
list($applicant_list_count) = mysqli_fetch_array(mysqli_query($my_db, $applicant_list_count_query));

$PAGE_CLASS = new Page($pg,$applicant_list_count,$page_size,$block_size);
$BLOCK_LIST = $PAGE_CLASS->blockList(); 
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount;


$applicant_list_query = "SELECT intseq, win_name, win_phone, win_email, win_userid , win_date, type FROM event_topgirl_winner $where Order by intseq DESC LIMIT $PAGE_CLASS->page_start, $page_size";
$res = mysqli_query($my_db, $applicant_list_query);
	while($applicant_data = mysqli_fetch_array($res))
	{
		if($applicant_data[type]=="1"){
			$country = "필리핀";
		}else if($applicant_data[type]=="2"){
			$country = "대만";
		}else if($applicant_data[type]=="3"){
			$country = "인도네시아";
		}else if($applicant_data[type]=="4"){
			$country = "싱가폴";
		}
?>
            <tr>
            <td><?php echo $PAGE_UNCOUNT--?></td>	<!-- No. 하나씩 감소 -->
            <td><?php echo $applicant_data[win_name]?></td>
            <td><?php echo $applicant_data[win_phone]?></td>
            <td><?php echo $applicant_data[win_email]?></td>
            <td><?php echo $country?></td>
            <td><?php echo $applicant_data[win_date]?></td>
            </tr>
<?php 
	}
?>
            <tr><td colspan="12"><div class="pageing"><?php echo $BLOCK_LIST?></div></td></tr>
          </tbody>
        </table>
