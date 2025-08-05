<?php
//session_start();
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
<?php require_once($InsProyecto->MtdRutLibrerias().'excel/OLERead.php');?>
<?php require_once($InsProyecto->MtdRutLibrerias().'excel/reader.php');?>
<?php require_once($InsProyecto->MtdRutLibrerias().'simplexlsx.class.php');?>
<?php
$Identificador = $_GET['Identificador'];

require_once($InsPoo->MtdPaqActividad().'ClsCampanaVehiculo.php');

session_start();
if (!isset($_SESSION['InsCampanaVehiculo'.$Identificador])){
	$_SESSION['InsCampanaVehiculo'.$Identificador] = new ClsSesionObjeto();
}


//echo $Identificador;

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
	$targetPath = '../../../subidos/campana/';
	$targetFile =  str_replace('//','/',$targetPath) . ($file_name);	
	
	$ext = pathinfo($targetFile, PATHINFO_EXTENSION);
	$file_name = date("d-m-Y")."_ARCHIVO1_".$Identificador.".".$ext;
	
	$targetFile =  str_replace('//','/',$targetPath) . $file_name;	
	
?>

    Nombre de Archivo: <b><?php echo $file_name;?></b>. <br />

<?php
	if (move_uploaded_file($tempFile,$targetFile)){
?>
		Se subio correctamente: <b><?php echo utf8_encode($file_name);?></b>.
<?php
		$_SESSION['CampanaArchivo1'.$Identificador] = $file_name;


	unset($_SESSION['InsCampanaVehiculo'.$Identificador]);	
	
	$_SESSION['InsCampanaVehiculo'.$Identificador] = new ClsSesionObjeto();
	
	//deb($ext);
		//$path = $targetFile;
		//$ext = pathinfo($path, PATHINFO_EXTENSION);
?>
<hr /><hr />
Leyendo datos...<br /><br />
<?php
		switch($ext){
		
			case "xls":


				$InsCampanaVehiculo = new ClsCampanaVehiculo();
				
				
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
						
						if( $aux  == "VIN" or $aux  == "CHASIS-VIN" ){
							$inicio_columna = $j;
							$inicio_fila = $fila;
							break;
						}
					}
					$fila++;
				}

				

				$fila = 1;
				for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {	
					  
					$InsCampanaVehiculo = new ClsCampanaVehiculo();
					  
					$InsCampanaVehiculo->AveVIN  = $data->sheets[0]['cells'][$i][$inicio_columna];
					$InsCampanaVehiculo->AveVIN  = str_replace("'", "&#8217;", $InsCampanaVehiculo->AveVIN);	
					  
					$InsCampanaVehiculo->AveEstado = 1;
					$InsCampanaVehiculo->AveTiempoCreacion = date("Y-m-d H:i:s");
					$InsCampanaVehiculo->AveTiempoModificacion = date("Y-m-d H:i:s");
			
					if(!empty($InsCampanaVehiculo->AveVIN)){
				
							
								
									//SesionObjeto-InsCampanaVehiculo
									//Parametro1 = AveId
									//Parametro2 = AveVIN
									//Parametro3 = 
									//Parametro4 = 
									//Parametro5 = 
									//Parametro6 = AveEstado
									//Parametro7 = AveTiempoCreacion
									//Parametro8 = AveTiempoModificacion
	
								$_SESSION['InsCampanaVehiculo'.$Identificador]->MtdAgregarSesionObjeto(1,
								NULL,
								$InsCampanaVehiculo->AveVIN,
								NULL,
								NULL,
								NULL,
								1,
								date("d/m/Y H:i:s"),
								date("d/m/Y H:i:s")
								);
	
				?>
								<span class="EstImportarRegistrarSi">[Fila <?php echo $fila;?>]> <?php echo $InsCampanaVehiculo->AveVIN;?>, Se hizo la lectura correctamente.</span><br />
				<?php
						}else{
?>
								<span class="EstImportarRegistrarNo">[Fila <?php echo $fila;?>]> <?php echo $InsCampanaVehiculo->AveVIN;?>, no se encontro VIN.</span><br />
<?php	
						}
						
						
						
						
					?>
					
					<hr />
					<?php					
					  $fila++;
					}			
			



			break;
			
			case "xlsx":

				
				$xlsx = new SimpleXLSX($targetFile); 

				list($num_cols, $num_rows) = $xlsx->dimension(); 

				$fila = 0;
				$inicio_fila = 0;
				$inicio_columna = 0;

				foreach( $xlsx->rows() as $r ) { 

					for( $i = 0; $i < $num_cols; $i++ ) {

						if( strtoupper($r[$i]) == "VIN" or strtoupper($r[$i]) == "CHASIS-VIN" ){
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
						
						$InsCampanaVehiculo = new ClsCampanaVehiculo();
						
						for( $i=0; $i < $num_cols; $i++ ) {
					
							if($i==$inicio_columna){
								$InsCampanaVehiculo->AveVIN  = ( (!empty($r[$i])) ? $r[$i] : '' );	
							}
							
						
						}
					
						$InsCampanaVehiculo->AveEstado = 1;
						$InsCampanaVehiculo->AveTiempoCreacion = date("Y-m-d H:i:s");
						$InsCampanaVehiculo->AveTiempoModificacion = date("Y-m-d H:i:s");
						
						if(!empty($InsCampanaVehiculo->AveVIN)){
				
							
								
									//SesionObjeto-InsCampanaVehiculo
									//Parametro1 = AveId
									//Parametro2 = AveVIN
									//Parametro3 = 
									//Parametro4 = 
									//Parametro5 = 
									//Parametro6 = AveEstado
									//Parametro7 = AveTiempoCreacion
									//Parametro8 = AveTiempoModificacion
	
								$_SESSION['InsCampanaVehiculo'.$Identificador]->MtdAgregarSesionObjeto(1,
								NULL,
								$InsCampanaVehiculo->AveVIN,
								NULL,
								NULL,
								NULL,
								1,
								date("d/m/Y H:i:s"),
								date("d/m/Y H:i:s")
								);
	
				?>
								<span class="EstImportarRegistrarSi">[Fila <?php echo $fila;?>]> <?php echo $InsCampanaVehiculo->AveVIN;?>, Se hizo la lectura correctamente.</span><br />
				<?php
						}else{
?>
								<span class="EstImportarRegistrarNo">[Fila <?php echo $fila;?>]> <?php echo $InsCampanaVehiculo->AveVIN;?>, no se encontro VIN.</span><br />
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
		$_SESSION['CampanaArchivo1'.$Identificador] = "";
?>
    Hubo un error al subir el archivo
<?php		
	}
?>

<?php
	
}
?></td>
</tr>
</table>

	</form>
    
    
<?php
//name="BtnEnviar"
if(!isset($_POST['BtnEnviar'])){
?>

<hr />
Archivo actual: <b><?php echo $_SESSION['CampanaArchivo1'.$Identificador];?></b>
<hr />

<?php
$RepCampanaVehiculo = $_SESSION['InsCampanaVehiculo'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrCampanaVehiculos = $RepCampanaVehiculo['Datos'];
?>


<?php
if(!empty($ArrCampanaVehiculos)){
	foreach($ArrCampanaVehiculos as $DatCampanaVehiculo){
?>

	<?php echo $DatCampanaVehiculo->Parametro2;?><br />

<?php
	}	
}else{
?>
No se encontraron registros.
<?php	
}
?>


<?php
}
?>
  