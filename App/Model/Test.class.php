<?php
/**
 * Copyright (c) 2017, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘    要：Test.class.php
 * 作    者：wangld
 * 修改日期：2017/11/9
 */

namespace App\Model;

use Xiaotu\Model;

class Test extends Model
{
    protected $dbName = 'jelly_tec';
    public function getData()
    {
        $data = $this->db->table('jokes')->select('*')->limit(0, 100)->findAll();
        return $data;
    }
}
