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
     * @return void
     */
    protected function loadModels()
    {
        $this->comment = new Comment(new MySqlConnection($this->config['database']));
    }

    public function create()
    {
        if(!$this->session->get('AUTHENTICATED')) {
            die('not auth');
            header("Location: /");
            exit;
        }

        $this->comment->createComment(array(
            $_SESSION['username'],
            $_POST['story_id'],
            filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        ));
        header("Location: /story/?id=" . $_POST['story_id']);
    }
}