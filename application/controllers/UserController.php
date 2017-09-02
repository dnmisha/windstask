<?php

namespace Mvc\Application\Controllers;

use Mvc\Application\Models\User;
use Mvc\Core\Base\BaseController;


class UserController extends BaseController
{
    /**
     * @return string
     */
    public function actionLogin()
    {
        return $this->render('login', ['rw' => 'wd']);
    }
}