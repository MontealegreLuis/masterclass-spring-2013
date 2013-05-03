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

    /**
     * @todo
     */
    public function create()
    {
        $error = null;

        // Do the create
        if(isset($_POST['create'])) {
            if(empty($_POST['username']) || empty($_POST['email']) ||
               empty($_POST['password']) || empty($_POST['password_check'])) {
                $error = 'You did not fill in all required fields.';
            }

            if(is_null($error)) {
                if(!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
                    $error = 'Your email address is invalid';
                }
            }

            if(is_null($error)) {
                if($_POST['password'] != $_POST['password_check']) {
                    $error = "Your passwords didn't match.";
                }
            }

            if (is_null($error)) {

                if ($this->user->fetchUser($_POST['username'])) {
                    $error = 'Your chosen username already exists. Please choose another.';
                }
            }

            if (is_null($error)) {

                $this->user->createUser(array(
                    $_POST['username'],
                    $_POST['email'],
                    $_POST['password'],
                ));

                header("Location: /user/login");
                exit;
            }
        }
        // Show the create form

        $content = '
            <form method="post">
                ' . $error . '<br />
                <label>Username</label> <input type="text" name="username" value="" /><br />
                <label>Email</label> <input type="text" name="email" value="" /><br />
                <label>Password</label> <input type="password" name="password" value="" /><br />
                <label>Password Again</label> <input type="password" name="password_check" value="" /><br />
                <input type="submit" name="create" value="Create User" />
            </form>
        ';

        require_once $this->config['layout_path'] . '/layout.phtml';
    }

    public function account()
    {
        if (!$this->getSession()->get('AUTHENTICATED')) {
            return $this->getResponse()->setRedirect('/user/login');
        }

        $username = $this->getSession()->get('username');

        $this->addResult('details', $this->getUser()->fetchUser($username));
        $this->addResult('errors', array());
        $this->addResult('message', '');

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
        $this->addResult('errors', array());

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
        $this->getResponse()->setRedirect('/');
    }
}