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
        <table id="applicant_list" class="table table-hover">
          <thead>
            <tr>
              <th>No</th>
              <th>이름</th>
              <th>나이</th>
              <th>전화번호</th>
              <th>이메일</th>
              <th>국가</th>
              <th>주소</th>
              <th>YOUTUBE URL</th>
              <th>LIKE COUNT</th>
              <th>신청날짜</th>
              <th>쿠폰 URL</th>
              <th>쿠폰 사용여부</th>
            </tr>
          </thead>
          <tbody>
<?php

$where = " WHERE strNAME LIKE '%".$search_txt."%'";

if($search_type == "search_by_name"){
	$where = " WHERE strNAME LIKE '%".$search_txt."%'";
}else if($search_type == "search_by_phone"){
	$where = " WHERE PHONE LIKE '%".$search_txt."%'";
}else if($search_type == "search_by_country"){
	if($search_txt == "필리핀"){
		$where = " WHERE TYPE = '1'";
	}else if($search_txt == "대만"){
		$where = " WHERE TYPE = '2'";
	}else if($search_txt == "인도네시아"){
		$where = " WHERE TYPE = '3'";
	}else if($search_txt == "싱가폴"){
		$where = " WHERE TYPE = '4'";
	}
}	

// 사용자 이름 검색 쿼리
$applicant_list_count_query = "SELECT count(*) FROM event_topgirl_main $where";
list($applicant_list_count) = mysqli_fetch_array(mysqli_query($my_db, $applicant_list_count_query));

$PAGE_CLASS = new Page($pg,$applicant_list_count,$page_size,$block_size);
$BLOCK_LIST = $PAGE_CLASS->blockList(); 
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount;


$applicant_list_query = "SELECT intseq, strNAME, strAGE, PHONE, EMAIL, ADDRESS , YOUTUBE, TYPE, LIKECOUNT, USERID, REGDATE, coupon_page, USED FROM event_topgirl_main $where Order by intseq DESC LIMIT $PAGE_CLASS->page_start, $page_size";
$res = mysqli_query($my_db, $applicant_list_query);

	while($applicant_data = mysqli_fetch_array($res))
	{
		if($applicant_data['TYPE']=="1"){
			$country = "필리핀";
		}else if($applicant_data['TYPE']=="2"){
			$country = "대만";
		}else if($applicant_data['TYPE']=="3"){
			$country = "인도네시아";
		}else if($applicant_data['TYPE']=="4"){
			$country = "싱가폴";
		}
?>
            <tr>
            <td><?php echo $PAGE_UNCOUNT--?></td>	<!-- No. 하나씩 감소 -->
            <td><?php echo $applicant_data['strNAME']?></td>
            <td><?php echo $applicant_data['strAGE']?></td>
            <td><?php echo $applicant_data['PHONE']?></td>
            <td><?php echo $applicant_data['EMAIL']?></td>
            <td><?php echo $country?></td>
            <td><?php echo $applicant_data['ADDRESS']?></td>
            <td><?php echo $applicant_data['YOUTUBE']?></td>
            <td><?php echo $applicant_data['LIKECOUNT']?></td>
            <td><?php echo $applicant_data['REGDATE']?></td>
            <td><?php echo $applicant_data['coupon_page']?></td>
<?php
if($applicant_data['USED']=="1"){
	$coupon_status = "사용완료";
}else if($applicant_data['USED']=="0"){
	$coupon_status = "미사용";
}
?>
            <td><?php echo $coupon_status?></td>
            </tr>
<?php 
	}
?>
            <tr><td colspan="12"><div class="pageing"><?php echo $BLOCK_LIST?></div></td></tr>
          </tbody>
        </table>
