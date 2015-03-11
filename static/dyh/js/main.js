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
	if (browser_width > 973) {		
		var left_div = $('#expmenu-freebie').outerHeight();
		var cate_div = $('#category_wrap').outerHeight();
		var left_height = browser_height - 50 > left_div ? browser_height - 50 : left_div;
		var cate_height = browser_width > 973 && (browser_height - 50) > cate_div ? (browser_height - 90) : cate_div;
		$('#left_wrap').css({"height":left_height});
		$('#category_wrap').css({"height":cate_height});
	}

	//调整浏览器大小
	$(window).resize(function(){
		var browser_height = document.documentElement.clientHeight;
		var browser_width = document.documentElement.clientWidth;
		var left_div = $('#expmenu-freebie').outerHeight();

		$('#category_wrap').css({"height":''});//初始化为自动高度
		var cate_div = $('#category_wrap').outerHeight();
		var left_height = browser_width > 973 && (browser_height - 50) > left_div ? (browser_height - 50) : left_div;
		var cate_height = browser_width > 973 && (browser_height - 50) > cate_div ? (browser_height - 90) : cate_div;
		$('#left_wrap').css({"height":left_height});
		$('#category_wrap').css({"height":cate_height});

		if ($('#edui1')) {
			$('#edui1').css({"width":"auto"});
			$('#edui1_iframeholder').css({"width":"auto"});
		}
	});

	//链接跳转
	$('.menu li, .http-direct span').click(function(){
		var href = $(this).attr("data-href");
		if (href.length > 0) {
			window.location.href = "http://" + window.location.host + "/" + href;
		}
	});

	var url = 'http://' + window.location.host + '/';

	//添加文章标签
	$('#add_tag').keyup(function(event){
		var e = event || window.event || arguments.callee.caller.arguments[0];
		var key_val = e.keyCode;
		if (key_val == 13) { //Enter键
			var tag_val = $('#add_tag').val();
			var aid = $('#article_id').val();
			if (! isNaN(aid) && tag_val.length > 0) {
				$.Tag.AddTag(tag_val, aid, url);
			}
		}
	});

	//删除文章标签
	$('.tag-label').on('click', function(){
		var tid = $(this).attr("data-tid");
		if (! isNaN(tid)) {
			$.Tag.DeleteTag(tid, url, $(this));
		}
	});
	
	$('#posttitle').blur(function(){
		var title = $(this).val();
		if (title.length == 0) {
			$(this).parent().parent().attr({"class":"form-group has-error"});
		} else {
			$(this).parent().parent().attr({"class":"form-group"});
		}
	});

	$('#posturl').blur(function(){
		var aurl = $(this).val();
		var aid = $('#article_id').val();
		if (aid == 0 && aurl.length > 0) {
			$.post(
				url + '/index.php/dyh/articles/checkUrlExist',
				{"url":aurl},
				function(data){
					if (data.errorcode == 1 || data.status == 1) {
						$('#posturl').parent().parent().attr({"class":"form-group has-error has-feedback"});
					} else {
						$('#posturl').parent().parent().attr({"class":"form-group has-success has-feedback"});
					}
				},
				"JSON"
			);
		} else if (aurl.length == 0) {
			$('#posturl').parent().parent().attr({"class":"form-group has-error has-feedback"});
		} else if (aurl.length > 0) {
			$('#posturl').parent().parent().attr({"class":"form-group has-success has-feedback"});
		}
	});

	$('#postdesc').blur(function(){
		var desc = $(this).val();
		if (desc.length == 0) {
			$(this).parent().parent().attr({"class":"form-group has-error"});
		} else {
			$(this).parent().parent().attr({"class":"form-group"});
		}
	});

	//更新文章, 发布文章
	$('#article_save, #article_post').click(function(){
		var c_type = 1;
		c_type = $(this).attr('id') == 'article_save' ? 0 : 1; //操作类型

		if ($.Article.CheckForm() === 1) {
			$.Article.PostArticle(url,c_type);
		}
	});

	//需要修改的分类
	$('.category-li').on('click', function(){		
		$.Category.GetCategoryDetail($(this), url);		
	});

	//确认修改
	$('#alter_category').click(function(){
		$.Category.AlterCategory(url);	
	});
});

