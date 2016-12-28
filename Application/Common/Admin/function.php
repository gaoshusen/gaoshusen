<?php
/*
* 作者：偷天换芪
* 作用：系统后台通用函数
*/
		function getAdmTpl($type='')
		{
			switch ($type) {
				case 'input':
					$Html	=	'<div class="form-group">
	                                <label class="col-sm-3 control-label">#field_title#</label>
	                                <div class="col-sm-8">
	                                    <input id="#field_name#" name="#field_name#" value="#fieldValue#" class="form-control" type="text" class="valid" placeholder="#field_tip#" #readonly#>
	                                	<span class="help-block m-b-none"><i class="fa fa-info-circle"></i>#field_tip#</span>
	                                </div>
	                            </div>';
					break;

				// case 'sys':
				// 	$Html	=	'<input id="#field_name#" name="#field_name#" value="#fieldValue#" type="hidden">';
				// 	break;

				case 'img':
					$Html	=	'<div class="form-group">
	                                <label class="col-sm-3 control-label">#field_title#预览：</label>
	                                <div class="col-sm-8">
	                                    <img id="#field_name#" src="#fieldValue#" width="160" height="120" border="0" />
	                                </div>
	                            </div>
	                            <div class="form-group">
	                                <label class="col-sm-3 control-label">#field_title#上传：</label>
	                                <div class="col-sm-8">
	                                    <input id="#field_name#_val" type="hidden" name="#field_name#" value="#fieldValue#"><input id="upload_#field_name#" name="upload_#field_name#" type="file" multiple="true" value="" />
	                                	<span class="help-block m-b-none"><i class="fa fa-info-circle"></i>#field_tip#</span>
	                                </div>
	                            </div>';
					break;
				
				case 'images':
					$Html	=	'<div class="form-group">
	                                <label class="col-sm-3 control-label">#field_title#上传：</label>
	                                <volist name="contentInfo.#field_name#" id="IL" key="K">
	                                <div id="uploadList_k<{$K}>" class="upload_append_list">  
	                                    <div class="file_bar file_hover">      
	                                        <div style="padding:5px;">          
	                                            <p class="file_name" title="<{$IL.info}>"><{$IL.info}></p>
	                                            <a title="删除" href=javascript:remove("","<{$K}>");>
	                                            <span class="file_del" title="删除"></span></a>
	                                        </div>
	                                    </div>
	                                    <a style="height:100px;width:120px;" href="#" class="imgBox">

	                                        <div class="uploadImg" style="width:105px;max-width:105px;max-height:90px;">
	                                            <img id="uploadImage_k<{$K}>" class="upload_image" src="<{$IL.names}>" style="width:expression(this.width > 105 ? 105px : this.width);">
	                                        </div>
	                                    </a>
	                                    <p id="uploadProgress_k<{$K}>" class="file_progress"></p>
	                                    <p id="uploadFailure_k<{$K}>" class="file_failure">上传失败，请重试</p>
	                                    <p id="uploadTailor_k<{$K}>" class="file_tailor" tailor="false">裁剪完成</p>
	                                    <p id="uploadSuccess_k<{$K}>" class="file_success"></p>图片说明：<br>
	                                    <textarea name="imgInfo[]" style="width:120px;height:30px;"><{$IL.info}></textarea><br><input type="hidden" name="images[]" style="height:30px;" id="upname_k<{$K}>" value="<{$IL.names}>">
	                                </div>
	                                </volist>  
	                                
	                            </div> 
	                            <div class="form-group">
	                                <label class="col-sm-3 control-label"></label>
	                                <div class="col-sm-8">
	                                    <div id="demo" class="demo"></div>
	                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>#field_tip#</span>
	                                </div>
	                            </div>';
					break;

				case 'select':
					$Html	=	'<div class="form-group">
	                                <label class="col-sm-3 control-label">#field_title#：</label>
	                                <div class="col-sm-8">
	                                    <select class="form-control" style="width:350px;" name="#field_name#" id="#field_name#">
	                                        #component#
	                                        <option value="0">----请选择#field_title#----</option>
	                                        <volist name="#field_name#" id="A">
	                                            <option value="<{$A.id}>" <eq name="#field_name#" value="$A.id">selected="selected"</eq> ><{$A.name}></option>
	                                            <volist name="A.list" id="B">
	                                            	<option value="<{$B.id}>" <eq name="#field_name#" value="$B.id">selected="selected"</eq> >     ┗━━<{$B.name}></option>
	                                            	<volist name="B.list" id="C">
	                                            		<option value="<{$C.id}>" <eq name="#field_name#" value="$C.id">selected="selected"</eq> >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;┗━━<{$C.name}></option>
	                                            	</volist>
	                                            </volist>
	                                        </volist>
	                                    </select>     
	                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>#field_tip#</span>                            
	                                </div>
	                            </div>';
					break;

				case 'radio':
					$Html	=	'<div class="form-group">
	                                <label class="col-sm-3 control-label">#field_title#：</label>
	                                <div class="col-sm-8">
	                                    <div class="radio i-checks">
	                                    	#component#
                                        </div>
                                        <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>#field_tip#</span>
	                                </div>
	                            </div> ';
					break;

				case 'checkbox':
					$Html	=	'<div class="form-group">
	                                <label class="col-sm-3 control-label">#field_title#：</label>
	                                <div class="col-sm-8">
	                                    <div class="checkbox i-checks">
	                                       #component# 
	                                    </div>  
	                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>#field_tip#</span>                                  
	                                </div>
	                            </div> ';
					break;

				case 'laydate':
					$Html	=	'<div class="form-group">
	                                <label class="col-sm-3 control-label">#field_title#：</label>
	                                <div class="col-sm-8">
	                                    <input placeholder="请选择日期" id="#field_name#" name="#field_name#" class="form-control" style="width:240px" readonly onclick="laydate({istime: false,min: laydate.now()})">
	                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>#field_tip#</span>                                  
	                                </div>
	                            </div>';
					break;

				case 'key':
					$Html	=	'<div class="form-group">
	                                <label class="col-sm-3 control-label">#field_title#：</label>
	                                <div class="col-sm-8">
	                                    <input id="#field_name#" name="#field_name#" value="#fieldValue#" class="inputTagator form-control" type="text">
	                                    <input value="" id="#field_name#_tagator" type="hidden" class="operateBtn">
	                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>#field_tip#</span>
	                                </div>
	                            </div>';
					break;

				case 'textarea':
					$Html	=	'<div class="form-group">
	                                <label class="col-sm-3 control-label">#field_title#：</label>
	                                <div class="col-sm-8">
	                                    <textarea id="#field_name#" name="#field_name#" class="form-control" aria-required="true" style="height:120px;">#fieldValue#</textarea>
	                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>#field_tip#</span>
	                                </div>
	                            </div>';
					break;

				case 'html':
					$Html 	=	'<div class="form-group">
	                                <label class="col-sm-3 control-label">#field_title#：</label>
	                                <div class="col-sm-8">
	                                    <script id="#field_name#" name="#field_name#" type="text/plain"></script>
	                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>#field_tip#</span>
	                                </div>
	                            </div>';
					break;
			}

			return $Html;
		}	

		
		/**
		*作用：取出数据库备份文件名中的文件名
		* @param array $string 数据库备份文件
		* @return string  返回取得的文件名
		*
		*/
		function get_file($string='')
		{
			if ($string!='') {
				$dir	= C("DB_BACKUP");
				$string = str_replace($dir, '', $string);
			}
			return $string;
		}

		/**
		*作用：取出数据库备份文件名中的创建时间
		* @param array $string 数据库备份文件
		* @return string  返回取得的时间
		*
		*/
		function get_time($string='')
		{
			if ($string!='') {
				$string = get_file($string);
				$string = substr($string, 0,14);
				$string = substr($string, 0,4)."-".substr($string, 4,2)."-".substr($string, 6,2)." ".substr($string, 8,2).":".substr($string, 10,2).":".substr($string, 12,2);
			}
			return $string;
		}

		/**
		*作用：取出数据库备份文件名中的数据表名
		* @param array $string 数据库备份文件
		* @return string  返回取得的数据表名，如表名为all,则返回“全部数据表”。
		*
		*/
		function get_database($string='')
		{
			if ($string!='') {
				$string = get_file($string);
				$pos	= strpos($string, '.');
				$string = substr($string, 15,$pos-15);
			}
			if ($string=='all') {
				$string = "全部数据表";
			}
			return $string;
		}


		/**
		 * 功能：计算文件大小
		 * @param int $bytes
		 * @return string 转换后的字符串
		 */
		function byte_Format($bytes) {
		    $sizetext = array(" B", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
		    return round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), 2) . $sizetext[$i];
		} 

		//下载文件
		function download_file($file){
			if ($file!='') {
				$file = __ROOT__.$file;
				if(is_file($file)){
		        $length = filesize($file);
		        //$type = mime_content_type($file);
		        $showname =  ltrim(strrchr($file,'/'),'/');
		        header("Content-Description: File Transfer");
		        //header('Content-type: ' . $type);
		        header('Content-Length:' . $length);
		         if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) { //for IE
		             header('Content-Disposition: attachment; filename="' . rawurlencode($showname) . '"');
		         } else {
		             header('Content-Disposition: attachment; filename="' . $showname . '"');
		         }
		         readfile($file);
		         exit;
		     } else {
		         exit('文件已被删除！');
		     }
			}		    
		 }


		 //将 xxx,yyy,zzz,aaa,bbb 格式文本转化为数组
		function str2arr($words)
		{
			$a_word			=	explode(",", $words);
			for ($i=0; $i < count($a_word); $i++) { 
				$b_word		.=	"'".$a_word[$i]."',";
			}
			$c_word			=	"array(".substr($b_word, 0,-1).")";
			eval("\$ConArr=".$c_word.";");
			return $ConArr;
		}


		function Upload_code()
		{
			$Upload 	=	M("config");
			$UploadStr	=	$Upload->where("config_tag='upload'")->find();
			eval("\$ConArr=".$UploadStr["config_array"].";");
			return $ConArr;
		}

		/**
		 * 作用：检测用户对指定目录的权限
		 * @param string $uid  欲检测的用户ID
		 * @param string $mid  欲检测的目录ID
		 * @return foolen  返回用户对该目录是否具有权限
		 */
		function ckpower($rid,$mid)
		{
			if ($rid==0) {
				return true;
			}else{
				$dbAuth	=	M('auth');
				$rows	=	$dbAuth ->where('rid='.$rid.' and mid='.$mid) ->count();
				if ($rows>0) {
	    			return true;
	    		}
	    		else{
	    			return false;
	    		}
			}			
		}

		/**
		 * 作用：获取对应模块名和方法名关联的菜单ID
		 * @param string $moduleName  模块名
		 * @param string $actionName  方法名
		 * @return int  返回菜单ID ,不存在则返回0
		 */
		function getMid($moduleName,$actionName)
		{
			$dbMenu	=	M('menu');
			$menuInfo	=	$dbMenu ->where("module_name='".$moduleName."' and action_name='".$actionName."'") ->find();
    		if (!is_null($menuInfo)) {
    			return $menuInfo['id'];
    		}
    		else{
    			return 0;
    		}
		}

		/**
		 * 作用：获取对应模块名和方法名关联的菜单的放开权限状态
		 * @param int $menuID  模块名
		 * @return int  返回权限状态 ,1为放开权限，0为管控权限
		 */
		function getAllow($menuID)
		{
			$dbMenu	=	M('menu');
			$menuAllow	=	$dbMenu ->where('id='.$menuID) ->getField('is_public');
			return $menuAllow;
		}


		//获取文件修改时间
		function getfiletime($file, $DataDir) {
		    $a = filemtime($DataDir . $file);
		    $time = date("Y-m-d H:i:s", $a);
		    return $time;
		}

		//获取文件的大小
		function get_filesize($file, $DataDir) {
		    $perms = stat($DataDir . $file);
		    $size = $perms['size'];
		    // 单位自动转换函数
		    $kb = 1024;         // Kilobyte
		    $mb = 1024 * $kb;   // Megabyte
		    $gb = 1024 * $mb;   // Gigabyte
		    $tb = 1024 * $gb;   // Terabyte

		    if ($size < $kb) {
		        return $size . " B";
		    } else if ($size < $mb) {
		        return round($size / $kb, 2) . " KB";
		    } else if ($size < $gb) {
		        return round($size / $mb, 2) . " MB";
		    } else if ($size < $tb) {
		        return round($size / $gb, 2) . " GB";
		    } else {
		        return round($size / $tb, 2) . " TB";
		    }
		}

		
		function addlog($module,$action,$logstr)
		{
			$syslog		=	M('log');
			$user 		=	session('ttcms_usr');
			$dataLog	= 	array('usr' => $user,'module_name'=>$module,'action_name'=>$action,'info'=>$logstr,'logtime'=>time() );
			$syslog ->add($dataLog);
		}
?>