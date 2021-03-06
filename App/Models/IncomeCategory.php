<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 04.12.2019
 * Time: 19:28
 */

namespace App\Models;


class IncomeCategory extends \Core\Model
{

    public function __construct ($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
        $this->userId = $_SESSION['userId'];
    }


    public function loadIncomeCategories ()
    {
        $query = "SELECT * FROM incomes_category_assigned_to_users WHERE user_id = $this->userId";
        $db = static::getDB();
        $stmt = $db->prepare($query);
        $stmt->execute();
        $this->incomeCategories = $stmt->fetchAll();
    }

    public function update ()
    {

        $sql = " UPDATE incomes_category_assigned_to_users SET name =:name,income_limit = null WHERE id =:id ";
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        return $stmt->execute(['id' => $this->id, 'name' => $this->name]);
    }

    public function delete ()
    {
        $sql = "DELETE FROM incomes_category_assigned_to_users WHERE id = :id";
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        return $stmt->execute(['id' => $this->id]);
    }

    public function create ()
    {
        if (count($this->categoryNameAvailability()) == 0) {
            $sql = "INSERT INTO incomes_category_assigned_to_users( `user_id`, `name`) VALUES (:user_id,:name)";

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->execute(['user_id' => $this->userId, 'name' => $this->name]);
            return true;
        } else
            return false;
    }

    public function categoryNameAvailability ()
    {
        $query = "SELECT * FROM incomes_category_assigned_to_users WHERE user_id = :user_id AND LOWER(name) = LOWER(:name)";
        $db = static::getDB();
        $stmt = $db->prepare($query);
        $stmt->execute(['user_id' => $this->userId, 'name' => $this->name]);
        $this->rowCount = $stmt->fetchAll();
        return $this->rowCount;
    }

}