<?php

class Store_page extends Model
{
    public function getProductList()
    {
        $sql = "select * from product where status = 0 ORDER by id DESC";
        return $this->db->query($sql);
    }
}