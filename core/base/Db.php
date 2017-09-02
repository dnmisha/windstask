<?php
/**
 * Created by PhpStorm.
 * User: misha
 * Date: 01.09.17
 * Time: 23:57
 */

namespace Mvc\Core\Base;

/**
 * Class Db
 * @package Mvc\Core\Base
 */
class Db
{
    /**
     * @var $pdo \PDO
     */
    public $pdo = null;
    private $pdoClass = 'PDO';
    private $dsn;
    private $username;
    private $password;
    private $attributes;

    private $driverName = 'mysql';
    private $dbName = null;
    private $host = '127.0.0.1';

    /**
     * Db constructor.
     * @param $dbName
     * @param $username
     * @param $password
     * @param string $driverName
     * @param string $host
     */
    public function __construct($dbName, $username, $password, $driverName = 'mysql', $host = '127.0.0.1')
    {
        $this->dbName = $dbName;
        $this->username = $username;
        $this->password = $password;
        $this->driverName = $driverName;
        $this->host = $host;
    }

    /**
     * @throws \Exception
     */
    public function init()
    {
        $this->dsn = $this->driverName . ':dbname=' . $this->dbName . ';host=' . $this->host;
        try {
            $this->pdo = $this->createPdoInstance();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $pdoClassName
     */
    public function setPdoClass($pdoClassName)
    {
        $this->pdoClass = $pdoClassName;
    }

    /**
     * @return \PDO
     */
    protected function createPdoInstance()
    {
        $pdoClass = $this->pdoClass;
        return new $pdoClass($this->dsn, $this->username, $this->password, $this->attributes);
    }

    /**
     * @param $sql
     * @param array $params
     * @return \PDOStatement
     * @throws BaseException
     */
    public function query($sql, $params = [])
    {
        $statement = $this->pdo->prepare("$sql");
        try {
            if (!empty($params)) {
                foreach ($params as $key => $value) {
                    $statement->bindParam(":$key", $value);
                }
            }
            $statement->execute();
            return $statement;
        } catch (BaseException $exception) {
            throw new BaseException($exception->getMessage());
        }
    }
}