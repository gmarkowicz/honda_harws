<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="content-language" content="en" />
    <meta name="robots" content="noindex, nofollow" />
    <link rel="stylesheet" href="<?=$this->config->item('base_url');?>public/encuesta_tsi/css.css" type="text/css" media="all">
    <script type="text/javascript" src="<?=$this->config->item('base_url');?>public/encuesta_tsi/js.js"></script>
    <title>Encuesta de Satisfacci&oacute;n por el Servicio</title>
</head>
<body>

<form action="<?php echo current_url();?>" method="post" id="form" name="form">
<div class="contenedor">


	<table class="general">
	<tr>
		<td class="top2">&nbsp;</td>
	</tr>
	<?php if ($mostrar_encuesta == true)
        { ?>
	<tr>
		<td>
		<table width="100%">
                <tr>
			<td class="datos"><span class="titulo">Cliente:</span></td>
			<td class="datos2"><?php echo $cliente_sucursal_field_razon_social . ' ' . $cliente_sucursal_field_nombre . ' ' . $cliente_sucursal_field_apellido ?></td>
		</tr>
                <tr>
			<td class="borde" colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td class="datos"><span class="titulo">Concesionario:</span></td>
			<td class="datos2"><?echo $sucursal_field_desc; ?></td>
		</tr>
		<tr>
			<td class="borde" colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td class="datos"><span class="titulo">Fecha de Servicio:</span></td>
			<td class="datos2"><?php echo date('d-m-Y', strtotime($tsi_field_fecha_de_egreso)); ?></td>
		</tr>
		<tr>
			<td class="borde" colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td class="datos"><span class="titulo">N&deg; de Chasis:</span></td>
			<td class="datos2"><?echo $unidad_field_vin; ?></td>
		</tr>
		<tr>
			<td class="borde" colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td class="datos"><span class="titulo">Vehiculo:</span></td>
			<td class="datos2">Honda <?echo $auto_modelo_field_desc . ' ' . $auto_version_field_desc . ' ' . $auto_anio_field_desc; ?></td>
		</tr>
		<tr>
			<td class="borde" colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td class="datos"><span class="titulo">Asesor de servicio</span></td>
			<td class="datos2"><?echo $recepcion_admin_field_nombre . ' ' . $recepcion_admin_field_apellido;?></td>
		</tr>
		<tr>
			<td class="borde" colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td class="datos"><span class="titulo">Nombre del T&eacute;cnico:</span></td>
			<td class="datos2"><?php echo $tecnico_admin_field_nombre . ' ' . $tecnico_admin_field_apellido;?></td>
		</tr>
		<tr>
			<td class="borde" colspan="2">&nbsp;</td>
		</tr>
		</table>
		</td>
	</tr>
	<?php } ?>
	<tr>
            <td>
		<?php if ($encuesta_ingresada == true)
                { ?>

		<div class="ayuda">
			La encuesta que intenta completar ya fue ingresada.
		</div>

		<?php
                }

                if ($mostrar_encuesta == true)
                { ?>

		<div class="ayuda">
			Por favor seleccione la cantidad de estrellas de acuerdo a su opini&oacute;n y/o grado de satisfacci&oacute;n en cada pregunta.
		</div>

		<?php }

		if ($mostrar_gracias == true)
                { ?>

		<div class="ayuda"  style="font-size:15px;">
			Honda Motor de Argentina le agradece mucho el tiempo dedicado a responder esta encuesta.<br />
			Su opini&oacute;n ser&aacute; tomada en cuenta para poder brindarle en el futuro un mejor servicio.
		</div>
                <?php
                }

		if ($show_datos_incorrectos == true)
                { ?>

		<div class="ayuda">
			Datos incorrectos
		</div>

		<?php
                }
                ?>
		</td>
	</tr>
	</table>

	<?php if ($mostrar_encuesta == true)
        { ?>
	<table class="general">
	<tr>
		<td class="turno_previo">&nbsp;</td>
	</tr>
	</table>
	<table class="general">
	<tr class="tr">
		<td colspan="2" class="colsp"><span class="titulo">Solicit&oacute; usted un turno con anticipaci&oacute;n?</span><br />
			<table width="100%">
			<tr>
				<td>
					<label><input type="radio" name="pregunta_1" value="2"> Si</label>
				</td>
			</tr>
			<tr>
				<td>
					<label><input type="radio" name="pregunta_1" value="1"> No</label>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>
	<tr class="tr">
		<td class="descripcion"><span class="titulo">Cu&aacute;l es su nivel de satisfacci&oacute;n con la prontitud y conveniencia del turno otorgado?</span></td>
		<td class="puntos">
			<div id="set_p1" class="set">
					<input type="text" name="pregunta_1a" id="item_p1" value="0"/>
					<a href="#" onclick="javascript:set('p1','1',5);return false"  onmouseover="ilumina('p1','1',5)" onmouseout="desilumina('p1','1',5)" class="item-off" id="p1_v1"></a>
					<a href="#" onclick="javascript:set('p1','2',5);return false"  onmouseover="ilumina('p1','2',5)" onmouseout="desilumina('p1','2',5)" class="item-off" id="p1_v2"></a>
					<a href="#" onclick="javascript:set('p1','3',5);return false"  onmouseover="ilumina('p1','3',5)" onmouseout="desilumina('p1','3',5)" class="item-off" id="p1_v3"></a>
					<a href="#" onclick="javascript:set('p1','4',5);return false"  onmouseover="ilumina('p1','4',5)" onmouseout="desilumina('p1','4',5)" class="item-off" id="p1_v4"></a>
					<a href="#" onclick="javascript:set('p1','5',5);return false"  onmouseover="ilumina('p1','5',5)" onmouseout="desilumina('p1','5',5)" class="item-off" id="p1_v5"></a>
				</div>
		</td>
	</tr>

	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>
	</table>


	<table class="general">
	<tr>
		<td class="llevando_servicio">&nbsp;</td>
	</tr>
	</table>


	<table class="general">
	<tr  class="tr">
		<td colspan="2" class="colsp"><span class="titulo">C&oacute;mo eval&uacute;a al Asesor de Servicio, tomando en cuenta:</span></td>
	</tr>

	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>

	<tr  class="tr">
		<td class="descripcion">a.	Prontitud en el saludo y en realizar la Orden de Servicio</td>
		<td class="puntos">
			<div id="set_p2a" class="set">
					<input type="text" name="pregunta_2a" id="item_p2a" value="0" />
					<a href="#" onclick="javascript:set('p2a','1',5);return false"  onmouseover="ilumina('p2a','1',5)" onmouseout="desilumina('p2a','1',5)" class="item-off" id="p2a_v1"></a>
					<a href="#" onclick="javascript:set('p2a','2',5);return false"  onmouseover="ilumina('p2a','2',5)" onmouseout="desilumina('p2a','2',5)" class="item-off" id="p2a_v2"></a>
					<a href="#" onclick="javascript:set('p2a','3',5);return false"  onmouseover="ilumina('p2a','3',5)" onmouseout="desilumina('p2a','3',5)" class="item-off" id="p2a_v3"></a>
					<a href="#" onclick="javascript:set('p2a','4',5);return false"  onmouseover="ilumina('p2a','4',5)" onmouseout="desilumina('p2a','4',5)" class="item-off" id="p2a_v4"></a>
					<a href="#" onclick="javascript:set('p2a','5',5);return false"  onmouseover="ilumina('p2a','5',5)" onmouseout="desilumina('p2a','5',5)" class="item-off" id="p2a_v5"></a>
				</div>
		</td>
	</tr>

	<tr >
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>

	<tr  class="tr">
		<td class="descripcion">b.	La ayuda brindada</td>
		<td class="puntos">
			<div id="set_p2b" class="set">
					<input type="text" name="pregunta_2b" id="item_p2b" value="0" />
					<a href="#" onclick="javascript:set('p2b','1',5);return false"  onmouseover="ilumina('p2b','1',5)" onmouseout="desilumina('p2b','1',5)" class="item-off" id="p2b_v1"></a>
					<a href="#" onclick="javascript:set('p2b','2',5);return false"  onmouseover="ilumina('p2b','2',5)" onmouseout="desilumina('p2b','2',5)" class="item-off" id="p2b_v2"></a>
					<a href="#" onclick="javascript:set('p2b','3',5);return false"  onmouseover="ilumina('p2b','3',5)" onmouseout="desilumina('p2b','3',5)" class="item-off" id="p2b_v3"></a>
					<a href="#" onclick="javascript:set('p2b','4',5);return false"  onmouseover="ilumina('p2b','4',5)" onmouseout="desilumina('p2b','4',5)" class="item-off" id="p2b_v4"></a>
					<a href="#" onclick="javascript:set('p2b','5',5);return false"  onmouseover="ilumina('p2b','5',5)" onmouseout="desilumina('p2b','5',5)" class="item-off" id="p2b_v5"></a>
				</div>
		</td>
	</tr>

	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>

	<tr  class="tr">
		<td class="descripcion">c.	Comprensi&oacute;n de sus necesidades</td>
		<td class="puntos">
			<div id="set_p2c" class="set">
					<input type="text" name="pregunta_2c" id="item_p2c" value="0" />
					<a href="#" onclick="javascript:set('p2c','1',5);return false"  onmouseover="ilumina('p2c','1',5)" onmouseout="desilumina('p2c','1',5)" class="item-off" id="p2c_v1"></a>
					<a href="#" onclick="javascript:set('p2c','2',5);return false"  onmouseover="ilumina('p2c','2',5)" onmouseout="desilumina('p2c','2',5)" class="item-off" id="p2c_v2"></a>
					<a href="#" onclick="javascript:set('p2c','3',5);return false"  onmouseover="ilumina('p2c','3',5)" onmouseout="desilumina('p2c','3',5)" class="item-off" id="p2c_v3"></a>
					<a href="#" onclick="javascript:set('p2c','4',5);return false"  onmouseover="ilumina('p2c','4',5)" onmouseout="desilumina('p2c','4',5)" class="item-off" id="p2c_v4"></a>
					<a href="#" onclick="javascript:set('p2c','5',5);return false"  onmouseover="ilumina('p2c','5',5)" onmouseout="desilumina('p2c','5',5)" class="item-off" id="p2c_v5"></a>
				</div>
		</td>
	</tr>

	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>

	<tr  class="tr">
		<td class="descripcion">d.	Tiempo que le dedic&oacute; a usted</td>
		<td class="puntos">
			<div id="set_p2d" class="set">
					<input type="text" name="pregunta_2d" id="item_p2d" value="0" />
					<a href="#" onclick="javascript:set('p2d','1',5);return false"  onmouseover="ilumina('p2d','1',5)" onmouseout="desilumina('p2d','1',5)" class="item-off" id="p2d_v1"></a>
					<a href="#" onclick="javascript:set('p2d','2',5);return false"  onmouseover="ilumina('p2d','2',5)" onmouseout="desilumina('p2d','2',5)" class="item-off" id="p2d_v2"></a>
					<a href="#" onclick="javascript:set('p2d','3',5);return false"  onmouseover="ilumina('p2d','3',5)" onmouseout="desilumina('p2d','3',5)" class="item-off" id="p2d_v3"></a>
					<a href="#" onclick="javascript:set('p2d','4',5);return false"  onmouseover="ilumina('p2d','4',5)" onmouseout="desilumina('p2d','4',5)" class="item-off" id="p2d_v4"></a>
					<a href="#" onclick="javascript:set('p2d','5',5);return false"  onmouseover="ilumina('p2d','5',5)" onmouseout="desilumina('p2d','5',5)" class="item-off" id="p2d_v5"></a>
				</div>
		</td>
	</tr>

	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>

	<tr  class="tr">
		<td class="descripcion">e.	Explicaci&oacute;n del costo estimado</td>
		<td class="puntos">
			<div id="set_p2e" class="set">
					<input type="text" name="pregunta_2e" id="item_p2e" value="0" />
					<a href="#" onclick="javascript:set('p2e','1',5);return false"  onmouseover="ilumina('p2e','1',5)" onmouseout="desilumina('p2e','1',5)" class="item-off" id="p2e_v1"></a>
					<a href="#" onclick="javascript:set('p2e','2',5);return false"  onmouseover="ilumina('p2e','2',5)" onmouseout="desilumina('p2e','2',5)" class="item-off" id="p2e_v2"></a>
					<a href="#" onclick="javascript:set('p2e','3',5);return false"  onmouseover="ilumina('p2e','3',5)" onmouseout="desilumina('p2e','3',5)" class="item-off" id="p2e_v3"></a>
					<a href="#" onclick="javascript:set('p2e','4',5);return false"  onmouseover="ilumina('p2e','4',5)" onmouseout="desilumina('p2e','4',5)" class="item-off" id="p2e_v4"></a>
					<a href="#" onclick="javascript:set('p2e','5',5);return false"  onmouseover="ilumina('p2e','5',5)" onmouseout="desilumina('p2e','5',5)" class="item-off" id="p2e_v5"></a>
				</div>
		</td>
	</tr>

	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>
	<tr class="tr">
		<td class="descripcion">f.	Desempe&ntilde;o en general del Asesor de Servicio</td>
		<td class="puntos">
			<div id="set_p2f" class="set">
					<input type="text" name="pregunta_2f" id="item_p2f" value="0" />
					<a href="#" onclick="javascript:set('p2f','1',5);return false"  onmouseover="ilumina('p2f','1',5)" onmouseout="desilumina('p2f','1',5)" class="item-off" id="p2f_v1"></a>
					<a href="#" onclick="javascript:set('p2f','2',5);return false"  onmouseover="ilumina('p2f','2',5)" onmouseout="desilumina('p2f','2',5)" class="item-off" id="p2f_v2"></a>
					<a href="#" onclick="javascript:set('p2f','3',5);return false"  onmouseover="ilumina('p2f','3',5)" onmouseout="desilumina('p2f','3',5)" class="item-off" id="p2f_v3"></a>
					<a href="#" onclick="javascript:set('p2f','4',5);return false"  onmouseover="ilumina('p2f','4',5)" onmouseout="desilumina('p2f','4',5)" class="item-off" id="p2f_v4"></a>
					<a href="#" onclick="javascript:set('p2f','5',5);return false"  onmouseover="ilumina('p2f','5',5)" onmouseout="desilumina('p2f','5',5)" class="item-off" id="p2f_v5"></a>
				</div>
		</td>
	</tr>
	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>

	</table>


	<table class="general">
	<tr>
		<td class="durante_reparacion">&nbsp;</td>
	</tr>
	</table>


	<table class="general">

	<tr class="tr">
		<td colspan="2"  class="colsp"><span class="titulo">C&oacute;mo eval&uacute;a al Servicio Honda en lo siguiente:</span></td>
	</tr>


	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>

	<tr class="tr">
		<td class="descripcion">a.	Tiempo que demoraron en realizar el Servicio / reparaci&oacute;n</td>
		<td class="puntos">
			<div id="set_p3a" class="set">
					<input type="text" name="pregunta_3a" id="item_p3a" value="0" />
					<a href="#" onclick="javascript:set('p3a','1',5);return false"  onmouseover="ilumina('p3a','1',5)" onmouseout="desilumina('p3a','1',5)" class="item-off" id="p3a_v1"></a>
					<a href="#" onclick="javascript:set('p3a','2',5);return false"  onmouseover="ilumina('p3a','2',5)" onmouseout="desilumina('p3a','2',5)" class="item-off" id="p3a_v2"></a>
					<a href="#" onclick="javascript:set('p3a','3',5);return false"  onmouseover="ilumina('p3a','3',5)" onmouseout="desilumina('p3a','3',5)" class="item-off" id="p3a_v3"></a>
					<a href="#" onclick="javascript:set('p3a','4',5);return false"  onmouseover="ilumina('p3a','4',5)" onmouseout="desilumina('p3a','4',5)" class="item-off" id="p3a_v4"></a>
					<a href="#" onclick="javascript:set('p3a','5',5);return false"  onmouseover="ilumina('p3a','5',5)" onmouseout="desilumina('p3a','5',5)" class="item-off" id="p3a_v5"></a>
				</div>
		</td>
	</tr>

	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>

	<tr class="tr">
		<td class="descripcion">b. Disponibilidad de repuestos / partes que se necesitaron para su veh&iacute;culo</td>
		<td class="puntos">
			<div id="set_p3b" class="set">
					<input type="text" name="pregunta_3b" id="item_p3b" value="0" />
					<a href="#" onclick="javascript:set('p3b','1',5);return false"  onmouseover="ilumina('p3b','1',5)" onmouseout="desilumina('p3b','1',5)" class="item-off" id="p3b_v1"></a>
					<a href="#" onclick="javascript:set('p3b','2',5);return false"  onmouseover="ilumina('p3b','2',5)" onmouseout="desilumina('p3b','2',5)" class="item-off" id="p3b_v2"></a>
					<a href="#" onclick="javascript:set('p3b','3',5);return false"  onmouseover="ilumina('p3b','3',5)" onmouseout="desilumina('p3b','3',5)" class="item-off" id="p3b_v3"></a>
					<a href="#" onclick="javascript:set('p3b','4',5);return false"  onmouseover="ilumina('p3b','4',5)" onmouseout="desilumina('p3b','4',5)" class="item-off" id="p3b_v4"></a>
					<a href="#" onclick="javascript:set('p3b','5',5);return false"  onmouseover="ilumina('p3b','5',5)" onmouseout="desilumina('p3b','5',5)" class="item-off" id="p3b_v5"></a>
				</div>
		</td>
	</tr>

	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>

	<tr class="tr">
		<td class="descripcion">c. Limpieza y apariencia del &aacute;rea de recepci&oacute;n / sala de espera para los clientes</td>
		<td class="puntos">
			<div id="set_p3c" class="set">
					<input type="text" name="pregunta_3c" id="item_p3c" value="0" />
					<a href="#" onclick="javascript:set('p3c','1',5);return false"  onmouseover="ilumina('p3c','1',5)" onmouseout="desilumina('p3c','1',5)" class="item-off" id="p3c_v1"></a>
					<a href="#" onclick="javascript:set('p3c','2',5);return false"  onmouseover="ilumina('p3c','2',5)" onmouseout="desilumina('p3c','2',5)" class="item-off" id="p3c_v2"></a>
					<a href="#" onclick="javascript:set('p3c','3',5);return false"  onmouseover="ilumina('p3c','3',5)" onmouseout="desilumina('p3c','3',5)" class="item-off" id="p3c_v3"></a>
					<a href="#" onclick="javascript:set('p3c','4',5);return false"  onmouseover="ilumina('p3c','4',5)" onmouseout="desilumina('p3c','4',5)" class="item-off" id="p3c_v4"></a>
					<a href="#" onclick="javascript:set('p3c','5',5);return false"  onmouseover="ilumina('p3c','5',5)" onmouseout="desilumina('p3c','5',5)" class="item-off" id="p3c_v5"></a>
				</div>
		</td>
	</tr>

	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>

	</table>


	<table class="general">
	<tr>
		<td class="recogiendo_honda">&nbsp;</td>
	</tr>
	</table>


	<table class="general">



	<tr class="tr">
		<td colspan="2"  class="colsp"><span class="titulo">Califique su grado de satisfacci&oacute;n al momento de recoger su veh&iacute;culo, en los siguientes &iacute;tems:</span></td>
	</tr>

	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>

	<tr class="tr">
		<td class="descripcion">a.	El veh&iacute;culo estuvo listo cuando lo prometieron</td>
		<td class="puntos">
			<div id="set_p4a" class="set">
					<input type="text" name="pregunta_4a" id="item_p4a" value="0" />
					<a href="#" onclick="javascript:set('p4a','1',5);return false"  onmouseover="ilumina('p4a','1',5)" onmouseout="desilumina('p4a','1',5)" class="item-off" id="p4a_v1"></a>
					<a href="#" onclick="javascript:set('p4a','2',5);return false"  onmouseover="ilumina('p4a','2',5)" onmouseout="desilumina('p4a','2',5)" class="item-off" id="p4a_v2"></a>
					<a href="#" onclick="javascript:set('p4a','3',5);return false"  onmouseover="ilumina('p4a','3',5)" onmouseout="desilumina('p4a','3',5)" class="item-off" id="p4a_v3"></a>
					<a href="#" onclick="javascript:set('p4a','4',5);return false"  onmouseover="ilumina('p4a','4',5)" onmouseout="desilumina('p4a','4',5)" class="item-off" id="p4a_v4"></a>
					<a href="#" onclick="javascript:set('p4a','5',5);return false"  onmouseover="ilumina('p4a','5',5)" onmouseout="desilumina('p4a','5',5)" class="item-off" id="p4a_v5"></a>
				</div>
		</td>
	</tr>

	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>

	<tr class="tr">
		<td class="descripcion">b.	Hora de su conveniencia para retirar el veh&iacute;culo</td>
		<td class="puntos">
			<div id="set_p4b" class="set">
					<input type="text" name="pregunta_4b" id="item_p4b" value="0" />
					<a href="#" onclick="javascript:set('p4b','1',5);return false"  onmouseover="ilumina('p4b','1',5)" onmouseout="desilumina('p4b','1',5)" class="item-off" id="p4b_v1"></a>
					<a href="#" onclick="javascript:set('p4b','2',5);return false"  onmouseover="ilumina('p4b','2',5)" onmouseout="desilumina('p4b','2',5)" class="item-off" id="p4b_v2"></a>
					<a href="#" onclick="javascript:set('p4b','3',5);return false"  onmouseover="ilumina('p4b','3',5)" onmouseout="desilumina('p4b','3',5)" class="item-off" id="p4b_v3"></a>
					<a href="#" onclick="javascript:set('p4b','4',5);return false"  onmouseover="ilumina('p4b','4',5)" onmouseout="desilumina('p4b','4',5)" class="item-off" id="p4b_v4"></a>
					<a href="#" onclick="javascript:set('p4b','5',5);return false"  onmouseover="ilumina('p4b','5',5)" onmouseout="desilumina('p4b','5',5)" class="item-off" id="p4b_v5"></a>
				</div>
		</td>
	</tr>

	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>

	<tr class="tr">
		<td class="descripcion">c.	Explicaci&oacute;n del trabajo realizado</td>
		<td class="puntos">
			<div id="set_p4c" class="set">
					<input type="text" name="pregunta_4c" id="item_p4c" value="0" />
					<a href="#" onclick="javascript:set('p4c','1',5);return false"  onmouseover="ilumina('p4c','1',5)" onmouseout="desilumina('p4c','1',5)" class="item-off" id="p4c_v1"></a>
					<a href="#" onclick="javascript:set('p4c','2',5);return false"  onmouseover="ilumina('p4c','2',5)" onmouseout="desilumina('p4c','2',5)" class="item-off" id="p4c_v2"></a>
					<a href="#" onclick="javascript:set('p4c','3',5);return false"  onmouseover="ilumina('p4c','3',5)" onmouseout="desilumina('p4c','3',5)" class="item-off" id="p4c_v3"></a>
					<a href="#" onclick="javascript:set('p4c','4',5);return false"  onmouseover="ilumina('p4c','4',5)" onmouseout="desilumina('p4c','4',5)" class="item-off" id="p4c_v4"></a>
					<a href="#" onclick="javascript:set('p4c','5',5);return false"  onmouseover="ilumina('p4c','5',5)" onmouseout="desilumina('p4c','5',5)" class="item-off" id="p4c_v5"></a>
				</div>
		</td>
	</tr>

	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>

	<tr class="tr">
		<td class="descripcion">d.	Explicaci&oacute;n de los costos</td>
		<td class="puntos">
			<div id="set_p4d" class="set">
					<input type="text" name="pregunta_4d" id="item_p4d" value="0" />
					<a href="#" onclick="javascript:set('p4d','1',5);return false"  onmouseover="ilumina('p4d','1',5)" onmouseout="desilumina('p4d','1',5)" class="item-off" id="p4d_v1"></a>
					<a href="#" onclick="javascript:set('p4d','2',5);return false"  onmouseover="ilumina('p4d','2',5)" onmouseout="desilumina('p4d','2',5)" class="item-off" id="p4d_v2"></a>
					<a href="#" onclick="javascript:set('p4d','3',5);return false"  onmouseover="ilumina('p4d','3',5)" onmouseout="desilumina('p4d','3',5)" class="item-off" id="p4d_v3"></a>
					<a href="#" onclick="javascript:set('p4d','4',5);return false"  onmouseover="ilumina('p4d','4',5)" onmouseout="desilumina('p4d','4',5)" class="item-off" id="p4d_v4"></a>
					<a href="#" onclick="javascript:set('p4d','5',5);return false"  onmouseover="ilumina('p4d','5',5)" onmouseout="desilumina('p4d','5',5)" class="item-off" id="p4d_v5"></a>
				</div>
		</td>
	</tr>

	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>

	<tr class="tr">
		<td class="descripcion">e.	Cu&aacute;n razonables fueron los costos</td>
		<td class="puntos">
			<div id="set_p4e" class="set">
					<input type="text" name="pregunta_4e" id="item_p4e" value="0" />
					<a href="#" onclick="javascript:set('p4e','1',5);return false"  onmouseover="ilumina('p4e','1',5)" onmouseout="desilumina('p4e','1',5)" class="item-off" id="p4e_v1"></a>
					<a href="#" onclick="javascript:set('p4e','2',5);return false"  onmouseover="ilumina('p4e','2',5)" onmouseout="desilumina('p4e','2',5)" class="item-off" id="p4e_v2"></a>
					<a href="#" onclick="javascript:set('p4e','3',5);return false"  onmouseover="ilumina('p4e','3',5)" onmouseout="desilumina('p4e','3',5)" class="item-off" id="p4e_v3"></a>
					<a href="#" onclick="javascript:set('p4e','4',5);return false"  onmouseover="ilumina('p4e','4',5)" onmouseout="desilumina('p4e','4',5)" class="item-off" id="p4e_v4"></a>
					<a href="#" onclick="javascript:set('p4e','5',5);return false"  onmouseover="ilumina('p4e','5',5)" onmouseout="desilumina('p4e','5',5)" class="item-off" id="p4e_v5"></a>
				</div>
		</td>
	</tr>

	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>

	</table>


	<table class="general">
	<tr>
		<td class="despues_casa">&nbsp;</td>
	</tr>
	</table>


	<table class="general">





	<tr class="tr">
		<td class="descripcion">Cu&aacute;n satisfecho est&aacute; con la calidad del trabajo realizado?</td>
		<td class="puntos">
			<div id="set_p5" class="set">
					<input type="text" name="pregunta_5" id="item_p5" value="0" />
					<a href="#" onclick="javascript:set('p5','1',5);return false"  onmouseover="ilumina('p5','1',5)" onmouseout="desilumina('p5','1',5)" class="item-off" id="p5_v1"></a>
					<a href="#" onclick="javascript:set('p5','2',5);return false"  onmouseover="ilumina('p5','2',5)" onmouseout="desilumina('p5','2',5)" class="item-off" id="p5_v2"></a>
					<a href="#" onclick="javascript:set('p5','3',5);return false"  onmouseover="ilumina('p5','3',5)" onmouseout="desilumina('p5','3',5)" class="item-off" id="p5_v3"></a>
					<a href="#" onclick="javascript:set('p5','4',5);return false"  onmouseover="ilumina('p5','4',5)" onmouseout="desilumina('p5','4',5)" class="item-off" id="p5_v4"></a>
					<a href="#" onclick="javascript:set('p5','5',5);return false"  onmouseover="ilumina('p5','5',5)" onmouseout="desilumina('p5','5',5)" class="item-off" id="p5_v5"></a>
				</div>
		</td>
	</tr>

	</table>


	<table class="general">

	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>

	<tr class="tr">
		<td colspan="2"  class="colsp"><span class="titulo">Queda satisfecho con la reparaci&oacute;n que le realizaron en la primer visita?</span><br />

			<table width="100%">
			<tr>
				<td>
					<label><input onclick="javascript:displayOpciones(6,'none')" type="radio" name="pregunta_6" value="2"> Si</label>
				</td>
			</tr>
			<tr>
				<td>
                                    <label><input onclick="javascript:displayOpciones(6,'inline')" type="radio" name="pregunta_6" value="1"> No</label>
				</td>
			</tr>
			</table>
		</td>
	</tr>
            <tr>
                <td id="opciones_6" style="display:none">
                    <table>



                            <tr>
                                    <td class="borde" colspan="2">&nbsp;</td>
                            </tr>

                            <tr>
                                    <td colspan="2"  class="colsp"><span class="titulo">Cu&aacute;ntas visitas adicionales fueron necesarias?</span></td>
                            </tr>

                            <tr  class="tr">
                                    <td class="descripcion">
                                            <table width="100%">
                                            <tr>
                                                    <td width="50%">
                                                            <label><input type="radio" name="pregunta_6a" value="1" {if $PREGUNTA_6A1=='1'}checked{/if}>Una (1)</label>
                                                    </td>
                                                    <td width="50%">
                                                            <label><input type="radio" name="pregunta_6a" value="4" {if $PREGUNTA_6A4=='1'}checked{/if}>Cuatro (4)</label>
                                                    </td>
                                            </tr>
                                            <tr>
                                                    <td width="50%">
                                                            <label><input type="radio" name="pregunta_6a" value="2" {if $PREGUNTA_6A2=='1'}checked{/if}>Dos (2)</label>
                                                    </td>
                                                    <td width="50%">
                                                            <label><input type="radio" name="pregunta_6a" value="5" {if $PREGUNTA_6A5=='1'}checked{/if}>Cinco (5)</label>
                                                    </td>
                                            </tr>
                                            <tr>
                                                    <td width="50%">
                                                            <label><input type="radio" name="pregunta_6a" value="3" {if $PREGUNTA_6A3=='1'}checked{/if}>Tres (3)</label>
                                                    </td>
                                                    <td width="50%">
                                                            <label><input type="radio" name="pregunta_6a" value="6" {if $PREGUNTA_6A6=='1'}checked{/if}>Seis (6) o m&aacute;s</label>
                                                    </td>
                                            </tr>
                                            </table>
                                    </td>
                                    <td class="puntos">&nbsp;</td>
                            </tr>

                            <tr>
                                    <td class="borde" colspan="2">&nbsp;</td>
                            </tr>

                            <tr class="tr">
                                    <td colspan="2"  class="colsp"><span class="titulo">Por qu&eacute: fue necesario que usted volviera al Servicio?</span></td>
                            </tr>



                            <tr class="tr">
                                    <td class="descripcion">
                                            <table width="100%">
                                            <tr>
                                                    <td><label><input type="radio" name="pregunta_6b" value="1">a.	Repuestos / partes no disponibles</label></td>
                                            </tr>
                                            <tr>
                                                    <td><label><input type="radio" name="pregunta_6b" value="2">b.	El Servicio no encontr&oacute; el problema</label></td>
                                            </tr>
                                            <tr>
                                                    <td><label><input type="radio" name="pregunta_6b" value="3">c.	Intentaron repararlo pero no pudieron solucionar el problema</label></td>
                                            </tr>
                                            <tr>
                                                    <td><label><input type="radio" name="pregunta_6b" value="4">d.	Otro (Por favor especifique)</label></td>
                                            </tr>
                                            <tr>
                                                    <td>Por favor especifique<br /><textarea name="pregunta_6b4_otra"></textarea></td>
                                            </tr>
                                            </table>
                                    </td>
                                    <td class="puntos">&nbsp;</td>


                    </table>
                </td>
            </tr>


	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>

	</table>


	<table class="general">
	<tr>
		<td class="sumario">&nbsp;</td>
	</tr>
	</table>


	<table class="general">

	<tr class="tr">
		<td colspan="2"  class="colsp"><span class="titulo">Qu&eacute; calificaci&oacute;n general le otorga al Servicio Honda en las siguientes &aacute;reas?:</span></td>
	</tr>

	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>

	<tr class="tr">
		<td class="descripcion">a. Desempe&ntilde;o en la reparaci&oacute;n</td>
		<td class="puntos">
			<div id="set_p7a" class="set">
					<input type="text" name="pregunta_7a" id="item_p7a" value="0" />
					<a href="#" onclick="javascript:set('p7a','1',5);return false"  onmouseover="ilumina('p7a','1',5)" onmouseout="desilumina('p7a','1',5)" class="item-off" id="p7a_v1"></a>
					<a href="#" onclick="javascript:set('p7a','2',5);return false"  onmouseover="ilumina('p7a','2',5)" onmouseout="desilumina('p7a','2',5)" class="item-off" id="p7a_v2"></a>
					<a href="#" onclick="javascript:set('p7a','3',5);return false"  onmouseover="ilumina('p7a','3',5)" onmouseout="desilumina('p7a','3',5)" class="item-off" id="p7a_v3"></a>
					<a href="#" onclick="javascript:set('p7a','4',5);return false"  onmouseover="ilumina('p7a','4',5)" onmouseout="desilumina('p7a','4',5)" class="item-off" id="p7a_v4"></a>
					<a href="#" onclick="javascript:set('p7a','5',5);return false"  onmouseover="ilumina('p7a','5',5)" onmouseout="desilumina('p7a','5',5)" class="item-off" id="p7a_v5"></a>
				</div>
		</td>
	</tr>

	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>

	<tr class="tr">
		<td class="descripcion">b. Amabilidad en el trato al cliente</td>
		<td class="puntos">
			<div id="set_p7b" class="set">
					<input type="text" name="pregunta_7b" id="item_p7b" value="0" />
					<a href="#" onclick="javascript:set('p7b','1',5);return false"  onmouseover="ilumina('p7b','1',5)" onmouseout="desilumina('p7b','1',5)" class="item-off" id="p7b_v1"></a>
					<a href="#" onclick="javascript:set('p7b','2',5);return false"  onmouseover="ilumina('p7b','2',5)" onmouseout="desilumina('p7b','2',5)" class="item-off" id="p7b_v2"></a>
					<a href="#" onclick="javascript:set('p7b','3',5);return false"  onmouseover="ilumina('p7b','3',5)" onmouseout="desilumina('p7b','3',5)" class="item-off" id="p7b_v3"></a>
					<a href="#" onclick="javascript:set('p7b','4',5);return false"  onmouseover="ilumina('p7b','4',5)" onmouseout="desilumina('p7b','4',5)" class="item-off" id="p7b_v4"></a>
					<a href="#" onclick="javascript:set('p7b','5',5);return false"  onmouseover="ilumina('p7b','5',5)" onmouseout="desilumina('p7b','5',5)" class="item-off" id="p7b_v5"></a>
				</div>
		</td>
	</tr>

	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>

	<tr class="tr">
		<td class="descripcion">c. Desempe&ntilde;o en general del departamento de Servicio</td>
		<td class="puntos">
			<div id="set_p7c" class="set">
					<input type="text" name="pregunta_7c" id="item_p7c" value="0" />
					<a href="#" onclick="javascript:set('p7c','1',5);return false"  onmouseover="ilumina('p7c','1',5)" onmouseout="desilumina('p7c','1',5)" class="item-off" id="p7c_v1"></a>
					<a href="#" onclick="javascript:set('p7c','2',5);return false"  onmouseover="ilumina('p7c','2',5)" onmouseout="desilumina('p7c','2',5)" class="item-off" id="p7c_v2"></a>
					<a href="#" onclick="javascript:set('p7c','3',5);return false"  onmouseover="ilumina('p7c','3',5)" onmouseout="desilumina('p7c','3',5)" class="item-off" id="p7c_v3"></a>
					<a href="#" onclick="javascript:set('p7c','4',5);return false"  onmouseover="ilumina('p7c','4',5)" onmouseout="desilumina('p7c','4',5)" class="item-off" id="p7c_v4"></a>
					<a href="#" onclick="javascript:set('p7c','5',5);return false"  onmouseover="ilumina('p7c','5',5)" onmouseout="desilumina('p7c','5',5)" class="item-off" id="p7c_v5"></a>
				</div>
		</td>
	</tr>

	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2"><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p></td>
	</tr>

	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>

	<tr class="tr">
		<td colspan="2"  class="colsp"><span class="titulo">Cu&aacute;n probable ser&aacute; que recomiende el Servicio a sus familiares y amigos?</span></td>
	</tr>



	<tr class="tr">
		<td class="descripcion">
			<table width="100%">
			<tr>
				<td><label><input type="radio" name="pregunta_8" value="4">a.	Muy Probable</label></td>
			</tr>
			<tr>
				<td><label><input type="radio" name="pregunta_8" value="3">b.	Probable</label></td>
			</tr>
			<tr>
				<td><label><input type="radio" name="pregunta_8" value="2">c.	Poco probable</label></td>
			</tr>
			<tr>
				<td><label><input type="radio" name="pregunta_8" value="1">d.	Improbable</label></td>
			</tr>
			</table>
		</td>
		<td class="puntos">&nbsp;</td>

	</tr>

	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>

	<tr class="tr">
		<td colspan="2"  class="colsp"><span class="titulo">Cu&aacute;n probable ser&aacute; que vuelva a comprar otro veh&iacute;culo Honda en el futuro?</span></td>
	</tr>



	<tr class="tr">
		<td class="descripcion">
			<table width="100%">
			<tr>
				<td><label><input type="radio" name="pregunta_9" value="4">a.	Muy Probable</label></td>
			</tr>
			<tr>
				<td><label><input type="radio" name="pregunta_9" value="3">b.	Probable</label></td>
			</tr>
			<tr>
				<td><label><input type="radio" name="pregunta_9" value="2">c.	Poco probable</label></td>
			</tr>
			<tr>
				<td><label><input type="radio" name="pregunta_9" value="1">d.	Improbable</label></td>
			</tr>
			</table>
		</td>
		<td class="puntos">&nbsp;</td>

	</tr>

	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>



	<tr class="tr">
		<td class="descripcion">Cu&aacute;n probable ser&aacute; que vuelva a comprar otro veh&iacute;culo Honda en el futuro?</td>
		<td class="puntos">
			<div id="set_p9" class="set">
					<input type="text" name="pregunta_9" id="item_p9" value="0" />
					<a href="#" onclick="javascript:set('p9','1',4);return false"  onmouseover="ilumina('p9','1',4)" onmouseout="desilumina('p9','1',4)" class="item-off" id="p9_v1"></a>
					<a href="#" onclick="javascript:set('p9','2',4);return false"  onmouseover="ilumina('p9','2',4)" onmouseout="desilumina('p9','2',4)" class="item-off" id="p9_v2"></a>
					<a href="#" onclick="javascript:set('p9','3',4);return false"  onmouseover="ilumina('p9','3',4)" onmouseout="desilumina('p9','3',4)" class="item-off" id="p9_v3"></a>
					<a href="#" onclick="javascript:set('p9','4',4);return false"  onmouseover="ilumina('p9','4',4)" onmouseout="desilumina('p9','4',4)" class="item-off" id="p9_v4"></a>
				</div>
		</td>
	</tr>

	<tr>
		<td class="borde" colspan="2">&nbsp;</td>
	</tr>

	<tr class="tr">
		<td colspan="2"  class="colsp"><span class="titulo">Comentarios:</span><br />
		<textarea name="comentarios"></textarea>
		</td>
	</tr>
	<tr>
		<td colspan="2">
                <?php
                echo form_hidden('tsi', $tsi_id);
                echo form_hidden('token', $token);
                echo form_submit('send','send', 'class="enviar"')
                ?>
		</td>
	</tr>

	</table>
	<?php } ?>


	<table class="general">
	<tr>
		<td class="pie"><div id="pie_texto">&copy; <?php echo date('Y'); ?> Honda Motor de Argentina<br />Todos los derechos reservados</div></td>
	</tr>
	</table>

</div>

</form>

</body>

</html>
