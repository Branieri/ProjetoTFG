    <body class="w3-light-grey">

        <?php $this->load->view('commons/menulateral')?>

        <!-- !PAGE CONTENT! -->
        <div class="w3-main" style="margin-left:300px;margin-top:43px;">

            <?php $this->load->view('commons/menupagina')?>

            <div class="w3-container">
                <table class="w3-table-all w3-container">
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
                                    <td><a href="<?=base_url('editarusuario')."/".$row['RA']?>" style="text-decoration: none"><i class="w3-xlarge fa fa-edit">&nbsp;</i></a><a href="<?=base_url('excluirusuario')."/".$row['RA']?>"><i class="w3-xlarge fa fa-trash"></i></a></td>
                                </tr>
                            <?php endforeach;?>
                        <?php endif;?>
                    </tbody>
                </table>
                <button onclick="location.href='<?php echo base_url('salvarusuario');?>'" class="w3-btn w3-black w3-xlarge"><i class="w3-xlarge fa fa-user-plus"></i></button>

                <?php if ($this->session->flashdata('error') == TRUE): ?>
                    <p><?php echo $this->session->flashdata('error'); ?></p>
                <?php endif; ?>
                <?php if ($this->session->flashdata('success') == TRUE): ?>
                    <p><?php echo $this->session->flashdata('success'); ?></p>
                <?php endif; ?>
            </div>
