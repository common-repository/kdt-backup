<?php
/**
 * Plugin Name: KDT BACKUP PLUGIN
 * Description: Make Backups Of Posts Or/And Files.  Plugin make backups,backups of posts and wordpress files ,and let download backup as zip archive from admin panel.
 * Version: 0.1
 * Author: KDT
 * 
 **/
    require_once(dirname(__FILE__). DIRECTORY_SEPARATOR. 'config.php');
    require_once(dirname(__FILE__). DIRECTORY_SEPARATOR. 'functions.php');
    importClassBcp('dbBcp');
    importClassBcp('installerBcp');
    importClassBcp('baseObjectBcp');
    importClassBcp('moduleBcp');
    importClassBcp('modelBcp');
    importClassBcp('viewBcp');
    importClassBcp('controllerBcp');
    importClassBcp('helperBcp');
    importClassBcp('tabBcp');
    importClassBcp('dispatcherBcp');
    importClassBcp('fieldBcp');
    importClassBcp('tableBcp');
    importClassBcp('frameBcp');
    importClassBcp('langBcp');
    importClassBcp('reqBcp');
    importClassBcp('uriBcp');
    importClassBcp('htmlBcp');
    importClassBcp('responseBcp');
    importClassBcp('fieldAdapterBcp');
    importClassBcp('validatorBcp');
    importClassBcp('errorsBcp');
    importClassBcp('utilsBcp');
    importClassBcp('modInstallerBcp');
    importClassBcp('wpUpdater');
	importClassBcp('toeWordpressWidgetBcp');
	importClassBcp('installerDbUpdaterBcp');
	importClassBcp('templateModuleBcp');
	importClassBcp('templateViewBcp');
	importClassBcp('fileuploaderBcp');
	importClassBcp('recapcha',			BCP_HELPERS_DIR. 'recapcha.php');
	importClassBcp('mobileDetect',		BCP_HELPERS_DIR. 'mobileDetect.php');

    installerBcp::update();
    errorsBcp::init();
 
    dispatcherBcp::doAction('onBeforeRoute');
    frameBcp::_()->parseRoute();
    dispatcherBcp::doAction('onAfterRoute');

    dispatcherBcp::doAction('onBeforeInit');
    frameBcp::_()->init();
    dispatcherBcp::doAction('onAfterInit');

    dispatcherBcp::doAction('onBeforeExec');
    frameBcp::_()->exec();
    dispatcherBcp::doAction('onAfterExec');
   
