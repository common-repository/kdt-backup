<form id="bcpAdminAccessFormUser">
<table>
	<tr>
		<td width="117"><?php langBcp::_e('Users')?>:</td>
		<td>
			<?php echo htmlBcp::selectlist('selectlistBcpUser', array('attrs'=>'style="width:340px;"','options' => $this->arrUser))?>
            <div align="left" class="accessDelElement"><a id="delUserBcp" href="javascript: void(0)"><?php langBcp::_e('remove User')?></a></div>
        </td>
	</tr>
	<tr>
		<td></td>
		<td>
                <?php echo htmlBcp::selectbox( 'userBcp', array('attrs' => '', 'options' => $this->selectUser) ); ?>
        </td>
	</tr>
	<tr>
		<td></td>
		<td>
			<?php echo htmlBcp::hidden('reqType', array('value' => 'ajax'))?>
			<?php echo htmlBcp::hidden('page', array('value' => 'access'))?> 
			<?php echo htmlBcp::hidden('action', array('value' => 'saveUser'))?>
			<?php echo htmlBcp::submit('submitUser', array('value' => langBcp::_('add User'), 'attrs' => 'class="button button-primary button-large"'))?>            
        </td>
	</tr>
</form>
</table>
