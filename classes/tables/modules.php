<?php
class tableModulesBcp extends tableBcp {
    public function __construct() {
        $this->_table = '@__modules';
        $this->_id = 'id';     /*Let's associate it with posts*/
        $this->_alias = 'toe_m';
        $this->_addField('label', 'text', 'varchar', 0, langBcp::_('Label'), 128)
                ->_addField('type_id', 'selectbox', 'smallint', 0, langBcp::_('Type'))
                ->_addField('active', 'checkbox', 'tinyint', 0, langBcp::_('Active'))
                ->_addField('params', 'textarea', 'text', 0, langBcp::_('Params'))
                ->_addField('has_tab', 'checkbox', 'tinyint', 0, langBcp::_('Has Tab'))
                ->_addField('description', 'textarea', 'text', 0, langBcp::_('Description'), 128)
                ->_addField('code', 'hidden', 'varchar', '', langBcp::_('Code'), 64)
                ->_addField('ex_plug_dir', 'hidden', 'varchar', '', langBcp::_('External plugin directory'), 255);
    }
}
?>
