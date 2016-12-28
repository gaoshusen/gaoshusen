<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title>JUNGO会员管理系统后台 - 目录管理</title>

    <link href="__PUBLIC__/H4/css/bootstrap.min.css" rel="stylesheet">
    <link href="__PUBLIC__/H4/css/font-awesome.min.css" rel="stylesheet">
    <link href="__PUBLIC__/H4/css/animate.min.css" rel="stylesheet">
    <link href="__PUBLIC__/H4/css/style.min.css" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
        <?php if(is_array($usrList)): $i = 0; $__LIST__ = $usrList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$U): $mod = ($i % 2 );++$i;?><div class="col-sm-4">
                <div class="contact-box">
                    <a href="javascript:;">
                        <div class="col-sm-4">
                            <div class="text-center">
                                <img alt="image" class="img-circle m-t-xs img-responsive" src="<?php if(($U["photo"]) == ""): ?>__PUBLIC__/H4/img/nopic.png<?php else: echo ($U["photo"]); endif; ?>" onClick="usrEdt(<?php echo ($U['id']); ?>)">
                                <div class="m-t-xs font-bold" onClick="usrEdt(<?php echo ($U['id']); ?>)"><?php echo ($U["username"]); ?></div>
                            </div>
                        </div>
                        <div class="col-sm-8" onClick="usrEdt(<?php echo ($U['id']); ?>)">
                            <h3><strong <?php if(($U["status"]) == "0"): ?>style="color:red;"<?php endif; ?>><?php echo ($U["nickname"]); ?></strong></h3>
                            <p>&nbsp;</p>
                            <address <?php if(($U["status"]) == "0"): ?>style="color:red;"<?php endif; ?>>
                                <strong>角色：<?php echo ($roleList[$U['rid']]); ?></strong><br>
                                上次登录时间：<br><?php echo (date('Y-m-d H:i:s',$U["lasttime"])); ?><br>
                                上次登录IP：<br><?php echo ntoip($U['lastip']);?><br>
                                登录次数：<?php echo ($U["logins"]); ?><br>
                                用户状态：<?php if(($U["status"]) == "1"): ?>正常<?php else: ?>已停用<?php endif; ?><br>
                            </address>

                        </div>
                        <button class="btn btn-danger btn-block" onclick="usrDel(<?php echo ($U["id"]); ?>)" type="button"><i class="fa fa-trash"></i> &nbsp;删除当前用户</button>
                        <div class="clearfix"></div>
                    </a>
                </div>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>   
        </div>
    </div>

    <!-- 全局js -->
    <script src="__PUBLIC__/H4/js/jquery.min.js"></script>
    <script src="__PUBLIC__/H4/js/bootstrap.min.js"></script>



    <!-- 自定义js -->
    <script src="__PUBLIC__/H4/js/content.min.js"></script>
    <script src="__PUBLIC__/H4/js/jquery.form.js"></script>
    <script src="__PUBLIC__/H4/js/plugins/layer/layer.js"></script>


    <script>
        $(document).ready(function () {
            $('.contact-box').each(function () {
                animationHover(this, 'pulse');
            });
        });

        function usrEdt (uid) {
        layer.open({
            type:2,
            title: ['编辑用户','background:#438EB9;color:#fff;'],
            content: "<?php echo U('edit');?>?uid="+uid,
            area:['740px', ($(window).height() - 50) +'px'],
            closeBtn:1,
            shade:[0.6, '#000'],
        });
        }

        function usrDel (uid) {   
        layer.confirm('是否删除当前用户?', {icon: 3, title:'删除确认'}, function(index){
            $(this).ajaxSubmit({
              type:"get",
              url:"<?php echo U('del');?>",
              data:{
                  'uid':uid
                },
              dataType: "json",
              success: function(result){
                var getStatu=result.status;
                if (getStatu==0) 
                  {
                    layer.msg(result.info,{icon:2});
                  }
                  else
                  {
                    var getData=result.data;
                    layer.msg(result.info,{icon:1,time:300},function(){
                        location.href=getData;
                    });                    
                  };
               }
            });
        }); 
      }
    </script>

</body>

</html>