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
}