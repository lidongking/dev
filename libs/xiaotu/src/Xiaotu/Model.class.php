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
    protected $pkName;
    protected $id;
    protected $data = array();

    protected $cache;

    protected function __construct()
    {
        parent::__construct();
        if ($this->dbName)
        {
            $this->db = MySQL::getInstance($this->dbName);
        }
        $this->cache = File::getInstance('c1');
    }

    public function __destruct()
    {
        $this->db = $this->cache = null;
    }

    public function get($id)
    {
        return $this->db->table($this->tableName)->select('*')->where
        ($this->pkName . '=:' . $this->pkName,
            array(
            $this->pkName => $id,
        ))->find(\PDO::FETCH_CLASS);
    }

    public function add($data)
    {
        return $this->db->table($this->tableName)->insert($data)->execute();
    }

    public function del($id)
    {
        return $this->db->table($this->tableName)->where($this->pkName . '=:' . $this->pkName, array($this->pkName, $id))->delete()->execute();
    }

    public function save()
    {
        return $this->edit($this->id, $this->data);
    }

    public function edit($id, $data)
    {
        return $this->db->table($this->tableName)->where($this->pkName . '=:' . $this->pkName, array($this->pkName, $id))->update
            ($data)->execute();
    }

    public function drop($id)
    {
        return $this->del($id);
    }

    public function __get($name)
    {
        return $this->data[$name];
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }
}
