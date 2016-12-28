<?php
/*
* 作者：偷天换芪
*/
		// ===========================================================================================
		// ===========================================================================================
		// 									系统功能代码
		// ===========================================================================================
		// ===========================================================================================
		
		//向手机发送推送信息
		function pushMsg($msg='',$user)
		{

			import("ORG.Util.Jpush");
			$pushObj = new Jpush();
			//组装需要的参数
			if (isset($user)) {
				$receive = array('alias'=>array($user)); //别名
			}else{
				$receive = 'all'; //全部				
			}
			//$receive = array('tag'=>array('2401','2588','9527')); //标签
			// $receive = array('alias'=>array('93d78b73611d886a74*****88497f501')); //别名
			$content = $msg;
			$m_type = 'http';
			$m_txt = 'http://www.junnet.net/';
			$m_time = '600'; //离线保留时间
		
			//调用推送,并处理
			$result = $pushObj->push($receive,$content,$m_type,$m_txt,$m_time);
			// echo '<script>alert("'.$result.'");</script>';
			if($result){
				$res_arr = json_decode($result, true);
				if(isset($res_arr['error'])){ //如果返回了error则证明失败
					$res_arr['error']['message']; //错误信息
					// echo $res_arr['error']['code']; //错误码
					return false; 
				}else{
					//处理成功的推送......
					// echo '推送成功.....';
					return true;
				}
			}else{ //接口调用失败或无响应
				// echo '接口调用失败或无响应';
				return false;
			}
		}
		// 向手机发送验证码
		function vpost($url,$data){ // 模拟提交数据函数
		    $curl = curl_init(); // 启动一个CURL会话
			$this_header = array(
				"content-type: application/x-www-form-urlencoded; 
				 charset=UTF-8"
				);
			curl_setopt($curl, CURLOPT_HTTPHEADER,$this_header);
		    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
		    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
		    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
		    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
		    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
		    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
		    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
		    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
		    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		    $tmpInfo = curl_exec($curl); // 执行操作
		    if (curl_errno($curl)) {
		       echo 'Errno'.curl_error($curl);//捕抓异常
		    }
		    curl_close($curl); // 关闭CURL会话
		    return $tmpInfo; // 返回数据
		}

		// 创建二维码图片
		function createQR($url,$sign)
		{	
            vendor("phpqrcode.phpqrcode");
            $data = $url;
            // 纠错级别：L、M、Q、H
            $level = 'L';
            // 点的大小：1到10,用于手机端4就可以了
            $size = 4;
            // 下面注释了把二维码图片保存到本地的代码,如果要保存图片,用$fileName替换第二个参数false
            $path = "./Upload/qrcode/";
            // 生成的文件名
            $fileName = $path.$sign.'.png';
            QRcode::png($data, $fileName, $level, $size);
            return $fileName;
		}

		// 计算用户的奖励金额
		function getReturnMny($lvto)
		{
			// $usrInfo	=	M('member') ->where('ID='.$mid) ->find();
			// $regnums	=	$usrInfo['regnums'];	//用户的推荐人数
			// $usr_lv		=	$usrInfo['dengji'];		//用户的当前等级
			// $leastNums	=	getBaseConfig('leastNums');	//最低推荐人设置
			$returnMnys	=	getBaseConfig('reward');	//奖励设置

			// if ($regnums<$leastNums) {	//推荐注册会员的数量低于最低要求，没有奖励
			// 	$returnMny = 0;
			// }else{
				$returnMnyArray	=	explode('-', $returnMnys);
				$returnMny	=	intval($returnMnyArray[$lvto-1]);
			// }
			return $returnMny;
		}

		// 取指定名称的基础设置数据
		function getBaseConfig($key)
		{
			$back	=	M('config') ->where('config_tag="basic"') ->getField('config_value');
			$valueArray	=	json_decode($back,true);
			return $valueArray[$key];
		}

		// 获取系统设置的默认密码
		function getDefaultSafe()
		{
			$back	=	M('config') ->where('config_tag="basic"') ->getField('config_value');
			$valueArray	=	json_decode($back,true);
			return $valueArray['dftSafe'];
			// $this->ajaxReturn(array('status'=>true,'dftPWD'=>$valueArray['dftPWD']));

		}

		// 获取系统设置的默认密码
		function getDefaultPwd()
		{
			$back	=	M('config') ->where('config_tag="basic"') ->getField('config_value');
			$valueArray	=	json_decode($back,true);
			return $valueArray['dftPWD'];
			// $this->ajaxReturn(array('status'=>true,'dftPWD'=>$valueArray['dftPWD']));

		}
		// 判断两个会员是否为同一条分支之中
		function isSameTeam($mid,$mmid)
		{
			$res =	M('member')	->where('find_in_set('.$mid.',parentids) and mid='.$mmid) ->find();
			$ress =	M('member')	->where('find_in_set('.$mmid.',parentids) and mid='.$mid) ->find();

			if ($res || $ress) {
				return true;
			}else{
				return false;
			}
		}

		// 计算会员团队所有成员的数量
		// 参数 $msign 用户编号
		function getAllDownCount($msign)
		{
			$nums	=	M('member')	->where('find_in_set('.$msign.',parentids)') ->count('id');
			return $nums;
		}

		// 获取仍在有效期的广告列表
		function getADList()
		{
			$now  = time();
			$list =	M('ad') ->where('e_time>'.$now.' and status=1') ->select();
			// dump($list);
			return $list;
		}

		// 获取会员等级的图标名称
		function getLvImgTitle($lv='')
		{
			$lvImgs = array(
				'0' => "dengji0.png",
				'1' => "dengji1.png",
				'2' => "dengji2.png",
				'3' => "dengji3.png",
				'4' => "dengji4.png",
				'5' => "dengji5.png",
			 );
			return $lvImgs[$lv];
		}

		// 获取会员等级的图标
		function getLvImg($lv='')
		{
			$lvImgs = array(
				'0' => "__PUBLIC__/packet/image/dengji0.png",
				'1' => "__PUBLIC__/packet/image/dengji1.png",
				'2' => "__PUBLIC__/packet/image/dengji2.png",
				'3' => "__PUBLIC__/packet/image/dengji3.png",
				'4' => "__PUBLIC__/packet/image/dengji4.png",
				'5' => "__PUBLIC__/packet/image/dengji5.png",
			 );
			return $lvImgs[$lv];
		}

		// 根据ID取管理员名称
		function getAdmInfo($aid='',$field)
		{
			$admInfo 	=	M('user') ->where('id='.$aid) ->find();
			if ($admInfo['photo']=="") {
				$admInfo['photo']	=	"__PUBLIC__/ttcms/img/nopic.png";
			}
			$admName 	=	$admInfo['nickname']==''?$admInfo['username']:$admInfo['nickname'];
			$bacArray = array('name' => $admName, 'info'=>$admInfo);
			if (isset($field)) {
				return $bacArray[$field];
			}else{
				return $bacArray;
			}
		}

		// 根据mid取会员信息
		function getMebInfoByMid($mid='',$field)
		{
			$mebInfo 	=	M('member') ->where('mid='.$mid) ->find();
			if (isset($field)) {
				return $mebInfo[$field];
			}else{
				return $mebInfo;
			}
		}

		// 根据ID取会员信息
		function getMebInfo($aid='',$field)
		{
			$mebInfo 	=	M('member') ->where('id='.$aid) ->find();
			if (isset($field)) {
				return $mebInfo[$field];
			}else{
				return $mebInfo;
			}
		}

		//获取系统前台的频道数据
		function getChannel($from)			
		{
			$dbChannel	=	M('channel');
			$topChnl	=	$dbChannel ->where('pid=0') ->order('sort asc') ->select();
			foreach ($topChnl as $top) {
				$top['list']	=	getSubChnl($top['id'],$from);
				$topChannel[]	=	$top;
			}
			return $topChannel;
		}

		//递归法取出指定频道的所有下级子频道
		function getSubChnl($pid=0,$from)		
		{
			if ($from=="back") {
				$sortStr	=	'sort desc';
			}else{
				$sortStr	=	'sort asc';
			}
			$dbChannel	=	M('channel');
			$subChnl	=	$dbChannel ->where('pid='.$pid)->order($sortStr) ->select();
			if ($subChnl) {
				foreach ($subChnl as $sub) {
					$sub['list']	=	getSubChnl($sub['id']);		//自我循环
					$subChannel[]	=	$sub;
				}
				return $subChannel;
			}else{
				return null;
			}
		}

		// 获取系统的基础设置数据
		function getSiteConfig()
		{
			$dbConfig	=	M('config');
			$configStr	=	$dbConfig ->where("config_tag='basic'") ->find();
			$configArr 	=	json_decode($configStr['config_value'],true);
			return $configArr;
		}


		// ===========================================================================================
		// ===========================================================================================
		// 									通用功能代码
		// ===========================================================================================
		// ===========================================================================================


		/**
		*作用：加密编码文本，常用于对富文本(包含有Html代码等特殊字符的文本)进行前期处理
		* @param string $value 源文本
		* @return string  返回密文文本
		*
		*/
		function tt_encode($value='')
		{
			$result 	= 	urlencode(stripslashes($value));
			return $result;
		}

		/**
		*作用：解密由tt_encode加密的文本
		* @param string $value 密文文本
		* @return string  返回明文文本
		*
		*/
		function tt_decode($value='')
		{
			$result 	= 	urldecode($value);
			return $result;
		}

		/**
		*作用：去除因前端框架会在url后自动的添加 ?v=4.0 标识，避免导致thinkphp的I()函数读取参数失误。
		* @param string $value I()函数识别参数名
		* @return string  返回正确的参数内容
		*
		*/
		function Y($value='')
		{
			$end 	=	I($value);
			$end 	=	str_replace('?v=4.0', '', $end);
			return $end;
		}


		/**
		*作用：删除数组中指定key的元素
		* @param array $data 数组对象
		* @param string $key key名
		* @return array  返回新的数组
		*
		*/
		function array_remove($data, $key){
		    if(!array_key_exists($key, $data)){
		        return $data;
		    }
		    $keys = array_keys($data);
		    $index = array_search($key, $keys);
		    if($index !== FALSE){
		        array_splice($data, $index, 1);
		    }
		    return $data;
		}

		/*多维数组排序
		$multi_array:多维数组名称
		$sort_key:二维数组的键名
		$sort:排序常量	SORT_ASC || SORT_DESC
		*/
		function multi_array_sort(&$multi_array,$sort_key,$sort=SORT_DESC){
			if(is_array($multi_array)){
				foreach ($multi_array as $row_array){
					if(is_array($row_array)){
						//把要排序的字段放入一个数组中，
						$key_array[] = $row_array[$sort_key];
					}else{
						return false;
					}
				}
			}else{
				return false;
			}
			//对多个数组或多维数组进行排序
			array_multisort($key_array,$sort,$multi_array);
			return $multi_array;
		}
		
		//将IP转换为数字
		function ipton($ip){
			$ip_arr=explode('.',$ip);//分隔ip段
			foreach ($ip_arr as $value){
					$iphex=dechex($value);//将每段ip转换成16进制
					if(strlen($iphex)<2){//255的16进制表示是ff，所以每段ip的16进制长度不会超过2
						$iphex='0'.$iphex;//如果转换后的16进制数长度小于2，在其前面加一个0
						//没有长度为2，且第一位是0的16进制表示，这是为了在将数字转换成ip时，好处理
					}
				$ipstr.=$iphex;//将四段IP的16进制数连接起来，得到一个16进制字符串，长度为8
				}
			return hexdec($ipstr);//将16进制字符串转换成10进制，得到ip的数字表示
		}




		//将数字转换为IP，进行上面函数的逆向过程
		function ntoip($n)
		{
			$iphex=dechex($n);//将10进制数字转换成16进制
			$len=strlen($iphex);//得到16进制字符串的长度
			if(strlen($iphex)<8)
			{
			$iphex='0'.$iphex;//如果长度小于8，在最前面加0
			$len=strlen($iphex); //重新得到16进制字符串的长度
			}
			//这是因为ipton函数得到的16进制字符串，如果第一位为0，在转换成数字后，是不会显示的
			//所以，如果长度小于8，肯定要把第一位的0加上去
			//为什么一定是第一位的0呢，因为在ipton函数中，后面各段加的'0'都在中间，转换成数字后，不会消失
			for($i=0,$j=0;$j<$len;$i=$i+1,$j=$j+2)
			{//循环截取16进制字符串，每次截取2个长度
				$ippart=substr($iphex,$j,2);//得到每段IP所对应的16进制数
				$fipart=substr($ippart,0,1);//截取16进制数的第一位
				if($fipart=='0')
				{//如果第一位为0，说明原数只有1位
					$ippart=substr($ippart,1,1);//将0截取掉
				}
				$ip[]=hexdec($ippart);//将每段16进制数转换成对应的10进制数，即IP各段的值
			}
			return implode('.', $ip);//连接各段，返回原IP值
		}


		/**
		* @param string $string 原文或者密文
		* @param string $operation 操作(ENCODE | DECODE), 默认为 DECODE
		* @param string $key 密钥
		* @param int $expiry 密文有效期, 加密时候有效， 单位 秒，0 为永久有效
		* @return string 处理后的 原文或者 经过 base64_encode 处理后的密文
		*
		* @example
		*
		*  $a = authcode('abc', 'ENCODE', 'key');
		*  $b = authcode($a, 'DECODE', 'key');  // $b(abc)
		*
		*  $a = authcode('abc', 'ENCODE', 'key', 3600);
		*  $b = authcode('abc', 'DECODE', 'key'); // 在一个小时内，$b(abc)，否则 $b 为空
		*/
		function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
		{
		    $ckey_length = 4;  
		    // 随机密钥长度 取值 0-32;
		    // 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
		    // 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
		    // 当此值为 0 时，则不产生随机密钥
		    $key = md5($key ? $key : EABAX::getAppInf('KEY'));
		    $keya = md5(substr($key, 0, 16));
		    $keyb = md5(substr($key, 16, 16));
		    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
		    
		    $cryptkey = $keya.md5($keya.$keyc);
		    $key_length = strlen($cryptkey);
		    
		    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
		    $string_length = strlen($string);
		    
		    $result = '';
		    $box = range(0, 255);
		    
		    $rndkey = array();
		    for($i = 0; $i <= 255; $i++)
		    {
		        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
		    }
		    
		    for($j = $i = 0; $i < 256; $i++)
		    {
		        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
		        $tmp = $box[$i];
		        $box[$i] = $box[$j];
		        $box[$j] = $tmp;
		    }
		    
		    for($a = $j = $i = 0; $i < $string_length; $i++)
		    {
		        $a = ($a + 1) % 256;
		        $j = ($j + $box[$a]) % 256;
		        $tmp = $box[$a];
		        $box[$a] = $box[$j];
		        $box[$j] = $tmp;
		        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		    }
		    
		    if($operation == 'DECODE')
		    {
		        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)){
		          return substr($result, 26);
		        }else{
		          return '';
		        }
		    }else
		    {
		        return $keyc.str_replace('=', '', base64_encode($result));
		    }
		}


		/**
		 * Goofy 2011-11-30
		 * getDir()去文件夹列表，getFile()去对应文件夹下面的文件列表,二者的区别在于判断有没有“.”后缀的文件，其他都一样
		 */
		 
		//获取文件目录列表,该方法返回数组
		function getDir($dir) {
		    $dirArray[]=NULL;
		    if (false != ($handle = opendir ( $dir ))) {
		        $i=0;
		        while ( false !== ($file = readdir ( $handle )) ) {
		            //去掉"“.”、“..”以及带“.xxx”后缀的文件
		            if ($file != "." && $file != ".."&&!strpos($file,".")) {
		                $dirArray[$i]=$file;
		                $i++;
		            }
		        }
		        //关闭句柄
		        closedir ( $handle );
		    }
		    return $dirArray;
		}
		 
		//获取文件列表
		function getFile($dir) {
		    $fileArray[]=NULL;
		    if (false != ($handle = opendir ( $dir ))) {
		        $i=0;
		        while ( false !== ($file = readdir ( $handle )) ) {
		            //去掉"“.”、“..”以及带“.xxx”后缀的文件
		            if ($file != "." && $file != ".."&&strpos($file,".")) {
		                $fileArray[$i]="./imageroot/current/".$file;
		                if($i==100){
		                    break;
		                }
		                $i++;
		            }
		        }
		        //关闭句柄
		        closedir ( $handle );
		    }
		    return $fileArray;
		}
		 
		//调用方法getDir("./dir")……

		/**
		 * 作用：遍历输出指定目录所有文件名
		 * @param string $dir  需要遍历的目录
		 * @return array  返回文件名数组
		 */
		//print_r(listDir('./')); //遍历当前目录
		function listDirs($dir='./')
		{
		    $dir .= substr($dir, -1) == '/' ? '' : '/';
		    $dirInfo = array();
		    foreach (glob($dir.'*') as $v)
		    {
		        $dirInfo[] = $v; 
		        if(is_dir($v))
		        {
		            $dirInfo = array_merge($dirInfo, listDirs($v));
		        }
		    }
		    krsort($dirInfo); //反转数组排序，将创建日期由升序转为降序排列
		    return $dirInfo;
		}

		function getDirNum($dir='./')
		{
			$dir .= substr($dir, -1) == '/' ? '' : '/';
			$dir_arr	=	scandir($dir);
			$Number	=	count($dir_arr)-2;
			return $Number;
		}
		/**
		 * 作用：计算文件夹占空间大小
		 * @param string $dir  需要计算的目录
		 * @return array  返回所占空间大小，单位为字节
		 */
		function countDirSize($dir)
		{
			$handle = opendir($dir);
			while (false!==($FolderOrFile = readdir($handle)))
			{
				if($FolderOrFile != "." && $FolderOrFile != "..")
				{
					if(is_dir("$dir/$FolderOrFile")) 
					{
						$sizeResult += countDirSize("$dir/$FolderOrFile");
					} else {
						$sizeResult += filesize("$dir/$FolderOrFile");
					}
				}
			}
			closedir($handle);
			$TrueSize	=	get_real_size($sizeResult);
			return $TrueSize;
		}

		/**
		 * 作用：将字节数转化为KB，MB，GB等单位
		 * @param string $size  需要转换的字节数
		 * @return array  返回转换后的单位
		 */
		function get_real_size($size) 
		{
        $kb = 1024;         // Kilobyte
        $mb = 1024 * $kb;   // Megabyte
        $gb = 1024 * $mb;   // Gigabyte
        $tb = 1024 * $gb;   // Terabyte

        if($size < $kb) 
        {
           return $size." B";
        }else if($size < $mb) {
           return round($size/$kb,2)." KB";
        }else if($size < $gb) {
           return round($size/$mb,2)." MB";
        }else if($size < $tb) {
           return round($size/$gb,2)." GB";
        }else {
           return round($size/$tb,2)." TB";
        }

		}


		/**
		 * Curl版本提交POST数据
		 * 使用方法：
		 * $post_string = "app=request&version=beta";
		 * request_by_curl('http://facebook.cn/restServer.php',$post_string);
		 */
		function request_by_curl($remote_server, $post_string)
		{
		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, $remote_server);
		    curl_setopt($ch, CURLOPT_POST,1); 
		    curl_setopt($ch, CURLOPT_POSTFIELDS, '='.$post_string);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($ch, CURLOPT_USERAGENT, "TTHQ's CURL Example beta");
		    // dump($ch);
		    $data = curl_exec($ch);
		    curl_close($ch);
		    return $data;
		}

		function request_ssl_curl($url='')
		{
			$ch = curl_init();
			$header = "Accept-Charset: utf-8";
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$temp = curl_exec($ch);
			curl_close($ch);
			return $temp;
		}

		
		/**
		* 作用：在线向指定地址发送email邮件
		* @param string $address 欲发送邮件的目的地址
		* @param string $sentname 欲发送邮件的发件人
		* @param string $title 欲发送邮件的标题
		* @param string $message 欲发送邮件的邮件正文
		* @return foolen 是否成功 
		*
		* @example
		*
		*  SendMail("tthq08@163.com","偷天换芪","欢迎使用TTCMS系统","正文内容")
		*/

		function SendMail($address,$sentname,$title,$message)
		{
		    $Config 		=	M("config");
			$Site_Arr 		=	$Config->where("config_tag='email'")->find();

			eval("\$ConArr=".$Site_Arr["config_array"].";");

		    import('ORG.Net.PHPMailer');
		    $mail=new PHPMailer();
		    // 设置PHPMailer使用SMTP服务器发送Email
		    $mail->IsSMTP();
		    // 设置邮件的字符编码，若不指定，则为'UTF-8'
		    $mail->CharSet='UTF-8';
		    // 添加收件人地址，可以多次使用来添加多个收件人
		    $mail->AddAddress($address);
		    // 设置邮件正文
		    $mail->Body=$message;
		    // 设置邮件头的From字段。
		    $mail->From=$ConArr['mailadd'];
		    // 设置发件人名字
		    $mail->FromName=$sentname;
		    // 设置邮件标题
		    $mail->Subject=$title;
		    // 设置SMTP服务器。
		    $mail->Host=$ConArr['mailserver'];
		    // 设置服务端口
		    $mail->Port=$ConArr['mailport'];
		    // 设置为“需要验证”
		    $mail->SMTPAuth=true;
		    // 设置用户名和密码。
		    $mail->Username=$ConArr['username'];
		    $mail->Password=$ConArr['password'];
		    // 发送邮件。
		    return($mail->Send());

		}
		
		/**
		*+----------------------------------------------------------
		* 字符串截取，支持中文和其他编码
		*+----------------------------------------------------------
		* @static
		* @access public
		*+----------------------------------------------------------
		* @param string $str 需要转换的字符串
		* @param string $start 开始位置
		* @param string $length 截取长度
		* @param string $charset 编码格式
		* @param string $suffix 截断显示字符
		*+----------------------------------------------------------
		* @return string
		*+----------------------------------------------------------
		*/

		function tt_substr($str, $start=0, $length, $charset="utf-8", $suffix=true){
		  if(function_exists("mb_substr")){
			 if($suffix){
			  return mb_substr($str, $start, $length, $charset)."...";
			 }else{
			  return mb_substr($str, $start, $length, $charset);
			 }
		  }elseif(function_exists('iconv_substr')) {
			   if($suffix){
					return iconv_substr($str,$start,$length,$charset)."...";
			   }else{
				return iconv_substr($str,$start,$length,$charset);
			   }
		  }

			$re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
			$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
			$re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
			$re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
			preg_match_all($re[$charset], $str, $match);
			$slice = join("",array_slice($match[0], $start, $length));
			if($suffix){ 
				return $slice."...";
			}else{
				return $slice;
			}
		}
	
?>