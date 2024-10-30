<?php
/**
 * Class for templates module tab at options page
 */
class templatesViewBcp extends viewBcp {
    /**
     * Get the content for templates module tab
     * 
     * @return type 
     */
    public function getTabContent(){
       $templates = frameBcp::_()->getModule('templatesBcp')->getModel()->get();
       if(empty($templates)) {
           $tpl = 'noTemplates';
       } else {
           $this->assign('templatesBcp', $templates);
           $this->assign('default_theme', frameBcp::_()->getModule('optionsBcp')->getModel()->get('default_theme'));
           $tpl = 'templatesTab';
       }
       return parent::getContent($tpl);
   }
}

