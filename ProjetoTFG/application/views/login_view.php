<!DOCTYPE html>
<html lang="pt_BR">

    <head>
        <title>Projeto TFG - Login</title>
        <meta http-equiv="content-type" content="text/html"; charset="utf-8">
        <link rel="stylesheet" href="<?=base_url('assets/css/form_Login.css')?>">
    </head>

    <body>
        <h1>Tela de Login</h1>
        <div id="form_login">
            <?php echo validation_errors();?>
            <?php
                echo form_open();

                echo form_label('RA', 'ra');
                echo form_input('ra', '');

                echo form_label('Senha', 'senha');
                echo form_password('senha', '');

                echo form_submit('submit', 'Entrar');
            ?>
            <?php form_close(); ?>

        </div>
    </body>
</html>
