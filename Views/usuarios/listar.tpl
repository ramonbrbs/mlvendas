{include file="header.tpl"}
<div class='container'>
    <h2>Gestão de Usuários</h2>
<table>
    <thead>
        <tr>
            <th>Nome</th>
            <th>Login</th>
        </tr>
    </thead>
    <tbody>
        {foreach $users as $u }
            <tr>
                <td>{$u->name}</td>
                <td>{$u->login}</td>
                
            </tr>
        {/foreach}
    </tbody>
</table>
</div>

<script>
    
$(document).ready(function(){
    $('table').DataTable();
});
</script>
{include file="footer.tpl"}