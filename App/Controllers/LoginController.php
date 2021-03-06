<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Auth;
use \App\Flash;


class LoginController extends \Core\Controller
{


    public function newAction ()
    {
        View::renderTemplate('Login/new.html');
    }

    public function createAction ()
    {
        $user = User::authenticate($_POST['email'], $_POST['password']);

        if ($user) {

            Auth::login($user);

            Flash::addMessage('Login successful');

            $this->redirect(Auth::getReturnToPage());

        } else {

            Flash::addMessage('Login unsuccessful, please try again', Flash::WARNING);

            View::renderTemplate('Login/new.html', [
                'email' => $_POST['email'],
            ]);
        }
    }

    public function destroyAction ()
    {
        Auth::logout();

        $this->redirect('/home');
    }


    public function showLogoutMessageAction ()
    {
        Flash::addMessage('Logout successful');

        $this->redirect('/');
    }
}
