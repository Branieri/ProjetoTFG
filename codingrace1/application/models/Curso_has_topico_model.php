<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: ranieri
 * Date: 05/03/17
 * Time: 18:24
 */
class Curso_has_topico_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'Curso_has_Topico';
    }

    public function BuscaTopicoCadastrado($idTopico, $pin)
    {
        if(is_null($pin) || is_null($idTopico))
            return false;
        $this->db->select('Topico_idTopico');
        $this->db->where('Curso_PIN', $pin);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            $topicos = $query->result_array();
            foreach ($topicos as $ok){
                if ($ok['Topico_idTopico'] == $idTopico) {
                    return false;
                }else{
                    return true;
                }
            }
        } else {
            return true;
        }
    }

    public function TopicosCursos($pin)
    {
        if(is_null($pin))
            return false;
        $this->db->select('Topico_idTopico');
        $this->db->where('Curso_PIN', $pin);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function CursosTopicos($id)
    {
        if(is_null($id))
            return false;
        $this->db->select('Curso_PIN');
        $this->db->where('Topico_idTopico', $id);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function ExcluirTopicosCadastrado($pin, $id){
        if(is_null($pin) || is_null($id))
            return false;
        $this->db->where('Curso_PIN', $pin);
        $this->db->where('Topico_idTopico', $id);
        return $this->db->delete($this->table);
    }
}