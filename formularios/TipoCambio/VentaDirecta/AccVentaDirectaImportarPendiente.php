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

						if( strtoupper($r[$columna]) == "Solicitado" ){
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
										
						if( strtoupper($r[$columna]) == "Entregado" ){
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
					
					
					
?>

[Fila <?php echo $fila;?>]> 

<?php
						if(!empty($OrdenCompraNumero) and !empty($ProductoCodigoOriginal) and !empty($Solicitado)){


//MtdObtenerVentaDirectaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VddId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaDirecta=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oMoneda=NULL,$oCliente=NULL,$oConOrdenCompraReferencia=NULL)
						$ResVentaDirectaDetalle = $InsVentaDirectaDetalle->MtdObtenerVentaDirectaDetalles("VdiOrdenCompraNumero",$OrdenCompraNumero,'VddId','Desc',NULL,NULL,NULL,$oProducto=NULL,NULL,NULL,NULL,"CLI-10770",NULL);
						$ArrVentaDirectaDetalles = $ResVentaDirectaDetalle['Datos'];
						
						
						if(!empty($ArrVentaDirectaDetalles)){
							foreach($ArrVentaDirectaDetalles as $DatVentaDirectaDetalle){
								
								if($DatVentaDirectaDetalle->ProCodigoOriginal == $ProductoCodigoOriginal){
?>
Encontrado <br />
<?php

								}
								
							}
						}
?>

                      
                                          
<?php
						}else{
?>
							<span class="EstImportarRegistrarNo">Codigo original u orden de compra no identificada</span><br />
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