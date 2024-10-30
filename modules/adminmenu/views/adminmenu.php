<?php
class adminmenuViewBcp extends viewBcp {
    protected $_file = '';
    /**
     * Array for standart menu pages
     * @see initMenu method
     */
    protected $_mainSlug = 'kdt_backup_plugin';
    public function init() {
        $this->_file = __FILE__;
		//
        $this->_options = array(
            array('title' => langBcp::_('All Backups'),	'capability' => 'manage_options', 'menu_slug' => 'kdt_backup_plugin&tab=bcpAllBackups',	'function' =>  array(frameBcp::_()->getModule('backup')->getController(), 'getAllBackups')),
            array('title' => langBcp::_('New Backup'),	'capability' => 'manage_options', 'menu_slug' => 'kdt_backup_plugin&tab=bcpAddNewBackup',	'function' =>  array(frameBcp::_()->getModule('backup')->getController(), 'NewBackup')),
            
            array('title' => langBcp::_('Plugin Settings'),		'capability' => 'manage_options', 'menu_slug' => 'kdt_backup_plugin&tab=bcpPluginSettings',	'function' => array(frameBcp::_()->getModule('options')->getController(), 'pluginSettings')),
          
          
        );
        
       
        add_action('admin_menu', array($this, 'initMenu'), 9);
        parent::init();
    }
    public function initMenu() {
	$mainSlug = dispatcherBcp::applyFilters('adminMenuMainSlug', $this->_mainSlug);	
	$this->_options = dispatcherBcp::applyFilters('adminMenuOptions', $this->_options);
        add_menu_page(langBcp::_(BCP_WP_PLUGIN_NAME),
                      langBcp::_(BCP_WP_PLUGIN_NAME), 10,
                      $this->_mainSlug, 
                       array(frameBcp::_()->getModule('options')->getView(), 
                      'getAdminPage')
                    );
        
         foreach($this->_options as $opt) {
            add_submenu_page($mainSlug, langBcp::_($opt['title']),
                    langBcp::_($opt['title']), $opt['capability'], $opt['menu_slug'], $opt['function']);
        }
    }
    public function getFile() {
        return $this->_file;
    }
	public function getMainSlug() {
		return $this->_mainSlug;
	}
    /*public function getOptions() {
        return $this->_options;
    }*/
}