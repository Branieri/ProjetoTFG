<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class Admin extends MY_Controller
    {
        public function HomeAdmin()
        {
            $data['nome'] = $this->session->userdata('nome');
            $data['title'] = "Projeto TFG - Home";
            $this->load->view('commons/header',$data);
            $this->load->view('homeadmin_view');
            $this->load->view('commons/footer');
        }


        public function CadUsuario()
        {
            $data['nome'] = $this->session->userdata('nome');
            $data['title'] = "Projeto TFG - Usuários";
            $this->load->model('usuarios_model');
            $data['usuarios'] = $this->usuarios_model->GetAll('Nome');
            $this->load->view('commons/header',$data);
            $this->load->view('usuarios_view');
            $this->load->view('commons/footer');
        }

    }

?>