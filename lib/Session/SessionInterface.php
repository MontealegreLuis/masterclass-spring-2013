<?php
namespace Session;

interface SessionInterface
{
    /**
     * @param string $key
     * @param string $default
     */
    public function get($key, $default = null);

    /**
     * @param string $key
     * @param string $value
     */
    public function set($key, $value);

    /**
     * @return void
     */
    public function regenerateId();

    /**
     * @return void
     */
    public function destroy();
}