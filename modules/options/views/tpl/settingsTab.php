<div class='clearfix'></div>
<div class='bcpPluginSettingsFormContainer'>
    <h2><?php langBcp::_e("Plugin Settings");?></h2>
    <form id='bcpPluginSettingsForm'>

              <div class='bcpFormRow'>
                   <?php
                      echo htmlBcp::checkboxHiddenVal("send_statistic",
                            array("attrs"=>" class='statistic' ",
                                'checked'=>((bool)$this->saveStatistic)?"checked":""))    
                   ?>
                   <label for="bcpNewMap_title" class="bcpFormLabel">
                         <?php langBcp::_e('Send anonym statistic?')?>
                   </label>
                </div>  
       <div class='controls'>
           <?php
                echo htmlBcp::hidden("mod",array("value"=>"options"));
                echo htmlBcp::hidden("action",array("value"=>"updateStatisticStatus"));
                echo htmlBcp::hidden("reqType",array("value"=>"ajax"));
           ?>
           <div id='bcpPluginOptsMsg'></div>
           
           <input type='submit' class='btn btn-success'  value='<?php langBcp::_e("Save")?>' />
       </div>   
    </form>
</div>    
<script type='text/javascript'>
        jQuery(document).ready(function(){
            jQuery("#bcpPluginSettingsForm").submit(function(){
		jQuery("#bcpPluginSettingsForm").sendFormBcp({
			msgElID: 'bcpPluginOptsMsg'
		,	onSuccess: function(res) {
                                
                                return false;
			}
		});
                 return false;
            })
           
        })
</script>        