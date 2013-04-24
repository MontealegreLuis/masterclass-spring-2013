<?php
use \Utils\Session;
use \Utils\Factory;

class MasterController
{
    /**
     * @var array
     */
    private $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->_setupConfig($config);
    }

    public function execute()
    {
        $router = Factory::getInstance($this->config['router']);
        $call = $router->route();
        $call_class = $call['call'];
        $class = ucfirst(array_shift($call_class));
        $class = "Controller\\{$class}Controller";
        $method = array_shift($call_class);
        $connection = Factory::getInstance($this->config['database']);
        $session = Factory::getInstance($this->config['session']);
        $o = new $class($connection, $session, $this->config);

        return $o->$method();
    }

    private function _setupConfig($config)
    {
        $this->config = $config;
    }
}