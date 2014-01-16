<?php
namespace Database\Driver;

use \Database\Connection\PdoConnection;

class PdoMySqlDriver implements DriverInterface
{
    /**
     * @see \Database\Driver\DriverInterface::connect()
     */
    public function connect($username, $password, array $params)
    {
        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";

        return new PdoConnection($dsn, $username, $password);
    }
}