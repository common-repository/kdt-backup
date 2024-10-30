<?php
class tableSubscribersBcp extends tableBcp {
    public function __construct() {
        $this->_table = '@__subscribers';
        $this->_id = 'id';
        $this->_alias = 'toe_subscr';
        $this->_addField('user_id', 'text', 'int', '', langBcp::_('User Id'), 11, '', '', langBcp::_('User Id'))
            ->_addField('email', 'text', 'varchar', '', langBcp::_('User E-mail'), 255, '', '', langBcp::_('Subscriber E-mail'))
            ->_addField('name', 'text', 'varchar', 0, langBcp::_('User Name'),255,'','', langBcp::_('User Name If User Is Registered'))
            ->_addField('created', 'text', 'datetime', '', langBcp::_('Subscription Date'), '', '','', langBcp::_('Date Of Subscription'))
            ->_addField('active', 'checkbox', 'tinyint', '', langBcp::_('Active Subscription'), 4, '','', langBcp::_('If Is Not Checked user will not get any newsletters'))
            ->_addField('token', 'hidden', 'varchar', '', langBcp::_('Token'), 255,'','','')
			->_addField('ip', 'hidden', 'varchar', '', langBcp::_('IP address'), 64,'','','');
    }
}
?>