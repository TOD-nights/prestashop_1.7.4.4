<?php
/* Smarty version 3.1.33, created on 2024-05-10 12:50:34
  from 'C:\xampp\htdocs\prestashop_1.7.4.4\admin78257ysim\themes\default\template\controllers\stats\stats.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_663dfbfa2c4c61_26406463',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9f6861682bc0735a1929dfbfa6d8f92f001096c1' => 
    array (
      0 => 'C:\\xampp\\htdocs\\prestashop_1.7.4.4\\admin78257ysim\\themes\\default\\template\\controllers\\stats\\stats.tpl',
      1 => 1715092758,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_663dfbfa2c4c61_26406463 (Smarty_Internal_Template $_smarty_tpl) {
?>
		<div class="panel">
			<?php if ($_smarty_tpl->tpl_vars['module_name']->value) {?>
				<?php if ($_smarty_tpl->tpl_vars['module_instance']->value && $_smarty_tpl->tpl_vars['module_instance']->value->active) {?>
					<?php echo $_smarty_tpl->tpl_vars['hook']->value;?>

				<?php } else { ?>
					<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Module not found','d'=>'Admin.Stats.Notification'),$_smarty_tpl ) );?>

				<?php }?>
			<?php } else { ?>
				<h3 class="space"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Please select a module from the left column.','d'=>'Admin.Stats.Notification'),$_smarty_tpl ) );?>
</h3>
			<?php }?>
		</div>
	</div>
</div>
<?php }
}
