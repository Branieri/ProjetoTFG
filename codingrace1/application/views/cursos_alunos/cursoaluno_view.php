<body class="w3-light-grey">

<?php $this->load->view('commons/menulateral')?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

    <?php $this->load->view('commons/menupagina')?>

    <div class="w3-container">
        <table class="w3-table-all">
            <h2 class="w3-left">Tópicos</h2>
            <thead>
            <tr class="w3-light-grey">
                <th>Nome</th>
                <th>Exercícios</th>
                <th>Concluído</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($topicos == FALSE): ?>
                <tr><td colspan="2">Nenhum tópico cadastrado</td></tr>
            <?php else: ?>
                <?php foreach ($topicos as $row): ?>
                    <tr>
                        <td><?=$row['Nome']?></td>
                        <td><a href="<?=base_url('realizartopico_aluno')."/".$row['idTopico']?>" style="text-decoration: none"><i class="w3-xlarge fa fa-pencil">&nbsp;</i></a></td>
                        <td></td>
                    </tr>
                <?php endforeach;?>
            <?php endif;?>
            </tbody>
        </table>
