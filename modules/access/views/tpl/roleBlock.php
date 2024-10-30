<form id="bcpAdminAccessFormRole">
<table>
  <tr>
    <td>Only users at or above this level will be able to log in:</td>
    <td>
    	<?php $selected = frameBcp::_()->getTable('access')->get('access', array('type_access' => 3)); ?>
		<?php echo htmlBcp::selectbox( 'roleBcp', array('attrs' => 'style="float:left; width:120px; margin-right:8px;"',
														'options' => $this->selectRole,
														'value'=> $selected[0]['access']) ); ?>
        <?php echo htmlBcp::hidden('reqType', array('value' => 'ajax'))?>
		<?php echo htmlBcp::hidden('page', array('value' => 'access'))?>
		<?php echo htmlBcp::hidden('action', array('value' => 'saveRole'))?>
        <?php echo htmlBcp::submit('submitRole', array('value' => langBcp::_('Save'), 'attrs' => 'class="button button-primary button-large" style="float:right;"'))?>        
    </td>
  </tr>
</table>
</form>