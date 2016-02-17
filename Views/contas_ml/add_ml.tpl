{include file="header.tpl"}
{if isset($alerts) }
<div class='container'>
    {foreach $alerts as $alert}
    <div class="alert alert-{$alert@key}">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      {$alert}
    </div>
    {/foreach}
</div>
{/if}
<div class='row'></div>
<div class='col col-md-3 col-sm-6' style='margin-bottom: 15px;'>
<a href='{$url_meli}'><button type="button" class="btn btn-secondary btn-lg"><span class="glyphicon glyphicon-new-window" aria-hidden="true"> </span> Adicionar Conta </button> </a>
</div>

<div class='row' style=''></div>
{foreach $accounts as $account }
<div class='col col-md-3 col-sm-6'>
<div class="panel panel-primary ">
  <div class="panel-heading ">{$account->nickname}</div>
  <div class="panel-body"><h6 ><a href='{$Controller_Contas_ML}/Remove/{$account->id}/' class='text-danger'>Remover</a></h6></div>
</div>
</div>
{/foreach}
{include file="footer.tpl"}