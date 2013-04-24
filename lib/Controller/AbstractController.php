<?php
namespace Controller;

use \Session\SessionInterface;

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

    public function __construct(SessionInterface $session, array $config)
    {
        $this->session = $session;
        $this->config = $config;
        $this->loadModels();
    }

    abstract protected function loadModels();
}