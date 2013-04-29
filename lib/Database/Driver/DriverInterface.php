<?php
namespace Database\Driver;

interface DriverInterface
{
    /**
     * @param string $username
     * @param string $password
     * @param array $params
     * @return \Database\Connection\ConnectionInterface
     */
    public function connect($username, $password, array $params);
}