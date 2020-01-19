<?php


namespace App\Models;


class Expense extends \Core\Model
{

    public function __construct ($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }

    public function save ()
    {
        $sql = 'INSERT INTO expenses (user_id, expense_category_assigned_to_user_id, payment_method_assigned_to_user_id, amount, date_of_expense, expense_comment) 
                VALUES (:user_id,:expense_category_assigned_to_user_id,:payment_method_assigned_to_user_id,:amount,:date_of_expense,:expense_comment)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        return $stmt->execute(['user_id' => $_SESSION['userId'], 'amount' => $this->amount, 'date_of_expense' => $this->date, 'expense_category_assigned_to_user_id' => $this->category, 'expense_comment' => $this->comment, 'payment_method_assigned_to_user_id' => $this->payment]);
    }

    public function update ()
    {
        $sql = " UPDATE expenses SET expense_category_assigned_to_user_id=:category,payment_method_assigned_to_user_id=:payment,amount=:amount, date_of_expense =:date,expense_comment =:comment WHERE id =:id ";
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        return $stmt->execute(['category' => $this->categoryId, 'payment' => $this->paymentId, 'amount' => $this->amount, 'date' => $this->date, 'comment' => $this->comment, 'id' => $this->id]);
    }

    public function delete ()
    {
        $sql = "DELETE FROM expenses WHERE id = :id";
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        return $stmt->execute(['id' => $this->id]);
    }


    public function preloadCategories ()
    {
        $id = $_SESSION['userId'];
        $query = "SELECT * FROM expenses_category_assigned_to_users WHERE user_id = '$id ' ORDER BY name  ASC";

        $db = static::getDB();
        $stmt = $db->prepare($query);
        $stmt->execute();
        $this->categories = $stmt->fetchAll();

        return $this->categories;
    }

    public function preloadPaymentMethods ()
    {
        $id = $_SESSION['userId'];
        $query = "SELECT * FROM payment_methods_assigned_to_users WHERE user_id = '$id ' ORDER BY name ASC";

        $db = static::getDB();
        $stmt = $db->prepare($query);
        $stmt->execute();
        $this->paymentMethods = $stmt->fetchAll();

        return $this->paymentMethods;
    }

    public function getDate ()
    {
        return $this->date = date('Y-m-d');
    }

}