<?php
/**
* 
*/
class IndexAction extends Action
{
	public function bridge()
	{
		$appstoreUrl	=	getBaseConfig('appstore');
		$appUrl	=	getBaseConfig('appUrl');
		$this->assign('appstore',$appstoreUrl);
		$this->assign('appurl',$appUrl);
		$this->display();
	}

	public function reg()
	{
		$uid 	=	I('uid');
		$from 	=	I('from');
		$from 	=	$from=='app'?'app':'web';
		$this->assign('from',$from);
		$usrInfo	=	M('member') ->where('ID='.$uid) ->find();
		$uname	=	$usrInfo['mname'];
		$this->assign('uid',$uid);
		$this->assign('uname',$uname);

		$this->display();
	}
  public function scanCode(){
    $this -> display();
  }

	public function index()
	{
		$memberID	=	session('memberID');
		$this->assign('memberID',$memberID);
		$this->display();
	}

	public function login()
	{	
		if (IS_POST) {
			$phone	=	I('phone');
			$pwd	=	md5(I('password'));
			$res	=	M('member') ->where("moblie='".$phone."' and mpwd='".$pwd."'") ->find();
			$loginData	=	array(
				// 'online'=>1,   // 目前登录只为显示data页面，所以暂时不修改登录状态
				'logintime_last'=>time()
				);
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
								 );
			session('memberID',$res['ID']);
			session('member',$ajaxReturn);
			$goUrl	=	U('data');
			if ($res) {
				$this->ajaxReturn(array('status'=>true,'info'=>"登录成功！",'goUrl'=>$goUrl));
			}else{
				$this->ajaxReturn(array('status'=>false,'info'=>"手机号或密码错误，请重试"));
			}
		}else{
			$this->display();
		}		
	}

	public function newsList()
	{
		$this->display();
	}

	public function newsDetail()
	{	
		$nid = I('nid');
		$this->assign('nid',$nid);
		$this->display();
	}

	public function acceptpacket()
	{
		$memberID	=	session('memberID');
		$dataPost	=	I('');
		$mid 		=	$memberID;		//会员ID
		$pid		=	$dataPost['pid'];		//红包ID
		$types		=	$dataPost['types'];		//红包种类 升级券、现金
		if (empty($memberID)) {
			session('goUrl',U('packetresult',array('pid'=>$pid,'types'=>$types)));
			$res 	=	array('status'=>"-1",'info'=>"尚未登录",'url'=>U('login'));
			$this->ajaxReturn($res);
			exit;
		}
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
				$billData = array('fromID' => $packetInfo['UID'],'toID'=>$mid,'type'=>0,'billtp'=>$billtp,'billnum'=>$getNum,'ordid'=>$pid,'billtime'=>time(),'smark'=>"抢红包获得升级券(现金)" );
				$billRst	=	M('bill') ->add($billData);	//插入账单记录表
				$mebRst	=	M('member') ->where('ID='.$mid) ->setInc($memberField,$getNum);	//增加用户的升级券/余额数
				$rst	=	M($types.'now') ->where('pid='.$pid) ->add($dataNow);	//插入抢红包记录
				$rsr	=	M($types)	->where('id='.$pid) ->setField('prandom',$newRandom);		//更新红包的随机分布数据
				$rss	=	M($types)	->where('id='.$pid) ->setDec($leftField,$getNum);		//更新红包剩余额
			}
		}
		$res['url'] = U('packetresult',array('pid'=>$pid,'types'=>$types));
		$this->ajaxReturn($res);
	}

	public function packetresult()
	{
		$memberID	=	session('memberID');
		$dataPost	=	I('');
		$pid		=	$dataPost['pid'];		//红包ID
		$types		=	$dataPost['types'];		//红包种类 升级券、现金
		$this->assign('pid',$pid);
		$this->assign('types',$types);
		$this->assign('mid',$memberID);
		$this->display();
	}

	public function ucenter()
	{
		$memberID	=	session('memberID');
		if (empty($memberID)) {
			session('goUrl',U('ucenter'));
			$this->redirect('Index/login');
			// $this->ajaxReturn($res);
			// exit;
		}else{
			$this->assign('memberID',$memberID);
			$this->display();
		}
	}

	public function mypapers()
	{
		$memberID	=	session('memberID');
		$this->assign('memberID',$memberID);
		$this->display();
	}
	public function account()
	{
		$memberID	=	session('memberID');
		$this->assign('memberID',$memberID);
		$this->display();
	}

	public function aboutus()
	{
		$this->display();
	}

	public function upgrademe()
	{
		$this->display();
	}
	public function data(){
		$mid = session('memberID');
		$minfo = M('member') ->where('ID='.$mid) ->find();
		$dataNum= $this -> getFloorMemberNum($mid);
		$dataSum=0;
		$mnyarray = array('0' => '100','1' => '200','2' => '400','3' => '800' );
		foreach ($dataNum as $key => $value) {
			$dataSum+=$mnyarray[$key]*$value;
		}
		$mnybill = M('bill')->where('toID = '.$mid." and billtp = 'mny'".' and type not in(5,6,7)')->order('id desc')->select();
		// $a = M()->getLastSql();
		// print_r($a);die;
		foreach ($mnybill as $key => $value) {
			$mnybill[$key]['time'] = date('Y-m-d H:i:s',$value['billtime']);	//注册时间
			// 账单类型（0:红包，1:转账，2:提现，3:转账，4:签到，5:升级，6商城券,7:关闭直推奖）
			if($value['type'] == 2){
				$mnybill[$key]['billnum'] = '-'.$value['billnum'];
				$mnybill[$key]['billstatus'] = 0;
			}else{
				$mnybill[$key]['billnum'] = '+'.$value['billnum'];
				$mnybill[$key]['billstatus'] = 1;
			}
			$ar = $this->getTimeWeek($value['billtime']);
			$mnybill[$key]['rq'] = $ar[0];
			$mnybill[$key]['z'] = $ar[1];
		}
		$shopbill = M('bill')->where('toID = '.$mid." and billtp = 'mny'".' and type = 6 ')->order('id desc')->select();
		// $a = M()->getLastSql();
		// print_r($a);die;
		foreach ($shopbill as $key => $value) {
			$shopbill[$key]['time'] = date('Y-m-d H:i:s',$value['billtime']);	//注册时间
			// 账单类型（0:红包，1:转账，2:提现，3:转账，4:签到，5:升级，6商城券,7:关闭直推奖）
			if($value['type'] == 2){
				$shopbill[$key]['billnum'] = '-'.$value['billnum'];
				$shopbill[$key]['billstatus'] = 0;
			}else{
				$shopbill[$key]['billnum'] = '+'.$value['billnum'];
				$shopbill[$key]['billstatus'] = 1;
			}
			$ar = $this->getTimeWeek($value['billtime']);
			$shopbill[$key]['rq'] = $ar[0];
			$shopbill[$key]['z'] = $ar[1];
		}
		// print_r($mnybill);die;
		$this->assign('dataSum',$dataSum);
		$this->assign('minfo',$minfo);
		$this->assign('mnybill',$mnybill);
		$this->assign('shopbill',$shopbill);
		$this->display();
	}	
	function getTimeWeek($time, $i = 0) {
	  $weekarray = array("日","一", "二", "三", "四", "五", "六");
	  $rq=date('m-d',$time);
	  $z = "周" . $weekarray[date("N", $time)];
	  $ar[0] = $rq;
	  $ar[1] = $z;
	  return $ar;
	}
	public function getBillList(){
		$mid = I('mid');
		//账单内容物类型（mny：现金，paper：升级券）
		$billtp = I('billtp');
		// $mid = '56';
		// $billtp = 'mny';
		$mnybill = M('bill')->where('toID = '.$mid." and billtp = '".$billtp."'".' and type not in(5,6,7)')->order('id desc')->select();
		// $a = M()->getLastSql();
		// print_r($a);die;
		foreach ($mnybill as $key => $value) {
			$mnybill[$key]['time'] = date('Y-m-d H:i:s',$value['billtime']);	//注册时间
			// 账单类型（0:红包，1:转账，2:提现，3:转账，4:签到，5:升级，6商城券,7:关闭直推奖）
			if($value['type'] == 2){
				$mnybill[$key]['billnum'] = '-'.$value['billnum'];
			}else{
				$mnybill[$key]['billnum'] = '+'.$value['billnum'];
			}
			$ar = $this->getTimeWeek($value['billtime']);
			$mnybill[$key]['rq'] = $ar[0];
			$mnybill[$key]['z'] = $ar[1];
		}
		// print_r($mnybill);die;
		return $this->ajaxReturn($mnybill);
	}
	function getFloorMemberNum($mid)
	{	
		$firstMembs	=	M('member') ->field('ID,dengji') ->where('pid='.$mid) ->select();
		// dump($firstMembs);
		if ($firstMembs) {
			$firstNums	=	count($firstMembs);
			$back[]	=	$firstNums;
			$first = 0;
			for ($i=0; $i < $firstNums; $i++) { 
				$whereStr	.=	' OR pid='.$firstMembs[$i]['ID'];
				$whereStr	=	ltrim($whereStr,' OR ');
				if($firstMembs[$i]['dengji']>0){
					$first = $first+1;
				}
			}
			$backNum[]	=	$first;
			$secondMembs	=	M('member') ->field('ID,dengji') ->where($whereStr) ->select();
			$back[]	=	count($secondMembs);
			if (count($secondMembs)<=0) {
				$back[]	=	0;
				$back[]	=	0;
				$back[]	=	0;
				return $back;
			}
			$second = 0;
			for ($j=0; $j < count($secondMembs); $j++) { 
				$whereStrA	.=	' OR pid='.$secondMembs[$j]['ID'];
				$whereStrA	=	ltrim($whereStrA,' OR ');
				if($secondMembs[$j]['dengji']>1){
					$second = $second+1;
				}
			}
			$backNum[]	=	$second;
			$thirdMembs	=	M('member') ->field('ID,dengji') ->where($whereStrA) ->select();
			// echo M('member') ->getLastSql();
			$back[]	=	count($thirdMembs);

			if (count($thirdMembs)<=0) {
				$back[]	=	0;
				$back[]	=	0;
				return $back;
			}
			$third=0;
			for ($k=0; $k < count($thirdMembs); $k++) { 
				$whereStrB	.=	' OR pid='.$thirdMembs[$k]['ID'];
				$whereStrB	=	ltrim($whereStrB,' OR ');
				if($thirdMembs[$k]['dengji']>2){
					$third = $third+1;
				}
			}
			$backNum[]	= $third;
			$forthMembs	=	M('member') ->field('ID,dengji') ->where($whereStrB) ->select();
			// echo M('member') ->getLastSql();
			$back[]	=	count($forthMembs);

			if (count($forthMembs)<=0) {
				$back[]	=	0;
				return $back;
			}
			$forth = 0;
			for ($p=0; $p < count($forthMembs); $p++) { 
				$whereStrC	.=	' OR pid='.$forthMembs[$p]['ID'];
				$whereStrC	=	ltrim($whereStrC,' OR ');
				if($forthMembs[$p]['dengji']>3){
					$forth = $forth+1;
				}
			}
			$backNum[]	= $forth;
			return $backNum;
		}else{
			return null;
		}
	}
}
?>