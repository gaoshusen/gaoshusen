<?php
	/**
	* 
	*/
	class AdAction extends CommonAction
	{
		public function lists()
		{
			$uid = session('ttcms_uid');
			$newsList	=	M('ad') ->where('uid='.$uid) ->order('addtime desc') ->select();
			$this->assign('list',$newsList);
			$this->display();
		}

		public function edit()
		{
			$nid	=	I('nid');
			$info 	=	M('ad') ->where('id='.$nid) ->find();
			$this->assign('contentInfo',$info);
			$this->display();
		}

		public function del()
		{
			$nid	=	I('nid');
			$res	=	M('ad') ->where('id='.$nid) ->delete();
			if ($res) {
				$ajaxReturn =	array('data'=>U('lists'),'info'=>"广告删除成功！",'status'=>1);
			}else{
				$ajaxReturn =	array('data'=>"excute Error",'info'=>"广告删除失败，请重试",'status'=>0);
			}
			addlog(MODULE_NAME,ACTION_NAME,$ajaxReturn['info']);
			$this->ajaxReturn($ajaxReturn);
		}
	}
?>