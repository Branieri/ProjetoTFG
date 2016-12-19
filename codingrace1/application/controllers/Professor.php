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
        $data['quantidade_cursos'] = $this->session->userdata('quantidadecursos');
        $data['title'] = "Projeto TFG - Home";
        $this->load->view('commons/header',$data);
        $this->load->view('homeprofessor_view');
        $this->load->view('commons/footer');
    }

    /** Funções CRUD para Usuários */

    public function Usuarios()
    {
        /** Carrega funções de busca do BD */
        $this->load->model('usuarios_model');

        /** Variável com dados para serem passadas para a view */
        $data['nome'] = $this->session->userdata('nome');
        $data['quantidade_cursos'] = $this->session->userdata('quantidadecursos');
        $data['title'] = "Projeto TFG - Usuários";

        // Retorna todos os usuários do BD
        $data['usuarios'] = $this->usuarios_model->GetAll('Nome');

        /** Carrega a view */
        $this->load->view('commons/header',$data);
        $this->load->view('usuario/usuarios_view');
        $this->load->view('commons/footer');
    }


    /** Funções CRUD para Cursos */

    public function Cursos(){
        /** Carrega funções de busca do BD */
        $this->load->model('cursos_model');

        /** Variável com dados para serem passadas para a view */
        $data['nome'] = $this->session->userdata('nome');
        $data['title'] = "Projeto TFG - Cursos";
        $data['quantidade_cursos'] = $this->session->userdata('quantidadecursos');

        // Retorna todos os cursos do BD
        $data['cursos'] = $this->cursos_model->GetAll('PIN');

        /** Carrega a view */
        $this->load->view('commons/header',$data);
        $this->load->view('curso/cursos_view');
        $this->load->view('commons/footer');
    }

    public function AtualizaCurso(){
        $this->load->model('cursos_model');
        $validacao = self::Validar('editar_curso');
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

        if(is_null($pin))
            redirect('cursoscadastrados_professor');

        $data['curso'] = $this->cursos_model->GetByPIN($pin);

        $data['nome'] = $this->session->userdata('nome');
        $data['quantidade_cursos'] = $this->session->userdata('quantidadecursos');
        $data['title'] = "Projeto TFG - Edita Curso";

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
        $data['quantidade_cursos'] = $this->session->userdata('quantidadecursos');
        $data['title'] = "Projeto TFG - Minhas Disciplinas";

        $pin = $this->usuario_has_curso_model->CursosUsuario($ra);
        $data['cursos'] = $this->cursos_model->GetBySomePIN($pin);

        $this->load->view('commons/header',$data);
        $this->load->view('curso/cursos_view');
        $this->load->view('commons/footer');
    }

    public function CadCursoUsuario($pin){
        $this->load->model('usuario_has_curso_model');
        $ra = $this->session->userdata('ra');

        $dados_curso_cadastrado = array(
            'Usuario_RA' => $ra,
            'Curso_PIN' => $pin,
        );

        $validacurso = $this->usuario_has_curso_model->BuscaCursoCadastrado($ra, $pin);

        if ($validacurso){
            $status = $this->usuario_has_curso_model->Inserir($dados_curso_cadastrado);
            if(!$status)
            {
                $this->session->set_flashdata('error', 'Não foi possível cadastrar o curso!');
                redirect('cursos_professor');
            }else{
                $this->session->set_flashdata('success', 'Curso cadastrado com sucesso!');
                redirect('cursoscadastrados_professor');
            }
        }else{
            $this->session->set_flashdata('error', 'Curso já cadastrado para esse Usuário!');
            redirect('cursos_professor');
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
        $data['quantidade_cursos'] = $this->session->userdata('quantidadecursos');
        $data['title'] = "Projeto TFG - Tópicos";

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
        $validacao = self::Validar('novo_topico');

        if ($validacao){
            $nome = $this->input->post('nome');
            $dados_topico = array(
                'Nome' => $nome,
            );
            $status = $this->topicos_model->Inserir($dados_topico);
            if(!$status)
            {
                $this->session->set_flashdata('error', 'Não foi possível inserir o tópico!');
                $data['nome'] = $this->session->userdata('nome');
                $data['quantidade_cursos'] = $this->session->userdata('quantidadecursos');
                $data['title'] = "Projeto TFG - Novo Tópico";

                /** Carrega a view */
                $this->load->view('commons/header',$data);
                $this->load->view('topico/novotopico_view');
                $this->load->view('commons/footer');
            }else{
                $this->session->set_flashdata('success', 'Tópico inserido com sucesso!');
                redirect('topicos_admin');
            }
        }
        $data['nome'] = $this->session->userdata('nome');
        $data['quantidade_cursos'] = $this->session->userdata('quantidadecursos');
        $data['title'] = "Projeto TFG - Novo Tópico";

        /** Carrega a view */
        $this->load->view('commons/header',$data);
        $this->load->view('topico/novotopico_view');
        $this->load->view('commons/footer');
    }

    public function AtualizaTopico()
    {
        $this->load->model('topicos_model');
        $validacao = self::Validar('editar_topico');
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

        $this->load->model('topicos_model');

        if(is_null($id))
            redirect('topicos_admin');

        $data['topico'] = $this->topicos_model->GetById($id);

        $data['nome'] = $this->session->userdata('nome');
        $data['quantidade_cursos'] = $this->session->userdata('quantidadecursos');
        $data['title'] = "Projeto TFG - Edita Tópico";

        /** Carrega a view */
        $this->load->view('commons/header',$data);
        $this->load->view('topico/editartopico_view');
        $this->load->view('commons/footer');

    }

    public function Validar($operacao)
    {
        if($operacao == 'novo_usuario') {
            $this->form_validation->set_rules('ra', 'RA', 'required|is_unique[Usuario.RA]');
            $this->form_validation->set_rules('nome', 'Nome', 'required');
            $this->form_validation->set_rules('senha', 'Senha', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('confirmar_email', 'Confirmar Email', 'required|matches[email]');
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        }elseif ($operacao == 'editar_usuario'){
            $this->form_validation->set_rules('ra', 'RA', 'required');
            $this->form_validation->set_rules('nome', 'Nome', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('confirmar_email', 'Confirmar Email', 'required|matches[email]');
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        }elseif ($operacao == 'novo_curso'){
            $this->form_validation->set_rules('pin', 'PIN', 'required|is_unique[Curso.PIN]');
            $this->form_validation->set_rules('nome', 'Nome', 'required');
            $this->form_validation->set_rules('ano', 'Ano', 'required');
            $this->form_validation->set_rules('periodo', 'Periodo', 'required');
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        }elseif ($operacao == 'editar_curso'){
            $this->form_validation->set_rules('pin', 'PIN', 'required');
            $this->form_validation->set_rules('nome', 'Nome', 'required');
            $this->form_validation->set_rules('ano', 'Ano', 'required');
            $this->form_validation->set_rules('periodo', 'Periodo', 'required');
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        }elseif ($operacao == 'novo_topico'){
            $this->form_validation->set_rules('nome', 'Nome', 'required');
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        }elseif ($operacao == 'editar_topico'){
            $this->form_validation->set_rules('nome', 'Nome', 'required');
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        }

        return $this->form_validation->run();
    }

    public function teste($teste){

        $data['teste'] = $teste;
        $this->load->view('teste_view',$data);
    }


}