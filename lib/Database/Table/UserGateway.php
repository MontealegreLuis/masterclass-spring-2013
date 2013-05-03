<?php
namespace Database\Table;

class UserGateway extends TableGateway implements UserGatewayInterface
{
    /**
     * @param string $username
     * @param string $password
     * @return string
     */
    public function insert($username, $email, $password)
    {
        $sql = 'INSERT INTO user (username, email, password) VALUES (?, ?, ?)';

        $this->executeQuery($sql, array($username, $email, $password));

        return $this->getConnection()->lastInsertId();
    }

    /**
     * @param string $username
     * @param string $password
     * @return array
     */
    public function findOneByUsernameAndPassword($username, $password)
    {
        $sql ='SELECT * FROM user WHERE username = ? AND password = ? LIMIT 1';

        return $this->fetchOne($sql, array($username, $password));
    }

    /**
     * @param string $username
     * @return array
     */
    public function findOneByUsername($username)
    {
        $sql = 'SELECT * FROM user WHERE username = ?';

        return $this->fetchOne($sql, array($username));
    }

    /**
     * @param string $username
     * @param string $password
     * @return void
     */
    public function updatePassword($username, $password)
    {
        $sql = 'UPDATE user SET password = ? WHERE username = ?';

        $this->executeQuery($sql, array($password, $username));
    }
}