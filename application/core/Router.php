<?php

namespace application\core;

class Router
{
    protected $routes = [];
    protected $params = [];

    public function __construct()
    {
        $routes = require 'application/config/routes.php';
        foreach ($routes as $key => $val) {
            $this->add($key, $val);
        }
    }

    public function add($route, $params)
    {
        $route = '#^'.$route.'$#';
        $this->routes[$route] = $params;
    }

    public function match()
    {
        $url = str_replace('/simple-mvc', '', $_SERVER['REQUEST_URI']);
        $url = trim($url, '/');

        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function run()
    {
        if ($this->match()) {
            $class = 'application\controllers\\' . ucfirst($this->params['controller']) . 'Controller';
            if (class_exists($class)) {
                $action = $this->params['action'] . 'Action';
                if (method_exists($class, $action)) {
                    $controller = new $class($this->params);
                    $controller->$action();
                } else {
                    // echo 'Not found ' . $action;
                    View::errorCode(404);
                }
            } else {
                // echo 'Not found ' . $class;
                View::errorCode(404);
            }
        } else {
            // echo 'Route not found';
            View::errorCode(500);
        }
    }
}
