<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 08.12.2019
 * Time: 17:58
 */

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Flash;

class UserController extends \Core\Controller
{

    public function newAction ()
    {
        $user = new User();
        $user->loadUserInformation();

        View::renderTemplate('/Setup/User.html', ['user' => $user]);
    }

    public function updateLoginAction ()
    {
        $user = new User ($_POST);

        if ($user->updateLogin() == true) {
            Flash::addMessage('Login updated successfully');
        } else {
            Flash::addMessage($user->error, $type = 'warning');
        }
    }

    public function updatePasswordAction ()
    {
        $user = new User ($_POST);

        if ($user->updatePassword() == true) {
            Flash::addMessage('Password updated successfully');
        } else {
            foreach ($user->errors as $error) {
                Flash::addMessage($error, $type = 'warning');
            }
        }
    }

}