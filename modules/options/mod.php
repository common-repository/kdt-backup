<?php
class optionsBcp extends moduleBcp {
	public static $saveStatistic=null;
        public static $statLimit=20;
        
    /**
     * Method to trigger the database update
     */
    public function init(){
        parent::init();
        
        
        if(!self::$saveStatistic){
           $data = frameBcp::_()->getTable("options")->get("*"," `code`='find_us' "); 
           $params = utilsBcp::jsonDecode($data[0]['params']);
           self::$saveStatistic = $params['save_statistic'];
        }
        
        $this->checkStatistic();
        /*$add_option = array(
            'add_checkbox' => langBcp::_('Add Checkbox'),
            'add_radiobutton' => langBcp::_('Add Radio Button'),
            'add_item' => langBcp::_('Add Item'),
        );
        frameBcp::_()->addJSVar('adminOptions', 'TOE_LANG', $add_option);*/
    }
    /**
     * Returns the available tabs
     * 
     * @return array of tab 
     */
    public function getTabs(){
        $tabs = array();
        $tab = new tabBcp(langBcp::_('General'), $this->getCode());
        $tab->setView('optionTab');
        $tab->setSortOrder(-99);
        $tabs[] = $tab;
        return $tabs;
    }
    /**
     * This method provides fast access to options model method get
     * @see optionsModel::get($d)
     */
    public function get($d = array()) {
        return $this->getController()->getModel()->get($d);
    }
	/**
     * This method provides fast access to options model method get
     * @see optionsModel::get($d)
     */
	public function isEmpty($d = array()) {
		return $this->getController()->getModel()->isEmpty($d);
	}
	
	public function getUploadDir() {
		return $this->_uploadDir;
	}
	public function getBgImgDir() {
		return $this->_uploadDir. DS. $this->_bgImgSubDir;
	}
	public function getBgImgFullDir() {
		return utilsBcp::getUploadsDir(). DS. $this->getBgImgDir(). DS. $this->get('bg_image');
	}
	public function getBgImgFullPath() {
		return utilsBcp::getUploadsPath(). '/'. $this->_uploadDir. '/'. $this->_bgImgSubDir. '/'. $this->get('bg_image');
	}
	
	public function getLogoImgDir() {
		return $this->_uploadDir. DS. $this->_bgLogoImgSubDir;
	}

	public function getLogoImgFullDir() {
		return utilsBcp::getUploadsDir(). DS. $this->getLogoImgDir(). DS. $this->get('logo_image');
	}
	
	public function getLogoImgFullPath() {
		return utilsBcp::getUploadsPath(). '/'. $this->_uploadDir. '/'. $this->_bgLogoImgSubDir. '/'. $this->get('logo_image');
	}
	
	public function getFavicoDir(){
		return $this->_uploadDir. DS. $this->_favicoDir;		
	}
	
	public function getFavicoFullDir(){
		
		return utilsBcp::getUploadsDir(). DS. $this->getFavicoDir(). DS. $this->get('favico');		
	}
	public function getFavicoFullPath(){
		return utilsBcp::getUploadsPath(). '/'. $this->_uploadDir. '/'. $this->_favicoDir. '/'. $this->get('favico');		
	}
	public function getAllowedPublicOptions() {
		$res = array();
		$alowedForPublic = array('mode', 'template');
		$allOptions = $this->getModel()->getByCode();
		foreach($alowedForPublic as $code) {
			if(isset($allOptions[ $code ]))
				$res[ $code ] = $allOptions[ $code ];
		}
		return $res;
	}
        public function getFindOptions(){
            return array(
			1 => array('label' => 'Google'),
			2 => array('label' => 'Wordpress.org'),
			3 => array('label' => 'Reffer a friend'),
			4 => array('label' => 'Find on the web'),
			5 => array('label' => 'Other way...'),
		);
        }
        
        public function updateStatistic($code){
            if(self::$saveStatistic==1){
               $this->getModel("options")->updateStatistic($code);
            }
        }
        public function checkStatistic(){
           // $stats = $this->getModel("options")->getStatsCount(); 
                    

            
            if(count($stats)>=self::$statLimit){
                //$this->sendStatistic($)
            }
        }
        public function sendStatistic(){
            
        }
}

