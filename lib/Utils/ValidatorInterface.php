<?php
namespace Utils;

interface ValidatorInterface
{
    /**
     * @param array $rules
     */
    public function setRules(array $rules);

    /**
     * @param array $values
     * @return boolean
     */
    public function isValid(array $values);

    /**
     * @param array $values
     * @return array
     */
    public function filter(array$values);

    /**
     * @return array
     */
    public function getErrorMessages();

    /**
     * @param string $message
     */
    public function addErrorMessage($message);

    /**
     * @return array
     */
    public function getValues();
}