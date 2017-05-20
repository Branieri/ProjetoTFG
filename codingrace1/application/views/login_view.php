<!DOCTYPE html>
<html lang="pt_BR">
    <title>Projeto TFG - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
    <body>

        <header class="w3-container w3-center w3-blue">
            <h1>CodingRace</h1>
        </header>

        <div class="w3-display-middle w3-container w3-quarter w3-margin-top">
            <?php echo validation_errors();?>
            <?php if ($this->session->flashdata('usuario_naoencontrado') == TRUE): ?>
                <p><?php echo $this->session->flashdata('usuario_naoencontrado'); ?></p>
            <?php endif; ?>
            <form class="w3-container w3-card-4" method="post" >
                <p>
                    <input class="w3-input" type="text" style="width:90%" name="ra" id="ra" value="<?=set_value('ra')?>">
                    <label class="w3-label w3-text-blue w3-validate">RA</label></p>
                <p>
                    <input class="w3-input" type="password" style="width:90%" name="senha" id="senha" value="<?=set_value('senha')?>">
                    <label class="w3-label w3-text-blue w3-validate">Senha</label></p>
                <p>
                    <button class="w3-btn w3-section w3-blue w3-ripple" type="submit" value="entrar"> Entrar </button></p>
                <p>
                    <a  href="<?=base_url('new_user')?>" style="color: blue">Novo Usuário</a>
            </form>

        </div>

    </body>
</html>
