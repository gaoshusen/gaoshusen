<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="your,keywords,separated ">
	<meta name="description" content="150 chars">
	<title></title>
	<!-- <link rel="stylesheet" href="__PUBLIC__/phone/css/common.css"> -->
	<link rel="stylesheet" href="__PUBLIC__phone/css/reset.css">
    <link rel="stylesheet" href="__PUBLIC__phone/css/style2.css">
	<script src="__PUBLIC__phone/script/index.js"></script>
</head>
<body id="popu">
		<header class="header">
			<div class="headerTop">
				<div class="back">
					<span></span>
				</div>
				<h3 class="logo">
					我的推广
				</h3>
			</div>
		</header>
		<section class="content">
			<ul class="main">
				<li>
					<div class="mainLeft">
						推荐人：
					</div>
					<div class="mainRight">
						<input type="text" class="" id="commond" value="" readonly="readonly">
						<input type="hidden" class="" id="fphone" value="" readonly="readonly">
						<input type="hidden" class="" id="parentids" value="" readonly="readonly">
						<input type="hidden" class="" id="recast" value="" readonly="readonly">
					</div>
				</li>
				
				<li>
					<div class="mainLeft">
						手机号码：
					</div>
					<input type="text" id="mobile" placeholder="请输入手机号"/>
					<!--<span class="code" id="code" onclick=";"></span>-->
					<input type="button" class="code" id="code" ></input>
				</li>
				<li>
					<div class="mainLeft">
						验证码：
					</div>
					<input type="text" id="codes" placeholder="请输入验证码"/>
				</li>
				<li>
					<div class="mainLeft">
						会员名称：
					</div>
					<input type="text" id="mName" placeholder="请输入会员名称"/>
				</li>
				<li>
					<div class="mainLeft">
						真实姓名：
					</div>
					<input type="text" id="trueName" placeholder="请输入真实姓名"/>
				</li>
				<!-- <li>
					<div class="mainLeft">
						支付宝：
					</div>
					<input type="text" id="alipay" placeholder="请输入支付宝帐号"/>
				</li>
				<li>
					<div class="mainLeft">
						微信：
					</div>
					<input type="text" id="wex" placeholder="请输入微信帐号"/>
				</li> -->
				<li>
					<div class="mainLeft">
						登录密码：
					</div>
					<div class="mainRight" id="dftPwd">
					</div>
				</li>
				<li>
					<div class="mainLeft">
						安全密码：
					</div>
					<div class="mainRight" id="dftSafe">
					</div>
				</li>
			</ul>
			<div class="zhuce" class="regbtn" onclick="goPost();">
				
			</div>
		</section>

