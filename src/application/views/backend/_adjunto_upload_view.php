				<?
				/*
				$imagen = array objeto de doctrine
				$model = nombre del modelo en minusculas ej noticia
				$prefix = nombre de la tabla de las imagenes ej: imagen
				*/
				//cargo el config del modelo

				//$this->config->load('adjunto/' .$model . '_' .$prefix);
				//$config = $this->config->item('adjunto_upload');

				$this->config->load('adjunto/' . $model . '_' .$prefix, TRUE);
				$config = $this->config->item('adjunto_upload','imagen/' . $model . '_' .$prefix);


				if(isset($adjuntos) && count($adjuntos)>0){
				?>
				<li class="unitx8">

								<?
								while(list($id,$adjunto) = each($adjuntos))
								{
									if(isset($adjunto[$model . '_' . $prefix . '_field_archivo']))
									{
								?>
									<div class="noticia_titulo_otras" id="<?=$adjunto['id'];?>">
										<a target="_adjunto" class="always" href="<?=$this->config->item('base_url');?>public/uploads/<?echo $model.'/'.$prefix.'/'.$adjunto[$model . '_' . $prefix . '_field_archivo'] . '.' . $adjunto[$model . '_' . $prefix . '_field_extension'];?>"><?echo $adjunto[$model . '_' . $prefix . '_field_archivo'] . '.' . $adjunto[$model . '_' . $prefix . '_field_extension'];?></a>
										<?if ($this->backend->_permiso('del') && $this->router->method!='show'){?>
											<a href="#" class="eliminarAdjunto noprint" id="<?=$adjunto['id'];?>" rel="<?=$prefix;?>"><img src="<?=$this->config->item('base_url');?>public/images/icons/delete.png"></a>
										<?}?>
									</div>
								<?
									}
								}
								?>
				</li>
				<?
				} //if(isset($imagenes) && count($imagenes)>0){
				?>
				<?
				if( $this->router->method!='show'){
				?>
				<li class="unitx8 both noprint">
					<label><?=lang('ingresar_adjunto')?>
					<input <?php /*id="multiple_upload_adjunto"*/?> type="file" name="<?=$model;?>_<?=$prefix?>[]" size="69" class="multi" accept="<?echo $config['allowed_types'];?>" /></label>
				</li>
				<?}?>

