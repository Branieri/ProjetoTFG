<body class="w3-light-grey">

<?php $this->load->view('commons/menulateral')?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

    <?php $this->load->view('commons/menupagina')?>

    <div class="w3-container">
        <table class="w3-table-all">
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
                        <?php if ($this->router->fetch_class() == 'Admin'): ?>
                            <td><a href="<?=base_url('editartopico_admin')."/".$row['idTopico']?>" style="text-decoration: none"><i class="w3-xlarge fa fa-edit">&nbsp;</i></a><a href="<?=base_url('excluirtopico_admin')."/".$row['idTopico']?>"><i class="w3-xlarge fa fa-trash"></i></a></td>
                        <?php elseif ($this->router->fetch_class() == 'Professor'): ?>
                            <td><a href="<?=base_url('editartopico_professor')."/".$row['idTopico']?>" style="text-decoration: none"><i class="w3-xlarge fa fa-edit">&nbsp;</i></a></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach;?>
            <?php endif;?>
            </tbody>
        </table>
        <?php if ($this->router->fetch_class() == 'Admin'): ?>
            <button onclick="location.href='<?php echo base_url('salvartopico_admin');?>'" class="w3-btn w3-black w3-xlarge"><i class="w3-xlarge fa fa-plus-square"></i></button>
        <?php elseif ($this->router->fetch_class() == 'Professor'): ?>
            <button onclick="location.href='<?php echo base_url('salvartopico_professor');?>'" class="w3-btn w3-black w3-xlarge"><i class="w3-xlarge fa fa-plus-square"></i></button>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error') == TRUE): ?>
            <p><?php echo $this->session->flashdata('error'); ?></p>
        <?php endif; ?>
        <?php if ($this->session->flashdata('success') == TRUE): ?>
            <p><?php echo $this->session->flashdata('success'); ?></p>
        <?php endif; ?>
    </div>