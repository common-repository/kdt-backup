<?php
class optionsControllerBcp extends controllerBcp {
        public function activatePlugin() {
		$res = new responseBcp();
		if($this->getModel('modules')->activatePlugin(reqBcp::get('post'))) {
			$res->addMessage(langBcp::_('Plugin was activated'));
		} else {
			$res->pushError($this->getModel('modules')->getErrors());
		}
		return $res->ajaxExec();
	}
	public function activateUpdate() {
		$res = new responseBcp();
		if($this->getModel('modules')->activateUpdate(reqBcp::get('post'))) {
			$res->addMessage(langBcp::_('Very good! Now plugin will be updated.'));
		} else {
			$res->pushError($this->getModel('modules')->getErrors());
		}
		return $res->ajaxExec();
	}
	public function getPermissions() {
		return array(
			BCP_USERLEVELS => array(
				BCP_ADMIN => array('save', 'saveGroup', 'saveBgImg', 'saveLogoImg','saveFavico', 
					'saveMainGroup', 'saveSubscriptionGroup', 'setTplDefault', 
					'removeBgImg', 'removeLogoImg',
					'activatePlugin', 'activateUpdate')
			),
		);
	}
        
        public function updateStatisticStatus(){
            $data = reqBcp::get("post");
            $result = $this->getModel("options")->updateStatisticStatus($data);
            $resp = new responseBcp();
            if($result){
                $resp->addMessage(langBcp::_("Done"));
            }else{
                $resp->pushError("Cannot Save Info");
            }
            return $resp->ajaxExec();
        }
		public function pluginSettings(){
			
			
		}
        
}

