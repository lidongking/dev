<?php
/**
 * Copyright (c) 2017, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘    要：File.class.php
 * 作    者：Jelly
 * 修改日期：2017/7/10
 */

namespace Xiaotu\Cache;

use Exception;

class File
{
    protected $dir;
    protected static $instances = array();

    /**
     * File constructor.
     *
     * @param array $config 文件缓存配置
     *
     * @throws Exception 配置问题，抛出异常
     */
    protected function __construct($config)
    {
        if (empty($config) || empty($config['dir']))
        {
            throw new Exception('FileCache dbKey: ' . $config['dbKey'] . ' is not good.');
        }
        $this->dir = $config['dir'];
        $this->salt = isset($config['salt']) ? $config['salt'] : 'A!@#*&^';
        if (!is_dir($this->dir))
        {
            mkdir($this->dir, 0755, true);
        }
    }

    /**
     * 功    能：获取文件缓存实例
     * 修改日期：2017-7-10
     *
     * @param string $dbKey key标示
     *
     * @return self 返回实例
     */
    public static function getInstance($dbKey = 'DEFAULT')
    {
        $dbKey = strtolower($dbKey);
        if (!isset(self::$instances[$dbKey]))
        {
            global $CFG;

            $config = $CFG['cache']['file'][$dbKey];
            $config['dbKey'] = $dbKey;

            self::$instances[$dbKey] = new self($config);
        }

        return self::$instances[$dbKey];
    }

    /**
     * 功    能：设置缓存
     * 修改日期：2017-7-10
     *
     * @param string $key 键名
     * @param mixed $value 键值
     * @param null|int $expires 超时时间秒级
     *
     * @return bool|int 结果
     */
    public function set($key, $value, $expires = null)
    {
        $caeFile = $this->getCacheFile($key);
        $data = array(
            'data' => $value,
        );
        is_int($expires) && $data['expires'] = (time() + $expires);

        return file_put_contents($caeFile, serialize($data));
    }

    /**
     * 功    能：获取缓存值
     * 修改日期：2017-7-10
     *
     * @param string $key key值
     *
     * @return bool|mixed 结果
     */
    public function get($key)
    {
        $cae = array('data' => false);
        $caeFile = $this->getCacheFile($key);
        is_file($caeFile) && $cae = unserialize(file_get_contents($caeFile));
        if ($cae && isset($cae['expires']) && intval($cae['expires']) < time())
        {
            // 过期
            unlink($caeFile);
            $cae['data'] = false;
        }

        return $cae['data'];
    }

    public function getStatus($key)
    {
        $status = array(
            'atime' => fileatime($this->getCacheFile($key)),
            'ctime' => filectime($this->getCacheFile($key)),
            'mtime' => filemtime($this->getCacheFile($key))
        );

        return $status;
    }

    /**
     * 功    能：获取缓存对应物理文件
     * 修改日期：2017-7-10
     *
     * @param string $key 标示key
     *
     * @return string 问价缓存实际地址
     */
    private function getCacheFile($key)
    {
        $md5 = md5($key . $this->salt);
        $cacheFile = $this->dir . '/' . substr($md5, 0, 1) . '/' . $md5 . '.cae';
        if (!is_dir(dirname($cacheFile)))
        {
            mkdir(dirname($cacheFile), 0755, true);
        }

        return $cacheFile;
    }
}
