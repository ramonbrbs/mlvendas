{include file="header.tpl"}
<div class='container'>
    <form class="form-horizontal" action='' method="POST">
   {if isset($user)}<input type='hidden' name='id' value='{$user->id}'></input>{/if}
   <fieldset>
      <div id="legend">
         <legend class="">Cadastro</legend>
      </div>
      <div class="control-group">
         <!-- Username --> <label class="control-label" for="login">Nome de Usuario</label> 
         <div class="controls">
            <input type="text" id="login" name="login" placeholder="" class="input-xlarge" {if isset($user)}value={$user->login}{/if}> 
            
         </div>
      </div>
      <div class="control-group">
         <!-- Username --> <label class="control-label" for="name">Nome</label> 
         <div class="controls">
            <input type="text" id="name" name="name" placeholder="" class="input-xlarge" {if isset($user)}value={$user->name}{/if}> 
            
         </div>
      </div>
      <div class="control-group">
         <!-- E-mail --> <label class="control-label" for="email">E-mail</label> 
         <div class="controls">
            <input type="text" id="email" name="email" placeholder="" class="input-xlarge" {if isset($user)}value={$user->email}{/if}> 
            
         </div>
      </div>
      <div class="control-group">
         <!-- Password--> <label class="control-label" for="plainPassword">Senha</label> 
         <div class="controls">
            <input type="password" id="plaiPassword" name="plainPassword" placeholder="" class="input-xlarge"> 
            
         </div>
      </div>
      
      <div class="control-group">
         <!-- Button --> 
         <div class="controls"> <button class="btn btn-success" type='submit' name='submit' value='submit'>Register</button> </div>
      </div>
   </fieldset>
</form>
</div>
{include file="footer.tpl"}