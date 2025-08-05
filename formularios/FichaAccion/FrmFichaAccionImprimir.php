<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$GET_id = $_GET['Id'];

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionDetalle.php');

$InsFichaAccion = new ClsFichaAccion();

$InsFichaAccion->FccId = $GET_id;
$InsFichaAccion = $InsFichaAccion->MtdObtenerFichaAccion();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orden de Trabajo No. <?php echo $InsFichaAccion->FccId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssFichaAccion.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsFichaAccionImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsFichaAccion->FccId)){?> 
FncFichaAccionImprimir(); 
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
  <td colspan="3" align="left" valign="top"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
  </tr>
<tr>
  <td width="22%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" /></td>
  <td width="57%" align="center" valign="top"><span class="EstReporteTitulo">FICHA DE ACCION</span></td>
  <td width="21%" align="right" valign="top">
    <span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstReporteImprimirTabla">

<tr>
    <td valign="top">
    
    <div class="EstReporteImprimirCapa">
    

    <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstReporteImprimirTabla">
    <tbody class="EstReporteImprimirTablaBody">
    <tr>
      <td colspan="4" align="left" valign="top"><span class="EstReporteImprimirCabecera">DATOS DEL FICHA DE ACCION</span></td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="10%" align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">Codigo:</span></td>
      <td width="40%" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsFichaAccion->FccId;?></span></td>
      <td width="10%" align="left" valign="top" class="EstReporteImprimirEtiquetaFondo" ><span class="EstReporteImprimirEtiqueta">No. de O/T:</span></td>
      <td width="38%" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsFichaAccion->FinId;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">Fecha de Pedido:</span></td>
      <td align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsFichaAccion->FccFecha;?></span></td>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">Estado:</span></td>
      <td align="left" valign="top" ><span class="EstReporteImprimirContenido">
        <?php
		switch($InsFichaAccion->FccEstado){
			case 1:
	?>
        Pendiente
  <?php
			break;
			case 2:
	?>
        Atendido
  <?php
			break;	
			case 3:
	?>
        Realizado
  <?php
			break;
		}
	?>
      </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">Observacion:</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo stripslashes($InsFichaAccion->FccObservacion);?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </tbody>
    </table>

	</div>
        
    </td>
  </tr>
  
<tr>
  <td colspan="5" valign="top">
    <div class="EstReporteImprimirCapa">
      <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstReporteImprimirTabla">
        <tbody class="EstReporteImprimirTablaBody">
          <tr>
            <td>
              
              <span class="EstReporteImprimirCabecera">ELEMENTOS DEL FICHA DE ACCION</span>
              </td>
            </tr>
          <tr>
            <td>
              
              
              <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstReporteImprimirTabla">
                <thead class="EstReporteImprimirTablaHead">
                  <tr>
                    <th width="2%" align="center" >#</th>
                    <th width="8%" align="center" > Id</th>
                    <th width="90%" align="center" >Producto</th>
                    </tr>
                  </thead>
                <tbody class="EstReporteImprimirTablaBody">
                  <?php

	$i=1;
	if(is_array($InsFichaAccion->FichaAccionDetalle)){
		
		foreach($InsFichaAccion->FichaAccionDetalle as $DatFichaAccionDetalle){

?>
                  <tr>
                    <td align="right" class="EstReporteDetalleImprimirContenido"><?php echo $i;?></td>
                    <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatFichaAccionDetalle->FidId;?></td>
                    <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatFichaAccionDetalle->PmtNombre;?></td>
                    </tr>
                  <?php	
		
	
		$i++;
		}
		
		
	} 
	
	
	
	
	
?>
                  </tbody>
                </table>
              
              
              </td>
            </tr>
          </tbody>
        </table>
  </div>
    </td>
</tr>
<tr>
  <td colspan="5" valign="top">&nbsp;</td>
</tr>
</table>

</body>
</html>
