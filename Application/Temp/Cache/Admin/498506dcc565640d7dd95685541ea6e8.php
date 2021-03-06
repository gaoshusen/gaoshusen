<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title>JUNGO会员管理系统后台 - </title>

    <link href="/Public/H4/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/H4/css/font-awesome.min.css" rel="stylesheet">
    <link href="/Public/H4/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/Public/H4/css/animate.min.css" rel="stylesheet">
    <link href="/Public/H4/css/style.min.css" rel="stylesheet">
    <link href="/Public/Uploadify/uploadify.css" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5></h5>
                        <div class="ibox-tools">
                            <a title="刷新当前页面" href="javascript:location.replace(location.href);">
                                <i class="fa fa-refresh"></i>
                            </a> 
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>                            
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal m-t" id="userForm" method="post">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">会员编号：</label>
                                <div class="col-sm-8">
                                    <input name="mid" value="" class="form-control" type="hidden">
                                    <label class="col-sm-3 control-label" style="color:red;text-align:left;font-size:40px"></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">推广二维码：</label>
                                <div class="col-sm-8">
                                    <input name="qrsrc" value="" class="form-control" type="hidden">
                                    <img src="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">会员名称：</label>
                                <div class="col-sm-8">
                                    <input type="hidden" name="method" value="add">
                                    <input type="hidden" name="id" value="">
                                    <input id="mname" name="mname" value="" class="form-control" type="text" aria-required="true" aria-invalid="false" class="valid" placeholder="请输入欲新增的会员名称。">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">会员等级：</label>
                                <div class="col-sm-8">                                
                                    <input id="dengji" name="dengji" value="" class="form-control" type="text" aria-required="true" aria-invalid="false" class="valid" placeholder="请输入欲新增的会员名称。">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">真实姓名：</label>
                                <div class="col-sm-8">
                                    <input id="truename" name="truename" value="" class="form-control" type="text" aria-required="true" aria-invalid="false" class="valid" placeholder="请输入欲新增的真实姓名。">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">密码：</label>
                                <div class="col-sm-8">
                                    <input id="mpwd" name="mpwd" class="form-control" type="password" placeholder="请设置会员的密码">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">确认密码：</label>
                                <div class="col-sm-8">
                                    <input id="repwd" name="repwd" class="form-control" type="password" placeholder="请再输入一次会员的密码进行验证">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">交易密码：</label>
                                <div class="col-sm-8">
                                    <input id="apwd" name="apwd" class="form-control" type="password" placeholder="请设置会员交易的密码">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">确认交易密码：</label>
                                <div class="col-sm-8">
                                    <input id="rapwd" name="rapwd" class="form-control" type="password" placeholder="请再输入一次会员的交易密码进行验证">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">会员手机：</label>
                                <div class="col-sm-8">
                                    <input id="moblie" name="moblie" value="" class="form-control" type="text" aria-required="true" aria-invalid="false" class="valid" placeholder="请输入会员的手机号码，以便联络。">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">会员支付宝：</label>
                                <div class="col-sm-8">
                                    <input id="qqaccout" name="qqaccout" value="" class="form-control" type="text" aria-required="true" aria-invalid="false" class="valid" placeholder="请输入会员的QQ号码，以便联络。">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">会员微信：</label>
                                <div class="col-sm-8">
                                    <input id="weixinaccout" name="weixinaccout" value="" class="form-control" type="text" aria-required="true" aria-invalid="false" class="valid" placeholder="请输入会员的微信号码，以便联络。">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">会员状态：</label>
                                <div class="col-sm-8">
                                    <div class="radio i-checks">
                                        <label>
                                            <input type="radio" value="1" name="flag" > <i></i>正常</label>
                                        
                                        <label>
                                            <input type="radio" value="0" name="flag" > <i></i>停用</label>
                                        </div>
                                </div>
                            </div> 

                            <div class="form-group">
                                <label class="col-sm-3 control-label">备注说明：</label>
                                <div class="col-sm-8">
                                    <textarea id="markcontent" name="markcontent" class="form-control" aria-required="true" style="height:120px;"></textarea>
                                </div>
                            </div> 
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-3">
                                    <button class="btn btn-primary" onclick="postForm();" type="button">提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- 全局js -->
    <script src="/Public/H4/js/jquery.min.js"></script>
    <script src="/Public/H4/js/bootstrap.min.js"></script>

    <!-- 自定义js -->
    <script src="/Public/H4/js/content.min.js"></script>

    <!-- jQuery Validation plugin javascript-->
    <script src="/Public/H4/js/jquery.form.js"></script>
    <script src="/Public/H4/js/plugins/layer/layer.js"></script>
    <script src="/Public/H4/js/plugins/iCheck/icheck.min.js"></script>
    <script src="/Public/Uploadify/jquery.uploadify-3.1.min.js?ver=1610"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });

        function postForm() {      //提交表单数据
            // alert('abc');
            var mname = $('#mname').val();
            var mpwd = $('#mpwd').val();
            var repwd = $('#repwd').val();
            var apwd = $('#apwd').val();
            var rapwd = $('#rapwd').val();
            var level = Number($('#dengji').val());

            if (mpwd=='' || mname=='') {layer.msg('账号密码不能为空，请重设！', {icon:2});return;};
            if (apwd=='') {layer.msg('交易密码不能为空，请重设！', {icon:2});return;};
            if (mpwd!='' && repwd!=mpwd) {
                layer.msg('两次输入的登录密码不一致，请重设！', {icon:2});
                return;
            };
            if (apwd!='' && rapwd!=apwd) {
                layer.msg('两次输入的交易密码不一致，请重设！', {icon:2});
                return;
            };
            if (level<0 || level>5) {
                layer.msg('等级设置只能在0~5期间！', {icon:2});
                return;
            };
            var moblie  =   $('#moblie').val();
            var truename    =   $('#truename').val();
            var wex     =   $('#weixinaccout').val();

            if (moblie=='' || truename=='' || wex=='') {
                layer.msg('手机号、真实姓名及微信号为必填项，请填写！', {icon:2});
                return;
            };
            $("#userForm").ajaxSubmit({
                 type: "post",
                 url: "/index.php/admin/Group/excute",
                 dataType: "json",
                 success: function(result){
                    var getStatu=result.status;
                    if (getStatu==0) 
                      {
                        layer.msg(result.info, {icon:2});
                      }
                      else
                      {
                        var getData=result.data;
                        layer.msg(result.info, {icon:1,time:300},function(){
                                                        parent.location.href="/index.php/admin/Group/lists";                        });                        
                      };
                 }
             });
            };        
    </script>


</body>

</html>