<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_has_curso_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'Usuario_has_Curso';
    }

    public function BuscaCursoCadastrado($ra, $pin)
    {
        if(is_null($pin))
            return false;
        $this->db->select('Usuario_RA');
        $this->db->where('Curso_PIN', $pin);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            $professores = $query->result_array();
            foreach ($professores as $ok){
                if ($ok['Usuario_RA'] == $ra) {
                    return false;
                }else{
                    return true;
                }
            }
        } else {
            return true;
        }
    }

    public function QuantidadeCursosUsuario($ra)
    {
        if(is_null($ra))
            return false;

        $this->db->select('Curso_PIN');
        $this->db->where('Usuario_RA', $ra);
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    public function CursosUsuario($ra)
    {
        if(is_null($ra))
            return false;
        $this->db->select('Curso_PIN');
        $this->db->where('Usuario_RA', $ra);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function UsuariosCurso($pin)
    {
        if(is_null($pin))
            return false;
        $this->db->select('Usuario_RA');
        $this->db->where('Curso_PIN', $pin);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function ExcluirCursoCadastrado($pin, $ra){
        if(is_null($pin))
            return false;
        $this->db->where('Curso_PIN', $pin);
        $this->db->where('Usuario_RA', $ra);
        return $this->db->delete($this->table);
    }
}