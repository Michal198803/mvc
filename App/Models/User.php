<?php

namespace App\Models;

use PDO;


class User extends \Core\Model
{

    public $errors = [];

    public function __construct ($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }

    public function getUserId ()
    {
        $sql = "SELECT id FROM users ORDER BY id DESC LIMIT 1";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $this->id = $stmt->fetchAll();

        foreach ($this->id as $id) {
            $_SESSION['userId'] = (string)$id['id'];
        }
    }

    public function loadIncomeCategories ()
    {
        $db = static::getDB();
        $sql = "SELECT incomes_category_default.name FROM mich1988_finm.incomes_category_default";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $this->incomeCategories = $stmt->fetchAll();

        $userId = $_SESSION['userId'] + 1;
        $db = static::getDB();
        foreach ($this->incomeCategories as $category) {
            $category1 = $category['name'];
            $sql = " INSERT INTO mich1988_finm.incomes_category_assigned_to_users(incomes_category_assigned_to_users.id,incomes_category_assigned_to_users.user_id,incomes_category_assigned_to_users.name) values (null,'$userId','$category1')";
            $stmt = $db->prepare($sql);
            $stmt->execute();
        }
    }

    public function loadExpenseCategories ()
    {
        $db = static::getDB();
        $sql = "SELECT expenses_category_default.name FROM mich1988_finm.expenses_category_default";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $this->expenseCategories = $stmt->fetchAll();

        $userId = $_SESSION['userId'] + 1;
        $db = static::getDB();
        foreach ($this->expenseCategories as $category) {
            $category1 = $category['name'];
            $sql = "INSERT INTO mich1988_finm.expenses_category_assigned_to_users(expenses_category_assigned_to_users.id,expenses_category_assigned_to_users.user_id,expenses_category_assigned_to_users.name) values (null,'$userId','$category1')";
            $stmt = $db->prepare($sql);
            $stmt->execute();
        }
    }

    public function loadExpensePaymentMethods ()
    {
        $db = static::getDB();
        $sql = "SELECT payment_methods_default.name FROM mich1988_finm.payment_methods_default";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $this->expensePaymentMethodsCategory = $stmt->fetchAll();

        $userId = $_SESSION['userId'] + 1;
        $db = static::getDB();

        foreach ($this->expensePaymentMethodsCategory as $category) {
            $category1 = $category['name'];
            $sql = "INSERT INTO mich1988_finm.payment_methods_assigned_to_users(payment_methods_assigned_to_users.id,payment_methods_assigned_to_users.user_id,payment_methods_assigned_to_users.name) values (null,'$userId','$category1')";
            $stmt = $db->prepare($sql);
            $stmt->execute();
        }
    }

    public function save ()
    {
        $this->validate();
        $this->getUserId();
        $this->loadIncomeCategories();
        $this->loadExpenseCategories();
        $this->loadExpensePaymentMethods();

        if (empty($this->errors)) {

            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

            $sql = 'INSERT INTO users ( login, password_hash)
                    VALUES ( :login, :password_hash)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);


            $stmt->bindValue(':login', $this->login, PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);

            return $stmt->execute();
        }

        return false;
    }

    public function validate ()
    {


        if (filter_var($this->login, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[] = 'Invalid login.';
        }
        if (static::loginExists($this->login)) {
            $this->errors[] = 'login already taken';
        }

        // Password
        if (strlen($this->password) < 6) {
            $this->errors[] = 'Please enter at least 6 characters for the password';
        }

        if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
            $this->errors[] = 'Password needs at least one letter';
        }

        if (preg_match('/.*\d+.*/i', $this->password) == 0) {
            $this->errors[] = 'Password needs at least one number';
        }
    }

    public static function loginExists ($login)
    {
        return static::findByLogin($login) !== false;
    }

    public static function findByLogin ($login)
    {
        $sql = 'SELECT * FROM users WHERE login = :login';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':login', $login, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    public static function authenticate ($login, $password)
    {
        $user = static::findByLogin($login);
        $_SESSION['userId'] = $user->id;

        if ($user) {
            if (password_verify($password, $user->password_hash)) {
                return $user;
            }
        }

        return false;
    }

    public static function findByID ($id)
    {
        $sql = 'SELECT * FROM users WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }
}
