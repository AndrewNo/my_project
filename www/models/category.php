<?php

class Category extends Model
{
    public function getCategoryList($status = false)
    {
        $sql = "select * from category WHERE 1";
        if ($status) {
            $sql .= " and status = 1 order by sort_order ASC";
        }
        return $this->db->query($sql);
    }

    public function getCategoryByAlias($alias)
    {
        $alias = $this->db->escape($alias);
        $sql = "select * from category where alias = '{$alias}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    public function getProductsByCategoryAlias($alias)
    {
        $alias = $this->db->escape($alias);
        $sql = "select * from product where category_alias = '{$alias}' limit 1";
        $result = $this->db->query($sql);
        return isset($result) ? $result : null;
    }
}