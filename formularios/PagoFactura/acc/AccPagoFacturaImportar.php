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

$POST_ClienteId = $_POST['CmpClienteId'];
$POST_MonedaId = $_POST['CmpMonedaId'];

$POST_AreaId = $_POST['CmpAreaId'];
$POST_FormaPagoId = $_POST['CmpFormaPago'];
$POST_CuentaId = $_POST['CmpCuenta'];

$POST_ClienteNombre = $_POST['CmpClienteNombre'];
$POST_ClienteNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];

if(empty($POST_ClienteId)){
	exit("No ha escogido un cliente");
}

if(empty($POST_MonedaId)){
	exit("No ha escogido una moneda");
}
	
if(empty($POST_CuentaId)){
	exit("No ha escogido una cuenta destino");
}

if(empty($POST_FormaPagoId)){
	exit("No ha escogido una forma de pago");
}

if(empty($POST_AreaId)){
	exit("No ha escogido una area destino");
}
				
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsCuenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsFormaPago.php');
require_once($InsPoo->MtdPaqLogistica().'ClsArea.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaTalonario.php');

if(empty($POST_ClienteId) and !empty($POST_ClienteNombre)){
	
	$ResCliente = $InsCliente->MtdObtenerClientes("CliNombre,CliApellidoPaterno,CliApellidoMaterno","contiene",$POST_ClienteNombre,"CliId","ASC",1,"1",NULL,NULL);
	$ArrClientes = $ResCliente['Datos'];
	
	if(!empty($ArrClientes)){
		foreach($ArrClientes as $DatCliente){
			$POST_ClienteId = $DatCliente->CliId;
		}
	}

}

if(empty($POST_ClienteId) and !empty($POST_ClienteNumeroDocumento)){
	
	$ResCliente = $InsCliente->MtdObtenerClientes("CliNumeroDocumento","contiene",$POST_ClienteNumeroDocumento,"CliId","ASC",1,"1",NULL,NULL);
	$ArrClientes = $ResCliente['Datos'];
	
	if(!empty($ArrClientes)){
		foreach($ArrClientes as $DatCliente){
			$POST_ClienteId = $DatCliente->CliId;
		}
	}

}




$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();

$InsCliente = new ClsCliente();
$InsCliente->CliId = $POST_ClienteId;
$InsCliente->MtdObtenerCliente();

$InsCuenta = new ClsCuenta();
$InsCuenta->CueId = $POST_CuentaId;
$InsCuenta->MtdObtenerCuenta();

$InsFormaPago = new ClsFormaPago();
$InsFormaPago->FpaId = $POST_FormaPagoId;
$InsFormaPago->MtdObtenerFormaPago();

$InsArea = new ClsArea();
$InsArea->AreId = $POST_AreaId;
$InsArea->MtdObtenerArea();

?>


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
<tbody class="EstFormularioBody">
<tr><td width="14%" align="left" valign="top">

  
  </td>
  </tr>
<tr>
  <td align="left" valign="top">
    
  <!--  <input type="file" id="CmpArchivo" name="CmpArchivo" />
    
    
    <input  name="BtnEnviar" id="BtnEnviar" type="submit" value="Importar Excel" />
    -->
    </td>
</tr>
<tr>
  <td align="left" valign="top">
    <?php
