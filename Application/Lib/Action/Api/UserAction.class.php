<?php
/**
* 
*/
header("Access-Control-Allow-Origin:*");
class UserAction extends Action
{
	function checkuser($mid){
		// $mid =	I('mid');
		$top =	M('member') ->where('ID='.$mid) ->find();
		if($top['ID']>0){
			return true;
		}else{
			return false;
		}
	}
	function checktype(){  //检测会员状态
		$mid =	I('mid');
		$type =	M('member') ->where('ID='.$mid) ->getField('type');
		if($type==1){
			return $this->ajaxReturn(array('iscu'=>1,'info'=>""));
		}elseif($type==2){
			return $this->ajaxReturn(array('iscu'=>2,'info'=>"您已为普通会员"));
		}else{
			return $this->ajaxReturn(array('iscu'=>3,'info'=>"您已为普通会员"));
		}
	}
	public function getRegRole()
	{
		$mid =	I('mid');
		$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
		$top 	=	M('member') ->where('id='.$mid) ->find();
		$topPaper	=	$top['quansum'];
		$needPaper	=	getBaseConfig('regPaper');
		if ($topPaper<$needPaper) {
			$this->ajaxReturn(array('status'=>false,'info'=>"推荐注册需要消耗".$needPaper."张升级券，您的余额不足！",'needPaper'=>$needPaper));
			die;
		}else{
			$this->ajaxReturn(array('status'=>true,'info'=>"可以注册",'needPaper'=>$needPaper));
			die;
		}
	}

