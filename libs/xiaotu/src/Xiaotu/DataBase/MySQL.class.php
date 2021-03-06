<?php
/**
 * Copyright (c) 2017, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘    要：MySQL.class.php
 * 作    者：wangld
 * 修改日期：2017/6/19
 */

namespace Xiaotu\DataBase;

use PDO;
use PDOException;
use PDOStatement;
use Exception;

class MySQL
{
    protected $dsn;
    protected $dbUser;
    protected $dbPass;
    protected $tablePrefix;
    protected $charset;
    protected $isPersistent;
    protected $isDebug;
    protected $pdo;
    protected $pdoStatement;

    protected $queryType;
    protected $table;
    protected $sql;
    protected $where;
    protected $order;
    protected $limit;
    protected $data;
    protected $isExec;

    protected static $instances = array();

    /**
     * MySQL constructor.
     *
     * @param array $config 配置
     *
     * @throws Exception 异常抛出
     */
    protected function __construct($config = array())
    {
        $dbHost = $config['host'];
        $dbPort = isset($config['port']) && $config['port'] ? $config['port'] : '3306';
        $dbUser = $config['user'];
        $dbPass = $config['pass'];
        $dbName = isset($config['dbName']) ? $config['dbName'] : $config['dbKey'];
        $tablePrefix = isset($config['prefix']) ? $config['prefix'] : '';
        $charset = isset($config['charset']) ? strtolower(str_replace('-', '', $config['charset'])) : 'utf8';
        $isPersistent = empty($config['persistent']) ? false : true;
        $isDebug = empty($config['debug']) ? false : true;

        if (empty($config) || empty($dbHost) || empty($dbUser) || empty($dbPass) || empty($dbName))
        {
            throw new Exception('MySQL dbKey: ' . $config['dbKey'] . ' is not good.');
        }
        $this->dsn = 'mysql:host=' . $dbHost . ';port=' . $dbPort . ';dbname=' . $dbName;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
        $this->tablePrefix = $tablePrefix;
        $this->charset = $charset;
        $this->isPersistent = $isPersistent;
        $this->isDebug = $isDebug;
        $this->connect();
    }

    private function __clone()
    {
    }

    /**
     * 功    能：获取操作DB实例
     * 修改日期：2017-6-4
     *
     * @param string $dbKey 数据库标示Key
     *
     * @return MySQL 当前DB实例
     */
    public static function getInstance($dbKey = 'jelly_tec')
    {
        $dbKey = strtolower($dbKey);
        if (empty(self::$instances[$dbKey]))
        {
            global $CFG;

            $config = $CFG['mysql'][$dbKey];
            $config['dbKey'] = $dbKey;
            self::$instances[$dbKey] = new self($config);
        }

        return self::$instances[$dbKey];
    }

