<?php
namespace Observer;

use \SplObserver;
use \SplSubject;

class IsAuthenticatedObserver implements SplObserver
{
    /**
     * Set variable isAuthenticated in order to allow the view to render the
     * menu options correctly
     *
     * @see SplObserver::update()
     */
    public function update(SplSubject $controller)
    {
        if ($controller->getSession()->get('AUTHENTICATED')) {

            $controller->addResult('isAuthenticated', true);

        } else {

            $controller->addResult('isAuthenticated', false);
        }
    }
}