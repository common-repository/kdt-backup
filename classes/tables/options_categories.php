<?php
class tableOptions_categoriesBcp extends tableBcp {
    public function __construct() {
        $this->_table = '@__options_categories';
        $this->_id = 'id';     
        $this->_alias = 'toe_opt_cats';
        $this->_addField('id', 'hidden', 'int', 0, langBcp::_('ID'))
            ->_addField('label', 'text', 'varchar', 0, langBcp::_('Method'), 128);
    }
}
?>
