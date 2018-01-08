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
     * 功    能：变量编码转换，支持字符串和数组
     * 修改日期：2018/1/8
     *
     * @param array|string $data 带转换数据
     * @param string $to 目的编码
     * @param string $from 源编码
     *
     * @return array|string 结果
     */
    public static function convertEncoding($data, $to = 'GBK', $from = 'UTF-8')
    {
        $desData = array();

        if (is_string($data))
        {
            // 只有是string类型才会转换，防止过多转换，例如：number,bool等
            $desData = mb_convert_encoding($data, $to, $from);
        }
        elseif (is_array($data))
        {
            foreach ($data as $dataKey => $dataVal)
            {
                $dataKey = convertEncoding($dataKey, $to, $from);
                $dataVal = convertEncoding($dataVal, $to, $from);
                $desData[$dataKey] = $dataVal;
            }
        }
        else
        {
            $desData = $data;
        }

        return $desData;
    }
}
