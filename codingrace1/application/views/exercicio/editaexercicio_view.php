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
        <form class="w3-container w3-light-grey w3-text-black w3-margin" method="post" id="form_editarexercicio" enctype="multipart/form-data" action="<?=($this->router->fetch_class() == 'Admin') ? base_url('atualizarexercicio_admin')."/".$exercicio['idExercicio']."/".$exercicio['Topico_idTopico'] : base_url('atualizarexercicio_professor')."/".$exercicio['idExercicio']."/".$exercicio['Topico_idTopico'];?>">
            <h2 class="w3-center">Editar Exercício</h2>

            <div class="w3-row w3-section">
                <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-book"></i></div>
                <div class="w3-rest">
                    <textarea class="w3-input w3-border" name="exercicio" id="exercicio" type="text" placeholder="Digite o Exercício" ><?php echo $exercicio['Pergunta']?></textarea>
                </div>
            </div>

            <div class="w3-row w3-section">
                <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-code"></i></div>
                <div class="w3-container w3-left">
                    <select name="bloom" id="bloom" form="form_editarexercicio">
                        <option value="1" <?=($exercicio['Categoria_Bloom'] == 1) ? 'selected' : '' ;?>>Lembrar</option>
                        <option value="2" <?=($exercicio['Categoria_Bloom'] == 2) ? 'selected' : '' ;?>>Entender</option>
                        <option value="3" <?=($exercicio['Categoria_Bloom'] == 3) ? 'selected' : '' ;?>>Aplicar</option>
                        <option value="4" <?=($exercicio['Categoria_Bloom'] == 4) ? 'selected' : '' ;?>>Analisar</option>
                        <option value="5" <?=($exercicio['Categoria_Bloom'] == 5) ? 'selected' : '' ;?>>Avaliar</option>
                        <option value="6" <?=($exercicio['Categoria_Bloom'] == 6) ? 'selected' : '' ;?>>Criar</option>
                    </select>
                </div>
            </div>
            <div class="w3-row w3-section">
                <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-calendar"></i></div>
                <div class="w3-rest">
                    <input class="w3-input w3-border" name="tipo_exercicio" id="tipo_exercicio" type="number" value="<?php echo $exercicio['Tipo_Exercicio']?>">
                </div>
            </div>

            <div class="w3-row w3-section">
                <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-book"></i></div>
                <div class="w3-rest">
                    <textarea class="w3-input w3-border" name="opcaoa" id="opcaoa" type="text" placeholder="Opção A" ><?php echo $alternativas['itemA']?></textarea>
                </div>
            </div>

            <div class="w3-row w3-section">
                <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-book"></i></div>
                <div class="w3-rest">
                    <textarea class="w3-input w3-border" name="opcaob" id="opcaob" type="text" placeholder="Opção B" ><?php echo $alternativas['itemB']?></textarea>
                </div>
            </div>

            <div class="w3-row w3-section">
                <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-book"></i></div>
                <div class="w3-rest">
                    <textarea class="w3-input w3-border" name="opcaoc" id="opcaoc" type="text" placeholder="Opção C" ><?php echo $alternativas['itemC']?></textarea>
                </div>
            </div>

            <div class="w3-row w3-section">
                <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-book"></i></div>
                <div class="w3-rest">
                    <textarea class="w3-input w3-border" name="opcaod" id="opcaod" type="text" placeholder="Opção D" ><?php echo $alternativas['itemD']?></textarea>
                </div>
            </div>

            <div class="w3-row w3-section">
                <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-book"></i></div>
                <div class="w3-rest">
                    <textarea class="w3-input w3-border" name="opcaoe" id="opcaoe" type="text" placeholder="Opção E" ><?php echo $alternativas['itemE']?></textarea>
                </div>
            </div>

            <div class="w3-row w3-section">
                <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-book"></i></div>
                <div class="w3-container w3-left">
                    <select name="opcao_correta" id="opcao_correta" form="form_editarexercicio">
                        <option value="A" <?=($alternativas['Alternativa'] == "A") ? 'selected' : '' ;?>>A</option>
                        <option value="B" <?=($alternativas['Alternativa'] == "B") ? 'selected' : '' ;?>>B</option>
                        <option value="C" <?=($alternativas['Alternativa'] == "C") ? 'selected' : '' ;?>>C</option>
                        <option value="D" <?=($alternativas['Alternativa'] == "D") ? 'selected' : '' ;?>>D</option>
                        <option value="E" <?=($alternativas['Alternativa'] == "E") ? 'selected' : '' ;?>>E</option>
                    </select>
                </div>
            </div>

            <p class="w3-center">
                <button class="w3-btn w3-section w3-black w3-ripple" type="submit" value="salvar"> Salvar </button>
                <?php if ($this->router->fetch_class() == 'Admin'): ?>
                    <button onclick="location.href='<?php echo base_url('editartopico_admin')."/".$exercicio['Topico_idTopico'];?>'" type="button" class="w3-btn w3-section w3-black w3-ripple"> Cancelar </button>
                <?php elseif ($this->router->fetch_class() == 'Professor'): ?>
                    <button onclick="location.href='<?php echo base_url('editartopico_professor')."/".$exercicio['Topico_idTopico'];?>'" type="button" class="w3-btn w3-section w3-black w3-ripple"> Cancelar </button>
                <?php endif; ?>
            </p>
        </form>

    </div>
