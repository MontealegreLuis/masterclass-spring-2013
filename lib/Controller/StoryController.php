<?php
namespace Controller;

use \Http\HttpController;
use \Model\Story;

class StoryController extends HttpController
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
    protected function getStory()
    {
        return $this->story;
    }

    public function index()
    {
        $storyId = $this->getRequest()->getQuery()->get('id');

        if ( ! $storyId) {

            return $this->getResponse()->setRedirect('/');
        }

        $story = $this->getStory()->fetchStoryById($storyId);

        if ( ! $story) {

            return $this->getResponse()->setRedirect('/');
        }

        $comments = $this->getStory()->fetchStoryComments($storyId);

        $this->addResult('story', $story);
        $this->addResult('comments', $comments);
    }

    public function create()
    {
        if ( ! $this->getSession()->get('AUTHENTICATED')) {

            return $this->getResponse()->setRedirect('/user/login');
        }

        if ($this->getRequest()->isPost()) {

            if ($this->getStory()->isValid($this->getRequest()->getPost()->toArray())) {

                $this->getStory()->createStory($this->getSession()->get('username'));

                return $this->getResponse()->setRedirect('/');

            } else {

                $this->addResult('errors', $this->getStory()->getErrors());
            }
        }
    }
}