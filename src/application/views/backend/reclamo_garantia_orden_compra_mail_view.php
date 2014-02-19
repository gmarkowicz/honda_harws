<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body background="fondo.gif" bgcolor="#252525" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="680" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td><table width="680" height="125" border="0" cellpadding="0" cellspacing="0" background="cabezal.jpg">
      <tr>
        <td valign="top"><table width="680" border="0" cellspacing="0" cellpadding="0">
          
          <tr>
            <td width="630"><div align="right"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Orden de Compra<br /> SAP <br />
              Nº ##ORDEN_COMPRA_SAP##</strong></font></div></td>
            <td width="50">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><div align="center"><img src="separador.gif" width="640" height="17" /></div></td>
  </tr>
  <tr>
  <td>
	<center>
		<table border="0" width="640">
		<tr>
		<td align="left"  bgcolor="#eeeeee">
		<font color="#535353" size="4" face="Arial, Helvetica, sans-serif">Resumen de Aprobación  de Garantías Nº ##ORDEN_COMPRA_NUMERO##
</font>
		</td>
		</tr>
		</table>
	</center>
  </td>
  </tr>
  <tr>
    <td><div align="center"><img src="separador.gif" width="640" height="17" /></div></td>
  </tr>
  <tr>
  <td>
	<center>
		<table border="0" width="640">
		<tr>
		<td align="left">
		<font color="#535353" size="4" face="Arial, Helvetica, sans-serif">Concesionario: <strong>##CONCESIONARIO_NOMBRE##</strong></font>
		</td>
		</tr>
		</table>
	</center>
  </td>
  </tr>
   <tr>
    <td><div align="center"><img src="separador.gif" width="640" height="2" /></div></td>
  </tr>
  <tr>
	<td>
		<center>
		<table border="0" width="640">
		<tr>
			<td  width="100" bgcolor="#535353" align="center">
				<strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">RECLAMO</font></strong>
			</td>
			<td width="100" bgcolor="#535353" align="center">
				<strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">FECHA DE ALTA DE RECLAMO</font></strong>
			</td>
			<td width="100" bgcolor="#535353" colspan="2" align="center">
				<strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">IMPORTE APROBADO</font></strong>
			</td>
			<td width="100" bgcolor="#535353" align="center">
				<strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">FECHA DE APROBACIÓN</font></strong>
			</td>
		</tr>
		##INFORMACION##
		<tr>
			<td bgcolor="#eeeeee" colspan="2"><strong><font size="2" color="#CC0000" face="Arial, Helvetica, sans-serif">TOTAL APROBADO (sin impuestos)</font></strong></td>
			<td bgcolor="#eeeeee" align="right" width="100"><font  color="#CC0000" size="2" face="Arial, Helvetica, sans-serif"><strong>AR$</strong></font></td>
			<td bgcolor="#eeeeee" align="right" width="10"><font   color="#CC0000" size="2" face="Arial, Helvetica, sans-serif"><strong>##IMPORTE_ACEPTADO##</strong></font></td>
			<td bgcolor="#eeeeee">&nbsp;</td>
		</tr>
		</table>
		</center>
	
	</td>
  </tr>
  <tr>
    <td><div align="center"><img src="separador.gif" width="640" height="17" /></div></td>
  </tr>
  <tr>
  <td>
	<center>
		<table border="0" width="640">
		<tr>
		<td align="left">
		<font color="#535353" size="2" face="Arial, Helvetica, sans-serif">
		Estimado Concesionario:<br />
Emita la factura a nombre de Honda Motor de Argentina S.A., CUIT 30-57754677-7, por el Importe $##IMPORTE_ACEPTADO## (sin impuestos), indicando en el cuerpo de la misma:<br /><br />
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td width="100%" bgcolor="#eeeeee"><font color="#535353" size="2" face="Arial, Helvetica, sans-serif">ORDEN DE COMPRA SAP: <strong>##ORDEN_COMPRA_SAP##</strong></font>	</td>
</tr>
</table>
<br />
<p><font color="#CC0000"><strong>Importante!</strong></font> Ambos datos deben coincidir exactamente con la información de este mail. Ante cualquier diferencia la factura NO podrá ser abonada.
 </p>

		</font>
		</td>
		</tr>
		</table>
	</center>
  </td>
  </tr>
  <tr>
    <td><img src="pie.jpg" width="680" height="70" /></td>
  </tr>
</table>
</body>
</html>
