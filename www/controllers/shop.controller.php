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

}