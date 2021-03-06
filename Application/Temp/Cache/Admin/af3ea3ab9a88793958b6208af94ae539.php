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
                        <h5>反馈回复</h5>
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
                            <input name="id" type="hidden" value="<?php echo ($info["id"]); ?>">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">反馈会员：</label>
                                <div class="col-sm-8">
                                    <input name="mname" class="form-control" type="text" aria-required="true" aria-invalid="false" readonly="true" class="valid" value="<?php echo (getmebinfo($info["mid"],'mname')); ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">反馈类型：</label>
                                <div class="col-sm-4">
                                    <div class="col-sm-8">
                                        <input name="typestr" class="form-control" type="text" aria-required="true" aria-invalid="false" readonly="true" class="valid" value="<?php echo ($info["typestr"]); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">反馈内容：</label>
                                <div class="col-sm-4">
                                    <div class="col-sm-8">
                                        <textarea name="content" class="form-control" aria-required="true" style="height:120px;" readonly="readonly" ><?php echo ($info["content"]); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">回复内容：</label>
                                <div class="col-sm-4">
                                    <div class="col-sm-8">
                                        <textarea name="domsg" class="form-control" aria-required="true" style="height:120px;" ></textarea>
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
         //以下是uploadify 文件上传插件
        try {                                    //单图上传
          $('#upload_logo').uploadify('destroy');
          }catch(e)
          {
            $('#upload_logo').uploadify({
                'swf'      : '__PUBLIC__/Uploadify/uploadify.swf',
                'uploader' : "<?php echo U('Content/uploadpic');?>",
                'buttonText' : '<i class="fa fa-upload"></i>  上传图片',
                'width' : 120,
                'onUploadSuccess' : function(file, data, response) {
                    var newdata = data.split("_")[1];
                    $('#logo').attr('src','/Upload/image/'+newdata);
                    $('#logo_val').val('/Upload/image/'+newdata);
                },
            });
            $("#upload_logo").css({position: "relative", border: "0px solid", left: "0px"}); 
            //$("#note_thumb").css({position: "relative",  left: "0px",top: "-30px"}); 
          };
        function postForm() {      //提交表单数据
            var index = layer.load();
            $("#userForm").ajaxSubmit({
                 type: "post",
                 url: "<?php echo U('refeed');?>",
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
                        layer.close(index);  
                        layer.msg(result.info, {icon:1,time:300},function(){
                            <?php if(($isFull) == "1"): ?>location.replace(location.href);
                            <?php else: ?>
                            parent.location.href="<?php echo U('feedlist');?>";<?php endif; ?>
                        });                        
                      };
                 }
             });
            };        
    </script>


</body>

</html>