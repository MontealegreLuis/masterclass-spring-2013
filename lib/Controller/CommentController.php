<?php
namespace Controller;

use \Http\HttpController;
use \Model\Comment;

class CommentController extends HttpController
{
    /**
     * @var \Model\Comment
     */
    protected $comment;

    /**
     * @param \Model\Comment $comment
     */
    public function setComment(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return \Model\Comment
     */
    protected function getComment()
    {
        return $this->comment;
    }

    public function create()
    {
        if (!$this->session->get('AUTHENTICATED')) {

            return $this->getResponse()->setRedirect('/');
        }

        $storyId = $this->getRequest()->getPost()->get('story_id');

        if ($this->getComment()->isValid($this->getRequest()->getPost()->toArray())) {

            $this->getComment()->createComment($this->getSession()->get('username'));

            return $this->getResponse()->setRedirect("/story/?id={$storyId}");
        }

        $this->addResult('story', array('id' => $storyId));
        $this->addResult('errors', $this->getComment()->getErrors());
    }
}