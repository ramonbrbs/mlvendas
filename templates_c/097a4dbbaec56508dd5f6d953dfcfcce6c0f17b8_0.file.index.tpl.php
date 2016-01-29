<?php
/* Smarty version 3.1.29, created on 2016-01-29 02:58:25
  from "/home/ubuntu/workspace/Views/index.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_56aad551bca0d8_38880703',
  'file_dependency' => 
  array (
    '097a4dbbaec56508dd5f6d953dfcfcce6c0f17b8' => 
    array (
      0 => '/home/ubuntu/workspace/Views/index.tpl',
      1 => 1454036294,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_56aad551bca0d8_38880703 ($_smarty_tpl) {
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>



<div class="container col-md-4 col-md-offset-4 col-xs-12">

      <form class="form-signin" method='POST' action=''>
        <h2 class="form-signin-heading">LOGIN</h2>
        <label for="login" class="sr-only">Nome de Usuário</label>
        <input type="text" id="login" name='login' class="form-control" placeholder="Nome de Usuário" value='<?php echo $_smarty_tpl->tpl_vars['_post_login']->value;?>
' required autofocus>
        <label for="plainPassword" class="sr-only">Senha</label>
        <input type="password" name='plainPassword' id="plainPassword" class="form-control" placeholder="Senha" required>
        
        <button class="btn btn-lg btn-primary btn-block" type="submit" >Entrar</button>
      </form>

</div> <!-- /container -->

<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}
