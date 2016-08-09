<?php

class ShopController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Shop_page();
    }

    public function index()
    {
        $this->data['categories'] = $this->model->getCategoryList();
        $this->data['products'] = $this->model->getProductList();

    }

    public function view()
    {
        $params = App::getRouter()->getParams(); //получаем алиас страницы тобишь ссылку на нее

        if (isset($params[0])) { //проверяем задан ли первый параметр если да, то алиасом будет его значение в нижнем регистре
            $product_id = (int)$params[0];
            $this->data['product'] = $this->model->getById($product_id);
        }

        $this->data['categories'] = $this->model->getCategoryList();
    }

    public function admin_index()
    {
        $this->data['products'] = $this->model->getProductList();
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
            Router::redirect('/admin/shop/');
        }

        $this->data['categories'] = $this->model->getCategoryList();
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
            Router::redirect('/admin/shop/');
        }

        if (isset($this->params[0])) {
            $this->data['product'] = $this->model->getById($this->params[0]);
        } else {
            Session::setFlashMessage('Не правильный id страницы');
            Router::redirect('/admin/shop/');
        }

        $this->data['categories'] = $this->model->getCategoryList();

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
        Router::redirect('/admin/shop/');
    }
}