<?php
/* Smarty version 3.1.29, created on 2016-02-02 12:11:19
  from "/home/ubuntu/workspace/Views/contas_ml/add_ml.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_56b09ce70ba852_54094409',
  'file_dependency' => 
  array (
    '9284635ff17657143214713809c96b79a3fa3d67' => 
    array (
      0 => '/home/ubuntu/workspace/Views/contas_ml/add_ml.tpl',
      1 => 1454415071,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_56b09ce70ba852_54094409 ($_smarty_tpl) {
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div class='container'>
<a href='<?php echo $_smarty_tpl->tpl_vars['url_meli']->value;?>
'><button type="button" class="btn btn-secondary btn-lg"><span class="glyphicon glyphicon-new-window" aria-hidden="true"> </span> Efetuar login no Mercado Livre </button> </a>
</div>

<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
