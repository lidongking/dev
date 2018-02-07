{include file="admin/header.html.tpl"}
{include file="admin/slider.html.tpl"}
<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px; margin-top: 20px">
        <form class="layui-form admin-login-form" method="post" action="{$personalAction}{if $editPassword}?password{/if}">
            <span>基本资料</span>
            <span>账户密码</span>
            {if !$editPassword}
            <div class="layui-form-item">
                <div class="layui-form-label">用户名：</div>
                <div class="layui-input-inline">
                    <input value="{$personalInfo.username}" class="layui-input" disabled readonly>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-form-label">头　像：</div>
                <button type="button" class="layui-btn layui-btn-sm" id="avatar">
                    <i class="layui-icon">&#xe67c;</i>上传头像
                </button>
                <div class="layui-inline" style="position: relative">
                    <input type="hidden" name="avatar" value="{$personalInfo.avatar}">
                    <img style="position: absolute; top: -56px; left: 110px; border: 1px solid silver; border-radius: 2px" width="102" src="{$personalInfo.avatar}">
                    <span style="display: inline-block">(100kb以内)</span>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-form-label">昵　称：</div>
                <div class="layui-input-inline">
                    <input name="nickname" value="{$personalInfo.nickname}" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-form-label">年　龄：</div>
                <div class="layui-input-inline">
                    <input name="age" value="{$personalInfo.age}" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-form-label">性　别：</div>
                <div class="layui-input-block">
                    <input type="radio" name="sex" value="男" title="男" {if $personalInfo.sex=='男'} checked{/if}>
                    <input type="radio" name="sex" value="女" title="女" {if $personalInfo.sex=='女'} checked{/if}>
                    <input type="radio" name="sex" value="未知" title="未知" {if $personalInfo.sex=='未知'} checked{/if}>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-form-label">电　话：</div>
                <div class="layui-input-inline">
                    <input name="telephone" value="{$personalInfo.telephone}" type="tel" class="layui-input">
                </div>
            </div>
            {else}
            <div class="layui-form-item">
                <div class="layui-form-label">原密码：</div>
                <div class="layui-input-inline">
                    <input name="password_old" type="password" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-form-label">新密码：</div>
                <div class="layui-input-inline">
                    <input name="password_new" type="password" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">请填写6到12位密码字母数字符号其中两种</div>
            </div>
            <div class="layui-form-item">
                <div class="layui-form-label">重复密码：</div>
                <div class="layui-input-inline">
                    <input name="password_repeat" type="password" class="layui-input">
                </div>
            </div>
            {/if}
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>
</div>
{include file="admin/footer.html.tpl"}
<script>
    layui.use(['form', 'layedit', 'laydate'], function () {
        var form = layui.form
    });
    layui.use('upload', function () {
        var upload = layui.upload;

        //执行实例
        var uploadInst = upload.render({
            elem: '#avatar' //绑定元素
            , url: '/Api/upload' //上传接口
            , done: function (res) {
                //上传完毕回调
                if (null == res.file.error_msg) {
                    $("#avatar").parent().find('img')[0].src = (res.file.dest);
                }
                else {
                    alert(res.file.error_msg);
                }
            }
            , error: function () {
                //请求异常回调
                alert('error')
            }
        });
    });
</script>