<?php
/**
 * Copyright (c) 2017, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘    要：Joke.class.php
 * 作    者：wangld
 * 修改日期：2017/11/9
 */

namespace App\Module\Api\Model;

use Xiaotu\Model;

class Joke extends Model
{
    protected $db;
    protected $dbName = 'jelly_tec';
    protected $tableName = 'jokes';
    protected $pkName = 'id';
    protected $id;
    protected $data = array();

    protected $pageSize = 20;
    protected $pageMax = null;

    protected function __construct()
    {
        parent::__construct();
        $this->getMaxPage();
    }

    public function getPage($page)
    {
        $data = array();
        if (1 <= $page && $page <= $this->pageMax)
        {
            $cacheKey = CacheKey::JOKE_LIST . '_' . $page;
            $data = $this->cache->get($cacheKey);
            if ($data === false)
            {
                $data = $this->db->table('jokes')->select('*')->where('title!=:title', array('title' => ''))->limit(($page - 1) * $this->pageSize, $this->pageSize)->findAll();
                $this->cache->set($cacheKey, $data);
            }
        }

        return $data;
    }

    public function getMaxPage()
    {
        $cacheKey = CacheKey::JOKE_MAX_PAGE;
        $maxPage = $this->cache->get($cacheKey);

        if ($maxPage === false)
        {
            $maxPage = ceil(intval($this->db->table('jokes')->select('COUNT(*) AS total')->where('title!=:title', array('title' => ''))->findCell()) / $this->pageSize);
            $this->cache->set($cacheKey, $maxPage);
        }
        $this->pageMax = $maxPage;

        return $this->pageMax;
    }
}
