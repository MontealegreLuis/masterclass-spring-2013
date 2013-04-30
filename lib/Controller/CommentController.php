<?php
namespace Controller;

use \Database\MySqlConnection;
use \Model\Comment;
use \Utils\Session;

class CommentController extends AbstractController
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

    public function create()
    {
        if(!$this->session->get('AUTHENTICATED')) {
            die('not auth');
            header("Location: /");
            exit;
        }

        $this->comment->createComment(array(
            'createdBy' => $_SESSION['username'],
            'storyId' => $_POST['story_id'],
            'comment' => filter_input(
                INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS
            ),
        ));
        header("Location: /story/?id=" . $_POST['story_id']);
    }
}