if (!empty($_FILES)) {
	$tempFile = $_FILES['CmpArchivo']['tmp_name'];
	//$file_name = strtolower($_FILES['CmpArchivo']['name']);	
	$file_name = iconv("UTF-8","WINDOWS-1251",$_FILES['CmpArchivo']['name']);
	$targetPath = '../../../subidos/pago_factura_excel/';
	
	
	
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
		
/*			case "xls":

//				$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
//				
//				if(!$InsProductoDisponibilidad->MtdEliminarTodoProductoDisponibilidad()){
//?>
//					<span class="EstImportarRegistrarNo">No se pudo vaciar la tabla de disponibilidad.</span><br />
//<?php					
//				}
//				
//				$data = new Spreadsheet_Excel_Reader();	
//				$data->setOutputEncoding('CP1251');				
//				$data->read($targetFile);
//				
//				
//				$fila = 0;
//				$inicio_fila = 0;
//				$inicio_columna = 0;
//				
//				for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {	
//
//					for($j = 1; $j<20; $j++){
//
//						$aux  = $data->sheets[0]['cells'][$i][$j];
//						$aux  = str_replace("'", "&#8217;", $aux);	
//						
//						if( $aux  == "MATERIAL NUMBER" ){
//							$inicio_columna = $j;
//							$inicio_fila = $fila;
//							break;
//						}
//					}
//					$fila++;
//				}
//
//				
//
//				$fila = 1;
//				for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {	
//					  
//					$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
//					  
//					$InsProductoDisponibilidad->PdiCodigo  = $data->sheets[0]['cells'][$i][$inicio_columna];
//					$InsProductoDisponibilidad->PdiCodigo  = str_replace("'", "&#8217;", $InsProductoDisponibilidad->PdiCodigo);	
//					  
//					$InsProductoDisponibilidad->PdiNombre  = $data->sheets[0]['cells'][$i][$inicio_columna+1];
//					$InsProductoDisponibilidad->PdiNombre  = str_replace("'", "&#8217;", $InsProductoDisponibilidad->PdiNombre);	
//					  
//					$InsProductoDisponibilidad->PdiDisponible  = $data->sheets[0]['cells'][$i][$inicio_columna+2];
//					$InsProductoDisponibilidad->PdiDisponible  = str_replace("'", "&#8217;", $InsProductoDisponibilidad->PdiDisponible);	
//					$InsProductoDisponibilidad->PdiTiempoCreacion = date("Y-m-d H:i:s");
//					
//					if(!empty($InsProductoDisponibilidad->PdiCodigo)){
//			
//						if($InsProductoDisponibilidad->MtdRegistrarProductoDisponibilidad()){
//			?>
//							<span class="EstImportarRegistrarSi">[Fila <?php echo $fila;?>]> <?php echo $InsProductoDisponibilidad->PdiCodigo;?>, Se registro correctamente.</span><br />
//			<?php
//						}else{
//			?>
//							<span class="EstImportarRegistrarNo">[Fila <?php echo $fila;?>]> <?php echo $InsProductoDisponibilidad->PdiCodigo;?>, No se pudo registrar.</span><br />
//			<?php	
//						}
//									
//					}else{
//			?>
//						<span class="EstImportarRegistrarNo">[Fila <?php echo $fila;?>]> No se pudo registrar, codigo vacio</span><br />
//			<?php
//					}
//			
//					?>
//					
//					<hr />
//					<?php					
//					  $fila++;
//					}			
//			
//

			break;
			*/
			case "xlsx":


		
				$InsPago = new ClsPago();
				$InsPago->PleFecha = date("Y-m-d");
				$InsPago->PleEstado = 3;
				$InsPago->PleTiempoCreacion = date("Y-m-d H:i:s");
				$InsPago->PleTiempoModificacion = date("Y-m-d H:i:s");
				
				$xlsx = new SimpleXLSX($targetFile); 

				list($num_cols, $num_rows) = $xlsx->dimension(); 

				
				$OrdenCompraNumero = "";
				$PagoFecha = "";
				$Factura = "";
				$FacturaTalonario = "";
				$FacturaNumero = "";
				$Monto = 0;
				
				$fila = 1;
				foreach( $xlsx->rows() as $r ) { 

?>

[Fila <?php echo $fila;?>]> 

<?php
$OrdenCompraNumero = "";
							
							$OrdenCompraNumero = "";
							$PagoFecha = "";
							$FacturaTalonario = "";
							$FacturaNumero = "";
							$Monto = 0;
							
							

						for( $columna=0; $columna < $num_cols; $columna++ ) {
							
							
							
							//if($fila == $inicio_filaA and $columna == $inicio_columnaA){
							if($columna == 1){
								$OrdenCompraNumero  =  trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							}
							//if($fila == $inicio_filaB and $columna == $inicio_columnaB){
								
							if($columna == 2){
								
								$PagoFecha = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
								//deb($PagoFecha);
								list($PagoFechaDia,$PagoFechaMes,$PagoFechaAno) = explode("/",$PagoFecha);;

								$PagoFecha = $PagoFechaAno."-".$PagoFechaMes."-".$PagoFechaDia;
								
								//deb($PagoFecha);
								
							}
							
							if($columna == 3){
								
								$Factura = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));								
								$Factura = eregi_replace("FT","",$Factura);
								$Factura = eregi_replace("F","",$Factura);
								$Factura = eregi_replace("T","",$Factura);
								$Factura = eregi_replace(" ","",$Factura);
								
								list($FacturaTalonario,$FacturaNumero) = explode("-",$Factura);;
								
								
								$InsFacturaTalonario = new ClsFacturaTalonario();
								$ResFacturaTalonario = $InsFacturaTalonario->MtdObtenerFacturaTalonarios("FtaNumero",$FacturaTalonario,"FtaId","Desc","1");
								$ArrFacturaTalonarios = $ResFacturaTalonario['Datos'];
								
								
								if(!empty($ArrFacturaTalonarios)){
									foreach($ArrFacturaTalonarios as $DatFacturaTalonario){
										
										$FacturaTalonario =  $DatFacturaTalonario->FtaId;
										
									}
								}else{
									$FacturaTalonario = "";
								}
								
									
							}
							
							if($columna == 4){
								$Monto = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							}
							
							
							
						}
						
						
