<?php
class backupViewBcp extends viewBcp {

        public function getBackupsList($data,$fromAjax=false){
			$this->assign("fromAjax",$fromAjax);	
			$this->assign("backupList",$data);
            return parent::getContent('backupList');
         }
		 
        public function addNewBackup(){
            return parent::getContent('newBackupForm');
        }

}