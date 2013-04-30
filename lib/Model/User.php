<?php
namespace Model;

class User extends AbstractModel
{
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
    public function authenticate(array $credentials)
    {
        extract($credentials);

        return $this->getTable()->findOneByUsernameAndPassword(
            $user, $this->hashPassword($user, $pass)
        );
    }

    /**
     * @param string $username
     * @return array
     */
    public function fetchUser($username)
    {
        return $this->getTable()->findOneByUsername($username);
    }

    /**
     * @param string $username
     * @param string $password
     * @return void
     */
    public function updatePassword($username, $password)
    {
        $this->getTable()->updatePassword(
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
        return md5($username . $password); // THIS IS NOT SECURE. DO NOT USE IN PRODUCTION.
    }
}