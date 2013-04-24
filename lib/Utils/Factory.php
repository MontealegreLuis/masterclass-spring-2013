<?php
namespace Utils;

class Factory
{
    private function __construct(){}

    static public function getInstance(array $config)
    {
        return new $config['class']($config['options']);
    }
}