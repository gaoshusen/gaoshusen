<?php
	/**
	* 
	*/
	class MemberAction extends CommonAction
	{
		
		public function lists()
		{
			$pid =	I('pid');
			$pid =	$pid==''?0:$pid;
			$dbUsr	=	M('member');
			$userList	=	$dbUsr ->where('pid='.$pid) ->select();
			$this->assign('usrList',$userList);

			$this->display('lists');
		}


		public function detail()
		{
			$this->display();
		}

		public function add()
		{	
			$this->assign('method','add');
			$this->assign('isFull',1);
			$this->assign('windowTitle','新增顶级会员');
			// $mid	=	time();   // 时间戳（秒）会在同一时间注册多个用户修，改为时间戳（毫秒）
			$mtime=explode('.',microtime(true));
			if(strlen($mtime[1])==3){
				$mid=$mtime[0].$mtime[1].'0';
			}else if(strlen($mtime[1])==2){
				$mid=$mtime[0].$mtime[1].'00';
			}else{
				$mid=$mtime[0].$mtime[1];
			}
			$this->assign('mid',$mid);
			$QRcode	=	createQR("http://".$_SERVER["SERVER_NAME"]."/index.php/Api/Api/regByUsr?sign=".$mid,$mid);
			$QRcode	=	'http://'.$_SERVER["SERVER_NAME"].ltrim($QRcode,'.');
			// $url_default	=	'http://'.$_SERVER["SERVER_NAME"].'/index.php/Api/Api/regByUsr?sign='.$mid;
			$this->assign('qrsrc',$QRcode);
			// $url_code	=	urlencode($url_default);
			// $site_con	= getSiteConfig();
			// $this->assign('wxqr','http://qr.topscan.com/api.php?w=200&text=https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$site_con['WXappid'].'&redirect_uri='.$url_code.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect');
			$this->display('excute');
		}

		public function edit()
		{
			$this->assign('method','edit');
			$this->assign('isFull',0);
			$this->assign('windowTitle','编辑顶级会员');
			$mid	=	I('mid');
			$memInfo	=	M('member') ->where('id='.$mid)	->find();

			$this->assign($memInfo);
			$this->display('excute');
		}

		public function search()
		{
			$moblie	=	I('moblie');
			$res 	=	M('member') ->where('moblie="'.$moblie.'" OR mname LIKE "%'.$moblie.'%"') ->find();
			// dump($res);
			if ($res) {
				$url 	=	U("lists",array("pid"=>$res['pid']));
				$ajxReturn	=	array('status'=>1,'path'=>$url ,'info'=>'查找成功，正在显示结果...');
			}else{
				$ajxReturn	=	array('status'=>0,'info'=>'会员不存在，请输入正确的手机号！');
			}
			$this->ajaxReturn($ajxReturn);
		}

		public function clearlogin()
		{
			$mid 	=	I('mid');
			$dataClear	=	array(
							'online'=>0,
							'deviceid'=>''
							);
			$res 	=	M('member') ->where('ID') ->save($dataClear);
			if ($res!==false) {
				$url 	=	U("lists",array("pid"=>$res['pid']));
				$ajxReturn	=	array('status'=>1,'path'=>$url ,'info'=>'清除登录成功！');
			}else{
				$ajxReturn	=	array('status'=>0,'info'=>'清除登录失败，请重试！');
			}
			$this->ajaxReturn($ajxReturn);
		}

		public function delete()
		{
			$mid	=	I('mid');
			// $mid	=	'43';
			$dbMember	=	M('member');
			$pcount = $dbMember ->where('pid='.$mid)->count();
			// print_r($pcount);die;
			if($pcount > 0){
				$ajxReturn	=	array('status'=>0,'info'=>'该会员有下线会员，不能直接删除');
			}else{
				$pid 		= $dbMember ->where('id='.$mid) ->getField('pid');
				$res 		= $dbMember ->where('id='.$mid) ->delete();
				if ($res) {
					$dbMember ->where('ID='.$pid) ->setDec('childnum',1);
					$url 	=	U("lists",array("pid"=>$pid));
					$ajxReturn	=	array('status'=>1,'info'=>'会员删除成功！','data'=>$url);
				}else{
					$ajxReturn	=	array('status'=>0,'info'=>'会员删除失败！');
				}
			}			
			addlog(MODULE_NAME,ACTION_NAME,$ajxReturn['info']);
			$this->ajaxReturn($ajxReturn);
		}

		public function excute()
		{
			$dataPost	=	I('');

			// 编辑时，如果密码未设置则不更新密码
			if ($dataPost['mpwd']=='') {
				$dataPost	=	array_remove($dataPost,'mpwd');
			}else{
				$dataPost['mpwd']	=	md5($dataPost['mpwd']);				
			}
			if ($dataPost['apwd']=='') {
				$dataPost	=	array_remove($dataPost,'apwd');
			}else{
				$dataPost['apwd']	=	md5($dataPost['apwd']);				
			}
			$dbMember	=	M('member');
			// dump($dataPost);
			switch ($dataPost['method']) {
				case 'add':
					$dataPost['addtime']	=	time();
					$dataPost['parentids']	=	'';
					// $dataPost['dengji']		=	4;
					$dataPost['grid']		=	1;
					$phone	=	$dbMember ->where('moblie="'.$dataPost['moblie'].'"') ->find();
					$mname 	=	$dbMember ->where('mname="'.$dataPost['mname'].'"') ->find();
					if ($phone || $mname) {
						if ($phone) {
							$ajxReturn	=	array('status'=>0,'info'=>'手机号已被注册，请更换手机号后再试！');
						}else{
							$ajxReturn	=	array('status'=>0,'info'=>'会员名称已存在，请更换会员名称后再试！');
						}
					}else{
						$res =	$dbMember ->add($dataPost);
						$regtime =	$dbMember ->where('ID = '.$res) ->find();
						// 分享注册二维码
						$QRcodeReg	=	createQR("http://".$_SERVER["SERVER_NAME"]."/index.php/Index/reg/uid/".$res."/from/app",'reg'.$regtime['mid']);
						$qrsrcreg	=	'http://'.$_SERVER["SERVER_NAME"].ltrim($QRcodeReg,'.');
						M('member') ->where('ID='.$res) ->save(array('qrsrcreg' => $qrsrcreg));
						if ($res) {
							$ajxReturn	=	array('status'=>1,'info'=>'会员新增成功！');
						}else{
							$ajxReturn	=	array('status'=>0,'info'=>'会员新增失败！');
						}						
					}
					break;
				
				case 'edit':
					$res	=	$dbMember ->where('id='.$dataPost['id']) ->save($dataPost);
					if ($res) {
						$ajxReturn	=	array('status'=>1,'info'=>'会员编辑成功！');
					}else{
						$ajxReturn	=	array('status'=>0,'info'=>'会员编辑失败！');
					}
					break;
			}
			addlog(MODULE_NAME,ACTION_NAME,$ajxReturn['info']);
			$this->ajaxReturn($ajxReturn);
		}


		// ======================================================================================
		//									红包管理		
		// ======================================================================================

		public function packets()		//升级券红包
		{
			$dbPackets	=	M('packet');
			$packetList	=	$dbPackets ->select();
			$this->assign('packets',$packetList);
			$this->display();
		}

		public function givepkt()		//发升级券红包
		{
			if (IS_POST) {
				$dataPost	=	I('');
				$uid = session('ttcms_uid');
				// 计算出所有红包的随机升级券数，转换为字符串存入数据库中。抢红包时将字符串转换为数组，再随机取出一个成员做为红包所得
				import("ORG.Util.Reward");
				// 引用红包生成随机算法类
				// $reward=new reward();
				// $rewardArr=$reward->splitReward($dataPost['papernum'],$dataPost['nums'],100,1);
				// $dataPost['prandom']	=	implode(',', $rewardArr);
				$totalPaper	=	$dataPost['papernum']*$dataPost['nums'];
				for ($i=0; $i < $dataPost['nums']; $i++) { 
					$prandom	.=	$dataPost['papernum'].',';
				}
				$dataPost['prandom']	=	rtrim($prandom,',');

				$dataPost['UID']	=	$uid;
				$dataPost['papernum']	=	$totalPaper;
				$dataPost['now_papernum']	=	$totalPaper;
				$dataPost['stime']	=	time();
				$res 	=	M('packet') ->add($dataPost);
				$packData	=	array('types'=>'packet','pid'=>$res,'addtime'=>time());
				$ress 	=	M('packetlist') ->add($packData);
				if ($res) {
					pushMsg('有升级券红包啦，快来抢！');		//发送手机推送信息
					$ajxReturn	=	array('status'=>1,'info'=>'升级券红包发放成功！');
				}else{
					$ajxReturn	=	array('status'=>0,'info'=>'升级券红包发放失败！');
				}
				addlog(MODULE_NAME,ACTION_NAME,$ajxReturn['info']);
				$this->ajaxReturn($ajxReturn);
			}else{
				$this->display();
			}
		}

		public function showpkt()		//查看升级券红包
		{
			$pid 	=	I('pid');
			$pactInfo	=	M('packet') ->where('id='.$pid) ->find();
			$this->assign('info',$pactInfo);
			$acceptList	=	M('packetnow') ->where('pid='.$pid) ->select();
			$this->assign('acctotal',count($acceptList));
			$this->assign('list',$acceptList);
			$this->display();
		}

		public function mnypackets()		//现金红包
		{
			$dbPackets	=	M('mnypacket');
			$packetList	=	$dbPackets ->order('ID desc') ->select();
			foreach ($packetList as $key => $value) {
				$pic = M('ad')->where('id = '.$value['adid'])->find();
				$packetList[$key]['banner'] = $pic['thumb'];
				$packetList[$key]['ad'] = $pic['mphoto'];
				$packetlist = M('packetlist')->where('pid = '.$value['ID'])->find();
				$packetList[$key]['ish'] = $packetlist['ish'];
			}
			$this->assign('packets',$packetList);
			$this->display();
		}
		public function mnypacketsnum()		//现金红包
		{
			$dbPackets	=	M('packets');
			$packetList	=	$dbPackets ->select();
			$this->assign('packets',$packetList);
			$this->display();
		}

		public function addmnypacketsnum()		//添加红包数量
		{if (IS_POST) {
				$dataPost	=	I('');

				$dataPost['desc']	=	$dataPost['num'].'个('.$dataPost['mny'].'元)';
				$res 	=	M('packets') ->add($dataPost);
				if ($res) {
					$ajxReturn	=	array('status'=>1,'info'=>'现金红包发放成功！');
				}else{
					$ajxReturn	=	array('status'=>0,'info'=>'现金红包发放失败！');
				}
				addlog(MODULE_NAME,ACTION_NAME,$ajxReturn['info']);
				$this->ajaxReturn($ajxReturn);
			}else{
				$this->display();
			}
		}
		public function editmnypacketsnum()		//修改红包数量
		{
			$dataPost	=	I('');
			$packets 	=	M('packets') ->where('id = '.$dataPost['pid']) ->find();				
			$this->assign('packets',$packets);
			$this->display();
		}
		public function editsnum()		//修改红包数量
		{
			$dataPost	=	I('');
			$dataPost['desc']	=	$dataPost['num'].'个('.$dataPost['mny'].'元)';
			$data = array('num' => $dataPost['num'], 'mny' => $dataPost['mny'], 'desc' => $dataPost['desc']);
			$res 	=	M('packets') ->where('id = '.$dataPost['id']) ->save($data);
			// $a = M()->getLastSql();
			// print_r($a);die;	
			if ($res) {
				$ajxReturn	=	array('status'=>1,'info'=>'修改成功！');
			}else{
				$ajxReturn	=	array('status'=>0,'info'=>'修改失败！');
			}
			addlog(MODULE_NAME,ACTION_NAME,$ajxReturn['info']);
			$this->ajaxReturn($ajxReturn);
		}

		public function onoff()
		{
			$pid 	=	I('pid');
			$statusNow	=	M('packetlist') ->where('pid='.$pid) ->getField('ish');
			$statusNew	=	$statusNow==0?1:0;
			$res 	=	M('packetlist') ->where('pid='.$pid) ->setField('ish',$statusNew);
			if ($res) {
				if($statusNow == 1){
					pushMsg('有现金红包啦，快来抢！');
				}
				
				$ajaxReturn	=	array('status'=>true,'info'=>'切换页面状态成功！');
			}else{
				$ajaxReturn	=	array('status'=>false,'info'=>'切换页面状态失败！');
			}
			addlog(MODULE_NAME,ACTION_NAME,$ajaxReturn['info']);
			$this->ajaxReturn($ajaxReturn);
		}

		public function givemny()		//发现金红包
		{if (IS_POST) {
				$dataPost	=	I('');
				$uid = session('ttcms_uid');
				// 计算出所有红包的随机金额，转换为字符串存入数据库中。抢红包时将字符串转换为数组，再随机取出一个成员做为红包所得
				import("ORG.Util.Reward");
				// 引用红包生成随机算法类
				$reward=new reward();
				$rewardArr=$reward->splitReward($dataPost['money'],$dataPost['nums'],100);
				$dataPost['prandom']	=	implode(',', $rewardArr);

				$dataPost['UID']	=	$uid;
				$dataPost['mny_now']	=	$dataPost['money'];
				$dataPost['stime']	=	time();
				$res 	=	M('mnypacket') ->add($dataPost);
				$packData	=	array('types'=>'mnypacket','pid'=>$res,'addtime'=>time(),'ish'=>1);
				$ress 	=	M('packetlist') ->add($packData);
				if ($res) {
					pushMsg('有现金红包啦，快来抢！');		//发送手机推送信息
					$ajxReturn	=	array('status'=>1,'info'=>'现金红包发放成功！');
				}else{
					$ajxReturn	=	array('status'=>0,'info'=>'现金红包发放失败！');
				}
				addlog(MODULE_NAME,ACTION_NAME,$ajxReturn['info']);
				$this->ajaxReturn($ajxReturn);
			}else{
				$this->display();
			}
		}

		public function showmny()		//查看现金红包
		{
			$pid 	=	I('pid');
			$pactInfo	=	M('mnypacket') ->where('id='.$pid) ->find();
			$this->assign('info',$pactInfo);
			$acceptList	=	M('mnypacketnow') ->where('pid='.$pid) ->select();
			$this->assign('acctotal',count($acceptList));
			$this->assign('list',$acceptList);
			pushMsg('有现金红包啦，快来抢！');		//发送手机推送信息
			$this->display();
		}

		// ==================================================================================================
		// 						会员相关业务管理
		// ==================================================================================================	
		
		public function gift()		//赠送给会员
		{
			$giftList	=	M('gift') ->order('id desc') ->select();
			$this->assign('list',$giftList);
			$this->display();
		}

		public function addgift()
		{
			if (IS_POST) {
				$dataPost	=	I('');
				$memberInfo	=	M('member') ->where('moblie="'.$dataPost['mphone'].'"') ->find();
				if (!$memberInfo) {
					$ajxReturn 	=	$ajxReturn	=	array('status'=>0,'info'=>'会员不存在，请输入正确的手机号！');
					$this->ajaxReturn($ajxReturn);
					die;
				}
				$dataPost['mid']	=	$memberInfo['ID'];
				$dataPost['usrid']	=	session('ttcms_uid');
				$dataPost['addtime']	=	time();
				//增加会员对应的账户余额
				if ($dataPost['gift_tp']==1) {	//现金余额
					$billtp =	'mny';
					$addRes	=	M('member') ->where('ID='.$memberInfo['ID']) ->setInc('mnysum',$dataPost['nums']);
				}else{		//升级券余额
					$billtp	=	'paper';
					$addRes	=	M('member') ->where('ID='.$memberInfo['ID']) ->setInc('quansum',$dataPost['nums']);
				}
				if ($addRes) {
					$billData = array('fromID' => 0,'toID'=>$memberInfo['ID'],'type'=>1,'billtp'=>$billtp,'billnum'=>$dataPost['nums'],'ordid'=>$addRes,'billtime'=>time(),'smark'=>"系统管理员赠送获得升级券(现金)" );
					$billRst	=	M('bill') ->add($billData);	//插入账单记录表
					$recordRes	=	M('gift') ->add($dataPost);
					$ajxReturn 	=	$ajxReturn	=	array('status'=>1,'info'=>'赠送给会员['.$dataPost['mphone'].']成功');
				}else{
					$ajxReturn 	=	$ajxReturn	=	array('status'=>0,'info'=>'赠送给会员['.$dataPost['mphone'].']失败');
				}
				addlog(MODULE_NAME,ACTION_NAME,$ajxReturn['info']);
				$this->ajaxReturn($ajxReturn);
			}else{
				$this->display();
			}
		}

		public function cashlist()		//提现申请列表
		{
			$dbCash	=	M('needmny');
			$cashList = $dbCash ->order('id desc') ->select();
			$rate	=	getBaseConfig('rate');	//提现费率
			foreach ($cashList as $key => $value) {
				$cashList[$key]['mny'] = $value['mny']*(1-$rate/100);
			}
			$this->assign('list',$cashList);
			$this->display();
		}


		public function docash()		//处理提现
		{
			$pid 	=	I('pid');
			$mid 	=	I('mid');
			$res 	=	M('needmny') ->where('id='.$pid) ->setField('status',1);	//更新提现申请的当前状态
			if ($res) {
				pushMsg('您的提现申请已被处理！',$mid);		//发送手机推送信息
				$ajxReturn	=	array('status'=>1,'info'=>'提现处理成功！');
			}else{
				$ajxReturn	=	array('status'=>0,'info'=>'提现处理失败！');
			}
			addlog(MODULE_NAME,ACTION_NAME,$ajxReturn['info']);
			$this->ajaxReturn($ajxReturn);
		}

    public function txfeed()			//提现回复反馈
    {
      if (IS_POST) {
        $dataPost	=	I('');
        $dataPost['txfeed']	=	1;
        $res 	=	M('needmny') ->where('id='.$dataPost['id']) ->save($dataPost);
        $wei = M('needmny') -> where('id='.$dataPost['id']) -> find();
        if ($res) {
          $ajxReturn	=	array('txfeed'=>1,'info'=>'回复成功！','huifu'=>$wei['huifu']);
        }else{
          $ajxReturn	=	array('txfeed'=>0,'info'=>'回复失败！');
        }
        addlog(MODULE_NAME,ACTION_NAME,$ajxReturn['info']);
        $this->ajaxReturn($ajxReturn);
      }else{
        $fid =	I('fid');
        $feedInfo	=	M('needmny') ->where('id='.$fid) ->find();
        $this->assign('info',$feedInfo);
        $this->display();
      }
    }

		public function uplist()		//升级记录
		{
			$upGradeDB	=	M('shengji');
			$upList = $upGradeDB ->order('id desc') ->select();
			$this->assign('list',$upList);
			$this->display();
		}

		public function transeList()		//升级券转账记录
		{
			$transDb	=	M('papertrans');
			$tranList = $transDb ->order('id desc') ->select();
			$this->assign('list',$tranList);
			$this->display();
		}

		public function feedlist()			//反馈信息记录
		{
			$feedDB	=	M('feedback');
			$feedList = $feedDB ->order('id desc') ->select();
			$this->assign('list',$feedList);
			$this->display();
		}

		public function refeed()			//回复反馈
		{	
			if (IS_POST) {
				$dataPost	=	I('');
				$dataPost['status']	=	1;
				$dataPost['dotime']	=	time();
				$dataPost['dousr']	=	session('ttcms_uid');
				$res 	=	M('feedback') ->where('id='.$dataPost['id']) ->save($dataPost);
        $wei = M('feedback') -> where('id='.$dataPost['id']) -> find();
				if ($res) {
					$ajxReturn	=	array('status'=>1,'info'=>'回复成功！','domsg'=>$wei['domsg']);
				}else{
					$ajxReturn	=	array('status'=>0,'info'=>'回复失败！');
				}
				addlog(MODULE_NAME,ACTION_NAME,$ajxReturn['info']);
        $this->ajaxReturn($ajxReturn);
        // dump($ajxReturn);die;
      }else{
				$fid =	I('fid');
				$feedInfo	=	M('feedback') ->where('id='.$fid) ->find();
				$this->assign('info',$feedInfo);
				$this->display();				
			}
		}
		public function rechargelist(){			
			$billDB	=	M('bill');
			$billList = $billDB ->where('type in(10,11)') ->order('id desc') ->select();
			foreach ($billList as $key => $value) {
				if($value['type'] == 10){
					$billList[$key]['desc'] = '充值余额';
				}else{
					$billList[$key]['desc'] = '充值积分';
				}				
			}
			$this->assign('list',$billList);
			$this->display();
		}
	}
?>