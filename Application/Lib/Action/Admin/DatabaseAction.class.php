<?php
	/**
	* 
	*/
	class DatabaseAction extends CommonAction
	{
		public function index() {
        $DataDir = "Databack/";
        if (!empty($_GET['Action'])) {
            import("ORG.Util.MySQLReback");
            $config = array(
                'host' => C('DB_HOST'),
                'port' => C('DB_PORT'),
                'userName' => C('DB_USER'),
                'userPassword' => C('DB_PWD'),
                'dbprefix' => C('DB_PREFIX'),
                'charset' => 'UTF8',
                'path' => $DataDir,
                'isCompress' => 0, //是否开启gzip压缩
                'isDownload' => 0  
            );
            $mr = new MySQLReback($config);
            $mr->setDBName(C('DB_NAME'));
            if ($_GET['Action'] == 'backup') {
                $mr->backup();                
                //$this->success( '数据库备份成功！');
                addlog(MODULE_NAME,ACTION_NAME,"数据库备份成功！");
                $this->ajaxReturn('','数据库备份成功！',1,'json');
            } elseif ($_GET['Action'] == 'RL') {
                $mr->recover($_GET['File']);                
                // $this->success( '数据库还原成功！');
                addlog(MODULE_NAME,ACTION_NAME,"数据库自备份文件[".$_GET['File']."]还原成功！");
                $this->ajaxReturn('','数据库还原成功！',1,'json');
            } elseif ($_GET['Action'] == 'Del') {
                if (@unlink($DataDir . $_GET['File'])) {
                    addlog(MODULE_NAME,ACTION_NAME,"数据库备份文件[".$_GET['File']."]删除成功！");
                    $this->ajaxReturn('','备份文件删除成功！',1,'json');
                } else {                    
					addlog(MODULE_NAME,ACTION_NAME,"数据库备份文件[".$_GET['File']."]删除失败！");
                    $this->ajaxReturn('','备份文件删除失败！',0,'json');
                }
            }
            if ($_GET['Action'] == 'dow') {
                function DownloadFile($fileName) {
                    ob_end_clean();
                    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Length: ' . filesize($fileName));
                    header('Content-Disposition: attachment; filename=' . basename($fileName));
                    readfile($fileName);
                }
                DownloadFile($DataDir . $_GET['file']);
                exit();
            }
        }
        $lists = $this->MyScandir('Databack/');
        unset($lists[0]);
        unset($lists[1]);
        $lists = array_reverse($lists);
        $this->assign("datadir",$DataDir);
        $this->assign("lists", $lists);
        $this->display('recovery');
    }

    private function MyScandir($FilePath = './', $Order = 0) {
        $FilePath = opendir($FilePath);
        while (false !== ($filename = readdir($FilePath))) {
            $FileAndFolderAyy[] = $filename;
        }
        $Order == 0 ? sort($FileAndFolderAyy) : rsort($FileAndFolderAyy);
        return $FileAndFolderAyy;
    }

    public function datatext()	//输出数据字典
	    {
	    	/**
	    	 * 生成mysql数据字典
	    	 */
	    	header("Content-type: text/html; charset=utf-8");
	    	//配置数据库
	    	$dbserver   = C('DB_HOST');
	    	$dbusername = C('DB_USER');
	    	$dbpassword = C('DB_PWD');
	    	$database   = C('DB_NAME');

	    	//其他配置
	    	$mysql_conn = @mysql_connect("$dbserver", "$dbusername", "$dbpassword") or die("Mysql连接出错，请检查数据库连接.");
	    	mysql_select_db($database, $mysql_conn);
	    	mysql_query('SET NAMES utf8', $mysql_conn);
	    	$table_result = mysql_query('show tables', $mysql_conn);

	    	$no_show_table = array();    //不需要显示的表
	    	$no_show_field = array();   //不需要显示的字段

	    	//取得所有的表名
	    	while($row = mysql_fetch_array($table_result)){
	    		if(!in_array($row[0],$no_show_table)){
	    			$tables[]['TABLE_NAME'] = $row[0];
	    		}
	    	}
	    	//替换所以表的表前缀
	    	if($_GET['prefix']){
	    		$prefix = 'bm_';
	    		foreach($tables as $key => $val){
	    			$tableName = $val['TABLE_NAME'];
	    			$string = explode('_',$tableName);
	    			if($string[0] != $prefix){  
	    				$string[0] = $prefix;  
	    				$newTableName = implode('_', $string);  
	    				mysql_query('rename table '.$tableName.' TO '.$newTableName);  
	    			}
	    		}
	    		echo "替换成功！";exit();
	    	}

	    	//循环取得所有表的备注及表中列消息
	    	foreach ($tables as $k=>$v) {
	    	    $sql  = 'SELECT * FROM ';
	    	    $sql .= 'INFORMATION_SCHEMA.TABLES ';
	    	    $sql .= 'WHERE ';
	    	    $sql .= "table_name = '{$v['TABLE_NAME']}'  AND table_schema = '{$database}'";
	    	    $table_result = mysql_query($sql, $mysql_conn);
	    	    while ($t = mysql_fetch_array($table_result) ) {
	    	        $tables[$k]['TABLE_COMMENT'] = $t['TABLE_COMMENT'];
	    	    }

	    	    $sql  = 'SELECT * FROM ';
	    	    $sql .= 'INFORMATION_SCHEMA.COLUMNS ';
	    	    $sql .= 'WHERE ';
	    	    $sql .= "table_name = '{$v['TABLE_NAME']}' AND table_schema = '{$database}'";

	    	    $fields = array();
	    	    $field_result = mysql_query($sql, $mysql_conn);
	    	    while ($t = mysql_fetch_array($field_result) ) {
	    	        $fields[] = $t;
	    	    }
	    	    $tables[$k]['COLUMN'] = $fields;
	    	}
	    	mysql_close($mysql_conn);


	    	$html = '';
	    	//循环所有表
	    	foreach ($tables as $k=>$v) {
	    	    $html .= '	<h3>' . ($k + 1) . '、' . $v['TABLE_COMMENT'] .'  （'. $v['TABLE_NAME']. '）</h3>'."\n";
	    	    $html .= '	<table border="1" cellspacing="0" cellpadding="0" width="100%">'."\n";
	    	    $html .= '		<tbody>'."\n";
	    		$html .= '			<tr>'."\n";
	    		$html .= '				<th>字段名</th>'."\n";
	    		$html .= '				<th>数据类型</th>'."\n";
	    		$html .= '				<th>默认值</th>'."\n";
	    		$html .= '				<th>允许非空</th>'."\n";
	    		$html .= '				<th>自动递增</th>'."\n";
	    		$html .= '				<th>备注</th>'."\n";
	    		$html .= '			</tr>'."\n";

	    	    foreach ($v['COLUMN'] as $f) {
	    			if(!is_array($no_show_field[$v['TABLE_NAME']])){
	    				$no_show_field[$v['TABLE_NAME']] = array();
	    			}
	    			if(!in_array($f['COLUMN_NAME'],$no_show_field[$v['TABLE_NAME']])){
	    				$html .= '			<tr>'."\n";
	    				$html .= '				<td class="c1">' . $f['COLUMN_NAME'] . '</td>'."\n";
	    				$html .= '				<td class="c2">' . $f['COLUMN_TYPE'] . '</td>'."\n";
	    				$html .= '				<td class="c3">' . $f['COLUMN_DEFAULT'] . '</td>'."\n";
	    				$html .= '				<td class="c4">' . $f['IS_NULLABLE'] . '</td>'."\n";
	    				$html .= '				<td class="c5">' . ($f['EXTRA']=='auto_increment'?'是':'&nbsp;') . '</td>'."\n";
	    				$html .= '				<td class="c6">' . $f['COLUMN_COMMENT'] . '</td>'."\n";
	    				$html .= '			</tr>'."\n";
	    			}
	    	    }
	    	    $html .= '		</tbody>'."\n";
	    		$html .= '	</table>'."\n";
	    	}
	    	$this->assign('dataHtml',$html);
	    	$this->display();
	    }
}
?>