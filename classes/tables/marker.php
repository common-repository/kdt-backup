<?php
class tableMarkerBcp extends tableBcp{
    public function __construct() {

        $this->_table = '@__markers';
        $this->_id = 'id';
        $this->_alias = 'toe_mr';
        $this->_addField('id', 'int', 'int', '11', langBcp::_('Map ID'))
                ->_addField('title', 'varchar', 'varchar', '255', langBcp::_('File name'))
                ->_addField('description', 'text', 'text', '', langBcp::_('Description Of Map'))
                ->_addField('coord_x', 'varchar', 'varchar', '50', langBcp::_('X coordinate if marker(lng)')) 
                ->_addField('coord_y', 'varchar', 'varchar', '50', langBcp::_('Y coordinate of marker(lat)'))
                ->_addField('icon', 'varchar', 'varchar', '255', langBcp::_('Path of icon file'))
                ->_addField('map_id', 'int', 'int', '11', langBcp::_('Map Id'))                
                ->_addField('address', 'text', 'text', '', langBcp::_('Marker Address'))                
                ->_addField('marker_group_id', 'int', 'int', '11', langBcp::_("Id of Marker's group"))
                ->_addField('adnimation','int','int','0', langBcp::_('Animation'))
                ->_addField('create_date','datetime','datetime','',  langBcp::_('Creation date'));
    }
}

