<?php
namespace Database\Statement;

interface StatementInterface
{
    /**
     * @param int $fetchStyle
     */
    public function fetch($fetchStyle);

    /**
     * @param int $fetchStyle
     */
    public function fetchAll($fetchStyle);

    /**
     * @param array $params
     */
    public function execute(array $params = array());

    /**
     * @return int
     */
    public function rowCount();
}