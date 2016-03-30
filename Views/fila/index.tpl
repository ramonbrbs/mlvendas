{include file="header.tpl"}

<script>
  $(document).ready(function() {
    $('#example').DataTable( {
        "serverSide": true,
        ajax: {
            url: '{$Controller_Fila}/PendentesAjax'
            //dataFilter: function(data){
                //console.log(data);
            //}
        }
        
    } );
} );
</script>


<table id="example">
    <thead>
        <tr>
            <th>Título</th>
            <th>SKU</th>
            <th>Conta ML</th>
        </tr>
    </thead>
    
</table>


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
  
    <button type="button" class="btn btn-primary btn-lg">
      <span class="glyphicon glyphicon-inbox" aria-hidden="true"></span> Pendentes ({$anuncios_pendentes})
    </button>
</div>


{include file="footer.tpl"}