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
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');

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

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoManoObra.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoHerramienta.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoSuministro.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoMantenimiento.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTempario.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSuministro.php');


//require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalida.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');


$InsFichaIngreso = new ClsFichaIngreso();

$InsFichaIngreso->FinId = $GET_id;
$InsFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngreso();

//deb($InsFichaIngreso);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orden de Trabajo No. <?php echo $InsFichaIngreso->FinId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssFichaIngreso.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsFichaIngresoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsFichaIngreso->FinId)){?> 
FncFichaIngresoImprimir(); 
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
  <td colspan="3" align="left" valign="top"><span class="EstFichaIngresoCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
  </tr>
<tr>
  <td width="22%" align="left" valign="top"> <img src="../../imagenes/logos/logo_impresion.png" width="150" title="Logo" alt="Logo" border="0" /></td>
  <td width="57%" align="center" valign="top">
  
  <span class="EstPlantillaTitulo">INVENTARIO</span><br />
  
  <span class="EstPlantillaTituloCodigo">
  <?php echo $InsFichaIngreso->FinId;?></span>
  
  
  </td>
  <td width="21%" align="right" valign="top">
    <span class="EstPlantillaoDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    
    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstPlantillaLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstFichaIngresoImprimirTabla">

<tr>
    <td width="75%" valign="top">
      
      <div class="EstFichaIngresoImprimirCapa">
        
        
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstFichaIngresoImprimirTabla">
          <tbody class="EstFichaIngresoImprimirTablaBody">
            <tr>
              <td width="14%" align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo" ><span class="EstFichaIngresoImprimirEtiqueta">Asesor</span></td>
              <td width="2%" align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
              <td colspan="5" align="left" valign="top" ><span class="EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->PerNombreAsesor;?> <?php echo $InsFichaIngreso->PerApellidoPaternoAsesor;?> <?php echo $InsFichaIngreso->PerApellidoMaternoAsesor;?> (<?php echo $InsFichaIngreso->PerCelularAsesor;?>)</span></td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo"><span class="EstFichaIngresoImprimirEtiqueta">Cliente</span></td>
              <td align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
              <td colspan="5" align="left" valign="top" ><span class="EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->CliNombre;?> <?php echo $InsFichaIngreso->CliApellidoPaterno;?> <?php echo $InsFichaIngreso->CliApellidoMaterno;?></span></td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo" ><span class="EstFichaIngresoImprimirEtiqueta">Contacto</span></td>
              <td align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
              <td colspan="5" align="left" valign="top" ><span class="EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->FinContacto;?></span></td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo" ><span class="EstFichaIngresoImprimirEtiqueta">Direccion</span></td>
              <td align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
              <td colspan="5" align="left" valign="top" ><span class="EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->FinDireccion;?></span></td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo" ><span class="EstFichaIngresoImprimirEtiqueta">Celular</span></td>
              <td align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
              <td colspan="5" align="left" valign="top" ><span class="EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->FinTelefono;?></span></td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo" ><span class="EstFichaIngresoImprimirEtiqueta">TECNICO</span></td>
              <td align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
              <td colspan="5" align="left" valign="top">
              <span class="EstFichaIngresoImprimirContenido">
              <?php echo ($InsFichaIngreso->PerNombre);?>
                <?php echo ($InsFichaIngreso->PerApellidoPaterno);?>
                <?php echo ($InsFichaIngreso->PerApellidoMaterno);?></span>
                
              </td>
            </tr>
            <tr>
              <td align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo" ><span class="EstFichaIngresoImprimirEtiqueta">Fecha de Cita</span></td>
              <td align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
              <td width="18%" align="left" valign="top"><span class="EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->FinFechaCita;?></span></td>
              <td width="18%" align="left" valign="top"><span class="EstFichaIngresoImprimirEtiqueta">Fecha de Entrega:</span></td>
              <td width="18%" align="left" valign="top"><span class="EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->FinFechaEntrega;?> <?php echo $InsFichaIngreso->FinHoraEntrega;?> </span></td>
              <td width="8%" align="left" valign="top"><span class="EstFichaIngresoImprimirEtiqueta">R:</span></td>
              <td width="22%" align="left" valign="top"><span class="EstFichaIngresoImprimirContenido">-</span></td>
            </tr>
          </tbody>
        </table>
        
      </div>
      
    </td>
    <td width="22%" valign="top"><div class="EstFichaIngresoImprimirCapa">
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstFichaIngresoImprimirTabla">
        <tbody class="EstFichaIngresoImprimirTablaBody">
          <tr>
            <td width="46%" align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo" ><span class="EstFichaIngresoImprimirEtiqueta">No. de O/T:</span></td>
            <td width="6%" align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
            <td width="48%" align="left" valign="top" ><span class="EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->FinId;?></span></td>
            </tr>
          <tr>
            <td align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo"><span class="EstFichaIngresoImprimirEtiqueta">Fecha de O/T:</span></td>
            <td align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
            <td align="left" valign="top" ><span class="EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->FinFecha;?> <?php echo $InsFichaIngreso->FinHora;?></span></td>
            </tr>
          <tr>
            <td align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo" ><span class="EstFichaIngresoImprimirEtiqueta">No. de Chasis:</span></td>
            <td align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
            <td align="left" valign="top" ><span class="EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->EinVIN;?></span></td>
            </tr>
          <tr>
            <td align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo" ><span class="EstFichaIngresoImprimirEtiqueta">No. de Placa:</span></td>
            <td align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
            <td align="left" valign="top" ><span class="EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->EinPlaca;?></span></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo" ><span class="EstFichaIngresoImprimirEtiqueta">Kilometraje:</span></td>
            <td align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
            <td align="left" valign="top" ><span class="EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->FinVehiculoKilometraje;?></span></td>
          </tr>
          </tbody>
        </table>
    </div></td>
  </tr>
  

