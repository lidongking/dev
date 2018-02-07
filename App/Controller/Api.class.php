<?php
/**
 * Copyright (c) 2018, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘    要：Api.class.php
 * 作    者：wangld
 * 修改日期：2018/1/16
 */

namespace App\Controller;

use Xiaotu\Http\Upload;
use Xiaotu\Controller;

class Api extends Controller
{
    public function uploadAction()
    {
        $config = array(
            'type' => array('image'),
            'size' => 1024 * 100,   // 100kb
        );
        Upload::init($config);
        $files = Upload::upload();
        if (!empty($files))
        {
            echo json_encode($files);
        }
    }
}
