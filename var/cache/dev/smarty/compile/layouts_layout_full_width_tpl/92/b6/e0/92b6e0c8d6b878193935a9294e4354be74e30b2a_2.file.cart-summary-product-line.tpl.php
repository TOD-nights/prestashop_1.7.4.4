<?php
/* Smarty version 3.1.33, created on 2024-07-16 06:57:19
  from 'C:\xampp\htdocs\prestashop_1.7.4.4\themes\classic\templates\checkout\_partials\cart-summary-product-line.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6695fdafa59c52_44149328',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '92b6e0c8d6b878193935a9294e4354be74e30b2a' => 
    array (
      0 => 'C:\\xampp\\htdocs\\prestashop_1.7.4.4\\themes\\classic\\templates\\checkout\\_partials\\cart-summary-product-line.tpl',
      1 => 1715092761,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6695fdafa59c52_44149328 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1591305936695fdafa542c9_36239488', 'cart_summary_product_line');
?>

<?php }
/* {block 'cart_summary_product_line'} */
class Block_1591305936695fdafa542c9_36239488 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'cart_summary_product_line' => 
  array (
    0 => 'Block_1591305936695fdafa542c9_36239488',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <div class="media-left">
    <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['url'], ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8');?>
">
      <img class="media-object" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['cover']['small']['url'], ENT_QUOTES, 'UTF-8');?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8');?>
">
    </a>
  </div>
  <div class="media-body">
    <span class="product-name"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8');?>
</span>
    <span class="product-quantity">x<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['quantity'], ENT_QUOTES, 'UTF-8');?>
</span>
    <span class="product-price float-xs-right"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['price'], ENT_QUOTES, 'UTF-8');?>
</span>
    <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayProductPriceBlock','product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>"unit_price"),$_smarty_tpl ) );?>

    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['product']->value['attributes'], 'value', false, 'attribute');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['attribute']->value => $_smarty_tpl->tpl_vars['value']->value) {
?>
        <div class="product-line-info product-line-info-secondary text-muted">
            <span class="label"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['attribute']->value, ENT_QUOTES, 'UTF-8');?>
:</span>
            <span class="value"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
</span>
        </div>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    <br/>
  </div>
<?php
}
}
/* {/block 'cart_summary_product_line'} */
}
