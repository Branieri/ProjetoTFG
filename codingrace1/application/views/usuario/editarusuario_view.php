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
        <?php if ($this->router->fetch_class() == 'Admin'): ?>
            <form class="w3-container w3-light-grey w3-text-black w3-margin" method="post" enctype="multipart/form-data" action="<?=base_url('atualizarusuario_admin')?>" id="form_editausuario">
        <?php elseif ($this->router->fetch_class() == 'Professor'): ?>
            <form class="w3-container w3-card-4 w3-light-grey w3-text-black w3-margin" method="post" enctype="multipart/form-data" action="<?=base_url('atualizarusuario_professor')?>" id="form_editausuario">
        <?php else: ?>
            <form class="w3-container w3-card-4 w3-light-grey w3-text-black w3-margin" method="post" enctype="multipart/form-data" action="<?=base_url('atualizarusuario_aluno')?>" id="form_editausuario">
        <?php endif; ?>
            <h2 class="w3-center">Editar Usuário</h2>

            <div class="w3-row w3-section">
                <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
                <div class="w3-rest">
                    <input class="w3-input w3-border" name="nome" id="nome" type="text" placeholder="Nome" value="<?php echo $usuario['Nome']?>">
                </div>
            </div>

            <div class="w3-row w3-section">
                <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-book"></i></div>
                <div class="w3-rest">
                    <input class="w3-input w3-border" name="ra" id="ra" type="text" placeholder="RA" value="<?php echo $usuario['RA']?>">
                </div>
            </div>

            <div class="w3-row w3-section">
                <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-envelope-o"></i></div>
                <div class="w3-rest">
                    <input class="w3-input w3-border" name="email" id="email" type="text" placeholder="Email" value="<?php echo $usuario['Email']?>">
                </div>
            </div>

            <div class="w3-row w3-section">
                <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-envelope-o"></i></div>
                <div class="w3-rest">
                    <input class="w3-input w3-border" name="confirmar_email" id="confirmar_email" type="text" placeholder="Confirmar Email" value="<?=set_value('confirmar_email')?>">
                </div>
            </div>

            <div class="w3-row w3-section">
                <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-key"></i></div>
                <div class="w3-rest">
                    <input class="w3-input w3-border" name="senha" id="senha" type="password" placeholder="Senha" value="<?php echo $usuario['Senha']?>">
                </div>
            </div>

            <?php if ($this->router->fetch_class() == 'Admin'): ?>
                <div class="w3-row w3-section">
                    <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-code"></i></div>
                    <div class="w3-container w3-left">
                        <select name="tipo_usuario" id="tipo_usuario" form="form_editausuario">
                            <option value="0" <?=($usuario['Tipo_Usuario'] == 0) ? 'selected' : '' ;?>>Administrador</option>
                            <option value="1" <?=($usuario['Tipo_Usuario'] == 1) ? 'selected' : '' ;?>>Professor</option>
                            <option value="2" <?=($usuario['Tipo_Usuario'] == 2) ? 'selected' : '' ;?>>Aluno</option>
                        </select>
                    </div>
                </div>
            <?php endif; ?>

            <p class="w3-center">
                <button class="w3-btn w3-section w3-black w3-ripple" type="submit" value="salvar"> Salvar </button>
                <?php if ($this->router->fetch_class() == 'Admin'): ?>
                    <button onclick="location.href='<?php echo base_url('home_admin');?>'" type="button" class="w3-btn w3-section w3-black w3-ripple">Cancelar</button>
                <?php elseif ($this->router->fetch_class() == 'Professor'): ?>
                    <button onclick="location.href='<?php echo base_url('home_professor');?>'" type="button" class="w3-btn w3-section w3-black w3-ripple">Cancelar</button>
                <?php else: ?>
                    <button onclick="location.href='<?php echo base_url('home_aluno');?>'" type="button" class="w3-btn w3-section w3-black w3-ripple">Cancelar</button>
                <?php endif; ?>
            </p>
        </form>
    </div>