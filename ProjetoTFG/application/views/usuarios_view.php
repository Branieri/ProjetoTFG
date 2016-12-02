<body class="w3-light-grey">

<?php $this->load->view('commons/menulateral')?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

<script>
    function Novo_Usuario() {
        window.open('<?=base_url('form_newusuario')?>','Novo Usuário')
    }

</script>
<?php $this->load->view('commons/menupagina')?>
    <table id="lista_usuario">
        <thead>
            <tr>
                <th>Nome</th>
                <th>RA</th>
                <th>E-mail</th>
                <th>Operações</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($usuarios == FALSE): ?>
                <tr><td colspan="2">Nenhum usuário encontrado</td></tr>
            <?php else: ?>
                <?php foreach ($usuarios as $row): ?>
                    <tr>
                        <td><?=$row['Nome']?></td>
                        <td><?=$row['RA']?></td>
                        <td><?=$row['Email']?></td>
                        <td><a href="#">Editar</a><a href="#">Excluir</a></td>
                    </tr>
                <?php endforeach;?>
            <?php endif;?>
        </tbody>
    </table>
    <input type="button" onclick="Novo_Usuario()" value="Novo Usuário">



