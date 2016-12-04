<body class="w3-light-grey">

<?php $this->load->view('commons/menulateral')?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

    <?php $this->load->view('commons/menupagina')?>

    <div id="form_newusuario">
        <?php echo validation_errors();?>
        <?php
            echo form_open();

            echo form_label('Nome: ', 'nome');
            echo form_input('nome', '');

            echo form_label('RA: ', 'ra');
            echo form_input('ra', '');

            echo form_label('Email: ', 'email');
            echo form_input('email', '');

            echo form_label('Confirmar Email: ', 'confirmar_email');
            echo form_input('confirmar_email', '');

            echo form_label('Senha: ', 'senha');
            echo form_password('senha', '');

            echo form_submit('submit', 'Salvar');
            echo form_submit('button', 'Cancelar');
        ?>
        <?php form_close(); ?>

    </div>