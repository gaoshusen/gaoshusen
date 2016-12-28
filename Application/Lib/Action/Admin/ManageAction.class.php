<?php

/** 管理员后台首页控制器
* 	作者：偷天换芪
*	联系QQ：314820983
*	E-mail:tthq08@163.com
*	网址：www.tthq8.com
*/
class ManageAction extends CommonAction
{
	public function index()
	{
		$dbMenu	=	M('menu');
		$topMenu	=	$dbMenu	->where('pid=0 and is_show=1') ->order('sort asc') ->select();
		$this->assign('topMenuList',$topMenu);
		$mid	=	I('mid');
		if ($mid=="") {
			$mid=$topMenu[0]['id'];
		}
		$menuList 	=	$dbMenu	->where('pid='.$mid.' and is_show=1') ->order('sort asc') ->select();
		$this->assign('menuList',$menuList);
		for ($i=0; $i < count($menuList); $i++) { 
			$pid	= $menuList[$i]['id'];
			$subMenuList =	$dbMenu ->where('pid='.$pid.' and is_show=1') ->order('sort asc') ->select();
			$subMenusList[$pid] = $subMenuList;
		}
		$this->assign('subMenuList',$subMenusList);

		$uid	= 	session('ttcms_uid');
		$dbUser	=	M('user');
		$usrInfo	=	$dbUser ->where('id='.$uid) ->find();
		$this->assign($usrInfo);

		$this->display();
	}

	public function main()
	{
		$uid	= 	session('ttcms_uid');
		$dbUser	=	M('user');
		$usrInfo	=	$dbUser ->where('id='.$uid) ->find();
		$this->assign($usrInfo);
		$this->assign("DomainNow",$_SERVER['SERVER_NAME']);
		$this->display();
	}
	public function logout() //退出登录
	{
		addlog(MODULE_NAME,ACTION_NAME,"退出登录");
		session(NULL); 
		$this->redirect('Index/index');

	}

	//生成模块结构信息 app/分组/模块/方法
    public function fetch_module(){
        $M = M('Module');
        $M->query("truncate table ".C('DB_PREFIX')."module");  //初始化module表
        $app = $this->getAppName();		//获取项目的APP名
        $groups = $this->getGroup();	//获取项目的分组
        $n=0;
        foreach ($groups as $group) {	//循环获取分组下的模块，方法
            $modules = $this->getModule($group);	//获取当前分组的模块
            foreach ($modules as $module) {	//循环获取各模块下的方法
                $module_name=$app.'://'.$group.'/'.$module;
                $functions = $this->getFunction($module_name);
                foreach ($functions as $function) {
                    $data[$n]['appname'] = $app;
                    $data[$n]['groupname'] = $group;
                    $data[$n]['modulename'] = $module;
                    $data[$n]['functionname'] = $function;
                    ++$n;                                }
            }
        }
        $M->addAll($data);
        //$this->success('所有分组/模块/方法已成功读取到module表中.');
        $this->ajaxReturn('OK','系统节点更新成功',1,'JSON');
    }
    private function getAppName(){
        return APP_NAME;
    }
    private function getGroup(){
        $result = explode(',',C('APP_GROUP_LIST'));
        return $result;
    }
    private function getModule($group){
        if(empty($group))return null;
        $group_path=LIB_PATH.'Action/'.$group;
        if(!is_dir($group_path))return null;
        $group_path.='/*.class.php';
        $ary_files = glob($group_path);
        foreach ($ary_files as $file) {
            if (is_dir($file)) {
                continue;
            }else {
                    $files[] = basename($file,'Action.class.php');
            }
        }
        return $files;
    }
    private function getFunction($module){
        if(empty($module))return null;
        $action=A($module);
        $functions=get_class_methods($action);
        $inherents_functions = array(
            '_initialize','__construct','getActionName','isAjax','display','show','fetch',
            'buildHtml','assign','__set','get','__get','__isset',
            '__call','error','success','ajaxReturn','redirect','__destruct'
        );
        foreach ($functions as $func){
            if(!in_array($func, $inherents_functions)){
                $customer_functions[]=$func;
            }
        }
        return $customer_functions;
    }

}
?>