<?php
/**
 * Copyright (c) 2017, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘    要：Home.class.php
 * 作    者：wangld
 * 修改日期：2017/10/17
 */

namespace App\Controller;

use App\Model\Test;
use Xiaotu\Controller;

class Home extends Controller
{
    public function indexAction()
    {
        echo 'Home->index()';
    }
}
