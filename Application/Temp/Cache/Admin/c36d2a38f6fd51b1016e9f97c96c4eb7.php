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
    <link href="__PUBLIC__/H4/css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="__PUBLIC__/H4/css/animate.min.css" rel="stylesheet">
    <link href="__PUBLIC__/H4/css/style.min.css" rel="stylesheet">
    <link href="__PUBLIC__/Uploadify/uploadify.css" rel="stylesheet">
    <style type="text/css">
        .cell{
            width:10%;
            display: table-cell;
        }
    </style>
</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>站点设置 <small>基础信息设置</small></h5>
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
                        <form class="form-horizontal m-t" id="configForm" method="post">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">苹果APPstore地址：</label>
                                <div class="col-sm-8">
                                    <input id="appstore" name="appstore" value="<?php echo ($appstore); ?>" class="form-control" type="text" aria-required="true" aria-invalid="true" class="error" placeholder="请输入应用的APPStore地址，提供给用户下载">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">安卓版APP下载地址：</label>
                                <div class="col-sm-8">
                                    <input id="appUrl" name="appUrl" value="<?php echo ($appUrl); ?>" class="form-control" type="text" aria-required="true" aria-invalid="true" class="error" placeholder="请输入应用的APPStore地址，提供给用户下载">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">用户注册默认密码：</label>
                                <div class="col-sm-8">
                                    <input id="dftPWD" name="dftPWD" value="<?php echo ($dftPWD); ?>" class="form-control" type="text" aria-required="true" aria-invalid="true" class="error" placeholder="请输入用户注册默认密码">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">用户默认安全密码：</label>
                                <div class="col-sm-8">
                                    <input id="dftPWD" name="dftSafe" value="<?php echo ($dftSafe); ?>" class="form-control" type="text" aria-required="true" aria-invalid="true" class="error" placeholder="请输入用户默认安全密码">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">注册下线消耗升级券数量：</label>
                                <div class="col-sm-8">
                                    <input id="regPaper" name="regPaper" value="<?php echo ($regPaper); ?>" class="form-control" type="text" placeholder="请输入注册下线需要使用的升级券的数量！">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">团队管理处注册开关：</label>
                                <div class="col-sm-8">
                                    <div class="radio i-checks">
                                        <label>
                                            <input type="radio" value="1" name="regon" <?php if(($regon) == "1"): ?>checked="checked"<?php endif; ?>> <i></i>开</label>
                                        
                                        <label>
                                            <input type="radio" value="0" name="regon" <?php if(($regon) == "0"): ?>checked="checked"<?php endif; ?>> <i></i>关</label>
                                        </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">会员提现开关：</label>
                                <div class="col-sm-8">
                                    <div class="radio i-checks">
                                        <label>
                                            <input type="radio" value="1" name="cashon" <?php if(($cashon) == "1"): ?>checked="checked"<?php endif; ?>> <i></i>开</label>
                                        
                                        <label>
                                            <input type="radio" value="0" name="cashon" <?php if(($cashon) == "0"): ?>checked="checked"<?php endif; ?>> <i></i>关</label>
                                        </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">取现基数：</label>
                                <div class="col-sm-8">
                                    <input id="cashbasic" name="cashbasic" value="<?php echo ($cashbasic); ?>" class="form-control" type="text" placeholder="请设置系统的取现基数。">
                                    取现基数即限制了取现的最低金额，也限制了取现金额必须为基数的整数倍。如设为100，则取现金额必须大于100，且是100的整数倍。
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">红包广告时长：</label>
                                <div class="col-sm-8">
                                    <input id="adv_time" name="adv_time" value="<?php echo ($adv_time); ?>" class="form-control" type="text" placeholder="请设置红包的广告时长。">
                                    单位：秒。广告时长决定了打开红包时需要等待的时间长度
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">最低推荐人数：</label>
                                <div class="col-sm-8">
                                    <input id="leastNums" name="leastNums" value="<?php echo ($leastNums); ?>" class="form-control" type="text" aria-required="true" aria-invalid="true" class="error" placeholder="请输入会员可审核下线升级需要的最少的推荐人数！">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">推荐奖励设置：</label>
                                <div class="col-sm-8">
                                <input id="reward" name="reward" value="<?php echo ($reward); ?>" class="form-control" type="text" aria-required="true" aria-invalid="true" class="error" data-mask="99-99-99-99-99" placeholder="推荐人数大于最低推荐人数时生效">每推荐注册一个会员奖励的金额，推荐人数大于最低推荐人数时生效,从等级1至等级5依次设置，单位为RMB元
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">系统账号设置：</label>
                                <div class="col-sm-8">
                                    <input id="sysMphone" name="sysMphone" value="<?php echo ($sysMphone); ?>" class="form-control" type="text" aria-required="true" aria-invalid="true" class="error" placeholder="请输入系统账号的手机号！">
                                    系统账号可处理系统所有会员的升级申请,请设置系统账号的手机号,多个账号间以|分隔.
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">升级扣除券数量：</label>
                                <div class="col-sm-8">
                                <input id="pp_lv1" name="pp_lv1" value="<?php echo ($pp_lv1); ?>" class="form-control cell" type="text" placeholder="1级">》
                                <input id="pp_lv2" name="pp_lv2" value="<?php echo ($pp_lv2); ?>" class="form-control cell" type="text" placeholder="2级">》
                                <input id="pp_lv3" name="pp_lv3" value="<?php echo ($pp_lv3); ?>" class="form-control cell" type="text" placeholder="3级">》
                                <input id="pp_lv4" name="pp_lv4" value="<?php echo ($pp_lv4); ?>" class="form-control cell" type="text" placeholder="4级"><!-- 》
                                <input id="pp_lv5" name="pp_lv5" value="<?php echo ($pp_lv5); ?>" class="form-control cell" type="text" placeholder="5级"> -->
                                <p>会员审核升级请求时各级需要扣除的升级券数量，从左往右依次为1~4级</p>
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label class="col-sm-3 control-label">微信appid：</label>
                                <div class="col-sm-8">
                                    <input id="WXappid" name="WXappid" value="<?php echo ($WXappid); ?>" class="form-control" type="text" aria-required="true" aria-invalid="true" class="error" placeholder="请输入微信appid">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">微信appsecret：</label>
                                <div class="col-sm-8">
                                    <input id="WXappsecret" name="WXappsecret" value="<?php echo ($WXappsecret); ?>" class="form-control" type="text" aria-required="true" aria-invalid="true" class="error" placeholder="请输入微信appsecret">
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-sm-3 control-label">微信token：</label>
                                <div class="col-sm-8">
                                    <input id="WXtoken" name="WXtoken" value="<?php echo ($WXtoken); ?>" class="form-control" type="text" aria-required="true" aria-invalid="true" class="error" placeholder="请输入微信token">
                                </div>
                            </div>   -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">升级所需费用：</label>
                                <div class="col-sm-8">
                                    <input id="mny_lv1" name="mny_lv1" value="<?php echo ($mny_lv1); ?>" class="form-control cell" type="text" aria-required="true" aria-invalid="true" class="cell" placeholder="1级">》
                                    <input id="mny_lv2" name="mny_lv2" value="<?php echo ($mny_lv2); ?>" class="form-control cell" type="text" aria-required="true" aria-invalid="true" class="cell" placeholder="2级">》
                                    <input id="mny_lv3" name="mny_lv3" value="<?php echo ($mny_lv3); ?>" class="form-control cell" type="text" aria-required="true" aria-invalid="true" class="cell" placeholder="3级">》
                                    <input id="mny_lv4" name="mny_lv4" value="<?php echo ($mny_lv4); ?>" class="form-control cell" type="text" aria-required="true" aria-invalid="true" class="cell" placeholder="4级"><!-- 》
                                    <input id="mny_lv5" name="mny_lv5" value="<?php echo ($mny_lv5); ?>" class="form-control cell" type="text" aria-required="true" aria-invalid="true" class="cell" placeholder="5级"> -->
                                    <p>会员申请升级时各级需要向上线打款的金额，从左往右依次为1~4级</p>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-sm-3 control-label">温馨提示消息：</label>
                                <div class="col-sm-8">
                                    <input id="msg_tip" name="msg_tip" value="<?php echo ($msg_tip); ?>" class="form-control" type="text" aria-required="true" aria-invalid="true" class="error" placeholder="请输入温馨提示消息！">
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
    <script src="__PUBLIC__/H4/js/plugins/jasny/jasny-bootstrap.min.js"></script>
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

        function postForm() {      //提交表单数据
            $("#configForm").ajaxSubmit({
                 type: "post",
                 url: "<?php echo U('savebasic');?>",
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