<?php


namespace App\Controllers;

use \Core\View;
use \App\Models\Expense;

class ExpenseController extends \Core\Controller
{


    public function newAction ()
    {

        $expense = new Expense();
        $expense->preloadPaymentMethods();
        $expense->preloadCategories();
        $expense->getDate();

        View::renderTemplate('/Expense/Expense.html', ['expense' => $expense]);

    }


    public function createAction ()
    {

        $expense = new Expense($_POST);


        if ($expense->save()) {

            $this->redirect('/Expense');

        } else {

            echo 'error';
        }
    }
}
