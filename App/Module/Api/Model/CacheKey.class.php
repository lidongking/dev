<?php
/**
 * Copyright (c) 2017, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘    要：CacheKey.class.php
 * 作    者：wangld
 * 修改日期：2017/11/9
 */

namespace App\Module\Api\Model;

use Xiaotu\Model;

class CacheKey extends Model
{
    const JOKE_LIST = 'joke_list';
    const JOKE_INFO = 'joke_info';
    const JOKE_MAX_PAGE = 'joke_max_page';
}
