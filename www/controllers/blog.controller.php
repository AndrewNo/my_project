<?php

class BlogController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Blog_page();
    }

    public function index()
    {
        $this->data['posts'] = $this->model->getPosts();
    }

    public function view()
    {
        $params = App::getRouter()->getParams(); //получаем алиас страницы тобишь ссылку на нее

        if (isset($params[0])) { //проверяем задан ли первый параметр если да, то алиасом будет его значение в нижнем регистре
            $id = (int)$params[0];
            $this->data['post'] = $this->model->getById($id);
        }
    }

    public function admin_index()
    {
        $this->data['posts'] = $this->model->getPosts();
    }

    public function admin_add()
    {
        if ($_POST) {
            $result = $this->model->save($_POST);
            if ($result) {
                Session::setFlashMessage('Страница сохранена');
            } else {
                Session::setFlashMessage('Не удалось сохранить страницу');
            }
            Router::redirect('/admin/home/');
        }
    }
}