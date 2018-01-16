<?php
/**
 * Copyright (c) 2017, 杰利信息科技[demo.jelly-tec.com]
 * 摘    要：Controller.class.php
 * 作    者：wangld
 * 修改日期：2017/6/10
 */

namespace Xiaotu;

use Xiaotu\DataBase\MySQL;
use Xiaotu\Cache\Redis;
use \Smarty;

class Controller extends Base
{
    protected $smarty;
    protected $_params;
    protected $pageData = array();

    public function __construct()
    {
        global $CFG;
        parent::__construct();

        // smarty
        $smarty = new Smarty;
        $smarty->setTemplateDir(ROOT_PATH . '/' . $CFG['smarty']['TPL_DIR']);
        $smarty->setCompileDir(ROOT_PATH . '/' . $CFG['smarty']['COMPILE_DIR']);
        $smarty->setCacheDir(ROOT_PATH . '/' . $CFG['smarty']['CACHE_DIR']);
        $smarty->caching = $CFG['smarty']['CACHE'];
        $smarty->cache_lifetime = $CFG['smarty']['CACHE_TIME'];
        //$smarty->force_compile = true;


        $this->smarty = $smarty;
    }

    /**
     * 功    能：渲染并输出页面
     * 修改日期：2017-6-10
     *
     * @param string $tpl 模板
     * @param array $data 数据
     */
    protected function display($tpl, $data = array())
    {
        global $CFG;
        $this->smarty->display($tpl . '.' . $CFG['smarty']['TPL_EXT'], $data);
    }

    /**
     * 功    能：只渲染页面
     * 修改日期：2017-6-10
     *
     * @param string $tpl 模板
     * @param array $data 数据
     *
     * @return string 渲染后的数据
     */
    protected function render($tpl, $data = array())
    {
        global $CFG;
        return $this->smarty->fetch($tpl . '.' . $CFG['SMARTY']['TPL_EXT'], $data);
    }

    /**
     * 功    能：参数设置
     * 修改日期：2017-4-15
     *
     * @param array $params 参数
     *
     * @return null 无返回
     */
    public function setParams($params)
    {
        $this->_params = $params;
    }

    /**
     * 功    能：获取参数
     * 修改日期：2017-4-15
     *
     * @param string $key 参数key
     *
     * @return array|null 参数值
     */
    public function getParams($key)
    {
        return $key ? (isset($this->_params[$key]) ? $this->_params[$key] : null) : $this->_params;
    }

    public function redirect($url, $is301 = false)
    {
        $is301 && header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $url);exit;
    }
}