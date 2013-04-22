<?php
namespace Utils;

class Session
{
    /**
     * @param array $values
     */
    public function __construct(array $values = array())
    {
        session_start();
    }

    /**
     * @param string $key
     * @param string $default
     * @return string
     */
    public function get($key, $default = null)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function set($key, $value)
    {
        $_SESSION[$key] =$value;
    }

    /**
     * @return void
     */
    public function regenerateId()
    {
        session_regenerate_id();
    }

    /**
     * @return void
     */
    public function destroy()
    {
        session_destroy();
        unset($_SESSION);
    }
}