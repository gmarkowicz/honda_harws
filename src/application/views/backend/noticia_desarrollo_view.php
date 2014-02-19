<?php

$imagen_path = $this->config->item('base_url') . $image_path;
$adjunto_path = $this->config->item('base_url') . $adjunto_path;

?>

<div id="info_home" class="clearfix">

				<div id="info_home_columna_izquierda" class="clearfix">
					<div class="noticia">
					
						<div class="noticia_titulo"><?php echo $noticia['noticia_field_titulo'];?></div>
						<?php
						if(isset($noticia['Noticia_Imagen'][0]['noticia_imagen_field_archivo']))
						{
						?>
						<img src="<?php echo $imagen_path . $noticia['Noticia_Imagen'][0]['noticia_imagen_field_archivo'];?>_thumb_580<?php echo $noticia['Noticia_Imagen'][0]['noticia_imagen_field_extension']?>" class="noticia_imagen"  />
						<?
						}
						?>
						<span class="noticia_texto" >
							<?php echo $noticia['noticia_field_desarrollo'];?>
						</span>
						
						<?php
						if(isset($noticia['Noticia_Adjunto'][0]['noticia_adjunto_field_archivo']))
						{
							?>
							<div class="noticia_volanta">ARCHIVOS AJUNTOS</div>
							<?
							while(list($key,$val) = each ($noticia['Noticia_Adjunto']))
							{
							?>
								<div class="noticia_titulo_otras"><a href="<?echo $adjunto_path . $val['noticia_adjunto_field_archivo'] . '.' . $val['noticia_adjunto_field_extension'];?>"><?echo $val['noticia_adjunto_field_archivo'] . '.' . $val['noticia_adjunto_field_extension'] ;?></a></div>
							<?
							}
						?>
							
						<?
						}
						?>
						
					</div>

				</div>

				<div id="info_home_columna_derecha" class="clearfix">

					
					<div class="noticia">			
					<div class="noticia_volanta">OTRAS NOTICIAS</div>
					<?php
					reset($noticias);
					while(list($key,$val) = each ($noticias))
					{
						
					?>	
						<div class="noticia_titulo_otras"><a href="<?php echo $this->config->item('base_url')?><?=$this->config->item('backend_root');?>index/noticia/<?php echo $val['id'];?>"><?php echo $val['noticia_field_titulo'];?></a></div>
						
					<?
					}
					?>	
							
							
					</div>
					

				</div>

		</div>