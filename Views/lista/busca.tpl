{include file="header.tpl"}

{if $errors}
<div class="alert alert-danger">
{foreach $errors as $e}

  <p>{$e}</p>

{/foreach}
</div>
{/if}
<form action="{$Controller_Lista}/busca/{$status}" method="get" >
    
<div class='btn btn-info'>Selecionar Página</div>
<div class='btn btn-info'>Selecionar Tas as Pag.</div>
<table class='table table-hover'>
    <thead>
        
    <tr>
        <th></th>
        <th>Foto</th>
        <th>Título</th>
        <th>SKU</th>
        <th>Preço</th>
        <th>Em Estoque</th>
        <th>ID</th>
        <th>Envio</th>
    </tr>
    </thead>
    {foreach $itens as $i}
        <tr >
            <td style='vertical-align:middle;'><input type="checkbox" name='selection[]' value='{$i->id}' class='form-control' style='max-height: 20px;min-width:18px'></td>
            <td><img src="{$i->thumbnail}"/></td>
            <td style='vertical-align:middle;'><a target="_blank" href='{$i->permalink}'>{$i->title}</a></td>
            <td style='vertical-align:middle;'>{$i->seller_custom_field}</td>
            <td style='vertical-align:middle;'>R${$i->price|replace:".":","}</td>
            <td style='vertical-align:middle;'>{$i->available_quantity}</td>
            <td style='vertical-align:middle;'>{$i->id}</td>
            <td style='vertical-align:middle;'>{$i->shipping->mode}</td>
        </tr>
    {/foreach}
    
</table>

<input type='hidden' name='conta' value='{$conta}'/>
<ul class="pagination">
    {for $i = 1 to $qtd_pags}
        <li><button name='page' value='{$i}'>{$i}</button></li>
    {/for}
</ul>

</form>

<script>
    
</script>