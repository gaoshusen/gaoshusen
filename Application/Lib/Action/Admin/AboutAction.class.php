<?php
/**
* 
*/
class AboutAction extends CommonAction
{
	public function aboutlist()
	{
		$list	=	M('aboutus') ->where('webtp<>1') ->order('addtime desc') ->select();			//取出所有不是列表页类型的关于我们页
		$this->assign('list',$list);
		$this->display();
	}

	public function helplist()
	{
		$list	=	M('aboutus') ->where('webtp=1') ->order('addtime desc') ->select();			//取出所有不是列表页类型的关于我们页
		$this->assign('list',$list);
		$this->display();
	}

	public function addweb()
	{	
		$type	=	I('type');
		$this->assign('webTitle','新增内容');
		$this->assign('method','add');
		$this->assign('type',$type);
		$this->display();
	}

	public function editweb()
	{
		$type	=	I('type');
		$this->assign('webTitle','编辑内容');
		$this->assign('method','edit');
		$this->assign('type',$type);
		$mid	=	I('mid');
		$webInfo	=	M('aboutus') ->where('id='.$mid)->find();
		$this->assign('webInfo',$webInfo);
		$this->display('addweb');
	}

	public function delweb()
	{
		$mid 	=	I('mid');
		$res 	=	M('aboutus') ->where('id='.$mid) ->delete();
		if ($res) {
			$ajaxReturn	=	array('status'=>true,'info'=>'删除页面成功！');
		}else{
			$ajaxReturn	=	array('status'=>false,'info'=>'删除页面失败！');
		}
		addlog(MODULE_NAME,ACTION_NAME,$ajaxReturn['info']);
		$this->ajaxReturn($ajaxReturn);
	}

	public function onoff()
	{
		$mid 	=	I('mid');
		$statusNow	=	M('aboutus') ->where('id='.$mid) ->getField('status');
		$statusNew	=	$statusNow==0?1:0;
		$res 	=	M('aboutus') ->where('id='.$mid) ->setField('status',$statusNew);
		if ($res) {
			$ajaxReturn	=	array('status'=>true,'info'=>'切换页面状态成功！');
		}else{
			$ajaxReturn	=	array('status'=>false,'info'=>'切换页面状态失败！');
		}
		addlog(MODULE_NAME,ACTION_NAME,$ajaxReturn['info']);
		$this->ajaxReturn($ajaxReturn);
	}

	public function excute()
	{
		if (IS_POST) {
			$dataPost	=	I('');
			$dbAbout	=	M('aboutus');
			$url 	=	$dataPost['webtp']==0?U('aboutlist'):U('helplist');
			switch ($dataPost['method']) {
				case 'add':
					$dataPost['addtime']	=	time();
					$res 	=	$dbAbout	->add($dataPost);
					if ($res) {
						$ajaxReturn	=	array('status'=>true,'info'=>'新增关于我们页面成功！','data'=>$url);
					}else{
						$ajaxReturn	=	array('status'=>false,'info'=>'新增关于我们页面失败！');
					}
					break;
				
				case 'edit':
					$res 	=	$dbAbout  ->where('id='.$dataPost['id']) ->save($dataPost);
					if ($res) {
						$ajaxReturn	=	array('status'=>true,'info'=>'编辑关于我们页面成功！','data'=>$url);
					}else{
						$ajaxReturn	=	array('status'=>false,'info'=>'编辑关于我们页面失败！');
					}
					break;
			}
			addlog(MODULE_NAME,ACTION_NAME,$ajaxReturn['info']);
			$this->ajaxReturn($ajaxReturn);
			
		}else{
			$this->ajaxReturn("Data error","数据非法",0,'JSON');
		}
	}
}
?>