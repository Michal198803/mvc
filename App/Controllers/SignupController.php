<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;


class SignupController extends \Core\Controller
{

    public function newAction ()
    {
        View::renderTemplate('Signup/new.html');
    }

    public function createAction ()
    {
        var_dump($_POST);
        $user = new User($_POST);

        if ($user->save()) {

            $this->redirect('/login');

        } else {

            View::renderTemplate('Signup/new.html', [
                'user' => $user
            ]);

        }
    }

    public function successAction ()
    {
        View::renderTemplate('/Home/index.html');
    }
}
