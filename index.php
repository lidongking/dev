<?php
/**
 * Copyright (c) 2018, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘    要：index.php 简单路由由$_GET参数指定mca（模块，控制器，动作）
 * 作    者：wangld
 * 修改日期：2018/1/15
 */

use Xiaotu\Http\Gpcs;
use \Xiaotu\Http\RouterNew;

include_once dirname(__FILE__) . '/inc/global.php';
include_once dirname(__FILE__) . '/libs/xiaotu/autoload.php';

RouterNew::init();
RouterNew::parseUrl();

exit;

// 传统方法，仅支持Web模式 指定mca参数

$m = Gpcs::get('m') ? Gpcs::get('m') : '';
$c = Gpcs::get('c') ? Gpcs::get('c') : 'Default';
$a = Gpcs::get('a') ? Gpcs::get('a') : 'index';

$className = 'App\\' . ($m ? 'Module\\' . $m . '\\': '') . 'Controller\\' . $c;
if (class_exists($className))
{
    $funcName = $a . 'Action';
    if (method_exists($className, $funcName))
    {
        call_user_func(array($className, $funcName));
        return;
    }
}

die('Error 403');
