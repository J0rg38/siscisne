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


require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
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
	$file_name = strtolower($_FILES['CmpArchivo']['name']);	
	$targetPath = '../../../subidos/producto_excel/';
	$targetFile =  str_replace('//','/',$targetPath) . date("d-m-Y").'_P_'.($file_name);	
?>
    Nombre de Archivo: <?php echo $file_name;?><br />
  <?php
	if (move_uploaded_file($tempFile,$targetFile)){

		
		$path = $targetFile;
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		
		
		switch($ext){
		
			case "xls":


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
			



			break;
			
			case "xlsx":

				$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
				
				if(!$InsProductoDisponibilidad->MtdEliminarTodoProductoDisponibilidad()){
?>
					<span class="EstImportarRegistrarNo">No se pudo vaciar la tabla de disponibilidad.</span><br />
<?php					
				}
				
				$xlsx = new SimpleXLSX($targetFile); 

				list($num_cols, $num_rows) = $xlsx->dimension(); 

				$fila = 0;
				$inicio_fila = 0;
				$inicio_columna = 0;

				foreach( $xlsx->rows() as $r ) { 

					for( $i = 0; $i < $num_cols; $i++ ) {

						if( strtoupper($r[$i]) == "MATERIAL NUMBER" ){
							$inicio_columna = $i;
							$inicio_fila = $fila;
							break;
						}

					}
					$fila++;
				}

/*?>

			<!--	<b>Ubicacion de Cabecera <?php echo $inicio_columna." - ".$inicio_fila;?></b>
<hr/>-->
<?php	*/	

		
			//exit();
				$fila = 1;
				foreach( $xlsx->rows() as $r ) { 
					
					if($inicio_fila <= $fila){
						
						$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
						
						for( $i=0; $i < $num_cols; $i++ ) {
					
							if($i==$inicio_columna){
								$InsProductoDisponibilidad->PdiCodigo  = ( (!empty($r[$i])) ? $r[$i] : '' );	
							}
							
							if($i == $inicio_columna + 1){
								$InsProductoDisponibilidad->PdiNombre  = ( (!empty($r[$i])) ? $r[$i] : '' );	
							}
						
							if($i == $inicio_columna + 2){
								$InsProductoDisponibilidad->PdiDisponible  = ( (!empty($r[$i])) ? $r[$i] : '' );	
							}
						
						}
						
						if(strtoupper($InsProductoDisponibilidad->PdiDisponible) == "SI"){
							$InsProductoDisponibilidad->PdiDisponible = 1;
						}else if(strtoupper($InsProductoDisponibilidad->PdiDisponible) == "NO"){
							$InsProductoDisponibilidad->PdiDisponible = 2;							
						}else{
							$InsProductoDisponibilidad->PdiDisponible = 0;
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