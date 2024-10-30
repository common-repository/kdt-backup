<?php
class modulesModelBcp extends modelBcp {
    public function get($d = array()) {
        if($d['id'] && is_numeric($d['id'])) {
            $fields = frameBcp::_()->getTable('modules')->fillFromDB($d['id'])->getFields();
            $fields['types'] = array();
            $types = frameBcp::_()->getTable('modules_type')->fillFromDB();
            foreach($types as $t) {
                $fields['types'][$t['id']->value] = $t['label']->value;
            }
            return $fields;
        } elseif(!empty($d)) {
            $data = frameBcp::_()->getTable('modules')->get('*', $d);
            return $data;
        } else {
            return frameBcp::_()->getTable('modules')
                ->innerJoin(frameBcp::_()->getTable('modules_type'), 'type_id')
                ->getAll(frameBcp::_()->getTable('modules')->alias().'.*, '. frameBcp::_()->getTable('modules_type')->alias(). '.label as type');
        }
        parent::get($d);
    }
    public function put($d = array()) {
        $res = new responseBcp();
        $id = $this->_getIDFromReq($d);
        $d = prepareParamsBcp($d);
        if(is_numeric($id) && $id) {
            if(isset($d['active']))
                $d['active'] = ((is_string($d['active']) && $d['active'] == 'true') || $d['active'] == 1) ? 1 : 0;           //mmm.... govnokod?....)))
           /* else
                 $d['active'] = 0;*/
            
            if(frameBcp::_()->getTable('modules')->update($d, array('id' => $id))) {
                $res->messages[] = langBcp::_('Module Updated');
                $mod = frameBcp::_()->getTable('modules')->getById($id);
                $newType = frameBcp::_()->getTable('modules_type')->getById($mod['type_id'], 'label');
                $newType = $newType['label'];
                $res->data = array(
                    'id' => $id, 
                    'label' => $mod['label'], 
                    'code' => $mod['code'], 
                    'type' => $newType,
                    'params' => utilsBcp::jsonEncode($mod['params']),
                    'description' => $mod['description'],
                    'active' => $mod['active'], 
                );
            } else {
                if($tableErrors = frameBcp::_()->getTable('modules')->getErrors()) {
                    $res->errors = array_merge($res->errors, $tableErrors);
                } else
                    $res->errors[] = langBcp::_('Module Update Failed');
            }
        } else {
            $res->errors[] = langBcp::_('Error module ID');
        }
        parent::put($d);
        return $res;
    }
    public function delete($d = array()) {
        $id = $this->_getIDFromReq($d);
        if(is_numeric($id) && $id) {
            frameBcp::_()->getTable('modules')->delete($d);
        }
    }
    protected function _getIDFromReq($d = array()) {
        $id = 0;
        if(isset($d['id']))
            $id = $d['id'];
        elseif(isset($d['code'])) {
            $fromDB = $this->get(array('code' => $d['code']));
            if($fromDB[0]['id'])
                $id = $fromDB[0]['id'];
        }
        return $id;
    }
    /**
     * Collect the tabs from the given modules
     * 
     * @param array $modules
     * @return array of tab 
     */
    public function getTabs($modules = array()){
        if (!is_array($modules)) {
            $modules = array($modules);
        }
        $tabs = array();
        if (!empty($modules)) {
            foreach ($modules as $module) {
                if ($module['has_tab'] && frameBcp::_()->getModule($module['code'])) {
                    $moduleTabs = frameBcp::_()->getModule($module['code'])->getTabs();
                    if (!empty($moduleTabs)) {
						$tabs = array_merge($tabs, $moduleTabs);
                    }
                }
            }
        }
		if(!empty($tabs)) {
			usort($tabs, array($this, 'sortTabsCallback'));
			$tempTabs = $tabs;
			foreach($tempTabs as $i => $tab) {
				$parent = $tab->getParent();
				if(empty($parent) && ($parentIter = $this->getTabIterByModule($tabs, $parent))) {
					array_splice($tabs, $parentIter+1, 1, array($tabs[$parentIter+1], $tab));
				}
			}
		}
        return $tabs;
    }
	
