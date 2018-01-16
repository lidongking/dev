<?php
/**
 * Copyright (c) 2018, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘    要：RouterNew.class.php
 * 作    者：wangld
 * 修改日期：2018/1/16
 */

namespace Xiaotu\Http;

use Xiaotu\Base;
use Xiaotu\Tool\Helper;
use ReflectionMethod;

class RouterNew extends Base
{
    private static $_class = null;
    private static $_method = null;
    private static $_params = array();
    private static $_config = array();

    public static function init($config = array())
    {
        static::$_config = $config;
        !isset(static::$_config['namespace']) ? static::$_config['namespace'] = 'App' : static::$_config['namespace'];
        Response::getInstance()->setHeader('Server', 'JS');
        Response::getInstance()->setHeader('Powered-by', 'Jelly-Tec.com');
    }

    public static function parseUrl()
    {
        'cli' == PHP_SAPI ? static::parseCli() : static::parseWeb();
        static::run();
    }

    protected static function parseCli()
    {
        $segments = isset($argv) ? $argv : Gpcs::server('argv');
        array_shift($segments);
        static::router($segments);
    }

    protected static function parseWeb()
    {
        $requestUri = Gpcs::server('REQUEST_URI');
        $scriptName = Gpcs::server('SCRIPT_NAME');
        $scriptFileName = Gpcs::server('SCRIPT_FILENAME');
        $scriptFileName = pathinfo($scriptFileName, PATHINFO_BASENAME);
        // 去除脚本/index.php/m/c/a中'/index.php' => ''
        $requestUri = str_replace('/' . $scriptFileName, '', $requestUri);

        if (isset($requestUri) && isset($scriptName))
        {
            $parts = preg_split('#\?#i', $requestUri, 2);
            $requestUri = $parts[0];

            if ($requestUri && $requestUri != '/')
            {
                $uri = parse_url($requestUri, PHP_URL_PATH);
                $uri = str_replace(array('//', '../'), '/', trim($uri, '/'));
                $uri = Helper::removeInvisibleCharacters($uri);
                // 兼容自定义后缀
                $ext = isset(static::$_config['ext']) && static::$_config['ext'] ? static::$_config['ext'] : 'php';
                $uri = preg_replace("|.{$ext}$|", '', $uri);
                // 跳转
                $moves = isset(static::$_config['moves']) ? static::$_config['moves'] : array();
                if (!empty($moves))
                {
                    if (isset($moves[$uri]))
                    {
                        Response::getInstance()->redirect($moves[$uri]);
                    }
                }
                $routers = isset(static::$_config['routers']) ? static::$_config['routers'] : array();
                if (!empty($routers))
                {
                    if (isset($routers[$uri]))
                    {
                        $uri = $routers[$uri];
                    }
                    else
                    {
                        foreach ($routers as $key => $val)
                        {
                            if (preg_match("#^{$key}$#", $uri))
                            {
                                if (false !== strpos($val, '$') && false !== strpos($key, '('))
                                {
                                    $uri = preg_replace("#^{$key}$#", $val, $uri);
                                }
                                break;
                            }
                        }
                    }
                }
                if ($uri)
                {

                    if (!preg_match("|^[" . str_replace(array('\\-', '\-'), '-', preg_quote('a-z 0-9~%.:_\-/', '-')) . "]+$|i", $uri))
                    {
                        return;
                    }
                    $bad = array('$', '(', ')', '%28', '%29');
                    $good = array('&#36;', '&#40;', '&#41;', '&#40;', '&#41;');
                    $uri = str_replace($bad, $good, $uri);
                    $segments = explode('/', preg_replace("|/*(.+?)/*$|", "\\1", $uri));

                    static::router($segments);

                }
            }
            else
            {
                static::$_class = 'Default';
                static::$_method = 'index';
            }
        }
    }

    protected static function router($segments)
    {
        $segCount = count($segments);
        if ($segCount == 1)
        {
            static::$_class = static::$_config['namespace'] . '\\' . 'Controller' . '\\' . ucfirst($segments[0]);
        }
        elseif ($segCount == 2)
        {
            static::$_class = static::$_config['namespace']. '\\' . 'Controller' . '\\' . ucfirst($segments[0]);
            static::$_method = lcfirst($segments[1]);
        }
        elseif ($segCount >= 3)
        {
            // 优先匹配CA
            if (class_exists(static::$_config['namespace'] . '\\' . 'Controller' . '\\' . ucfirst($segments[0])))
            {
                static::$_class = static::$_config['namespace'] . '\\' . 'Controller' . '\\' . $segments[0];
                static::$_method = lcfirst($segments[1]);
                static::$_params = array_slice($segments, 2);
            }
            // module/controller/action/...params.../
            if (static::$_class === null)
            {
                // 匹配不到CA，匹配MCA
                static::$_class = static::$_config['namespace'] . '\\' . 'Module' . '\\' . $segments[0] . '\\Controller\\' .
            $segments[1];
                static::$_method = lcfirst($segments[2]);
                static::$_params = array_slice($segments, 3);
            }
        }
        if (static::$_method == null)
        {
            static::$_method = "index";
        }
    }

    protected static function run()
    {
        // 实际方法
        $class = static::$_class;
        $method = static::$_method . 'Action';
        $params = static::$_params;
        if (class_exists($class) && method_exists($class, $method))
        {
            $rfm = new ReflectionMethod($class, $method);
            if ($rfm->isPublic() && !$rfm->isStatic())
            {
                $obj = $class::getInstance();

                // 匹配到了方法
                call_user_func_array(array(&$obj, $method), $params);
                return;
            }
        }

        // 最终走404
        static::error404();
    }

    protected static function error404()
    {
        Response::setStatus(404);
    }
}
