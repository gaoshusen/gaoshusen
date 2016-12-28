<?php
/**
*   项目公用配置
*
*/
return array(
	//'配置项'=>'配置值'

	//使用项目分组方式
	'APP_GROUP_LIST' => 'Mobile,Admin,Api', 		//启用项目分组模式
	'DEFAULT_GROUP'	=> 'Mobile',				//配置默认分组

	//设置数据库参数
	'DB_HOST'	=> 'localhost',		//数据库地址
	'DB_PORT'	=> '3306',				//数据库端口
	'DB_NAME'	=> 'api',		//数据库名
	'DB_USER'	=> 'root',			//数据库用户名
	'DB_PWD'	=> 'root',				//数据库密码
	'DB_PREFIX' => 't_',			//数据表前缀
	// 'DB_HOST'	=> 'localhost',		//数据库地址
	// 'DB_PORT'	=> '',				//数据库端口
	// 'DB_NAME'	=> 'qmsb',		//数据库名
	// 'DB_USER'	=> 'qmsb',			//数据库用户名
	// 'DB_PWD'	=> 'qmsb2016',				//数据库密码
	// 'DB_PREFIX' => 't_',			//数据表前缀

	// 'DB_HOST'	=> 'localhost',		//数据库地址
	// 'DB_PORT'	=> '',				//数据库端口
	// 'DB_NAME'	=> 'memberdata',		//数据库名
	// 'DB_USER'	=> 'root',			//数据库用户名
	// 'DB_PWD'	=> 'root',				//数据库密码
	// 'DB_PREFIX' => 't_',			//数据表前缀
	'DB_BACKUP'	=>	"Databack/",	//数据库备份路径
	'DB_BACKUP_SIZE'	=> "2048",	//数据分卷大小（用于系统备份）

	'TOP_PASSWORD'		=>	md5("tthq8.com@2016"), 
	//设置模板路径
	'TMPL_FILE_DEPR'	=> '_',
	//设置路径后缀
	'URL_HTML_SUFFIX' => '',

);
?>