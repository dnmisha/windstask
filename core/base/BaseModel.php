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
 * Class BaseModel
 * @package Mvc\Core\Base
 */
class BaseModel
{
    public $currentTable = null;
    /**
     * @var $dbConnection Db
     */
    private $dbConnection = null;
    /**
     * @var $query \PDOStatement
     */
    private $query = null;

    public function __construct()
    {
        $this->dbConnection = MvcKernel::$app->getDb();
        if($this->dbConnection == null){
            throw new BaseException('Bad database connection');
        }
    }

    /**
     * @param $data
     * @param bool $skipValidation
     */
    public function loadData($data, $skipValidation = false)
    {
        if (is_array($data)) {
            $attributes = array_flip(array_keys(get_object_vars($this)));
            foreach ($data as $name => $value) {
                if (isset($attributes[$name])) {
                    if ($this->$name != $value) {
                        $this->$name = ($skipValidation)?$value:trim(strip_tags($value));
                    }
                }
            }
        }
    }

    /**
     * @param array $params
     * @param null $tableName
     */
    public function insertRecord($params = [],$tableName = null){
        if(!empty($params)){
            $fieldNames = $values = '';
            foreach ($params as $key=>$value){
                $fieldNames.=" $key,";
                $values.=" :$key,";
            }
            $fieldNames  = rtrim($fieldNames,',');
            $values  = rtrim($values,',');
            $tableName = ($tableName!==null)?$tableName:$this->currentTable;
            $sql = "INSERT INTO $tableName ($fieldNames) VALUES ($values)";
            $this->dbConnection->query($sql,$params);
        }
    }

    /**
     * @param $sql
     * @param array $params
     */
    public function deleteRecord($sql,$params = []){

    }

    /**
     * @param $select
     * @param null $condition
     * @param array $params
     * @return mixed
     */
    public function getRecord($select, $condition = null, $params = []){
        $sql = "SELECT $select FROM $this->currentTable";
        if($condition !==null){
            $sql .= " WHERE $condition";
        }
        $this->query = $this->dbConnection->query($sql,$params);
        return $this;
    }

    /**
     * @return mixed
     */
    public function all(){
        return $this->query->fetchAll();
    }

    /**
     * @return mixed
     */
    public function one(){
        return $this->query->fetch();
    }
}