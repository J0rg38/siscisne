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

				$OrdenCompraId = "";
				$ProductoCodigoOriginal = "";
				$ProductoNombre = "";
				$Cantidad = 0;
				
				$fila = 1;
				foreach( $xlsx->rows() as $r ) { 
					
					for( $columna=0; $columna < $num_cols; $columna++ ) {
						
						if($columna == 0){
							$OrdenCompraId  =  trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
						}
	
						if($columna == 5){
							$ProductoCodigoOriginal  = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
						}
	
						if($columna == 6){
							$ProductoNombre = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
						}
						
						if($columna == 7){
							$Cantidad = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
						}
						
					}
					
?>

[Fila <?php echo $fila;?>]>

<?php echo $OrdenCompraId;?>
<?php echo $ProductoCodigoOriginal;?>
<?php echo $ProductoNombre;?>

<?php
						if( !empty($OrdenCompraId) and !empty($ProductoCodigoOriginal) ){
							
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

											if($ProductoCodigoOriginal == trim($DatPedidoCompraDetalle->ProCodigoOriginal)){
											
$InsPedidoCompraDetalle1 = new ClsPedidoCompraDetalle();
$InsPedidoCompraDetalle1->MtdEditarPedidoCompraDetalleDato("PcdAPTiempoCarga",date("Y-m-d H:i:s"),$DatPedidoCompraDetalle->PcdId);
$InsPedidoCompraDetalle1->MtdEditarPedidoCompraDetalleDato("PcdAPCantidad",($Cantidad),$DatPedidoCompraDetalle->PcdId);
?>

<span class="EstImportarFila">
<b>Producto:</b> <?php echo $DatPedidoCompraDetalle->ProCodigoOriginal;?> - <?php echo $DatPedidoCompraDetalle->ProNombre;?><br />
<b>Orden Venta:</b> <?php echo $InsPedidoCompra->VdiId;?> - <?php echo $InsPedidoCompra->CliNombre;?><br />
<b>O.C. Ref.: </b> <?php echo $InsPedidoCompra->VdiOrdenCompraNumero;?><br />
<b>Cantidad a Atender: </b> <?php echo $Cantidad;?><br />
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
								<span class="EstImportarRegistrarNo">No se pudo encontrar el codigo original <?php echo $ProductoCodigoOriginalImportado;?></span><br />	
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