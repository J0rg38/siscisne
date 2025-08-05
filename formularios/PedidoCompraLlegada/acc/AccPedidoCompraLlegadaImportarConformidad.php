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

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsPedidoCompraLlegada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsPedidoCompraLlegadaDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');
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
	$targetPath = '../../../subidos/pedidocomprallegada_excel/';
	
	
	
	$targetFile =  str_replace('//','/',$targetPath) . ($file_name);	
	
	$ext = pathinfo($targetFile, PATHINFO_EXTENSION);
	$file_name = date("d-m-Y")."_ARCHIVO2_".$Identificador.".".$ext;
	
	$targetFile =  str_replace('//','/',$targetPath) . $file_name;	
	
	
	
	//$targetFile =  str_replace('//','/',$targetPath) . date("d-m-Y").'_P_'.(FncLimpiarCaracteresEspeciales($file_name));	
	
?>
    Nombre de Archivo: <?php echo $file_name;?><br />
  <?php
	if (move_uploaded_file($tempFile,$targetFile)){

		
		$path = $targetFile;
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		
		
		switch($ext){
		
			/*case "xls":


				$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
				
				if(!$InsProductoDisponibilidad->MtdEliminarTodoProductoDisponibilidad()){
?>
					<span class="EstImportarRegistrarNo">No se pudo vaciar la tabla de disponibilidad.</span><br />
<?php					
				}
				
				$data = new Spreadsheet_Excel_Reader();	
				$data->setOutputEncoding('CP1251');				
				$data->read($targetFile);
				
				
				$fila = 0;
				$inicio_fila = 0;
				$inicio_columna = 0;
				
				for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {	

					for($j = 1; $j<20; $j++){

						$aux  = $data->sheets[0]['cells'][$i][$j];
						$aux  = str_replace("'", "&#8217;", $aux);	
						
						if( $aux  == "MATERIAL NUMBER" ){
							$inicio_columna = $j;
							$inicio_fila = $fila;
							break;
						}
					}
					$fila++;
				}

				

				$fila = 1;
				for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {	
					  
					$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
					  
					$InsProductoDisponibilidad->PdiCodigo  = $data->sheets[0]['cells'][$i][$inicio_columna];
					$InsProductoDisponibilidad->PdiCodigo  = str_replace("'", "&#8217;", $InsProductoDisponibilidad->PdiCodigo);	
					  
					$InsProductoDisponibilidad->PdiNombre  = $data->sheets[0]['cells'][$i][$inicio_columna+1];
					$InsProductoDisponibilidad->PdiNombre  = str_replace("'", "&#8217;", $InsProductoDisponibilidad->PdiNombre);	
					  
					$InsProductoDisponibilidad->PdiDisponible  = $data->sheets[0]['cells'][$i][$inicio_columna+2];
					$InsProductoDisponibilidad->PdiDisponible  = str_replace("'", "&#8217;", $InsProductoDisponibilidad->PdiDisponible);	
					$InsProductoDisponibilidad->PdiTiempoCreacion = date("Y-m-d H:i:s");
					
					if(!empty($InsProductoDisponibilidad->PdiCodigo)){
			
						if($InsProductoDisponibilidad->MtdRegistrarProductoDisponibilidad()){
			?>
							<span class="EstImportarRegistrarSi">[Fila <?php echo $fila;?>]> <?php echo $InsProductoDisponibilidad->PdiCodigo;?>, Se registro correctamente.</span><br />
			<?php
						}else{
			?>
							<span class="EstImportarRegistrarNo">[Fila <?php echo $fila;?>]> <?php echo $InsProductoDisponibilidad->PdiCodigo;?>, No se pudo registrar.</span><br />
			<?php	
						}
									
					}else{
			?>
						<span class="EstImportarRegistrarNo">[Fila <?php echo $fila;?>]> No se pudo registrar, codigo vacio</span><br />
			<?php
					}
			
					?>
					
					<hr />
					<?php					
					  $fila++;
					}			
			



			break;*/
			
			case "xlsx":

				$InsPedidoCompraLlegada = new ClsPedidoCompraLlegada();
				$InsPedidoCompraLlegada->PleFecha = date("Y-m-d");
				$InsPedidoCompraLlegada->PerId = $_SESSION['SesionPersonal'];
				$InsPedidoCompraLlegada->PleObservacion = "Despacho cargado el ".date("d/m/Y H:i:s");
				$InsPedidoCompraLlegada->PleEstado = 3;
				$InsPedidoCompraLlegada->PleTiempoCreacion = date("Y-m-d H:i:s");
				$InsPedidoCompraLlegada->PleTiempoModificacion = date("Y-m-d H:i:s");
				
				$xlsx = new SimpleXLSX($targetFile); 

				list($num_cols, $num_rows) = $xlsx->dimension(); 

				$fila = 0;
				$inicio_filaA = 0;
				$inicio_columnaA = 0;

				foreach( $xlsx->rows() as $r ) { 

					for( $columna = 0; $columna < $num_cols; $columna++ ) {
						
						//deb(strtoupper($r[$columna]));
						
						if( strtoupper($r[$columna]) == "COD. MOV." ){
							$inicio_columnaA = $columna;
							$inicio_filaA = $fila;
							break;
						}

					}
					$fila++;
				}
				
				//deb($inicio_columnaA ." - ".$inicio_filaA);
				
				$fila = 0;
				$inicio_filaB = 0;
				$inicio_columnaB = 0;

				foreach( $xlsx->rows() as $r ) { 

					for( $columna = 0; $columna < $num_cols; $columna++ ) {

						if( strtoupper($r[$columna]) == "ORD. COMPRA" ){
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

						if( strtoupper($r[$columna]) == "COD. ORIG." ){
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

						if( strtoupper($r[$columna]) == "CANT." ){
							$inicio_columnaD = $columna;
							$inicio_filaD = $fila;
							break;
						}

					}
					$fila++;
				}
			
			
				$fila = 0;
				$inicio_filaE = 0;
				$inicio_columnaE = 0;

				foreach( $xlsx->rows() as $r ) { 

					for( $columna = 0; $columna < $num_cols; $columna++ ) {

						if( strtoupper($r[$columna]) == "NOMBRE" ){
							$inicio_columnaE = $columna;
							$inicio_filaE = $fila;
							break;
						}

					}
					$fila++;
				}
				
				


				$fila = 0;
				$inicio_filaF = 0;
				$inicio_columnaF = 0;

				foreach( $xlsx->rows() as $r ) { 

					for( $columna = 0; $columna < $num_cols; $columna++ ) {

						if( strtoupper($r[$columna]) == "CONF." ){
							$inicio_columnaF = $columna;
							$inicio_filaF = $fila;
							break;
						}

					}
					$fila++;
				}
				
				
				$PedidoCompraLlegadaDetalleId = "";
				$OrdenCompraId = "";
				$ProductoCodigoOriginal = "";
				$PedidoCompraLlegadaDetalleCantidad = "";
				$ProductoNombre = "";
				$PedidoCompraLlegadaDetalleEstado = "";
		
				$fila = 1;
				foreach( $xlsx->rows() as $r ) { 

						for( $columna=0; $columna < $num_cols; $columna++ ) {

							if($columna == $inicio_columnaA){
								$PedidoCompraLlegadaDetalleId  =  trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							}

							if($columna == $inicio_columnaB){
								$OrdenCompraId  = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							}

							if($columna == $inicio_columnaC){
								$ProductoCodigoOriginal = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							}

							if($columna == $inicio_columnaD){
								$PedidoCompraLlegadaDetalleCantidad = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							}

							if($columna == $inicio_columnaE){
								$ProductoNombre = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							}

							if($columna == $inicio_columnaF){
								$PedidoCompraLlegadaDetalleEstado = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							}

						}
						
?>

[Fila <?php echo $fila;?>]> 

<?php
						if(!empty($OrdenCompraId) and !empty($ProductoCodigoOriginal) and !empty($PedidoCompraLlegadaDetalleCantidad) and !empty($PedidoCompraLlegadaDetalleEstado)){
							
							if(!empty($PedidoCompraLlegadaDetalleId)){
								
								$InsPedidoCompraLlegadaDetalle1 = new ClsPedidoCompraLlegadaDetalle();	
								$InsPedidoCompraLlegadaDetalle1->MtdEditarPedidoCompraLlegadaDetalleDato("PcdEstado","3",$PedidoCompraLlegadaDetalleId);					
							
							}else{
								
								$EncontroCodigo = false;

								$InsOrdenCompra = new ClsOrdenCompra();
								$InsOrdenCompra->OcoId = $OrdenCompraId;
								$InsOrdenCompra->MtdObtenerOrdenCompra();
	
								if(!empty($InsOrdenCompra->OrdenCompraPedido)){
									foreach($InsOrdenCompra->OrdenCompraPedido as $DatOrdenCompraPedido){
	
										$InsPedidoCompra = new ClsPedidoCompra();
										$InsPedidoCompra->PcoId = $DatOrdenCompraPedido->PcoId;
										$InsPedidoCompra->MtdObtenerPedidoCompra();
										
										if(!empty($InsPedidoCompra->PedidoCompraDetalle)){
											foreach($InsPedidoCompra->PedidoCompraDetalle as $DatPedidoCompraDetalle){
	
												if( trim($ProductoCodigoOriginal) == trim($DatPedidoCompraDetalle->ProCodigoOriginal) ){
											
													$InsPedidoCompraLlegadaDetalle1 = new ClsPedidoCompraLlegadaDetalle();	
													
													$InsPedidoCompraLlegadaDetalle1->PcdId = $DatPedidoCompraDetalle->PcdId;
													$InsPedidoCompraLlegadaDetalle1->ProId = $DatPedidoCompraDetalle->ProId;
													
													$InsPedidoCompraLlegadaDetalle1->PldOrdenCompraId = $OrdenCompraId;
													$InsPedidoCompraLlegadaDetalle1->PldOrdenCompraFecha = NULL;
													
													$InsPedidoCompraLlegadaDetalle1->PldCantidad = $PedidoCompraLlegadaDetalleCantidad;			
													$InsPedidoCompraLlegadaDetalle1->PldComprobanteNumero = NULL;			
													$InsPedidoCompraLlegadaDetalle1->PldComprobanteFecha = NULL;						
													$InsPedidoCompraLlegadaDetalle1->PldImporte = 0;									
	
													$InsPedidoCompraLlegadaDetalle1->PldEstado = 1;									
													$InsPedidoCompraLlegadaDetalle1->PldTiempoCreacion = date("Y-m-d H:i:s");
													$InsPedidoCompraLlegadaDetalle1->PldTiempoModificacion = date("Y-m-d H:i:s");					
													$InsPedidoCompraLlegadaDetalle1->PldEliminado = 1;
													
													//$InsPedidoCompraLlegada->PedidoCompraLlegadaDetalle[] = $InsPedidoCompraLlegadaDetalle1;
?>
	
                                                    <span class="EstImportarFila">
                                                    
                                                    <b>Producto:</b> <?php echo $DatPedidoCompraDetalle->ProCodigoOriginal;?> - <?php echo $DatPedidoCompraDetalle->ProNombre;?><br />
                                                    <b>Orden Venta:</b> <?php echo $InsPedidoCompra->VdiId;?> - <?php echo $InsPedidoCompra->CliNombre;?><br />
                                                    <b>O.C. Ref.: </b> <?php echo $InsPedidoCompra->VdiOrdenCompraNumero;?>
                                                    
                                                    </span>
                                                    
                                                    <br />
                                                    <br />
	
	<?php										
													$EncontroCodigo = true;
													break;
												}
												
	
											} 
										}
										
									}
									
								}
	?>
	
	<?php
								if(!$EncontroCodigo){
	
				
								}
							
							}
							
							
							
							
?>  
                            
                            
                                          
<?php
						}else{
?>
							<span class="EstImportarRegistrarNo">No se pudo registrar, codigo original u orden de compra no identificada</span><br />
<?php	
						}
						
				?>

				
				-
				<hr />
				<?php	
				
					 $fila++;
				} 

				if(!empty($InsPedidoCompraLlegada->PedidoCompraLlegadaDetalle)){
					
					if($InsPedidoCompraLlegada->MtdRegistrarPedidoCompraLlegada()){
				?>
						
                        Se registro la llegada de repuestos.
                        
                <?php	
					}else{
				?>
						
                        No se pudo registrar la llegada de repuestos.
                        
                <?php		
					}
					
				}
				
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
    
    
    
    
    PROCESO TERMINADO<br />
<?php echo date("d/m/Y H:i:s");?><br />