<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <title>登录</title>
    <meta property="qc:admins" content="3500076736063251636" />
    <meta name="keywords" content="会员,管理,系统">
    <meta name="description" content="">
    
    <link href="__PUBLIC__/H4/css/bootstrap.min.css" rel="stylesheet">
    <link href="__PUBLIC__/H4/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="__PUBLIC__/H4/css/animate.min.css" rel="stylesheet">
    <link href="__PUBLIC__/H4/css/style.min.css" rel="stylesheet">
    <link href="__PUBLIC__/H4/css/login.min.css" rel="stylesheet">
    <!--[if lt IE 8]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>
        if(window.top!==window.self){window.top.location=window.location};
    </script>

</head>

<body class="signin">
    <div class="signinpanel">
        <div class="row">
            <div class="col-sm-7">
                <div class="signin-info">
                    <div class="logopanel m-b">
                        <h1>[ + ]</h1>
                    </div>
                    <div class="m-b"></div>
                    <h4>欢迎使用 <strong>会员管理系统</strong></h4>
                    <ul class="m-b">
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 完全响应式布局（支持电脑、平板、手机等主流设备）</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 基于最新版本的Bootstrap 3.3.4</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 使用最流行的的扁平化设计</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 采用HTML5 & CSS3</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 拥有良好的代码结构</li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-5">
                <form id="loginForm" method="post" enctype="multipart/form-data">
                    <h4 class="no-margins">登录：</h4>
                    <p class="m-t-md">登录到会员管理系统后台</p>
                    <input type="text" name="username" class="form-control uname" placeholder="用户名" />
                    <input type="password" name="password" class="form-control pword m-b" placeholder="密码" />
                    <button class="btn btn-success btn-block" onclick="login();"  type="button">登录</button>
                </form>
            </div>
        </div>
        <div class="signup-footer">
            <div class="pull-left">
                &copy;2012-<?php echo date('Y');?> All Rights Reserved. 
            </div>
        </div>
    </div>
</body>
<script src="__PUBLIC__/H4/js/jquery.min.js"></script>
<script src="__PUBLIC__/H4/js/jquery.form.js"></script>
<script src="__PUBLIC__/H4/js/plugins/layer/layer.js"></script>
<script type="text/javascript">
    function login() {
      var USR= $("input[name='username']");
      var PWD= $("input[name='password']");

      if (USR.val()=="" || PWD.val()=="")
       {
        layer.msg('用户名与密码均不能为空!', {icon:2});
        USR.focus();
        return;
       }

      $("#loginForm").ajaxSubmit({
         type: "post",
         url: "<?php echo U('login');?>",
         dataType: "json",
         success: function(result){
            var getStatu=result.status;
            if (getStatu==0) 
              {
                layer.msg(result.info, {icon:2},function(){
                  PWD.val('');
                  PWD.focus();
                });                
              }
              else
              {
                var getData=result.data;
                layer.msg(result.info, {icon:1,time:500},function(){
                    location.href=getData;
                });                
              };
         }
     });
    }
</script>
</html>