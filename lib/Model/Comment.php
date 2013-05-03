<?php
namespace Model;

use \Utils\ValidatorInterface;
use \Database\Table\CommentGatewayInterface;

class Comment
{
    /**
     * @var \Utils\ValidatorInterface
     */
    protected $validator;

    /**
     * @var \Database\Table\CommentGatewayInterface
     */
    protected $commentGateway;

    /**
     * @var array
     */
    protected $rules;

    /**
     * @param \Utils\ValidatorInterface $validator
     * @param \Database\Table\CommentGatewayInterface $storyGateway
     */
    public function __construct(ValidatorInterface $validator, CommentGatewayInterface $commentGateway)
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
     * @return \Utils\ValidatorInterface
     */
    protected function getValidator()
    {
        return $this->validator;
    }

    /**
     * @param array $values
     * @return boolean
     */
    public function isValid(array $values)
    {
        $this->getValidator()->setRules($this->rules);

        return $this->getValidator()->isValid($values);
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->getValidator()->getErrorMessages();
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