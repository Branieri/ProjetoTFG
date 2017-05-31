    <body class="w3-light-grey">

        <?php $this->load->view('commons/menulateral')?>

        <!-- !PAGE CONTENT! -->
        <div class="w3-main" style="margin-left:300px;margin-top:43px;">

            <?php $this->load->view('commons/menupagina')?>

            <div class="w3-container">
                <table class="w3-table-all">
                    <thead>
                        <tr class="w3-light-grey">
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
                                    <?php if ($ra != $row['RA']): ?>
                                        <td><a href="<?=base_url('editarusuario_admin')."/".$row['RA']?>" style="text-decoration: none"><i class="w3-xlarge fa fa-edit">&nbsp;</i></a><a href="<?=base_url('excluirusuario_admin')."/".$row['RA']?>" onclick="return confirm('Tem certeza que deseja excluir o usuário <?=$row['Nome']?>?')"><i class="w3-xlarge fa fa-trash"></i></a></td>
                                    <?php else: ?>
                                        <td><a href="<?=base_url('editarusuario_admin')."/".$row['RA']?>" style="text-decoration: none"><i class="w3-xlarge fa fa-edit">&nbsp;</i></a>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach;?>
                        <?php endif;?>
                    </tbody>
                </table>

                <?php if ($this->router->fetch_class() == 'Admin'): ?>
                    <button onclick="location.href='<?php echo base_url('salvarusuario_admin');?>'" class="w3-btn w3-black w3-xlarge"><i class="w3-xlarge fa fa-plus-square"></i></button>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error') == TRUE && $this->router->fetch_class() == 'Admin'): ?>
                    <p><?php echo $this->session->flashdata('error'); ?></p>
                <?php endif; ?>
                <?php if ($this->session->flashdata('success') == TRUE && $this->router->fetch_class() == 'Admin'): ?>
                    <p><?php echo $this->session->flashdata('success'); ?></p>
                <?php endif; ?>
            </div>
