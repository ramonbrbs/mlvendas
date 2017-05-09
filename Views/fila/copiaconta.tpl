{include file="header.tpl"}

{if $errors}
<div class="alert alert-danger">
{foreach $errors as $e}

  <p>{$e}</p>

{/foreach}
</div>
{/if}

<form action="" method="post" enctype="multipart/form-data">

<div class="container">
    <div class="col-md-6">
<div class="panel panel-default ">
    <div class="panel-heading">Copia de:</div>
    <div class="panel-body">
        <select name='mlaccountDe'>
                {foreach $accounts as $account }
              <option value="{$account@key}">{$account.nickname}</option>
                {/foreach}
            </select>
    </div>
    
</div>
</div>

<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading">Copia Para:</div>
<div class="panel-body">
    <select name='mlaccountPara'>
            {foreach $accounts as $account }
          <option value="{$account@key}">{$account.nickname}</option>
            {/foreach}
        </select>
</div>
    
</div>
</div>
<input class="btn btn-primary" type="submit" value="Copiar" />
</div>


</form>
{include file="footer.tpl"}