<?php
class tableMarker_groupsBcp extends tableBcp{
    public function __construct() {

        $this->_table = '@__marker_groups';
        $this->_id = 'id';
        $this->_alias = 'bcp_mrgr';
        $this->_addField('id', 'int', 'int', '11', langBcp::_('Map ID'))
                ->_addField('title', 'varchar', 'varchar', '255', langBcp::_('File name'))
                ->_addField('description', 'text', 'text', '', langBcp::_('Description Of Map'));
    }
}

