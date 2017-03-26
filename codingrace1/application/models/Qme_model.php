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
}