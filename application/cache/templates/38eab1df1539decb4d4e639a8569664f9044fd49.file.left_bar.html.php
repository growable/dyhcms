<?php /* Smarty version Smarty-3.1.15, created on 2015-01-29 14:14:10
         compiled from "application\views\dyh\\left_bar.html" */ ?>
<?php /*%%SmartyHeaderCode:2302954c8d1b0142736-61826866%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '38eab1df1539decb4d4e639a8569664f9044fd49' => 
    array (
      0 => 'application\\views\\dyh\\\\left_bar.html',
      1 => 1422540845,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2302954c8d1b0142736-61826866',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_54c8d1b0161220_79733928',
  'variables' => 
  array (
    'base_url' => 0,
    'spath' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54c8d1b0161220_79733928')) {function content_54c8d1b0161220_79733928($_smarty_tpl) {?>	<div class="center">
		<div class="left">
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
							<li title="发布新文章" data-href="articles/new">New Post</li>
							<li class="selected" title="所有文章" data-href="articles">All Post</li>
							<li title="分类文章" data-href="articles/category">Category Post</li>
						</ul>
					</li>
					
					<li>
						<div class="header">
							<span class="label" style="background-image: url(<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['spath']->value;?>
img/pc.png);">Category</span>
							<span class="arrow down"></span>
						</div>
						<ul class="menu" style="display:none">
							<li>New Category</li>
							<li>All Category</li>
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
		<div class="right"><?php }} ?>
