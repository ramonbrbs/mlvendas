{include file="header.tpl"}

{if $errors}
<div class="alert alert-danger">
{foreach $errors as $e}

  <p>$e</p>

{/foreach}
</div>
{/if}

<form action="" method="post" enctype="multipart/form-data">
<p>Arquivo:
<input type="file" name="file[]" multiple/>
<select name='mlaccount'>
    {foreach $accounts as $account }
  <option value="{$account@key}">{$account.nickname}</option>
    {/foreach}
</select>
<input type="submit" value="Enviar" />
</p>
</form>
{include file="footer.tpl"}