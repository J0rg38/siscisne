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
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


$POST_ProductoId = $_POST['ProductoId'];
$POST_Ano = (empty($_POST['Ano'])?date("Y"):$_POST['Ano']);
$POST_AlmacenId = $_POST['AlmacenId'];
$POST_Sucursal = $_POST['Sucursal'];

if(empty($POST_ProductoId)){
	die("No ha escogido un producto");
}

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsKardex.php');

$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();
$InsAlmacenMovimientoSalidaDetalle = new ClsAlmacenMovimientoSalidaDetalle();
$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();

$InsAlmacenStock = new ClsAlmacenStock();
$InsKardex = new ClsKardex();

//$InsAlmacenStock->ProId = $POST_ProductoId;
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

if(!empty($POST_AlmacenId)){
//	$stipo = "1,2,3,6,7,8";		
}else{
	$stipo = "1,2,3,7";
}

/// MtdObtenerAlmacenMovimientoSalidaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAlmacenMovimientoSalida=NULL,$oEstado=NULL,$oProducto=NULL,$oAlmacenMovimientoSalidaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oAlmacenId=NULL,$oAlmacenMovimientoSubTipo=NULL) 

//MtdObtenerAlmacenMovimientoSalidaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAlmacenMovimientoSalida=NULL,$oEstado=NULL,$oProducto=NULL,$oAlmacenMovimientoSalidaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oAlmacenId=NULL,$oAlmacenMovimientoSubTipo=NULL,$oSucursal=NULL)
$ResAlmacenMovimientoSalidaDetalle = $InsKardex->MtdObtenerAlmacenMovimientoSalidaDetalles(NULL,NULL,NULL,'AmoFecha','ASC',NULL,NULL,3,$POST_ProductoId,NULL,NULL,NULL,$POST_Ano."-01-01",$POST_Ano."-12-31",$POST_AlmacenId,$stipo,$POST_Sucursal);
$ArrAlmacenMovimientoSalidaDetalles = $ResAlmacenMovimientoSalidaDetalle['Datos'];
?>



 
			  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado">
				<thead class="EstTablaListadoHead">
				  <tr>
					<th width="2%">#</th>
					<th width="8%">FICHA</th>
					<th width="12%">FEC. FICHA</th>
					<th width="12%">OPERACION</th>
					<th width="12%">FEC. SALIDA</th>
					<th width="33%">CLIENTE</th>
					<th width="15%">ORD. VEN.</th>
					<th width="15%">ORD. TRAB.</th>
					<th width="15%">MODALIDAD</th>
					<th width="15%">NUM. COMPROB.</th>
					<th width="15%">FEC. COMPROB.</th>
					<th width="8%">U.M.</th>
					<th width="15%">CANTIDAD</th>
					<th width="8%">CANT. UNI. BASE.</th>
				  </tr>
				</thead>
				<tbody class="EstTablaListadoBody">
				  <?php
				  $i=1;
			  $TotalSalidas = 0;
			  $TotalSalidasReal = 0;
			  
			foreach($ArrAlmacenMovimientoSalidaDetalles as $DatAlmacenMovimientoSalidaDetalle){
		  ?>
				  
				  <tr>
					<td align="left" valign="top"><?php echo $i;?></td>
					<td align="left" valign="top">
					
					
					
			<?php 
			
		//deb($DatAlmacenMovimientoSalidaDetalle->AmoSubTipo);
					switch($DatAlmacenMovimientoSalidaDetalle->AmoSubTipo){
						case "4":
				  ?>
				 <a target="_blank" href="principal.php?Mod=AlmacenMovimientoSalidaSimple&Form=Ver&Id=<?php echo $DatAlmacenMovimientoSalidaDetalle->AmoId?>"> <?php echo $DatAlmacenMovimientoSalidaDetalle->AmoId?> </a>
					
				  <?php  
						break;
						
					 case "6":
  ?>
 <a target="_blank" href="principal.php?Mod=TrasladoAlmacen&Form=Ver&Id=<?php echo $DatAlmacenMovimientoSalidaDetalle->TalId?>">
    <?php echo $DatAlmacenMovimientoSalidaDetalle->TalId;?>
    </a> 	
  <?php  
        break;
		
		 case "7":
  ?>
 <a target="_blank" href="principal.php?Mod=ProduccionProducto&Form=Ver&Id=<?php echo $DatAlmacenMovimientoSalidaDetalle->PprId?>">
    <?php echo $DatAlmacenMovimientoSalidaDetalle->PprId?>
    </a> 	
  <?php  
        break;
						
						default:
				  ?>
				   <a target="_blank" href="principal.php?Mod=AlmacenMovimientoSalida&amp;Form=Ver&amp;Id=<?php echo $DatAlmacenMovimientoSalidaDetalle->AmoId?>"> <?php echo $DatAlmacenMovimientoSalidaDetalle->AmoId?> </a>
					
					
				  <?php	  
						break;
					}
					
					 ;
					 
					 
					 ?>
					
								
					
				  
					
					
					</td>
					<td align="left" valign="top"><?php echo $DatAlmacenMovimientoSalidaDetalle->AmoFecha?></td>
					<td align="left" valign="top"><?php echo $DatAlmacenMovimientoSalidaDetalle->TopNombre?></td>
					<td align="left" valign="top"><?php echo $DatAlmacenMovimientoSalidaDetalle->AmdFecha?></td>
					<td align="left" valign="top">
					
					<?php echo $DatAlmacenMovimientoSalidaDetalle->CliNombre;?> 
					<?php echo $DatAlmacenMovimientoSalidaDetalle->CliApellidoPaterno;?> 
					<?php echo $DatAlmacenMovimientoSalidaDetalle->CliApellidoMaterno;?> 
					
					</td>
					<td align="left" valign="top"><a target="_blank" href="principal.php?Mod=VentaDirecta&amp;Form=Ver&amp;Id=<?php echo $DatAlmacenMovimientoSalidaDetalle->VdiId;?>"><?php echo $DatAlmacenMovimientoSalidaDetalle->VdiId;?></a></td>
					<td align="left" valign="top">
					
					<a target="_blank" href="principal.php?Mod=FichaIngreso&amp;Form=Ver&amp;Id=<?php echo $DatAlmacenMovimientoSalidaDetalle->FinId;?>">
					<?php echo $DatAlmacenMovimientoSalidaDetalle->FinId;?></a>
				   
					
					</td>
					<td align="left" valign="top"><?php echo $DatAlmacenMovimientoSalidaDetalle->MinNombre;?></td>
					<td align="left" valign="top">
					
					<?php echo $DatAlmacenMovimientoSalidaDetalle->AmdFactura;?>
					<?php echo $DatAlmacenMovimientoSalidaDetalle->AmdBoleta;?>
					
					</td>
					<td align="left" valign="top">

					  <?php echo $DatAlmacenMovimientoSalidaDetalle->AmdFacturaFechaEmision;?>
					  <?php echo $DatAlmacenMovimientoSalidaDetalle->AmdBoletaFechaEmision;?>

					</td>
					<td align="left" valign="top"><?php echo $DatAlmacenMovimientoSalidaDetalle->UmeNombre?></td>
					<td align="left" valign="top"><?php echo number_format($DatAlmacenMovimientoSalidaDetalle->AmdCantidad,2);?></td>
					<td align="left" valign="top" bgcolor="#FFFF66"><?php echo $DatAlmacenMovimientoSalidaDetalle->AmdCantidadReal?></td>
				  </tr>
				  <?php	
				  $TotalSalidasReal += $DatAlmacenMovimientoSalidaDetalle->AmdCantidadReal;
				  $TotalSalidas += $DatAlmacenMovimientoSalidaDetalle->AmdCantidad;
				  $i++;  
			}
			 ?>
			 <tr>
					<td colspan="13" align="right">TOTAL SALIDAS:</td>
					<td><?php echo number_format($TotalSalidasReal,6);?></td>
				  </tr>
				  
				</tbody>
			  </table>