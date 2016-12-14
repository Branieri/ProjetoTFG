<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
            return $query->result_array();
        } else {
            return null;
        }
    }

    function GetByRA($ra) {
        if(is_null($ra))
            return false;
        $this->db->where('RA', $ra);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return null;
        }
    }

    function AtualizaUsuario($ra, $data) {
        if(is_null($ra) || !isset($data))
            return false;
        $this->db->where('RA', $ra);
        return $this->db->update($this->table, $data);
    }

    function ExcluirUsuario($ra) {
        if(is_null($ra))
            return false;
        $this->db->where('RA', $ra);
        return $this->db->delete($this->table);
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
