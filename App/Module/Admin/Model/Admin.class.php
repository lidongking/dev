<?php
/**
 * Copyright (c) 2018, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘　　要：Admin.class.php
 * 作　　者：wangld
 * 修改日期：2018/1/18
 */

namespace App\Module\Admin\Model;

class Admin extends Member
{
    protected $dbName = 'jt_shop_sys';
    protected $tableName = 'sys_admin';
}
