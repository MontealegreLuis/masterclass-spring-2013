<?php
use Di\ConfigurablesFactory;

use \Di\Container;
use \Di\ConstructorFactory;

class MasterController
{
    /**
     * @var \Di\Container
     */
    protected $container;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->setupContainer($config);
    }

    /**
     * @return string
     */
    public function execute()
    {
        $call = $this->container->get('router')->route();

        $call_class = $call['call'];
        $class = ucfirst(array_shift($call_class));
        $class = "Controller\\{$class}Controller";
        $method = array_shift($call_class);

        $controller = $this->container->get($class);

        return $controller->$method();
    }

    /**
     * @param array $config
     * @return void
     */
    protected function setupContainer(array $config)
    {
        $this->container = new Container($config);
    }
}