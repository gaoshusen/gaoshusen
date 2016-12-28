<?php
	/**
	* 
	*/
	class GroupAction extends CommonAction
	{
		
		public function lists()
		{
			$group	=	M('group');
			$groupList	=	$group->select();
			$this->assign('grouplist',$groupList);
			$this->display('lists');
		}

		public function xiaoyu()
		{
			$pid =	I('pid');
			$gid =	I('gid');
			$pid =	$pid==''?0:$pid;
			$dbUsr	=	M('member');
			$grInfo	=	M('group_recast')->where('gid = '.$gid)->select();
			foreach ($grInfo as $key => $value) {
				$userList[$key]['user']	= $dbUsr ->where('pid='.$pid .' and grid = '.$value['id']) ->select();
			}
			$sum = count($grInfo);
			$num = round(100/$sum,2);
			$this->assign( "grlist", $grInfo );
			$this->assign( "list", $userList );
			$this->assign( "num", $num );
			$this->assign( "gid", $gid );
			$this->display('xiaoyu');
		}

		public function AGroup(){
			$gid = I('gid');
			$re = M('group_recast');
			$record = M('group_recast')->where('gid = '.$gid)->order('`id` desc')->find();
			$data = array();
			$data['name'] = $record['value'].($record['key']+1);
			$data['key'] = $record['key']+1;
			$data['value'] = $record['value'];
			$data['addtime'] = time();
			$data['gid'] = $gid;
			$res = M('group_recast')->add($data);
			if ($res) {
				$url 	=	U("xiaoyu",array("gid"=>$data['gid']));
				$ajxReturn	=	array('status'=>1,'data'=>$url ,'info'=>'新增成功');
			}else{
				$ajxReturn	=	array('status'=>0,'info'=>'新增失败');
			}
			$this->ajaxReturn($ajxReturn);
		}


		public function detail()
		{
			$this->display();
		}

		public function add()
		{
			$title	=	array('father'=>"团队管理");			
			$this->assign('uid',$uid);
			$model_id	=	Y('model');
			$cid 		=	Y('cid');
			$method		=	$cid==''?'add':'edit';		//如果获取的cid为空，则是新增模式，否则为编辑模式
			$this->assign('method',$method);
			$readonly	=	$method=='edit'?'readonly':'';		//如果当前是编辑模式，则输出只读标识，代码模板中有只读限制的自动识别
			$title['this']	=	$method=='edit'?'编辑内容':'新增内容';
			$this->assign('title',$title);
			//$cid 		=	1;
			$model_id = 3;
			$modelInfo	=	M('model') ->where('id='.$model_id)->find();	//取得当前操作的模型数据
			$table_name	=	$modelInfo['table_name'];		//当前操作涉及的数据表
			$this->assign('modelName',$table_name);
			$contentInfo	=	M($table_name) ->where('id='.$cid) ->find();	//如果有接收到cid参数，则取出对应的数据内容
			
			$this->assign('contentInfo',$contentInfo);	

			//取出当前操作的模型的所有字段
			$fieldList	=	M('model_fields') ->where('model_id='.$model_id.' AND status=1') ->order('sort asc') ->select();
			//对每个字段进行处理
			foreach ($fieldList as $field) {

				$fieldType	=	$field['show_type'];	//得到字段绑定的组件

				$tplStr	=	getAdmTpl($fieldType);		//取得组件的代码模板
				$keys	=	array_keys($field);			
				$vals	=	array_values($field);
				$fieldValue	=	$contentInfo[$field['field_name']];
				switch ($fieldType) {		//对特殊字段进行特别处理，以确保下面的字段可以同时出现多个
					case 'img':
						if ($fieldValue=='') {		//组件类型为img 的，如果已有值为空，则显示系统默认图片
							$fieldValue	=	__PUBLIC__.'/ttcms/img/nopic.png';
						}
						$imgArr[]['name']	=	$field['field_name'];
						break;

					case 'key':
						$keyArr[]['name']	=	$field['field_name'];
						break;

					case 'html':
						$htmlArr[]['name']	=	$field['field_name'];
						break;

				}

				$show_value	=	$field['show_value'];	//取得字段的默认内容
				if($show_value!='' && !is_null($show_value))
				{
					if (strpos($show_value,'function')!==false) {		//找到组件选项内容设置了函数的内容
						$funcName	=	explode(':', $show_value);
						$funcName	=	$funcName[1];
						eval("\$funEnd=".$funcName.";");
						$componStr	=	"";				//清除固定内容的select选项标识标签
						$this->assign($field['field_name'],$funEnd);
					}else{			//字段的默认内容为手动设置的固定的内容
						$valArr	=	explode("\n", $show_value);
						switch ($fieldType) {
							case 'radio':
								$comp	=	'<label>
	                                            <input type="radio" value="#compVal#" name="#field_name#" <eq name="contentInfo.#field_name#" value="#compVal#">checked="checked" </eq>> <i></i>#compTitle#
	                                        </label>';
								break;
							
							case 'checkbox':
								$comp 	=	'<label>
	                                            <input type="checkbox" value="#compVal#" name="#field_name#" <eq name="contentInfo.#field_name#" value="#compVal#">checked="checked" </eq>> <i></i> #compTitle#
	                                        </label>';
								break;

							case 'select':
								$tplStr	=	str_replace('<option value="0">----请选择#field_title#----</option>', '', $tplStr);
								$comp 	=	'<option value="#compVal#" <eq name="#field_name#" value="contentInfo.#field_name#">selected="selected"</eq> >#compTitle#</option>';
								break;
						}
						foreach ($valArr as $val) {
							$param	=	explode('|', $val);
							$element	=	str_replace('#compVal#',$param[0],$comp);
							$element	=	str_replace('#compTitle#',$param[1],$element);
							$componStr	.=	$element;
						}
						
					}
				}
				for ($i=0; $i < count($keys); $i++) { 
					$tplStr	=	str_replace('#'.$keys[$i].'#',$vals[$i],$tplStr);
					$tplStr	=	str_replace('#fieldValue#',$fieldValue,$tplStr);
					$tplStr	=	str_replace('#readonly#',$readonly,$tplStr);
					$tplStr	=	str_replace('#component#',$componStr,$tplStr);
					$componStr 	=	"";
				}
				
				$tplHtml	.=	$tplStr;

			}
			$this->assign('imgArr',$imgArr);
			$this->assign('htmlArr',$htmlArr);
			$this->assign('keyArr',$keyArr);

			$this->assign('tplHtml',$tplHtml);
			$HTML = $this->fetch('excute');
			$this->show($HTML);
		}

		public function addSSS()
		{	
			$this->assign('method','add');
			$this->assign('isFull',1);
			$this->assign('windowTitle','新增顶级会员');
			$mid	=	time();
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
			// print_r($memInfo);die;

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
			$dbMember	=	M('member');
			$res 		= $dbMember ->where('id='.$mid) ->delete();
			if ($res) {
				$ajxReturn	=	array('status'=>1,'info'=>'会员删除成功！');
			}else{
				$ajxReturn	=	array('status'=>0,'info'=>'会员删除失败！');
			}
			addlog(MODULE_NAME,ACTION_NAME,$ajxReturn['info']);
			$this->ajaxReturn($ajxReturn);
		}

		public function excute()
		{
			if (IS_POST) {
				$dataPost 	=	I('');
				// $ajaxReturn =	array('data'=>$dataPost['modelName'],'info'=>"非法数据",'status'=>0);
				// $this->ajaxReturn($ajaxReturn);
				// die;
				// print_r($phone);die;
				$res	=	M($dataPost['modelName'])->where("name = '".$dataPost['name']."'")->getField('name');
				// $aaa = M()->getLastSql();
				if($res){
					$ajaxReturn =	array('data'=>'excute Error','info'=>"请勿重复输入团队名称",'status'=>0);
					$this->ajaxReturn($ajaxReturn);
					die;
				}
				
				switch ($dataPost['method']) {
					case 'add':
						$dataPost['addtime'] = time();

						$res	=	M($dataPost['modelName']) ->add($dataPost);
						if($dataPost['modelName'] == 'group' && $res > 0){
							$data = array();
							$data['name'] = $dataPost['name'].'1';
							$data['key'] = 1;
							$data['value'] = $dataPost['name'];
							$data['addtime'] = time();
							$data['gid'] = $res;
							M('group_recast') ->add($data);
						}
						if ($res) {
							// pushMsg('有新消息了，速来围观！');		//发送手机推送信息
							$ajaxReturn =	array('data'=>U('lists'),'info'=>"内容提交成功！",'status'=>1);
						}else{
							$ajaxReturn =	array('data'=>"excute Error",'info'=>"内容提交失败，请重试！",'status'=>0);
						}
						break;
					
					case 'edit':
						$dataPost['editime'] = time();
						// $dataPost['uid']	= session('ttcms_uid');
						$res	=	M($dataPost['modelName']) ->save($dataPost);
						if ($res) {
							// pushMsg('有新消息了，速来围观！');		//发送手机推送信息
							$ajaxReturn =	array('data'=>U('lists'),'info'=>"内容提交成功！",'status'=>1);
						}else{
							$ajaxReturn =	array('data'=>"excute Error",'info'=>"内容提交失败，请重试！",'status'=>0);
						}
						break;
				}
				
			}else{
				$ajaxReturn =	array('data'=>"author Error",'info'=>"非法数据",'status'=>0);
			}
			addlog(MODULE_NAME,ACTION_NAME,$ajaxReturn['info']);
			$this->ajaxReturn($ajaxReturn);
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
					// pushMsg('有升级券红包啦，快来抢！');		//发送手机推送信息
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
			$packetList	=	$dbPackets ->select();
			$this->assign('packets',$packetList);
			$this->display();
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
				$packData	=	array('types'=>'mnypacket','pid'=>$res,'addtime'=>time());
				$ress 	=	M('packetlist') ->add($packData);
				if ($res) {
					// pushMsg('有现金红包啦，快来抢！');		//发送手机推送信息
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
			// pushMsg('有现金红包啦，快来抢！');		//发送手机推送信息
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
			$this->assign('list',$cashList);
			$this->display();
		}

		public function docash()		//处理提现
		{
			$pid 	=	I('pid');
			$mid 	=	I('mid');
			$res 	=	M('needmny') ->where('id='.$pid) ->setField('status',1);	//更新提现申请的当前状态
			if ($res) {
				// pushMsg('您的提现申请已被处理！',$mid);		//发送手机推送信息
				$ajxReturn	=	array('status'=>1,'info'=>'提现处理成功！');
			}else{
				$ajxReturn	=	array('status'=>0,'info'=>'提现处理失败！');
			}
			addlog(MODULE_NAME,ACTION_NAME,$ajxReturn['info']);
			$this->ajaxReturn($ajxReturn);
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
				if ($res) {
					$ajxReturn	=	array('status'=>1,'info'=>'回复成功！');
				}else{
					$ajxReturn	=	array('status'=>0,'info'=>'回复失败！');
				}
				addlog(MODULE_NAME,ACTION_NAME,$ajxReturn['info']);
				$this->ajaxReturn($ajxReturn);
			}else{
				$fid =	I('fid');
				$feedInfo	=	M('feedback') ->where('id='.$fid) ->find();
				$this->assign('info',$feedInfo);
				$this->display();				
			}
		}
	}
?>