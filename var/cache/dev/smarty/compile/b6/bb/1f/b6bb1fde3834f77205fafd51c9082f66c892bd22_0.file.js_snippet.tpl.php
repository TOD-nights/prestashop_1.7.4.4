<?php
/* Smarty version 3.1.33, created on 2024-05-21 19:06:30
  from 'C:\xampp\htdocs\prestashop_1.7.4.4\modules\dhlshipping\views\templates\admin\js_snippet.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_664cd49619edb8_06659103',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b6bb1fde3834f77205fafd51c9082f66c892bd22' => 
    array (
      0 => 'C:\\xampp\\htdocs\\prestashop_1.7.4.4\\modules\\dhlshipping\\views\\templates\\admin\\js_snippet.tpl',
      1 => 1715638544,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_664cd49619edb8_06659103 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 type="text/javascript">
    document.GspedData = <?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'json_encode' ][ 0 ], array( $_smarty_tpl->tpl_vars['data']->value ));?>
;
<?php echo '</script'; ?>
><?php }
}
