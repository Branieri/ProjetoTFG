<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class Admin extends MY_Controller
    {
        public  function __construct()
        {
            parent::__construct();

            $usuario = $this->session->userdata('tipo_usuario');

            if($usuario == 1 || $usuario == null){
                echo 'Você não tem permissão para entrar nessa página';
                die();
            }elseif ($usuario == 2 || $usuario == null){
                echo 'Você não tem permissão para entrar nessa página';
                die();
            }
        }

        public function HomeAdmin()
        {
            $data['nome'] = $this->session->userdata('nome');
            $data['ra'] = $this->session->userdata('ra');
            $data['title'] = "Projeto TFG - Home";
            $data['header'] = "Home";

            $this->load->view('commons/header',$data);
            $this->load->view('homeadmin_view');
            $this->load->view('commons/footer');
        }

        /** Funções CRUD Usuários */

        public function Usuarios()
        {
            /** Carrega funções de busca do BD */
            $this->load->model('usuarios_model');

            /** Variável com dados para serem passadas para a view */
            $data['nome'] = $this->session->userdata('nome');
            $data['ra'] = $this->session->userdata('ra');
            $data['title'] = "Projeto TFG - Usuários";
            $data['header'] = "Usuários";

            // Retorna todos os usuários do BD
            $data['usuarios'] = $this->usuarios_model->GetAll('Nome');

                /** Carrega a view */
            $this->load->view('commons/header',$data);
            $this->load->view('usuario/usuarios_view');
            $this->load->view('commons/footer');
        }

        public function CadUsuario()
        {
            $this->load->model('usuarios_model');
            $validacao = self::Validar('usuario');

            $data['nome'] = $this->session->userdata('nome');
            $data['ra'] = $this->session->userdata('ra');
            $data['title'] = "Projeto TFG - Novo Usuário";
            $data['header'] = "Novo Usuário";

            if($this->input->post('tipo_usuario') == -1){
                echo "<script> window.alert('Selecione o tipo de usuário')</script>";
                /** Carrega a view */
                $this->load->view('commons/header', $data);
                $this->load->view('usuario/novousuario_view');
                $this->load->view('commons/footer');
            } else {
                if ($validacao) {
                    $nome = $this->input->post('nome');
                    $senha = $this->input->post('senha');
                    $email = $this->input->post('email');
                    $ra = $this->input->post('ra');
                    $dados_usuario = array(
                        'Nome' => $nome,
                        'Email' => $email,
                        'Senha' => $senha,
                        'RA' => $ra,
                        'Status' => 0,
                        'Tipo_Usuario' => 0
                    );
                    $status = $this->usuarios_model->Inserir($dados_usuario);
                    if (!$status) {
                        $this->session->set_flashdata('error', 'Não foi possível inserir o usuário!');

                        /** Carrega a view */
                        $this->load->view('commons/header', $data);
                        $this->load->view('usuario/novousuario_view');
                        $this->load->view('commons/footer');

                    } else {
                        $this->session->set_flashdata('success', 'Usuário inserido com sucesso!');
                        redirect('usuarios_admin');
                    }
                } else {

                    /** Carrega a view */
                    $this->load->view('commons/header', $data);
                    $this->load->view('usuario/novousuario_view');
                    $this->load->view('commons/footer');
                }
            }

        }

        public function AtualizaUsuario()
        {
            $this->load->model('usuarios_model');
            $validacao = self::Validar('edita_usuario');
            $ra = $this->input->post('ra');

            if($validacao) {
                $nome = $this->input->post('nome');
                $email = $this->input->post('email');
                $tipo_usuario = $this->input->post('tipo_usuario');

                $dados_usuario = array(
                    'Nome' => $nome,
                    'Email' => $email,
                    'Tipo_Usuario' => $tipo_usuario,
                );

                $status = $this->usuarios_model->AtualizaUsuario($ra, $dados_usuario);

                if (!$status) {
                    $this->session->set_flashdata('error', 'Não foi possível atualizar o usuário.');
                    self::EditaUsuario($ra);
                } else {
                    $this->session->set_flashdata('success', 'Usuário atualizado com sucesso.');
                    redirect('usuarios_admin');
                }
            }else{
                self::EditaUsuario($ra);
            }

        }

        public function EditaUsuario($ra)
        {

            $this->load->model('usuarios_model');

            if(is_null($ra))
                redirect('usuarios_admin');

            $data['usuario'] = $this->usuarios_model->GetByRA($ra);

            $data['nome'] = $this->session->userdata('nome');
            $data['ra'] = $this->session->userdata('ra');
            $data['title'] = "Projeto TFG - Edita Usuário";
            $data['header'] = "Edita Usuário";

            /** Carrega a view */
            $this->load->view('commons/header',$data);
            $this->load->view('usuario/editarusuario_view');
            $this->load->view('commons/footer');

        }

        public function ExcluiUsuario($ra)
        {
            $this->load->model('usuarios_model');

            if(is_null($ra)) {
                $this->session->set_flashdata('error', 'Não foi possível excluir o usuário.');
                redirect('usuarios_admin');
            }else{
                $data['usuario'] = $this->usuarios_model->ExcluirUsuario($ra);
                $this->session->set_flashdata('success', 'Usuário excluído com sucesso.');
                redirect('usuarios_admin');
            }
        }

        /** Funções CRUD para Cursos */

        public function Cursos(){
            /** Carrega funções de busca do BD */
            $this->load->model('cursos_model');

            /** Variável com dados para serem passadas para a view */
            $data['nome'] = $this->session->userdata('nome');
            $data['ra'] = $this->session->userdata('ra');
            $data['title'] = "Projeto TFG - Cursos";
            $data['header'] = "Disciplinas";

            // Retorna todos os cursos do BD
            $data['cursos'] = $this->cursos_model->GetAll('PIN');

            /** Carrega a view */
            $this->load->view('commons/header',$data);
            $this->load->view('curso/cursos_view');
            $this->load->view('commons/footer');
        }

        public function CadCurso(){

            $this->load->model('cursos_model');
            $validacao = self::Validar('curso');

            $data['nome'] = $this->session->userdata('nome');
            $data['ra'] = $this->session->userdata('ra');
            $data['title'] = "Projeto TFG - Novo Curso";
            $data['header'] = "Nova Disciplina";

            if ($validacao){
                $nome = $this->input->post('nome');
                $pin = $this->input->post('pin');
                $ano = $this->input->post('ano');
                $periodo = $this->input->post('periodo');
                $dados_curso = array(
                    'Nome' => $nome,
                    'PIN' => $pin,
                    'Ano' => $ano,
                    'Periodo' => $periodo,
                );
                $status = $this->cursos_model->Inserir($dados_curso);
                if(!$status)
                {
                    $this->session->set_flashdata('error', 'Não foi possível cadastrar o curso!');

                    /** Carrega a view */
                    $this->load->view('commons/header',$data);
                    $this->load->view('curso/novocurso_view');
                    $this->load->view('commons/footer');
                }else{
                    $this->session->set_flashdata('success', 'Curso cadastrado com sucesso!');
                    redirect('cursos_admin');
                }
            }else{

                /** Carrega a view */
                $this->load->view('commons/header',$data);
                $this->load->view('curso/novocurso_view');
                $this->load->view('commons/footer');
            }

        }

        public function ExcluiCurso($pin){
            $this->load->model('cursos_model');

            if(is_null($pin)) {
                $this->session->set_flashdata('error', 'Não foi possível excluir o curso.');
                redirect('cursos_admin');
            }else{
                $data['curso'] = $this->cursos_model->ExcluirCurso($pin);
                $this->session->set_flashdata('success', 'Curso excluído com sucesso.');
                redirect('cursos_admin');
            }
        }

        public function AtualizaCurso(){
            $this->load->model('cursos_model');
            $validacao = self::Validar('edita_curso');
            $pin = $this->input->post('pin');

            if($validacao) {
                $nome = $this->input->post('nome');
                $ano = $this->input->post('ano');
                $periodo = $this->input->post('periodo');

                $dados_curso = array(
                    'Nome' => $nome,
                    'Ano' => $ano,
                    'Periodo'=> $periodo,
                );

                $status = $this->cursos_model->AtualizaCurso($pin, $dados_curso);

                if (!$status) {
                    $this->session->set_flashdata('error', 'Não foi possível atualizar o curso.');
                    self::EditaCurso($pin);
                } else {
                    $this->session->set_flashdata('success', 'Curso atualizado com sucesso.');
                    redirect('cursos_admin');
                }
            }else{
                self::EditaCurso($pin);
            }
        }

        public function EditaCurso($pin){
            $this->load->model('cursos_model');
            $this->load->model('usuario_has_curso_model');
            $this->load->model('usuarios_model');
            $this->load->model('curso_has_topico_model');
            $this->load->model('topicos_model');

            if(is_null($pin))
                redirect('cursos_admin');

            $data['curso'] = $this->cursos_model->GetByPIN($pin);

            $ra = $this->usuario_has_curso_model->UsuariosCurso($pin);
            $data['usuarios'] = $this->usuarios_model->GetBySomeRa($ra);

            $idTopico = $this->curso_has_topico_model->TopicosCursos($pin);
            $data['topicos'] = $this->topicos_model->GetBySomeId($idTopico);

            $data['topicostotal'] = $this->topicos_model->GetAll('idTopico');

            $data['nome'] = $this->session->userdata('nome');
            $data['ra'] = $this->session->userdata('ra');
            $data['title'] = "Projeto TFG - Edita Curso";
            $data['header'] = "Editar Disciplina";

            /** Carrega a view */
            $this->load->view('commons/header',$data);
            $this->load->view('curso/editarcurso_view');
            $this->load->view('commons/footer');
        }

        /** Funções CRUD para Tópicos */

        public function Topicos()
        {
            /** Carrega funções de busca do BD */
            $this->load->model('topicos_model');

            /** Variável com dados para serem passadas para a view */
            $data['nome'] = $this->session->userdata('nome');
            $data['title'] = "Projeto TFG - Tópicos";
            $data['ra'] = $this->session->userdata('ra');
            $data['header'] = "Tópicos";

            // Retorna todos os usuários do BD
            $data['topicos'] = $this->topicos_model->GetAll('idTopico');

            /** Carrega a view */
            $this->load->view('commons/header',$data);
            $this->load->view('topico/topicos_view');
            $this->load->view('commons/footer');
        }

        public function CadTopico()
        {
            $this->load->model('topicos_model');
            $validacao = self::Validar('topico');

            $data['nome'] = $this->session->userdata('nome');
            $data['ra'] = $this->session->userdata('ra');
            $data['title'] = "Projeto TFG - Novo Tópico";
            $data['header'] = "Novo Tópico";

            if ($validacao){
                $nome = $this->input->post('nome');
                $dados_topico = array(
                    'Nome' => $nome,
                );
                $status = $this->topicos_model->Inserir($dados_topico);
                if(!$status)
                {
                    $this->session->set_flashdata('error', 'Não foi possível inserir o tópico!');

                    /** Carrega a view */
                    $this->load->view('commons/header',$data);
                    $this->load->view('topico/novotopico_view');
                    $this->load->view('commons/footer');
                }else{
                    $this->session->set_flashdata('success', 'Tópico inserido com sucesso!');
                    redirect('topicos_admin');
                }
            }else{

                /** Carrega a view */
                $this->load->view('commons/header',$data);
                $this->load->view('topico/novotopico_view');
                $this->load->view('commons/footer');
            }

        }

        public function CadTopicoCurso($pin){
            $this->load->model('curso_has_topico_model');
            $idTopico = $this->input->post('Topicos_Lista');

            if ($idTopico == 0){

                echo "<script> window.alert('Selecione um Tópico')</script>";
                $this->EditaCurso($pin);

            } else {
                $dados_topico_cadastrado = array(
                    'Topico_idTopico' => $idTopico,
                    'Curso_PIN' => $pin,
                );

                $validacurso = $this->curso_has_topico_model->BuscaTopicoCadastrado($idTopico, $pin);

                if ($validacurso){
                    $status = $this->curso_has_topico_model->Inserir($dados_topico_cadastrado);
                    if(!$status)
                    {
                        echo "<script> window.alert('Não foi possível cadastrar o tópico')</script>";
                        $this->EditaCurso($pin);
                    }else{
                        echo "<script> window.alert('Tópico cadastrado com sucesso')</script>";
                        $this->EditaCurso($pin);
                    }
                }else{
                    echo "<script> window.alert('Tópico já cadastrado')</script>";
                    $this->EditaCurso($pin);
                }
            }
        }

        public function ExcluiTopicoCurso($id, $pin){
            $this->load->model('curso_has_topico_model');
            $ra = $this->session->userdata('ra');

            if(is_null($pin)) {
                $this->session->set_flashdata('error', 'Não foi possível excluir o tópico.');
                $this->EditaCurso($pin);
            }else{
                $data[''] = $this->curso_has_topico_model->ExcluirTopicosCadastrado($pin, $id);
                $this->session->set_flashdata('success', 'Tópico excluído com sucesso.');
                $this->EditaCurso($pin);
            }
        }

        public function AtualizaTopico()
        {
            $this->load->model('topicos_model');
            $validacao = self::Validar('topico');
            $id = $this->input->post('id');

            if($validacao) {
                $nome = $this->input->post('nome');

                $dados_topico = array(
                    'Nome' => $nome,
                );

                $status = $this->topicos_model->AtualizaTopico($id, $dados_topico);

                if (!$status) {
                    $this->session->set_flashdata('error', 'Não foi possível atualizar o tópico.');
                    self::EditaTopico($id);
                } else {
                    $this->session->set_flashdata('success', 'Tópico atualizado com sucesso.');
                    redirect('topicos_admin');
                }
            }else{
                self::EditaTopico($id);
            }

        }

        public function EditaTopico($id)
        {
            $this->load->model('exercicio_model');
            $this->load->model('topicos_model');

            if(is_null($id))
                redirect('topicos_admin');

            $data['topico'] = $this->topicos_model->GetById($id);
            $data['exercicios'] = $this->exercicio_model->GetByTopico($id);

            $data['nome'] = $this->session->userdata('nome');
            $data['ra'] = $this->session->userdata('ra');
            $data['title'] = "Projeto TFG - Edita Tópico";
            $data['header'] = "Edita Tópico";

            /** Carrega a view */
            $this->load->view('commons/header',$data);
            $this->load->view('topico/editartopico_view');
            $this->load->view('commons/footer');

        }

        public function ExcluiTopico($id)
        {
            $this->load->model('topicos_model');

            if(is_null($id)) {
                $this->session->set_flashdata('error', 'Não foi possível excluir o tópico.');
                redirect('topicos_admin');
            }else{
                $data['topicos'] = $this->topicos_model->ExcluirTopico($id);
                $this->session->set_flashdata('success', 'Tópico excluído com sucesso.');
                redirect('topicos_admin');
            }
        }

        /** Funções para Exercícios */

        public function CadExercicio($idTopico){
            $this->load->model('exercicio_model');
            $this->load->model('qme_model');
            $validacao = self::Validar('exercicio');

            $data['nome'] = $this->session->userdata('nome');
            $data['topico'] = $idTopico;
            $data['ra'] = $this->session->userdata('ra');
            $data['title'] = "Projeto TFG - Novo Exercício";
            $data['header'] = "Novo Exercício";

            if ($validacao){
                $exercicio = $this->input->post('exercicio');
                $bloom = $this->input->post('bloom');
                $tipo_exercicio = $this->input->post('tipo_exercicio');
                $opcaoa = $this->input->post('opcaoa');
                $opcaob = $this->input->post('opcaob');
                $opcaoc = $this->input->post('opcaoc');
                $opcaod = $this->input->post('opcaod');
                $opcaoe = $this->input->post('opcaoe');
                $resposta_certa = $this->input->post('opcao_correta');
                $dados_exercicio = array(
                    'Pergunta' => $exercicio,
                    'Categoria_Bloom' => $bloom,
                    'Tipo_Exercicio' => $tipo_exercicio,
                    'Topico_idTopico' => $idTopico
                );

                $idExercicio = $this->exercicio_model->InserirRetornandoId($dados_exercicio);

                if(!$idExercicio)
                {
                    $this->session->set_flashdata('error', 'Não foi possível cadastrar o Exercício!');

                    /** Carrega a view */
                    $this->load->view('commons/header',$data);
                    $this->load->view('exercicio/novoexercicio_view');
                    $this->load->view('commons/footer');
                }else{
                    $dados_resposta = array(
                        'itemA' => $opcaoa,
                        'itemB' => $opcaob,
                        'itemC' => $opcaoc,
                        'itemD' => $opcaod,
                        'itemE' => $opcaoe,
                        'Alternativa' => $resposta_certa,
                        'Exercicio_idExercicio' => $idExercicio
                    );
                    $okResposta = $this->qme_model->Inserir($dados_resposta);
                    if (!$okResposta){
                        $this->exercicio_model->Excluir($idExercicio);

                        $this->session->set_flashdata('error', 'Não foi possível cadastrar o exercício, problema nas Respostas!');

                        /** Carrega a view */
                        $this->load->view('commons/header',$data);
                        $this->load->view('exercicio/novoexercicio_view');
                        $this->load->view('commons/footer');
                    }else{
                        $this->session->set_flashdata('success', 'Exercicio cadastrado com sucesso!');
                        $this->EditaTopico($idTopico);
                    }
                }
            }else {
                $data['nome'] = $this->session->userdata('nome');
                $data['title'] = "Projeto TFG - Novo Exercício";
                $data['topico'] = $idTopico;
                $data['header'] = "Novo Exercício";

                /** Carrega a view */
                $this->load->view('commons/header', $data);
                $this->load->view('exercicio/novoexercicio_view');
                $this->load->view('commons/footer');
            }
        }

        public function ExcluiExercicioTopico($idTopico, $idExercicio){
            $this->load->model('exercicio_model');
            $this->load->model('qme_model');
            $ra = $this->session->userdata('ra');

            if(is_null($idExercicio)) {
                $this->session->set_flashdata('error', 'Não foi possível excluir o exercício.');
                $this->EditaTopico($idTopico);
            }else{
                $excluiQME = $this->qme_model->ExcluirQME($idExercicio);
                if($excluiQME){
                    $excluiExercicio = $this->exercicio_model->ExcluirExercicio($idExercicio);
                    if ($excluiExercicio){
                        $this->session->set_flashdata('success', 'Exercício excluído com sucesso.');
                        $this->EditaTopico($idTopico);
                    }else{
                        $this->session->set_flashdata('error', 'Não foi possível excluir o exercício.');
                        $this->EditaTopico($idTopico);
                    }
                }else{
                    $this->session->set_flashdata('error', 'Não foi possível excluir o exercício.');
                    $this->EditaTopico($idTopico);
                }
            }
        }

        public function EditaExercicio($idExercicio){
            $this->load->model('exercicio_model');
            $this->load->model('qme_model');

            $data['exercicio'] = $this->exercicio_model->GetById($idExercicio);
            $data['alternativas'] = $this->qme_model->GetByIdExercicio($idExercicio);

            $data['nome'] = $this->session->userdata('nome');
            $data['ra'] = $this->session->userdata('ra');
            $data['title'] = "Projeto TFG - Edita Exercício";
            $data['header'] = "Edita Exercício";

            /** Carrega a view */
            $this->load->view('commons/header',$data);
            $this->load->view('exercicio/editaexercicio_view');
            $this->load->view('commons/footer');

        }

        public function AtualizaExercicio($idExercicio, $idTopico){

            $this->load->model('exercicio_model');
            $this->load->model('qme_model');
            $validacao = self::Validar('exercicio');

            $id = $idExercicio;

            if($validacao) {
                $exercicio = $this->input->post('exercicio');
                $bloom = $this->input->post('bloom');
                $tipo_exercicio = $this->input->post('tipo_exercicio');
                $opcaoa = $this->input->post('opcaoa');
                $opcaob = $this->input->post('opcaob');
                $opcaoc = $this->input->post('opcaoc');
                $opcaod = $this->input->post('opcaod');
                $opcaoe = $this->input->post('opcaoe');
                $resposta_certa = $this->input->post('opcao_correta');
                $dados_exercicio = array(
                    'Pergunta' => $exercicio,
                    'Categoria_Bloom' => $bloom,
                    'Tipo_Exercicio' => $tipo_exercicio,
                );

                $status = $this->exercicio_model->AtualizaExercicio($idExercicio, $dados_exercicio);

                if(!$status){
                    $this->session->set_flashdata('error', 'Não foi possível atualizar o Exercício.');
                    self::EditaTopico($idTopico);
                }else{
                    $dados_resposta = array(
                        'itemA' => $opcaoa,
                        'itemB' => $opcaob,
                        'itemC' => $opcaoc,
                        'itemD' => $opcaod,
                        'itemE' => $opcaoe,
                        'Alternativa' => $resposta_certa,
                    );
                }
                $status2 = $this->qme_model->AtualizaQME($idExercicio, $dados_resposta);
                if (!$status2) {
                    $this->session->set_flashdata('error', 'Não foi possível atualizar o Exercício.');
                    self::EditaExercicio($idExercicio);
                } else {
                    $this->session->set_flashdata('success', 'Exercício atualizado com sucesso.');
                    self::EditaTopico($idTopico);
                }
            }else{
                self::EditaExercicio($idExercicio);
            }
        }

        /** Função para Validar Operações */

        public function Validar($operacao)
        {
            if($operacao == 'usuario') {
                $this->form_validation->set_rules('ra', 'RA', 'required|is_unique[Usuario.RA]');
                $this->form_validation->set_rules('nome', 'Nome', 'required');
                $this->form_validation->set_rules('senha', 'Senha', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required');
                $this->form_validation->set_rules('confirmar_email', 'Confirmar Email', 'required|matches[email]');
                $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            }elseif ($operacao == 'edita_usuario'){
                $this->form_validation->set_rules('nome', 'Nome', 'required');
                $this->form_validation->set_rules('senha', 'Senha', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required');
                $this->form_validation->set_rules('confirmar_email', 'Confirmar Email', 'required|matches[email]');
                $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            }elseif ($operacao == 'curso') {
                $this->form_validation->set_rules('pin', 'PIN', 'required');
                $this->form_validation->set_rules('nome', 'Nome', 'required');
                $this->form_validation->set_rules('ano', 'Ano', 'required');
                $this->form_validation->set_rules('periodo', 'Periodo', 'required');
                $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            }elseif ($operacao == 'edita_curso'){
                $this->form_validation->set_rules('nome', 'Nome', 'required');
                $this->form_validation->set_rules('ano', 'Ano', 'required');
                $this->form_validation->set_rules('periodo', 'Periodo', 'required');
                $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            }elseif ($operacao == 'topico'){
                $this->form_validation->set_rules('nome', 'Nome', 'required');
                $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            }elseif ($operacao == 'exercicio'){
                $this->form_validation->set_rules('exercicio', 'Pergunta', 'required');
                $this->form_validation->set_rules('bloom', 'Categoria de Bloom', 'required');
                $this->form_validation->set_rules('tipo_exercicio', 'Tipo de Exercício', 'required');
                $this->form_validation->set_rules('opcaoa', 'Alternativa A', 'required');
                $this->form_validation->set_rules('opcaob', 'Alternativa B', 'required');
                $this->form_validation->set_rules('opcaoc', 'Alternativa C', 'required');
                $this->form_validation->set_rules('opcaod', 'Alternativa D', 'required');
                $this->form_validation->set_rules('opcaoe', 'Alternativa E', 'required');
                $this->form_validation->set_rules('opcao_correta', 'Alternatia Correta', 'required');
                $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            }

            return $this->form_validation->run();
        }

        public function teste($ra){

            $data['ra'] = $ra;
            $this->load->view('teste_view',$data);
        }

    }

?>