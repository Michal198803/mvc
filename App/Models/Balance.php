<?php


namespace App\Models;

use PDO;

class Balance extends \Core\Model
{
    public function __construct ($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
        $this->userId = $_SESSION['userId'];

        if (isset($this->period)) {
            $_SESSION['period'] = $this->period;
        } else $this->period = 1;
        if (isset($this->dateBegin) AND isset($this->dateEnd)) {
            $_SESSION['dateBegin'] = $this->dateBegin;
            $_SESSION['dateEnd'] = $this->dateEnd;
        }
    }

    public function getDate ()
    {
        return $this->date = date('Y-m-d');
    }

    public function loadPeriod ()
    {
        if (!isset($this->period))
            return $this->period = $_SESSION['period'];
    }

    public function loadIncomes ()
    {

        switch ($this->period) {
            case 1:
                $query = "SELECT incomes.amount, incomes_category_assigned_to_users.name, incomes.date_of_income, incomes.income_comment FROM incomes LEFT OUTER JOIN incomes_category_assigned_to_users ON incomes.income_category_assigned_to_user_id = incomes_category_assigned_to_users.id WHERE incomes.user_id = '$this->userId' AND EXTRACT(YEAR_MONTH FROM incomes.date_of_income) = EXTRACT(YEAR_MONTH FROM current_date)  order by incomes.amount desc ";
                $db = static::getDB();
                $stmt = $db->prepare($query);
                $stmt->execute();
                $this->incomes = $stmt->fetchAll();

                return $this->incomes;

                break;
            case 2:

                $query = "SELECT incomes.amount, incomes_category_assigned_to_users.name, incomes.date_of_income, incomes.income_comment FROM incomes LEFT OUTER JOIN incomes_category_assigned_to_users ON incomes.income_category_assigned_to_user_id = incomes_category_assigned_to_users.id WHERE incomes.user_id = '$this->userId' AND EXTRACT(YEAR_MONTH FROM incomes.date_of_income) = EXTRACT(YEAR_MONTH FROM current_date) - 1 order by incomes.amount desc ";
                $db = static::getDB();
                $stmt = $db->prepare($query);
                $stmt->execute();
                $this->incomes = $stmt->fetchAll();
                return $this->incomes;
                break;
            case 3:
                $query = "SELECT incomes.amount, incomes_category_assigned_to_users.name, incomes.date_of_income, incomes.income_comment FROM incomes LEFT OUTER JOIN incomes_category_assigned_to_users ON incomes.income_category_assigned_to_user_id = incomes_category_assigned_to_users.id WHERE incomes.user_id = '$this->userId'AND YEAR(incomes.date_of_income) = YEAR(current_date) order by incomes.amount desc ";
                $db = static::getDB();
                $stmt = $db->prepare($query);
                $stmt->execute();
                $this->incomes = $stmt->fetchAll();
                return $this->incomes;
                break;
            case 4:
                $this->dateBegin = $_POST['dateBegin'];
                $this->dateEnd = $_POST['dateEnd'];
                $query = "SELECT incomes.amount, incomes_category_assigned_to_users.name, incomes.date_of_income, incomes.income_comment FROM incomes LEFT OUTER JOIN incomes_category_assigned_to_users ON incomes.income_category_assigned_to_user_id = incomes_category_assigned_to_users.id WHERE incomes.user_id = '$this->userId' AND   incomes.date_of_income >='$this->dateBegin' AND incomes.date_of_income <='$this->dateEnd' order by incomes.amount desc ";
                $db = static::getDB();
                $stmt = $db->prepare($query);
                $stmt->execute();
                $this->incomes = $stmt->fetchAll();
                return $this->incomes;
                break;
        }
    }

