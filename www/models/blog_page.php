<?php

class Blog_page extends Model
{
    public function getPosts($is_published = false)
    {
        $sql = "select * from post";
        if ($is_published) {
            $sql .= " and is_published = 1 order by dt DESC";
        }
        return $this->db->query($sql);
    }

    public function getById($id)
    {
        $id = (int)$id;
        $sql = "select * from post where id = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    public function save($data, $id = null)
    {
        if (!isset($data['alias']) || !isset($data['title']) || !isset($data['content'])) {
            return false;
        }

        $id = (int)$id;
        $alias = $this->db->escape($data['alias']);
        $title = $this->db->escape($data['title']);
        $content = $this->db->escape($data['content']);
        $is_published = isset($data['is_published']) ? 1 : 0;

        if (!$id) {
            $sql = "insert into post
                    set alias = '{$alias}',
                        title = '{$title}',
                        content = '{$content}',
                        is_published = {$is_published}
            ";
        } else {
            $sql = "update post
                    set alias = '{$alias}',
                        title = '{$title}',
                        content = '{$content}',
                        is_published = {$is_published}
                    where id = {$id}
            ";
        }

        return $this->db->query($sql);

    }
}