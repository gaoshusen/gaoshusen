<?php

/** 管理员后台系统设置控制器
* 	作者：偷天换芪
*	联系QQ：314820983
*	E-mail:tthq08@163.com
*	网址：www.tthq8.com
*/
class SysAction extends CommonAction
{
	public function icons()		//加载选择图标功能
	{
		$dbico	= M('icons');
		$iconList	= $dbico ->select();
		$this->assign('iconList',$iconList);
		$this->display();
	}

	public function logs()		//系统日志
	{
		$uid = session('ttcms_uid');
		$dbUsr	=	M('user');
		$usrInfo	=	$dbUsr ->where('id='.$uid) ->find();
		$rid 		= $usrInfo['rid'];
		if ($rid==0) {
			$whereString = "id>0";
		}else{
			$whereString = "usr='".$usrInfo['username']."'";
		}

		$dbLog	=	M('log');
		$logData	=	$dbLog ->where($whereString) ->order('id desc') ->select();

		$this->assign('logInfo',$logData);
		$this->display();
	}

	public function logsdel()	//批量删除日志
	{
		$lidArray	= I('check');
		$dbLog	=	M('log');
		$lidNum		= count($lidArray);
		for ($i=0; $i < $lidNum; $i++) { 	//循环处理每条选中的日志记录
			$delEnd	=	$dbLog ->where('id='.$lidArray[$i]) ->delete();
			if ($delEnd) {
				$j += 1;
			}
		}

		if ($j<$lidNum) {
			addlog(MODULE_NAME,ACTION_NAME,"日志批量删除失败！");
			$this->ajaxReturn('','有部分或全部日志删除失败！',0,'json');
		}else{
			addlog(MODULE_NAME,ACTION_NAME,"日志批量删除成功！");
			$this->ajaxReturn(U('logs'),'日志批量删除成功！',1,'json');
			}
	}

	public function logclear()	//清空日志
	{
		$uid = session('ttcms_uid');
		$dbUsr	=	M('user');
		$usrInfo	=	$dbUsr ->where('id='.$uid) ->find();
		$rid 		= $usrInfo['rid'];
		if ($rid==0) {
			$whereString = "id>0";
		}else{
			$whereString = "usr='".$usrInfo['username']."'";
		}

		$dbLog	=	M('log');
		$clearEnd	=	$dbLog	->where($whereString) ->delete();
			
		if (!$clearEnd) {
			addlog(MODULE_NAME,ACTION_NAME,"日志清空失败！");
			$this->ajaxReturn('','日志清空失败，请重试！',0,'json');
		}else{
			addlog(MODULE_NAME,ACTION_NAME,"日志清空成功！");
			$this->ajaxReturn(U('logs'),'日志清空成功！',1,'json');
    		}
	}
}
?>