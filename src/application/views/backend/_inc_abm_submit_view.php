<?php

$lasts = $this->session->userdata('last_add_' . $this->router->class );
if(!is_array($lasts))
	$lasts = array();

if(
	($this->router->method == 'add' && $this->backend->_permiso('add') ) OR

	($this->router->method == 'edit' && ($this->backend->_permiso('edit') OR in_array($this->uri->segment(4),$lasts) ))
 )
{
?>
<ul>
	<li class="buttons">
		<div>
			<input id="enviar" name="_submit" class="btTxt submit" value="<?=lang('enviar_form');?>" type="submit">
		</div>
	</li>
</ul>
<?
}
?>
<script type="text/javascript">
jQuery.fn.preventDoubleSubmit = function() {
  jQuery(this).submit(function() {
    if (this.beenSubmitted)
      return false;
    else
      this.beenSubmitted = true;
  });
};

jQuery('form').preventDoubleSubmit();


</script>


