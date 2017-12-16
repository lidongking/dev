<?php

/**
 * Class TransCoding
 * 数据转码，支持String和Array
 */

namespace Xiaotu\Tool;

class TransCoding
{
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
