<?php

namespace App\controllers;

use League\Plates\Engine;
use org\camunda\php\sdk\Api;
use org\camunda\php\sdk\entity\request\ProcessDefinitionRequest;
use Tamtamchik\SimpleFlash\Flash;

class HomeController
{
    private $view;
    private $flash;


    /**
     * HomeController constructor.
     * @param Engine $view
     * @param Flash $flash
     */
    public function __construct(Engine $view, Flash $flash)
    {
        $this->view = $view;
        $this->flash = $flash;
    }

    /**
     *  Главная страница
     */
    public function index()
    {
        // Если пользователь в системе, то РЕДИРЕКТИМ в страницу dashboard.
        // Иначе ПОКАЗЫВАЕМ экран входа
        if ($this->check()) {
            header("Location: /dashboard");
        } else {
            echo $this->view->render("login");
        }
    }


    /**
     * Страница со списком задеплоенных в Camunda процессов
     * @throws \Exception
     */
    public function dashboard()
    {
        if ($this->check()) {

            $camundaAPI = new Api('http://localhost:8080/engine-rest');
            $processDefinitionRequest = new ProcessDefinitionRequest();
            $processDefinitions = $camundaAPI->processDefinition->getDefinitions($processDefinitionRequest);

            echo $this->view->render("dashboard", [
                'processDefinitions' => $processDefinitions,
            ]);
        } else {
            header("Location: /");
        }
    }

    /*
     *
     */
    public function login()
    {
        // тут должна быть отправка запроса на REST API Camunda.
        // так как я не смог решить проблему CORS и 403 ошибки, то решил сделать fake проверку.
        // CURL

        // Fake проверка
        if ($_POST['username'] == 'demo' && $_POST['password'] == 'demo') {
            $_SESSION['user'] = [
                'id' => '1',
                'username' => $_POST['username']
            ];
            header("Location: /dashboard");
        } else {
            $this->flash->error("Неверно введён логин или пароль!");
            header("Location: /");
        }
    }

    /*
     * Выход
     */
    public function logout()
    {
        unset($_SESSION['user']);
        header("Location: /");
    }

    /**
     * Проверяем, пользователь в системе или нет
     *
     * @return bool
     */
    private function check()
    {
        return (isset($_SESSION['user'])) ? true : false;
    }
}