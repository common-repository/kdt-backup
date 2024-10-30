<?php
class tableUsage_statBcp extends tableBcp{
    public function __construct() {

        $this->_table = '@__usage_stat';
        $this->_id = 'id';
        $this->_alias = 'bcp_icons';
        $this->_addField('id', 'int', 'int', '11', langBcp::_('Usage id'))
               ->_addField('code', 'varchar', 'varchar', '200', langBcp::_('Code'))
               ->_addField('visits', 'int', 'int', '11', langBcp::_('Visits Count'));
    }
}

