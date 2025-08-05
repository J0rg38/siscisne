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
Nombre: JS Calendar
Descripcion: Libreria para generar menu de calendario.
-->
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar-blue.css" title="winter" />
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar-setup.js"></script>


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

$POST_Fecha = (empty($_POST['CmpFecha'])?date("d/m/Y"):$_POST['CmpFecha']);

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsPedidoCompraLlegada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsPedidoCompraLlegadaDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');

$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoReemplazo = new ClsProductoReemplazo();


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
    
<input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php echo $POST_Fecha?>" size="10" maxlength="10" readonly="readonly" />
<img src="../../../imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
               
               
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
				$InsPedidoCompraLlegada->PleFecha = FncCambiaFechaAMysql($POST_Fecha);
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
						
						if( ($r[$columna]) == "Número de Parte" ){
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

						if( ($r[$columna]) == "Nombre de Pedido" ){
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

						if( ($r[$columna]) == "Unidades Facturadas" ){
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

						if( ($r[$columna]) == "Factura Electrónica" ){
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

						if( ($r[$columna]) == "Fecha de Factura" ){
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

						if( ($r[$columna]) == "Total" ){
							$inicio_columnaF = $columna;
							$inicio_filaF = $fila;
							break;
						}

					}
					$fila++;
				}
				
				
				
				
				$fila = 0;
				$inicio_filaG = 0;
				$inicio_columnaG = 0;

				foreach( $xlsx->rows() as $r ) { 

					for( $columna = 0; $columna < $num_cols; $columna++ ) {

						if( ($r[$columna]) == "Descripción" ){
							$inicio_columnaG = $columna;
							$inicio_filaG = $fila;
							break;
						}

					}
					$fila++;
				}
				
				
				
				
				
				$fila = 0;
				$inicio_filaH = 0;
				$inicio_columnaH = 0;

				foreach( $xlsx->rows() as $r ) { 

					for( $columna = 0; $columna < $num_cols; $columna++ ) {

						if( ($r[$columna]) == "Guia Remisión" ){
							$inicio_columnaH = $columna;
							$inicio_filaH = $fila;
							break;
						}

					}
					$fila++;
				}
			
			
				$fila = 0;
				$inicio_filaI = 0;
				$inicio_columnaI = 0;

				foreach( $xlsx->rows() as $r ) { 

					for( $columna = 0; $columna < $num_cols; $columna++ ) {

						if( ($r[$columna]) == "Despacho" ){
							$inicio_columnaI = $columna;
							$inicio_filaI = $fila;
							break;
						}

					}
					$fila++;
				}
				
				
				$fila = 0;
				$inicio_filaJ = 0;
				$inicio_columnaJ = 0;

				foreach( $xlsx->rows() as $r ) { 

					for( $columna = 0; $columna < $num_cols; $columna++ ) {

						if( ($r[$columna]) == "Observación" ){
							$inicio_columnaJ = $columna;
							$inicio_filaJ = $fila;
							break;
						}

					}
					$fila++;
				}				
				
				
				$ProductoCodigoOriginalImportado = "";
				$OrdenCompraId = "";
				$PedidoCompraLlegadaDetalleCantidad = 0;
				$ProductoNombre = "";
				
				$GuiaRemisionNumero = "";
				$GuiaRemisionFecha = "";
				
				$ComprobanteNumero = "";
				$ComprobanteFecha = "";
				$Observacion = "";				
				
				$Importe = 0;
				
				$fila = 1;
				foreach( $xlsx->rows() as $r ) { 
				
					$ProductoCodigoOriginalImportado = "";
					$OrdenCompraId = "";
					$PedidoCompraLlegadaDetalleCantidad = 0;
					$ProductoNombre = "";
					
					$GuiaRemisionNumero = "";
					$GuiaRemisionFecha = "";
					
					$ComprobanteNumero = "";
					$ComprobanteFecha = "";
					$Observacion = "";	
				
					
						for( $columna=0; $columna < $num_cols; $columna++ ) {

							if($columna == $inicio_columnaA){
								$ProductoCodigoOriginalImportado  =  trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							}
							
							if($columna == $inicio_columnaB){
								$OrdenCompraId  = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
								$OrdenCompraId = eregi_replace("-AC","",$OrdenCompraId);
							}
							
							if($columna == $inicio_columnaC){
								$PedidoCompraLlegadaDetalleCantidad = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							}
							
							if($columna == $inicio_columnaD){
								$ComprobanteNumero = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
								//$ComprobanteNumero = substr ($ComprobanteNumero,5);
								//$ComprobanteNumero = "004-".$ComprobanteNumero;
							}
							
							if($columna == $inicio_columnaE){
								$ComprobanteFecha = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
								
								$ComprobanteFechaDia = substr ($ComprobanteFecha,6,2);
								$ComprobanteFechaMes = substr ($ComprobanteFecha,4,2);
								$ComprobanteFechaAno = substr ($ComprobanteFecha,0,4);
								
								$ComprobanteFecha = $ComprobanteFechaAno."-".$ComprobanteFechaMes."-".$ComprobanteFechaDia;
							}

							if($columna == $inicio_columnaF){

								$Importe = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
								
							}
							
							if($columna == $inicio_columnaG){

								$ProductoNombre = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
								
							}
							
							if($columna == $inicio_columnaH){

								$GuiaRemisionNumero = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
								
							}
													
							if($columna == $inicio_columnaI){

								$GuiaRemisionFecha = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
								
	//$UNIX_DATE = ($GuiaRemisionFecha - 25569) * 86400;
//$GuiaRemisionFecha = gmdate("Y-m-d", $UNIX_DATE);
								
							}
							
							if($columna == $inicio_columnaJ){

								$Observacion = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
								
							}

							
						}
						
?>

[Fila <?php echo $fila;?>]> 

<?php

//echo $ProductoCodigoOriginalImportado;
//echo $GuiaRemisionFecha." :::";
//echo "<br>";
						if(!empty($ProductoCodigoOriginalImportado) and !empty($OrdenCompraId) and !empty($PedidoCompraLlegadaDetalleCantidad)){
							
							$EncontroCodigo = false;
							//$EncontroReemplazo = false;
							//$RegistroNuevoProducto = false;

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
											
											//deb($DatPedidoCompraDetalle->PcdCantidadPendiente."aas");
											//if($ProductoCodigoOriginalImportado == trim($DatPedidoCompraDetalle->ProCodigoOriginal) and $DatPedidoCompraDetalle->PcdCantidadPendiente>0){
											if( $ProductoCodigoOriginalImportado == trim($DatPedidoCompraDetalle->ProCodigoOriginal) ){												
												
												if($DatPedidoCompraDetalle->PcdCantidadPendiente<$PedidoCompraLlegadaDetalleCantidad){
													$PedidoCompraLlegadaDetalleCantidad = $PedidoCompraLlegadaDetalleCantidad - $DatPedidoCompraDetalle->PcdCantidadPendiente;
												}

												$InsPedidoCompraLlegadaDetalle1 = new ClsPedidoCompraLlegadaDetalle();	
												$InsPedidoCompraLlegadaDetalle1->PcdId = $DatPedidoCompraDetalle->PcdId;
												$InsPedidoCompraLlegadaDetalle1->ProId = $DatPedidoCompraDetalle->ProId;
												
												$InsPedidoCompraLlegadaDetalle1->PldOrdenCompraId = $OrdenCompraId;
												$InsPedidoCompraLlegadaDetalle1->PldOrdenCompraFecha = NULL;
												
												$InsPedidoCompraLlegadaDetalle1->PldCantidad = $PedidoCompraLlegadaDetalleCantidad;		
												$InsPedidoCompraLlegadaDetalle1->PldCantidadEntregada = $PedidoCompraLlegadaDetalleCantidad;		
												$InsPedidoCompraLlegadaDetalle1->PldComprobanteNumero = $ComprobanteNumero;			
												$InsPedidoCompraLlegadaDetalle1->PldComprobanteFecha = $ComprobanteFecha;	
												
												$InsPedidoCompraLlegadaDetalle1->PldGuiaRemisionNumero = $GuiaRemisionNumero;			
												$InsPedidoCompraLlegadaDetalle1->PldGuiaRemisionFecha = FncCambiaFechaAMysql($GuiaRemisionFecha);		
																	
												$InsPedidoCompraLlegadaDetalle1->PldImporte = $Importe;		
												$InsPedidoCompraLlegadaDetalle1->PldObservacion = $Observacion;									

												$InsPedidoCompraLlegadaDetalle1->PldEstado = 1;									
												$InsPedidoCompraLlegadaDetalle1->PldTiempoCreacion = date("Y-m-d H:i:s");
												$InsPedidoCompraLlegadaDetalle1->PldTiempoModificacion = date("Y-m-d H:i:s");					
												$InsPedidoCompraLlegadaDetalle1->PldEliminado = 1;
												
												$InsPedidoCompraLlegada->PedidoCompraLlegadaDetalle[] = $InsPedidoCompraLlegadaDetalle1;
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
												//break;
											}
											

										} 
									}
									
								}
								
							}
?>

<?php
                            if(!$EncontroCodigo){
?>
                                <span class="EstImportarRegistrarSi">No se pudo encontrar el codigo original <?php echo $ProductoCodigoOriginalImportado;?>, se buscara codigos de reemplazo en la lista...</span><br />	
                                
                                <?php		
								//BUSCANDO REEMPLAZOS								
                                $InsProductoReemplazo = new ClsProductoReemplazo();
                                $ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10","esigual",$ProductoCodigoOriginalImportado ,"PreId","ASC",NULL,"1");
                                $ArrProductoReemplazos = $ResProductoReemplazo['Datos'];
								?>

<?php
								//REEMPLAZOS ENCONTRADOS
								if(!empty($ArrProductoReemplazos)){
?>										
											
									<span class="EstImportarRegistrarNo">Se encontro posible codigo de reemplazo </span><br />

<?php												
									$ReemplazoConfirmado = false;
									$PedidoCompraDetalleId = "";
													
									$VentaDirectaId = "";
									$ClienteNombre = "";
									$VentaDirectaOrdenCompraNumero = "";
									$ProductoNombre  = "";
									$ProductoCodigoOriginal = "";

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
													
													foreach($ArrProductoReemplazos as $DatProductoReemplazo){
													
														  if(
														  $DatProductoReemplazo->PreCodigo1 == $DatPedidoCompraDetalle->ProCodigoOriginal or
														  $DatProductoReemplazo->PreCodigo2 == $DatPedidoCompraDetalle->ProCodigoOriginal or
														  $DatProductoReemplazo->PreCodigo3 == $DatPedidoCompraDetalle->ProCodigoOriginal or
														  $DatProductoReemplazo->PreCodigo4 == $DatPedidoCompraDetalle->ProCodigoOriginal or
														  $DatProductoReemplazo->PreCodigo5 == $DatPedidoCompraDetalle->ProCodigoOriginal or
														  $DatProductoReemplazo->PreCodigo6 == $DatPedidoCompraDetalle->ProCodigoOriginal or
														  $DatProductoReemplazo->PreCodigo7 == $DatPedidoCompraDetalle->ProCodigoOriginal or
														  $DatProductoReemplazo->PreCodigo8 == $DatPedidoCompraDetalle->ProCodigoOriginal or
														  $DatProductoReemplazo->PreCodigo9 == $DatPedidoCompraDetalle->ProCodigoOriginal or
														  $DatProductoReemplazo->PreCodigo10 == $DatPedidoCompraDetalle->ProCodigoOriginal 
														  
														  ){
															
															$ReemplazoConfirmado = true;
															$PedidoCompraDetalleId = $DatPedidoCompraDetalle->PcdId;
															$VentaDirectaId =  $InsPedidoCompra->VdiId;
															$ClienteNombre = $InsPedidoCompra->CliNombre." ".$InsPedidoCompra->CliApellidoPaterno." ".$InsPedidoCompra->CliApellidoMaterno;
															$VentaDirectaOrdenCompraNumero = $InsPedidoCompra->VdiOrdenCompraNumero;
															$ProductoNombre = $DatPedidoCompraDetalle->ProNombre;
															$ProductoCodigoOriginal = $DatPedidoCompraDetalle->ProCodigoOriginal;
															
															break;
                                                             
														  }
													
													}
													
												}
											}
											
										}
									}
	
									if($ReemplazoConfirmado){
	?>					
										<span class="EstImportarRegistrarNo">Codigo de reemplazo identificado <?php echo $ProductoCodigoOriginalImportado;?> </span><br />
	
	<?php
										$InsProducto = new ClsProducto();
										$ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$ProductoCodigoOriginalImportado,'ProId','Desc',"1",NULL,NULL,1,NULL,NULL,NULL,NULL,false);
										$ArrProductos = $ResProducto['Datos'];
		
										$ProductoId = "";
		
										if(empty($ArrProductos)){
		
	?>
											<span class="EstImportarRegistrarSi">No se encontro el codigo de reemplazo registrado en sistema, se procedera a registrar automaticamente... </span><br />
	
	<?php
											$InsProducto = new ClsProducto();
											$InsProducto->UsuId = $_SESSION['SesionId'];
											$InsProducto->ProCodigoAlternativo = "";
											$InsProducto->ProCodigoOriginal = $ProductoCodigoOriginalImportado;
											$InsProducto->ProNombre = $ProductoNombre;
											$InsProducto->ProUbicacion = "-";
											$InsProducto->ProReferencia = "Producto registrado automaticamente por despacho ".date("d/m/Y");
											$InsProducto->ProEspecificacion = "";
											
											$InsProducto->UmeId = "UME-10007";
											$InsProducto->UmeIdIngreso = "UME-10007";
										
											$InsProducto->ProCodigoBarra = $ProductoCodigoOriginalImportado;
											$InsProducto->ProStockMinimo = 1;
											$InsProducto->ProValidarUso = 1;
										
											$InsProducto->ProPeso = 0;
																		
											$InsProducto->ProLargo= 0;
											$InsProducto->ProAncho = 0;
											$InsProducto->ProAlto = 0;
											$InsProducto->ProVolumen = 0;
			
		
		
																$InsProducto->RtiId = "RTI-10000";	
																$InsProducto->ProFoto = "";
																$InsProducto->ProValidarStock = 1;	
																$InsProducto->ProTienePromocion = 2;	
											$InsProducto->ProCalcularPrecio = 2;	
											
																$InsProducto->ProEstado = 1;	
																$InsProducto->ProTiempoCreacion = date("Y-m-d H:i:s");
																$InsProducto->ProTiempoModificacion = date("Y-m-d H:i:s");
																$InsProducto->ProEliminado = 1;
	
	
	
		$Disponible = 0;
		$Cantidad = 0;
	
		if(!empty($InsProducto->ProCodigoOriginal)){
		
			$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
			$ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",trim($InsProducto->ProCodigoOriginal) ,"PdiTiempoCreacion","DESC","1",1);
			$ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
			
			//$Disponibilidad = "";
			
			
			if(!empty($ArrProductoDisponibilidades)){
				foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
	
					$Disponible =  ($DatProductoDisponibilidad->PdiDisponible);
					$Cantidad =  ($DatProductoDisponibilidad->PdiCantidad);
	
				}
			}
			
			
		}
		
		$InsProducto->ProTieneDisponibilidadGM = $Disponible;
		$InsProducto->ProDisponibilidadCantidadGM = $Cantidad;
		
			
		$Reemplazo = "NO";
		
		if(!empty($InsProducto->ProCodigoOriginal)){
	
			 $ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10","esigual",trim($InsProducto->ProCodigoOriginal) ,"PreId","ASC",NULL,1);
			$ArrProductoReemplazos = $ResProductoReemplazo['Datos'];
			
			if(!empty($ArrProductoReemplazos)){
				$Reemplazo= "SI";
			}
		
		}
		
		$InsProducto->ProTieneReemplazoGM = $Reemplazo;
		
		
		
		
											if($InsProducto->MtdRegistrarProducto()){
	
												$ProductoId = $InsProducto->ProId;
	?>
												<span class="EstImportarRegistrarSi">Se registro correctamente el producto nuevo</span><br />
	
	<?php
											}else{
	?>																
												<span class="EstImportarRegistrarNo">No se pudo registrar el producto nuevo. PROCESO CANCELADO </span><br />
	
	<?php
											}
	
										}else{
											
											foreach($ArrProductos as $DatProducto){
												
												$ProductoId  = $DatProducto->ProId;
												
											}
										
										}
																	
										if(!empty($ProductoId)){
	
											$InsPedidoCompraLlegadaDetalle1 = new ClsPedidoCompraLlegadaDetalle();	
											$InsPedidoCompraLlegadaDetalle1->PcdId = $PedidoCompraDetalleId;
											$InsPedidoCompraLlegadaDetalle1->ProId = $ProductoId;
											$InsPedidoCompraLlegadaDetalle1->PldCantidad = $PedidoCompraLlegadaDetalleCantidad;	
											$InsPedidoCompraLlegadaDetalle1->PldCantidadEntregada = $PedidoCompraLlegadaDetalleCantidad;	
											
											$InsPedidoCompraLlegadaDetalle1->PldComprobanteNumero = $ComprobanteNumero;			
											$InsPedidoCompraLlegadaDetalle1->PldComprobanteFecha = $ComprobanteFecha;	
											$InsPedidoCompraLlegadaDetalle1->PldImporte = $Importe;
											
											$InsPedidoCompraLlegadaDetalle1->PldEstado = 1;									
											$InsPedidoCompraLlegadaDetalle1->PldTiempoCreacion = date("Y-m-d H:i:s");
											$InsPedidoCompraLlegadaDetalle1->PldTiempoModificacion = date("Y-m-d H:i:s");					
											$InsPedidoCompraLlegadaDetalle1->PldEliminado = 1;
											
											$InsPedidoCompraLlegada->PedidoCompraLlegadaDetalle[] = $InsPedidoCompraLlegadaDetalle1;
											
	?>
											<span class="EstImportarFila">
																	   
											<b>Producto:</b> <?php echo $ProductoCodigoOriginal;?> reemplazado por <?php echo $ProductoCodigoOriginalImportado;?> - <?php echo $ProductoNombre;?><br />
											<b>Orden Venta:</b> <?php echo $VentaDirectaId;?> - <?php echo $ClienteNombre;?><br />
											<b>O.C. Ref.: </b> <?php echo $VentaDirectaOrdenCompraNumero;?>
											
											</span>
	
											<br />
											<br />
	
	<?php
										}
	
									}else{
	?>		
	
										<span class="EstImportarRegistrarNo">Codigo de reemplazo NO identificado <?php echo $ProductoCodigoOriginalImportado;?>. PROCESO CANCELADO </span><br />
	
	<?php									
										$InsProducto = new ClsProducto();
										$ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$ProductoCodigoOriginalImportado,'ProId','Desc',"1",NULL,NULL,1,NULL,NULL,NULL,NULL,false);
										$ArrProductos = $ResProducto['Datos'];
		
										$ProductoId = "";
										
										if(empty($ArrProductos)){
	
											$InsProducto = new ClsProducto();
											$InsProducto->ProCodigoAlternativo = "";
											$InsProducto->ProCodigoOriginal = $ProductoCodigoOriginalImportado;
											$InsProducto->ProNombre = "CODIGO NO IDENTIFICADO";
											$InsProducto->ProUbicacion = "-";
											$InsProducto->ProReferencia = "Producto registrado automaticamente por despacho ".date("d/m/Y");
											$InsProducto->ProEspecificacion = "";
											
											$InsProducto->UmeId = "UME-10007";
											$InsProducto->UmeIdIngreso = "UME-10007";
										
											$InsProducto->ProCodigoBarra = $ProductoCodigoOriginalImportado;
											$InsProducto->ProStockMinimo = 1;
											$InsProducto->ProValidarUso = 1;
										
											$InsProducto->ProPeso = 0;
																		
											$InsProducto->ProLargo= 0;
											$InsProducto->ProAncho = 0;
											$InsProducto->ProAlto = 0;
											$InsProducto->ProVolumen = 0;
			
											$InsProducto->RtiId = "RTI-10000";	
											$InsProducto->ProFoto = "";
											$InsProducto->ProValidarStock = 1;	
											
											$InsProducto->ProTienePromocion = 2;	
											$InsProducto->ProCalcularPrecio = 2;	
											
											$InsProducto->ProEstado = 1;	
											$InsProducto->ProTiempoCreacion = date("Y-m-d H:i:s");
											$InsProducto->ProTiempoModificacion = date("Y-m-d H:i:s");
											$InsProducto->ProEliminado = 1;
																
											if($InsProducto->MtdRegistrarProducto()){
	
												$ProductoId = $InsProducto->ProId;
	?>
												<span class="EstImportarRegistrarSi">Se registro correctamente el producto nuevo</span><br />
	
	<?php
											}else{
	?>																
												<span class="EstImportarRegistrarNo">No se pudo registrar el producto nuevo. PROCESO CANCELADO </span><br />
	
	<?php
											}
											
										}
											
										  if(!empty($ProductoId)){
											  
											  $InsPedidoCompraLlegadaDetalle1 = new ClsPedidoCompraLlegadaDetalle();	
											  $InsPedidoCompraLlegadaDetalle1->PcdId = NULL;
											  $InsPedidoCompraLlegadaDetalle1->ProId = $ProductoId;
											  
											  $InsPedidoCompraLlegadaDetalle1->PldOrdenCompraId = $OrdenCompraId;
											  $InsPedidoCompraLlegadaDetalle1->PldOrdenCompraFecha = NULL;
											  
											  $InsPedidoCompraLlegadaDetalle1->PldCantidad = $PedidoCompraLlegadaDetalleCantidad;			
											  $InsPedidoCompraLlegadaDetalle1->PldCantidadEntregada = $PedidoCompraLlegadaDetalleCantidad;			
											  $InsPedidoCompraLlegadaDetalle1->PldComprobanteNumero = $ComprobanteNumero;			
											  $InsPedidoCompraLlegadaDetalle1->PldComprobanteFecha = $ComprobanteFecha;						
											  $InsPedidoCompraLlegadaDetalle1->PldImporte = $Importe;									
		
											  $InsPedidoCompraLlegadaDetalle1->PldEstado = 1;									
											  $InsPedidoCompraLlegadaDetalle1->PldTiempoCreacion = date("Y-m-d H:i:s");
											  $InsPedidoCompraLlegadaDetalle1->PldTiempoModificacion = date("Y-m-d H:i:s");					
											  $InsPedidoCompraLlegadaDetalle1->PldEliminado = 1;
											  
											  $InsPedidoCompraLlegada->PedidoCompraLlegadaDetalle[] = $InsPedidoCompraLlegadaDetalle1;
											  
										  }
										  
											
											
											
						
									}
													
								}

			
?>
                                
                                
                                
                                
                                
                                
                                
                                
                                
<?php                 
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

<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del botón que  
	});


</script>

	</form>
    
    
    
    
    PROCESO TERMINADO<br />
<?php echo date("d/m/Y H:i:s");?><br />