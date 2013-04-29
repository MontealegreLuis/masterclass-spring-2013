<?php
namespace Router;

class DefaultRouter implements RouterInterface
{
    /**
     * @var array
     */
    protected $routes;

    /**
     * @param array $config
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * (non-PHPdoc)
     * @see \Router\RouterInterface::route()
     */
    public function route()
    {
        if (isset($_SERVER['REDIRECT_BASE'])) {
            $rb = $_SERVER['REDIRECT_BASE'];
        } else {
            $rb = '';
        }

        $ruri = $_SERVER['REQUEST_URI'];
        $path = str_replace($rb, '', $ruri);
        $return = array();

        foreach($this->routes as $k => $v) {

            $matches = array();
            $pattern = '$' . $k . '$';
            if (preg_match($pattern, $path, $matches)) {
                $controller_details = $v;
                $path_string = array_shift($matches);
                $arguments = $matches;
                $controller_method = explode('/', $controller_details);
                $return = array('call' => $controller_method);
            }
        }

        return $return;
    }
}