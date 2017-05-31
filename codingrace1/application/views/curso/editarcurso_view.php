    <body class="w3-light-grey">

        <?php $this->load->view('commons/menulateral')?>

        <!-- !PAGE CONTENT! -->
        <div class="w3-main" style="margin-left:300px;margin-top:43px;">

            <?php $this->load->view('commons/menupagina')?>

            <div class="w3-container w3-content w3-center">
                <div class="w3-container w3-left">
                    <?php if ($this->session->flashdata('error') == TRUE): ?>
                        <p><?php echo $this->session->flashdata('error'); ?></p>
                    <?php endif; ?>
                </div>
                <?php echo validation_errors();?>
                <form class="w3-container w3-light-grey w3-text-black w3-margin" method="post" enctype="multipart/form-data" action="<?=($this->router->fetch_class() == 'Admin') ? base_url('atualizarcurso_admin') : base_url('atualizarcurso_professor');?>">
                    <h2 class="w3-center">Editar Curso</h2>

                    <div class="w3-row w3-section">
                        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-book"></i></div>
                        <div class="w3-rest">
                            <input class="w3-input w3-border" name="nome" id="nome" type="text" placeholder="Nome" value="<?php echo $curso['Nome']?>">
                        </div>
                    </div>

                    <div class="w3-row w3-section">
                        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-code"></i></div>
                        <div class="w3-rest">
                            <input readonly class="w3-input w3-border" name="pin" id="pin" type="text" placeholder="PIN" value="<?php echo $curso['PIN']?>">
                        </div>
                    </div>

                    <div class="w3-row w3-section">
                        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-calendar"></i></div>
                        <div class="w3-rest">
                            <input class="w3-input w3-border" name="ano" id="ano" type="text" placeholder="Ano" value="<?php echo $curso['Ano']?>">
                        </div>
                    </div>

                    <div class="w3-row w3-section">
                        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-calendar-o"></i></div>
                        <div class="w3-rest">
                            <input class="w3-input w3-border" name="periodo" id="periodo" type="text" placeholder="Periodo" value="<?php echo $curso['Periodo']?>">
                        </div>
                    </div>

                    <p class="w3-center">
                        <button class="w3-btn w3-section w3-black w3-ripple" type="submit" value="salvar"> Salvar </button>
                        <?php if ($this->router->fetch_class() == 'Admin'): ?>
                            <button onclick="location.href='<?php echo base_url('cursos_admin');?>'" type="button" class="w3-btn w3-section w3-black w3-ripple"> Cancelar </button>
                        <?php elseif ($this->router->fetch_class() == 'Professor'): ?>
                            <button onclick="location.href='<?php echo base_url('cursoscadastrados_professor');?>'" type="button" class="w3-btn w3-section w3-black w3-ripple"> Cancelar </button>
                        <?php endif; ?>
                    </p>
                </form>
            </div>

            <div class="w3-container">
                <table class="w3-table-all">
                    <h2 class="w3-left">Alunos</h2>
                    <thead>
                    <tr class="w3-light-grey">
                        <th>Nome</th>
                        <th>RA</th>
                        <th>E-mail</th>
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
                            </tr>
                        <?php endforeach;?>
                    <?php endif;?>
                    </tbody>
                </table>
            </div>

            <div class="w3-container">
                <table class="w3-table-all">
                    <h2 class="w3-left">Tópicos</h2>
                    <thead>
                        <tr class="w3-light-grey">
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Operações</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($topicos == FALSE): ?>
                        <tr><td colspan="2">Nenhum tópico cadastrado</td></tr>
                    <?php else: ?>
                        <?php foreach ($topicos as $row): ?>
                            <tr>
                                <td><?=$row['idTopico']?></td>
                                <td><?=$row['Nome']?></td>
                                <?php if ($this->router->fetch_class() == 'Professor'): ?>
                                    <td><a href="<?=base_url('editartopico_professor')."/".$row['idTopico']?>" style="text-decoration: none"><i class="w3-xlarge fa fa-edit">&nbsp;</i></a><a href="<?=base_url('excluirtopicocurso_professor')."/".$row['idTopico']."/".$curso['PIN']?>"><i class="w3-xlarge fa fa-trash"></i></a></td>
                                <?php else: ?>
                                    <td><a href="<?=base_url('editartopico_admin')."/".$row['idTopico']?>" style="text-decoration: none"><i class="w3-xlarge fa fa-edit">&nbsp;</i></a><a href="<?=base_url('excluirtopicocurso_admin')."/".$row['idTopico']."/".$curso['PIN']?>"><i class="w3-xlarge fa fa-trash"></i></a></td>
                                <?php endif; ?>
                                </tr>
                        <?php endforeach;?>
                    <?php endif;?>
                    </tbody>
                </table>
                <?php if ($topicostotal == FALSE): ?>
                    <tr><td colspan="2">Nenhum tópico encontrado</td></tr>
                <?php else: ?>
                    <form class="w3-container w3-light-grey w3-text-black w3-margin" method="post" enctype="multipart/form-data" id="form_adicionatopico" action="<?=($this->router->fetch_class() == 'Admin') ? base_url('adicionartopicocurso_admin')."/".$curso['PIN'] : base_url('adicionartopicocurso_professor')."/".$curso['PIN'];?>">
                        Novo Tópico: <select id="Topicos_Lista" name="Topicos_Lista" form="form_adicionatopico">
                            <option value="0">Selecione...</option>
                            <?php foreach ($topicostotal as $row2): ?>
                                <option value="<?=$row2['idTopico']?>"><?=$row2['Nome']?></option>
                            <?php endforeach;?>
                        </select>
                        <button class="w3-btn w3-section w3-black w3-ripple" type="submit" value="salvar"> <i class="w3-large fa fa-plus-square"></i> </button>
                    </form>
                <?php endif;?>