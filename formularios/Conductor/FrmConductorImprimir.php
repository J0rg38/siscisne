<?php
session_start();
	
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}

require_once('../../proyecto/ClsProyecto.php');

$InsProyecto->Ruta = '../../';

/*
*Configuraciones
*/
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
/*
*Mensajes
*/
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
/*
*Clases Generales
*/
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
/*
*Clases de Conexion
*/
require_once($InsProyecto->MtdRutClases().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
/*
*Funciones
*/
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


$GET_id = $_GET['Id'];

require_once($InsProyecto->MtdRutClases().'ClsConductor.php');
require_once($InsProyecto->MtdRutClases().'ClsConductorActividad.php');
require_once($InsProyecto->MtdRutClases().'ClsVehiculo.php');
require_once($InsProyecto->MtdRutClases().'ClsPropietario.php');

$InsConductor = new ClsConductor();

$InsConductor->ConId = $GET_id;
$InsConductor->MtdObtenerConductor();	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Conductor <?php echo $InsConductor->ConId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">

<link href="css/CssConductorImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsConductorImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 


<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsConductor->ConId)){?> 
FncConductorImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>
	
});
</script>


</head>
<body>


<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">
<?php
		if(!empty($SistemaLogo) and file_exists("../imagenes/".$SistemaLogo)){
		?>
			<img src="../../imagenes/<?php echo $SistemaLogo;?>" width="271" height="92" />
        <?php
		}else{
		?>
	        <img src="../../imagenes/logotipo.png" width="271" />
        <?php	
		}
		?>
        
        </td>
  <td width="50%" align="center" valign="middle"><span class="EstReporteTitulo">FICHA DEL CONDUCTOR</span></td>
  <td width="27%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SisSucNombre'];?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstReporteImprimirTabla">

<tr>
  <td width="49%" valign="top">
  
  <div class="EstReporteCapa">
  <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstReporteImprimirTabla">
    <tr>
      <td colspan="4" align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirCabecera">DATOS DE LA UNIDAD</span></td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">UNIDAD SIGNADA</span></td>
      <td width="30%" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsConductor->VehUnidad; ?></span></td>
      <td width="13%" align="left" valign="top" ><span class="EstReporteImprimirEtiqueta"> TURNO</span></td>
      <td width="32%" align="left" valign="top" ><span class="EstReporteImprimirContenido">
	  
<?php

switch($InsConductor->ConTurno){
				case 1:
?>
DIA
<?php
				break;
				
				case 2:
?>
NOCHE
<?php
				break;
				
				case 3:
?>
PUERTA LIBRE
<?php
				break;


			}
			
?>

</span></td>
      </tr>
    <tr>
      <td width="25%" align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta"> PLACA:</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsConductor->VehPlaca;?></span></td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">MARCA:</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsConductor->VehMarca;?></span></td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">MODELO:</span></td>
      <td align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsConductor->VehModelo;?></span></td>
      <td align="left" valign="top" ><span class="EstReporteImprimirEtiqueta">COLOR:</span></td>
      <td align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsConductor->VehColor;?></span></td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">SOAT:</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsConductor->VehSOATFecha;?></span></td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">REV. TECNICA:</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsConductor->VehRevisionTecnicaFecha;?></span></td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">CREDENCIAL:</span></td>
      <td align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsConductor->ConCredencialTaxi;?></span></td>
      <td align="left" valign="top" ><span class="EstReporteImprimirEtiqueta">MM:</span></td>
      <td align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsConductor->VehCodigoMunicipal;?></span></td>
      </tr>
    </table>
    
    </div>
    </td>
  <td width="49%" valign="top">
  
    <div class="EstReporteCapa">
  <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstReporteImprimirTabla">
    <tr>
      <td colspan="4" align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirCabecera">DATOS DEL CONDUCTOR</span></td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">CODIGO DE CONDUCTOR:</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsConductor->ConOtroCodigo;?></span></td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">NRO. DOCUMENTO:</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsConductor->ConNumeroDocumento; ?></span></td>
      </tr>
    <tr>
      <td width="34%" align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta"> NOMBRE:</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsConductor->ConNombre;?></span></td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">APELLIDOS:</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsConductor->ConApellido;?></span></td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">DIRECCION:</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsConductor->ConDireccion;?></span></td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">TELEFONO:</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsConductor->ConTelefono;?></span></td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">CELULAR:</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsConductor->ConCelular;?></span></td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">BREVETE CATG:</span></td>
      <td width="18%" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsConductor->ConNumeroBrevete;?></span></td>
      <td width="27%" align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">VENCIMIENTO:</span></td>
      <td width="21%" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsConductor->ConBreveteFechaExpiracion;?></span></td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">CONDICION:</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsConductor->ASucNombre;?></span></td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">HISTORIAL:</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsConductor->ASucNombre;?></span></td>
      </tr>
    </table>
    </div>
    </td>
    <td width="2%" valign="top">&nbsp;</td>
  </tr>
  

<tr>
    <td colspan="7">
    
      <div class="EstReporteCapa">
      
    <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstReporteImprimirTabla">
      <tr>
        <td colspan="2" align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirCabecera">DATOS DEL PROPIETARIO</span></td>
      </tr>
      <tr>
        <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">NOMBRES Y APELLIDOS:</span></td>
        <td align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsConductor->ProNombre;?> <?php echo $InsConductor->ProApellido;?></span></td>
        </tr>
      <tr>
        <td width="15%" align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">DIRECCION:</span></td>
        <td width="85%" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsConductor->ProDireccion;?></span></td>
        </tr>
      <tr>
        <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">TELEFONO:</span></td>
        <td align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsConductor->ProTelefono;?></span></td>
        </tr>
      </table>
      </div>
      
    </td>
</tr>
</table>

</body>
</html>
