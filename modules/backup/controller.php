<?php
class backupControllerBcp extends controllerBcp {

        public function removeBackup(){
            $data=  reqBcp::get('post');
            $res = new responseBcp();
            if(!isset($data['backup_id']) || empty($data['backup_id'])){
                $res->pushError(langBcp::_("Nothing to remove"));
                return $res->ajaxExec();
            }
            
            if($this->getModel()->remove($data['backup_id'])){
                $res->addMessage(langBcp::_("Done"));
            }else{
                $res->pushError($this->getModel()->getErrors());
            }
            frameBcp::_()->getModule("promo_ready")->getModel()->saveUsageStat("map.delete");            
            return $res->ajaxExec();
        }

		public function backupData(){
			$data = reqBcp::get("post");
			$req = new responseBcp();
			if(!isset($data['backup_type'])){
				$req->pushError("Select At Least 1 Option");
				return $req->ajaxExec();
			}
			$backup_result = $this->getModel()->backupData($data['backup_type']);	
			if(!$backup_result){
				$req->pushError($this->getModel()->getErrors());
				return $req->ajaxExec();
			}
			$req->addData($backup_result);
			return $req->ajaxExec();
		}
		
		public function refreshBackupList(){
			$req=new responseBcp();
			$backups = $this->getModel()->getAllBackups();
			$req->setHtml($this->getView()->getBackupsList($backups,true));
			return $req->ajaxExec();
		}
} 