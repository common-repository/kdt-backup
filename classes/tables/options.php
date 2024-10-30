<?php
class tableOptionsBcp extends tableBcp {
     public function __construct() {
        $this->_table = '@__options';
        $this->_id = 'id';     /*Let's associate it with posts*/
        $this->_alias = 'toe_opt';
        $this->_addField('id', 'text', 'int', 0, langBcp::_('ID'))->
                _addField('code', 'text', 'varchar', '', langBcp::_('Code'), 64)->
                _addField('value', 'text', 'varchar', '', langBcp::_('Value'), 134217728)->
                _addField('label', 'text', 'varchar', '', langBcp::_('Label'), 255)->
                _addField('params', 'text', 'text', '', langBcp::_('Params') )->
                _addField('description', 'text', 'text', '', langBcp::_('Description'))->
                _addField('htmltype_id', 'selectbox', 'text', '', langBcp::_('Type'))->
				_addField('cat_id', 'hidden', 'int', '', langBcp::_('Category ID'))->
				_addField('sort_order', 'hidden', 'int', '', langBcp::_('Sort Order'))->
				_addField('value_type', 'hidden', 'varchar', '', langBcp::_('Value Type'));;
    }
}
?>