	public function getTabIterByModule($tabs, $module) {
		foreach($tabs as $i => $tab) {
			if($tab->getModule() == $module)
				return $i;
		}
		return false;
	}
	public function sortTabsCallback($a, $b) {
		$sortOrderA = $a->getSortOrder();
		$sortOrderB = $b->getSortOrder();
		/*if($sortOrderA === false)
			$sortOrderA = -1;
		if($sortOrderB === false)
			$sortOrderB = -1;
		if($sortOrderA == $sortOrderB)
			return 0;
		return $sortOrderA > $sortOrderB ? 1 : -1;*/
		if($sortOrderA === false && $sortOrderB === false) {
			return 0;
		} elseif($sortOrderA !== false && $sortOrderB === false) {
			return -1;
		} elseif($sortOrderA === false && $sortOrderB !== false) {
			return 1;
		} elseif($sortOrderA !== false && $sortOrderB !== false) {
			if($sortOrderA == $sortOrderB)
				return 0;
			else
				return $sortOrderA > $sortOrderB ? 1 : -1;
		}
		return 0;
	}
	public function activatePlugin($d = array()) {
		$plugName = isset($d['plugName']) ? $d['plugName'] : '';
		if(!empty($plugName)) {
			$activationKey = isset($d['activation_key']) ? $d['activation_key'] : '';
			if(!empty($activationKey)) {
				$result = modInstallerBcp::activatePlugin($plugName, $activationKey);
				if($result === true) {
					$allActivationModules = modInstallerBcp::getActivationModules();
					// Activate all required modules
					if(!empty($allActivationModules)) {
						foreach($allActivationModules as $i => $m) {
							if($m['plugName'] == $plugName) {
								// We need to set this var here each time - as it will be detected on put() method bellow
								unset($allActivationModules[ $i ]);
								modInstallerBcp::updateActivationModules($allActivationModules);
								$this->put(array(
									'code' => $m['code'],
									'active' => 1,
								));
}
						}
						modInstallerBcp::updateActivationModules($allActivationModules);
					}
					$allActivationMessages = modInstallerBcp::getActivationMessages();
					// Remove activation messages for this plugin
					if(!empty($allActivationMessages) && isset($allActivationMessages[ $plugName ])) {
						unset($allActivationMessages[ $plugName ]);
						modInstallerBcp::updateActivationMessages($allActivationMessages);
					}
					return true;
				} elseif(is_array($result)) {	// Array with errors
					$this->pushError($result);
				} else {
					$this->pushError(langBcp::_('Can not contact authorization server for now.'));
					$this->pushError(langBcp::_('Please try again latter.'));
					$this->pushError(langBcp::_('If problem will not stop - please contact us using this form <a href="http://readyshoppingcart.com/contacts/" target="_blank">http://readyshoppingcart.com/contacts/</a>.'));
				}
			} else
				$this->pushError (langBcp::_('Please enter activation key'));
		} else
			$this->pushError (langBcp::_('Empty plugin name'));
		return false;
	}
	public function activateUpdate($d = array()) {
		$plugName = isset($d['plugName']) ? $d['plugName'] : '';
		if(!empty($plugName)) {
			$activationKey = isset($d['activation_key']) ? $d['activation_key'] : '';
			if(!empty($activationKey)) {
				$result = modInstallerBcp::activateUpdate($plugName, $activationKey);
				if($result === true) {
					return true;
				} elseif(is_array($result)) {	// Array with errors
					$this->pushError($result);
				} else {
					$this->pushError(langBcp::_('Can not contact authorization server for now.'));
					$this->pushError(langBcp::_('Please try again latter.'));
					$this->pushError(langBcp::_('If problem will not stop - please contact us using this form <a href="http://readyshoppingcart.com/contacts/" target="_blank">http://readyshoppingcart.com/contacts/</a>.'));
				}
			} else
				$this->pushError (langBcp::_('Please enter activation key'));
		} else
			$this->pushError (langBcp::_('Empty plugin name'));
	}
}
