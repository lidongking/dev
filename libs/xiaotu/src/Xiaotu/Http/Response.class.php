<?php
/**
 * Copyright (c) 2016, [dev.jelly-tec.com]
 * 摘    要：
 * 作    者：wangld
 * 修改日期：2017/4/15
 */

namespace Xiaotu\Http;

use Xiaotu\Base;

class Response extends Base
{
    private static $_httpCode = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
    );
    private $_charset;
    const CHARSET = "UTF-8";

    private function _parseXml($msg)
    {
        $result = '';
        if (is_array($msg))
        {
            foreach ($msg as $key => $val)
            {
                $tag = is_int($key) ? 'item' : $key;
                $result .= '<' . $tag . '>' . $this->_parseXml($val) . '</' . $tag . '>';
            }
        }
        else
        {
            $result = preg_match("/^[^<>]+$/is", $msg) ? $msg : '<![CDATA[' . $msg . ']]>';
        }

        return $result;
    }

    public function setCharset($charset = null)
    {
        $this->_charset = empty($charset) ? self::CHARSET : $charset;
    }

    public function getCharset()
    {
        if (empty($this->_charset))
        {
            $this->setCharset();
        }

        return $this->_charset;
    }

    public function setContentType($contentType = 'text/html')
    {
        header('Content-Type: ' . $contentType . '; charset=' . $this->getCharset(), true);
    }

    public function setHeader($name, $value)
    {
        header($name . ': ' . $value, true);
    }

    public static function setStatus($code)
    {
        if (isset(self::$_httpCode[$code]))
        {
            header((isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1') . ' ' . $code . ' ' . self::$_httpCode[$code], true, $code);
        }
    }

    public function throwXml($msg)
    {
        /** 设置http头信息 */
        $this->setContentType('text/xml');
        /** 构建消息体 */
        echo '<?xml version="1.0" encoding="' . $this->getCharset() . '"?>', '<response>', $this->_parseXml($msg), '</response>';
        /** 终止后续输出 */
        exit;
    }

    public function throwJson($msg)
    {
        /** 设置http头信息 */
        $this->setContentType('application/json');
        echo json_encode($msg);
        /** 终止后续输出 */
        exit;
    }

    public function redirect($location, $isPermanently = false)
    {
        // 考虑处理url $location
        if ($isPermanently)
        {
            header('Location: ' . $location, true, 301);
            exit;
        }
        else
        {
            header('Location: ' . $location, true, 302);
            exit;
        }
    }

    public function goBack($suffix = null, $default = null)
    {
        //获取来源
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        //判断来源
        if (!empty($referer))
        {
            // ~ fix Issue 38
            if (!empty($suffix))
            {
                $parts = parse_url($referer);
                $myParts = parse_url($suffix);
                if (isset($myParts['fragment']))
                {
                    $parts['fragment'] = $myParts['fragment'];
                }
                if (isset($myParts['query']))
                {
                    $args = array();
                    if (isset($parts['query']))
                    {
                        parse_str($parts['query'], $args);
                    }
                    parse_str($myParts['query'], $currentArgs);
                    $args = array_merge($args, $currentArgs);
                    $parts['query'] = http_build_query($args);
                }
                $referer = (isset($parts['scheme']) ? $parts['scheme'] . '://' : null) . (isset($parts['user']) ? $parts['user'] . (isset($parts['pass']) ? ':' . $parts['pass'] : null) . '@' : null) . (isset($parts['host']) ? $parts['host'] : null) . (isset($parts['port']) ? ':' . $parts['port'] : null) . (isset($parts['path']) ? $parts['path'] : null) . (isset($parts['query']) ? '?' . $parts['query'] : null) . (isset($parts['fragment']) ? '#' . $parts['fragment'] : null);
            }
            $this->redirect($referer, false);
        }
        elseif (!empty($default))
        {
            $this->redirect($default);
        }
        exit;
    }

    public static function showMsg($msg = '默认消息', $url = null, $timeout = 3)
    {
        $timeout = intval($timeout) * 1000;
        $url = isset($url) ? $url : '';
        $html = "<html><body><div style='width: 300px; height: 60px; padding: 10px; margin: 100px auto; border: 1px solid #CCCCCC; 
text-align: center; vertical-align: middle; cursor: pointer;' onclick='window.location=\"{$url}\"'>{$msg}</div>";
        $html .= "<script>setTimeout(\"if ('{$url}'){window.location='{$url}';}else{history.go(-1);}\", {$timeout});</script>" . "</body></html>";
        exit($html);
    }
}
