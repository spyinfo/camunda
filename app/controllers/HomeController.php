<?php

namespace App\controllers;

use League\Plates\Engine;

class HomeController
{
    private $view;
    private $database;


    /**
     * HomeController constructor.
     * @param Engine $view
     */
    public function __construct(Engine $view)
    {
        $this->view = $view;
    }

    /**
     * Главная страница
     */
    public function index()
    {
        $camundaAPI = new \org\camunda\php\sdk\Api('http://localhost:8080/engine-rest');
        $processDefinitionRequest = new \org\camunda\php\sdk\entity\request\ProcessDefinitionRequest();
        $processDefinitions = $camundaAPI->processDefinition->getDefinitions($processDefinitionRequest);

        foreach($processDefinitions AS $data) {
            echo 'Process deployment id: ' . $data->getDeploymentId() . '<br />';
        }

        // передаем для отображения
//        echo $this->view->render("index");
    }
}