<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <title>JUNGO会员管理系统后台 - 内容模型</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link href="__PUBLIC__/H4/css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
    <link href="__PUBLIC__/H4/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">

    <!-- Data Tables -->
    <link href="__PUBLIC__/H4/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

    <link href="__PUBLIC__/H4/css/animate.min.css" rel="stylesheet">
    <link href="__PUBLIC__/H4/css/style.min.css?v=4.0.0" rel="stylesheet"><base target="_blank">

</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>会员管理 <small>管理员赠送记录</small></h5>
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
                      <div class="">
                          <a onclick="addgift();" href="javascript:void(0);" class="btn btn-primary ">发起赠送</a>
                      </div>
                      <form id="delsForm" method="post">
                      <table class="table table-striped table-bordered table-hover dataTables-example" id="dataTable">
                          <thead>
                              <tr>
                                  <th>编号</th>
                                  <th>赠送管理员</th>
                                  <th>接收会员名</th>
                                  <th>接收会员手机</th>
                                  <th>赠送类型</th>
                                  <th>赠送数量</th>
                                  <th>发起时间</th>
                                  <th>赠送说明</th>
                              </tr>
                          </thead>
                          <tbody>
                          
                              <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$P): $mod = ($i % 2 );++$i;?><tr class="gradeA">
                                  <td><?php echo ($P["id"]); ?></td> 
                                  <td><?php echo (getadminfo($P["usrid"],'name')); ?></td>
                                  <td><?php echo (getmebinfo($P["mid"],'mname')); ?></td>
                                  <td><?php echo (getmebinfo($P["mid"],'moblie')); ?></td>
                                  <td><?php if(($P["gift_tp"]) == "0"): ?>赠送余额<?php else: ?>现金<?php endif; ?></td>
                                  <td style="text-align:center;"><?php echo ($P["nums"]); ?></td>  
                                  <td><?php echo (date("Y-m-d H:i:s",$P["addtime"])); ?></td>
                                  <td><?php echo ($P["remark"]); ?></td> 
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?> 
                                                    
                          </tbody>
                          <tfoot>
                              <tr>
                                  <th>编号</th>
                                  <th>赠送管理员</th>
                                  <th>接收会员名</th>
                                  <th>接收会员手机</th>
                                  <th>赠送类型</th>
                                  <th>赠送数量</th>
                                  <th>发起时间</th>
                                  <th>赠送说明</th>
                              </tr>
                          </tfoot>
                      </table>
                      </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="__PUBLIC__/H4/js/jquery.min.js?v=2.1.4"></script>
    <script src="__PUBLIC__/H4/js/bootstrap.min.js?v=3.3.5"></script>
    <script src="__PUBLIC__/H4/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="__PUBLIC__/H4/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="__PUBLIC__/H4/js/plugins/layer/layer.js"></script>
    <script src="__PUBLIC__/H4/js/jquery.form.js"></script>
    <script>
    $(document).ready(function () {
        //表头的复选框控制表格中所有行的复选框状态
        $("#dataTable").on("click","#checkAll", function () {
            var result = $("#checkAll").prop('checked');
            if (result == true) {
                $("input[name='check[]']").prop("checked",true);
            } else {
                $("input[name='check[]']").prop("checked",false);
            }
        });
    });
    $('#dataTable').dataTable({
        "lengthMenu":[10,20,30,50],//显示数量选择 
        "iDisplayLength":10,
        "bFilter": true,//过滤功能
        "bPaginate": true,//翻页信息
        "bInfo": false,//数量信息
        "aaSorting": [[ 1, "desc" ]],//默认第几个排序
        "bStateSave": true,//状态保存
        "language": {
          "sLengthMenu": "每页显示 _MENU_ 条",
          "sZeroRecords": "没有检索到数据",
          "sInfo": "从 _START_ 到 _END_ /共 _TOTAL_ 条数据",
          "sSearch": "搜索：",
          "sInfoEmpty": "没有数据",
          "sInfoFiltered": "(从 _MAX_ 条数据中检索)",
          "oPaginate": {
            "sFirst": "首页",
            "sPrevious": "上一页",
            "sNext": "下一页",
            "sLast": "尾页"
          },
        },
        "aoColumnDefs": [
          {"orderable":false,"aTargets":[7]}// 制定列不参与排序
        ],
      });
    function addgift () {
      layer.open({
          type:2,
          title: ['发起赠送','background:#438EB9;color:#fff;'],
          content: "<?php echo U('addgift');?>",
          area:['740px', ($(window).height() - 50) +'px'],
          closeBtn:1,
          shade:[0.6, '#000'],
      });   
    }
    </script>
</body>

</html>