<?php
/**
 * Copyright (c) 2017, 杰利信息科技[demo.jelly-tec.com]
 * 摘    要：Router.class.php
 * 作    者：wangld
 * 修改日期：2017/6/10
 */

namespace Xiaotu\Http;

use Xiaotu\Base;

class Router extends Base
{
    private static $_module = '';
    private static $_controller = 'home';
    private static $_action = 'index';
    private static $params = array();

    protected static $rules = array();

    private static $_mode = 1;

    public static function dispatch()
    {
        static::autoDetact();
    }

    protected static function autoDetact()
    {
        $server = Gpcs::server();
        $qStr = '';
        if (strpos($server['REQUEST_URI'], '?') !== false)
        {
            list($sUrl, $qStr) = explode('?', $server['REQUEST_URI']);
        }
        else
        {
            $sUrl = $server['REQUEST_URI'];
        }
        // 去除默认index.php
        $sUrl = str_replace('index.php', '', $sUrl);
        if ($sUrl != '/')
        {
            //MCA
            $tmpArr = array_filter(explode('/', $sUrl));
            $countA = count($tmpArr);
            if ($countA == 3)
            {
                self::$_module = $tmpArr[1];
                self::$_controller = $tmpArr[2];
                self::$_action = $tmpArr[3];
            }
            elseif ($countA == 2)
            {
                self::$_module = '';
                self::$_controller = $tmpArr[1];
                self::$_action = $tmpArr[2];
            }
            elseif ($countA == 1)
            {
                self::$_action = $tmpArr[1];
            }
        }

        switch (self::$_mode)
        {
            case 1:
                //Params normal
                $qArr = array_filter(explode('&', $qStr));
                $params = array();
                foreach ($qArr as $key => $val)
                {
                    $param = explode('=', $val);
                    $params[$param[0]] = isset($param[1]) ? $param[1] : null;
                }
                self::$params = $params;
                break;
        }
        self::$_module = ucwords(self::$_module);
        self::$_controller = ucwords(self::$_controller);
        //action 首字母小写驼峰
        self::$_action = lcfirst(self::$_action);

        $mod = self::$_module;
        $con = self::$_controller;
        $act = self::$_action;
        $modStr = $mod ? "\\Module\\{$mod}" : '';
        $controllerStr = "\\App{$modStr}\\Controller\\{$con}";
        //判定类是否存在
        if (!class_exists($controllerStr))
        {
            Response::status(404, 'Class: <b>' . $controllerStr . '</b> is unavailable.');
            exit;
        }
        $controller = $controllerStr::getInstance();
        //设置参数
        $controller->setParams(self::$params);
        $actionStr = $act . 'Action';
        //判定方法是否存在
        if (method_exists($controller, $actionStr))
        {
            $controller->$actionStr();
        }
        else
        {
            Response::status(404, 'Method: <b>' . $controllerStr . '</b>::<b>' . $actionStr . '</b>() is unavailable.');
            exit;
        }
    }
}
