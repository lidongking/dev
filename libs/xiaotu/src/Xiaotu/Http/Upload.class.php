<?php
/**
 * Copyright (c) 2018, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘　　要：Upload.class.php One model for upload files, single file and multi files.
 * 作　　者：wangld
 * 修改日期：2018/1/19
 */

namespace Xiaotu\Http;

use Xiaotu\Base;

if (!defined('ROOT_PATH'))
{
    exit('ROOT_PATH IS NOT DEFINED!');
}

class Upload extends Base
{
    protected static $uploadDir = '/upload';
    protected static $allowTypes = array(
        'image',
        'text',
        'audio',
        'video',
        'application',
    );
    protected static $allowMimeTypes = array();
    protected static $errors = array(
        UPLOAD_ERR_OK => 'UPLOAD_ERR_OK',
        UPLOAD_ERR_INI_SIZE => 'UPLOAD_ERR_INI_SIZE',
        UPLOAD_ERR_FORM_SIZE => 'UPLOAD_ERR_FORM_SIZE',
        UPLOAD_ERR_PARTIAL => 'UPLOAD_ERR_PARTIAL',
        UPLOAD_ERR_NO_FILE => 'UPLOAD_ERR_NO_FILE',
        UPLOAD_ERR_NO_TMP_DIR => 'UPLOAD_ERR_NO_TMP_DIR',
        UPLOAD_ERR_CANT_WRITE => 'UPLOAD_ERR_CANT_WRITE',
        UPLOAD_ERR_EXTENSION => 'UPLOAD_ERR_EXTENSION',
    );
    protected static $allowSize = 1048576;  // 1Mb

    /**
     * 功　　能：Init Upload class config for good.
     * 修改日期：2018/1/19
     *
     * @param array $config Upload settings
     */
    public static function init($config = array())
    {
        static::$uploadDir = isset($config['dir']) ? static::$uploadDir . DS . $config['dir'] : static::$uploadDir . DS . date('Ymd');
        static::$allowTypes = isset($config['type']) ? $config['type'] : static::$allowTypes;
        static::$allowSize = isset($config['size']) ? $config['size'] : static::$allowSize;
        if (!is_dir(ROOT_PATH . static::$uploadDir))
        {
            // create folder
            mkdir(ROOT_PATH . static::$uploadDir, 0755, true);
        }
        // detect mime types
        foreach (static::$allowTypes as $type)
        {
            if (isset(Mime::$mimes[$type]))
            {
                foreach (Mime::$mimes[$type] as $mimeYype)
                {
                    static::$allowMimeTypes[] = $mimeYype;
                }
            }
        }
    }

    /**
     * 功　　能：Upload files to server.
     * 修改日期：2018/1/19
     *
     * @return array Upload results
     */
    public static function upload()
    {
        $files = Gpcs::files();
        $allFiles = array();
        if (!empty($files))
        {
            foreach ($files as $key => $val)
            {
                if (!is_array($val['name']) && !empty($val['name']))
                {
                    $val['mime'] = mime_content_type($val['tmp_name']);
                    $allFiles[$key] = $val;
                }
                else
                {
                    $names = $val['name'];
                    $types = $val['type'];
                    $tmpNames = $val['tmp_name'];
                    $errors = $val['error'];
                    $sizes = $val['size'];
                    if (is_array($names) && !empty($names[0]))
                    {
                        foreach ($names as $kkey => $vval)
                        {
                            $allFiles[$key . '_' . $kkey] = array(
                                'name' => $vval,
                                'type' => $types[$kkey],
                                'tmp_name' => $tmpNames[$kkey],
                                'error' => $errors[$kkey],
                                'size' => $sizes[$kkey],
                                'mime' => mime_content_type($tmpNames[$kkey]),
                            );
                        }
                    }
                }
            }
        }
        foreach ($allFiles as $key => $file)
        {
            $tmp_file = $file['tmp_name'];
            $file['error_msg'] = null;
            $file['dest'] = null;
            if (filesize($tmp_file) > static::$allowSize)
            {
                // too large file
                $file['error_msg'] = 'File is too big!';
            }
            if (!in_array(mime_content_type($tmp_file), static::$allowMimeTypes))
            {
                $file['error_msg'] = 'File type is not allow!';
            }
            if (!isset($file['error_msg']) && $file['error'] === UPLOAD_ERR_OK)
            {
                // no upload error
                $randName = date('His') . '_' . static::genRandStr();
                do
                {
                    $dest = static::$uploadDir . DS . $randName . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                }
                while (file_exists($dest));
                $status = move_uploaded_file($tmp_file, ROOT_PATH . DS . $dest);
                if ($status)
                {
                    $file['dest'] = $dest;
                }
            }
            elseif ($file['error'] !== UPLOAD_ERR_OK)
            {
                $file['error_msg'] = static::$errors[$file['error']];
            }
            unset($file['error']);
            unset($file['type']);
            unset($file['tmp_name']);
            $allFiles[$key] = $file;
        }

        return $allFiles;
    }

    /**
     * 功　　能：Generate length defined random string.
     * 修改日期：2018/1/19
     *
     * @param int $num String length
     * @return string random string
     */
    protected static function genRandStr($num = 8)
    {
        $randomStr = '';
        // Case low up Linux
        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        for ($i = 0; $i < $num; $i ++)
        {
            $randomStr .= substr($str, mt_rand(0, 62), 1);
        }

        return $randomStr;
    }
}
