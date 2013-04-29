<?php
namespace Model;

use \Database\Table\TableGateway;

abstract class AbstractModel
{
    /**
     * @var \Database\Table\TableGateway
     */
    protected $table;

    /**
     * @param \Database\Table\TableGateway $connection
     */
    public function __construct(TableGateway $table)
    {
        $this->table = $table;
    }

    /**
     * @return \Database\Connection
     */
    protected function getTable()
    {
        return $this->table;
    }
}