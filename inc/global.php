<?php
/**
 * Copyright (c) 2017, 杰利信息科技[demo.jelly-tec.com]
 * 摘    要：
 * 作    者：wangld
 * 修改日期：2017/6/1
 */
#ini_set('display_errors', 'on');
#error_reporting(E_ALL);
use \Xiaotu\Http\Gpcs;
use \Smarty_Autoloader;

ini_set('default_charset', 'UTF-8');

if (file_exists(dirname(__FILE__) . '/online.txt'))
{
    define('ENVIRONMENT', 'PRODUCT');
}
else
{
    define('ENVIRONMENT', 'DEVELOPMENT');
}

if ('PRODUCT' !== ENVIRONMENT)
{
    ini_set('display_errors', 'on');
    error_reporting(E_ALL);
}

include_once dirname(__FILE__) . '/config.php';

// PHPQuery
// include_once ROOT_PATH . '/vendor/phpQuery/phpQuery.php';
include_once ROOT_PATH . '/vendor/Smarty/Autoloader.php';
Smarty_Autoloader::register();

// cli 修复$_SERVER['DOCUMENT_ROOT']
if ('cli' === PHP_SAPI || empty($_SERVER['DOCUMENT_ROOT']))
{
    // cli 下 DOCUMENT_ROOT 为空
    $_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__);
}

// 加载器
include_once ROOT_PATH . '/libs/xiaotu/autoload.php';


Gpcs::get('debug') == 1 && define('DEBUG', true);
