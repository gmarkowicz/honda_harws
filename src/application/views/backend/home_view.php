<?php

$imagen_path = $this->config->item('base_url') . $image_path;

?>

<div id="info_home" class="clearfix">

				<div id="info_home_columna_izquierda" class="clearfix">


					<!--div class="diapos">DIAPOS</div-->
					<div class="noticia">
							<!--
							<div class="noticia_volanta">NOTICIA</div>
							<div class="noticia_titulo"><a href="sarasa">TC2000 - Equipo Petrobras, Neuquen.</a></div>
							<img src="images/foto_noticia.jpg" width="400" height="230" class="noticia_imagen" />
							<span class="noticia_texto" >Aenean gravida luctus turpis in semper. Sed mollis nisl ut dolor vulputate ultricies. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi fermentum mauris ante, porta molestie enim. Aliquam auctor fringilla sem a ultricies. Quisque varius feugiat mauris, id laoreet diam consequat quis. Ut euismod, nulla vitae consectetur placerat, erat leo scelerisque dolor, eget porttitor ligula lacus at erat. Vestibulum sed arcu sit amet lacus interdum egestas. Praesent ante dui, volutpat sit amet aliquam eu, iaculis sed lorem. Morbi vel metus id massa sodales adipiscing. 
							</span>						
							-->
							<?php
							if(isset($administracion) && is_array($administracion))
							{
								reset($administracion);
								$i=0;
								while(list($key,$val) = each ($administracion))
								{
								?>
									<?php if($i<2){?>
									
									<div class="noticia_volanta">NOTICIA</div>
									<div class="noticia_titulo"><a href="<?php echo $this->config->item('base_url')?><?=$this->config->item('backend_root');?>index/noticia/<?php echo $val['id'];?>"><?php echo $val['noticia_field_titulo'];?></a></div>
									<?php
									
									
									
									if(isset($val['Noticia_Imagen'][0]['noticia_imagen_field_archivo']))
									{
									?>
										<img src="<?php echo $imagen_path . $val['Noticia_Imagen'][0]['noticia_imagen_field_archivo'];?>_thumb_400<?php echo $val['Noticia_Imagen'][0]['noticia_imagen_field_extension']?>" class="noticia_imagen" />
									<?
									}
									?>
									<span class="noticia_texto" >
										<?php echo $val['noticia_field_copete'];?>
									</span>
									
									<?php
									}
									else
									{
									?>
									<div class="noticia_titulo_otras"><a href="<?php echo $this->config->item('base_url')?><?=$this->config->item('backend_root');?>index/noticia/<?php echo $val['id'];?>"><?php echo $val['noticia_field_titulo'];?></a></div>
									
									<?php
									}
									?>
								
								<?
								$i++;
								}
							}
							
							?>
							
							
							
										

							<!--
								<div class="noticia_titulo_otras"><a href="lime">+ Sed mollis nisl ut dolor vulputate.</a></div>
							-->
							
					
				</div>

				</div>

				<div id="info_home_columna_derecha" class="clearfix">

					<!--div class="video">
					   <script type="text/javascript">
						AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','330','height','240','src','images/player_(hondaweb)_final','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','images/player_(hondaweb)_final' ); //end AC code
						</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="330" height="240">
          			<param name="movie" value="images/player_(hondaweb)_final.swf" />
                  <param name="quality" value="high" />
                  <embed src="images/player_(hondaweb)_final.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="330" height="240"></embed>
			     		</object>
						</noscript>
					</div-->
								
					<div class="noticia">
						<!--
						<div class="noticia_volanta">SERVICIOS</div>
						<div class="noticia_titulo_2"><a href="sarasa">TC2000 - Equipo Petrobras, Neuquen.</a></div>
							<img src="images/foto_noticia.jpg" width="180" height="120" class="noticia_imagen_2" />
							<span class="noticia_texto" >Aenean gravida luctus turpis in semper. Sed mollis nisl ut dolor vulputate ultricies. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi fermentum mauris ante, porta molestie enim. Aliquam auctor fringilla sem a ultricies. Quisque varius feugiat mauris, id laoreet diam consequat quis. Ut euismod, nulla vitae consectetur placerat, erat leo scelerisque dolor, eget porttitor ligula lacus at erat. Vestibulum sed arcu sit amet lacus interdum egestas.
							</span>	
						-->
						<?php
							if(isset($servicio) && is_array($servicio))
							{
								reset($servicio);
								$i=0;
								while(list($key,$val) = each ($servicio))
								{
								?>
									<?php if($i==0){?>
									<div class="noticia_volanta">SERVICIO</div>
									<div class="noticia_titulo_2"><a href="<?php echo $this->config->item('base_url')?><?=$this->config->item('backend_root');?>index/noticia/<?php echo $val['id'];?>"><?php echo $val['noticia_field_titulo'];?></a></div>
									<?php
									if(isset($val['Noticia_Imagen'][0]['noticia_imagen_field_archivo']))
									{
									?>
										<img src="<?php echo $imagen_path . $val['Noticia_Imagen'][0]['noticia_imagen_field_archivo'];?>_thumb_180<?php echo $val['Noticia_Imagen'][0]['noticia_imagen_field_extension']?>" class="noticia_imagen_2" />
									<?
									}
									?>
									<span class="noticia_texto" >
										<?php echo $val['noticia_field_copete'];?>
									</span>
									<?php
									} else {
									?>
									
									
									<div class="noticia_titulo_otras"><a href="<?php echo $this->config->item('base_url')?><?=$this->config->item('backend_root');?>index/noticia/<?php echo $val['id'];?>"><?php echo $val['noticia_field_titulo'];?></a></div>
									
									
									<?php } ?>
								<?
								$i++;
								}
							}
							
							?>
						<!--
						<div class="noticia_volanta">COMERCIAL</div>
						<div class="noticia_titulo_2"><a href="sarasa">TC2000 - Equipo Petrobras, Neuquen.</a></div>
							<img src="images/foto_noticia.jpg" width="180" height="120" class="noticia_imagen_2" />
							<span class="noticia_texto" >Aenean gravida luctus turpis in semper. Sed mollis nisl ut dolor vulputate ultricies. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi fermentum mauris ante, porta molestie enim. Aliquam auctor fringilla sem a ultricies. Quisque varius feugiat mauris, id laoreet diam consequat quis. Ut euismod, nulla vitae consectetur placerat, erat leo scelerisque dolor, eget porttitor ligula lacus at erat. Vestibulum sed arcu sit amet lacus interdum egestas.
							</span>	
						-->
						
						<?php
							if(isset($comercial) && is_array($comercial))
							{
								reset($comercial);
								//print_r($comercial);
								
								$i=0;
								while(list($key,$val) = each ($comercial))
								{
								?>
									<?php if($i==0){?>
									<div class="noticia_volanta">COMERCIAL</div>
									<div class="noticia_titulo_2"><a href="<?php echo $this->config->item('base_url')?><?=$this->config->item('backend_root');?>index/noticia/<?php echo $val['id'];?>"><?php echo $val['noticia_field_titulo'];?></a></div>
									<?php
									
									if(isset($val['Noticia_Imagen'][0]['noticia_imagen_field_archivo']))
									{
									?>
										<img src="<?php echo $imagen_path . $val['Noticia_Imagen'][0]['noticia_imagen_field_archivo'];?>_thumb_180<?php echo $val['Noticia_Imagen'][0]['noticia_imagen_field_extension']?>" class="noticia_imagen_2" />
									<?
									}
									?>
									<span class="noticia_texto" >
										<?php echo $val['noticia_field_copete'];?>
									</span>
									<?
									if(isset($val['Noticia_Adjunto'][0]['noticia_adjunto_field_archivo']))
									{
										//link a archivo adjunto
									}
									?>
									
									<?php
									} else {
									?>
									
									
									<div class="noticia_titulo_otras"><a href="<?php echo $this->config->item('base_url')?><?=$this->config->item('backend_root');?>index/noticia/<?php echo $val['id'];?>"><?php echo $val['noticia_field_titulo'];?></a></div>
									
									
									<?php } ?>
								<?
								$i++;
								}
							}
							
							?>
						
					</div>

				</div>

		</div>