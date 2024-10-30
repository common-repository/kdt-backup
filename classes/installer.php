<?php
class installerBcp {
	static public $update_to_version_method = '';
	static public function init() {
		global $wpdb;
		$wpPrefix = $wpdb->prefix; /* add to 0.0.3 Versiom */
		//$start = microtime(true);					// Speed debug info
		//$queriesCountStart = $wpdb->num_queries;	// Speed debug info
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		$current_version = get_option($wpPrefix. BCP_DB_PREF. 'db_version', 0);
		$installed = (int) get_option($wpPrefix. BCP_DB_PREF. 'db_installed', 0);
		/**
		 * htmltype 
		 */
		if (!dbBcp::exist($wpPrefix.BCP_DB_PREF."htmltype")) {
			$q = "CREATE TABLE IF NOT EXISTS `".$wpPrefix.BCP_DB_PREF."htmltype` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `label` varchar(32) NOT NULL,
			  `description` varchar(255) NOT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE INDEX `label` (`label`)
			) DEFAULT CHARSET=utf8";
			dbDelta($q);
		
			dbBcp::query("INSERT INTO `".$wpPrefix.BCP_DB_PREF."htmltype` VALUES
				(1, 'text', 'Text'),
				(2, 'password', 'Password'),
				(3, 'hidden', 'Hidden'),
				(4, 'checkbox', 'Checkbox'),
				(5, 'checkboxlist', 'Checkboxes'),
				(6, 'datepicker', 'Date Picker'),
				(7, 'submit', 'Button'),
				(8, 'img', 'Image'),
				(9, 'selectbox', 'Drop Down'),
				(10, 'radiobuttons', 'Radio Buttons'),
				(11, 'countryList', 'Countries List'),
				(12, 'selectlist', 'List'),
				(13, 'countryListMultiple', 'Country List with posibility to select multiple countries'),
				(14, 'block', 'Will show only value as text'),
				(15, 'statesList', 'States List'),
				(16, 'textFieldsDynamicTable', 'Dynamic table - multiple text options set'),
				(17, 'textarea', 'Textarea'),
				(18, 'checkboxHiddenVal', 'Checkbox with Hidden field')");
    
            }
		/**
		 * modules 
		 */
		if (!dbBcp::exist($wpPrefix.BCP_DB_PREF."modules")) {
				$q = "CREATE TABLE IF NOT EXISTS `".$wpPrefix.BCP_DB_PREF."modules` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `code` varchar(64) NOT NULL,
				  `active` tinyint(1) NOT NULL DEFAULT '0',
				  `type_id` smallint(3) NOT NULL DEFAULT '0',
				  `params` text,
				  `has_tab` tinyint(1) NOT NULL DEFAULT '0',
				  `label` varchar(128) DEFAULT NULL,
				  `description` text,
				  `ex_plug_dir` varchar(255) DEFAULT NULL,
				  PRIMARY KEY (`id`),
				  UNIQUE INDEX `code` (`code`)
				) DEFAULT CHARSET=utf8;";
				dbDelta($q);
	
				dbBcp::query("INSERT INTO `".$wpPrefix.BCP_DB_PREF."modules` (id, code, active,    
                    type_id, params, has_tab, label, description) VALUES
					 (NULL, 'adminmenu',1,1,'',0,'Admin Menu',''),
					(NULL, 'options',1,1,'',1,'Options',''),
					 (NULL, 'user',1,1,'',1,'Users',''),
					 (NULL, 'templates',1,1,'',1,'Templates for Plugin',''),
		  
					 (NULL, 'shortcodes', 1, 6, '', 0, 'Shortcodes', 'Shortcodes data'),
				     (NULL, 'backup', 1, 1, '',1, 'Gmap', 'Gmap'),
					        
					(NULL, 'promo_ready', 1, 1, '', 0, 'Promo Ready', 'Promo Ready');");
                }
		/**
		 *  modules_type 
		 */
		if(!dbBcp::exist($wpPrefix.BCP_DB_PREF."modules_type")) {
				$q = "CREATE TABLE IF NOT EXISTS `".$wpPrefix.BCP_DB_PREF."modules_type` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `label` varchar(64) NOT NULL,
				  PRIMARY KEY (`id`)
				) AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;";
				dbDelta($q);
		
					dbBcp::query("INSERT INTO `".$wpPrefix.BCP_DB_PREF."modules_type` VALUES
					  (1,'system'),
					  (2,'payment'),
					  (3,'shipping'),
					  (4,'widget'),
					  (5,'product_extra'),
					  (6,'addons'),
					  (7,'template')");
            }
		/**
		 * options 
		 */
		if(!dbBcp::exist($wpPrefix.BCP_DB_PREF."options")) {
				$q = "CREATE TABLE IF NOT EXISTS `".$wpPrefix.BCP_DB_PREF."options` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `code` varchar(64) CHARACTER SET latin1 NOT NULL,
				  `value` text NULL,
				  `label` varchar(128) CHARACTER SET latin1 DEFAULT NULL,
				  `description` text CHARACTER SET latin1,
				  `htmltype_id` smallint(2) NOT NULL DEFAULT '1',
				  `params` text NULL,
				  `cat_id` mediumint(3) DEFAULT '0',
				  `sort_order` mediumint(3) DEFAULT '0',
				  `value_type` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
				  PRIMARY KEY (`id`),
				  KEY `id` (`id`),
				  UNIQUE INDEX `code` (`code`)
				) DEFAULT CHARSET=utf8";
				dbDelta($q);
				dbBcp::query("`".$wpPrefix.BCP_DB_PREF."options` (  `code` ,  `value` ,  `label` ) 
								VALUES ( 'save_statistic',  '0',  'Send statistic')");
			}
			$eol = "\n";
		
