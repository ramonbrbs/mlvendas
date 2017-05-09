{include file="header.tpl"}

{if $errors}
<div class="alert alert-danger">
{foreach $errors as $e}

  <p>{$e}</p>

{/foreach}
</div>
{/if}

<form action="{$Controller_Lista}/busca" method="get" >


<div class="container">
    <div class="row">
    <div class="col-md-6">
<div class="panel panel-default ">
    <div class="panel-heading">Selecionar Conta:</div>
    <div class="panel-body">
        <select name='conta'>
                {foreach $accounts as $account }
              <option value="{$account@key}">{$account.nickname}</option>
                {/foreach}
            </select>
    </div>
    
</div>
</div>
</div>

<input class="btn btn-primary" type="submit" value="Selecionar" />
</div>


</form>
{include file="footer.tpl"}