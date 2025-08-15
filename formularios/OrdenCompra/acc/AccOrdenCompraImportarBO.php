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

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');
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
	$targetPath = '../../../subidos/backorder_excel/';
	
	
	$targetFile =  str_replace('//','/',$targetPath) . ($file_name);	
	
	$ext = pathinfo($targetFile, PATHINFO_EXTENSION);
	$file_name = date("d-m-Y")."_ARCHIVO1_".$Identificador.".".$ext;
	
	$targetFile =  str_replace('//','/',$targetPath) . $file_name;	
	
	//$targetFile =  str_replace('//','/',$targetPath) . date("d-m-Y").'_P_'.(FncLimpiarCaracteresEspeciales($file_name));	
	echo 'Nombre de Archivo: '.$file_name;
	echo '<br />';

	if (move_uploaded_file($tempFile,$targetFile)){

		$path = $targetFile;
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		
		switch($ext){
		
			case "xls":


				/*$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
				
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
			*/


			break;
			
			case "xlsx":

				
				$xlsx = new SimpleXLSX($targetFile); 

				list($num_cols, $num_rows) = $xlsx->dimension(); 

				$fila = 0;
				$inicio_filaA = 0;
				$inicio_columnaA = 0;

				foreach( $xlsx->rows() as $r ) { 
					
					for( $columna = 0; $columna < $num_cols; $columna++ ) {

						if( strtoupper($r[$columna]) == "PN SOLICITADA" ){
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

						if( strtoupper($r[$columna]) == "PEDIDO DEALER" ){
							$inicio_columnaB = $columna;
							$inicio_filaB = $fila;
							break;
						}

					}
					$fila++;
				}
				
				
				
				
				
				
			//	$fila = 0;
//				$inicio_filaC = 0;
//				$inicio_columnaC = 0;
//
//				foreach( $xlsx->rows() as $r ) { 
//
//					for( $columna = 0; $columna < $num_cols; $columna++ ) {
//
//						if( strtoupper($r[$columna]) == "STATUS" ){
//							$inicio_columnaC = $columna;
//							$inicio_filaC = $fila;
//							break;
//						}
//
//					}
//					$fila++;
//				}
//				
//				
//				$fila = 0;
//				$inicio_filaD = 0;
//				$inicio_columnaD = 0;
//
//				foreach( $xlsx->rows() as $r ) { 
//
//					for( $columna = 0; $columna < $num_cols; $columna++ ) {
//										
//						if( strtoupper($r[$columna]) == "FECHA APROX. DESPACHO" ){
//							$inicio_columnaD = $columna;
//							$inicio_filaD = $fila;
//							break;
//						}
//
//					}
//					$fila++;
//				}
//				
				
				$fila = 0;
				$inicio_filaE = 0;
				$inicio_columnaE = 0;

				foreach( $xlsx->rows() as $r ) { 

					for( $columna = 0; $columna < $num_cols; $columna++ ) {
										
						if( strtoupper($r[$columna]) == "CANTIDAD EN BO" ){
							$inicio_columnaE = $columna;
							$inicio_filaE = $fila;
							break;
						}

					}
					$fila++;
				}
				
//				echo "inicio_filaE: ".$inicio_filaE;
//				echo "<br>";
//				
//				echo "inicio_columnaE: ".$inicio_columnaE;
//				echo "<br>";
				
				$inicio_filaF = $inicio_filaE;
				$inicio_columnaF = $inicio_columnaE+1;
				
//				echo "inicio_filaF: ".$inicio_filaF;
//				echo "<br>";
//				
//				echo "inicio_columnaF: ".$inicio_columnaF;
//				echo "<br>";
				
				$inicio_filaG = $inicio_filaE;
				$inicio_columnaG = $inicio_columnaE+2;
				
			//		echo "inicio_filaG: ".$inicio_filaG;
//				echo "<br>";
//				
//				echo "inicio_columnaG: ".$inicio_columnaG;
//				echo "<br>";
				
				$inicio_filaH = $inicio_filaE;
				$inicio_columnaH = $inicio_columnaE;
				
				$inicio_filaI = $inicio_filaE;
				$inicio_columnaI = $inicio_columnaE+4;
				
				$inicio_filaJ = $inicio_filaE;
				$inicio_columnaJ = $inicio_columnaE+5;
				
				$inicio_filaK = $inicio_filaE;
				$inicio_columnaK = $inicio_columnaE+6;
				
				
			//deb($inicio_columnaD." - ".$inicio_filaD);
			
				
				
				$fila = 1;
				foreach( $xlsx->rows() as $r ) { 
					
					
				$ProductoCodigoOriginalImportado = "";
				$PedidoDealer = "";
				$StatusFinal = "";
				$FechaFinal = "";
				
					for( $columna=0; $columna < $num_cols; $columna++ ) {
						
						if($columna == $inicio_columnaA){
							$ProductoCodigoOriginalImportado  =  trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
						}
	
						if($columna == $inicio_columnaB){
							$PedidoDealer  = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
						}
	
					//	if($columna == $inicio_columnaC){
//							$Status = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
//						}
//						
						//$Fecha = "";
//						
////deb($columna." a-a ".$inicio_columnaD);
//						if($columna == $inicio_columnaD){
//							//$Fecha = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
//							$Dias = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
//							
//							if($Dias!="EN BO"){
//								
//								list($Dia,$Mes,$Ano) = explode("/",$Dias);
//								
//								if(empty($Dia) or empty($Mes) or empty($Ano)){
//									
//									if(!empty($Dias)){
//										
//										$Fecha = strtotime ('+'.($Dias-2).' days' , strtotime ( "1900-01-01" )) ;
//										$Fecha = date ('Y-m-d' , $Fecha );
//										
//									}else{
//										
//										$Fecha = "";
//									}
//									
//								}else{
//									$Fecha = $Dias;
//								}	
//
//							}else{
//								$Fecha = "";	
//							}
//							
//							
//							
//							
//						}

						$Fecha1 = "";
						$Status1 = "";
//deb($columna." a-a ".$inicio_columnaF);
						if($columna == $inicio_columnaF){
							//$Fecha = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							$EXCEL_DATE = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							
							if($EXCEL_DATE!="EN BO" and $EXCEL_DATE!="1"){	
							
								$UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
								$EXCEL_DATE = 25569 + ($UNIX_DATE / 86400);
								$UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
								
								$Fecha1 =  gmdate("Y-m-d", $UNIX_DATE);

								//list($Dia,$Mes,$Ano) = explode("/",$Dias);
//								
//								if(!empty($Dia) and !empty($Mes) and !empty($Ano)){									
//									$Fecha1 = $Ano."-".$Mes."-".$Dia;									
//								}else{									
//									$Fecha1 = "";									
//								}	
							}else{
								$Fecha1 = "";	
								$Status1 = "EN BO";
							}
							
						}
						
						$Fecha2 = "";
						$Status2 = "";
//deb($columna." a-a ".$inicio_columnaG);
						if($columna == $inicio_columnaG){
							//$Fecha = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							$EXCEL_DATE = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							
							
							if($EXCEL_DATE!="EN BO" and $EXCEL_DATE!="1"){
							
								$UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
								$EXCEL_DATE = 25569 + ($UNIX_DATE / 86400);
								$UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
								
								$Fecha2 =  gmdate("Y-m-d", $UNIX_DATE);
											
								//list($Dia,$Mes,$Ano) = explode("/",$Dias);
//								
//								if(!empty($Dia) and !empty($Mes) and !empty($Ano)){									
//									$Fecha2 = $Ano."-".$Mes."-".$Dia;									
//								}else{									
//									$Fecha2 = "";									
//								}	
							}else{
								$Fecha2 = "";	
								$Status2 = "EN BO";
							}
							
						}
						
						//deb($Fecha2);
						
						
						$Fecha3 = "";
						$Status3 = "";
//deb($columna." a-a ".$inicio_columnaD);
						if($columna == $inicio_columnaH){
							//$Fecha = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							$EXCEL_DATE = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							//deb($EXCEL_DATE);
							
							if($EXCEL_DATE!="EN BO" and $EXCEL_DATE!="1"){
								
								//echo "LARVA A";
								$UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
								$EXCEL_DATE = 25569 + ($UNIX_DATE / 86400);
								$UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
								
								$Fecha3 =  gmdate("Y-m-d", $UNIX_DATE);
											
								//list($Dia,$Mes,$Ano) = explode("/",$Dias);
//								
//								if(!empty($Dia) and !empty($Mes) and !empty($Ano)){									
//									$Fecha3 = $Ano."-".$Mes."-".$Dia;									
//								}else{									
//									$Fecha3 = "";									
//								}	

							}else{
								//echo "LARVA B";
								$Fecha3 = "";	
								$Status3 = "EN BO";
							}
							
						}


						$Fecha4 = "";
						$Status4 = "";
//deb($columna." a-a ".$inicio_columnaD);
						if($columna == $inicio_columnaI){
							//$Fecha = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							$EXCEL_DATE = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							
							if($EXCEL_DATE!="EN BO" and $EXCEL_DATE!="1"){		
							
							
								$UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
								$EXCEL_DATE = 25569 + ($UNIX_DATE / 86400);
								$UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
								
								$Fecha4 =  gmdate("Y-m-d", $UNIX_DATE);
															
								//list($Dia,$Mes,$Ano) = explode("/",$Dias);
//								
//								if(!empty($Dia) and !empty($Mes) and !empty($Ano)){									
//									$Fecha4 = $Ano."-".$Mes."-".$Dia;									
//								}else{									
//									$Fecha4 = "";									
//								}	
							}else{
								$Fecha4 = "";	
								$Status4 = "EN BO";
							}
							
						}

						$Fecha5 = "";
						$Status5 = "";
//deb($columna." a-a ".$inicio_columnaD);
						if($columna == $inicio_columnaJ){
							//$Fecha = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							$EXCEL_DATE = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							
							if($EXCEL_DATE!="EN BO" and $EXCEL_DATE!="1"){
							
								$UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
								$EXCEL_DATE = 25569 + ($UNIX_DATE / 86400);
								$UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
								
								$Fecha5 =  gmdate("Y-m-d", $UNIX_DATE);	
								//list($Dia,$Mes,$Ano) = explode("/",$Dias);
//								
//								if(!empty($Dia) and !empty($Mes) and !empty($Ano)){									
//									$Fecha5 = $Ano."-".$Mes."-".$Dia;									
//								}else{									
//									$Fecha5 = "";									
//								}	
							}else{
								$Fecha5 = "";	
								$Status5 = "EN BO";
							}
							
						}
						
						
						$Fecha6 = "";
						$Status6 = "";
//deb($columna." a-a ".$inicio_columnaD);
						if($columna == $inicio_columnaK){
							//$Fecha = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							$EXCEL_DATE = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							
							if($EXCEL_DATE!="EN BO" and $EXCEL_DATE!="1"){
							
								$UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
								$EXCEL_DATE = 25569 + ($UNIX_DATE / 86400);
								$UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
								
								$Fecha6 =  gmdate("Y-m-d", $UNIX_DATE);
														
								//list($Dia,$Mes,$Ano) = explode("/",$Dias);
//																
//								if(!empty($Dia) and !empty($Mes) and !empty($Ano)){									
//									$Fecha6 = $Ano."-".$Mes."-".$Dia;									
//								}else{									
//									$Fecha6 = "";									
//								}	

							}else{
								$Fecha6 = "";	
								$Status6 = "EN BO";
							}
							
						}
						
						
						
						
					}
					
					
						if(!empty($Fecha6)){
							//echo "Fecha6";
							//echo "<br>";
							$FechaFinal = $Fecha6;
							//$StatusFinal = $Status6;
						}else if(!empty($Fecha5)){
							//	echo "Fecha5";
							//echo "<br>";
							$FechaFinal = $Fecha5;
							//$StatusFinal = $Status5;
						}else if(!empty($Fecha4)){
							//	echo "Fecha4";
							//echo "<br>";
							$FechaFinal = $Fecha4;
							//$StatusFinal = $Status4;
						}else if(!empty($Fecha3)){
							//	echo "Fecha3";
							//echo "<br>";
							$FechaFinal = $Fecha3;
							//$StatusFinal = $Status3;
						}else if(!empty($Fecha2)){
							//echo "Fecha2";
							//echo "<br>";
							$FechaFinal = $Fecha2;
							//$StatusFinal = $Status2;
						}else if(!empty($Fecha1)){
							//	echo "Fecha1";
							//echo "<br>";
							$FechaFinal = $Fecha1;
							//$StatusFinal = $Status1;
						}else{
							
						}
						
						if(!empty($Status6)){
							echo "Fecha1";
							$Status6 = $Status6;
						}else if(!empty($Status5)){
							echo "Status5";
							$StatusFinal = $Status5;
						}else if(!empty($Status4)){
							echo "Status4";
							$StatusFinal = $Status4;
						}else if(!empty($Status3)){
							echo "Status3";
							$StatusFinal = $Status3;
						}else if(!empty($Status2)){
							echo "Status2";
							$StatusFinal = $Status2;
						}else if(!empty($Status1)){
							echo "Status1";
							$StatusFinal = $Status1;
						}else{
							
						}
						
						$PedidoDealer = preg_replace("/-AC/", "", $PedidoDealer);
			
						echo '[Fila '.$fila.']> ';					
						echo "<br>";
						echo "ProductoCodigoOriginalImportado: ".$ProductoCodigoOriginalImportado;
						echo "<br>";
						echo "PedidoDealer: ".$PedidoDealer;
						echo "<br>";
						echo "FechaFinal: ".$FechaFinal;
						echo "<br>";
						
						//if(!empty($ProductoCodigoOriginalImportado) and !empty($PedidoDealer) and !empty($FechaFinal)){
						if(!empty($ProductoCodigoOriginalImportado) and !empty($PedidoDealer)){
							
							$EncontroCodigo = false;
							
							$InsOrdenCompra = new ClsOrdenCompra();
							$InsOrdenCompra->OcoId = $PedidoDealer;
							$InsOrdenCompra->MtdObtenerOrdenCompra();

							if(!empty($InsOrdenCompra->OrdenCompraPedido)){
								foreach($InsOrdenCompra->OrdenCompraPedido as $DatOrdenCompraPedido){

									$InsPedidoCompra = new ClsPedidoCompra();
									$InsPedidoCompra->PcoId = $DatOrdenCompraPedido->PcoId;
									$InsPedidoCompra->MtdObtenerPedidoCompra();
									
									if(!empty($InsPedidoCompra->PedidoCompraDetalle)){
										foreach($InsPedidoCompra->PedidoCompraDetalle as $DatPedidoCompraDetalle){

											if($ProductoCodigoOriginalImportado == trim($DatPedidoCompraDetalle->ProCodigoOriginal)){
												
												//$InsPedidoCompraDetalle1 = new ClsPedidoCompraDetalle();
												$InsPedidoCompraDetalle1 = new ClsPedidoCompraDetalle();
												$InsPedidoCompraDetalle1->MtdEditarPedidoCompraDetalleDato("PcdBOTiempoCarga",date("Y-m-d H:i:s"),$DatPedidoCompraDetalle->PcdId);
												$InsPedidoCompraDetalle1->MtdEditarPedidoCompraDetalleDato("PcdBOFecha",($FechaFinal),$DatPedidoCompraDetalle->PcdId);
												$InsPedidoCompraDetalle1->MtdEditarPedidoCompraDetalleDato("PcdBOEstado",$StatusFinal,$DatPedidoCompraDetalle->PcdId);
												
												echo '<span class="EstImportarFila">';
												echo '<b>Producto:</b>'.$DatPedidoCompraDetalle->ProCodigoOriginal.' - '.$DatPedidoCompraDetalle->ProNombre.'<br>';
												echo '<b>Orden Venta:</b>'.$DatPedidoCompraDetalle->VdiId.' - '.$DatPedidoCompraDetalle->CliNombre.'<br>';
												echo '<b>O.C. Ref.:</b>'.$DatPedidoCompraDetalle->VdiOrdenCompraNumero.'<br>';
												echo '<b>Fecha llegada estimada: </b>'.FncCambiaFechaANormal($FechaFinal,true).'<br>';
												echo '<b>Status:</b>'.$StatusFinal.'<br>';
												echo '</span>';
												
												echo '<br />';
												echo '<br />';
																						
												$EncontroCodigo = true;
												//break;
											}
											
											
											

										} 
									}
									
								}
								
							}

                            if(!$EncontroCodigo){
								
								echo '<span class="EstImportarRegistrarNo">No se pudo encontrar el codigo original '.$ProductoCodigoOriginalImportado.'</span><br />';
                
							}

						}else{
							
							echo '<span class="EstImportarRegistrarNo">No se pudo registrar, codigo original u orden de compra no identificada</span><br />';
	
						}
					
				
				
				echo '		<hr />';	
					 $fila++;
				} 

			break;
			
			default:
			
			break;
			
		}
		
		


	} else {
		
		echo 'Hubo un error al subir el archivo';
	
		}

	
}
?></td>
</tr>
</table>

	</form>
    
    
<?php
echo "PROCESO TERMINADO<br />";
echo date("d/m/Y H:i:s");
echo "<br />";
?>