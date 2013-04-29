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
     * @param Connection $connection
     * @param SessionInterface $session
     * @param array $config
     */
    public function __construct(SessionInterface $session, array $config)
    {
        $this->session = $session;
        $this->config = $config;
    }
}