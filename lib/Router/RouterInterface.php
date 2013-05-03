<?php
namespace Router;

use \Http\RequestInterface;

interface RouterInterface
{
    /**
     * @param RequestInterface $request
     * @return array
     */
    public function route(RequestInterface $request);
}