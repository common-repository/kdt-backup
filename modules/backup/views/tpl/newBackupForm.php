<?php
	$checkbox_type_arr=array(
		"all"=>"All",
		"posts"=>langBcp::_("Posts"),
		"files"=>langBcp::_("Files")
	);
?>
<div class='newBackupForm'>
	<h2>Add New Backup</h2>
	<div class='clr'></div>
	<div class='focm-container'>
		<?php 
			echo htmlBcp::formStart("NewBackUpForm", $params=array("attrs"=>" id='NewBackUpForm' "))
		?>
		<div class='form-row'>
			
			<div class='select-type-cont'>
				<label for='select_backup_type'>What Do You Want To Save-Backup</label>
				<select id="select_backup_type" name='backup_type'>
				<?php
				
					foreach($checkbox_type_arr as $val=>$name){
						?>
							<option value='<?php echo $val?>'><?php echo $name;?></option>
						<?php
					}
				?>
				</select>
			</div>	
		</div>	
		<div class='clearfix'>
			<div class='bcp-response-cont' id='NewBackupResp'>
				
			</div>	
			<div class='btns-cont'>
				<button class='btn btn-success' type='submit'>
					<i class='bcpIconw bcpIconSave'></i>
					<?php echo langBcp::_("Backup");?>
				</button>
				<button class='btn btn-danger' type='reset'>
					<i class='bcpIconw bcpIconDiscard'></i>
					<?php echo langBcp::_("Reset");?>
				</button>
			</div>	
			
		</div>
		<?php echo htmlBcp::hidden('pl', array('value' => 'bcp'))?>
		<?php echo htmlBcp::hidden('mod', array('value' => 'backup'))?>
		<?php echo htmlBcp::hidden('action', array('value' => 'backupData'))?>
		<?php echo htmlBcp::hidden('reqType', array('value' => 'ajax'))?>

		<?php echo htmlBcp::formEnd();?>

	</div>	
</div>	
<script type='text/javascript'>
	var respElem = jQuery("#NewBackupResp");
	jQuery('#NewBackUpForm').submit(function(){
		jQuery(this).sendFormBcp({
			msgElID: 'NewBackupResp'
		,	onSuccess: function(res) {
				if(res.data){
					respElem.html("<a href='"+res.data.archive_path+"' target='_blank' class='backup_result_download'><?php echo langBcp::_e("Download Backup")?></a>")
				}
			}
		});
		return false;
	});
</script>	