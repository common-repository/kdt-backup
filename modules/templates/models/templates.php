<?php
class templatesModelBcp extends modelBcp {
    protected $_allTemplates = array();
    public function get($d = array()) {
        parent::get($d);
        if(empty($this->_allTemplates)) {
            $directories = utilsBcp::getDirList(BCP_TEMPLATES_DIR);
            if(!empty($directories)) {
                foreach($directories as $code => $dir) {
                    if($xml = utilsBcp::getXml($dir['path']. 'settings.xml')) {
                        $this->_allTemplates[$code] = $xml;
                        $this->_allTemplates[$code]->prevImg = BCP_TEMPLATES_PATH. $code. '/screenshot.png';
                    }
                }
            }
            if(is_dir( utilsBcp::getCurrentWPThemeDir(). 'bcp'. DS )) {
                if($xml = utilsBcp::getXml( utilsBcp::getCurrentWPThemeDir(). 'bcp'. DS. 'settings.xml' )) {
                    $code = utilsBcp::getCurrentWPThemeCode();
					if(strpos($code, '/') !== false) {	// If theme is in sub-folder
						$code = explode('/', $code);
						$code = trim( $code[count($code)-1] );
					}
                    $this->_allTemplates[$code] = $xml;
					if(is_file(utilsBcp::getCurrentWPThemeDir(). 'screenshot.jpg'))
						$this->_allTemplates[$code]->prevImg = utilsBcp::getCurrentWPThemePath(). '/screenshot.jpg';
					else
						$this->_allTemplates[$code]->prevImg = utilsBcp::getCurrentWPThemePath(). '/screenshot.png';
                }
            }
        }
        if(isset($d['code']) && isset($this->_allTemplates[ $d['code'] ]))
            return $this->_allTemplates[ $d['code'] ];
        return $this->_allTemplates;
    }
}
