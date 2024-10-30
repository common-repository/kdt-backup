<?php
class tableFilesBcp extends tableBcp {
    public function __construct() {
        $this->_table = '@__files';
        $this->_id = 'id';
        $this->_alias = 'toe_f';
        $this->_addField('pid', 'hidden', 'int', '', langBcp::_('Product ID'))
                ->_addField('name', 'text', 'varchar', '255', langBcp::_('File name'))
                ->_addField('path', 'hidden', 'text', '', langBcp::_('Real Path To File'))
                ->_addField('mime_type', 'text', 'varchar', '32', langBcp::_('Mime Type'))
                ->_addField('size', 'text', 'int', 0, langBcp::_('File Size'))
                ->_addField('active', 'checkbox', 'tinyint', 0, langBcp::_('Active Download'))
                ->_addField('date','text','datetime','',langBcp::_('Upload Date'))
                ->_addField('download_limit','text','int','',langBcp::_('Download Limit'))
                ->_addField('period_limit','text','int','',langBcp::_('Period Limit'))
                ->_addField('description', 'textarea', 'text', 0, langBcp::_('Descritpion'))
                ->_addField('type_id','text','int','',langBcp::_('Type ID'));
    }
}
