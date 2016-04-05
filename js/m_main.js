$(".mask").click(function(){
	$('#mobile_menu').animate({right:-200},300,'linear',function(){
		$("#mobile_menu").hide();
		$(".mask").fadeOut(300);
		$(window).off(".disableScroll");
	});
});

function show_menu()
{
	if ($("#mobile_menu").css("display") == "block")
	{
		$('#mobile_menu').animate({right:-200},300,'linear',function(){
			$("#mobile_menu").hide();
			$(".mask").fadeOut(300);
			$(window).off(".disableScroll");
		});
	}else{
		$(".mask").width($(window).width());
		$(".mask").height($(window).height());
		$(".mask").fadeTo(1000, 0.8);

		$('#mobile_menu').css('right','-200px');
		// 이동위치값 지정
		var position = 0;
		$('#mobile_menu').show().animate({right:position},300,'linear');

		$(window).on("mousewheel.disableScroll DOMMouseScroll.disableScroll touchmove.disableScroll", function(e) {
			e.preventDefault();
			return;
		});
	}
}

function open_pop(param)
{
	$.colorbox({innerWidth:"100%", initialWidth:"95%", inline:true, opacity:"0.9", scrolling:false, reposition: false,closeButton:false, overlayClose: false, open:true, speed:0, fadeOut: 300, href:"#"+param, onComplete: function(){
		$("#cboxContent").css("background","none");
		$("#cboxContent").css("z-index","99999");
		$('#cboxWrapper').css('backgroundColor', "");
		$('#cboxWrapper').css("z-index","99999");
		$('.popup_wrap').css("z-index","99999");
		$("#colorbox").css("z-index","99999");
		$('#cboxLoadedContent').css('backgroundColor', "");
		$('#cboxLoadedContent').css("z-index","99999");
		$("#colorbox").width($("body").width());
		//$("body").height($("#"+param).height());
		$("#cboxWrapper").width($("body").width());
		//$(".sec_main_img").hide();
		if (param == "gift_popup2" || param == "notice_popup2")
		{
			$(".sec_top").hide();
		}
	},
	onClosed: function(){
		//del_info();
		$("#cboxContent").css("background","#fff");
		$(".sec_main_img").show();
		if (param == "gift_popup2" || param == "notice_popup2")
		{
			$(".sec_top").show();
		}
	}});
}

function open_pop2(param)
{
	$.colorbox({innerWidth:"100%", initialWidth:"95%", inline:true, opacity:"0.9", scrolling:false, reposition: false,closeButton:false, overlayClose: false, open:true, speed:0, fadeOut: 300, href:"#"+param, onComplete: function(){
		$("#cboxContent").css("background","none");
		$("#cboxOverlay").css("background","none");
		$("#cboxContent").css("z-index","99999");
		$('#cboxWrapper').css('backgroundColor', "");
		$('#cboxWrapper').css("z-index","99999");
		$('.popup_wrap').css("z-index","99999");
		$("#colorbox").css("z-index","99999");
		$('#cboxLoadedContent').css('backgroundColor', "");
		$('#cboxLoadedContent').css("z-index","99999");
		$("#colorbox").width($("body").width());
		//$("body").height($("#"+param).height());
		$("#cboxWrapper").width($("body").width());
		//$(".sec_main_img").hide();
		if (param == "gift_popup2" || param == "notice_popup2")
		{
			$(".sec_top").hide();
		}
	},
	onClosed: function(){
		//del_info();
		$("#cboxContent").css("background","#fff");
		$(".sec_main_img").show();
		if (param == "gift_popup2" || param == "notice_popup2")
		{
			$(".sec_top").show();
		}
	}});
}

var count = 30;
var gage_per	= 0;
var gage_num	= 0;

function start_game()
{
	$("#game1_div").hide();
	$("#game2_div").show();
	$("#game_timer").show();

	time_control();
}

var counter = null;

function time_control()
{
	counter = setInterval(timer, 1000); //10 will  run it every 100th of a second

	function timer()
	{
		if (count <= 0)
		{
			clearInterval(counter);
			open_pop("timeover_popup");
			return;
		}
		count--;
		gage_num++;
		gage_per	= (gage_num / 30)*100;
		$(".time").html(count+"<span>초</span>");
		$(".blue").css("width",gage_per+"%");
	}
}

