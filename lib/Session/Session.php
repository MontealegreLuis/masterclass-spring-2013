<?php
namespace Session;

class Session implements SessionInterface
{
    /**
     * @var string
     */
    static public $CLASS = __CLASS__;

    /**
     * @param array $options
     */
    public function __construct()
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