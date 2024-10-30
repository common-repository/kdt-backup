<?php
class userBcp extends moduleBcp {
    public function loadUserData() {
        return $this->getCurrent();
    }
    public function addProfileFieldsHtml($user) {
        //if($this->isCustomer($user->ID)) {
            $this->getController()->getView('user')->displayAllMeta($user->ID);
        //}
    }

    public function isAdmin() {
        if(!function_exists('wp_get_current_user')) {
                 frameBcp::_()->loadPlugins();
          }
        return current_user_can('administrator');
    }

	public function getCurrentUserPosition() {
		if($this->isAdmin())
			return BCP_ADMIN;
		else if($this->getCurrentID())
			return BCP_LOGGED;
		else 
			return BCP_GUEST;
	}
    public function getCurrent() {
        return $this->getController()->getModel('user')->get();
    }

    public function getCurrentID() {
        return $this->getController()->getModel()->getCurrentID();
    }
    /**
     * Returns the available tabs
     * 
     * @return array of tab 
     */
    public function getTabs(){
        $tabs = array();
        $tab = new tabBcp(langBcp::_('User Fields'), $this->getCode());
        $tab->setView('userFieldsTab');
		$tab->setSortOrder(3);
		$tab->setParent('templatesBcp');
		$tab->setNestingLevel(1);
        $tabs[] = $tab;
        return $tabs;
    }
}

