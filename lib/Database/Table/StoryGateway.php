<?php
namespace Database\Table;

class StoryGateway extends TableGateway
{
    /**
     * @param string $headline
     * @param string $url
     * @param string $createdBy
     * @return string
     */
    public function insert($headline, $url, $createdBy)
    {
        $sql = 'INSERT INTO story
                (headline, url, created_by, created_on)
                VALUES (?, ?, ?, NOW())';

        $this->executeQuery($sql, array($headline, $url, $createdBy));

        return $this->getConnection()->lastInsertId();
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $sql = 'SELECT s.*, COUNT(c.id) as comment_count
                FROM story s
                LEFT OUTER JOIN comment c
                    ON s.id = c.story_id
                ORDER BY s.created_on DESC';

        return $this->fetchAll($sql);
    }

    /**
     * @param int $storyId
     * @return array
     */
    public function findOneById($storyId)
    {
        $sql = 'SELECT s.*, COUNT(c.id) AS comment_count
                FROM story s
                LEFT OUTER JOIN comment c
                    ON s.id = c.story_id
                WHERE s.id = ?';

        return $this->fetchOne($sql, array($storyId));
    }

    /**
     * @param int $storyId
     * @return array
     */
    public function findCommentsByStoryId($storyId)
    {
        $sql = 'SELECT * FROM comment WHERE story_id = ?';

        return $this->fetchAll($sql, array($storyId));
    }
}