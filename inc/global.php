<?php
/**
 * Copyright (c) 2017, 杰利信息科技[dev.jelly-tec.com]
 * 摘    要：
 * 作    者：wangld
 * 修改日期：2017/6/1
 */
use \Xiaotu\Http\Gpcs;

ini_set('default_charset', 'UTF-8');

// include config
include_once dirname(__DIR__) . '/inc/config.php';

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

// include functions
include_once ROOT_PATH . '/inc/function.php';

// PHPQuery
// include_once ROOT_PATH . '/vendor/phpQuery/phpQuery.php';
include_once ROOT_PATH . '/vendor/Smarty/Autoloader.php';
Smarty_Autoloader::register();

// fix $_SERVER['DOCUMENT_ROOT'] for cli
if ('cli' === PHP_SAPI || empty($_SERVER['DOCUMENT_ROOT']))
{
    // under cli DOCUMENT_ROOT is empty
    $_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__);
}

// Autoloader
include_once ROOT_PATH . '/libs/xiaotu/autoload.php';

Gpcs::get('debug') == 1 && define('DEBUG', true);
