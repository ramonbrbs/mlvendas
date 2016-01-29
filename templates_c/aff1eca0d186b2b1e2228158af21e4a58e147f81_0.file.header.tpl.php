<?php
/* Smarty version 3.1.29, created on 2016-01-29 01:58:48
  from "/home/ubuntu/workspace/Views/header.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_56aac75805cf30_44823120',
  'file_dependency' => 
  array (
    'aff1eca0d186b2b1e2228158af21e4a58e147f81' => 
    array (
      0 => '/home/ubuntu/workspace/Views/header.tpl',
      1 => 1454032726,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_56aac75805cf30_44823120 ($_smarty_tpl) {
?>
<html>
<head>
  <meta charset="UTF-8">
</head>
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['static']->value;?>
/css/bootstrap.css" media="screen">
    <?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-1.10.2.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['static']->value;?>
/js/bootstrap.min.js"><?php echo '</script'; ?>
>


<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Envios ML</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Fila de Envios <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Contas ML</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Envios <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Fila de Envios</a></li>
            <li><a href="#">Histórico</a></li>
            <li><a href="#">Erros</a></li>
            <li class="divider"></li>
            <li><a href="#">Adicionar Arquivo na Fila</a></li>
            <!--<li class="divider"></li>
            <li><a href="#">One more separated link</a></li>-->
          </ul>
        </li>
      </ul>
      
      
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Sair</a></li>
      </ul>
    </div>
  </div>
</nav>

<body><?php }
}
