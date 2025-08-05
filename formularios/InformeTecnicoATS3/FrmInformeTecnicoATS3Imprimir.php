<?php
@session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$GET_id = $_GET['Id'];

require_once($InsPoo->MtdPaqActividad().'ClsInformeTecnico.php');
require_once($InsPoo->MtdPaqActividad().'ClsInformeTecnicoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsInformeTecnicoOperacion.php');

$InsInformeTecnico = new ClsInformeTecnico();

$InsInformeTecnico->IteId = $GET_id;
$InsInformeTecnico = $InsInformeTecnico->MtdObtenerInformeTecnico();


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orden de Trabajo No. <?php echo $InsInformeTecnico->IteId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssInformeTecnicoATS3Imprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsInformeTecnicoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsInformeTecnico->IteId)){?> 
FncInformeTecnicoImprimir(); 
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
  <td colspan="3" align="left" valign="top"><span class="EstPlantillaCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
  </tr>
<tr>
  <td width="22%" rowspan="2" align="left" valign="top">
  
   <img src="../../imagenes/chevrolet.png" />
  
  <?php
/*		if(!empty($SistemaLogo) and file_exists("../../imagenes/".$SistemaLogo)){
		?>
    <img src="../../imagenes/<?php echo $SistemaLogo;?>" />
    <?php
		}else{
		?>
    <img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
        
    <?php	
		}*/
		?>    </td>
  <td width="57%" rowspan="2" align="center" valign="top">
    
    
    <span class="EstPlantillaImprimirEtiqueta">REPORTE DE DIAGNOSTICO TECNICO [DTR]</span><br />
    <span class="EstPlantillaTituloCodigo">Utilice un reporte por cada caso</span>  </td>
  <td align="center" valign="top">FORM<br />ATS3</td>
</tr>
<tr>
  <td width="21%" align="right" valign="top">
    <span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    
    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstPlantillaLinea">

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstInformeTecnicoATS3ImprimirTabla">

<tr>
    <td width="75%" align="left" valign="top">
      
      <div class="EstInformeTecnicoATS3ImprimirCapa">
        
        
        <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstInformeTecnicoATS3ImprimirTabla">
          <tbody class="EstInformeTecnicoATS3ImprimirTablaBody">
            <tr>
              <td width="9%" align="left" valign="top" class="EstInformeTecnicoATS3ImprimirEtiquetaFondo" ><span class="EstInformeTecnicoATS3ImprimirEtiqueta">concesionario</span></td>
              <td align="left" valign="top" ><span class="EstInformeTecnicoATS3ImprimirEtiqueta">:</span></td>
              <td width="29%" align="left" valign="top" ><span class="EstInformeTecnicoATS3ImprimirContenido"><?php echo $InsInformeTecnico->IteConcesionario;?></span></td>
              <td width="9%" align="left" valign="top" class="EstInformeTecnicoATS3ImprimirEtiquetaFondo" ><span class="EstInformeTecnicoATS3ImprimirEtiqueta">no. de reporte</span></td>
              <td width="1%" align="left" valign="top" ><span class="EstInformeTecnicoATS3ImprimirEtiqueta">:</span></td>
              <td width="50%" align="left" valign="top" ><span class="EstInformeTecnicoATS3ImprimirContenido"><?php echo $InsInformeTecnico->IteId;?></span></td>
              <td align="left" valign="top" >&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstInformeTecnicoATS3ImprimirEtiquetaFondo"><span class="EstInformeTecnicoATS3ImprimirEtiqueta">sede del local</span></td>
              <td align="left" valign="top" ><span class="EstInformeTecnicoATS3ImprimirEtiqueta">:</span></td>
              <td align="left" valign="top" ><span class="EstInformeTecnicoATS3ImprimirContenido"><?php echo $InsInformeTecnico->IteSedeLocal;?></span></td>
              <td align="left" valign="top" class="EstInformeTecnicoATS3ImprimirEtiquetaFondo"><span class="EstInformeTecnicoATS3ImprimirEtiqueta">Fecha de Emision</span></td>
              <td align="left" valign="top" ><span class="EstInformeTecnicoATS3ImprimirEtiqueta">:</span></td>
              <td align="left" valign="top" ><span class="EstInformeTecnicoATS3ImprimirContenido"><?php echo $InsInformeTecnico->IteFecha;?></span></td>
              <td align="left" valign="top" >&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstInformeTecnicoATS3ImprimirEtiquetaFondo" ><span class="EstInformeTecnicoATS3ImprimirEtiqueta">ContactO DE GM</span></td>
              <td align="left" valign="top" ><span class="EstInformeTecnicoATS3ImprimirEtiqueta">:</span></td>
              <td align="left" valign="top" ><span class="EstInformeTecnicoATS3ImprimirContenido"><?php echo $InsInformeTecnico->IteContactoGM;?></span></td>
              <td align="left" valign="top" class="EstInformeTecnicoATS3ImprimirEtiquetaFondo" ><span class="EstInformeTecnicoATS3ImprimirEtiqueta">Fecha de Venta</span></td>
              <td align="left" valign="top" ><span class="EstInformeTecnicoATS3ImprimirEtiqueta">:</span></td>
              <td align="left" valign="top" ><span class="EstInformeTecnicoATS3ImprimirContenido"><?php echo $InsInformeTecnico->IteFechaVenta;?></span></td>
              <td align="left" valign="top" >&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstInformeTecnicoATS3ImprimirEtiquetaFondo" ><span class="EstInformeTecnicoATS3ImprimirEtiqueta">CODIGO DE VIN</span></td>
              <td align="left" valign="top" ><span class="EstInformeTecnicoATS3ImprimirEtiqueta">:</span></td>
              <td align="left" valign="top" ><span class="EstInformeTecnicoATS3ImprimirContenido"><?php echo $InsInformeTecnico->EinVIN;?></span></td>
              <td align="left" valign="top" class="EstInformeTecnicoATS3ImprimirEtiquetaFondo" ><span class="EstInformeTecnicoATS3ImprimirEtiqueta">Placa o serie</span></td>
              <td align="left" valign="top" ><span class="EstInformeTecnicoATS3ImprimirEtiqueta">:</span></td>
              <td align="left" valign="top" ><span class="EstInformeTecnicoATS3ImprimirContenido"><?php echo $InsInformeTecnico->EinPlaca;?></span></td>
              <td align="left" valign="top" >&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstInformeTecnicoATS3ImprimirEtiquetaFondo" ><span class="EstInformeTecnicoATS3ImprimirEtiqueta">MODELO</span></td>
              <td align="left" valign="top" ><span class="EstInformeTecnicoATS3ImprimirEtiqueta">:</span></td>
              <td align="left" valign="top" ><span class="EstInformeTecnicoATS3ImprimirContenido">
			  
			  <?php echo $InsInformeTecnico->VmaNombre;?>
              <?php echo $InsInformeTecnico->VmoNombre;?>
              <?php echo $InsInformeTecnico->VveNombre;?>
              
              </span></td>
              <td align="left" valign="top" class="EstInformeTecnicoATS3ImprimirEtiquetaFondo" ><span class="EstInformeTecnicoATS3ImprimirEtiqueta">Kilometraje</span></td>
              <td align="left" valign="top" ><span class="EstInformeTecnicoATS3ImprimirEtiqueta">:</span></td>
              <td align="left" valign="top" ><span class="EstInformeTecnicoATS3ImprimirContenido"><?php echo $InsInformeTecnico->FinVehiculoKilometraje;?></span></td>
              <td align="left" valign="top" >&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstInformeTecnicoATS3ImprimirEtiquetaFondo" ><span class="EstInformeTecnicoATS3ImprimirEtiqueta">PROPIETARIO</span></td>
              <td width="1%" align="left" valign="top" ><span class="EstInformeTecnicoATS3ImprimirEtiqueta">:</span></td>
              <td colspan="4" align="left" valign="top" ><span class="EstInformeTecnicoATS3ImprimirContenido"><?php echo $InsInformeTecnico->ItePropietario;?></span></td>
              <td width="1%" align="left" valign="top" >&nbsp;</td>
            </tr>
          </tbody>
        </table>
        
      </div>
      
    </td>
  </tr>
  
<tr>
  <td colspan="5" valign="top">
    <div class="EstInformeTecnicoATS3ImprimirCapa">
      <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstInformeTecnicoATS3ImprimirTabla">
        <tbody class="EstInformeTecnicoATS3ImprimirTablaBody">
          <tr>
            <td colspan="5" align="left" valign="top"><span class="EstInformeTecnicoATS3ImprimirEtiqueta">1. Condición (explicar en que consiste la falla y las condiciones en que se presenta)</span></td>
            <td width="1%" align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td colspan="5" align="left" valign="top"><span class="EstInformeTecnicoATS3ImprimirContenido"><?php echo $InsInformeTecnico->IteCondicion;?></span></td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td width="22%" align="left" valign="top">&nbsp;</td>
            <td colspan="4" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td colspan="5" align="left" valign="top"><span class="EstInformeTecnicoATS3ImprimirEtiqueta">2. Causa (análisis y verificación de causa raiz de la falla)</span></td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td colspan="5" align="left" valign="top"><span class="EstInformeTecnicoATS3ImprimirContenido"><?php echo $InsInformeTecnico->IteCausa;?></span></td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="4" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td colspan="5" align="left" valign="top"><span class="EstInformeTecnicoATS3ImprimirEtiqueta">3. Corrección (explicar que solución es la propuesta para corregir la causa raiz)</span></td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td colspan="5" align="left" valign="top"><span class="EstInformeTecnicoATS3ImprimirContenido"><?php echo $InsInformeTecnico->IteCorreccion;?></span></td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="4" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td colspan="5" align="left" valign="top"><span class="EstInformeTecnicoATS3ImprimirEtiqueta">4. Conclusiones (especificar conclusiones que ayuden a prevenir la falla)</span></td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td colspan="5" align="left" valign="top"><span class="EstInformeTecnicoATS3ImprimirContenido"><?php echo $InsInformeTecnico->IteConclusion;?></span></td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="4" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td align="left" valign="top"><span class="EstInformeTecnicoATS3ImprimirEtiqueta">5. ¿Ha sido la solución satisfactoria?</span></td>
            <td width="3%" align="left" valign="top"><span class="EstInformeTecnicoATS3ImprimirEtiqueta">SI</span></td>
            <td width="5%" align="left" valign="top"><span class="EstInformeTecnicoATS3ImprimirContenido">
			
			<?php echo ($InsInformeTecnico->IteSolucionSatisfactoria==1)?'X':'';?></span>
            </td>
            <td width="4%" align="left" valign="top"><span class="EstInformeTecnicoATS3ImprimirEtiqueta">NO</span></td>
            <td width="65%" align="left" valign="top"><span class="EstInformeTecnicoATS3ImprimirContenido"><?php echo ($InsInformeTecnico->IteSolucionSatisfactoria==2)?'X':'';?></span></td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="4" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td align="left" valign="top"><span class="EstInformeTecnicoATS3ImprimirEtiqueta">EMITIDO POR</span></td>
            <td colspan="4" align="left" valign="top"><span class="EstInformeTecnicoATS3ImprimirContenido"><?php echo $InsInformeTecnico->PerNombre;?> <?php echo $InsInformeTecnico->PerApellidoPaterno;?> <?php echo $InsInformeTecnico->PerApellidoMaterno;?></span></td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td align="left" valign="top"><span class="EstInformeTecnicoATS3ImprimirEtiqueta">CARGO</span></td>
            <td colspan="4" align="left" valign="top"><span class="EstInformeTecnicoATS3ImprimirContenido"><?php echo $InsInformeTecnico->IteCargo;?></span></td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="4" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          </tbody>
        </table>
      </div>
    </td>
</tr>
</table>


</body>
</html>
