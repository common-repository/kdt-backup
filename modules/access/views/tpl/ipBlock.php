<form id="bcpAdminAccessFormIp">
<table>
	<tr>
		<td width="117"><?php langBcp::_e('IP Address')?>:</td>
		<td>
			<?php echo htmlBcp::selectlist('selectlistBcpIp', array('attrs'=>'style="width:340px;"','options' => $this->arrIp))?>
            <div align="left" class="accessDelElement"><a id="delIpBcp" href="javascript: void(0)"><?php langBcp::_e('remove IP Address')?></a></div>
        </td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo htmlBcp::text('ipAddressBcp', array('value' => ''))?></td>
	</tr>
	<tr>
		<td></td>
		<td>
			<?php echo htmlBcp::hidden('reqType', array('value' => 'ajax'))?>
			<?php echo htmlBcp::hidden('page', array('value' => 'access'))?> <!--page = для адинки | mod = для сайт-->
			<?php echo htmlBcp::hidden('action', array('value' => 'saveIp'))?> <!--метод-->
			<?php echo htmlBcp::submit('submitIp', array('value' => langBcp::_('add Ip address'), 'attrs' => 'class="button button-primary button-large"'))?>            
        </td>
	</tr>
</table>
</form>
