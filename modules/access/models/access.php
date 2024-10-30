<?php
class accessModelBcp extends modelBcp {
	public function saveIp($post = array())	{
		if(isset($post['ipAddressBcp']) && !empty($post['ipAddressBcp'])) {
				if ($this->validationIp($post['ipAddressBcp'])) {
				   if(frameBcp::_()->getTable('access')->insert(array('access'=>$post['ipAddressBcp'], 'type_access'=>'1'))) {
						return array(frameBcp::_()->getTable('access')->getLastInsertID(), $post['ipAddressBcp']);
				   }
				   else
  			   		 $this->pushError(langBcp::_('Error writing to database'));		
				}
			
		} else
			$this->pushError(langBcp::_('Field is empty'));
		return false;
	}
	
	public function saveUser($post = array()) {
		if(isset($post['userBcp']) && !empty($post['userBcp'])) {
				
				if ($this->validationUser($post['userBcp'])) { 
				   if(frameBcp::_()->getTable('access')->insert(array('access'=>$post['userBcp'], 'type_access'=>'2'))) {
					   $user_meta = get_user_by('id', $post['userBcp']);
					   return array(frameBcp::_()->getTable('access')->getLastInsertID(), $user_meta->user_login);
				   }
				   else
				     $this->pushError(langBcp::_('Error writing to database'));		
				} 
		} else
			$this->pushError(langBcp::_('Field is empty'));
		return false;
	}
	
	public function saveRole($post = array()) {
		if(isset($post['roleBcp']) && !empty($post['roleBcp'])) {
			
			if( frameBcp::_()->getTable('access')->update(array('access' => $post['roleBcp']), array('id' => 1)) ) {
				return true;
			} else
			    $this->pushError(langBcp::_('Error writing to database'));		
		} 
		return false;
	}
	
	public function validationIp($ip) {
		if (preg_match('/^(25[0-5]|2[0-4][0-9]|[0-1][0-9]{2}|[0-9]{2}|[0-9])(\.(25[0-5]|2[0-4][0-9]|[0-1][0-9]{2}|[0-9]{2}|[0-9])){3}$/', $ip)) { // надо поправить ибо 000 это не гуд
			
			$check = frameBcp::_()->getTable('access')->get('*', "`access` = '$ip' AND `type_access` = 1");
			if (empty($check)) 
				return true;
			else 
				$this->pushError(langBcp::_('This Ip address already exists'));
			
		}
		else 
			$this->pushError(langBcp::_('Wrong format Ip address'));
		return false;
	}
	
	public function validationUser($user) {
		$check = frameBcp::_()->getTable('access')->get('*', "`access` = '$user' AND `type_access` = 2");
			if (empty($check))
				return true;
			else 
				$this->pushError(langBcp::_('This User already exists'));
	    return false;
	}
	
   public function deleteElement($post = array()) {
	   $returnDelElement = array();
	   foreach($post['arrElement'] as $el) {
		   if (!frameBcp::_()->getTable('access')->delete($el)) {
			  $this->pushError(langBcp::_('Element '.$el.' is not removed'));	   
		   }
		   else {
			   $returnDelElement[] = $el;
		   }
	   }
	   if ( $this->haveErrors() ) { 
	   		return false;
	   }
	  return $returnDelElement;
   }
   
   function GetRealIp() {
	   if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		 $ip=$_SERVER['HTTP_CLIENT_IP'];
	   } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	   } else {
		 $ip=$_SERVER['REMOTE_ADDR'];
	   }
	   return $ip;
	  }
   
   public function accessFilter() {
	   if (frameBcp::_()->getModule('user')->getCurrentID()) {
		   $current_user = wp_get_current_user();
		   $id = $current_user->ID;
		   if (frameBcp::_()->getTable('access')->get('*', "`access` = '$id' AND `type_access` = 2")) { 
		         return false;
		   } else { // role
			     $where['type_access'] = 3;
			     $role = frameBcp::_()->getTable('access')->get('*', $where);
				 $level = 'level_'.$role[0]['access'];
				 extract($current_user->allcaps);
				 if (!empty($$level)) {
					 return false;
				 }
			 return $this->checkIp();
		   }
	   } else { // this visitor user
			return $this->checkIp();
	   }
   }
   
   public function checkIp() {
	   $ip = utilsBcp::getIP();
	   if (frameBcp::_()->getTable('access')->get('*', array('access' => $ip, 'type_access' => 1)) ) {
	         return false;
	   } else 
	   		 return true;
   }
}
?>