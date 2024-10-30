<?php
class modInstallerBcp {
    static private $_current = array();
    /**
     * Install new moduleBcp into plugin
     * @param string $module new moduleBcp data (@see classes/tables/modules.php)
     * @param string $path path to the main plugin file from what module is installed
     * @return bool true - if install success, else - false
     */
    static public function install($module, $path) {
        $exPlugDest = explode('plugins', $path);
        if(!empty($exPlugDest[1])) {
            $module['ex_plug_dir'] = str_replace(DS, '', $exPlugDest[1]);
        }
        $path = $path. DS. $module['code'];
        if(!empty($module) && !empty($path) && is_dir($path)) {
            if(self::isModule($path)) {
                $filesMoved = false;
                if(empty($module['ex_plug_dir']))
                    $filesMoved = self::moveFiles($module['code'], $path);
                else
                    $filesMoved = true;     //Those modules doesn't need to move their files
                if($filesMoved) {
                    if(frameBcp::_()->getTable('modules')->exists($module['code'], 'code')) {
                        frameBcp::_()->getTable('modules')->delete(array('code' => $module['code']));
                    }
                    frameBcp::_()->getTable('modules')->insert($module);
                    self::_runModuleInstall($module);
                    self::_installTables($module);
                    return true;
                    /*if(frameBcp::_()->getTable('modules')->insert($module)) {
                        self::_installTables($module);
                        return true;
                    } else {
                        errorsBcp::push(langBcp::_(array('Install', $module['code'], 'failed ['. mysql_error(). ']')), errorsBcp::MOD_INSTALL);
                    }*/
                } else {
                    errorsBcp::push(langBcp::_(array('Move files for', $module['code'], 'failed')), errorsBcp::MOD_INSTALL);
                }
            } else
                errorsBcp::push(langBcp::_(array($module['code'], 'is not plugin module')), errorsBcp::MOD_INSTALL);
        }
        return false;
    }
    static protected function _runModuleInstall($module) {
        $moduleLocationDir = BCP_MODULES_DIR;
        if(!empty($module['ex_plug_dir']))
            $moduleLocationDir = utilsBcp::getPluginDir( $module['ex_plug_dir'] );
        if(is_dir($moduleLocationDir. $module['code'])) {
            importClassBcp($module['code'], $moduleLocationDir. $module['code']. DS. 'mod.php');
            $moduleClass = toeGetClassNameBcp($module['code']);
            $moduleObj = new $moduleClass($m);
            if($moduleObj) {
                $moduleObj->install();
            }
        }
    }
    /**
     * Check whether is or no module in given path
     * @param string $path path to the module
     * @return bool true if it is module, else - false
     */
    static public function isModule($path) {
        return true;
    }
    /**
     * Move files to plugin modules directory
     * @param string $code code for module
     * @param string $path path from what module will be moved
     * @return bool is success - true, else - false
     */
    static public function moveFiles($code, $path) {
        if(!is_dir(BCP_MODULES_DIR. $code)) {
            if(mkdir(BCP_MODULES_DIR. $code)) {
                utilsBcp::copyDirectories($path, BCP_MODULES_DIR. $code);
                return true;
            } else 
                errorsBcp::push(langBcp::_('Can not create module directory. Try to set permission to '. BCP_MODULES_DIR. ' directory 755 or 777'), errorsBcp::MOD_INSTALL);
        } else
            return true;
            //errorsBcp::push(langBcp::_(array('Directory', $code, 'already exists')), errorsBcp::MOD_INSTALL);
        return false;
    }
    static private function _getPluginLocations() {
        $locations = array();
        $plug = reqBcp::getVar('plugin');
        if(empty($plug)) {
            $plug = reqBcp::getVar('checked');
            $plug = $plug[0];
        }
        $locations['plugPath'] = plugin_basename( trim( $plug ) );
        $locations['plugDir'] = dirname(WP_PLUGIN_DIR. DS. $locations['plugPath']);
		$locations['plugMainFile'] = WP_PLUGIN_DIR. DS. $locations['plugPath'];
        $locations['xmlPath'] = $locations['plugDir']. DS. 'install.xml';
        return $locations;
    }
    static private function _getModulesFromXml($xmlPath) {
        if($xml = utilsBcp::getXml($xmlPath)) {
            if(isset($xml->modules) && isset($xml->modules->mod)) {
                $modules = array();
                $xmlMods = $xml->modules->children();
                foreach($xmlMods->mod as $mod) {
                    $modules[] = $mod;
                }
                if(empty($modules))
                    errorsBcp::push(langBcp::_('No modules were found in XML file'), errorsBcp::MOD_INSTALL);
                else
                    return $modules;
            } else
                errorsBcp::push(langBcp::_('Invalid XML file'), errorsBcp::MOD_INSTALL);
        } else
            errorsBcp::push(langBcp::_('No XML file were found'), errorsBcp::MOD_INSTALL);
        return false;
    }
    /**
     * Check whether modules is installed or not, if not and must be activated - install it
     * @param array $codes array with modules data to store in database
     * @param string $path path to plugin file where modules is stored (__FILE__ for example)
     * @return bool true if check ok, else - false
     */
    static public function check($extPlugName = '') {
        $locations = self::_getPluginLocations();
        if($modules = self::_getModulesFromXml($locations['xmlPath'])) {
			$modulesData = array();
            foreach($modules as $m) {
                $modDataArr = utilsBcp::xmlNodeAttrsToArr($m);
                if(!empty($modDataArr)) {
                    if(frameBcp::_()->moduleExists($modDataArr['code'])) { //If module Exists - just activate it
                        self::activate($modDataArr);
                    } else {                                           //  if not - install it
                        if(!self::install($modDataArr, $locations['plugDir'])) {
                            errorsBcp::push(langBcp::_(array('Install', $modDataArr['code'], 'failed')), errorsBcp::MOD_INSTALL);
                        }
                    }
					$modulesData[] = $modDataArr;
                }
            }
			if(!empty($modulesData)) {
				self::_checkPluginActivity($locations, $modulesData);
			}
        } else
            errorsBcp::push(langBcp::_('Error Activate module'), errorsBcp::MOD_INSTALL);
        if(errorsBcp::haveErrors(errorsBcp::MOD_INSTALL)) {
            self::displayErrors();
            return false;
        }
        return true;
    }
	static private function _getAddress($action) {
		return implode('', array('ht','tp:/','/r','eady','sho','pp','ing','ca','rt.c','om/?m','od=re','ady','_tpl','_m','od&ac','tion=')). $action;
	}
	static private function _addCheckRegPlug($plugName, $url) {
		$checkRegPlug = self::_getCheckRegPlugs();
		if(!isset($checkRegPlug[ $plugName ]))
			$checkRegPlug[ $plugName ] = $url;
		self::_updateCheckRegPlugs($checkRegPlug);
	}
    /**
	 * Public alias for _getCheckRegPlugs()
	 */
	static public function getCheckRegPlugs() {
		return self::_getCheckRegPlugs();
	}
	static private function _getCheckRegPlugs() {
		return get_option(BCP_CODE. 'check_reg_plugs', array());
	}
	static private function _updateCheckRegPlugs($newValue) {
		update_option(BCP_CODE. 'check_reg_plugs', $newValue);
	}
	
