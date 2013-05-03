<?php
namespace Utils;

class Map implements MapInterface
{
    /**
     * @var array
     */
    protected $values;

    /**
     * @param array $values
     */
    public function __construct(array $values = array())
    {
        $this->values = $values;
    }

    /**
     * @param string $key
     * @param string $default
     * @return string
     */
    public function get($key, $default = null)
    {
        return isset($this->values[$key]) ? $this->values[$key] : $default;
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function set($key, $value)
    {
        $this->values[$key] =$value;
    }

    /**
     * @return
     */
    public function toArray()
    {
        return $this->values;
    }
}