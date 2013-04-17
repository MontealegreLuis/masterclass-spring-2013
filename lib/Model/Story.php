<?php
namespace Model;

class Story extends AbstractModel
{
    /**
     * @param array $values
     * @return int
     */
    public function createStory(array $values)
    {
        $sql = 'INSERT INTO story
                (headline, url, created_by, created_on)
                VALUES (?, ?, ?, NOW())';

        return $this->getConnection()->insert($sql, $values);
    }

    /**
     * @return array
     */
    public function fetchAllWithCommentCount()
    {
        $sql = 'SELECT s.*, COUNT(c.id) as comment_count
                FROM story s
                LEFT OUTER JOIN comment c
                    ON s.id = c.story_id
                ORDER BY s.created_on DESC';

        return $this->getConnection()->fetchAll($sql);
    }

    /**
     * @param int $id
     * @return array
     */
    public function fetchStoryById($id)
    {
        $sql = 'SELECT s.*, COUNT(c.id) AS comment_count
                FROM story s
                LEFT OUTER JOIN comment c
                    ON s.id = c.story_id
                WHERE s.id = ?';

        return $this->getConnection()->fetchOne($sql, array($id));
    }

    /**
     * @param int $id
     * @return array
     */
    public function fetchStoryComments($id)
    {
        $sql = 'SELECT * FROM comment WHERE story_id = ?';

        return $this->getConnection()->fetchAll($sql, array($id));
    }
}