<?php

namespace application\lib;

use PDO;

class Db
{
    protected $db;

    public function __construct()
    {
        $config = require 'application/config/db.php';
        extract($config);
        
        $this->db = new PDO('mysql:host=' . $host . ';dbname=' . $dbname . '', $user, $password);
    }

    public function query($sql, $params = [])
    {
        if (!empty($params)) {
            $sth = $this->db->prepare($sql);
            foreach ($params as $key => $value) {
                $sth->bindValue(':' . $key, $value);
            }
            $sth->execute();
        } else {
            $sth = $this->db->query($sql);
        }

        return $sth;
    }

    public function row($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function column($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }
}
