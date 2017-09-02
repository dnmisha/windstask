<?php

/**
 * Created by PhpStorm.
 * User: misha
 * Date: 01.09.17
 * Time: 23:30
 */

namespace Mvc\Core\Base;
use Mvc\Core\MvcKernel;
use PDO;

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
     * @return array
     */
    public function fields(){
        return [];
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
     * @return $this
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
            $this->query = $this->dbConnection->query($sql,$params);
            return $this;
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
     * @return BaseModel
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
        return $this->query->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @return mixed
     */
    public function one(){
        return $this->query->fetch(PDO::FETCH_OBJ);
    }

    /**
     * save data to sb table as new record
     */
    public function save(){
        $fields = $this->fields();
        $attributes = get_object_vars($this);
        $params = [];
        foreach ($fields as $field){
            if(array_key_exists($field,$attributes)){
                $params[$field] = $attributes[$field];
            }
        }
        $this->insertRecord($params);
    }

    /**
     * @return BaseModel
     */
    public static function find($tableName){
        $model = new self();
        $model->currentTable = $tableName;
        return $model;
    }
}