{include file="header.tpl"}
<div class='container'>
    <h2>Anúncios do Arquivo {$arquivo} para a conta {$conta}</h2>
<table id='example'>
    <thead>
        <tr>
            <th>Titulo</th>
            <th>Status</th>
            <th>Link</th>
            <th>Erro</th>
        </tr>
    </thead>
    <tbody>
      {foreach $anuncios as $a }
        <tr>
          
          <td>{$a->titulo}</td>
          <td>{$a->status->name}</td>
          <td>{$a->permalink}</td>
          <td>{$a->error}</td>
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
{include file="footer.tpl"}