{include file="header.tpl"}
<div class='container'>
    <h2>Anúncios Pendentes na Fila</h2>
<table id="example">
    <thead>
        <tr>
            <th>Título</th>
            <th>SKU</th>
            <th>Conta ML</th>
        </tr>
    </thead>
    
</table>
</div>

<script>



  $(document).ready(function() {
      

    $('#example').DataTable( {
        "serverSide": true,
        "processing": true,
        ajax: {
            url: '{$Controller_Lista}/BuscaAjax/' 
            //dataFilter: function(data){
                //console.log(data);
            //}
        }
        
    } );
} );
</script>
{include file="footer.tpl"}