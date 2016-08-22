<?php

class Orders extends Model
{
    public function getCategoryList($status = false)
    {
        $sql = "select * from category WHERE 1";
        if ($status) {
            $sql .= " and status = 1 order by sort_order ASC";
        }
        return $this->db->query($sql);
    }

    public function getById($id)
    {
        $id = (int)$id;
        $sql = "select * from product where id = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }


    public function save($data)
    {
        if (!isset($data['name']) || !isset($data['product_id']) || !isset($data['phone']) || !isset($data['email']) || !isset($data['city'])) {
            return false;
        }

        $name = $this->db->escape($data['name']);
        $product_id = (int)$data['product_id'];
        $phone = $this->db->escape($data['phone']);
        $email = $this->db->escape($data['email']);
        $city = $this->db->escape($data['city']);
        $message = $this->db->escape($data['message']);

        $sql = "insert into orders
                    set `name` = '{$name}',
                        product_id = {$product_id},
                        phone = '{$phone}',
                        email = '{$email}',
                        city = '{$city}',
                        message = '{$message}'";

        return $this->db->query($sql);

    }

    public function getOrderList()
    {
        $sql = "select orders.id, orders.name, orders.phone, orders.email, orders.city, orders.message, orders.dt,
                product.id as product_id, product.name as product_name
                from orders
                INNER JOIN product on orders.product_id = product.id
                WHERE orders.is_active = 1
                order by orders.dt DESC";
        return $this->db->query($sql);
    }

    public function done($data)
    {
        if (!isset($data['is_active'])) {
            return false;
        }

        $id = (int)$data['id'];
        $is_active = (int)$data['is_active'];

        $sql = "update orders
                    set is_active = {$is_active}
                    where id = {$id}";

        return $this->db->query($sql);
    }

    public function getOrderArchiveList()
    {
        $sql = "select orders.id, orders.name, orders.phone, orders.email, orders.city, orders.message, orders.dt, orders.is_active,
                product.id as product_id, product.name as product_name
                from orders
                INNER JOIN product on orders.product_id = product.id
                WHERE orders.is_active = 0
                order by orders.dt DESC";
        return $this->db->query($sql);
    }

    public function getOrderWorkList()
    {
        $sql = "select orders.id, orders.name, orders.phone, orders.email, orders.city, orders.message, orders.dt, orders.is_active,
                product.id as product_id, product.name as product_name
                from orders
                INNER JOIN product on orders.product_id = product.id
                WHERE orders.is_active = 2
                order by orders.dt DESC";
        return $this->db->query($sql);
    }
}


