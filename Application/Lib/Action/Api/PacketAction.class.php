<?php
	header("Access-Control-Allow-Origin:*");
	/**
	* 
	*/
	class PacketAction extends Action
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
		public function getpacket()
		{
			$dataGet	=	I('');
			$page	=	$dataGet['page']?$dataGet['page']:1;
			$mid	=	$dataGet['mid'];
		$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
			$pageSize = 10;
			$pageStart = ($page-1)*$pageSize;
			// 新需求，要求显示全部88888888888888888888888888888888888888888888
			// $lastTime	=	time()	-	24*3600;
			// //取出24小时内红包总个数
			// // $packetNum	=	M('packetlist') ->where('addtime >= '.$lastTime) ->count('id');
			// $packetNum	=	M('packetlist') ->count('id');
			// if ($packetNum<=3) {
			// 	// 如果24小时内红包总个数在3个以内则显示3个最近的红包
			// 	if ($minid>2) {		//APP取第3个以上红包时返回fase
			// 		$packet = false;
			// 	}else{
			// 		$packet =	M('packetlist') ->order('id desc') ->limit($minid,1) ->select();	//从红包总列表中找到红包
			// 	}
			// }else{
			// 	$packet =	M('packetlist') ->where('addtime >= '.$lastTime) ->order('id desc') ->limit($minid,1) ->select();				
			// }
			// 8888888888888888888888888888888888888888888888888888888888888888888
			$packet =	M('packetlist') ->where('ish = 1') ->order('id desc') ->limit($pageStart,$pageSize) ->select();	//从红包总列表中找到红包
			$packet1 =	M('packetlist') ->where('ish = 1') ->select();
			$sum = count($packet1)/$pageSize;
			$sum = ceil($sum);
			// $a=M()->getLastSql();
			// print_r($a);die;
			// echo $lastTime;
			if ($packet) {
				// $packet =	$packet[0];
				// $pacType	=	$packet['types'];
				foreach ($packet as $key => $value) {
					$pacType	=	$value['types'];
					$pacInfo	=	M($pacType) ->where('id='.$value['pid']) ->find();	//取出红包信息
					unset($pacInfo['prandom']);
					//查找用户是否已经领取当前红包
					$isGetten	=	M($pacType.'now') ->where('pid='.$value['pid'].' and acceptID='.$mid) ->find();
					$pacInfo['isGet']	=	$isGetten!=false?"1":"0";

					if($pacInfo['isGet']==0){
						if ($value['types']=='packet') {
							$guang	=	M($value['types']) ->where('id='.$value['pid']) ->find();	//取出剩余升级券数
							$left	=	$guang['now_papernum'];
						}else{
							$guang	=	M($value['types']) ->where('id='.$value['pid']) ->find();	//取出剩余金额
							$left	=	$guang['mny_now'];
						}
						if($left<=0){
							$pacInfo['isGuang'] = 1;
						}else{
							$pacInfo['isGuang'] = 0;
						}
					}else{
						$pacInfo['isGuang'] = 0;
					}

					// $userInfo	=	M('user') ->where('id='.$pacInfo['UID']) ->find();	//取出发包人信息
					// $pacInfo['usrname']	=	$userInfo['nickname'];	//将发包人的相关信息拼入红包输出信息中
					$pacInfo['logo']	=	C('webRoot').$pacInfo['logo'];
					$adid =	$pacInfo['adid'];
					if ($adid=='-1') {		// adid为0表示随机广告
						$adInfo =	M('ad') ->where('e_time>'.time()) ->order('rand()') ->find(); 	//随机取得一条广告
					}else{
						$adInfo	=	M('ad') ->where('id='.$adid) ->find();				
					}
					$pacInfo['ad_url']	=	$adInfo['url'];
					$pacInfo['ad_pic']	=	C('webRoot').$adInfo['mphoto'];
					$pacInfo['banner_pic']	=	C('webRoot').$adInfo['thumb'];
					$pacInfo['types']	=	$pacType;
					$pacInfos['packetlist'][] = $pacInfo;
					$pacInfos['status']	=	true;
				}
				// $pacInfo	=	M($pacType) ->where('id='.$packet['pid']) ->find();	//取出红包信息
				// unset($pacInfo['prandom']);
				// //查找用户是否已经领取当前红包
				// $isGetten	=	M($pacType.'now') ->where('pid='.$packet['pid'].' and acceptID='.$mid) ->find();
				// $pacInfo['isGet']	=	$isGetten!=false?"1":"0";
				// // $userInfo	=	M('user') ->where('id='.$pacInfo['UID']) ->find();	//取出发包人信息
				// // $pacInfo['usrname']	=	$userInfo['nickname'];	//将发包人的相关信息拼入红包输出信息中
				// $pacInfo['logo']	=	C('webRoot').$pacInfo['logo'];
				// $adid =	$pacInfo['adid'];
				// if ($adid==0) {		// adid为0表示随机广告
				// 	$adInfo =	M('ad') ->where('e_time>'.time()) ->order('rand()') ->find(); 	//随机取得一条广告
				// }else{
				// 	$adInfo	=	M('ad') ->where('id='.$adid) ->find();				
				// }
				// $pacInfo['ad_url']	=	$adInfo['url'];
				// $pacInfo['ad_pic']	=	C('webRoot').$adInfo['thumb'];
				// $pacInfo['status']	=	true;
				// $pacInfo['types']	=	$pacType;
			}else{
				$pacInfo['status']	=	false;
			}
			$adv_time	=	getBaseConfig('adv_time');
			$usr_lv 	=	M('member') ->where('ID='.$mid) ->getField('dengji');
			$pacInfos['usr_lv'] 	=	$usr_lv;
			$pacInfos['adv_time'] 	=	$adv_time;
			$pacInfos['sum'] 	=	$sum;
			// print_r($pacInfos);die;
			$this->ajaxReturn($pacInfos);
		}

		public function showpacket()		//显示红包信息
		{
			$pid	=	I('pid');
			$types		=	I('types');
			$mid 	=	I('mid');
		$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
			$bao 	=	I('bao');
			if($bao == 1){				
				$membName	=	getMebInfo($mid);
				$membName['lvImg']	=	getLvImgTitle($membName['dengji']);
				$membName['stime']	=	date('Y-m-d H:i:s',time());
				$this->ajaxReturn($membName);
				die;
			}
			$pacInfo	=	M($types) ->where('id='.$pid) ->find();
			$adid 	=	$pacInfo['adid'];
			$adInfo 	=	M('ad') ->where('id='.$adid) ->find();
			$pacInfo['ad_pic']	=	C('webRoot').$adInfo['mphoto'];
			$pacInfo['ad_url']	=	$adInfo['url'];
			$pacInfo['logo']	=	C('webRoot').$pacInfo['logo'];
			unset($pacInfo['prandom']);
			$getList	=	M($types.'now') ->where('pid='.$pid) ->order('id asc') ->select();
			$getNum 	=	count($getList);
			$pacInfo['getnum']	=	$getNum;
			$usrGetInfo	=	M($types.'now') ->where('pid='.$pid.' and acceptID='.$mid) ->find();
			// echo M($types.'now')->getLastSql();
			$pacInfo['getInfo']	=	$usrGetInfo;
			foreach ($getList as $get) {
				$membName	=	getMebInfo($get['acceptID']);
				$get['getName']	=	$membName['mname'];
				$get['level']	=	$membName['dengji'];
				$get['lvImg']	=	getLvImgTitle($membName['dengji']);
				$get['stime']	=	date('Y-m-d H:i:s',$get['stime']);
				$getMember[]	=	$get;
			}
			$pacInfo['getlist']	=	$getMember;
			$this->ajaxReturn($pacInfo);
		}

		public function acceptpacket()		//抢红包
		{
			$dataPost	=	I('');
			$mid 		=	$dataPost['mid'];		//会员ID
		$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
			$pid		=	$dataPost['pid'];		//红包ID
			$types		=	$dataPost['types'];		//红包种类 升级券、现金
			$bao		=	$dataPost['bao'];		//
			$memberInfo	=	M('member') ->where('ID='.$mid) ->find();
			if($bao == 1){
				$baoRst	=	M('member') ->where('ID='.$mid) ->save(array('bao' => '1'));
				if($baoRst){
					$MemberData= array(
									'mnysum' => array('exp', '`mnysum`+0.88'),
									);
					$mebRst	=	M('member') ->where('ID='.$mid) ->save($MemberData);	//增加用户的余额0.88
					$billData = array('fromID' => 0,'toID'=>$mid,'type'=>0,'billtp'=>'mny','billnum'=>'0.88','ordid'=>999999999,'billtime'=>time(),'smark'=>"抢红包获得现金",'tag'=>1 );
					$billRst	=	M('bill') ->add($billData);	//插入账单记录表					
				}
				$res	=	array('status'=>"1", 'info'=>"恭喜，您抢到红包啦！",'bao'=>'1');
				$this->ajaxReturn($res);
				die;
			}
			// 新需求0级会员可以抢红包
			// if ($memberInfo['dengji']==0) {
			// 	$this->ajaxReturn(array('status'=>'3','info'=>"您的等级为0，不能抢红包哟！"));
			// 	exit;
			// }
			$isGetten	=	M($types.'now') ->where('pid='.$pid.' AND acceptID='.$mid) ->find();	//检测是否已抢过红包
			$gettedNum	=	M($types.'now') ->where('pid='.$pid) ->count('id');	//得到已被领取的红包数量 
			if ($isGetten) {
				$res 	=	array('status'=>"2",'info'=>"您已经抢过啦！");
			}else{
				if ($types=='packet') {
					$packetInfo	=	M($types) ->where('id='.$pid) ->find();	//取出剩余升级券数
					$totalMny	=	$packetInfo['papernum'];
					$left	=	$packetInfo['now_papernum'];
				}else{
					$packetInfo	=	M($types) ->where('id='.$pid) ->find();	//取出剩余金额
					$totalMny	=	$packetInfo['money'];
					$left	=	$packetInfo['mny_now'];
				}

				if ($left<=0) {
					$res 	=	array('status'=>"3",'info'=>"红包已经被抢光啦！");
				}else{
					$totalNum	=	$packetInfo['nums'];		//红包总个数
					$leftNum	=	$totalNum - $gettedNum;		//剩余红包个数

					$res	=	array('status'=>"1", 'info'=>"恭喜，您抢到红包啦！");
					$randomArray	=	explode(',', $packetInfo['prandom']);	//取出剩余的红包分布数组
					$dataNow	=	array('acceptID'=>$mid,'stime'=>time(),'pid'=>$pid);

					if ($leftNum<=1) {		//最后剩余1个红包时，所有金额/升级券全部给出，否则随机给出
						$getNum 	=	$left;

					}else{	
						$getKey 	=	array_rand($randomArray,1);		//随机取出
						$getNum 	=	$randomArray[$getKey];
						$randomArray	=	array_remove($randomArray,$getKey);	//将取得的记录从原记录中删除
						$newRandom	=	implode(',', $randomArray);		//将新的红包分布数组编为字符，后面将存入红包数据库中
					}
					$leftField	=	$types=='packet'?"now_papernum":"mny_now";
					$getField	=	$types=='packet'?"papernum":"getmny";
					$memberField	=	$types=='packet'?"quansum":"mnysum";
					$billtp		=	$types=='packet'?"paper":"mny";
					$dataNow[$getField]	=	$getNum;
					$res[$getField]	=	$getNum;
					$billData = array('fromID' => $packetInfo['UID'],'toID'=>$mid,'type'=>0,'billtp'=>$billtp,'billnum'=>$getNum,'ordid'=>$pid,'billtime'=>time(),'smark'=>"抢红包获得现金",'tag'=>1 );
					$billRst	=	M('bill') ->add($billData);	//插入账单记录表
					$mebRst	=	M('member') ->where('ID='.$mid) ->setInc($memberField,$getNum);	//增加用户的升级券/余额数
					$rst	=	M($types.'now') ->where('pid='.$pid) ->add($dataNow);	//插入抢红包记录
					$rsr	=	M($types)	->where('id='.$pid) ->setField('prandom',$newRandom);		//更新红包的随机分布数据
					$rss	=	M($types)	->where('id='.$pid) ->setDec($leftField,$getNum);		//更新红包剩余额
				}
			}
			$this->ajaxReturn($res);
		}
		public function getQuantum(){		//红包数量钱数
			// $data = array('0' => '100个(1000元)', '1' => '200个(2000元)');
			$data = M('packets') ->select();
			foreach ($data as $key => $value) {
				$num[] = $value['desc'];
			}
			$quansum['status']	=	true;
			$quansum['nums']	=	$num;
			$quansum['list']	=	$data;
			$this->ajaxReturn($quansum);
		}
		public function packetGive(){		//发红包

			if (IS_POST) {
				$mid 	=	I('mid');
		$checkmid = $this->checkuser($mid);
		if(!$checkmid){
			$this->ajaxReturn(array('iscu'=>false,'info'=>"用户不存在,请重新登陆"));
			die;
		}
				$qu 	=	I('qu');
				$sumid	=	I('sumid');
				$onepic 	=	I('onepic');
				$twopic 	=	I('twopic');
				$threepic 	=	I('threepic');


				$packets	=	M('packets') ->where('id='.$sumid) ->find();
				$member	=	M('member') ->where('ID='.$mid) ->find();

				if($packets['mny'] > $member['mnysum']){
					$ajxReturn	=	array('status'=>false,'info'=>'现金红包发放失败！');
					die;
				}

				if($onepic == ''){
					$onepic = C('onepic');
				}
				if($twopic == ''){
					$twopic = C('twopic');
				}
				if($threepic == ''){
					$threepic = C('threepic');
				}

				$adarray = array('thumb' => '/'.$twopic, 
								'addtime' => time(),
								's_time' => time(),
								'e_time' => 4607251200,
								'status' => 1,
								'uid' => '0'.$mid,
								'mphoto' => '/'.$threepic,
								);
				$adid = M('ad')->add($adarray);



				$dataPost['title']	=	$member['mname'];
				$dataPost['logo']	=	'/'.$onepic;
				$dataPost['money']	=	$packets['mny'];
				$dataPost['nums']	=	$packets['num'];
				$dataPost['adid']	=	$adid;

				// 计算出所有红包的随机金额，转换为字符串存入数据库中。抢红包时将字符串转换为数组，再随机取出一个成员做为红包所得
				import("ORG.Util.Reward");
				// 引用红包生成随机算法类
				$reward=new reward();
				$rewardArr=$reward->splitReward($packets['mny'],$packets['num'],100);
				$dataPost['prandom']	=	implode(',', $rewardArr);

				$dataPost['UID']	=	0;
				$dataPost['mid']	=	$mid;
				$dataPost['mny_now']	=	$packets['mny'];
				$dataPost['stime']	=	time();
				$dataPost['status']	=	0;
				$dataPost['smark']	=	$qu;
				$res 	=	M('mnypacket') ->add($dataPost);
				if ($res) {	
					$packData	=	array('types'=>'mnypacket','pid'=>$res,'addtime'=>time(),'ish'=>0);
					$ress 	=	M('packetlist') ->add($packData);				
					$billModle = M('bill');
					$memberModle = M('member');
					// 
					$rr = $memberModle ->where('ID='.$mid) ->setDec('mnysum',$packets['mny']);	//钱数
					$billDataaddneedmny = array('fromID' => $mid,'toID'=>0,'type'=>5,'billtp'=>"mny",'billnum'=>$packets['mny'],'ordid'=>$res,'billtime'=>time(),'smark'=>"发红包所扣除余额",'tag'=>0);
					$billModle ->add($billDataaddneedmny);	//插入账单记录表
					if($rr){
						// pushMsg('有现金红包啦，快来抢！');		//发送手机推送信息
						$ajxReturn	=	array('status'=>ture,'info'=>'现金红包发放成功,请等待审核！');						
					}else{
						$ajxReturn	=	array('status'=>false,'info'=>'现金红包发放失败！');
					}
				}else{
					$ajxReturn	=	array('status'=>false,'info'=>'现金红包发放失败！');
				}
				// addlog(MODULE_NAME,ACTION_NAME,$ajxReturn['info']);
				$this->ajaxReturn($ajxReturn);
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"非法数据提交！"));
			}
		}
	}
?>