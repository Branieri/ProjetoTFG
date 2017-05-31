<body class="w3-light-grey">

<?php $this->load->view('commons/menulateral')?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

    <?php $this->load->view('commons/menupagina')?>

    <div class="w3-container w3-content">
        <div class="w3-container w3-left">
            <?php if ($this->session->flashdata('error') == TRUE): ?>
                <p><?php echo $this->session->flashdata('error'); ?></p>
            <?php endif; ?>
        </div>
        <?php echo validation_errors();?>
        <form class="w3-container w3-light-grey w3-text-black w3-margin" method="post" enctype="multipart/form-data" action="<?=base_url('confereexercicio_aluno')."/".$exercicio['idExercicio'];?>">
            <h2 class="w3-center">Novo Curso</h2>

            <div class="w3-row w3-section">
               <p><?php echo $exercicio['Pergunta'];?></p>
            </div>

            <div class="w3-row w3-section">
                <label>A) </label><input type="radio" name="opcao" id="opcao" value="A"/><?php echo $alternativas['itemA'];?>
                <label>B) </label><input type="radio" name="opcao" id="opcao" value="B"/><?php echo $alternativas['itemB'];?>
                <label>C) </label><input type="radio" name="opcao" id="opcao" value="C"/><?php echo $alternativas['itemC'];?>
                <label>D) </label><input type="radio" name="opcao" id="opcao" value="D"><?php echo $alternativas['itemD'];?>
                <label>E) </label><input type="radio" name="opcao" id="opcao" value="E"><?php echo $alternativas['itemE'];?>
            </div>

            <p class="w3-center">
                <button class="w3-btn w3-section w3-black w3-ripple" type="submit" value="salvar"> Confirmar </button>
                <button onclick="location.href='<?php echo base_url('realizartopico_aluno')."/".$exercicio['Topico_idTopico'];?>'" type="button" class="w3-btn w3-section w3-black w3-ripple"> Cancelar </button>
            </p>
        </form>

    </div>
