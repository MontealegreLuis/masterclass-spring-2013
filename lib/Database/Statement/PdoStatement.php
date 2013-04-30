<?php
namespace Database\Statement;

use \PDO;
use \PDOStatement as Statement;

class PdoStatement implements StatementInterface
{
    /**
     * @var \PDOStatement
     */
    protected $statement;

    /**
     * @param \PDOStatement $statement
     */
    public function __construct(Statement $statement)
    {
        $this->statement = $statement;
    }

    /**
     * @return \PDOStatement
     */
    protected function getStatement()
    {
        return $this->statement;
    }

    /**
     * @param int $fetchStyle
     */
    public function fetch($fetchStyle = PDO::FETCH_ASSOC)
    {
        return $this->getStatement()->fetch($fetchStyle);
    }

    /**
     * @param int $fetchStyle
    */
    public function fetchAll($fetchStyle = PDO::FETCH_ASSOC)
    {
        return $this->getStatement()->fetchAll($fetchStyle);
    }

    /**
     * @param array $params
    */
    public function execute(array $params = array())
    {
        return $this->getStatement()->execute($params);
    }

    /**
     * @return int
    */
    public function rowCount()
    {
        return $this->getStatement()->rowCount();
    }
}