    public function loadExpence ()
    {

        switch ($this->period) {
            case 1:
                $query = "SELECT  expenses.amount, payment_methods_assigned_to_users.name, expenses.date_of_expense, expenses_category_assigned_to_users.name name2, expenses.expense_comment FROM expenses LEFT OUTER JOIN expenses_category_assigned_to_users ON expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id LEFT OUTER JOIN payment_methods_assigned_to_users ON expenses.payment_method_assigned_to_user_id = payment_methods_assigned_to_users.id WHERE expenses.user_id = '$this->userId' AND EXTRACT(YEAR_MONTH FROM expenses.date_of_expense) = EXTRACT(YEAR_MONTH FROM current_date) order by expenses.amount desc ";
                $db = static::getDB();
                $stmt = $db->prepare($query);
                $stmt->execute();
                $this->expenses = $stmt->fetchAll();
                $expensesCategoryNumber = "SELECT expenses_category_assigned_to_users.name name ,SUM(expenses.amount) count FROM expenses LEFT OUTER JOIN expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id where expenses.user_id = '$this->userId' AND EXTRACT(YEAR_MONTH FROM expenses.date_of_expense) = EXTRACT(YEAR_MONTH FROM current_date) GROUP BY expenses_category_assigned_to_users.name";
                $stmt = $db->prepare($expensesCategoryNumber);
                $stmt->execute();
                $this->expensesCategoryNumber = $stmt->fetchAll();
                $this->expensesCategoryNumber = json_encode($this->expensesCategoryNumber);
                return $this->expenses;
                break;
            case 2:
                $query = "SELECT expenses.amount, payment_methods_assigned_to_users.name, expenses.date_of_expense, expenses_category_assigned_to_users.name name2, expenses.expense_comment FROM expenses LEFT OUTER JOIN expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id LEFT OUTER JOIN payment_methods_assigned_to_users ON expenses.payment_method_assigned_to_user_id = payment_methods_assigned_to_users.id WHERE expenses.user_id = '$this->userId'  AND EXTRACT(YEAR_MONTH FROM expenses.date_of_expense) = EXTRACT(YEAR_MONTH FROM current_date) -1 order by expenses.amount desc";
                $db = static::getDB();
                $stmt = $db->prepare($query);
                $stmt->execute();
                $this->expenses = $stmt->fetchAll();
                $expensesCategoryNumber = "SELECT expenses_category_assigned_to_users.name name ,SUM(expenses.amount) count FROM expenses LEFT OUTER JOIN expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id where expenses.user_id = '$this->userId' AND EXTRACT(YEAR_MONTH FROM expenses.date_of_expense) = EXTRACT(YEAR_MONTH FROM current_date) - 1 GROUP BY expenses_category_assigned_to_users.name";
                $stmt = $db->prepare($expensesCategoryNumber);
                $stmt->execute();
                $this->expensesCategoryNumber = $stmt->fetchAll();
                $this->expensesCategoryNumber = json_encode($this->expensesCategoryNumber);
                return $this->expenses;
                break;
            case 3:
                $query = "SELECT expenses.amount, payment_methods_assigned_to_users.name, expenses.date_of_expense, expenses_category_assigned_to_users.name name2, expenses.expense_comment FROM expenses LEFT OUTER JOIN expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id LEFT OUTER JOIN payment_methods_assigned_to_users ON expenses.payment_method_assigned_to_user_id = payment_methods_assigned_to_users.id WHERE expenses.user_id = '$this->userId' AND YEAR(expenses.date_of_expense) = YEAR(current_date) order by expenses.amount desc";
                $db = static::getDB();
                $stmt = $db->prepare($query);
                $stmt->execute();
                $this->expenses = $stmt->fetchAll();
                $expensesCategoryNumber = "SELECT expenses_category_assigned_to_users.name name ,SUM(expenses.amount) count FROM expenses LEFT OUTER JOIN expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id  WHERE expenses.user_id = '$this->userId' AND YEAR(expenses.date_of_expense) = YEAR(current_date) GROUP BY expenses_category_assigned_to_users.name";
                $stmt = $db->prepare($expensesCategoryNumber);
                $stmt->execute();
                $this->expensesCategoryNumber = $stmt->fetchAll();
                $this->expensesCategoryNumber = json_encode($this->expensesCategoryNumber);
                return $this->expenses;
                break;
            case 4:

                if (!isset($this->dateBegin) AND !isset($this->dateEnd)) {
                    $this->dateBegin = $_SESSION['dateBegin'];
                    $this->dateEnd = $_SESSION['dateEnd'];
                }

                $query = "SELECT  expenses.amount, payment_methods_assigned_to_users.name, expenses.date_of_expense, expenses_category_assigned_to_users.name name2, expenses.expense_comment FROM expenses LEFT OUTER JOIN expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id LEFT OUTER JOIN payment_methods_assigned_to_users ON expenses.payment_method_assigned_to_user_id = payment_methods_assigned_to_users.id WHERE expenses.user_id = '$this->userId' AND   expenses.date_of_expense >='$this->dateBegin' AND expenses.date_of_expense <='$this->dateEnd' order by expenses.amount desc";
                $db = static::getDB();
                $stmt = $db->prepare($query);
                $stmt->execute();
                $this->expenses = $stmt->fetchAll();
                $expensesCategoryNumber = "SELECT expenses_category_assigned_to_users.name name ,SUM(expenses.amount) count FROM expenses LEFT OUTER JOIN expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id  WHERE expenses.user_id = '$this->userId' AND   expenses.date_of_expense >='$this->dateBegin' AND expenses.date_of_expense <='$this->dateEnd' GROUP BY expenses_category_assigned_to_users.name";
                $stmt = $db->prepare($expensesCategoryNumber);
                $stmt->execute();
                $this->expensesCategoryNumber = $stmt->fetchAll();
                $this->expensesCategoryNumber = json_encode($this->expensesCategoryNumber);
                return $this->expenses;
                break;
        }
    }

}