				<?
				/*
				$imagen = array objeto de doctrine
				$model = nombre del modelo en minusculas ej noticia
				$prefix = nombre de la tabla de las imagenes ej: imagen
				*/
				//cargo el config del modelo
				$this->config->load('imagen/' . $model . '_' .$prefix, TRUE);
				$config = $this->config->item('image_upload','imagen/' . $model . '_' .$prefix);
				
				if(isset($images) && count($images)>0){
				reset($images);
				?>
				<li class="unitx8">
					
						<!-- Sort -->
						<div class="t-center">
							<ul class="ui-sortable sort<?=$model . '_' .$prefix?>" id="sortable">
								<?
								while(list($id,$imagen) = each($images)){
								?>
								<li id="<?=$imagen['id'];?>" class="ui-state-default">
										<div class="imagen">
											<img src="<?=$this->config->item('base_url');?>public/uploads/<?=$model;?>/<?=$prefix;?>/<?=$imagen[$model . '_' . $prefix . '_field_archivo'] . '_bo' . $imagen[ $model . '_' . $prefix . '_field_extension'];?>" alt="<?=$imagen[ $model . '_' . $prefix . '_field_copete'];?>">
										</div>
										<div class="descripcion t-center">
											<strong><span id="_span_imagen_titulo<?=$imagen['id'];?>"><?=$imagen[$model . '_' . $prefix . '_field_titulo'];?></span></strong><br />
											<span id="_span_imagen_copete<?=$imagen['id'];?>"><?=$imagen[$model . '_' . $prefix . '_field_copete'];?></span>
											<input type="hidden" id="_imagen_titulo<?=$imagen['id'];?>" value="<?=$imagen[$model . '_' . $prefix . '_field_titulo'];?>">
											<input type="hidden" id="_imagen_copete<?=$imagen['id'];?>" value="<?=$imagen[$model . '_' . $prefix . '_field_copete'];?>">
											<input type="hidden" id="_imagen_url<?=$imagen['id'];?>" value="<?=$this->config->item('base_url');?>public/uploads/<?=$model?>/<?=$prefix?>/<?=$imagen[$model . '_' . $prefix . '_field_archivo'] . '_bo' . $imagen[$model . '_' . $prefix . '_field_extension'];?>">
										</div>									
										<div class="acciones noprint">
											<div class="f-right">
												<!--a href="#" rel="prettyPhoto[gallery]"><img src="<?=$this->config->item('base_url');?>public/images/icons/zoom_in.png"></a-->
												<?if ($this->backend->_permiso('del') && $this->router->method!='show'){?>
												<a href="#" class="actualizarDescripcion" rel="<?=$prefix;?>" id="<?=$imagen['id'];?>"><img src="<?=$this->config->item('base_url');?>public/images/icons/page_white_edit.png"></a>
												<?}?>
											</div>
											<div class="f-left">
											<?if ($this->backend->_permiso('del') && $this->router->method!='show'){?>
												<a href="#" class="eliminarImagen" id="<?=$imagen['id'];?>" rel="<?=$prefix;?>"><img src="<?=$this->config->item('base_url');?>public/images/icons/delete.png"></a>
											<?}?>
											</div>
										</div>
									</li>
									<?
									}//while(list($id,$imagen) = each($noticia_imagen)){
									?>
									
							</ul>
						</div>
						<?
						 if($this->router->method!='show'){
						?>
						<script type="text/javascript">
							$(document).ready(function() {
								<!-- sort -->
								$(".sort<?=$model . '_' .$prefix?>").sortable({
									placeholder: 'ui-state-highlight'
								});
								$(".sort<?=$model . '_' .$prefix?>").bind('sortupdate', function() {
									$.ajax({
											beforeSend: function(objeto){
												$('#_ajax_loading').show();
											},
											type: "POST",
											url: "<?=$abm_url;?>/ordenar_imagenes/<?=set_value('id');?>",
											data: "prefix=<?=$prefix;?>&_<?=$model;?>_<?=$prefix;?>_field_orden="+$('.sort<?=$model . '_' .$prefix?>').sortable('toArray'),
											success: function(datos){
												$('#_ajax_loading').hide();
											}
									});
								});
								
								<!-- sort -->
							 });
						</script>
						<!-- Sort -->
						<?
						}
						?>
					
				</li>
				<?
				} //if(isset($imagenes) && count($imagenes)>0){
				?>
				<?
					if($this->router->method!='show'){
				?>
				<li class="unitx8 both noprint">
					<label><?=lang('ingresar_imagen')?>
					<input id="multiple_upload_image<?=$model . '_' .$prefix;?>" type="file" name="<?=$model;?>_<?=$prefix?>[]" size="20" class="multi" accept="<?echo $config['allowed_types'];?>" /></label>
				</li>
				<?
					}
				?>
				
		
