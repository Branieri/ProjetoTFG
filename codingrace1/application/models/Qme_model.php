<?php

/**
 * Created by PhpStorm.
 * User: ranieri
 * Date: 19/03/17
 * Time: 18:37
 */
class QME_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'QME';
    }

    function ExcluirQME($idExercicio) {
        if(is_null($idExercicio))
            return false;
        $this->db->where('Exercicio_idExercicio', $idExercicio);
        return $this->db->delete($this->table);
    }

    function GetByIdExercicio($id) {
        if(is_null($id))
            return false;
        $this->db->where('Exercicio_idExercicio', $id);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return null;
        }
    }

    function AtualizaQME($id, $data) {
        if(is_null($id) || !isset($data))
            return false;
        $this->db->where('Exercicio_idExercicio', $id);
        return $this->db->update($this->table, $data);
    }
}