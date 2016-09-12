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

        if ($_POST || $_FILES) {

            $result = $this->model->save($_POST);

            $id = $this->model->nextId();

            mkdir('uploads' . DS . $id . DS . 'thumbnails' . DS, 0777, true);

            if (!empty($_FILES['main_photo']['tmp_name'])) {
                $types = array('image/gif', 'image/png', 'image/jpeg');

                if (!in_array($_FILES['main_photo']['type'], $types)) {
                    Session::flash('error', 'Формат файла не поддерживается. Допустимые форматы: .jpg, .png, .gif');
                    Router::redirect($_SERVER['HTTP_REFERER']);
                    exit;

                }
                move_uploaded_file($_FILES['main_photo']['tmp_name'], 'uploads' . DS . $id . DS . 'main.jpg');
                copy('uploads' . DS . $id . DS . 'main.jpg', 'uploads' . DS . $id . DS . 'thumbnails' . DS . 'main.jpg');

                $image = new Image();
                $image->load('uploads' . DS . $id . DS . 'thumbnails' . DS . 'main.jpg');
                $image->resize(250, 250);
                $image->save('uploads' . DS . $id . DS . 'thumbnails' . DS . 'main.jpg');

            }

            if (!empty($_FILES['add_photo']['tmp_name'])) {


                $types = array('image/gif', 'image/png', 'image/jpeg');

                foreach ($_FILES['add_photo']['type'] as $type) {

                    if (!in_array($type, $types)) {
                        Session::flash('error', 'Формат файла не поддерживается. Допустимые форматы: .jpg, .png, .gif');
                        Router::redirect($_SERVER['HTTP_REFERER']);
                        exit;
                    }
                }

                $i = 0;
                foreach (($_FILES['add_photo']['tmp_name']) as $tmp_file) {
                    $i++;
                    move_uploaded_file($tmp_file, 'uploads' . DS . $id . DS . "{$i}" . '.jpg');
                }
            }

            if ($result) {
                Session::flash('success', 'Данные сохранены!');
                Router::redirect('/admin/shop/');
                exit;
            } else {
                Session::flash('error', 'Не удалось сохранить данные!');
            }
            Router::redirect('/admin/shop/');
        }


        $this->data['categories'] = $this->model->getCategoryList();
    }


    public function admin_edit()
    {

        if (isset($_POST['delete_photo'])) {
            foreach ($_POST['delete_photo'] as $photo) {
                unlink($photo);
            }
        }

        if ($_POST || $_FILES) {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $result = $this->model->save($_POST, $id);


            if (!empty($_FILES['main_photo']['tmp_name'])) {
                $types = array('image/gif', 'image/png', 'image/jpeg');

                if (!in_array($_FILES['main_photo']['type'], $types)) {
                    Session::flash('error', 'Формат файла не поддерживается. Допустимые форматы: .jpg, .png, .gif');
                    Router::redirect($_SERVER['HTTP_REFERER']);
                    exit;
                }
                move_uploaded_file($_FILES['main_photo']['tmp_name'], 'uploads' . DS . $id . DS . 'main.jpg');
                copy('uploads' . DS . $id . DS . 'main.jpg', 'uploads' . DS . $id . DS . 'thumbnails' . DS . 'main.jpg');

                $image = new Image();
                $image->load('uploads' . DS . $id . DS . 'thumbnails' . DS . 'main.jpg');
                $image->resize(250, 250);
                $image->save('uploads' . DS . $id . DS . 'thumbnails' . DS . 'main.jpg');
            }

            if (!empty($_FILES['add_photo']['tmp_name'][0])) {



                $types = array('image/gif', 'image/png', 'image/jpeg');

                foreach ($_FILES['add_photo']['type'] as $type) {

                    if (!in_array($type, $types)) {

                        Session::flash('error', 'Формат файла не поддерживается. Допустимые форматы: .jpg, .png, .gif');
                        Router::redirect($_SERVER['HTTP_REFERER']);
                        exit;

                    }
                }

                $i = 0;
                foreach (($_FILES['add_photo']['tmp_name']) as $tmp_file) {
                    $i++;
                    if (file_exists('uploads' . DS . $id . DS . "{$i}" . '.jpg')) {
                        move_uploaded_file($tmp_file, 'uploads' . DS . $id . DS . $i . '_' . $i . '.jpg');
                    } else {
                        move_uploaded_file($tmp_file, 'uploads' . DS . $id . DS . $i . '.jpg');
                    }
                }
            }

            if ($result) {
                Session::flash('success', 'Данные сохранены!');
                Router::redirect('/admin/shop/');
                exit;
            } else {
                Session::flash('error', 'Не удалось сохранить данные!');
            }
            Router::redirect('/admin/shop/');
        }

        if (isset($this->params[0])) {
            $this->data['product'] = $this->model->getById($this->params[0]);
        } else {
            Session::flash('error', 'Не правильный id страницы');
            header("location: /admin/shop/");
            exit;

        }

        $this->data['categories'] = $this->model->getCategoryList();

    }

    public function admin_delete()
    {
        if (isset($this->params[0])) {
            $result = $this->model->delete($this->params[0]);
            if ($result) {
                Session::flash('success', 'Товар удален');

            } else {
                Session::flash('error', 'Не удалось удалить товар');
            }

        }
        Router::redirect('/admin/shop/');
    }
}