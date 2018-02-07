<?php
/**
 * Copyright (c) 2017, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘    要：config.php
 * 作    者：Jelly
 * 修改日期：2017/7/7
 */

// define('DEBUG', true);
define('ROOT_PATH', dirname(__DIR__));
// dictionary separator
define('DS', '/');
// 本地环境
$localIp = '127.0.0.1';
// 线上环境
$onlineIp = '144.48.9.54';
// $localIp = $onlineIp;
$mysql = array(
    'jelly_tec' => array(
        'host' => $localIp,
        'port' => 3306,
        'user' => 'Jelly',
        'pass' => 'cookies',
        'prefix' => 'jt_'
    ),
    'jt_shop_sys' => array(
        'host' => $localIp,
        'port' => 3306,
        'user' => 'Jelly',
        'pass' => 'cookies',
        'prefix' => ''
    )
);

$redis = array(
    'jelly_tec' => array(
        'host' => $onlineIp,
        'port' => 6379,
        'auth' => 'jellytec_redis'
    )
);

$cache = array(
    'file' => array(
        'c1' => array(
            'salt' => 'A!@#*&^',
            'dir' => dirname(__DIR__) . '/cache/c1'
        ),
        'c2' => array(
            'salt' => 'A!@#*&^',
            'dir' => dirname(__DIR__) . '/cache/c2'
        ),
        'c3' => array(
            'salt' => 'A!@#*&^',
            'dir' => dirname(__DIR__) . '/cache/c3'
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

// 路由
$router = array(
    'ext' => '.html',       // Url后缀
    'namespace' => 'App',
    'moves' => array(
        'Home/test/a/aa/a/2133' => '/tz.php'
    ),
    'routers' => array(
        'Home/test/a/aa/a/2133' => 'Api/get',
    )
);

$CFG = array(
    'mysql' => $mysql,
    'redis' => $redis,
    'cache' => $cache,
    'smarty' => $smarty,
    'router' => $router
);
