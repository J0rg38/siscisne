<?php
session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta  = '../../';

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



require_once($InsPoo->MtdPaqLogistica().'ClsAprobacionVentaVehiculo.php');


require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

$InsAprobacionVentaVehiculo = new ClsAprobacionVentaVehiculo();
$InsAprobacionVentaVehiculo->AovId = $GET_id;
$InsAprobacionVentaVehiculo->MtdObtenerAprobacionVentaVehiculo();



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Aprobacion de Venta de Vehiculo No. <?php echo $InsAprobacionVentaVehiculo->AovId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssAprobacionVentaVehiculoImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsAprobacionVentaVehiculoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsAprobacionVentaVehiculo->AovId)){?> 
FncAprobacionVentaVehiculoImprimir(); 
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
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="3" align="left" valign="top"><span class="EstPlantillaCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="3" align="left" valign="top"><img src="../../imagenes/membretes/cabecera_simple.png" width="100%"  /></td>
      <td align="right" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="34%" align="left" valign="top">&nbsp;</td>
      <td width="28%" align="center" valign="top">&nbsp;</td>
      <td width="37%" align="right" valign="top"><span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> - 
        <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
      <td width="0%" align="right" valign="top">&nbsp;</td>
    </tr>
    </table>










<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstAprobacionVentaVehiculoImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstAprobacionVentaVehiculoImprimirTabla">
    <tr>
      <td width="3%" align="left" valign="top">&nbsp;</td>
      <td width="94%" colspan="2" align="center" valign="top">
        
        
        <span class="EstPlantillaTitulo">APROBACION DE VENTA DE VEHICULO</span> <br />
        <span class="EstPlantillaTituloCodigo"> <?php echo $InsAprobacionVentaVehiculo->AovId;?></span>
        
        </td>
      <td width="3%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstAprobacionVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstAprobacionVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" > <span class="EstAprobacionVentaVehiculoImprimirTitulo">    Datos Generales: </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstAprobacionVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstAprobacionVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      
      
      <td colspan="2" align="left" valign="top" ><table  class="EstAprobacionVentaVehiculoImprimirTabla" width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="19%" align="left" valign="top"><span class="EstAprobacionVentaVehiculoImprimirEtiqueta">Asesor de Ventas:</span></td>
          <td width="31%" align="left" valign="top"><span class="EstAprobacionVentaVehiculoImprimirContenido"> <?php echo $InsAprobacionVentaVehiculo->PerNombreVendedor;?> <?php echo $InsAprobacionVentaVehiculo->PerApellidoPaternoVendedor;?> <?php echo $InsAprobacionVentaVehiculo->PerApellidoMaternoVendedor;?></span></td>
          <td width="24%" align="left" valign="top"><span class="EstAprobacionVentaVehiculoImprimirEtiqueta">Fecha Aprobación:</span></td>
          <td width="26%" align="left" valign="top"><span class="EstAprobacionVentaVehiculoImprimirContenido"><?php echo $InsAprobacionVentaVehiculo->AovFecha;?></span></td>
          </tr>
        <tr>
          <td align="left" valign="top"><span class="EstAprobacionVentaVehiculoImprimirEtiqueta">Sucursal:</span></td>
          <td align="left" valign="top"><span class="EstAprobacionVentaVehiculoImprimirContenido"><?php echo $InsAprobacionVentaVehiculo->SucNombre;?></span></td>
          <td align="left" valign="top"><span class="EstAprobacionVentaVehiculoImprimirEtiqueta">Ord. Venta Vehiculo:</span></td>
          <td align="left" valign="top"><span class="EstAprobacionVentaVehiculoImprimirContenido"><?php echo $InsAprobacionVentaVehiculo->OvvId;?></span></td>
          </tr>
        <tr>
          <td align="left" valign="top"><span class="EstAprobacionVentaVehiculoImprimirEtiqueta">RUC/DNI:</span></td>
          <td align="left" valign="top"><span class="EstAprobacionVentaVehiculoImprimirContenido"> <?php echo $InsAprobacionVentaVehiculo->TdoNombre;?>: <?php echo $InsAprobacionVentaVehiculo->CliNumeroDocumento;?></span></td>
          <td align="left" valign="top"><span class="EstAprobacionVentaVehiculoImprimirEtiqueta">Nombres:</span></td>
          <td align="left" valign="top"><span class="EstAprobacionVentaVehiculoImprimirContenido"><?php echo $InsAprobacionVentaVehiculo->CliNombre;?> <?php echo $InsAprobacionVentaVehiculo->CliApellidoPaterno;?> <?php echo $InsAprobacionVentaVehiculo->CliApellidoMaterno;?></span></td>
          </tr>
        <tr>
          <td align="left" valign="top"><span class="EstAprobacionVentaVehiculoImprimirEtiqueta">Revisado  por:</span></td>
          <td align="left" valign="top"><!--<span class="EstAprobacionVentaVehiculoImprimirContenido"><?php echo $InsAprobacionVentaVehiculo->CliDireccion;?></span>-->
            <span class="EstAprobacionVentaVehiculoImprimirContenido"> <?php echo $InsAprobacionVentaVehiculo->PerNombre;?> <?php echo $InsAprobacionVentaVehiculo->PerApellidoPaterno;?> <?php echo $InsAprobacionVentaVehiculo->PerApellidoMaterno;?></span></td>
          <td align="left" valign="top" class="EstAprobacionVentaVehiculoImprimirEtiqueta"><span class="EstAsignacionVentaVehiculoImprimirEtiqueta">Estado de solicitud:</span></td>
          <td align="left" valign="top" class="EstAprobacionVentaVehiculoImprimirContenido"><span class="EstAsignacionVentaVehiculoImprimirContenido">
            <?php
		  switch($InsAsignacionVentaVehiculo->AvvAprobacion){
			  case 1:
			 ?>
            Aprobado
  <?php 
			  break;
			  
			  case 2:
			 ?>
            Desaprobado
  <?php 
			  break;
		  }
		  ?>
          </span></td>
          </tr>
        </table></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstAprobacionVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" >
        <span class="EstAprobacionVentaVehiculoImprimirTitulo">    
      Unidad Vehicular Asignada: 
      </span>
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstAprobacionVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="center" valign="top" >
        
        
          
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPlantillaImprimirTabla">
       <thead class="EstPlantillaImprimirTablaHead">
        <tr>
            <th align="center" valign="middle">Caracteristicas</th>
            <th align="center" valign="middle">Valor</th>
          </tr>
       </thead>
        <tbody class="EstPlantillaImprimirTablaBody">
        
          <tr>
            <td align="center" valign="middle">VIN:</td>
            <td align="center" valign="middle"><?php echo $InsAprobacionVentaVehiculo->EinVIN;?></td>
          </tr>
          <tr>
            <td align="center" valign="middle">Modelo:</td>
            <td align="center" valign="middle"><?php echo $InsAprobacionVentaVehiculo->VmaNombre;?> <?php echo $InsAprobacionVentaVehiculo->VmoNombre;?> <?php echo $InsAprobacionVentaVehiculo->VveNombre;?></td>
          </tr>
          <tr>
            <td align="center" valign="middle">Num. Motor:</td>
            <td align="center" valign="middle"><?php echo $InsAprobacionVentaVehiculo->EinNumeroMotor;?></td>
          </tr>
          <tr>
            <td align="center" valign="middle">Color:</td>
            <td align="center" valign="middle"><?php echo $InsAprobacionVentaVehiculo->EinColor;?></td>
          </tr>
          <tr>
            <td align="center" valign="middle">Año Fabricación:</td>
            <td align="center" valign="middle"><?php echo $InsAprobacionVentaVehiculo->EinAnoFabricacion;?></td>
          </tr>
          <tr>
            <td align="center" valign="middle">Año Modelo:</td>
            <td align="center" valign="middle"><?php echo $InsAprobacionVentaVehiculo->EinAnoModelo;?></td>
          </tr>
          <tr>
            <td width="257" align="center" valign="middle">Ubicación:</td>
            <td width="257" align="center" valign="middle">
			<?php echo $InsAprobacionVentaVehiculo->EinUbicacion;?></td>
            </tr>
            </tbody>
          </table>
          
          <br />
        <?php
		
		//deb($InsAprobacionVentaVehiculo->VveId);
		//deb($InsAprobacionVentaVehiculo->VveFoto);
		if(!empty($InsAprobacionVentaVehiculo->VveFoto)){
		?>
        <img src="../../subidos/vehiculo_version_fotos/<?php echo $InsAprobacionVentaVehiculo->VveFoto;?>" width="334" />
        <?php
		}
		?>
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    
    <tr>
      <td align="left" valign="top" class="EstAprobacionVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" >
      
       <span class="EstAprobacionVentaVehiculoImprimirTitulo">    
          <p>
          Observaciones:
          </p>
          </span>
          </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstAprobacionVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" >
        
        <span class="EstAprobacionVentaVehiculoImprimirContenido">    
          <p>
            <?php echo $InsAprobacionVentaVehiculo->AovObservacion;?>
            </p>
          </span>
        
        </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstAprobacionVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  </tr>
  
<tr>
    <td colspan="5">&nbsp;</td>
  </tr>
</table>


<p align="center">
        <span class="EstAprobacionVentaVehiculoImprimirNota2"><!--Urb. Los Cedros Mz. B Lte. 10 Av. Manuel A. Odria Via Panamericana Sur (Costado Grifo Municipal)<br />
        Tel&eacute;fono 51-52 315216 Anexo 210 Fono Fax: 851-52 315207 E-mail: canepa@cyc.com.pe<br />-->
      </span>
</p>

 
 
</body>
</html>
