<?php
namespace Database\Table;

interface UserGatewayInterface
{
    /**
     * @param string $username
     * @param string $password
     * @return string
     */
    public function insert($username, $email, $password);

    /**
     * @param string $username
     * @param string $password
     * @return array
     */
    public function findOneByUsernameAndPassword($username, $password);

    /**
     * @param string $username
     * @return array
     */
    public function findOneByUsername($username);

    /**
     * @param string $username
     * @param string $password
     * @return void
     */
    public function updatePassword($username, $password);
}