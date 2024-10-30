<?php
class templatesBcp extends moduleBcp {
    /**
     * Returns the available tabs
     * 
     * @return array of tab 
     */
    protected $_styles = array();
    public function getTabs(){
        $tabs = array();
        $tab = new tabBcp(langBcp::_('Templates'), $this->getCode());
        $tab->setView('templatesTab');
		$tab->setSortOrder(1);
        $tabs[] = $tab;
        return $tabs;
    }
    public function init() {

        $this->_styles = array(
            'styleBcp'				=> array('path' => BCP_CSS_PATH. 'style.css'), 
			'adminStylesBcp'		=> array('path' => BCP_CSS_PATH. 'adminStyles.css'), 
			
			'jquery-tabs'			=> array('path' => BCP_CSS_PATH. 'jquery-tabs.css'),
			'jquery-buttons'		=> array('path' => BCP_CSS_PATH. 'jquery-buttons.css'),
			'wp-jquery-ui-dialog'	=> array(),
			'farbtastic'			=> array(),
			// Our corrections for ui dialog
			'jquery-dialog'			=> array('path' => BCP_CSS_PATH. 'jquery-dialog.css'),
        );

        $defaultPlugTheme = frameBcp::_()->getModule('options')->get('default_theme');
		$ajaxurl = admin_url('admin-ajax.php');
		if(frameBcp::_()->getModule('options')->get('ssl_on_ajax')) {
			$ajaxurl = uriBcp::makeHttps($ajaxurl);
		}
        $jsData = array(
            'siteUrl'					=> BCP_SITE_URL,
            'imgPath'					=> BCP_IMG_PATH,
            'loader'					=> BCP_LOADER_IMG, 
            'close'						=> BCP_IMG_PATH. 'cross.gif', 
            'ajaxurl'					=> $ajaxurl,
            'animationSpeed'			=> frameBcp::_()->getModule('options')->get('js_animation_speed'),
			'siteLang'					=> langBcp::getData(),
			'options'					=> frameBcp::_()->getModule('options')->getAllowedPublicOptions(),
			'BCP_CODE'					=> BCP_CODE,
			'ball_loader'				=> BCP_IMG_PATH. 'ajax-loader-ball.gif',
			'ok_icon'					=> BCP_IMG_PATH. 'ok-icon.png',
        );
        
		frameBcp::_()->addScript('jquery-ui-tabs', '', array('jquery'));
		frameBcp::_()->addScript('jquery-ui-dialog', '', array('jquery'));
		frameBcp::_()->addScript('jquery-ui-button', '', array('jquery'));
		 	
		frameBcp::_()->addScript('farbtastic',get_bloginfo('wpurl'). '/wp-admin/js/farbtastic.js');
                 
		frameBcp::_()->addScript('commonBcp', BCP_JS_PATH. 'common.js');
		frameBcp::_()->addScript('coreBcp', BCP_JS_PATH. 'core.js');
		frameBcp::_()->addScript('datatable', BCP_JS_PATH. 'jquery.dataTables.min.js');
		
        if (is_admin()) {
			frameBcp::_()->addScript('adminOptionsBcp', BCP_JS_PATH. 'admin.options.js');
			frameBcp::_()->addScript('ajaxupload', BCP_JS_PATH. 'ajaxupload.js');
			frameBcp::_()->addScript('postbox', get_bloginfo('wpurl'). '/wp-admin/js/postbox.js');
			add_thickbox();
			
			$jsData['allCheckRegPlugs']	= modInstallerBcp::getCheckRegPlugs();
		} else {

        }
        
		$jsData = dispatcherBcp::applyFilters('jsInitVariables', $jsData);
        frameBcp::_()->addJSVar('coreBcp', 'BCP_DATA', $jsData);

		
        
        foreach($this->_styles as $s => $sInfo) {
            if(isset($sInfo['for'])) {
                if(($sInfo['for'] == 'frontend' && is_admin()) || ($sInfo['for'] == 'admin' && !is_admin()))
                    continue;
            }
            $canBeSubstituted = true;
            if(isset($sInfo['substituteFor'])) {
                switch($sInfo['substituteFor']) {
                    case 'frontend':
                        $canBeSubstituted = !is_admin();
                        break;
                    case 'admin':
                        $canBeSubstituted = is_admin();
                        break;
                }
            }
            if($canBeSubstituted && file_exists(BCP_TEMPLATES_DIR. $defaultPlugTheme. DS. $s. '.css')) {
                frameBcp::_()->addStyle($s, BCP_TEMPLATES_PATH. $defaultPlugTheme. '/'. $s. '.css');
            } elseif($canBeSubstituted && file_exists(utilsBcp::getCurrentWPThemeDir(). 'bcp'. DS. $s. '.css')) {
                frameBcp::_()->addStyle($s, utilsBcp::getCurrentWPThemePath(). '/toe/'. $s. '.css');
            } elseif(!empty($sInfo['path'])) {
                frameBcp::_()->addStyle($s, $sInfo['path']);
            } else {
				frameBcp::_()->addStyle($s);
			}
        }
                //add_action('wp_head', array($this, 'addInitJsVars'));
        parent::init();
                                                

    }
	/**
	 * Some JS variables should be added after first wordpress initialization.
	 * Do it here.
	 */
	public function addInitJsVars() {
		frameBcp::_()->addJSVar('adminOptions', 'BCP_PAGES', array(
			'isCheckoutStep1' => @frameBcp::_()->getModule('pages')->isCheckoutStep1(),
			'isCart' => frameBcp::_()->getModule('pages')->isCart(),
		));
	}
}
