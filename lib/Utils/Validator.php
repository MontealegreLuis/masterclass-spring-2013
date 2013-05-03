<?php
namespace Utils;

class Validator implements ValidatorInterface
{
    /**
     * @var array
     */
    protected $rules;

    /**
     * @var array
     */
    protected $values;

    /**
     * @var array
     */
    protected $errorMessages;

    /**
     * @param array $rules
     */
    public function setRules(array $rules)
    {
        $this->rules = $rules;
        $this->errorMessages = array();
    }

    /**
     * @see \Utils\ValidatorInterface::isValid()
     */
    public function isValid(array $values)
    {
        $this->filter($values);
        $this->validate();

        return 0 === count($this->errorMessages);
    }

    /**
     * @see \Utils\ValidatorInterface::filter()
     */
    public function filter(array $values)
    {
        foreach ($this->rules['filters'] as $key => $filter) {
            switch ($filter) {
                case 'string':
                    $this->values[$key] = filter_var($values[$key], FILTER_SANITIZE_STRING);
                    break;
                case 'url':
                    $this->values[$key] = filter_var($values[$key], FILTER_SANITIZE_URL);
                    break;
                case 'integer':
                    $this->values[$key] = filter_var($values[$key], FILTER_SANITIZE_NUMBER_INT);
            }
        }
    }

    /**
     * @param array $values
     */
    protected function validate()
    {
        foreach ($this->rules['validators'] as $key => $validations) {
            foreach ($validations as $validation => $message) {
                switch ($validation) {
                    case 'required':
                        if ('' === trim($this->values[$key])) {
                            $this->errorMessages[] = $message;
                        }
                        break;
                    case 'url':
                        if (!filter_var($this->values[$key], FILTER_VALIDATE_URL)) {
                            $this->errorMessages[] = $message;
                        }
                }
            }
        }
    }

    /**
     * @see \Utils\ValidatorInterface::getErrorMessages()
     */
    public function getErrorMessages()
    {
        return $this->errorMessages;
    }

    /**
     * @see \Utils\ValidatorInterface::addErrorMessage()
     */
    public function addErrorMessage($message)
    {
        $this->errorMessages[] = $message;
    }

    /**
     * @see \Utils\ValidatorInterface::getValues()
     */
    public function getValues()
    {
        return $this->values;
    }
}