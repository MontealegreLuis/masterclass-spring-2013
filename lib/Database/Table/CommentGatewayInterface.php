<?php
namespace Database\Table;

interface CommentGatewayInterface
{
    /**
     * @param string $comment
     * @param string $createdBy
     * @param string $storyId
     * @return string
     */
    public function insert($comment, $createdBy, $storyId);
}