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
            $this->load->view('login');
        } else {
            if ($query) {
                $data = array(
                    'ra' => $this->input->post('ra'),
                    'logged' => true
                );
                $this->session->set_userdata($data);
                redirect('home_admin');
            } else {
                redirect($this->index());
            }

        }
    }

    public function logout()
    {
        $data['logged'] = false;
        $this->session->set_userdata($data);
        redirect($this->index());
    }
}
