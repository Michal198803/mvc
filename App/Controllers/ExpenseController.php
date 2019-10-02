<?php


namespace App\Controllers;

use \Core\View;
use \App\Models\Expense;
use \App\Flash;


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
            Flash::addMessage('Expense added successfully');
            $this->redirect('/Expense');

        } else {

            echo 'error';
        }
    }
}
