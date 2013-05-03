<?php
namespace Model;

use \Database\Table\StoryGatewayInterface;
use \Utils\ValidatorInterface;

class Story extends AbstractModel
{
    /**
     * @var \Database\Table\StoryGatewayInterface
     */
    protected $storyGateway;

    /**
     * @param \Database\Table\StoryGatewayInterface $storyGateway
     */
    public function __construct(StoryGatewayInterface $storyGateway)
    {
        $this->rules = array(
            'filters' => array(
                'headline' => 'string',
                'url' => 'url',
            ),
            'validators' => array(
                'headline' => array(
                    'required' => 'Please provide a headline',
                ),
                'url' => array(
                    'url' => 'Please provide a valid URL',
                )
            ),
        );
        $this->storyGateway = $storyGateway;
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
     * @return \Database\Table\StoryGatewayInterface
     */
    protected function getStoryGateway()
    {
        return $this->storyGateway;
    }

    /**
     * @param string $createdBy
     * @return string
     */
    public function createStory($createdBy)
    {
        extract($this->getValidator()->getValues());

        return $this->getStoryGateway()->insert($headline, $url, $createdBy);
    }

    /**
     * @return array
     */
    public function fetchAllIncludingCommentCount()
    {
        return $this->getStoryGateway()->findAll();
    }

    /**
     * @param int $storyId
     * @return array
     */
    public function fetchStoryById($storyId)
    {
        return $this->getStoryGateway()->findOneById($storyId);
    }

    /**
     * @param int $id
     * @return array
     */
    public function fetchStoryComments($storyId)
    {
        return $this->getStoryGateway()->findCommentsByStoryId($storyId);
    }
}