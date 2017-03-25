<?php

if(!defined('BASEPATH')) exit('No direct script acces allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('javascript');
        $this->load->library('email');

        $this->load->model('usuarios_model');
        $ra = $this->session->userdata('ra');
        $usuario = $this->usuarios_model->GetByRA($ra);

        $data['nome'] = $usuario['Nome'];

        $this->session->set_userdata($data);

        $this->usuarios_model->logged();
    }
}