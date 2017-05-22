<html>
<head>
  <meta charset="UTF-8">
</head>
    <link rel="stylesheet" href="{$static}/css/bootstrap.css" media="screen">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="{$static}/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" media="screen">
    <script src='https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js'></script>


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

    {if isset($SESSION_USER)}
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li ><a href="{$Controller_Fila}">Fila de Envios {if isset($anuncios_pendentes_count)}({$anuncios_pendentes_count}){/if} <span class="sr-only">(current)</span></a></li>
        <li {if (isset($curr_page) && $curr_page=='contas_ml')}class="active"{/if}><a href="{$Controller_Contas_ML}/add">Contas ML</a></li>
        <li {if (isset($curr_page) && $curr_page=='usuarios')}class="active"{/if}><a href="{$Controller_Usuarios}/listar">Usuarios</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Envios <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Fila de Envios</a></li>
            <li><a href="#">Histórico</a></li>
            <li><a href="#">Erros</a></li>
            <li><a href="{$Controller_Fila}/Copia">Copiar Anuncios de Conta</a></li>
            <li class="divider"></li>
            <li><a href="{$Controller_Fila}/upload">Adicionar Arquivo na Fila</a></li>
            <!--<li class="divider"></li>
            <li><a href="#">One more separated link</a></li>-->
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Listagem <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="{$Controller_Lista}/SelecionarConta?status=pending">Pendentes</a></li>
            <li><a href="{$Controller_Lista}/SelecionarConta?status=active">Ativos</a></li>
            <li><a href="{$Controller_Lista}/SelecionarConta?status=closed">Cancelados</a></li>
            <li><a href="{$Controller_Lista}/SelecionarConta?status=paused">Pausados</a></li>
          </ul>
        </li>
      </ul>
      
      
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Sair</a></li>
      </ul>
    </div>
    {/if}
    
  </div>
</nav>

<body>