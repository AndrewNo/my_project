<?php

class Shop_page extends Model
{
    public function getCategoryList($status = false)
    {
        $sql = "select * from category WHERE 1";
        if ($status) {
            $sql .= " and status = 1 order by sort_order ASC";
        }
        return $this->db->query($sql);
    }

    public function getProductList()
    {
        $sql = "select * from product where status = 1 ORDER by id DESC";
        return $this->db->query($sql);
    }

    public function getById($id)
    {
        $id = (int)$id;
        $sql = "select * from product where id = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }


    public function save($data, $id = null)
    {
        if (!isset($data['name']) || !isset($data['category_alias']) || !isset($data['availability']) || !isset($data['description']) || !isset($data['availability'])) {
            return false;
        }

        $id = (int)$id;
        $name = $this->db->escape($data['name']);
        $category_alias = $this->db->escape($data['category_alias']);
        $description = $this->db->escape($data['description']);
        $availability = (int)$data['availability'];
        $is_new = isset($data['is_new']) ? 1 : 0;
        $status = isset($data['status']) ? 1 : 0;

        if (!$id) {
            $sql = "insert into product
                    set `name` = '{$name}',
                        category_alias = '{$category_alias}',
                        description = '{$description}',
                        availability = {$availability},
                        is_new = {$is_new},
                        status = {$status}
            ";
        } else {
            $sql = "update product
                    set `name` = '{$name}',
                        category_alias = '{$category_alias}',
                        description = '{$description}',
                        availability = {$availability},
                        is_new = {$is_new},
                        status = {$status}
                    where id = {$id}
            ";
        }

        return $this->db->query($sql);

    }
    public function delete($id)
    {
        $id = (int)$id;
        $sql = "delete from product where id = {$id}";
        return $this->db->query($sql);
    }

    public function nextId(){
        return $this->db->insertId();
    }
}