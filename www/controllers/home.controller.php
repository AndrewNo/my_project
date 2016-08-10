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

    }

    public function admin_index()
    {

    }



}