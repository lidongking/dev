<?php
/**
 * Copyright (c) 2017, 杰利信息科技有限公司 dev.jelly-tec.com
 * 摘    要：test.php
 * 作    者：wangld
 * 修改日期：2017/6/19
 */

header('Content-Type:text/html;charset=UTF-8');
ini_set('display_errors', 'on');
error_reporting(E_ALL);
include_once dirname(__FILE__) . '/inc/config.php';
include_once dirname(__FILE__) . '/libs/xiaotu/autoload.php';

$db = \Xiaotu\DataBase\MySQL::getInstance();
$res = $db->table('test')->select()->where('id=:id', array('id' => 1))->find();
var_dump($res);

$db->table('test')->update(array('title' => 'new title updated'))->where('title=:title', array('title' => 'test'))->execute();
$db->table('test')->delete()->where('id=:id', array('id' => 1))->execute();
$db->table('test')->insert(array('title' => 'this is title', 'content' => 'this is content'))->execute();

$data = $db->table('test')->select()->findAll();
var_dump($data);
