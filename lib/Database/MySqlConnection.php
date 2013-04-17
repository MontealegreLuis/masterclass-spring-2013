<?php
namespace Database;

use \PDO;

class MySqlConnection implements Connection
{
    /**
     * @var \PDO
     */
    protected $connection;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $dsn = "mysql:host={$config['host']};dbname={$config['name']}";
        $this->connection = new PDO($dsn, $config['user'], $config['pass']);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @return \PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return int
     */
    public function insert($sql, array $params)
    {
       $this->executeQuery($sql, $params);

       return $this->getConnection()->lastInsertId();
    }

    public function delete($sql, array $params)
    {
        $this->executeQuery($sql, $params);
    }

    public function update($sql, array $params)
    {
        $this->executeQuery($sql, $params);
    }

    public function fetchAll($sql, array $params = array())
    {
        $statement = $this->executeQuery($sql, $params);

        return $statement->fetchAll();
    }

    /**
     * @see \Database\Connection::fetchOne()
     */
    public function fetchOne($sql, array $params)
    {
        $statement = $this->executeQuery($sql, $params);

        return $statement->fetch();
    }

    /**
     * @param string $sql
     * @param array $params
     * @return \PDOStatement
     */
    protected function executeQuery($sql, array $params)
    {
        $statement = $this->getConnection()->prepare($sql);
        $statement->execute($params);

        return $statement;
    }
}