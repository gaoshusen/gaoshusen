<?php 
	/** 前台栏目管理控制器
	* 	作者：偷天换芪
	*	联系QQ：314820983
	*	E-mail:tthq08@163.com
	*	网址：www.tthq8.com
	*/
	class ChannelAction extends CommonAction
	{
		// 显示前台栏目列表清单页面
		public function lists()
		{
			$dbChannel	=	M('channel');
			// $topChannel	=	$dbChannel ->where('pid=0') ->order('sort asc') ->select();
			// foreach ($topChannel as $top) {
			// 	$subChannel =	$this ->getSubChannel($top['id']);
			// 	if ($subChannel) {
			// 	$top['sublist']	=	$subChannel;
			// 	}
			// 	$channels[]	=	$top;
			// }
			$channels	=	getChannel('back');
			// dump($channels);
			$this->assign('channels',$channels);
			$this->display();
		}

		//单条记录更新排序
		public function sortsingle()		
		{
			$dataSort	= I('rid');
			$dataMid	= I('mid');
			$dbChannel		=	M('channel');
			$end 		=	$dbChannel	->where('id='.$dataMid) ->setField('sort',$dataSort);
			$this->ajaxReturn(U('lists'),"排序成功",1);
		}

		//递归取出指定ID的子目录树结构
		public function getSubChannel($cid)
		{
			$dbChannel	=	M('channel');
			$channels	=	$dbChannel ->where('pid='.$cid) ->order('sort desc') ->select();
			if ($channels) {
				foreach ($channels as $chs) {
					$subChannel =	$this -> getSubChannel($chs['id']);
					if ($subChannel) {
						$chs['sublist'] = $subChannel;
					}

				}
				return $channels;
			}else{
				return false;
			}			
		}

		// 加载新增栏目项页面
		public function add()
		{
			$dbChannel	=	M('channel');
			$dbModel	=	M('model');
			$mid 	=	I('mid');

			if ($mid=="") {
				$this->assign('isFull','1');
			}else{
				$this->assign('isFull','0');
				$this->assign('pid',$mid);
			}
			// 获取所有的栏目结构树并输出到模板中
			$topChannel	=	$dbChannel ->where('pid=0') ->order('sort asc') ->select();
			foreach ($topChannel as $top) {
				$subChannel =	$this ->getSubChannel($top['id']);
				if ($subChannel) {
				$top['sublist']	=	$subChannel;
				}
				$channels[]	=	$top;
			}
			$this->assign('channel',$channels);

			$modelList 	=	$dbModel ->select();
			$this->assign('modelList',$modelList);

			$this->assign('windowTitle',"新增栏目");
			$this->assign('method','add');		//输出操作方式标识 
			
			$this->display('excute');
		}

		// 加载编辑栏目项页面
		public function edit()
		{
			$dbChannel	=	M('channel');
			$dbModel	=	M('model');
			$mid 	=	I('mid');

			if ($mid=="") {
				$this->ajaxReturn('author error','参数错误，请重试',0,'JSON');
			}

			$channelInfo =	$dbChannel ->where('id='.$mid) ->find();
			$this->assign('pid',$channelInfo['pid']);
			$this->assign('channelInfo',$channelInfo);
			// 获取所有的栏目结构树并输出到模板中
			$topChannel	=	$dbChannel ->where('pid=0') ->order('sort asc') ->select();
			foreach ($topChannel as $top) {
				$subChannel =	$this ->getSubChannel($top['id']);
				if ($subChannel) {
				$top['sublist']	=	$subChannel;
				}
				$channels[]	=	$top;
			}
			$this->assign('channel',$channels);


			// 取出所有的模型
			$modelList 	=	$dbModel ->select();
			$this->assign('modelList',$modelList);

			$this->assign('isFull','0');
			$this->assign('windowTitle',"编辑栏目");
			$this->assign('method','edit');		//输出操作方式标识 

			$this->display('excute');
		}

		public function execution()
		{
			$dataPost	= I('');
			$method		= $dataPost['method'];
			$dbChannel		= M('channel');
			$userName	= session('ttcms_usr');
			switch ($method) {
				case 'add':		//添加
					$End 	= $dbChannel ->add($dataPost);
					if ($End) {
						addlog(MODULE_NAME,ACTION_NAME,"新增栏目【".$dataPost['name']."】成功！");
						$this->ajaxReturn('',"新增栏目成功！",1);
					}else{
						addlog(MODULE_NAME,ACTION_NAME,"新增栏目失败！");
						$this->ajaxReturn('',"新增栏目失败！",0);
					}
					break;

				case 'edit':	//编辑
					$End 	= $dbChannel ->where('id='.$dataPost['id']) ->save($dataPost);
					if ($End) {
						addlog(MODULE_NAME,ACTION_NAME,"编辑栏目【".$dataPost['name']."】成功！");
						$this->ajaxReturn('',"编辑栏目成功！",1);
					}else{
						addlog(MODULE_NAME,ACTION_NAME,"编辑栏目失败！");
						$this->ajaxReturn('',"编辑栏目失败！",0);
					}
					break;
			}
		}

		public function del()
		{
			$mid 	=	I('mid');
			$dbChannel	=	M('channel');
			$userName	= session('ttcms_usr');
			$channelInfo 	= $dbChannel ->where('id='.$mid) ->find();
			$parentID 	= $channelInfo['pid'];
			$End 		= $dbChannel ->where('id='.$mid) ->delete();
			if ($End) {
				$dbChannel ->where('id='.$parentID)->setDec('channel');		//给新增菜单的父菜单的menus的值加1
				addlog(MODULE_NAME,ACTION_NAME,"删除栏目【".$channelInfo['name']."】成功！");
				$this->ajaxReturn('',"删除栏目成功！",1);
			}else{
				addlog(MODULE_NAME,ACTION_NAME,"删除栏目失败！");
				$this->ajaxReturn('',"删除栏目失败！",0);
			}
		}
	}
 ?>