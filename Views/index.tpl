{include file="header.tpl"}

<div>
  {foreach $errors as $e }
  <p>$e</p>
  {/foreach}
</div>
<div class="container col-md-4 col-md-offset-4 col-xs-12">

      <form class="form-signin" method='POST' action=''>
        <h2 class="form-signin-heading">LOGIN</h2>
        {if isset($auth_failed)}
        <div class="alert alert-danger">
          Senha ou usuário incorreto(s).
        </div>
        {/if}
        <label for="login" class="sr-only">Nome de Usuário</label>
        <input type="text" id="login" name='login' class="form-control" placeholder="Nome de Usuário" value='{(isset($_post_login))?$_post_login:''}' required autofocus>
        <label for="plainPassword" class="sr-only">Senha</label>
        <input type="password" name='plainPassword' id="plainPassword" class="form-control" placeholder="Senha" required>
        
        <button class="btn btn-lg btn-primary btn-block" type="submit" >Entrar</button>
      </form>

</div> <!-- /container -->

{include file="footer.tpl"}
