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
                        <h5>角色管理 <small><?php if(($method) == "edit"): ?>编辑角色<?php else: ?>新增角色<?php endif; ?></small></h5>
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
                        <form class="form-horizontal m-t" id="roleForm" method="post">
                           
                            <div class="form-group">
                                <label class="col-sm-3 control-label">角色名：</label>
                                <div class="col-sm-8">
                                    <input type="hidden" name="method" value="<?php echo ($method); ?>">
                                    <input type="hidden" name="id" value="<?php echo ($id); ?>">
                                    <input id="name" name="name" value="<?php echo ($name); ?>" class="form-control" type="text" aria-required="true" aria-invalid="false" class="valid" placeholder="请输入欲新增的角色名称。">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">说明：</label>
                                <div class="col-sm-8">
                                    <textarea id="des" name="des" class="form-control"><?php echo ($des); ?></textarea>
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
    <script type="text/javascript">
        
        function postForm() {      //提交表单数据
            $("#roleForm").ajaxSubmit({
                 type: "post",
                 url: "<?php echo U('roleaction');?>",
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
                            parent.location.replace(getData);
                        });                        
                      };
                 }
             });
            };        
    </script>
</body>

</html>