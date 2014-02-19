
<style>
	.tr_seleccionado{
		background-color:#C7C7C9 !important;
		
	}
	.tr_seleccionado td,.tr_seleccionado label{
		color:#000 !important;
		
	}
	.aprobar_reclamo{
		background-color:transparent !important;
	}
	.rechazar_reclamo{
		background-color:transparent !important;
	}
</style>




<?php if($this->session->flashdata('reclamos_aprobados')):?>
	<div class="mensaje_sistema">
		<div class="info_ok"> <?php echo sprintf(lang('reclamos_auto_aprobados'), $this->session->flashdata('reclamos_aprobados'));?>
		</div>
	</div>
<?php endif;?>



<?php 

	$cantidad_sin_problemas = count($sin_problemas);
	if($cantidad_sin_problemas >0 ) :?>

	<div class="noticia_titulo" style="clear:both;margin-top:70px;"><?php echo lang('aprobado_automatico');?></div>
	<fieldset>
	<form name="form" id="form" method="post" action="<?php echo $this->config->item('base_url').$this->config->item('backend_root').'reclamo_garantia_aprobar_main/auto_aprueba/';?>">
	<ul class="form" style="padding:10px;">
				<li class="full">
					<div><?php echo sprintf(lang('garantias_sin_problemas'), $cantidad_sin_problemas, number_format($this->maximo_importe_auto, 2, '.', ''));?></div>
					<p style="padding:20px;"><input type="submit" name="AprobarAuto" value="Aprobar" onclick="return confirm('<?php echo lang('confirmar_aprobado_automatico');?>')"></p>
				</li>
			</ul>
	</form>
	</fieldset>




<?php endif;?>











<div class="noticia_titulo" style="clear:both;margin-top:70px;"><?php echo lang('reclamos_pre_aprobados');?></div>



			<table id="hor-zebra" >
				<thead>
					<tr>
						<th scope="col"><?php echo lang('id');?></th>
						<th scope="col"><?php echo lang('vin');?></th>
						<th scope="col"><?php echo lang('sucursal_id');?></th>
						<th scope="col"><?php echo lang('fechahora_alta');?></th>
						<th scope="col"><?php echo lang('importe_honda');?></th>
						<th scope="col"><?php echo lang('importe_japon');?></th>
						<th scope="col"></th>
						
					</tr>
				</thead>
				<tbody>
				<?php if($result):
					$odd=1;
				?>

			<?php foreach($result as $key => $row):?>
			
				<?php $versiones = $row['Reclamo_Garantia_Version'];?>
				
				<tr class="bloque_<?php echo $row['id'];?><?php if(($odd % 2) == 1) echo ' odd ';?>" <?php if(!isset($sin_problemas[$row['id']])) echo ' style="border: 1px	solid #D87800;" title="problemas detectados"';?> >
					<td>
						<a href="<?php echo $this->config->item('base_url').$this->config->item('backend_root').'reclamo_garantia_abm/edit/'.$row['id'];?>/HONDA" target="reclamo_garantia_abm"><?php echo $row['id'];?></a>
					</td>
					<!--input type="checkbox" honda="1191.45" jp="234.28" value="37240" class="cAprobar" id="37240" cons="127" name="aprobar[]"></td-->
					<td><?php echo $row['Tsi']['Unidad']['unidad_field_vin'];?></td>
					<td><?php echo $row['Tsi']['Sucursal']['sucursal_field_desc'];?></td>
					<td><?php echo $row['reclamo_garantia_field_fechahora_alta'];?></td>
					
					<td>
					<?php //esto esta muy mal

						foreach($versiones as $version)
						{
							if($version['reclamo_garantia_version_field_desc'] == 'HONDA')
							{
								$valor_honda = $version['reclamo_garantia_version_field_valor_reclamado'];
								echo 'AR$ ' . $valor_honda;
							}
						}
					?>
					</td>
					<td>
					<?php //esto esta muy mal

						foreach($versiones as $version)
						{
							if($version['reclamo_garantia_version_field_desc'] == 'JAPON')
							{
								$valor_japon = $version['reclamo_garantia_version_field_valor_reclamado'];
								echo 'U$S ' . $version['reclamo_garantia_version_field_valor_reclamado'];
							}
						}
					?>
					
					</td>
					<td><a href="#" class="aprobar_reclamo positive" id="<?php echo $row['id'];?>"><?php echo lang('aprobar');?></a></td>
					<td><a href="<?php echo $this->config->item('base_url').$this->config->item('backend_root').'reclamo_garantia_aprobar_main/reject/'.$row['id'];?>" class="rechazar_reclamo eliminar_bloque"><?php echo lang('rechazar');?></a></td>
					
				</tr>
				
				<tr class="hide dinamico bloque_<?php echo $row['id'];?> aprobar<?php if(($odd % 2) == 1) echo ' odd';?>" id="tr_<?php echo $row['id'];?>">
					<td colspan="8">
					<form name="form" id="form" method="post" action="<?php echo $this->config->item('base_url').$this->config->item('backend_root').'reclamo_garantia_aprobar_main/aprueba/'.$row['id'];?>">
					
							<label for="comentarios" class="desc"><?php echo lang('comentarios');?>:</label>
							<div><textarea name="comentarios" style="width:90%; background-color:#eee;" class="field"></textarea>
							</div>
							<p><input type="submit" value="Aprobar" name="_submit"></p>
						
					</form>
					
					</td>
				</tr>
				
				<?php 
					
					++$odd;
				
				?>
				
				
				
				
				
				
				
			<?php endforeach;?>
	<?php endif;?>
	</tbody>
			</table>
	


<br />
<br />
<br />


<script LANGUAGE="JavaScript"> 
$(document).ready(function(){
	$('.aprobar_reclamo').click(function(e) {
		e.preventDefault();
		$(".dinamico").hide();
		$("tr").removeClass('tr_seleccionado');
		$("#tr_"+$(this).attr("id")).show();
		$(".bloque_"+$(this).attr("id")).addClass('tr_seleccionado');
		
	});
	
});

</script>










