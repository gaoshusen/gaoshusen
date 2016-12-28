<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <title>JUNGO会员管理系统后台 - 角色管理</title>
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
                        <h5>角色管理 <small>角色列表</small></h5>
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
                            <a onclick="roleAdd();" href="javascript:void(0);" class="btn btn-primary "><i class="fa fa-plus"></i> &nbsp;新增角色</a>
                        </div>
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="dataTable">
                            <thead>
                                <tr>
                                    <th width="40">ID</th>
                                    <th width="200">角色名</th>
                                    <th>用户列表</th>
                                    <th width="300">描述</th>
                                    <th width="90">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(is_array($rolelist)): $i = 0; $__LIST__ = $rolelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$R): $mod = ($i % 2 );++$i;?><tr class="gradeA">
                                    <td><?php echo ($R["id"]); ?></td>       
                                    <td><?php echo ($R["name"]); ?></td>
                                    <td><?php echo ($usrlist[$R['id']]); ?></td>  
                                    <td><?php echo ($R["des"]); ?></td>
                                    <td> <a title="配置权限" href="javascript:;" onClick="roleAuthor(<?php echo ($R["id"]); ?>,'<?php echo ($R["name"]); ?>')" class="btn btn-white btn-bitbucket btn-xs"><i class="fa fa-wrench"></i></a> <a title="编辑角色" href="javascript:;" onClick="roleEdt(<?php echo ($R["id"]); ?>)" class="btn btn-white btn-bitbucket btn-xs"><i class="fa fa-edit"></i></a> <a title="删除角色" href="javascript:;" onClick="roleDel(<?php echo ($R["id"]); ?>)" class="btn btn-white btn-bitbucket btn-xs"><i class="fa fa-trash"></i></a></td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th width="40">ID</th>
                                    <th width="200">角色名</th>
                                    <th>用户列表</th>
                                    <th width="300">描述</th>
                                    <th width="90">操作</th>
                                </tr>
                            </tfoot>
                        </table>

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
    <script src="__PUBLIC__/H4/js/jquery.form.js"></script>
    <script>
        $('#dataTable').dataTable({
            "lengthMenu":[10,20,30],//显示数量选择 
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
              {"orderable":false,"aTargets":[2,3,4]}// 制定列不参与排序
            ],
          });

        function roleAdd () {
            layer.open({
                type:2,
                title: ['新增角色','background:#438EB9;color:#fff;'],
                content: "<?php echo U('Usr/addrole');?>",
                area:['740px', ($(window).height() - 100) +'px'],
                closeBtn:1,
                shade:[0.6, '#000'],
            });   
          }

          function roleEdt (rid) {
            layer.open({
                type:2,
                title: ['编辑角色','background:#438EB9;color:#fff;'],
                content: "<?php echo U('Usr/edtrole');?>?rid="+rid,
                area:['740px', ($(window).height() - 100) +'px'],
                closeBtn:1,
                shade:[0.6, '#000'],
            });
          };

          function roleDel (rid) {
            layer.confirm('是否删除当前角色?', {icon: 3, title:'删除确认'}, function(index){
            $(this).ajaxSubmit({
              type:"get",
              url:"<?php echo U('delrole');?>",
              data:{
                  'rid':rid
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
        };

          function roleAuthor (rid,name_role) {
            layer.open({
                type:2,
                title: ['角色权限分配['+name_role+']','background:#438EB9;color:#fff;'],
                content: "<?php echo U('Usr/authorset');?>?rid="+rid,
                area:['500px', ($(window).height() - 100) +'px'],
                closeBtn:1,
                shade:[0.6, '#000'],
            });
          }
    </script>
</body>

</html>