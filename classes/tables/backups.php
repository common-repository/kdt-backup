<?php
class tableBackupsBcp extends tableBcp{
    public function __construct() {

        $this->_table = '@__backups';
        $this->_id = 'id';
        $this->_alias = 'backups';
        $this->_addField('id', 'int', 'int', '11', langBcp::_('Backup ID'))
                ->_addField('archive_path', 'text', 'text', '', langBcp::_('Archive Path'))
                ->_addField('sql_dumps', 'text', 'text', '', langBcp::_('Sql Dumps Files'))
                ->_addField('create_date', 'datetime', 'datetime', '', langBcp::_('Create Date'))
                ->_addField('params', 'text', 'text', '', langBcp::_('Additional Params'));

    }
}

