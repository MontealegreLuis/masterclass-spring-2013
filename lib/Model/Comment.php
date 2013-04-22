<?php
namespace Model;

class Comment extends AbstractModel
{
    /**
     * @param array $values
     * @return int
     */
    public function createComment(array $values)
    {
        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';

        return $this->getConnection()->insert($sql, $values);
    }
}