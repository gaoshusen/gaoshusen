<?php
/** 系统用户管理控制器
* 	作者：偷天换芪
*	联系QQ：314820983
*	E-mail:tthq08@163.com
*	网址：www.tthq8.com
*/
	class UsrAction extends CommonAction
	{
		public function lists()
		{
			$dbUsr	=	M('user');
			$userList	=	$dbUsr ->select();
			$this->assign('usrList',$userList);

			$dbRole	=	M('role');
			$roleList	=	$dbRole ->select();
			for ($i=0; $i < count($roleList); $i++) { 
				$arrayRole[$roleList[$i]['id']] = $roleList[$i]['name'];
			}
			$arrayRole[0]	=	'系统超级管理员';
			$this->assign('roleList',$arrayRole);
			$this->display();
		}

		public function add()
		{
			$dbRole	=	M('role');
			$this->assign('isFull','1');		//当页面为直接加载时 isFull设为1 ，在弹出层中加载时，isFull设为0
			$this->assign('method','add');
			$this->assign('windowTitle','新增用户');
			$roleList	=	$dbRole ->select();
			$this->assign('roleList',$roleList);
			$this->display('excute');
		}

		public function edit()
		{	
			$uid	=	I('uid');
			$dbUsr 	=	M('user');
			$this->assign('isFull','0');	//当页面为直接加载时 isFull设为1 ，在弹出层中加载时，isFull设为0
			$this->assign('method','edit');
			$this->assign('windowTitle','编辑用户');
			$usrInfo=	$dbUsr ->where('id='.$uid) ->find();
			//dump($usrInfo);
			$this->assign($usrInfo);
			$dbRole	=	M('role');
			$roleList	=	$dbRole ->select();
			$this->assign('roleList',$roleList); 
			$this->display('excute');
		}

		public function del()
		{
			$uid	=	I('uid');
			$dbUsr	=	M('user');
			$End 		= $dbUsr ->where('id='.$uid) ->delete();
			if ($End) {
				addlog(MODULE_NAME,ACTION_NAME,"删除用户【id:".$uid."】成功！");
				$this->ajaxReturn('',"删除用户成功！",1);
			}else{
				addlog(MODULE_NAME,ACTION_NAME,"删除用户失败！");
				$this->ajaxReturn('',"删除用户失败！",0);
			}
		}

		public function execution()
		{
			$dataPost	= I('');
			if ($dataPost['password']<>"") {
				$dataPost['password'] 	= md5(md5(md5($dataPost['password'])));
			}else{
				unset($dataPost['password']);
			}
			$dbUsr	=	M('user');
			switch ($dataPost['method']) {
				case 'edit':						
					$dataAc =	$dbUsr ->where('id='.$dataPost['id']) ->save($dataPost);
					$isHave = false;
					break;
				
				case 'add':
					$isHave	=	$dbUsr ->where("username='".$dataPost['username']."'")->count();
					if (!$isHave) {						
						$dataAc = 	$dbUsr ->add($dataPost);			
					}						
					break;
			}
			if ($isHave) {
				$this->ajaxReturn('','管理员已经存在，不可重复添加！',0,'json');
			}else{
				if ($dataAc) {
					addlog(MODULE_NAME,ACTION_NAME,'用户[id:'.$dataPost['username'].']执行操作['.$dataPost['method'].']成功');
					$this->ajaxReturn('','提交成功！',1,'json');
				}else
				{
					addlog(MODULE_NAME,ACTION_NAME,'用户[id:'.$dataPost['username'].']执行操作['.$dataPost['method'].']失败');
					$this->ajaxReturn('','提交失败！',0,'json');
				}
			}						
		}

		public function uploadpic()		//单图上传
		{
		    if (!empty($_FILES)) {
		        import('ORG.Net.UploadFile');
				$upload		= 	new UploadFile();// 实例化上传类
		        $upload->maxSize = 2048000;
		        $upload->allowExts = array('jpg','jpeg','gif','png');
		        $upload->savePath = './Upload/image/';// 设置附件上传目录
		        $upload->saveRule = "time" ;  //设置上传文件的保存规则为时间
				$upload->autoSub  =	true;	//是否使用子目录保存上传文件
				$upload->subType  = 'date'; //设置子目录创建方式为date
				$upload->dateFormat = "Ymd"; //指定子目录名的日期格式
		        //$upload->thumbRemoveOrigin = true; //删除原图
		        if(!$upload->upload()){
		            $this->error($upload->getErrorMsg());//获取失败信息
		        } else {
		            $info = $upload->getUploadFileInfo();//获取成功信息
		        }
		        echo '_' . $info[0]['savename'];    //返回文件名给JS作回调用
		    }
		}

		//---------------------------------------------------------------------------------

		public function roles()
		{
			$dbRole	=	M('role');
			$roleData	=	$dbRole ->select();
    		$this->assign("rolelist",$roleData);
    		
    		$dbUsr	=	M('user');
    		$usrInfo	=	$dbUsr ->select();
    		for ($i=0; $i < count($usrInfo); $i++) { 
    			$usrlst[$usrInfo[$i]['rid']] .= $usrInfo[$i]['username'].",";
    		}
    		$this->assign('usrlist',$usrlst);
			$this->display();
		}

		public function addrole()
		{
			$this->assign('method','add');
			$this->display('roleaction');
		}

		public function edtrole()
		{
			$rid	=	I('rid');
			$dbRole	=	M('role');
			$roleInfo	=	$dbRole ->where('id='.$rid) ->find();
			$this->assign($roleInfo);
			$this->assign('method','edit');
			$this->display('roleaction');
		}

		public function delrole()
		{
			$rid	=	I('rid');
			$dbRole	=	M('role');
			$dataDel	=	$dbRole ->where('id='.$rid) ->delete();

    		if ($dataDel) {
    			addlog(MODULE_NAME,ACTION_NAME,'删除角色[id:'.$rid.']执行操作['.$dataPost['method'].']成功');
    			//wrtlog(session('TT_usr'),'删除角色[id:'.$dataRid.']成功',MODULE_NAME,ACTION_NAME);
    			$this->ajaxReturn(U('roles'),'角色删除成功',1,'json');
    		}else{
    			addlog(MODULE_NAME,ACTION_NAME,'删除角色[id:'.$rid.']执行操作['.$dataPost['method'].']失败');
    			$this->ajaxReturn('','角色删除失败',0,'json');
    		}
		}

		public function roleaction()
		{
			$dataPost	= I('');
			$dbRole		=	M('role');
			switch ($dataPost['method']) {
				case 'edit':					
					$dataAc =	$dbRole ->save($dataPost);
					break;
				
				case 'add':
					$dataAc =	$dbRole ->add($dataPost);
					break;
			}
			if ($dataAc) {
    			addlog(MODULE_NAME,ACTION_NAME,'角色['.$dataPost['name'].']执行操作['.$dataPost['method'].']成功');
				$this->ajaxReturn(U('roles'),'操作执行成功！',1,'json');
			}else
			{
    			addlog(MODULE_NAME,ACTION_NAME,'角色['.$dataPost['name'].']执行操作['.$dataPost['method'].']失败');
				$this->ajaxReturn('','操作执行失败，请重试！',0,'json');
			}
		}

		public function authorset()			//角色权限分配
		{
			$rid 	= I('rid');
			$this->assign('rid',$rid);
			$dbMenu	=	M('menu');
			$FaMenu	=	$dbMenu	->field(array('id','mnname','pid')) ->where('pid=0') ->order('sort asc,id asc') ->select();
			foreach ($FaMenu as $Top) {
				if (!is_null($Top)) {
					$menus[]	=	$Top;
					$subMenu	=	$dbMenu	->field(array('id','mnname','pid')) ->where('pid='.$Top['id']) ->order('sort asc,id asc') ->select();
					foreach ($subMenu as $sub) {
						if(!is_null($sub)){
							$menus[]	=	$sub;
							$sonMenu	=	$dbMenu	->field(array('id','mnname','pid')) ->where('pid='.$sub['id']) ->order('sort asc,id asc') ->select();
							foreach ($sonMenu as $son) {
								if (!is_null($son)) {
									$menus[]	=	$son;
								}
							}
						}
					}
				}
			}

			$FaMenu	=	$menus;
			$dbAuth	=	M('auth');
			$authorMenu	=	$dbAuth ->field('mid') ->where('rid='.$rid) ->select();
    		$authorRow = array();
    		for ($j=0; $j < count($authorMenu); $j++) { 
    			array_push($authorRow,$authorMenu[$j]['mid']);
    			$midd .= $authorMenu[$j]['mid'].",";
    		}

    		$jsonArrqy = array();
    		for ($i=0; $i < count($FaMenu); $i++) { 
    			$pId 	= $FaMenu[$i]['pid'];
    			// $isHave	=	$this -> getTopID($pId);
    			// $isHave	=	$dbMenu ->where('id='.$isHave) ->find();

    			// if (!is_null($isHave)) {
	    			$mid 	= $FaMenu[$i]['id'];
	    			$mname 	= htmlspecialchars_decode($FaMenu[$i]['mnname']);
	    			$jsonrow['id'] = $mid;
	    			$jsonrow['pId'] = $pId;
	    			$jsonrow['name'] = $mname;

	    			if ($i == 0) {
	    				$jsonrow['open']= true;
	    			}else{
	    				$jsonrow['open']= false;
	    			}

	    			if (in_array($mid, $authorRow)) {
	    				$jsonrow['checked']= true;
	    			}else{
	    				$jsonrow['checked']= false;
	    			}

	    			array_push($jsonArrqy, $jsonrow);
    			// }
    		}
    		// dump($jsonArrqy);
    		$FaJson		= json_encode($jsonArrqy);    		
    		$this->assign('midd',$midd);
    		$this->assign('dataNodes',$FaJson);
			$this->display();
		}

		public function getAllChild($cid='')
		{
			$dbMenu	=	M('menu');
			$subMenu	=	$dbMenu ->field(array('id','mnname','pid')) ->where('pid='.$cid) ->select();
			// dump($subMenu);
			if ($subMenu) {
				foreach ($subMenu as $key => $sub) {
					$subs[]	=	$this->getAllChild($sub['id']);
					dump($subs);
					array_push($subMenu, $subs);
				}
				return $subMenu;
			}
		}

		public function authorupdate()	//权限变更执行
		{
			$dataPost	= I('');
			$dbAuth	=	M('auth');
			$dbAuth ->where('rid='.$dataPost['rid']) ->delete(); //清除用户原有权限

    		$midArray	= explode(',', $dataPost['menuData']);	//解析新的权限文本
    		$authorNum	= count($midArray);
    		for ($i=0; $i < $authorNum; $i++) { 
    			$data = array('mid' => $midArray[$i], 'rid'=>$dataPost['rid']);
    			$dataAc =	$dbAuth ->add($data);
				if ($dataAc) {
					$j += 1;
				}
    		}
    		if ($j<$authorNum) {
    			addlog(MODULE_NAME,ACTION_NAME,'角色[id:'.$dataPost['rid'].']权限分配失败');
    			$this->ajaxReturn('','权限分配失败，请重新提交！',0,'json');
    		}else{
    			addlog(MODULE_NAME,ACTION_NAME,'角色[id:'.$dataPost['rid'].']权限分配成功');
    			$this->ajaxReturn(U('roles'),'权限分配成功！',1,'json');
    		}
		}
	}
?>