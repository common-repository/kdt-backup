<?php
    if(!$this->fromAjax){
        ?>
<div class='bcpBackupsContainer'>
    <div class='refreshMapsList'>
        <a class='btn btn-success' id='bcpRefreshList' onclick='getBakupList()'>
            <span class=" bcpIconRefresh icon-refresh"></span>
            <?php langBcp::_e("Refresh");?>
        </a>
    </div>
	<div class='table-container'>
            <?php
    }
?>

<script type='text/javascript'>
            var existsBackupArr=JSON.parse('<?php echo utilsBcp::listToJson($this->backupList);?>');
</script> 

    <table class='bcpTable backupsTable' id='bcpBackupsListTable'>
        <thead>
        <tr>
            <th class='bcpTableThMini'>
                <?php echo langBcp::_('Id');?>
            </th>
            <th class='bcpTableThSmall'>
                <?php echo langBcp::_('Type');?>
            </th>
            <th class='bcpTableThMax'>
                <?php echo langBcp::_('Backup File');?>
            </th>
            <th class='bcpTableThLarge'>
                <?php echo langBcp::_('Create Date');?>
            </th>
            <th class='thOperations'>
                <?php echo langBcp::_('Operations');?>
            </th>
        </tr>
        </thead>
        <?php
            if(!empty($this->backupList) && is_array($this->backupList)){
                /*
                    Pass maps to js 
                */
                ?>
       
        <tbody>
               <?php
                       
                foreach($this->backupList as $backup){
					
					$type = $backup['params']['type'];
					
                    ?>
                     <tr id='backup_row_<?php echo $backup['id'];?>'>
                         <td>
                             <?php echo $backup['id'];?>
                         </td>
                         <td>
                             <?php echo $type;?>
                         </td>
                       
                         <td>
                             <a href='<?php echo $backup['archive_path'];?>' target='_blank'><?php echo $backup['archive_name'];?></a>
                         </td>
                         <td>
                             <?php  echo $backup['create_date']; ?>
                         </td>
                        
                         <td class='bcpExistsMapActions'>
                             
                             
                             <a class='bcpBackupRemoveBtn  bcpRemoveBtn btn btn-danger' id='<?php echo $backup['id'];?>' onclick='bcpRemoveBackup(<?php echo $backup['id'];?>)'>
                                  <span class=' icon-remove '></span>
                                 <?php langBcp::_e('Delete');?>
                             </a>
                             <div id='bcpRemoveElemLoader__<?php echo $backup['id'];?>'></div>
                         </td>
                     </tr>
                        
                  <?php
                }
            }
         ?> 
        </tbody>
    </table>
	
    <?php
        if(!$this->fromAjax){
            ?>
			</div>
           </div> 
           <?php
        }
    ?>

