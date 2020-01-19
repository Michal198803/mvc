<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 04.12.2019
 * Time: 19:29
 */

namespace App\Models;


class ExpenseCategory extends \Core\Model
{
    public function __construct ($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
        $this->userId = $_SESSION['userId'];
    }

    public function loadExpenseCategoriesLimits ()
    {
        $query = "SELECT id,name,expense_limit FROM expenses_category_assigned_to_users WHERE user_id = :user_id  AND id =:expense_id ";
        $db = static::getDB();
        $stmt = $db->prepare($query);
        $stmt->execute(['user_id' => $this->userId, 'expense_id' => $this->id]);
        $this->expenseCategoryLimits = $stmt->fetchAll();
        return print json_encode($this->expenseCategoryLimits);
    }

    public function loadThisMonthLimit ()
    {
        $query = "SELECT SUM(expenses.amount) amount FROM expenses LEFT OUTER JOIN expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id WHERE 
        expenses.user_id =:user_id AND expenses_category_assigned_to_users.id =:category_id AND MONTH(expenses.date_of_expense)=:month AND YEAR(expenses.date_of_expense)=:year  ";
        $db = static::getDB();
        $stmt = $db->prepare($query);
        $stmt->execute(['user_id' => $this->userId, 'category_id' => $this->categoryId, 'year' => $this->year, 'month' => $this->month]);
        $this->expenseCategoryLimits = $stmt->fetchAll();
        return print json_encode($this->expenseCategoryLimits);
    }

    public function loadExpenseCategories ()
    {
        $query = "SELECT * FROM expenses_category_assigned_to_users WHERE user_id = $this->userId";
        $db = static::getDB();
        $stmt = $db->prepare($query);
        $stmt->execute();
        $this->expenseCategories = $stmt->fetchAll();

    }

    public function update ()
    {
        if ($this->expenseLimit == "") {
            $sql = " UPDATE expenses_category_assigned_to_users SET name =:name,expense_limit = null WHERE id =:id ";
            $db = static::getDB();
            $stmt = $db->prepare($sql);

            return $stmt->execute(['id' => $this->id, 'name' => $this->name]);
        } else {
            $sql = " UPDATE expenses_category_assigned_to_users SET name =:name,expense_limit =:expense_limit WHERE id =:id ";
            $db = static::getDB();
            $stmt = $db->prepare($sql);

            return $stmt->execute(['id' => $this->id, 'name' => $this->name, 'expense_limit' => $this->expenseLimit]);
        }
    }

    public function delete ()
    {
        $sql = "DELETE FROM expenses_category_assigned_to_users WHERE id = :id";
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        return $stmt->execute(['id' => $this->id]);
    }

    public function create ()
    {
        if (count($this->categoryNameAvailability()) == 0) {
            $sql = "INSERT INTO expenses_category_assigned_to_users( `user_id`, `name`) VALUES (:user_id,:name)";
            $db = static::getDB();
            $stmt = $db->prepare($sql);
            $stmt->execute(['user_id' => $this->userId, 'name' => $this->name]);
            return true;
        } else
            return false;
    }

    public function categoryNameAvailability ()
    {
        $query = "SELECT * FROM expenses_category_assigned_to_users WHERE user_id = :user_id AND LOWER(name) = LOWER(:name)";
        $db = static::getDB();
        $stmt = $db->prepare($query);
        $stmt->execute(['user_id' => $this->userId, 'name' => $this->name]);
        $this->rowCount = $stmt->fetchAll();
        return $this->rowCount;
    }

}