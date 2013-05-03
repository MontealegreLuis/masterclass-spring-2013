<?php
namespace Observer;

use \SplObserver;
use \SplSubject;

class IsAuthenticatedObserver implements SplObserver
{
    public function update(SplSubject $controller)
    {
        if ($controller->getSession()->get('AUTHENTICATED')) {

            $controller->addResult('isAuthenticated', true);
        } else {

            $controller->addResult('isAuthenticated', false);
        }
    }
}