<tr>
  <td colspan="6" valign="top"><div class="EstFichaIngresoImprimirCapa">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstFichaIngresoImprimirTabla">
      <tbody class="EstFichaIngresoImprimirTablaBody">
        <tr>
          <td width="10%" align="left" valign="top" class="EstFichaIngresoImprimirEtiquetaFondo" ><span class="EstFichaIngresoImprimirEtiqueta">Modelo/Año:</span></td>
          <td width="3%" align="left" valign="top" ><span class="EstFichaIngresoImprimirEtiqueta">:</span></td>
          <td width="87%" align="left" valign="top" ><h2><span class="2EstFichaIngresoImprimirContenido"><?php echo $InsFichaIngreso->VmaNombre;?>/ <?php echo $InsFichaIngreso->VmoNombre;?>/ <?php echo $InsFichaIngreso->VveNombre;?>/ <?php echo $InsFichaIngreso->EinAnoFabricacion;?>/ <?php echo $InsFichaIngreso->EinColor;?></span></h2></td>
          </tr>
        </tbody>
      </table>
    </div></td>
</tr>
<tr>
  <td colspan="6" valign="top"><div class="EstFichaIngresoImprimirCapa">
    
    
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstInventarioImprimirTabla">
      <tbody class="EstInventarioImprimirTablaBody">
        <tr>
          <td colspan="11" align="left" valign="top"><span class="EstInventarioImprimirTitulo">INVENTARIO DE INGRESO</span></td>
          </tr>
        <tr>
          <td colspan="5" align="left" valign="top" class="EstInventarioImprimirSubTitulo" >EXTERIORES</td>
          <td width="14" rowspan="20" align="left" valign="top">&nbsp;</td>
          <td colspan="5" align="left" valign="top" class="EstInventarioImprimirSubTitulo">INTERIORES</td>
          </tr>
        <tr>
          <td colspan="5" align="left" valign="top" >&nbsp;</td>
          <td colspan="5" align="left" valign="top">&nbsp;</td>
          </tr>
        <tr>
          <td colspan="2" align="left" valign="top"  ><span class="EstInventarioImprimirSubTitulo2">Lado Delantero</span></td>
          <td width="19" rowspan="18" align="left" valign="top"  >&nbsp;</td>
          <td colspan="2" align="left" valign="top"  ><span class="EstInventarioImprimirSubTitulo2">Lado Derecho</span></td>
          <td width="297" align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Llave de Contacto:</span></td>
          <td width="81" align="center" valign="top" ><input  name="CmpInterior1" type="text" class="EstInventarioImprimirCaja" id="CmpInterior1" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td width="31" rowspan="14" align="left" valign="top">&nbsp;</td>
          <td width="283" align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Cenicero:</span></td>
          <td width="105" align="center" valign="top" ><input  name="CmpInterior15" type="text" class="EstInventarioImprimirCaja" id="CmpInterior15" value="" size="5" maxlength="1" readonly="readonly" /></td>
          </tr>
        <tr>
          <td width="182" align="left" valign="top" >
            
            <span class="EstInventarioImprimirEtiqueta"> Parachoque:</span>
            </td>
          <td width="63" align="center" valign="top" ><input  name="CmpExteriorDelantero1" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorDelantero1" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td width="226" align="left" valign="top" >
            <span class="EstInventarioImprimirEtiqueta">Gdfgo  Posterior:</span>
            </td>
          <td width="78" align="center" valign="top" ><input  name="CmpExteriorDerecho1" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorDerecho1" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" >
            <span class="EstInventarioImprimirEtiqueta">Lunas Electricas:</span>
            </td>
          <td align="center" valign="top" ><input  name="CmpInterior2" type="text" class="EstInventarioImprimirCaja" id="CmpInterior2" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" > <span class="EstInventarioImprimirEtiqueta">Manual:</span></td>
          <td align="center" valign="top" ><input  name="CmpInterior16" type="text" class="EstInventarioImprimirCaja" id="CmpInterior16" value="" size="5" maxlength="1" readonly="readonly" /></td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Neblineros:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorDelantero2" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorDelantero2" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Tapa de Combustible:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorDerecho2" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorDerecho2" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Asiento (tela, cuero):</span></td>
          <td align="center" valign="top" ><input  name="CmpInterior3" type="text" class="EstInventarioImprimirCaja" id="CmpInterior3" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Antena:</span></td>
          <td align="center" valign="top" ><input  name="CmpInterior17" type="text" class="EstInventarioImprimirCaja" id="CmpInterior17" value="" size="5" maxlength="1" readonly="readonly" /></td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Faros:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorDelantero3" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorDelantero3" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Aros:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorDerecho3" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorDerecho3" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Asiento Piloto:</span></td>
          <td align="center" valign="top" ><input  name="CmpInterior4" type="text" class="EstInventarioImprimirCaja" id="CmpInterior4" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Copas de Aros / Vasos:</span></td>
          <td align="center" valign="top" ><input  name="CmpInterior18" type="text" class="EstInventarioImprimirCaja" id="CmpInterior18" value="" size="5" maxlength="1" readonly="readonly" /></td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Plumillas:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorDelantero4" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorDelantero4" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Puerta Posterior:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorDerecho4" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorDerecho4" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Controles de Tim&oacute;n:</span></td>
          <td align="center" valign="top" ><input  name="CmpInterior5" type="text" class="EstInventarioImprimirCaja" id="CmpInterior5" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Airbags:</span></td>
          <td align="center" valign="top" ><input  name="CmpInterior19" type="text" class="EstInventarioImprimirCaja" id="CmpInterior19" value="" size="5" maxlength="1" readonly="readonly" /></td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Parabrisas:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorDelantero5" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorDelantero5" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Puerta Delantera:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorDerecho5" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorDerecho5" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Perilla de Palanca:</span></td>
          <td align="center" valign="top" ><input  name="CmpInterior6" type="text" class="EstInventarioImprimirCaja" id="CmpInterior6" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Seguro Cromado Rueda:</span></td>
          <td align="center" valign="top" ><input  name="CmpInterior20" type="text" class="EstInventarioImprimirCaja" id="CmpInterior20" value="" size="5" maxlength="1" readonly="readonly" /></td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Emble:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorDelantero6" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorDelantero6" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Espejo Lateral:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorDerecho6" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorDerecho6" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Radio (Cass/CD/MP/A/C):</span></td>
          <td align="center" valign="top" ><input  name="CmpInterior7" type="text" class="EstInventarioImprimirCaja" id="CmpInterior7" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Gancho de remolque:</span></td>
          <td align="center" valign="top" ><input  name="CmpInterior21" type="text" class="EstInventarioImprimirCaja" id="CmpInterior21" value="" size="5" maxlength="1" readonly="readonly" /></td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Bicel/Mascara:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorDelantero7" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorDelantero7" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Gdfgo  Delantero:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorDerecho7" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorDerecho7" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">A/C:</span></td>
          <td align="center" valign="top" ><input  name="CmpInterior8" type="text" class="EstInventarioImprimirCaja" id="CmpInterior8" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Estuche de Herram.:</span></td>
          <td align="center" valign="top" ><input  name="CmpInterior22" type="text" class="EstInventarioImprimirCaja" id="CmpInterior22" value="" size="5" maxlength="1" readonly="readonly" /></td>
          </tr>
        <tr>
          <td align="left" valign="top" >&nbsp;</td>
          <td align="center" valign="top" >&nbsp;</td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Lunas:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorDerecho8" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorDerecho8" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Reloj:</span></td>
          <td align="center" valign="top" ><input  name="CmpInterior9" type="text" class="EstInventarioImprimirCaja" id="CmpInterior9" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Gata llave de rueda Palanca:</span></td>
          <td align="center" valign="top" ><input  name="CmpInterior23" type="text" class="EstInventarioImprimirCaja" id="CmpInterior23" value="" size="5" maxlength="1" readonly="readonly" /></td>
          </tr>
        <tr>
          <td colspan="2" align="left" valign="top"  ><span class="EstInventarioImprimirSubTitulo2">Lado Posterior</span></td>
          <td align="left" valign="top" >&nbsp;</td>
          <td align="center" valign="top" >&nbsp;</td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Espejo Retovisor:</span></td>
          <td align="center" valign="top" ><input  name="CmpInterior10" type="text" class="EstInventarioImprimirCaja" id="CmpInterior10" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Luz de Sal&oacute;n:</span></td>
          <td align="center" valign="top" ><input  name="CmpInterior24" type="text" class="EstInventarioImprimirCaja" id="CmpInterior24" value="" size="5" maxlength="1" readonly="readonly" /></td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Parachoque:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorPosterior1" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorPosterior1" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td colspan="2" align="left" valign="top"  ><span class="EstInventarioImprimirSubTitulo2">Lado Izquierdo</span></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Correas de Seguridad:</span></td>
          <td align="center" valign="top" ><input  name="CmpInterior11" type="text" class="EstInventarioImprimirCaja" id="CmpInterior11" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Triangulo:</span></td>
          <td align="center" valign="top" ><input  name="CmpInterior25" type="text" class="EstInventarioImprimirCaja" id="CmpInterior25" value="" size="5" maxlength="1" readonly="readonly" /></td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Faros:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorPosterior2" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorPosterior2" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Gdfgo Posterior:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorIzquierdo1" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorIzquierdo1" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Tapasoles:</span></td>
          <td align="center" valign="top" ><input  name="CmpInterior12" type="text" class="EstInventarioImprimirCaja" id="CmpInterior12" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Extintor:</span></td>
          <td align="center" valign="top" ><input  name="CmpInterior26" type="text" class="EstInventarioImprimirCaja" id="CmpInterior26" value="" size="5" maxlength="1" readonly="readonly" /></td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Maletera:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorPosterior3" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorPosterior3" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Aros:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorIzquierdo2" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorIzquierdo2" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Sunroof:</span></td>
          <td align="center" valign="top" ><input  name="CmpInterior13" type="text" class="EstInventarioImprimirCaja" id="CmpInterior13" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Cobertor de Maletera:</span></td>
          <td align="center" valign="top" ><input  name="CmpInterior27" type="text" class="EstInventarioImprimirCaja" id="CmpInterior27" value="" size="5" maxlength="1" readonly="readonly" /></td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Plumillas:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorPosterior4" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorPosterior4" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Puerta Posterior:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorIzquierdo3" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorIzquierdo3" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Encendedor:</span></td>
          <td align="center" valign="top" ><input  name="CmpInterior14" type="text" class="EstInventarioImprimirCaja" id="CmpInterior14" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" >&nbsp;</td>
          <td align="center" valign="top">&nbsp;</td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">5ta   Aro:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorPosterior5" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorPosterior5" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Puerta Delantera:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorIzquierdo4" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorIzquierdo4" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td rowspan="4" align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="2">Leyenda:</td>
              </tr>
            <tr>
              <td>1</td>
              <td>Buen Estado</td>
              </tr>
            <tr>
              <td>2</td>
              <td>Pintura Rayada</td>
              </tr>
            <tr>
              <td>3</td>
              <td>Abolladura</td>
              </tr>
            <tr>
              <td>4</td>
              <td>Rotura</td>
              </tr>
            <tr>
              <td>5</td>
              <td>Faltante</td>
              </tr>
            <tr>
              <td>6</td>
              <td>Oxido</td>
              </tr>
            <tr>
              <td>0</td>
              <td>No preseta</td>
              </tr>
            </table></td>
          <td colspan="4" align="right" valign="top"><span class="EstFichaIngresoImprimirEtiquetaFondo">Vista al rededor del vehiculo e inventario:</span></td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Emblema:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorPosterior6" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorPosterior6" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Espejo Lateral:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorIzquierdo5" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorIzquierdo5" value="" size="5" maxlength="1" readonly="readonly" /></td>
          <td colspan="4" rowspan="3" align="right" valign="top"><img src="../../imagenes/orden_trabajo1.png" alt="" height="130" /></td>
          </tr>
        <tr>
          <td colspan="2" rowspan="2" align="left" valign="top" >&nbsp;</td>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Gdfgo Delantero:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorIzquierdo6" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorIzquierdo6" value="" size="5" maxlength="1" readonly="readonly" /></td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstInventarioImprimirEtiqueta">Lunas:</span></td>
          <td align="center" valign="top" ><input  name="CmpExteriorIzquierdo7" type="text" class="EstInventarioImprimirCaja" id="CmpExteriorIzquierdo7" value="" size="5" maxlength="1" readonly="readonly" /></td>
          </tr>
        <tr>
          <td colspan="11" align="left" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td align="left" valign="top"  >DIAGNOSTICO:</td>
          <td colspan="10" align="left" valign="top" class="Observacion" >
            
            <table width="100%"  border="1" cellpadding="0" cellspacing="0" class="EstFichaIngresoImprimirTabla">
              <thead class="EstFichaIngresoImprimirTablaHead">
                <tr>
                  <th width="5%" align="center" >#</th>
                  <th width="95%" align="center" >&nbsp;</th>
                  </tr>
                </thead>
              <tbody class="EstFichaIngresoImprimirTablaBody">
                
                <!--if(!empty($DatFichaIngresoModalidad->FichaIngresoTarea)){
				foreach($DatFichaIngresoModalidad->FichaIngresoTarea as $DatFichaIngresoTarea){
					
					//echo 'InsFichaIngresoTarea'.$DatFichaIngresoTarea->MinSigla.$Identificador;
					
					if(!empty($DatFichaIngresoTarea->MinSigla)){ //AUX
						$_SESSION['InsFichaIngresoTarea'.$DatFichaIngresoTarea->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
						$DatFichaIngresoTarea->FitId,
						NULL,
						$DatFichaIngresoTarea->FitDescripcion,
						NULL,
						NULL,
						$DatFichaIngresoTarea->FitAccion,
						($DatFichaIngresoTarea->FitTiempoCreacion),
						($DatFichaIngresoTarea->FitTiempoModificacion),
						NULL);
						
					}
					
					
				}
			}-->
                
                
                <?php
foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
	$i=1;
	if(!empty($DatFichaIngresoModalidad->FichaIngresoTarea)){
?>
                <?php
		foreach($DatFichaIngresoModalidad->FichaIngresoTarea as $DatFichaIngresoTarea){
			
			//deb($DatFichaIngresoTarea->FatEstado);
		?>
                <?php
        		//if($DatFichaIngresoTarea->FatEstado == 2){
            ?>
                <tr>
                  <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido"><?php echo $i;?>.-</td>
                  <td align="right" valign="top" class="EstFichaIngresoDetalleImprimirContenido" ><?php echo $DatFichaIngresoTarea->FitDescripcion;?></td>
                  </tr>
                <?php
				   $i++;
				//}
         
            ?>
                <?php	
					
		}
		?>
                <?php		
	} 
	
}
?>
                
                </tbody>
              </table>
            
            </td>
          </tr>
        <tr>
          <td align="left" valign="top"  ><span class="EstInventarioImprimirEtiqueta">Observacion:</span></td>
          <td colspan="10" align="left" valign="top" class="Observacion" ><?php echo $InsFichaIngreso->FinObservacion;?></td>
          </tr>
        </tbody>
      </table>
    </div></td>
</tr>

<tr>
	<td colspan="6" valign="top">
  
  <div class="EstFichaIngresoImprimirCapa">
  

<table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstFichaIngresoImprimirTabla">
<tbody class="EstFichaIngresoImprimirTablaBody">
          <tr>
            <td width="46%" align="center" valign="top" >
              
              <p align="center">__________________<br />
                Cliente
                </p>
              </td>
            <td width="6%" align="center" valign="top" >&nbsp;</td>
            <td width="48%" align="center" valign="top" >
              <p align="center">__________________<br />
                Recepcion
              </p></td>
          </tr>
          </tbody>
        </table>


  </div>
  
	</td>
</tr>
</table>

</body>
</html>