		/* options categories */
		if(!dbBcp::exist($wpPrefix.BCP_DB_PREF."options_categories")) {
			$q = "CREATE TABLE IF NOT EXISTS `".$wpPrefix.BCP_DB_PREF."options_categories` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`label` varchar(128) NOT NULL,
				PRIMARY KEY (`id`),
				KEY `id` (`id`)
			  ) DEFAULT CHARSET=utf8";
			  dbDelta($q);
		
				dbBcp::query("INSERT INTO `".$wpPrefix.BCP_DB_PREF."options_categories` VALUES
					(1, 'General'),
					(2, 'Template'),
					(3, 'Subscribe'),
					(4, 'Social');");
		
            }
                 

                if(!dbBcp::exist($wpPrefix.BCP_DB_PREF."backup")) {
						$q = "CREATE TABLE IF NOT EXISTS `".$wpPrefix.BCP_DB_PREF."backups` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `archive_path` text CHARACTER SET utf8 NULL,
						  `sql_dumps` text CHARACTER SET utf8 NULL,
						  `params` text NULL,
						  `create_date` datetime,
						  PRIMARY KEY (`id`),
						  UNIQUE INDEX `id` (`id`)
						) DEFAULT CHARSET=utf8";
					dbDelta($q);
				}
                
              
                if(!dbBcp::exist($wpPrefix.BCP_DB_PREF."usage_stat")) {
                        dbDelta("CREATE TABLE `".$wpPrefix.BCP_DB_PREF."usage_stat` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `code` varchar(64) NOT NULL,
                          `visits` int(11) NOT NULL DEFAULT '0',
                          `spent_time` int(11) NOT NULL DEFAULT '0',
                          `modify_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                          UNIQUE INDEX `code` (`code`),
                          PRIMARY KEY (`id`)
                        ) DEFAULT CHARSET=utf8");
                        dbBcp::query("INSERT INTO `".$wpPrefix.BCP_DB_PREF."usage_stat` (code, visits) VALUES ('installed', 1)");
                }
               
             

                  
                update_option($wpPrefix. BCP_DB_PREF. 'db_version', BCP_VERSION);
		add_option($wpPrefix. BCP_DB_PREF. 'db_installed', 1);
		dbBcp::query("UPDATE `".$wpPrefix.BCP_DB_PREF."options` SET value = '". BCP_VERSION. "' WHERE code = 'version' LIMIT 1");
                  
                  installerDbUpdaterBcp::runUpdate();
		//$time = microtime(true) - $start;	// Speed debug info
	}
	static public function setUsed() {
		update_option(BCP_DB_PREF. 'plug_was_used', 1);
	}
	static public function isUsed() {
		return true;	
		return  (bool)get_option(BCP_DB_PREF. 'plug_was_used');
	}
	/**
	 * Create pages for plugin usage
	 */
	static public function createPages() {
		return false;
	}
	
	/**
	 * Return page data from given array, searched by title, used in self::createPages()
	 * @return mixed page data object if success, else - false
	 */
	static private function _getPageByTitle($title, $pageArr) {
		foreach($pageArr as $p) {
			if($p->title == $title)
				return $p;
		}
		return false;
	}
	static public function delete() {
            global $wpdb;
            $wpPrefix = $wpdb->prefix; /* add to 0.0.3 Version */
            $deleteOptions = reqBcp::getVar('deleteAllData');

            if(is_null($deleteOptions)) {
                    frameBcp::_()->getModule('options')->getView()->displayDeactivatePage();
                    exit();
            }
           
            if((bool)$deleteOptions){
				
               $wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.BCP_DB_PREF."modules`");
               $wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.BCP_DB_PREF."backups`");

               $wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.BCP_DB_PREF."options`");
               $wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.BCP_DB_PREF."htmltype`");
               $wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.BCP_DB_PREF."options_categories`");
               $wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.BCP_DB_PREF."access`");
               $wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.BCP_DB_PREF."modules_type`");
               $wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.BCP_DB_PREF."usage_stat`");
               delete_option(BCP_DB_PREF. 'db_version');
               delete_option($wpPrefix.BCP_DB_PREF.'db_installed');
               delete_option(BCP_DB_PREF. 'plug_was_used');       
            }
                       
	}
	static protected function _addPageToWP($post_title, $post_parent = 0) {
		return wp_insert_post(array(
			 'post_title' => langBcp::_($post_title),
			 'post_content' => langBcp::_($post_title. ' Page Content'),
			 'post_status' => 'publish',
			 'post_type' => 'page',
			 'post_parent' => $post_parent,
			 'comment_status' => 'closed'
		));
	}
	static public function update() {
		global $wpdb;
		$wpPrefix = $wpdb->prefix; /* add to 0.0.3 Versiom */
		$currentVersion = get_option($wpPrefix. 'db_version', 0);
		$installed = (int) get_option($wpPrefix. 'db_installed', 0);
		if(!$currentVersion || version_compare(BCP_VERSION, $currentVersion, '>')) {
			self::init();
			update_option($wpPrefix. 'db_version', BCP_VERSION);
		}
	}
}
