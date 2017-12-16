<?php
/**
 * Copyright (c) 2017, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘    要：config.php
 * 作    者：Jelly
 * 修改日期：2017/7/7
 */

define('ROOT_PATH', dirname(__DIR__));
// 本地环境
$localIp = '192.168.138.1';
// 线上环境
$onlineIp = '103.51.145.13';

$mongo = array(
    'DEFAULT' => array(
        'uri' => 'mongodb://' . $localIp . ':27017',
        'dbName' => 'mongo_tv_dm_zy',
        'options' => array(
            'username' => 'Jelly',
            'password' => 'cookies',
        )
    ),
    'LOCAL' => array(
        'uri' => 'mongodb://' . $localIp,
        'dbName' => 'jelly_db'
    ),
    'ONLINE' => array(
        'uri' => 'mongodb://' . $onlineIp,
        'dbName' => 'jelly_db'
    ),
    // 22
    'TEST' => array(
        'uri' => 'mongodb://172.16.0.227:27017,172.16.0.227:27018,172.16.0.227:27019',
        'dbName' => 'mongo_tv_dm_zy',
        'replicaSet' => 'ys_test',
        'options' => array(
            'username' => 'yingshi_test',
            'password' => '0lvImtC4xxhng',
        )
    )
);

$mysql = array(
    'DEFAULT' => array(
        'host' => $localIp,
        'port' => 3306,
        'user' => 'Jelly',
        'pass' => 'cookies',
        'dbName' => 'jelly_tec',
        'prefix' => 'jt_'
    ),
    'LOCAL' => array(
        'host' => $localIp,
        'port' => 3306,
        'user' => 'Jelly',
        'pass' => 'cookies',
        'dbName' => 'jelly_tec',
        'prefix' => 'jt_'
    ),
    'ONLINE' => array(
        'host' => $onlineIp,
        'port' => 3306,
        'user' => 'Jelly',
        'pass' => 'cookies',
        'dbName' => 'jelly_tec',
        'prefix' => 'jt_'
    )
);

$redis = array(
    'DEFAULT' => array(
        'host' => $onlineIp,
        'port' => 6379,
        'auth' => 'jelly_tec'
    ),
    'LOCAL' => array(
        'host' => $onlineIp,
        'port' => 6379,
        'auth' => 'jelly_tec'
    ),
    'ONLINE' => array(
        'host' => $onlineIp,
        'port' => 6379,
        'auth' => 'jelly_tec'
    )
);

$cache = array(
    'file' => array(
        'DEFAULT' => array(
            'salt' => 'A!@#*&^',
            'dir' => dirname(__DIR__) . '/cache'
        ),
        'LOCAL' => array(
            'salt' => 'A!@#*&^',
            'dir' => dirname(__DIR__) . '/cache'
        ),
        'ONLINE' => array(
            'salt' => 'A!@#*&^',
            'dir' => dirname(__DIR__) . '/cache'
        ),
    )
);

$smarty = array(
    'TPL_DIR' => 'template',
    'TPL_EXT' => 'tpl',
    'COMPILE_DIR' => 'template_c',
    'CACHE' => false,
    'CACHE_DIR' => 'cache',
    'CACHE_TIME' => 120
);

$CFG = array(
    'mongo' => $mongo,
    'mysql' => $mysql,
    'redis' => $redis,
    'cache' => $cache,
    'smarty' => $smarty
);
