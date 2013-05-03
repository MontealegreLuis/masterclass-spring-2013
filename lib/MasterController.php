<?php
use \Di\Container;

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

        $callClass = $call['call'];
        $class = ucfirst(array_shift($callClass));
        $controllerClass = "Controller\\{$class}Controller";
        $method = array_shift($callClass);

        $controller = $this->container->get($controllerClass);

        $response = $controller->dispatch($method);

        if (!$response->isRedirect()) {

            $view = $this->container->get('view');
            $view->setTemplate(sprintf('%s/%s', lcfirst($class), $method));
            $view->assign($controller->getResults());
            $response->setBody($view->render());
        }

        $response->send();
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