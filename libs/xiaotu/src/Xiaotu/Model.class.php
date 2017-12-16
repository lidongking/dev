<?php
/**
 * Copyright (c) 2017, 杰利信息科技[demo.jelly-tec.com]
 * 摘    要：Model.class.php
 * 作    者：wangld
 * 修改日期：2017/6/10
 */

namespace Xiaotu;

use Xiaotu\Cache\File;
use Xiaotu\Cache\Redis;
use Xiaotu\DataBase\MySQL;

/**
 * Class Model
 * @package Xiaotu
 *
 * @property MySQL $db
 * @property Redis $redis
 */
class Model extends Base
{
    protected $db;
    protected $redis;
    protected $mongo;

    protected $cache;

    protected function __construct()
    {
        parent::__construct();
        $this->db = MySQL::getInstance();
        $this->redis = Redis::getInstance();
        $this->cache = File::getInstance();
    }
}
