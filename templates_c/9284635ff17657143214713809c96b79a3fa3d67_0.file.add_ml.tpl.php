<?php
/* Smarty version 3.1.29, created on 2016-02-07 03:34:24
  from "/home/ubuntu/workspace/Views/contas_ml/add_ml.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_56b6bb40e6ce73_02435839',
  'file_dependency' => 
  array (
    '9284635ff17657143214713809c96b79a3fa3d67' => 
    array (
      0 => '/home/ubuntu/workspace/Views/contas_ml/add_ml.tpl',
      1 => 1454816060,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_56b6bb40e6ce73_02435839 ($_smarty_tpl) {
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php if (isset($_smarty_tpl->tpl_vars['alerts']->value)) {?>
<div class='container'>
    <?php
$_from = $_smarty_tpl->tpl_vars['alerts']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_alert_0_saved_item = isset($_smarty_tpl->tpl_vars['alert']) ? $_smarty_tpl->tpl_vars['alert'] : false;
$_smarty_tpl->tpl_vars['alert'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['alert']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['alert']->key => $_smarty_tpl->tpl_vars['alert']->value) {
$_smarty_tpl->tpl_vars['alert']->_loop = true;
$__foreach_alert_0_saved_local_item = $_smarty_tpl->tpl_vars['alert'];
?>
    <div class="alert alert-<?php echo $_smarty_tpl->tpl_vars['alert']->key;?>
">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <?php echo $_smarty_tpl->tpl_vars['alert']->value;?>

    </div>
    <?php
$_smarty_tpl->tpl_vars['alert'] = $__foreach_alert_0_saved_local_item;
}
if ($__foreach_alert_0_saved_item) {
$_smarty_tpl->tpl_vars['alert'] = $__foreach_alert_0_saved_item;
}
?>
</div>
<?php }?>
<div class='row'></div>
<div class='col col-md-3 col-sm-6' style='margin-bottom: 15px;'>
<a href='<?php echo $_smarty_tpl->tpl_vars['url_meli']->value;?>
'><button type="button" class="btn btn-secondary btn-lg"><span class="glyphicon glyphicon-new-window" aria-hidden="true"> </span> Adicionar Conta </button> </a>
</div>

<div class='row' style=''></div>
<?php
$_from = $_smarty_tpl->tpl_vars['accounts']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_account_1_saved_item = isset($_smarty_tpl->tpl_vars['account']) ? $_smarty_tpl->tpl_vars['account'] : false;
$_smarty_tpl->tpl_vars['account'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['account']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['account']->value) {
$_smarty_tpl->tpl_vars['account']->_loop = true;
$__foreach_account_1_saved_local_item = $_smarty_tpl->tpl_vars['account'];
?>
<div class='col col-md-3 col-sm-6'>
<div class="panel panel-primary ">
  <div class="panel-heading "><?php echo $_smarty_tpl->tpl_vars['account']->value->nickname;?>
</div>
  <div class="panel-body"><h6 ><a href='<?php echo $_smarty_tpl->tpl_vars['Controller_Contas_ML']->value;?>
/Remove/<?php echo $_smarty_tpl->tpl_vars['account']->value->id;?>
/' class='text-danger'>Remover</a></h6></div>
</div>
</div>
<?php
$_smarty_tpl->tpl_vars['account'] = $__foreach_account_1_saved_local_item;
}
if ($__foreach_account_1_saved_item) {
$_smarty_tpl->tpl_vars['account'] = $__foreach_account_1_saved_item;
}
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
