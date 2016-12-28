<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--360浏览器优先以webkit内核解析-->
    <title>JUNGO会员管理系统后台 - 首页</title>

    <link rel="shortcut icon" href="favicon.ico"> <link href="__PUBLIC__/H4/css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
    <link href="__PUBLIC__/H4/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">

    <link href="__PUBLIC__/H4/css/animate.min.css" rel="stylesheet">
    <link href="__PUBLIC__/H4/css/style.min.css?v=4.0.0" rel="stylesheet">
    <base target="_blank">

</head>

<body class="gray-bg">
    <!-- <div class="row  border-bottom white-bg dashboard-header">
        <div class="col-sm-12">
            <blockquote class="text-warning" style="font-size:14px">【<?php if(($nickname) == ""): echo ($username); else: echo ($nickname); endif; ?>】欢迎使用JUNGO会员系统
                <br>上次登录时间：<?php echo (date('Y-m-d H:i:s',$lasttime)); ?>
                <br>上次登录IP：<?php echo ntoip($lastip);?> （不是您登录的？<a href="<?php echo U('Usr/edtadm','','',0);?>?id=<?php echo ($UsrID); ?>">请点这里</a>） 
                <br>当前域名：<?php echo ($DomainNow); ?>
                
            </blockquote>

            <hr>
        </div>
        <div class="col-sm-3">
            <small>移动设备访问请扫描以下二维码：</small>
            <br>
            <img src="__PUBLIC__/ttcms/img/qrcode.png" width="100%" style="max-width:264px;">
            <br>
            扫二维码，关注微信，了解更多资讯.
        </div>
        <div class="col-sm-5">
            <h2>
                    JUNGO会员管理系统介绍
                </h2>
            <p>JUNGO会员管理系统基于ThinkPHP+Bootstrap打造的响应式内容信息管理平台（Content management system）。前端采用了主流的左右两栏式布局，使用了Html5+CSS3等现代IT技术，具有高度的兼容性，可同时在电脑 PAD 手机等多种终端使用。系统继承TTCMS V1.0 的操作简便明了，容易上手的特点，经过更加专注的锤炼打造，具有更高的数据安全性，更快的响应速度，更美观大气的UI。重新构建了全新的数据结构，较之前代版本更加简洁高效，同时也减少了碎片化的泛滥。是您建站的不二选择...</p>
            <p>
                <b>当前版本：</b><span class="label label-warning">v2.0</span>
            </p>
            <br>
            <p>
                <a class="btn btn-success btn-outline" href="http://sighttp.qq.com/authd?IDKEY=32ea6e3f2449766763d0c0b5e61d505aea1653b2a102de23" target="_blank">
                    <i class="fa fa-qq"> </i> 联系我
                </a>
                <a class="btn btn-white btn-bitbucket" href="http://www.junnet.net" target="_blank">
                    <i class="fa fa-home"></i> 访问官网
                </a>
            </p>
        </div>
        <div class="col-sm-4">
            <h4>TTCMS V2.0 具有以下特点：</h4>
            <ol>
                <li>完全响应式布局（支持电脑、平板、手机等所有主流设备）</li>
                <li>基于最新版本的Bootstrap 3.3.4</li>
                <li>使用最流行的的扁平化设计</li>
                <li>采用HTML5 & CSS3</li>
                <li>拥有良好的代码结构</li>
                <li>更加简洁的数据库架构</li>
                <li>更高的数据安全性</li>
                <li>代码重构，更高效的执行效率</li>
                <li>更多……</li>
            </ol>
        </div>

    </div> -->
    <!-- <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-sm-4">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>最新文章动态</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>

                    <div class="ibox-content timeline">

                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-briefcase"></i>
                                    6:00
                                    <br>
                                    <small class="text-navy">2 小时前</small>
                                </div>
                                <div class="col-xs-7 content no-top-border">
                                    <p class="m-b-xs"><strong>服务器已彻底崩溃</strong>
                                    </p>

                                    <p>还未检查出错误</p>

                                    <p><span data-diameter="40" class="updating-chart" style="display: none;">9,6,5,9,4,7,3,2,9,8,7,4,5,1,2,9,5,4,7,2,7,7,3,5,2,2,10,8,2,8,4,4,4,9,1,7,4</span> 
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-file-text"></i>
                                    7:00
                                    <br>
                                    <small class="text-navy">3小时前</small>
                                </div>
                                <div class="col-xs-7 content">
                                    <p class="m-b-xs"><strong>修复了0.5个bug</strong>
                                    </p>
                                    <p>重启服务</p>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-coffee"></i>
                                    8:00
                                    <br>
                                </div>
                                <div class="col-xs-7 content">
                                    <p class="m-b-xs"><strong>喝水、上厕所、做测试</strong>
                                    </p>
                                    <p>
                                        喝了4杯水，上了3次厕所，控制台输出出2324个错误，神啊，带我走吧
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-phone"></i>
                                    11:00
                                    <br>
                                    <small class="text-navy">21小时前</small>
                                </div>
                                <div class="col-xs-7 content">
                                    <p class="m-b-xs"><strong>项目经理打电话来了</strong>
                                    </p>
                                    <p>
                                        TMD，项目经理居然还没有起床！！！
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-user-md"></i>
                                    09:00
                                    <br>
                                    <small>21小时前</small>
                                </div>
                                <div class="col-xs-7 content">
                                    <p class="m-b-xs"><strong>开会</strong>
                                    </p>
                                    <p>
                                        开你妹的会，老子还有897894个bug没有修复
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-comments"></i>
                                    12:50
                                    <br>
                                    <small class="text-navy">讨论</small>
                                </div>
                                <div class="col-xs-7 content">
                                    <p class="m-b-xs"><strong>…………</strong>
                                    </p>
                                    <p>
                                        又是操蛋的一天
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>最新图片集动态</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>

                    <div class="ibox-content timeline">

                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-briefcase"></i>
                                    6:00
                                    <br>
                                    <small class="text-navy">2 小时前</small>
                                </div>
                                <div class="col-xs-7 content no-top-border">
                                    <p class="m-b-xs"><strong>服务器已彻底崩溃</strong>
                                    </p>

                                    <p>还未检查出错误</p>

                                    <p><span data-diameter="40" class="updating-chart" style="display: none;">9,6,5,9,4,7,3,2,9,8,7,4,5,1,2,9,5,4,7,2,7,7,3,5,2,2,10,8,2,8,4,4,4,9,1,7,4</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-file-text"></i>
                                    7:00
                                    <br>
                                    <small class="text-navy">3小时前</small>
                                </div>
                                <div class="col-xs-7 content">
                                    <p class="m-b-xs"><strong>修复了0.5个bug</strong>
                                    </p>
                                    <p>重启服务</p>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-coffee"></i>
                                    8:00
                                    <br>
                                </div>
                                <div class="col-xs-7 content">
                                    <p class="m-b-xs"><strong>喝水、上厕所、做测试</strong>
                                    </p>
                                    <p>
                                        喝了4杯水，上了3次厕所，控制台输出出2324个错误，神啊，带我走吧
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-phone"></i>
                                    11:00
                                    <br>
                                    <small class="text-navy">21小时前</small>
                                </div>
                                <div class="col-xs-7 content">
                                    <p class="m-b-xs"><strong>项目经理打电话来了</strong>
                                    </p>
                                    <p>
                                        TMD，项目经理居然还没有起床！！！
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-user-md"></i>
                                    09:00
                                    <br>
                                    <small>21小时前</small>
                                </div>
                                <div class="col-xs-7 content">
                                    <p class="m-b-xs"><strong>开会</strong>
                                    </p>
                                    <p>
                                        开你妹的会，老子还有897894个bug没有修复
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-comments"></i>
                                    12:50
                                    <br>
                                    <small class="text-navy">讨论</small>
                                </div>
                                <div class="col-xs-7 content">
                                    <p class="m-b-xs"><strong>…………</strong>
                                    </p>
                                    <p>
                                        又是操蛋的一天
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>最新留言</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content no-padding">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <p><a class="text-info" href="index_3.html#">@星探子</a> 我的目标就是想做一个跟你一样有责任感，有思想，有深度的新闻媒体从业人</p>
                                <small class="block text-muted"><i class="fa fa-clock-o"></i> 1分钟前</small>
                            </li>
                            <li class="list-group-item">
                                <p><a class="text-info" href="index_3.html#">@小七是</a> 其实自己一半的大学生活也基本上是和新闻为伍了～一篇小小的稿子也许只有5、6百字，可以却可以写1、2个小时。一场会议也许3个小时，睡一觉就过去了，可是却要端着相机站3个小时，害怕错过一个经典的镜头。新闻人，更辛苦。</p>
                                <div class="text-center m">
                                    <span id="sparkline8"></span>
                                </div>
                                <small class="block text-muted"><i class="fa fa-clock-o"></i> 2天前</small>
                            </li>
                            <li class="list-group-item">
                                <p><a class="text-info" href="index_3.html#">@镜子mini</a> 大一邵老师说记者是高危职业，防火防盗防记者；大二时老师说嫁人莫嫁记者郎。可他们依然坚守岗位，培养新闻学子。现在大三，毕业了也会从事新闻工作。有时候坚持一件事情，并不是因为这样做了会改变什么，而是坚信，这样做是对的。</p>
                                <small class="block text-muted"><i class="fa fa-clock-o"></i> 2分钟前</small>
                            </li>
                            <li class="list-group-item ">
                                <p><a class="text-info" href="index_3.html#">@爱nimen</a> 记得费希特在《论学者的使命》中说：“你们都是最优秀的知识分子。如果最优秀的分子丧失了自己的力量，那又用什么去感召呢？如果出类拔萃的人都腐化了，那还到哪里去寻找道德善良呢？”</p>
                                <small class="block text-muted"><i class="fa fa-clock-o"></i> 1小时前</small>
                            </li>
                            <li class="list-group-item ">
                                <p><a class="text-info" href="index_3.html#">@爱nimen</a> 记得费希特在《论学者的使命》中说：“你们都是最优秀的知识分子。如果最优秀的分子丧失了自己的力量，那又用什么去感召呢？如果出类拔萃的人都腐化了，那还到哪里去寻找道德善良呢？”</p>
                                <small class="block text-muted"><i class="fa fa-clock-o"></i> 1小时前</small>
                            </li>
                        </ul>
                    </div>
                </div> 
            </div>
        </div>
    </div> -->
    </script>
</body>

</html>