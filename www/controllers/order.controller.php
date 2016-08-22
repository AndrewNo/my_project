<?php

class OrderController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Orders();
    }

    public function get()
    {
        $params = App::getRouter()->getParams(); //получаем алиас страницы тобишь ссылку на нее

        if (isset($params[0])) { //проверяем задан ли первый параметр если да, то алиасом будет его значение в нижнем регистре
            $product_id = (int)$params[0];
            $this->data['product'] = $this->model->getById($product_id);
        }

        $this->data['categories'] = $this->model->getCategoryList();


        if ($_POST) {

            $result = $this->model->save($_POST);

            if ($result) {
                Session::setFlashMessage('Ваш заказ принят');
            } else {
                Session::setFlashMessage('Не удалось принять заказ');
            }
            Router::redirect('/shop/');
        }
    }

    public function admin_index()
    {
        $this->data['orders'] = $this->model->getOrderList();

        if ($_POST) {

            $result = $this->model->done($_POST);

            if ($result) {
                Session::setFlashMessage('Ваш заказ принят');
            } else {
                Session::setFlashMessage('Не удалось принять заказ');
            }
            Router::redirect('/admin/order/');
        }

    }

    public function admin_archive()
    {
        $this->data['orders'] = $this->model->getOrderArchiveList();
    }

    public function admin_inwork()
    {
        $this->data['orders'] = $this->model->getOrderWorkList();

        if ($_POST) {

            $result = $this->model->done($_POST);

            if ($result) {
                Session::setFlashMessage('Ваш заказ принят');
            } else {
                Session::setFlashMessage('Не удалось принять заказ');
            }
            Router::redirect('/admin/order/');
        }
    }
}