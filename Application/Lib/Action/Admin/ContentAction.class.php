<?php
	/** 文章管理控制器
	* 	作者：偷天换芪
	*	联系QQ：314820983
	*	E-mail:tthq08@163.com
	*	网址：www.tthq8.com
	*/

	class ContentAction extends CommonAction
	{
		public function add()
		{
			$title	=	array('father'=>"内容管理");			
			$this->assign('uid',$uid);
			$model_id	=	Y('model');
			$cid 		=	Y('cid');
			$method		=	$cid==''?'add':'edit';		//如果获取的cid为空，则是新增模式，否则为编辑模式
			$this->assign('method',$method);
			$readonly	=	$method=='edit'?'readonly':'';		//如果当前是编辑模式，则输出只读标识，代码模板中有只读限制的自动识别
			$title['this']	=	$method=='edit'?'编辑内容':'新增内容';
			$this->assign('title',$title);
			//$cid 		=	1;

			$modelInfo	=	M('model') ->where('id='.$model_id)->find();	//取得当前操作的模型数据
			$table_name	=	$modelInfo['table_name'];		//当前操作涉及的数据表
			$this->assign('modelName',$table_name);
			$contentInfo	=	M($table_name) ->where('id='.$cid) ->find();	//如果有接收到cid参数，则取出对应的数据内容

			$this->assign('contentInfo',$contentInfo);	

			//取出当前操作的模型的所有字段
			$fieldList	=	M('model_fields') ->where('model_id='.$model_id.' AND status=1') ->order('sort asc') ->select();
			// echo M('model_fields') ->getLastSql();
			// dump($fieldList);
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


		public function lists()
		{	
			$uid = session('ttcms_uid');
			$newsList	=	M('news') ->where('uid='.$uid) ->order('addtime desc') ->select();
			$this->assign('list',$newsList);
			$this->display();
		}

		public function edit()
		{
			$nid	=	I('nid');
			$info 	=	M('news') ->where('id='.$nid) ->find();
			$this->assign('contentInfo',$info);
			$this->display();
		}

		public function del()
		{
			$nid	=	I('nid');
			$res	=	M('news') ->where('id='.$nid) ->delete();
			if ($res) {
				$ajaxReturn =	array('data'=>U('lists'),'info'=>"新闻删除成功！",'status'=>1);
			}else{
				$ajaxReturn =	array('data'=>"excute Error",'info'=>"新闻删除失败，请重试",'status'=>0);
			}
			addlog(MODULE_NAME,ACTION_NAME,$ajaxReturn['info']);
			$this->ajaxReturn($ajaxReturn);
		}

		public function excute()
		{
			if (IS_POST) {
				$dataPost 	=	I('');
				$dataPost['s_time']	=	strtotime($dataPost['s_time']);
				$dataPost['e_time']	=	strtotime($dataPost['e_time']);
				switch ($dataPost['method']) {
					case 'add':
						$dataPost['addtime'] = time();
						$dataPost['uid']	= session('ttcms_uid');
						$res	=	M($dataPost['modelName']) ->add($dataPost);
						if ($res) {
							pushMsg('有新消息了，速来围观！');		//发送手机推送信息
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
							pushMsg('有新消息了，速来围观！');		//发送手机推送信息
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

		public function uploadpic()		//单图上传
		{
		    if (!empty($_FILES)) {
		        import('ORG.Net.UploadFile');
				$upload		= 	new UploadFile();// 实例化上传类
		        $upload->maxSize = 2048000;
		        $upload->allowExts = array('jpg','jpeg','gif','png');
		        $upload->savePath = './Upload/image/';// 设置附件上传目录
		        $upload->saveRule = "time" ;  //设置上传文件的保存规则为时间
				$upload->autoSub  =	true;	//是否使用子目录保存上传文件
				$upload->subType  = 'date'; //设置子目录创建方式为date
				$upload->dateFormat = "Ymd"; //指定子目录名的日期格式
		        //$upload->thumbRemoveOrigin = true; //删除原图
		        if(!$upload->upload()){
		            $this->error($upload->getErrorMsg());//获取失败信息
		        } else {
		            $info = $upload->getUploadFileInfo();//获取成功信息
		        }
		        echo '_' . $info[0]['savename'];    //返回文件名给JS作回调用
		    }
		}

		public function uploadpics(){   //多图上传模块
	        if (!empty($_FILES)) {
	            import("ORG.Net.UploadFile");
	            import("ORG.Util.Image");
				$MaxSize 	=	2048000;
				$AllExt 	=	array('jpg','jpeg','gif','png');
				$AuSub 		=	true;
				$SubTp 		=	'date';
				$DataFor 	=	'Ymd';


	            $upload = new UploadFile(); // 实例化上传类
	            $upload->maxSize  =  $MaxSize;// 设置附件上传大小
	            $upload->saveRule = time()."_".rand(); 
	            //多图上传，由于是同时上传，所以时间参数是一致的，将导致文件名一致，使文件被覆盖。所以需要加入随机参数。
				$upload->uploadReplace = true;
	           	$upload->allowExts  = $AllExt;// 设置附件上传类型
	            $upload->savePath =  './Upload/product/';// 设置附件上传目录
	            $upload->autoSub  =	$AuSub;	//是否使用子目录保存上传文件
				$upload->subType  = $SubTp; //设置子目录创建方式为date
				$upload->dateFormat = $DataFor; //指定子目录名的日期格式
				 if (!$upload->upload()) { // 上传错误提示错误信息
					$error['message'] = $upload->getErrorMsg();
	                $error['status'] = 0;
				    echo json_encode($error);
	                exit;
	            } else {
	                // 上传成功 获取上传文件信息
	                $info = $upload->getUploadFileInfo();
	                $info[0]['file'] = trim($info[0]['savepath'].$info[0]['savename'],'.');
	                //echo json_encode(stripslashes($info[0]));
				//exit(stripslashes(json_encode($info[0])));
					echo stripslashes(json_encode($info[0]['file']));
					// echo stripslashes(json_encode($info[0]));
	                exit;
	            }
	        }
		}


	}
?>