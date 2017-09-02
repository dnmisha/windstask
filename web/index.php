<?php
require '../core/autoload.php';
/**
 * Created by PhpStorm.
 * User: misha
 * Date: 31.08.17
 * Time: 23:23
 */
use Mvc\Core\Components\CoreHelper;
use Mvc\Core\MvcKernel;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$app = new MvcKernel(CoreHelper::buildConfig());
$app->run();

?>