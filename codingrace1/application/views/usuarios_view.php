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
                                <td><button onclick="PegaDados(this)">Editar</button><button>Excluir</button></td>
                            </tr>
                        <?php endforeach;?>
                    <?php endif;?>
                </tbody>
            </table>
            <button onclick="location.href='<?php echo base_url('salvar');?>'" class="w3-btn w3-black w3-large">Novo Usuário</button>

            <div id="editar" class="w3-modal">
                <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
                    <form class="w3-container" method="post" action="<?=base_url('atualizar')?>" enctype="multipart/form-data">
                        <div class="w3-section">
                            <label><b>Nome</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Digite o Nome" name="nome" id="nome" value="">
                            <label><b>Email</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Digite o Email" name="email" id="email" value="<?=$row['Email']?>">
                            <button class="w3-btn-block w3-black w3-section w3-padding" type="submit" value="salvar">Atualizar</button>
                        </div>
                    </form>
                    <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                        <button onclick="document.getElementById('editar').style.display='none'" type="button" class="w3-btn w3-red">Cancel</button>
                    </div>
                </div>
            </div>

            <?php if ($this->session->flashdata('error') == TRUE): ?>
                <p><?php echo $this->session->flashdata('error'); ?></p>
            <?php endif; ?>
            <?php if ($this->session->flashdata('success') == TRUE): ?>
                <p><?php echo $this->session->flashdata('success'); ?></p>
            <?php endif; ?>

        </div>





