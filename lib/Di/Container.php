<?php
namespace Di;

class Container
{
    /**
     * @var array
     */
    protected $objects;

    /**
     * @var array
     */
    protected $factories;

    /**
     * @param array $factories
     */
    public function __construct(array $factories)
    {
        $this->objects = array();
        $this->factories = $factories;
    }

    /**
     * @param string $key
     * @throws ContainerException
     * @return mixed
     */
    public function get($key)
    {
        if (isset($this->objects[$key])) {

            return $this->objects[$key];
        }

        if (!isset($this->factories[$key])) {

            throw new ContainerException("Object with key '$key' cannot be created");
        }

        if (is_callable($this->factories[$key])) {

            $this->objects[$key] = $this->factories[$key]($this);

            return $this->objects[$key];
        }

        $this->objects[$key] = $this->factories[$key];

        return $this->objects[$key];
    }
}