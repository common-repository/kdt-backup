<?php
//delete_option(BCP_DB_PREF. 'plug_was_used');
class promo_readyBcp extends moduleBcp {
	private $_specSymbols = array(
		'from'	=> array('?', '&'),
		'to'	=> array('%', '^'),
	);
	private $_minDataInStatToShow = 20;	// At least 5 points in table showld present before show send stats message
	public function init() {
		parent::init();
		dispatcherBcp::addFilter('templatesListToAdminTab', array($this, 'addPromoTemplates'));
		//dispatcherBcp::addFilter('adminOptModulesList', array($this, 'addPromoPayments'));
		add_action('admin_footer', array($this, 'displayAdminFooter'), 9);
		
		//dispatcherBcp::addFilter('adminMenuOptions', array($this, 'addWelcomePageToMenus'), 99);
		//dispatcherBcp::addFilter('adminMenuMainOption', array($this, 'addWelcomePageToMainMenu'), 99);
		//dispatcherBcp::addFilter('adminMenuMainSlug', array($this, 'modifyMainAdminSlug'), 99);
		/*
		* Check and send statistic
		*/
                
		$this->checkStatisticStatus();
	}
	public function getUserHidedSendStats() {
		return (int) get_option(BCP_CODE. 'user_hided_send_stats');
	}
	public function setUserHidedSendStats($newVal = 1) {
		return update_option(BCP_CODE. 'user_hided_send_stats', $newVal);
	}
	/**
	 * Show only if we have something to show or user didn't closed it
	 */
	public function canShowSendStats() {
		if(frameBcp::_()->getModule("options")->getModel("options")->getStatisticStatus()==1){
			return true;
		}
		return false;
	}
	public function showAdminSendStatNote() {
           
        if($this->canShowSendStats()){
			$this->getController()->getView()->showAdminSendStatNote();                    
        }

	}
	public function detectAdminStat() {

	}
	// We used such methods - _encodeSlug() and _decodeSlug() - as in slug wp don't understand urlencode() functions
	private function _encodeSlug($slug) {
		return str_replace($this->_specSymbols['from'], $this->_specSymbols['to'], $slug);
	}
	private function _decodeSlug($slug) {
		return str_replace($this->_specSymbols['to'], $this->_specSymbols['from'], $slug);
	}
	public function decodeSlug($slug) {
		return $this->_decodeSlug($slug);
	}
	public function modifyMainAdminSlug($mainSlug) {
		$firstTimeLookedToPlugin = !installerBcp::isUsed();
		if($firstTimeLookedToPlugin) {
			$mainSlug = $this->_getNewAdminMenuSlug($mainSlug);
		}
		return $mainSlug;
	}
	private function _getWelcomMessageMenuData($option, $modifySlug = true) {
		return array_merge($option, array(
			'page_title'	=> langBcp::_('Welcome to Ready! Ecommerce'),
			'menu_slug'		=> ($modifySlug ? $this->_getNewAdminMenuSlug( $option['menu_slug'] ) : $option['menu_slug'] ),
			'function'		=> array($this, 'showWelcomePage'),
		));
	}
	private function _getNewAdminMenuSlug($menuSlug) {
		// We can't use "&" symbol in slug - so we used "|" symbol
		return 'welcome-to-ready-ecommerce|return='. $this->_encodeSlug($menuSlug);
	}
	public function addWelcomePageToMenus($options) {
		
	}
	public function addWelcomePageToMainMenu($option) {
		
	}
	public function showWelcomePage() {
		return false;
        $firstTimeLookedToPlugin = !installerBcp::isUsed();
		if($firstTimeLookedToPlugin){
                    $this->getView()->showWelcomePage();
		}
	}
	public function saveUsageStat($code) {
		return $this->getModel()->saveUsageStat($code);
	}
	public function saveSpentTime($code, $spent) {
		return $this->getModel()->saveSpentTime($code, $spent);
	}
	private function _preparePromoLink($link) {
		$link .= '?ref=user';
		return $link;
	}
	/**
	 * Public shell for private method
	 */
	public function preparePromoLink($link) {
		return $this->_preparePromoLink($link);
	}
	public function displayAdminFooter() {
		if(frameBcp::_()->isAdminPlugPage())
			$this->getView()->displayAdminFooter();
	}
	public function checkStatisticStatus(){
		$canSend  = frameBcp::_()->getModule("options")->getModel("options")->getStatisticStatus();
		if($canSend){
			$this->getModel()->checkAndSend();
		}
    }
}