	public function autoregmember()
	{	
		if (IS_POST) {
			$mobile =	I('mobile');
			$mname =	I('mname');
			$wex 	=	I('wex');
			$recast 	=	I('recast');
			$uid	=	I('pid');
			$truename 	=	I('truename');
			$alipay	=	I('alipay');
			$fphone	=	I('fphone');
			$parentids	=	I('parentids');
			$defaultPWD	=	getDefaultPwd();
			$defaultSafe	=	getDefaultSafe();
			$isMname	=	M('member') ->where('mname="'.$mname.'"') ->find();
			if ($isMname) {
				$this->ajaxReturn(array('status'=>false,'info'=>"用户名已经存在,请更换用户名再注册！"));
				die;
			}
			$dbMember	=	M('member');
			$top 	=	$dbMember ->where('ID='.$uid) ->find();
			if($top['dengji'] == 0){
				$info 	=	"您的推荐代理商尚未升级到白银代理商";
				$this->ajaxReturn(array('status'=>false,'info'=>$info));
				die;
			}
			$topPaper	=	$top['quansum'];
			$needPaper	=	getBaseConfig('regPaper');
			if ($topPaper<$needPaper) {
				$info 	=	"推荐注册需要消耗".$needPaper."张升级券，您或您的推荐人的余额不足！";
				$this->ajaxReturn(array('status'=>false,'info'=>$info,'need'=>$needPaper));
				die;
			}
			$isFind	=	M('member') ->where('moblie="'.$mobile.'"') ->find();
			if (!$isFind) {
				// $timeNow	=	time();   // 时间戳（秒）会在同一时间注册多个用户修，改为时间戳（毫秒）
				$mtime=explode('.',microtime(true));
				if(strlen($mtime[1])==3){
					$timeNow=$mtime[0].$mtime[1].'0';
				}else if(strlen($mtime[1])==2){
					$timeNow=$mtime[0].$mtime[1].'00';
				}else{
					$timeNow=$mtime[0].$mtime[1];
				}
				$regData	= 	array(
										'moblie'	=>	$mobile,
										'mid'		=>	$timeNow,
										'mname'		=>	$mname,
										'truename'	=>	$truename,
										'mpwd'		=>	md5($defaultPWD),
										'apwd'		=>	md5($defaultSafe),
										'reference'	=>	$uid,
										'qqaccout'	=>	$alipay,
										'weixinaccout'	=>	$wex,
										'addtime'	=>	time(),
										);
				if($recast == 22){ //复投注册
					// $grid	=	M('member') ->where('ID='.$uid) ->getField('grid');
					// $gid	=	M('group_recast') ->where('id='.$grid) ->getField('gid');
					// $grInfo	=	M('group_recast')->where('gid='.$gid)->select();
					// if(count($grInfo)>0){
					// 	$grInfo;
					// }


					// $uid = 5;
					$grid	=	M('member') ->where('ID='.$uid) ->getField('grid');
					$gid	=	M('group_recast') ->where('id='.$grid) ->getField('gid');
					$grInfo	=	M('group_recast')->where('gid='.$gid)->select();

					foreach ($grInfo as $key => $value) {
						if ($value['id'] == $grid) {
							
							if($grInfo[$key+1]['id']){
								$gridnew = $grInfo[$key+1]['id'];
							}else{
								$data = array();
								$data['name'] = $value['value'].($value['key']+1);
								$data['value'] = $value['value'];
								$data['key'] = $value['key']+1;
								$data['addtime'] = time();
								$data['gid'] = $value['gid'];
								$id	= M('group_recast')->add($data);
								$gridnew = $id;
							}
						}
					}
					$mInfo	=	M('member')->where('grid='.$gridnew.' and childnum < 3 and exist_grid = 0')->select();
					if($mInfo){
						// 循环复投
						$mbInfo = M('member')->where('grid='.$gridnew.' and childnum < 3 and exist_grid = 0')->find();
						$regData['pid']	=	$mbInfo['ID'];
						$regData['parentids']	=	$mbInfo['parentids'].','.$mbInfo['mid'];
					}else{
						if($fphone){
							$fphoneInfo = M('member')->where("moblie='".$fphone."'")->find();
							$regData['pid'] = $fphoneInfo['ID'];
							$regData['parentids'] = $parentids;
							$isrand = false;
						}else{
							$randphone = $this->randphone();
							$regData['pid']	=	$randphone['pid'];
							$regData['parentids']	=	$randphone['parentids'];
							$isrand = false;							
						}
					}
					// $this->ajaxReturn(array('status'=>true,'info'=>$regData['pid'].'=='.$regData['parentids'].'==='.$recast));
					$regData['grid']	=	$gridnew;
					// 添加复投父id
					$regData['rpid']	=	$uid;
					$QRcode	=	createQR(C('webRoot')."/index.php/Api/Api/regByUsr?sign=".$regData['addtime'],$regData['addtime']);
					$regData['qrsrc']	=	C('webRoot').ltrim($QRcode,'.');
				}else{
					$mSign  =	$top['mid'];
					if ($top['childnum']<3) {		//如果当前用户的直接下级数小于3，则直接注册到当前用户下
						$regData['parentids']	=	$top['parentids']=='0'?$mSign:$top['parentids'].','.$mSign;
						$psign =	ltrim($mSign,',');
						$pid = $top['ID'];
					}else{
						$father	=	$dbMember ->where('find_in_set('.$mSign.',parentids) AND childnum<3 AND exist_grid=0') ->order('mid asc') ->find();
						$psign =	$father['mid'];
						$pid 	=	$father['ID'];
						$regData['parentids']	=	$father['parentids'].','.$psign;
					}
					$regData['parentids']	=	ltrim($regData['parentids'],',');
					$regData['pid']	=	$pid;
					$QRcode	=	createQR(C('webRoot')."/index.php/Api/Api/regByUsr?sign=".$regData['addtime'],$regData['addtime']);
					$regData['qrsrc']	=	C('webRoot').ltrim($QRcode,'.');


					$regData['grid']	=	$top['grid'];
				}
				
				
				$res 	=	M('member') ->add($regData);
				// $a =  M('member') ->getLastSql();
				// $this->ajaxReturn(array('status'=>true,'info'=>$regData,'date'=>$regData['pid']));
				// die;
				if ($res) {
					// 分享注册二维码
					$QRcodeReg	=	createQR(C('webRoot')."/index.php/Index/reg/uid/".$res."/from/app",'reg'.$regData['addtime']);
					$qrsrcreg	=	C('webRoot').ltrim($QRcodeReg,'.');
					M('member') ->where('ID='.$res) ->save(array('qrsrcreg' => $qrsrcreg));
					if($recast == 22){
						// 复投注册成功 提交申请复投用户修改状态,
						M('member') ->where('ID='.$uid) ->save(array('recast' => '1'));
						// M('member') ->where('ID='.$uid) ->setInc('childnum',1);
						// 如果不是随机 修改上级存在复投会员为1
						// if($isrand){
						// 	M('member') ->where('ID='.$regData['pid']) ->save(array('exist_grid' => '1'));
						// }
						
						$this->ajaxReturn(array('status'=>true,'info'=>"复投注册成功，请重新登录复投帐号！",'recast'=>'1'));
					}else{
					// 增加推荐人数
					$dbMember ->where('ID='.$uid) ->setInc('regnums',1);	
					if($top['childnum']>=3){						
						M('member') ->where('ID='.$regData['pid']) ->save(array('exist_grid' => '1'));
					}				
					// // 扣除推荐注册需要消耗的升级券
					// $dbMember ->where('ID='.$uid) ->setDec('quansum',$needPaper);
					$dbMember ->where('mid='.$psign) ->setInc('childnum',1);
						$this->ajaxReturn(array('status'=>true,'info'=>"用户注册成功！",'recast'=>'0'));
					}
					
				}else{
					$this->ajaxReturn(array('status'=>false,'info'=>"用户注册失败！"));
				}
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"手机号已经注册过，请更换手机号后再注册。"));
			}
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}

	public function regmember()
	{
		if (IS_POST) {
			$mobile =	I('mobile');
			$mname =	I('mname');
			$wex 	=	I('wex');
			$truename 	=	I('truename');
			$alipay	=	I('alipay');
			$pid	=	I('pid');
			$defaultPWD	=	getDefaultPwd();
			$defaultSafe	=	getDefaultSafe();
			$isMname	=	M('member') ->where('mname="'.$mname.'"') ->find();
			if ($isMname) {
				$this->ajaxReturn(array('status'=>false,'info'=>"用户名已经存在,请更换用户名再注册！"));
				die;
			}			
			$isFind	=	M('member') ->where('moblie="'.$mobile.'"') ->find();
			if (!$isFind) {
				$parentInfo	=	M('member') ->where('ID='.$pid) ->find();
				$psign		=	$parentInfo['mid'];
				$pparentid	=	$parentInfo['parentids'].','.$psign;
				$pparentid	=	ltrim($pparentid,',');
				$timeNow	=	time();   // 时间戳（秒）会在同一时间注册多个用户修，改为时间戳（毫秒）
				$mtime=explode('.',microtime(true));
				if(strlen($mtime[1])==3){
					$timeNow=$mtime[0].$mtime[1].'0';
				}else if(strlen($mtime[1])==2){
					$timeNow=$mtime[0].$mtime[1].'00';
				}else{
					$timeNow=$mtime[0].$mtime[1];
				}
				$QRcode	=	createQR(C('webRoot')."/index.php/Api/Api/regByUsr?sign=".$timeNow,$timeNow);
				$QRcode	=	C('webRoot').ltrim($QRcode,'.');
				$regData	= 	array(
										'moblie'	=>	$mobile,
										'mid'		=>	$timeNow,
										'pid'		=>	$pid,
										'mname'		=>	$mname,
										'truename'	=>	$truename,
										'mpwd'		=>	md5($defaultPWD),
										'apwd'		=>	md5($defaultSafe),
										'parentids'	=>	$pparentid,
										'reference'	=>	$pid,
										'qqaccout'	=>	$alipay,
										'weixinaccout'	=>	$wex,
										'addtime'	=>	$timeNow,
										'qrsrc'		=>	$QRcode
										);
				$res 	=	M('member') ->add($regData);
				// echo M('member') ->getLastSql();
				if ($res) {
					// 增加注册人数
					$dbMember ->where('ID='.$pid) ->setInc('regnum',1);
					$dbMember ->where('mid='.$psign) ->setInc('childnum',1);
					$this->ajaxReturn(array('status'=>true,'info'=>"用户注册成功！"));
				}else{
					$this->ajaxReturn(array('status'=>false,'info'=>"用户注册失败！"));
				}
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"手机号已经注册过，请更换手机号后再注册。"));
			}
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}
	
	public function checklogin()		//会员登录
	{
		if (IS_POST) {
			$phone	=	I('phone');
			$deviceid	=	I('deviceid');
			$pwd	=	md5(I('password'));
			$res	=	M('member') ->where("moblie='".$phone."' and mpwd='".$pwd."'") ->find();
			$loginData	=	array('online'=>1,'deviceid'=>$deviceid,'logintime_last'=>time());
			if ($res['online']==1 && $res['deviceid']!=$deviceid) {
				$this->ajaxReturn(array('status'=>false,'info'=>"您的账号已在其它设备登录，请先在该设备中退出后再登录！"));
				die;
			}
			if ($res['flag']===0) {
				$this->ajaxReturn(array('status'=>false,'info'=>"您的账号已被管理员锁定，无法登录！"));
				die;
			}
			$log 	=	M('member') ->where('ID='.$res['ID']) ->save($loginData);
			// dump($res);
			$ajaxReturn = array('mid' 		=> 	$res['ID'],			//会员ID
								// 'msign'		=>	$res['mid'],		//会员编号
								'msign'		=>	$res['moblie'],		//会员编号，以手机号显示
								'mkey'		=>	$res['mkey'],		//会员识别号
								'mobile'	=>	$phone,		//会员编号
								'addtime'	=>	date('Y-m-d H:i:s',$res['addtime']),	//注册时间
								'qrsrc'		=>	$res['qrsrc'],		//推广码地址
								'wxid'		=>	$res['wxid'],		//微信ID
								'wxid_app'	=>	$res['wxid_app'],	//微信APP用户ID
								'qqid'		=>	$res['qqid'],		//QQID
								'qqid_app'	=>	$res['qqid_app'],	//来自手机QQ登录用户的ID
								'parentids'	=>	$res['parentids'],	//上级会员ID组
								'pid'		=>	$res['pid'],		//直接上级ID
								'qqaccout'	=>	$res['qqaccout'],	//QQ号
								'weixinaccout'	=>	$res['weixinaccout'],	//微信号
								'bao'	=>	$res['bao'],	//bao
								'recast'	=>	$res['recast'],	//是否复投
								'truename'	=>	$res['truename'],	//真实姓名
								 );
			if ($res) {
				$this->ajaxReturn($ajaxReturn);
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"手机号或密码错误，请重试"));
			}
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}

	public function memlogout()
	{
		if (IS_POST) {
			$mid	=	I('mid');
			$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
			// $deviceid	=	I('devID');
			// $logDeviceid	=	M('member') ->where('ID='.$mid) ->getField('deviceid');
			// if ($deviceid!=$logDeviceid) {
			// 	$this->ajaxReturn(array('status'=>false,'info'=>"设备标识符错误，无法退出！"));
			// 	die;
			// }
			$logoutData	=	array('online'=>0,'deviceid'=>'');
			$res	=	M('member') ->where('ID='.$mid) ->save($logoutData);
			// dump($res);
			if ($res!==false) {
				$this->ajaxReturn(array('status'=>true,'info'=>"退出成功！"));
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"退出失败！"));
			}
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}

	public function addfeed()
	{
		if (IS_POST) {
			$mid 	=	I('mid');
			$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
			$tpstr 	=	I('tpstr');
			$msg 	=	I('msg');
			$onepic 	=	I('onepic');
			$twopic 	=	I('twopic');
			$threepic 	=	I('threepic');
			$pic='';
			if($onepic){
				$pic .= $onepic;
			}
			if($twopic){
				$pic .= ','.$twopic;
			}
			if($threepic){
				$pic .= ','.$threepic;
			}
			$feedData	=	array('mid'=>$mid,'typestr'=>$tpstr,'content'=>$msg,'addtime'=>time(),'status'=>0,'pic'=>$pic);
			$res 	=	M('feedback') ->add($feedData);
			if ($res!==false) {
				$this->ajaxReturn(array('status'=>true,'info'=>"提交成功！"));
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"提交失败！"));
			}
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}

	public function signinbeifen()		//签到 5天给1卷 备份
	{
		$mid	=	I('mid');
		$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
		$membInfo	=	M('member') ->where('ID='.$mid) ->find();
		$nowdays = 	$membInfo['nowdaynum'];
		if (date('Y-m-d') == date('Y-m-d',$membInfo['signtime'])) {
		    $this->ajaxReturn(array('status'=>false,'info'=>"今日已签到"));
			die;
		}
		if ($nowdays<4) {		//如果当前签到小于4天，则添加当前签到天数1
			$Member = M('member');		
			$MemberData= array(
							'signtime'	=> time(),
							'nowdaynum' => array('exp', '`nowdaynum`+1'),
							'alldaynum' => array('exp', '`alldaynum`+1'),
							);
			$res = $Member ->where('ID='.$mid) ->save($MemberData);
			if ($res) {
				$info 	=	$Member ->field('nowdaynum,alldaynum') ->where('ID='.$mid) ->find();
				$this->ajaxReturn(array('status'=>1,'info'=>"签到成功",'nowDays'=>$info['nowdaynum'],'nowTotalDays'=>$info['alldaynum']));
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"签到失败，请重试"));
			}
		}else{		//否则发放升级券1张，当前签到天数归0
			$Member = M('member');		
			$MemberData= array(
							'signtime'	=> time(),
							'nowdaynum' => 0,
							'quansum' => array('exp', '`quansum`+1'),
							'alldaynum' => array('exp', '`alldaynum`+1'),
							);
			$res = $Member ->where('ID='.$mid) ->save($MemberData);
			if ($res) {
				$billData = array('fromID' => 0,'toID'=>$mid,'type'=>4,'billtp'=>"paper",'billnum'=>1,'ordid'=>'0','billtime'=>time(),'smark'=>"签到获得升级券",'tag'=>1);
				$billRst	=	M('bill') ->add($billData);	//插入账单记录表
				$this->ajaxReturn(array('status'=>2,'info'=>"签到成功,升级券加1"));
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"签到失败，请重试"));
			}
		}
	}

	public function signin()		//签到 
	{
		$mid	=	I('mid');
		$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
		$membInfo	=	M('member') ->where('ID='.$mid) ->find();
		if (date('Y-m-d') == date('Y-m-d',$membInfo['signtime'])) {
		    $this->ajaxReturn(array('status'=>false,'info'=>"今日已签到"));
			die;
		}
		$Member = M('member');		
		$MemberData= array(
						'signtime'	=> time(),
						'mnysum' => array('exp', '`mnysum`+0.08'),
						);
		$res = $Member ->where('ID='.$mid) ->save($MemberData);
		if($res){
			$billData = array('fromID' => 0,'toID'=>$mid,'type'=>4,'billtp'=>"mny",'billnum'=>0.08,'ordid'=>'0','billtime'=>time(),'smark'=>"签到获得0.08元",'tag'=>1);
			$billRst	=	M('bill') ->add($billData);	//插入账单记录表
			$this->ajaxReturn(array('status'=>2,'info'=>"签到成功,获得0.08元"));
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"签到失败，请重试"));
		}
		
		
	}

	public function getbossinfo()
	{
		$uid	=	I('uid');
		$bid	=	I('bid');
		$this->checkuser($uid);
		$usrInfo	=	M('member') ->where('ID='.$uid) ->find();
		$lvto 	=	$usrInfo['dengji']+1;
		$rows 	=	M('shengji') ->where('fromid='.$uid.' and levelto='.$lvto) ->count('ID');
		$is_sys =	$rows>1?true:false;
		$sj 	=	M('shengji') ->where('fromid='.$uid.' and levelto='.$lvto) ->select();

		// $bidnum = count($sj);

		// if($bidnum>1){
		// 	$bid = M('shengji') ->where('fromid='.$uid.' and levelto='.$lvto.' and status<>2') ->getField('toid');
		// }else{
		// 	$bid = $sj[0]['toid'];
		// }

		$res	=	M('member') ->where('ID='.$bid) ->find();
		$ajaxReturn = array('mid' 		=> 	$res['ID'],			//会员ID
							'mkey'		=>	$res['moblie'],
							'mname'		=>	$res['mname'],
							'truename'	=>	$res['truename'],
							'level'		=>	$res['dengji'],
							'lvimg'		=>	getLvImgTitle($res['dengji']),
							'paperNum'	=>	$res['quansum'],
							'mnyNum'	=>	$res['mnysum'],
							'mobile'	=>	$res['moblie'],		//手机号
							'qqaccout'	=>	$res['qqaccout'],	//QQ号
							'needUpNum'	=>	$upMngNum,
							'adimg'		=>	C('webRoot').$adInfo['mphoto'],
							'adurl'		=>	$adInfo['url'],
							'weixinaccout'	=>	$res['weixinaccout'],	//微信号
							'qrSrc'		=>	$res['qrsrc'],	//微信号
							'teams'		=>	getAllDownCount($res['mid']),
							'is_sys'	=>	$is_sys,
							'msg_tip'	=>	getBaseConfig('msg_tip'),
							 );
			if ($res) {
				$this->ajaxReturn($ajaxReturn);
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>$bid));
			}
	}
	public function getbossinfo20161130() //2016113备份
	{
		$uid	=	I('uid');
		$usrInfo	=	M('member') ->where('ID='.$uid) ->find();
		$lvto 	=	$usrInfo['dengji']+1;
		$rows 	=	M('shengji') ->where('fromid='.$uid.' and levelto='.$lvto) ->count('ID');
		$is_sys =	$rows>1?true:false;
		$sj 	=	M('shengji') ->where('fromid='.$uid.' and levelto='.$lvto) ->select();

		$bidnum = count($sj);

		if($bidnum>1){
			$bid = M('shengji') ->where('fromid='.$uid.' and levelto='.$lvto.' and status<>2') ->getField('toid');
		}else{
			$bid = $sj[0]['toid'];
		}

		$res	=	M('member') ->where('ID='.$bid) ->find();
		$ajaxReturn = array('mid' 		=> 	$res['ID'],			//会员ID
							'mkey'		=>	$res['moblie'],
							'mname'		=>	$res['mname'],
							'truename'	=>	$res['truename'],
							'level'		=>	$res['dengji'],
							'lvimg'		=>	getLvImgTitle($res['dengji']),
							'paperNum'	=>	$res['quansum'],
							'mnyNum'	=>	$res['mnysum'],
							'mobile'	=>	$res['moblie'],		//手机号
							'qqaccout'	=>	$res['qqaccout'],	//QQ号
							'needUpNum'	=>	$upMngNum,
							'adimg'		=>	C('webRoot').$adInfo['mphoto'],
							'adurl'		=>	$adInfo['url'],
							'weixinaccout'	=>	$res['weixinaccout'],	//微信号
							'qrSrc'		=>	$res['qrsrc'],	//微信号
							'teams'		=>	getAllDownCount($res['mid']),
							'is_sys'	=>	$is_sys,
							'msg_tip'	=>	getBaseConfig('msg_tip'),
							 );
			if ($res) {
				$this->ajaxReturn($ajaxReturn);
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>$bid));
			}
	}
	public function getAd()		//取广告
	{
		$pid	=	I('pid');
		$mnypacket = M('mnypacket')->where('ID = '.$pid)->find();
		$adInfo =	M('ad') ->where('e_time>'.time().' and id = '.$mnypacket['adid']) ->find(); 	//随机取得一条广告
		$ajaxReturn = array('adimg'		=>	C('webRoot').$adInfo['mphoto'],
							'adurl'		=>	$adInfo['url'],
							'banner'	=>	C('webRoot').$adInfo['thumb'],
							);
		$this->ajaxReturn($ajaxReturn);
	}
	public function getmemberinfo()		//取会员信息
	{
		if (IS_POST) {
			$uid	=	I('uid');
			$this->checkuser($uid);
			$mid	=	I('mid');
			$usrInfo	=	M('member') ->where('ID='.$uid) ->find();
			$lvto 	=	$usrInfo['dengji']+1;
			$rows 	=	M('shengji') ->where('fromid='.$uid.' and levelto='.$lvto) ->count('ID');
			$is_sys =	$rows>1?true:false;
			$res	=	M('member') ->where('ID='.$mid) ->find();
			$upMngNum	=	M('shengji') ->where('toid='.$mid.' and status=0') ->count('ID');
			$adInfo =	M('ad') ->where('e_time>'.time()) ->order('rand()') ->find(); 	//随机取得一条广告
			// dump($res);
			$ajaxReturn = array('mid' 		=> 	$res['ID'],			//会员ID
								'mkey'		=>	$res['moblie'],
								'recast'	=>	$res['recast'],
								'mname'		=>	$res['mname'],
								'level'		=>	$res['dengji'],
								'lvimg'		=>	getLvImgTitle($res['dengji']),
								'paperNum'	=>	$res['quansum'],
								'shopNum'	=>	$res['shopsum'],//商城卷张数
								'mnyNum'	=>	$res['mnysum'],
								'shopscore'	=>	$res['shopscore'],
								'backscore'	=>	$res['backscore'],
								'mobile'	=>	$res['moblie'],		//手机号
								'qqaccout'	=>	$res['qqaccout'],	//QQ号
								'needUpNum'	=>	$upMngNum,
								'adimg'		=>	C('webRoot').$adInfo['mphoto'],
								'adurl'		=>	$adInfo['url'],
								'weixinaccout'	=>	$res['weixinaccout'],	//微信号
								'qrSrc'		=>	$res['qrsrc'],	//微信号
								'teams'		=>	getAllDownCount($res['mid']),
								'is_sys'	=>	$is_sys,
								'msg_tip'	=>	getBaseConfig('msg_tip'),
								 );
			if ($res) {
				$this->ajaxReturn($ajaxReturn);
			}else{
				$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			}
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}

	public function getminfo()		//取会员信息2
	{
		if (IS_POST) {
			$uid	=	I('uid');
			$usrInfo	=	M('member') ->where('ID='.$uid) ->find();
			// $lvto 	=	$usrInfo['dengji']+1;
			// $rows 	=	M('shengji') ->where('fromid='.$uid.' and levelto='.$lvto) ->count('ID');
			// $is_sys =	$rows>1?true:false;
			// $res	=	M('member') ->where('ID='.$mid) ->find();
			// $upMngNum	=	M('shengji') ->where('toid='.$mid.' and status=0') ->count('ID');
			// $adInfo =	M('ad') ->where('e_time>'.time()) ->order('rand()') ->find(); 	//随机取得一条广告
			// dump($res);
			// $ajaxReturn = array('mid' 		=> 	$res['ID'],			//会员ID
			// 					'mkey'		=>	$res['moblie'],
			// 					'recast'	=>	$res['recast'],
			// 					'mname'		=>	$res['mname'],
			// 					'level'		=>	$res['dengji'],
			// 					'lvimg'		=>	getLvImgTitle($res['dengji']),
			// 					'paperNum'	=>	$res['quansum'],
			// 					'shopNum'	=>	$res['shopsum'],//商城卷张数
			// 					'mnyNum'	=>	$res['mnysum'],
			// 					'mobile'	=>	$res['moblie'],		//手机号
			// 					'qqaccout'	=>	$res['qqaccout'],	//QQ号
			// 					'needUpNum'	=>	$upMngNum,
			// 					'adimg'		=>	C('webRoot').$adInfo['mphoto'],
			// 					'adurl'		=>	$adInfo['url'],
			// 					'weixinaccout'	=>	$res['weixinaccout'],	//微信号
			// 					'qrSrc'		=>	$res['qrsrc'],	//微信号
			// 					'teams'		=>	getAllDownCount($res['mid']),
			// 					'is_sys'	=>	$is_sys,
			// 					'msg_tip'	=>	getBaseConfig('msg_tip'),
			// 					 );
			if ($usrInfo) {
				$this->ajaxReturn($usrInfo);
			}else{
				$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			}
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}

	public function addtemp()
	{
		$dataGet =	I();
		$key=1;
		foreach ($dataGet as $data) {
			$dataSave['value'.$key] = $data;
			$key += 1;
		}
		$res = M('tempdb') ->add($dataSave);
		$this->ajaxReturn($res);
	}

	public function getmemberpaper()		//取会员升级券数
	{
		if (IS_POST) {
			$mid	=	I('mid');
			$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
			$res	=	M('member') ->where('ID='.$mid) ->find();
			// dump($res);
			$ajaxReturn = array('paperNum'	=>	$res['quansum'] );
			if ($res) {
				$this->ajaxReturn($ajaxReturn);
			}else{
				$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			}			
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}

	public function getmembermny()		//取会员现金余额
	{	
		if (IS_POST) {
			$cashON	=	getBaseConfig('cashon');	//取系统的取现开关设置
			$cashBasic	=	getBaseConfig('cashbasic');	//取系统的取现基数设置
			$rate	=	getBaseConfig('rate');	//提现费率
			$mid	=	I('mid');
			$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
			$res	=	M('member') ->where('ID='.$mid) ->find();
			// dump($res);
			$ajaxReturn = array('mnyNum'	=>	$res['mnysum'],'cashOn'=>$cashON,'cashBasic'=>$cashBasic,'rate'=>$rate );
			if ($res) {
				$this->ajaxReturn($ajaxReturn);
			}else{
				$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			}
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}

	public function getmembershopsorce()		//取会员商城积分余额
	{	
		if (IS_POST) {
			$mid	=	I('mid');
			$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
			$res	=	M('member') ->where('ID='.$mid) ->find();
			// dump($res);
			$ajaxReturn = array('mnyNum'	=>	$res['mnysum'],'cashOn'=>$cashON,'cashBasic'=>$cashBasic );
			if ($res) {
				$this->ajaxReturn($ajaxReturn);
			}else{
				$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			}
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}

	public function ineedmny()		//现金提现
	{
		if (IS_POST) {
			$mid	=	I('mid');
      $payment = i('matment');
			$checkmid = $this->checkuser($mid);
			if(!$checkmid){
				$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
				die;
			}
			$mny 	=	I('mny');
			$paypwd	=	md5(I('paypass'));
			$membInfo	=	M('member') ->where('ID='.$mid) ->find();

			if (empty($membInfo['apwd']) || is_null($membInfo['apwd'])) {
				$this->ajaxReturn(array('status'=>false,'go'=>1,'info'=>"您尚未设置安全密码，请先设置安全密码！"));
				die;
			}else{
				if ($paypwd!=$membInfo['apwd']) {
					$this->ajaxReturn(array('status'=>false,'info'=>"安全密码错误"));
					die;
				}
			}			
			if ($membInfo['dengji']<=0) {
				$this->ajaxReturn(array('status'=>false,'info'=>"提现需要白银会员哦！"));
				die;
			}			
			if ($mny>$membInfo['mnysum']) {
				$this->ajaxReturn(array('status'=>false,'info'=>"账户余额不足！"));
				die;
			}
			if ($mny%10!=0) {
				$this->ajaxReturn(array('status'=>false,'info'=>"提现的金额须为10的倍数！"));
				die;
			}
			$needData = array('mid' => $mid,'mny'=>$mny,'addtime'=>time(),'payment'=>$payment);
			$res	=	M('needmny')->add($needData);
			if ($res) {
				M('member') ->where('ID='.$mid) ->setDec('mnysum',$mny);	//用户余额减去相应金额
				M('member') ->where('ID='.$mid) ->setInc('mnylock',$mny);	//用户冻结金额加上相应金额
				$mnyNow	=	M('member') ->where('ID='.$mid) ->getField('mnysum');
				$billData = array('fromID' => $mid,'toID'=>0,'type'=>2,'billtp'=>"mny",'billnum'=>$mny,'billtime'=>time(),'ordid'=>$res,'smark'=>"会员申请提现",'tag'=>0);
				$billRst	=	M('bill') ->add($billData);	//插入账单记录表

				$this->ajaxReturn(array('status'=>true,'info'=>"申请成功，提现资金将转至您绑定的帐户中。",'mnyNow'=>$mnyNow));
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"申请失败，请重试！"));
			}
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}

	public function transpaper()		//升级券转账
	{
		if (IS_POST) {
			$mid	=	I('mid');
			$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
			$papers 	=	I('papers');
			$transTO	=	I('msign');	//手机号
			$paypwd	=	md5(I('paypass'));
			$getMember	=	M('member') ->where('moblie="'.$transTO.'"') ->find();	//根据手机号获取会员信息
			$giveMember	=	M('member') ->where('ID='.$mid) ->find();

			if (empty($giveMember['apwd']) || is_null($giveMember['apwd'])) {
				$this->ajaxReturn(array('status'=>false,'go'=>1,'info'=>"您尚未设置安全密码，请先设置安全密码！"));
				die;
			}else{
				if ($paypwd!=$giveMember['apwd']) {
					$this->ajaxReturn(array('status'=>false,'info'=>"安全密码错误"));
					die;
				}
			}
			if ($papers<1) {
				$this->ajaxReturn(array('status'=>false,'info'=>"赠送升级券需大于1张！"));
				die;
			}
			if ($papers > $giveMember['quansum']) {
				$this->ajaxReturn(array('status'=>false,'info'=>"账户中升级券余额不足！"));
				die;
			}
			if (!isSameTeam($giveMember['mid'],$getMember['mid'])) {
				$this->ajaxReturn(array('status'=>false,'info'=>"您赠送的会员和您不在一个团队！"));
				die;
			}
			$dbMember	=	M('member');
			$res	=	$dbMember	->where('ID='.$mid) ->setDec('quansum',$papers);	//减去赠送人的升级券
			if ($res) {
				$ress	=	$dbMember	->where('mid='.$getMember['mid']) ->setInc('quansum',$papers);	//增加获赠人的升级券
				if ($ress) {
					$transData = array('fromid' => $mid,'toid'=>$getMember['mid'],'papernum'=>$papers,'fromtime' =>time());
					$transRes  = M('papertrans') ->add($transData);		//插入升级券转移记录表

					$billData = array('fromID' => $mid,'toID'=>$getMember['mid'],'type'=>3,'billtp'=>"paper",'billnum'=>$papers,'ordid'=>$transRes,'billtime'=>time(),'smark'=>"赠送升级券给其它会员",'tag'=>1);
					$billRst	=	M('bill') ->add($billData);	//插入账单记录表
					$paperNow	=	M('member') ->where('ID='.$mid) ->getField('quansum');
					pushMsg('会员['.$giveMember['mname'].']向您赠送'.$papers.'张升级券！',$getMember['ID']);		//发送手机推送信息
					$this->ajaxReturn(array('status'=>true,'info'=>"赠送成功，升级券已转至会员[".$transTO."]账户。",'paperNow'=>$paperNow));
				}else{
					// 获赠人增加升级券失败，赠送人恢复升级券
					$dbMember	->where('ID='.$mid) ->setInc('quansum',$papers);
					$this->ajaxReturn(array('status'=>false,'info'=>"转账失败！！"));
				}
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"转账失败！"));
			}
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}
    //用户余额转账
      public function usertransfe(){
        if (IS_POST) {
          $mid  =   I('mid');
          $checkmid = $this->checkuser($mid);
          if(!$checkmid){
            $this->ajaxReturn(array('status'=>false,'info'=>"用户不存在"));
            die;
          }
          $papers   =   I('papers');//转账金额
          $transTO  =   I('msign'); //手机号
          $paypwd   =   md5(I('paypass'));
          $otherName = I('otherName');
          $getMember    =   M('member') ->where('moblie="'.$transTO.'"'.' and mname = "'.$otherName.'"') ->find();  //根据手机号获取会员信息
          $giveMember   =   M('member') ->where('ID='.$mid) ->find();
          if(!$getMember['ID']){
          	$this->ajaxReturn(array('status'=>false,'go'=>1,'info'=>"用户不存在，或手机号与昵称不匹配！"));
            die;
          }
          if (empty($giveMember['apwd']) || is_null($giveMember['apwd'])) {
            $this->ajaxReturn(array('status'=>false,'go'=>1,'info'=>"您尚未设置安全密码，请先设置安全密码！"));
            die;
          }else{
            if ($paypwd!=$giveMember['apwd']) {
              $this->ajaxReturn(array('status'=>false,'info'=>"安全密码错误"));
              die;
            }
          }
          if ($papers > $giveMember['mnysum']) {
            $this->ajaxReturn(array('status'=>false,'info'=>"账户中余额不足！"));
            die;
          }
          $dbMember =   M('member');
          $res  =   $dbMember   ->where('ID='.$mid) ->setDec('mnysum',$papers); //减去赠送人的现金
          //减少数据添加到数据库？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？
          $transData = array('fromID' => $mid,'toID'=>$getMember['ID'],'papernum'=>$papers,'fromtime' =>time());
          $transRes  = M('papertrans') ->add($transData);       //插入余额bill转移记录表
          $billData = array('fromID' => $mid,'toID'=>0,'type'=>3,'billtp'=>"mny",'billnum'=>$papers,'ordid'=>$transRes,'billtime'=>time(),'smark'=>"赠送余额给其它会员",'tag'=>0);
          $billRst  =   M('bill') ->add($billData); //插入账单记录表
          if ($res) {
            $ress   =   $dbMember   ->where('ID='.$getMember['ID']) ->setInc('mnysum',$papers);   //增加获赠人的现金余额
            if ($ress) {
              $transData = array('fromID' =>$mid,'toID'=>$getMember['ID'],'papernum'=>$papers,'fromtime' =>time());
              $transRes  = M('papertrans') ->add($transData);       //插入余额bill转移记录表

              $billData = array('fromID' => 0,'toID'=>$getMember['ID'],'type'=>3,'billtp'=>"mny",'billnum'=>$papers,'ordid'=>$transRes,'billtime'=>time(),'smark'=>"其他会员转账给我",'tag'=>1);
              $billRst  =   M('bill') ->add($billData); //插入账单记录表
              $paperNow =   M('member') ->where('ID='.$mid) ->getField('mnysum');
              pushMsg('会员['.$giveMember['mname'].']向您转入'.$papers.'元！',$getMember['ID']);        //发送手机推送信息
              $this->ajaxReturn(array('status'=>true,'info'=>"转账成功，已转至会员[".$transTO."]账户。",'paperNow'=>$paperNow));
            }else{
              // 获赠人增加现金失败，赠送人恢复现金
              $dbMember ->where('ID='.$mid) ->setInc('mnysum',$papers);
              $this->ajaxReturn(array('status'=>false,'info'=>"转账失败！！"));
            }
          }else{
            $this->ajaxReturn(array('status'=>false,'info'=>"转账失败！"));
          }
        }else{
          $this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
        }
      }

	public function changepwd()		//修改登录密码
	{
		if (IS_POST) {
			$mid	=	I('mid');
			$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
			$oldPwd	=	md5(I('oldpwd'));
			$newPwd	=	md5(I('newpwd'));
			if ($oldPwd==$newPwd) {
				$this->ajaxReturn(array('status'=>false,'info'=>"新旧密码一致，修改失败！"));
				die;
			}
			$isOK	=	M('member') ->where("ID=".$mid." and mpwd='".$oldPwd."'") ->find();
			if ($isOK) {
				$res =	M('member') ->where('ID='.$mid) ->setField('mpwd',$newPwd);
				if ($res) {
					$this->ajaxReturn(array('status'=>true,'info'=>"密码修改成功，系统将自动退出，请以新密码重新登录！"));
				}else{
					$this->ajaxReturn(array('status'=>false,'info'=>"密码修改失败，请重试！"));						
				}
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"原密码验证错误"));
			}
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}

	public function forgetpwd()		//忘记登录密码
	{
		if (IS_POST) {
			$moblie	=	I('phone');
			$newPwd	=	md5(I('newpwd'));
			$isOK	=	M('member') ->where("moblie=".$moblie." and mpwd='".$newPwd."'") ->find();
			if($isOK){
				$this->ajaxReturn(array('status'=>false,'info'=>"新密码与原密码相同，请以原密码重新登录！"));
			}else{
				$res =	M('member') ->where('moblie='.$moblie) ->setField('mpwd',$newPwd);		
				if ($res) {
					$this->ajaxReturn(array('status'=>true,'info'=>"密码修改成功，请以新密码重新登录！"));
				}else{
					$this->ajaxReturn(array('status'=>false,'info'=>"密码修改失败，请重试！"));						
				}				
			}
			
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}

	public function changesafe()		//修改安全密码
	{
		if (IS_POST) {
			$mid	=	I('mid');
			$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
			$oldPwd	=	md5(I('oldpwd'));
			$newPwd	=	md5(I('newpwd'));
			if ($oldPwd==$newPwd) {
				$this->ajaxReturn(array('status'=>false,'info'=>"新旧密码一致，修改失败！"));
				die;
			}
			$membInfo	=	M('member') ->where("ID=".$mid) ->find();
			if (!empty($membInfo['apwd']) && !is_null($membInfo['apwd']) && $membInfo['apwd']!='') {
				if ($oldPwd!=$membInfo['apwd']) {
					$this->ajaxReturn(array('status'=>false,'info'=>"原安全密码验证错误!"));
					die;
				}
			}

			$res =	M('member') ->where('ID='.$mid) ->setField('apwd',$newPwd);
			if ($res) {
				$this->ajaxReturn(array('status'=>true,'info'=>"安全密码修改成功"));
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"安全密码修改失败，请重试！"));						
			}
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}

	public function forgetsafe()		//忘记安全密码密码
	{
		if (IS_POST) {
			$mid	=	I('mid');
			$moblie	=	I('phone');
			$newPwd	=	md5(I('newpwd'));
			$isOK	=	M('member') ->where("ID = ".$mid." and moblie=".$moblie." and apwd='".$newPwd."'") ->find();
			if($isOK){
				$this->ajaxReturn(array('status'=>false,'info'=>"新密码与原密码相同，请以原密码使用！"));
			}else{
				$res =	M('member') ->where('moblie='.$moblie) ->setField('apwd',$newPwd);		
				if ($res) {
					$this->ajaxReturn(array('status'=>true,'info'=>"密码修改成功，请以新密码使用！"));
				}else{
					$this->ajaxReturn(array('status'=>false,'info'=>"密码修改失败，请重试！"));						
				}				
			}
			
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}

	public function editinfo()		//修改用户信息
	{
		if (IS_POST) {
			$mid   = I('mid');
			$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
			$infoData['mname'] = I('mname');
			$infoData['qqaccout'] = I('qq');
			$infoData['weixinaccout'] = I('wex');
			// $infoData['mobile']= I('mobile');
			$res 	=	M('member') ->where('ID='.$mid) ->save($infoData);
			if ($res) {
				$this->ajaxReturn(array('status'=>true,'info'=>"资料修改成功"));
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"资料修改失败，请重试！"));						
			}

		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}

	public function getboss()		//计算用户升级的审核会员
	{
		if (IS_POST) {
			$mid	=	I('mid');
			$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
			$lvTo	=	I('lvto'); 

			if ($lvTo>6) {
				$this->ajaxReturn(array('status'=>2,'info'=>"等级已至最高，无法升级"));
				die;
			}
			$typemember =	M('member')->where('ID='.$mid)->find();
			if($typemember['type']==2){  // 2为被删代理商没有pid和parentids
				// 获取系统上4级parentids
				$bossMsign =	M('member')->where('moblie="'.getBaseConfig('delphone').'"')->getField('mid');
				
				
			}else{
				$pid =	M('member')->where('ID='.$mid)->getField('pid');
				if ($pid==0) {
					$this->ajaxReturn(array('status'=>3,'info'=>"您是最高层级会员，无需向他人申请"));
					die;
				}
				// 取出用户的上线成员组
				$parentids	=	M('member') ->where('ID='.$mid) ->getField('parentids');
				$parentArray	=	explode(',', $parentids);
				$floors	= count($parentArray);
				// $this->ajaxReturn(array('status'=>false,'info'=>$parentArray));
				if ($floors<$lvTo) {		//如果上线层数不足，取最高层上线
					$bossMsign	=	$parentArray[0];
					// echo $floors;
				}else{
					if (count($parentArray)>4) {	//如果上线层数过多，取最接近的5层(现在改成4层)
						for ($i=0; $i < 4; $i++) { 
							// echo $parentArray[5-$i].",";
							$parentArr[$i]	=	$parentArray[count($parentArray)-1-$i];
						}
					}else{
						rsort($parentArray);		//反向排序用户的上级成员，则升级等级与排序序号即可对应，等级-1即为上线会员排序
						$parentArr 	=	$parentArray;
					}
					$bossMsign	=	$parentArr[$lvTo-1];	//获得审核的会员的编号				
				}

			}
			
			// echo $bossMsign;
			$bossInfo	=	M('member') ->where('mid='.$bossMsign) ->find();
			if ($bossInfo) {
				$ajaxReturn	=	array('status'=>true,'bid'=>$bossInfo['ID'],'bsign'=>$bossInfo['mid'],'bname'=>$bossInfo['mname'],'blevel'=>$bossInfo['dengji']);
				$this->ajaxReturn($ajaxReturn);
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"获取上线成员失败，请重试"));
			}
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}

	public function upgrademe()			//申请升级
	{
		if (IS_POST) {
			$mid 	=	I('mid');
			$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
			$bid 	=	I('bid');
			$lvto 	=	I('lvto');
			$flag 	=	I('flag'); //1申请升级2继续升级
			$paypwd	=	md5(I('paypass'));
			$membInfo	=	M('member') ->where('ID='.$mid) ->find();
			$bossInfo	=	M('member') ->where('ID='.$bid) ->find();
			// 安全密码验证
			if (empty($membInfo['apwd']) || is_null($membInfo['apwd'])) {
				$this->ajaxReturn(array('status'=>false,'go'=>1,'info'=>"您尚未设置安全密码，请先设置安全密码！"));
				die;
			}else{
				if ($paypwd!=$membInfo['apwd']) {
					$this->ajaxReturn(array('status'=>false,'info'=>"安全密码错误"));
					die;
				}
			}

			// $dataSearch	=	array(
			// 					'fromid'	=>	$mid,
			// 					'toid'		=>	$bid,
			// 					'levelto'	=>	$lvto
			// 						);
			// $isUpgraded	=	M('shengji') ->where($dataSearch) ->select();
			// if ($isUpgraded) {
			// 	$this->ajaxReturn(array('status'=>false,'info'=>"当前等级的升级已经申请过了，无需重复申请！"));
			// 	die;
			// }
			
			// // if ($bossInfo['dengji']<$lvto || $bossInfo['regnums']<$needRecomm) { 暂时修改不要后面这个条件了
			// // 条件1：上级等级小于要升级数，条件2：升3级时下线3人且等级1级，条件3：领导人必须复投
			// if ($bossInfo['dengji']<$lvto || $dj3 || $dj4) {
			// 	$goSys	=	true;		//goSys为true时，审核对象将转向系统账号
			// 	// $this->ajaxReturn(array('status'=>2,'info'=>"您的上线等级不足，不能升级;"));

			// 	// 向原审核用户添加一个失败申请
			// 	if($flag != 2){
			// 		$dataUpgrade	=	array(
			// 								'fromid'	=>	$mid,
			// 								'toid'		=>	$bid,
			// 								'levelto'	=>	$lvto,
			// 								'fromtime'	=>	time(),
			// 								'status'	=>	2,
			// 									);				
			// 		M('shengji') ->add($dataUpgrade);	
			// 	}
				
			// 	pushMsg('会员['.$membInfo['mname'].']向您发起升级申请，由于您的等级不足，申请失败，请您尽快向您的上级申请升级！',$bid);		//发送手机推送信息
				
			// 	if($flag == 1){
			// 		$this->ajaxReturn(array('status'=>2,'bid'=>$bid,'info'=>"由于您的上级等级不足或推荐人数不足，申请失败，请您联系您的上级！"));
			// 		die;
			// 	}
			// }

			// if ($goSys) {	//向审核用户添加一个失败申请，同时向系统账号添加一个申请

			// 	// pushMsg('会员['.$membInfo['mname'].']向您发起升级申请，因您的等级或推荐会员数量不足，系统已匹配他人！',$bid);		//发送手机推送信息

			// 	// 向系统账号添加一个升级申请
			// 	$sysAccounts	=	getBaseConfig('sysMphone');
			// 	// 随机取一个系统账号
			// 	$sysAccArr	=	explode('|', $sysAccounts);
			// 	$randSys	=	array_rand($sysAccArr);
			// 	$sysMphone	=	$sysAccArr[$randSys];

			// 	$randphone = $this->randphone();
			// 	$randid	=	$randphone['pid'];

			// 	$sysInfo	=	M('member') ->where("ID='".$randid."'") ->find();
			// 	$bid 	=	$sysInfo['ID'];

			// 	$dataSearch	=	array(
			// 						'fromid'	=>	$mid,
			// 						'toid'		=>	$bid,
			// 						'levelto'	=>	$lvto,
			// 						'status'	=>	0,
			// 							);
			// 	$isUpgraded	=	M('shengji') ->where($dataSearch) ->select();
			// 	if ($isUpgraded) {
			// 		$this->ajaxReturn(array('status'=>false,'info'=>"当前等级的升级已经申请过了，无需重复申请！"));
			// 		die;
			// 	}

			// 	$dataUpgrade	=	array(
			// 							'fromid'	=>	$mid,
			// 							'toid'		=>	$bid,
			// 							'levelto'	=>	$lvto,
			// 							'fromtime'	=>	time(),
			// 							'status'	=>	0
			// 								);
			// 	$res 	=	M('shengji') ->add($dataUpgrade);
			// 	// if($res){
			// 	// 	$dataUpgrade1	=	array(
			// 	// 						'fromid'	=>	$mid,
			// 	// 						'levelto'	=>	$lvto,
			// 	// 						'status'	=>	2
			// 	// 							);
			// 	// 	M('shengji')->where($dataUpgrade1) ->setField('status',$upInfo['levelto']);
			// 	// }
			// }else{

				// 返现积分/商城积分 (直推/商城券 buyaole) 
				$back	=	M('config') ->where('config_tag="basic"') ->getField('config_value');
				$valueArray	=	json_decode($back,true);
				$rewardMny	=	getReturnMny($lvto);
				// 用户升级需扣除的钱数
				$needmny = $valueArray['mny_lv'.$lvto];
				// 上级用户所需要增加的钱数
				$addneedmny =  $needmny * 0.8;
				// 上级用户所需要扣除的升级卷
				$quanj =  pow(2,$lvto);


				$datamember	=	array('dengji'=>$lvto);
				$membInfo	=	M('member') ->where('ID='.$mid) ->save($datamember);	
				
				if($flag == 2){
					//存入升级记录
					$dataUpgrade	=	array(
											'fromid'	=>	$mid,
											'toid'		=>	$bid,
											'levelto'	=>	$lvto,
											'fromtime'	=>	time(),
											'status'	=>	2
												);				
					M('shengji') ->add($dataUpgrade);
					$tobid	=	M('member') ->where('pid=0 and dengji=4') ->order('rand()') ->getField('ID');
					pushMsg('您的下线['.$membInfo['mname'].']向您申请升级，因您的等级不足导致无法完成升级！该下线会员已经向系统发出升级匹配。为保证您的利益，请尽快完成升级',$bid);		//发送手机推送信息
				}else{
					$tobid = $bid;
				}
				//存入升级记录
				$dataUpgrade	=	array(
										'fromid'	=>	$mid,
										'toid'		=>	$tobid,
										'levelto'	=>	$lvto,
										'fromtime'	=>	time()
											);				
				$res = M('shengji') ->add($dataUpgrade);
			// }
			// 升级成功后 
			if ($res) {
				$billModle = M('bill');
				$memberModle = M('member');

				$membInfoss	=	M('member') ->where('ID='.$mid) ->find();
				if($membInfoss['type'] == 2){
					$tmember = $memberModle->where('ID = '.$tobid)->find();
					$tdata = array('pid' => $tobid, 'type' => 1, 'parentids'=> $tmember['parentids'].','.$tmember['mid']);
					$memberModle->where('ID = '.$mid)->save($tdata);
				}
				// 上级代理商

				// 20161201 修改 不扣除升级券
				// // 如果flag=2。则说明用户选择系统匹配，这时不需要给系统帐号做操作减少操作
				// if($flag != 2){
				// 	// 上级代理商耗费升级券
				// 	$memberModle ->where('ID='.$tobid) ->setDec('quansum',$quanj);	//扣除上级用户的升级券
				// 	$billDataquan = array('fromID' => $tobid,'toID'=>0,'type'=>5,'billtp'=>"paper",'billnum'=>$quanj,'ordid'=>$res,'billtime'=>time(),'smark'=>"升级代理商所耗费升级券");
				// 	$billModle ->add($billDataquan);	//插入账单记录表
				// }

				// 上级代理商增加钱数
				$memberModle ->where('ID='.$tobid) ->setInc('mnysum',$addneedmny);	//增加上级用户的钱数
				$billDataaddneedmny = array('fromID' => 0,'toID'=>$tobid,'type'=>5,'billtp'=>"mny",'billnum'=>$addneedmny,'ordid'=>$res,'billtime'=>time(),'smark'=>"升级下级代理商所获得",'tag'=>1);
				$billModle ->add($billDataaddneedmny);	//插入账单记录表
				// 上级代理商增加商城积分
				$memberModle ->where('ID='.$tobid) ->setInc('shopscore',$rewardMny);	//增加上级用户的商城积分
				$billDatarewardMny = array('fromID' => 0,'toID'=>$tobid,'type'=>8,'billtp'=>"score",'billnum'=>$rewardMny,'ordid'=>$res,'billtime'=>time(),'smark'=>"升级下级代理商所获得商城积分",'tag'=>1);
				$billModle ->add($billDatarewardMny);	//插入账单记录表
				// 上级代理商增加返现积分
				$memberModle ->where('ID='.$tobid) ->setInc('backscore',$rewardMny);	//增加上级用户的返现积分
				$billDatarewardMny = array('fromID' => 0,'toID'=>$tobid,'type'=>9,'billtp'=>"backscore",'billnum'=>$rewardMny,'ordid'=>$res,'billtime'=>time(),'smark'=>"升级下级代理商所获得返现积分",'tag'=>1);
				$billModle ->add($billDatarewardMny);	//插入账单记录表

				// 升级代理商

				// 升级代理商扣除钱数
				$memberModle ->where('ID='.$mid) ->setDec('mnysum',$needmny);	//扣除升级用户的余额
				$billData = array('fromID' => $mid,'toID'=>0,'type'=>5,'billtp'=>"mny",'billnum'=>$needmny,'ordid'=>$res,'billtime'=>time(),'smark'=>"向上线申请升级扣除金额",'tag'=>0);
				$billModle ->add($billData);	//插入账单记录表

				pushMsg('会员['.$membInfo['mname'].']向您升级，请注意查收！',$bid);		//发送手机推送信息
				$ajaxReturn	=	array('status'=>true,'info'=>"申请成功，等待上线审核",'bid'=>$bid);
				$this->ajaxReturn($ajaxReturn);
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"升级申请失败！"));
			}
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}

	public function pushmessage()
	{
		$mid 	=	I('mid');
		$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
		$bid 	=	I('bid');
		$membInfo	=	M('member') ->where('ID='.$mid) ->find();
		// if($lvto<3){
		// 	$msg = '您的下线会员['.$membInfo['mname'].']向您申请升级，因您的等级不足，无法完成升级，为保证您的利益，请尽快提升您的等级！';
		// }elseif ($lvto==3) {
		// 	if($membInfo['childnum']<3){
		// 		$msg = '您的下线会员['.$membInfo['mname'].']向您申请升级，因您下线不足3人，无法完成升级，为保证您的利益，请您尽快推广！';
		// 	}else{
		// 		$msg = '您的下线会员['.$membInfo['mname'].']向您申请升级，因您下线等级不满1级，无法完成升级，为保证您的利益，请您尽快通知下线提升等级！';
		// 	}
		// }else{
		// 	$msg = '您的下线会员['.$membInfo['mname'].']向您申请升级，因您没有复投升级，无法完成升级，为保证您的利益，请您尽快完成复投！';
		// }
		$msg = '您的下线['.$membInfo['mname'].']向您申请升级，因您的等级不足导致无法完成升级！为保证您的利益，请尽快完成升级';
		pushMsg($msg,$bid);
		// $this->ajaxReturn(array('status'=>true,'info'=>"数据提交！"));
	}

	public function pushmessage123()
	{
		$mid 	=	'494';
		$bid 	=	'494';
		$membInfo	=	M('member') ->where('ID='.$mid) ->find();
		$msg = '您的下线['.$membInfo['mname'].']向您申请升级，因您的等级不足导致无法完成升级！为保证您的利益，请尽快完成升级';
		pushMsg($msg,$bid);
		echo 'daole';die;
	}

	public function upgrademe20161130()			//申请升级20161130备份
	{
		if (IS_POST) {
			$mid 	=	I('mid');
			$bid 	=	I('bid');
			$lvto 	=	I('lvto');
			$flag 	=	I('flag'); //1申请升级2继续升级
			$paypwd	=	md5(I('paypass'));
			$membInfo	=	M('member') ->where('ID='.$mid) ->find();
			$bossInfo	=	M('member') ->where('ID='.$bid) ->find();
			if($flag == 1){
				if (empty($membInfo['apwd']) || is_null($membInfo['apwd'])) {
					$this->ajaxReturn(array('status'=>false,'go'=>1,'info'=>"您尚未设置安全密码，请先设置安全密码！"));
					die;
				}else{
					if ($paypwd!=$membInfo['apwd']) {
						$this->ajaxReturn(array('status'=>false,'info'=>"安全密码错误"));
						die;
					}
				}

				$dataSearch	=	array(
									'fromid'	=>	$mid,
									'toid'		=>	$bid,
									'levelto'	=>	$lvto
										);
				$isUpgraded	=	M('shengji') ->where($dataSearch) ->select();
				if ($isUpgraded) {
					$this->ajaxReturn(array('status'=>false,'info'=>"当前等级的升级已经申请过了，无需重复申请！"));
					die;
				}
			}
			
			

			$needRecomm	=	getBaseConfig('leastNums');
			if($bossInfo['pid'] != 0){
				if($lvto == 3){
					$num = '';
					$bossInfoC	=	M('member')->field('dengji') ->where('pid='.$bid) ->select();
					foreach ($bossInfoC as $key => $value) {
						if($value['dengji'] >=1 ){
							$num = $num+1;
						}
					}
					if($num < 3){
						$dj3 = true;
					}
				}
			}
			if($lvto == 4){
				if($bossInfo['recast'] != 1){
					$dj4 = true;
				}
			}



			// if ($bossInfo['dengji']<$lvto || $bossInfo['regnums']<$needRecomm) { 暂时修改不要后面这个条件了
			// 条件1：上级等级小于要升级数，条件2：升3级时下线3人且等级1级，条件3：领导人必须复投
			if ($bossInfo['dengji']<$lvto || $dj3 || $dj4) {
				$goSys	=	true;		//goSys为true时，审核对象将转向系统账号
				// $this->ajaxReturn(array('status'=>2,'info'=>"您的上线等级不足，不能升级;"));

				// 向原审核用户添加一个失败申请
				if($flag != 2){
					$dataUpgrade	=	array(
											'fromid'	=>	$mid,
											'toid'		=>	$bid,
											'levelto'	=>	$lvto,
											'fromtime'	=>	time(),
											'status'	=>	2,
												);				
					M('shengji') ->add($dataUpgrade);	
				}
				
				pushMsg('会员['.$membInfo['mname'].']向您发起升级申请，由于您的等级不足，申请失败，请您尽快向您的上级申请升级！',$bid);		//发送手机推送信息
				
				if($flag == 1){
					$this->ajaxReturn(array('status'=>2,'bid'=>$bid,'info'=>"由于您的上级等级不足或推荐人数不足，申请失败，请您联系您的上级！"));
					die;
				}
			}

			if ($goSys) {	//向审核用户添加一个失败申请，同时向系统账号添加一个申请

				// pushMsg('会员['.$membInfo['mname'].']向您发起升级申请，因您的等级或推荐会员数量不足，系统已匹配他人！',$bid);		//发送手机推送信息

				// 向系统账号添加一个升级申请
				$sysAccounts	=	getBaseConfig('sysMphone');
				// 随机取一个系统账号
				$sysAccArr	=	explode('|', $sysAccounts);
				$randSys	=	array_rand($sysAccArr);
				$sysMphone	=	$sysAccArr[$randSys];

				$randphone = $this->randphone();
				$randid	=	$randphone['pid'];

				$sysInfo	=	M('member') ->where("ID='".$randid."'") ->find();
				$bid 	=	$sysInfo['ID'];

				$dataSearch	=	array(
									'fromid'	=>	$mid,
									'toid'		=>	$bid,
									'levelto'	=>	$lvto,
									'status'	=>	0,
										);
				$isUpgraded	=	M('shengji') ->where($dataSearch) ->select();
				if ($isUpgraded) {
					$this->ajaxReturn(array('status'=>false,'info'=>"当前等级的升级已经申请过了，无需重复申请！"));
					die;
				}

				$dataUpgrade	=	array(
										'fromid'	=>	$mid,
										'toid'		=>	$bid,
										'levelto'	=>	$lvto,
										'fromtime'	=>	time(),
										'status'	=>	0
											);
				$res 	=	M('shengji') ->add($dataUpgrade);
				// if($res){
				// 	$dataUpgrade1	=	array(
				// 						'fromid'	=>	$mid,
				// 						'levelto'	=>	$lvto,
				// 						'status'	=>	2
				// 							);
				// 	M('shengji')->where($dataUpgrade1) ->setField('status',$upInfo['levelto']);
				// }
			}else{
				$dataUpgrade	=	array(
										'fromid'	=>	$mid,
										'toid'		=>	$bid,
										'levelto'	=>	$lvto,
										'fromtime'	=>	time()
											);				
				$res 	=	M('shengji') ->add($dataUpgrade);
			}
			if ($res) {
				// $ress	=	M('member') ->where('ID='.$mid) ->setDec('quansum',$lvto);	//扣除用户的升级券
				// $billData = array('fromID' => $mid,'toID'=>0,'type'=>5,'billtp'=>"paper",'billnum'=>$lvto,'ordid'=>$ress,'billtime'=>time(),'smark'=>"向上线申请升级耗费升级券");
				// $billRst	=	M('bill') ->add($billData);	//插入账单记录表
				pushMsg('会员['.$membInfo['mname'].']向您发起升级申请，请尽快处理！',$bid);		//发送手机推送信息
				$ajaxReturn	=	array('status'=>true,'info'=>"申请成功，等待上线审核",'bid'=>$bid);
				$this->ajaxReturn($ajaxReturn);
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"升级申请失败！"));
			}
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}
	public function upgrademe2()			//申请升级2原始备份
	{
		if (IS_POST) {
			$mid 	=	I('mid');
			$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
			$bid 	=	I('bid');
			$lvto 	=	I('lvto');
			$flag 	=	I('flag'); //1申请升级2继续升级
			$paypwd	=	md5(I('paypass'));
			$membInfo	=	M('member') ->where('ID='.$mid) ->find();
			$bossInfo	=	M('member') ->where('ID='.$bid) ->find();
			if (empty($membInfo['apwd']) || is_null($membInfo['apwd'])) {
				$this->ajaxReturn(array('status'=>false,'go'=>1,'info'=>"您尚未设置安全密码，请先设置安全密码！"));
				die;
			}else{
				if ($paypwd!=$membInfo['apwd']) {
					$this->ajaxReturn(array('status'=>false,'info'=>"安全密码错误"));
					die;
				}
			}
			$needRecomm	=	getBaseConfig('leastNums');
			if ($bossInfo['dengji']<$lvto || $bossInfo['regnums']<$needRecomm) {
				$goSys	=	true;		//goSys为true时，审核对象将转向系统账号
				// $this->ajaxReturn(array('status'=>2,'info'=>"您的上线等级不足，不能升级;"));
				pushMsg('会员['.$membInfo['mname'].']向您发起升级申请，由于您的等级不足或推荐人数不足，申请失败，请您尽快向您的上级申请升级！',$bid);		//发送手机推送信息
				if($flag == 1){
					die;
				}
				
			}
			//flag : 申请升级失败后，用户选择继续升级
			$dataSearch	=	array(
									'fromid'	=>	$mid,
									'toid'		=>	$bid,
									'levelto'	=>	$lvto
										);
			$isUpgraded	=	M('shengji') ->where($dataSearch) ->select();
			if ($isUpgraded) {
				$this->ajaxReturn(array('status'=>false,'info'=>"当前等级的升级已经申请过了，无需重复申请！"));
				die;
			}
			if ($goSys) {	//向审核用户添加一个失败申请，同时向系统账号添加一个申请
				// 向原审核用户添加一个失败申请
				$dataUpgrade	=	array(
										'fromid'	=>	$mid,
										'toid'		=>	$bid,
										'levelto'	=>	$lvto,
										'fromtime'	=>	time(),
										'status'	=>	2
											);				
				M('shengji') ->add($dataUpgrade);
				pushMsg('会员['.$membInfo['mname'].']向您发起升级申请，因您的等级或推荐会员数量不足，系统已匹配他人！',$bid);		//发送手机推送信息

				// 向系统账号添加一个升级申请
				$sysAccounts	=	getBaseConfig('sysMphone');
				// 随机取一个系统账号
				$sysAccArr	=	explode('|', $sysAccounts);
				$randSys	=	array_rand($sysAccArr);
				$sysMphone	=	$sysAccArr[$randSys];
				$sysInfo	=	M('member') ->where("moblie='".$sysMphone."'") ->find();
				$bid 	=	$sysInfo['ID'];
				$dataUpgrade	=	array(
										'fromid'	=>	$mid,
										'toid'		=>	$bid,
										'levelto'	=>	$lvto,
										'fromtime'	=>	time(),
										'status'	=>	0
											);
				$res 	=	M('shengji') ->add($dataUpgrade);
			}else{
				$dataUpgrade	=	array(
										'fromid'	=>	$mid,
										'toid'		=>	$bid,
										'levelto'	=>	$lvto,
										'fromtime'	=>	time()
											);				
				$res 	=	M('shengji') ->add($dataUpgrade);
			}
			if ($res) {
				// $ress	=	M('member') ->where('ID='.$mid) ->setDec('quansum',$lvto);	//扣除用户的升级券
				// $billData = array('fromID' => $mid,'toID'=>0,'type'=>5,'billtp'=>"paper",'billnum'=>$lvto,'ordid'=>$ress,'billtime'=>time(),'smark'=>"向上线申请升级耗费升级券");
				// $billRst	=	M('bill') ->add($billData);	//插入账单记录表
				pushMsg('会员['.$membInfo['mname'].']向您发起升级申请，请尽快处理！',$bid);		//发送手机推送信息
				$ajaxReturn	=	array('status'=>true,'info'=>"申请成功，等待上线审核",'bid'=>$bid);
				$this->ajaxReturn($ajaxReturn);
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"升级申请失败！"));
			}
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}
	
	public function upgrademny()		//取升级所需费用
	{
		if (IS_POST) {
			$level 	=	I('lvto');
			$back	=	M('config') ->where('config_tag="basic"') ->getField('config_value');
			$valueArray	=	json_decode($back,true);
			$this->ajaxReturn(array('status'=>true,'mny'=>$valueArray['mny_lv'.$level]));
			// dump($valueArray);
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}		
	}

	public function getdefaultpwd()		//取注册时默认密码
	{
		if (IS_POST) {
			$uid 	=	I('uid');
			$this->checkuser($uid);
			$mSign 	=	M('member') ->where('ID='.$uid)->getField('mid');
			$subMembs	=	M('member') ->where('FIND_IN_SET('.$mSign.',parentids)') ->count('ID');
			$is_full	=	$subMembs==363?true:false;	//输出下线是否满员
			$back	=	M('config') ->where('config_tag="basic"') ->getField('config_value');
			$valueArray	=	json_decode($back,true);
			$this->ajaxReturn(array('status'=>true,'is_full'=>$is_full,'dftPWD'=>$valueArray['dftPWD'],'dftSafe'=>$valueArray['dftSafe']));
			// dump($valueArray);
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}		
	}

	public function getRecast()		//随机获取复投上级
	{
		if (IS_POST) {
			$randphone = $this->randphone();
			$regData['pid']	=	$randphone['pid'];
			$regData['parentids']	=	$randphone['parentids'];
			$mname	=	M('member') ->where('ID = '.$regData['pid']) ->getField('mname');
			$sysMphone	=	M('member') ->where('ID = '.$regData['pid']) ->getField('moblie');
			$this->ajaxReturn(array('status'=>true,'moblie'=>$sysMphone,'mname'=>$mname,'parentids'=>$regData['parentids']));
			// dump($valueArray);
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}		
	}

	public function issentted()			//判断是否已经申请过
	{
		$mid 	=	I('mid');
		$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
		$bid 	=	I('bid');
		$lvto 	=	I('lvto');
		$dataSearch	=	array(
								'fromid'	=>	$mid,
								// 'toid'		=>	$bid,
								'levelto'	=>	$lvto
									);
		$isUpgraded	=	M('shengji') ->where($dataSearch) ->select();
		if(count($isUpgraded)>1){
			$dataSearch	=	array(
								'fromid'	=>	$mid,
								// 'toid'		=>	$bid,
								'levelto'	=>	$lvto,
								'status'	=>	0
									);
			$isUp	=	M('shengji') ->where($dataSearch) ->select();
			if ($isUp) {
				$this->ajaxReturn(array('status'=>true,'info'=>"当前等级的升级已经申请过了，无需重复申请！",'flag'=>1));
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"申请记录不存在！"));
			}
		}else{
			if ($isUpgraded) {
				if($isUpgraded[0]['status'] == 0){
					$this->ajaxReturn(array('status'=>true,'info'=>"当前等级的升级已经申请过了，无需重复申请！",'flag'=>2,'state'=>'success'));
				}else{
					$pInfo =M('member') ->where('ID='.$bid)->find();
					// if($pInfo['pid'] != 0){
						if($lvto == 3){
							$num = '';
							$bossInfoC	=	M('member')->field('dengji') ->where('pid='.$bid) ->select();
							foreach ($bossInfoC as $key => $value) {
								if($value['dengji'] >=1 ){
									$num = $num+1;
								}
							}
							if($num < 3){
								$dj3 = true;
							}
						}
					// }
					if($lvto == 4){
						if($pInfo['recast'] != 1){
							$dj4 = true;
						}
					}

					// 条件1：上级等级小于要升级数，条件2：升3级时下线3人且等级1级，条件3：领导人必须复投
					if ($pInfo['dengji']<$lvto || $dj3 || $dj4) {
						$this->ajaxReturn(array('status'=>true,'info'=>"当前等级的升级已经申请过了，无需重复申请！",'flag'=>2));
					}else{
						$this->ajaxReturn(array('status'=>true,'info'=>"当前等级的升级已经申请过了，无需重复申请！",'flag'=>2,'state'=>'success'));
					}					
				}				
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"申请记录不存在！"));
			}
		}
		// if ($isUpgraded) {
		// 	$this->ajaxReturn(array('status'=>true,'info'=>"当前等级的升级已经申请过了，无需重复申请！",'flag'=>$isUpgraded[0]['status']));
		// }else{
		// 	$this->ajaxReturn(array('status'=>false,'info'=>"申请记录不存在！"));
		// }
	}
	// 升级是判断上级是否满足升级条件
	public function isBossSatisfy(){
		$bid 	=	I('bid');
		$lvto 	=	I('lvto');
		$pInfo =M('member') ->where('ID='.$bid)->find();
		if($pInfo['pid'] != 0){
			if($lvto == 3){
				$num = '';
				$bossInfoC	=	M('member')->field('dengji') ->where('pid='.$bid) ->select();
				foreach ($bossInfoC as $key => $value) {
					if($value['dengji'] >=1 ){
						$num = $num+1;
					}
				}
				if($num < 3){
					$dj3 = true;
				}
			}
		}
		if($lvto == 4){
			if($pInfo['recast'] != 1){
				$dj4 = true;
			}
		}

		// 条件1：上级等级小于要升级数，条件2：升3级时下线3人且等级1级，条件3：领导人必须复投
		if ($pInfo['dengji']<$lvto || $dj3 || $dj4) {
			$this->ajaxReturn(array('status'=>false,'info'=>"不满足条件"));
		}else{
			$this->ajaxReturn(array('status'=>true,'info'=>"满足条件"));
		}		
	}

	// 根据用户ID和当前设备标识判断是否允许当前设备正常使用缓存的用户数据
	public function isSameDevice()
	{
		if (IS_POST) {
			$mid =	I('mid');
			$deviceid 	=	I('deviceid');
			$findDevice	=	M('member') ->where('ID='.$mid) ->find();
			if (empty($findDevice['deviceid'])) {	//如果没有设备标识记录，允许继续使用
				$this->ajaxReturn(array('status'=>1,'info'=>"无设备登录"));
				die;
			}
			if ($findDevice['deviceid']==$deviceid) {	//与已登录的设备标识一致，允许继续使用
				$this->ajaxReturn(array('status'=>1,'info'=>"相同设备"));
			}else{	//与已登录的设备标识不一致，不允许继续使用，APP中清除用户数据缓存
				$this->ajaxReturn(array('status'=>2,'info'=>"不同设备"));
			}
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}

	public function getuplist()	//获取升级申请列表
	{
		$mid	=	I('mid');
		$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
		$minid	=	I('minid');
		$list	=	M('shengji') ->where('toid='.$mid) ->order('status asc,id desc') ->select();
		if ($list) {
			foreach ($list as $up) {
				$countNum = M('shengji') ->where('fromid='.$up['fromid'].' and levelto = '.$up['levelto']) ->count();
				if($countNum>1){
					$up['st'] = 'sys';//选择系统升级，提示语句修改判断
				}else{
					if($up['status'] == 2){
						$info	=	M('member') ->where('id='.$up['toid']) ->find();	//取申请人信息
						if($up['levelto'] <= 2){
							if($info['dengji'] >=$up['levelto']){
								$up['status'] = 0;
							}
						}elseif ($up['levelto'] == 3) {
							if($info['dengji'] >=3){
								$num = '';
								$bossInfoC	=	M('member')->field('dengji') ->where('pid='.$info['ID']) ->select();
								foreach ($bossInfoC as $key => $value) {
									if($value['dengji'] >=1 ){
										$num = $num+1;
									}
								}
								if($num >= 3){
									$up['status'] = 0;
								}
							}
						}elseif ($up['levelto'] <= 4) {
							if($info['dengji'] ==$up['levelto'] && $info['recast'] == 1){
								$up['status'] = 0;
							}
						}
					}					
				}
				$usrInfo	=	M('member') ->where('id='.$up['fromid']) ->find();	//取申请人信息
				$up['fromMobile']	=	$usrInfo['moblie'];
				$up['fromName']	=	$usrInfo['mname'];
				$up['fromSign']	=	$usrInfo['mid'];
				$up['childnum']	=	$usrInfo['childnum'];
				$up['fromtime']	=	date('Y-m-d',$up['fromtime']);
				$upList[]	=	$up;
			}
			$this->ajaxReturn($upList);
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"没有申请数据..."));
		}
	}

	public function upagree()
	{
		if (IS_POST) {
			$mid 	=	I('mid');
			$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
			$upid 	=	I('upid');
			$paypwd	=	md5(I('paypass'));
			$membInfo	=	M('member') ->where('ID='.$mid) ->find();
			if (empty($membInfo['apwd']) || is_null($membInfo['apwd'])) {
				$this->ajaxReturn(array('status'=>false,'go'=>1,'info'=>"您尚未设置安全密码，请先设置安全密码！"));
				die;
			}else{
				if ($paypwd!=$membInfo['apwd']) {
					$this->ajaxReturn(array('status'=>false,'info'=>"安全密码错误"));
					die;
				}
			}
			$upInfo	=	M('shengji') ->where('ID='.$upid) ->find();	//取出升级详情
			// echo $membInfo['dengji']."|".$upInfo['levelto'];
			if ($membInfo['dengji']<$upInfo['levelto']) {
				$this->ajaxReturn(array('status'=>false,'info'=>"审核失败，您的等级不足"));
				die;
			}
			// 
			// 理解错误，不应该判断要升级会员的直推
			// $reUidss 	=	M('member') ->where('ID='.$upInfo['fromid']) ->getField('reference');
			// if($upInfo['levelto'] == 3){
			// 	// 查出推荐人下级3个会员是否为1级
			// 	$num='';
			// 	$bossInfoC	=	M('member')->field('dengji') ->where('pid='.$reUidss) ->select();
			// 	foreach ($bossInfoC as $key => $value) {
			// 		if($value['dengji'] >=1 ){
			// 			$num = $num+1;
			// 		}
			// 	}
			// 	if($num < 3){
			// 		$this->ajaxReturn(array('status'=>false,'info'=>"审核失败，您的下级会员等级不足"));
			// 		die;
			// 	}
			// }
			//
			if($upInfo['levelto'] == 4){
				$bossInfoC	=	M('member')->field('recast') ->where('ID='.$upInfo['toid']) ->find();
				if($bossInfoC['recast'] != 1){
					$this->ajaxReturn(array('status'=>false,'info'=>"审核失败，您还没有复投升级"));
					die;
				}
			}
			
			// 取出审核升级需要消耗的升级券数量
			$needPaper	=	getBaseConfig('pp_lv'.$upInfo['levelto']);
			if ($membInfo['quansum'] < $needPaper) {
				$this->ajaxReturn(array('status'=>false,'info'=>"审核失败，您的升级券不足"));
				die;
			}else{
				$leftPaper	=	$membInfo['quansum'] - $needPaper;
			}

			$upRst	=	M('member') ->where('ID='.$upInfo['fromid']) ->setField('dengji',$upInfo['levelto']);
			if ($upRst) {
				$upData	=	array('status'=>1,'totime'=>time());
				$comp	=	M('shengji') ->where('ID='.$upid) ->save($upData);	//更新申请记录状态
				$res 	=	M('member') ->where('ID='.$mid) ->setDec('quansum',$needPaper);	//扣除审核人的升级券
				// 申请升级会员的推荐注册会员获得奖励
				if ($res) {		
					// 升级会员的推荐人ID 给钱
					$reUid 	=	M('member') ->where('ID='.$upInfo['fromid']) ->getField('reference');
					// $a = M()->getLastSql();
					$rewardMny	=	getReturnMny($upInfo['levelto']);
					// 直推奖
					$pushmnyON	=	getBaseConfig('pushmnyon');	//取系统的直推奖开关设置
					if($pushmnyON==1){
						$a = M('member') ->where('ID='.$reUid) ->setInc('mnysum',$rewardMny);
						if($a){
							$billData = array('fromID' => 0,'toID'=>$reUid,'type'=>5,'billtp'=>"mny",'billnum'=>$rewardMny,'ordid'=>$upInfo['ID'],'billtime'=>time(),'smark'=>"审核用户升级得到钱",'tag'=>0);
							$billRst	=	M('bill') ->add($billData);	//插入账单记录表						
						}
					}else{
						$billData = array('fromID' => 0,'toID'=>$reUid,'type'=>7,'billtp'=>"mny",'billnum'=>$rewardMny,'ordid'=>$upInfo['ID'],'billtime'=>time(),'smark'=>"审核用户升级扣除直推奖",'tag'=>1);
						$billRst	=	M('bill') ->add($billData);	//插入账单记录表
					}
					// 商场券奖励
					$b = M('member') ->where('ID='.$reUid) ->setInc('shopsum',$rewardMny);
					
					if($b){
						$billData = array('fromID' => 0,'toID'=>$reUid,'type'=>6,'billtp'=>"mny",'billnum'=>$rewardMny,'ordid'=>$upInfo['ID'],'billtime'=>time(),'smark'=>"审核用户升级得到商城券",'tag'=>1);
						$billRst	=	M('bill') ->add($billData);	//插入账单记录表						
					}	
				}
				// $billData = array('fromID' => $mid,'toID'=>0,'type'=>6,'billtp'=>"paper",'billnum'=>$needPaper,'ordid'=>$upInfo['ID'],'billtime'=>time(),'smark'=>"审核用户升级耗费升级券");
				// $billRst	=	M('bill') ->add($billData);	//插入账单记录表
				pushMsg('会员['.$membInfo['mname'].']已同意您的升级申请！',$upInfo['fromid']);		//发送手机推送信息
				$this->ajaxReturn(array('status'=>true,'info'=>"审核成功！",'leftPaper'=>$leftPaper));
			}else{
				$dd	=	M('shengji') ->where('fromid='.$upInfo['fromid'].' and status = 2') ->find();
				if($dd){
					$upData	=	array('status'=>1,'totime'=>time());
					M('shengji') ->where('ID='.$dd['ID']) ->save($upData);	//更新申请记录状态
					$this->ajaxReturn(array('status'=>false,'info'=>"审核失败，其他会员已审核"));
				}else{
					$this->ajaxReturn(array('status'=>false,'info'=>"审核失败，请重试"));
				}
			}

		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}

	public function getfirsteam()
	{
		if (IS_POST) {
			$mid 	=	I('mid');
			$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
			$sublist	=	M('member') ->where('pid='.$mid) ->select();
			// 取团队管理处的注册开头状态设置
			$back	=	M('config') ->where('config_tag="basic"') ->getField('config_value');
			$valueArray	=	json_decode($back,true);
			$regon	=	$valueArray['regon'];
			if (empty($sublist)) {
				$teams	=	array(null,null,null);
			}else{
				for ($i=0; $i < 3; $i++) { 
					if (empty($sublist[$i]) || !isset($sublist[$i])) {
						$midArray[]	=	null;
					}else{
						$midArray[]	=	$sublist[$i]['ID'];
					}
				}

				foreach ($midArray as $mid) {
					if (empty($mid)) {
						$teams[]	=	null;
					}else{
						$memberInfo	=	M('member') ->where('ID='.$mid) ->find();
						$team = array('ID'=>$mid, 'mname' => $memberInfo['mname'],'msign'=>$memberInfo['mid'],'level'=>$memberInfo['dengji'],'wex'=>$memberInfo['weixinaccout'],'mobile'=>$memberInfo['moblie'],'dengji'=>$memberInfo['dengji'] );
						$team['list']	=	$this->getDownline($mid);
						$teams[]	=	$team;					
					}
				}				
			}
			$returnData	=	array('regon'=>$regon,
								  'team' =>$teams,
									);
			// $teams['regon']	=	$regon;
			// dump($teams);
			$this->ajaxReturn($returnData);
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}

	public function getmemberteam()		//获取会员的团队数据
	{
		if (IS_POST) {
			$midStr 	=	I('mid');
			$checkmid = $this->checkuser($mid);
		// if(!$checkmid){
		// 	$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
		// 	die;
		// }
			$midStr	= ltrim($midStr,',');	//去除字符串中最左侧的,
			$midArray	=	explode(',', $midStr);
			foreach ($midArray as $mid) {
				if (empty($mid) || $mid == 'null') {
					$teams[]	=	null;
				}else{
					$memberInfo	=	M('member') ->where('ID='.$mid) ->find();
					$team = array('ID'=>$mid, 'mname' => $memberInfo['mname'],'msign'=>$memberInfo['mid'],'level'=>$memberInfo['dengji'],'wex'=>$memberInfo['weixinaccout'],'mobile'=>$memberInfo['moblie'],'dengji'=>$memberInfo['dengji'] );
					$team['list']	=	$this->getDownline($mid);
					$teams[]	=	$team;					
				}
			}
			// dump($teams);
			$this->ajaxReturn($teams);
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}

	function getDownline($pid)		//获取指定会员ID的直接下线成员
	{
		$list 	=	M('member') ->field('ID,mname,mid,dengji,weixinaccout,moblie') ->where('pid='.$pid) ->select();
		if ($list) {
			for ($i=0; $i < 3; $i++) { 
				if (empty($list[$i]) || !isset($list[$i])) {
					$sublist[]	=	null;
				}else{
					$sublist[]	=	$list[$i];
				}
			}
		}else{
			$sublist =	array(null,null,null);
		}
		return $sublist;

	}

	public function teamcount()		//计算会员的团队统计信息
	{
		if (IS_POST) {
			$mid 	=	I('mid');
			$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
			$memberInfo	=	M('member') ->where('ID='.$mid) ->find();
			if ($memberInfo) {
				$msign 	=	$memberInfo['mid'];
				$levlArray = array(
									0 => $this->countLevelMember($msign,0), 
									1 => $this->countLevelMember($msign,1), 
									2 => $this->countLevelMember($msign,2),  
									3 => $this->countLevelMember($msign,3), 
									4 => $this->countLevelMember($msign,4), 
									);
				$floorArray= $this -> getFloorMemberNum($mid,4);
				$backData = array('levelCount' => $levlArray, 'floorCount'=>$floorArray,'regNums'=>$memberInfo['regnums']);
				$this->ajaxReturn($backData);
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"获取会员信息失败，请重试"));
			}
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}

	function countLevelMember($msign,$lv)
	{
		$nums	=	M('member') ->where('find_in_set('.$msign.',parentids) and dengji='.$lv) ->count('ID');
		return $nums;
	}

	function getFloorMemberNum($mid,$fl)
	{	
		$firstMembs	=	M('member') ->where('pid='.$mid) ->select();
		// dump($firstMembs);
		if ($firstMembs) {
			$firstNums	=	count($firstMembs);
			$back[]	=	$firstNums;
			for ($i=0; $i < $firstNums; $i++) { 
				$whereStr	.=	' OR pid='.$firstMembs[$i]['ID'];
				$whereStr	=	ltrim($whereStr,' OR ');
			}
			$secondMembs	=	M('member') ->field('ID') ->where($whereStr) ->select();
			$back[]	=	count($secondMembs);
			if (count($secondMembs)<=0) {
				$back[]	=	0;
				$back[]	=	0;
				$back[]	=	0;
				return $back;
			}
			for ($j=0; $j < count($secondMembs); $j++) { 
				$whereStrA	.=	' OR pid='.$secondMembs[$j]['ID'];
				$whereStrA	=	ltrim($whereStrA,' OR ');
			}
			$thirdMembs	=	M('member') ->field('ID') ->where($whereStrA) ->select();
			// echo M('member') ->getLastSql();
			$back[]	=	count($thirdMembs);

			if (count($thirdMembs)<=0) {
				$back[]	=	0;
				$back[]	=	0;
				return $back;
			}
			for ($k=0; $k < count($thirdMembs); $k++) { 
				$whereStrB	.=	' OR pid='.$thirdMembs[$k]['ID'];
				$whereStrB	=	ltrim($whereStrB,' OR ');
			}
			$forthMembs	=	M('member') ->field('ID') ->where($whereStrB) ->select();
			// echo M('member') ->getLastSql();
			$back[]	=	count($forthMembs);

			if (count($forthMembs)<=0) {
				$back[]	=	0;
				return $back;
			}
			for ($p=0; $p < count($forthMembs); $p++) { 
				$whereStrC	.=	' OR pid='.$forthMembs[$p]['ID'];
				$whereStrC	=	ltrim($whereStrC,' OR ');
			}
			$fifthMembs	=	M('member') ->field('ID') ->where($whereStrC) ->select();
			// echo M('member') ->getLastSql();
			$back[]	=	count($fifthMembs);
			return $back;
		}else{
			return null;
		}
	}

	public function getweblist()
	{
		$tp 	=	I('tp');
		if ($tp==1) {
			$helpList	=	M('aboutus') ->where('webtp=1') ->select();
			$ajaxReturn['help']	=	$helpList;
		}else{
			$webList	=	M('aboutus') ->where('webtp<>1') ->select();
			$ajaxReturn['web']	=	$webList;
		}	
		
		$this->ajaxReturn($ajaxReturn);
	}

	public function webdetail()
	{	
		$wid 	=	I('wid');
		$webInfo	=	M('aboutus') ->where('id='.$wid) ->find();
		if ($webInfo) {
			$webInfo['content']	=	stripslashes(htmlspecialchars_decode($webInfo['content']));
			$this->ajaxReturn($webInfo);
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"页面不存在..."));
		}
	}

	public function randphone()
	{	
		// 从系统池里求出系统帐号总数
		$phoneSum	=	M('member') ->where('pid=0 and dengji=4') ->count('ID');
		// 上4级平分
		$num = floor($phoneSum / 4);
			$up4 =	M('member') ->where('pid=0') ->limit('0,'.$num) ->select(); 		//上4级
			$up3 =	M('member') ->where('pid=0') ->limit($num.','.$num) ->select(); 	//上3级
			$ks = $num*2;
			$up2 =	M('member') ->where('pid=0') ->limit($ks.','.$num) ->select(); 	//上2级
			$ks = $num*3;
			$up1 =	M('member') ->where('pid=0') ->limit($ks.','.$num) ->select(); 	//上1级
			$r = rand(0,$num-1);
			$parentids = $up4[$r]['mid'].','.$up3[$r]['mid'].','.$up2[$r]['mid'].','.$up1[$r]['mid'];
			$pid = $up1[$r]['ID'];
		if ($parentids && $pid) {
			return array('status'=>true,'info'=>"随机成功",'pid'=>$pid,'parentids'=>$parentids);
		}else{
			return array('status'=>false,'info'=>"随机失败");
		}
	}
	public function getCode(){
		$phone = I('mobile');
		$member = M('member')->where("moblie = '".$phone."'")->find();
		if($member){
			$this->ajaxReturn(array('status'=>false,'info'=>"该手机号已注册"));
			die;
		}
		$sid = C('accountSid');
		$token = C('authToken');
		$url = C('mdUrl');
		date_default_timezone_set("Asia/Shanghai");
		$timestamp = date("YmdHis");
		$sig = md5($sid.$token.$timestamp);
		$code = rand(100000,999999);
		$smsContent = '【全民私包】您当前的验证码是'.$code.',请于10分钟内正确输入验证码，超时请重新获取。';
		$post_data = 'timestamp='.$timestamp.'&accountSid='.$sid.'&smsContent='.$smsContent.'&to='.$phone.'&sig='.$sig.'&respDataType=JSON';//
		$result = vpost($url,$post_data);
		$res = json_decode($result,true);
		if($res['respCode'] = '00000'){
			return $this->ajaxReturn(array('status'=>true,'info'=>"发送成功",'code'=>$code,'codephone'=>$phone));
		}else{
			return $this->ajaxReturn(array('status'=>false,'info'=>"发送失败"));
		}
	}
	public function getCodeFYy(){  //语音获取验证码
		$phone = I('mobile');
		$member = M('member')->where("moblie = '".$phone."'")->find();
		if($member){
			$this->ajaxReturn(array('status'=>false,'info'=>"该手机号已注册"));
			die;
		}
		$sid = C('accountSid');
		$token = C('authToken');
		$url = C('mdyyUrl');
		date_default_timezone_set("Asia/Shanghai");
		$timestamp = date("YmdHis");
		$sig = md5($sid.$token.$timestamp);
		$code = rand(100000,999999);
		// $smsContent = '【全民私包】您当前的验证码是'.$code.',请于10分钟内正确输入验证码，超时请重新获取。';
		$post_data = 'timestamp='.$timestamp.'&accountSid='.$sid.'&verifyCode='.$code.'&called='.$phone.'&sig='.$sig.'&callDisplayNumber=13702126183&playTimes=3&respDataType=JSON';//
		
		$result = vpost($url,$post_data);
		$res = json_decode($result,true);
			$this->ajaxReturn(array('status'=>false,'info'=>$res));
			die;
		if($res['respCode'] = '00000'){
			$this->ajaxReturn(array('status'=>true,'info'=>"发送成功",'code'=>$code,'codephone'=>$phone));
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"发送失败"));
		}
	}
	public function getBillList(){
		$mid = I('mid');
		$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
		//账单内容物类型（mny：现金，paper：升级券）
		$billtp = I('billtp');
		// $mid = '504';
		// $billtp = 'mny';
		$mnybill = M('bill')->where('fromID = '.$mid.' OR toID = '.$mid." and billtp = '".$billtp."'".' and type in(0,1,2,3,4,5,10)')->order('id desc')->select();
		// $a = M()->getLastSql();
		// print_r($a);die;
		foreach ($mnybill as $key => $value) {
			$mnybill[$key]['time'] = date('Y-m-d H:i:s',$value['billtime']);	//注册时间
			// 账单类型（0:红包，1:转账，2:提现，3:转账，4:签到，5:升级，6商城券,7:关闭直推奖，8商城积分，9返现积分）
			if($value['tag'] == 1){
				$mnybill[$key]['billnum'] = '+'.$value['billnum'];
			}else{
				$mnybill[$key]['billnum'] = '-'.$value['billnum'];
			}
			$ar = $this->getTimeWeek($value['billtime']);
			$mnybill[$key]['rq'] = $ar[0];
			$mnybill[$key]['z'] = $ar[1];
		}
		return $this->ajaxReturn(array('status'=>true,'data'=>$mnybill,'iscu'=>true));
	}
	// 获取商城积分
	public function getSorceList(){
		$mid = I('mid');
		$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
		$billtp = I('billtp');
		// $mid = '3';
		// $billtp = 'score';
		if($billtp == 'score'){
			$type = '8,11';
		}else{
			$type = '9,12';
		}

		$mnybill = M('bill')->where('toID = '.$mid." and billtp = '".$billtp."'".' and type in ('.$type.')')->order('id desc')->select();
		// $a = M()->getLastSql();
		// print_r($a);die;
		foreach ($mnybill as $key => $value) {
			$mnybill[$key]['time'] = date('Y-m-d H:i:s',$value['billtime']);	//注册时间
			// 账单类型（0:红包，1:转账，2:提现，3:转账，4:签到，5:升级，6商城券,7:关闭直推奖，8商城积分，9返现积分）
			if($value['tag'] == 1){
				$mnybill[$key]['billnum'] = '+'.$value['billnum'];
			}else{
				$mnybill[$key]['billnum'] = '-'.$value['billnum'];
			}
			$ar = $this->getTimeWeek($value['billtime']);
			$mnybill[$key]['rq'] = $ar[0];
			$mnybill[$key]['z'] = $ar[1];
		}
		// print_r($mnybill);die;
		return $this->ajaxReturn(array('status'=>true,'data'=>$mnybill,'iscu'=>true));
	}
	function getTimeWeek($time, $i = 0) {
	  $weekarray = array("一", "二", "三", "四", "五", "六","日");
	  $rq=date('m-d',$time);
	  $z = "周" . $weekarray[date("N", $time)-1];
	  $ar[0] = $rq;
	  $ar[1] = $z;
	  return $ar;
	}

	public function creatOrder(){
		if(IS_POST){
			$uid 	=	I('mid');
			$checkmid = $this->checkuser($uid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
			$method 	=	I('rechargeMethod');   //支付方式
			$type 	=	I('rechargeType');   //支付类型
			$money 	=	I('rechargeMoney');   // 订单钱数
			$membermid = M('member')->where('ID = '.$uid)->getField('mid');
			$number = time().$membermid;
			$data	= 	array(
							'number'	=>	$number,						
							'uid'		=>	$uid,
							'method'	=>	$method,
							'type'		=>	$type,
							'money'		=>	$money,
							'addtime'	=>	time(),
							'status'	=>	0,
							);
			$res 	=	M('order') ->add($data);
			if($res){
				return $this->ajaxReturn(array('status'=>true,'info'=>"成功",'number'=>$number));
			}else{
				return $this->ajaxReturn(array('status'=>false,'info'=>"失败"));
			}			
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}
	public function paySuccess(){
		if(IS_POST){
			$number 	=	I('number');
			$res = M('order') ->where("number='".$number."'") ->save(array('status' => '1','paytime' => time()));
			if($res){
				$order = M('order') ->where("number='".$number."'") ->find();
				$billModle = M('bill');
				$memberModle = M('member');
				if($order['type'] == 0){
					$ress = M('member') ->where('ID='.$order['uid']) ->setInc('mnysum',$order['money']);
					$billDataaddneedmny = array('fromID' => 0,'toID'=>$order['uid'],'type'=>10,'billtp'=>"mny",'billnum'=>$order['money'],'ordid'=>$res,'billtime'=>time(),'smark'=>"充值所获得",'tag'=>1);
					$billModle ->add($billDataaddneedmny);	//插入账单记录表
				}else{
					M('member') ->where('ID='.$order['uid']) ->setInc('shopscore',$order['money']);
					$billDatarewardMny = array('fromID' => 0,'toID'=>$order['uid'],'type'=>11,'billtp'=>"score",'billnum'=>$order['money'],'ordid'=>$res,'billtime'=>time(),'smark'=>"充值所获得商城积分",'tag'=>1);
					$billModle ->add($billDatarewardMny);	//插入账单记录表
					M('member') ->where('ID='.$order['uid']) ->setInc('backscore',$order['money']);
					$billDatarewardMny = array('fromID' => 0,'toID'=>$order['uid'],'type'=>12,'billtp'=>"backscore",'billnum'=>$order['money'],'ordid'=>$res,'billtime'=>time(),'smark'=>"充值商城积分获得返现积分",'tag'=>1);
					$billModle ->add($billDatarewardMny);	//插入账单记录表
				}
				return $this->ajaxReturn(array('status'=>true,'info'=>"支付成功",'ress'=>$ress));
			}else{
				return $this->ajaxReturn(array('status'=>false,'info'=>"支付失败"));
			}			
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}
	public function getQrsrcReg(){		
		if(IS_POST){
			$mid 	=	I('mid');
			$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
			$member 	=	M('member') ->where('ID='.$mid) ->find();
			$qrsrc	=	$member['qrsrcreg'];
			$this->ajaxReturn(array('status'=>true,'qrsrc'=>$qrsrc));					
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}
	public function delMember(){
		$mid	=	I('mid');
		// $mid	=20;
		// $checkmid = $this->checkuser($mid);
		// if(!$checkmid){
		// 	$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
		// 	die;
		// }
		$dbMember	=	M('member');
		$pcount = $dbMember ->where('pid='.$mid)->count();
		$dbBill	=	M('bill');
		$bill = $dbBill ->where("fromID = 0 and type = 10 and billtp = 'mny' and toID=".$mid)->find();
		if($bill['billnum'] > 0){
			$ajxReturn	=	array('status'=>false,'info'=>'该会员有过充值，不能直接删除');
			$this->ajaxReturn($ajxReturn);
			die;
		}
		if($pcount > 0){
			$ajxReturn	=	array('status'=>false,'info'=>'该会员有下线会员，不能直接删除');
		}else{
      //判断会员等级如果超过一级不可以删除
      $pcount = $dbMember ->where('ID='.$mid)->find();
      $dengji = $pcount['dengji'];
      if($dengji>0){
        $ajxReturn	=	array('status'=>false,'info'=>'该会员为'.$dengji.'级会员不能直接删除');
      }else{
        //判断时间够不够48小时
        $member = M('member') -> where('ID'.$mid) -> find();
        $a = time() - $member['addtime'];
        $b = 48*60*60;
        if($a<=$b){
          $ajxReturn	=	array('status'=>false,'info'=>'会员注册不超过48小时，请等待。。。');
        }else{
          $balance = $member['mnysum'];
          if($balance){
            $ajxReturn	=	array('status'=>false,'info'=>'会员账户中存在余额，不允许删除');
          }else{
            //判断账户中是否存在积分

            $jifen = $member['shopscore'];
            if($jifen>0){

              $ajxReturn	=	array('status'=>false,'info'=>'会员账户中存在积分，不允许删除');
            }else{
              $pid 		= $dbMember ->where('ID='.$mid) ->getField('pid');

              $data = array('pid' => 2147483647,'parentids' => '','type' => 2 );


              $res 		= $dbMember ->where('ID='.$mid) ->save($data);
              // $a=M()->getLastSql();
              // print_r($a);die;
              if ($res) {
                $dbMember ->where('ID='.$pid) ->setDec('childnum',1);
                // $url 	=	U("lists",array("pid"=>$pid));
                $ajxReturn	=	array('status'=>true,'info'=>'会员删除成功！');
              }else{
                $ajxReturn	=	array('status'=>false,'info'=>'会员删除失败！');
              }
            }
          }
        }
       }
      }
    // print_r($ajxReturn);die;
    $this->ajaxReturn($ajxReturn);
  }



	// public function getTname(){
	// 	$mid 	=	I('mid');
	// 	$checkmid = $this->checkuser($mid);
	// 	if(!$checkmid){
	// 		$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
	// 		die;
	// 	}
	// 	$member 	=	M('member') ->where('ID='.$mid) ->find();
	// 	$this->ajaxReturn(array('status'=>true,'data'=>$member['truename']));
	// }
	public function getBname(){

		$cardNo =I('cardNo');
		$url="https://ccdcapi.alipay.com/validateAndCacheCardInfo.json?_input_charset=utf-8&cardNo=".$cardNo."&cardBinCheck=true";
		$res = file_get_contents($url);
		$bank = json_decode($res,true);
		if($bank['bank'] != ''){
			$bankname = C($bank['bank']);
			$this->ajaxReturn(array('status'=>true,'data'=>$bankname));
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>'请输入正确的银行卡号或联系客服'));
		}
	}
	public function getBankName($number){


		//$number = '6217000010074079370';
		$url="https://ccdcapi.alipay.com/validateAndCacheCardInfo.json?_input_charset=utf-8&cardNo=".$number."&cardBinCheck=true";
		$res = file_get_contents($url);
    $bank = json_decode($res,true);
    $cardname = C($bank['bank']);
    return $cardname;






		// // $cardnumber =I('number');
		// $cardname = getBankName($number);
		// if($cardname){
		// 	return $cardname;
		// 	// $ajxReturn	=	array('status'=>true,'info'=>$cardname);
		// }
		// // else{
		// // 	$ajxReturn	=	array('status'=>false,'info'=>'获取银行卡名称失败！');
		// // }
		// // $this->ajaxReturn($ajxReturn);
	}

	public function getBank(){
		if(IS_POST){
			$mid 	=	I('mid');
			$checkmid = $this->checkuser($mid);
			if(!$checkmid){
				$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
				die;
			}
			$member 	=	M('member') ->where('ID='.$mid) ->find();
			$bankaccout	=	$member['bankaccout'];
			if($bankaccout){
				$cardname = $this->getBankName($bankaccout);
				$four=substr($bankaccout,-4);
				$data = array('four' => $four, 'cardname' => $cardname);
				$this->ajaxReturn(array('status'=>true,'data'=>$data));
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"银行卡不存在"));
			}
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}
	public function getAli(){
		if(IS_POST){
			$mid 	=	I('mid');
			$checkmid = $this->checkuser($mid);
			if(!$checkmid){
				$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
				die;
			}
			$member 	=	M('member') ->where('ID='.$mid) ->find();
			$qqaccout	=	$member['qqaccout'];
			if($qqaccout){
				// $cardname = $this->getBankName($bankaccout);
				// $four=substr($bankaccout,-4);
				$data = array('qqaccout' => $qqaccout,'mname'=>$member['truename']);
				$this->ajaxReturn(array('status'=>true,'data'=>$data));
			}else{
				$data = array('mname'=>$member['truename']);
				$this->ajaxReturn(array('status'=>false,'info'=>"支付宝不存在",'data'=>$data));
			}
								
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}
	public function addBank(){
		if(IS_POST){
			$mid 	=	I('mid');
			$bankaccout 	=	I('bankaccout');//银行卡账号
			$bankname 	=	I('bankname');//银行名字
			$tname 	=	I('tname');//持卡人真实姓名
			$checkmid = $this->checkuser($mid);
			if(!$checkmid){
				$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
				die;
			}
			$member 	=	M('member') ->where('ID='.$mid) ->find();
			if($member['truename'] != $tname){
				$this->ajaxReturn(array('status'=>false,'info'=>"银行卡姓名与注册时真实姓名不符，如需修改请联系客服"));
				die;				
			}
      //通过json返回bank值
      $cardname = $this->getBankName($bankaccout);
			$addData = array('bankaccout' => $bankaccout,'return' => $cardname);
			$res 	=	M('member') ->where('ID='.$mid) ->save($addData);
			// $qqaccout	=	$member['qqaccout'];
			if($res){
        $model = M('bank');
        $arr = M('member') -> join('t_bank ON t_bank.fanhui = t_member.return') -> find();
        $fanhui = $model -> where('fanhui="'.$cardname.'"') -> find();
        foreach($arr as $key=>$value){
          $fanhui[$key]=$value;
        }
        $photo = $fanhui['photo'];//银行卡归属银行对应图片路径
        $four=substr($bankaccout,-4);//截取银行卡后四位
        $data = array('four' => $four, 'cardname' => $bankname,'pic' => $photo,);
        $this->ajaxReturn(array('status'=>true,'info'=>"添加成功",'data'=>$data));
      }else{
				$this->ajaxReturn(array('status'=>false,'info'=>"添加失败"));
			}
								
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}

	public function addAli(){
		if(IS_POST){
			$mid 	=	I('mid');
			$qqaccout 	=	I('qqaccout');
			$tname 	=	I('tname');
			$checkmid = $this->checkuser($mid);
			if(!$checkmid){
				$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
				die;
			}
			$member 	=	M('member') ->where('ID='.$mid) ->find();
			if($member['truename'] != $tname){
				$this->ajaxReturn(array('status'=>false,'info'=>"支付宝姓名与注册时真实姓名不符，如需修改请联系客服"));
				die;				
			}
			if($member['qqaccout'] == $qqaccout){
				$this->ajaxReturn(array('status'=>true,'info'=>"添加成功"));
				die;
			}
			$addData = array('qqaccout' => $qqaccout);
			$res 	=	M('member') ->where('ID='.$mid) ->save($addData);
			// $qqaccout	=	$member['qqaccout'];
			if($res){
				// $cardname = $this->getBankName($bankaccout);
				// $four=substr($bankaccout,-4);
				$this->ajaxReturn(array('status'=>true,'info'=>"添加成功"));
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"添加失败"));
			}
								
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}
	public function editBank(){
		if(IS_POST){
			$mid 	=	I('mid');
			$bankaccout 	=	I('bankaccout');
			$bankname 	=	I('bankname');
			$tname 	=	I('tname');
			$phone 	=	I('phone');
			$checkmid = $this->checkuser($mid);
			if(!$checkmid){
				$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
				die;
			}
			$member 	=	M('member') ->where('ID='.$mid) ->find();
			if($member['truename'] != $tname){
				$this->ajaxReturn(array('status'=>false,'info'=>"银行卡姓名与注册时真实姓名不符，如需修改请联系客服"));
				die;				
			}
			if($member['moblie'] != $phone){
				$this->ajaxReturn(array('status'=>false,'info'=>"手机号与注册时手机号不符，如需修改请联系客服"));
				die;				
			}
      $cardname = $this->getBankName($bankaccout);
			$saveData = array('bankaccout' => $bankaccout,'return' =>$cardname);
			$res 	=	M('member') ->where('ID='.$mid) ->save($saveData);
			// $qqaccout	=	$member['qqaccout'];
			if($res){
        $model = M('bank');
        $arr = M('member') -> join('t_bank ON t_bank.fanhui = t_member.return') -> find();
        $fanhui = $model -> where('fanhui="'.$cardname.'"') -> find();
        foreach($arr as $key=>$value){
          $fanhui[$key]=$value;
        }
        $photo = $fanhui['photo'];//银行卡归属银行对应图片路径
        $four=substr($bankaccout,-4);//截取银行卡后四位
        $data = array('four' => $four, 'cardname' => $bankname,'pic' => $photo,);
				// $cardname = $this->getBankName($bankaccout);
				$this->ajaxReturn(array('status'=>true,'info'=>"修改成功",'data'=>$data));
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"修改失败"));
			}
								
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}
	public function editAli(){
		if(IS_POST){
			$mid 	=	I('mid');
			$qqaccout 	=	I('qqaccout');
			$tname 	=	I('tname');
			$phone 	=	I('phone');
			$checkmid = $this->checkuser($mid);
			if(!$checkmid){
				$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
				die;
			}
			$member 	=	M('member') ->where('ID='.$mid) ->find();
			if($member['truename'] != $tname){
				$this->ajaxReturn(array('status'=>false,'info'=>"支付宝姓名与注册时真实姓名不符，如需修改请联系客服"));
				die;				
			}
			if($member['moblie'] != $phone){
				$this->ajaxReturn(array('status'=>false,'info'=>"手机号与注册时手机号不符，如需修改请联系客服"));
				die;				
			}
			$saveData = array('qqaccout' => $qqaccout);
			$res 	=	M('member') ->where('ID='.$mid) ->save($saveData);
			// $qqaccout	=	$member['qqaccout'];
			if($res){
				// $cardname = $this->getBankName($bankaccout);
				// $four=substr($bankaccout,-4);
				$this->ajaxReturn(array('status'=>true,'info'=>"修改成功"));
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"修改失败"));
			}
								
		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}

	public function getuinfo(){
		$mid 	=	I('mid');
		$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
		$member 	=	M('member') ->where('ID='.$mid) ->find();
		if(!$member['qqaccout']){
			$member['qqaccout'] = null;
		}
		if(!$member['bankaccout']){
			$member['bankaccout'] = null;		
		}
		if(!$member['moblie']){
			$member['moblie'] = null;
		}
		$mem['qqaccout'] = $member['qqaccout'];
		$mem['bankaccout'] = $member['bankaccout'];
		$mem['moblie'] = $member['moblie'];
		$this->ajaxReturn(array('status'=>true,'info'=>"",'data'=>$mem));
	}

	public function testpush(){
		$bid = I('bid');
		if($bid){}else{
			$bid = 1;
		}
		pushMsg('服务器推送测试！',$bid);
		echo '12';
	}
	//回复反馈
	public function refeed(){
		if (IS_POST) {
			/* `content` text COMMENT '留言内容',
			`addtime` int(11) NOT NULL COMMENT '发布时间',
			`dotime` int(11) DEFAULT NULL COMMENT '处理时间',
			`domsg` text COMMENT '处理意见',*/
			$dataPost	=	I('mid');
			// $dataPost	=	1;
			$wei = M('feedback') -> where('mid='.$dataPost.' and domsg != ""') -> select();
			// $a=M()->getLastSql();
			foreach ($wei as $key => $value) {
				$feed['content'] = $value['content'];
				$feed['dotime'] = date('Y-m-d H:i',$value['dotime']);
				$feed['domsg'] = $value['domsg'];
			}
			$this->ajaxReturn(array('status'=>true,'info'=>'','data'=>$feed));

		}else{
			$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
		}
	}


	public function test(){
$ban =  array(
		// 银行卡名称
		"SRCB"=> "深圳农村商业银行", 
		"BGB"=> "广西北部湾银行", 
		"SHRCB"=> "上海农村商业银行", 
		"BJBANK"=> "北京银行", 
		"WHCCB"=> "威海市商业银行", 
		"BOZK"=> "周口银行", 
		"KORLABANK"=> "库尔勒市商业银行", 
		"SPABANK"=> "平安银行", 
		"SDEB"=> "顺德农商银行", 
		"HURCB"=> "湖北省农村信用社", 
		"WRCB"=> "无锡农村商业银行", 
		"BOCY"=> "朝阳银行", 
		"CZBANK"=> "浙商银行", 
		"HDBANK"=> "邯郸银行", 
		"BOC"=> "中国银行", 
		"BOD"=> "东莞银行", 
		"CCB"=> "中国建设银行", 
		"ZYCBANK"=> "遵义市商业银行", 
		"SXCB"=> "绍兴银行", 
		"GZRCU"=> "贵州省农村信用社", 
		"ZJKCCB"=> "张家口市商业银行", 
		"BOJZ"=> "锦州银行", 
		"BOP"=> "平顶山银行", 
		"HKB"=> "汉口银行", 
		"SPDB"=> "上海浦东发展银行", 
		"NXRCU"=> "宁夏黄河农村商业银行", 
		"NYNB"=> "广东南粤银行", 
		"GRCB"=> "广州农商银行", 
		"BOSZ"=> "苏州银行", 
		"HZCB"=> "杭州银行", 
		"HSBK"=> "衡水银行", 
		"HBC"=> "湖北银行", 
		"JXBANK"=> "嘉兴银行", 
		"HRXJB"=> "华融湘江银行", 
		"BODD"=> "丹东银行", 
		"AYCB"=> "安阳银行", 
		"EGBANK"=> "恒丰银行", 
		"CDB"=> "国家开发银行", 
		"TCRCB"=> "江苏太仓农村商业银行", 
		"NJCB"=> "南京银行", 
		"ZZBANK"=> "郑州银行", 
		"DYCB"=> "德阳商业银行", 
		"YBCCB"=> "宜宾市商业银行", 
		"SCRCU"=> "四川省农村信用", 
		"KLB"=> "昆仑银行", 
		"LSBANK"=> "莱商银行", 
		"YDRCB"=> "尧都农商行", 
		"CCQTGB"=> "重庆三峡银行", 
		"FDB"=> "富滇银行", 
		"JSRCU"=> "江苏省农村信用联合社", 
		"JNBANK"=> "济宁银行", 
		"CMB"=> "招商银行", 
		"JINCHB"=> "晋城银行JCBANK", 
		"FXCB"=> "阜新银行", 
		"WHRCB"=> "武汉农村商业银行", 
		"HBYCBANK"=> "湖北银行宜昌分行", 
		"TZCB"=> "台州银行", 
		"TACCB"=> "泰安市商业银行", 
		"XCYH"=> "许昌银行", 
		"CEB"=> "中国光大银行", 
		"NXBANK"=> "宁夏银行", 
		"HSBANK"=> "徽商银行", 
		"JJBANK"=> "九江银行", 
		"NHQS"=> "农信银清算中心", 
		"MTBANK"=> "浙江民泰商业银行", 
		"LANGFB"=> "廊坊银行", 
		"ASCB"=> "鞍山银行", 
		"KSRB"=> "昆山农村商业银行", 
		"YXCCB"=> "玉溪市商业银行", 
		"DLB"=> "大连银行", 
		"DRCBCL"=> "东莞农村商业银行", 
		"GCB"=> "广州银行", 
		"NBBANK"=> "宁波银行", 
		"BOYK"=> "营口银行", 
		"SXRCCU"=> "陕西信合", 
		"GLBANK"=> "桂林银行", 
		"BOQH"=> "青海银行", 
		"CDRCB"=> "成都农商银行", 
		"QDCCB"=> "青岛银行", 
		"HKBEA"=> "东亚银行", 
		"HBHSBANK"=> "湖北银行黄石分行", 
		"WZCB"=> "温州银行", 
		"TRCB"=> "天津农商银行", 
		"QLBANK"=> "齐鲁银行", 
		"GDRCC"=> "广东省农村信用社联合社", 
		"ZJTLCB"=> "浙江泰隆商业银行", 
		"GZB"=> "赣州银行", 
		"GYCB"=> "贵阳市商业银行", 
		"CQBANK"=> "重庆银行", 
		"DAQINGB"=> "龙江银行", 
		"CGNB"=> "南充市商业银行", 
		"SCCB"=> "三门峡银行", 
		"CSRCB"=> "常熟农村商业银行", 
		"SHBANK"=> "上海银行", 
		"JLBANK"=> "吉林银行", 
		"CZRCB"=> "常州农村信用联社", 
		"BANKWF"=> "潍坊银行", 
		"ZRCBANK"=> "张家港农村商业银行", 
		"FJHXBC"=> "福建海峡银行", 
		"ZJNX"=> "浙江省农村信用社联合社", 
		"LZYH"=> "兰州银行", 
		"JSB"=> "晋商银行", 
		"BOHAIB"=> "渤海银行", 
		"CZCB"=> "浙江稠州商业银行", 
		"YQCCB"=> "阳泉银行", 
		"SJBANK"=> "盛京银行", 
		"XABANK"=> "西安银行", 
		"BSB"=> "包商银行", 
		"JSBANK"=> "江苏银行", 
		"FSCB"=> "抚顺银行", 
		"HNRCU"=> "河南省农村信用", 
		"COMM"=> "交通银行", 
		"XTB"=> "邢台银行", 
		"CITIC"=> "中信银行", 
		"HXBANK"=> "华夏银行", 
		"HNRCC"=> "湖南省农村信用社", 
		"DYCCB"=> "东营市商业银行", 
		"ORBANK"=> "鄂尔多斯银行", 
		"BJRCB"=> "北京农村商业银行", 
		"XYBANK"=> "信阳银行", 
		"ZGCCB"=> "自贡市商业银行", 
		"CDCB"=> "成都银行", 
		"HANABANK"=> "韩亚银行", 
		"CMBC"=> "中国民生银行", 
		"LYBANK"=> "洛阳银行", 
		"GDB"=> "广东发展银行", 
		"ZBCB"=> "齐商银行", 
		"CBKF"=> "开封市商业银行", 
		"H3CB"=> "内蒙古银行", 
		"CIB"=> "兴业银行", 
		"CRCBANK"=> "重庆农村商业银行", 
		"SZSBK"=> "石嘴山银行", 
		"DZBANK"=> "德州银行", 
		"SRBANK"=> "上饶银行", 
		"LSCCB"=> "乐山市商业银行", 
		"JXRCU"=> "江西省农村信用", 
		"ICBC"=> "中国工商银行", 
		"JZBANK"=> "晋中市商业银行", 
		"HZCCB"=> "湖州市商业银行", 
		"NHB"=> "南海农村信用联社", 
		"XXBANK"=> "新乡银行", 
		"JRCB"=> "江苏江阴农村商业银行", 
		"YNRCC"=> "云南省农村信用社", 
		"ABC"=> "中国农业银行", 
		"GXRCU"=> "广西省农村信用", 
		"PSBC"=> "中国邮政储蓄银行", 
		"BZMD"=> "驻马店银行", 
		"ARCU"=> "安徽省农村信用社", 
		"GSRCU"=> "甘肃省农村信用", 
		"LYCB"=> "辽阳市商业银行", 
		"JLRCU"=> "吉林农信", 
		"URMQCCB"=> "乌鲁木齐市商业银行", 
		"XLBANK"=> "中山小榄村镇银行", 
		"CSCB"=> "长沙银行", 
		"JHBANK"=> "金华银行", 
		"BHB"=> "河北银行", 
		"NBYZ"=> "鄞州银行", 
		"LSBC"=> "临商银行", 
		"BOCD"=> "承德银行", 
		"SDRCU"=> "山东农信", 
		"NCB"=> "南昌银行", 
		"TCCB"=> "天津银行", 
		"WJRCB"=> "吴江农商银行", 
		"CBBQS"=> "城市商业银行资金清算中心", 
		"HBRCU"=> "河北省农村信用社"
		 );
		foreach ($ban as $key => $value) {
			$data = array('fanhui' => $key,'name' => $value );
			M('bank')->add($data);
		}
		print_r('$ban');
		die;
		$cardNo = '6217000010074079370';
		$url="https://ccdcapi.alipay.com/validateAndCacheCardInfo.json?_input_charset=utf-8&cardNo=".$cardNo."&cardBinCheck=true";
		$res = file_get_contents($url);
		$bank = json_decode($res,true);
		$bankname = C($bank['bank']);
		dump($bankname);die;
		$mid = I('mid');
		echo $checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
	}
}
?>
