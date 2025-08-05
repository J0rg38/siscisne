<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsPoo->Ruta= '../../../';
$InsProyecto->Ruta= '../../../';

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

?>
<!--
Libreria leer excel
-->
<?php require_once($InsProyecto->MtdRutLibrerias().'excel/OLERead.php');?>
<?php require_once($InsProyecto->MtdRutLibrerias().'excel/reader.php');?>
<?php require_once($InsProyecto->MtdRutLibrerias().'simplexlsx.class.php');?>

<?php
require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');
?>

<?php require_once($InsProyecto->MtdRutLibrerias().'JSON.php'); ?>
<?php require_once($InsProyecto->MtdRutLibrerias().'JSON2.php'); ?>


<?php


require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaTarea.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaFoto.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');




?>

<form method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td align="left" valign="top">
	

    
  </td>
</tr>
<tr>
  <td align="left" valign="top">

	<input type="file" id="CmpArchivo" name="CmpArchivo" />
    
    
	<input  name="BtnEnviar" id="BtnEnviar" type="submit" value="Importar Excel" />

    </td>
</tr>
<tr>
  <td align="left" valign="top">
    <?php
if (!empty($_FILES)) {
	$tempFile = $_FILES['CmpArchivo']['tmp_name'];
	//$file_name = strtolower($_FILES['CmpArchivo']['name']);	
	$file_name = iconv("UTF-8","WINDOWS-1251",$_FILES['CmpArchivo']['name']);
	$targetPath = '../../../subidos/orden_pendiente_excel/';
	
	
	
	$targetFile =  str_replace('//','/',$targetPath) . ($file_name);	
	
	$ext = pathinfo($targetFile, PATHINFO_EXTENSION);
	$file_name = date("d-m-Y")."_ARCHIVO1_".$Identificador.".".$ext;
	
	$targetFile =  str_replace('//','/',$targetPath) . $file_name;	
	
	
	
	//$targetFile =  str_replace('//','/',$targetPath) . date("d-m-Y").'_P_'.(FncLimpiarCaracteresEspeciales($file_name));	
	
?>
    Nombre de Archivo: <?php echo $file_name;?><br />
  <?php
	if (move_uploaded_file($tempFile,$targetFile)){

		$path = $targetFile;
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		
		switch($ext){
		
			case "xls":




			break;
			
			case "xlsx":

				
				$xlsx = new SimpleXLSX($targetFile); 

				list($num_cols, $num_rows) = $xlsx->dimension(); 

				$fila = 0;
				$inicio_filaA = 0;
				$inicio_columnaA = 0;

				foreach( $xlsx->rows() as $r ) { 

					for( $columna = 0; $columna < $num_cols; $columna++ ) {
						
						//deb(strtoupper($r[$columna]));
						
						if( strtoupper($r[$columna]) == "O.C." ){
							$inicio_columnaA = $columna;
							$inicio_filaA = $fila;
							break;
						}

					}
					$fila++;
				}
				
			
				$fila = 0;
				$inicio_filaB = 0;
				$inicio_columnaB = 0;

				foreach( $xlsx->rows() as $r ) { 

					for( $columna = 0; $columna < $num_cols; $columna++ ) {

						if( strtoupper($r[$columna]) == "PRODUCTO" ){
							$inicio_columnaB = $columna;
							$inicio_filaB = $fila;
							break;
						}

					}
					$fila++;
				}
				
				
				
				$fila = 0;
				$inicio_filaC = 0;
				$inicio_columnaC = 0;

				foreach( $xlsx->rows() as $r ) { 

					for( $columna = 0; $columna < $num_cols; $columna++ ) {

						if( strtoupper($r[$columna]) == "SOLICITADO" ){
							$inicio_columnaC = $columna;
							$inicio_filaC = $fila;
							break;
						}

					}
					$fila++;
				}
				
				
				$fila = 0;
				$inicio_filaD = 0;
				$inicio_columnaD = 0;

				foreach( $xlsx->rows() as $r ) { 

					for( $columna = 0; $columna < $num_cols; $columna++ ) {
										
						if( strtoupper($r[$columna]) == "ENTREGADO" ){
							$inicio_columnaD = $columna;
							$inicio_filaD = $fila;
							break;
						}

					}
					$fila++;
				}
	
				
				$OrdenCompraNumero = "";
				$ProductoCodigoOriginal = "";
				$Solicitado = "";
				$Entregado = "";
				
				$fila = 1;
?>

<table>
    <tr>
    <td>#</td>
    <td>O.C. </td>
    <td>Cod. Original</td>
    <td>Solicitado</td>
    <td>Entregado</td>
    <td>Orden GM</td>
    <td>Fecha Orden GM</td>
    <td>En Camino</td>
    <td>Fecha En Camino</td>
    <td>Ficha Salida</td>
    <td>Fecha Ficha</td>
    <td>Factura</td>
    <td>Fecha Fac.</td>
    <td>Situacion</td>
    </tr>

<?php
				foreach( $xlsx->rows() as $r ) { 
					
					for( $columna=0; $columna < $num_cols; $columna++ ) {
						
						if($columna == $inicio_columnaA){
							$OrdenCompraNumero  =  trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
						}
	
						if($columna == $inicio_columnaB){
							$ProductoCodigoOriginal  = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
						}
	
						if($columna == $inicio_columnaC){
							$Solicitado = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
						}
						
						$Entregado = "";
		
						if($columna == $inicio_columnaD){
							$Entregado = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
						}

					}
					
					
						
				$OrdenCompraGM = "";
				$OrdenCompraGMFecha = "";
				
				$EnCamino = 0;
				$EnCaminoFecha = "";
				$VentaConcretadaId = "";
				$VentaConcretadaFecha = "";
				
				$FacturaTalonarioNumero = "";
				$FacturaId = "";
				$FacturaFecha = "";
		
				$Situacion = -1;		
				
				$ProductoId = "";
					if(!empty($OrdenCompraNumero) and !empty($ProductoCodigoOriginal)){
?>

<tr>
	<td><?php echo $fila;?></td>
	<td><?php echo $OrdenCompraNumero;?></td>
	<td><?php echo $ProductoCodigoOriginal;?></td>
	<td><?php echo $Solicitado;?></td>
	<td><?php echo $Entregado;?></td>

	
    
<?php


//MtdObtenerVentaDirectaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VddId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaDirecta=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oMoneda=NULL,$oCliente=NULL,$oConOrdenCompraReferencia=NULL)
$InsVentaDirectaDetalle = new ClsVentaDirectaDetalle();
$ResVentaDirectaDetalle = $InsVentaDirectaDetalle->MtdSeguimientoVentaDirectaDetalles("VdiOrdenCompraNumero","termina",$OrdenCompraNumero,'VddId','Desc',NULL,NULL,NULL,NULL,NULL,NULL,NULL,"CLI-10770",NULL);
$ArrVentaDirectaDetalles = $ResVentaDirectaDetalle['Datos'];


						if(!empty($ArrVentaDirectaDetalles)){
							foreach($ArrVentaDirectaDetalles as $DatVentaDirectaDetalle){
								
								if($DatVentaDirectaDetalle->ProCodigoOriginal == $ProductoCodigoOriginal){
									
									$Situacion = 1;
	
?>	

							
<!-- ------------------------------------------------------ -->


<?php
$InsPedidoCompraDetalle = new ClsPedidoCompraDetalle();
//MtdObtenerPedidoCompraDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPedidoCompra=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oVentaDirectaDetalleId=NULL,$oPedidoCompraEstado=NULL,$oFecha="PcoFecha")
$ResPedidoCompraDetalle = $InsPedidoCompraDetalle->MtdObtenerPedidoCompraDetalles(NULL,NULL,'PcdId','Desc',"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatVentaDirectaDetalle->VddId,3);
$ArrPedidoCompraDetalles = $ResPedidoCompraDetalle['Datos'];

?>
	  <?php
if(!empty($ArrPedidoCompraDetalles)){
	foreach($ArrPedidoCompraDetalles as $DatPedidoCompraDetalle){
		
		$OrdenCompraGM = $DatPedidoCompraDetalle->OcoId;
		$OrdenCompraGMFecha = $DatPedidoCompraDetalle->OcoFecha;
		$Situacion = 11;
		
	}	
}
?>

							
<!-- ------------------------------------------------------ -->
									
<?php
									if($DatVentaDirectaDetalle->VddCantidadPorLlegar>0){
										
										$EnCamino = $DatVentaDirectaDetalle->VddCantidadPorLlegar;
										$EnCaminoFecha = FncCambiaFechaANormal($DatVentaDirectaDetalle->VddFechaPorLlegar,true);
										
										$Situacion = 2;
									}
									
?>
								
<!-- ------------------------------------------------------ -->
									
									<?php
                                    $VentaConcretadaId = "";
                                    $VentaConcretadaFecha = "";
                                    $VentaConcretadaRevisar = false;
                                    ?>
                                    
                                    <?php
                                    $InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();
//MtdObtenerVentaConcretadaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaConcretada=NULL,$oEstado=NULL,$oProducto=NULL,$oVentaDirectaDetalleId=NULL,$oVentaConcretadaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL)
                                    $ResVentaConcretadaDetalle = $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetalles(NULL,NULL,'AmdId','Desc',"1",NULL,NULL,NULL,$DatVentaDirectaDetalle->VddId,3);
                                    $ArrVentaConcretadaDetalles = $ResVentaConcretadaDetalle['Datos'];
                                    
                                    ?>
                                    <?php
                                    if(!empty($ArrVentaConcretadaDetalles)){
                                        foreach($ArrVentaConcretadaDetalles as $DatVentaConcretadaDetalle){
                                    ?>
                                    
                                        <?php
                                        $VentaConcretadaId = $DatVentaConcretadaDetalle->AmoId;
                                        $VentaConcretadaFecha = $DatVentaConcretadaDetalle->AmoFecha;
                                        ?>
                                    
                                    <?php
                                        }
                                    }
                                    ?>


                                   
                                    
                                    <?php
                                        if(!empty($VentaConcretadaId)){
                                            $Situacion = 3;
                                        }
                                    ?>	
      								
									
 <!-- ------------------------------------------------------ -->
         							
									<?php
                                    $FacturaId = "";
                                    $FacturaTalonarioId = "";
                                    $FacturaFecha = "";
                                    $FacturaTalonarioNumero = "";
                                    $FacturaRevisar = false;
                                    ?>
                                        
                                    <?php
                                    $InsFacturaDetalle = new ClsFacturaDetalle();
//MtdObtenerFacturaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FdeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFactura=NULL,$oTalonario=NULL,$oAlmacenMovimientoDetalleId=NULL,$oFacturaEstado=NULL,$oVentaDirectaDetalleId=NULL)
                                    $ResFacturaDetalle = $InsFacturaDetalle->MtdObtenerFacturaDetalles(NULL,NULL,'FdeId','Desc',"1",NULL,NULL,NULL,5,$DatVentaDirectaDetalle->VddId);
                                    $ArrFacturaDetalles = $ResFacturaDetalle['Datos'];
                                    ?>
                                    
                                    <?php
                                    if(!empty($ArrFacturaDetalles)){
                                        foreach($ArrFacturaDetalles as $DatFacturaDetalle){
                                    ?>
                                        
                                        <?php
                                        $FacturaId = $DatFacturaDetalle->FacId;
                                        $FacturaTalonarioId = $DatFacturaDetalle->FtaId;
                                        $FacturaFecha = $DatFacturaDetalle->FacFechaEmision;
                                        $FacturaTalonarioNumero = $DatFacturaDetalle->FtaNumero;
                                        ?>
                                    
                                    <?php
                                        }
                                    }
                                    ?>
                                        
                                    <?php
                                        if(!empty($FacturaId)){
                                            $Situacion = 4;
                                        }
                                    ?>	
                                    
 <!-- ------------------------------------------------------ --> 
                                   
								 

<?php

								}
								
							}
						}
?>
    
<td><?php  echo $OrdenCompraGM;?></td>
<td><?php echo $OrdenCompraGMFecha;?></td>
<td><?php echo $EnCamino;?></td>
<td><?php echo $EnCaminoFecha;?></td>
<td><?php echo $VentaConcretadaId;?></td>
<td><?php echo $VentaConcretadaFecha;?></td>
<td><?php echo $FacturaTalonarioNumero."-".$FacturaId;?></td>
<td><?php echo $FacturaFecha;?></td>
<td>
                
                
									<?php 
                                    switch($Situacion){
										
										case -1:
									?>
                                    No encontrado
                                    <?php	
										break;
										
                                        case 1:
                                    ?>
                                    Pendiente
                                    <?php	
                                        break; 
										
										case 11:
									?>
                                    Solicitado a GM
                                    <?php	
										break;
                                        
                                        case 2:
                                    ?>
                                    En Camino
                                    <?php
                                        break;
                                        
                                        case 3:
                                    ?>
                                    Despachado
                                    <?php
                                        break;
                                        
                                        case 4:
                                    ?>
                                    Facturado
                                    <?php
                                        break;
										
										default:
										
										break;
                                    }		
                                    ?>
</td>
</tr>
                   
                  
                                          
<?php
						}
						
					
				
					 $fila++;
				} 
?>

</table>
<?php
			break;
			
			default:
			
			break;
			
		}
		
		


	} else {
?>
    Hubo un error al subir el archivo
    <?php		
		}

	
}
?></td>
</tr>
</table>

	</form>