{include file="header.tpl"}

<div class='container'>
  <a href='{$Controller_Fila}/Ok'>
    <button type="button" class="btn btn-default btn-lg">
      <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Anunciados ({$anuncios_ok})
    </button>
  </a>
    <button type="button" class="btn btn-danger btn-lg">
      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Erros ({$anuncios_erro})
    </button>
    
    <button type="button" class="btn btn-primary btn-lg">
      <span class="glyphicon glyphicon-inbox" aria-hidden="true"></span> Pendentes ({$anuncios_pendentes})
    </button>
</div>


{include file="footer.tpl"}