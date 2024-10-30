<link rel='stylesheet' type='text/css' href='<?php echo BCP_CSS_PATH."bootstrap.min.css";?>' />
<link rel='stylesheet' type='text/css' href='<?php echo BCP_CSS_PATH."bcpTabsContent.css";?>' />

<?php 

     wp_enqueue_script('thickbox');
    
     wp_enqueue_script('media-models');
     
     wp_enqueue_script('media-upload');
     
     wp_enqueue_media();
     if(empty($this->defaultOpenTab)){
         $this->defaultOpenTab="bcpAddNewMap";
     }
?>
<script type='text/javascript'>
        var defaultOpenTab = "<?php echo $this->defaultOpenTab;?>";
       
</script>    

<div id="bcpAdminOptionsTabs">
    <h1 class='bcp-plugin-title'>
        <?php langBcp::_e(BCP_WP_PLUGIN_NAME)?>
    </h1>
	<ul class="nav nav-tabs bcpMainTab" >
		<?php foreach($this->tabsData as $tId => $tData) { 
			
		?>
		<li class="<?php echo $tId?> " >
                        <a href="#<?php echo $tId ?>">
                            <span class='bcpIcon bcpIcon<?php echo $tId ?>'></span>
                            <?php langBcp::_e($tData['title'])?>
                        </a>
                </li>
		<?php }?>
	</ul>

	<div class='tab_data_container'>
		<?php foreach($this->tabsData as $tId => $tData) { ?>
			<div id="<?php echo $tId?>" class="tab-pane" >
				<?php 

					echo $tData['content'];
		 ?></div>
			<?php }?>		
	</div>	

</div>

<div id="bcpAdminTemplatesSelection">
        <?php echo $this->presetTemplatesHtml;?>
</div>
