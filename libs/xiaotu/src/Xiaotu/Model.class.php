<?php
/**
 * Copyright (c) 2017, 杰利信息科技[demo.jelly-tec.com]
 * 摘    要：Model.class.php
 * 作    者：wangld
 * 修改日期：2017/6/10
 */

namespace Xiaotu;

use Xiaotu\Cache\File;
use Xiaotu\DataBase\MySQL;

/**
 * Class Model
 *
 * @package Xiaotu
 *
 * @property MySQL $db
 * @property File $cache
 */
class Model extends Base
{

    protected $db;
    protected $dbName;
    protected $tableName;
    protected $pkName = 'id';
    protected $id;
    protected $data = array();
    protected $cache;

    /**
     * Model constructor.
     */
    protected function __construct()
    {
        parent::__construct();
        if ($this->dbName)
        {
            $this->db = MySQL::getInstance($this->dbName);
        }
        $this->cache = File::getInstance('c1');
    }

    /**
     * Model destructor.
     */
    public function __destruct()
    {
        $this->db = $this->cache = null;
    }

    /**
     * Get recode by primary key.
     * @param $id PrimaryKey
     * @return array|bool Recode
     */
    public function get($id)
    {
        $bindData = array($this->pkName => $id);

        return $this->db->table($this->tableName)->select('*')->where($this->pkName . '=:' . $this->pkName, $bindData)->find();
    }

    /**
     * Get all recodes. Be careful, use it seriously, Dangerous!!!
     * @return array|bool Recodes
     */
    public function getAll()
    {
        return $this->db->table($this->tableName)->select('*')->findAll();
    }

    /**
     * Add new recode to database.
     * @param $data The data you want to add.
     * @return bool Result.
     */
    public function add($data)
    {
        return $this->db->table($this->tableName)->insert($data)->execute();
    }

    /**
     * Delete recode by primary key.
     * @param $id Primary key.
     * @return bool Result.
     */
    public function del($id)
    {
        $bindData = array($this->pkName => $id);

        return $this->db->table($this->tableName)->where($this->pkName . '=:' . $this->pkName, $bindData)->delete()->execute();
    }

    /**
     * Save a Recode by it's data.
     * @return bool Result.
     */
    public function save()
    {
        return $this->edit($this->id, $this->data);
    }

    /**
     * Edit Recode.
     * @param $id Recode id(pk)
     * @param $data Recode data.
     * @return bool Result.
     */
    public function edit($id, $data)
    {
        $bindData = array($this->pkName => $id);

        return $this->db->table($this->tableName)->where($this->pkName . '=:' . $this->pkName, $bindData)->update($data)->execute();
    }

    /**
     * Drop a recode by primary key
     * @param $id Recode id(pk)
     * @return bool Result.
     */
    public function drop($id)
    {
        return $this->del($id);
    }

    /**
     * Get data by param key.
     * @param $name The param key you want to get.
     * @return mixed Recode Data
     */
    public function __get($name)
    {
        return $this->data[$name];
    }

    /**
     * Set data by param key
     * @param $name key
     * @param $value value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }
}
