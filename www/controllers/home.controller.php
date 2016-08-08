<?php

class HomeController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Home_page();
    }

    public function index()
    {
        $this->data['pages'] = $this->model->getList();
    }

    public function admin_index()
    {
        $this->data['pages'] = $this->model->getList();
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

    public function admin_edit()
    {
        if ($_POST) {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $result = $this->model->save($_POST, $id);
            if ($result) {
                Session::setFlashMessage('Страница сохранена');
            } else {
                Session::setFlashMessage('Не удалось сохранить страницу');
            }
            Router::redirect('/admin/home/');
        }

        if (isset($this->params[0])) {
            $this->data['page'] = $this->model->getById($this->params[0]);
        } else {
            Session::setFlashMessage('Не правильный id страницы');
            Router::redirect('/admin/home/');
        }

    }

    public function admin_delete()
    {
        if (isset($this->params[0])){
            $result = $this->model->delete($this->params[0]);
            if ($result) {
                Session::setFlashMessage('Страница удалена');
            } else {
                Session::setFlashMessage('Не удалось удалить страницу');
            }

        }
        Router::redirect('/admin/home/');
    }


}