<?php
	/*
	*   后台框架控制器
	*   作者：偷天换芪
	*   联系QQ：314820983
	*   E-mail:tthq08@163.com
	*   网址：www.tthq8.com
	*/
	class IndexAction extends Action
	{
		
		public function index()
		{
			$this->display("login");
		}

		public function login()
		{
			if ($this->isPost()) {		//判断是否为POST提供数据，如果不是，则拒绝访问
				$dataPost	=	I('');
				$userName	=	$dataPost['username'];
				$passWord	=	$dataPost['password'];
				$passWord	=	md5(md5(md5($passWord)));	//密码加密
				$dbAdmin	=	M('user');
				$userInfo	=	$dbAdmin->where("username='".$userName."'")->find();
				$uid		=	$userInfo['id'];
				if ($passWord==$userInfo['password']) {		//比对当前密码和服务器密码
					if ($userInfo['status']==1) {
						session('ttcms_uid',$uid);
						session('ttcms_usr',$userName);
						session('ttcms_rid',$userInfo['rid']);
						$usrArr = array('thistime' 	=> time(),
										'lasttime'	=> $userInfo['thistime'],
										'thisip'	=> get_client_ip(1),
										'lastip'	=> $userInfo['thisip'],
										);
						$dbAdmin ->where('id='.$uid) ->setField($usrArr);
						$dbAdmin ->where('id='.$uid) ->setInc('logins');
						addlog(MODULE_NAME,ACTION_NAME,"登录成功");
						$this->ajaxReturn(U("Manage/index"),"登录成功",1);	//ajax返回结果信息
					}else{
						addlog(MODULE_NAME,ACTION_NAME,"因状态为禁用而登录失败");
						$this->ajaxReturn('',"登录失败，用户已被禁用！",0);	//ajax返回结果信息
					}					
				}
				else
				{	

					addlog(MODULE_NAME,ACTION_NAME,"用户名或密码错误，登录失败");
					$this->ajaxReturn('',"用户名或密码错误，登录失败",0);
				}				
			}
			else
			{
				$this->error('非法请求！！！');
			}	
		}
	}
?>