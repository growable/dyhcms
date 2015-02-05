$(function(){
	var $body = $(document.body);;
	var $bottomTools = $('#to_top');

	$(window).scroll(function () {
		var scrollHeight = $(document).height();
		var scrollTop = $(window).scrollTop();
		var $footerHeight = $('.page-footer').outerHeight(true);
		var $windowHeight = $(window).innerHeight();
		scrollTop > 50 ? $("#to_top").fadeIn(200).css("display","block") : $("#to_top").fadeOut(200);			
		$bottomTools.css("bottom", scrollHeight - scrollTop - $footerHeight > $windowHeight ? 100 : $windowHeight + scrollTop + $footerHeight + 100 - scrollHeight);
	});

	$('#to_top').bind({
		mouseover:function(){
			$(this).children('.arrow').css("border-color","transparent transparent #5faedb");
		},
		mouseout:function(){
			$(this).children('.arrow').css("border-color","transparent transparent #cbcfd7");
		},
		click:function(e){
			e.preventDefault();
			$('html,body').animate({ scrollTop:0});
		}
	});
});