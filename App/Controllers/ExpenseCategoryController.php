<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 04.12.2019
 * Time: 19:47
 */

namespace App\Controllers;

use App\Models\Balance;
use \Core\View;
use \App\Models\ExpenseCategory;
use \App\Flash;


class ExpenseCategoryController extends \Core\Controller
{
    public function newAction ()
    {
        $category = new ExpenseCategory();
        $category->loadExpenseCategories();
        View::renderTemplate('/Setup/ExpenseCategory.html', ['category' => $category]);
    }

    public function checkCategoryNameAvailabilityAction ()
    {
        $category = new ExpenseCategory($_POST);

        $category->categoryNameAvailability();
        echo count($category->rowCount);
    }

    public function updateAction ()
    {

        $expenseCategory = new ExpenseCategory($_POST);

        if ($expenseCategory->update()) {
            Flash::addMessage('Category updated successfully');
        } else {
            echo 'error';
        }
    }

    public function createAction ()
    {

        $expenseCategory = new ExpenseCategory($_POST);

        if ($expenseCategory->create() == true) {
            Flash::addMessage('Category created successfully');
        } else {
            Flash::addMessage('Category not created', $type = 'warning');
        }
    }

    public function deleteAction ()
    {

        $expenseCategory = new ExpenseCategory($_POST);

        if ($expenseCategory->delete()) {
            Flash::addMessage('Category deleted successfully');
        } else {
            echo 'error';
        }
    }

    public function loadLimitAction ()
    {

        $expenseCategory = new ExpenseCategory($_POST);
        return $expenseCategory->loadExpenseCategoriesLimits();
    }

    public function validateRemoveAction ()
    {
        $balanceCategory = new Balance($_POST);
        return $balanceCategory->loadExpensesWithCategory();
    }

    public function loadThisMonthLimitAction ()
    {

        $expenseCategory = new ExpenseCategory($_POST);
        return $expenseCategory->loadThisMonthLimit();
    }
}