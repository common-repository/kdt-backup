<?php
class tableLogBcp extends tableBcp {
    public function __construct() {
        $this->_table = '@__log';
        $this->_id = 'id';     /*Let's associate it with posts*/
        $this->_alias = 'toe_log';
        $this->_addField('id', 'text', 'int', 0, langBcp::_('ID'), 11)
                ->_addField('type', 'text', 'varchar', '', langBcp::_('Type'), 64)
                ->_addField('data', 'text', 'text', '', langBcp::_('Data'))
                ->_addField('date_created', 'text', 'int', '', langBcp::_('Date created'))
				->_addField('uid', 'text', 'int', 0, langBcp::_('User ID'))
				->_addField('oid', 'text', 'int', 0, langBcp::_('Order ID'));
    }
}