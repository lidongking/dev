<?php
/**
 * Copyright (c) 2017, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘    要：Joke.class.php
 * 作    者：wangld
 * 修改日期：2017/11/9
 */

namespace App\Module\Api\Controller;

use Xiaotu\Controller;

use App\Module\Api\Model\Joke as JokeModel;
use Xiaotu\Http\Response;

class Joke extends Controller
{
    protected $joleModel;

    protected function __construct()
    {
        parent::__construct();
        $this->joleModel = JokeModel::getInstance();
    }

    public function indexAction()
    {
        $this->display('api/index/index.html', array());
    }

    public function getAction()
    {
        $p = $this->getParams('p') ? intval($this->getParams('p')) : 1;
        $data = $this->joleModel->getPage($p);
        $maxPage = $this->joleModel->getMaxPage();
        $retData = array(
            'status' => 'ok',
            'curPage' => $p,
            'maxPage' => $maxPage,
            'data' => $data
        );
        $json = json_encode($retData);
        Response::output($json, 'json', 'UTF-8');
    }
}
