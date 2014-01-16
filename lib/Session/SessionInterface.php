<?php
namespace Session;

use \Utils\MapInterface;

interface SessionInterface extends MapInterface
{
    /**
     * @return void
     */
    public function regenerateId();

    /**
     * @return void
     */
    public function destroy();
}