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
    <link rel="stylesheet" href="__PUBLIC__/H4/css/lanrenzhijia.css">

</head>

<body class="gray-bg">

<!-- <div class="wrap"> -->
    <div class="tabs">
        <?php if(is_array($grlist)): $i = 0; $__LIST__ = $grlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="#" hidefocus="true" <?php if($key == 0 ): ?>class="active"<?php endif; ?>><?php echo ($vo["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>    
    <div class="swiper-container">
      <div class="swiper-wrapper">
      <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$UU): $mod = ($i % 2 );++$i;?><div class="swiper-slide">
        <div class="content-slide">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
        <?php if(is_array($UU["user"])): $i = 0; $__LIST__ = $UU["user"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$U): $mod = ($i % 2 );++$i; if ($U['pid']==0) { $isFist = true; }else{ $isFist = false; } ?>
            <div class="col-sm-4">
                <div class="contact-box">
                    <a href="javascript:;">
                        <div class="col-sm-4">
                            <div class="text-center">
                                <img alt="image" class="img-circle m-t-xs img-responsive" src="<?php echo ($U["qrsrc"]); ?>" style="border-radius:0;margin-top:0px;max-width:130%;">
                                <div class="m-t-xs font-bold" onClick="usrEdt(<?php echo ($U['ID']); ?>)"><?php echo ($U["username"]); ?></div>
                            </div>
                        </div>
                        <div class="col-sm-8" onClick="usrEdt(<?php echo ($U['ID']); ?>)">
                            <h3><strong style="color:red;" <?php if(($U["flag"]) == "0"): endif; ?>><?php echo ($U["mname"]); ?>[lv:<?php echo ($U["dengji"]); ?>]</strong></h3>
                            <p>&nbsp;</p>
                            <address <?php if(($U["flag"]) == "0"): ?>style="color:red;"<?php endif; ?>>
                                <p style="color:red;">手机：<?php echo ($U["moblie"]); ?></p>
                                <p style="color:pink;">微信：<?php echo ($U["weixinaccout"]); ?></p>
                                <p style="color:black;">支付宝：<?php echo ($U["qqaccout"]); ?></p>
                                <p style="color:black;">下线数：<?php echo (getalldowncount($U["mid"])); ?></p>
                                <p style="color:green;">升级券数：<?php echo ($U["quansum"]); ?><p>
                                <p style="color:green;">会员状态：<?php if(($U["flag"]) == "1"): ?>正常<?php else: ?>已停用<?php endif; ?></p><br>
                            </address>

                        </div>
                        <button class="btn btn-success btn-block" onclick="showOwn(<?php echo ($U["ID"]); ?>,<?php echo ($gid); ?>)" type="button"><i class="fa fa-eye"></i> &nbsp;查看下线会员</button>
<!--                         <?php if(($U["pid"]) != "0"): ?><button class="btn btn-success btn-block" onclick="showUp(<?php echo ($U["ID"]); ?>)" type="button"><i class="fa fa-eye"></i> &nbsp;查看上线会员</button><?php endif; ?> -->
                        <button class="btn btn-danger btn-block" onclick="clearLogin(<?php echo ($U["ID"]); ?>)" type="button"><i class="fa fa-user-times"></i> &nbsp;清除登录</button>
                        <div class="clearfix"></div>
                    </a>
                </div>
            </div><?php endforeach; endif; else: echo "" ;endif; ?> 
        <?php if ($isFist==false) { ?>
            <div class="col-sm-4">
                <div class="contact-box" style="text-align:center;">
                    <a href="javascript:history.go(-1);">
                        <img src="__PUBLIC__/h4/img/back.png" style="max-width:215px;">
                    </a>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
        </div>
        </div><?php endforeach; endif; else: echo "" ;endif; ?>
      </div>
   </div>
<!-- </div> -->


    <!-- 全局js -->
    <script src="__PUBLIC__/H4/js/jquery.min.js"></script>
    <script src="__PUBLIC__/H4/js/bootstrap.min.js"></script>



    <!-- 自定义js -->
    <script src="__PUBLIC__/H4/js/content.min.js"></script>
    <script src="__PUBLIC__/H4/js/jquery.form.js"></script>
    <script src="__PUBLIC__/H4/js/plugins/layer/layer.js"></script>
    <script src="__PUBLIC__/H4/js/jquery.min.js"></script>
    <script src="__PUBLIC__/H4/js/mm.min.js"></script> 

<script>
var tabsSwiper = new Swiper('.swiper-container',{
  speed:500,
  onSlideChangeStart: function(){
    $(".tabs .active").removeClass('active');
    $(".tabs a").eq(tabsSwiper.activeIndex).addClass('active');
  }
});

$(".tabs a").on('touchstart mousedown',function(e){
  e.preventDefault()
  $(".tabs .active").removeClass('active');
  $(this).addClass('active');
  tabsSwiper.swipeTo($(this).index());
});

$(".tabs a").click(function(e){
  e.preventDefault();
});



        $(document).ready(function () {
            $('.contact-box').each(function () {
                animationHover(this, 'pulse');
            });
            var nn = <?php echo ($num); ?>;
            $(".tabs a").css("width",nn+'%');
        });

        function usrEdt (mid) {
            layer.open({
                type:2,
                title: ['编辑会员','background:#438EB9;color:#fff;'],
                content: "<?php echo U('edit');?>?mid="+mid,
                area:['740px', ($(window).height() - 50) +'px'],
                closeBtn:1,
                shade:[0.6, '#000'],
            });
        }

        function showOwn (mid,gid) {
            var url = "<?php echo U('Group/xiaoyu','pid=ppdd&gid=gids');?>";
            url = url.replace('ppdd',mid);
            url = url.replace('gids',gid);
            location.href = url;
        }

        function usrDel (mid) {   
        layer.confirm('是否删除当前会员?', {icon: 3, title:'删除确认'}, function(index){
            $(this).ajaxSubmit({
              type:"get",
              url:"<?php echo U('delete');?>",
              data:{
                  'mid':mid
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

        function clearLogin (mid) {   
        layer.confirm('是否清除当前会员的登录状态?', {icon: 3, title:'清除确认'}, function(index){
            $(this).ajaxSubmit({
              type:"get",
              url:"<?php echo U('clearlogin');?>",
              data:{
                  'mid':mid
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
                        location.href='';
                    });                    
                  };
               }
            });
        }); 
      }

      function searchMember () {
        var mphone  =   $('#searchValue').val();
        $(this).ajaxSubmit({
          type:"get",
          url:"<?php echo U('search');?>",
          data:{
              'moblie':mphone
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
                var goUrl=result.path;
                layer.msg(result.info,{icon:1,time:300},function(){
                    location.href=goUrl;
                });
              };
           }
        });
      }
    </script>

</body>

</html>