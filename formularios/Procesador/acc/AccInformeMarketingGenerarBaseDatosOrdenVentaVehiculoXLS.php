<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta  = '../../../';

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

if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"BASE_DATOS_ORDEN_VENTA_VEHICULOS_".date('d-m-Y').".xls\";");
}

$POST_FechaInicio = empty($_GET['FechaInicio'])?date("d/m/Y"):$_GET['FechaInicio'];
$POST_FechaFin = empty($_GET['FechaFin'])?date("d/m/Y"):$_GET['FechaFin'];

$POST_Sucursal = (($_GET['Sucursal']));
$POST_C = (($_GET['C']));

//Sdeb($POST_C);
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoSalida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoSalidaDetalle.php');

require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');


require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');


$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsMoneda = new ClsMoneda();
$InsSucursal = new ClsSucursal();
$InsPersonal = new ClsPersonal();



//MtdObtenerOrdenVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oCliente=NULL,$oConCotizacion=0,$oFacturable=NULL,$oCotizacionVehiculo=NULL,$oVehiculoIngreso=NULL,$oSucursal=NULL,$oAprobacion1=NULL,$oAprobacion2=NULL,$oAprobacion3=NULL,$oTieneActaFechaEntrega=0,$oTieneComprobante=false,$oFechaTipo="OvvFecha") {
$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculos(NULL,NULL,NULL,"OvvFecha","DESC","",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"5",NULL,NULL,NULL,0,NULL,NULL,NULL,$POST_Sucursal,NULL,NULL,NULL,NULL);
$ArrOrdenVentaVehiculos = $ResOrdenVentaVehiculo['Datos'];
	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BASE DE DATOS DE ORDENES DE VENTA DE VEHICULOS</title>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssAsignacionVentaVehiculoImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsAsignacionVentaVehiculoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	

	
});
</script>

<?php
}
?>
</head>
<body>


<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="1%" >#</th>
                <th width="13%" >ID</th>
                <th width="13%" >SUCURSAL</th>
                <th width="12%" >FECHA</th>
                <th width="8%" >NUM. DOC.</th>
                <th width="9%" >CLIENTE</th>
                <th width="9%" >ASESOR</th>
                <th width="9%" >MARCA</th>
                <th width="25%" >MODELO</th>
                <th width="14%" >REF.</th>
                <th width="14%" >TELEFONO</th>
                <th width="14%" >CELULAR</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
            </tfoot>
 <tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;
				
								foreach($ArrOrdenVentaVehiculos as $dat){


$dat->OvvPrecio = (($dat->OvvPrecio/(empty($dat->OvvTipoCambio)?1:$dat->OvvTipoCambio)));
$dat->OvvTotal = (($dat->OvvTotal/(empty($dat->OvvTipoCambio)?1:$dat->OvvTipoCambio)));
				


			
			
		?>
        <tr id="Fila_<?php echo $f;?>">
                <td width="1%" align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle" width="13%"   ><?php echo $dat->OvvId;  ?></td>
                <td align="right" valign="middle" width="13%"   >
                  
                 <?php echo $dat->SucNombre;  ?>
                  
               
                </td>
                <td  width="12%" align="right" >  <?php echo $dat->OvvFecha;  ?></td>
                <td  width="8%" align="right" ><?php echo $dat->CliNumeroDocumento;  ?></td>
                <td  width="9%" align="right" ><?php echo $dat->CliNombre;  ?> <?php echo $dat->CliApellidoPaterno;  ?> <?php echo $dat->CliApellidoMaterno;  ?></td>
                <td  width="9%" align="right" ><?php echo $dat->PerNombre;  ?> <?php echo $dat->PerApellidoPaterno;  ?> <?php echo $dat->PerApellidoMaterno;  ?></td>
                <td  width="9%" align="right" >
                  <?php echo $dat->VmaNombre;  ?>
                
			
                
                </td>
                <td  width="25%" align="right" ><?php echo $dat->VmoNombre;  ?></td>
                <td  width="14%" align="left" ><?php echo $dat->TrfNombre;  ?></td>
                <td  width="14%" align="left" ><?php echo $dat->CliTelefono;  ?></td>
                <td  width="14%" align="left" ><?php echo $dat->CliCelular;  ?></td>
    </tr>
        <?php
		$f++;
			
									}
									

									?>
            </tbody>
      </table>
 
</body>
</html>