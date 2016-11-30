<?php

class Usuarios_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->table = 'Usuario';
    }

    public function Login($ra, $senha)
    {
        $this->db->where('RA', $ra);
        $this->db->where('Senha', $senha);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return null;
        }
    }

    public function logged()
    {
        $logged = $this->session->userdata('logged');
        if(!isset($logged) || $logged == null)
        {
            echo 'Você não tem permissão para entrar nessa página';
            die();
        }
    }

}