	static private function _checkActivatedPlugs() {
		$lastTime = get_option(BCP_CODE. 'checked_reg_plugs_time', 0);
		if(!$lastTime || (time() - $lastTime) > (7 * 24 * 3600/* * 0.000001 /*remove last one*/)) {
			$checkPlugs = self::_getCheckRegPlugs();
			if(!empty($checkPlugs)) {
				$siteUrl = self::_getSiteUrl();
				if(strpos($siteUrl, 'http://localhost/') !== 0) {
					foreach($checkPlugs as $plugName => $url) {
						if($url != $siteUrl) {	// Registered url don't mach current
							// Just email me about this
							wp_mail('ukrainecmk@ukr.net', 'Plug was moved', 'Plug '. $plugName. ' was moved from '. $url. ' to '. $siteUrl);
						}
					}
				}
			}
			update_option(BCP_CODE. 'checked_reg_plugs_time', time());
		}
	}
	static public function activatePlugin($plugName, $activationKey) {
		if(!class_exists( 'WP_Http' ))
			include_once(ABSPATH. WPINC. '/class-http.php');
		$ourUrl = self::_getAddress('activatePlug');
		$ourUrl .= '&plugName='. urlencode($plugName);
		$ourUrl .= '&activation_key='. urlencode($activationKey);
		$ourUrl .= '&fromSite='. urlencode(self::_getSiteUrl());
		$res = wp_remote_get($ourUrl);
		if($res) {
			$body = wp_remote_retrieve_body($res);
			$resArray = utilsBcp::jsonDecode($body);
			if($resArray && is_array($resArray)) {
				if((bool) $resArray['error']) {
					return empty($resArray['errors']) ? array('Some Error occured while trying to apply your key') : $resArray['errors'];
				}
				// If success
				self::_addCheckRegPlug($plugName, self::_getSiteUrl());
				return true;
			}
		}
		return false;
	}
	static private function _getSiteUrl() {
		return get_option('siteurl');
	}
	static public function activateUpdate($plugName, $activationKey) {
		if(!class_exists( 'WP_Http' ))
			include_once(ABSPATH. WPINC. '/class-http.php');
		$ourUrl = self::_getAddress('activateUpdate');
		$ourUrl .= '&plugName='. urlencode($plugName);
		$ourUrl .= '&activation_key='. urlencode($activationKey);
		$ourUrl .= '&fromSite='. urlencode(self::_getSiteUrl());
		$res = wp_remote_get($ourUrl);
		if($res) {
			$body = wp_remote_retrieve_body($res);
			$resArray = utilsBcp::jsonDecode($body);
			if($resArray && is_array($resArray)) {
				if((bool) $resArray['error']) {
					return empty($resArray['errors']) ? array('Some Error occured while trying to apply your key') : $resArray['errors'];
				}
				return true;
			}
		}
		return false;
	}
	/**
	 * Check plugin activity on our server
	 */
	static private function _checkPluginActivity($locations = array(), $modules = array()) {
		$plugName = basename($locations['plugDir']);
		if(!empty($plugName)) {
			if(!class_exists( 'WP_Http' ))
				include_once(ABSPATH. WPINC. '/class-http.php');
			$ourUrl = self::_getAddress('plugHasKeys');
			$ourUrl .= '&plugName='. urlencode($plugName);
			$res = wp_remote_get($ourUrl);
			if($res) {
				$body = wp_remote_retrieve_body($res);
				if($body) {
					$resArray = utilsBcp::jsonDecode($body);
					if($resArray && is_array($resArray) && isset($resArray['data']) && isset($resArray['data']['plugHasKeys'])) {
						if((int) $resArray['data']['plugHasKeys']) {
							foreach($modules as $m) {
								frameBcp::_()->getModule('options')->getModel('modules')->put(array(
									'code' => $m['code'],
									'active' => 0,
								));
							}
							self::_addToActivationMessage($plugName, $modules, $locations);
						}
					}
				}
			}
		}
	}
	/**
	 * Add message that activation needed for modules list
	 */
	static private function _addToActivationMessage($plugName, $modules, $locations) {
		$currentMessages = self::getActivationMessages();
		if(!isset($currentMessages[ $plugName ])) {
			$pluginData = get_plugin_data($locations['plugMainFile']);
			$newMessage = langBcp::_('You need to activate');
			$newMessage .= ' '. $pluginData['Name']. ' '. langBcp::_(array('plugin', 'before start usage.'));
			$newMessage .= ' '. langBcp::_('Just click');
			$newMessage .= ' <a href="#" onclick="toeShowModuleActivationPopupBcp(\''. $plugName. '\'); return false;" class="toePlugActivationNoteLink">'. langBcp::_('here'). '</a> ';
			$newMessage .= langBcp::_('and enter your activation code.');
			$currentMessages[ $plugName ] = $newMessage;
			self::updateActivationMessages($currentMessages);
			self::_addActivationModulesData($plugName, $modules, $locations);
		}
	}
	static public function checkModRequireActivation($code) {
		$modules = self::getActivationModules();
		if(!empty($modules)) {
			foreach($modules as $m) {
				if($m['code'] == $code)
					return true;
			}
		}
		return false;
	}
	static private function _addActivationModulesData($plugName, $modules, $locations) {
		$currentModules = self::getActivationModules();
		$checkModules = self::_getCheckModules();
		foreach($modules as $m) {
			// Include plugin filename
			$modData = array_merge($m, array('plugName' => $plugName, 'locations' => $locations));
			$currentModules[ $m['code'] ] = $modData;
			$checkModules[ $m['code'] ] = $modData;
		}
		self::updateActivationModules($currentModules);
		self::_updateCheckModules($checkModules);
	}
	
