<?php

namespace Mvc\Core\Components;

use Mvc\Core\Base\BaseException;
use Mvc\Core\MvcKernel;

/**
 * Class CoreHelper
 * @package Mvc\Core\Components
 */
class CoreHelper
{
    /**
     * @return array
     * @throws BaseException
     */
    public static function buildConfig()
    {
        $commonConfigPath = MvcKernel::CONFIG_PATH . '/common.yaml';
        $commonConfigLocalPath = MvcKernel::CONFIG_PATH . '/common-local.yaml';
        $routerConfigPath = MvcKernel::CONFIG_PATH . '/routes.yaml';
        $assetsConfigPath = MvcKernel::CONFIG_PATH . '/assets.yaml';
        if (!file_exists($commonConfigPath) || !file_exists($commonConfigLocalPath) || !file_exists($routerConfigPath) || !file_exists($assetsConfigPath)) {
            throw new BaseException('check config files');
        }
        try {
            $commonConfig = self::parseYamlFile($commonConfigPath);
            $commonLocalConfig = self::parseYamlFile($commonConfigLocalPath);
            $routerConfig = self::parseYamlFile($routerConfigPath);
            $assetsConfig = self::parseYamlFile($assetsConfigPath);
            return array_merge($commonConfig, $commonLocalConfig, $routerConfig, $assetsConfig);
        } catch (BaseException $exception) {
            throw new BaseException($exception->getMessage());
        }
    }

    /**
     * @param $path
     * @return mixed
     * @throws BaseException
     */
    public static function parseYamlFile($path)
    {
        try {
            return yaml_parse(file_get_contents($path));
        } catch (BaseException $exception) {
            throw new BaseException($exception->getMessage());
        }
    }

    /**
     * Checks if multiple keys exist in an array
     *
     * @param array $array
     * @param array|string $keys
     *
     * @return bool
     */
    public static function arrayKeysExist(array $array, $keys)
    {
        $count = 0;
        if (!is_array($keys)) {
            $keys = func_get_args();
            array_shift($keys);
        }
        foreach ($keys as $key) {
            if (array_key_exists($key, $array)) {
                $count++;
            }
        }
        return count($keys) === $count;
    }

    /**
     * @param bool $absolute
     * @return string
     */
    public static function baseUrl($absolute = false){
        if($absolute == true){
            return sprintf(
                "%s://%s",
                isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
                $_SERVER['SERVER_NAME']
            );
        }else{
            return '/';
        }
    }
}