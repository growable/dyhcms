<?php /* Smarty version Smarty-3.1.15, created on 2015-01-30 18:28:19
         compiled from "application\views\dyh\new_articles.html" */ ?>
<?php /*%%SmartyHeaderCode:2709354cb34e5106840-54593575%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9900e8fcefb01a6e83f9d13c476eeb9a4eb9bc7f' => 
    array (
      0 => 'application\\views\\dyh\\new_articles.html',
      1 => 1422613698,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2709354cb34e5106840-54593575',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_54cb34e51437b7_81528824',
  'variables' => 
  array (
    'vpath' => 0,
    'base_url' => 0,
    'spath' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54cb34e51437b7_81528824')) {function content_54cb34e51437b7_81528824($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['vpath']->value)."/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['vpath']->value)."/left_bar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	<header id="article_header" class="col-xs-12 breadcrumb http-direct">
		<span data-href="/">Home</span> &rsaquo; 
		<span data-href="articles/post">Post</span> &raquo;
		<span>New Article</span>
	</header>
	<section class="col-xs-12 post-wrap pd0">
		<form class="form-horizontal post-wrap-base" role="form">
			<div class="form-group">
			    <label for="posttitle" class="col-sm-2 control-label">Title</label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="posttitle" placeholder="Title">
			    </div>
			</div>
			<div class="form-group has-success has-feedback">
			    <label for="posturl" class="col-sm-2 control-label">URL</label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="posturl" aria-describedby="inputSuccess2Status" placeholder="URL">
					<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
					<span id="inputSuccess2Status" class="sr-only">(success)</span>
			    </div>
			</div>
			<div class="form-group">
			    <label for="postcontent" class="col-sm-2 control-label">Description</label>
			    <div class="col-sm-10">
			    	<textarea class="form-control" rows="2" id="postcontent" placeholder="Description"></textarea>
			    </div>
			</div>
			<div class="form-group">
			    <label for="postcontent" class="col-sm-2 control-label">Category & Tags</label>
			    <div class="col-sm-10">
			    	<div class="col-xs-4 pd0">
			    		<select class="form-control">
							<option>Category</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
						</select>
			    	</div>
			    	<div class="col-xs-8 pdr0">
			    		<input type="text" class="form-control" placeholder="Input Tags">
			    	</div>
			    </div>
			</div>
		</form>
		<div class="col-xs-12 pd0 post-wrap-content">
			<script id="container" name="content" type="text/plain">这里写你的初始化内容</script>
			<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['spath']->value;?>
ueditor/ueditor.config.js"></script>
		    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['spath']->value;?>
ueditor/ueditor.all.js"></script>
		    <script type="text/javascript">
		        var ue = UE.getEditor('container');
		    </script>
		</div>
		<div class="col-xs-12 post-button">
			<span class="col-xs-5">&nbsp;</span>
			<button type="button" class="btn btn-primary col-md-1" title="保存为草稿">Save</button>
			<button type="button" class="btn btn-primary col-md-1" title="发布">Post</button>
		</div>
	</section>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['vpath']->value)."/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
