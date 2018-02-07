<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>后台管理 - 杰利信息科技</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">

    <link rel="stylesheet" href="/static/libs/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/base/css/admin.css" media="all">
</head>
<body class="layui-layout-body">
<div class="layui-layout admin-login-block">
    <form class="layui-form admin-login-form" method="post" action="{$loginAction}">
        <div class="layui-form-item">
            <label class="layui-form-label">用户名:</label>
            <div class="layui-input-inline">
                <input type="text" name="username" autocomplete="off" placeholder="请输入用户..." class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密　码:</label>
            <div class="layui-input-inline">
                <input type="password" name="password" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="loginSubmit">登陆</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="/static/libs/layui/layui.js"></script>
</body>
</html>