<script src="__PUBLIC__phone/script/jquery-1.9.1.min.js"></script>
<script src="__PUBLIC__phone/script/swiper.min.js"></script>
<script src="__PUBLIC__phone/script/system.js"></script>
<script type="text/javascript">

	$(function() {
		
		
			
			
        $('#mobile').val('');
		$('#mName').val('');
		$('#trueName').val('');
		$('#wex').val('');                       
		$('#alipay').val('');   
		
		var timer=null;
		var num=60;
		var code=document.getElementById('code');
		code.onclick=function(){
			var mobile = $('#mobile').val();
			if(!(/^1[34578]\d{9}$/.test(mobile))){
				alert("请输入正确的手机号码!");
				return false; 
			}
			getCode();
			this.setAttribute('disabled',"disabled");
			this.className='code none';
			this.value='倒计时'+num+'s';
			timer=setInterval(function(){
				num--;
				code.value='倒计时'+num+'s';
				if(num<1){
					clearInterval(timer);
					num=60;
					code.value='';
					
					code.className='code show';
					
					code.removeAttribute('disabled')
				}
			},1000)
		}
		getDefaultPwd();
		getMemberinfo();
	});
 	function getDefaultPwd () {
 		var url = ApiUrl + 'User/getdefaultpwd';
 		var uid = <?php echo ($uid); ?>;
		$.ajax({
			url : url,
			data:{
				uid:uid
			},
			dataType : 'json', //服务器返回json格式数据
			type : 'post',	
			success : function(data) {
				if (data.status!=false) {
					var show_full	=	'<span style="color:red;font-size:22px;">您的下线已经满员，无法注册！</span>';
					if (data.is_full) {
						$('.regbtn').hide();
						$('.submit').html(show_full);
					};
					$('#dftPwd').html("默认密码为"+data.dftPWD);
					$('#dftSafe').html("默认密码为"+data.dftSafe);
					// setHtml(data,'#team_list'+position);
				};
			}
		})
 	}

 	function getCode () {
 		var mobile	=	$('#mobile').val();
 		var url = ApiUrl + 'User/getCode';
		$.ajax({
			url : url,
			data:{
				mobile:mobile
			},
			dataType : 'json', //服务器返回json格式数据
			type : 'post',	
			success : function(data) {
				if (data.status!=false) {
					localStorage.code = data.code;
				}
			},
		})
 	}

 	function getMemberinfo () {
 		var url = ApiUrl + 'User/getminfo';
 		var uid = <?php echo ($uid); ?>;
		$.ajax({
			url : url,
			data:{
				uid:uid
			},
			dataType : 'json', //服务器返回json格式数据
			type : 'post',	
			success : function(data) {
				// alert(data);moblie
				// console.log(data);
				// alert(JSON.parse(data));
				// if (data.status!=false) {
				$('#commond').val(data.moblie+'('+data.mname+')');
				// 	$('#fphone').val(data.moblie);
				// 	$('#parentids').val(data.parentids);
				// 	$('#recast').val(22);
				// };
			}
		})
 	}

 	function goPost () {
 		var url = ApiUrl + 'User/autoregmember';
 		var mobile	=	$('#mobile').val();
 		var fphone	=	$('#fphone').val();
 		var parentids	=	$('#parentids').val();
 		var mname 	=	$('#mName').val();
 		var truename 	=	$('#trueName').val();
 		var wex 	=	$('#wex').val();                  
		var alipay 	=	$('#alipay').val(); 
 		var recast 	=	$('#recast').val();
 		var code 	=	$('#codes').val();
		if (code!=localStorage.code) {
			alert("请输入正确验证码！");
			return false; 
		};
 		if (mobile=="") {
			alert("请输入完整的手机号！");
			return false; 
		};
		if (mname=="") {
			alert("请输入会员名称！");
			return false; 
		};
		if (truename=="") {
			alert("请输入真实姓名！");
			return false; 
		};
		if (wex=="") {
			alert("请输入微信号！");
			return false; 
		};
		if (alipay=="") {
			alert("请输入支付宝号！");
			return false; 
		};
		if(!(/^1[3|4|5|7|8][0-9]\d{4,8}$/.test(mobile))){
			alert("请输入正确的手机号码!");
			return false; 
		}

		// showLoading('会员注册中...');
		var uid = <?php echo ($uid); ?>;
 		var url = ApiUrl + 'User/autoregmember';
		$.ajax({
			url : url,
			data : {
				mobile:mobile,
				mname:mname,
				truename:truename,
				wex:wex,
				recast:recast,
				alipay:$('#alipay').val(),
				pid:uid,
				fphone:fphone,
				parentids:parentids
			},
			dataType : 'json', //服务器返回json格式数据
			type : 'post',	
			success : function(data) {
				// api.alert({msg:data});
				if (data.status!=false) {
					alert(data.info);
					localStorage.recast = data.recast;
					location.href="<?php echo U('bridge');?>";
					// goBack();
				}else{
					alert(data.info);
				};
			closeLoading();
			}
		})
 	}

	function goBack () {
		var from = '<?php echo ($from); ?>';
		if (from=='app') {
			location.href="<?php echo U('scanCode');?>";
		}else{
			history.back(-1);
		};
	}
</script>
</body>
</html>