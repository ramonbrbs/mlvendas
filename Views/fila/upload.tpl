{include file="header.tpl"}

<div class='container'>
    {foreach $alerts as $alert}
    <div class="alert alert-{$alert@key}">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      {$alert}
    </div>
    {/foreach}
</div>

{if $errors}
<div class="alert alert-danger">
{foreach $errors as $e}

  <p>{$e}</p>

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