<?php
namespace Mvc\Application\Controllers;
use Mvc\Core\Base\BaseController;

/**
 * Created by PhpStorm.
 * User: misha
 * Date: 01.09.17
 * Time: 12:36
 */
class MainController extends BaseController
{
    /**
     * @return string
     */
    public function actionIndex(){
        return $this->render('index',['rw'=>'wd']);
    }

    /**
     * @return string
     */
    public function actionDemo(){
         return $this->render('demo',['rw'=>'wd']);
    }
}