<?php
	header("Access-Control-Allow-Origin:*");
	/**
	* 
	*/
	class NewsAction extends Action
	{
		public function getnewslist()
		{
			$dataGet	=	I('');
			$minid	=	$dataGet['minid'] ? $dataGet['minid'] : 0;
			$maxid	=	$dataGet['maxid'];
			$newslist =	M('news') ->field('id,title,addtime,description') ->order('addtime asc') ->limit($minid,8) ->select();	//从新闻列表中找到
			if ($newslist) {
				foreach ($newslist as $news) {
					$news['addtime'] =	date("Y-m-d",$news['addtime']);	
					$newsLst[] =	$news;
				}
				$res['list']	=	$newsLst;
				$res['status'] 	=	true;
			}else{
				$res 	=	array('status'=>false,"info"=>'没有数据...');
			}
			$this->ajaxReturn($res);
		}

		public function shownews()
		{
			$newsId	=	I('nid');
			$newsInfo	=	M('news') ->where('id='.$newsId) ->find();
			if ($newsInfo) {
				$newsInfo['addtime']	=	date("Y-m-d H:i:s",$newsInfo['addtime']);
				$newsInfo['content']	=	stripslashes(htmlspecialchars_decode($newsInfo['content']));
				$res['infos']	=	$newsInfo;
				$res['status'] 	=	true;
			}else{
				$res 	=	array('status'=>false,"info"=>'没有数据...');
			}
			$this->ajaxReturn($res);
		}

		public function show_news()
		{
			$newsId	=	I('nid');
			$newsInfo	=	M('aboutus') ->where('id='.$newsId) ->find();
			if ($newsInfo) {
				$newsInfo['addtime']	=	date("Y-m-d H:i:s",$newsInfo['addtime']);
				$newsInfo['content']	=	stripslashes(htmlspecialchars_decode($newsInfo['content']));
				$res['infos']	=	$newsInfo;
				$res['status'] 	=	true;
			}else{
				echo '没有数据...';
			}
			// dump($res);
			$this->assign($res);
			$this->display();
		}

	}
?>