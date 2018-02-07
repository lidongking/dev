<?php
/**
 * Copyright (c) 2018, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘    要：Index.class.php
 * 作    者：wangld
 * 修改日期：2018/1/11
 */

namespace App\Module\Admin\Controller;

use App\Module\Admin\Model\Admin;
use Xiaotu\Http\RouterNew;
use Xiaotu\Http\Gpcs;
use Xiaotu\Http\Response;
use ReflectionClass;

class Index extends Controller
{
    protected function __construct()
    {
        parent::__construct();

    }

    public function indexAction()
    {
        $this->check();
        $this->pageData['last_login_info'] = json_decode(Gpcs::cookie('last_login_info'), true);
        $this->display('admin/index.html');
    }

    public function loginAction()
    {
        if ($this->check())
        {
            // Already logined.
            Response::getInstance()->redirect($this->pageData['indexAction']);
        }
        $post = Gpcs::post();
        if (empty($post))
        {
            $this->display('admin/login.html');
            exit;
        }
        if (empty($post['username']) || empty($post['password']))
        {
            Response::showMsg('<span style="color: red">用户名和密码不可为空！</span>', $this->pageData['loginAction']);
        }
        $admin = Admin::getInstance();
        $code = $admin->login($post);
        if (Admin::USER_IS_VALIDATED === $code)
        {
            // 验证成功，设置cookies等
            $this->userLogin($admin);
            Response::getInstance()->redirect($this->pageData['indexAction']);
        }
        else
        {
            Response::showMsg('<span style="color: red">请输入正确的用户名和密码！</span>');
        }
    }

    public function logoutAction()
    {
        $this->userLogout();
        Response::getInstance()->redirect($this->pageData['loginAction']);
    }

    public function personalAction()
    {
        $this->pageData['editPassword'] = Gpcs::get('password') !== null ? true : false;
        $this->check();
        $post = Gpcs::post();
        if (!empty($post))
        {
            if (!$this->pageData['editPassword'])
            {
                $age = Gpcs::post('age');
                $sex = Gpcs::post('sex');
                $avatar = Gpcs::post('avatar');
                $nickName = Gpcs::post('nickname');
                $telephone = Gpcs::post('telephone');
                if (!empty($age) && !empty($sex) && !empty($avatar) && !empty($nickName) && !empty($telephone))
                {
                    if (!in_array($sex, array('男', '女', '未知')))
                    {
                        Response::showMsg('性别只能选择：男、女、未知！', null, 1);
                    }
                    $admin = Admin::getInstance()->get(Gpcs::session('adminId'));
                    $admin['age'] = $age;
                    $admin['sex'] = $sex;
                    $admin['avatar'] = $avatar;
                    $admin['nickname'] = $nickName;
                    $admin['telephone'] = $telephone;
                    Admin::getInstance()->edit(Gpcs::session('adminId'), $admin);
                    Response::showMsg('更新成功！', $this->pageData['personalAction'], 1);
                }
                else
                {
                    Response::showMsg('请填写完整信息！', null, 1);
                }
            }
            else
            {
                // password
            }

        }
        // personal information
        echo $this->render('admin/personal.html');
    }
}
