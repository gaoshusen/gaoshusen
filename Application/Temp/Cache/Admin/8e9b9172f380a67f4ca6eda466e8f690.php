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
    <link rel="stylesheet" href="/Public/zyUpload/control/css/zyUpload.css" type="text/css">
    <link href="/Public/H4/css/fm.tagator.jquery.css" rel="stylesheet"/>


    
    <!-- 全局js -->
    <script src="/Public/H4/js/jquery.min.js"></script>
    <script src="/Public/H4/js/bootstrap.min.js"></script>

    <!-- 自定义js -->
    <script src="/Public/H4/js/content.min.js"></script>

    <!-- jQuery Validation plugin javascript-->
    <script src="/Public/H4/js/jquery.form.js"></script>    
    <script src="/Public/H4/js/plugins/layer/layer.js"></script>
    <script src="/Public/H4/laydate/laydate.js"></script>
    <script src="/Public/H4/js/plugins/iCheck/icheck.min.js"></script>
    <script src="/Public/Uploadify/jquery.uploadify-3.1.min.js?ver=5162"></script>
    <script type="text/javascript" src="/Public/H4/js/fm.tagator.jquery.js"></script>

    <script src="/Public/ueditor/ueditor.config.js"></script>
    <script src="/Public/ueditor/ueditor.all.js"></script>
    <script src="/Public/ueditor/lang/zh-cn/zh-cn.js"></script>
    <script type="text/javascript" src="/Public/zyUpload/core/zyFile.js"></script>
    <script type="text/javascript" src="/Public/zyUpload/control/js/zyUpload.js"></script>

