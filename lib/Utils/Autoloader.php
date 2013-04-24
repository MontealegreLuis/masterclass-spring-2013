<?php
namespace Utils;

class Autoloader
{
    /**
     * @var string
     */
    protected $directory;

    /**
     * @param string $directory
     */
    public function __construct($directory)
    {
        $this->directory = $directory;
    }

    /**
     * @param string $className
     */
    public function loadClass($className)
    {
        $classPath = str_replace('\\', '/', $className);

        require_once "{$this->directory}{$classPath}.php";
    }

    /**
     * @return void
     */
    public function register()
    {
        spl_autoload_register(array($this, 'loadClass'));
    }
}