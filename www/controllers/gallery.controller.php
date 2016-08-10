<?php

class GalleryController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Gallery_page();
    }

    public function index()
    {

    }
}