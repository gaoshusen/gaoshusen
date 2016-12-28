<?php
	/** 系统内容模型管理控制器
	* 	作者：偷天换芪
	*	联系QQ：314820983
	*	E-mail:tthq08@163.com
	*	网址：www.tthq8.com
	*/
	class ModulAction extends CommonAction
	{
		public function lists()			//模型管理/列表
		{	
			$modelLst	=	M('model') ->select();
			$this->assign('modelList',$modelLst);
			$this->display();
		}

		public function add()			//新增模型
		{
			$dbPrex	=	C('DB_PREFIX');
			$this->assign('dbPrex',$dbPrex);
			$this->assign('windowTitle',"新增模型");
			$this->assign('isFull','1');	//当页面为直接加载时 isFull设为1 ，在弹出层中加载时，isFull设为0
			$this->assign('method','add');		//输出操作方式标识 
			$this->display('excute');
		}

		public function edit()			//编辑模型
		{
			$dbPrex	=	C('DB_PREFIX');
			$this->assign('dbPrex',$dbPrex);
			$mid =	I('mid');
			$modelInfo	=	M('model') ->where('id='.$mid) ->find();
			$this->assign('modelInfo',$modelInfo);
			$this->assign('isFull','0');	//当页面为直接加载时 isFull设为1 ，在弹出层中加载时，isFull设为0
			$this->assign('windowTitle',"编辑模型");
			$this->assign('method','edit');		//输出操作方式标识 
			$this->display('excute');
		}

		public function execution()		//执行操作
		{
			$dataPost	=	I('');
			$table_name	=	C('DB_PREFIX').$dataPost['table_name'];
			$dbModel	=	M('model');
			switch ($dataPost['method']) {
				case 'add':
					$basciFields	= $this	->getBasicFields($table_name,$dataPost['title']);
					$fieldArray	=	$basciFields['fields'];		//所有模式共有字段
					$dbField	=	M('model_fields');
					$isNow	=	$dbModel ->where("mark='".$dataPost['mark']."' OR table_name='".$dataPost['table_name']."'") ->find();
					if ($isNow) {
						$this->ajaxReturn('model is exists','模型标识或模型数据表已存在，请检查无误后再重试！',0,'JSON');
					}else{
						$resAdd		=	$dbModel ->add($dataPost);
						if ($resAdd) {
							foreach ($fieldArray as $field) {
								$fieldData	=	array(	'field_name' => $field['field_name'],
														'field_title' => $field['field_title'],
														'field_type' => $field['field_type'],
														'field_value' => $field['field_value'],
														'field_length' => $field['field_length'],
														'field_tip' => $field['field_title'],
														'show_type' => $field['show_type'],
														'model_id' => $resAdd,
														'is_sys' => 1,
														'status' => 1,
														'sort' => 0,
														);
								$resField	=	$dbField ->add($fieldData);
								if (!$resField) {
									$this->ajaxReturn('add field fail','插入基础字段['.$field['field_title'].']失败',0,'JSON');
									exit();
								}
							}
							//创建表
							$sqlStr 	=	$basciFields['sqlstr'];
							$tableDo	=	D();
							$res	=	$tableDo->execute($sqlStr);
							if ($res===false) {
								$back 	=	array('status'=>0,'info'=>'创建模型['.$dataPost['table_name'].']表失败！');
								// $this->ajaxReturn('create table fail','创建模型表失败',0,'JSON');
							}else{
								$back 	=	array('status'=>1,'info'=>'创建模型['.$mdName.']删除成功！！');
								// $this->ajaxReturn('','创建模型表成功',1,'JSON');
							}
						}else{
							$back 	=	array('status'=>0,'info'=>'插入模型表数据失败！');
							// $this->ajaxReturn('add recorder fail','插入模型表数据失败',0,'JSON');
						}						
					}
					break;

				case 'edit':
					$res 	=	$dbModel ->where('id='.$dataPost['id']) ->save($dataPost);
					if ($res) {
						$back 	=	array('status'=>1,'info'=>'编辑模型['.$dataPost['title'].']成功！！','data'=>U('lists'));
					}else{
						$back 	=	array('status'=>0,'info'=>'编辑模型['.$dataPost['title'].']失败！');
					}					
					break;
				
			}
			addlog(MODULE_NAME,ACTION_NAME,$back['info']);
			$this->ajaxReturn($back);
			 // dump($sqlStr);
		}

		public function getBasicFields($tableName,$tableDes)
		{
			$fieldsArr = array(
							array('field_name'=>'title','field_title'=>'标题','field_type'=>'VARCHAR','field_value'=>'','empty'=>'NULL','field_length'=>255,'show_type'=>'input'),
							array('field_name'=>'thumb','field_title'=>'缩略图','field_type'=>'VARCHAR','field_value'=>'','empty'=>'NULL','field_length'=>255,'show_type'=>'img'),
							array('field_name'=>'seo_title','field_title'=>'SEO标题','field_type'=>'VARCHAR','field_value'=>'','empty'=>'NULL','field_length'=>255,'show_type'=>'input'),
							array('field_name'=>'seo_des','field_title'=>'SEO描述','field_type'=>'TEXT','empty'=>'NULL','field_length'=>'','show_type'=>'input'),
							array('field_name'=>'seo_key','field_title'=>'SEO关键词','field_type'=>'VARCHAR','empty'=>'NULL','field_length'=>255,'show_type'=>'key'),
							array('field_name'=>'description','field_title'=>'简述','field_type'=>'TEXT','empty'=>'NULL','field_length'=>'','show_type'=>'textarea'),
							array('field_name'=>'content','field_title'=>'内容','field_type'=>'TEXT','empty'=>'NULL','field_length'=>'','show_type'=>'html'),
							array('field_name'=>'hits','field_title'=>'点击数','field_type'=>'INT','field_value'=>'0','empty'=>'NOT NULL','field_length'=>6,'show_type'=>'sys'),
							array('field_name'=>'addtime','field_title'=>'发布时间','field_type'=>'INT','field_value'=>'0','empty'=>'NOT NULL','field_length'=>11,'show_type'=>'sys'),
							array('field_name'=>'editime','field_title'=>'编辑时间','field_type'=>'INT','field_value'=>'0','empty'=>'NULL','field_length'=>11,'show_type'=>'sys'),
							array('field_name'=>'sort','field_title'=>'排序序号','field_type'=>'INT','field_value'=>'0','empty'=>'NULL','field_length'=>11,'show_type'=>'sys'),
							);
			// $sqlStr	=	'DROP TABLE IF EXISTS `'.$tableName.'`;';
			$sqlStr =	'CREATE TABLE `'.$tableName.'` (';
			$sqlStr	.=	'`id` int(10) NOT NULL AUTO_INCREMENT,';
			foreach ($fieldsArr as $fields) {
				if ($fields["field_value"]=='') {
					$defaultValue	=	'';
				}else{
					$defaultValue	=	"DEFAULT '".$fields["field_value"]."'";
				}

				if ($fields['field_length']!='') {
					$field_length = "(".$fields['field_length'].")";
				}else{
					$field_length = '';
				}
				$sqlStr .= "`".$fields["field_name"]."` ".$fields["field_type"].$field_length." ".$defaultValue." ".$fields["empty"]." COMMENT '".$fields["field_title"]."',";
			}
			$sqlStr	.=	'PRIMARY KEY (`id`)';
			$sqlStr	.=	") ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='".$tableDes."[创建模型时系统创建的表]';";
			$backData	=  array('sqlstr'=>$sqlStr,'fields'=>$fieldsArr);
			return $backData;
		}

		public function del()			//删除模型
		{
			$mid =	I('mid');
			$dbModel	=	M('model');
			$modelInfo	=	$dbModel ->where('id='.$mid) ->find();
			if ($modelInfo) {	//验证模型是否存在
				$tbName =	$modelInfo['table_name'];
				$mdName =	$modelInfo['title'];
				$rows 	=	M($tbName) ->select();
				if ($rows>0) {	
					// 检查模型绑定的数据表是否还有数据存在，如有数据存在不允许删除模型
					$back 	=	array('status'=>0,'info'=>'模型数据表['.$tbName.']仍有数据，请清空表数据后再删除模型！');
				}else{
					// 执行删除数据表动作
					$sqlStr 	=	"drop table ".C('DB_PREFIX').$tbName;
					$tableDo	=	D();
					$res	=	$tableDo->execute($sqlStr);
					//dump($res);
					if ($res!==false) {
						$resField	=	M('model_fields') ->where('model_id='.$mid) ->delete();	//删除字段表中的数据
						if ($resField===false) {
							$back 	=	array('status'=>0,'info'=>'删除模型['.$mdName.']相关字段数据失败！');
						}else{
							$ress	=	$dbModel ->where('id='.$mid) ->delete();
							$back 	=	array('status'=>1,'info'=>'模型['.$mdName.']删除成功！！','data'=>U('lists'));
						}
					}else{
						$back 	=	array('status'=>0,'info'=>'删除模型数据表['.$tbName.']失败！');
					}
				}
			}else{
				$back 	=	array('status'=>0,'info'=>'模型['.$mdName.']不存在，无法删除！');
			}
			addlog(MODULE_NAME,ACTION_NAME,$back['info']);
			$this->ajaxReturn($back);
		}

		public function checktoppsw()		//验证系统最高权限密码
		{
			$psw	=	I('psw');
			$pswTop	=	C('TOP_PASSWORD');
			if ($pswTop==md5($psw)) {
				$back = array('status'=>1);
			}else{
				$back = array('status'=>0);
			}
			$this->ajaxReturn($back);
		}


		//====================================================================================================
		public function fieldsMng()		//字段管理
		{
			$mid =	I('mid');
			// $isSys =I('show');
			// $isSys = $isSys==''?0:$isSys; //如果没有传入show参数，则设定为0
			// $isSys = $isSys==0?1:0;			//切换show状态
			// $isShow = $isSys==1?' and is_sys=0':'';	
			// $this->assign('sysShow',$isSys);
			$this->assign('mid',$mid);
			$fieldsList	=	M('model_fields') ->where('model_id='.$mid.$isShow) ->order('sort asc') ->select();
			$this->assign('fieldList',$fieldsList);
			$this->assign('windowTitle',"字段管理");
			$this->assign('isFull','0');	//当页面为直接加载时 isFull设为1 ，在弹出层中加载时，isFull设为0
			$this->display();
		}

		public function fieldsAdd()		//新增字段
		{
			$mid 	=	I('mid');
			$modelTitle = M('model') ->where('id='.$mid) ->getField('title');
			$this->assign('model_id',$mid);
			$this->assign('model_name',$modelTitle);
			$this->assign('windowTitle',"新增字段");
			$this->assign('isFull','0');	//当页面为直接加载时 isFull设为1 ，在弹出层中加载时，isFull设为0
			$this->assign('method','add');		//输出操作方式标识 
			$this->display('fieldexcute');
		}

		public function fieldsDel()		//删除字段
		{
			$fid = I('fid');
			$fieldInfo	=	M('model_fields') ->where('id='.$fid) ->find();
			$model_id 	=	$fieldInfo['model_id'];
			$field_name	=	$fieldInfo['field_name'];
			$table_name	=	M('model')->where('id='.$model_id)->getField('table_name');

			// 执行删除字段动作
			$sqlStr 	=	"ALTER TABLE ".C('DB_PREFIX').$table_name." DROP COLUMN ".$field_name;
			$tableDo	=	D();
			$res	=	$tableDo->execute($sqlStr);
			if ($res!==false) {
				$resField	=	M('model_fields') ->where('id='.$fid) ->delete();	//删除字段表中的数据
				if ($resField===false) {
					$back 	=	array('status'=>0,'info'=>'删除模型字段表中的字段['.$field_name.']数据失败！');
				}else{
					$back 	=	array('status'=>1,'info'=>'字段['.$field_name.']删除成功！！','data'=>U('fieldsMng',array('mid'=>$model_id,'show'=>0)));
				}
			}else{
				$back 	=	array('status'=>0,'info'=>'删除模型数据表['.$tbName.']的字段['.$field_name.']失败！');
			}
			addlog(MODULE_NAME,ACTION_NAME,$back['info']);
			$this->ajaxReturn($back);
		}

		public function changestatus()	//切换字段状态
		{
			$fid 	=	I('fid');
			$dbField 	=	M('model_fields');
			$fieldInfo 	=	$dbField ->where('id='.$fid) ->find();
			$statuNew = $fieldInfo['status']==1?0:1;

			$res 	=	$dbField ->where('id='.$fid) ->setField('status',$statuNew);
			if ($res!==false) {
				$back 	=	array('status'=>1,'info'=>'切换字段['.$fieldInfo['field_name'].']状态成功！！','data'=>U('fieldsMng','mid='.$fieldInfo['model_id']));
			}else{
				$back = array('status' => 0,'info'=>'切换字段['.$fieldInfo['field_name'].']状态失败！！' );
			}
			addlog(MODULE_NAME,ACTION_NAME,$back['info']);
			$this->ajaxReturn($back);
		}

		public function sortfield()  	//设置字段排序
		{
			$dataSort	= I('rid');
			$dataMid	= I('fid');
			$dbField		=	M('model_fields');
			$fieldInfo 	=	$dbField ->where('id='.$dataMid) ->find();
			$end 		=	$dbField ->where('id='.$dataMid) ->setField('sort',$dataSort);
			if ($end!==false) {
				$back 	=	array('status'=>1,'info'=>'字段['.$fieldInfo['field_name'].']更新排序成功！！','data'=>U('fieldsMng','mid='.$fieldInfo['model_id']));
			}else{
				$back = array('status' => 0,'info'=>'字段['.$fieldInfo['field_name'].']更新排序失败！！' );
			}
			addlog(MODULE_NAME,ACTION_NAME,$back['info']);
			$this->ajaxReturn($back);
		}

		public function fieldsExcut()	//字段操作执行
		{
			$dataPost 	=	I('');
			// 取出模型的数据表名
			$model_table = M('model') ->where('id='.$dataPost['model_id']) ->getField('table_name');

			// 给表名拼接上表前缀
			$table_name	=	C('DB_PREFIX').$model_table;

			if ($dataPost['field_length']!='') {
				$field_length = "(".$dataPost['field_length'].")";
			}else{
				$field_length = '';
			}

			// 对各类组件匹配数据类型
			switch ($dataPost['show_type']) {
				case 'sys':
					$field_type	= "INT";
					break;

				case 'textarea':
					$field_type	= "TEXT";
					break;

				case 'html':
					$field_type	= "TEXT";
					break;

				case 'images':
					$field_type	= "TEXT";
					break;

				case 'select':
					$field_type	= "INT";
					break;

				case 'radio':
					$field_type	= "INT";
					break;

				case 'checkbox':
					$field_type	= "INT";
					break;

				default:
					$field_type	= "VARCHAR";
					break;
			}
			$dataPost['field_type'] =	$field_type;
			$dbModField	=	M('model_fields');
			switch ($dataPost['method']) {
				case 'add':		//新增字段
					// 检测字段是否已存在
					$find 	=	$dbModField ->where("field_name='".$dataPost['field_name']."' AND model_id=".$dataPost['model_id']) ->find();
					if(!$find)
					{
						$show_type 	=	$dbModField ->where("show_type='images' AND model_id=".$dataPost['model_id']) ->find();
						if($show_type && $dataPost['show_type']=='images')
						{
							$back = array('status' => 0,'info'=>'新增失败，每个模型中只能存在一个[多图上传]类型的字段！' );
						}else{
							// 给模型数据表插入字段
							$sqlStr 	=	"alter table ".$table_name." add ".$dataPost['field_name']." ".$field_type.$field_length." NULL COMMENT '".$dataPost["field_title"]."'";
							$tableDo	=	D();
							$res	=	$tableDo->execute($sqlStr);
							// echo $tableDo ->getLastSql();
							if ($res!==false) {
								$result	=	$dbModField ->add($dataPost);
								if ($result) {
									$back 	=	array('status'=>1,'info'=>'增加字段['.$dataPost['field_name'].']成功！！','data'=>U('lists'));
								}
							}else{
								$back = array('status' => 0,'info'=>'往模型数据表中插入字段失败！' );
							}
						}
					}else{
						$back = array('status' => 0,'info'=>'字段名称['.$dataPost['field_name'].']已存在，同一个模型中不能存在相同名称的字段' );
					}
					break;
				
				default:
					# code...
					break;
			}
			
			addlog(MODULE_NAME,ACTION_NAME,$back['info']);
			$this->ajaxReturn($back);
		}
	}
?>