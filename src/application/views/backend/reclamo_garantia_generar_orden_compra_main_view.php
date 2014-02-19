<?php 
$sucursal_anterior = FALSE;
?>

<?php if($this->session->flashdata('ordenes_de_compra_generadas')):?>
	<div class="info_ok"><?php echo sprintf(lang('cantidad_ordenes_compra_generadas'),$this->session->flashdata('ordenes_de_compra_generadas'));?></div>
<?php endif;?>


<?php if($this->session->flashdata('error_generando_orden_compra')):?>
	<div class="info_error"><?php echo lang('error_generando_orden_compra');?></div>
<?php endif;?>




<?php if($result):?>


<div class="custom-checkbox"  style="padding:50px 0px;float:right;clear:both;">
					<input type="checkbox" class="selectall" id="all" name="all" >
					<label class="choice" for="all"><strong>Marcar / Desmarcar todos</strong> </label>
					
					
				</div>



<form method="post" action="<?php echo $this->config->item('base_url').$this->config->item('backend_root').'reclamo_garantia_generar_orden_compra_main/generar/';?>">

	<?php foreach($result as $key => $row):?>
		
		<?php if($sucursal_anterior != $row['Tsi']['sucursal_id']):
			$odd=1;
		?>
			
			<div class="noticia_titulo" style="clear:both;"><?php echo $row['Tsi']['Sucursal']['sucursal_field_desc'];?></div>
			<table id="hor-zebra" summary="<?php echo $row['Tsi']['Sucursal']['sucursal_field_desc'];?>">
				<thead>
					<tr>
						<th scope="col">ID</th>
						<th scope="col">VIN</th>
						<th scope="col">Fecha Alta</th>
						<th scope="col">Fecha Aprobación</th>
						<th scope="col">Importe Honda</th>
						<th scope="col">Importe Japón</th>
					</tr>
				</thead>
				<tbody>
				
		<?php endif;?>
		
		
		
		<?php //esto esta muy mal pero lo de abajo esta peor
				
				$valor_honda = 0;
				$valor_japon = 0;
				
				$versiones = $row['Reclamo_Garantia_Version'];
				foreach($versiones as $version)
				{
					if($version['reclamo_garantia_version_field_desc'] == 'HONDA')
					{
						$valor_honda = $version['reclamo_garantia_version_field_valor_reclamado'];
					}
					if($version['reclamo_garantia_version_field_desc'] == 'JAPON')
					{
						$valor_japon = $version['reclamo_garantia_version_field_valor_reclamado'];
					}
				}
			?>
			
			
			
		
		<tr <?php if(($odd % 2) == 1) echo 'class="odd"';?>>
			<td>
				<div class="custom-checkbox">
					<input type="checkbox" honda="<?php echo $valor_honda;?>" jp="<?php echo $valor_japon;?>" id="<?php echo $row['id'];?>" value="<?php echo $row['id'];?>" cons="<?php echo $row['Tsi']['sucursal_id'];?>" name="aprobar[]" class="cAprobar">
					<label class="choice autocheck" for="<?php echo $row['id'];?>"><strong><?php echo $row['id'];?></strong> </label>
				</div>
			</td>
			<!--input type="checkbox" honda="1191.45" jp="234.28" value="37240" class="cAprobar" id="37240" cons="127" name="aprobar[]"></td-->
			<td><?php echo $row['Tsi']['Unidad']['unidad_field_vin'];?></td>
			<td><?php echo $row['reclamo_garantia_field_fechahora_alta'];?></td>
			<td><?php echo $row['reclamo_garantia_field_fechahora_aprobacion'];?></td>
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
			
		</tr>
		
		<?php 
			$sucursal_anterior = $row['Tsi']['sucursal_id'];
			++$odd;
		
		?>
		
		<?php if(!isset($result[$key+1]) OR ( isset($result[$key+1]) && $result[$key+1]['Tsi']['sucursal_id']!= $sucursal_anterior )  ):?>
			<tr class="foot">
				<td colspan="4">Total <?php echo $row['Tsi']['Sucursal']['sucursal_field_desc'];?>:</td>
				<td>AR$ <span id="totalHonda<?php echo $sucursal_anterior;?>" class="totalH">0.00</span></td>
				<td>U$S <span id="totalJapon<?php echo $sucursal_anterior;?>" class="totalJ">0.00</span></td>
				
			</tr>
			</tbody>
			</table>
		<?php endif;?>
		
		
		
		
		
	<?php endforeach;?>
	
	
	<div class="clearfix" style="border: 1px dashed #D9221A;clear:both;margin:50px 0px;padding:10px;">
		<div class="noticia_titulo" style="clear:both;">TOTALES</div>
		
		<table id="hor-zebra" summary="TOTALES">
			<thead>
				<tr>
					<th scope="col" colspan="6">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
			<tr class="odd">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td style="color:#D9221A;"><strong>AR$ <span class="hondaTotal">0</span></strong></td>
				<td style="color:#D9221A;"><strong>U$S <span class="japonTotal">0</span></strong></td>
			</tr>
			<tr>
				<td align="right" colspan="6"><input class="btTxt submit" id="enviar" type="submit" onclick="return confirm('Seguro que desea Aprobar las garantías seleccionadas?')" value="Generar Ordenes de Compra" name="enviar"></p></td>
			</tr>
		</tbody>
		</table>
	</div>
	
	<br />
	<br />
	<br />

	</form>

<?php endif;?>



<script LANGUAGE="JavaScript"> 
	

	
	
	
	// This function formats numbers by adding commas
	function numberFormat(nStr,prefix){
    var prefix = prefix || '';
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1))
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    return prefix + x1 + x2;
}

	$(document).ready(function(){		
		
			
	
	/*--------------------[check]*/
	
	$(".selectall").change(function() {
		var select = $(this);
		if(select.is(':checked')){
			$('.autocheck').addClass('checked');
			$('input[name$="aprobar[]"]').attr('checked', true);
		}
		else
		{
			$('.autocheck').removeClass('checked');
			$('input[name$="aprobar[]"]').attr('checked', false);
		}
		
		
		$(".cAprobar").first().trigger('change');
		
		
	});
	
	

/*--------------------[check]*/
		
		
		
		
		$(".cAprobar").change(function() {
			
			$("span.totalJ").html( 0 );
			$("span.totalH").html( 0 );
			var totalHonda = 0.00;
			var totalJapon = 0.00;
			$("input[type=checkbox]").each(
			  function() {
			  
			  var input =  $(this);
			  if (isNaN($(input).attr("id"))==false){
				//alert($(input).attr("cons") );
				 totalHonda*1;
				 
				 if(input.is(':checked')){
					
				    var actual = $("span#totalHonda"+$(input).attr("cons")).html();
					var suma = (actual*1) + ($(input).attr("honda")*1);
					$("span#totalHonda"+$(input).attr("cons")).html( suma.toFixed(2)  );
					totalHonda= (totalHonda*1) + ($(input).attr("honda")*1);
					totalHonda=totalHonda.toFixed(2);
					suma=0;
					
					var actual = $("span#totalJapon"+$(input).attr("cons")).html();
					var suma = (actual*1) + ($(input).attr("jp")*1);
					$("span#totalJapon"+$(input).attr("cons")).html( suma.toFixed(2)  );
					totalJapon= (totalJapon*1) + ($(input).attr("jp")*1);
					totalJapon=totalJapon.toFixed(2);
				 }
				
			  }
			  }
			);
		
		$("span.hondaTotal").html( numberFormat(totalHonda)  );
		$("span.japonTotal").html( numberFormat(totalJapon)  );
		});
		
	});
	

	
	

</script>


