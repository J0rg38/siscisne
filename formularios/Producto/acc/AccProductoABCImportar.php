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
////AUDITORIA
require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');

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
    
    
	<input  name="BtnEnviar" id="BtnEnviar" type="submit" value="Importar Excel" /><br />
    
    
    </td>
</tr>
<tr>
  <td align="left" valign="top">
    <?php
if (!empty($_FILES)) {
	$tempFile = $_FILES['CmpArchivo']['tmp_name'];
	//$file_name = strtolower($_FILES['CmpArchivo']['name']);	
	$file_name = iconv("UTF-8","WINDOWS-1251",$_FILES['CmpArchivo']['name']);
	$targetPath = '../../../subidos/producto_excel/';
	
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

/*
				
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
					  
					$InsProducto = new ClsProducto();
					  
					$InsProductoDisponibilidad->PdiCodigo  = $data->sheets[0]['cells'][$i][$inicio_columna];
					$InsProductoDisponibilidad->PdiCodigo  = str_replace("'", "&#8217;", $InsProductoDisponibilidad->PdiCodigo);	
					  
					$InsProductoDisponibilidad->PdiNombre  = $data->sheets[0]['cells'][$i][$inicio_columna+1];
					$InsProductoDisponibilidad->PdiNombre  = str_replace("'", "&#8217;", $InsProductoDisponibilidad->PdiNombre);	
					  
					  
					 if($_POST['CmpTipo']=="1"){

						$InsProductoDisponibilidad->PdiCantidad  = $data->sheets[0]['cells'][$i][$inicio_columna+2];
						$InsProductoDisponibilidad->PdiCantidad  = str_replace("'", "&#8217;", $InsProductoDisponibilidad->PdiCantidad);

					
						if($InsProductoDisponibilidad->PdiCantidad>0){
							$InsProductoDisponibilidad->PdiDisponible = 1;
						}else{
							$InsProductoDisponibilidad->PdiDisponible = 2;
						}
						
						
					 }else{
						 
						$InsProductoDisponibilidad->PdiDisponible  = $data->sheets[0]['cells'][$i][$inicio_columna+2];
						$InsProductoDisponibilidad->PdiDisponible  = str_replace("'", "&#8217;", $InsProductoDisponibilidad->PdiDisponible);	
						
						if(strtoupper($InsProductoDisponibilidad->PdiDisponible) == "SI"){
							$InsProductoDisponibilidad->PdiDisponible = 1;
						}else if(strtoupper($InsProductoDisponibilidad->PdiDisponible) == "NO"){
							$InsProductoDisponibilidad->PdiDisponible = 2;							
						}else{
							$InsProductoDisponibilidad->PdiDisponible = 0;
						}

					 }
					
					
	

						
						

						
						$InsProductoDisponibilidad->PdiEstado = 1;
						
						
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
				$inicio_fila = 0;
				$inicio_columna = 0;

				foreach( $xlsx->rows() as $r ) { 

					for( $i = 0; $i < $num_cols; $i++ ) {

						if( strtoupper($r[$i]) == "PN" ){
							$inicio_columna = $i;
							$inicio_fila = $fila;
							break;
						}

					}
					$fila++;
				}


		
				$fila = 1;
				foreach( $xlsx->rows() as $r ) { 
					
					if($inicio_fila <= $fila){
						
					$InsProducto = new ClsProducto();
					$InsProducto->UsuId = $_SESSION['SesionId'];
					
						for( $i=0; $i < $num_cols; $i++ ) {
					
							if($i==$inicio_columna){
								$Codigo  = ( (!empty($r[$i])) ? $r[$i] : '' );	
								$Codigo= trim($Codigo);
							}
							
							if($i == $inicio_columna + 2){
								$Procedencia  = ( (!empty($r[$i])) ? $r[$i] : '' );	
							}
							
								
							if($i == $inicio_columna + 3){
								$Rotacion = ( (!empty($r[$i])) ? $r[$i] : '' );	
							}

						}
						
						
						$ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$Codigo,'ProTiempoCreacion','Desc','1',NULL,NULL,1,NULL,NULL,NULL,NULL,false,NULL,NULL,0,NULL) ;
						$ArrProductos = $ResProducto['Datos'];
						
						if(!empty($ArrProductos)){
							foreach($ArrProductos as $DatProducto){
								
								$ProductoId = $DatProducto->ProId;
							}
						}
						
						$InsProducto->ProId = $ProductoId;
						$InsProducto->ProProcedencia = $Procedencia;
						$InsProducto->ProRotacion = $Rotacion;
						$InsProducto->ProTiempoModifiacion = date("Y-m-d H:i:s");
						
						if(!empty($InsProducto->ProId)){
				
							if($InsProducto->MtdActualizarPrductoABC()){
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
				
					
					}
					
					
					
					
					
					
					
					
						
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