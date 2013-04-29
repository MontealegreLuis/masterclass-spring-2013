<?php
namespace Model;

class Story extends AbstractModel
{
    /**
     * @param array $values
     * @return string
     */
    public function createStory(array $values)
    {
        extract($values);

        return $this->getTable()->insert($headline, $url, $createdBy);
    }

    /**
     * @return array
     */
    public function fetchAllIncludingCommentCount()
    {
        return $this->getTable()->findAll();
    }

    /**
     * @param int $storyId
     * @return array
     */
    public function fetchStoryById($storyId)
    {
        return $this->getTable()->findOneById($storyId);
    }

    /**
     * @param int $id
     * @return array
     */
    public function fetchStoryComments($storyId)
    {
        return $this->getTable()->findCommentsByStoryId($storyId);
    }
}