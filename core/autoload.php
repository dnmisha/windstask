<?php
/**
 * Created by PhpStorm.
 * User: misha
 * Date: 01.09.17
 * Time: 0:44
 */
require __DIR__ . '/MvcKernel.php';

/**
 * Class MvcKernel
 */
class MvcKernel extends Mvc\Core\MvcKernel
{
}

spl_autoload_register(['MvcKernel', 'autoload'], true, true);
MvcKernel::$classMap = require(__DIR__ . '/classes.php');