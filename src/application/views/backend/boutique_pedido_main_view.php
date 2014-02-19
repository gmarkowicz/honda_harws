<div id="tabs">
    <ul>
        <li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
    </ul>
    <div id="tabs-1">
     <?php
        if($this->backend->_permiso('add',ID_SECCION))
        {
            $this->load->view( 'backend/esqueleto_botones_view' );
        }
        ?>
        <script>$(function(){$('#nuevoregistro').hide();});</script>
        <div class="grilla">
                <table id="flex1" style="display:none"></table>
        </div>
    </div>
</div>