function right_answer(param, param2)
{
	if (param == "1")
	{
		ill_find1	= ill_find1 + 1;
		$(".stage_1_"+param2).fadeIn(200,function(){
			if (ill_find1 == 3)
			{
				$("#game2_div").fadeOut(100,function(){
					$("#game3_div").fadeIn(100);
					$("#step_image").attr("src","images/step_2.png");
				});
			}
		});
	}else if (param == "2"){
		ill_find2	= ill_find2 + 1;
		$(".stage_2_"+param2).fadeIn(200,function(){
			if (ill_find2 == 3)
			{
				clearInterval(counter);
				$(".input_info").show();
				$("#game6_div").show();
				if ($(window).height() > 550)
				{
					$( 'html, body' ).animate({ scrollTop: $(".game").height()+100},500,function(){
						//$(".inner_game").hide();
						$('body').bind('touchmove', function(e){e.preventDefault()});
						$('body').css("overflow","hidden");
					});
				}else{
					$( 'html, body' ).animate({ scrollTop: $(".game").height()+180},500,function(){
						//$(".inner_game").hide();
						$('body').bind('touchmove', function(e){e.preventDefault()});
						$('body').css("overflow","hidden");
					});
				}
			}
		});
	}
}

function change_page()
{
					$( 'html, body' ).animate({ scrollTop: $(".game").height()+155},500,function(){
					});

}

function change_addr(param)
{
	$.ajax({
		type:"POST",
		data:{
			"addr_idx"		: param.value
		},
		url: "../MOBILE/ajax_addr.php",
		success: function(response){
			$("#mb_shop").html(response);
		}
	});
}

function ins_info()
{
	var mb_name		= $("#mb_name").val();
	var mb_phone		= $("#mb_phone").val();
	var mb_addr		= $("#mb_addr").val();
	var mb_shop		= $("#mb_shop").val();

	if (mb_name == "")
	{
		alert('이름을 입력해 주세요.');
		$("#mb_name").focus();
		//chk_ins = 0;
		return false;
	}

	var chk_name	= chk_byte(mb_name,4);
	if (chk_name === false)
	{
		alert('이름은 두글자 이상 입력해주세요.');
		$("#mb_name").focus();
		//chk_ins = 0;
		return false;
	}

	if (mb_phone == "")
	{
		alert('전화번호를 입력해 주세요.');
		$("#mb_phone").focus();
		//chk_ins = 0;
		return false;
	}

	if (mb_phone.length < 10)
	{
		alert('휴대폰 번호를 정확히 입력해 주세요.');
		$("#mb_phone").focus();
		//chk_ins = 0;
		return false;
	}

	if (mb_addr == "")
	{
		alert('매장을 선택해 주세요.');
		$("#mb_addr").focus();
		//chk_ins = 0;
		return false;
	}

	if (chk_mb_flag == 0)
	{
		alert("개인정보 수집 및 위탁에 관한 동의를 안 하셨습니다");
		//chk_ins = 0;
		return false;
	}

	$.ajax({
		type:"POST",
		data:{
			"exec"				: "insert_info",
			"mb_name"		: mb_name,
			"mb_phone"		: mb_phone,
			"mb_shop"		: mb_shop,
		},
		url: "../main_exec.php",
		success: function(response){
			var resArray	= response.split("||");
			if (resArray[0] == "D")
			{
				open_pop("duplicate_popup");
			}else{
				if ($(window).height() > 550)
					$("#game6_div").css("padding-bottom","120px");
				else
					$("#game6_div").css("padding-bottom","80px");
				if (resArray[1] == "FIRST")
				{
					//$("#game6_div").show();
					$("#thanks_img").attr("src","images/bg_thanks_01.png");
					var move_height	= $("#game4_div").height() + $("#game5_div").height()+ $("#step_div").height()+ $("#sec_div").height()+ $("#bar_div").height()+ $(".close").height();
					$( 'html, body' ).animate({ scrollTop: "2200"},1500,function(){
						//$("#game5_div").hide();
						//$("body").css("overflow","auto");
					});
				}else if (resArray[1] == "SECOND"){
					$("#thanks_img").attr("src","images/bg_thanks_02.png");
					var move_height	= $("#game4_div").height() + $("#game5_div").height()+ $("#step_div").height()+ $("#sec_div").height()+ $("#bar_div").height()+ $(".close").height();
					$( 'html, body' ).animate({ scrollTop: "2200"},1500,function(){
					});
				}else if (resArray[1] == "THIRD"){
					$("#thanks_img").attr("src","images/bg_thanks_03.png");
					var move_height	= $("#game4_div").height() + $("#game5_div").height()+ $("#step_div").height()+ $("#sec_div").height()+ $("#bar_div").height()+ $(".close").height();
					$( 'html, body' ).animate({ scrollTop: "2200"},1500,function(){
					});
				}
			}
		}
	});
}

