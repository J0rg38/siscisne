<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');

$InsProyecto->Ruta= '../../../';

/*
*Configuraciones
*/
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
/*
*Clases de Conexion
*/
require_once($InsProyecto->MtdRutClases().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
/*
*Funciones
*/
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');
?>

<!--
Libreria leer excel
-->
<?php require_once($InsProyecto->MtdRutLibrerias().'excel/OLERead.php');?>
<?php require_once($InsProyecto->MtdRutLibrerias().'excel/reader.php');?>


<?php
require_once($InsProyecto->MtdRutClases().'ClsConductor.php');
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
    <?php
if (!empty($_FILES)) {
	$tempFile = $_FILES['CmpArchivo']['tmp_name'];
	$file_name = strtolower($_FILES['CmpArchivo']['name']);	
	$targetPath = '../../../subidos/cliente_importar/';
	$targetFile =  str_replace('//','/',$targetPath) . date("d-m-Y").'_P_'.($file_name);	
?>
Nombre de Archivo: <?php echo $file_name;?><br />
<?php
	if (move_uploaded_file($tempFile,$targetFile)){

			$data = new Spreadsheet_Excel_Reader();	
			$data->setOutputEncoding('CP1251');				
			$data->read($targetFile);

			$fila = 1;
			for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {	
			
				$InsConductor = new ClsConductor();
						
				
				$VehiculoUnidad  = $data->sheets[0]['cells'][$i][1];
				$VehiculoUnidad  = str_replace("'", "&#8217;", $VehiculoUnidad);	
				
				$InsVehiculo->MtdIdentificarVehiculoUnidad($VehiculoUnidad);
				
				if(empty($InsVehiculo->VehId)){
						
					
						
				}else{
					
					
					
				}
				
			
		
				
				$InsConductor->ConNumeroDocumento  = $data->sheets[0]['cells'][$i][5];
				$InsConductor->ConNumeroDocumento  = str_replace("'", "&#8217;", $InsConductor->ConNumeroDocumento);	
		
				$InsConductor->ConNombre  = $data->sheets[0]['cells'][$i][4];
				$InsConductor->ConNombre  = str_replace("'", "&#8217;", $InsConductor->ConNombre);	
			
				$InsConductor->ConTelefono  = $data->sheets[0]['cells'][$i][9];
				$InsConductor->ConTelefono  = str_replace("'", "&#8217;", $InsConductor->ConTelefono);	

				$InsConductor->ConCelular  = $data->sheets[0]['cells'][$i][9];
				$InsConductor->ConCelular  = str_replace("'", "&#8217;", $InsConductor->ConCelular);	

				$InsConductor->ConDreccion  = $data->sheets[0]['cells'][$i][6];
				$InsConductor->ConDreccion  = str_replace("'", "&#8217;", $InsConductor->ConDreccion);										
															
				$InsConductor->ConTiempoCreacion = date("Y-m-d H:i:s");
				$InsConductor->ConTiempoModificacion = date("Y-m-d H:i:s");
		
		
		
		
						
						if(!empty($InsConductor->ConNombre) ){
							if(!empty($InsConductor->ConId)){		
	
								if($InsConductor->MtdEditarConductor()){
	?>
									<?php echo $fila;?>=> <?php echo $InsConductor->ConId;?> - <?php echo $InsConductor->ConNombre;?> <?php echo $InsConductor->ConApellido;?>: Se actualizo correctamente <br />
	<?php		
								}else{
	?>
									<?php echo $fila;?>=> <?php echo $InsConductor->ConId;?> - <?php echo $InsConductor->ConNombre;?> <?php echo $InsConductor->ConApellido;?>: <b>No se pudo actualizar</b> <br />
	<?php								
								}
	
							}else{
								
//								$InsConductor->ConEstado  = 1;		
								
								/*if($InsConductor->MtdRegistrarConductor()){
	?>
									<?php echo $fila;?>=> <?php echo $InsConductor->ConId;?> - <?php echo $InsConductor->ConNombre;?> <?php echo $InsConductor->ConApellido;?>: Se registro correctamente <br />
	<?php		
								}else{
	?>
									<?php echo $fila;?>=> <?php echo $InsConductor->ConId;?> - <?php echo $InsConductor->ConNombre;?> <?php echo $InsConductor->ConApellido;?>: <b>No se pudo registrar</b> <br />
	<?php	
								}*/
								
							}
						}else{
?>
									<?php echo $fila;?>=> <?php echo $InsConductor->ConId;?> - <?php echo $InsConductor->ConNombre;?> <?php echo $InsConductor->ConApellido;?>: <b>Los campos NOMBRE y TURNO son obligatorios</b> <br />
<?php

                                    
						}

	
?>
<hr />
<?php					
				$fila++;
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

