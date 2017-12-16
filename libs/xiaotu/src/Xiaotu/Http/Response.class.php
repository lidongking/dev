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
    private static $httpStatus = array(
        100 => "HTTP/1.1 100 Continue",
        101 => "HTTP/1.1 101 Switching Protocols",
        200 => "HTTP/1.1 200 OK",
        201 => "HTTP/1.1 201 Created",
        202 => "HTTP/1.1 202 Accepted",
        203 => "HTTP/1.1 203 Non-Authoritative Information",
        204 => "HTTP/1.1 204 No Content",
        205 => "HTTP/1.1 205 Reset Content",
        206 => "HTTP/1.1 206 Partial Content",
        300 => "HTTP/1.1 300 Multiple Choices",
        301 => "HTTP/1.1 301 Moved Permanently",
        302 => "HTTP/1.1 302 Found",
        303 => "HTTP/1.1 303 See Other",
        304 => "HTTP/1.1 304 Not Modified",
        305 => "HTTP/1.1 305 Use Proxy",
        307 => "HTTP/1.1 307 Temporary Redirect",
        400 => "HTTP/1.1 400 Bad Request",
        401 => "HTTP/1.1 401 Unauthorized",
        402 => "HTTP/1.1 402 Payment Required",
        403 => "HTTP/1.1 403 Forbidden",
        404 => "HTTP/1.1 404 Not Found",
        405 => "HTTP/1.1 405 Method Not Allowed",
        406 => "HTTP/1.1 406 Not Acceptable",
        407 => "HTTP/1.1 407 Proxy Authentication Required",
        408 => "HTTP/1.1 408 Request Time-out",
        409 => "HTTP/1.1 409 Conflict",
        410 => "HTTP/1.1 410 Gone",
        411 => "HTTP/1.1 411 Length Required",
        412 => "HTTP/1.1 412 Precondition Failed",
        413 => "HTTP/1.1 413 Request Entity Too Large",
        414 => "HTTP/1.1 414 Request-URI Too Large",
        415 => "HTTP/1.1 415 Unsupported Media Type",
        416 => "HTTP/1.1 416 Requested range not satisfiable",
        417 => "HTTP/1.1 417 Expectation Failed",
        500 => "HTTP/1.1 500 Internal Server Error",
        501 => "HTTP/1.1 501 Not Implemented",
        502 => "HTTP/1.1 502 Bad Gateway",
        503 => "HTTP/1.1 503 Service Unavailable",
        504 => "HTTP/1.1 504 Gateway Time-out"
    );

    private static $mimeTypes = array(
        'chm' => 'application/octet-stream',
        'ppt' => 'application/vnd.ms-powerpoint',
        'xls' => 'application/vnd.ms-excel',
        'doc' => 'application/msword',
        'exe' => 'application/octet-stream',
        'rar' => 'application/octet-stream',
        'js' => "javascript/js",
        'css' => "text/css",
        'pdf' => "application/pdf",
        'zip' => "application/zip",
        'tar' => "application/x-tar",
        'sh' => "application/x-sh",
        'gif' => "image/gif",
        'jpeg' => "image/pjpeg",
        'jpg' => "image/pjpeg",
        'tif' => "image/tiff",
        'tiff' => "image/tiff",
        'txt' => "text/plain",
        'c' => "text/plain",
        'h' => "text/plain",
        'html' => "text/html",
        'htm' => "text/html",
        'mpeg' => "video/mpeg",
        'movie' => "video/x-sgi-movie",
        'wav' => "audio/x-wav",
        'json' => "application/json"
    );

    /**
     * 功    能：输出http状态码和信息
     * 修改日期：2017-4-15
     *
     * @param int $code http状态码
     * @param string $msg 输出信息
     *
     * @return null 无返回输出信息
     */
    public static function status($code, $msg)
    {
        header(self::$httpStatus[$code]);
        $msg = '<h1>' . self::$httpStatus[$code] . '</h1><hr />' . $msg;
        self::output($msg);
    }

    /**
     * 功    能：输出具有mime类型的数据
     * 修改日期：2017-4-15
     *
     * @param string|array $stream 信息
     * @param string $type 输出类型
     * @param string $charset 编码
     *
     * @return null 无返回，直接输出信息
     */
    public static function output($stream, $type = 'html', $charset = 'UTF-8')
    {
        header('Access-Control-Allow-Origin: *');
        //header('Access-Control-Allow-Headers: x-requested-with,content-type');
        $contentType = self::getContentType($type);
        !$contentType ? : header("Content-Type: {$contentType};charset=$charset");
        echo $stream;
    }

    /**
     * 功    能：获取mime类型
     * 修改日期：2017-4-15
     *
     * @param string $type 类型
     *
     * @return string 类型
     */
    private static function getContentType($type)
    {
        return isset(self::$mimeTypes[$type]) ? self::$mimeTypes[$type] : '';
    }
}
