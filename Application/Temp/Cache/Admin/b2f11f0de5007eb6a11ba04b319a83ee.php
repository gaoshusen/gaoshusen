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
                        <h5>新闻管理 <small>新闻列表</small></h5>
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
                      <form id="delsForm" method="post">
                      <table class="table table-striped table-bordered table-hover dataTables-example" id="dataTable">
                          <thead>
                              <tr>
                                  <th width="50">编号</th>
                                  <th>标题</th>
                                  <th width="90">发布人</th>
                                  <th width="160">发布时间</th>
                                  <th width="120">操作</th>
                              </tr>
                          </thead>
                          <tbody>
                          
                              <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$P): $mod = ($i % 2 );++$i; $giver = getAdmInfo($P['uid']); ?>
                                <tr class="gradeA">
                                  <td><?php echo ($P["id"]); ?></td>       
                                  <td><?php echo ($P["title"]); ?></td>
                                  <td><?php echo ($giver["name"]); ?></td>
                                  <td><?php echo (date("Y-m-d H:i:s",$P["addtime"])); ?></td>  
                                  <td><a href="javascript:;" onclick="edtNews(<?php echo ($P["id"]); ?>);">[编辑]</a><a href="javascript:;" onclick="delNews(<?php echo ($P["id"]); ?>);">[删除]</a></td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?> 
                                                    
                          </tbody>
                          <tfoot>
                              <tr>
                                  <th width="50">编号</th>
                                  <th>标题</th>
                                  <th width="90">发布人</th>
                                  <th width="160">发布时间</th>
                                  <th width="120">操作</th>
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
    <script src="__PUBLIC__/H4/js/plugins/jeditable/jquery.jeditable.js"></script>
    <script src="__PUBLIC__/H4/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="__PUBLIC__/H4/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="__PUBLIC__/H4/js/content.min.js?v=1.0.0"></script>
    <script src="__PUBLIC__/H4/js/plugins/layer/layer.js"></script>
    <script src="__PUBLIC__/H4/js/plugins/layer/extend/layer.ext.js"></script>
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
          {"orderable":false,"aTargets":[4]}// 制定列不参与排序
        ],
      });

    function edtNews (nid) {
      layer.open({
          type:2,
          title: ['编辑新闻','background:#438EB9;color:#fff;'],
          content: "<?php echo U('edit');?>?nid="+nid,
          area:['740px', ($(window).height() - 50) +'px'],
          closeBtn:1,
          shade:[0.6, '#000'],
      });   
    }

    function delNews (nid) {
      layer.confirm('是否删除当前新闻?', {icon: 3, title:'删除确认'}, function(index){
          $(this).ajaxSubmit({
            type:"get",
            url:"<?php echo U('del');?>",
            data:{
                'nid':nid
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