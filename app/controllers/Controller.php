<?php


namespace App\controllers;


class Controller
{
    public function __construct()
    {
        // Если неавторизованный пользователь вручную изменил URL на /dashboard
        if (!$_SESSION['user']) {
            echo "ERROR 404. Go back"; exit;
        }
    }

}