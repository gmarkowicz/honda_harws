<style>
	legend{text-transform: uppercase;}
	.reporte fieldset{background-color:#fff;background-image:none;}
	.reporte table tr, .reporte table td{border-bottom:1px solid #F3F3F3;}
</style>
<?php
function genera_estrellas($numero)
	{
	$info=explode("_",$numero);
	
	//$val=$info[0];
	$val=number_format($info[0], 2, '.', '');
	$total=$info[1];
	$aux="";
	if($val==0){
		for($i=0;$i<$total;$i++){
			$aux.='<div class="estrella_off"></div>'."\n";
		}
	}else{
		for($i=0;$i<$total;$i++){
			//echo $val."-".$i."<br />";
			if($val>$i && $val<($i+1)){
				$aux.='<div class="estrella_media"></div>'."\n";
				//echo 'if($val>$i && $val<($i+1)){'."<br />";
			}else if($val===$i){
				$aux.='<div class="estrella_on"></div>'."\n";
				//echo 'if($val===$i){'."<br />";
				
			}else if($val>$i){
				$aux.='<div class="estrella_on"></div>'."\n";
				//echo 'if($val>$i){'."<br />";
			}else{
				$aux.='<div class="estrella_off"></div>'."\n";
				//echo 'else'."<br />";
			}
		}
	}
	return $aux;
	}
?>

<script type="text/javascript">
	$(document).ready(function() {
		$("#nuevoregistro").hide();
	});
</script>
	<div id="tabs">
		<ul>
			<li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
			<li class="boton-tab"><a href="#tabs-2" id="reporte"><?=lang('reporte');?></a></li>
		</ul>
		<div id="tabs-1" class="reporte">
			
			
			
			<?php
				//$this->load->view( 'backend/esqueleto_botones_view' );
			?>
			
				<?php if(isset($sin_resultados)):?>
					<p><?php echo lang('sin_resultados');?></p>
				<?php endif;?>
				
				<?php if(isset($stat_filtro['total'])):?>
				
					<div class="botones_registros">
						<p><a id="versionimprenta" href="#" onclick="javascript:myPrint();"><?=lang('imprimir');?></a></p>
					</div>
					
					
					<fieldset>
					<ul>
						<li class="unitx2 f-left">
							<?php if($this->input->post('tsi_encuesta_satisfaccion_field_fechahora_alta_inicial')):?>
								
								<label class="unitx2 first">
									<?php echo $this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_fechahora_alta_inicial');?>
								</label><br />
								<strong><?php echo $this->marvin->mysql_date_to_form($this->input->post('tsi_encuesta_satisfaccion_field_fechahora_alta_inicial'));?>
								</strong>
								
							<?php endif;?>
						</li>
						<li class="unitx2 f-left">
							<?php if($this->input->post('tsi_encuesta_satisfaccion_field_fechahora_alta_final')):?>
								
								<label class="unitx2 first">
									<?php echo $this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_fechahora_alta_final');?>
								</label><br />
								<strong><?php echo $this->marvin->mysql_date_to_form($this->input->post('tsi_encuesta_satisfaccion_field_fechahora_alta_final'));?>
								</strong>
								
							<?php endif;?>
						</li>
						<li class="unitx2 f-left">
							<?php if($this->input->post('tsi_field_fecha_de_egreso_inicial')):?>
								
								<label class="unitx2 first">
									<?php echo $this->marvin->mysql_field_to_human('tsi_field_fecha_de_egreso_inicial');?>
								</label><br />
								<strong><?php echo $this->marvin->mysql_date_to_form($this->input->post('tsi_field_fecha_de_egreso_inicial'));?>
								</strong>
								
							<?php endif;?>
						</li>
						<li class="unitx2 f-left">
							<?php if($this->input->post('tsi_field_fecha_de_egreso_final')):?>
								
								<label class="unitx2 first">
									<?php echo $this->marvin->mysql_field_to_human('tsi_field_fecha_de_egreso_final');?>
								</label><br />
								<strong><?php echo $this->marvin->mysql_date_to_form($this->input->post('tsi_field_fecha_de_egreso_final'));?>
								</strong>
								
							<?php endif;?>
						</li>
					</ul>
					<?php if(is_array($this->input->post('sucursal_id')) && count($this->input->post('sucursal_id'))>0):?>
					<li class="unitx8 both">
						<?php echo lang('sucursal_id');?>: 
						<strong>
						<?php foreach($this->input->post('sucursal_id') as $s):?>
							<?php echo $sucursal_id[$s];?> | 
						<?php endforeach;?>
						</strong>
					</li>
					<?php endif;?>
					
					</fieldset>
					
					<div class="bloque" style="padding-bottom:5px;margin-bottom:10px;text-align:right;">
					<strong><?php echo $stat_filtro['total'];?> <?php echo lang('registros_encontrados');?>.</strong>
					
					</div>
					
					
					
					
					
					<div class="noprint">
						<fieldset>
							<legend><?=$this->marvin->mysql_field_to_human('haciendo_una_cita');?></legend>
							<table border="0" width="100%" id="hor-zebra">
								<thead>
									<th class="odd" scope="col" colspan="3"><?php echo lang('reporte_encuesta_tsi_pregunta_1');?></th>
								</thead>
								<tbody>
									<tr>
										<td width="50%"><?php echo lang('si');?>:</td>
										<td width="50%" class="tright" colspan="2"><?php echo $stat_filtro['pregunta_1']['si'];?> %</td>
									</tr>
									<tr class="odd">
										<td width="50%"><?php echo lang('no');?>:</td>
										<td width="50%" class="tright" colspan="2"><?php echo $stat_filtro['pregunta_1']['no'];?> %</td>
									</tr>
									<tr>
										<td width="50%"><?php echo lang('ns_nc');?>:</td>
										<td width="50%" class="tright" colspan="2"><?php echo $stat_filtro['pregunta_1']['nsnc'];?> %</td>
									</tr>
									<tr class="odd">
										<td width="36%"><?php echo lang('reporte_encuesta_tsi_pregunta_1a');?>:</td>
										<td><?php echo $stat_filtro['pregunta_1a'];?> %</td>
										<td width="14%" style="text-align:right;">
											<div class="right_star_legend">
											<?php 
												$estrellas = 5;
												echo genera_estrellas(($stat_filtro['pregunta_1a']*$estrellas)/100 .'_' . $estrellas);
											?>								
											</div>		
										</td>
									</tr>
								</tbody>
							</table>
						</fieldset>
					</div>
				
				<div class="noprint">
					<fieldset>
					<legend><?=$this->marvin->mysql_field_to_human('llevando_honda_servicio');?></legend>		
						
						<table border="0" width="100%" id="hor-zebra">
							<tbody>
								<tr class="odd">
									<td width="50%"><?php echo lang('reporte_encuesta_tsi_pregunta_2a');?>:</td>
									<td width="36%"><?php echo $stat_filtro['pregunta_2a'];?>%</td>
									<td width="14%">
										<div class="right_star_legend">
											<?php 
												$estrellas = 5;
												echo genera_estrellas(($stat_filtro['pregunta_2a']*$estrellas)/100 .'_' . $estrellas);
											?>				
										</div>	
									</td>
								</tr>
								
								<tr>
									<td width="50%"><?php echo lang('reporte_encuesta_tsi_pregunta_2b');?>:</td>
									<td width="36%"><?php echo $stat_filtro['pregunta_2b'];?>%</td>
									<td width="14%">
										<div class="right_star_legend">
											<?php 
												$estrellas = 5;
												echo genera_estrellas(($stat_filtro['pregunta_2b']*$estrellas)/100 .'_' . $estrellas);
											?>		
										</div>		
									</td>
								</tr>
								
								<tr class="odd">
									<td width="50%"><?php echo lang('reporte_encuesta_tsi_pregunta_2c');?>:</td>
									<td width="36%"><?php echo $stat_filtro['pregunta_2c'];?>%</td>
									<td width="14%">
										<div class="right_star_legend">
											<?php 
												$estrellas = 5;
												echo genera_estrellas(($stat_filtro['pregunta_2c']*$estrellas)/100 .'_' . $estrellas);
											?>		
										</div>		
									</td>
								</tr>
								
								<tr>
									<td width="50%"><?php echo lang('reporte_encuesta_tsi_pregunta_2d');?>:</td>
									<td width="36%"><?php echo $stat_filtro['pregunta_2d'];?>%</td>
									<td width="14%">
										<div class="right_star_legend">
											<?php 
												$estrellas = 5;
												echo genera_estrellas(($stat_filtro['pregunta_2d']*$estrellas)/100 .'_' . $estrellas);
											?>			
										</div>	
									</td>
								</tr>
								
								<tr class="odd">
									<td width="50%"><?php echo lang('reporte_encuesta_tsi_pregunta_2e');?>:</td>
									<td width="36%"><?php echo $stat_filtro['pregunta_2e'];?>%</td>
									<td width="14%">
										<div class="right_star_legend">
											<?php 
												$estrellas = 5;
												echo genera_estrellas(($stat_filtro['pregunta_2e']*$estrellas)/100 .'_' . $estrellas);
											?>		
										</div>		
									</td>
								</tr>
								
								<tr>
									<td width="50%"><?php echo lang('reporte_encuesta_tsi_pregunta_2f');?>:</td>
									<td width="36%"><?php echo $stat_filtro['pregunta_2f'];?>%</td>
									<td width="14%">
										<div class="right_star_legend">
										<?php 
											$estrellas = 5;
											echo genera_estrellas(($stat_filtro['pregunta_2f']*$estrellas)/100 .'_' . $estrellas);
										?>		
										</div>
									</td>
								</tr>
								
							</tbody>
						</table>
					</fieldset>
				</div>
				
		
				<div class="noprint">
					<fieldset>
					<legend><?=$this->marvin->mysql_field_to_human('durante_el_servicio_reparacion');?></legend>
					
					
						<table border="0" width="100%" id="hor-zebra">
							<tbody>
								<tr class="odd">
									<td width="50%"><?php echo lang('reporte_encuesta_tsi_pregunta_3a');?>:</td>
									<td width="36%"><?php echo $stat_filtro['pregunta_3a'];?>%</td>
									<td width="14%">
										<div class="right_star_legend">
											<?php 
												$estrellas = 5;
												echo genera_estrellas(($stat_filtro['pregunta_3a']*$estrellas)/100 .'_' . $estrellas);
											?>				
										</div>		
									</td>
								</tr>
								
								<tr>
									<td width="50%"><?php echo lang('reporte_encuesta_tsi_pregunta_3b');?>:</td>
									<td width="36%"><?php echo $stat_filtro['pregunta_3b'];?>%</td>
									<td width="14%">
										<div class="right_star_legend">
											<?php 
												$estrellas = 5;
												echo genera_estrellas(($stat_filtro['pregunta_3b']*$estrellas)/100 .'_' . $estrellas);
											?>		
										</div>		
									</td>
								</tr>
								
								<tr class="odd">
									<td width="50%"><?php echo lang('reporte_encuesta_tsi_pregunta_3c');?>:</td>
									<td width="36%"><?php echo $stat_filtro['pregunta_3c'];?>%</td>
									<td width="14%">
										<div class="right_star_legend">
											<?php 
												$estrellas = 5;
												echo genera_estrellas(($stat_filtro['pregunta_3c']*$estrellas)/100 .'_' . $estrellas);
											?>				
										</div>		
									</td>
								</tr>
							</tbody>
						</table>
				</fieldset>
			</div>
			
			<div class="noprint">
				<fieldset>
				<legend><?=$this->marvin->mysql_field_to_human('recogiendo_su_honda');?></legend>

					<table border="0" width="100%" id="hor-zebra">
						<tbody>
							<tr class="odd">
								<td width="50%"><?php echo lang('reporte_encuesta_tsi_pregunta_4a');?>:</td>
								<td width="36%"><?php echo $stat_filtro['pregunta_4a'];?>%</td>
								<td width="14%">
									<div class="right_star_legend">
										<?php 
											$estrellas = 5;
											echo genera_estrellas(($stat_filtro['pregunta_4a']*$estrellas)/100 .'_' . $estrellas);
										?>					
									</div>		
								</td>
							</tr>
							
							<tr>
								<td width="50%"><?php echo lang('reporte_encuesta_tsi_pregunta_4b');?>:</td>
								<td width="36%"><?php echo $stat_filtro['pregunta_4b'];?>%</td>
								<td width="14%">
									<div class="right_star_legend">
										<?php 
											$estrellas = 5;
											echo genera_estrellas(($stat_filtro['pregunta_4b']*$estrellas)/100 .'_' . $estrellas);
										?>			
									</div>		
									
								</td>
							</tr>
							
							<tr class="odd">
								<td width="50%"><?php echo lang('reporte_encuesta_tsi_pregunta_4c');?>:</td>
								<td width="36%"><?php echo $stat_filtro['pregunta_4c'];?>%</td>
								<td width="14%">
									<div class="right_star_legend">
										<?php 
											$estrellas = 5;
											echo genera_estrellas(($stat_filtro['pregunta_4c']*$estrellas)/100 .'_' . $estrellas);
										?>				
									</div>		
								</td>
							</tr>
							
							<tr>
								<td width="50%"><?php echo lang('reporte_encuesta_tsi_pregunta_4d');?>: </td>
								<td width="36%"><?php echo $stat_filtro['pregunta_4d'];?>%</td>
								<td width="14%">
									<div class="right_star_legend">
										<?php 
											$estrellas = 5;
											echo genera_estrellas(($stat_filtro['pregunta_4d']*$estrellas)/100 .'_' . $estrellas);
										?>			
									</div>		
								</td>
							</tr>
							<tr class="odd">
								<td width="50%"><?php echo lang('reporte_encuesta_tsi_pregunta_4e');?>:</td>
								<td width="36%"><?php echo $stat_filtro['pregunta_4e'];?>%</td>
								<td width="14%">
									<div class="right_star_legend">
										<?php 
											$estrellas = 5;
											echo genera_estrellas(($stat_filtro['pregunta_4e']*$estrellas)/100 .'_' . $estrellas);
										?>			
									</div>	
								</td>
							</tr>
							
						
						</tbody>
					</table>
				</fieldset>
			</div>
	
			
			<div class="noprint">
			<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('llevando_honda_a_casa');?></legend>
				<table border="0" width="100%" id="hor-zebra">
					<tbody>
						<tr class="odd">
							<td width="50%" colspan="2"><?php echo lang('reporte_encuesta_tsi_pregunta_5');?>:</td>
							<td width="36%"><?php echo $stat_filtro['pregunta_5'];?>%</td>
							<td width="14%">
								<div class="right_star_legend">
									<?php 
										$estrellas = 5;
										echo genera_estrellas(($stat_filtro['pregunta_5']*$estrellas)/100 .'_' . $estrellas);
									?>		
								</div>		
							</td>
						</tr>
						<tr>
							<td width="50%" colspan="2"><?php echo lang('reporte_encuesta_tsi_pregunta_6');?></td>
							<td width="36%"></td>
							<td width="14%"></td>
						</tr>
						<tr class="odd">
							<td width="10%"></td>
							<td width="40%"><?php echo lang('si');?>:</td>
							<td width="36%"><?php echo $stat_filtro['pregunta_6']['si'];?>%</td>
							<td width="14%"></td>
						</tr>
						<tr>
							<td width="10%"></td>
							<td width="40%"><?php echo lang('no');?>:</td>
							<td width="36%"><?php echo $stat_filtro['pregunta_6']['no'];?> %</td>
							<td width="14%"></td>
						</tr>
						<tr class="odd">
							<td width="10%"></td>
							<td width="40%"><?php echo lang('ns_nc');?>:</td>
							<td width="36%"><?php echo $stat_filtro['pregunta_6']['nsnc'];?> %</td>
							<td width="14%"></td>
						</tr>
						<tr>
							<td width="50%" colspan="2"><?php echo lang('visitas_adicionales_requeridas');?>:</td>
							<td width="36%"></td>
							<td width="14%"></td>
						</tr>
						<tr class="odd">
							<td width="10%"></td>
							<td width="40%"><?php echo lang('una');?> (1):</td>
							<td width="36%"><?php echo $stat_filtro['pregunta_6a']['una'];?> %</td>
							<td width="14%"></td>
						</tr>
						<tr>
							<td width="10%"></td>
							<td width="40%"><?php echo lang('dos');?> (2):</td>
							<td width="36%"><?php echo $stat_filtro['pregunta_6a']['dos'];?> %</td>
							<td width="14%"></td>
						</tr>
						<tr class="odd">
							<td width="10%"></td>
							<td width="40%"><?php echo lang('tres');?> (3):</td>
							<td width="36%"><?php echo $stat_filtro['pregunta_6a']['tres'];?> %</td>
							<td width="14%"></td>
						</tr>
						<tr>
							<td width="10%"></td>
							<td width="40%"><?php echo lang('cuatro');?> (4):</td>
							<td width="36%"><?php echo $stat_filtro['pregunta_6a']['cuatro'];?> %</td>
							<td width="14%"></td>
						</tr>
						<tr class="odd">
							<td width="10%"></td>
							<td width="40%"><?php echo lang('cinco');?> (5):</td>
							<td width="36%"><?php echo $stat_filtro['pregunta_6a']['cinco'];?> %</td>
							<td width="14%"></td>
						</tr>
						<tr>
							<td width="10%"></td>
							<td width="40%"><?php echo lang('seis_o_mas');?>:</td>
							<td width="36%"><?php echo $stat_filtro['pregunta_6a']['seis'];?> %</td>
							<td width="14%"></td>
						</tr>
						<tr class="odd">
							<td width="10%"></td>
							<td width="40%"><?php echo lang('ns_nc');?>:</td>
							<td width="36%"><?php echo $stat_filtro['pregunta_6a']['nsnc'];?> %</td>
							<td width="14%"></td>
						</tr>
						<tr>
							<td colspan="4"><strong><?php echo lang('razones_repeticion_servicio');?>:</strong></td>
						</tr>
						<tr class="odd">
							<td width="10%"></td>
							<td width="40%"><?php echo lang('reporte_encuesta_tsi_pregunta_6b_1');?>:</td>
							<td width="36%"><?php echo $stat_filtro['pregunta_6b']['uno'];?> %</td>
							<td width="14%"></td>
						</tr>
						<tr>
							<td width="10%"></td>
							<td width="40%"><?php echo lang('reporte_encuesta_tsi_pregunta_6b_2');?>:</td>
							<td width="36%"><?php echo $stat_filtro['pregunta_6b']['dos'];?> %</td>
							<td width="14%"></td>
						</tr>
						<tr class="odd">
							<td width="10%"></td>
							<td width="40%"><?php echo lang('reporte_encuesta_tsi_pregunta_6b_3');?>.</td>
							<td width="36%"><?php echo $stat_filtro['pregunta_6b']['tres'];?> %</td>
							<td width="14%"></td>
						</tr>
						<tr>
							<td width="10%"></td>
							<td width="40%"><?php echo lang('reporte_encuesta_tsi_pregunta_6b_4');?></td>
							<td width="36%"><?php echo $stat_filtro['pregunta_6b']['cuatro'];?> %</td>
							<td width="14%"></td>
						</tr>
						<tr class="odd">
							<td width="10%"></td>
							<td width="40%"><?php echo lang('ns_nc');?>:</td>
							<td width="36%"><?php echo $stat_filtro['pregunta_6b']['nsnc'];?> %</td>
							<td width="14%"></td>
						</tr>
					</tbody>
			</table>
		</fieldset>
	</div>
	
	<div class="noprint">
	<fieldset>
		<legend><?=$this->marvin->mysql_field_to_human('sumario');?></legend>		
		<table border="0" width="100%" id="hor-zebra">
			<tbody>
				<tr class="odd">
					<td width="50%"><?php echo lang('reporte_encuesta_tsi_pregunta_7a');?>:</td>
					<td width="36%"> <?php echo $stat_filtro['pregunta_7a'];?>%</td>
					<td width="14%">
						<div class="right_star_legend">
							<?php 
								$estrellas = 5;
								echo genera_estrellas(($stat_filtro['pregunta_7a']*$estrellas)/100 .'_' . $estrellas);
							?>						
						</div>		
					</td>
				</tr>
				<tr>
					<td width="50%"><?php echo lang('reporte_encuesta_tsi_pregunta_7b');?>:</td>
					<td width="36%"><?php echo $stat_filtro['pregunta_7b'];?>%</td>
					<td width="14%">
						<div class="right_star_legend">
							<?php 
								$estrellas = 5;
								echo genera_estrellas(($stat_filtro['pregunta_7b']*$estrellas)/100 .'_' . $estrellas);
							?>			
						</div>		
					</td>
				</tr>
				<tr class="odd">
					<td width="50%"><?php echo lang('reporte_encuesta_tsi_pregunta_7c');?>:</td>
					<td width="36%"><?php echo $stat_filtro['pregunta_7c'];?>%</td>
					<td width="14%">
						<div class="right_star_legend">
							<?php 
								$estrellas = 5;
								echo genera_estrellas(($stat_filtro['pregunta_7c']*$estrellas)/100 .'_' . $estrellas);
							?>	
						</div>		
					</td>
				</tr>
				
				<tr>
					<td width="50%"><?php echo lang('reporte_encuesta_tsi_pregunta_8');?>:</td>
					<td width="36%"><?php echo $stat_filtro['pregunta_8'];?>%</td>
					<td width="14%">
						<div class="right_star_legend">
							<?php 
								$estrellas = 4;
								echo genera_estrellas(($stat_filtro['pregunta_8']*$estrellas)/100 .'_' . $estrellas);
							?>				
						</div>	
					</td>
				</tr>
				<tr class="odd">
					<td width="50%"><?php echo lang('reporte_encuesta_tsi_pregunta_9');?>: </td>
					<td width="36%"><?php echo $stat_filtro['pregunta_9'];?>%</td>
					<td width="14%">
						<div class="right_star_legend">
							<?php 
								$estrellas = 4;
								echo genera_estrellas(($stat_filtro['pregunta_9']*$estrellas)/100 .'_' . $estrellas);
							?>			
						</div>		
					</td>
				</tr>
			
			</tbody>
		</table>
	</fieldset>
	</div>
	
	
	<!-- DIV style="page-break-after:always"></DIV -->
	

		<fieldset>
			<legend><?php echo lang('indice_capacidad');?></legend>
				<div class="gradata">
					<table border="0" width="100%" id="hor-zebra">
						<thead>
							<tr>
								<th scope="col" width="70%">&nbsp;</th>
								<th scope="col" width="15%" class="tright"><strong><?php echo lang('sucursal_id');?></strong></th>
								<th scope="col" width="15%" class="tright"><strong><?php echo lang('distribuidor');?></strong></th>
							</tr>
						</thead>
						<tbody>
							<tr class="odd">
								<td><strong><?php echo lang('indice_capacidad');?></strong></td>
								<td	class="tright"><strong><?php echo $stat_filtro['indice_capacidad'];?>%</strong></td>
								<td class="tright"><strong><?php echo $stat_distribuidor['indice_capacidad'];?>%</strong></td>
							</tr>
							
							<tr>
								<td width="70%">1) <?php echo lang('reporte_encuesta_tsi_pregunta_1_p');?></td>
								<td width="15%" class="tright"><?php echo $stat_filtro['pregunta_1']['si'];?>%</td>
								<td width="15%" class="tright"><?php echo $stat_distribuidor['pregunta_1']['si'];?>%</td>
							</tr>
							<tr class="odd">
								<td width="70%">1a) <?php echo lang('reporte_encuesta_tsi_pregunta_1a_p');?></td>
								<td width="15%" class="tright"><?php echo $stat_filtro['pregunta_1a'];?>%</td>
								<td width="15%" class="tright"><?php echo $stat_distribuidor['pregunta_1a'];?>%</td>
							</tr>
							<tr>
								<td width="70%">2a) <?php echo lang('reporte_encuesta_tsi_pregunta_2a_p');?></td>
								<td width="15%" class="tright"><?php echo $stat_filtro['pregunta_2a'];?>%</td>
								<td width="15%" class="tright"><?php echo $stat_distribuidor['pregunta_2a'];?>%</td>
							</tr>
							<tr class="odd">
								<td width="70%">3a) <?php echo lang('reporte_encuesta_tsi_pregunta_3a_p');?></td>
								<td width="15%" class="tright"><?php echo $stat_filtro['pregunta_3a'];?>%</td>
								<td width="15%" class="tright"><?php echo $stat_distribuidor['pregunta_3a'];?>%</td>
							</tr>
							<tr>
								<td width="70%">3b) <?php echo lang('reporte_encuesta_tsi_pregunta_3b');?></td>
								<td width="15%" class="tright"><?php echo $stat_filtro['pregunta_3b'];?>%</td>
								<td width="15%" class="tright"><?php echo $stat_distribuidor['pregunta_3b'];?>%</td>
							</tr>
							<tr class="odd">
								<td width="70%">3c) <?php echo lang('reporte_encuesta_tsi_pregunta_3c');?></td>
								<td width="15%" class="tright"><?php echo $stat_filtro['pregunta_3c'];?>%</td>
								<td width="15%" class="tright"><?php echo $stat_distribuidor['pregunta_3c'];?>%</td>
							</tr>
							<tr>
								<td width="70%">4a) <?php echo lang('reporte_encuesta_tsi_pregunta_4a_p');?></td>
								<td width="15%" class="tright"><?php echo $stat_filtro['pregunta_4a'];?>%</td>
								<td width="15%" class="tright"><?php echo $stat_distribuidor['pregunta_4a'];?>%</td>
							</tr>
							<tr class="odd">
								<td width="70%">4b) <?php echo lang('reporte_encuesta_tsi_pregunta_4b_p');?></td>
								<td width="15%" class="tright"><?php echo $stat_filtro['pregunta_4b'];?>%</td>
								<td width="15%" class="tright"><?php echo $stat_distribuidor['pregunta_4b'];?>%</td>
							</tr>
							<tr>
								<td width="70%">4e) <?php echo lang('reporte_encuesta_tsi_pregunta_4e_p');?></td>
								<td width="15%" class="tright"><?php echo $stat_filtro['pregunta_4e'];?>%</td>
								<td width="15%" class="tright"><?php echo $stat_distribuidor['pregunta_4e'];?>%</td>
							</tr>
						</tbody>
					</table>
				</div>
			</fieldset>

			<fieldset>
				<legend><?php echo lang('indice_interpersonal');?></legend>
				<div class="gradata">
					<table border="0" width="100%" id="hor-zebra">
						<thead>
							<tr>
								<th scope="col" width="70%">&nbsp;</th>
								<th scope="col"  width="15%" class="tright"><strong><?php echo lang('sucursal_id');?></strong></th>
								<th scope="col"  width="15%" class="tright"><strong><?php echo lang('distribuidor');?></strong></th>
							</tr>
						</thead>
						<tbody>
						
							<tr class="odd">
								<td width="70%"><strong><?php echo lang('indice_interpersonal');?></strong></td>
								<td width="15%" class="tright"><strong><?php echo $stat_filtro['indice_interpersonal'];?>%</strong></td>
								<td width="15%" class="tright"><strong><?php echo $stat_distribuidor['indice_interpersonal'];?>%</strong></td>
							</tr>
							
							<tr>
								<td width="70%">2b) <?php echo lang('reporte_encuesta_tsi_pregunta_2b');?></td>
								<td width="15%" class="tright"><?php echo $stat_filtro['pregunta_2b'];?>%</td>
								<td width="15%" class="tright"><?php echo $stat_distribuidor['pregunta_2b'];?>%</td>
							</tr>
							<tr class="odd">
								<td width="70%">2c) <?php echo lang('reporte_encuesta_tsi_pregunta_2c_p');?></td>
								<td width="15%" class="tright"><?php echo $stat_filtro['pregunta_2c'];?>%</td>
								<td width="15%" class="tright"><?php echo $stat_distribuidor['pregunta_2c'];?>%</td>
							</tr>
							<tr>
								<td width="70%">2d) <?php echo lang('reporte_encuesta_tsi_pregunta_2d_p');?></td>
								<td width="15%" class="tright"><?php echo $stat_filtro['pregunta_2d'];?>%</td>
								<td width="15%" class="tright"><?php echo $stat_distribuidor['pregunta_2d'];?>%</td>
							</tr>
							<tr class="odd">
								<td width="70%">2e) <?php echo lang('reporte_encuesta_tsi_pregunta_2e');?></td>
								<td width="15%" class="tright"><?php echo $stat_filtro['pregunta_2e'];?>%</td>
								<td width="15%" class="tright"><?php echo $stat_distribuidor['pregunta_2e'];?>%</td>
							</tr>
							<tr>
								<td width="70%">2f) <?php echo lang('reporte_encuesta_tsi_pregunta_2f_p');?></td>
								<td width="15%" class="tright"><?php echo $stat_filtro['pregunta_2f'];?>%</td>
								<td width="15%" class="tright"><?php echo $stat_distribuidor['pregunta_2f'];?>%</td>
							</tr>
							<tr class="odd">
								<td width="70%">4c) <?php echo lang('reporte_encuesta_tsi_pregunta_4c_p');?></td>
								<td width="15%" class="tright"><?php echo $stat_filtro['pregunta_4c'];?>%</td>
								<td width="15%" class="tright"><?php echo $stat_distribuidor['pregunta_4c'];?>%</td>
							</tr>
							<tr>
								<td width="70%">4d) <?php echo lang('reporte_encuesta_tsi_pregunta_4d_p');?></td>
								<td width="15%" class="tright"><?php echo $stat_filtro['pregunta_4d'];?>%</td>
								<td width="15%" class="tright"><?php echo $stat_distribuidor['pregunta_4d'];?>%</td>
							</tr>
							<tr class="odd">
								<td width="70%">7b) <?php echo lang('reporte_encuesta_tsi_pregunta_7b');?></td>
								<td width="15%" class="tright"><?php echo $stat_filtro['pregunta_7b'];?>%</td>
								<td width="15%" class="tright"><?php echo $stat_distribuidor['pregunta_7b'];?>%</td>
							</tr>
						</tbody>
					</table>
				</div>
			</fieldset>

			<fieldset>
				<legend><?php echo lang('indice_calidad');?></legend>
				
					<table border="0" width="100%"  id="hor-zebra">
					<thead>
						<tr>
							<th scope="col" width="70%" colspan="2">&nbsp;</th>
							<th scope="col" width="15%" class="tright"><strong><?php echo lang('sucursal_id');?></strong></th>
							<th scope="col" width="15%" class="tright"><strong><?php echo lang('distribuidor');?></strong></th>
						</tr>
					</thead>
					<tbody>
						<tr class="odd">
							<td colspan="2"><strong><?php echo lang('indice_calidad');?></strong></td>
							<td class="tright"><strong><?php echo $stat_filtro['indice_calidad'];?>%</strong></td>
							<td class="tright"><strong><?php echo $stat_distribuidor['indice_calidad'];?>%</strong></td>
						</tr>
						<tr>
							<td colspan="2">5) <?php echo lang('reporte_encuesta_tsi_pregunta_5_p');?></td>
							<td class="tright"><?php echo $stat_filtro['pregunta_5'];?>%</td>
							<td class="tright"><?php echo $stat_distribuidor['pregunta_5'];?>%</td>
						</tr>
						<tr class="odd">
							<td colspan="2"><strong>6) <?php echo lang('reporte_encuesta_tsi_pregunta_6_p');?></strong></td>
							<td class="tright"><?php echo $stat_filtro['pregunta_6']['si'];?>%</td>
							<td class="tright"><?php echo $stat_distribuidor['pregunta_6']['si'];?>%</td>
						</tr>
						<tr>
							<td width="10%">&nbsp;</td>
							<td width="60%"><i><?php echo lang('visitas_adicionales_requeridas_p');?></i></td>
							<td width="15%" class="tright"></td>
							<td width="15%" class="tright"></td>
						</tr>
						<tr class="odd">
							<td>&nbsp;</td>
							<td><?php echo strtoupper(lang('uno'));?></td>
							<td class="tright"><?php echo $stat_filtro['pregunta_6a']['una'];?>%</td>
							<td class="tright"><?php echo $stat_distribuidor['pregunta_6a']['una'];?>%</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><?php echo strtoupper(lang('dos'));?></td>
							<td class="tright"><?php echo $stat_filtro['pregunta_6a']['dos'];?>%</td>
							<td class="tright"><?php echo $stat_distribuidor['pregunta_6a']['dos'];?>%</td>
						</tr>
						<tr class="odd">
							<td>&nbsp;</td>
							<td><?php echo strtoupper(lang('tres'));?></td>
							<td class="tright"><?php echo $stat_filtro['pregunta_6a']['tres'];?>%</td>
							<td class="tright"><?php echo $stat_distribuidor['pregunta_6a']['tres'];?>%</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><?php echo strtoupper(lang('cuatro'));?></td>
							<td class="tright"><?php echo $stat_filtro['pregunta_6a']['cuatro'];?>%</td>
							<td class="tright"><?php echo $stat_distribuidor['pregunta_6a']['cuatro'];?>%</td>
						</tr>
						<tr class="odd">
							<td>&nbsp;</td>
							<td><?php echo strtoupper(lang('cinco'));?></td>
							<td class="tright"><?php echo $stat_filtro['pregunta_6a']['cinco'];?>%</td>
							<td class="tright"><?php echo $stat_distribuidor['pregunta_6a']['cinco'];?>%</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><?php echo strtoupper(lang('seis_o_mas'));?></td>
							<td class="tright"><?php echo $stat_filtro['pregunta_6a']['seis'];?>%</td>
							<td class="tright"><?php echo $stat_distribuidor['pregunta_6a']['seis'];?>%</td>
						</tr>
						<tr class="odd">
							<td>&nbsp;</td>
							<td><i><?php echo lang('razones_repeticion_servicio_p');?></i></td>
							<td class="tright"></td>
							<td class="tright"></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><?php echo lang('reporte_encuesta_tsi_pregunta_6b_1');?></td>
							<td class="tright"><?php echo $stat_filtro['pregunta_6b']['uno'];?>%</td>
							<td class="tright"><?php echo $stat_distribuidor['pregunta_6b']['uno'];?>%</td>
						</tr>
						<tr class="odd">
							<td>&nbsp;</td>
							<td><?php echo lang('reporte_encuesta_tsi_pregunta_6b_2_p');?></td>
							<td class="tright"><?php echo $stat_filtro['pregunta_6b']['dos'];?>%</td>
							<td class="tright"><?php echo $stat_distribuidor['pregunta_6b']['dos'];?>%</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><?php echo lang('reporte_encuesta_tsi_pregunta_6b_3');?></td>
							<td class="tright"><?php echo $stat_filtro['pregunta_6b']['tres'];?>%</td>
							<td class="tright"><?php echo $stat_distribuidor['pregunta_6b']['tres'];?>%</td>
						</tr>
						<tr class="odd">
							<td>&nbsp;</td>
							<td><?php echo lang('reporte_encuesta_tsi_pregunta_6b_4');?></td>
							<td class="tright"><?php echo $stat_filtro['pregunta_6b']['cuatro'];?>%</td>
							<td class="tright"><?php echo $stat_distribuidor['pregunta_6b']['cuatro'];?>%</td>
						</tr>
						
						</tbody>
					</table>
				
			</fieldset>
			<fieldset>
				<legend><?php echo lang('sumario');?></legend>
			
					<table border="0" width="100%"  id="hor-zebra">
					<thead>
						<tr>
							<th scope="col" width="70%">&nbsp;</th>
							<th scope="col" width="15%" class="tright"><strong><?php echo lang('sucursal_id');?></strong></th>
							<th scope="col" width="15%" class="tright"><strong><?php echo lang('distribuidor');?></strong></th>
						</tr>
					</thead>
					<tbody>
						<tr class="odd">
							<td width="70%"><strong><?php echo lang('sumario');?></strong></td>
							<td width="15%" class="tright"></td>
							<td width="15%" class="tright"></td>
						</tr>
						</tr>
							<td width="70%">7a) <?php echo lang('pregunta_07a');?></td>
							<td width="15%" class="tright"><?php echo $stat_filtro['pregunta_7a'];?>%</td>
							<td width="15%" class="tright"><?php echo $stat_distribuidor['pregunta_7a'];?>%</td>
						</tr>
						<tr class="odd">
							<td width="70%">7b) <?php echo lang('pregunta_07b');?></td>
							<td width="15%" class="tright"><?php echo $stat_filtro['pregunta_7b'];?>%</td>
							<td width="15%" class="tright"><?php echo $stat_distribuidor['pregunta_7b'];?>%</td>
						</tr>
						
						</tr>
							<td width="70%">7c) <?php echo lang('pregunta_07c');?></td>
							<td width="15%" class="tright"><?php echo $stat_filtro['pregunta_7c'];?>%</td>
							<td width="15%" class="tright"><?php echo $stat_distribuidor['pregunta_7c'];?>%</td>
						</tr>
						<tr class="odd">
							<td width="70%">8) <?php echo lang('pregunta_08_p');?></td>
							<td width="15%" class="tright"><?php echo $stat_filtro['pregunta_8'];?>%</td>
							<td width="15%" class="tright"><?php echo $stat_distribuidor['pregunta_8'];?>%</td>
						</tr>
						<tr>
							<td width="70%">9) <?php echo lang('pregunta_09_p');?></td>
							<td width="15%" class="tright"><?php echo $stat_filtro['pregunta_9'];?>%</td>
							<td width="15%" class="tright"><?php echo $stat_distribuidor['pregunta_9'];?>%</td>
						</tr>
					</tbody>
				</table>
			</fieldset>
	<?php endif;?>
	</div>
	
	<div id="tabs-2" class="noprint">
		<form autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
		<ul>


		<fieldset>
		<legend><?=$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_id');?></legend>
		<li class="unitx4 f-left">
			<?php
					$config	=	array(
							'field_name'=>'tsi_encuesta_satisfaccion_field_fechahora_alta_inicial',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
				<?php
					$config	=	array(
							'field_name'=>'tsi_encuesta_satisfaccion_field_fechahora_alta_final',
							'field_req'=>FALSE,
							'label_class'=>'unitx2', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
	
			
		</li>
		<li class="unitx4 f-left">
			<?php
					$config	=	array(
							'field_name'=>'tsi_field_fecha_de_egreso_inicial',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
				<?php
					$config	=	array(
							'field_name'=>'tsi_field_fecha_de_egreso_final',
							'field_req'=>FALSE,
							'label_class'=>'unitx2', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
		</li>
		</fieldset>
		
		<?php
				$this->load->view( 'backend/_inc_unidad_filtro_view' );
		?>
		
		
		
		<fieldset>
		<legend><?=$this->marvin->mysql_field_to_human('auto_modelo_id');?></legend>
		<li class="unitx8">
			
				<?php
					$config	=	array(
						'field_name'=>'auto_modelo_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'auto_modelo_id',
						'field_type'=>'checkbox',
						'field_options'=>$auto_modelo_id
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
			</li>
		</fieldset>
		
		<div id="div_auto_version_id">
			<?$this->load->view( 'backend/auto_version_id_inc_view' );?>
		</div>
		
		<fieldset>
		<legend><?=$this->marvin->mysql_field_to_human('sucursal_id');?></legend>
		<li class="unitx8">
			
				<?php
					$config	=	array(
						'field_name'=>'sucursal_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$sucursal_id
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
			</li>
		</fieldset>
		

		
		<li class="buttons">
		
			<div>
				<input id="enviar" name="_filtro" class="btTxt submit" value="<?=lang('filtrar')?>" type="submit">
			</div>
		
		</li>
			


	
		</ul>
		</form>
	</div>
</div> <!-- <div id="tabs"> -->


