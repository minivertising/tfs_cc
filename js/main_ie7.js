
function all_check()
{
	var chk = $("#all_agree").is(':checked');

    if (chk) {
        $("input[name=agree]:checkbox").prop('checked', true);
    } else {
        $("input[name=agree]:checkbox").prop('checked', false);
    }
}

function sns_share(media)
{
	if (media == "fb")
	{
		var newWindow = window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent('http://www.babience-giveandtake.com/?media=fb'),'sharer','toolbar=0,status=0,width=600,height=325');
		$.ajax({
			type   : "POST",
			async  : false,
			url    : "../main_exec.php",
			data:{
				"exec" : "insert_share_info",
				"media" : media
			}
		});
	}else if (media == "tw"){
		var newWindow = window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent("[베비언스] 우리 아기 이름으로 첫 기부도 하고, 매일매일 100% 당첨 선물도 테이크하세요!") + '&url='+ encodeURIComponent('http://bit.ly/1LIDUII'),'sharer','toolbar=0,status=0,width=600,height=325');
		$.ajax({
			type   : "POST",
			async  : false,
			url    : "../main_exec.php",
			data:{
				"exec" : "insert_share_info",
				"media" : media
			}
		});
	}
}

function auto_count()
{
	$.ajax({
		type:"POST",
		data:{
			"exec"					: "total_member"
		},
		url: "../main_exec.php",
		success: function(response){
			$(".block_p_num").html(response);
		}
	});
}

function auto_give_count()
{
	$.ajax({
		type:"POST",
		data:{
			"exec"					: "total_give_member"
		},
		url: "../main_exec.php",
		success: function(response){
			$("#give_view_num1").html(response);
		}
	});
}

function auto_give_count2()
{
	$.ajax({
		type:"POST",
		data:{
			"exec"					: "total_give_member2"
		},
		url: "../main_exec.php",
		success: function(response){
			$("#give_view_num2").html(response);
		}
	});
}

var timerId = 0;
function auto_comment(num)
{
	$.ajax({
		type:"POST",
		data:{
			"exec"		: "view_comment",
			"num"		: num
		},
		url: "../main_exec.php",
		success: function(response){
			var comment_txt	= response.split("||");
			$("#comment_view" + num).html(comment_txt[0]);
			timerId = setInterval("comment_rolling("+comment_txt[1]+","+num+")",2500);
		}
	});

}
var rolling_num		= 1;
function comment_rolling(cnt, num)
{
	//alert(cnt);
	$("#ct_"+rolling_num).fadeOut("fast");
	$("#cn_"+rolling_num).fadeOut("fast",function(){
		if (rolling_num == cnt)
		{
			rolling_num	= 0;
		}
		rolling_num = rolling_num + 1;
		$("#cn_"+rolling_num).fadeIn("fast");
		$("#ct_"+rolling_num).fadeIn("fast");
	});
}

function go_recom(num, detail)
{
	if (confirm('추천하시겠어요?'))
	{
		if (detail == "main")
		{
			//popup_desc('pop_event_input', num);
			open_pop('pop_event_input','');
			$("#blogger_num").val(num);
		}else{
			//$.magnificPopup.close();
			//setTimeout("popup_desc('pop_event_input', "+num+");",500);
			if (num == 1)
				open_pop('pop_event_input','pop_detail_view1')
			else if (num == 2)
				open_pop('pop_event_input','pop_detail_view2')
			else if (num == 3)
				open_pop('pop_event_input','pop_detail_view3')
			else if (num == 4)
				open_pop('pop_event_input','pop_detail_view4')
			else if (num == 5)
				open_pop('pop_event_input','pop_detail_view5')
			else if (num == 6)
				open_pop('pop_event_input','pop_detail_view6')
		}
	}
}

function go_detail(num)
{
	if (num == 1){
		open_pop('pop_detail_view1',0);
		auto_comment('1');
	}else if (num == 2){
		open_pop('pop_detail_view2',0);
		auto_comment('2');
	}else if (num == 3){
		open_pop('pop_detail_view3',0);
		auto_comment('3');
	}else if (num == 4){
		open_pop('pop_detail_view4',0);
		auto_comment('4');
	}else if (num == 5){
		open_pop('pop_detail_view5',0);
		auto_comment('5');
	}else if (num == 6){
		open_pop('pop_detail_view6',0);
		auto_comment('6');
	}
}