    /**
     * 功    能：连接数据库
     * 修改日期：2017-6-4
     *
     * @return null 无返回
     */
    private function connect()
    {
        try
        {
            $options = array();
            if ($this->isPersistent)
            {
                $options[] = array(PDO::ATTR_PERSISTENT => true);
            }
            $this->pdo = new PDO($this->dsn, $this->dbUser, $this->dbPass, $options);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            $this->halt('ERROR:' . $e->getMessage());
        }
        if ($this->pdo)
        {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            $this->pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);
            $this->pdo->setAttribute(PDO::ATTR_TIMEOUT, 2);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->pdo->exec("SET NAMES {$this->charset}");
        }
    }

    /**
     * 功    能：获取pdo对象,以便直接操作pdo
     * 修改日期：2017-6-4
     *
     * @return Pdo pdo对象
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * 功    能：获取pdoStatement对象
     * 修改日期：2017-6-10
     *
     * @return PDOStatement pdoStatement对象
     */
    protected function getPdoStatement()
    {
        return $this->pdoStatement;
    }

    /**
     * 功    能：初始化参数
     * 修改日期：2017-6-4
     *
     * @return null 无返回
     */
    public function init()
    {
        $this->queryType = '';
        $this->table = '';
        $this->sql = '';
        $this->where = '';
        $this->order = '';
        $this->limit = '';
        $this->data = array();
        $this->isExec = false;
    }

    public function table($table)
    {
        $this->init();
        $this->table = $this->tablePrefix . $table;

        return $this;
    }

    /**
     * 功    能：选择数据库
     * 修改日期：2017-6-6
     *
     * @param array|string $fields 字段
     *
     * @return $this 返回当前对象，链式操作
     */
    public function select($fields = array())
    {
        $this->queryType = 'S';
        empty($fields) && $fields = '*';
        $fieldStr = '';
        is_array($fields) && $fieldStr = '`' . implode('`,`', $fields) . '`';
        is_string($fields) && $fieldStr = $fields;

        $this->sql = 'SELECT ' . $fieldStr . ' FROM `' . $this->table . '`';

        return $this;
    }

    /**
     * 功    能：插入方法
     * 修改日期：2017-6-4
     *
     * @param array $data 数据
     * @param bool $update 是否ON DUPLICATE KEY UPDATE
     *
     * @return $this 返回当前对象，链式操作
     */
    public function insert($data = array(), $update = false)
    {
        $this->queryType = 'I';
        $fields = array_keys($data);
        $values = ':' . implode(', :', $fields);
        // ON DUPLICATE KEY UPDATE
        $updates = array();
        foreach ($fields as $key => $val)
        {
            $updates[] = '`' . $val . '`=VALUES(`' . $val . '`)';
        }
        $updateStr = '';
        $update && $updateStr = ' ON DUPLICATE KEY UPDATE ' . implode(',', $updates);
        $this->sql = 'INSERT INTO `' . $this->table . '`(`' . implode('`,`', $fields) . '`) VALUES(' . $values . ')' . $updateStr;

        foreach ($data as $key => $val)
        {
            $this->data[$key] = $val;
        }

        return $this;
    }

    /**
     * 功    能：批量插入
     * 修改日期：2017-7-7
     *
     * @param array $data 数据
     * @param bool $update 是否冲突更新 ON DUPLICATE KEY UPDATE
     *
     * @return $this 返回当前实例以便链式操作
     */
    public function batchInsert($data = array(), $update = false)
    {
        $this->queryType = 'BI';
        $first = current($data);
        // 多行插入
        $fields = array_keys($first);
        $pos = 0;
        $values = array();
        foreach ($data as $key => $val)
        {
            foreach ($val as $kkey => $vval)
            {
                $this->data[$kkey . '_' . $pos] = $vval;
            }
            $values[] = '(:' . implode('_' . $pos . ', :', array_keys($val)) . '_' . $pos . ')';

            $pos++;
        }
        $valuesAll = implode(',', $values);
        // ON DUPLICATE KEY UPDATE
        $updates = array();
        foreach ($fields as $key => $val)
        {
            $updates[] = '`' . $val . '`=VALUES(`' . $val . '`)';
        }
        $updateStr = '';
        $update && $updateStr = ' ON DUPLICATE KEY UPDATE ' . implode(',', $updates);
        $this->sql = 'INSERT INTO `' . $this->table . '`(`' . implode('`,`', $fields) . '`) VALUES' . $valuesAll . $updateStr;

        return $this;
    }

    /**
     * 功    能：更新数据
     * 修改日期：2017-7-7
     *
     * @param array $data 数据
     *
     * @return $this 返回当前对象，链式操作
     */
    public function update($data = array())
    {
        $this->queryType = 'U';
        $sets = array();
        foreach ($data as $key => $val)
        {
            $sets[] = "`{$key}` = :{$key}";
        }
        $setStr = implode(', ', $sets);
        $this->sql = 'UPDATE `' . $this->table . '` SET ' . $setStr;
        $this->data = $data;

        return $this;
    }

    /**
     * 功    能：删除数据方法
     * 修改日期：2017-6-4
     *
     * @return $this 返回当前对象，链式操作
     */
    public function delete()
    {
        $this->queryType = 'D';
        $this->sql = "DELETE FROM `{$this->table}`";

        return $this;
    }

    /**
     * 功    能：获取where语句
     * 修改日期：2017-6-4
     *
     * @param string $str where条件
     * @param array $data 参数绑定
     *
     * @return $this 返回当前对象，链式操作
     */
    public function where($str, $data = array())
    {
        $str ? $this->where = ' WHERE ' . $str : $this->where = $str;

        !empty($data) && $this->data = $data;

        return $this;
    }

    /**
     * 功    能：排序
     * 修改日期：2017-6-4
     *
     * @param string $str order语句
     *
     * @return $this 返回当前对象，链式操作
     */
    public function order($str)
    {
        $str && $this->order = ' ORDER BY ' . $str;

        return $this;
    }

    /**
     * 功    能：限定条数
     * 修改日期：2017-6-4
     *
     * @param int $offset 起始数据位置
     * @param int $size 返回条目
     *
     * @return $this 返回当前对象，链式操作
     */
    public function limit($offset = 0, $size = 10)
    {
        $this->limit = ' LIMIT :offset, :size';

        // 检测参数
        ($offset < 0 || !is_int($offset)) && $offset = 0;
        ($size < 0 || !is_int($size)) < 0 && $size = 10;

        $this->data['offset'] = $offset;
        $this->data['size'] = $size;

        return $this;
    }

    /**
     * 功    能：
     * 修改日期：2017-6-4
     *
     * @param string $sql sql语句
     * @param array $data 参数
     *
     * @return $this 返回当前对象，链式操作
     */
    public function query($sql, $data = array())
    {
        $this->init();
        $this->queryType = 'Q';
        $this->sql = $sql;

        !empty($data) && $this->data = $data;

        return $this;
    }

    /**
     * 功    能：执行语句
     * 修改日期：2017-6-4
     *
     * @return bool 执行结果
     */
    public function execute()
    {
        $pdo = $this->getPdo();
        if ($pdo && $this->table)
        {
            switch ($this->queryType)
            {
                case 'S':
                    $this->sql .= $this->where . $this->order . $this->limit;
                    break;
                case 'U':
                    //$this->sql .= $this->where;
                    //break;
                case 'D':
                    $this->sql .= $this->where;
                    break;
            }
            if ($this->pdoStatement = $pdo->prepare($this->sql))
            {
                foreach ($this->data as $key => $val)
                {
                    $type = PDO::PARAM_STR;
                    if ($key == 'offset' || $key == 'size')
                    {
                        // limit 强制int， 其他全部选择string类型绑定
                        $type = PDO::PARAM_INT;
                    }
                    if (!$this->pdoStatement->bindValue(':' . $key, $val, $type))
                    {
                        return false;
                    }
                }
                if (defined('DEBUG') && true === DEBUG)
                {
                    $this->debug();
                }
                if ($this->pdoStatement->execute())
                {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * 功    能：获取所有数据
     * 修改日期：2017-6-4
     *
     * @param int $style 返回数据类型,默认数据
     *
     * @return bool|array 结果
     */
    public function findAll($style = PDO::FETCH_ASSOC)
    {
        $res = false;
        if ($this->execute())
        {
            $res = $this->getPdoStatement()->fetchAll($style);
            $res = $res === false ? array() : $res;
        }

        return $res;
    }

    /**
     * 功    能：获取一行数据
     * 修改日期：2017-6-4
     *
     * @param int $style 返回数据类型,默认数据
     *
     * @return array|bool 结果
     */
    public function find($style = PDO::FETCH_ASSOC)
    {
        $res = false;
        if ($this->execute())
        {
            $res = $this->getPdoStatement()->fetch($style);
            $res = $res === false ? array() : $res;
        }

        return $res;
    }

    /**
     * 功    能：返回第1行第1列的值
     * 修改日期：2017-6-4
     *
     * @return bool|null 返回值
     */
    public function findCell()
    {
        $res = false;
        if ($this->execute())
        {
            $res = $this->getPdoStatement()->fetchColumn();
            $res = $res === false ? null : $res;
        }

        return $res;
    }

    /**
     * 功    能：执行事务操作
     * 修改日期：2017-6-4
     *
     * @return mixed 结果
     */
    public function beginTransaction()
    {
        return $this->getPdo()->beginTransaction();
    }

    /**
     * 功    能：事务提交
     * 修改日期：2017-6-4
     *
     * @return mixed 结果
     */
    public function commit()
    {
        return $this->getPdo()->commit();
    }

    /**
     * 功    能：事务回滚
     * 修改日期：2017-6-4
     *
     * @return mixed 结果
     */
    public function rollback()
    {
        return $this->getPdo()->rollback();
    }

    /**
     * 功    能：是否在事务中
     * 修改日期：2017-6-4
     *
     * @return mixed 结果
     */
    public function inTransaction()
    {
        return $this->getPdo()->inTransaction();
    }

    /**
     * 功    能：获取上次插入id
     * 修改日期：2017-6-4
     *
     * @return bool|int 上次插入id
     */
    public function lastInsertId()
    {
        $res = false;
        if ($this->execute())
        {
            $res = $this->getPdo()->lastInsertId();
            $res = $res === false ? null : $res;
        }

        return $res;
    }

    /**
     * 功    能：返回影响行数
     * 修改日期：2017-6-4
     *
     * @return bool|int 行数
     */
    public function affectedRows()
    {
        $res = false;
        if ($this->execute())
        {
            $res = $this->getPdoStatement()->rowCount();
        }
        return $res;
    }

    /**
     * 功    能：输出信息
     * 修改日期：2017-6-4
     *
     * @param string $msg 信息
     */
    public function halt($msg)
    {
        if ($this->isDebug)
        {
            echo $msg;
            $this->debug();
        }
    }

    /**
     * 功    能：debug一下信息
     * 修改日期：2017-6-10
     *
     * output something for debuging...
     */
    public function debug()
    {
        header('Content-Type:text/html;charset=UTF-8');
        $output = array(
            'sql' => $this->sql,
            'data' => $this->data,
            'pdo' => $this->getPdo(),
            'stmt' => $this->getPdoStatement(),
            'errorInfo' => $this->getPdoStatement()->errorInfo()
        );
        echo '############################# debuging start #############################' . '<pre>';
        var_export($output);
        echo '</pre>' . '############################# debuging end #############################';
    }
}
