<?php
/**
 * Copyright (c) 2017, 杰利信息科技[dev.jelly-tec.com]
 * 摘    要：Gpcs.class.php GPCS GET,POST,COOKIE,SERVER
 * 作    者：wangld
 * 修改日期：2017/6/10
 */

namespace Xiaotu\Http;

use Xiaotu\Base;

class Gpcs extends Base
{
    /**
     * 功    能：获取get参数
     * 修改日期：2017-4-15
     *
     * @param string $key key值
     *
     * @return mixed 结果
     */
    public static function get($key = '')
    {
        return $key ? isset($_GET[$key]) ? $_GET[$key] : null : $_GET;
    }

    /**
     * 功    能：获取post参数
     * 修改日期：2017-4-15
     *
     * @param string $key key值
     *
     * @return mixed 结果
     */
    public static function post($key = '')
    {
        return $key ? isset($_POST[$key]) ? $_POST[$key] : null : $_POST;
    }

    /**
     * 功    能：获取server参数
     * 修改日期：2017-4-15
     *
     * @param string $key key值
     *
     * @return mixed 结果
     */
    public static function server($key = '')
    {
        return $key ? isset($_SERVER[$key]) ? $_SERVER[$key] : null : $_SERVER;
    }

    /**
     * 功    能：获取cookie参数
     * 修改日期：2017-4-15
     *
     * @param string $key key值
     *
     * @return mixed 结果
     */
    public static function cookie($key = '')
    {
        return $key ? isset($_COOKIE[$key]) ? $_COOKIE[$key] : null : $_COOKIE;
    }
}
