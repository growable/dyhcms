$(function(){
	var body = $(document.body);;
	var bottomTools = $('#to_top');
	var isloading = 0;

	$(window).scroll(function () {
		var scrollHeight = $(document).height();
		var scrollTop = $(window).scrollTop();
		var footerHeight = $('.page-footer').outerHeight(true);
		var windowHeight = $(window).innerHeight();
		scrollTop > 50 ? $("#to_top").fadeIn(200).css("display","block") : $("#to_top").fadeOut(200);			
		bottomTools.css("bottom", scrollHeight - scrollTop - footerHeight > windowHeight ? 100 : windowHeight + scrollTop + footerHeight + 100 - scrollHeight);

		if ((scrollHeight - windowHeight - scrollTop < 50) && isloading == 0) {
			isloading = 1; //设置加载状态
			$.Load.Article();
			isloading = 0;
		}
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

	//加载上一页，下一页
	if ($('#right').attr("data-article").length > 0) {
		var aid = $('#right').attr("data-article");
		$.Load.PreNext(aid);
	}
});

jQuery.Load = {
	Article:function(){
		var page     = $('#right').attr("data-page");
		var category = $('#right').attr("data-category");

		if (page > 0) {
			$.post(
				'http://' + window.location.host + "/index.php/load_article_list",
				{"page":++page, "category":category},
				function(data) {
					if (data.errorcode == 0) {
						$('#right').append(data.data);
						$('#right').attr({"data-page":page});
					} else if (data.errorcode == 2) {
						$('#right').attr({"data-page":0}); //设置没有数据
					}
				},
				"JSON"
			);
		}

	},
	PreNext:function(aid) {
		if (! isNaN(aid)) {
			$.post(
				'http://' + window.location.host + "/index.php/load_article_prenext",
				{"aid":aid},
				function(data) {
					if (data.errorcode == 0) {
						if (data.data.pre.length > 0) {
							$('.pre-next').children('.text-left').html(data.data.pre);
						} else {
							$('.pre-next').children('.text-left').text("");
						}

						if (data.data.next.length > 0) {
							$('.pre-next').children('.text-right').html(data.data.next);
						} else {
							$('.pre-next').children('.text-right').text("");
						}
					} 
				},
				"JSON"
			);
		}
	}
}