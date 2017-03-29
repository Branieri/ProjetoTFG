<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->model('usuarios_model');
        $validacao = self::Validar('login');

        if($validacao) {
            $ra = $this->input->post('ra');
            $senha = $this->input->post('senha');
            $data['ra'] = $ra;
            $query = $this->usuarios_model->Login($ra, $senha);
            if ($query) {
                foreach ($query as $item) {
                    $tipo_usuario = $item['Tipo_Usuario'];
                }
                $data['logged'] = true;
                $data['tipo_usuario'] = $tipo_usuario;
                $this->session->set_userdata($data);
                if ($tipo_usuario == 0) {
                    redirect('home_admin');
                } elseif ($tipo_usuario == 1) {
                    redirect('home_professor');
                } else {
                    redirect('home_aluno');
                }
            } else {
                $this->session->set_flashdata('usuario_naoencontrado', 'Usuário ou senha incorreto!');
                redirect('Login');
            }
        }else{
            $this->load->view('login_view');
        }
    }

    public function logout()
    {
        $this->session->set_userdata('logged', false);
        redirect($this->index());
    }

    public function NovoUsuario(){
        $this->load->model('usuarios_model');
        $validacao = self::Validar('novo_usuario');

        if ($validacao){
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
                'Tipo_Usuario' => 2
            );
            $status = $this->usuarios_model->Inserir($dados_usuario);
            if(!$status)
            {
                $this->session->set_flashdata('error', 'Não foi possível inserir o usuário!');
                $data['nome'] = $this->session->userdata('nome');
                $data['title'] = "Projeto TFG - Novo Usuário";
                $data['header'] = "Novo Usuário";

                /** Carrega a view */
                $this->load->view('commons/header',$data);
                $this->load->view('usuario/novousuario_view');
                $this->load->view('commons/footer');
            }else{
                $this->session->set_flashdata('success', 'Usuário inserido com sucesso!');
                $this->index();
            }
        }else{
            $data['nome'] = $this->session->userdata('nome');
            $data['title'] = "Projeto TFG - Novo Usuário";
            $data['header'] = "Novo Usuário";

            /** Carrega a view */
            $this->load->view('commons/header',$data);
            $this->load->view('usuario/novousuario_view');
            $this->load->view('commons/footer');
        }

    }

    public function Validar($operacao)
    {
        if ($operacao == 'novo_usuario') {
            $this->form_validation->set_rules('ra', 'RA', 'required|is_unique[Usuario.RA]');
            $this->form_validation->set_rules('nome', 'Nome', 'required');
            $this->form_validation->set_rules('senha', 'Senha', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('confirmar_email', 'Confirmar Email', 'required|matches[email]');
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        }
        elseif ($operacao == 'login'){
            $this->form_validation->set_rules('ra', 'RA', 'required');
            $this->form_validation->set_rules('senha', 'Senha', 'required');
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        }
        return $this->form_validation->run();
    }
}
