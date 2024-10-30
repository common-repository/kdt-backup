<?php
class adminmenuBcp extends moduleBcp {
    public function init() {
        parent::init();
        $this->getController()->getView('adminmenu')->init();
		$plugName = plugin_basename(BCP_DIR. BCP_MAIN_FILE);
		add_filter('plugin_action_links_'. $plugName, array($this, 'addSettingsLinkForPlug') );
    }
	public function addSettingsLinkForPlug($links) {
		array_unshift($links, '<a href="'. uriBcp::_(array('baseUrl' => admin_url('admin.php'), 'page' => frameBcp::_()->getModule('adminmenu')->getView()->getMainSlug())). '">'. langBcp::_('Settings'). '</a>');
		return $links;
	}
}

