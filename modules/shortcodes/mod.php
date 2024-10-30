<?php
class shortcodesBcp extends moduleBcp {
        
        public function init() {
            $gmapModule = frameBcp::_()->getModule('gmap');
            add_shortcode('ready_google_map',array($gmapModule,'drawMapFromShortcode'));
        }
  
}