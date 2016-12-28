<?php
	/**
	* TTCMS V2.0 基础控制类
	* 	作者：偷天换芪
	*	联系QQ：314820983
	*	E-mail:tthq08@163.com
	*	网址：www.tthq8.com
	*/
	class CommonAction extends Action
	{
		
		function _initialize()
	    {
	    	if (session('ttcms_uid')=="") {		// 根据session 的状态来判定用户是否已登录
	    		$this->error('会话已超时，请重新登录',__GROUP__);
	    		$this->ajaxReturn('session error','会话已超时，请重新登录',0,'JSON');
	    	}else{
	    		$Mid 	=	getMid(MODULE_NAME,ACTION_NAME);
	    		$is_allow	=	getAllow($Mid); //获取当前功能的权限放开状态，为0则为管控权限，再进行权限验证
	    		if ($is_allow==0) {		//	根据session的值来确定用户是否具有对应模块方法的权限
		    		$isAllow	= ckpower(session('ttcms_rid'),$Mid);
		    		if (!$isAllow) {
		    			wrtlog(session('ttcms_usr'),'非法访问，权限不足！',MODULE_NAME,ACTION_NAME);
		    			$this->error('权限不足，无法操作！');
		    			$this->ajaxReturn('author error','权限不足，无法操作！',0,'JSON');
		    		}
	    		}
	    	}	
	    }
	}
?>