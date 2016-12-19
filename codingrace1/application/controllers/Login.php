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
        $this->form_validation->set_rules('ra', 'RA', 'required');
        $this->form_validation->set_rules('senha', 'Senha', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        $this->load->model('usuarios_model');
        $ra = $this->input->post('ra');
        $senha = $this->input->post('senha');
        $data['ra'] = $ra;
        $this->session->set_userdata($data);
        $query = $this->usuarios_model->Login($ra, $senha);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login_view');
        } else {
            if ($query) {
                $this->session->set_userdata('logged', true);
                foreach ($query as $item) {
                    $tipo_usuario = $item['Tipo_Usuario'];
                }
                if ($tipo_usuario == 0) {
                    redirect('home_admin');
                } elseif ($tipo_usuario == 1) {
                    redirect('home_professor');
                } else {
                    redirect('home_aluno');
                }
            } else {
                $this->session->set_flashdata('usuario_naoencontrado', 'Usuário não encontrado!');
                redirect('Login');
            }
        }
    }

    public function logout()
    {
        $this->session->set_userdata('logged', false);
        redirect($this->index());
    }
}
