<?php
namespace Model;

use \Utils\ValidatorInterface;
use \Database\Table\CommentGatewayInterface;

class Comment extends AbstractModel
{
    /**
     * @var \Database\Table\CommentGatewayInterface
     */
    protected $commentGateway;

    /**
     * @param \Database\Table\CommentGatewayInterface $storyGateway
     */
    public function __construct(CommentGatewayInterface $commentGateway)
    {
        $this->rules = array(
            'filters' => array(
                'storyId' => 'integer',
                'comment' => 'string',
            ),
            'validators' => array(
                'storyId' => array(
                    'required' => 'Cannot associate this comment with a story.',
                ),
                'comment' => array(
                    'required' => 'Please enter your comment.',
                )
            ),
        );
        $this->validator = $validator;
        $this->commentGateway = $commentGateway;
    }

    /**
     * @return \Database\Table\CommentGatewayInterface
     */
    protected function getCommentGateway()
    {
        return $this->commentGateway;
    }

    /**
     * @param string $createdBy
     * @return int
     */
    public function createComment($createdBy)
    {
        extract($this->getValidator()->getValues());

        $this->getCommentGateway()->insert($comment, $createdBy, $storyId);
    }
}