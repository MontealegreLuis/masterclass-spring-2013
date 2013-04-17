<?php
namespace Model;

class User extends AbstractModel
{
    public function createUser($values)
    {
        $sql = 'INSERT INTO user (username, email, password) VALUES (?, ?, ?)';
        $values['password'] = $this->hashPassword($values['username'], $values['password']);

        return $this->getConnection()->insert($sql, $values);
    }

    /**
     * @param array $credentials
     * @return array
     */
    public function authenticate(array $credentials)
    {
        $username = $credentials['user'];
        $password = $credentials['pass'];
        $password = $this->hashPassword($username, $password);

        $sql ='SELECT * FROM user WHERE username = ? AND password = ? LIMIT 1';

        return $this->getConnection()->fetchOne($sql, array($username, $password));
    }

    /**
     * @param string $username
     * @return array
     */
    public function fetchUser($username)
    {
        $sql = 'SELECT * FROM user WHERE username = ?';

        return $this->getConnection()->fetchOne($sql, array($username));
    }

    /**
     * @param string $username
     * @param string $password
     * @return void
     */
    public function updatePassword($username, $password)
    {
        $sql = 'UPDATE user SET password = ? WHERE username = ?';

        $password = $this->hashPassword($username, $password);

        $this->getConnection()->update($sql, array($password, $username));
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