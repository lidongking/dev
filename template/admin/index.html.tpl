{include file="admin/header.html.tpl"}
{include file="admin/slider.html.tpl"}
<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        {if $last_login_info}
        上次登录信息: <br>
        IP：{$last_login_info.ip}<br>
        Time：{$last_login_info.time}
        {/if}
    </div>
</div>
{include file="admin/footer.html.tpl"}