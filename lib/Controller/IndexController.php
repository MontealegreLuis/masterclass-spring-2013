<?php
namespace Controller;

use \Database\MySqlConnection;
use \Model\Story;

class IndexController
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var \Model\Story
     */
    protected $story;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->story = new Story(new MySqlConnection($config['database']));
    }

    public function index()
    {
        $stories = $this->story->fetchAllWithCommentCount();

        $content = '<ol>';

        foreach($stories as $story) {
            $content .= '
                <li>
                <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
                <span class="details">' . $story['created_by'] . ' | <a href="/story/?id=' . $story['id'] . '">' . $story['comment_count'] . ' Comments</a> |
                ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
                </li>
            ';
        }

        $content .= '</ol>';

        require $this->config['views']['layout_path'] . '/layout.phtml';
    }
}