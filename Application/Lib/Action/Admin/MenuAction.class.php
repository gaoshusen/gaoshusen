<?php

/** 管理员后台菜单控制器
* 	作者：偷天换芪
*	联系QQ：314820983
*	E-mail:tthq08@163.com
*	网址：www.tthq8.com
*/
class MenuAction extends CommonAction
{

	public function lists()		//	加载后台菜单列表清单页面
	{
		$Menu	=	M('menu');
		$topMenus	=	$Menu ->where('pid=0') ->order('sort asc , id asc') ->select();		//  取出所有顶级目录
		$this->assign('topMenuList',$topMenus);
		$sunMenus	=	$Menu ->where('pid<>0') ->order('sort desc , id desc') ->select();	//   取出所有非顶级目录作为二级目录集合输出
		$ssunMenus	=	$Menu ->where('pid<>0') ->order('sort asc , id desc') ->select();	//	取出所有非顶级目录作为三级目录集合输出
		$this->assign('sunMenuList',$sunMenus);
		$this->assign('sunMenuLists',$sunMenus);
		$this->assign('ssunMenuLists',$ssunMenus);
		$this->display();
	}

	public function add()		// 加载新增菜单页面
	{
		$Menu	=	M('menu');
		$mid 	=	I('mid');
		// dump($mid);
		$dbModule	=	M('module');
		if ($mid=="") {
			$this->assign('isFull','1');
		}else{
			$this->assign('isFull','0');
			$this->assign('pid',$mid);

			$dbMenu	=	M('menu');
			$module_name =	$dbMenu ->where('id='.$mid) ->getField('module_name');		//	取得参数传递进来的菜单的模块名
			if ($module_name=='') {		//	如果模块名为空则取参数传递进来的菜单的父级菜单的模块名
				$module_name =	$dbMenu ->where('pid='.$mid) ->limit(1) ->getField('module_name');
			}
			$menuDetail['module_name']	=	$module_name;
			// dump($menuDetail);
			$this->assign('menuInfo',$menuDetail);
			
			$actionList	=	$dbModule ->field('functionname') ->where("modulename='".$module_name."' and functionname<>'theme' and groupname='".GROUP_NAME."'") ->select();
			// dump($actionList);
			$this->assign('actionList',$actionList);
		}
		$this->assign('windowTitle',"新增菜单");
		$this->assign('method','add');		//输出操作方式标识 
		$topMenus	=	$Menu ->where('pid=0') ->select();
		$this->assign('topMenuList',$topMenus);
		$sunMenus	=	$Menu ->where('pid<>0')	->select();
		$this->assign('sunMenuList',$sunMenus);
		$moduleList	=	$dbModule ->field('modulename,COUNT(id)') ->group('modulename') ->where("groupname='".GROUP_NAME."' and modulename<>'Common'") ->select();
		// dump($moduleList);
		$this->assign('moduleList',$moduleList);
		$this->display('excute');
	}

	public function edit()
	{
		$dbMenu	=	M('menu');
		$mid 	=	I('mid');
		$this->assign('isFull','0');
		$menuInfo	=	$dbMenu ->where('id='.$mid) ->find();
		$this->assign('pid',$menuInfo['pid']);
		$this->assign('menuInfo',$menuInfo);
		$this->assign('windowTitle',"编辑菜单");
		$this->assign('method','edit');		//输出操作方式标识 
		$topMenus	=	$dbMenu ->where('pid=0') ->select();
		$this->assign('topMenuList',$topMenus);
		$sunMenus	=	$dbMenu ->where('pid<>0')	->select();
		$this->assign('sunMenuList',$sunMenus);

		$dbModule	=	M('module');
		$moduleList	=	$dbModule ->field('modulename,COUNT(id)') ->group('modulename') ->where("groupname='".GROUP_NAME."' and modulename<>'Common'") ->select();
		$this->assign('moduleList',$moduleList);
		// echo $menuInfo['module_name'];
		$actionList	=	$dbModule ->field('functionname') ->where("modulename='".$menuInfo['module_name']."' and functionname<>'theme' and groupname='".GROUP_NAME."'") ->select();
		$this->assign('actionList',$actionList);
		// dump($actionList);
		$this->display('excute');
	}

