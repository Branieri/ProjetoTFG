<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class Admin extends MY_Controller
    {
        public function HomeAdmin()
        {
            $data['title'] = "Projeto TFG - Home";
            $this->load->view('commons/header',$data);
            $this->load->view('home_admin');
            $this->load->view('commons/footer');
        }


        public function CadUsuario()
        {
            $data['title'] = "Projeto TFG - Usuários";
            $this->load->model('usuarios_model');
            $data['usuarios'] = $this->usuarios_model->GetAll('Nome');
            $this->load->view('commons/header',$data);
            $this->load->view('cadusuario');
            $this->load->view('commons/footer');
        }

    }

?>