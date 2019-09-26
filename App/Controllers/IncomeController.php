<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Income;


class IncomeController extends \Core\Controller
{

    public function newAction ()
    {
        $income = new Income ();
        $income->preloadCategory();
        $income->getDate();

        View::renderTemplate('/Income/Income.html', ['income' => $income]);
    }

    public function createAction ()
    {
        $income = new Income($_POST);

        if ($income->save()) {

            $this->redirect('/Income');

        } else {

            echo 'error';
        }
    }
}
