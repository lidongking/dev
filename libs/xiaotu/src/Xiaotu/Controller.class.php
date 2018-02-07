<?php
/**
 * Copyright (c) 2017, 杰利信息科技[dev.jelly-tec.com]
 * 摘    要：Controller.class.php
 * 作    者：wangld
 * 修改日期：2017/6/10
 */

namespace Xiaotu;

use \Smarty;

class Controller extends Base
{
    protected $smarty;
    protected $_params;
    protected $pageData = array();

    protected function __construct()
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
        $tplData = empty($data) ? $this->pageData : $data;
        $this->smarty->display($tpl . '.' . $CFG['smarty']['TPL_EXT'], $tplData);
    }

    /**
     * 功    能：只渲染页面
     * 修改日期：2017-6-10
     *
     * @param string $tpl 模板
     * @param array $data 数据
     *
     * @return string 渲染后的数据
     *
     * @throws
     */
    protected function render($tpl, $data = array())
    {
        global $CFG;
        $tplData = empty($data) ? $this->pageData : $data;
        return $this->smarty->fetch($tpl . '.' . $CFG['smarty']['TPL_EXT'], $tplData);
    }
}