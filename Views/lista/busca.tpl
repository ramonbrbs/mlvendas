{include file="header.tpl"}

{if $errors}
<div class="alert alert-danger">
{foreach $errors as $e}

  <p>{$e}</p>

{/foreach}
</div>
{/if}
<form action="{$Controller_Lista}/busca/{$status}" method="get" >
<div class="container row">
    <input type="text" class='col-md-4 col-sm-6' name="sku" placeholder="SKU" />
    <input type="text" class=' col-md-4 col-sm-6' name="descricao" placeholder="Descrição" />
    <input type="submit" value="Buscar" class="btn" />
</div>

<script>
    
</script>
<div class='row'>
    <div class='btn btn-info' id='selecionarPag'>Selecionar Página</div>
    <div class='btn btn-info' id='selecionarTodos'>Selecionar Tas as Pag.</div>
    
    {if $status == 'closed'}
        <div class='btn btn-primary' id='recadastrar'>Recadastrar</div>
        <div class='btn btn-primary' id='excluir'>Excluir</div>
    {elseif $status == 'active'}
        <div class='btn btn-primary' id='pausar'>Pausar</div>
        <div class='btn btn-primary' id='finalizar'>Finalizar</div>
        {elseif $status == 'paused'}
        <div class='btn btn-primary' id='ativar'>Ativar</div>
        <div class='btn btn-primary' id='finalizar'>Finalizar</div>
    {/if}
    
</div>




<script>
$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
       return null;
    }
    else{
       return decodeURI(results[1]) || 0;
    }
}

$(document).ready(function() {
    var conta = $.urlParam('conta');
    var descricao = $.urlParam('descricao');
    var status = $.urlParam('status');
    var page = $.urlParam('page');
    
    $('#selecionarTodos').click(function(){
       selecionarTodos = true;
       $('input:checkbox').prop('checked', 'checked');
    });
    $('#selecionarPag').click(function(){
       $('input:checkbox').prop('checked', 'checked');

    });
    
    $("#pausar").click(function(){
        
        var qtdCheckbox = $(".checkbox:checked").size();
        if(selecionarTodos === true || qtdCheckbox > 0 ){
            if(selecionarTodos === true){
                {literal}
                var data = {selecionarTodos: true, status : status, descricao : descricao, conta : conta, page : page};
                {/literal}
                $.post('{$Controller_Lista}/PausarAjax/', data, function(){
                    
                });
            }else{
                
                var checked = [];
                $('.checkbox:checked').each(function(){ 
                    checked.push($(this).val());
                });
                {literal}var data = {checked : checked};{/literal}
                $.post('{$Controller_Lista}/PausarAjax/', data, function(){
                    
                });
            }
        }
    });
    
    $('#recadastrar').click(function(){
        var qtdCheckbox = $(".checkbox:checked").size();
        if(selecionarTodos === true || qtdCheckbox > 0 ){
            if(selecionarTodos === true){
                {literal}
                var data = {selecionarTodos: true, status : status, descricao : descricao, conta : conta, page : page};
                {/literal}
                $.post('{$Controller_Lista}/RecadastrarAjax/', data, function(){
                    
                });
            }else{
                
                var checked = [];
                $('.checkbox:checked').each(function(){ 
                    checked.push($(this).val());
                });
                {literal}var data = {checked : checked};{/literal}
                $.post('{$Controller_Lista}/RecadastrarAjax/', data, function(){
                    
                });
            }
        }
    });
});
    
</script>

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
            <td style='vertical-align:middle;'><input type="checkbox" name='selection[]' value='{$i->id}' class='form-control checkbox' style='max-height: 20px;min-width:18px'></td>
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