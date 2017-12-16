<?php
/**
 * Copyright (c) 2017, 杰利信息科技[jokes.jelly-tec.com]
 * 摘    要：
 * 作    者：wangld
 * 修改日期：2017/6/1
 */

// 根路径防止重复获取目录消耗
define('ROOT_PATH', dirname(__DIR__));

$CONF['DB'] = array(
    'DEFAULT' => array(
        'type' => 'mysql',
        'host' => '103.51.145.13',
        'port' => '3306',
        'user' => 'Jelly',
        'pass' => 'cookies',
        'dbName' => 'jelly_tec',
        'charset' => 'utf8',
        'prefix' => 'jt_',
        'persistent' => 1,
        'debug' => 1
    ),
);

$CONF['REDIS'] = array(
    'DEFAULT' => array(
        'host' => '103.51.145.13',
        'port' => 6379,
        'auth' => 'jelly_tec'
    ),
);

$CONF['SMARTY'] = array(
    'TPL_DIR' => 'template',
    'TPL_EXT' => 'tpl',
    'COMPILE_DIR' => 'template_c',
    'CACHE' => false,
    'CACHE_DIR' => 'cache',
    'CACHE_TIME' => 120
);
