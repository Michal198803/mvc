<?php


require dirname(__DIR__) . '/vendor/autoload.php';

error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

session_start();


$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'HomeController', 'action' => 'index']);
$router->add('login', ['controller' => 'LoginController', 'action' => 'new']);
$router->add('login_create', ['controller' => 'LoginController', 'action' => 'create']);
$router->add('signup', ['controller' => 'SignupController', 'action' => 'new']);
$router->add('signupNew', ['controller' => 'SignupController', 'action' => 'create']);
$router->add('logout', ['controller' => 'LoginController', 'action' => 'destroy']);
$router->add('expense', ['controller' => 'ExpenseController', 'action' => 'new']);
$router->add('addExpense', ['controller' => 'ExpenseController', 'action' => 'create']);
$router->add('income', ['controller' => 'IncomeController', 'action' => 'new']);
$router->add('addIncome', ['controller' => 'IncomeController', 'action' => 'create']);
$router->add('balance', ['controller' => 'BalanceController', 'action' => 'create']);
$router->add('show', ['controller' => 'BalanceController', 'action' => 'create']);
$router->add('setup', ['controller' => 'SetupController', 'action' => 'new']);
$router->add('home', ['controller' => 'HomeController', 'action' => 'index']);
$router->add('home/index', ['controller' => 'HomeController', 'action' => 'index']);
$router->add('ToJson', ['controller' => 'BalanceController', 'action' => 'toJson']);
$router->add('expense_update', ['controller' => 'ExpenseController', 'action' => 'update']);
$router->add('expense_delete', ['controller' => 'ExpenseController', 'action' => 'delete']);
$router->add('income_update', ['controller' => 'IncomeController', 'action' => 'update']);
$router->add('income_delete', ['controller' => 'IncomeController', 'action' => 'delete']);
$router->add('income_category_check', ['controller' => 'IncomeCategoryController', 'action' => 'checkCategoryNameAvailability']);

$router->add('expense/category', ['controller' => 'ExpenseCategoryController', 'action' => 'new']);
$router->add('expense_category_update', ['controller' => 'ExpenseCategoryController', 'action' => 'update']);
$router->add('expense_category_delete', ['controller' => 'ExpenseCategoryController', 'action' => 'delete']);
$router->add('expense_category_add', ['controller' => 'ExpenseCategoryController', 'action' => 'create']);
$router->add('expense_category_check', ['controller' => 'ExpenseCategoryController', 'action' => 'checkCategoryNameAvailability']);


$router->add('expense/payment', ['controller' => 'ExpensePaymentMethodController', 'action' => 'new']);
$router->add('expense_payment_update', ['controller' => 'ExpensePaymentMethodController', 'action' => 'update']);
$router->add('expense_payment_method_delete', ['controller' => 'ExpensePaymentMethodController', 'action' => 'delete']);
$router->add('expense_payment_add', ['controller' => 'ExpensePaymentMethodController', 'action' => 'create']);
$router->add('expense_payment_check', ['controller' => 'ExpensePaymentMethodController', 'action' => 'checkPaymentMethodNameAvailability']);

$router->add('income/category', ['controller' => 'IncomeCategoryController', 'action' => 'new']);
$router->add('income_category_update', ['controller' => 'IncomeCategoryController', 'action' => 'update']);
$router->add('income_category_delete', ['controller' => 'IncomeCategoryController', 'action' => 'delete']);
$router->add('income_category_add', ['controller' => 'IncomeCategoryController', 'action' => 'create']);

$router->add('user', ['controller' => 'userController', 'action' => 'new']);
$router->add('user_login_change', ['controller' => 'userController', 'action' => 'updateLogin']);
$router->add('user_password_change', ['controller' => 'userController', 'action' => 'updatePassword']);

$router->add('ToJsonExpenseLimit', ['controller' => 'ExpenseCategoryController', 'action' => 'loadLimit']);
$router->add('ToJsonExpenseThisMonthLimit', ['controller' => 'ExpenseCategoryController', 'action' => 'loadThisMonthLimit']);


$router->add('validate_remove_expense_category', ['controller' => 'ExpenseCategoryController', 'action' => 'validateRemove']);
$router->add('validate_remove_income_category', ['controller' => 'IncomeCategoryController', 'action' => 'validateRemove']);
$router->add('validate_remove_expense_payment_method', ['controller' => 'ExpensePaymentMethodController', 'action' => 'validateRemove']);


$router->add('{controller}/{action}');

$router->dispatch($_SERVER['QUERY_STRING']);
