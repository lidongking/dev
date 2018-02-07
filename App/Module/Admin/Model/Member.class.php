<?php
/**
 * Copyright (c) 2018, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘    要：Member.class.php
 * 作    者：wangld
 * 修改日期：2018/1/11
 */

namespace App\Module\Admin\Model;

use Xiaotu\Tool\Helper;

class Member extends Model
{

    protected $db;
    protected $dbName = 'jt_shop_sys';
    protected $tableName = 'sys_member';
    protected $pkName = 'id';

    // password, solt
    protected $salt = 'AW!@#$%*&)w235;|/w(';

    const USER_IS_INVALIDED = - 1;
    const USER_PASSWORD_ERROR = - 2;
    const USER_IS_VALIDATED = 1;

    const USER_LOGIN_EXPIRES = 86400;    // Default 24h one day

    public function __construct()
    {
        parent::__construct();
    }

    public function login($data)
    {
        $username = $data['username'];
        $password = $data['password'];

        $user = $this->find('username = :u', array('u' => $username));
        if (empty($user))
        {
            // 用户不存在
            $code = self::USER_IS_INVALIDED;
        }
        else
        {
            if ($this->password($password) === $user['password'])
            {
                $code = self::USER_IS_VALIDATED;
                $this->data = $user;
                $loginInfo = array(
                    'ip' => Helper::getClientIp(),
                    'time' => date('Y-m-d H:i:s')
                );
                $this->data['last_login_info'] = json_encode($loginInfo);
                // 保存登录信息
                $this->save();
            }
            else
            {
                $code = self::USER_PASSWORD_ERROR;
            }
        }

        return $code;
    }

    protected function password($password)
    {
        return md5($this->salt . md5($password) . md5(substr($this->salt, intval(strlen($this->salt) / 2))));
    }
}
