<?php
namespace Controller;

use \Http\HttpController;
use \Model\Story;

class IndexController extends HttpController
{
    /**
     * @var \Model\Story
     */
    protected $story;

    /**
     * @return void
     */
    public function setStory(Story $story)
    {
        $this->story = $story;
    }

    /**
     * @return \Model\Story
     */
    public function getStory()
    {
        return $this->story;
    }

    /**
     * @return array
     */
    public function index()
    {
        $this->addResult('stories', $this->getStory()->fetchAllIncludingCommentCount());
    }
}