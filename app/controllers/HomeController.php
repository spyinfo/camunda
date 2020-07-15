<?php

namespace App\controllers;

use App\components\CURL;
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;

class HomeController
{
    private $view;
    private $flash;
    private $curl;


    /**
     * HomeController constructor.
     * @param Engine $view
     * @param Flash $flash
     */
    public function __construct(Engine $view, Flash $flash, CURL $curl)
    {
        $this->view = $view;
        $this->flash = $flash;
        $this->curl = $curl;
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

    /*
     *
     */
    public function login()
    {
        // Данные в формате x-www-form-urlencoded
        $data = 'username=' . $_POST['username'] . '&password=' . $_POST['password'];

        $response = $this->curl->post('http://localhost:8080/camunda/api/admin/auth/user/default/login/welcome', $data);

        // Введенные данные верны
        if ($response) {
            $_SESSION['user'] = $response;
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