{include file="header.tpl"}


<div class='container'>
    <h2>Anúncios Realizados</h2>
<table id='example'>
    <thead>
        <tr>
            <th>Arquivo</th>
            <th>Conta ML</th>
            <th>Anunciados</th>
            <th>Com erro</th>
            <th>Pendentes</th>
            
        </tr>
    </thead>
    <tbody>
      {foreach $arquivosConta as $a }
        <tr id="{$a.mlaccount_id}">
          <td><a href="{$Controller_Fila}/Arquivo/{$a.file|escape:'url'}/{$a.mlaccount_id}"> {$a.file} </a></td>
          <td>{$a.nickname}</td>
          <td>{$a.anunciado}</td>
          <td>{$a.erro}</td>
          <td>{$a.pendente}</td>
        </tr>
      {/foreach}
    </tbody>
</table>
</div>

<script>
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>

<div class='container'>
  <a href='{$Controller_Fila}/Ok'>
    <button type="button" class="btn btn-default btn-lg">
      <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Anunciados ({$anuncios_ok})
    </button>
  </a>
  
  <a href='{$Controller_Fila}/Erro'>
    <button type="button" class="btn btn-danger btn-lg">
      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Erros ({$anuncios_erro})
    </button>
  </a>
  <a href='{$Controller_Fila}/Pendentes'>
    <button type="button" class="btn btn-primary btn-lg">
      <span class="glyphicon glyphicon-inbox" aria-hidden="true"></span> Pendentes ({$anuncios_pendentes})
    </button>
  </a>
</div>


{include file="footer.tpl"}