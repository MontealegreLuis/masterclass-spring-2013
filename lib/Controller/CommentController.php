<?php
namespace Controller;

use \Database\MySqlConnection;
use \Model\Comment;
use \Utils\Session;

class CommentController
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var \Model\Comment
     */
    protected $comment;

    /**
     * @var \Utils\Session
     */
    protected $session;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->comment = new Comment(new MySqlConnection($config['database']));
        $this->session = new Session();
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