<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 07.12.2019
 * Time: 20:29
 */

namespace App\Controllers;

use \Core\View;
use \App\Models\ExpensePaymentMethod;
use \App\Models\Balance;
use \App\Flash;


class ExpensePaymentMethodController extends \Core\Controller
{
    public function newAction ()
    {
        $expensePaymentMethod = new ExpensePaymentMethod();
        $expensePaymentMethod->loadPaymentMethods();
        View::renderTemplate('/Setup/ExpensePaymentMethod.html', ['payment' => $expensePaymentMethod]);
    }

    public function checkPaymentMethodNameAvailabilityAction ()
    {
        $paymentMethod = new ExpensePaymentMethod($_POST);

        $paymentMethod->paymentMethodNameAvailability();
        echo count($paymentMethod->rowCount);
    }

    public function updateAction ()
    {

        $expensePaymentMethod = new ExpensePaymentMethod($_POST);

        if ($expensePaymentMethod->update()) {
            Flash::addMessage('Payment method updated successfully');
        } else {
            echo 'error';
        }
    }

    public function createAction ()
    {

        $expensePaymentMethod = new ExpensePaymentMethod($_POST);

        if ($expensePaymentMethod->create()) {
            Flash::addMessage('Payment method created successfully');
        } else {
            echo 'error';
        }
    }

    public function deleteAction ()
    {

        $expensePaymentMethod = new ExpensePaymentMethod($_POST);

        if ($expensePaymentMethod->delete()) {
            Flash::addMessage('Payment method deleted successfully');
        } else {
            echo 'error';
        }
    }

    public function validateRemoveAction ()
    {
        $expensePaymentMethodBalance = new Balance($_POST);
        return $expensePaymentMethodBalance->loadExpensesWithPaymentMethods();
    }


}