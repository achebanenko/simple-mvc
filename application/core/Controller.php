<?php

namespace application\core;

abstract class Controller
{
    public $route;
    public $view;
    public $acl;

    public function __construct($route)
    {
        $this->route = $route;

        if (!$this->checkAcl()) {
            View::errorCode(403);
        }

        $this->view = new View($route);

        // if (method_exists($this, 'before')) {
        //     $this->before();
        // }

        $this->model = $this->loadModel($route['controller']);
    }

    public function loadModel($name)
    {
        $class = 'application\models\\' . ucfirst($name);
        if (class_exists($class)) {
            return new $class;
        }
    }

    public function redirect($url)
    {
        header('location: ' . $url);
        exit;
    }

    public function checkAcl()
    {
        $file = 'application/acl/' . $this->route['controller'] . '.php';
        if (file_exists($file)) {
            $this->acl = require $file;
            if ($this->isAcl('all')) {
                return true;
            } elseif (isset($_SESSION['auth']['id']) and $this->isAcl('auth')) {
                return true;
            } elseif (!isset($_SESSION['auth']['id']) and $this->isAcl('guest')) {
                return true;
            } elseif (isset($_SESSION['admin']) and $this->isAcl('admin')) {
                return true;
            }
            return false;
        }
        return true;
    }

    public function isAcl($key)
    {
        return in_array($this->route['action'], $this->acl[$key]);
    }
}
