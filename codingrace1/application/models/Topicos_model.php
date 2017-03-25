<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Topicos_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'Topico';
    }

    function GetById($id) {
        if(is_null($id))
            return false;
        $this->db->where('idTopico', $id);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return null;
        }
    }

    function GetBySomeId($id){
        if(is_null($id))
            return false;

        $ids = array();

        foreach ($id as $dados) {
            $ids[] = $dados['Topico_idTopico'];
        }

        $this->db->where_in('idTopico', $ids);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    function AtualizaTopico($id, $data) {
        if(is_null($id) || !isset($data))
            return false;
        $this->db->where('idTopico', $id);
        return $this->db->update($this->table, $data);
    }

    function ExcluirTopico($id) {
        if(is_null($id))
            return false;
        $this->db->where('idTopico', $id);
        return $this->db->delete($this->table);
    }
}