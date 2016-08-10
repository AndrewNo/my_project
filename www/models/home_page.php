<?php

class Home_page extends Model
{
    public function getList()
    {
        $sql = "select *from pages";
        return $this->db->query($sql);
    }


}