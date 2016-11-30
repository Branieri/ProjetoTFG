<?php

if(!defined('BASEPATH')) exit('No direct script acces allowed');

/**
 * Created by PhpStorm.
 * User: ranieri
 * Date: 23/11/16
 * Time: 13:41
 */
class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('javascript');
        $this->load->library('email');
        $this->load->library('session');

        $this->load->model('usuarios_model');
        $this->usuarios_model->logged();
    }
}