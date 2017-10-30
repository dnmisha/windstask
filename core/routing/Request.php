<?php
/**
 * Created by PhpStorm.
 * User: misha
 * Date: 02.09.17
 * Time: 13:53
 */

namespace Mvc\Core\Routing;


class Request
{
    private $postData = [];

    /**
     * @return $this
     */
    public function init(){
        if($this->isPost()){
            $this->postData = $_POST;
        }
        if($this->isGet()){
            $this->postData = $_GET;
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function isPost(){
        return ($_SERVER['REQUEST_METHOD'] === 'POST');
    }
    /**
     * @return bool
     */
    public function isGet(){
        return ($_SERVER['REQUEST_METHOD'] === 'GET');
    }

    /**
     * @param null $variableName
     * @param null $defaultValue
     * @return array|mixed|null
     */
    public function post($variableName = null,$defaultValue = null){
        if($variableName !== null){
            if(array_key_exists($variableName,$this->postData)){
                return $this->postData[$variableName];
            }
            return $defaultValue;
        }
        return $this->postData;
    }

    public function redirect($url){
        header("Location:$url");
    }
}