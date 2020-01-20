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
        } else {
            if (isset($_SESSION['period']))
                $this->period = $_SESSION['period'];
            else
                $this->period = 1;
        }

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
                $query = "SELECT incomes.income_category_assigned_to_user_id expensePaymentMethodId,incomes.id,incomes.amount, incomes_category_assigned_to_users.name, incomes.date_of_income, incomes.income_comment FROM incomes LEFT OUTER JOIN incomes_category_assigned_to_users ON incomes.income_category_assigned_to_user_id = incomes_category_assigned_to_users.id WHERE incomes.user_id = '$this->userId' AND EXTRACT(YEAR_MONTH FROM incomes.date_of_income) = EXTRACT(YEAR_MONTH FROM current_date)  order by incomes.amount desc ";
                $db = static::getDB();
                $stmt = $db->prepare($query);
                $stmt->execute();
                $this->incomes = $stmt->fetchAll();
                $query = "SELECT * FROM incomes_category_assigned_to_users WHERE user_id = '$this->userId'  ";
                $db = static::getDB();
                $stmt = $db->prepare($query);
                $stmt->execute();
                $this->incomeCategories = $stmt->fetchAll();
                return $this->incomes;

                break;
            case 2:
                if ((int)date("m") != 1) {
                    $query = "SELECT incomes.income_category_assigned_to_user_id expensePaymentMethodId,incomes.id,incomes.amount, incomes_category_assigned_to_users.name, incomes.date_of_income, incomes.income_comment FROM incomes LEFT OUTER JOIN incomes_category_assigned_to_users ON incomes.income_category_assigned_to_user_id = incomes_category_assigned_to_users.id WHERE incomes.user_id = '$this->userId' AND EXTRACT(YEAR_MONTH FROM incomes.date_of_income) = EXTRACT(YEAR_MONTH FROM current_date) - 1 order by incomes.amount desc ";
                    $db = static::getDB();
                    $stmt = $db->prepare($query);
                    $stmt->execute();
                    $this->incomes = $stmt->fetchAll();
                    $query = "SELECT * FROM incomes_category_assigned_to_users WHERE user_id = '$this->userId'  ";
                    $db = static::getDB();
                    $stmt = $db->prepare($query);
                    $stmt->execute();
                    $this->incomeCategories = $stmt->fetchAll();
                    return $this->incomes;
                    break;
                } else {
                    $query = "SELECT incomes.income_category_assigned_to_user_id expensePaymentMethodId,incomes.id,incomes.amount, incomes_category_assigned_to_users.name, incomes.date_of_income, incomes.income_comment FROM incomes LEFT OUTER JOIN incomes_category_assigned_to_users ON incomes.income_category_assigned_to_user_id = incomes_category_assigned_to_users.id WHERE incomes.user_id = '$this->userId' AND EXTRACT(YEAR_MONTH FROM incomes.date_of_income) = EXTRACT(YEAR_MONTH FROM current_date) - 89 order by incomes.amount desc ";
                    $db = static::getDB();
                    $stmt = $db->prepare($query);
                    $stmt->execute();
                    $this->incomes = $stmt->fetchAll();
                    $query = "SELECT * FROM incomes_category_assigned_to_users WHERE user_id = '$this->userId'  ";
                    $db = static::getDB();
                    $stmt = $db->prepare($query);
                    $stmt->execute();
                    $this->incomeCategories = $stmt->fetchAll();
                    return $this->incomes;
                    break;
                }
            case 3:
                $query = "SELECT incomes.income_category_assigned_to_user_id expensePaymentMethodId, incomes.id,incomes.amount, incomes_category_assigned_to_users.name, incomes.date_of_income, incomes.income_comment FROM incomes LEFT OUTER JOIN incomes_category_assigned_to_users ON incomes.income_category_assigned_to_user_id = incomes_category_assigned_to_users.id WHERE incomes.user_id = '$this->userId'AND YEAR(incomes.date_of_income) = YEAR(current_date) order by incomes.amount desc ";
                $db = static::getDB();
                $stmt = $db->prepare($query);
                $stmt->execute();
                $this->incomes = $stmt->fetchAll();
                $query = "SELECT * FROM incomes_category_assigned_to_users WHERE user_id = '$this->userId'  ";
                $db = static::getDB();
                $stmt = $db->prepare($query);
                $stmt->execute();
                $this->incomeCategories = $stmt->fetchAll();
                return $this->incomes;
                break;
            case 4:
                if (!isset($this->dateBegin) AND !isset($this->dateEnd)) {
                    $this->dateBegin = $_SESSION['dateBegin'];
                    $this->dateEnd = $_SESSION['dateEnd'];
                }
                $query = "SELECT incomes.income_category_assigned_to_user_id expensePaymentMethodId,incomes.id,incomes.amount, incomes_category_assigned_to_users.name, incomes.date_of_income, incomes.income_comment FROM incomes LEFT OUTER JOIN incomes_category_assigned_to_users ON incomes.income_category_assigned_to_user_id = incomes_category_assigned_to_users.id WHERE incomes.user_id = '$this->userId' AND   incomes.date_of_income >='$this->dateBegin' AND incomes.date_of_income <='$this->dateEnd' order by incomes.amount desc ";
                $db = static::getDB();
                $stmt = $db->prepare($query);
                $stmt->execute();
                $this->incomes = $stmt->fetchAll();
                $query = "SELECT * FROM incomes_category_assigned_to_users WHERE user_id = '$this->userId'  ";
                $db = static::getDB();
                $stmt = $db->prepare($query);
                $stmt->execute();
                $this->incomeCategories = $stmt->fetchAll();
                return $this->incomes;
                break;
        }
    }

    public function loadExpense ()
    {

        switch ($this->period) {
            case 1:
                $query = "SELECT expenses.expense_category_assigned_to_user_id categoryId, expenses.payment_method_assigned_to_user_id paymentId, expenses.id,expenses.amount, payment_methods_assigned_to_users.name, expenses.date_of_expense, expenses_category_assigned_to_users.name name2, expenses.expense_comment FROM expenses LEFT OUTER JOIN expenses_category_assigned_to_users ON expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id LEFT OUTER JOIN payment_methods_assigned_to_users ON expenses.payment_method_assigned_to_user_id = payment_methods_assigned_to_users.id WHERE expenses.user_id = '$this->userId' AND EXTRACT(YEAR_MONTH FROM expenses.date_of_expense) = EXTRACT(YEAR_MONTH FROM current_date) order by expenses.amount desc ";
                $db = static::getDB();
                $stmt = $db->prepare($query);
                $stmt->execute();
                $this->expenses = $stmt->fetchAll();
                $query = "SELECT * FROM expenses_category_assigned_to_users WHERE user_id = '$this->userId'  ";
                $db = static::getDB();
                $stmt = $db->prepare($query);
                $stmt->execute();
                $this->expensesCategories = $stmt->fetchAll();
                $query = "SELECT * FROM payment_methods_assigned_to_users WHERE user_id = '$this->userId' ";
                $db = static::getDB();
                $stmt = $db->prepare($query);
                $stmt->execute();
                $this->paymentMethods = $stmt->fetchAll();
                $expensesCategoryNumber = "SELECT expenses_category_assigned_to_users.name name ,SUM(expenses.amount) count FROM expenses LEFT OUTER JOIN expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id where expenses.user_id = '$this->userId' AND EXTRACT(YEAR_MONTH FROM expenses.date_of_expense) = EXTRACT(YEAR_MONTH FROM current_date) GROUP BY expenses_category_assigned_to_users.name";
                $stmt = $db->prepare($expensesCategoryNumber);
                $stmt->execute();
                $this->expensesCategoryNumber = $stmt->fetchAll();
                $this->expensesCategoryNumber = json_encode($this->expensesCategoryNumber);

                return $this->expenses;
                break;
            case 2:
                if ((int)date("m") != 1) {
                    $query = "SELECT expenses.expense_category_assigned_to_user_id  categoryId, expenses.payment_method_assigned_to_user_id paymentId, expenses.id,expenses.amount, payment_methods_assigned_to_users.name, expenses.date_of_expense, expenses_category_assigned_to_users.name name2, expenses.expense_comment FROM expenses LEFT OUTER JOIN expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id LEFT OUTER JOIN payment_methods_assigned_to_users ON expenses.payment_method_assigned_to_user_id = payment_methods_assigned_to_users.id WHERE expenses.user_id = '$this->userId'  AND EXTRACT(YEAR_MONTH FROM expenses.date_of_expense) = EXTRACT(YEAR_MONTH FROM current_date) -1 order by expenses.amount desc";
                    $db = static::getDB();
                    $stmt = $db->prepare($query);
                    $stmt->execute();
                    $this->expenses = $stmt->fetchAll();
                    $query = "SELECT * FROM expenses_category_assigned_to_users WHERE user_id = '$this->userId' ";
                    $db = static::getDB();
                    $stmt = $db->prepare($query);
                    $stmt->execute();
                    $this->expensesCategories = $stmt->fetchAll();
                    $query = "SELECT * FROM payment_methods_assigned_to_users WHERE user_id = '$this->userId' ";
                    $db = static::getDB();
                    $stmt = $db->prepare($query);
                    $stmt->execute();
                    $this->paymentMethods = $stmt->fetchAll();
                    $expensesCategoryNumber = "SELECT expenses_category_assigned_to_users.name name ,SUM(expenses.amount) count FROM expenses LEFT OUTER JOIN expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id where expenses.user_id = '$this->userId' AND EXTRACT(YEAR_MONTH FROM expenses.date_of_expense) = EXTRACT(YEAR_MONTH FROM current_date) - 1 GROUP BY expenses_category_assigned_to_users.name";
                    $stmt = $db->prepare($expensesCategoryNumber);
                    $stmt->execute();
                    $this->expensesCategoryNumber = $stmt->fetchAll();
                    $this->expensesCategoryNumber = json_encode($this->expensesCategoryNumber);
                    return $this->expenses;
                    break;
                } else {
                    $query = "SELECT expenses.expense_category_assigned_to_user_id  categoryId, expenses.payment_method_assigned_to_user_id paymentId, expenses.id,expenses.amount, payment_methods_assigned_to_users.name, expenses.date_of_expense, expenses_category_assigned_to_users.name name2, expenses.expense_comment FROM expenses LEFT OUTER JOIN expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id LEFT OUTER JOIN payment_methods_assigned_to_users ON expenses.payment_method_assigned_to_user_id = payment_methods_assigned_to_users.id WHERE expenses.user_id = '$this->userId'  AND EXTRACT(YEAR_MONTH FROM expenses.date_of_expense) = EXTRACT(YEAR_MONTH FROM current_date) -89 order by expenses.amount desc";
                    $db = static::getDB();
                    $stmt = $db->prepare($query);
                    $stmt->execute();
                    $this->expenses = $stmt->fetchAll();
                    $query = "SELECT * FROM expenses_category_assigned_to_users WHERE user_id = '$this->userId' ";
                    $db = static::getDB();
                    $stmt = $db->prepare($query);
                    $stmt->execute();
                    $this->expensesCategories = $stmt->fetchAll();
                    $query = "SELECT * FROM payment_methods_assigned_to_users WHERE user_id = '$this->userId' ";
                    $db = static::getDB();
                    $stmt = $db->prepare($query);
                    $stmt->execute();
                    $this->paymentMethods = $stmt->fetchAll();
                    $expensesCategoryNumber = "SELECT expenses_category_assigned_to_users.name name ,SUM(expenses.amount) count FROM expenses LEFT OUTER JOIN expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id where expenses.user_id = '$this->userId' AND EXTRACT(YEAR_MONTH FROM expenses.date_of_expense) = EXTRACT(YEAR_MONTH FROM current_date) - 89 GROUP BY expenses_category_assigned_to_users.name";
                    $stmt = $db->prepare($expensesCategoryNumber);
                    $stmt->execute();
                    $this->expensesCategoryNumber = $stmt->fetchAll();
                    $this->expensesCategoryNumber = json_encode($this->expensesCategoryNumber);
                    return $this->expenses;
                    break;
                }
            case 3:
                $query = "SELECT expenses.expense_category_assigned_to_user_id categoryId, expenses.payment_method_assigned_to_user_id paymentId, expenses.id,expenses.amount, payment_methods_assigned_to_users.name, expenses.date_of_expense, expenses_category_assigned_to_users.name name2, expenses.expense_comment FROM expenses LEFT OUTER JOIN expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id LEFT OUTER JOIN payment_methods_assigned_to_users ON expenses.payment_method_assigned_to_user_id = payment_methods_assigned_to_users.id WHERE expenses.user_id = '$this->userId' AND YEAR(expenses.date_of_expense) = YEAR(current_date) order by expenses.amount desc";
                $db = static::getDB();
                $stmt = $db->prepare($query);
                $stmt->execute();
                $this->expenses = $stmt->fetchAll();
                $query = "SELECT * FROM expenses_category_assigned_to_users WHERE user_id = '$this->userId' ";
                $db = static::getDB();
                $stmt = $db->prepare($query);
                $stmt->execute();
                $this->expensesCategories = $stmt->fetchAll();
                $query = "SELECT * FROM payment_methods_assigned_to_users WHERE user_id = '$this->userId' ";
                $db = static::getDB();
                $stmt = $db->prepare($query);
                $stmt->execute();
                $this->paymentMethods = $stmt->fetchAll();
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
                $query = "SELECT expenses.expense_category_assigned_to_user_id categoryId, expenses.payment_method_assigned_to_user_id paymentId,  expenses.id,expenses.amount, payment_methods_assigned_to_users.name, expenses.date_of_expense, expenses_category_assigned_to_users.name name2, expenses.expense_comment FROM expenses LEFT OUTER JOIN expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id LEFT OUTER JOIN payment_methods_assigned_to_users ON expenses.payment_method_assigned_to_user_id = payment_methods_assigned_to_users.id WHERE expenses.user_id = '$this->userId' AND   expenses.date_of_expense >='$this->dateBegin' AND expenses.date_of_expense <='$this->dateEnd' order by expenses.amount desc";
                $db = static::getDB();
                $stmt = $db->prepare($query);
                $stmt->execute();
                $this->expenses = $stmt->fetchAll();
                $query = "SELECT * FROM expenses_category_assigned_to_users WHERE user_id = '$this->userId' ";
                $db = static::getDB();
                $stmt = $db->prepare($query);
                $stmt->execute();
                $this->expensesCategories = $stmt->fetchAll();
                $query = "SELECT * FROM payment_methods_assigned_to_users WHERE user_id = '$this->userId' ";
                $db = static::getDB();
                $stmt = $db->prepare($query);
                $stmt->execute();
                $this->paymentMethods = $stmt->fetchAll();
                $expensesCategoryNumber = "SELECT expenses_category_assigned_to_users.name name ,SUM(expenses.amount) count FROM expenses LEFT OUTER JOIN expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id  WHERE expenses.user_id = '$this->userId' AND   expenses.date_of_expense >='$this->dateBegin' AND expenses.date_of_expense <='$this->dateEnd' GROUP BY expenses_category_assigned_to_users.name";
                $stmt = $db->prepare($expensesCategoryNumber);
                $stmt->execute();
                $this->expensesCategoryNumber = $stmt->fetchAll();
                $this->expensesCategoryNumber = json_encode($this->expensesCategoryNumber);
                return $this->expenses;
                break;
        }
    }

    public function loadExpensesWithCategory ()
    {
        $query = "SELECT expenses.id,expenses.expense_category_assigned_to_user_id expenseCategoryId, expenses.payment_method_assigned_to_user_id paymentId, expenses.id,expenses.amount, payment_methods_assigned_to_users.name, expenses.date_of_expense, expenses_category_assigned_to_users.name name2, expenses.expense_comment FROM expenses LEFT OUTER JOIN expenses_category_assigned_to_users ON expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id LEFT OUTER JOIN payment_methods_assigned_to_users ON expenses.payment_method_assigned_to_user_id = payment_methods_assigned_to_users.id WHERE expenses.user_id =:user_id AND expenses.expense_category_assigned_to_user_id =:category_id ";
        $db = static::getDB();
        $stmt = $db->prepare($query);
        $stmt->execute(['user_id' => $this->userId, 'category_id' => $this->categoryId]);
        $this->expenses = $stmt->fetchAll();
        return print json_encode($this->expenses);
    }

    public function loadIncomesWithCategory ()
    {
        $query = "SELECT incomes.id,incomes.income_category_assigned_to_user_id expensePaymentMethodId, incomes.id, incomes.date_of_income, incomes_category_assigned_to_users.name name2, incomes.income_comment,incomes.amount FROM incomes LEFT OUTER JOIN incomes_category_assigned_to_users ON income_category_assigned_to_user_id = incomes_category_assigned_to_users.id WHERE incomes.user_id =:user_id AND incomes.income_category_assigned_to_user_id =:category_id ";
        $db = static::getDB();
        $stmt = $db->prepare($query);
        $stmt->execute(['user_id' => $this->userId, 'category_id' => $this->categoryId]);
        $this->incomes = $stmt->fetchAll();
        return print json_encode($this->incomes);
    }

    public function loadExpensesWithPaymentMethods ()
    {
        $query = "SELECT expenses.id,expenses.expense_category_assigned_to_user_id expenseCategoryId, expenses.payment_method_assigned_to_user_id paymentId, expenses.id,expenses.amount, payment_methods_assigned_to_users.name, expenses.date_of_expense, expenses_category_assigned_to_users.name name2, expenses.expense_comment FROM expenses LEFT OUTER JOIN expenses_category_assigned_to_users ON expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id LEFT OUTER JOIN payment_methods_assigned_to_users ON expenses.payment_method_assigned_to_user_id = payment_methods_assigned_to_users.id WHERE expenses.user_id =:user_id AND expenses.payment_method_assigned_to_user_id =:payment_id ";
        $db = static::getDB();
        $stmt = $db->prepare($query);
        $stmt->execute(['user_id' => $this->userId, 'payment_id' => $this->paymentId]);
        $this->expenses = $stmt->fetchAll();
        return print json_encode($this->expenses);
    }

}