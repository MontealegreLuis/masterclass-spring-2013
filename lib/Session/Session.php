<?php
namespace Session;

use \Utils\Map;

class Session extends Map implements SessionInterface
{
    /**
     * @param array $options
     */
    public function __construct(array &$values = array())
    {
        session_start();

        if (empty($values)) {
            $this->values = &$_SESSION;
        } else {
            $this->values = $values;
        }
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
    }
}