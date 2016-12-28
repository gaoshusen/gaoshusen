
document.write('<script src="/Public/phone/script/layer/layer.js"></script>');
var ServRoot	=	"http://test.tn28.cn/";
var	ApiUrl		=	ServRoot + "index.php/Api/";
var debug		=	false;		//是否调试版本
var	version		=	"";

function goWeb (webName) {
	location.href = webName;
}

function msg_t (msg) {
	layer.msg(msg);
}

function showLoading (title,text) {
	layer.load(0, {shade: false});
}

function closeLoading () {
	layer.closeAll('loading');
}

function chkUseLogin() {		//检测用户是否登录
	var memberID	=	$.session.get('memberID');
	if (typeof(memberID) != 'undefined' && memberID != "" && memberID != null) {
		return true;
	} else {
		return false;
	}
}