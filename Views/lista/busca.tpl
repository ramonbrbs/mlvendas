{include file="header.tpl"}

{if $errors}
<div class="alert alert-danger">
{foreach $errors as $e}

  <p>{$e}</p>

{/foreach}
</div>
{/if}
<form action="{$Controller_Lista}/" method="get" >