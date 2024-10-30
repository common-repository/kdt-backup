<?php
class templateViewBcp extends viewBcp {
	protected $_styles = array();
	protected $_scripts = array();
	/**
	 * Provide or not html code of subscribe for to template. Can be re-defined for child classes
	 */
	protected $_useSubscribeForm = true;
	/**
	 * Provide or not html code of social icons for to template. Can be re-defined for child classes
	 */
	protected $_useSocIcons = true;
	public function getComingSoonPageHtml() {
		$this->_beforeShow();
		
		$this->assign('msgTitle', frameBcp::_()->getModule('options')->get('msg_title'));
		$this->assign('msgTitleColor', frameBcp::_()->getModule('options')->get('msg_title_color'));
		$this->assign('msgTitleFont', frameBcp::_()->getModule('options')->get('msg_title_font'));
		$msgTitleStyle = array();
		if(!empty($this->msgTitleColor))
			$msgTitleStyle['color'] = $this->msgTitleColor;
		if(!empty($this->msgTitleFont)) {
			$msgTitleStyle['font-family'] = $this->msgTitleFont;
			$this->_styles[] = 'http://fonts.googleapis.com/css?family='. $this->msgTitleFont. '&subset=latin,cyrillic-ext';
		}
		$this->assign('msgTitleStyle', utilsBcp::arrToCss( $msgTitleStyle ));
		
		$this->assign('msgText', frameBcp::_()->getModule('options')->get('msg_text'));
		$this->assign('msgTextColor', frameBcp::_()->getModule('options')->get('msg_text_color'));
		$this->assign('msgTextFont', frameBcp::_()->getModule('options')->get('msg_text_font'));
		$msgTextStyle = array();
		if(!empty($this->msgTextColor))
			$msgTextStyle['color'] = $this->msgTextColor;
		if(!empty($this->msgTextFont)) {
			$msgTextStyle['font-family'] = $this->msgTextFont;
			if($this->msgTitleFont != $this->msgTextFont)
				$this->_styles[] = 'http://fonts.googleapis.com/css?family='. $this->msgTextFont. '&subset=latin,cyrillic-ext';
		}
		$this->assign('msgTextStyle', utilsBcp::arrToCss( $msgTextStyle ));
		
		if($this->_useSubscribeForm && frameBcp::_()->getModule('options')->get('sub_enable')) {
			$this->_scripts[] = frameBcp::_()->getModule('subscribe')->getModPath(). 'js/frontend.subscribe.js';
			$this->assign('subscribeForm', frameBcp::_()->getModule('subscribe')->getController()->getView()->getUserForm());
		}
		
		$this->assign('countDownTimerHtml', dispatcherBcp::applyFilters('countDownTimerHtml', ''));
		$this->assign('progressBarHtml', dispatcherBcp::applyFilters('progressBarHtml', ''));
		$this->assign('contactFormHtml', dispatcherBcp::applyFilters('contactFormHtml', ''));
		$this->assign('googleMapsHtml', dispatcherBcp::applyFilters('googleMapsHtml', ''));

		if($this->_useSocIcons) {
			$this->assign('socIcons', frameBcp::_()->getModule('social_icons')->getController()->getView()->getFrontendContent());
		}
		
		if(file_exists($this->getModule()->getModDir(). 'css/style.css'))
			$this->_styles[] = $this->getModule()->getModPath(). 'css/style.css';
		
		$this->assign('logoPath', $this->getModule()->getLogoImgPath());
		$this->assign('bgCssAttrs', dispatcherBcp::applyFilters('tplBgCssAttrs', $this->getModule()->getBgCssAttrs()));
		$this->assign('styles', dispatcherBcp::applyFilters('tplStyles', $this->_styles));
		$this->assign('scripts', dispatcherBcp::applyFilters('tplScripts', $this->_scripts));
		$this->assign('initJsVars', dispatcherBcp::applyFilters('tplInitJsVars', $this->initJsVars()));
		$this->assign('messages', frameBcp::_()->getRes()->getMessages());
		$this->assign('errors', frameBcp::_()->getRes()->getErrors());
		return parent::getContent($this->getCode(). 'BCPHtml');
	}
	public function addScript($path) {
		if(!in_array($path, $this->_scripts))
			$this->_scripts[] = $path;
	}
	public function addStyle($path) {
		if(!in_array($path, $this->_styles))
			$this->_styles[] = $path;
	}
	public function initJsVars() {
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
			'BCP_CODE'					=> BCP_CODE,
		);
		return '<script type="text/javascript">
		// <!--
			var BCP_DATA = '. utilsBcp::jsonEncode($jsData). ';
		// -->
		</script>';
	}
	protected function _beforeShow() {
		
	}
}