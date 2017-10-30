<?php
namespace Mvc\Application\Models;
use Mvc\Core\Base\BaseModel;

/**
 * Created by PhpStorm.
 * User: misha
 * Date: 02.09.17
 * Time: 13:55
 */
class User extends BaseModel
{
    public $currentTable = 'user';

    public $login;
    public $name;
    public $password;
    public $email;


}