<?php

class Blog_page extends Model
{
    public function getPosts()
    {
        $sql = "select * from post where `is_published` = 1 order by `dt` DESC";
        return $this->db->query($sql);
    }

    public function getDraftPosts()
    {
        $sql = "select * from post where `is_published` = 0 order by `dt` DESC";
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
        if (!isset($data['title']) || !isset($data['content'])) {
            return false;
        }

        $id = (int)$id;
        $title = $this->db->escape($data['title']);
        $content = $this->db->escape($data['content']);
        $short_content = substr($content, 0, 150);
        $is_published = isset($data['is_published']) ? 1 : 0;

        if (!$id) {
            $sql = "insert into post
                    set title = '{$title}',
                        short_content = '{$short_content}',
                        content = '{$content}',
                        is_published = {$is_published}
            ";
        } else {
            $sql = "update post
                    set title = '{$title}',
                        short_content = '{$short_content}',
                        content = '{$content}',
                        is_published = {$is_published}
                    where id = {$id}
            ";
        }

        return $this->db->query($sql);

    }

    public function delete($id)
    {
        $id = (int)$id;
        $sql = "delete from post where id = {$id}";
        return $this->db->query($sql);
    }
}


