<body class="w3-light-grey">

<?php $this->load->view('commons/menulateral')?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

    <?php $this->load->view('commons/menupagina')?>

    <div class="w3-container ">

        <table class="w3-table-all">
            <thead>
                <tr class="w3-light-grey">
                    <th>Título</th>
                    <th>Realizado</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($exercicios == FALSE): ?>
                    <tr><td colspan="2">Nenhum exercício cadastrado</td></tr>
                <?php else: ?>
                    <?php if (isset($exercicios)): ?>
                        <?php foreach ($exercicios as $row): ?>
                            <tr>
                                <td><?=$row['Pergunta']?></td>
                                <td><a href="<?=base_url("realizaexercicio_aluno")."/".$row['idExercicio']?>"><i class="w3-xlarge fa fa-pencil"></i>
                            </tr>
                        <?php endforeach;?>
                    <?php endif; ?>
                <?php endif;?>
            </tbody>
        </table>
    </div>