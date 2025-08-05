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


$POST_VehiculoId = $_POST['VehiculoId'];
$POST_Ano = (empty($_POST['Ano'])?date("Y"):$_POST['Ano']);
$POST_Sucursal = $_POST['Sucursal'];

if(empty($POST_VehiculoId)){
	die("No ha escogido un producto");
}

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoSalidaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsKardexVehiculo.php');

$InsVehiculoMovimientoEntradaDetalle = new ClsVehiculoMovimientoEntradaDetalle();
$InsVehiculoMovimientoSalidaDetalle = new ClsVehiculoMovimientoSalidaDetalle();
$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();

$InsAlmacenStock = new ClsAlmacenStock();
$InsKardexVehiculo = new ClsKardexVehiculo();

//$InsAlmacenStock->ProId = $POST_VehiculoId;
//$InsAlmacenStock->MtdObtenerAlmacenStock();


?>




              
 
    
<?php

/*
ENTRADAS
1 - ALMACEN MOVIMIENTO ENTRADA / compras
2 - otros ingresos
6 - TRASLADO ALMACEN
7 - CONVERSION
SALIDAS
1 - ALMACEN MOVIMIENTO SALIDA
2 - TALLER PEDIDO
3 - VENTA CONCRETADA
6 - TRASLADO ALMACEN
7 - CONVERSION
8 - TRANSFERENCIA SALIDA

*/

//deb($POST_AlmacenId);

if(!empty($POST_Sucursal)){
	$stipo = "1,2,6";
}else{
	$stipo = "1,2";
}

