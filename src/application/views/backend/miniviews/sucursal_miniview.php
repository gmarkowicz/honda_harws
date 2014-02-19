<?php
	if(isset($SUCURSAL))
	{
		$sucursal = $SUCURSAL;
		
	?>
		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('sucursal_id');?></legend>
			<li>
				<table cellspacing="0" class="tabla_opciones" width="100%">
						
						<tbody>
							<tr>
								<td><strong><?=$this->marvin->mysql_field_to_human('id');?></strong></td>
								<td><span><?php echo $sucursal['id'];?></span></td>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('sucursal_field_desc');?></strong></td>
								<td><span><?php echo $sucursal['sucursal_field_desc'];?></span></td>
							</tr>
							
						</tbody>
				</table>
			</li>
		</fieldset>
<?
}
?>