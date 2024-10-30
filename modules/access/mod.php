<?php
class accessBcp extends moduleBcp {
 public function init() {
		dispatcherBcp::addFilter('adminOptionsTabs', array($this, 'addOptionsTab'));
		dispatcherBcp::addFilter('canAccessSite', array($this, 'accessFilter'));
	}
	
	public function addOptionsTab($tabs) {
		frameBcp::_()->addScript('adminAccessOptions', $this->getModPath(). 'js/admin.access.options.js');
		$tabs['bcpAccess'] = array(
		   'title' => 'Access', 'content' => $this->getController()->getView()->getAdminOptions(),
		);
		return $tabs;
	}  
	
	public function getList() {
			$res[] = $this->getController()->getView('ipBlock');
			$res[] = $this->getController()->getView('userBlock');
		return $res;
	}
	
	public function accessFilter() {
		return $this->getController()->getModel()->accessFilter();
	}
}

