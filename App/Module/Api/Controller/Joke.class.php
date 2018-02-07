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
use Xiaotu\Http\Gpcs;
use Xiaotu\Http\Response;

class Joke extends Controller
{
    protected $jokeModel;

    protected function __construct()
    {
        parent::__construct();
        $this->jokeModel = JokeModel::getInstance();
    }

    public function indexAction()
    {
        $this->display('api/index/index.html', array());
    }

    public function getAction($p)
    {
        $p = isset($p) ? intval($p) : (isset($_GET['p']) ? Gpcs::get('p') : 1);
        $data = $this->jokeModel->getPage($p);
        $maxPage = $this->jokeModel->getMaxPage();
        $retData = array(
            'status' => 'ok',
            'curPage' => $p,
            'maxPage' => $maxPage,
            'data' => $data
        );
        Response::getInstance()->throwJson($retData);
    }
}
