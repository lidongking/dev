<?php
/**
 * Copyright (c) 2017, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘    要：config.php
 * 作    者：Jelly
 * 修改日期：2017/7/7
 */

define('ROOT_PATH', dirname(__DIR__));
// 本地环境
$localIp = '127.0.0.1';
// 线上环境
$onlineIp = '144.48.9.54';

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
        'host' => $localIp,
        'port' => 6379,
        'auth' => 'jelly_tec'
    ),
    'LOCAL' => array(
        'host' => $localIp,
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
    'mysql' => $mysql,
    'redis' => $redis,
    'cache' => $cache,
    'smarty' => $smarty
);
