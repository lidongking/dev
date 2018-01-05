<?php
/**
 * Copyright (c) 2017, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘    要：Helper.class.php
 * 作    者：Jelly
 * 修改日期：2017/8/2
 */

namespace Xiaotu\Tool;

class Helper
{
    /**
     * 功    能：检查变量是否存在，并且为真
     * 修改日期：2017/12/19
     *
     * @param mixed $val 被检测变量
     *
     * @return bool 结果
     */
    public static function check($val)
    {
        return isset($val) && !!$val;
    }

    /**
     * 功    能：gbk转utf-8
     * 修改日期：2017-6-2
     *
     * @param array|string $array 待转换编码数据
     *
     * @return array|string 转码结果
     */
    public static function gbk2utf8($array)
    {
        $tmpArr = null;
        if (empty($array))
        {
            $tmpArr = $array;
        }

        if (!is_array($array))
        {
            $tmpArr = mb_convert_encoding($array, 'UTF-8', 'GBK');
        }

        foreach ($array as $key => $value)
        {
            if (is_array($value))
            {
                $tmpArr[self::gbk2utf8($key)] = self::gbk2utf8($value);
            }
            else
            {
                $tmpArr[self::gbk2utf8($key)] = mb_convert_encoding($value, 'UTF-8', 'GBK');
            }
        }

        return $tmpArr;
    }

    /**
     * 功    能：utf-8转gbk
     * 修改日期：2017-6-2
     *
     * @param array|string $array 待转换编码数据
     *
     * @return array|string 转码结果
     */
    public static function utf82gbk($array)
    {
        $tmpArr = null;
        if (empty($array))
        {
            $tmpArr = $array;
        }

        if (!is_array($array))
        {
            $tmpArr = mb_convert_encoding($array, 'GBK', 'UTF-8');
        }

        foreach ($array as $key => $value)
        {
            if (is_array($value))
            {
                $tmpArr[self::utf82gbk($key)] = self::utf82gbk($value);
            }
            else
            {
                $tmpArr[self::utf82gbk($key)] = mb_convert_encoding($value, 'GBK', 'UTF-8');
            }
        }

        return $tmpArr;
    }
}
