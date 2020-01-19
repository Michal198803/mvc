<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 07.12.2019
 * Time: 20:29
 */

namespace App\Models;


class ExpensePaymentMethod extends \Core\Model
{
    public function __construct ($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
        $this->userId = $_SESSION['userId'];
    }


    public function loadPaymentMethods ()
    {
        $query = "SELECT * FROM payment_methods_assigned_to_users WHERE user_id = $this->userId";
        $db = static::getDB();
        $stmt = $db->prepare($query);
        $stmt->execute();
        $this->paymentMethods = $stmt->fetchAll();
    }

    public function update ()
    {
        $sql = " UPDATE payment_methods_assigned_to_users SET name =:name WHERE id =:id ";
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        return $stmt->execute(['id' => $this->id, 'name' => $this->name]);
    }

    public function delete ()
    {
        $sql = "DELETE FROM payment_methods_assigned_to_users WHERE id = :id";
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        return $stmt->execute(['id' => $this->id]);
    }

    public function create ()
    {
        if (count($this->paymentMethodNameAvailability()) == 0) {
            $sql = "INSERT INTO payment_methods_assigned_to_users( `user_id`, `name`) VALUES (:user_id,:name)";

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            return $stmt->execute(['user_id' => $this->userId, 'name' => $this->name]);
        } else
            return false;
    }


    public function paymentMethodNameAvailability ()
    {
        $query = "SELECT * FROM payment_methods_assigned_to_users WHERE user_id = :user_id AND LOWER(name) = LOWER(:name)";
        $db = static::getDB();
        $stmt = $db->prepare($query);
        $stmt->execute(['user_id' => $this->userId, 'name' => $this->name]);
        $this->rowCount = $stmt->fetchAll();
        return $this->rowCount;
    }

}