{include file="header.tpl"}
<form action="" method="post" enctype="multipart/form-data">
<p>Arquivo:
<input type="file" name="file" />
<select name='mlaccount'>
    {foreach $accounts as $account }
  <option value="{$account@key}">{$account.nickname}</option>
    {/foreach}
</select>
<input type="submit" value="Enviar" />
</p>
</form>
{include file="footer.tpl"}