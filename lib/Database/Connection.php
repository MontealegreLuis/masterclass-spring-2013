<?php
namespace Database;

interface Connection
{
    /**
     * @param int $sql
     * @param array $params
     * qreturn int
     */
    public function insert($sql, array $params);

    /**
     * @param int $sql
     * @param array $params
     * @return void
     */
    public function delete($sql, array $params);

    /**
     * @param int $sql
     * @param array $params
     * @return void
     */
    public function update($sql, array $params);

    /**
     * @param int $sql
     * @param array $params
     * @return array
     */
    public function fetchAll($sql, array $params = array());

    /**
     * @param int $sql
     * @param array $params
     * @return array
     */
    public function fetchOne($sql, array $params);
}