</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>内容管理 <small>新增内容</small></h5>
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
                        <form class="form-horizontal m-t" id="contentForm" method="post">
                        <input type="hidden" name="id" value="">
                        <input type="hidden" name="method" value="add">
                        <input type="hidden" name="modelName" value="ad">
                        <div class="form-group">
	                                <label class="col-sm-3 control-label">标题</label>
	                                <div class="col-sm-8">
	                                    <input id="title" name="title" value="" class="form-control" type="text" class="valid" placeholder="标题" >
	                                	<span class="help-block m-b-none"><i class="fa fa-info-circle"></i>标题</span>
	                                </div>
	                            </div><div class="form-group">
	                                <label class="col-sm-3 control-label">广告缩略图预览：</label>
	                                <div class="col-sm-8">
	                                    <img id="thumb" src="/Public/ttcms/img/nopic.png" width="160" height="120" border="0" />
	                                </div>
	                            </div>
	                            <div class="form-group">
	                                <label class="col-sm-3 control-label">广告缩略图上传：</label>
	                                <div class="col-sm-8">
	                                    <input id="thumb_val" type="hidden" name="thumb" value="/Public/ttcms/img/nopic.png"><input id="upload_thumb" name="upload_thumb" type="file" multiple="true" value="" />
	                                	<span class="help-block m-b-none"><i class="fa fa-info-circle"></i>广告缩略图，打开红包结果页显示【750*277】</span>
	                                </div>
	                            </div><div class="form-group">
	                                <label class="col-sm-3 control-label">广告链接</label>
	                                <div class="col-sm-8">
	                                    <input id="url" name="url" value="" class="form-control" type="text" class="valid" placeholder="请输入广告的跳转链接" >
	                                	<span class="help-block m-b-none"><i class="fa fa-info-circle"></i>请输入广告的跳转链接</span>
	                                </div>
	                            </div><div class="form-group">
	                                <label class="col-sm-3 control-label">广告主图预览：</label>
	                                <div class="col-sm-8">
	                                    <img id="mphoto" src="/Public/ttcms/img/nopic.png" width="160" height="120" border="0" />
	                                </div>
	                            </div>
	                            <div class="form-group">
	                                <label class="col-sm-3 control-label">广告主图上传：</label>
	                                <div class="col-sm-8">
	                                    <input id="mphoto_val" type="hidden" name="mphoto" value="/Public/ttcms/img/nopic.png"><input id="upload_mphoto" name="upload_mphoto" type="file" multiple="true" value="" />
	                                	<span class="help-block m-b-none"><i class="fa fa-info-circle"></i>此为广告主图，显示在10秒广告中【750*1334】</span>
	                                </div>
	                            </div><div class="form-group">
	                                <label class="col-sm-3 control-label">简述：</label>
	                                <div class="col-sm-8">
	                                    <textarea id="description" name="description" class="form-control" aria-required="true" style="height:120px;"></textarea>
	                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>简述</span>
	                                </div>
	                            </div><div class="form-group">
	                                <label class="col-sm-3 control-label">开始时间：</label>
	                                <div class="col-sm-8">
	                                    <input placeholder="请选择日期" id="s_time" name="s_time" class="form-control" style="width:240px" readonly onclick="laydate({istime: false,min: laydate.now()})">
	                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>请设置广告的生效开始时间</span>                                  
	                                </div>
	                            </div><div class="form-group">
	                                <label class="col-sm-3 control-label">到期时间：</label>
	                                <div class="col-sm-8">
	                                    <input placeholder="请选择日期" id="e_time" name="e_time" class="form-control" style="width:240px" readonly onclick="laydate({istime: false,min: laydate.now()})">
	                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>请设置广告到期时间</span>                                  
	                                </div>
	                            </div><div class="form-group">
	                                <label class="col-sm-3 control-label">是否启用：</label>
	                                <div class="col-sm-8">
	                                    <div class="radio i-checks">
	                                    	<label>
	                                            <input type="radio" value="0" name="status" <?php if(($contentInfo["status"]) == "0"): ?>checked="checked"<?php endif; ?>> <i></i>停用
	                                        </label><label>
	                                            <input type="radio" value="1" name="status" <?php if(($contentInfo["status"]) == "1"): ?>checked="checked"<?php endif; ?>> <i></i>启用
	                                        </label>
                                        </div>
                                        <span class="help-block m-b-none"><i class="fa fa-info-circle"></i></span>
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



    <script type="text/javascript">
        $(document).ready(function () {
            $(".file-box").each(function(){animationHover(this,"pulse")})
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            // 定义时间选择器风格
            laydate.skin('yalan');

            //以下是标签自动分段插件加载
            
            //以下是uploadify 文件上传插件
            try {                                    //单图上传
                  $('#upload_thumb').uploadify('destroy');
                  }catch(e)
                  {
                    $('#upload_thumb').uploadify({
                        'swf'      : '/Public/Uploadify/uploadify.swf',
                        'uploader' : "/index.php/admin/Content/uploadpic",
                        'buttonText' : '<i class="fa fa-upload"></i>  上传图片',
                        'width' : 120,
                        'onUploadSuccess' : function(file, data, response) {
                            var newdata = data.split("_")[1];
                            $('#thumb').attr('src','/Upload/image/'+newdata);
                            $('#thumb_val').val('/Upload/image/'+newdata);
                        },
                    });
                    $("#upload_thumb").css({position: "relative", border: "0px solid", left: "0px"}); 
                    //$("#note_thumb").css({position: "relative",  left: "0px",top: "-30px"}); 
                  };try {                                    //单图上传
                  $('#upload_mphoto').uploadify('destroy');
                  }catch(e)
                  {
                    $('#upload_mphoto').uploadify({
                        'swf'      : '/Public/Uploadify/uploadify.swf',
                        'uploader' : "/index.php/admin/Content/uploadpic",
                        'buttonText' : '<i class="fa fa-upload"></i>  上传图片',
                        'width' : 120,
                        'onUploadSuccess' : function(file, data, response) {
                            var newdata = data.split("_")[1];
                            $('#mphoto').attr('src','/Upload/image/'+newdata);
                            $('#mphoto_val').val('/Upload/image/'+newdata);
                        },
                    });
                    $("#upload_mphoto").css({position: "relative", border: "0px solid", left: "0px"}); 
                    //$("#note_thumb").css({position: "relative",  left: "0px",top: "-30px"}); 
                  };
            //多图上传插件
            // 初始化插件
            $("#demo").zyUpload({ 
                itemWidth        :   "120px",                 // 文件项的宽度
                itemHeight       :   "100px",                 // 文件项的高度
                url              :   "/index.php/admin/Content/uploadpics",  // 上传文件的路径
                multiple         :   true,                    // 是否可以多个文件上传
                dragDrop         :   false,                    // 是否可以拖动上传文件
                del              :   true,                    // 是否可以删除文件
                finishDel        :   false,                   // 是否在上传文件完成后删除预览
                /* 外部获得的回调接口 */
                onSuccess: function(file, response){          // 文件上传成功的回调方法
                    var filename= response.replace(/["“”]/g,"");
                    $('#upname_'+ file.index).val(filename);
                },
            });

        //以下是加载Ueditor 富文本编辑器
                });


       

        function remove(file,id){
            $('#uploadList_k'+id).remove();
          }
        function postForm() {      //提交表单数据
            $("#contentForm").ajaxSubmit({
                 type: "post",
                 url: "/index.php/admin/Content/excute",
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
                        location.replace(location.href);
                        });                        
                      };
                 }
             });
            };        
    </script>


</body>

</html>