<?php

namespace application\controllers;

use application\core\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        // $this->redirect('google');

        // $db = new Db;
        // $params = [
        //     'id' => 1,
        // ];
        // $data = $db->row('SELECT * FROM users WHERE id = :id', $params);
        // debug($data);

        $news = $this->model->getNews();

        $vars = [
            'news' => $news,
        ];
        
        $this->view->render('Index', $vars);
    }

    public function contactsAction()
    {
    }
}
