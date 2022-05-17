<?php

namespace application\models;

use application\core\Model;

class Main extends Model
{
    public function getNews()
    {
        $result = $this->db->row('SELECT id,title,description FROM news LIMIT 2');
        return $result;
    }
}
