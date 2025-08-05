<?php
/*
*Archivos de Sistema
*/
require_once('proyecto/ClsProyecto.php');
require_once('proyecto/ClsPoo.php');

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ACERCA DE</title>

<link rel="stylesheet" type="text/css" href="../estilos/CssGeneral.css">
</head>

<body>

<table width="100%" class="EstTablaAcercade" border="0" cellpadding="2" cellspacing="1">
<tr>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td>&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
</tr>
<tr>
  <td align="left">&nbsp;</td>
  <td colspan="3" align="center">
  <span class="EstTablaAcercadeEtiqueta"> <?php echo $SistemaNombre;?></span>
  
 </td>
  <td align="left">&nbsp;</td>
</tr>
<tr>
  <td align="left">&nbsp;</td>
  <td colspan="3" align="center">
  
  <?php
		
		?>
		<?php
		if(!empty($SistemaLogo) and file_exists("imagenes/".$SistemaLogo)){
		?>
			<img src="imagenes/logotipo.png" />
        <?php
		}else{
		?>
	        <img src="imagenes/logotipo.png" />
        <?php	
		}
		?>
        
        
  </td>
  <td align="left">&nbsp;</td>
</tr>
<tr>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td>&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
</tr>
<tr>
  <td width="2%" align="left">&nbsp;</td>
  <td width="30%" align="left"><span class="EstTablaAcercadeEtiqueta">Autor</span></td>
  <td width="1%">:</td>
  <td width="64%" align="left"><?php echo $SistemaAutor;?></td>
  <td width="3%" align="left">&nbsp;</td>
</tr>
<tr>
  <td align="left">&nbsp;</td>
  <td align="left"><span class="EstTablaAcercadeEtiqueta">Contacto</span></td>
  <td>:</td>
  <td align="left"><?php echo $SistemaAutorContacto;?></td>
  <td align="left">&nbsp;</td>
</tr>
<tr>
  <td align="left">&nbsp;</td>
  <td align="left"><span class="EstTablaAcercadeEtiqueta">Email</span></td>
  <td>:</td>
  <td align="left"><?php echo $SistemaAutorEmail;?></td>
  <td align="left">&nbsp;</td>
</tr>
<tr>
  <td align="left">&nbsp;</td>
  <td align="left"><span class="EstTablaAcercadeEtiqueta">Version</span></td>
  <td>:</td>
  <td align="left"><?php echo $SistemaVersion;?></td>
  <td align="left">&nbsp;</td>
</tr>
<tr>
  <td align="left">&nbsp;</td>
  <td align="left"><span class="EstTablaAcercadeEtiqueta">Creado el</span></td>
  <td>:</td>
  <td align="left"><?php echo $SistemaTiempoCreacion;?></td>
  <td align="left">&nbsp;</td>
</tr>
<tr>
  <td align="left">&nbsp;</td>
  <td align="left"><span class="EstTablaAcercadeEtiqueta">Ultima Actualizacion: </span></td>
  <td>:</td>
  <td align="left"><?php echo $SistemaTiempoModificacion;?></td>
  <td align="left">&nbsp;</td>
</tr>
<tr>
  <td colspan="5" align="center">&nbsp;</td>
</tr>
<tr>
  <td colspan="5" align="center"><input type="button" onclick="self.parent.tb_remove();" value="Salir" /></td>
</tr>
<tr>
<td colspan="5" align="center">&nbsp;</td>
</tr>
</table>
</body>
</html>