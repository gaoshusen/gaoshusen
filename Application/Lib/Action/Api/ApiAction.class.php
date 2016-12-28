<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:text/html;charset=utf8");
	/**
	* 
	*/

class ApiAction extends Action
	{
		public function wxAuthor()		//微信验证接口
		{
			$echoStr = $_GET["echostr"];

	        if (!empty($_GET["echostr"])) {		//如果接收到echostr 内容则为首次微信接入验证
		        if($this->checkSignature()){
		        	echo $echoStr;
		        	exit;
		        }	        	
	        }else{
	        	dump($site_con);
	        }
		}

		public function UpVersion()
		{
			$version = I('version');
			$v = M('version')->order('`id` desc')->find();
			if($version < $v){
				$this->ajaxReturn(array('status'=>true,'info'=>"有新版本啦"));
			}
			
		}

		// public function signin()		//签到 
		// {
		// 	$mid	=	I('mid');
		// 	$membInfo	=	M('member') ->where('ID='.$mid) ->find();
		// 	$nowdays = 	$membInfo['nowdaynum'];
		// 	if (date('Y-m-d') == date('Y-m-d',$membInfo['signtime'])) {
		// 	    $this->ajaxReturn(array('status'=>false,'info'=>"今日已签到"));
		// 		die;
		// 	}
		// 	$billData = array('fromID' => 0,'toID'=>$mid,'type'=>4,'billtp'=>"mny",'billnum'=>0.2,'ordid'=>'0','billtime'=>time(),'smark'=>"签到获得0.2元");
		// 	$billRst	=	M('bill') ->add($billData);	//插入账单记录表
		// 	if($billRst){
		// 		$this->ajaxReturn(array('status'=>2,'info'=>"签到成功,获得0.2元"));
		// 	}else{
		// 		$this->ajaxReturn(array('status'=>false,'info'=>"签到失败，请重试"));
		// 	}
		
		
		// }

		private function checkSignature()
		{
	        
	        $signature = $_GET["signature"];
	        $timestamp = $_GET["timestamp"];
	        $nonce = $_GET["nonce"];
	        $site_con	= getSiteConfig();	
			$token = $site_con['WXtoken'];
			$tmpArr = array($token, $timestamp, $nonce);
	        // use SORT_STRING rule
			sort($tmpArr, SORT_STRING);
			$tmpStr = implode( $tmpArr );
			$tmpStr = sha1( $tmpStr );
			
			if( $tmpStr == $signature ){
				return true;
			}else{
				return false;
			}
		}

		public function regByUsr()
		{	
			$uid	=	I('sign');
			$UA 	=	$_SERVER['HTTP_USER_AGENT'];
			
			$regUrl =	'http://'.$_SERVER["SERVER_NAME"].'/index.php/Api/Api/regAuto?sign='.$uid;

			if (strpos($UA, 'MicroMessenger')!==false) {	//微信扫码
				$regUrl	=	urlencode($regUrl.'&pt=wx');
				$site_con	= getSiteConfig();
				$wxURL	=	'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$site_con['WXappid'].'&redirect_uri='.$regUrl.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
				header("Location:".$wxURL);
			}else{
				echo '请使用微信扫一扫进行扫描！';
			}
		}

		public function regAuto()
		{
			$dataGet=	I('');
			$site_con	= getSiteConfig();	//取系统配置信息
			$userData['mid']	=	time();
			$userData['mpwd']	=	md5($site_con['dftPWD']);	//取出默认密码设为注册用户的密码
			$this->assign('defautPwd',$site_con['dftPWD']);
			$dbMember	=	M('member');
			switch ($dataGet['pt']) {
				case 'wx':		//微信
					$code	=	$dataGet['code'];
					$url 	=	'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$site_con['WXappid'].'&secret='.$site_con['WXappsecret'].'&code='.$code.'&grant_type=authorization_code';
					$wxBack	=	request_ssl_curl($url);
					$wxBack	=	json_decode($wxBack,true);
					$infoUrl	=	'https://api.weixin.qq.com/sns/userinfo?access_token='.$wxBack['access_token'].'&openid='.$wxBack['openid'].'&lang=zh_CN';
					$wxInfo	=	request_ssl_curl($infoUrl);
					$wxInfo	=	json_decode($wxInfo,true);

					$userData['mname']	=	$wxInfo['nickname'];
					$userData['wxid']	=	$wxInfo['openid'];
					$userData['headimgurl']	=	$wxInfo['headimgurl'];

					$isFind	=	$dbMember ->where("wxid='".$wxInfo['openid']."'") ->find();
					if ($isFind) {		//用户已经注册过了
						$this->assign('info','您的微信已经注册过了');
						$this->assign('mid',$isFind['mid']);						
					}

					break;
				
				default:
					echo '请使用微信扫一扫进行扫描！';
					break;
			}

			$uid	=	I('sign');
			$dbMember	=	M('member');

			$top 	=	$dbMember ->where('mid='.$uid) ->find();
			if ($top['childnum']<3) {		//如果当前用户的直接下级数小于3，则直接注册到当前用户下
				$userData['parentids']	=	$top['parentids']=='0'?$uid:$top['parentids'].','.$uid;
				$psign =	$uid;
				$pid = $top['ID'];
			}else{
				$father	=	$dbMember ->where('find_in_set('.$uid.',parentids) AND childnum<3') ->find();
				// dump($father);
				$psign =	$father['mid'];
				$pid 	=	$father['ID'];
				$userData['parentids']	=	$father['parentids'].','.$psign;
			}
			$userData['pid']	=	$pid;
			$userData['addtime']	=	time();
			$QRcode	=	createQR(C('webRoot')."/index.php/Api/Api/regByUsr?sign=".$userData['addtime'],$userData['addtime']);
			$userData['qrsrc']	=	C('webRoot').ltrim($QRcode,'.');
			// $userData['qrsrc']	=	'http://qr.topscan.com/api.php?w=200&text=http://'.$_SERVER["SERVER_NAME"].'/index.php/Api/Api/regByUsr?sign='.$userData['addtime'];

			if (!$isFind) {
				$res =	M('member') ->add($userData);
				if ($res) {
					$add 	=	$dbMember ->where('mid='.$psign) ->setInc('childnum',1);
					$ajxReturn	=	array('status'=>1,'info'=>'恭喜，会员注册成功！');

				}else{
					$ajxReturn	=	array('status'=>0,'info'=>'抱歉,会员注册失败！');
				}

				$this->assign('info',$ajxReturn['info']);
				$this->assign('mid',$userData['mid']);
			}
			$this->display('regok');
			// addlog(MODULE_NAME,ACTION_NAME,$ajxReturn['info']);
			// $this->ajaxReturn($ajaxReturn);
		}

		// 获取微信的access_token
		public function getWxAccToken()
		{	
			$sesToken	=	session('wx_access_token');
			if (!is_null($sesToken)) {		//如果session中存在access_token则取session中的值 ，如果不存在则重新从微信获取
				return $sesToken;
			}else{
				$site_con	= getSiteConfig();
				$url	=	'grant_type=client_credential&appid='.$site_con['WXappid'].'&secret='.$site_con['WXappsecret'];
				$wxBack	=	request_ssl_curl('https://api.weixin.qq.com/cgi-bin/token?'.$url);
				$wxBack =	json_decode($wxBack,true);
				// 设置wx_access_token 的内容为当前微信的access_token并设置有效时间为获取到的有效期
				session(array('name'=>'wx_access_token','expire'=>$wxBack['expires_in']));
				session('wx_access_token',$wxBack['access_token']);
				return session('wx_access_token');
			}
		}

		public function uploadpic()		//单图上传
		{
			// echo json_encode('1111');die;
		  //   if (!empty($_FILES)) {
		  //       import('ORG.Net.UploadFile');
				// $upload		= 	new UploadFile();// 实例化上传类
		  //       $upload->maxSize = 2048000;
		  //       $upload->allowExts = array('jpg','jpeg','gif','png');
		  //       $upload->savePath = './Upload/image/';// 设置附件上传目录
		  //       $upload->saveRule = "time" ;  //设置上传文件的保存规则为时间
				// $upload->autoSub  =	true;	//是否使用子目录保存上传文件
				// $upload->subType  = 'date'; //设置子目录创建方式为date
				// $upload->dateFormat = "Ymd"; //指定子目录名的日期格式
		  //       //$upload->thumbRemoveOrigin = true; //删除原图
		  //       if(!$upload->upload()){
		  //           $this->error($upload->getErrorMsg());//获取失败信息
		  //       } else {
		  //           $info = $upload->getUploadFileInfo();//获取成功信息
		  //       }
		  //       echo '_' . $info[0]['savename'];    //返回文件名给JS作回调用
		  //   }else{
		  //   	echo json_encode('nimei');die;
		  //   }
			$dir = './Upload/image/'.date('Ymd');
			$i=1;
			if(!is_dir($dir)){
				mkdir($dir,0777);
			}
			if(!empty($_FILES)){
				echo json_encode('1111');die;
			}else{
				echo json_encode('nimei');die;
			}
		}



		public function upsss(){

			$uploadfile = $this->lj(); 

			$picname = $_FILES['mypic']['name'];
			$picsize = $_FILES['mypic']['size'];
			// $arr = array(
			// 	'name'=>$picname,
			// 	'pic'=>'123',
			// 	'size'=>$picsize,
			// 	'path'=>'321     '
			// );

			if ($picname != "") {
				if ($picsize > 1048576) {
					// echo '图片大小不能超过1M';
					// exit;
					$re = array('status' => false, 'data' => $picsize, 'info' => '图片大小不能超过1M');
					echo json_encode($re);
					die;
				}
				$type = strstr($picname, '.');
				if ($type != ".jpg") {					
					$re = array('status' => false, 'data' => $picsize, 'info' => '请上传jpg图片');
					echo json_encode($re);
					die;
				}
				$rand = rand(100, 999);
				$pics = date("YmdHis") . $rand . $type;
				//上传路径
				$pic_path = $uploadfile. $pics;
				move_uploaded_file($_FILES['mypic']['tmp_name'], $pic_path);
			}
			$path = ltrim($pic_path,'./');
			$size = round($picsize/1024,2);
			$arr = array(
				'name'=>$picname,
				'pic'=>$pics,
				'size'=>$size,
				'path'=>$path
			);
			$re = array('status' => true, 'data' => $arr, 'info' => '');
			echo json_encode($re);
		}

		public function lj(){
			$dir = './Upload/image/'.date('Ymd').'/';
			
			if(!is_dir($dir)){
				mkdir($dir,0777);
			}
			return $dir;
		}
	}
?>