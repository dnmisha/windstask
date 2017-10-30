<?php
/**
 * Created by PhpStorm.
 * User: misha
 * Date: 02.09.17
 * Time: 1:36
 */

namespace Mvc\Core\Base;

use Throwable;

/**
 * Class BaseException
 * @package Mvc\Core\Base
 */
class BaseException extends \Exception
{
    /**
     * BaseException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        http_response_code($code);
        parent::__construct($message, $code, $previous);
    }
}