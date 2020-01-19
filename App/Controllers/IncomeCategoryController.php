<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 07.12.2019
 * Time: 20:00
 */

namespace App\Controllers;

use App\Models\Balance;
use \Core\View;
use \App\Models\IncomeCategory;
use \App\Flash;


class IncomeCategoryController extends \Core\Controller
{
    public function newAction ()
    {
        $category = new IncomeCategory();
        $category->loadIncomeCategories();

        View::renderTemplate('/Setup/IncomeCategory.html', ['category' => $category]);
    }

    public function checkCategoryNameAvailabilityAction ()
    {
        $category = new IncomeCategory($_POST);

        $category->categoryNameAvailability();
        echo count($category->rowCount);
    }

    public function updateAction ()
    {

        $incomeCategory = new IncomeCategory($_POST);

        if ($incomeCategory->update()) {
            Flash::addMessage('Category updated successfully');
        } else {
            echo 'error';
        }
    }

    public function createAction ()
    {

        $incomeCategory = new IncomeCategory($_POST);

        if ($incomeCategory->create()) {
            Flash::addMessage('Category created successfully');
        } else {
            echo 'error';
        }
    }

    public function deleteAction ()
    {

        $incomeCategory = new IncomeCategory($_POST);

        if ($incomeCategory->delete()) {
            Flash::addMessage('Category deleted successfully');
        } else {
            echo 'error';
        }
    }

    public function validateRemoveAction ()
    {
        $balanceCategory = new Balance($_POST);
        return $balanceCategory->loadIncomesWithCategory();
    }


}