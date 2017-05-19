    <body class="w3-light-grey">

        <?php $this->load->view('commons/menulateral')?>

        <!-- !PAGE CONTENT! -->
        <div class="w3-main" style="margin-left:300px;margin-top:43px;">

            <?php $this->load->view('commons/menupagina')?>



            <div class="w3-container">

                <?php if ($this->router->fetch_class() == 'Aluno' || $this->router->fetch_class() == 'Professor'): ?>
                    <div class="w3-container w3-left">
                        <?php if ($this->session->flashdata('error') == TRUE): ?>
                            <p><?php echo $this->session->flashdata('error'); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php echo validation_errors();?>

                    <form class="w3-container w3-card-4 w3-light-grey w3-text-black w3-margin" method="post" enctype="multipart/form-data" action="<?=($this->router->fetch_class() == 'Professor') ? base_url('cadastracursos_professor') : base_url('cadastracursos_aluno');?>">
                        <h2 class="w3-left">Novo Curso</h2>

                        <div class="w3-row w3-section">
                            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-book"></i></div>
                            <div class="w3-rest">
                                <input class="w3-input w3-border" name="PIN" id="PIN" type="text" placeholder="Digite o PIN">
                            </div>
                        </div>
                        <p class="w3-left">
                            <button class="w3-btn w3-section w3-black w3-ripple" type="submit" value="salvar"> Cadastrar </button>
                        </p>
                    </form>
                <?php endif; ?>

                <table class="w3-table-all">
                    <thead>
                        <tr class="w3-light-grey">
                            <th>Nome</th>
                            <th>PIN</th>
                            <th>Ano</th>
                            <th>Período</th>
                            <th>Operações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($cursos == FALSE): ?>
                            <tr><td colspan="2">Nenhum curso cadastrado</td></tr>
                        <?php else: ?>
                            <?php if (isset($cursos)): ?>
                                <?php foreach ($cursos as $row): ?>
                                    <tr>
                                        <td><?=$row['Nome']?></td>
                                        <td><?=$row['PIN']?></td>
                                        <td><?=$row['Ano']?></td>
                                        <td><?=$row['Periodo']?></td>
                                        <?php if ($this->router->fetch_class() == 'Admin'): ?>
                                            <td><a href="<?=base_url('editarcurso_admin')."/".$row['PIN']?>" style="text-decoration: none"><i class="w3-xlarge fa fa-edit">&nbsp;</i></a><a href="<?=base_url('excluircurso_admin')."/".$row['PIN']?>"><i class="w3-xlarge fa fa-trash"></i></a></td>
                                        <?php elseif ($this->router->fetch_class() == 'Professor' && $this->router->fetch_method() == 'CursosUsuario'): ?>
                                            <td><a href="<?=base_url('editarcurso_professor')."/".$row['PIN']?>" style="text-decoration: none"><i class="w3-xlarge fa fa-edit">&nbsp;</i></a><a href="<?=base_url('excluircursousuario_professor')."/".$row['PIN']?>"><i class="w3-xlarge fa fa-trash"></i></a></td>
                                        <?php elseif ($this->router->fetch_class() == 'Aluno' && $this->router->fetch_method() == 'CursosUsuario'): ?>
                                            <td><a href="<?=base_url('excluircursousuario_aluno')."/".$row['PIN']?>"><i class="w3-xlarge fa fa-trash"></i></a></td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach;?>
                            <?php endif; ?>
                        <?php endif;?>
                    </tbody>
                </table>
                <?php if ($this->router->fetch_class() == 'Admin'): ?>
                    <button onclick="location.href='<?php echo base_url('salvarcurso_admin');?>'" class="w3-btn w3-black w3-xlarge"><i class="w3-xlarge fa fa-plus-square"></i></button>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error') == TRUE): ?>
                    <p><?php echo $this->session->flashdata('error'); ?></p>
                <?php endif; ?>
                <?php if ($this->session->flashdata('success') == TRUE): ?>
                    <p><?php echo $this->session->flashdata('success'); ?></p>
                <?php endif; ?>
            </div>