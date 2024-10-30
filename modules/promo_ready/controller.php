<?php
class promo_readyControllerBcp extends controllerBcp {
	public function welcomePageSaveInfo() {
		$res = new responseBcp();
                
		if($this->getModel()->welcomePageSaveInfo(reqBcp::get('post'))) {
			$res->addMessage(langBcp::_('Information was saved. Thank you!'));
			$originalPage = reqBcp::getVar('original_page');
			$returnArr = explode('|', $originalPage);
			$return = $this->getModule()->decodeSlug(str_replace('return=', '', $returnArr[1]));
			$return = admin_url( strpos($return, '?') ? $return : 'admin.php?page='. $return);
			$res->addData('redirect', $return);
			installerBcp::setUsed();
		} else {
			$res->pushError($this->getModel()->getErrors());
		}
		return $res->ajaxExec();
	}
	public function saveUsageStat() {
		$res = new responseBcp();
		$code = reqBcp::getVar('code');
		if($code)
			$this->getModel()->saveUsageStat($code);
		return $res->ajaxExec();
	}
	public function sendUsageStat() {
		$res = new responseBcp();
		$this->getModel()->sendUsageStat();
		$res->addMessage(langBcp::_('Information was saved. Thank you for your support!'));
		return $res->ajaxExec();
	}
	public function hideUsageStat() {
		$res = new responseBcp();
		$this->getModule()->setUserHidedSendStats();
		return $res->ajaxExec();
	}
	/**
	 * @see controller::getPermissions();
	 */
	public function getPermissions() {
		return array(
			BCP_USERLEVELS => array(
				BCP_ADMIN => array('welcomePageSaveInfo', 'saveUsageStat', 'sendUsageStat', 'hideUsageStat')
			),
		);
	}
}