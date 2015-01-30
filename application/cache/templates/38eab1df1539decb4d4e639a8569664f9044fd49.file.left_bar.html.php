<?php /* Smarty version Smarty-3.1.15, created on 2015-01-30 18:05:28
         compiled from "application\views\dyh\\left_bar.html" */ ?>
<?php /*%%SmartyHeaderCode:2657254cb3479a56556-55042401%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '38eab1df1539decb4d4e639a8569664f9044fd49' => 
    array (
      0 => 'application\\views\\dyh\\\\left_bar.html',
      1 => 1422612324,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2657254cb3479a56556-55042401',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_54cb3479a77bb7_48073899',
  'variables' => 
  array (
    'base_url' => 0,
    'spath' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54cb3479a77bb7_48073899')) {function content_54cb3479a77bb7_48073899($_smarty_tpl) {?>	<div id="center" class="col-xs-12">
		<div id="left" class="col-xs-12 col-sm-3 col-lg-2">
			<div id="left_wrap" class="col-xs-12 pd0">
			<ul id="expmenu-freebie">
				<li>
					<!-- Start Freebie -->
					<ul class="expmenu">
						<li>
							<div class="header">
								<span class="label" style="background-image: url(<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['spath']->value;?>
img/user.png);">Account</span>
								<span class="arrow up"></span>
							</div>
							<ul class="menu">
								<li><input type="range" name="range" min="0" max="100" value="35" style="width: 100%;" /></li>
							</ul>
						</li>
						<li>
							<div class="header">
								<span class="label" style="background-image: url(<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['spath']->value;?>
img/messages.png);">Post</span>
								<span class="arrow up"></span>
							</div>
							<ul class="menu">
								<li title="发布新文章" data-href="articles/post">New Post</li>
								<li class="selected" title="所有文章" data-href="articles">All Post</li>
								<li title="分类文章" data-href="articles/category">Category Post</li>
							</ul>
						</li>
						
						<li>
							<div class="header">
								<span class="label" style="background-image: url(<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['spath']->value;?>
img/pc.png);">Category</span>
								<span class="arrow up"></span>
							</div>
							<ul class="menu">
								<li title="新增分类">New Category</li>
								<li title="所有分类">All Category</li>
							</ul>
						</li>
						<li>
							<div class="header">
								<span class="label" style="background-image: url(<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['spath']->value;?>
img/search.png);">Search</span>
							</div>
						</li>
					</ul>
					<!-- End Freebie -->
				</li>
			</ul>
			</div>
		</div>
		<div id="right" class="col-xs-12 col-sm-9 col-lg-10"><?php }} ?>
