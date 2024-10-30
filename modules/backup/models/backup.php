<?php
class backupModelBcp extends modelBcp {
    public static $tableObj;
	public static $paths;
	public static $backup_prefix="kdt_backup_";
	public static $backupUri;
	public static $backupPath;
	
    function __construct(){
        if(empty(self::$tableObj)){
            self::$tableObj=frameBcp::_()->getTable('backups');  
        }
		if(empty(self::$paths)){
			self::$paths = wp_upload_dir();
		}
		if(empty(self::$backupUri)){
			self::$backupUri = self::$paths['baseurl'];
		}
		if(empty(self::$backupPath)){
			self::$backupPath = self::$paths['basedir'];
		}
    }

    public function prepareParams($params){
        $params['archive_path']= str_replace('\\','/',$params['archive_path']);
        $params['sql_dumps']= str_replace('\\','/',$params['sql_dumps']);

		$sqls = explode(",",$params['sql_dumps']);
		foreach($sqls as &$s_file){
			$name_attr = explode("/",$s_file);
			$name = $name_attr[count($name_attr)-1];
			$s_file = $name;
		}
		$params['sql_dumps'] = implode(",",$sqls);
		$params['create_date']=date("Y-m-d H:i:s");
		$params['params']=  utilsBcp::serialize($params['params']);
        return $params;
    }
    public function getAllBackups(){
		$res =self::$tableObj->get("*");
		if(!empty($res)){
			foreach($res as &$backup){
				$backup['params']= utilsBcp::unserialize($backup['params']);
				$backup['archive_name'] = $backup['archive_path'];
				$backup['archive_path'] = self::$backupUri.'/'.$backup['archive_path'];
			}			
		}

       return $res;
    }
	public function saveBackup($params){

		$params = $this->prepareParams($params);
		self::$tableObj->store($params,"insert");
	}
	public function removeSqls($sqls){
		  foreach ($sqls as $sql){
				//$name_attr = explode("/",$sql);
				unlink($sql);
		  }
	}
    public function backupData($action){

	   switch($action){
		   case "all":
			
				   $sql_files=$this->backupDbase();
				   if(!$sql_files){
					   $this->pushError(langBcp::_("Cannot Dump Database"));
					   return false;
				   }

				   $files_dest_name=$this->backupFiles();
					
				   if(!$files_dest_name){
					   $this->pushError(langBcp::_("Cannot Create Backup File"));
					   return false;					   
				   }
				   $store_data['sql_dumps']=implode(",",$sql_files);
				   $store_data['archive_path']=$files_dest_name;
   				   $this->removeSqls($sql_files);
				   $store_data['params']=array(
					   'type'=>"all"
				   );
		   break;
		   case "posts":
				$sql_files=$this->backupDbase();
			  
				if(!$sql_files){
					$this->pushError(langBcp::_("Cannot Dump Database"));
					return false;
				}
				$file_name = self::$backup_prefix.date("Y-M-d")."_".rand(100,999).".zip";
				$dest=self::$backupPath ."/".$file_name;
				if(!$this->zipFiles($sql_files,$dest)){
					$this->pushError(langBcp::_("Cannot Create Backup File"));					
					return false;
				}
				
				$this->removeSqls($sql_files);
				   $store_data['sql_dumps']=implode(",",$sql_files);
				   $store_data['archive_path']=$file_name;
				   $store_data['params']=array(
					   'type'=>"posts"
				   );
				   
		   break;
		   case "files":
			   
			   $files_dest_name=$this->backupFiles();	
			  
			   if(!$files_dest_name){
				   $this->pushError(langBcp::_("Cannot Create Dump File"));
				   return false;
			   }
				   $store_data['archive_path']=$files_dest_name;
				   $store_data['params']=array(
					   'type'=>"files"
				   );			   
		   break;	   

	   }
	  
	   $this->saveBackup($store_data);
	   $store_data['archive_path'] = self::$backupUri."/".$store_data['archive_path'];
	   return $store_data;
	   
     }
	 public function backupDbase($tables=array('posts','postmeta')){

		 $res= array();
		 for($i=0;$i<count($tables);$i++){
			 $r = $this->dumpTables($tables[$i]);
			 if($r){
				 $res[] = $r;				 
			 }else{
				 return false;
			 }
		 }
		 return $res;
	 }
	 public function backupFiles(){
		 
		 $fullDirName = ABSPATH;
		 $path = dirname(__FILE__);
		 
		 $upload_dir_arr = wp_upload_dir();
		 $zip_name =self::$backup_prefix.date("Y-M-d")."_".rand(100,999).".zip";
		 $dest = self::$backupPath."/".$zip_name;
				  
		 $this->BcpZipDir($fullDirName,$dest);
		 return $zip_name;
	 }
	 public function dumpTables($table_type){
		 global $wpdb;
			$wp_pref = $wpdb->prefix;
			$tableName=$wp_pref.$table_type;
		return $this->dump_table($tableName);
	 }
	 public function dump_table($tbname){
		 global $wpdb;
			$dump_file_name=date("Y-M-d")."_".rand(100,999)."_".$tbname.".sql";
			 $dump_file=ABSPATH."/".$dump_file_name;
			 
			 $dump_file=str_replace("\\","/",$dump_file);

			$backup= $this->bcpTableDumper($tbname);
			$handle = fopen($dump_file,"a+");

			if(!is_writable($dump_file)){
				$this->pushError("Dump File Is not Writeable");
				return false;
			}
				fwrite($handle,$backup);
				fclose($handle);
			 return $dump_file;
	 }
	 
	 
     public function remove($backupId){
		
         $backup = self::$tableObj->get('*',array('id'=>(int)$backupId));

		 @unlink(self::$backupPath.'/'.$backup[0]['archive_path']);
         return self::$tableObj->delete($backupId);
         
         /*
          * remove map
          */
     }
   
