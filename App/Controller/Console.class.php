<?php
/**
 * Copyright (c) 2018, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘　　要：Console.class.php
 * 作　　者：wangld
 * 修改日期：2018/1/22
 */

namespace App\Controller;

use Xiaotu\Controller;

class Console extends Controller
{
    public function indexAction()
    {
        echo 'Console->index()';
    }

    public function testAction()
    {
        echo 'Console/test';
    }
}
