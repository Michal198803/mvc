<?php


namespace App\Models;


class Income extends \Core\Model
{
    public function __construct ($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }


    public function save ()
    {

        $sql = 'INSERT INTO incomes (user_id, amount, date_of_income,income_category_assigned_to_user_id,income_comment)
                    VALUES (:user_id, :amount, :date_of_income,:income_category_assigned_to_user_id,:income_comment)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        return $stmt->execute(['user_id' => $_SESSION['userId'], 'amount' => $this->amount, 'date_of_income' => $this->date, 'income_category_assigned_to_user_id' => $this->category, 'income_comment' => $this->comment]);
    }

    public function update ()
    {
        $sql = " UPDATE incomes SET income_category_assigned_to_user_id=:category,amount=:amount, date_of_income =:date,income_comment =:comment WHERE id =:id ";
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        return $stmt->execute(['category' => $this->categoryId, 'amount' => $this->amount, 'date' => $this->date, 'comment' => $this->comment, 'id' => $this->id]);
    }

    public function delete ()
    {
        $sql = "DELETE FROM incomes WHERE id = :id";
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        return $stmt->execute(['id' => $this->id]);
    }

    public function preloadCategory ()
    {
        $id = $_SESSION['userId'];

        $query = "SELECT * FROM incomes_category_assigned_to_users WHERE user_id = '$id ' ORDER BY name ASC";

        $db = static::getDB();
        $stmt = $db->prepare($query);
        $stmt->execute();
        $this->categories = $stmt->fetchAll();

        return $this->categories;
    }

    public function getDate ()
    {
        return $this->date = date('Y-m-d');
    }

}