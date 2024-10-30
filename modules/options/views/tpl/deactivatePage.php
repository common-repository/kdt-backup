<html>
    <head>
        <title><?php echo BCP_WP_PLUGIN_NAME .langBcp::_(":Deactivation")?></title>
		<link rel='stylesheet' href='<?php echo BCP_CSS_PATH?>/bcpTabsContent.css' type='text/css' />
		<link rel='stylesheet' href='<?php echo BCP_CSS_PATH?>/bootstrap.min.css' type='text/css' />
    </head>
    <body>
<div class='deactivate-block' id='bcpAdminOptionsTabs'>
    <div><?php langBcp::_e(BCP_WP_PLUGIN_NAME .' - Plugin Deactivation')?></div>
    <?php echo htmlBcp::formStart('deactivatePlugin', array('action' => $this->REQUEST_URI, 'method' => $this->REQUEST_METHOD))?>
    <?php
        $formData = array();
        switch($this->REQUEST_METHOD) {
            case 'GET':
                $formData = $this->GET;
                break;
            case 'POST':
                $formData = $this->POST;
                break;
        }
        foreach($formData as $key => $val) {
            if(is_array($val)) {
                foreach($val as $subKey => $subVal) {
                    echo htmlBcp::hidden($key. '['. $subKey. ']', array('value' => $subVal));
                }
            } else
                echo htmlBcp::hidden($key, array('value' => $val));
        }
    ?>
        <table width="100%">
            <tr>
                <td><?php langBcp::_e('Delete All Backup Data And Files')?>:</td>
                <td><?php echo htmlBcp::radiobuttons('deleteAllData', array('options' => array('No', 'Yes')))?></td>
            </tr>
        </table>
	<br class='clr' />
	<br class='clr' />
	
    <?php echo htmlBcp::submit('toeGo', array('value' => langBcp::_('Done'),'attrs'=>' class="btn btn-danger "'))?>
    <?php echo htmlBcp::formEnd()?>
    </div>
</body>
</html>