?>

<span class="EstImportarFila">
<b>Ord. Compra Ref.:</b> <?php echo $OrdenCompraNumero;?><br />
<b>Fecha de Pago:</b> <?php echo FncCambiaFechaANormal($PagoFecha);?><br />
</span>
<br />
Tareas realizdas:

<br />
        
<?php
	
							$InsFactura = new ClsFactura();
//							$InsFactura->FacId = $FacturaNumero;
//							$InsFactura->FtaId = $FacturaTalonario;
//							$InsFactura->MtdObtenerFactura(false);								
							$ExisteFactura = $InsFactura->MtdVerificarExisteFactura($FacturaNumero,$FacturaTalonario);
							
							if($ExisteFactura){
								
								$InsFactura->FacId = $FacturaNumero;
								$InsFactura->FtaId = $FacturaTalonario;
								$InsFactura->MtdObtenerFactura(false);		
								
							}
							
								$InsPago = new ClsPago();
								$InsPago->PagFecha = date("Y-m-d");
								$InsPago->CliId = $POST_ClienteId;
								
								$InsPago->AreId = $POST_AreaId;
								$InsPago->FpaId = $POST_FormaPagoId;
								$InsPago->CueId = $POST_CuentaId;
								
								$InsPago->PagFechaTransaccion = $PagoFecha;;
								
								$InsPago->MonId = $POST_MonedaId;
								$InsPago->PagTipoCambio = $InsFactura->FacTipoCambio;
								$InsPago->PagMonto = eregi_replace(",","",(empty($Monto)?0:$Monto));
								$InsPago->PagObservacion = "Pago importado de excel ".date("d/m/Y H:i:s");
								
								$InsPago->PagTipo = "FAC";		
								$InsPago->PagEstado = 3;		
								$InsPago->PagTiempoCreacion = date("Y-m-d H:i:s");
								$InsPago->PagTiempoModificacion = date("Y-m-d H:i:s");
								$InsPago->PagEliminado = 1;
								
								$InsPago->PagoComprobante = array();
								
								
								if($InsPago->MonId<>$EmpresaMonedaId ){
									$InsPago->PagMonto = $InsPago->PagMonto * $InsPago->PagTipoCambio;
								}
								
									$InsPagoComprobante1 = new ClsPagoComprobante();
									
									$InsPagoComprobante1->FacId = $FacturaNumero;
									$InsPagoComprobante1->FtaId = $FacturaTalonario;
									
									$InsPagoComprobante1->PacEstado = 1;
									$InsPagoComprobante1->PacTiempoCreacion = date("Y-m-d H:i:s");
									$InsPagoComprobante1->PacTiempoModificacion = date("Y-m-d H:i:s");
									
									$InsPago->PagoComprobante[] = $InsPagoComprobante1;
									
						//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha")
						
						
//						if(!empty($InsFactura->FacId) and !empty($InsFactura->FtaId)){
						if($ExisteFactura){

$ResPago = $InsPago->MtdObtenerPagos("PagMonto","comienza",$InsPago->PagMonto,'PagId','Desc',"1",NULL,NULL,NULL,NULL,$POST_MonedaId,$FacturaNumero,$FacturaTalonario,NULL,NULL,NULL,$PagoFecha,$PagoFecha,"PagFechaTransaccion");
						$ArrPagos = $ResPago['Datos'];



							if(empty($ArrPagos)){
	
								if(!empty($FacturaNumero) and !empty($FacturaTalonario)){
									
									if($InsPago->MtdRegistrarPago()){
		
		?>
										<span class="EstImportarRegistrarSi">Se registro correctamente el pago.</span><br />
		<?php
									}else{
		?>
		
										<span class="EstImportarRegistrarNo">No se pudo registrar el pago. PROCESO CANCELADO </span><br />
		
		
		<?php
									}
		
								}else{
		?>
									<span class="EstImportarRegistrarNo">No se pudo registrar el pago, no se pudo identificar la factura</span><br />
		<?php	
								}
							
							}else{
		?>
									<span class="EstImportarRegistrarNo">No se pudo registrar el pago, se detecto registro dupicado</span><br />
		<?php							
							}


						}else{
?>
									<span class="EstImportarRegistrarNo">No se pudo registrar el pago, la factura no esta registrada en sistema. </span><br />
		<?php	
						}
					

						
				?>

				
				
				<hr />
				<?php	
				
					 $fila++;
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
</tbody>
</table>

	