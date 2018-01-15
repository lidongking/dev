<?php
/**
 * Copyright (c) 2018, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘    要：Home.class.php
 * 作    者：wangld
 * 修改日期：2018/1/11
 */

namespace App\Module\Admin\Controller;

use App\Module\Admin\Model\Member;
use Xiaotu\Controller;

class Home extends Controller
{
    public function indexAction()
    {
        echo 'Admin->index';
        $member = Member::getInstance();
        $member->test();
    }
}
