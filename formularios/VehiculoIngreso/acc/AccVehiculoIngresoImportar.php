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
<?php require_once($InsProyecto->MtdRutLibrerias().'JSON.php'); ?>
<?php require_once($InsProyecto->MtdRutLibrerias().'JSON2.php'); ?>

<?php

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');


$InsSucursal = new ClsSucursal();
//MtdObtenerSucursales($oCampo=NULL,$oFiltro=NULL,$oOrden = 'SucId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)
$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL,"INICIAL");
$ArrSucursales = $RepSucursal['Datos'];

$SucursalId = "";

if(!empty($ArrSucursales)){
	foreach($ArrSucursales as $DatSucursal){
		$SucursalId = $DatSucursal->SucId;
	}
}


?>
	<form method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td align="left" valign="top">

	<input type="file" id="CmpArchivo" name="CmpArchivo" />
	<input name="BtnEnviar" id="BtnEnviar" type="submit" value="Importar Excel" />

  
  </td>
</tr>
<tr>
	<td align="left" valign="top">


</td>
  </tr>
<tr>
  <td align="left" valign="top">
    <?php
if (!empty($_FILES)) {
	$tempFile = $_FILES['CmpArchivo']['tmp_name'];
	$file_name = strtolower($_FILES['CmpArchivo']['name']);	
	$targetPath = '../../../subidos/vehiculos/';
	$targetFile =  str_replace('//','/',$targetPath) . date("d-m-Y").'_P_'.($file_name);	
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
	
					$fila = 1;
					$inicio_fila = 0;
					$inicio_columna = 0;
	
					foreach( $xlsx->rows() as $r ) { 
	
						echo "[Fila_".$fila."]>";	
						echo "<br>";
						
						/*
						A CODIGO111111
						B PROVEEDOR
						C NOTA DE PEDIDO PROVEEDOR
						D NOTA DE PEDIDO CISNE
						E MARCA
						F MODELO
						G NOMBRE COMERCIAL
						H AÑO FABRICACIÓN	
						I AÑO MODELO	
						J COLOR EXTERIOR	
						K COLOR INTERIOR	
						L VIN	
						M NRO. MOTOR	
						N NRO. FACTURA	
						O VALOR FACTURADO	
						P UBICACIÓN
						*/
					
						/*
						A PROVEEDOR
						B NOTA DE PEDIDO PROVEEDOR
						C NOTA DE PEDIDO CISNE
						D CODIGO MATERIAL
						E MARCA
						F MODELO
						G NOMBRE COMERCIAL
						H AÑO FABRICACIÓN	
						I AÑO MODELO	
						J COLOR EXTERIOR	
						K COLOR INTERIOR	
						L VIN	
						M NRO. MOTOR	
						N NRO. FACTURA	
						O VALOR FACTURADO	
						P UBICACIÓN
						*/
						
						$Proveedor  = ( (!empty($r[0])) ? $r[0] : '' );
						$NotaPedidoProveedor  = ( (!empty($r[1])) ? $r[1] : '' );
						$NotaPedidoCisne  = ( (!empty($r[2])) ? $r[2] : '' );
						$CodigoIdentificador  = ( (!empty($r[3])) ? $r[3] : '' );
						
						$Marca  = ( (!empty($r[4])) ? $r[4] : '' );
						$Modelo  = ( (!empty($r[5])) ? $r[5] : '' );
						
						$NombreComercial  = ( (!empty($r[6])) ? $r[6] : '' );
						$AnoFabricacion  = ( (!empty($r[7])) ? $r[7] : '' );
						$AnoModelo  = ( (!empty($r[8])) ? $r[8] : '' );
						$ColorExterior  = ( (!empty($r[9])) ? $r[9] : '' );
						$ColorInterior  = ( (!empty($r[10])) ? $r[10] : '' );
						
						$Clase  = ( (!empty($r[11])) ? $r[11] : '' );////
						$Carroceria  = ( (!empty($r[12])) ? $r[12] : '' );//
						
						$VIN  = ( (!empty($r[13])) ? $r[13] : '' );
						$NumeroMotor  = ( (!empty($r[14])) ? $r[14] : '' );
						$PotenciaMotor  = ( (!empty($r[15])) ? $r[15] : '' );////
						$Combustible  = ( (!empty($r[16])) ? $r[16] : '' );//
						$Cilindrada  = ( (!empty($r[17])) ? $r[17] : '' );//
						$NumeroCilindros  = ( (!empty($r[18])) ? $r[18] : '' );//
						$Transmision  = ( (!empty($r[19])) ? $r[19] : '' );
						
						$Traccion  = ( (!empty($r[20])) ? $r[20] : '' );//
						$NumeroRuedas  = ( (!empty($r[21])) ? $r[21] : '' );////
						$NumeroPuertas  = ( (!empty($r[22])) ? $r[22] : '' );//
						$NumeroEjes  = ( (!empty($r[23])) ? $r[23] : '' );//
						$DistanciaEjes  = ( (!empty($r[24])) ? $r[24] : '' );//
						
						$NumeroAsientos  = ( (!empty($r[25])) ? $r[25] : '' );//
						$Pasajeros  = ( (!empty($r[26])) ? $r[26] : '' );//
						$PesoBruto  = ( (!empty($r[27])) ? $r[27] : '' );//
						$PesoNeto  = ( (!empty($r[28])) ? $r[28] : '' );//
						
						$CargaUtil  = ( (!empty($r[29])) ? $r[29] : '' );//
						$Ancho  = ( (!empty($r[30])) ? $r[30] : '' );//
						$Largo  = ( (!empty($r[31])) ? $r[31] : '' );//
						$Alto  = ( (!empty($r[32])) ? $r[32] : '' );//
						
						$Puertas  = ( (!empty($r[33])) ? $r[33] : '' );
						
						$NumeroFactura  = ( (!empty($r[34])) ? $r[34] : '' );
						$ValorFacturado  = ( (!empty($r[35])) ? $r[35] : '' );
						$ValorFacturadoSinIGV  = ( (!empty($r[36])) ? $r[36] : '' );
						$Ubicacion  = ( (!empty($r[37])) ? $r[37] : '' );
						
						
			
	
	
	
						
							echo "VIN: ".$VIN;
							echo "<br>";

							echo "CodigoIdentificador: ".$CodigoIdentificador;
							echo "<br>";
							
							echo "Marca: ".$Marca;
							echo "<br>";
							
							echo "Modelo: ".$Modelo;
							echo "<br>";
														
							$VehiculoId  = "";
							$VehiculoMarcaId  = "";
							$VehiculoModeloId  = "";
							$VehiculoVersionId  = "";
							//$SucursalId  = "";
							
							/*if(!empty($Ubicacion)){

								$InsSucursal = new ClsSucursal();
								$SucursalId = $InsSucursal->MtdIdentificarSucursal("SucNombre",$Ubicacion);
							
							}*/
							
							
							if(!empty($CodigoIdentificador)){
							
								$InsVehiculo = new ClsVehiculo();
								$VehiculoId = $InsVehiculo->MtdIdentificarVehiculo($CodigoIdentificador);
							
							}	
							
							//echo "VehiculoId: ".$VehiculoId;
//							echo "<br>";		
							
							if(empty($CodigoIdentificador)){
								
								if(!empty($Marca)){
									
									$InsVehiculoMarca = new ClsVehiculoMarca();
									$VehiculoMarcaId = $InsVehiculoMarca->MtdIdentificarVehiculoMarca($Marca);
									
									if(empty($VehiculoMarcaId)){
										
										$InsVehiculoMarca->VmaId = NULL;
										$InsVehiculoMarca->VmaNombre = $Marca;
										$InsVehiculoMarca->VmaVigenciaVenta = 1;
										$InsVehiculoMarca->VmaFoto = "";
										$InsVehiculoMarca->VmaEstado = 1;
										$InsVehiculoMarca->VmaTiempoCreacion = date("Y-m-d H:i:s");
										$InsVehiculoMarca->VmaTiempoModificacion = date("Y-m-d H:i:s");
											
										if($InsVehiculoMarca->MtdRegistrarVehiculoMarca()){	
											$VehiculoMarcaId = $InsVehiculoMarca->VmaId;
										}else{
											echo "No se pudo registrar la marca de vehiculo";
											echo "<br>";
										}
										
									}
								}
								
								
								if(!empty($Modelo)){
									
									$InsVehiculoModelo = new ClsVehiculoModelo();
									$VehiculoModeloId = $InsVehiculoModelo->MtdIdentificarVehiculoModelo($Modelo);
									
									if(empty($VehiculoModeloId)){
										
										$InsVehiculoModelo->VmoId = $_POST['CmpId'];
										$InsVehiculoModelo->VmaId = $VehiculoMarcaId;
										$InsVehiculoModelo->VtiId = NULL;
										$InsVehiculoModelo->VmoNombre = $Modelo;
										$InsVehiculoModelo->VmoNombreComercial = $Modelo;
										$InsVehiculoModelo->VmoVigenciaVenta = 1;
										$InsVehiculoModelo->VmoEstado = 1;
										$InsVehiculoModelo->VmoTiempoCreacion = date("Y-m-d H:i:s");
										$InsVehiculoModelo->VmoTiempoModificacion = date("Y-m-d H:i:s");
											
										if($InsVehiculoModelo->MtdRegistrarVehiculoModelo()){	
											$VehiculoModeloId = $InsVehiculoMarca->VmoId;
										}else{
											echo "No se pudo registrar el modelo de vehiculo";
											echo "<br>";	
										}
										
									}
									
								}
								
								if(!empty($NombreComercial)){
								
									$InsVehiculoVersion = new ClsVehiculoVersion();
									$VehiculoVersionId = $InsVehiculoVersion->MtdIdentificarVehiculoVersion($NombreComercial);					
									
									if(empty($VehiculoModeloId)){
										
										$InsVehiculoVersion->VveId = NULL;	
										$InsVehiculoVersion->VmaId = $VehiculoMarcaId;
										$InsVehiculoVersion->VmoId = $VehiculoModeloId;
										$InsVehiculoVersion->VveNombre = $Version;
										$InsVehiculoVersion->VveVigenciaVenta = 1;
										$InsVehiculoVersion->VveFoto = NULL;
										$InsVehiculoVersion->VveFotoLateral = NULL;
										$InsVehiculoVersion->VveFotoPosterior = NULL;
										$InsVehiculoVersion->VveEstado = 1;
										$InsVehiculoVersion->VveTiempoCreacion = date("Y-m-d H:i:s");
										$InsVehiculoVersion->VveTiempoModificacion = date("Y-m-d H:i:s");
										
										if($InsVehiculoVersion->MtdRegistrarVehiculoVersion()){	
											$VehiculoVersionId = $InsVehiculoMarca->VveId;
										}else{
											echo "No se pudo registrar la version de vehiculo";
											echo "<br>";	
										}
										
									}
									
								}
								
							//948980455		
								
							}
										
						
							
						
								
							if(!empty($CodigoIdentificador)){
								
								if(!empty($VIN)){
									
									if(!empty($VehiculoId)){
										
										//MtdObtenerVehiculoIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oCliente=NULL,$oEstadoVehicular=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoModelo=NULL,$oAnoFabricacion=NULL,$oColor=NULL,$oConProforma=NULL,$oFecha="EinFechaRecepcion",$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL) {
										$InsVehiculoIngreso = new ClsVehiculoIngreso();
										$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos("EinVIN","esigual",$VIN,'EinVIN','ASC','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"EinFechaRecepcion",NULL,NULL,NULL);
										$ArrVehiculoIngresos = $ResVehiculoIngreso['Datos'];
										
										$VehiculoIngresoId = "";
										
										if(!empty($ArrVehiculoIngresos)){
											
											foreach($ArrVehiculoIngresos as $DatVehiculoIngreso){
												$VehiculoIngresoId = $DatVehiculoIngreso->EinId;
											}		
																		
										}
											
										if(empty($VehiculoIngresoId)){
											
											
											$InsVehiculo = new ClsVehiculo();
											$InsVehiculo->VehId = $VehiculoId;
											$InsVehiculo->MtdObtenerVehiculo(false);
											
											$InsVehiculoVersion = new ClsVehiculoVersion();
											$InsVehiculoVersion->VveId = $VehiculoVersionId;
											$InsVehiculoVersion->MtdObtenerVehiculoVersion();
											
											$VehiculoIngresoNombre = $InsVehiculoVersion->VmoNombre."".$InsVehiculoVersion->VveNombre;
											
											$VehiculoVersionId = $InsVehiculo->VveId;
											
											
											$InsVehiculoIngreso = new ClsVehiculoIngreso();
											$InsVehiculoIngreso->VehId = $VehiculoId;
											$InsVehiculoIngreso->SucId = $SucursalId;
											
											//$InsVehiculoIngreso->VmaId = $VehiculoMarcaId;
											//$InsVehiculoIngreso->VmoId = $VehiculoModeloId;
											$InsVehiculoIngreso->VveId = $VehiculoVersionId;
											
											$InsVehiculoIngreso->EinNombre = $VehiculoIngresoNombre;
											$InsVehiculoIngreso->EinColor = $ColorExterior;
											$InsVehiculoIngreso->EinColorInterno = $ColorInterior;
											$InsVehiculoIngreso->EinVIN = $VIN;
											$InsVehiculoIngreso->EinNumeroMotor = $NumeroMotor;
											$InsVehiculoIngreso->EinAnoFabricacion = $AnoFabricacion;
											$InsVehiculoIngreso->EinAnoModelo = $AnoModelo;
											
											$InsVehiculoIngreso->EinFacturaNumero = $NumeroFactura;
											$InsVehiculoIngreso->EinFacturaValor = $ValorFacturado;
											
											$InsVehiculoIngreso->EinCodigoPedido = $NotaPedidoCisne;
											$InsVehiculoIngreso->EinProveedor = $Proveedor;
												
																			
																			
											$InsVehiculoIngreso->EinCaracteristica1 = addslashes($NumeroCilindros);
											$InsVehiculoIngreso->EinCaracteristica2 = addslashes($NumeroEjes);
											$InsVehiculoIngreso->EinCaracteristica3 = addslashes($Cilindrada);
											$InsVehiculoIngreso->EinCaracteristica4 = addslashes($NumeroAsientos);
											$InsVehiculoIngreso->EinCaracteristica5 =  addslashes($Pasajeros);;
											$InsVehiculoIngreso->EinCaracteristica6 = 0;
											$InsVehiculoIngreso->EinCaracteristica7 = addslashes($Traccion);
											$InsVehiculoIngreso->EinCaracteristica8 = addslashes($Carroceria);
											$InsVehiculoIngreso->EinCaracteristica9 = addslashes($NumeroPuertas);
											$InsVehiculoIngreso->EinCaracteristica10 = addslashes($Combustible);
											
											$InsVehiculoIngreso->EinCaracteristica11 = addslashes($PesoBruto);
											$InsVehiculoIngreso->EinCaracteristica12 = addslashes($CargaUtil);
											$InsVehiculoIngreso->EinCaracteristica13 = addslashes($PesoNeto);
											$InsVehiculoIngreso->EinCaracteristica14 = addslashes($Alto );
											$InsVehiculoIngreso->EinCaracteristica15 = addslashes($Largo);
											$InsVehiculoIngreso->EinCaracteristica16 = addslashes($Ancho);
											$InsVehiculoIngreso->EinCaracteristica17 = addslashes($DistanciaEjes);	
											$InsVehiculoIngreso->EinCaracteristica18 = addslashes($NumeroRuedas);	
											$InsVehiculoIngreso->EinCaracteristica19 = addslashes($PotenciaMotor);	
											$InsVehiculoIngreso->EinCaracteristica20 = addslashes($Clase);	
											$InsVehiculoIngreso->EinNumeroProforma = addslashes($NotaPedidoProveedor);	
											$InsVehiculoIngreso->EinNotaPedido = addslashes($NotaPedidoCisne);
				
											$InsVehiculoIngreso->EinManualPropietario = 1;
											$InsVehiculoIngreso->EinManualGarantia = 1;
											$InsVehiculoIngreso->EinDescuentoGerencia = 2;
											$InsVehiculoIngreso->EinEstadoVehicular = "STOCK";
											
											$InsVehiculoIngreso->EinCancelado = 2;
											$InsVehiculoIngreso->EinTipo = 1;
											$InsVehiculoIngreso->EinEstado = 1;
											$InsVehiculoIngreso->EinTiempoCreacion = date("Y-m-d H:i:s");
											$InsVehiculoIngreso->EinTiempoModificacion = date("Y-m-d H:i:s");
											$InsVehiculoIngreso->EinEliminado = 1;		
											
											if($InsVehiculoIngreso->MtdRegistrarVehiculoIngreso()){
												echo "VIN registrado correctamente";
												echo "<br>";
											}else{
												echo "El VIN no se pudo registrar";
												echo "<br>";
											}
											
											
										}else{
											
											echo "El VIN ya se encuentra registrado";
											echo "<br>";
										}
										
									}else{
										echo "No se pudo identificar el Codigo de Material";
										echo "<br>";
									}
									
								}else{
									echo "No se ha encontrado los datos de la columna VIN";
									echo "<br>";
								}
								
							}else{
								
								echo "No se ha encontrado datos en la columna CODIGO MATERIAL";
								echo "<br>";
								
							}
						
						
							echo "<br>";
							echo "<br>";
						$fila++;
					}
					
					
					
				
				break;
				
			}
			
			
				

		} else {
			
			echo "Hubo un error al subir el archivo";
			echo "<br>";
		
		}

	
}
?></td>
</tr>
</table>

	</form>



