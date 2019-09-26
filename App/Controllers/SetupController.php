<?php

namespace App\Controllers;

use \Core\View;


class SetupController extends \Core\Controller
{

    public function newAction ()
    {
        View::renderTemplate('Setup/Setup.html', []);
    }
}
