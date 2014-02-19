<!-- esto deberia ser un include -->
			
			
			
			
			
			<div class="resultados both encuesta_nos_graficos" style="min-height:500px;">
			<?php
				if(isset($_SESSION['nos_listado']))
				{
					if($_SESSION['nos_listado']['registros_encontrados']==0)
					{
						echo "<p>No se encontraron resultados</p>";
					}
					else
					{
			?>	
					<p class="fr" style="clear:both;"><strong><?php echo $_SESSION['nos_listado']['registros_encontrados'];?> registros encontrados</strong></p>
					<br style="clear:both;">
					<fieldset>
					<legend>2. G&eacute;nero</legend>
					<div class="gradata fl" style="width:50%">
						<table border="0" width="100%">
						<tr>
							<td width="50%">Hombre:</td>
							<td width="50%" class="tright"><?php echo $_SESSION['nos_listado']['sexo'][1];?> %</td>
						</tr>
						<tr>
							<td width="50%">Mujer:</td>
							<td width="50%" class="tright"><?php echo $_SESSION['nos_listado']['sexo'][2];?> %</td>
						</tr>
						<tr>
							<td width="50%">Ns/Nc:</td>
							<td width="50%" class="tright"><?php echo $_SESSION['nos_listado']['sexo'][0];?> %</td>
						</tr>
						</table>
					</div>
					<div class="graimage fr"><img src="<?php echo site_url('public/jpgraph/sexo_'.$_SESSION['nos_listado']['tmp_images'].'.png')?>"></div>
				</fieldset>
				
				<fieldset>
				<legend>3. Edad</legend>
				<div class="gradata fl" style="width:50%">
					<table border="0" width="100%">
					<tr>
						<td width="50%">Menos de 20:</td>
						<td width="50%" class="tright"><?php echo $_SESSION['nos_listado']['edad'][1];?> %</td>
					</tr>
					<tr>
						<td width="50%">20-29:</td>
						<td width="50%" class="tright"><?php echo $_SESSION['nos_listado']['edad'][2];?> %</td>
					</tr>
					<tr>
						<td width="50%">30-39:</td>
						<td width="50%" class="tright"><?php echo $_SESSION['nos_listado']['edad'][3];?> %</td>
					</tr>
					<tr>
						<td width="50%">40-49:</td>
						<td width="50%" class="tright"><?php echo $_SESSION['nos_listado']['edad'][4];?> %</td>
					</tr>
					<tr>
						<td width="50%">50-59:</td>
						<td width="50%" class="tright"><?php echo $_SESSION['nos_listado']['edad'][5];?> %</td>
					</tr>
					<tr>
						<td width="50%">60-69:</td>
						<td width="50%" class="tright"><?php echo $_SESSION['nos_listado']['edad'][6];?> %</td>
					</tr>
					<tr>
						<td width="50%">70 o m&aacute;s:</td>
						<td width="50%" class="tright"><?php echo $_SESSION['nos_listado']['edad'][7];?> %</td>
					</tr>
					<tr>
						<td width="50%">Ns/Nc:</td>
						<td width="50%" class="tright"><?php echo $_SESSION['nos_listado']['edad'][0];?> %</td>
					</tr>
					</table>
				</div>
				<div class="graimage fr"><img src="<?php echo site_url('public/jpgraph/edad_'.$_SESSION['nos_listado']['tmp_images'].'.png')?>"></div>
			</fieldset>
			
			<fieldset>
			<legend>4. N&uacute;mero de personas</legend>
			<div class="gradata fl" style="width:50%">
				<table border="0" width="100%">
				<tr>
					<td width="50%">Uno:</td>
					<td width="50%" class="tright"><?php echo $_SESSION['nos_listado']['grupo'][1];?> %</td>
				</tr>
				<tr>
					<td width="50%">Dos:</td>
					<td width="50%" class="tright"><?php echo $_SESSION['nos_listado']['grupo'][2];?>  %</td>
				</tr>
				<tr>
					<td width="50%">Tres:</td>
					<td width="50%" class="tright"><?php echo $_SESSION['nos_listado']['grupo'][3];?>  %</td>
				</tr>
				<tr>
					<td width="50%">Cuatro:</td>
					<td width="50%" class="tright"><?php echo $_SESSION['nos_listado']['grupo'][4];?>  %</td>
				</tr>
				<tr>
					<td width="50%">Cinco:</td>
					<td width="50%" class="tright"><?php echo $_SESSION['nos_listado']['grupo'][5];?>  %</td>
				</tr>
				<tr>
					<td width="50%">Seis o M&aacute;s:</td>
					<td width="50%" class="tright"><?php echo $_SESSION['nos_listado']['grupo'][6];?>  %</td>
				</tr>
				<tr>
					<td width="50%">Ns/Nc:</td>
					<td width="50%" class="tright"><?php echo $_SESSION['nos_listado']['grupo'][0];?>  %</td>
				</tr>
				</table>
			</div>
			<div class="graimage fr"><img src="<?php echo site_url('public/jpgraph/grupo_'.$_SESSION['nos_listado']['tmp_images'].'.png')?>"></div>
		</fieldset>
		
			<fieldset>
			<legend>5. Ocupaci&oacute;n</legend>
			<div class="gradata" style="width:49%;float:left;">
				<table border="0" width="100%">
				<tr>
					<td width="80%">Due&ntilde;o de una compa&ntilde;ia / Director ejecutivo:</td>
					<td width="20%" class="tright"><?php echo $_SESSION['nos_listado']['ocupacion'][1];?> %</td>
				</tr>
				<tr>
					<td width="80%">Gerencia de compa&ntilde;ia:</td>
					<td width="20%" class="tright"><?php echo $_SESSION['nos_listado']['ocupacion'][2];?> %</td>
				</tr>
				<tr>
					<td width="80%">Empleado de una compa&ntilde;ia:</td>
					<td width="20%" class="tright"><?php echo $_SESSION['nos_listado']['ocupacion'][3];?> %</td>
				</tr>
				<tr>
					<td width="80%">Profesional:</td>
					<td width="20%" class="tright"><?php echo $_SESSION['nos_listado']['ocupacion'][4];?> %</td>
				</tr>
				<tr>
					<td width="80%">Educador:</td>
					<td width="20%" class="tright"><?php echo $_SESSION['nos_listado']['ocupacion'][5];?> %</td>
				</tr>
				<tr>
					<td width="80%">Trabajador independiente:</td>
					<td width="20%" class="tright"><?php echo $_SESSION['nos_listado']['ocupacion'][6];?> %</td>
				</tr>
				<tr>
					<td width="80%">Estudiante:</td>
					<td width="20%" class="tright"><?php echo $_SESSION['nos_listado']['ocupacion'][7];?> %</td>
				</tr>
				</table>
			</div>
			<div class="gradata" style="width:49%;float:right;">
				<table border="0" width="100%">
					<tr>
						<td width="80%">Funcionario de gobierno:</td>
						<td width="20%" class="tright"><?php echo $_SESSION['nos_listado']['ocupacion'][8];?> %</td>
					</tr>
					<tr>
						<td width="80%">Empleado del gobierno:</td>
						<td width="20%" class="tright"><?php echo $_SESSION['nos_listado']['ocupacion'][9];?> %</td>
					</tr>
					<tr>
						<td width="80%">Oficial militar:</td>
						<td width="20%" class="tright"><?php echo $_SESSION['nos_listado']['ocupacion'][10];?> %</td>
					</tr>
					<tr>
						<td width="80%">Soldado:</td>
						<td width="20%" class="tright"><?php echo $_SESSION['nos_listado']['ocupacion'][11];?> %</td>
					</tr>
					<tr>
						<td width="80%">Ama de casa:</td>
						<td width="20%" class="tright"><?php echo $_SESSION['nos_listado']['ocupacion'][12];?> %</td>
					</tr>
					<tr>
						<td width="80%">Otros:</td>
						<td width="20%" class="tright"><?php echo $_SESSION['nos_listado']['ocupacion'][13];?> %</td>
					</tr>
					<tr>
						<td width="80%">Ns/Nc:</td>
						<td width="20%" class="tright"><?php echo $_SESSION['nos_listado']['ocupacion'][0];?> %</td>
					</tr>
				</table>

			</div>
			<br />
			
				<img src="<?php echo site_url('public/jpgraph/ocupacion_'.$_SESSION['nos_listado']['tmp_images'].'.png')?>" class="imgcenter"style="">
			
		</fieldset>
		
		<fieldset>
			<legend>6. Como compr&oacute; su autom&oacute;vil</legend>
			<div class="gradata fl" style="width:50%">
				<table border="0" width="100%">
				<tr>
					<td width="50%">Al contado:</td>
					<td width="50%" class="tright"><?php echo $_SESSION['nos_listado']['financiacion'][1];?> %</td>
				</tr>
				<tr>
					<td width="50%">Pr&eacute;stamo:</td>
					<td width="50%" class="tright"><?php echo $_SESSION['nos_listado']['financiacion'][2];?> %</td>
				</tr>
				<tr>
					<td width="50%">Otros:</td>
					<td width="50%" class="tright"><?php echo $_SESSION['nos_listado']['financiacion'][3];?> %</td>
				</tr>
				<tr>
					<td width="50%">Ns/Nc:</td>
					<td width="50%" class="tright"><?php echo $_SESSION['nos_listado']['financiacion'][0];?> %</td>
				</tr>
				</table>
			</div>
			<div class="graimage fr"><img src="<?php echo site_url('public/jpgraph/financiacion_'.$_SESSION['nos_listado']['tmp_images'].'.png')?>"></div>
		</fieldset>
		
		<fieldset>
			<legend>7. Es este automovil</legend>
			<div class="gradata fl" style="width:50%">
				<table border="0" width="100%">
				<tr>
					<td width="70%">Principal:</td>
					<td width="30%" class="tright"><?php echo $_SESSION['nos_listado']['tipo'][1];?> %</td>
				</tr>
				<tr>
					<td width="70%">Secundario:</td>
					<td width="30%" class="tright"><?php echo $_SESSION['nos_listado']['tipo'][2];?> %</td>
				</tr>
				<tr>
					<td width="70%">Auto de la compa&ntilde;ia:</td>
					<td width="30%" class="tright"><?php echo $_SESSION['nos_listado']['tipo'][3];?> %</td>
				</tr>
				<tr>
					<td width="70%">Ns/Nc:</td>
					<td width="30%" class="tright"><?php echo $_SESSION['nos_listado']['tipo'][0];?> %</td>
				</tr>
				</table>
			</div>
			<div class="graimage fr"><img src="<?php echo site_url('public/jpgraph/tipo_'.$_SESSION['nos_listado']['tmp_images'].'.png')?>"></div>
		</fieldset>
		
		<fieldset>
			<legend>8. Este automovil es conducido por</legend>
			<div class="gradata fl" style="width:50%">
				<table border="0" width="100%">
				<tr>
					<td width="70%">Propietario:</td>
					<td width="30%" class="tright"><?php echo $_SESSION['nos_listado']['conducido'][1];?> %</td>
				</tr>
				<tr>
					<td width="70%">Esposo/a o Hijo/a:</td>
					<td width="30%" class="tright"><?php echo $_SESSION['nos_listado']['conducido'][2];?> %</td>
				</tr>
				<tr>
					<td width="70%">Chofer:</td>
					<td width="30%" class="tright"><?php echo $_SESSION['nos_listado']['conducido'][3];?> %</td>
				</tr>
				<tr>
					<td width="70%">Ejecutivo:</td>
					<td width="30%" class="tright"><?php echo $_SESSION['nos_listado']['conducido'][4];?> %</td>
				</tr>
				<tr>
					<td width="70%">Empleado:</td>
					<td width="30%" class="tright"><?php echo $_SESSION['nos_listado']['conducido'][5];?> %</td>
				</tr>
				<tr>
					<td width="70%">Otros:</td>
					<td width="30%" class="tright"><?php echo $_SESSION['nos_listado']['conducido'][6];?> %</td>
				</tr>
				<tr>
					<td width="70%">Ns/Nc:</td>
					<td width="30%" class="tright"><?php echo $_SESSION['nos_listado']['conducido'][0];?> %</td>
				</tr>
				
				</table>
			</div>
			<div class="graimage fr"><img src="<?php echo site_url('public/jpgraph/conducido_'.$_SESSION['nos_listado']['tmp_images'].'.png')?>"></div>
		</fieldset>
		
		<fieldset>
		<legend>Como usa el autom&oacute;vil</legend>
			<div class="gradata" style="width:99%;clear:both;">
				<table border="0" width="100%">
				<tr>
					<td class="tright">&nbsp;</td>
					<th class="tright">Principal</th>
					<th class="tright">Secundario</th>
					<th class="tright">Ns/Nc</th>
				</tr>
				<tr>
					<td width="55%">Negocios / Trabajo:</td>
					<td width="15%" class="tright"><?php echo $_SESSION['nos_listado']['uso_negocios'][1];?> %</td>
					<td width="15%" class="tright"><?php echo $_SESSION['nos_listado']['uso_negocios'][2];?> %</td>
					<td width="15%" class="tright"><?php echo $_SESSION['nos_listado']['uso_negocios'][0];?> %</td>
				</tr>
				<tr>
					<td width="55%">Transporte al trabajo:</td>
					<td width="15%" class="tright"><?php echo $_SESSION['nos_listado']['uso_trabajo'][1];?> %</td>
					<td width="15%" class="tright"><?php echo $_SESSION['nos_listado']['uso_trabajo'][2];?> %</td>
					<td width="15%" class="tright"><?php echo $_SESSION['nos_listado']['uso_trabajo'][0];?> %</td>
				</tr>
				<tr>
					<td width="55%">Transporte a la escuela:</td>
					<td width="15%" class="tright"><?php echo $_SESSION['nos_listado']['uso_escuela'][1];?> %</td>
					<td width="15%" class="tright"><?php echo $_SESSION['nos_listado']['uso_escuela'][2];?> %</td>
					<td width="15%" class="tright"><?php echo $_SESSION['nos_listado']['uso_escuela'][0];?> %</td>
				</tr>
				<tr>
					<td width="55%">General:</td>
					<td width="15%" class="tright"><?php echo $_SESSION['nos_listado']['uso_general'][1];?> %</td>
					<td width="15%" class="tright"><?php echo $_SESSION['nos_listado']['uso_general'][2];?> %</td>
					<td width="15%" class="tright"><?php echo $_SESSION['nos_listado']['uso_general'][0];?> %</td>
				</tr>
				<tr>
					<td width="55%">Placer:</td>
					<td width="15%" class="tright"><?php echo $_SESSION['nos_listado']['uso_placer'][1];?> %</td>
					<td width="15%" class="tright"><?php echo $_SESSION['nos_listado']['uso_placer'][2];?> %</td>
					<td width="15%" class="tright"><?php echo $_SESSION['nos_listado']['uso_placer'][0];?> %</td>
				</tr>
				</table>
			</div>
			<img src="<?php echo site_url('public/jpgraph/usos_'.$_SESSION['nos_listado']['tmp_images'].'.png')?>" class="imgcenter">
		</fieldset>
		
		<fieldset>
		<legend>Impresiones de Honda</legend>
			<div class="gradata" style="width:99%;clear:both;">
				<table border="0" width="100%">
				<tr>
					<td>&nbsp;</td>
					<th class="tright">M&aacute;s de lo normal</th>
					<th class="tright">Normal</th>
					<th class="tright">Debajo de lo Normal</th>
					<th class="tright">Ns/Nc</th>
				</tr>
				<tr>
					<td width="40%">Dedicaci&oacute;n a la investigaci&oacute;n y desarrollo:</td>
					<td width="15%" class="tright"><?php echo $_SESSION['nos_listado']['opinion_investigacion'][1];?> %</td>
					<td width="15%" class="tright"><?php echo $_SESSION['nos_listado']['opinion_investigacion'][2];?> %</td>
					<td width="20%" class="tright"><?php echo $_SESSION['nos_listado']['opinion_investigacion'][3];?> %</td>
					<td width="10%" class="tright"><?php echo $_SESSION['nos_listado']['opinion_investigacion'][4];?> %</td>
				</tr>
				<tr>
					<td>Originalidad e innovaci&oacute;n:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['opinion_originalidad'][1];?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['opinion_originalidad'][2];?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['opinion_originalidad'][3];?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['opinion_originalidad'][4];?> %</td>
				</tr>
				<tr>
					<td>Dedicaci&oacute;n a las carreras de auto:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['opinion_carreras'][1];?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['opinion_carreras'][2];?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['opinion_carreras'][3];?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['opinion_carreras'][4];?> %</td>
				</tr>
				<tr>
					<td>Compromiso para conducir con seguridad:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['opinion_seguridad'][1];?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['opinion_seguridad'][2];?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['opinion_seguridad'][3];?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['opinion_seguridad'][4];?> %</td>
				</tr>
				<tr>
					<td>Responsabilidad con el medio ambiente:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['opinion_medio_ambiente'][4];?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['opinion_medio_ambiente'][3];?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['opinion_medio_ambiente'][2];?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['opinion_medio_ambiente'][1];?> %</td>
				</tr>
				<tr>
					<td width="40%">Dedicaci&oacute;n a productos de alta eficiencia:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['opinion_eficiencia'][4];?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['opinion_eficiencia'][3];?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['opinion_eficiencia'][2];?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['opinion_eficiencia'][1];?> %</td>
				</tr>
				</table>
			</div>
			<img src="<?php echo site_url('public/jpgraph/opinion_'.$_SESSION['nos_listado']['tmp_images'].'.png')?>" class="imgcenter">
		</fieldset>
		
		<fieldset>
			<legend>Como se interes&oacute; en su Honda</legend>
			<div class="gradata">
				<table border="0" width="100%">
				<tr>
					<td width="70%">Reputaci&oacute;n del modelo:</td>
					<td width="30%" class="tright"><?php echo $_SESSION['nos_listado']['interes'][1];?> %</td>
				</tr>
				<tr>
					<td width="70%">Anuncios comerciales / por carta:</td>
						<td width="30%" class="tright"><?php echo $_SESSION['nos_listado']['interes'][2];?> %</td>
				</tr>
				<tr>
					<td width="70%">Recomendaci&oacute;n de amigos:</td>
						<td width="30%" class="tright"><?php echo $_SESSION['nos_listado']['interes'][3];?> %</td>
				</tr>
				<tr>
					<td width="70%">Conduciendo el modelo de otra persona:</td>
						<td width="30%" class="tright"><?php echo $_SESSION['nos_listado']['interes'][4];?> %</td>
				</tr>
				<tr>
					<td width="70%">Anuncio en peri&oacute;dico/tv/radio:</td>
						<td width="30%" class="tright"><?php echo $_SESSION['nos_listado']['interes'][5];?> %</td>
				</tr>
				<tr>
					<td width="70%">V&iacute; un Honda en el sal&oacute;n de exposiciones:</td>
						<td width="30%" class="tright"><?php echo $_SESSION['nos_listado']['interes'][6];?> %</td>
				</tr>				
				</table>
			</div>
				<img src="<?php echo site_url('public/jpgraph/interes_'.$_SESSION['nos_listado']['tmp_images'].'.png')?>" class="imgcenter">
		</fieldset>
		
		<fieldset>
			<legend>Influencia</legend>
			<div class="gradata" style="width:49%;float:left;">
				<table border="0" width="100%">
				<tr>
					<td>&nbsp;</td>
					<th>Imp.</th>
					<th>Sec.</th>
					<th>Ns/Nc</th>
				</tr>
				<tr>
					<td>Dise&ntilde;o / estilo exterior:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_estilo'][1]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_estilo'][2]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_estilo'][3]?> %</td>
				</tr>
				<tr>
					<td>Tama&ntilde;o:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_tamanio'][1]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_tamanio'][2]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_tamanio'][3]?> %</td>
				</tr>
				<tr>
					<td>Potencia:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_potencia'][1]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_potencia'][2]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_potencia'][3]?> %</td>
				</tr>
				<tr>
					<td>Respuesta:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_respuesta'][1]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_respuesta'][2]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_respuesta'][3]?> %</td>
				</tr>
				<tr>
					<td>Maniobrabilidad:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_maniobrabilidad'][1]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_maniobrabilidad'][2]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_maniobrabilidad'][3]?> %</td>
				</tr>
				<tr>
					<td>Econom&iacute;a del combustible:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_economia'][1]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_economia'][2]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_economia'][3]?> %</td>
				</tr>
				<tr>
					<td>Precio:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_precio'][1]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_precio'][2]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_precio'][3]?> %</td>
				</tr>
				<tr>
					<td>T&eacute;rminos del prestamo:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_financiacion'][1]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_financiacion'][2]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_financiacion'][3]?> %</td>
				</tr>
				<tr>
					<td>Per&iacute;odo / T&eacute;rminos de Garant&iacute;a:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_garantia'][1]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_garantia'][2]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_garantia'][3]?> %</td>
				</tr>
				<tr>
					<td>Reputaci&oacute;n del modelo:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_modelo'][1]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_modelo'][2]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_modelo'][3]?> %</td>
				</tr>
				<tr>
					<td>Reputaci&oacute;n de la compa&ntilde;ia:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_empresa'][1]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_empresa'][2]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_empresa'][3]?> %</td>
				</tr>
				</table>
			</div>
			<div class="gradata" style="width:49%;float:right;">
				<table border="0" width="100%">
					<tr>
					<td>&nbsp;</td>
					<th>Imp</th>
					<th>Sec.</th>
					<th>Ns/Nc</th>
				</tr>
				<tr>
					<td>Dise&ntilde;o / estilo interior:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_disenio'][1]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_disenio'][2]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_disenio'][3]?> %</td>
				</tr>
				<tr>
					<td>Comodidad:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_comodidad'][1]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_comodidad'][2]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_comodidad'][3]?> %</td>
				</tr>
				<tr>
					<td>Caracter Pr&aacute;ctico:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_practicidad'][1]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_practicidad'][2]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_practicidad'][3]?> %</td>
				</tr>
				<tr>
					<td>Caracter&iacute;sticas de seguridad:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_seguridad'][1]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_seguridad'][2]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_seguridad'][3]?> %</td>
				</tr>
				<tr>
					<td>Confiabilidad:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_confiabilidad'][1]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_confiabilidad'][2]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_confiabilidad'][3]?> %</td>
				</tr>
				<tr>
					<td>Longevidad:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_longevidad'][1]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_longevidad'][2]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_longevidad'][3]?> %</td>
				</tr>
				<tr>
					<td>Prestigio:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_prestigio'][1]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_prestigio'][2]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_prestigio'][3]?> %</td>
				</tr>
				<tr>
					<td>Calidad de los repuestos:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_calidad'][1]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_calidad'][2]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_calidad'][3]?> %</td>
				</tr>
				<tr>
					<td>Disponibilidad de los respuestos:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_disponibilidad'][1]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_disponibilidad'][2]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_disponibilidad'][3]?> %</td>
				</tr>
				<tr>
					<td>Opci&oacute;nes / accesorios:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_accesorios'][1]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_accesorios'][2]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_accesorios'][3]?> %</td>
				</tr>
				<tr>
					<td>Servicio del Concesionario:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_servicio'][1]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_servicio'][2]?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['influencia_servicio'][3]?> %</td>
				</tr>
					
				</table>

			</div>
			<img src="<?php echo site_url('public/jpgraph/influencia_'.$_SESSION['nos_listado']['tmp_images'].'.png')?>" class="imgcenter">
		</fieldset>
		
		<fieldset>
			<legend>Para comprar su Honda</legend>
			<div class="gradata fl" style="width:50%">
				<table border="0" width="100%">
				<tr>
					<td width="50%">&nbsp;</td>
					<th width="25%" class="tright">S&iacute;</th>
					<th width="25%" class="tright">No</th>
				</tr>
				<tr>
					<td>Comparó con otros modelos:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['comparo'][2];?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['comparo'][1];?> %</td>
					
				</tr>		
				</table>
			</div>
			<div class="graimage fr"><img src="<?php echo site_url('public/jpgraph/comparo_'.$_SESSION['nos_listado']['tmp_images'].'.png')?>"></div>
		</fieldset>
			<fieldset>
			<legend>Para comprar su Honda</legend>
			<div class="gradata fl" style="width:50%">
				<table border="0" width="100%">
				<tr>
					<td width="50%"  class="tright">&nbsp;</td>
					<th width="25%"  class="tright">S&iacute;</th>
					<th width="25%"  class="tright">No</th>
				</tr>
				<tr>
					<td>Es este su primer autom&oacute;vil:</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['primer_automovil'][2];?> %</td>
					<td class="tright"><?php echo $_SESSION['nos_listado']['primer_automovil'][1];?> %</td>
				</tr>		
				</table>
			</div>
			<div class="graimage fr"><img src="<?php echo site_url('public/jpgraph/primer_automovil_'.$_SESSION['nos_listado']['tmp_images'].'.png')?>"></div>
			
		</fieldset>
			
		
					
					
					
			<?php
						
					}
				}
			?>
			</div>	