jQuery.Category = {
	GetCategoryDetail:function(this_category, url) {
		var cid = this_category.attr('data-id');
		//获取该分类的详细信息
		$.post(
			url + 'index.php/dyh/category/getOne',
			{"cid":cid},
			function(data){
				if (data.errorcode == 0) {
					$('#category_id_alt').val(data.detail.ID);
					$('#category_name_alt').val(data.detail.Name);
					$('#category_url_alt').val(data.detail.URL);
					$('#category_parent_alt').val(data.detail.PID);
					$('#category_parent_alt').attr("data-org",data.detail.PID);//设置原分类父ID
					$('#category_name_alt').focus();
				}
			},
			"JSON"
		);
	},
	AlterCategory:function(url) {
		var cid = $('#category_id_alt').val();
		if (cid > 0) {
			var cname = $('#category_name_alt').val();
			var curl  = $('#category_url_alt').val();
			var cpid  = $('#category_parent_alt').val();
			var copid = $('#category_parent_alt').attr("data-org"); //原分类父ID

			if (cname.length > 0) {
				$.post(
					url + 'index.php/dyh/category/alterCategory',
					{"cid":cid, 'cname':cname, 'curl':curl, 'cpid':cpid},
					function(data){
						if (data.errorcode == 0) {
							//判断修改前后是否是同一个分类
							$("a[data-id='"+data.detail.ID+"']").text(data.detail.Name); //替换
						}
					},
					"JSON"
				);
			}
		}
	},
	AddCategory:function() {

	},
	DeleteCategory:function(){

	}
};

jQuery.Tag = {
	AddTag:function(tag_val, aid, url) {
		$.post(
			url + '/index.php/dyh/tags/add',
			{"val":tag_val,"aid":aid},
			function(data){
				if (data.errorcode == 0) {
					$('.tag-wrap').append(data.data);
				}
			},
			'JSON'
		);
	},
	DeleteTag:function(tid, url, stag){
		$.post(
			url + '/index.php/dyh/tags/delete',
			{"tid":tid},
			function(data){
				if (data.errorcode == 0) {
					stag.fadeOut('normal');
				}
			},
			'JSON'
		);
	}	
};

jQuery.Article = {
	CheckForm:function() {
		var status = 1;
		//文章标题
		var atitle = $('#posttitle').val();
		if (atitle.length == 0) {
			status = 0;
			$('#posttitle').focus();
		}

		//url
		var aurl = $('#posturl').val();
		var aid  = $('#article_id').val();
		if (aurl.length == 0) {
			status = 0;
			$('#posturl').focus();
		} else if (aid == 0) {
			//检查url是否已经存在
			var url = 'http://' + window.location.host;
			$.post(
				url + '/index.php/dyh/articles/checkUrlExist',
				{"url":aurl},
				function(data){
					if (data.errorcode == 1 || data.status == 1) {
						status = 0;
						$('#posturl').focus();
					}
				},
				"JSON"
			);
		}

		//描述
		var adesc = $('#postdesc').text();
		if (adesc.length == 0) {
			status = 0;
			$('#postdesc').focus();
		}

		//分类
		var acate = $('#postcate').val();
		if (isNaN(acate)) {
			status = 0;
			$('#postcate').focus();
		}

		//内容
		ue.ready(function() {
		    var acontent = ue.getContent();
		});
		return status;
	},
	PostArticle:function(url,c_type){
		var atitle = $('#posttitle').val();
		var aurl   = $('#posturl').val();
		var aid    = $('#article_id').val();
		var adesc  = $('#postdesc').text();
		var acate  = $('#postcate').val();
		var atag   = $('#add_tag').val();
		var acontent = '';
		ue.ready(function() {
		    acontent = ue.getContent();
		});

		//设置load层
		

		$.post(
			url + 'index.php/dyh/articles/saveArticle',
			{'aid':aid,'title':atitle,'url':aurl,'desc':adesc,'cate':acate,'tag':atag,'content':acontent,'type':c_type},
			function(data){
				if (data.errorcode == 0) {
					window.location.href = url + data.data;
				}
			},
			'JSON'
		);
	}
};