function only_num(obj)
{
	var inText = obj.value;
	var outText = "";
	var flag = true;
	var ret;
	for(var i = 0; i < inText.length; i++)
	{
		ret = inText.charCodeAt(i);
		if((ret < 48) || (ret > 57))
		{
			flag = false;
		}
		else
		{
			outText += inText.charAt(i);
		}
	}
 
	if(flag == false)
	{
		alert("전화번호는 숫자입력만 가능합니다.");
		obj.value = outText;
		obj.focus();
		return false;
	} 
	return true;
}

function only_kor(obj)
{
	var inText = obj.value;
	var outText = "";
	var flag = true;
	var ret;
	for(var i = 0; i < inText.length; i++)
	{
		var kor_check = /([^가-힣ㄱ-ㅎㅏ-ㅣ\x20])/i;
		if (kor_check.test(inText))
		{
			flag	= false;
			//alert("한글만 입력할 수 있습니다.");
			//frm.szKor.value="";
			//frm.szKor.focus();
		}else{
			outText += inText.charAt(i);
		}
	}
 
	if(flag == false)
	{
		alert("이름은 한글입력만 가능합니다.");
		obj.value = outText;
		obj.focus();
		return false;
	} 
	return true;
}

function chk_byte(in_texts, text_max)
{
	var ls_str = in_texts; 
	var li_str_len = ls_str.length; //전체길이
	//변수초기화
	var li_max = text_max; //제한할 글자수 크기
	var i = 0;
	var li_byte = 0;   //한글일경우 2, 그외글자는 1을 더함
	var li_len = 0;    // substring하기 위해 사용
	var ls_one_char = "";  //한글자씩 검사
	var ls_str2 = "";      //글자수를 초과하면 제한한 글자전까지만 보여줌.

	for(i=0; i< li_str_len; i++)
	{
		ls_one_char = ls_str.charAt(i);   //한글자 추출
		if(escape(ls_one_char).length > 4){ 
			li_byte +=2;   //한글이면 2를 더한다
		}else{
			li_byte++;     //한글아니면 1을 다한다
		}

		if(li_byte <= li_max){
			li_len = i + 1;
		}
	}
	//if(li_byte > li_max)
	if(li_byte < li_max)
	{
		//alert( li_max + "글자를 초과 입력할수 업습니다.");
		//ls_str2 = ls_str.substr(0, li_len);
		//in_texts.value = ls_str2;
		return false;
	}
	//in_texts.focus();
	return true;
}

function chk_len(val)
{
	if (val.length == 4)
	{
		$("#mb_phone3").focus();
	}
}

function chk_len2(val)
{
	if (val.length == 4)
	{
		$("#mb_phone3").blur();
	}
}

function chk_len3(val)
{
	if (val.length == 11)
	{
		$("#mb_phone").blur();
	}
}

// gnb
$(document).on("click", ".gnbBtn", function(){
	$("html").addClass("gnbOpen");
	$(".sec_top").hide();
	$(".sec_main_img").hide();
});
$(document).on("click", "#m_menu_close", function(){
	$("html").removeClass("gnbOpen");
	$(".sec_top").show();
	$(".sec_main_img").show();
});

$(document).on("click", "#m_event_show", function(){
	$("html").removeClass("gnbOpen");
	$(".sec_top").show();
});

function move_page(param)
{
	if (param == "product")
	{
		var product_area	= $(document).height() * 0.4;

		$("html").removeClass("gnbOpen");
		$(".sec_top").show();
		$( 'html, body' ).animate({ scrollTop: product_area},500);
	}
}

function mb_check()
{
	if (chk_mb_flag == 0)
	{
		$("#mb_agree").attr("src","images/checked.png");
		chk_mb_flag = 1;
	}else{
		$("#mb_agree").attr("src","images/check.png");
		chk_mb_flag = 0;
	}
}

