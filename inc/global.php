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
    include_once dirname(__FILE__) . '/config.php';
}
else
{
    include_once dirname(__FILE__) . '/config_online.php';
}

// PHPQuery
// include_once ROOT_PATH . '/vendor/phpQuery/phpQuery.php';
include_once ROOT_PATH . '/vendor/Smarty/Autoloader.php';
\Smarty_Autoloader::register();

// 加载器
include_once ROOT_PATH . '/libs/xiaotu/autoload.php';


Gpcs::get('debug') == 1 && define('DEBUG', true);
