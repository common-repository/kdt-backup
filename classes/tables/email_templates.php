<?php
class tableEmail_templatesBcp extends tableBcp {
    public function __construct() {
        $this->_table = '@__email_templates';
        $this->_id = 'id';
        $this->_alias = 'toe_etpl';
        $this->_addField('label', 'text', 'varchar', '', langBcp::_('Label'), 128, '','',langBcp::_('Template label'))
               ->_addField('subject', 'textarea', 'varchar','', langBcp::_('Subject'),255,'','',langBcp::_('E-mail Subject'))
               ->_addField('body', 'textarea', 'text','', langBcp::_('Body'),'','','',langBcp::_('E-mail Body'))
               ->_addField('variables', 'block', 'text','', langBcp::_('Variables'),'','','',langBcp::_('Template variables. They can be used in the body and subject'))
               ->_addField('active', 'checkbox', 'tinyint',0, langBcp::_('Active'),'','','',langBcp::_('If checked the notifications will be sent to receiver'))
               ->_addField('name', 'hidden', 'varchar','','',128)
               ->_addField('moduleBcp', 'hidden', 'varchar','','', 128);
    }
}
?>
