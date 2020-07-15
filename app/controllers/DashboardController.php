<?php


namespace App\controllers;


use League\Plates\Engine;
use org\camunda\php\sdk\Api;
use org\camunda\php\sdk\entity\request\ProcessDefinitionRequest;

class DashboardController extends Controller
{
    private $view;

    /**
     * DashboardController constructor.
     * @param Engine $view
     */
    public function __construct(Engine $view)
    {
        parent::__construct();
        $this->view = $view;
    }

    /**
     * Страница со списком задеплоенных в Camunda процессов
     * @throws \Exception
     */
    public function dashboard()
    {
        $camundaAPI = new Api('http://localhost:8080/engine-rest');
        $processDefinitionRequest = new ProcessDefinitionRequest();
        $processDefinitions = $camundaAPI->processDefinition->getDefinitions($processDefinitionRequest);

        echo $this->view->render("dashboard", [
            'processDefinitions' => $processDefinitions,
        ]);
    }

}