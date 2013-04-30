<?php
namespace Database\Table;

class CommentGateway extends TableGateway
{
    /**
     * @param string $comment
     * @param string $createdBy
     * @param string $storyId
     * @return string
     */
    public function insert($comment, $createdBy, $storyId)
    {
        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment)
                VALUES (?, NOW(), ?, ?)';

        $this->executeQuery($sql, array($createdBy, $storyId, $comment));

        return $this->getConnection()->lastInsertId();
    }
}