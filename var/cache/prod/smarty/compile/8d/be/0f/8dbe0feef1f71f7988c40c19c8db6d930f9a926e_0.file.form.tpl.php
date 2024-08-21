<?php
/* Smarty version 3.1.33, created on 2024-05-10 12:03:21
  from 'C:\xampp\htdocs\prestashop_1.7.4.4\admin78257ysim\themes\default\template\controllers\attributes\helpers\form\form.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_663df0e9cc6399_66572553',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8dbe0feef1f71f7988c40c19c8db6d930f9a926e' => 
    array (
      0 => 'C:\\xampp\\htdocs\\prestashop_1.7.4.4\\admin78257ysim\\themes\\default\\template\\controllers\\attributes\\helpers\\form\\form.tpl',
      1 => 1715092757,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_663df0e9cc6399_66572553 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1962694328663df0e9c234e1_85343852', "input_row");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1029344498663df0e9c76db2_78808747', "field");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_701495612663df0e9c79d60_96305876', "script");
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "helpers/form/form.tpl");
}
/* {block "input_row"} */
class Block_1962694328663df0e9c234e1_85343852 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'input_row' => 
  array (
    0 => 'Block_1962694328663df0e9c234e1_85343852',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<?php if ($_smarty_tpl->tpl_vars['input']->value['type'] == 'color' || $_smarty_tpl->tpl_vars['input']->value['name'] == 'texture' || $_smarty_tpl->tpl_vars['input']->value['name'] == 'current_texture') {?>
		<div class="colorAttributeProperties"<?php if (!$_smarty_tpl->tpl_vars['colorAttributeProperties']->value) {?> style="display: none;"<?php }?>>
	<?php }?>
	<?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this, '{$smarty.block.parent}');
?>

	<?php if ($_smarty_tpl->tpl_vars['input']->value['type'] == 'color' || $_smarty_tpl->tpl_vars['input']->value['name'] == 'texture' || $_smarty_tpl->tpl_vars['input']->value['name'] == 'current_texture') {?>
		</div>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['input']->value['name'] == 'name') {?>
		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>"displayAttributeForm",'id_attribute'=>$_smarty_tpl->tpl_vars['form_id']->value),$_smarty_tpl ) );?>

	<?php }
}
}
/* {/block "input_row"} */
/* {block "field"} */
class Block_1029344498663df0e9c76db2_78808747 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'field' => 
  array (
    0 => 'Block_1029344498663df0e9c76db2_78808747',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<?php if ($_smarty_tpl->tpl_vars['input']->value['name'] == 'current_texture') {?>
		<div class="col-lg-9">
			<?php if (isset($_smarty_tpl->tpl_vars['imageTextureExists']->value) && $_smarty_tpl->tpl_vars['imageTextureExists']->value) {?>
				<img src="<?php echo $_smarty_tpl->tpl_vars['imageTexture']->value;?>
" alt="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Texture','d'=>'Admin.Catalog.Feature'),$_smarty_tpl ) );?>
" class="img-thumbnail" />
			<?php } else { ?>
				<p class="form-control-static"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'None','d'=>'Admin.Global'),$_smarty_tpl ) );?>
</p>
			<?php }?>
		</div>
	<?php } else { ?>
		<?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this, '{$smarty.block.parent}');
?>

	<?php }
}
}
/* {/block "field"} */
/* {block "script"} */
class Block_701495612663df0e9c79d60_96305876 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'script' => 
  array (
    0 => 'Block_701495612663df0e9c79d60_96305876',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	var attributesGroups = {<?php echo $_smarty_tpl->tpl_vars['strAttributesGroups']->value;?>
};

	var displayColorFieldsOption = function() {
		var val = $('#id_attribute_group').val();
		if (attributesGroups[val])
			$('.colorAttributeProperties').show();
		else
			$('.colorAttributeProperties').hide();
	};

	displayColorFieldsOption();

	$('#id_attribute_group').change(displayColorFieldsOption);

	var shop_associations = <?php echo $_smarty_tpl->tpl_vars['fields']->value[0]['form']['shop_associations'];?>
;
	var changeAssociationGroup = function()
	{
		var id_attribute_group = $('#id_attribute_group').val();
		$('.input_shop').each(function(k, item)
		{
			var id_shop = $(item).attr('shop_id');
			if (typeof shop_associations[id_attribute_group] != 'undefined' && $.inArray(id_shop, shop_associations[id_attribute_group]) > -1)
				$(item).attr('disabled', false);
			else
			{
				$(item).attr('disabled', true);
				$(item).attr('checked', false);
			}
		});
	};
	$('#id_attribute_group').change(changeAssociationGroup);
	changeAssociationGroup();
<?php
}
}
/* {/block "script"} */
}
