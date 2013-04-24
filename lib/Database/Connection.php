<?php
namespace Database;

use \PDO;

abstract class Connection
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
        $this->connection = new PDO(
            $this->buildDsn($config), $config['user'], $config['pass']
        );
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @param array $config
     * @return string
     */
    abstract protected function buildDsn(array $config);

    /**
     * @return \PDO
     */
    protected function getConnection()
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

    /**
     * @param string $sql
     * @param array $params
     * @return void
     */
    public function delete($sql, array $params)
    {
        $this->executeQuery($sql, $params);
    }

    /**
     * @param string $sql
     * @param array $params
     * @return void
     */
    public function update($sql, array $params)
    {
        $this->executeQuery($sql, $params);
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function fetchAll($sql, array $params = array())
    {
        $statement = $this->executeQuery($sql, $params);

        return $statement->fetchAll();
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array
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