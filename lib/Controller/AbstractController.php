<?php
namespace Controller;

use \Session\SessionInterface;
use \Database\Connection;

abstract class AbstractController
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var \Utils\Session
     */
    protected $session;

    /**
     * @var \Database\Connection
     */
    protected $connection;

    /**
     * @param Connection $connection
     * @param SessionInterface $session
     * @param array $config
     */
    public function __construct(Connection $connection, SessionInterface $session, array $config)
    {
        $this->connection = $connection;
        $this->session = $session;
        $this->config = $config;
        $this->loadModels();
    }

    abstract protected function loadModels();
}