<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title>JUNGO会员管理系统后台 - <?php echo ($windowTitle); ?></title>

    <link href="__PUBLIC__/H4/css/bootstrap.min.css" rel="stylesheet">
    <link href="__PUBLIC__/H4/css/font-awesome.min.css" rel="stylesheet">
    <link href="__PUBLIC__/H4/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="__PUBLIC__/H4/css/animate.min.css" rel="stylesheet">
    <link href="__PUBLIC__/H4/css/style.min.css" rel="stylesheet">
    <link href="__PUBLIC__/Uploadify/uploadify.css" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo ($windowTitle); ?></h5>
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
                                <label class="col-sm-3 control-label">用户名：</label>
                                <div class="col-sm-8">
                                    <input type="hidden" name="method" value="<?php echo ($method); ?>">
                                    <input type="hidden" name="id" value="<?php echo ($id); ?>">
                                    <input id="username" name="username" value="<?php echo ($username); ?>" class="form-control" type="text" aria-required="true" aria-invalid="false" class="valid" placeholder="请输入欲新增的用户名称，此名称登录时使用。" <?php if(($method) == "edit"): ?>readonly<?php endif; ?>>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">昵称：</label>
                                <div class="col-sm-8">
                                    <input id="nickname" name="nickname" value="<?php echo ($nickname); ?>" class="form-control" type="text" aria-required="true" aria-invalid="true" class="error" placeholder="请输入用户的昵称">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">密码：</label>
                                <div class="col-sm-8">
                                    <input id="password" name="password" class="form-control" type="password" placeholder=<?php if(($method) == "edit"): ?>"如不修改密码请留空！"<?php else: ?>"请设置用户的密码"<?php endif; ?>>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">确认密码：</label>
                                <div class="col-sm-8">
                                    <input id="repwd" name="repwd" class="form-control" type="password" placeholder=<?php if(($method) == "edit"): ?>"如不修改密码请留空！"<?php else: ?>"请再输入一次用户的密码进行验证"<?php endif; ?>>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-sm-3 control-label">所属角色：</label>
                                <div class="col-sm-8">
                                <?php if(($rid) == "0"): ?><label class="col-sm-3 control-label">系统超级管理员</label>
                                <?php else: ?>
                                    <select class="form-control" style="width:350px;" name="rid" id="rid">
                                        <option value="0">----请选择角色----</option>
                                    <?php if(is_array($roleList)): $i = 0; $__LIST__ = $roleList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$R): $mod = ($i % 2 );++$i;?><option value="<?php echo ($R["id"]); ?>" <?php if(($R["id"]) == $rid): ?>selected="selected"<?php endif; ?> >
                                        <?php echo ($R["name"]); ?>
                                        </option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select><?php endif; ?>                                  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">头像预览：</label>
                                <div class="col-sm-8">
                                    <img id="thumb" src="<?php if(($photo) == ""): ?>__PUBLIC__/ttcms/img/nopic.png<?php else: echo ($photo); endif; ?>" width="64" height="64" border="0" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">头像上传[最佳分辨率：64*64px]：</label>
                                <div class="col-sm-8">
                                    <input id="thumb_val" type="hidden" name="photo" value="<?php echo ($photo); ?>"><input id="file_upload" name="file_upload" type="file" multiple="true" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">用户状态：</label>
                                <div class="col-sm-8">
                                    <div class="radio i-checks">
                                        <label>
                                            <input type="radio" value="1" name="status" <?php if(($status) == "1"): ?>checked="checked"<?php endif; ?>> <i></i>正常</label>
                                        
                                        <label>
                                            <input type="radio" value="0" name="status" <?php if(($status) == "0"): ?>checked="checked"<?php endif; ?>> <i></i>停用</label>
                                        </div>
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
    <script src="__PUBLIC__/H4/js/jquery.min.js"></script>
    <script src="__PUBLIC__/H4/js/bootstrap.min.js"></script>

    <!-- 自定义js -->
    <script src="__PUBLIC__/H4/js/content.min.js"></script>

    <!-- jQuery Validation plugin javascript-->
    <script src="__PUBLIC__/H4/js/jquery.form.js"></script>
    <script src="__PUBLIC__/H4/js/plugins/layer/layer.js"></script>
    <script src="__PUBLIC__/H4/js/plugins/iCheck/icheck.min.js"></script>
    <script src="__PUBLIC__/Uploadify/jquery.uploadify-3.1.min.js?ver=<?php echo rand(0,9999);?>"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            try {
                  $('#file_upload').uploadify('destroy');
                  }catch(e)
                  {
                    $('#file_upload').uploadify({
                        'swf'      : '__PUBLIC__/Uploadify/uploadify.swf',
                        'uploader' : "<?php echo U('uploadpic','','',0);?>",
                        'buttonText' : '<i class="icon-upload"></i>  上传图片',
                        'width' : 100,
                        'onUploadSuccess' : function(file, data, response) {
                            var newdata = data.split("_")[1];
                            $('#thumb').attr('src','/Upload/image/'+newdata);
                            $('#thumb_val').val('/Upload/image/'+newdata);
                        },
                    });
                    $("#file_upload").css({position: "relative", border: "0px solid", left: "0px"}); 
                    //$("#note_thumb").css({position: "relative",  left: "0px",top: "-30px"}); 
                  };
        });

        function showIcon() {       //弹出图标选择列表
                layer.open({
                    type:2,
                    title: ['选择图标','background:#438EB9;color:#fff;'],
                    content: '<?php echo U('Sys/icons');?>',
                    area:['740px', ($(window).height() - 100) +'px'],
                    closeBtn:1,
                    shade:[0.6, '#000'],
                });   
            };

        function postForm() {      //提交表单数据
            var password = $('#password').val();
            var repwd = $('#repwd').val();
            if (password!='' && repwd!=password) {
                layer.msg('再次输入的密码不致，请重设！', {icon:2});
                return;
            };
            $("#userForm").ajaxSubmit({
                 type: "post",
                 url: "<?php echo U('execution');?>",
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
                            <?php if(($isFull) == "1"): ?>location.replace(location.href);
                            <?php else: ?>
                            parent.location.href="<?php echo U('lists');?>";<?php endif; ?>
                        });                        
                      };
                 }
             });
            };        
    </script>


</body>

</html>