<?php
class accessControllerBcp extends controllerBcp {
	
   public function saveIp() {
	   $res = new responseBcp();
		  if(($ipAddressData = $this->getModel()->saveIp(reqBcp::get('post'))) !== false) {
			$res->addMessage(langBcp::_('Ip address added'));
			$res->addData($ipAddressData);
		} else
			$res->pushError ($this->getModel('access')->getErrors());
		return $res->ajaxExec();
   }
   
   public function saveUser() {
	   $res = new responseBcp();
  		  if(($userData = $this->getModel()->saveUser(reqBcp::get('post'))) !== false) {
			$res->addMessage(langBcp::_('User added'));
			$res->addData($userData);
		} else
			$res->pushError ($this->getModel('access')->getErrors());
		return $res->ajaxExec();
   }
   
   public function deleteIp() {
	   $res = new responseBcp();
	   if(($delIpData = $this->getModel()->deleteElement(reqBcp::get('post'))) !== false) {
			$res->addMessage(langBcp::_('Ip address removed'));
			$res->addData($delIpData);
		} else
			$res->pushError($this->getModel('access')->getErrors());
		return $res->ajaxExec();
   }
   
   public function deleteUser() {
	   $res = new responseBcp();
	   if(($delUserData = $this->getModel()->deleteElement(reqBcp::get('post'))) !== false) {
			$res->addMessage(langBcp::_('User removed'));
			$res->addData($delUserData);
		} else
			$res->pushError($this->getModel('access')->getErrors());
		return $res->ajaxExec();
   }
   
    public function saveRole() {
	   $res = new responseBcp();
	   if(($roleRetData = $this->getModel()->saveRole(reqBcp::get('post'))) !== false) {
			$res->addMessage(langBcp::_('Role change'));
			//$res->addData($roleRetData);
		} else
			$res->pushError($this->getModel('access')->getErrors());
		return $res->ajaxExec();	
	}
   
}

