<?php
class tableIconsBcp extends tableBcp{
    public function __construct() {

        $this->_table = '@__icons';
        $this->_id = 'id';
        $this->_alias = 'bcp_icons';
        $this->_addField('id', 'int', 'int', '11', langBcp::_('Icon ID'))
                ->_addField('title', 'varchar', 'varchar', '100', langBcp::_('Icon Title'))
                ->_addField('description', 'description', 'text', '', langBcp::_('Icon Description'))
                ->_addField('path', 'varchar', 'varchar', '255', langBcp::_('File Path'));
    }
}

