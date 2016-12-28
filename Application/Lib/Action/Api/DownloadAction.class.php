<?php
/**
* 
*/
class DownloadAction extends Action
{
	
	public function index()
	{
		$os	=	I('os');
		if ($os == 'android') {
			$this->downfile('AppDown/qmsb.apk');
		}else{
			$url="https://itunes.apple.com/cn/app/steamworld-heist/id1133913388" ;
			echo " <script language = 'javascript' type = 'text/javascript' > ";
			echo " window.location.href = '$url' ";
			echo " </script> ";
		}
	}

	function downfile($fileurl)
	{
		$urls = 'http://'.$_SERVER['SERVER_NAME'].'/AppDown/qmsb.apk';
		echo " <script language = 'javascript' type = 'text/javascript' > ";
		echo " window.location.href = '$urls' ";
		echo " </script> ";
		//  ob_start(); 
		//  $filename=$fileurl;
		//  $date=date("Ymd-H:i:m");
		//  header( "Content-type:  application/octet-stream "); 
		//  header( "Accept-Ranges:  bytes "); 
		//  header( "Content-Disposition:  attachment;  filename= {$date}.apk"); 
		//  $size=readfile($filename); 
		//  header( "Accept-Length: " .$size);
	}


}
?>