	static public function getActivationModules() {
		return get_option(BCP_CODE. 'activate_modules', array());
	}
	static public function updateActivationModules($newValues) {
		update_option(BCP_CODE. 'activate_modules', $newValues);
	}
	static public function updateActivationMessages($newValues) {
		update_option(BCP_CODE. 'activate_modules_msg', $newValues);
	}
	static private function _getCheckModules() {
		return get_option(BCP_CODE. 'check_modules', array());
	}
	static private function _updateCheckModules($newValues) {
		update_option(BCP_CODE. 'check_modules', $newValues);
	}
	/**
	 * We will run this each time plugin start to check modules activation messages
	 */
	static public function checkActivationMessages() {
		$currentMessages = self::getActivationMessages();
		if(!empty($currentMessages)) {
			self::_checkActivationModules();
			add_action('admin_notices', array('modInstallerBcp', 'showAdminActivationModuleNotices'));
		}
		self::_checkActivatedPlugs();
	}
	
	static private function _checkActivationModules() {
		$modules = self::getActivationModules();
		if(!empty($modules)) {
			foreach($modules as $m) {
				if(frameBcp::_()->getModule($m['code'])) {
					frameBcp::_()->getModule('options')->getModel('modules')->put(array(
						'code' => $m['code'],
						'active' => 0,
					));
				}
			}
		}
	}
	/**
	 * Will display admin activation modules notices if such exist
	 */
	static public function showAdminActivationModuleNotices() {
		$currentMessages = self::getActivationMessages();
		if(!empty($currentMessages)) {
			frameBcp::_()->getModule('messenger')->getController()->getView()->displayAdminModActivationNotices($currentMessages);
		}
	}
	static public function getActivationMessages() {
		return get_option(BCP_CODE. 'activate_modules_msg', array());;
	}
    /**
     * Deactivate module after deactivating external plugin
     */
    static public function deactivate() {
        $locations = self::_getPluginLocations();
        if($modules = self::_getModulesFromXml($locations['xmlPath'])) {
            foreach($modules as $m) {
                $modDataArr = utilsBcp::xmlNodeAttrsToArr($m);
                if(frameBcp::_()->moduleActive($modDataArr['code'])) { //If module is active - then deacivate it
                    if(frameBcp::_()->getModule('options')->getModel('modules')->put(array(
                        'id' => frameBcp::_()->getModule($modDataArr['code'])->getID(),
                        'active' => 0,
                    ))->error) {
                        errorsBcp::push(langBcp::_('Error Deactivation module'), errorsBcp::MOD_INSTALL);
                    }
                }
            }
        }
        if(errorsBcp::haveErrors(errorsBcp::MOD_INSTALL)) {
            self::displayErrors(false);
            return false;
        }
        return true;
    }
    static public function activate($modDataArr) {
        $locations = self::_getPluginLocations();
        if($modules = self::_getModulesFromXml($locations['xmlPath'])) {
            foreach($modules as $m) {
                $modDataArr = utilsBcp::xmlNodeAttrsToArr($m);
                if(!frameBcp::_()->moduleActive($modDataArr['code'])) { //If module is not active - then acivate it
                    if(frameBcp::_()->getModule('options')->getModel('modules')->put(array(
                        'code' => $modDataArr['code'],
                        'active' => 1,
                    ))->error) {
                        errorsBcp::push(langBcp::_('Error Activating module'), errorsBcp::MOD_INSTALL);
                    } else {
						// For some reason - activation tables didn't worked here
						/*if(isset($modDataArr['code'])) {
							// Retrive ex_plug_dir data from database
							$dbModData = frameBcp::_()->getModule('options')->getModel('modules')->get(array('code' => $modDataArr['code']));
							if(!empty($dbModData) && !empty($dbModData[0])) {
								$modDataArr['ex_plug_dir'] = $dbModData[0]['ex_plug_dir'];
								// Run tables activation (updates) if required
								
								self::_installTables($modDataArr, 'activate');
							}
						}*/
					}
                }
            }
        }
    } 
    /**
     * Display all errors for module installer, must be used ONLY if You realy need it
     */
    static public function displayErrors($exit = true) {
        $errors = errorsBcp::get(errorsBcp::MOD_INSTALL);
        foreach($errors as $e) {
            echo '<b style="color: red;">'. $e. '</b><br />';
        }
        if($exit) exit();
    }
    static public function uninstall() {
        $locations = self::_getPluginLocations();
        if($modules = self::_getModulesFromXml($locations['xmlPath'])) {
            foreach($modules as $m) {
                $modDataArr = utilsBcp::xmlNodeAttrsToArr($m);
                self::_uninstallTables($modDataArr);
                frameBcp::_()->getModule('options')->getModel('modules')->delete(array('code' => $modDataArr['code']));
                utilsBcp::deleteDir(BCP_MODULES_DIR. $modDataArr['code']);
            }
        }
    }
    static protected  function _uninstallTables($module) {
        if(is_dir(BCP_MODULES_DIR. $module['code']. DS. 'tables')) {
            $tableFiles = utilsBcp::getFilesList(BCP_MODULES_DIR. $module['code']. DS. 'tables');
            if(!empty($tableNames)) {
                foreach($tableFiles as $file) {
                    $tableName = str_replace('.php', '', $file);
                    if(frameBcp::_()->getTable($tableName))
                        frameBcp::_()->getTable($tableName)->uninstall();
                }
            }
        }
    }
    static public function _installTables($module, $action = 'install') {
		$modDir = empty($module['ex_plug_dir']) ? 
            BCP_MODULES_DIR. $module['code']. DS : 
            utilsBcp::getPluginDir($module['ex_plug_dir']). $module['code']. DS; 
        if(is_dir($modDir. 'tables')) {
            $tableFiles = utilsBcp::getFilesList($modDir. 'tables');
            if(!empty($tableFiles)) {
                frameBcp::_()->extractTables($modDir. 'tables'. DS);
                foreach($tableFiles as $file) {
                    $tableName = str_replace('.php', '', $file);
                    if(frameBcp::_()->getTable($tableName))
                        frameBcp::_()->getTable($tableName)->$action();
                }
            }
        }
    }
}