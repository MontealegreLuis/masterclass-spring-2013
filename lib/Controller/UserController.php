<?php
namespace Controller;

use \Http\HttpController;
use \Model\User;

class UserController extends HttpController
{
    /**
     * @var \Model\User
     */
    protected $user;

    /**
     * @return void
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return \Model\User
     */
    protected function getUser()
    {
        return $this->user;
    }

    public function create()
    {
        if ($this->getRequest()->isPost()) {

            if ($this->getUser()->isValid($this->getRequest()->getPost()->toArray())) {

                $this->getUser()->createUser();
                $this->logout();

            } else {

                $this->addResult('errors', $this->getUser()->getErrors());
            }
        }
    }

    public function account()
    {
        if (!$this->getSession()->get('AUTHENTICATED')) {
            return $this->getResponse()->setRedirect('/user/login');
        }

        $username = $this->getSession()->get('username');

        $this->addResult('details', $this->getUser()->fetchUser($username));

        if ($this->getRequest()->isPost()) {

            $passwords = $this->getRequest()->getPost()->toArray();

            if ( ! $this->getUser()->isValidPasswordChange($passwords)) {

                 $this->addResult('errors', $this->getUser()->getErrors());

            } else {

                $password = $this->getRequest()->getPost()->get('password');
                $this->getUser()->updatePassword($username, $password);

                $this->addResult('message', 'Your password was changed.');
            }
        }
    }

    public function login()
    {
        if ($this->getRequest()->isPost()) {

            $username = $this->getRequest()->getPost()->get('user');
            $password = $this->getRequest()->getPost()->get('pass');

            $user = $this->getUser()->authenticate($username, $password);

            if ($user) {

                $this->getUser()->storeCredentials($user, $this->getSession());

                return $this->getResponse()->setRedirect('/');
            }

            $this->addResult('errors', $this->getUser()->getLoginErrors());
        }
    }

    public function logout()
    {
        $this->getSession()->destroy();
        $this->getResponse()->setRedirect('/user/login');
    }
}