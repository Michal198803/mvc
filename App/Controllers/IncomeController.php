<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Income;
use \App\Flash;

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
            Flash::addMessage('Income added successfully');
            $this->redirect('/Income');

        } else {

            echo 'error';
        }
    }

    public function updateAction ()
    {

        $income = new Income($_POST);

        if ($income->update()) {
            Flash::addMessage('Income updated successfully');
            //    $this->redirect('/Balance');
        } else {

            echo 'error';
        }
    }

    public function deleteAction ()
    {

        $income = new Income($_POST);

        if ($income->delete()) {
            Flash::addMessage('Income deleted successfully');
            //  $this->redirect('/Expense');
        } else {

            echo 'error';
        }
    }

}
