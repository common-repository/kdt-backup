var datatable={
    selector:"#bcpBackupsListTable",
    params:{
            "iDisplayLength":4,
            "oLanguage": {
                            "sLengthMenu": "Display _MENU_ Orders In Page",
                            "sSearch": "Search:",
                            "sZeroRecords": "Not found",
                            "sInfo": "Show  _START_ to _END_ from _TOTAL_ records",
                            "sInfoEmpty": "show 0 to 0 from 0 records",
                            "sInfoFiltered": "(filtered from _MAX_ total records)",
			 },
            "bProcessing": true ,
            "bPaginate": true,
            "sPaginationType": "full_numbers"
    },
    create:function(){
        jQuery(this.selector).dataTable(this.default_options);    
    }
}
function createBAckupdatatable(){
    datatable.create();
}
function getBakupList(){
     var sendData ={
        mod     :   'backup',
        action  :   'refreshBackupList',
        reqType :   'ajax'
    }
    jQuery("#bcpBackupsListTable_wrapper").remove();
    jQuery(".table-container").addClass("bcpBigLoader");
    jQuery.sendFormBcp({
        msgElID:"",
        data:sendData,
        onSuccess:function(res){
            if(!res.error){
                jQuery(".table-container").removeClass("bcpBigLoader")
                jQuery(".table-container").html(res.html);
                datatable.create();
            }else{
               
            }
        }
    })     
}
function bcpRemoveBackup(backup_id){
	if(!confirm("Remove Backup?")){
		return false;
	}
	if(backup_id==""){
		return false;
	}
	var sendData={
		backup_id:backup_id,
		mod	:'backup',
		action :'removeBackup',
		reqType:'ajax'
	}
	jQuery.sendFormBcp({
	msgElID: 'bcpRemoveElemLoader__'+backup_id,
		data:sendData,
		onSuccess: function(res) {
			if(!res.error){
				 setTimeout(function(){
					 jQuery(".backupsTable").find('tr#backup_row_'+backup_id).hide('500');
					 jQuery(".backupsTable").find('tr#backup_row_'+backup_id).remove();
				 },500);   
			}
		}
	})
}
jQuery(document).ready(function(){
     createBAckupdatatable()
})