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

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCodificacion.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCodificacionDetalle.php');

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
	$targetPath = '../../../subidos/ordencotizacion_excel/';
	$CodigoReferencia = $file_name;
	
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
		
			case "xlsx":
			
				$xlsx = new SimpleXLSX($targetFile); 

				list($num_cols, $num_rows) = $xlsx->dimension(); 

				$columna = 5;

				foreach( $xlsx->rows() as $r ) { 

					$OrdenCodificacionId  =  trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	

					if (strpos($OrdenCodificacionId, 'CCO') !== false) {
						break;
					}

				}
				
				echo "Numero de consulta tecnica PN: ".$OrdenCodificacionId;
				echo "<br>";

					$fila = 0;
					$inicio_filaA = 0;
					$inicio_columnaA = 0;

					foreach( $xlsx->rows() as $r ) { 
						
					//	echo "<br>";
					////	echo "FILA: ".$fila;
					//	echo "<br>";
						
						for( $columna = 0; $columna < $num_cols; $columna++ ) {
								
//							deb($r[$columna]);							
							if( ($r[$columna]) == "GM Part Number" and ($r[$columna])!="" ){
								//echo "LOL";
								$inicio_columnaA = $columna;
								$inicio_filaA = $fila;
								
							//	echo "<br>";
//								echo "columna: ".$r[$columna];
//								echo "<br>";
//								echo "inicio_columnaA: ".$inicio_columnaA ;
//								echo "<br>";
//								echo "inicio_filaA: ".$inicio_filaA ;
//								echo "<br>";
					
								break;
							}
	
						}
						$fila++;
					}
					
//					echo "<br>";
//					echo "<br>";
//					echo "inicio_columnaA: ".$inicio_columnaA ;
//					echo "<br>";
//					echo "inicio_filaA: ".$inicio_filaA ;
//					echo "<br>";

					
					//echo "<hr>";
					$fila = 0;
					$inicio_filaB = 0;
					$inicio_columnaB = 0;

					foreach( $xlsx->rows() as $r ) { 
	
						for( $columna = 0; $columna < $num_cols; $columna++ ) {
							
							if( ($r[$columna]) == "Precio" and ($r[$columna])!="" ){
								$inicio_columnaB = $columna;
								$inicio_filaB = $fila;
								break;
							}
	
						}
						$fila++;
					}
					
//					echo "<br>";
//					echo "<br>";
//										echo "inicio_columnaB: ".$inicio_columnaB ;
//					echo "<br>";
//					echo "inicio_filaB: ".$inicio_filaB ;
//					echo "<br>";
//					echo "<br>";
					
//					echo "inicio_columnaA: ".$inicio_columnaA ;
//					echo "<br>";
//					echo "inicio_filaA: ".$inicio_filaA ;
//					echo "<br>";
//					echo "inicio_columnaB: ".$inicio_columnaB ;
//					echo "<br>";
//					echo "inicio_filaB: ".$inicio_filaB ;
//					echo "<br>";
//					echo "<br>";
					$InsOrdenCodificacion = new ClsOrdenCodificacion();
					$InsOrdenCodificacion->OciId = $OrdenCodificacionId;
					$InsOrdenCodificacion->MtdObtenerOrdenCodificacion();
					
					$InsOrdenCodificacion->MtdEditarOrdenCodificacionDato("OciCodigoReferencia",$CodigoReferencia,$InsOrdenCodificacion->OciId);
					

					if(!empty($InsOrdenCodificacion->OciEstado)){
							
						$fila = 1;
						foreach( $xlsx->rows() as $r ) { 
						
							for( $columna=0; $columna < $num_cols; $columna++ ) {
							
								if($columna == $inicio_columnaA){
									$ProductoCodigoOriginal  =  trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
								}	
								
								if($columna == $inicio_columnaB){
									$OrdenCodificacionDetallePrecio  =  trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
								}	
							
							}
							
							echo "[Fila ".$fila."]> ";
							// echo "<br>";
							
							if(!empty($ProductoCodigoOriginal)){
								
								if(!empty($OrdenCodificacionDetallePrecio)){
									
									echo "Codigo Original: ".$ProductoCodigoOriginal;
									echo "<br>";
									echo "Precio: ".$OrdenCodificacionDetallePrecio;
									echo "<br>";
							
									//MtdObtenerOrdenCodificacionDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'OodId',$oSentido = 'Desc',$oPaginacion = '0,10',$oOrdenCodificacion=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oProveedor=NULL,$oConOrdenCompra=NULL,$oVentaDirectaDetalleId=NULL,$oOrdenCodificacionEstado=NULL,$oFecha="OciFecha",$oValidarRecibido=false,$oConFichaIngreso=false,$oProductoId=NULL) {
									$InsOrdenCodificacionDetalle = new ClsOrdenCodificacionDetalle();
									$ResOrdenCodificacionDetalle = $InsOrdenCodificacionDetalle->MtdObtenerOrdenCodificacionDetalles("pro.ProCodigoOriginal",$ProductoCodigoOriginal,'OodId','Desc','1',$OrdenCodificacionId,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"OciFecha",false,false,NULL);
									$ArrOrdenCodificacionDetalles = $ResOrdenCodificacionDetalle['Datos'];						
									
									$OrdenCodificacionDetalleId = "";
									
									if(!empty($ArrOrdenCodificacionDetalles)){
										foreach($ArrOrdenCodificacionDetalles as $DatOrdenCodificacionDetalle){
											$OrdenCodificacionDetalleId = $DatOrdenCodificacionDetalle->OodId;		
										}
									}
								
									if(!empty($OrdenCodificacionDetalleId)){
										
										if($InsOrdenCodificacion->MonId<> $EmpresaMonedaId){
											$PrecioConvertido = $OrdenCodificacionDetallePrecio * $InsOrdenCodificacion->OciTipoCambio;	
										}else{
											$PrecioConvertido = $OrdenCodificacionDetallePrecio;				
										}
				
										if($InsOrdenCodificacionDetalle->MtdEditarOrdenCodificacionDetalleDato("OodPrecio",$PrecioConvertido,$OrdenCodificacionDetalleId)){
											if($InsOrdenCodificacionDetalle->MtdEditarOrdenCodificacionDetalleDato("OodImporte",$PrecioConvertido,$OrdenCodificacionDetalleId)){
												echo "Precio actualizado correctamente";	
												echo "<br>";
											}	
										}
				
									}else{
										echo "Repuesto no encontrado en la consulta tecnica PN";	
										echo "<br>";
									}
									
										
									}else{
										echo "Precio no encontrado";
										echo "<br>";
									}
								
								
							}else{
								echo "Codigo Original no encontrado";
								echo "<br>";
							}
							
							
							
		
							$fila++;
						} 
				
						
					}else{
						
						echo "Solicitu de cotizacion no identificada. PROCESO CANCELADO";		
						
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