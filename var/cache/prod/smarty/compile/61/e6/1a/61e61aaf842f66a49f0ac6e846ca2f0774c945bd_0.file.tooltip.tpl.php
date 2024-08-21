<?php
/* Smarty version 3.1.33, created on 2024-05-09 13:56:22
  from 'C:\xampp\htdocs\prestashop_1.7.4.4\modules\welcome\views\templates\tooltip.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_663cb9e6b8dd37_67322058',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '61e61aaf842f66a49f0ac6e846ca2f0774c945bd' => 
    array (
      0 => 'C:\\xampp\\htdocs\\prestashop_1.7.4.4\\modules\\welcome\\views\\templates\\tooltip.tpl',
      1 => 1715092759,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_663cb9e6b8dd37_67322058 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="onboarding-tooltip">
  <div class="content"></div>
  <div class="onboarding-tooltipsteps">
    <div class="total"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Step','d'=>'Modules.Welcome.Admin'),$_smarty_tpl ) );?>
 <span class="count">1/5</span></div>
    <div class="bulls">
    </div>
  </div>
  <button class="btn btn-primary btn-xs onboarding-button-next"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Next','d'=>'Modules.Welcome.Admin'),$_smarty_tpl ) );?>
</button>
</div>
<?php }
}
