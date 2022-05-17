<?php

namespace application\controllers;

use application\core\Controller;

class AccountController extends Controller
{
    // public function before()
    // {
    //     $this->view->layout = 'custom';
    // }

    public function loginAction()
    {
        if (!empty($_POST)) {
            $this->view->redirect('/simple-mvc');
            $this->view->message('success', '123');
        }
        $this->view->render('Sign in');
    }
    
    public function registerAction()
    {
        // $this->view->path = 'test/test';
        // $this->view->layout = 'custom';

        $this->view->render('Sign up');
    }
}
