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
<link href="css/CssInformeTecnicoIT200.css" rel="stylesheet" type="text/css" />

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
  <td width="22%" align="left" valign="top">
    <img src="../../imagenes/isuzu.png" />  
  <?php /*
		if(!empty($SistemaLogo) and file_exists("../../imagenes/".$SistemaLogo)){
		?>
    <img src="../../imagenes/<?php echo $SistemaLogo;?>" />
    <?php
		}else{
		?>
    <img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
        
    <?php	
		}*/
		?></td>
  <td width="57%" align="center" valign="top">
  

  <span class="EstPlantillaImprimirEtiqueta">INFORME TECNICO</span><br /></td>
  <td width="21%" align="right" valign="top">
    <span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    
    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstPlantillaLinea">

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstInformeTecnicoImprimirTabla">

<tr>
    <td width="75%" align="left" valign="top">
      
      <div class="EstInformeTecnicoImprimirCapa">
        
        
        <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstInformeTecnicoImprimirTabla">
          <tbody class="EstInformeTecnicoImprimirTablaBody">
            <tr>
              <td width="21%" align="left" valign="top" class="EstInformeTecnicoImprimirEtiquetaFondo" ><span class="EstInformeTecnicoImprimirEtiqueta">1. CODIGO DE FORMATO</span></td>
              <td width="29%" align="left" valign="top" ><span class="EstInformeTecnicoImprimirEtiqueta">2. No. REPORTE</span></td>
              <td colspan="2" align="left" valign="top" ><span class="EstInformeTecnicoImprimirEtiqueta">3. NOMBRE DEL PROPIETARIO</span></td>
              <td width="1%" align="left" valign="top" >&nbsp;</td>
            </tr>
            <tr>
              <td align="center" valign="top" class="EstInformeTecnicoImprimirEtiquetaFondo" ><span class="EstInformeTecnicoImprimirContenido">IT-200</span></td>
              <td align="center" valign="top" ><span class="EstInformeTecnicoImprimirContenido"><?php echo $InsInformeTecnico->IteId;?></span></td>
              <td colspan="2" align="center" valign="top" ><span class="EstInformeTecnicoImprimirContenido"><?php echo $InsInformeTecnico->ItePropietario;?></span></td>
              <td align="left" valign="top" >&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstInformeTecnicoImprimirEtiquetaFondo" ><span class="EstInformeTecnicoImprimirEtiqueta">4. FECHA DE EMISION</span></td>
              <td align="left" valign="top" ><span class="EstInformeTecnicoImprimirEtiqueta">5. FECHA DE VENTA UNIDAD</span></td>
              <td colspan="2" align="left" valign="top" ><span class="EstInformeTecnicoImprimirEtiqueta">6. NRO. DE VIN</span></td>
              <td align="left" valign="top" >&nbsp;</td>
            </tr>
            <tr>
              <td align="center" valign="top" class="EstInformeTecnicoImprimirEtiquetaFondo" ><span class="EstInformeTecnicoImprimirContenido"><?php echo $InsInformeTecnico->IteFecha;?></span></td>
              <td align="center" valign="top" ><span class="EstInformeTecnicoImprimirContenido"><?php echo $InsInformeTecnico->IteFechaVenta;?></span></td>
              <td colspan="2" align="center" valign="top" ><span class="EstInformeTecnicoImprimirContenido"><?php echo $InsInformeTecnico->EinVIN;?></span></td>
              <td align="left" valign="top" >&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" align="left" valign="top" class="EstInformeTecnicoImprimirEtiquetaFondo" ><span class="EstInformeTecnicoImprimirEtiqueta">7. TIPO Y NO. DE MOTOR</span></td>
              <td colspan="2" align="left" valign="top" ><span class="EstInformeTecnicoImprimirEtiqueta">8. TIPO DE TRANSMISION</span></td>
              <td align="left" valign="top" >&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="top" class="EstInformeTecnicoImprimirEtiquetaFondo" ><span class="EstInformeTecnicoImprimirContenido"><?php echo $InsInformeTecnico->IteMotor;?></span></td>
              <td colspan="2" align="center" valign="top" ><span class="EstInformeTecnicoImprimirContenido"><?php echo $InsInformeTecnico->IteTipoTransmision;?></span></td>
              <td align="left" valign="top" >&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstInformeTecnicoImprimirEtiquetaFondo" ><span class="EstInformeTecnicoImprimirEtiqueta">9. Kilometraje</span></td>
              <td align="left" valign="top" ><span class="EstInformeTecnicoImprimirEtiqueta">10. TIPO DE CARROCERIA</span></td>
              <td colspan="2" align="left" valign="top" ><span class="EstInformeTecnicoImprimirEtiqueta">10. CARGA/TARA</span></td>
              <td align="left" valign="top" >&nbsp;</td>
            </tr>
            <tr>
              <td align="center" valign="top" class="EstInformeTecnicoImprimirEtiquetaFondo" ><span class="EstInformeTecnicoImprimirContenido"><?php echo $InsInformeTecnico->FinVehiculoKilometraje;?></span></td>
              <td align="center" valign="top" ><span class="EstInformeTecnicoImprimirContenido"><?php echo $InsInformeTecnico->IteTipoCarroceria;?></span></td>
              <td colspan="2" align="center" valign="top" ><span class="EstInformeTecnicoImprimirContenido"><?php echo $InsInformeTecnico->IteCarga;?></span></td>
              <td align="left" valign="top" >&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstInformeTecnicoImprimirEtiquetaFondo" ><span class="EstInformeTecnicoImprimirEtiqueta">12. CIUDAD</span></td>
              <td align="left" valign="top" ><span class="EstInformeTecnicoImprimirEtiqueta">13. DEPARTAMENTO</span></td>
              <td width="27%" align="left" valign="top" ><span class="EstInformeTecnicoImprimirEtiqueta">14. USO DEL VEHICULO</span></td>
              <td width="22%" align="left" valign="top" class="EstInformeTecnicoImprimirEtiquetaFondo" ><span class="EstInformeTecnicoImprimirEtiqueta">15. ALTITUD: M.S.N.M</span></td>
              <td align="left" valign="top" >&nbsp;</td>
            </tr>
            <tr>
              <td align="center" valign="top" class="EstInformeTecnicoImprimirEtiquetaFondo" ><span class="EstInformeTecnicoImprimirContenido"><?php echo $InsInformeTecnico->IteCiudad;?></span></td>
              <td align="center" valign="top" ><span class="EstInformeTecnicoImprimirContenido"><?php echo $InsInformeTecnico->IteDepartamento;?></span></td>
              <td align="center" valign="top" ><span class="EstInformeTecnicoImprimirContenido"><?php echo $InsInformeTecnico->IteUsoVehiculo;?></span></td>
              <td align="center" valign="top" class="EstInformeTecnicoImprimirEtiquetaFondo" ><span class="EstInformeTecnicoImprimirContenido"><?php echo $InsInformeTecnico->IteAltitud;?></span></td>
              <td align="left" valign="top" >&nbsp;</td>
            </tr>
          </tbody>
        </table>
        
      </div>
      
    </td>
  </tr>
  
