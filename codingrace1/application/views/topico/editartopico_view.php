<body class="w3-light-grey">

<?php $this->load->view('commons/menulateral')?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

    <?php $this->load->view('commons/menupagina')?>

    <div class="w3-container w3-center">
        <div class="w3-container w3-left">
            <?php if ($this->session->flashdata('error') == TRUE): ?>
                <p><?php echo $this->session->flashdata('error'); ?></p>
            <?php endif; ?>
        </div>
        <?php echo validation_errors();?>
        <form class="w3-container w3-card-4 w3-light-grey w3-text-black w3-margin" method="post" enctype="multipart/form-data" action="<?=($this->router->fetch_class() == 'Admin') ? base_url('atualizartopico_admin') : base_url('atualizartopico_professor');?>">
            <h2 class="w3-center">Editar Tópico</h2>

            <div class="w3-row w3-section">
                <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-code"></i></div>
                <div class="w3-rest">
                    <input readonly class="w3-input w3-border" name="id" id="id" type="text" placeholder="idTopico" value="<?php echo $topico['idTopico']?>">
                </div>
            </div>

            <div class="w3-row w3-section">
                <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-book"></i></div>
                <div class="w3-rest">
                    <input class="w3-input w3-border" name="nome" id="nome" type="text" placeholder="Nome" value="<?php echo $topico['Nome']?>">
                </div>
            </div>

            <p class="w3-center">
                <button class="w3-btn w3-section w3-black w3-ripple" type="submit" value="salvar"> Salvar </button>
                <?php if ($this->router->fetch_class() == 'Admin'): ?>
                    <button onclick="location.href='<?php echo base_url('topicos_admin');?>'" type="button" class="w3-btn w3-section w3-black w3-ripple"> Cancelar </button>
                <?php elseif ($this->router->fetch_class() == 'Professor'): ?>
                    <button onclick="location.href='<?php echo base_url('topicos_professor');?>'" type="button" class="w3-btn w3-section w3-black w3-ripple"> Cancelar </button>
                <?php endif; ?>
            </p>
        </form>
    </div>

        <div class="w3-container">
            <table class="w3-table-all">
                <h2 class="w3-left">Exercícios</h2>
                <thead>
                    <tr class="w3-light-grey">
                        <th>Pergunta</th>
                        <th>Categoria de Bloom</th>
                        <th>Tipo de Exercício</th>
                        <th>Operações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($exercicios == FALSE): ?>
                        <tr><td colspan="2">Nenhum exercício encontrado</td></tr>
                    <?php else: ?>
                        <?php if (isset($exercicios)): ?>
                            <?php foreach ($exercicios as $row): ?>
                                <tr>
                                    <td><?=$row['Pergunta']?></td>
                                    <td><?=$row['Categoria_Bloom']?></td>
                                    <td><?=$row['Tipo_Exercicio']?></td>
                                    <td><a href="<?=base_url('editarexercicio_professor')."/".$row['idExercicio']?>" style="text-decoration: none"><i class="w3-xlarge fa fa-edit">&nbsp;</i></a><a href="<?=base_url('excluirexercicio_professor')."/".$topico['idTopico']."/".$row['idExercicio']?>"><i class="w3-xlarge fa fa-trash"></i></a></td>
                                </tr>
                            <?php endforeach;?>
                        <?php endif;?>
                    <?php endif;?>
                </tbody>
            </table>
            <button onclick="location.href='<?php echo base_url('salvarexercicio_professor')."/".$topico['idTopico'];?>'" class="w3-btn w3-black w3-xlarge"><i class="w3-xlarge fa fa-plus-square"></i></button>
        </div>