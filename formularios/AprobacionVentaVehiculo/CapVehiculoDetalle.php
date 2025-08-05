<?php
session_start();

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
////require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
//require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


//CONFIGURACIONES JORGE
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
 require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');


$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsOrdenVentaVehiculo->OvvId = $_POST['VehiculoId'];
$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();

//deb($InsOrdenVentaVehiculo);

//REVISAR SI ES EFICIENTE LA DECLARACION DE VARIAS VARIABLES

$TotalPrecio = substr($InsOrdenVentaVehiculo->OvvTotal, 0, -3);  // devuelve "abcde"

$PrecioDolares = $TotalPrecio/$InsOrdenVentaVehiculo->OvvTipoCambio;
$DolaresFormato = number_format($PrecioDolares,2);

?>

<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstTablaListadoHead">
<tr>
  <th width="65">Id.</th>
  <th width="57">Sucursal</th>
  <th width="98">Cliente</th>
  <th width="133">VIN</th>
  <th width="80">Marca</th>
  <th width="94">Modelo</th>
  <th width="126">Version</th>
  <th width="69">Color</th>
  <th width="69">GLP</th>
  <th width="38">Año Fab.</th>
  <th width="36">Año Mod.</th>
  <th width="54">Moneda</th>
  <th width="47">T.C.</th>
  <th width="97">Total</th>
  <th width="92">Asesor de Venta</th>
	
  </tr>
</thead>
<tbody class="EstTablaListadoBody">


<tr>

	<td align="center"><?php echo $InsOrdenVentaVehiculo->OvvId; ?></td>
	<td align="right"><?php echo $InsOrdenVentaVehiculo->SucNombre; ?></td>
	<td align="right"><?php echo $InsOrdenVentaVehiculo->CliNombre." ".$InsOrdenVentaVehiculo->CliApellidoPaterno." ".$InsOrdenVentaVehiculo->CliApellidoMaterno; ?></td>
	<td align="right"><?php echo $InsOrdenVentaVehiculo->EinVIN; ?></td>
	<td align="right"><?php echo $InsOrdenVentaVehiculo->VmaNombre; ?></td>
	<td align="right"><?php echo $InsOrdenVentaVehiculo->VmoNombre; ?></td>
	<td align="right"><?php echo $InsOrdenVentaVehiculo->VveNombre; ?></td>
	<td align="right"><?php echo $InsOrdenVentaVehiculo->OvvColor; ?></td>
	<td align="right"><?php echo $InsOrdenVentaVehiculo->OvvGLP; ?></td>
	<td align="right"><?php echo $InsOrdenVentaVehiculo->OvvAnoFabricacion; ?></td>
	<td align="right"><?php echo $InsOrdenVentaVehiculo->OvvAnoModelo; ?></td>
	<td align="right"><?php echo $InsOrdenVentaVehiculo->MonSimbolo; ?></td>
	<td align="right"><?php echo $InsOrdenVentaVehiculo->OvvTipoCambio; ?></td>
	<td align="right"><?php echo $DolaresFormato; ?></td>
	<td align="right"><?php echo $InsOrdenVentaVehiculo->PerNombre." ".$InsOrdenVentaVehiculo->PerApellidoPaterno." ".$InsOrdenVentaVehiculo->PerApellidoMaterno; ?></td>

</tr>

	
</tbody>
</table>


<a href="javascript:FncCargarVehiculoInstalar('<?php echo $InsOrdenVentaVehiculo->EinId;;?>');"><img src="imagenes/iconos/vehiculo_instalar.png" width="25" height="25" /> Accesorios</a>

<a href="javascript:FncCargarVehiculoIngresoEvento('<?php echo $InsOrdenVentaVehiculo->EinId;;?>');"><img src="imagenes/iconos/vehiculo_eventos.png" width="25" height="25" /> Accesorios</a>

