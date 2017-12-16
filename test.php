<?php
/**
 * Copyright (c) 2017, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘    要：test.php
 * 作    者：wangld
 * 修改日期：2017/6/19
 */


echo json_encode('<br>dd 对的ddd分担点<br>');
exit;

use \Xiaotu\Cache\MongoDB;
header('Content-Type:text/html;charset=UTF-8');
ini_set('display_errors', 'on');
error_reporting(E_ALL);
include_once dirname(__FILE__) . '/inc/config.php';
include_once dirname(__FILE__) . '/libs/xiaotu/autoload.php';

$mongo = MongoDB::getInstance('TEST');
$res = $mongo->insert('test_test', array('title' => '标题'));
var_dump($res);

$db = \Xiaotu\DataBase\MySQL::getInstance('');
$db->table('test')->select()->where('id=:id', array('id' => 1))->find();

$db->table('test')->update(array('title' => 'new title updated'))->where('title=:title', array('title' => 'test'))->execute();
$db->table('test')->delete()->where('id=:id', array('id' => 1))->execute();
$db->table('test')->insert(array('title' => 'this is title', 'content' => 'this is content'))->execute();