function go_gift()
{
	open_pop('pop_search_gift','');
}

function popup_desc(param, num)
{
	$.magnificPopup.open({
		items: {
			src: '#' + param+ ''
		},
		type: 'inline',
		fixedContentPos: true,
		fixedBgPos: true,
		overflowY: 'hidden',
		closeBtnInside: true,
		//preloader: false,
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-zoom-in',
		showCloseBtn : false,
		closeOnBgClick: true,
		callbacks: {
			open: function() {
				$("#blogger_num").val(num);
				if (param == "pop_thanks_div")
				{
					$("#serial_number").html();
				}else if (param == "pop_detail_view1"){
					auto_comment('1');
				}else if (param == "pop_detail_view2"){
					auto_comment('2');
				}else if (param == "pop_detail_view3"){
					auto_comment('3');
				}else if (param == "pop_detail_view4"){
					auto_comment('4');
				}else if (param == "pop_detail_view5"){
					auto_comment('5');
				}else if (param == "pop_detail_view6"){
					auto_comment('6');
				}
			},
			close: function() {
				chk_ins = 0;
				if (param == "pop_detail_view1"){
					$("#comment_view").html("");
					clearInterval(timerId);
					rolling_num = 1;
				}else if (param == "pop_detail_view2"){
					$("#comment_view").html("");
					clearInterval(timerId);
				}else if (param == "pop_detail_view3"){
					$("#comment_view").html("");
					clearInterval(timerId);
				}else if (param == "pop_detail_view4"){
					$("#comment_view").html("");
					clearInterval(timerId);
				}else if (param == "pop_detail_view5"){
					$("#comment_view").html("");
					clearInterval(timerId);
				}else if (param == "pop_detail_view6"){
					$("#comment_view").html("");
					clearInterval(timerId);
				}
				//chk_ins2 = 0;
				//$("#mb_receive").val("");
				//$("#mb_send").val("");
				//$("#mb_message").val("");
				$("#mb_baby_name").val("");
				$("#mb_name").val("");
				$("#mb_phone1").val("010");
				$("#mb_phone2").val("");
				$("#mb_phone3").val("");
				$("#s_name").val("");
				$("#s_phone1").val("010");
				$("#s_phone2").val("");
				$("#s_phone3").val("");
				$("#mb_comment").val("");
				$("#mb_nickname").val("");
				$('input').iCheck('uncheck');
			}
		}
	}, 0);
}

function input_info()
{
	if (chk_ins == 0)
	{
		chk_ins = 1;
		var mb_name			= $("#mb_name").val();
		var mb_phone1			= $("#mb_phone1").val();
		var mb_phone2			= $("#mb_phone2").val();
		var mb_phone3			= $("#mb_phone3").val();
		var mb_baby_name	= $("#mb_baby_name").val();
		var blogger_num		= $("#blogger_num").val();
		var mb_phone			= mb_phone1 + "-" + mb_phone2 + "-" + mb_phone3;

		if (mb_name == "")
		{

			alert('이름을 입력해 주세요.');

			$("#mb_name").focus();
			chk_ins = 0;
			return false;
		}

		if (mb_phone2 == "")
		{

			alert('전화번호를 입력해 주세요.');

			$("#mb_phone2").focus();
			chk_ins = 0;
			return false;
		}

		if (mb_phone3 == "")
		{

			alert('전화번호를 입력해 주세요.');

			$("#mb_phone3").focus();
			chk_ins = 0;
			return false;
		}

		if (mb_baby_name == "")
		{

			alert('아기 이름을 입력해주세요.');

			$("#mb_baby_name").focus();
			chk_ins = 0;
			return false;
		}

		if ($('#use_agree').is(":checked") == false)
		{
			alert("개인정보 활용 동의를 안 하셨습니다");
			chk_ins = 0;
			return false;
		}

		if ($('#privacy_agree').is(":checked") == false)
		{
			alert("개인정보 취급 위탁 동의를 안 하셨습니다");
			chk_ins = 0;
			return false;
		}

		if ($('#adver_agree').is(":checked") == false)
		{
			alert("광고 동의 약관에 동의를 안 하셨습니다");
			chk_ins = 0;
			return false;
		}

		$.ajax({
			type:"POST",
			data:{
				"exec"					: "insert_info",
				"mb_name"			: mb_name,
				"mb_phone"			: mb_phone,
				"mb_baby_name"	: mb_baby_name,
				"blogger_num"		: blogger_num
			},
			url: "../main_exec.php",
			success: function(response){
				if (response == "N")
				{
					alert("사용자가 많아 접속이 지연되고 있습니다. 다시 추천해 주세요.");
				}else if (response == "D"){
					open_pop('pop_dupli_div','pop_event_input');
				}else if (response == "E"){
					//open_pop('pop_dupli_div','pop_event_input');
					alert("오늘 참여 횟수를 다 쓰셨습니다. 내일 또 참여해 주세요.");
				}else{
					open_pop('pop_thanks_div','pop_event_input');
					var giftArr	= response.split("||");
					if (giftArr[0] == "CASH")
					{
						$("#prize_txt").attr("src","images/popup/img_gift_coupon.png");
					}
					$("#serial_number").html(giftArr[1]);
				}
			}
		});
	}
}

