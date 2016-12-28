<?php
$con = mysql_connect("localhost","root","root");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }



// Create table in my_db database
mysql_select_db("ttcms", $con);
$sql = "CREATE TABLE t_news (
id int(15) NOT NULL AUTO_INCREMENT,
title varchar(255) NULL COMMENT '标题',
thumb VARCHAR(255) NULL COMMENT '缩略图',
`seo_title` VARCHAR(255)  NULL COMMENT 'SEO标题',
`seo_des` text  NULL COMMENT 'SEO描述',
`seo_key` VARCHAR(255)  NULL COMMENT 'SEO关键词',
`content` TEXT  NULL COMMENT '内容',
`hits` INT(6) DEFAULT '0' NOT NULL COMMENT '点击数',
PRIMARY KEY (`id`)
)";
// $sql = "DROP TABLE IF EXISTS `t_news`;
// CREATE TABLE t_news(
// id int(10) NOT NULL AUTO_INCREMENT,
// title VARCHAR(255) NULL COMMENT '标题',
// thumb VARCHAR(255) NULL COMMENT '缩略图',
// `seo_title` VARCHAR(255)  NULL COMMENT 'SEO标题',
// `seo_des` text  NULL COMMENT 'SEO描述',
// `seo_key` VARCHAR(255)  NULL COMMENT 'SEO关键词',
// `content` TEXT  NULL COMMENT '内容',
// `hits` INT(6) DEFAULT '0' NOT NULL COMMENT '点击数',
// PRIMARY KEY (`id`)
// ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='新闻模型';";

// Create database
if (mysql_query($sql,$con))
  {
  echo "TABLE created";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }

mysql_close($con);
?>