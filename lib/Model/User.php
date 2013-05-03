<?php
namespace Model;

use \Session\SessionInterface;
use \Database\Table\UserGatewayInterface;
use \Utils\ValidatorInterface;

class User
{
    /**
     * @var \Utils\ValidatorInterface
     */
    protected $validator;

    /**
     * @var \Database\Table\UserGatewayInterface
     */
    protected $userGateway;

    /**
     * @var array
     */
    protected $rules;

    /**
     * @var array
     */
    protected $changePasswordRules;

    /**
     * @param \Utils\ValidatorInterface $validator
     * @param \Database\Table\StoryGatewayInterface $storyGateway
     */
    public function __construct(ValidatorInterface $validator, UserGatewayInterface $userGateway)
    {
        //TODO: fix this validations
        $this->rules = array(
            'filters' => array(
                'headline' => 'string',
                'url' => 'url',
            ),
            'validators' => array(
                'headline' => array(
                    array('required' => 'Please provide a headline')
                ),
                'url' => array(
                    array('url' => 'Please provide a valid URL'),
                )
            ),
        );
        $this->changePasswordRules = array(
            'filters' => array(
                'password' => 'string',
                'password_check' => 'string',
            ),
            'validators' => array(
                'password' => array(
                    'required' => 'Please enter your password',
                ),
                'password_check' => array(
                    'required' => 'Please confirm your password',
                )
            ),
        );
        $this->validator = $validator;
        $this->userGateway = $userGateway;
    }

    /**
     * @return array
     */
    protected function getChangePasswordRules()
    {
        return $this->changePasswordRules;
    }

    /**
     * @return \Utils\ValidatorInterface
     */
    protected function getValidator()
    {
        return $this->validator;
    }

    /**
     * @return \Database\Table\UserGatewayInterface
     */
    protected function getUserGateway()
    {
        return $this->userGateway;
    }

    public function createUser($values)
    {
        extract($values);

        return $this->getTable()
                    ->insert($username, $this->hashPassword($username, $password));
    }

    /**
     * @param array $credentials
     * @return array
     */
    public function authenticate($username, $password)
    {
        return $this->getUserGateway()->findOneByUsernameAndPassword(
            $username, $this->hashPassword($username, $password)
        );
    }

    /**
     * @return array
     */
    public function getLoginErrors()
    {
        return array('Your username/password did not match.');
    }

    /**
     * @param array $credentials
     * @param \Session\SessionInterface $session
     */
    public function storeCredentials(array $user, SessionInterface $session)
    {
        $session->regenerateId();
        $session->set('username', $user['username']);
        $session->set('AUTHENTICATED', true);
    }

    /**
     * @param string $username
     * @return array
     */
    public function fetchUser($username)
    {
        return $this->getUserGateway()->findOneByUsername($username);
    }

    /**
     * @param array $values
     * @return boolean
     */
    public function isValidPasswordChange(array $values)
    {
        $this->getValidator()->setRules($this->getChangePasswordRules());
        $isValid = $this->getValidator()->isValid($values);

        if ($isValid && $values['password'] !== $values['password_check']) {

            $isValid = false;
            $this->getValidator()->addErrorMessage('The password fields did not match.');
        }

        return $isValid;
    }

    /**
     * @param string $username
     * @param string $password
     * @return void
     */
    public function updatePassword($username, $password)
    {
        $this->getUserGateway()->updatePassword(
            $username, $this->hashPassword($username, $password)
        );
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->getValidator()->getErrorMessages();
    }

    /**
     * @param string $username
     * @param string $password
     * @return string
     */
    protected function hashPassword($username, $password)
    {
        return md5($username . $password); //THIS IS NOT SECURE. DO NOT USE IN PRODUCTION.
    }
}