function search_gift()
{
	var s_name	= $("#s_name").val();
	var s_phone1	= $("#s_phone1").val();
	var s_phone2	= $("#s_phone2").val();
	var s_phone3	= $("#s_phone3").val();
	var s_phone			= s_phone1 + "-" + s_phone2 + "-" + s_phone3;

	if (s_name == "")
	{
		alert('검색하실 이름을 입력해 주세요.');

		$("#s_name").focus();
		return false;
	}

	if (s_phone2 == "")
	{
		alert('검색하실 전화번호를 입력해 주세요.');

		$("#s_phone2").focus();
		return false;
	}

	if (s_phone3 == "")
	{
		alert('검색하실 전화번호를 입력해 주세요.');

		$("#s_phone3").focus();
		return false;
	}

	$.ajax({
		type:"POST",
		data:{
			"exec"				: "search_info",
			"s_name"				: s_name,
			"s_phone"			: s_phone
		},
		url: "../main_exec.php",
		success: function(response){
			$(".no_gift").hide();
			$(".yes_gift").show();

			$(".block_gift_num").html(response);
		}
	});
}

function input_comment(num)
{
	var mb_nickname	= $("#mb_nickname"+num).val();
	var mb_comment	= $("#mb_comment"+num).val();
	var blogger_idx		= $("#blogger_idx"+num).val();
	if (mb_nickname== "")
	{
		alert('닉네임을 입력해 주세요.');

		$("#mb_nickname"+num).focus();
		return false;
	}

	if (mb_comment == "")
	{
		alert('응원 댓글을 입력해 주세요.');

		$("#mb_comment"+num).focus();
		return false;
	}

	$.ajax({
		type:"POST",
		data:{
			"exec"				: "insert_comment",
			"mb_nickname"	: mb_nickname,
			"mb_comment"		: mb_comment,
			"blogger_idx"		: blogger_idx
		},
		url: "../main_exec.php",
		success: function(response){
			if (response == "Y")
			{
				if (blogger_idx == 1)
				{
					open_pop('pop_detail_view1','pop_comment_input1');
				}else if (blogger_idx == 2){
					open_pop('pop_detail_view2','pop_comment_input2');
				}else if (blogger_idx == 3){
					open_pop('pop_detail_view3','pop_comment_input3');
				}else if (blogger_idx == 4){
					open_pop('pop_detail_view4','pop_comment_input4');
				}else if (blogger_idx == 5){
					open_pop('pop_detail_view5','pop_comment_input5');
				}else if (blogger_idx == 6){
					open_pop('pop_detail_view6','pop_comment_input6');
				}
			}else{
				alert("접속자가 많아 지연되고 있습니다. 다시 시도해 주세요.");
			}
		}
	});

}

function copy_url(ss_url)
{
	//window.clipboardData.setData('text',"11<?=$_SESSION['ss_url']?>");
    //alert("클립보드에 복사되었습니다.");
	//var text = $("#serial_number").val();
	var text = ss_url;
	if(window.clipboardData){
		// IE처리
		// 클립보드에 문자열 복사
		window.clipboardData.setData('text', text);
		alert("클립보드에 복사되었습니다.");
	} else {
		// 비IE 처리    
		window.prompt ("Ctrl+C를 눌러 나의 선물번호를 복사해주세요!", text);  
	}
}

