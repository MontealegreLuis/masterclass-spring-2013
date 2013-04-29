<?php
namespace Controller;

use \Database\MySqlConnection;
use \Model\Story;

class IndexController extends AbstractController
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

    public function index()
    {
        $stories = $this->story->fetchAllIncludingCommentCount();

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

        require $this->config['layout_path'] . '/layout.phtml';
    }
}