<tr>
  <td colspan="5" valign="top">
    <div class="EstInformeTecnicoImprimirCapa">
      <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstInformeTecnicoImprimirTabla">
        <tbody class="EstInformeTecnicoImprimirTablaBody">
          <tr>
            <td colspan="5" align="left" valign="top"><span class="EstInformeTecnicoImprimirEtiqueta">16. SINTOMA</span></td>
            <td width="1%" align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td colspan="5" align="left" valign="top"><span class="EstInformeTecnicoImprimirContenido"><?php echo $InsInformeTecnico->IteCondicion;?></span></td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td width="22%" align="left" valign="top">&nbsp;</td>
            <td width="77%" colspan="4" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td colspan="5" align="left" valign="top"><span class="EstInformeTecnicoImprimirEtiqueta">17. DIAGNOSTICO</span></td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td colspan="5" align="left" valign="top"><span class="EstInformeTecnicoImprimirContenido"><?php echo $InsInformeTecnico->IteCausa;?></span></td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="4" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top"><span class="EstInformeTecnicoImprimirEtiqueta">18. ACCION CORRECTIVA</span></td>
            <td colspan="4" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top"><span class="EstInformeTecnicoImprimirContenido"><?php echo $InsInformeTecnico->IteCausa;?></span></td>
            <td colspan="4" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="4" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top"><span class="EstInformeTecnicoImprimirEtiqueta">19. CONCLUSIONES</span></td>
            <td colspan="4" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top"><span class="EstInformeTecnicoImprimirContenido"><?php echo $InsInformeTecnico->IteCausa;?></span></td>
            <td colspan="4" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="4" align="left" valign="top">&nbsp;</td>
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