	public function selectAction()
	{
		$module_name =	I('mname');
		$dbModule	=	M('module');
		$actionList	=	$dbModule ->field('functionname') ->where("modulename='".$module_name."' and functionname<>'theme' and groupname='".GROUP_NAME."'") ->select();
		if ($actionList) {
			$this->ajaxReturn($actionList,'获取'.$module_name.'模块下的方法成功。',1,'JSON');
		}else
		{
			$this->ajaxReturn('Data Error','获取'.$module_name.'模块下的方法失败。'	,0,'JSON');
		}
	}

	public function del()
	{
		$mid 	=	I('mid');
		$dbMenu	=	M('menu');
		$userName	= session('ttcms_usr');
		$menuInfo 	= $dbMenu ->where('id='.$mid) ->find();
		$parentID 	= $menuInfo['pid'];
		$End 		= $dbMenu ->where('id='.$mid) ->delete();
		if ($End) {
			$dbMenu ->where('id='.$parentID)->setDec('menus');		//给新增菜单的父菜单的menus的值加1
			addlog(MODULE_NAME,ACTION_NAME,"删除菜单【".$menuInfo['mnname']."】成功！");
			$this->ajaxReturn('',"删除菜单成功！",1);
		}else{
			addlog(MODULE_NAME,ACTION_NAME,"删除菜单失败！");
			$this->ajaxReturn('',"删除菜单失败！",0);
		}
	}

	public function sortsingle()
	{
		$dataSort	= I('rid');
		$dataMid	= I('mid');
		$dbMenu		=	M('menu');
		$end 		=	$dbMenu	->where('id='.$dataMid) ->setField('sort',$dataSort);
		$this->ajaxReturn(U('lists'),"排序成功",1);
	}

	public function execution()
	{
		$dataPost	= I('');
		//dump($dataPost);
		if ($dataPost['pid']==0) {		//如果是顶级菜单
			$dataPost['url']	= $dataPost['module_name']."/".$dataPost['action_name'];
			$dataPost['module_name'] = '';
			$dataPost['action_name'] = '';
		}
		else{
			if ($dataPost['action_name']=='0') {	//如果方法名留空（方法名留空默认为二级菜单）
				//$dataPost['url']	= $dataPost['module_name']."/".$dataPost['module_name'];
				$dataPost['action_name']	= $dataPost['module_name'];
			}
			else{
				$dataPost['url']	= $dataPost['module_name']."/".$dataPost['action_name'];
			}
		}
		
		
		$method		= $dataPost['method'];
		$dbMenu		= M('menu');
		$userName	= session('ttcms_usr');
		switch ($method) {
			case 'add':		//添加
				$End 	= $dbMenu ->add($dataPost);
				if ($End) {
					$dbMenu ->where('id='.$dataPost['pid'])->setInc('menus');		//给新增菜单的父菜单的menus的值加1
					addlog(MODULE_NAME,ACTION_NAME,"新增菜单【".$dataPost['mnname']."】成功！");
					$this->ajaxReturn('',"新增菜单成功！",1);
				}else{
					addlog(MODULE_NAME,ACTION_NAME,"新增菜单失败！");
					$this->ajaxReturn('',"新增菜单失败！",0);
				}
				break;

			case 'edit':	//编辑
				$oldMenu	= $dbMenu ->where('id='.$dataPost['id']) ->find();
				$End 	= $dbMenu ->where('id='.$dataPost['id']) ->save($dataPost);
				if ($End) {
					if ($oldMenu['pid']!=$dataPost['pid']) {	//如果编辑后的菜单父ID与原父ID不一致
						$dbMenu ->where('id='.$oldMenu['pid']) ->setDec('menus');	//原父菜单menus减1
						$dbMenu ->where('id='.$dataPost['pid']) ->setInc('menus');	//新的父菜单Menus加1
					}
					addlog(MODULE_NAME,ACTION_NAME,"编辑菜单【".$dataPost['mnname']."】成功！");
					$this->ajaxReturn('',"编辑菜单成功！",1);
				}else{
					addlog(MODULE_NAME,ACTION_NAME,"编辑菜单失败！");
					$this->ajaxReturn('',"编辑菜单失败！",0);
				}
				break;
		}
	}
}
?>