function open_pop(param, param2)
{
	$(".mask").width($(window).width());
	$(".mask").height($(window).height());

	$(".mask").show();

	if (param2 != "")
		$("#" + param2).hide();
	
	$("#" + param).show();
}

function close_pop(param)
{
	$("#" + param).hide();
	$(".mask").hide();
	location.reload();
}

/*
** param1 : 파워블로거 순번 (1~6)
** param2 : 주차 (1~4)
*/
var b_sel_num	= "4";
var b_url = "";
function show_story(param1, param2)
{
	if (param1 == "1")
	{
		if (param2 == "1")
		{
			b_url = "http://vazzanga.blog.me/220406355379";
		}else if (param2 == "2"){
			b_url = "http://vazzanga.blog.me/220413766743";
		}else if (param2 == "3"){
			b_url = "http://vazzanga.blog.me/220420676272";
		}else if (param2 == "4"){
			b_url = "http://vazzanga.blog.me/220429963527";
		}
	}else if (param1 == "2"){
		if (param2 == "1")
		{
			b_url = "http://blog.naver.com/goeun061133/220406179689";
		}else if (param2 == "2"){
			b_url = "http://blog.naver.com/goeun061133/220413488609";
		}else if (param2 == "3"){
			b_url = "http://blog.naver.com/goeun061133/220420035884";
		}else if (param2 == "4"){
			b_url = "http://blog.naver.com/goeun061133/220429923527";
		}
	}else if (param1 == "3"){
		if (param2 == "1")
		{
			b_url = "http://blog.naver.com/luckyj407/220406414442";
		}else if (param2 == "2"){
			b_url = "http://blog.naver.com/luckyj407/220413302937";
		}else if (param2 == "3"){
			b_url = "http://blog.naver.com/luckyj407/220420096757";
		}else if (param2 == "4"){
			b_url = "http://blog.naver.com/luckyj407/220428436797";
		}
	}else if (param1 == "4"){
		if (param2 == "1")
		{
			b_url = "http://jinjuseo.blog.me/220406575011";
		}else if (param2 == "2"){
			b_url = "http://jinjuseo.blog.me/220413279091";
		}else if (param2 == "3"){
			b_url = "http://jinjuseo.blog.me/220420390740";
		}else if (param2 == "4"){
			b_url = "http://jinjuseo.blog.me/220428422900";
		}
	}else if (param1 == "5"){
		if (param2 == "1")
		{
			b_url = "http://lovewjs012.blog.me/220406442563";
		}else if (param2 == "2"){
			b_url = "http://lovewjs012.blog.me/220413721936";
		}else if (param2 == "3"){
			b_url = "http://lovewjs012.blog.me/220419511767";
		}else if (param2 == "4"){
			b_url = "http://lovewjs012.blog.me/220428098259";
		}
	}else if (param1 == "6"){
		if (param2 == "1")
		{
			b_url = "http://clever_fox.blog.me/220406173165";
		}else if (param2 == "2"){
			b_url = "http://clever_fox.blog.me/220413541064";
		}else if (param2 == "3"){
			b_url = "http://clever_fox.blog.me/220420230434";
		}else if (param2 == "4"){
			b_url = "http://clever_fox.blog.me/220427841369";
		}
	}

	//if (param2 == "4")
	//{
		//alert("곧 오픈됩니다!");
		//return false;
	//}
	$("#post_area"+param1).fadeOut("fast", function(){
		var post_html = "<a href='"+b_url+"' target='_blank'><img src='images/popup/bloger_img_"+param1+"_"+param2+".png' alt=''/></a>";
		$("#post_area"+param1).html(post_html);
		$("#b"+param1+"_tab"+b_sel_num).attr("src","images/popup/tab_menu_"+b_sel_num+"_off.png");
		$("#post_area"+param1).fadeIn("fast", function(){
			$("#b"+param1+"_tab"+param2).attr("src","images/popup/tab_menu_"+param2+"_on.png");
			$("#b_name_url"+param1).attr("href",b_url);
			b_sel_num = param2;
		});
	});
}
