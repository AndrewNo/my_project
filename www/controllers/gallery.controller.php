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

    public function admin_index()
    {


    }

    public function admin_delete()
    {

        if (isset($_POST['delete_photo'])) {
            foreach ($_POST['delete_photo'] as $photo) {
                unlink($photo);
            }
        }
        Router::redirect('/admin/gallery/');
    }

    public function admin_add()
    {

        if ($_FILES) {
            /*$types = array('image/gif', 'image/png', 'image/jpeg');
            $files_type = array();
            foreach ($_FILES['add_photo']['type'] as $type) {
                $files_type = $type;
            }

            if (!in_array($files_type, $types)) {
                die ("Формат файла не поддерживается. Допустимые форматы: .jpg, .png, .gif");
            }*/


            foreach (($_FILES['add_photo']['tmp_name']) as $tmp_file) {

                if (file_exists('uploads' . DS . 'gallery' . DS . rand(1, 5000) . '.jpg')) {
                    move_uploaded_file($tmp_file, 'uploads' . DS . 'gallery' . DS . rand(1, 5000) . '_' . rand(1, 5000) . '.jpg');
                } else {
                    move_uploaded_file($tmp_file, 'uploads' . DS . 'gallery' . DS . rand(1, 5000) . '.jpg');
                }

            }
            Router::redirect('/admin/gallery/');
        }



    }
}