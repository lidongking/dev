<?php
/**
 * Copyright (c) 2017, 杰利信息科技[demo.jelly-tec.com]
 * 摘    要：Base.class.php
 * 作    者：wangld
 * 修改日期：2017/6/10
 */

namespace Xiaotu;

class Base
{
    protected static $_instance = array();
    protected function __construct()
    {

    }
/*
    public function __clone()
    {
        trigger_error('Clone is not allow!', E_USER_ERROR);
    }
*/
    /**
     * 功    能：
     * 修改日期：
     *
     * @return static
     */
    public static function getInstance()
    {
        $className = get_called_class();
        if (!isset(static::$_instance[$className]))
        {
            static::$_instance[$className] = new static();
        }

        return static::$_instance[$className];
    }
}
