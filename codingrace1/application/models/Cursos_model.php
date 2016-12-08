<?php

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
}