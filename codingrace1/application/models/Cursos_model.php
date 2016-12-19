<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cursos_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'Curso';
    }

    function GetByPIN($pin) {
        if(is_null($pin))
            return false;
        $this->db->where('PIN', $pin);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return null;
        }
    }

    function QuantidadeCursos() {
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    function AtualizaCurso($pin, $data) {
        if(is_null($pin) || !isset($data))
            return false;
        $this->db->where('PIN', $pin);
        return $this->db->update($this->table, $data);
    }

    function ExcluirCurso($pin) {
        if(is_null($pin))
            return false;
        $this->db->where('PIN', $pin);
        return $this->db->delete($this->table);
    }

    function GetBySomePIN($pin){
        if(is_null($pin))
            return false;

        $pins = array();
        foreach ($pin as $dados) {
            $pins[] = $dados['Curso_PIN'];
        }

        $this->db->where_in('PIN', $pins);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }
}