     public function  bcpTableDumper($tables = '*'){
		
				$host = DB_HOST;
				$user = DB_USER;
				$pass = DB_PASSWORD;
				$name = DB_NAME;
				global $wpdb;
				$data = "\n/*---------------------------------------------------------------".
				  "\n  SQL DB BACKUP ".date("d.m.Y H:i")." ".
				  "\n  HOST: {$host}".
				  "\n  DATABASE: {$name}".
				  "\n  TABLES: {$tables}".
				  "\n  ---------------------------------------------------------------*/\n";

				$link = $wpdb->dbh;
				if($tables == '*'){ //get all of the tables
				  $tables = array();
				  $result = $wpdb->get_results("SHOW TABLES",ARRAY_A);
				  foreach ($result as $k=>$t){
					 $tables[]=$t['Tables_in_'.DB_NAME];
				  }
				  
				}else{
				  $tables = is_array($tables) ? $tables : explode(',',$tables);
				}

				foreach($tables as $table){
				  $data.= "\n/*---------------------------------------------------------------".
						  "\n  TABLE: `{$table}`".
						  "\n  ---------------------------------------------------------------*/\n";           
				  $data.= "DROP TABLE IF EXISTS `{$table}`;\n";
				  $res = mysql_query("SHOW CREATE TABLE `{$table}`", $link);
				  $row = mysql_fetch_row($res);
				  $data.= $row[1].";\n";

				  $result = mysql_query("SELECT * FROM `{$table}`", $link);
				  $num_rows = mysql_num_rows($result);    

				  if($num_rows>0){
					$vals = Array(); $z=0;
					for($i=0; $i<$num_rows; $i++){
					  $items = mysql_fetch_row($result);
					  $vals[$z]="(";
					  for($j=0; $j<count($items); $j++){
						if (isset($items[$j])) { $vals[$z].= "'".mysql_real_escape_string( $items[$j], $link )."'"; } else { $vals[$z].= "NULL"; }
						if ($j<(count($items)-1)){ $vals[$z].= ","; }
					  }
					  $vals[$z].= ")"; $z++;
					}
					$data.= "INSERT INTO `{$table}` VALUES ";      
					$data .= "  ".implode(";\nINSERT INTO `{$table}` VALUES ", $vals).";\n";
				  }
				}
				//mysql_close( $link );
				return $data;
		}
		public function zipFiles($files,$dest){
			$zip = new ZipArchive();

			if ($zip->open($dest, ZIPARCHIVE::CREATE) !== TRUE) {
				return false;
			}

			foreach ($files as $file) {
				$zip->addFile(realpath($file), $ffile) ;
			}
			$zip->close();
			return true;
		}
		public function BcpZipDir($source, $destination,$without=false){
	
			if (!extension_loaded('zip') || !file_exists($source)) {
				return false;
			}

			$zip = new ZipArchive();
			if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
				return false;
			}

			$source = str_replace('\\', '/', realpath($source));

			if (is_dir($source) === true)
			{
				$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

				foreach ($files as $file)
				{
					$file = str_replace('\\', '/', $file);
					if(strpos($file,self::$backup_prefix) ){
						continue;
					}
					// Ignore "." and ".." folders
					if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
						continue;

					$file = realpath($file);

					if (is_dir($file) === true)
					{
						$zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
					}
					else if (is_file($file) === true)
					{
						$zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
					}

				}
			}
			else if (is_file($source) === true)
			{
				$zip->addFromString(basename($source), file_get_contents($source));
			}

			return $zip->close();

		}


}
