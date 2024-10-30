<?php
class optionsViewBcp extends viewBcp {
    public function getAdminPage() {
            if(!installerBcp::isUsed()){
                frameBcp::_()->getModule("promo_ready")->showWelcomePage();
                return;
            }
		$presetTemplatesHtml = $this->getPresetTemplates();

		$tabsData = array(
               'bcpAddNewBackup'   => array('title'    =>  'New Backup',
                                                  'content' =>  $this->addNewBackupTab()),
                    
				'bcpAllBackups'     => array('title'   => 'All Backups', 
                                                  'content' => $this->getBackupsListTab()),

		        'bcpPluginSettings'=>array('title'=>'Plugin Settings',
                                                    'content'=>$this->getPluginSettingsTab())                        
		);
		$tabsData = dispatcherBcp::applyFilters('adminOptionsTabs', $tabsData);
	
		$this->assign('presetTemplatesHtml', $presetTemplatesHtml);
		$this->assign('tabsData', $tabsData);
                //$this->assign("admin_footer",frameBcp::_()->getModule("promo_ready")->displayAdminFooter());       
                $defaultOpenTab  = reqBcp::getVar("tab",'get');
				
				if(empty($defaultOpenTab)){
					$defaultOpenTab = "bcpAllBackups";
				}
                $this->assign("defaultOpenTab",$defaultOpenTab);
        parent::display('optionsAdminPage');
    }
    
        public function getPluginSettingsTab(){
            $saveStatistic = $this->getModel("options")->getStatisticStatus();
            $this->assign("saveStatistic",$saveStatistic);
            return parent::getContent("settingsTab");
        }
	public function getPresetTemplates() {
			return parent::getContent('templatePresetTemplates');
	}
        public function addNewBackupTab(){
            return frameBcp::_()->getModule('backup')->getView()->addNewBackup();
        }
        public function getBackupsListTab(){
			$backup_list = frameBcp::_()->getModule('backup')->getModel()->getAllBackups();
            return frameBcp::_()->getModule('backup')->getView()->getBackupsList($backup_list ); 
        }
       
	
        
	public function getTemplateBgOptionsHtml() {
		if(!isset($this->optModel))
			$this->assign('optModel', $this->getModel());
		return parent::getContent('templateBgOptionsHtml');
	}
	public function getTemplateLogoOptionsHtml() {
		if(!isset($this->optModel))
			$this->assign('optModel', $this->getModel());
		return parent::getContent('templateLogoOptionsHtml');
	}
	public function getTemplateMsgOptionsHtml() {
		if(!isset($this->optModel))
			$this->assign('optModel', $this->getModel());
		return parent::getContent('templateMsgOptionsHtml');
	}
        public function displayDeactivatePage(){
            $this->assign('GET', reqBcp::get('get'));
            $this->assign('POST',reqBcp::get('post'));
            $this->assign('REQUEST_METHOD', strtoupper(reqBcp::getVar('REQUEST_METHOD', 'server')));
            $this->assign('REQUEST_URI', basename(reqBcp::getVar('REQUEST_URI', 'server')));
            parent::display("deactivatePage");
        }
}
