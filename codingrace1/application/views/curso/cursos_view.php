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
                            <?php foreach ($cursos as $row): ?>
                                <tr>
                                    <td><?=$row['Nome']?></td>
                                    <td><?=$row['PIN']?></td>
                                    <td><?=$row['Ano']?></td>
                                    <td><?=$row['Periodo']?></td>
                                    <td><a href="<?=base_url('editarcurso')."/".$row['PIN']?>" style="text-decoration: none"><i class="w3-xlarge fa fa-edit">&nbsp;</i></a><a href="<?=base_url('excluircurso')."/".$row['PIN']?>"><i class="w3-xlarge fa fa-trash"></i></a></td>
                                </tr>
                            <?php endforeach;?>
                        <?php endif;?>
                    </tbody>
                </table>
                <button onclick="location.href='<?php echo base_url('salvarcurso');?>'" class="w3-btn w3-black w3-xlarge"><i class="w3-xlarge fa fa-plus-square"></i></button>

                <?php if ($this->session->flashdata('error') == TRUE): ?>
                    <p><?php echo $this->session->flashdata('error'); ?></p>
                <?php endif; ?>
                <?php if ($this->session->flashdata('success') == TRUE): ?>
                    <p><?php echo $this->session->flashdata('success'); ?></p>
                <?php endif; ?>
            </div>