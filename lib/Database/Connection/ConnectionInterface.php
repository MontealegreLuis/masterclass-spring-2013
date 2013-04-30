<?php
namespace Database\Connection;

interface ConnectionInterface
{
    /**
     * @return string
     */
    public function lastInsertId();

    /**
     * @param string $sql
     * @param array $options
     * @return \Database\Connection\StatementInterface
     */
    public function prepare($sql, array $options = array());
}