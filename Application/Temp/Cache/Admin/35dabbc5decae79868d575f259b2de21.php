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
    <link rel="stylesheet" href="__PUBLIC__/zyUpload/control/css/zyUpload.css" type="text/css">
    <link href="__PUBLIC__/H4/css/fm.tagator.jquery.css" rel="stylesheet"/>


    
    <!-- 全局js -->
    <script src="__PUBLIC__/H4/js/jquery.min.js"></script>
    <script src="__PUBLIC__/H4/js/bootstrap.min.js"></script>

    <!-- 自定义js -->
    <script src="__PUBLIC__/H4/js/content.min.js"></script>

    <!-- jQuery Validation plugin javascript-->
    <script src="__PUBLIC__/H4/js/jquery.form.js"></script>    
    <script src="__PUBLIC__/H4/js/plugins/layer/layer.js"></script>
    <script src="__PUBLIC__/H4/laydate/laydate.js"></script>
    <script src="__PUBLIC__/H4/js/plugins/iCheck/icheck.min.js"></script>
    <script src="__PUBLIC__/Uploadify/jquery.uploadify-3.1.min.js?ver=<?php echo rand(0,9999);?>"></script>
    <script type="text/javascript" src="__PUBLIC__/H4/js/fm.tagator.jquery.js"></script>

    <script src="__PUBLIC__/ueditor/ueditor.config.js"></script>
    <script src="__PUBLIC__/ueditor/ueditor.all.js"></script>
    <script src="__PUBLIC__/ueditor/lang/zh-cn/zh-cn.js"></script>
    <script type="text/javascript" src="__PUBLIC__/zyUpload/core/zyFile.js"></script>
    <script type="text/javascript" src="__PUBLIC__/zyUpload/control/js/zyUpload.js"></script>

</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo ($title["father"]); ?> <small><?php echo ($title["this"]); ?></small></h5>
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
                        <input type="hidden" name="id" value="<?php echo ($contentInfo["id"]); ?>">
                        <input type="hidden" name="method" value="<?php echo ($method); ?>">
                        <input type="hidden" name="modelName" value="<?php echo ($modelName); ?>">
                        <?php echo ($tplHtml); ?>     
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
            <?php if(is_array($keyArr)): $i = 0; $__LIST__ = $keyArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$k): $mod = ($i % 2 );++$i;?>$('#<?php echo ($k["name"]); ?>_tagator').click(function () {
                if ($('#<?php echo ($k["name"]); ?>').data('tagator') === undefined) {
                    $('#<?php echo ($k["name"]); ?>').tagator();
                } else {
                    $('#<?php echo ($k["name"]); ?>').tagator('destroy');
                }
            });
            
            $('#<?php echo ($k["name"]); ?>_tagator').trigger('click');
            
            $('#getvalue').click(function () {
                alert($("#<?php echo ($k["name"]); ?>").val());
            });<?php endforeach; endif; else: echo "" ;endif; ?>

            //以下是uploadify 文件上传插件
            <?php if(is_array($imgArr)): $i = 0; $__LIST__ = $imgArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$img): $mod = ($i % 2 );++$i;?>try {                                    //单图上传
                  $('#upload_<?php echo ($img["name"]); ?>').uploadify('destroy');
                  }catch(e)
                  {
                    $('#upload_<?php echo ($img["name"]); ?>').uploadify({
                        'swf'      : '__PUBLIC__/Uploadify/uploadify.swf',
                        'uploader' : "<?php echo U('uploadpic','','',0);?>",
                        'buttonText' : '<i class="fa fa-upload"></i>  上传图片',
                        'width' : 120,
                        'onUploadSuccess' : function(file, data, response) {
                            var newdata = data.split("_")[1];
                            $('#<?php echo ($img["name"]); ?>').attr('src','/Upload/image/'+newdata);
                            $('#<?php echo ($img["name"]); ?>_val').val('/Upload/image/'+newdata);
                        },
                    });
                    $("#upload_<?php echo ($img["name"]); ?>").css({position: "relative", border: "0px solid", left: "0px"}); 
                    //$("#note_thumb").css({position: "relative",  left: "0px",top: "-30px"}); 
                  };<?php endforeach; endif; else: echo "" ;endif; ?>

            //多图上传插件
            // 初始化插件
            $("#demo").zyUpload({ 
                itemWidth        :   "120px",                 // 文件项的宽度
                itemHeight       :   "100px",                 // 文件项的高度
                url              :   "<?php echo U('uploadpics');?>",  // 上传文件的路径
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
        <?php if(is_array($htmlArr)): $i = 0; $__LIST__ = $htmlArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$html): $mod = ($i % 2 );++$i;?>var ue_<?php echo ($html["name"]); ?> = UE.getEditor('<?php echo ($html["name"]); ?>',{
                toolbars:[[
                    'source','|','undo', 'redo', '|',
                    'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
                    'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
                    'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
                    'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|','indent', '|',
                    'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
                    'link', 'unlink', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                    'simpleupload', 'insertimage', 'emotion', 'attachment', 'map','pagebreak', '|',
                    'horizontal', 'date', 'time', 'spechars', '|',
                    'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', '|',
                    'print', 'searchreplace', 'drafts'
                ]],
                initialFrameHeight:250,
                initialContent:'<?php echo (stripslashes(htmlspecialchars_decode($contentInfo[$html["name"]]))); ?>'
            });<?php endforeach; endif; else: echo "" ;endif; ?>
        });


       

        function remove(file,id){
            $('#uploadList_k'+id).remove();
          }
        function postForm() {      //提交表单数据
            $("#contentForm").ajaxSubmit({
                 type: "post",
                 url: "<?php echo U('excute');?>",
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