<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Professor extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $usuario = $this->session->userdata('tipo_usuario');
        if($usuario == 0 || $usuario == null){
            echo 'Você não tem permissão para entrar nessa página';
            die();
        }elseif ($usuario == 2 || $usuario == null){
            echo 'Você não tem permissão para entrar nessa página';
            die();
        }
    }

    public function HomeProfessor()
    {
        $data['nome'] = $this->session->userdata('nome');
        $data['ra'] = $this->session->userdata('ra');
        $data['title'] = "Projeto TFG - Home";
        $data['header'] = "Home";

        $this->load->view('commons/header',$data);
        $this->load->view('homeprofessor_view');
        $this->load->view('commons/footer');
    }

    /** Funções CRUD para Usuários */

    public function EditaUsuario($ra)
    {
        if($ra == $this->session->userdata('ra')){
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

        }else{
            echo 'Você não tem permissão para editar outro usuário';
            die();
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

            $dados_usuario = array(
                'Nome' => $nome,
                'Email' => $email,
            );

            $status = $this->usuarios_model->AtualizaUsuario($ra, $dados_usuario);

            if (!$status) {
                $this->session->set_flashdata('error', 'Não foi possível atualizar o usuário.');
                self::EditaUsuario($ra);
            } else {
                $this->session->set_flashdata('success', 'Usuário atualizado com sucesso.');
                redirect('home_professor');
            }
        }else{
            self::EditaUsuario($ra);
        }

    }


    /** Funções CRUD para Cursos */

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
            redirect('cursoscadastrados_professor');

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

    /** Funções CRUD cursos cadastrados */

    public function CursosUsuario(){
        $this->load->model('usuario_has_curso_model');
        $this->load->model('cursos_model');

        $ra = $this->session->userdata('ra');
        $data['nome'] = $this->session->userdata('nome');
        $data['ra'] = $this->session->userdata('ra');
        $data['title'] = "Projeto TFG - Minhas Disciplinas";
        $data['header'] = "Minhas Disciplinas";

        $pin = $this->usuario_has_curso_model->CursosUsuario($ra);
        $data['cursos'] = $this->cursos_model->GetBySomePIN($pin);

        $this->load->view('commons/header',$data);
        $this->load->view('curso/cursos_view');
        $this->load->view('commons/footer');
    }

    public function CadCursoUsuario(){
        $this->load->model('usuario_has_curso_model');
        $ra = $this->session->userdata('ra');
        $pin = $this->input->post('PIN');

        $dados_curso_cadastrado = array(
            'Usuario_RA' => $ra,
            'Curso_PIN' => $pin,
        );

        if(is_null($pin) || $pin == ""){
            echo "<script> window.alert('Favor inserir um curso')</script>";
            $this->CursosUsuario();
        }else {

            $validacurso = $this->usuario_has_curso_model->BuscaCursoCadastrado($ra, $pin);

            if ($validacurso) {
                $status = $this->usuario_has_curso_model->Inserir($dados_curso_cadastrado);
                if (!$status) {
                    $this->session->set_flashdata('error', 'Não foi possível cadastrar o curso!');
                    redirect('cursoscadastrados_professor');
                } else {
                    $this->session->set_flashdata('success', 'Curso cadastrado com sucesso!');
                    redirect('cursoscadastrados_professor');
                }
            } else {
                $this->session->set_flashdata('error', 'Curso já cadastrado para esse Usuário!');
                redirect('cursoscadastrados_professor');
            }
        }
    }

    public function ExcluiCursoUsuario($pin){
        $this->load->model('usuario_has_curso_model');
        $ra = $this->session->userdata('ra');

        if(is_null($pin)) {
            $this->session->set_flashdata('error', 'Não foi possível excluir o curso.');
            redirect('cursoscadastrados_professor');
        }else{
            $data[''] = $this->usuario_has_curso_model->ExcluirCursoCadastrado($pin, $ra);
            $this->session->set_flashdata('success', 'Curso excluído com sucesso.');
            redirect('cursoscadastrados_professor');
        }
    }

    /** Funções CRUD para Tópicos */

    public function Topicos()
    {
        /** Carrega funções de busca do BD */
        $this->load->model('topicos_model');

        /** Variável com dados para serem passadas para a view */
        $data['nome'] = $this->session->userdata('nome');
        $data['ra'] = $this->session->userdata('ra');
        $data['title'] = "Projeto TFG - Tópicos";
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
                redirect('topicos_professor');
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
                redirect('topicos_professor');
            }
        }else{
            self::EditaTopico($id);
        }

    }

    public function EditaTopico($idTopico)
    {
        $this->load->model('topicos_model');
        $this->load->model('exercicio_model');

        if(is_null($idTopico))
            redirect('topicos_professor');

        $data['topico'] = $this->topicos_model->GetById($idTopico);
        $data['exercicios'] = $this->exercicio_model->GetByTopico($idTopico);

        $data['nome'] = $this->session->userdata('nome');
        $data['ra'] = $this->session->userdata('ra');
        $data['title'] = "Projeto TFG - Edita Tópico";
        $data['header'] = "Edita Tópico";

        /** Carrega a view */
        $this->load->view('commons/header',$data);
        $this->load->view('topico/editartopico_view');
        $this->load->view('commons/footer');
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

    /** Função CRUD para exercícios */

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
                self::EditaTopico($idTopico);
            } else {
                $this->session->set_flashdata('success', 'Exercício atualizado com sucesso.');
                self::EditaTopico($idTopico);
            }
        }else{
            self::EditaTopico($idTopico);
        }
    }

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
        }elseif ($operacao == 'curso'){
            $this->form_validation->set_rules('pin', 'PIN', 'required|is_unique[Curso.PIN]');
            $this->form_validation->set_rules('nome', 'Nome', 'required');
            $this->form_validation->set_rules('ano', 'Ano', 'required');
            $this->form_validation->set_rules('periodo', 'Periodo', 'required');
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        }elseif ($operacao == "edita_curso"){
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

    public function teste($teste){

        $data['teste'] = $teste;
        $this->load->view('teste_view',$data);
    }


}