<?php
/**
 * Copyright (c) 2017, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘    要：View.class.php
 * 作    者：wangld
 * 修改日期：2017/11/10
 */

namespace Xiaotu;

class View extends Base
{
    protected $var = array();

    public function assign($name, $value = null)
    {
        $this->var[$name] = $value;
    }

    public function get($name)
    {
        return isset($this->var[$name]) ? $this->var[$name] : null;
    }

    public function show($content, $charset = 'UTF-8', $contentType = 'text/html')
    {
        header('Content-Type:' . $contentType . '; charset=' . $charset);
        header('Cache-control: private');  //支持页面回跳
        // 输出模板文件
        echo $content;
    }

    public function fetch($tpl, $var = null, $isOriginal = false)
    {
        if (!is_file($tpl))
        {
            return false;
        }
        // origin php tpl
        if ($isOriginal)
        {
            include "{$tpl}";
        }
        else
        {
            // diy tpl
            // TODO To fix it later.
        }
    }
}
