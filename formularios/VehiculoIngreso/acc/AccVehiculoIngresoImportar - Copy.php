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
				
					$data = new Spreadsheet_Excel_Reader();	
					$data->setOutputEncoding('CP1251');				
					$data->read($targetFile);
			
					$fila = 1;
					$InsVehiculoIngreso = new ClsVehiculoIngreso();
			
					for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {	
						
						echo "[Fila_".$fila."]> ".$fila;	
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
					
						$CodigoIdentificador  = $data->sheets[0]['cells'][$i][0];
						$CodigoIdentificador  = str_replace("'", "&#8217;", $CodigoIdentificador);	
						
						$Proveedor  = $data->sheets[0]['cells'][$i][1];
						$Proveedor  = str_replace("'", "&#8217;", $Proveedor);	
						
						$NotaPedidoProveedor  = $data->sheets[0]['cells'][$i][2];
						$NotaPedidoProveedor  = str_replace("'", "&#8217;", $NotaPedidoProveedor);	
						
						$NotaPedidoCisne  = $data->sheets[0]['cells'][$i][3];
						$NotaPedidoCisne  = str_replace("'", "&#8217;", $NotaPedidoCisne);	
						
						$Marca  = $data->sheets[0]['cells'][$i][4];
						$Marca  = str_replace("'", "&#8217;", $Marca);	
						
						$Modelo  = $data->sheets[0]['cells'][$i][5];
						$Modelo  = str_replace("'", "&#8217;", $Modelo);	
						
						$NombreComercial  = $data->sheets[0]['cells'][$i][6];
						$NombreComercial  = str_replace("'", "&#8217;", $NombreComercial);	
						
						$AnoFabricacion  = $data->sheets[0]['cells'][$i][7];
						$AnoFabricacion  = str_replace("'", "&#8217;", $AnoFabricacion);	
						
						$AnoModelo  = $data->sheets[0]['cells'][$i][8];
						$AnoModelo  = str_replace("'", "&#8217;", $AnoModelo);	
						
						$ColorExterior  = $data->sheets[0]['cells'][$i][9];
						$ColorExterior  = str_replace("'", "&#8217;", $ColorExterior);
						
						$ColorInterior  = $data->sheets[0]['cells'][$i][10];
						$ColorInterior  = str_replace("'", "&#8217;", $ColorInterior);	
						
						$VIN  = $data->sheets[0]['cells'][$i][11];
						$VIN  = str_replace("'", "&#8217;", $VIN);	
						
						$NumeroMotor  = $data->sheets[0]['cells'][$i][12];
						$NumeroMotor  = str_replace("'", "&#8217;", $NumeroMotor);	
						
						$NumeroFactura  = $data->sheets[0]['cells'][$i][13];
						$NumeroFactura  = str_replace("'", "&#8217;", $NumeroFactura);	
						
						$ValorFacturado  = $data->sheets[0]['cells'][$i][14];
						$ValorFacturado  = str_replace("'", "&#8217;", $ValorFacturado);	
						
						$Ubicacion  = $data->sheets[0]['cells'][$i][15];
						$Ubicacion  = str_replace("'", "&#8217;", $Ubicacion);	
						
						
							echo "VIN: ".$VIN;
							echo "<br>";
							
							if(!empty($CodigoIdentificador)){
								
								$InsVehiculo = new ClsVehiculo();
								$VehiculoId = $InsVehiculo->MtdIdentificarVehiculo($CodigoIdentificador);
							
								$InsVehiculo = new ClsVehiculo();
								$InsVehiculo->VehId = $VehiculoId;
								$InsVehiculo->MtdObtenerVehiculo(false);
								
								$InsVehiculoIngreso = new ClsVehiculoIngreso();
								$InsVehiculoIngreso->VehId = $VehiculoId;
								
								$InsVehiculoIngreso->VmaId = $InsVehiculo->VmaId;
								$InsVehiculoIngreso->VmoId = $InsVehiculo->VmoId;
								$InsVehiculoIngreso->VveId = $InsVehiculo->VveId;
								
								$InsVehiculoIngreso->EinColor = $ColorInterior;
								$InsVehiculoIngreso->EinColorExterior = $ColorExterior;
								$InsVehiculoIngreso->EinVIN = $VIN;
								$InsVehiculoIngreso->EinNumeroMotor = $NumeroMotor;
								$InsVehiculoIngreso->EinAnoFabricacion = $AnoFabricacion;
								$InsVehiculoIngreso->EinAnoModelo = $AnoModelo;
								
								$InsVehiculoIngreso->EinFacturaNumero = $NumeroFactura;
								$InsVehiculoIngreso->EinFacturaValor = $ValorFacturado;
								
								$InsVehiculoIngreso->EinCodigoPedido = $NotaPedidoCisne;
								$InsVehiculoIngreso->EinProveedor = $Proveedor;
								
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
								
								echo "No se ha encontrado datos en la columna CODIGO";
								echo "<br>";
								
							}
						
						
							
							//echo "<hr>";				
							echo "<br>";
							echo "<br>";
							$fila++;
						}	
						
				
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
					
						$CodigoIdentificador  = ( (!empty($r[0])) ? $r[0] : '' );
						
						$Proveedor  = ( (!empty($r[1])) ? $r[1] : '' );
						$NotaPedidoProveedor  = ( (!empty($r[2])) ? $r[2] : '' );
						$NotaPedidoCisne  = ( (!empty($r[3])) ? $r[3] : '' );
						$Marca  = ( (!empty($r[4])) ? $r[4] : '' );
						$Modelo  = ( (!empty($r[5])) ? $r[5] : '' );
						
						$NombreComercial  = ( (!empty($r[6])) ? $r[6] : '' );
						$AnoFabricacion  = ( (!empty($r[7])) ? $r[7] : '' );
						$AnoModelo  = ( (!empty($r[8])) ? $r[8] : '' );
						$ColorExterior  = ( (!empty($r[9])) ? $r[9] : '' );
						$ColorInterior  = ( (!empty($r[10])) ? $r[10] : '' );
						
						$VIN  = ( (!empty($r[11])) ? $r[11] : '' );
						$NumeroMotor  = ( (!empty($r[12])) ? $r[12] : '' );
						$NumeroFactura  = ( (!empty($r[13])) ? $r[13] : '' );
						$ValorFacturado  = ( (!empty($r[14])) ? $r[14] : '' );
						$Ubicacion  = ( (!empty($r[15])) ? $r[15] : '' );
						
						
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
							$SucursalId  = "";
							
							if(!empty($Ubicacion)){

								$InsSucursal = new ClsSucursal();
								$SucursalId = $InsSucursal->MtdIdentificarSucursal("SucNombre",$Ubicacion);
							
							}
							
							
							if(!empty($CodigoIdentificador)){
							
								$InsVehiculo = new ClsVehiculo();
								$VehiculoId = $InsVehiculo->MtdIdentificarVehiculo($CodigoIdentificador);
							
							}	
							
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
										}
										
									}
									
								}
								
							//948980455		
								
							}
																
							if(!empty($CodigoIdentificador)){
								
								if(!empty($SucursalId)){
									
									$InsVehiculo = new ClsVehiculo();
									$InsVehiculo->VehId = $VehiculoId;
									$InsVehiculo->MtdObtenerVehiculo(false);
									
									$VehiculoVersionId = $InsVehiculo->VveId;
									
									
									$InsVehiculoIngreso = new ClsVehiculoIngreso();
									$InsVehiculoIngreso->VehId = $VehiculoId;
									
									//$InsVehiculoIngreso->VmaId = $VehiculoMarcaId;
									//$InsVehiculoIngreso->VmoId = $VehiculoModeloId;
									$InsVehiculoIngreso->VveId = $VehiculoVersionId;
									
									$InsVehiculoIngreso->EinColor = $ColorInterior;
									$InsVehiculoIngreso->EinColorExterior = $ColorExterior;
									$InsVehiculoIngreso->EinVIN = $VIN;
									$InsVehiculoIngreso->EinNumeroMotor = $NumeroMotor;
									$InsVehiculoIngreso->EinAnoFabricacion = $AnoFabricacion;
									$InsVehiculoIngreso->EinAnoModelo = $AnoModelo;
									
									$InsVehiculoIngreso->EinFacturaNumero = $NumeroFactura;
									$InsVehiculoIngreso->EinFacturaValor = $ValorFacturado;
									
									$InsVehiculoIngreso->EinCodigoPedido = $NotaPedidoCisne;
									$InsVehiculoIngreso->EinProveedor = $Proveedor;
										
									$InsVehiculoIngreso->EinManualPropietario = 1;
									$InsVehiculoIngreso->EinManualGarantia = 1;
									$InsVehiculoIngreso->EinDescuentoGerencia = 2;
									
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
									
									echo "No se ha podido identificar la sucursal";
									echo "<br>";
								
								}
								
							}else{
								
								echo "No se ha encontrado datos en la columna CODIGO";
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



