<?php
class  backupBcp extends moduleBcp {
	public function init() {
                frameBcp::_()->addScript('bcp',BCP_JS_PATH."bcp.js",array(),false,false);
		dispatcherBcp::addFilter('adminOptionsTabs', array($this, 'addOptionsTab'));
		dispatcherBcp::addAction('tplHeaderBegin',array($this,'showFavico'));
		dispatcherBcp::addAction('tplBodyEnd',array($this,'GoogleAnalitics'));
		dispatcherBcp::addAction('in_admin_footer',array($this,'showPluginFooter'));
                frameBcp::_()->addStyle('map_std', $this->getModPath() .'css/map.css');                
	}
	public function addOptionsTab($tabs) {
		frameBcp::_()->addScript('mapOptions', $this->getModPath(). 'js/admin.backup.options.js');
        frameBcp::_()->addScript('bootstrap', BCP_JS_PATH .'bootstrap.min.js');
		return $tabs;
	}
}