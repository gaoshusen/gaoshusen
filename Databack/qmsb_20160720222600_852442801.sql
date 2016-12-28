
/* -- Created by MySQLReback class, Power By TTHQ
 -- Http://www.tthq8.com
 -- 主机: localhost
 -- 生成日期: 2016 年  07 月 20 日 22:26
 -- MySQL版本: 5.6.26-log
 -- PHP 版本: 5.3.29
 -- 
 -- 数据库: `qmsb`
 ---------------------------------------------------*/

 /* 创建表结构 `t_aboutus` */
 DROP TABLE IF EXISTS `t_aboutus`;/* MySQLReback Separation */ CREATE TABLE `t_aboutus` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL COMMENT '标题',
  `des` text COMMENT '简述',
  `content` text COMMENT '内容',
  `webtp` int(4) NOT NULL COMMENT '类型(0,普通单页；1,列表页)',
  `addtime` int(12) NOT NULL COMMENT '发布时间',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '状态(1,正常;0,停用)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='关于我们';/* MySQLReback Separation */
 /* 插入数据 `t_aboutus` */
 INSERT INTO `t_aboutus` VALUES ('1','关于我们','关于我们的简述信息','&lt;p&gt;技术支持：&lt;a href=&quot;http://3385054534@qq.com&quot; target=&quot;_self&quot;&gt;3385054534@qq.com&lt;/a&gt;&lt;/p&gt;','0','0','1'),('6','用户协议','全民私包用户协议','&lt;p&gt;xxxx手机客户端（以下简称“xxxx”）是xxxxxxxx提供的，在使用前，请务必认真阅读和理解《xxxx许可使用协议》（以下简称《协议》）中规定的所有权利和限制。除非您接受本《协议》条款，否则您无权下载、安装或使用本“xxxx”及其相关服务。您一旦安装、复制、下载、访问或以其它方式使用xxxx产品，将视为对本《协议》的接受，即表示您同意接受本《协议》各项条款的约束。如果您不同意本《协议》中的条款，请不要安装、复制或使用xxxx手机客户端软件。本《协议》是用户与xxxxxxxx之间关于用户下载、安装、使用、复制的法律协议。&lt;/p&gt;&lt;p&gt;一、总则&lt;/p&gt;&lt;p&gt;1.1本《协议》双方为xxxxxxxx与xxxx用户，本《协议》具有合同效力。&lt;/p&gt;&lt;p&gt;1.2自xxxx用户首次注册“xxxx”使用账号时起，本《协议》即在xxxxxxxx和xxxx用户之间产生法律效力。&lt;/p&gt;','0','1467013417','1'),('7','用户说明22222','用户说明用户说明2222222用户说明用户说明用户说明用户说明用户说明用户说明用户说明','&lt;p&gt;用户说明用户说明用户说明大规模用户载 魂牵梦萦土木工程说明用户说明用户说明用户说明用户说明用户说明&lt;/p&gt;','0','1467013572','1'),('8','如何提现22','如何提现如何提现如何提现如何提现如何提现如何提现222','&lt;p&gt;如何提现如何提现如何提现2222如何提现如何提现如何提现如何提现&lt;/p&gt;','1','1467013701','1'),('9','如何注册','如何注册如何注册如何注册如何注册如何注册如何注册如何注册如何注册如何注册如何注册如何注册','&lt;p&gt;如何注册如何注册如何注册如何注册如何注册如何注册如何注册如何注册&lt;/p&gt;','1','1467014153','1'),('11','如何升级？','升级的简述说明','&lt;p&gt;升级的简述说明&lt;/p&gt;','1','1467014235','1');/* MySQLReback Separation */
 /* 插入数据 `t_aboutus` */
 INSERT INTO `t_aboutus` VALUES ('13','隐私政策','全民私包隐私政策','&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;引言&amp;nbsp;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;全民私包重视用户的隐私，隐私权是您重要的权利。您在使用我们的服务时，我们可能会收集和使用您的相关信息。我们希望通过本《隐私政策》向您说明，在使用我们的服务时，我们如何收集、使用、储存和分享这些信息，以及我们为您提供的访问、更新、控制和保护这些信息的方式。本《隐私政策》与您所使用的其明服务息息相关，希望您仔细阅读，在需要时，按照本《隐私政策》的指引，作出您认为适当的选择。本《隐私政策》中涉及的相关技术词汇，我们尽量以简明扼要的表述，并提供进一步说明的链接，以便您的理解。&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;您使用或继续使用我们的服务，即意味着同意我们按照本《隐私政策》收集、使用、储存和分享您的相关信息。&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;如对本《隐私政策》或相关事宜有任何问题，请通过188660666@qq.com与我们联系。&amp;nbsp;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;我们可能收集的信息&amp;nbsp;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;我们提供服务时，可能会收集、储存和使用下列与您有关的信息。如果您不提供相关信息，可能无法注册成为我们的用户或无法享受我们提供的某些服务，或者无法达到相关服务拟达到的效果。&amp;nbsp;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&lt;br/&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;您提供的信息 &amp;nbsp;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;您在注册账户或使用我们的服务时，向我们提供的相关个人信息，例如电话号码、电子邮件或银行卡号等； &amp;nbsp;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;您通过我们的服务向其他方提供的共享信息，以及您使用我们的服务时所储存的信息。 &amp;nbsp;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;其他方分享的您的信息&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;其他方使用我们的服务时所提供有关您的共享信息。&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;我们获取的您的信息&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;您使用服务时我们可能收集如下信息：&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;日志信息，指您使用我们的服务时，系统可能通过cookies、web beacon或其他方式自动采集的技术信息，包括：设备或软件信息，例如您的移动设备、网页浏览器或用于接入我们服务的其他程序所提供的配置信息、您的IP地址和移动设备所用的版本和设备识别码；&amp;nbsp;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;在使用我们服务时搜索或浏览的信息，例如您使用的网页搜索词语、访问的社交媒体页url地址，以及您在使用我们服务时浏览或要求提供的其他信息和内容详情；有关您曾使用的移动应用（APP）和其他软件的信息，以及您曾经使用该等移动应用和软件的信息； &amp;nbsp;您通过我们的服务进行通讯的信息，例如曾通讯的账号，以及通讯时间、数据和时长； &amp;nbsp;位置信息，指您开启设备定位功能并使用我们基于位置提供的相关服务时，收集的有关您位置的信息，包括：&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;您通过具有定位功能的移动设备使用我们的服务时，通过GPS或 WiFi等方式收集的您的地理位置信息；&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;您或其他用户提供的包含您所处地理位置的实时信息，例如您提供的 账户信息中包含的您所在地区信息，您或其他人上传的显示您当前或曾经所处地理位置的共享信息，您或其他人共享的照片包含的地理标记信息； &amp;nbsp;您可以通过关闭定位功能，停止对您的地理位置信息的收集。&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;我们可能如何使用信息&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;我们可能将在向您提供服务的过程之中所收集的信息用作下列用途：  向您提供服务；&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;在我们提供服务时，用于身份验证、客户服务、安全防范、诈骗监 测、存档和备份用途，确保我们向您提供的产品和服务的安全性；&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;帮助我们设计新服务，改善我们现有服务；使我们更加了解您如何接 入和使用我们的服务，从而针对性地回应您的个性化需求，例如语言设定、 位置设定、个性化的帮助服务和指示，或对您和其他用户作出其他方面的回应；&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;向您提供与您更加相关的广告以替代普遍投放的广告；评估我们服务 中的广告和其他促销及推广活动的效果，并加以改善；软件认证或管理软件升级；让您参与有关我们产品和服务的调查。&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;为了让您有更好的体验、改善我们的服务或您同意的其他用途，在符合相关法律法规的前提下，我们可能将通过某一项服务所收集的信息，以汇集信息或者个性化的方式，用于我们的其他服务。例如，在您使用我们的一项服务时所收集的信息，可能在另一服务中用于向您提供特定内容，或向您展示与您相&lt;/span&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;关的、非普遍推送的信息。如果我们在相关服务中提供了相应选项，您也可以授权我们将该服务所提供和储存的信息用于我们的其他服务。&amp;nbsp;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;您如何访问和控制自己的个人信息&amp;nbsp;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;我们将尽一切可能采取适当的技术手段，保证您可以访问、更新和更正自己的注册信息或使用我们的服务时提供的其他个人信息。在访问、更新、更正和删除前述信息时，我们可能会要求您进行身份验证，以保障账户安全。&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;我们可能分享的信息&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;除以下情形外，未经您同意，我们以及我们的关联公司不会与任何第三方分享您的个人信息。&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;我们以及我们的关联公司，可能将您的个人信息与我们的关联公司、合作伙伴及第三方服务供应商、承包商及代理（例如代表我们发出电子邮件或推送通知的通讯服务提供商、为我们提供位置数据的地图服务供应商）分享（他们可能并非位于您所在的法域），用作下列用途：&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;向您提供我们的服务；&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;实现“我们可能如何使用信息”部分所述目的；&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;履行我们在本《隐私政策》中的义务和行使我们 的权利；&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;理解、维护和改善我们的服务。&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;如我们或我们的关联公司与任何上述第三方分享您的个人信息，我们将努力确保该等第三方在使用您的个人信息时遵守本《隐私政策》及我们要求其遵守的其他适当的保密和安全措施。&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;随着我们业务的持续发展，我们以及我们的关联公司有可能进行合并、收购、资产转让或类似的交易，您的个人信息有可能作为此类交易的一部分而被转移。我们将在转移前通知您。&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;我们或我们的关联公司还可能为以下需要而保留、保存或披露您的个人信息：&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;遵守适用的法律法规；&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;遵守法院命令或其他法律程序的规定；&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;遵守相关政府机关的要求。&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 微软雅黑, &amp;quot;Microsoft YaHei&amp;quot;;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;为遵守适用的法律法规、维护社会公共利益，或保护我们的客户、我们或我们的集团公司、其他用户或雇员的人身和财产安全或合法权益所合理必需的用途。&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;','0','1468407432','1');/* MySQLReback Separation */
 /* 创建表结构 `t_ad` */
 DROP TABLE IF EXISTS `t_ad`;/* MySQLReback Separation */ CREATE TABLE `t_ad` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `thumb` varchar(255) DEFAULT NULL COMMENT '缩略图',
  `seo_title` varchar(255) DEFAULT NULL COMMENT 'SEO标题',
  `seo_des` text COMMENT 'SEO描述',
  `seo_key` varchar(255) DEFAULT NULL COMMENT 'SEO关键词',
  `description` text COMMENT '简述',
  `content` text COMMENT '内容',
  `hits` int(6) NOT NULL DEFAULT '0' COMMENT '点击数',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `editime` int(11) DEFAULT '0' COMMENT '编辑时间',
  `sort` int(11) DEFAULT '0' COMMENT '排序序号',
  `s_time` varchar(12) DEFAULT NULL COMMENT '开始时间',
  `e_time` varchar(12) DEFAULT NULL COMMENT '到期时间',
  `status` int(2) DEFAULT NULL COMMENT '是否启用',
  `uid` int(11) DEFAULT NULL COMMENT '发布人',
  `url` varchar(255) DEFAULT NULL COMMENT '广告链接',
  `mphoto` varchar(255) DEFAULT NULL COMMENT '广告主图',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='广告模型[创建模型时系统创建的表]';/* MySQLReback Separation */
 /* 创建表结构 `t_article` */
 DROP TABLE IF EXISTS `t_article`;/* MySQLReback Separation */ CREATE TABLE `t_article` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `tid` int(4) NOT NULL COMMENT '类别ID，关联自t_type',
  `cid` int(4) NOT NULL COMMENT '频道ID，关联自t_channel',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `thumb` varchar(200) DEFAULT NULL COMMENT '缩略图',
  `keywords` varchar(200) DEFAULT NULL COMMENT '关键字',
  `description` text COMMENT '描述',
  `commend` int(4) NOT NULL DEFAULT '0' COMMENT '推荐类型。0为不推荐，1为推荐，可视项目需求另行设置更多',
  `url` varchar(200) DEFAULT NULL COMMENT '文章路径',
  `wrtime` varchar(20) NOT NULL COMMENT '发布时间，以10位时间戳存储',
  `hits` int(10) NOT NULL COMMENT '点击数量',
  `content` text COMMENT '文章正文，以URL编码后保存',
  `sort` int(4) DEFAULT NULL COMMENT '排序序号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章数据表';/* MySQLReback Separation */
 /* 创建表结构 `t_auth` */
 DROP TABLE IF EXISTS `t_auth`;/* MySQLReback Separation */ CREATE TABLE `t_auth` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `rid` int(4) NOT NULL COMMENT '角色ID，关联自t_role',
  `mid` int(4) NOT NULL COMMENT '目录ID，关联自t_menu.多个mid以","隔开',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COMMENT='权限分配表';/* MySQLReback Separation */
 /* 插入数据 `t_auth` */
 INSERT INTO `t_auth` VALUES ('15','4','25'),('14','4','24'),('13','4','23'),('12','4','22'),('11','4','15'),('10','4','12'),('16','4','1'),('17','4','33'),('18','4','34'),('19','4','41'),('20','4','42'),('21','4','44'),('22','4','45'),('23','3','12'),('24','3','14'),('25','3','18'),('26','3','19'),('27','3','20'),('28','3','21'),('29','3','1'),('30','3','33'),('31','3','34'),('32','3','41'),('33','3','42'),('34','3','44'),('35','3','45'),('45','1','58'),('44','1','57'),('43','1','34'),('42','1','33'),('41','1','1'),('46','1','7'),('47','1','8'),('48','7','82'),('49','7','83'),('50','7','84'),('51','7','41'),('52','7','42'),('53','7','44'),('54','7','45'),('55','6','74'),('56','6','75'),('57','6','76'),('58','6','77'),('59','6','78'),('60','6','79'),('61','6','80'),('62','6','81'),('63','6','41'),('64','6','42'),('65','6','44'),('66','6','45');/* MySQLReback Separation */
 /* 创建表结构 `t_bill` */
 DROP TABLE IF EXISTS `t_bill`;/* MySQLReback Separation */ CREATE TABLE `t_bill` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `fromID` int(12) NOT NULL COMMENT '来方ID（0为系统官方）',
  `toID` int(12) NOT NULL COMMENT '去方ID（0为系统官方）',
  `type` int(2) DEFAULT '0' COMMENT '账单类型（0:红包，1:转账，2:提现，3:转账，4:签到，5:升级）',
  `billtp` varchar(50) DEFAULT NULL COMMENT '账单内容物类型（mny：现金，paper：升级券）',
  `billnum` decimal(10,2) DEFAULT NULL COMMENT '账单涉及内容物数量',
  `ordid` int(12) NOT NULL COMMENT '相关订单ID(如为红包则为红包ID，如为签到则为0，其余为各类型对应表ID)',
  `billtime` int(12) NOT NULL COMMENT '账单发生时间',
  `smark` text COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='来往账单表';/* MySQLReback Separation */
 /* 创建表结构 `t_channel` */
 DROP TABLE IF EXISTS `t_channel`;/* MySQLReback Separation */ CREATE TABLE `t_channel` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `model` varchar(100) NOT NULL COMMENT '内容模型',
  `type` int(4) NOT NULL DEFAULT '0' COMMENT '栏目类型(0为列表，1为链接)',
  `mid` int(4) NOT NULL COMMENT '内容模型ID',
  `pid` int(4) NOT NULL DEFAULT '0' COMMENT '上级栏目ID',
  `mark` varchar(100) NOT NULL DEFAULT '0' COMMENT '栏目标识符',
  `name` varchar(200) NOT NULL COMMENT '栏目名称',
  `nick` varchar(200) DEFAULT NULL COMMENT '栏目别称',
  `dir` varchar(200) DEFAULT NULL COMMENT '附加参数',
  `thumb` varchar(200) DEFAULT NULL COMMENT '栏目图片',
  `url` varchar(200) DEFAULT NULL COMMENT '栏目路径',
  `sort` int(4) NOT NULL DEFAULT '0' COMMENT '栏目排序',
  `is_show` int(4) NOT NULL DEFAULT '1' COMMENT '是否显示，1为显示，0为隐藏',
  `is_target` int(4) NOT NULL DEFAULT '0' COMMENT '是否新窗口打开。1为是，0为否',
  `seo_title` varchar(200) DEFAULT NULL COMMENT 'SEO标题',
  `seo_key` varchar(200) DEFAULT NULL COMMENT 'SEO关键字',
  `seo_des` text COMMENT 'SEO描述',
  `pgsize` int(4) DEFAULT '20' COMMENT '列表页数据条数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='前台栏目表';/* MySQLReback Separation */
 /* 插入数据 `t_channel` */
 INSERT INTO `t_channel` VALUES ('1','sys','0','0','0','0','首页','Home','/','','','0','1','0','','','','20'),('2','news','0','1','0','0','资讯中心','News','index.php/News/lists','','','0','1','0','','','','20'),('3','news','0','1','2','0','行业资讯','HY News','index.php/News/lists/cid/1','','','0','1','0','','','','20'),('4','news','0','1','2','0','企业新闻','QY News','index.php/News/lists/cid/2','','','0','1','0','','','','20'),('5','product','0','2','0','0','产品中心','Products','index.php/Product/lists','','','0','1','0','','','','20'),('6','product','0','2','5','222','鞋类','Shoes','index.php/Product/lists/cid/1','','','0','1','0','其它产品-我们是大自然的搬运工','产品,农夫,山泉,有点田,哈哈','其它产品-我们是大自然的搬运工其它产品-我们是大自然的搬运工其它产品-我们是大自然的搬运工其它产品-我们是大自然的搬运工','20'),('7','product','0','2','5','0','服装','Clothes','index.php/Product/lists/cid/2','','','0','1','0','','','','20'),('9','single','1','0','0','ctus','联系我们','Contact us','','','#Site_root#/Single/show/id/1','0','1','0','联系我们 - TTCMS2.0   来自资深PHP攻城狮的倾情奉献','联系,方式,TTCMS,偷天,换钱,PHP,Bootstrap,Html5,响应式',' 来自资深PHP攻城狮偷天换钱【原名偷天换芪】的倾情奉献','20'),('10','product','0','0','5','5','其它产品','Other','','','','1','1','0','其它产品-我们是大自然的搬运工','产品,大自然,搬运工,农夫,山泉,有点甜','其它产品-我们是大自然的搬运工','20'),('11','news','0','0','2','notice','公司公告','Notice','','','','0','0','1','公告-TTCMS','公告,勿谓,言之,不预也','公告-TTCMS公告-TTCMS公告-TTCMS公告-TTCMS','20');/* MySQLReback Separation */
 /* 创建表结构 `t_config` */
 DROP TABLE IF EXISTS `t_config`;/* MySQLReback Separation */ CREATE TABLE `t_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_name` varchar(200) DEFAULT NULL COMMENT '设置名称',
  `config_value` text COMMENT '设置内容(以JSON文本模式存储所有设置参数)',
  `config_tag` varchar(50) NOT NULL COMMENT '设置标识符',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='系统设置表';/* MySQLReback Separation */
 /* 插入数据 `t_config` */
 INSERT INTO `t_config` VALUES ('1','系统基础信息设置','{\"dftPWD\":\"123456\",\"dftSafe\":\"123456789\",\"WXappid\":\"wxb171b9af1140e29c\",\"WXappsecret\":\"89f4e4c76238d33ca536112a1ee347c0 \",\"WXtoken\":\"ttcms2016\",\"mny_lv1\":\"10\",\"mny_lv2\":\"20\",\"mny_lv3\":\"40\",\"mny_lv4\":\"80\",\"mny_lv5\":\"160\",\"0\":\"Admin\",\"1\":\"Set\",\"2\":\"savebasic\",\"copyrighter\":\"\"}','basic'),('3','系统业务信息设置','','system'),('2','邮箱信息设置','{\"status\":\"0\",\"service\":\"smtp.ym.163.com\",\"srvPort\":\"25\",\"smtpUsr\":\"sys@tthq8.com\",\"seo_key\":\"wqgyjh8890\",\"seo_desc\":\"sys@tthq8.com\",\"0\":\"Admin\",\"1\":\"Set\",\"2\":\"savemail\"}','mail');/* MySQLReback Separation */
 /* 创建表结构 `t_feedback` */
 DROP TABLE IF EXISTS `t_feedback`;/* MySQLReback Separation */ CREATE TABLE `t_feedback` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `typestr` varchar(100) NOT NULL COMMENT '留言类型',
  `content` text COMMENT '留言内容',
  `mid` int(10) NOT NULL COMMENT '发布人',
  `addtime` int(11) NOT NULL COMMENT '发布时间',
  `dotime` int(11) DEFAULT NULL COMMENT '处理时间',
  `dousr` int(11) DEFAULT NULL COMMENT '处理人',
  `domsg` text COMMENT '处理意见',
  `status` int(2) NOT NULL COMMENT '状态(0：待处理，1:已处理)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='意见反馈表';/* MySQLReback Separation */
 /* 创建表结构 `t_gift` */
 DROP TABLE IF EXISTS `t_gift`;/* MySQLReback Separation */ CREATE TABLE `t_gift` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `usrid` int(12) NOT NULL COMMENT '管理员ID',
  `mid` int(12) NOT NULL COMMENT '赠送至会员ID',
  `gift_tp` int(2) NOT NULL DEFAULT '0' COMMENT '赠送类型（0为升级券;1为现金）',
  `nums` decimal(10,2) NOT NULL COMMENT '赠送数量',
  `remark` text COMMENT '说明',
  `addtime` int(11) NOT NULL COMMENT '赠送时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统赠送表';/* MySQLReback Separation */
 /* 创建表结构 `t_icons` */
 DROP TABLE IF EXISTS `t_icons`;/* MySQLReback Separation */ CREATE TABLE `t_icons` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `icons` char(60) NOT NULL COMMENT '图标名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=863 DEFAULT CHARSET=utf8 COMMENT='系统图标表';/* MySQLReback Separation */
 /* 插入数据 `t_icons` */
 INSERT INTO `t_icons` VALUES ('1','fa-500px'),('2','fa-amazon'),('3','fa-balance-scale'),('4','fa-battery-0'),('5','fa-battery-1'),('6','fa-battery-2'),('7','fa-battery-3'),('8','fa-battery-4'),('9','fa-battery-empty'),('10','fa-battery-full'),('11','fa-battery-half'),('12','fa-battery-quarter'),('13','fa-battery-three-quarters'),('14','fa-black-tie'),('15','fa-calendar-check-o'),('16','fa-calendar-minus-o'),('17','fa-calendar-plus-o'),('18','fa-calendar-times-o'),('19','fa-cc-diners-club'),('20','fa-cc-jcb'),('21','fa-chrome'),('22','fa-clone'),('23','fa-commenting'),('24','fa-commenting-o'),('25','fa-contao'),('26','fa-creative-commons'),('27','fa-expeditedssl'),('28','fa-firefox'),('29','fa-fonticons'),('30','fa-genderless'),('31','fa-get-pocket'),('32','fa-gg'),('33','fa-gg-circle'),('34','fa-hand-grab-o'),('35','fa-hand-lizard-o'),('36','fa-hand-paper-o'),('37','fa-hand-peace-o'),('38','fa-hand-pointer-o'),('39','fa-hand-rock-o'),('40','fa-hand-scissors-o'),('41','fa-hand-spock-o'),('42','fa-hand-stop-o'),('43','fa-hourglass'),('44','fa-hourglass-1'),('45','fa-hourglass-2'),('46','fa-hourglass-3'),('47','fa-hourglass-end'),('48','fa-hourglass-half'),('49','fa-hourglass-o'),('50','fa-hourglass-start'),('51','fa-houzz'),('52','fa-i-cursor'),('53','fa-industry'),('54','fa-internet-explorer'),('55','fa-map'),('56','fa-map-o'),('57','fa-map-pin'),('58','fa-map-signs'),('59','fa-mouse-pointer'),('60','fa-object-group'),('61','fa-object-ungroup'),('62','fa-odnoklassniki'),('63','fa-odnoklassniki-square'),('64','fa-opencart'),('65','fa-opera'),('66','fa-optin-monster'),('67','fa-registered'),('68','fa-safari'),('69','fa-sticky-note'),('70','fa-sticky-note-o'),('71','fa-television'),('72','fa-trademark'),('73','fa-tripadvisor'),('74','fa-tv'),('75','fa-vimeo'),('76','fa-wikipedia-w'),('77','fa-y-combinator'),('78','fa-yc'),('79','fa-adjust'),('80','fa-anchor'),('81','fa-archive'),('82','fa-area-chart'),('83','fa-arrows'),('84','fa-arrows-h'),('85','fa-arrows-v'),('86','fa-asterisk'),('87','fa-at'),('88','fa-automobile'),('89','fa-balance-scale'),('90','fa-ban'),('91','fa-bank'),('92','fa-bar-chart'),('93','fa-bar-chart-o'),('94','fa-barcode'),('95','fa-bars'),('96','fa-battery-0'),('97','fa-battery-1'),('98','fa-battery-2'),('99','fa-battery-3'),('100','fa-battery-4'),('101','fa-battery-empty'),('102','fa-battery-full'),('103','fa-battery-half'),('104','fa-battery-quarter'),('105','fa-battery-three-quarters'),('106','fa-bed'),('107','fa-beer'),('108','fa-bell'),('109','fa-bell-o'),('110','fa-bell-slash'),('111','fa-bell-slash-o'),('112','fa-bicycle'),('113','fa-binoculars'),('114','fa-birthday-cake'),('115','fa-bolt'),('116','fa-bomb'),('117','fa-book'),('118','fa-bookmark'),('119','fa-bookmark-o'),('120','fa-briefcase'),('121','fa-bug'),('122','fa-building'),('123','fa-building-o'),('124','fa-bullhorn'),('125','fa-bullseye'),('126','fa-bus'),('127','fa-cab'),('128','fa-calculator'),('129','fa-calendar'),('130','fa-calendar-check-o'),('131','fa-calendar-minus-o'),('132','fa-calendar-o'),('133','fa-calendar-plus-o'),('134','fa-calendar-times-o'),('135','fa-camera'),('136','fa-camera-retro'),('137','fa-car'),('138','fa-caret-square-o-down'),('139','fa-caret-square-o-left'),('140','fa-caret-square-o-right'),('141','fa-caret-square-o-up'),('142','fa-cart-arrow-down'),('143','fa-cart-plus'),('144','fa-cc'),('145','fa-certificate'),('146','fa-check'),('147','fa-check-circle'),('148','fa-check-circle-o'),('149','fa-check-square'),('150','fa-check-square-o'),('151','fa-child'),('152','fa-circle'),('153','fa-circle-o'),('154','fa-circle-o-notch'),('155','fa-circle-thin'),('156','fa-clock-o'),('157','fa-clone'),('158','fa-close'),('159','fa-cloud'),('160','fa-cloud-download'),('161','fa-cloud-upload'),('162','fa-code'),('163','fa-code-fork'),('164','fa-coffee'),('165','fa-cog'),('166','fa-cogs'),('167','fa-comment'),('168','fa-comment-o'),('169','fa-commenting'),('170','fa-commenting-o'),('171','fa-comments'),('172','fa-comments-o'),('173','fa-compass'),('174','fa-copyright'),('175','fa-creative-commons'),('176','fa-credit-card'),('177','fa-crop'),('178','fa-crosshairs'),('179','fa-cube'),('180','fa-cubes'),('181','fa-cutlery'),('182','fa-dashboard'),('183','fa-database'),('184','fa-desktop'),('185','fa-diamond'),('186','fa-dot-circle-o'),('187','fa-download'),('188','fa-edit'),('189','fa-ellipsis-h'),('190','fa-ellipsis-v'),('191','fa-envelope'),('192','fa-envelope-o'),('193','fa-envelope-square'),('194','fa-eraser'),('195','fa-exchange'),('196','fa-exclamation'),('197','fa-exclamation-circle'),('198','fa-exclamation-triangle'),('199','fa-external-link'),('200','fa-external-link-square'),('201','fa-eye'),('202','fa-eye-slash'),('203','fa-eyedropper'),('204','fa-fax'),('205','fa-feed'),('206','fa-female'),('207','fa-fighter-jet'),('208','fa-file-archive-o'),('209','fa-file-audio-o'),('210','fa-file-code-o'),('211','fa-file-excel-o'),('212','fa-file-image-o'),('213','fa-file-movie-o'),('214','fa-file-pdf-o'),('215','fa-file-photo-o'),('216','fa-file-picture-o'),('217','fa-file-powerpoint-o'),('218','fa-file-sound-o'),('219','fa-file-video-o'),('220','fa-file-word-o'),('221','fa-file-zip-o'),('222','fa-film'),('223','fa-filter'),('224','fa-fire'),('225','fa-fire-extinguisher'),('226','fa-flag'),('227','fa-flag-checkered'),('228','fa-flag-o'),('229','fa-flash'),('230','fa-flask');/* MySQLReback Separation */
 /* 插入数据 `t_icons` */
 INSERT INTO `t_icons` VALUES ('231','fa-folder');/* MySQLReback Separation */
 /* 插入数据 `t_icons` */
 INSERT INTO `t_icons` VALUES ('232','fa-folder-o'),('233','fa-folder-open'),('234','fa-folder-open-o'),('235','fa-frown-o'),('236','fa-futbol-o'),('237','fa-gamepad'),('238','fa-gavel'),('239','fa-gear'),('240','fa-gears'),('241','fa-gift'),('242','fa-glass'),('243','fa-globe'),('244','fa-graduation-cap'),('245','fa-group'),('246','fa-hand-grab-o'),('247','fa-hand-lizard-o'),('248','fa-hand-paper-o'),('249','fa-hand-peace-o'),('250','fa-hand-pointer-o'),('251','fa-hand-rock-o'),('252','fa-hand-scissors-o'),('253','fa-hand-spock-o'),('254','fa-hand-stop-o'),('255','fa-hdd-o'),('256','fa-headphones'),('257','fa-heart'),('258','fa-heart-o'),('259','fa-heartbeat'),('260','fa-history'),('261','fa-home'),('262','fa-hotel'),('263','fa-hourglass'),('264','fa-hourglass-1'),('265','fa-hourglass-2'),('266','fa-hourglass-3'),('267','fa-hourglass-end'),('268','fa-hourglass-half'),('269','fa-hourglass-o'),('270','fa-hourglass-start'),('271','fa-i-cursor'),('272','fa-image'),('273','fa-inbox'),('274','fa-industry'),('275','fa-info'),('276','fa-info-circle'),('277','fa-institution'),('278','fa-key'),('279','fa-keyboard-o'),('280','fa-language'),('281','fa-laptop'),('282','fa-leaf'),('283','fa-legal'),('284','fa-lemon-o'),('285','fa-level-down'),('286','fa-level-up'),('287','fa-life-bouy'),('288','fa-life-buoy'),('289','fa-life-ring'),('290','fa-life-saver'),('291','fa-lightbulb-o'),('292','fa-line-chart'),('293','fa-location-arrow'),('294','fa-lock'),('295','fa-magic'),('296','fa-magnet'),('297','fa-mail-forward'),('298','fa-mail-reply'),('299','fa-mail-reply-all'),('300','fa-male'),('301','fa-map'),('302','fa-map-marker'),('303','fa-map-o'),('304','fa-map-pin'),('305','fa-map-signs'),('306','fa-meh-o'),('307','fa-microphone'),('308','fa-microphone-slash'),('309','fa-minus'),('310','fa-minus-circle'),('311','fa-minus-square'),('312','fa-minus-square-o'),('313','fa-mobile'),('314','fa-mobile-phone'),('315','fa-money'),('316','fa-moon-o'),('317','fa-mortar-board'),('318','fa-motorcycle'),('319','fa-mouse-pointer'),('320','fa-music'),('321','fa-navicon'),('322','fa-newspaper-o'),('323','fa-object-group'),('324','fa-object-ungroup'),('325','fa-paint-brush'),('326','fa-paper-plane'),('327','fa-paper-plane-o'),('328','fa-paw'),('329','fa-pencil'),('330','fa-pencil-square'),('331','fa-pencil-square-o'),('332','fa-phone'),('333','fa-phone-square'),('334','fa-photo'),('335','fa-picture-o'),('336','fa-pie-chart'),('337','fa-plane'),('338','fa-plug'),('339','fa-plus'),('340','fa-plus-circle'),('341','fa-plus-square'),('342','fa-plus-square-o'),('343','fa-power-off'),('344','fa-print'),('345','fa-puzzle-piece'),('346','fa-qrcode'),('347','fa-question'),('348','fa-question-circle'),('349','fa-quote-left'),('350','fa-quote-right'),('351','fa-random'),('352','fa-recycle'),('353','fa-refresh'),('354','fa-registered'),('355','fa-remove'),('356','fa-reorder'),('357','fa-reply'),('358','fa-reply-all'),('359','fa-retweet'),('360','fa-road'),('361','fa-rocket'),('362','fa-rss'),('363','fa-rss-square'),('364','fa-search'),('365','fa-search-minus'),('366','fa-search-plus'),('367','fa-send'),('368','fa-send-o'),('369','fa-server'),('370','fa-share'),('371','fa-share-alt'),('372','fa-share-alt-square'),('373','fa-share-square'),('374','fa-share-square-o'),('375','fa-shield'),('376','fa-ship'),('377','fa-shopping-cart'),('378','fa-sign-in'),('379','fa-sign-out'),('380','fa-signal'),('381','fa-sitemap'),('382','fa-sliders'),('383','fa-smile-o'),('384','fa-soccer-ball-o'),('385','fa-sort'),('386','fa-sort-alpha-asc'),('387','fa-sort-alpha-desc'),('388','fa-sort-amount-asc'),('389','fa-sort-amount-desc'),('390','fa-sort-asc'),('391','fa-sort-desc'),('392','fa-sort-down'),('393','fa-sort-numeric-asc'),('394','fa-sort-numeric-desc'),('395','fa-sort-up'),('396','fa-space-shuttle'),('397','fa-spinner'),('398','fa-spoon'),('399','fa-square'),('400','fa-square-o'),('401','fa-star'),('402','fa-star-half'),('403','fa-star-half-empty'),('404','fa-star-half-full'),('405','fa-star-half-o'),('406','fa-star-o'),('407','fa-sticky-note'),('408','fa-sticky-note-o'),('409','fa-street-view'),('410','fa-suitcase'),('411','fa-sun-o'),('412','fa-support'),('413','fa-tablet'),('414','fa-tachometer'),('415','fa-tag'),('416','fa-tags'),('417','fa-tasks'),('418','fa-taxi'),('419','fa-television'),('420','fa-terminal'),('421','fa-thumb-tack'),('422','fa-thumbs-down'),('423','fa-thumbs-o-down'),('424','fa-thumbs-o-up'),('425','fa-thumbs-up'),('426','fa-ticket'),('427','fa-times'),('428','fa-times-circle'),('429','fa-times-circle-o'),('430','fa-tint'),('431','fa-toggle-down'),('432','fa-toggle-left'),('433','fa-toggle-off'),('434','fa-toggle-on'),('435','fa-toggle-right'),('436','fa-toggle-up'),('437','fa-trademark'),('438','fa-trash'),('439','fa-trash-o'),('440','fa-tree'),('441','fa-trophy'),('442','fa-truck'),('443','fa-tty'),('444','fa-tv'),('445','fa-umbrella'),('446','fa-university'),('447','fa-unlock'),('448','fa-unlock-alt'),('449','fa-unsorted'),('450','fa-upload'),('451','fa-user'),('452','fa-user-plus'),('453','fa-user-secret'),('454','fa-user-times'),('455','fa-users'),('456','fa-video-camera'),('457','fa-volume-down'),('458','fa-volume-off'),('459','fa-volume-up'),('460','fa-warning'),('461','fa-wheelchair'),('462','fa-wifi'),('463','fa-wrench'),('464','fa-hand-grab-o'),('465','fa-hand-lizard-o'),('466','fa-hand-o-down');/* MySQLReback Separation */
 /* 插入数据 `t_icons` */
 INSERT INTO `t_icons` VALUES ('467','fa-hand-o-left');/* MySQLReback Separation */
 /* 插入数据 `t_icons` */
 INSERT INTO `t_icons` VALUES ('468','fa-hand-o-right'),('469','fa-hand-o-up'),('470','fa-hand-paper-o'),('471','fa-hand-peace-o'),('472','fa-hand-pointer-o'),('473','fa-hand-rock-o'),('474','fa-hand-scissors-o'),('475','fa-hand-spock-o'),('476','fa-hand-stop-o'),('477','fa-thumbs-down'),('478','fa-thumbs-o-down'),('479','fa-thumbs-o-up'),('480','fa-thumbs-up'),('481','fa-ambulance'),('482','fa-automobile'),('483','fa-bicycle'),('484','fa-bus'),('485','fa-cab'),('486','fa-car'),('487','fa-fighter-jet'),('488','fa-motorcycle'),('489','fa-plane'),('490','fa-rocket'),('491','fa-ship'),('492','fa-space-shuttle'),('493','fa-subway'),('494','fa-taxi'),('495','fa-train'),('496','fa-truck'),('497','fa-wheelchair'),('498','fa-genderless'),('499','fa-intersex'),('500','fa-mars'),('501','fa-mars-double'),('502','fa-mars-stroke'),('503','fa-mars-stroke-h'),('504','fa-mars-stroke-v'),('505','fa-mercury'),('506','fa-neuter'),('507','fa-transgender'),('508','fa-transgender-alt'),('509','fa-venus'),('510','fa-venus-double'),('511','fa-venus-mars'),('512','fa-file'),('513','fa-file-archive-o'),('514','fa-file-audio-o'),('515','fa-file-code-o'),('516','fa-file-excel-o'),('517','fa-file-image-o'),('518','fa-file-movie-o'),('519','fa-file-o'),('520','fa-file-pdf-o'),('521','fa-file-photo-o'),('522','fa-file-picture-o'),('523','fa-file-powerpoint-o'),('524','fa-file-sound-o'),('525','fa-file-text'),('526','fa-file-text-o'),('527','fa-file-video-o'),('528','fa-file-word-o'),('529','fa-file-zip-o'),('530','fa-circle-o-notch'),('531','fa-cog'),('532','fa-gear'),('533','fa-refresh'),('534','fa-spinner'),('535','fa-check-square'),('536','fa-check-square-o'),('537','fa-circle'),('538','fa-circle-o'),('539','fa-dot-circle-o'),('540','fa-minus-square'),('541','fa-minus-square-o'),('542','fa-plus-square'),('543','fa-plus-square-o'),('544','fa-square'),('545','fa-square-o'),('546','fa-cc-amex'),('547','fa-cc-diners-club'),('548','fa-cc-discover'),('549','fa-cc-jcb'),('550','fa-cc-mastercard'),('551','fa-cc-paypal'),('552','fa-cc-stripe'),('553','fa-cc-visa'),('554','fa-credit-card'),('555','fa-google-wallet'),('556','fa-paypal'),('557','fa-area-chart'),('558','fa-bar-chart'),('559','fa-bar-chart-o'),('560','fa-line-chart'),('561','fa-pie-chart'),('562','fa-bitcoin'),('563','fa-btc'),('564','fa-cny'),('565','fa-dollar'),('566','fa-eur'),('567','fa-euro'),('568','fa-gbp'),('569','fa-gg'),('570','fa-gg-circle'),('571','fa-ils'),('572','fa-inr'),('573','fa-jpy'),('574','fa-krw'),('575','fa-money'),('576','fa-rmb'),('577','fa-rouble'),('578','fa-rub'),('579','fa-ruble'),('580','fa-rupee'),('581','fa-shekel'),('582','fa-sheqel'),('583','fa-try'),('584','fa-turkish-lira'),('585','fa-usd'),('586','fa-won'),('587','fa-yen'),('588','fa-align-center'),('589','fa-align-justify'),('590','fa-align-left'),('591','fa-align-right'),('592','fa-bold'),('593','fa-chain'),('594','fa-chain-broken'),('595','fa-clipboard'),('596','fa-columns'),('597','fa-copy'),('598','fa-cut'),('599','fa-dedent'),('600','fa-eraser'),('601','fa-file'),('602','fa-file-o'),('603','fa-file-text'),('604','fa-file-text-o'),('605','fa-files-o'),('606','fa-floppy-o'),('607','fa-font'),('608','fa-header'),('609','fa-indent'),('610','fa-italic'),('611','fa-link'),('612','fa-list'),('613','fa-list-alt'),('614','fa-list-ol'),('615','fa-list-ul'),('616','fa-outdent'),('617','fa-paperclip'),('618','fa-paragraph'),('619','fa-paste'),('620','fa-repeat'),('621','fa-rotate-left'),('622','fa-rotate-right'),('623','fa-save'),('624','fa-scissors'),('625','fa-strikethrough'),('626','fa-subscript'),('627','fa-superscript'),('628','fa-table'),('629','fa-text-height'),('630','fa-text-width'),('631','fa-th'),('632','fa-th-large'),('633','fa-th-list'),('634','fa-underline'),('635','fa-undo'),('636','fa-unlink'),('637','fa-angle-double-down'),('638','fa-angle-double-left'),('639','fa-angle-double-right'),('640','fa-angle-double-up'),('641','fa-angle-down'),('642','fa-angle-left'),('643','fa-angle-right'),('644','fa-angle-up'),('645','fa-arrow-circle-down'),('646','fa-arrow-circle-left'),('647','fa-arrow-circle-o-down'),('648','fa-arrow-circle-o-left'),('649','fa-arrow-circle-o-right'),('650','fa-arrow-circle-o-up'),('651','fa-arrow-circle-right'),('652','fa-arrow-circle-up'),('653','fa-arrow-down'),('654','fa-arrow-left'),('655','fa-arrow-right'),('656','fa-arrow-up'),('657','fa-arrows'),('658','fa-arrows-alt'),('659','fa-arrows-h'),('660','fa-arrows-v'),('661','fa-caret-down'),('662','fa-caret-left'),('663','fa-caret-right'),('664','fa-caret-square-o-down'),('665','fa-caret-square-o-left'),('666','fa-caret-square-o-right'),('667','fa-caret-square-o-up'),('668','fa-caret-up'),('669','fa-chevron-circle-down'),('670','fa-chevron-circle-left'),('671','fa-chevron-circle-right'),('672','fa-chevron-circle-up'),('673','fa-chevron-down'),('674','fa-chevron-left'),('675','fa-chevron-right'),('676','fa-chevron-up'),('677','fa-exchange'),('678','fa-hand-o-down'),('679','fa-hand-o-left'),('680','fa-hand-o-right'),('681','fa-hand-o-up'),('682','fa-long-arrow-down'),('683','fa-long-arrow-left'),('684','fa-long-arrow-right'),('685','fa-long-arrow-up'),('686','fa-toggle-down'),('687','fa-toggle-left'),('688','fa-toggle-right'),('689','fa-toggle-up'),('690','fa-arrows-alt'),('691','fa-backward'),('692','fa-compress'),('693','fa-eject'),('694','fa-expand'),('695','fa-fast-backward');/* MySQLReback Separation */
 /* 插入数据 `t_icons` */
 INSERT INTO `t_icons` VALUES ('696','fa-fast-forward');/* MySQLReback Separation */
 /* 插入数据 `t_icons` */
 INSERT INTO `t_icons` VALUES ('697','fa-forward'),('698','fa-pause'),('699','fa-play'),('700','fa-play-circle'),('701','fa-play-circle-o'),('702','fa-random'),('703','fa-step-backward'),('704','fa-step-forward'),('705','fa-stop'),('706','fa-youtube-play'),('707','fa-500px'),('708','fa-adn'),('709','fa-amazon'),('710','fa-android'),('711','fa-angellist'),('712','fa-apple'),('713','fa-behance'),('714','fa-behance-square'),('715','fa-bitbucket'),('716','fa-bitbucket-square'),('717','fa-bitcoin'),('718','fa-black-tie'),('719','fa-btc'),('720','fa-buysellads'),('721','fa-cc-amex'),('722','fa-cc-diners-club'),('723','fa-cc-discover'),('724','fa-cc-jcb'),('725','fa-cc-mastercard'),('726','fa-cc-paypal'),('727','fa-cc-stripe'),('728','fa-cc-visa'),('729','fa-chrome'),('730','fa-codepen'),('731','fa-connectdevelop'),('732','fa-contao'),('733','fa-css3'),('734','fa-dashcube'),('735','fa-delicious'),('736','fa-deviantart'),('737','fa-digg'),('738','fa-dribbble'),('739','fa-dropbox'),('740','fa-drupal'),('741','fa-empire'),('742','fa-expeditedssl'),('743','fa-facebook'),('744','fa-facebook-f'),('745','fa-facebook-official'),('746','fa-facebook-square'),('747','fa-firefox'),('748','fa-flickr'),('749','fa-fonticons'),('750','fa-forumbee'),('751','fa-foursquare'),('752','fa-ge'),('753','fa-get-pocket'),('754','fa-gg'),('755','fa-gg-circle'),('756','fa-git'),('757','fa-git-square'),('758','fa-github'),('759','fa-github-alt'),('760','fa-github-square'),('761','fa-gittip'),('762','fa-google'),('763','fa-google-plus'),('764','fa-google-plus-square'),('765','fa-google-wallet'),('766','fa-gratipay'),('767','fa-hacker-news'),('768','fa-houzz'),('769','fa-html5'),('770','fa-instagram'),('771','fa-internet-explorer'),('772','fa-ioxhost'),('773','fa-joomla'),('774','fa-jsfiddle'),('775','fa-lastfm'),('776','fa-lastfm-square'),('777','fa-leanpub'),('778','fa-linkedin'),('779','fa-linkedin-square'),('780','fa-linux'),('781','fa-maxcdn'),('782','fa-meanpath'),('783','fa-medium'),('784','fa-odnoklassniki'),('785','fa-odnoklassniki-square'),('786','fa-opencart'),('787','fa-openid'),('788','fa-opera'),('789','fa-optin-monster'),('790','fa-pagelines'),('791','fa-paypal'),('792','fa-pied-piper'),('793','fa-pied-piper-alt'),('794','fa-pinterest'),('795','fa-pinterest-p'),('796','fa-pinterest-square'),('797','fa-qq'),('798','fa-ra'),('799','fa-rebel'),('800','fa-reddit'),('801','fa-reddit-square'),('802','fa-renren'),('803','fa-safari'),('804','fa-sellsy'),('805','fa-share-alt'),('806','fa-share-alt-square'),('807','fa-shirtsinbulk'),('808','fa-simplybuilt'),('809','fa-skyatlas'),('810','fa-skype'),('811','fa-slack'),('812','fa-slideshare'),('813','fa-soundcloud'),('814','fa-spotify'),('815','fa-stack-exchange'),('816','fa-stack-overflow'),('817','fa-steam'),('818','fa-steam-square'),('819','fa-stumbleupon'),('820','fa-stumbleupon-circle'),('821','fa-tencent-weibo'),('822','fa-trello'),('823','fa-tripadvisor'),('824','fa-tumblr'),('825','fa-tumblr-square'),('826','fa-twitch'),('827','fa-twitter'),('828','fa-twitter-square'),('829','fa-viacoin'),('830','fa-vimeo'),('831','fa-vimeo-square'),('832','fa-vine'),('833','fa-vk'),('834','fa-wechat'),('835','fa-weibo'),('836','fa-weixin'),('837','fa-whatsapp'),('838','fa-wikipedia-w'),('839','fa-windows'),('840','fa-wordpress'),('841','fa-xing'),('842','fa-xing-square'),('843','fa-y-combinator'),('844','fa-y-combinator-square'),('845','fa-yahoo'),('846','fa-yc'),('847','fa-yc-square'),('848','fa-yelp'),('849','fa-youtube'),('850','fa-youtube-play'),('851','fa-youtube-square'),('852','fa-ambulance'),('853','fa-h-square'),('854','fa-heart'),('855','fa-heart-o'),('856','fa-heartbeat'),('857','fa-hospital-o'),('858','fa-medkit'),('859','fa-plus-square'),('860','fa-stethoscope'),('861','fa-user-md'),('862','fa-wheelchair');/* MySQLReback Separation */
 /* 创建表结构 `t_log` */
 DROP TABLE IF EXISTS `t_log`;/* MySQLReback Separation */ CREATE TABLE `t_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `usr` varchar(200) NOT NULL COMMENT '相关用户',
  `module_name` varchar(200) NOT NULL COMMENT '相关模块',
  `action_name` varchar(200) NOT NULL COMMENT '相关方法',
  `info` text COMMENT '日志内容',
  `logtime` varchar(20) NOT NULL COMMENT '日志时间，10位时间戳',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='系统日志表';/* MySQLReback Separation */
 /* 插入数据 `t_log` */
 INSERT INTO `t_log` VALUES ('1','admin','Index','login','登录成功','1468857682'),('2','admin','Index','login','登录成功','1468910124'),('3','admin','Member','excute','会员新增成功！','1468910216'),('4','admin','Index','login','登录成功','1468910230'),('5','admin','Member','excute','会员新增成功！','1468912192'),('6','admin','Member','excute','手机号已被注册，请更换手机号后再试！','1468912192'),('7','admin','Index','login','登录成功','1469024748');/* MySQLReback Separation */
 /* 创建表结构 `t_member` */
 DROP TABLE IF EXISTS `t_member`;/* MySQLReback Separation */ CREATE TABLE `t_member` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `mid` int(10) NOT NULL DEFAULT '0' COMMENT '会员编号ID（时间戳）',
  `mkey` varchar(12) DEFAULT NULL COMMENT '会员识别码(APP中以会员编号名义显示)',
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '直接上级ID',
  `mname` varchar(120) DEFAULT NULL COMMENT '会员名称',
  `truename` varchar(60) DEFAULT NULL COMMENT '真实姓名',
  `mpwd` varchar(50) DEFAULT NULL COMMENT '登陆密码',
  `apwd` varchar(50) DEFAULT NULL COMMENT '交易密码',
  `wxid` varchar(200) DEFAULT NULL COMMENT '微信openID',
  `wxid_app` varchar(200) DEFAULT NULL COMMENT '微信openID（来自APP）',
  `qqid` varchar(200) DEFAULT NULL COMMENT 'Q开放ID',
  `qqid_app` varchar(200) DEFAULT NULL COMMENT 'Q开放ID(来自APP)',
  `parentids` text COMMENT '上级会员Mid组',
  `childnum` tinyint(4) DEFAULT '0' COMMENT '下线个数',
  `moblie` varchar(12) DEFAULT NULL COMMENT '会员手机号',
  `qqaccout` varchar(20) DEFAULT NULL COMMENT '支付宝账号',
  `weixinaccout` varchar(50) DEFAULT NULL COMMENT '微信号',
  `addtime` int(11) DEFAULT '0' COMMENT '注册时间',
  `quansum` int(11) DEFAULT '0' COMMENT '升级券张数',
  `mnysum` decimal(10,2) DEFAULT '0.00' COMMENT '账户现金余额',
  `mnylock` decimal(10,2) DEFAULT '0.00' COMMENT '用户冻结金额',
  `nowdaynum` int(4) DEFAULT '0' COMMENT '当前签到天数',
  `alldaynum` int(11) DEFAULT '0' COMMENT '总签到天数',
  `signtime` int(12) DEFAULT NULL COMMENT '上次签到时间',
  `dengji` int(2) DEFAULT '0' COMMENT '会员等级0-5',
  `logintime_last` int(11) DEFAULT '0' COMMENT '最后登录时间',
  `flag` int(2) DEFAULT '1' COMMENT '会员状态',
  `markcontent` text COMMENT '备注说明',
  `marktxt` varchar(255) DEFAULT NULL COMMENT '备用2',
  `logintime_prev` int(11) DEFAULT '0' COMMENT '上次登录时间',
  `qrsrc` varchar(200) DEFAULT NULL COMMENT '推广二维码路径',
  `headimgurl` varchar(255) DEFAULT NULL COMMENT '用户头像路径',
  `online` int(2) NOT NULL DEFAULT '0' COMMENT '当前是否在线',
  `deviceid` varchar(255) NOT NULL COMMENT '当前在线的设备标识符',
  PRIMARY KEY (`ID`,`mid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='会员表';/* MySQLReback Separation */
 /* 插入数据 `t_member` */
 INSERT INTO `t_member` VALUES ('1','1468910130','','0','无名者','周晓通','10d66ccecdf01ccfff2b86cfb1fd2b76','89eba31e310b47b361506501eabb1272','','','','','','0','18622028563','18622028563','请转支付宝','1468910216','0','0.00','0.00','0','0','','5','0','1','','','0','http://182.254.242.153/Upload/qrcode/1468910130.png','','0',''),('2','1468912039','','0','为所欲为','黄小红','10d66ccecdf01ccfff2b86cfb1fd2b76','89eba31e310b47b361506501eabb1272','','','','','','0','13243785784','请加微信转包','aaa1829506','1468912192','0','0.00','0.00','0','0','','5','0','1','','','0','http://182.254.242.153/Upload/qrcode/1468912039.png','','0','');/* MySQLReback Separation */
 /* 创建表结构 `t_menu` */
 DROP TABLE IF EXISTS `t_menu`;/* MySQLReback Separation */ CREATE TABLE `t_menu` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `mnname` varchar(200) NOT NULL COMMENT '目录名称',
  `module_name` varchar(200) NOT NULL COMMENT '模块名',
  `action_name` varchar(200) NOT NULL COMMENT '方法名',
  `pid` int(4) NOT NULL COMMENT '上级目录ID，为0时是顶级目录',
  `menus` int(4) NOT NULL DEFAULT '0',
  `is_show` int(4) NOT NULL DEFAULT '1' COMMENT '是否显示。1为显示，0为隐藏',
  `is_public` int(4) NOT NULL DEFAULT '0' COMMENT '是否公共目录，即不受权限控制影响',
  `icons` varchar(200) DEFAULT NULL COMMENT '目录图标',
  `sort` int(4) NOT NULL DEFAULT '0' COMMENT '排序序号',
  `des` text COMMENT '目录说明',
  `code` varchar(200) DEFAULT NULL COMMENT '附加参数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=114 DEFAULT CHARSET=utf8 COMMENT='后台菜单表';/* MySQLReback Separation */
 /* 插入数据 `t_menu` */
 INSERT INTO `t_menu` VALUES ('1','系统管理','','','0','4','1','0','fa-cogs','2','系统最核心设置管理',''),('2','后台菜单管理','Menu','Menu','1','7','1','0','fa-list','2','',''),('3','菜单列表','Menu','lists','2','0','1','0','','0','',''),('4','新增菜单','Menu','add','2','0','1','0','','0','',''),('5','删除菜单','Menu','del','2','0','0','0','','0','',''),('6','编辑菜单','Menu','edit','2','0','0','0','','0','',''),('7','系统管理员','Usr','Usr','1','13','1','0','fa-group','1','',''),('8','用户列表','Usr','lists','7','0','1','0','','0','',''),('9','添加用户','Usr','add','7','0','1','0','','0','',''),('10','删除用户','Usr','del','7','0','0','0','','0','',''),('11','编辑用户','Usr','edit','7','0','0','0','','0','',''),('68','模型管理','Modul','Modul','63','2','1','0','fa-object-group','1','',''),('14','文章管理','Content','Content','12','4','1','0','fa-file-text','0','',''),('15','图片集管理','Content','Content','12','4','1','0','fa-th','0','',''),('16','页面管理','Webs','Webs','12','3','1','0','fa-desktop','0','',''),('18','文章列表','Article','lists','14','0','1','0','','0','',''),('19','新增文章','Content','add','14','0','1','0','','0','参数说明：tid为目录类型：1为文章类型，2为图片集类型，3为下载类型，4为视频类型；','ctid=1'),('20','编辑文章','Article','edit','14','0','0','0','','0','',''),('21','删除文章','Article','del','14','0','0','0','','0','',''),('22','新增图片集','Content','add','15','0','1','0','','0','','ctid=2'),('23','图片集列表','Pics','lists','15','0','1','0','','0','',''),('24','删除图片集','Pics','del','15','0','0','0','','0','',''),('25','编辑图片集','Pics','edit','15','0','0','0','','0','',''),('26','页面列表','Webs','lists','16','0','1','0','','0','',''),('27','新增页面','Webs','add','16','0','1','0','','0','',''),('28','编辑页面','0','0','16','0','1','0','','0','',''),('31','站点设置','Set','Set','1','2','1','0','fa-tasks','0','',''),('32','基础信息设置','Set','basic','31','0','1','0','','0','',''),('33','日志管理','Sys','Sys','1','3','1','0','fa-list-alt','0','',''),('34','系统日志','Sys','logs','33','0','1','0','','0','',''),('35','角色管理','Usr','roles','7','0','1','0','','0','',''),('36','权限分配','Usr','authorset','7','0','0','0','','0','',''),('37','下载管理','Content','Content','12','2','1','0','fa-download','0','',''),('38','下载列表','Download','lists','37','0','1','0','','0','',''),('39','新增下载','Content','add','37','0','1','0','','0','','ctid=3'),('40','操作执行模块','Menu','execution','2','0','0','0','','0','',''),('41','系统公共目录','','','0','3','0','1','fa-flag','1000','',''),('42','退出系统','Manage','logout','41','0','0','1','','0','',''),('43','更新系统节点','Manage','fetch_module','2','0','0','0','','0','',''),('44','系统后台框架','Manage','index','41','0','0','1','','0','',''),('45','系统后台首页','Manage','main','41','0','0','1','','0','',''),('46','头像上传','Usr','uploadpic','7','0','0','1','','0','',''),('47','用户操作执行','Usr','execution','7','0','0','0','','0','',''),('50','新增角色','Usr','addrole','7','0','0','0','','0','',''),('51','编辑权限','Usr','edtrole','7','0','0','0','','0','',''),('52','角色操作提交','Usr','roleaction','7','0','0','0','','0','',''),('53','删除角色','Usr','delrole','7','0','0','0','','0','',''),('54','权限变更执行','Usr','authorupdate','7','0','0','0','','0','',''),('56','给菜单选择图标','Sys','icons','2','0','0','1','','0','',''),('57','批量删除日志','Sys','logsdel','33','0','0','0','','0','',''),('58','清空日志','Sys','logclear','33','0','0','0','','0','',''),('59','数据库管理','Database','Database','1','2','1','0','fa-database','0','',''),('60','数据库备份/还原','Database','index','59','0','1','0','','0','',''),('61','数据字典','Database','datatext','59','0','1','0','','0','',''),('62','邮箱设置','Set','mail','31','0','0','0','','0','设置系统的邮箱参数，该参数设置后可通过设定的邮箱向用户发送邮件。',''),('75','会员管理','Member','Member','74','13','1','0','fa-group','0','',''),('64','前台栏目管理','Channel','Channel','63','5','1','0','fa-tasks','0','',''),('65','新增栏目','Channel','add','64','0','1','0','','0','',''),('66','栏目列表','Channel','lists','64','0','1','0','','0','',''),('69','模型列表','Modul','lists','68','0','1','0','','0','',''),('70','新增模型','Modul','add','68','0','1','0','','0','',''),('71','设置排序序号','Channel','sortsingle','64','0','0','0','','0','',''),('72','删除栏目','Channel','del','64','0','0','0','','0','',''),('73','执行新增、编辑操作','Channel','execution','64','0','0','0','','0','',''),('74','会员管理','','','0','5','1','0','fa-group','0','',''),('76','会员列表','Member','lists','75','0','1','0','','0','',''),('77','新增会员','Member','add','75','0','1','0','','0','','pid=0'),('78','编辑会员','Member','edit','75','0','0','0','','0','',''),('79','会员详情','Member','detail','75','0','0','0','','0','','');/* MySQLReback Separation */
 /* 插入数据 `t_menu` */
 INSERT INTO `t_menu` VALUES ('80','删除会员','Member','delete','75','0','0','0','','0','','');/* MySQLReback Separation */
 /* 插入数据 `t_menu` */
 INSERT INTO `t_menu` VALUES ('81','执行操作','Member','excute','75','0','0','0','','0','',''),('82','统计管理','','','0','1','0','0','fa-bar-chart','0','',''),('83','统计管理','Total','Total','82','1','1','0','','0','',''),('84','统计列表','Total','lists','83','0','1','0','','0','',''),('85','红包管理','Member','Member','74','6','1','0','fa-envelope-square','0','',''),('86','升级券红包','Member','packets','85','0','1','0','','0','',''),('87','发升级券红包','Member','givepkt','85','0','0','0','','0','',''),('88','查看红包','Member','showpkt','85','0','0','0','','0','',''),('89','现金红包','Member','mnypackets','85','0','1','0','','0','',''),('90','发现金红包','Member','givemny','85','0','0','0','','0','',''),('91','查看现金红包','Member','showmny','85','0','0','0','','0','',''),('92','新闻管理','Content','Content','74','2','1','0','fa-edit','0','',''),('93','新闻列表','Content','lists','92','0','1','0','','0','','model=1'),('94','发布新闻','Content','add','92','0','1','0','','0','','model=1'),('95','广告管理','Ad','Ad','74','4','1','0','fa-language','0','',''),('96','广告列表','Ad','lists','95','0','1','0','','0','',''),('97','新增广告','Content','add','95','0','1','0','','0','','model=2'),('98','编辑广告','Ad','edit','95','0','0','0','','0','',''),('99','执行变更','Ad','excute','95','0','0','0','','0','',''),('100','关于我们','About','About','74','6','1','0','fa-street-view','0','',''),('101','关于我们','About','aboutlist','100','0','1','0','','0','',''),('102','用户帮助','About','helplist','100','0','1','0','','0','',''),('103','新增页面','About','addweb','100','0','0','0','','0','',''),('104','编辑页面','About','editweb','100','0','0','0','','0','',''),('105','删除页面','About','delweb','100','0','0','0','','0','',''),('106','动作执行','About','excute','100','0','0','0','','0','',''),('107','提现管理','Member','cashlist','75','0','1','0','','0','',''),('108','提现处理','Member','docash','75','0','0','0','','0','',''),('109','会员升级记录','Member','uplist','75','0','1','0','','0','',''),('110','升级券转账记录','Member','transeList','75','0','1','0','','0','',''),('111','会员反馈','Member','feedlist','75','0','1','0','','0','',''),('112','回复反馈','Member','refeed','75','0','0','0','','0','',''),('113','赠送升级券(现金)','Member','gift','75','0','1','0','','0','','');/* MySQLReback Separation */
 /* 创建表结构 `t_mnypacket` */
 DROP TABLE IF EXISTS `t_mnypacket`;/* MySQLReback Separation */ CREATE TABLE `t_mnypacket` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UID` int(11) NOT NULL COMMENT '红包发放管理员ID',
  `title` varchar(100) DEFAULT NULL COMMENT '红包赞助商',
  `logo` varchar(100) DEFAULT NULL COMMENT '赞助商LOGO',
  `money` decimal(10,2) NOT NULL COMMENT '红包金额',
  `nums` int(10) NOT NULL COMMENT '红包个数',
  `stime` int(11) NOT NULL COMMENT '发放时间',
  `smark` text COMMENT '备注',
  `mny_now` decimal(10,2) DEFAULT '0.00' COMMENT '剩余金额',
  `style` int(2) NOT NULL DEFAULT '1' COMMENT '红包类型(0:平均红包,1:随机红包)',
  `adid` int(11) DEFAULT '0' COMMENT '广告ID（0为随机广告）',
  `prandom` text COMMENT '红包随机数分布',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='现金红包发送表';/* MySQLReback Separation */
 /* 创建表结构 `t_mnypacketnow` */
 DROP TABLE IF EXISTS `t_mnypacketnow`;/* MySQLReback Separation */ CREATE TABLE `t_mnypacketnow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acceptID` int(11) NOT NULL COMMENT '抢包人ID',
  `getmny` decimal(10,2) NOT NULL COMMENT '所得金额',
  `stime` int(11) NOT NULL COMMENT '抢得红包时间',
  `pid` int(11) NOT NULL COMMENT '红包ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='现金红包授受表';/* MySQLReback Separation */
 /* 创建表结构 `t_model` */
 DROP TABLE IF EXISTS `t_model`;/* MySQLReback Separation */ CREATE TABLE `t_model` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL COMMENT '模型名称',
  `mark` varchar(100) NOT NULL COMMENT '模型标志',
  `table_name` varchar(100) NOT NULL COMMENT '模型绑定数据表名',
  `status` int(4) NOT NULL DEFAULT '1' COMMENT '是否启用(1:启用，2:不启用)',
  `is_single` int(4) NOT NULL DEFAULT '0' COMMENT '是否单页模型(1:是，2:不是)',
  `is_sys` int(4) NOT NULL DEFAULT '0' COMMENT '是否系统模型，系统模型管理员无法删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='内容模型表';/* MySQLReback Separation */
 /* 插入数据 `t_model` */
 INSERT INTO `t_model` VALUES ('1','新闻模型','news','news','1','0','0'),('2','广告模型','ad','ad','1','0','0');/* MySQLReback Separation */
 /* 创建表结构 `t_model_fields` */
 DROP TABLE IF EXISTS `t_model_fields`;/* MySQLReback Separation */ CREATE TABLE `t_model_fields` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `field_name` varchar(150) NOT NULL COMMENT '字段名',
  `field_title` varchar(200) NOT NULL COMMENT '字段标题',
  `field_type` varchar(60) NOT NULL COMMENT '字段类型',
  `field_value` varchar(255) DEFAULT NULL COMMENT '字段默认值',
  `field_length` mediumint(8) DEFAULT NULL COMMENT '字段长度',
  `field_tip` varchar(255) DEFAULT NULL COMMENT '字段提示信息',
  `model_id` int(4) NOT NULL COMMENT '所属模型ID',
  `is_sys` int(4) NOT NULL DEFAULT '0' COMMENT '是否系统字段(系统字段无法删除)',
  `status` int(4) NOT NULL DEFAULT '1' COMMENT '是否启用',
  `sort` int(4) DEFAULT '0' COMMENT '排序序号',
  `show_type` varchar(50) DEFAULT NULL COMMENT '表现形式(文本框,多行文本框,下拉框,单选框,复选框等待)',
  `show_value` text COMMENT '选值内容(存储选择性组件的选项内容)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='模型字段表';/* MySQLReback Separation */
 /* 插入数据 `t_model_fields` */
 INSERT INTO `t_model_fields` VALUES ('1','title','标题','VARCHAR','','255','标题','1','1','1','0','input',''),('2','thumb','缩略图','VARCHAR','','255','缩略图','1','1','0','0','img',''),('3','seo_title','SEO标题','VARCHAR','','255','SEO标题','1','1','0','0','input',''),('4','seo_des','SEO描述','TEXT','','0','SEO描述','1','1','0','0','input',''),('5','seo_key','SEO关键词','VARCHAR','','255','SEO关键词','1','1','0','0','key',''),('6','description','简述','TEXT','','0','简述','1','1','1','0','textarea',''),('7','content','内容','TEXT','','0','内容','1','1','1','0','html',''),('8','hits','点击数','INT','0','6','点击数','1','1','1','0','sys',''),('9','addtime','发布时间','INT','0','11','发布时间','1','1','1','0','sys',''),('10','editime','编辑时间','INT','0','11','编辑时间','1','1','1','0','sys',''),('11','sort','排序序号','INT','0','11','排序序号','1','1','1','0','sys',''),('12','uid','发布人ID','INT','','11','','1','0','1','0','sys',''),('13','title','标题','VARCHAR','','255','标题','2','1','1','0','input',''),('14','thumb','广告缩略图','VARCHAR','','255','广告缩略图，打开红包时5秒显示【最大分辨率：623*885px等比例图】','2','1','1','0','img',''),('15','seo_title','SEO标题','VARCHAR','','255','SEO标题','2','1','0','0','input',''),('16','seo_des','SEO描述','TEXT','','0','SEO描述','2','1','0','0','input',''),('17','seo_key','SEO关键词','VARCHAR','','255','SEO关键词','2','1','0','0','key',''),('18','description','简述','TEXT','','0','简述','2','1','1','1','textarea',''),('19','content','内容','TEXT','','0','内容','2','1','0','0','html',''),('20','hits','点击数','INT','0','6','点击数','2','1','1','0','sys',''),('21','addtime','发布时间','INT','0','11','发布时间','2','1','1','0','sys',''),('22','editime','编辑时间','INT','0','11','编辑时间','2','1','1','0','sys',''),('23','sort','排序序号','INT','0','11','排序序号','2','1','1','0','sys',''),('24','s_time','开始时间','VARCHAR','','12','请设置广告的生效开始时间','2','0','1','1','laydate',''),('25','e_time','到期时间','VARCHAR','','12','请设置广告到期时间','2','0','1','1','laydate',''),('27','status','是否启用','INT','1','2','','2','0','1','1','radio','0|停用
1|启用'),('28','uid','发布人','INT','0','11','','2','0','1','0','sys',''),('29','url','广告链接','VARCHAR','','255','请输入广告的跳转链接','2','0','1','0','input',''),('30','mphoto','广告主图','VARCHAR','','255','此为广告主图，显示在红包详情及各页面之中【最大分辨率：720*255px等比例图】','2','0','1','0','img','');/* MySQLReback Separation */
 /* 创建表结构 `t_module` */
 DROP TABLE IF EXISTS `t_module`;/* MySQLReback Separation */ CREATE TABLE `t_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL COMMENT '名称',
  `appname` varchar(45) DEFAULT NULL COMMENT '项目',
  `groupname` varchar(45) DEFAULT NULL COMMENT '分组',
  `modulename` varchar(45) DEFAULT NULL COMMENT '模块',
  `functionname` varchar(45) DEFAULT NULL COMMENT '方法',
  `status` varchar(45) DEFAULT NULL COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=157 DEFAULT CHARSET=utf8 COMMENT='系统相关节点表';/* MySQLReback Separation */
 /* 插入数据 `t_module` */
 INSERT INTO `t_module` VALUES ('1','','Application','Api','Api','wxAuthor',''),('2','','Application','Api','Api','regByUsr',''),('3','','Application','Api','Api','regAuto',''),('4','','Application','Api','Api','getWxAccToken',''),('5','','Application','Api','Api','theme',''),('6','','Application','Api','News','getnewslist',''),('7','','Application','Api','News','shownews',''),('8','','Application','Api','News','theme',''),('9','','Application','Api','Packet','getpacket',''),('10','','Application','Api','Packet','showpacket',''),('11','','Application','Api','Packet','acceptpacket',''),('12','','Application','Api','Packet','theme',''),('13','','Application','Api','User','regmember',''),('14','','Application','Api','User','checklogin',''),('15','','Application','Api','User','memlogout',''),('16','','Application','Api','User','addfeed',''),('17','','Application','Api','User','signin',''),('18','','Application','Api','User','getmemberinfo',''),('19','','Application','Api','User','addtemp',''),('20','','Application','Api','User','getmemberpaper',''),('21','','Application','Api','User','getmembermny',''),('22','','Application','Api','User','ineedmny',''),('23','','Application','Api','User','transpaper',''),('24','','Application','Api','User','changepwd',''),('25','','Application','Api','User','changesafe',''),('26','','Application','Api','User','editinfo',''),('27','','Application','Api','User','getboss',''),('28','','Application','Api','User','upgrademe',''),('29','','Application','Api','User','upgrademny',''),('30','','Application','Api','User','getdefaultpwd',''),('31','','Application','Api','User','issentted',''),('32','','Application','Api','User','getuplist',''),('33','','Application','Api','User','upagree',''),('34','','Application','Api','User','getfirsteam',''),('35','','Application','Api','User','getmemberteam',''),('36','','Application','Api','User','getDownline',''),('37','','Application','Api','User','teamcount',''),('38','','Application','Api','User','countLevelMember',''),('39','','Application','Api','User','getFloorMemberNum',''),('40','','Application','Api','User','getweblist',''),('41','','Application','Api','User','webdetail',''),('42','','Application','Api','User','theme',''),('43','','Application','Admin','About','aboutlist',''),('44','','Application','Admin','About','helplist',''),('45','','Application','Admin','About','addweb',''),('46','','Application','Admin','About','editweb',''),('47','','Application','Admin','About','delweb',''),('48','','Application','Admin','About','onoff',''),('49','','Application','Admin','About','excute',''),('50','','Application','Admin','About','theme',''),('51','','Application','Admin','Ad','lists',''),('52','','Application','Admin','Ad','edit',''),('53','','Application','Admin','Ad','del',''),('54','','Application','Admin','Ad','theme',''),('55','','Application','Admin','Channel','lists',''),('56','','Application','Admin','Channel','sortsingle',''),('57','','Application','Admin','Channel','getSubChannel',''),('58','','Application','Admin','Channel','add',''),('59','','Application','Admin','Channel','edit',''),('60','','Application','Admin','Channel','execution',''),('61','','Application','Admin','Channel','del',''),('62','','Application','Admin','Channel','theme',''),('63','','Application','Admin','Common','theme',''),('64','','Application','Admin','Content','add',''),('65','','Application','Admin','Content','lists',''),('66','','Application','Admin','Content','edit',''),('67','','Application','Admin','Content','del',''),('68','','Application','Admin','Content','excute',''),('69','','Application','Admin','Content','uploadpic',''),('70','','Application','Admin','Content','uploadpics',''),('71','','Application','Admin','Content','theme',''),('72','','Application','Admin','Database','index',''),('73','','Application','Admin','Database','datatext',''),('74','','Application','Admin','Database','theme',''),('75','','Application','Admin','Index','index',''),('76','','Application','Admin','Index','login',''),('77','','Application','Admin','Index','theme',''),('78','','Application','Admin','Manage','index',''),('79','','Application','Admin','Manage','main',''),('80','','Application','Admin','Manage','logout',''),('81','','Application','Admin','Manage','fetch_module',''),('82','','Application','Admin','Manage','getAppName',''),('83','','Application','Admin','Manage','getGroup',''),('84','','Application','Admin','Manage','getModule',''),('85','','Application','Admin','Manage','getFunction',''),('86','','Application','Admin','Manage','theme',''),('87','','Application','Admin','Member','lists',''),('88','','Application','Admin','Member','detail',''),('89','','Application','Admin','Member','add',''),('90','','Application','Admin','Member','edit',''),('91','','Application','Admin','Member','search',''),('92','','Application','Admin','Member','delete',''),('93','','Application','Admin','Member','excute',''),('94','','Application','Admin','Member','packets',''),('95','','Application','Admin','Member','givepkt',''),('96','','Application','Admin','Member','showpkt',''),('97','','Application','Admin','Member','mnypackets',''),('98','','Application','Admin','Member','givemny','');/* MySQLReback Separation */
 /* 插入数据 `t_module` */
 INSERT INTO `t_module` VALUES ('99','','Application','Admin','Member','showmny','');/* MySQLReback Separation */
 /* 插入数据 `t_module` */
 INSERT INTO `t_module` VALUES ('100','','Application','Admin','Member','gift',''),('101','','Application','Admin','Member','cashlist',''),('102','','Application','Admin','Member','docash',''),('103','','Application','Admin','Member','uplist',''),('104','','Application','Admin','Member','transeList',''),('105','','Application','Admin','Member','feedlist',''),('106','','Application','Admin','Member','refeed',''),('107','','Application','Admin','Member','theme',''),('108','','Application','Admin','Menu','lists',''),('109','','Application','Admin','Menu','add',''),('110','','Application','Admin','Menu','edit',''),('111','','Application','Admin','Menu','selectAction',''),('112','','Application','Admin','Menu','del',''),('113','','Application','Admin','Menu','sortsingle',''),('114','','Application','Admin','Menu','execution',''),('115','','Application','Admin','Menu','theme',''),('116','','Application','Admin','Modul','lists',''),('117','','Application','Admin','Modul','add',''),('118','','Application','Admin','Modul','edit',''),('119','','Application','Admin','Modul','execution',''),('120','','Application','Admin','Modul','getBasicFields',''),('121','','Application','Admin','Modul','del',''),('122','','Application','Admin','Modul','checktoppsw',''),('123','','Application','Admin','Modul','fieldsMng',''),('124','','Application','Admin','Modul','fieldsAdd',''),('125','','Application','Admin','Modul','fieldsDel',''),('126','','Application','Admin','Modul','changestatus',''),('127','','Application','Admin','Modul','sortfield',''),('128','','Application','Admin','Modul','fieldsExcut',''),('129','','Application','Admin','Modul','theme',''),('130','','Application','Admin','Set','basic',''),('131','','Application','Admin','Set','savebasic',''),('132','','Application','Admin','Set','mail',''),('133','','Application','Admin','Set','savemail',''),('134','','Application','Admin','Set','theme',''),('135','','Application','Admin','Sys','icons',''),('136','','Application','Admin','Sys','logs',''),('137','','Application','Admin','Sys','logsdel',''),('138','','Application','Admin','Sys','logclear',''),('139','','Application','Admin','Sys','theme',''),('140','','Application','Admin','Total','lists',''),('141','','Application','Admin','Total','theme',''),('142','','Application','Admin','Usr','lists',''),('143','','Application','Admin','Usr','add',''),('144','','Application','Admin','Usr','edit',''),('145','','Application','Admin','Usr','del',''),('146','','Application','Admin','Usr','execution',''),('147','','Application','Admin','Usr','uploadpic',''),('148','','Application','Admin','Usr','roles',''),('149','','Application','Admin','Usr','addrole',''),('150','','Application','Admin','Usr','edtrole',''),('151','','Application','Admin','Usr','delrole',''),('152','','Application','Admin','Usr','roleaction',''),('153','','Application','Admin','Usr','authorset',''),('154','','Application','Admin','Usr','getAllChild',''),('155','','Application','Admin','Usr','authorupdate',''),('156','','Application','Admin','Usr','theme','');/* MySQLReback Separation */
 /* 创建表结构 `t_needmny` */
 DROP TABLE IF EXISTS `t_needmny`;/* MySQLReback Separation */ CREATE TABLE `t_needmny` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `mid` int(12) NOT NULL COMMENT '会员ID',
  `mny` decimal(10,2) NOT NULL COMMENT '提现金额',
  `addtime` int(12) DEFAULT NULL COMMENT '申请时间',
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '申请状态（0:申请中，1：受理中，2：已完成）',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='现金提现申请表';/* MySQLReback Separation */
 /* 创建表结构 `t_news` */
 DROP TABLE IF EXISTS `t_news`;/* MySQLReback Separation */ CREATE TABLE `t_news` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `thumb` varchar(255) DEFAULT NULL COMMENT '缩略图',
  `seo_title` varchar(255) DEFAULT NULL COMMENT 'SEO标题',
  `seo_des` text COMMENT 'SEO描述',
  `seo_key` varchar(255) DEFAULT NULL COMMENT 'SEO关键词',
  `description` text COMMENT '简述',
  `content` text COMMENT '内容',
  `hits` int(6) NOT NULL DEFAULT '0' COMMENT '点击数',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `editime` int(11) DEFAULT '0' COMMENT '编辑时间',
  `sort` int(11) DEFAULT '0' COMMENT '排序序号',
  `uid` int(11) DEFAULT NULL COMMENT '发布人ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='新闻模型[创建模型时系统创建的表]';/* MySQLReback Separation */
 /* 插入数据 `t_news` */
 INSERT INTO `t_news` VALUES ('26','全民私包是什么？','','','','','','&lt;p style=&quot;margin-top: 0px; margin-bottom: 22px; padding: 0px; color: rgb(51, 51, 51); font-family: &amp;#39;Microsoft Yahei&amp;#39;, Simsun; font-size: 17px; white-space: normal;&quot;&gt;全民私包平台和非法传销的区别：很多人认为拉人头就是传销，我在这里跟大家解释一下 我们是通过商家赞助广告费用发私包给所有会员的，玩家之间可通过互助私包提升级别，达到交友、娱乐、赚钱的多重收益，至于朋友间私包本平台不参与任何资金往来。&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 22px; padding: 0px; color: rgb(51, 51, 51); font-family: &amp;#39;Microsoft Yahei&amp;#39;, Simsun; font-size: 17px; white-space: normal;&quot;&gt;　　一、这是由一个非盈利的系统人助人的团体，不是买，更不是卖，没有任何层层加价的，而传销是层层加价，性质完全不一样。&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 22px; padding: 0px; color: rgb(51, 51, 51); font-family: &amp;#39;Microsoft Yahei&amp;#39;, Simsun; font-size: 17px; white-space: normal;&quot;&gt;　　二、传销要向公司缴纳高额的会员费用，并有最高一层的“网头”管理控制。平台根本不需要缴纳任何入门费用，也没有任何人来管理资金，都是爱心天使之间互赠一些少量的升级费用，同时可以获得为下边爱心天使激活升级的资格，人人平等，只是加入的时间先后而已。&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 22px; padding: 0px; color: rgb(51, 51, 51); font-family: &amp;#39;Microsoft Yahei&amp;#39;, Simsun; font-size: 17px; white-space: normal;&quot;&gt;　　三、传销是金字塔形状的；&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 22px; padding: 0px; color: rgb(51, 51, 51); font-family: &amp;#39;Microsoft Yahei&amp;#39;, Simsun; font-size: 17px; white-space: normal;&quot;&gt;　　有上边塔尖的人不断的赚钱，其他下边的没钱可赚，制度为终身制的，而平台则人人平等，什么时候加入都是一样的收益，排队制，出局制，循环制，真正的公平、公正、公开、透明、科学、合理。&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 22px; padding: 0px; color: rgb(51, 51, 51); font-family: &amp;#39;Microsoft Yahei&amp;#39;, Simsun; font-size: 17px; white-space: normal;&quot;&gt;　　四、传销是采用诱骗，洗脑，甚至强迫他人加入的，一般是亲戚骗亲戚，朋友骗朋友。平台则是规则透明，一定要先看懂，认同方可参与；如有看不懂、不明白的或者不相信等持有怀疑态度的朋友可以先观望，由始至终没有任何人去劝说过任何人加入，都是是自发自愿的爱心互助加入的。&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;全民推广部（宣）&lt;/p&gt;','0','1468340169','1468340499','0','1');/* MySQLReback Separation */
 /* 创建表结构 `t_packet` */
 DROP TABLE IF EXISTS `t_packet`;/* MySQLReback Separation */ CREATE TABLE `t_packet` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UID` int(11) DEFAULT '0' COMMENT '系统管理员ID',
  `title` varchar(100) DEFAULT NULL COMMENT '红包赞助商',
  `logo` varchar(100) DEFAULT NULL COMMENT '赞助商LOGO',
  `papernum` int(11) DEFAULT '0' COMMENT '升级券数量',
  `nums` int(10) DEFAULT NULL COMMENT '红包个数',
  `stime` int(10) DEFAULT '0' COMMENT '发放时间',
  `smark` text COMMENT '备注',
  `now_papernum` int(11) DEFAULT '0' COMMENT '剩余券数量',
  `style` int(2) NOT NULL DEFAULT '1' COMMENT '红包类型(0:平均红包,1:随机红包)',
  `adid` int(11) DEFAULT '0' COMMENT '广告ID(0为随机广告)',
  `prandom` text COMMENT '红包随机数分布',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='升级券红包发送表';/* MySQLReback Separation */
 /* 创建表结构 `t_packetlist` */
 DROP TABLE IF EXISTS `t_packetlist`;/* MySQLReback Separation */ CREATE TABLE `t_packetlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `types` varchar(20) NOT NULL COMMENT '红包类型ID（0为升级券红包，1为现金红包）',
  `pid` int(12) NOT NULL COMMENT '红包ID',
  `addtime` int(12) NOT NULL COMMENT '发放时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='红包发放表（多种红包统一记录）';/* MySQLReback Separation */
 /* 创建表结构 `t_packetnow` */
 DROP TABLE IF EXISTS `t_packetnow`;/* MySQLReback Separation */ CREATE TABLE `t_packetnow` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `acceptID` int(11) DEFAULT '0' COMMENT '接受人ID',
  `papernum` int(11) DEFAULT '0' COMMENT '升级券数量',
  `stime` int(10) DEFAULT '0' COMMENT '抢券时间',
  `pid` int(11) NOT NULL COMMENT '红包ID',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='红包接受表';/* MySQLReback Separation */
 /* 创建表结构 `t_papertrans` */
 DROP TABLE IF EXISTS `t_papertrans`;/* MySQLReback Separation */ CREATE TABLE `t_papertrans` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `fromid` int(10) DEFAULT '0' COMMENT '发起人ID',
  `toid` int(10) DEFAULT '0' COMMENT '接受人ID',
  `papernum` int(10) DEFAULT '0' COMMENT '转移升级券张数',
  `fromtime` int(10) DEFAULT '0' COMMENT '发起时间',
  `mark` text COMMENT '备注',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='升级券转移表';/* MySQLReback Separation */
 /* 创建表结构 `t_pics` */
 DROP TABLE IF EXISTS `t_pics`;/* MySQLReback Separation */ CREATE TABLE `t_pics` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `tid` int(4) NOT NULL COMMENT '类别ID，关联自t_type',
  `cid` int(4) NOT NULL COMMENT '频道ID，关联自t_channel',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `thumb` varchar(200) DEFAULT NULL COMMENT '缩略图',
  `pics` text COMMENT '图片集，各路径以“|”隔开',
  `keywords` varchar(200) DEFAULT NULL COMMENT '关键字',
  `description` text COMMENT '描述',
  `commend` int(4) NOT NULL DEFAULT '0' COMMENT '推荐类型。0为不推荐，1为推荐，可视项目需求另行设置更多',
  `url` varchar(200) DEFAULT NULL COMMENT '文章路径',
  `wrtime` varchar(20) NOT NULL COMMENT '发布时间，以10位时间戳存储',
  `hits` int(10) NOT NULL COMMENT '点击数量',
  `content` text COMMENT '文章正文，以URL编码后保存',
  `sort` int(4) DEFAULT NULL COMMENT '排序序号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='图片集数据表';/* MySQLReback Separation */
 /* 创建表结构 `t_role` */
 DROP TABLE IF EXISTS `t_role`;/* MySQLReback Separation */ CREATE TABLE `t_role` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL COMMENT '角色名称',
  `des` text COMMENT '角色说明',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='系统角色表';/* MySQLReback Separation */
 /* 插入数据 `t_role` */
 INSERT INTO `t_role` VALUES ('1','系统管理员','系统最高权限管理员'),('6','会员管理员',''),('7','统计管理员','');/* MySQLReback Separation */
 /* 创建表结构 `t_shengji` */
 DROP TABLE IF EXISTS `t_shengji`;/* MySQLReback Separation */ CREATE TABLE `t_shengji` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `fromid` int(11) DEFAULT '0' COMMENT '发起人ID',
  `toid` int(11) DEFAULT '0' COMMENT '接受人ID',
  `fromtime` int(10) DEFAULT '0' COMMENT '发起时间',
  `levelto` int(2) DEFAULT '0' COMMENT '目标等级',
  `totime` int(10) DEFAULT '0' COMMENT '审核时间',
  `mark` text COMMENT '备注',
  `status` tinyint(2) DEFAULT '0' COMMENT '审核状态(0-待审核，1-通过，2-未通过）',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='申请记录表';/* MySQLReback Separation */
 /* 创建表结构 `t_tempdb` */
 DROP TABLE IF EXISTS `t_tempdb`;/* MySQLReback Separation */ CREATE TABLE `t_tempdb` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `value1` text,
  `value2` text,
  `value3` text,
  `value4` text,
  `value5` text,
  `value6` text,
  `value7` text,
  `value8` text,
  `value9` text,
  `value10` text,
  `value11` text,
  `value12` text,
  `value13` text,
  `value14` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='临时表，用于测试';/* MySQLReback Separation */
 /* 插入数据 `t_tempdb` */
 INSERT INTO `t_tempdb` VALUES ('3','oKKcev62noUBHSjHSfEtZP6FaJQ8','观海听涛风无语','http://wx.qlogo.cn/mmopen/PiajxSqBRaEKsu2Pn52jJia7qFzF5WeVCibww44Dh9RjSahZNfm37UvicjhStibAzf7WxKyibicK4wQM9ntxParchicHqw/0','o2QBHv7x4x-DQYWzQQOm9imJRnt0','865982021703577','Api','User','addtemp','','','','','','');/* MySQLReback Separation */
 /* 创建表结构 `t_type` */
 DROP TABLE IF EXISTS `t_type`;/* MySQLReback Separation */ CREATE TABLE `t_type` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '类别名',
  `typeblong` varchar(200) NOT NULL COMMENT '归属模型，暂设news，product,video,download等',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 创建表结构 `t_user` */
 DROP TABLE IF EXISTS `t_user`;/* MySQLReback Separation */ CREATE TABLE `t_user` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL COMMENT '用户名',
  `nickname` varchar(200) DEFAULT NULL COMMENT '用户昵称',
  `password` varchar(200) NOT NULL COMMENT '密码',
  `rid` int(4) NOT NULL COMMENT '角色ID，关联自t_role表',
  `status` int(4) NOT NULL DEFAULT '1' COMMENT '状态。1为正常，0为禁用',
  `logins` int(10) NOT NULL COMMENT '登录次数',
  `lasttime` varchar(20) NOT NULL COMMENT '上次登录时间,10时间戳',
  `thistime` varchar(12) NOT NULL COMMENT '本次登录时间',
  `lastip` varchar(20) NOT NULL COMMENT '上次登录IP，由函数转换为数字格式',
  `thisip` varchar(12) NOT NULL COMMENT '本次登录IP',
  `photo` varchar(50) DEFAULT NULL COMMENT '头像地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='管理员表';/* MySQLReback Separation */
 /* 插入数据 `t_user` */
 INSERT INTO `t_user` VALUES ('1','admin','超级管理员','77e2edcc9b40441200e31dc57dbb8829','0','1','256','1468910230','1469024748','1017555543','1903585968',''),('7','mem1','会员管理员1','c56d0e9a7ccec67b4ea131655038d604','6','1','0','','','','',''),('8','total1','统计管理员1','c56d0e9a7ccec67b4ea131655038d604','7','1','0','','','','','');/* MySQLReback Separation */
 /* 创建表结构 `t_webs` */
 DROP TABLE IF EXISTS `t_webs`;/* MySQLReback Separation */ CREATE TABLE `t_webs` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `tid` int(4) NOT NULL COMMENT '类别ID，关联自t_type',
  `cid` int(4) NOT NULL COMMENT '频道ID，关联自t_channel',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `thumb` varchar(200) DEFAULT NULL COMMENT '缩略图',
  `keywords` varchar(200) DEFAULT NULL COMMENT '关键字',
  `description` text COMMENT '描述',
  `commend` int(4) NOT NULL DEFAULT '0' COMMENT '推荐类型。0为不推荐，1为推荐，可视项目需求另行设置更多',
  `url` varchar(200) DEFAULT NULL COMMENT '文章路径',
  `wrtime` varchar(20) NOT NULL COMMENT '发布时间，以10位时间戳存储',
  `hits` int(10) NOT NULL COMMENT '点击数量',
  `content` text COMMENT '文章正文，以URL编码后保存',
  `sort` int(4) DEFAULT NULL COMMENT '排序序号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='单页数据表';/* MySQLReback Separation */