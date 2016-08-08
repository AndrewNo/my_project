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
}