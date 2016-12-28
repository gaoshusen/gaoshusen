<?php

	
	/*
	*	获取网站前端栏目信息
	*	作者：偷天换芪
	*	QQ:314820983
	*/

	
	function GetMenu()
	{
		$lang		=	session("Language_tthq08_web");
		$Menus		=	M("category");
		$MenuInfo	=	$Menus->where('is_show=1 and parentid=0')->order("sort asc")->select(); //取出后台中允许显示的频道
		//dump($MenuInfo);
		
		for ($i=0; $i < count($MenuInfo); $i++) { 
			$MenuInfo[$i]['catnote']=$MenuInfo[$i]['catname'];
			$name = $MenuInfo[$i]['catname'];
			$comm = $MenuInfo[$i]['catabout'];
			if ($lang=="1") {
				$MenuInfo[$i]['catname']=$name;
				$MenuInfo[$i]['catabout']=$comm;
			}else{
				$MenuInfo[$i]['catname']=$comm;
				$MenuInfo[$i]['catabout']=$name;
				}
		}
		
		return $MenuInfo;
	}

	function GetSMenu()
	{
		$lang		=	session("Language_tthq08_web");
		$Menus		=	M("category");
		$MenuInfo	=	$Menus->where('is_show=1 and parentid<>0')->order("sort asc")->select(); //取出后台中允许显示的频道
		for ($i=0; $i < count($MenuInfo); $i++) { 
			//$MenuInfo[$i]['catnote']=$MenuInfo[$i]['catname'];
			$name = $MenuInfo[$i]['catname'];
			$comm = $MenuInfo[$i]['catabout'];
			if ($lang=="1") {
				$MenuInfo[$i]['catname']=$name;
				$MenuInfo[$i]['catabout']=$comm;
			}else{
				$MenuInfo[$i]['catname']=$comm;
				$MenuInfo[$i]['catabout']=$name;
				}
		}
		return $MenuInfo;
	}

	function GetCatPro($Catid='') 	//根据catid获取产品列表
	{
		$Product	=	M("product");
		$ProInfo	=	$Product->where("catid=".$Catid)->order("inputtime desc")->limit(11)->select();
		for ($i=0; $i < count($ProInfo); $i++) { 
			$ShowCode	.=	"<li>
		                        <a class='seeicon' href='".U('Product/show')."?id=".$ProInfo[$i]['id']."' title='".$ProInfo[$i]['title']."'></a>
		                        <a class='imgback' href='".U('Product/show')."?id=".$ProInfo[$i]['id']."' title='".$ProInfo[$i]['title']."'></a>
		                        <a class='img' href='".U('Product/show')."?id=".$ProInfo[$i]['id']."' title='".$ProInfo[$i]['url']."'><img src='".$ProInfo[$i]['thumb']."'></a>
		                        <a class='title' href='".U('Product/show')."?id=".$ProInfo[$i]['id']."' title='".$ProInfo[$i]['url']."'>".$ProInfo[$i]['title']."</a>
		                    </li>";
		}
		//return $ProInfo;
		return $ShowCode;
	}


	function GetCatNews($Catid='') 		//根据catid获取文章列表
	{
		$News 		=	M("news");
		$NewsInfo	=	$News->where("catid=".$Catid)->order("inputtime desc")->limit(5)->select();
		for ($i=0; $i < count($NewsInfo); $i++) { 
			if ($NewsInfo[$i]['thumb']=="no thumb") {
				$ThumbUrl	=	__PUBLIC__."/default/images/default.png";
			}
			else
			{
				$ThumbUrl	=	$NewsInfo[$i]['thumb'];
			}
			$ShowCode	.=	"<h2><span>".date('Y-m-d H:i:s',$NewsInfo[$i]['inputtime'])."</span><a href='".U('News/show')."?id=".$NewsInfo[$i]['id']."'>".$NewsInfo[$i]['title']."</a></h2>
                            <p class='newsnr bor2'>".msubstr($NewsInfo[$i]['description'],0,300)." <a href='".U('News/show')."?id=".$NewsInfo[$i]['id']."' class='more'>更多</a></p>                                                    
                        	";
		}
		return 	$ShowCode;
	}

	function addhits($id='',$tablea='',$fielda='hits')
	{
		$TableName		=	M($tablea);
		$End	= 	$TableName->where("id=".$id)->setInc($fielda);
		return $End;
	}

	function getmnfamily($mid)
	{
		$Menus 		= 	M('category');
		$MenuInfo	=	$Menus ->where('catid='.$mid) ->find();
		$lang		=	session("Language_tthq08_web");
		$MenuBros	=	$Menus ->where('parentid='.$MenuInfo['parentid']) ->select();
		$FaTitle	=	$Menus ->where('catid='.$MenuInfo['parentid']) ->find();
		//dump($FaTitle);
		$MnFamily = array();
		if ($lang == "1") {			
			$MnFamily['me']	=	$MenuInfo['catname'];
			$MnFamily['fa']	=	$FaTitle['catname'];
			$MnFamily['facomm']	=	$FaTitle['catabout'];
			for ($i=0; $i < count($MenuBros); $i++) { 
				$name = $MenuBros[$i]['catname'];
				$mnbrothers[$i]['name'] = $name;
				$mnbrothers[$i]['url'] = $MenuBros[$i]['url'];
			}
			$MnFamily['br']	=	$mnbrothers;

		}else{
			$MnFamily['me']	=	$MenuInfo['catabout'];
			$MnFamily['fa']	=	$FaTitle['catabout'];
			$MnFamily['facomm']	=	$FaTitle['catname'];
			for ($i=0; $i < count($MenuBros); $i++) { 
				$name = $MenuBros[$i]['catabout'];
				$mnbrothers[$i]['name'] = $name;
				$mnbrothers[$i]['url'] = $MenuBros[$i]['url'];
			}
			$MnFamily['br']	=	$mnbrothers;
		}
		return $MnFamily;
	}

?>