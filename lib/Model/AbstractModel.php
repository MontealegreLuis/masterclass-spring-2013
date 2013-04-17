<?php
namespace Model;

use \Database\Connection;

abstract class AbstractModel
{
    /**
     * @var \Database\Connection
     */
    protected $connection;

    /**
     * @param \Database\Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->setConnection($connection);
    }

    /**
     * @return \Database\Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param \Database\Connection $connection
     */
    public function setConnection(Connection $connection)
    {
        $this->connection = $connection;
    }
}