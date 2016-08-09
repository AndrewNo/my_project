<?php

class StoreController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Store_page();
    }

    public function admin_index(){
        $this->data['products'] = $this->model->getProductList();
    }
}