//MtdObtenerVehiculoMovimientoSalidaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCompraVehiculo=NULL,$oEstado=NULL,$oVehiculo=NULL,$oTipo=NULL,$oSucursal=NULL) {
$ResVehiculoMovimientoSalidaDetalle = $InsKardexVehiculo->MtdObtenerVehiculoMovimientoSalidaDetalles(NULL,NULL,NULL,'VmvFecha','ASC',NULL,NULL,3,$POST_VehiculoId,$stipo,$POST_Sucursal,$POST_Ano."-01-01",$POST_Ano."-12-31");
$ArrVehiculoMovimientoSalidaDetalles = $ResVehiculoMovimientoSalidaDetalle['Datos'];
?>



 
			  <table width="100%" border="0" cellpadding="0" cellspacing="1" class="EstTablaListado">
				<thead class="EstTablaListadoHead">
				  <tr>
				    <th width="2%" rowspan="2">#</th>
				    <th width="5%" rowspan="2">FICHA</th>
				    <th width="5%" rowspan="2">FECHA</th>
				    <th width="15%" rowspan="2">OPERACION</th>
				    <th width="24%" rowspan="2">CLIENTE</th>
				    <th>REFERENCIA</th>
				    <th colspan="2">COMPROB.</th>
				    <th colspan="2">SALIDA</th>
			      </tr>
				  <tr>
					<th width="13%">ORD. VEN.</th>
					<th width="10%">NUM. </th>
					<th width="10%">FEC. </th>
					<th width="7%">CANT.</th>
					<th width="9%">U.M.</th>
				  </tr>
				</thead>
				<tbody class="EstTablaListadoBody">
				  <?php
				  $i=1;
			  $TotalSalidas = 0;
			  $TotalSalidasReal = 0;
			  
			foreach($ArrVehiculoMovimientoSalidaDetalles as $DatVehiculoMovimientoSalidaDetalle){
		  ?>
				  
				  <tr>
					<td align="left" valign="top"><?php echo $i;?></td>
					<td align="left" valign="top">
					
					
					
			<?php 
			
		//deb($DatVehiculoMovimientoSalidaDetalle->VmvSubTipo);
					switch($DatVehiculoMovimientoSalidaDetalle->VmvSubTipo){
						
							case "1":
				  ?>
				 <a target="_blank" href="principal.php?Mod=VehiculoMovimientoSalida&Form=Ver&Id=<?php echo $DatVehiculoMovimientoSalidaDetalle->VmvId?>"> <?php echo $DatVehiculoMovimientoSalidaDetalle->VmvId?> </a>
					
				  <?php  
						break;
						
						
						case "2":
				  ?>
				 <a target="_blank" href="principal.php?Mod=VehiculoMovimientoSalidaSimple&Form=Ver&Id=<?php echo $DatVehiculoMovimientoSalidaDetalle->VmvId?>"> <?php echo $DatVehiculoMovimientoSalidaDetalle->VmvId?> </a>
					
				  <?php  
						break;
						
					 case "6":
  ?>
 <a target="_blank" href="principal.php?Mod=TrasladoVehiculo&Form=Ver&Id=<?php echo $DatVehiculoMovimientoSalidaDetalle->TveId?>">
    <?php echo $DatVehiculoMovimientoSalidaDetalle->TveId;?>
    </a> 	
  <?php  
        break;
		
						
						default:
				  ?>
				    <?php echo $DatVehiculoMovimientoEntradaDetalle->VmvId?>
				  <?php	  
						break;
					}
					
				
					 
					 ?>
					
								
					
				  
					
					
					</td>
					<td align="left" valign="top"><span title="<?php echo $DatVehiculoMovimientoSalidaDetalle->VmvFecha?>"><?php echo $DatVehiculoMovimientoSalidaDetalle->VmvFecha?></span></td>
					<td align="left" valign="top"><?php echo $DatVehiculoMovimientoSalidaDetalle->TopNombre?></td>
					<td align="left" valign="top">
					
					<?php echo $DatVehiculoMovimientoSalidaDetalle->CliNombre;?> 
					<?php echo $DatVehiculoMovimientoSalidaDetalle->CliApellidoPaterno;?> 
					<?php echo $DatVehiculoMovimientoSalidaDetalle->CliApellidoMaterno;?> 
					
                    
					<?php echo $DatVehiculoMovimientoSalidaDetalle->PrvNombre;?> 
					<?php echo $DatVehiculoMovimientoSalidaDetalle->PrvApellidoPaterno;?> 
					<?php echo $DatVehiculoMovimientoSalidaDetalle->PrvApellidoMaterno;?> 
                    
					</td>
					<td align="left" valign="top"><a target="_blank" href="principal.php?Mod=VentaDirecta&amp;Form=Ver&amp;Id=<?php echo $DatVehiculoMovimientoSalidaDetalle->OvvId;?>"><?php echo $DatVehiculoMovimientoSalidaDetalle->OvvId;?></a></td>
					<td align="left" valign="top">
					
					<?php echo $DatVehiculoMovimientoSalidaDetalle->VmdFactura;?>
					<?php echo $DatVehiculoMovimientoSalidaDetalle->VmdBoleta;?>
					
					</td>
					<td align="left" valign="top">

					  <?php echo $DatVehiculoMovimientoSalidaDetalle->VmdFacturaFechaEmision;?>
					  <?php echo $DatVehiculoMovimientoSalidaDetalle->VmdBoletaFechaEmision;?>

					</td>
					<td align="right" valign="top" bgcolor="#EEEEEE"><?php echo number_format($DatVehiculoMovimientoSalidaDetalle->VmdCantidad,2);?></td>
					<td align="right" valign="top" bgcolor="#EEEEEE"><?php echo $DatVehiculoMovimientoSalidaDetalle->UmeNombre?></td>
				  </tr>
				  <?php	
				  $TotalSalidasReal += $DatVehiculoMovimientoSalidaDetalle->VmdCantidadReal;
				  $TotalSalidas += $DatVehiculoMovimientoSalidaDetalle->VmdCantidad;
				  $i++;  
			}
			 ?>
			 <tr>
					<td colspan="8" align="right">TOTAL SALIDAS:</td>
					<td align="right"><?php echo number_format($TotalSalidas,2);?></td>
					<td align="right">&nbsp;</td>
				  </tr>
				  
				</tbody>
			  </table>