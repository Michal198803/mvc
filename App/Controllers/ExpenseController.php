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
            View::renderTemplate('/Balance/Balance.html', ['expense' => $expense]);
            Flash::addMessage('Expense added successfully');

        } else {
            echo 'error';
        }
    }

    public function updateAction ()
    {

        $expense = new Expense($_POST);

        if ($expense->update()) {
            Flash::addMessage('Expense updated successfully');
        } else {

            echo 'error';
        }
    }

    public function deleteAction ()
    {

        $expense = new Expense($_POST);

        if ($expense->delete()) {
            Flash::addMessage('Expense deleted successfully');
        } else {

            echo 'error';
        }
    }


}
