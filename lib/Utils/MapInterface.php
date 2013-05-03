<?php
namespace Utils;

interface MapInterface
{
    /**
     * @param string $key
     * @param string $default
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value);

    /**
     * @return
     */
    public function toArray();
}