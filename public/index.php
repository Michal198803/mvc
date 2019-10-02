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
$router->add('login/create', ['controller' => 'LoginController', 'action' => 'create']);
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
$router->add('{controller}/{action}');

$router->dispatch($_SERVER['QUERY_STRING']);
