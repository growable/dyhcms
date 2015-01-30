$(function(){
	$(":range").rangeinput({progress: true});

	/* Slide Toogle */
	$("ul.expmenu li > div.header").click(function()
	{
		var arrow = $(this).find("span.arrow");

		if(arrow.hasClass("up"))
		{
			arrow.removeClass("up");
			arrow.addClass("down");
		}
		else if(arrow.hasClass("down"))
		{
			arrow.removeClass("down");
			arrow.addClass("up");
		}
		$(this).parent().find("ul.menu").slideToggle();
	});

	//初始化窗口高度
	var browser_height = document.documentElement.clientHeight;
	var browser_width = document.documentElement.clientWidth;
	if (browser_width > 750) {		
		var left_div = $('#expmenu-freebie').outerHeight();
		var left_height = browser_height - 50 > left_div ? browser_height - 50 : left_div;
		$('#left_wrap').css({"height":left_height});
	}

	//调整浏览器大小
	$(window).resize(function(){
		var browser_height = document.documentElement.clientHeight;
		var browser_width = document.documentElement.clientWidth;
		var left_div = $('#expmenu-freebie').outerHeight();
		var left_height = browser_width > 750 && (browser_height - 50) > left_div ? (browser_height - 50) : left_div;
		$('#left_wrap').css({"height":left_height});

		if ($('#edui1')) {
			$('#edui1').css({"width":"auto"});
			$('#edui1_iframeholder').css({"width":"auto"});
		}
	});

	//链接跳转
	$('.menu li, .http-direct span').click(function(){
		var href = $(this).attr("data-href");
		window.location.href = "http://" + window.location.host + "/dyh/" + href;
	});
});