<?php
namespace Database\Connection;

use \Database\Statement\PdoStatement;
use \PDO;

class PdoConnection implements ConnectionInterface
{
    /**
     * @var \PDO
     */
    protected $connection;

    /**
     * @param string $dsn
     * @param string $username
     * @param string $password
     */
    public function __construct($dsn, $username, $password)
    {
        $this->connection = new PDO($dsn, $username, $password);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @return \PDO
     */
    protected function getConnection()
    {
        return $this->connection;
    }

    /**
     * @return string
     */
    public function lastInsertId()
    {
        return $this->getConnection()->lastInsertId();
    }

    /**
     * @param string $sql
     * @param array $options
     * @return \Database\Connection\StatementInterface
    */
    public function prepare($sql, array $options = array())
    {
        return new PdoStatement($this->getConnection()->prepare($sql, $options));
    }
}