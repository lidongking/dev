<?php
/**
 * Copyright (c) 2018, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘    要：function.php
 * 作    者：wangld
 * 修改日期：2018/1/8
 */

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
function convertEncoding($data, $to = 'GBK', $from = 'UTF-8')
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