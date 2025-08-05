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


require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');


$InsProducto = new ClsProducto();
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
	$targetPath = '../../../subidos/producto_excel/';

		$targetFile =  str_replace('//','/',$targetPath) . ($file_name);	
	
	$ext = pathinfo($targetFile, PATHINFO_EXTENSION);
	$file_name = date("d-m-Y")."_ARCHIVO1_".$Identificador.".".$ext;
	
	$targetFile =  str_replace('//','/',$targetPath) . $file_name;	
	
	 deb($_FILES['CmpArchivo']['error']);
	
	
//	$targetFile =  str_replace('//','/',$targetPath) . date("d-m-Y").'_P_'.(FncLimpiarCaracteresEspeciales($file_name));	
?>
    Nombre de Archivo: <?php echo $file_name;?><br />
  <?php
	if (move_uploaded_file($tempFile,$targetFile)){

		
		$path = $targetFile;
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		
		
		switch($ext){
		
			case "xls":

/*
				$InsProductoReemplazo = new ClsProductoReemplazo();
				
				if(!$InsProductoReemplazo->MtdEliminarTodoProductoReemplazo()){
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
						
						if( $aux  == "MATERIAL ANTIGUO" ){
							$inicio_columna = $j;
							$inicio_fila = $fila;
							break;
						}
					}
					$fila++;
				}

				

				$fila = 1;
				for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {	
					  
					$InsProductoReemplazo = new ClsProductoReemplazo();
					  
					$InsProductoReemplazo->PreCodigo  = $data->sheets[0]['cells'][$i][$inicio_columna];
					$InsProductoReemplazo->PreCodigo  = str_replace("'", "&#8217;", $InsProductoReemplazo->PreCodigo);	
					 
					$InsProductoReemplazo->PreNombre  = $data->sheets[0]['cells'][$i][$inicio_columna+1];
					$InsProductoReemplazo->PreNombre  = str_replace("'", "&#8217;", $InsProductoReemplazo->PreNombre);	
					  
					$InsProductoReemplazo->PreDisponible  = $data->sheets[0]['cells'][$i][$inicio_columna+2];
					$InsProductoReemplazo->PreDisponible  = str_replace("'", "&#8217;", $InsProductoReemplazo->PreDisponible);	
					$InsProductoReemplazo->PreTiempoCreacion = date("Y-m-d H:i:s");
					
					if(!empty($InsProductoReemplazo->PreCodigo)){
			
						if($InsProductoReemplazo->MtdRegistrarProductoReemplazo()){
			?>
							<span class="EstImportarRegistrarSi">[Fila <?php echo $fila;?>]> <?php echo $InsProductoReemplazo->PreCodigo;?>, Se registro correctamente.</span><br />
			<?php
						}else{
			?>
							<span class="EstImportarRegistrarNo">[Fila <?php echo $fila;?>]> <?php echo $InsProductoReemplazo->PreCodigo;?>, No se pudo registrar.</span><br />
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

				$InsProductoReemplazo = new ClsProductoReemplazo();
				
				if(!$InsProductoReemplazo->MtdEliminarTodoProductoReemplazo()){
?>
					<span class="EstImportarRegistrarNo">No se pudo vaciar la tabla de cadenas de reemplazo.</span><br />
<?php					
				}
				
				$xlsx = new SimpleXLSX($targetFile); 

				list($num_cols, $num_rows) = $xlsx->dimension(); 

				
				$fila = 1;
				foreach( $xlsx->rows() as $r ) { 
					//echo "".$i;
					//echo "<br>";
					
					if($inicio_fila <= $fila){
						
						$InsProductoReemplazo = new ClsProductoReemplazo();
						
						for( $i=1; $i < $num_cols; $i++ ) {
							
						//	echo "[ ".$r[$i]."] ";
							//echo "<br>";
							
							if($i==3){
								$InsProductoReemplazo->PreCodigo1  = ( (!empty($r[$i])) ? $r[$i] : '' );
								$InsProductoReemplazo->PreCodigo1 = trim($InsProductoReemplazo->PreCodigo1);		
							}
							
							if($i == 4){
								$InsProductoReemplazo->PreCodigo2  = ( (!empty($r[$i])) ? $r[$i] : '' );
								$InsProductoReemplazo->PreCodigo2 = trim($InsProductoReemplazo->PreCodigo2);	
							}
						
							if($i == 5){
								$InsProductoReemplazo->PreCodigo3  = ( (!empty($r[$i])) ? $r[$i] : '' );
								$InsProductoReemplazo->PreCodigo3 = trim($InsProductoReemplazo->PreCodigo3);		
							}
							
							if($i == 6){
								$InsProductoReemplazo->PreCodigo4  = ( (!empty($r[$i])) ? $r[$i] : '' );
								$InsProductoReemplazo->PreCodigo4 = trim($InsProductoReemplazo->PreCodigo4);		
							}
							
							
							if($i == 7){
								$InsProductoReemplazo->PreCodigo5  = ( (!empty($r[$i])) ? $r[$i] : '' );	
								$InsProductoReemplazo->PreCodigo5 = trim($InsProductoReemplazo->PreCodigo5);
							}
							
							
							if($i == 8){
								$InsProductoReemplazo->PreCodigo6  = ( (!empty($r[$i])) ? $r[$i] : '' );	
								$InsProductoReemplazo->PreCodigo6 = trim($InsProductoReemplazo->PreCodigo6);
							}
							
							if($i == 9){
								$InsProductoReemplazo->PreCodigo7  = ( (!empty($r[$i])) ? $r[$i] : '' );
								$InsProductoReemplazo->PreCodigo7 = trim($InsProductoReemplazo->PreCodigo7);	
							}
							
							if($i == 10){
								$InsProductoReemplazo->PreCodigo8  = ( (!empty($r[$i])) ? $r[$i] : '' );	
								$InsProductoReemplazo->PreCodigo8 = trim($InsProductoReemplazo->PreCodigo8);
							}
							
							if($i == 11){
								$InsProductoReemplazo->PreCodigo9  = ( (!empty($r[$i])) ? $r[$i] : '' );
								$InsProductoReemplazo->PreCodigo9 = trim($InsProductoReemplazo->PreCodigo9);	
							}
							
							if($i == 12){
								$InsProductoReemplazo->PreCodigo10  = ( (!empty($r[$i])) ? $r[$i] : '' );	
								$InsProductoReemplazo->PreCodigo10 = trim($InsProductoReemplazo->PreCodigo10);	
							}
							
							if($i == 13){
								$InsProductoReemplazo->PreCodigo11  = ( (!empty($r[$i])) ? $r[$i] : '' );	
								$InsProductoReemplazo->PreCodigo11 = trim($InsProductoReemplazo->PreCodigo11);	
							}	
							
							if($i == 14){
								$InsProductoReemplazo->PreCodigo12  = ( (!empty($r[$i])) ? $r[$i] : '' );	
								$InsProductoReemplazo->PreCodigo12 = trim($InsProductoReemplazo->PreCodigo12);	
							}			

						}
						
						
						$InsProductoReemplazo->PreEstado = 1;
						$InsProductoReemplazo->PreTiempoCreacion = date("Y-m-d H:i:s");
						
						if(!empty($InsProductoReemplazo->PreCodigo1)){
				
							if($InsProductoReemplazo->MtdRegistrarProductoReemplazo()){
				?>
								<span class="EstImportarRegistrarSi">[Fila <?php echo $fila;?>]> <?php echo $InsProductoReemplazo->PreCodigo1;?>, Se registro correctamente.</span><br />
				<?php
							}else{
				?>
								<span class="EstImportarRegistrarNo">[Fila <?php echo $fila;?>]> <?php echo $InsProductoReemplazo->PreCodigo1;?>, No se pudo registrar.</span><br />
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