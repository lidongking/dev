<?php
/**
 * Copyright (c) 2017, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘    要：router.php
 * 作    者：wangld
 * 修改日期：2017/11/9
 */

use Xiaotu\Http\RouterNew;

include_once dirname(__FILE__) . '/inc/global.php';
include_once dirname(__FILE__) . '/libs/xiaotu/autoload.php';
RouterNew::dispatch();
