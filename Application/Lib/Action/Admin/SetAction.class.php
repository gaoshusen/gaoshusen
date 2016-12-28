<?php
/** 网站设置管理控制器
* 	作者：偷天换芪
*	联系QQ：314820983
*	E-mail:tthq08@163.com
*	网址：www.tthq8.com
*/
	class SetAction extends CommonAction
	{
		public function basic()
		{
			$dbConfig	=	M('config');
			$cofngInfo	=	$dbConfig ->where("config_tag='basic'") ->getField('config_value');	//获取设置数据中标识符为'basic'的设置信息
			$basicArray	=	json_decode($cofngInfo,true);		//将数据库中设置内容的JSON格式转换为数组
			$basicArray['copyrighter']	=	tt_decode($basicArray['copyrighter']);	//将经过加密处理的文本进行解密
			$this->assign($basicArray);

			$rootUrl	=	"./Application/Tpl/Index";	//此处为系统前端模板放置目录
			$tempList	=	scandir($rootUrl);		//扫描目录，得到系统当前所有前端模板名
			$tplArray = array();
			for ($i=0; $i < count($tempList); $i++) { 
				if ($tempList[$i]!="." && $tempList[$i]!="..") {
					array_push($tplArray, $tempList[$i]);
				}
			}
			$this->assign('tplArray',$tplArray);
			$this->display();
		}

		public function savebasic()
		{
			$dataPost	= I('');
			// $dataPost['copyrighter']	=	tt_encode($dataPost['copyrighter']);	//对版本信息文本进行编码处理，方便存入数据库
			unset($dataPost[0]);
			unset($dataPost[1]);
			unset($dataPost[2]);
			$dataJSON	=	json_encode($dataPost);		//将数据组转换为JSON格式的文本
			$dbSet	=	M('config');
			$result	=	$dbSet ->where("config_tag='basic'") ->setField('config_value',$dataJSON);
			if ($result!==false) {
				addlog(MODULE_NAME,ACTION_NAME,'编辑系统基础设置信息成功！');
				$this->ajaxReturn('','提交成功！',1,'json');
			}else
			{
				addlog(MODULE_NAME,ACTION_NAME,'编辑系统基础设置信息失败！');
				$this->ajaxReturn('','提交失败！',0,'json');
			}
		}

		public function mail()
		{
			$dbConfig	=	M('config');
			$mailInfo	=	$dbConfig ->where("config_tag='mail'") ->getField('config_value');	//获取设置数据中标识符为'basic'的设置信息
			$mailArray	=	json_decode($mailInfo,true);		//将数据库中设置内容的JSON格式转换为数组
			$this->assign($mailArray);
			$this->display();
		}

		public function savemail()
		{
			$dataPost	= I('');
			//$dataPost['copyrighter']	=	tt_encode($dataPost['copyrighter']);	//对版本信息文本进行编码处理，方便存入数据库
			$dataJSON	=	json_encode($dataPost);		//将数据组转换为JSON格式的文本
			$dbSet	=	M('config');
			$result	=	$dbSet ->where("config_tag='mail'") ->setField('config_value',$dataJSON);
			if ($result) {
					addlog(MODULE_NAME,ACTION_NAME,'编辑邮箱设置信息成功！');
					$this->ajaxReturn('','提交成功！',1,'json');
				}else
				{
					addlog(MODULE_NAME,ACTION_NAME,'编辑邮箱设置信息失败！');
					$this->ajaxReturn('','提交失败！',0,'json');
				}
		}
	}
?>