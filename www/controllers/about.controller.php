<?php

class AboutController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new About_page();

    }

    public function index()
    {

    }
}

