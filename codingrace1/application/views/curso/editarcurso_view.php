    <body class="w3-light-grey">

        <?php $this->load->view('commons/menulateral')?>

        <!-- !PAGE CONTENT! -->
        <div class="w3-main" style="margin-left:300px;margin-top:43px;">

            <?php $this->load->view('commons/menupagina')?>

            <div class="w3-container w3-center">
                <div class="w3-container w3-left">
                    <?php if ($this->session->flashdata('error') == TRUE): ?>
                        <p><?php echo $this->session->flashdata('error'); ?></p>
                    <?php endif; ?>
                </div>
                <?php echo validation_errors();?>
                <form class="w3-container w3-card-4 w3-light-grey w3-text-black w3-margin" method="post" enctype="multipart/form-data" action="<?=base_url('atualizarcurso')?>">
                    <h2 class="w3-center">Editar Curso</h2>

                    <div class="w3-row w3-section">
                        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-book"></i></div>
                        <div class="w3-rest">
                            <input class="w3-input w3-border" name="nome" id="nome" type="text" placeholder="Nome" value="<?php echo $curso['Nome']?>">
                        </div>
                    </div>

                    <div class="w3-row w3-section">
                        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-code"></i></div>
                        <div class="w3-rest">
                            <input class="w3-input w3-border" name="pin" id="pin" type="text" placeholder="PIN" value="<?php echo $curso['PIN']?>">
                        </div>
                    </div>

                    <div class="w3-row w3-section">
                        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-calendar"></i></div>
                        <div class="w3-rest">
                            <input class="w3-input w3-border" name="ano" id="ano" type="text" placeholder="Ano" value="<?php echo $curso['Ano']?>">
                        </div>
                    </div>

                    <div class="w3-row w3-section">
                        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-calendar-o"></i></div>
                        <div class="w3-rest">
                            <input class="w3-input w3-border" name="periodo" id="periodo" type="text" placeholder="Periodo" value="<?php echo $curso['Periodo']?>">
                        </div>
                    </div>

                    <p class="w3-center">
                        <button class="w3-btn w3-section w3-black w3-ripple" type="submit" value="salvar"> Salvar </button>
                        <button onclick="location.href='<?php echo base_url('cursos');?>'" type="button" class="w3-btn w3-section w3-black w3-ripple">Cancelar</button>
                    </p>
                </form>
            </div>