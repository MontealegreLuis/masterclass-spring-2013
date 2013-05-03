<?php
namespace Model;

use \Session\SessionInterface;
use \Database\Table\UserGatewayInterface;
use \Utils\ValidatorInterface;

class User extends AbstractModel
{
    /**
     * @var \Database\Table\UserGatewayInterface
     */
    protected $userGateway;

    /**
     * @var array
     */
    protected $changePasswordRules;

    /**
     * @param \Utils\ValidatorInterface $validator
     * @param \Database\Table\StoryGatewayInterface $storyGateway
     */
    public function __construct(UserGatewayInterface $userGateway)
    {
        $this->rules = array(
            'filters' => array(
                'username' => 'string',
                'email' => 'email',
                'password' => 'string',
                'password_check' => 'string',
            ),
            'validators' => array(
                'username' => array(
                    'required' => 'Please provide a username',
                ),
                'email' => array(
                    'email' => 'Please provide a valid email',
                ),
                'password' => array(
                    'required' => 'Please provide a password',
                ),
                'password_check' => array(
                    'required' => 'Please confirm your password',
                ),
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
     * @return \Database\Table\UserGatewayInterface
     */
    protected function getUserGateway()
    {
        return $this->userGateway;
    }

    /**
     * Validate that passwords match and that username is unique
     *
     * @see \Model\AbstractModel::isValid()
     */
    public function isValid(array $values)
    {
        return       parent::isValid($values)
                &&   $this->validatePasswords($values)
                && ! $this->usernameAlreadyExist($values['username']);
    }

    /**
     * @param string $username
     * @return boolean
     */
    public function usernameAlreadyExist($username)
    {
        $user = $this->getUserGateway()->findOneByUsername($username);

        if (! empty($user)) {

            $this->getValidator()->addErrorMessage('The provided username already exist.');

            return true;
        }

        return false;
    }

    /**
     * @param array $values
     */
    public function createUser()
    {
        extract($this->getValidator()->getValues());

        return $this->getUserGateway()
                    ->insert($username, $email, $this->hashPassword($username, $password));
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

        return $isValid && $this->validatePasswords($values);
    }

    /**
     * @param string $password
     * @param string $passwordCheck
     * @return boolean
     */
    protected function validatePasswords(array $values)
    {
        if ($values['password'] !== $values['password_check']) {

            $this->getValidator()->addErrorMessage('The password fields did not match.');

            return false;
        }

        return true;
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
     * @param string $username
     * @param string $password
     * @return string
     */
    protected function hashPassword($username, $password)
    {
        return md5($username . $password); //THIS IS NOT SECURE. DO NOT USE IN PRODUCTION.
    }
}