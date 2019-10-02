<?php

namespace App\Controllers;

use \App\Models\User;

class Account extends \Core\Controller
{

    public function validateLoginAction ()
    {
        $is_valid = !User::loginExists($_GET['login'], $_GET['ignore_id'] ?? null);

        header('Content-Type: application/json');
        echo json_encode($is_valid);
    }
}
