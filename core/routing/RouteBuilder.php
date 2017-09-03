<?php

namespace Mvc\Core\Routing;

use Mvc\Core\Base\BaseController;
use Mvc\Core\Base\BaseException;
use Mvc\Core\MvcKernel;

/**
 * Created by PhpStorm.
 * User: misha
 * Date: 02.09.17
 * Time: 11:52
 * Class RouteBuilder
 * @package Mvc\Core\Routing
 */
class RouteBuilder
{
    private $config = [];

    private $currentPattern = '/';
    private $currentController;
    private $currentAction;

    private $params = [];

    /**
     * RouteBuilder constructor.
     * @param $routeConfig
     */
    public function __construct($routeConfig)
    {
        $this->config = $routeConfig;
        $this->parseRoute();
    }

    /**
     * return current controller object
     * @return mixed
     */
    public function init()
    {
        return $this->buildRoute();
    }

    /**
     * parse existed route
     */
    private function parseRoute()
    {
        $url = explode('?', trim($_SERVER['REQUEST_URI']));
        $path = mb_strtolower($url[0]);
        while (substr($path, -1) == MvcKernel::$ds) {
            $path = mb_substr($path, 0, (mb_strlen($path) - 1));
        }
        $path = trim(strip_tags(urldecode($path)));
        $this->currentPattern = empty($path) ? $this->currentPattern : $path;
    }

    /**
     * @return mixed
     * @throws BaseException
     */
    public function buildRoute()
    {

        foreach ( $this->config as $key=> $item){
            if (preg_match($this->regexPath($key),$this->currentPattern)) {
                $route = $this->config[$key];
                if (array_key_exists('controller', $route) && !empty($route['controller'])) {
                    $appRoute = explode(':', $route['controller']);
                    if (count($appRoute) == 2) {
                        $this->currentController = $appRoute[0];
                        $this->currentAction = $appRoute[1];
                        $this->params = $this->parseParams($this->currentPattern, $item);
                        return BaseController::getController($this->currentController, $this->currentAction, $this->params);
                    } else {
                        throw new BaseException('Bad path config');
                    }
                }
            }
        }
        throw new BaseException('Page not found', 404);
    }

    /**
     * @param $path
     * @return string
     */
    private function regexPath($path)
    {
        return '#' . str_replace([":int:", ":string:"], ["\d+", ".+"], $path) . '$#si';
    }

    /**
     * @param $url
     * @param $item
     * @return array
     */
    public function parseParams($url, $item){
        $parts = explode('/',$url);
        $params = [];
        if(array_key_exists('params',$item)){
            foreach ($item['params'] as $key=>$param){
                $params[$key]=array_key_exists($param,$parts)?$parts[$param]:null;
            }
        }
        return $params;
    }
}