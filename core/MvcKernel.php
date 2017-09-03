<?php
/**
 * Created by PhpStorm.
 * User: misha
 * Date: 01.09.17
 * Time: 23:22
 */

namespace Mvc\Core;

use Mvc\Core\Base\BaseController;
use Mvc\Core\Base\BaseException;
use Mvc\Core\Base\BaseView;
use Mvc\Core\Base\Db;
use Mvc\Core\Routing\Request;
use Mvc\Core\Components\CoreHelper;
use Mvc\Core\Routing\RouteBuilder;


define('BASE_PATH', realpath(dirname(__FILE__)));

/**
 * Class MvcKernel
 * @package Mvc\Core
 */
class MvcKernel
{
    /**
     * @var array
     */
    public static $classMap = [];
    /**
     * @var $app MvcKernel
     */
    public static $app = null;
    /**
     * @var array
     */
    private $config = [];
    private $db = null;

    public $controller = null;
    public $action = null;
    public $view = null;
    /**
     * @var $request Request
     */
    public $request = null;
    /**
     * @var $currentRoute RouteBuilder
     */
    private $currentRoute;

    public static $appNamespace = 'Mvc\Application';
    public static $ds = '/';

    const CONFIG_PATH = BASE_PATH . '/../config';

    const APPLICATION_PATH = BASE_PATH . '/../application';
    const COMPONENTS_PATH = BASE_PATH . '/../components';
    const CONTROLLERS_PATH = self::APPLICATION_PATH . '/controllers';
    const MODELS_PATH = self::APPLICATION_PATH . '/models';
    const VIEWS_PATH = self::APPLICATION_PATH . '/views';

    /**
     * MvcKernel constructor.
     * @param array $config
     * @throws \Exception
     */
    public function __construct($config = [])
    {
        if (!array_key_exists('db', $config) || CoreHelper::arrayKeysExist(['password', 'username', 'dbname'], $config['db'])) {
            throw new \Exception('bad db config');
        }
        if (!array_key_exists('routes', $config)) {
            throw new \Exception('bad routes config');
        }
        $this->config = $config;
        session_start();
    }

    /**
     *
     */
    public function beforeAction(){ }

    /**
     * @throws BaseException
     */
    public function run()
    {
        try {
            self::$app = $this;

            $this->db = new Db($this->config['db']['dbname'], $this->config['db']['username'], $this->config['db']['password']);
            $this->db->init();

            $request = new Request();
            $this->request = $request->init();
            $this->currentRoute = new RouteBuilder($this->config['routes']);
            /**
             * @var $objectController BaseController
             */
            $objectController = $this->currentRoute->init();
            $this->beforeAction();
            $content = $objectController->runAction();

            BaseView::renderLayout($objectController->layout, $content);
            self::$app = $this;
        } catch (\Exception $exception) {
            $content = $exception->getMessage();
            BaseView::renderLayout('main', $content);
        }
    }

    /**
     * @param $directory
     */
    public static function autoloadAppClass($directory)
    {
        if (is_dir($directory)) {
            $scan = scandir($directory);
            unset($scan[0], $scan[1]); //unset . and ..
            foreach ($scan as $file) {
                if (is_dir($directory . self::$ds . $file)) {
                    self::autoloadAppClass($directory . self::$ds . $file);
                } else {
                    if (strpos($file, '.php') !== false) {
                        $namespace = 'Mvc';
                        foreach (explode('/', $directory) as $part) {
                            if (in_array($part, ['controllers', 'application', 'models', 'views', 'components'])) {
                                $namespace .= '/' . ucfirst($part);
                            }
                        }
                        $name = str_replace('.php', '', $file);
                        self::$classMap[$namespace.'/'.ucfirst($name)] = $directory . self::$ds . $name;
                    }
                }
            }
        }
    }

    /**
     * @param $class
     */
    public static function autoload($class)
    {
        self::autoloadAppClass(self::APPLICATION_PATH);
        self::autoloadAppClass(self::COMPONENTS_PATH);

        $className = str_replace('\\', '/', $class);
        if (array_key_exists($className, self::$classMap)) {
            $filename = self::$classMap[$className] . '.php';
            include($filename);
        }
    }

    /**
     * @return string
     */
    public function getAppName()
    {
        return isset($this->config['app']['name']) ? $this->config['app']['name'] : get_class($this);
    }

    /**
     * @return string
     */
    public function getAssetsConfig()
    {
        return isset($this->config['assets']) ? $this->config['assets'] : [];
    }

    public function getDb(){
        return $this->db;
    }
}
