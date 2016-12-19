<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aluno extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $usuario = $this->session->userdata('tipo_usuario');
        if($usuario == 0 || $usuario == null){
            echo 'Você não tem permissão para entrar nessa página';
            die();
        }elseif ($usuario == 1 || $usuario == null){
            echo 'Você não tem permissão para entrar nessa página';
            die();
        }
    }

    public function HomeAluno()
    {
        $data['nome'] = $this->session->userdata('nome');
        $data['quantidade_cursos'] = $this->session->userdata('quantidadecursos');
        $data['title'] = "Projeto TFG - Home";
        $this->load->view('commons/header',$data);
        $this->load->view('homealuno_view');
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
                redirect('cursos_aluno');
            }else{
                $this->session->set_flashdata('success', 'Curso cadastrado com sucesso!');
                redirect('cursoscadastrados_aluno');
            }
        }else{
            $this->session->set_flashdata('error', 'Curso já cadastrado para esse Usuário!');
            redirect('cursos_aluno');
        }
    }

    public function ExcluiCursoUsuario($pin){
        $this->load->model('usuario_has_curso_model');
        $ra = $this->session->userdata('ra');

        if(is_null($pin)) {
            $this->session->set_flashdata('error', 'Não foi possível excluir o curso.');
            redirect('cursoscadastrados_aluno');
        }else{
            $data[''] = $this->usuario_has_curso_model->ExcluirCursoCadastrado($pin, $ra);
            $this->session->set_flashdata('success', 'Curso excluído com sucesso.');
            redirect('cursoscadastrados_aluno');
        }
    }


}