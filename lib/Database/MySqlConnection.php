<?php
namespace Database;

class MySqlConnection extends Connection
{
    /**
     * (non-PHPdoc)
     * @see \Database\Connection::buildDsn()
     */
    protected function buildDsn(array $config)
    {
        return "mysql:host={$config['host']};dbname={$config['name']}";
    }
}