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



require_once($InsPoo->MtdPaqLogistica().'ClsAsignacionVentaVehiculo.php');


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

$InsAsignacionVentaVehiculo = new ClsAsignacionVentaVehiculo();
$InsAsignacionVentaVehiculo->AvvId = $GET_id;
$InsAsignacionVentaVehiculo->MtdObtenerAsignacionVentaVehiculo();



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Asignacion de Vehiculo de Vehiculo No. <?php echo $InsAsignacionVentaVehiculo->AvvId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssAsignacionVentaVehiculoImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsAsignacionVentaVehiculoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsAsignacionVentaVehiculo->AvvId)){?> 
FncAsignacionVentaVehiculoImprimir(); 
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





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstAsignacionVentaVehiculoImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstAsignacionVentaVehiculoImprimirTabla">
    <tr>
      <td width="3%" align="left" valign="top">&nbsp;</td>
      <td width="94%" colspan="2" align="center" valign="top">
        
        
        <span class="EstPlantillaTitulo">ASIGNACION DE VEHICULO</span> <br />
        <span class="EstPlantillaTituloCodigo"> <?php echo $InsAsignacionVentaVehiculo->AvvId;?></span>
        
        </td>
      <td width="3%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstAsignacionVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstAsignacionVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" > <span class="EstAsignacionVentaVehiculoImprimirTitulo">    Datos Generales: </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstAsignacionVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstAsignacionVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      
      
      <td colspan="2" align="left" valign="top" ><table  class="EstAsignacionVentaVehiculoImprimirTabla" width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="19%" align="left" valign="top"><span class="EstAsignacionVentaVehiculoImprimirEtiqueta">Asesor de Ventas:</span></td>
          <td width="31%" align="left" valign="top"><span class="EstAsignacionVentaVehiculoImprimirContenido"> <?php echo $InsAsignacionVentaVehiculo->PerNombreVendedor;?> <?php echo $InsAsignacionVentaVehiculo->PerApellidoPaternoVendedor;?> <?php echo $InsAsignacionVentaVehiculo->PerApellidoMaternoVendedor;?></span></td>
          <td width="24%" align="left" valign="top"><span class="EstAsignacionVentaVehiculoImprimirEtiqueta">Fecha Aprobación:</span></td>
          <td width="26%" align="left" valign="top"><span class="EstAsignacionVentaVehiculoImprimirContenido"><?php echo $InsAsignacionVentaVehiculo->AvvFecha;?></span></td>
          </tr>
        <tr>
          <td align="left" valign="top"><span class="EstAsignacionVentaVehiculoImprimirEtiqueta">Sucursal:</span></td>
          <td align="left" valign="top"><span class="EstAsignacionVentaVehiculoImprimirContenido"><?php echo $InsAsignacionVentaVehiculo->SucNombre;?></span></td>
          <td align="left" valign="top"><span class="EstAsignacionVentaVehiculoImprimirEtiqueta">Ord. Venta Vehiculo:</span></td>
          <td align="left" valign="top"><span class="EstAsignacionVentaVehiculoImprimirContenido"><?php echo $InsAsignacionVentaVehiculo->OvvId;?></span></td>
          </tr>
        <tr>
          <td align="left" valign="top"><span class="EstAsignacionVentaVehiculoImprimirEtiqueta">RUC/DNI:</span></td>
          <td align="left" valign="top"><span class="EstAsignacionVentaVehiculoImprimirContenido"> <?php echo $InsAsignacionVentaVehiculo->TdoNombre;?>: <?php echo $InsAsignacionVentaVehiculo->CliNumeroDocumento;?></span></td>
          <td align="left" valign="top"><span class="EstAsignacionVentaVehiculoImprimirEtiqueta">Nombres:</span></td>
          <td align="left" valign="top"><span class="EstAsignacionVentaVehiculoImprimirContenido"><?php echo $InsAsignacionVentaVehiculo->CliNombre;?> <?php echo $InsAsignacionVentaVehiculo->CliApellidoPaterno;?> <?php echo $InsAsignacionVentaVehiculo->CliApellidoMaterno;?></span></td>
          </tr>
        <tr>
          <td align="left" valign="top"><span class="EstAsignacionVentaVehiculoImprimirEtiqueta">Revisado por:</span></td>
          <td align="left" valign="top"><!--<span class="EstAsignacionVentaVehiculoImprimirContenido"><?php echo $InsAsignacionVentaVehiculo->CliDireccion;?></span>-->
            <span class="EstAsignacionVentaVehiculoImprimirContenido"> <?php echo $InsAsignacionVentaVehiculo->PerNombre;?> <?php echo $InsAsignacionVentaVehiculo->PerApellidoPaterno;?> <?php echo $InsAsignacionVentaVehiculo->PerApellidoMaterno;?></span></td>
          <td align="left" valign="top"><span class="EstAsignacionVentaVehiculoImprimirEtiqueta">Estado de solicitud:</span></td>
          <td align="left" valign="top"><span class="EstAsignacionVentaVehiculoImprimirContenido">
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
      <td align="left" valign="top" class="EstAsignacionVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" >
        <span class="EstAsignacionVentaVehiculoImprimirTitulo">    
      Unidad Vehicular Asignada: 
      </span>
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstAsignacionVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
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
            <td align="center" valign="middle"><?php echo $InsAsignacionVentaVehiculo->EinVIN;?></td>
          </tr>
          <tr>
            <td align="center" valign="middle">Modelo:</td>
            <td align="center" valign="middle"><?php echo $InsAsignacionVentaVehiculo->VmaNombre;?> <?php echo $InsAsignacionVentaVehiculo->VmoNombre;?> <?php echo $InsAsignacionVentaVehiculo->VveNombre;?></td>
          </tr>
          <tr>
            <td align="center" valign="middle">Num. Motor:</td>
            <td align="center" valign="middle"><?php echo $InsAsignacionVentaVehiculo->EinNumeroMotor;?></td>
          </tr>
          <tr>
            <td align="center" valign="middle">Color:</td>
            <td align="center" valign="middle"><?php echo $InsAsignacionVentaVehiculo->EinColor;?></td>
          </tr>
          <tr>
            <td align="center" valign="middle">Año Fabricación:</td>
            <td align="center" valign="middle"><?php echo $InsAsignacionVentaVehiculo->EinAnoFabricacion;?></td>
          </tr>
          <tr>
            <td align="center" valign="middle">Año Modelo:</td>
            <td align="center" valign="middle"><?php echo $InsAsignacionVentaVehiculo->EinAnoModelo;?></td>
          </tr>
          <tr>
            <td width="257" align="center" valign="middle">Ubicación:</td>
            <td width="257" align="center" valign="middle">
			<?php echo $InsAsignacionVentaVehiculo->EinUbicacion;?></td>
            </tr>
            </tbody>
          </table>
          
          <br />
        <?php
		
		//deb($InsAsignacionVentaVehiculo->VveId);
		//deb($InsAsignacionVentaVehiculo->VveFoto);
		if(!empty($InsAsignacionVentaVehiculo->VveFoto)){
		?>
        <img src="../../subidos/vehiculo_version_fotos/<?php echo $InsAsignacionVentaVehiculo->VveFoto;?>" width="334" />
        <?php
		}
		?>
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    
    <tr>
      <td align="left" valign="top" class="EstAsignacionVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" >
      
       <span class="EstAsignacionVentaVehiculoImprimirTitulo">    
          <p>
          Observaciones:
          </p>
          </span>
          </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstAsignacionVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" >
        
        <span class="EstAsignacionVentaVehiculoImprimirContenido">    
          <p>
            <?php echo $InsAsignacionVentaVehiculo->AvvObservacion;?>
            </p>
          </span>
        
        </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstAsignacionVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
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
        <span class="EstAsignacionVentaVehiculoImprimirNota2"><!--Urb. Los Cedros Mz. B Lte. 10 Av. Manuel A. Odria Via Panamericana Sur (Costado Grifo Municipal)<br />
        Tel&eacute;fono 51-52 315216 Anexo 210 Fono Fax: 851-52 315207 E-mail: canepa@cyc.com.pe<br />-->
      </span>
</p>

 
 
</body>
</html>
