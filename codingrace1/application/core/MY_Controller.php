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

        foreach ($usuario as $item) {
            $data['nome'] = $item['Nome'];
            $data['tipo_usuario'] = $item['Tipo_Usuario'];
        }
        if ($data['tipo_usuario'] == 0){
            $this->load->model('cursos_model');
            $data['quantidadecursos'] = $this->cursos_model->QuantidadeCursos();
        }else{
            $this->load->model('usuario_has_curso_model');
            $data['quantidadecursos'] = $this->usuario_has_curso_model->QuantidadeCursosUsuario($ra);
        }
        $this->session->set_userdata($data);

        $this->usuarios_model->logged();
    }
}