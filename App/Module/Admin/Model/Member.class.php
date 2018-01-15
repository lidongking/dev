<?php
/**
 * Copyright (c) 2018, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘    要：Member.class.php
 * 作    者：wangld
 * 修改日期：2018/1/11
 */

namespace App\Module\Admin\Model;

use Xiaotu\Model;

class Member extends Model
{
    protected $db;
    protected $dbName = 'jt_shop_sys';
    protected $tableName = 'sys_member';
    protected $pkName = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    public function test()
    {
        // $m1 = array(
        //     'nickname' => '师大果冻',
        //     'username' => 'LidongKing',
        //     'password' => md5('cookies'),
        //     'age' => 25,
        //     'sex' => '男',
        //     'telephone' => '18355300869'
        // );
        // $m1Status = $this->add($m1);
        // var_dump($m1Status);

        $m1 = $this->get(1);
        var_dump($m1);
    }
}
