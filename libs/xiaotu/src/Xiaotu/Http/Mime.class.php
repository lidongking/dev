<?php
/**
 * Copyright (c) 2018, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘　　要：Mime.class.php
 * 作　　者：wangld
 * 修改日期：2018/1/19
 */

namespace Xiaotu\Http;

use Xiaotu\Base;

class Mime extends Base
{
    public static $mimes = array(
        'text' => array(
            'text/plain',
            'text/html',
            'text/css',
            'text/javascript',
        ),
        'image' => array(
            'image/gif',
            'image/png',
            'image/jpeg',
            'image/bmp',
            'image/webp',
            'image/svg+xml',
        ),
        'audio' => array(
            'audio/midi',
            'audio/mpeg',
            'audio/webm',
            'audio/ogg',
            'audio/wav',
            'audio/wave',
            'audio/x-wav',
            'audio/x-pn-wav',
        ),
        'video' => array(
            'application/ogg',
            'video/webm',
            'video/ogg',
            'video/mp4',
        ),
        'application' => array(
            'application/ogg',
            'application/xml',
            'application/pdf',
            'application/json',
            'application/pkcs12',
            'application/octet-stream',
            'application/octet-stream',
            'application/octet-stream',
            'application/vnd.mspowerpoint',
            'application/xhtml+xml',
        ),
    );
}
