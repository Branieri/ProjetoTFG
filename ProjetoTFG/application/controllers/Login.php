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
        $this->load->library('form_validation');
        $this->form_validation->set_rules('ra', 'RA', 'required');
        $this->form_validation->set_rules('senha', 'Senha', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        $this->load->model('usuarios_model');
        $ra = $this->input->post('ra');
        $senha = $this->input->post('senha');
        $query = $this->usuarios_model->Login($ra, $senha);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login_view');
        } else {
            foreach ($query as $row) :
                $nome = $row['Nome'];
            endforeach;
            if ($query) {
                $data = array(
                    'nome' => $nome,
                    'logged' => true
                );
                $this->session->set_userdata($data);
                redirect('homeadmin_view');
            } else {
                redirect($this->index());
            }
        }

    }
    public function logout()
    {
        $this->session->set_userdata('logged', false);
        redirect($this->index());
    }
}
