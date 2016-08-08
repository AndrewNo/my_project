<?php

class CategoriesController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Category();
    }

    public function view()
    {
        $params = App::getRouter()->getParams(); //получаем алиас страницы тобишь ссылку на нее

        if (isset($params[0])) { //проверяем задан ли первый параметр если да, то алиасом будет его значение в нижнем регистре

            $alias = strtolower($params[0]);
            $this->data['products'] = $this->model->getProductsByCategoryAlias($alias);
            $this->data['category'] = $this->model->getCategoryByAlias($alias);
        }

        $this->data['categories'] = $this->model->getCategoryList();
    }
}