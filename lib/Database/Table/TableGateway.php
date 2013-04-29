<?php
namespace Database\Table;

use \Database\Connection\ConnectionInterface;

class TableGateway
{
    /**
     * @var \Database\Connection\ConnectionInterface
     */
    protected $connection;

    /**
     * @param \Database\Connection\ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return \Database\Connection\ConnectionInterface
     */
    protected function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array
     */
    protected function fetchAll($sql, array $params = array())
    {
        $statement = $this->executeQuery($sql, $params);

        return $statement->fetchAll();
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array
     */
    protected function fetchOne($sql, array $params)
    {
        $statement = $this->executeQuery($sql, $params);

        return $statement->fetch();
    }

    /**
     * @param string $sql
     * @param array $params
     * @return \Database\Connection\StatementInterface
     */
    protected function executeQuery($sql, array $params)
    {
        $statement = $this->getConnection()->prepare($sql);
        $statement->execute($params);

        return $statement;
    }
}