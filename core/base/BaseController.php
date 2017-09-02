<?php

/**
 * Created by PhpStorm.
 * User: misha
 * Date: 31.08.17
 * Time: 23:29
 */

namespace Mvc\Core\Base;

use MvcKernel;

/**
 * Class BaseController
 * @package Mvc\Core\Base
 */
class BaseController
{

    private $currentAction;
    private $currentController;
    private $params;
    public static $controllerNamespace = '\Controllers';


    public $layout = 'main';
    /**
     * BaseController constructor.
     * @param $actionName
     * @param $params
     * @throws BaseException
     */
    public function __construct($actionName, $params)
    {
        if (!$this->checkAction($actionName)) throw new BaseException('invalid action name');
    }

    /**
     * @param $actionName
     * @return bool
     */
    private function checkAction($actionName)
    {
        $this->currentAction = $actionName;
        $actionName = $this->getMethodActionName();
        if (method_exists($this, $actionName)) {
            return true;
        }
        return false;
    }

    /**
     * run current action
     */
    public function runAction()
    {
        $actionName = $this->getMethodActionName();
        return $this->$actionName();
    }

    /**
     * @return string
     */
    public function getMethodActionName(){
        return 'action' . ucfirst($this->currentAction);;
    }

    /**
     * @param $controllerName
     * @param $actionName
     * @param $params
     * @return mixed
     * @throws BaseException
     */
    public static function getController($controllerName, $actionName, $params)
    {
        $currentControllerClassName = ucfirst($controllerName) . 'Controller';
        $currentControllerPath = MvcKernel::CONTROLLERS_PATH . MvcKernel::$ds . $currentControllerClassName . '.php';
        if (file_exists($currentControllerPath)) {
            include($currentControllerPath);
            $currentControllerClassName = MvcKernel::$appNamespace . self::$controllerNamespace . '\\' . $currentControllerClassName;
            $controller = new $currentControllerClassName($actionName, $params);
            $controller->currentController = $controllerName;
            return $controller;
        }
        throw new BaseException("Unable to find '$controllerName' in file: $currentControllerPath");
    }

    /**
     * @param $viewName
     * @param array $params
     * @return string
     */
    public function render($viewName, $params = [])
    {
        $view = new BaseView($viewName,$this->currentController,$this->currentAction);
        return $view->render($params);
    }
}