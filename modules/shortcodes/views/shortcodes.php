<?php
class shortcodesViewBcp extends viewBcp {
    public function adminTextEditorPopup() {
        $shortcodes = frameBcp::_()->getModule('shortcodesBcp')->getCodes();
        $shortcodesSelectOptions = array('' => langBcp::_('Select'));
        foreach($shortcodes as $code => $cinfo) {
            if(in_array($code, array('product', 'category'))) continue;
            $shortcodesSelectOptions[ $code ] = $code;
        }
        $this->assign('shortcodesBcp', $shortcodes);
        $this->assign('shortcodesSelectOptions', $shortcodesSelectOptions);
        return parent::getContent('adminTextEditorPopup');
    }
}
