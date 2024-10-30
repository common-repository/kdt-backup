jQuery(document).ready(function(){
	
 jQuery('#bcpAdminAccessFormIp').submit(function(){
  jQuery(this).sendFormBcp({
    msgElID: 'MSG_EL_ID_Ip',
    onSuccess: function(res) {
		if (!res.error) {
			jQuery('#bcpAdminAccessFormIp').clearForm();
			var addedElement = '<option value="' + res.data[0] +'">' + res.data[1] + '</option>';
			jQuery("select[name=selectlistBcpIp\\[\\]]").prepend(addedElement);
		}
    }
  });
  return false;
 });
 
  jQuery('#bcpAdminAccessFormUser').submit(function(){
	jQuery(this).sendFormBcp({
	  msgElID: 'MSG_EL_ID_User',
	  onSuccess: function(res) {
		 if (!res.error) {
			jQuery('#bcpAdminAccessFormUser').clearForm();
			var addedElement = '<option value="' + res.data[0] +'">' + res.data[1] + '</option>';
			jQuery("select[name=selectlistBcpUser\\[\\]]").prepend(addedElement);
		}
	  }
	});
	return false;
  });
  
  jQuery('#bcpAdminAccessFormRole').submit(function(){
	jQuery(this).sendFormBcp({
	  msgElID: 'MSG_EL_ID_Role'
	});
	return false;
  });
  
  jQuery("#delIpBcp").click(function(){
	 delElement('Ip');
  });
  
  jQuery("#delUserBcp").click(function(){
	 delElement('User');
  });
  
  function delElement(ch)
  {
	   var arrId;
		jQuery("select[name=selectlistBcp"+ch+"\\[\\]]").each(function(){
			arrId = jQuery(this).val();
		});
		  
	  if (arrId) {
		jQuery(this).sendFormBcp({
		  msgElID: 'MSG_EL_ID_'+ch,
		  data: {page: 'access', action: 'delete'+ch, reqType: 'ajax', arrElement: arrId },
		  onSuccess: function(res) {
			  if (res.data !== '') {
				res.data.forEach(function(entry) {
					jQuery("select[name=selectlistBcp"+ch+"\\[\\]] option[value="+entry+"]").remove();
				});
			  }
		  }
		});
	  }
  }
  
});

/*alert(res.errors);
alert(res.messages);*/