<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Balance;

class BalanceController extends \Core\Controller
{


    public function newAction ()
    {
        View::renderTemplate('/Balance/Balance.html');
    }

    public function createAction ()
    {
        $balance = new Balance($_POST);
        $_SESSION['period'] = $balance->period;
        $balance->getDate();
        $balance->loadIncomes();
        $balance->loadExpence();


        View::renderTemplate('/Balance/Balance.html', ['balance' => $balance]);

    }

    public function toJsonAction ()
    {
        $balance = new Balance($_POST);

        $balance->loadPeriod();
        $balance->getDate();
        $balance->loadExpence();
        return print $balance->expensesCategoryNumber;
    }
}
