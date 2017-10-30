<?php
/**
 * Created by PhpStorm.
 * User: misha
 * Date: 01.09.17
 * Time: 23:30
 */

namespace Mvc\Core\Base;

use Mvc\Core\MvcKernel;

/**
 * Class BaseView
 * @package Mvc\Core\Base
 */
class BaseView
{
    public $template;
    public $controllerName;
    public $actionName;

    /**
     * BaseView constructor.
     * @param $template
     * @param $controllerName
     * @param $actionName
     */
    public function __construct($template, $controllerName, $actionName)
    {
        $this->template = $template;
        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
    }

    /**
     * @param $params
     * @return string
     */
    public function render($params)
    {
        $viewPath = $this->getViewPath();
        extract($params);
        ob_start();
        include($viewPath);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    /**
     * @return string
     * @throws BaseException
     */
    public function getViewPath()
    {
        $viewPath = MvcKernel::APPLICATION_PATH . MvcKernel::$ds . 'views' . MvcKernel::$ds . $this->controllerName . MvcKernel::$ds . $this->template . '.php';
        if (file_exists($viewPath)) {
            return $viewPath;
        }
        throw new BaseException("view file $viewPath not found");
    }

    /**
     * @param $layout
     * @param $content
     */
    public static function renderLayout($layout, $content)
    {
        $viewPath = $viewPath = MvcKernel::APPLICATION_PATH . MvcKernel::$ds . 'views' . MvcKernel::$ds . $layout . '.php';
        extract(compact('content'));
        ob_start();
        include($viewPath);
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }

    /**
     * @param $viewPath
     * @param array $content
     * @return array|string
     * @throws BaseException
     */
    public static function renderPartial($viewPath, $content = [])
    {
        $viewPath = MvcKernel::APPLICATION_PATH . MvcKernel::$ds . 'views' . MvcKernel::$ds . $viewPath . '.php';
        if (!file_exists($viewPath)) throw new BaseException("view file $viewPath not found");
        extract($content);
        ob_start();
        include($viewPath);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    /**
     * @param null $script
     * @return \stdClass
     * @throws BaseException
     */
    public static function renderAssets($script = null)
    {
        $content = new \stdClass();
        $content->js = $content->css = '';
        $assetsConfig = MvcKernel::$app->getAssetsConfig();
        if (array_key_exists('basePath', $assetsConfig)) {
            $basePath = $assetsConfig['basePath'];
            if ($script == null) {
                if (array_key_exists('js', $assetsConfig) && !empty($assetsConfig['js'])) {
                    foreach ($assetsConfig['js'] as $js) {
                        $path = $basePath . $js;
                        $content->js .= "<script src=\"$path\"></script>";
                    }
                }
                if (array_key_exists('css', $assetsConfig) && !empty($assetsConfig['css'])) {
                    foreach ($assetsConfig['css'] as $css) {
                        $path = $basePath . $css;
                        $content->css .= "<link rel=\"stylesheet\" href=\"$path\">";
                    }
                }
            }
        } else {
            throw new BaseException("lost base path for assets");
        }
        return $content;
    }
}