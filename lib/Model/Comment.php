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
        extract($values);
        $this->getTable()->insert($comment, $createdBy, $storyId);
    }
}