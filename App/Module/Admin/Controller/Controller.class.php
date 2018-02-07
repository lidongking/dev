<?php
/**
 * Copyright (c) 2018, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘　　要：Controller.class.php
 * 作　　者：wangld
 * 修改日期：2018/1/18
 */

namespace App\Module\Admin\Controller;

use Xiaotu\Http\Gpcs;
use Xiaotu\Http\Response;
use Xiaotu\Http\RouterNew;
use Xiaotu\Controller as BaseController;
use App\Module\Admin\Model\Admin;
use ReflectionClass;

class Controller extends BaseController
{
    protected function __construct()
    {
        session_start();
        parent::__construct();
        // Reflecte the actionUrl and do check method
        $class = new ReflectionClass(get_called_class());
        foreach ($class->getMethods() as $a)
        {
            if (strpos($a->name, 'Action') !== false && $a->isPublic())
            {
                $this->pageData[$a->name] = RouterNew::buildUri('Admin', 'Index', str_replace('Action', '', $a->name));
            }
        }
        // $this->pageData['data']['avatar'] = '/avatar.gif';
        $this->pageData['personalInfo'] = Admin::getInstance()->get(Gpcs::session('adminId'));
    }

    protected function check()
    {
        $sAdminId = Gpcs::session('adminId');
        $sUserName = Gpcs::session('username');
        $sNickName = Gpcs::session('nickname');
        $cAdminId = Gpcs::cookie('adminId');
        $cUsername = Gpcs::cookie('username');
        $cNickName = Gpcs::cookie('nickname');
        if (empty($sUserName) || $sUserName != $cUsername || empty($sNickName) || $sNickName != $cNickName || empty($sAdminId) || $sAdminId != $cAdminId)
        {
            if ('Admin/Index/login' !== RouterNew::getCurUri())
            {
                Response::getInstance()->redirect('/Admin/Index/login');
            }

            return false;
        }

        return true;
    }

    protected function userLogin(Admin $admin)
    {
        $adminId = $admin->__get('id');
        $username = $admin->__get('username');
        $nickname = $admin->__get('nickname');
        $loginInfo = $admin->__get('last_login_info');

        setcookie('adminId', $adminId, time() + Admin::USER_LOGIN_EXPIRES, '/');
        setcookie('username', $username, time() + Admin::USER_LOGIN_EXPIRES, '/');
        setcookie('nickname', $nickname, time() + Admin::USER_LOGIN_EXPIRES, '/');
        setcookie('last_login_info', $loginInfo, time() + Admin::USER_LOGIN_EXPIRES, '/');

        $_SESSION['adminId'] = $adminId;
        $_SESSION['username'] = $username;
        $_SESSION['nickname'] = $nickname;
    }

    protected function userLogout()
    {
        setcookie('adminId', '', time() - 3600, '/');
        setcookie('username', '', time() - 3600, '/');
        setcookie('nickname', '', time() - 3600, '/');
        setcookie('last_login_info', '', time() - 3600, '/');
        session_destroy();
    }
}
