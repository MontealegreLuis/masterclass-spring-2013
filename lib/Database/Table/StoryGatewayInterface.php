<?php
namespace Database\Table;

interface StoryGatewayInterface
{
    /**
     * @param string $headline
     * @param string $url
     * @param string $createdBy
     * @return string
     */
    public function insert($headline, $url, $createdBy);

    /**
     * @return array
     */
    public function findAll();

    /**
     * @param int $storyId
     * @return array
     */
    public function findOneById($storyId);

    /**
     * @param int $storyId
     * @return array
     */
    public function findCommentsByStoryId($storyId);
}