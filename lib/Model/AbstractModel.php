<?php
namespace Model;

use \Utils\ValidatorInterface;

abstract class AbstractModel
{
    /**
     * @var \Utils\ValidatorInterface
     */
    protected $validator;

    /**
     * @var array
     */
    protected $rules;

    /**
     * @return \Utils\ValidatorInterface
     */
    protected function getValidator()
    {
        return $this->validator;
    }

    /**
     * @param \Utils\ValidatorInterface $validator
     */
    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;
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
}