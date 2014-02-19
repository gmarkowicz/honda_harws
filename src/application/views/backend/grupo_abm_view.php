<script LANGUAGE="JavaScript"> 
$(document).ready(function(){	
	$("#versionimprenta").hide();
});
</script>
<div id="tabs">
		<ul>
			<li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
<!-- 			<li><a href="#tabs-1"><img src="<?=$this->config->item('base_url');?>public/images/boton_principal.png"  /></a></li> -->
		</ul>
		<div id="tabs-1">
		<?php
				$this->load->view( 'backend/esqueleto_botones_view' );
		?>
<form autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
			
		<ul>	
				
				<fieldset>
				<legend><?=$this->marvin->mysql_field_to_human('grupo_id');?></legend>
				<li class="unitx8">
				

					<?php
				$config	=	array(
								'field_name'=>'grupo_field_desc',
								'field_req'=>TRUE,
								'label_class'=>'unitx3 first',
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>

		</li>
		</fieldset>
		
		<?php
		/*
		
		<?php if(isset($many_admin) AND count($many_admin)>0):?>
			<?php $odd = 1;?>
			<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('admin_id');?></legend>
			<li>
				
				<table id="hor-zebra" summary="<?=$this->marvin->mysql_field_to_human('admin_id');?>">
					<thead>
						<tr>
							<th scope="col"><?php echo $this->marvin->mysql_field_to_human('id');?></th>
							<th scope="col"><?php echo $this->marvin->mysql_field_to_human('admin_field_usuario');?></th>
							<th scope="col"><?php echo $this->marvin->mysql_field_to_human('admin_field_nombre');?></th>
							<th scope="col"><?php echo $this->marvin->mysql_field_to_human('admin_field_apellido');?></th>
						</tr>
					</thead>
					<tbody>
					
					<?php foreach($many_admin as $admin):?>
					<tr <?php if(($odd % 2) == 1) echo 'class="odd"';?>>
						<td><?php echo $admin['id'];?></td>
						<td><?php echo $admin['admin_field_usuario'];?></td>
						<td><?php echo $admin['admin_field_nombre'];?></td>
						<td><?php echo $admin['admin_field_apellido'];?></td>	
					</tr>
					<?php ++$odd;?>
					<?php endforeach;?>
					
					</tbody>
				</table>
			</li>
		</fieldset>
		<?php endif;?>
		*/
		?>
		
		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('secciones');?></legend>
			<li class="unitx8 t-center">
				
				
				
				<div  id="tablebase">
								<?
					$arbol = Doctrine::getTable('Backend_Menu')->getTree();
					$rootColumnName = $arbol->getAttribute('rootColumnName');
					foreach ($arbol->fetchRoots() as $root) {
					$options = array('root_id' => $root->$rootColumnName);
					foreach($arbol->fetchTree($options) as $node) {
						if($node->getNode()->isRoot())
						{
							?>
						
							<table class="tabla_opciones grupos" width="100%" cellspacing="0">

							<thead>
							<tr>
							<th colspan="6">
							<input id="be_benu<?=$node->id;?>" name="grupo_m_backend_menu[]" value="<?=$node->id;?>" type="checkbox" <?= $this->form_validation->set_checkbox('grupo_m_backend_menu[]', $node->id); ?> >
									<label class="choice" for="be_benu<?=$node->id;?>"><?=$node->backend_menu_field_desc;?></label>
							</td>
							</th>
							</thead>
							<?
							if($node->getNode()->hasChildren())
							{
								$areas = $node->getNode()->getChildren();
								foreach ($areas as $area) {
							?>
										
											<tr>
												<th style="padding-left:50px;">
												<input id="be_benu<?=$area->id;?>" name="grupo_m_backend_menu[]" value="<?=$area->id;?>" type="checkbox" <?= $this->form_validation->set_checkbox('grupo_m_backend_menu[]', $area->id); ?>>
													<label class="choice" for="be_benu<?=$area->id;?>"><?=$area->backend_menu_field_desc;?></label>
												</th>
												<th></th>
												<th style="text-align:center;"><?=lang('ingresar');?></th>
												<th><?=lang('modificar');?></th>
												<th><?=lang('eliminar');?></th>
												<th><?=lang('administrar');?></th>
											
										
										<?
										if($area->getNode()->hasChildren())
										{
											$secciones = $area->getNode()->getChildren();
											foreach ($secciones as $seccion)
											{
										?>	
											<tbody>
												<tr>
													<td></td>
													<td><input id="be_benu<?=$seccion->id;?>" name="grupo_m_backend_menu[]"  value="<?=$seccion->id;?>" type="checkbox" <?= $this->form_validation->set_checkbox('grupo_m_backend_menu[]', $seccion->id); ?>>
										<label class="choice" for="be_benu<?=$seccion->id;?>"><?=$seccion->backend_menu_field_desc;?></label></td>
													<td class="t-center"><input id="be_benu<?=$seccion->id;?>_add" name="add[]" class="ckeckbox" value="<?=$seccion->id;?>" type="checkbox" <?= $this->form_validation->set_checkbox('add[]', $seccion->id); ?>><label for="be_benu<?=$seccion->id;?>_add">&nbsp;&nbsp;&nbsp;&nbsp;</label></td>
													<td><input id="be_benu<?=$seccion->id;?>_edit" name="edit[]" value="<?=$seccion->id;?>" type="checkbox" <?= $this->form_validation->set_checkbox('edit[]', $seccion->id); ?>><label for="be_benu<?=$seccion->id;?>_edit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></td>
													<td><input id="be_benu<?=$seccion->id;?>_del" name="del[]" value="<?=$seccion->id;?>"  type="checkbox" <?= $this->form_validation->set_checkbox('del[]', $seccion->id); ?>><label for="be_benu<?=$seccion->id;?>_del">&nbsp;</label></td>
													<td><input id="be_benu<?=$seccion->id;?>_admin" name="admin[]" value="<?=$seccion->id;?>"  type="checkbox" <?= $this->form_validation->set_checkbox('admin[]', $seccion->id); ?>><label for="be_benu<?=$seccion->id;?>_admin">&nbsp;</label></td>
												</tr>
											</tbody>
										<?
											}
										}//if($area->getNode()->hasChildren()){
										?>
							<?
								}//foreach ($areas as $area) {
							}//if($node->getNode()->hasChildren())
							?>
						</table>
				

							<?							
						}
					
					}
				}
					?>
								
							</div>
				
			</li>
			</fieldset>
				
			</ul>
			
			
			<?php
				$this->load->view( 'backend/_inc_abm_submit_view' );
			?>
</form>
</div>
</div>