function sns_share(media, flag)
{
	if (media == "fb")
	{

		var newWindow = window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent('http://www.belif-play.com/MOBILE/index.php'),'sharer','toolbar=0,status=0,width=600,height=325');
		$.ajax({
			type   : "POST",
			async  : false,
			url    : "../main_exec.php",
			data:{
				"exec" : "insert_share_info",
				"sns_media" : media,
				"sns_flag"		: flag
			}
		});
		//var newWindow = window.open('https://www.facebook.com/dialog/feed?app_id=1604312303162602&display=popup&caption=testurl&link=http://vacance.babience-event.com&redirect_uri=http://www.hanatour.com','sharer','toolbar=0,status=0,width=600,height=325');
	}else if (media == "tw"){
		var newWindow = window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent("빌리를 도와 빌리프 봄 친구들을 찾아주신 모든 분들에게는 즉석 당첨을 통해 빌리프 봄 3종 체험키트를 드립니다.") + '&url='+ encodeURIComponent('http://www.belif-play.com/?media=tw'),'sharer','toolbar=0,status=0,width=600,height=325');
		$.ajax({
			type   : "POST",
			async  : false,
			url    : "../main_exec.php",
			data:{
				"exec" : "insert_share_info",
				"sns_media" : media,
				"sns_flag"		: flag
			}
		});
	}else if (media == "kt"){
		// 카카오톡 링크 버튼을 생성합니다. 처음 한번만 호출하면 됩니다.
		//Kakao.Link.createTalkLinkButton({
		Kakao.Link.sendTalkLink({
		  //container: '#kakao-link-btn',
		  label: "빌리의 SOS! 빌리프 친구들을 찾으면 올 봄 촉촉 화사한 기회가 내게로",
		  image: {
			src: 'http://www.belif-play.com/MOBILE/images/belif_share2.jpg',
			width: '1200',
			height: '630'
		  },
		  webButton: {
			text: '빌리의 봄 소풍 at London',
			url: 'http://www.belif-play.com/?media=kt' // 앱 설정의 웹 플랫폼에 등록한 도메인의 URL이어야 합니다.
		  }
		});
		$.ajax({
			type   : "POST",
			async  : false,
			url    : "../main_exec.php",
			data:{
				"exec" : "insert_share_info",
				"sns_media" : media,
				"sns_flag"		: flag
			}
		});
	}else{
		Kakao.Story.share({
			url: 'http://www.belif-play.com/MOBILE/index.php?media=ks',
			text: '빌리의 SOS! 빌리프 친구들을 찾으면 올 봄 촉촉 화사한 기회가 내게로'
		});
		$.ajax({
			type   : "POST",
			async  : false,
			url    : "../main_exec.php",
			data:{
				"exec" : "insert_share_info",
				"sns_media" : media,
				"sns_flag"		: flag
			}
		});
	}
}

function use_coupon(param)
{
	if (confirm("쿠폰을 사용하시겠습니까?"))
	{
		$.ajax({
			type:"POST",
			data:{
				"exec"				: "use_coupon",
				"mb_serial"		: param
			},
			url: "../main_exec.php",
			success: function(response){
				alert("서프라이즈! 빌리프의 선물 하나 더!");
				$("#gift_coupon").hide();
				$("#hidden_coupon").show();
				/*
				if (response == "Y")
				{
					alert('쿠폰이 사용처리되었습니다. 감사합니다.');
					location.reload();
				}else{
					alert('사용자가 많아 처리가 지연되고 있습니다. 잠시후 다시 시도해 주세요.');
				}
				*/
			}
		});
	}
}

function use_coupon_hidden(param)
{
	if (confirm("쿠폰을 사용하시겠습니까?"))
	{
		$.ajax({
			type:"POST",
			data:{
				"exec"				: "use_coupon_hidden",
				"mb_serial"		: param
			},
			url: "../main_exec.php",
			success: function(response){
				if (response == "Y")
				{
					alert('쿠폰이 사용처리되었습니다. 감사합니다.');
					location.reload();
				}else{
					alert('사용자가 많아 처리가 지연되고 있습니다. 잠시후 다시 시도해 주세요.');
				}
			}
		});
	}
}
