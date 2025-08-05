<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta  = '../../../';

/*
*Configuraciones
*/
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
/*
*Clases de Conexion
*/
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
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
require_once($InsProyecto->MtdRutClases().'ClsCliente.php');
require_once($InsProyecto->MtdRutClases().'ClsClienteCategoria.php');



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
			
				$InsCliente = new ClsCliente();

				$InsCliente->CliId  = $data->sheets[0]['cells'][$i][6];
				$InsCliente->CliId  = str_replace("'", "&#8217;", $InsCliente->CliId);	
				$InsCliente->CliId = trim($InsCliente->CliId);
							
				
					if (empty($InsCliente->CliId)){
						
						$InsCliente->CcaId = "CCA-1";	
						
						$InsCliente->CliNombre  = $data->sheets[0]['cells'][$i][3];
						$InsCliente->CliNombre  = str_replace("'", "&#8217;", $InsCliente->CliNombre);	
						$InsCliente->CliNombre = utf8_encode($InsCliente->CliNombre);
						
						$InsCliente->CliDireccion  = $data->sheets[0]['cells'][$i][2];
						$InsCliente->CliDireccion  = str_replace("'", "&#8217;", $InsCliente->CliDireccion);	
						$InsCliente->CliDireccion = utf8_encode($InsCliente->CliDireccion);
		
						$InsCliente->CliTelefono  = $data->sheets[0]['cells'][$i][4];
						$InsCliente->CliTelefono  = str_replace("'", "&#8217;", $InsCliente->CliTelefono);	

						$InsCliente->CliCelular  = $data->sheets[0]['cells'][$i][4];
						$InsCliente->CliCelular  = str_replace("'", "&#8217;", $InsCliente->CliCelular);	
											
						$InsCliente->CliZona  = $data->sheets[0]['cells'][$i][5];
						$InsCliente->CliZona  = str_replace("'", "&#8217;", $InsCliente->CliZona);	
									$InsCliente->CliConfirmado  = 2;
						$InsCliente->CliEstado  = 1;			
						$InsCliente->CliTiempoCreacion = date("Y-m-d H:i:s");
						$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
						
						if(empty($InsCliente->CliTelefono) and empty($InsCliente->CliCelular)){
?>
No se encontraron telefonos o celulares en la fila (<?php echo $fila;?>)
<?php
						}else{
							
							if(!empty($InsCliente->CliCelular)){

								$InsCliente->MtdVerificarExisteClienteCelular();
								
								if(!empty($InsCliente->CliId)){		
									$InsCliente->MtdObtenerCliente();
								?>
	                                Celular <b>(<?php echo $InsCliente->CliCelular;?>)</b> de Cliente identificado <b><?php echo $InsCliente->CliNombre;?>)</b> se actualizaran sus datos
                                <?php					
									if(!$InsCliente->MtdEditarCliente2()){
								?>
										<i>No se pudo actualizar.</i>
                                <?php		
									}
								}else{
								?>
	                                Cliente no identificado <b><?php echo $InsCliente->CliNombre;?>)</b> se registran sus datos
                                <?php					
									
									if(!$InsCliente->MtdRegistrarCliente()){
								?>
										<i>No se pudo registrar.</i>
                                <?php		
									}
								}

							}else{
								
								$InsCliente->MtdVerificarExisteClienteTelefono();
								
								if(!empty($InsCliente->CliId)){		
									$InsCliente->MtdObtenerCliente();	
								?>
	                               Telefono <b>(<?php echo $InsCliente->CliTelefono;?>)</b> de Cliente identificado <b><?php echo $InsCliente->CliNombre;?>)</b> se actualizaran sus datos
                                <?php					
									if(!$InsCliente->MtdEditarCliente2()){
								?>
										<i>No se pudo actualizar.</i>
                                <?php		
									}
								}else{
								?>
	                                Cliente no identificado <b><?php echo $InsCliente->CliNombre;?>)</b> se registran sus datos
                                <?php					
									
									if(!$InsCliente->MtdRegistrarCliente()){
								?>
										<i>No se pudo registrar.</i>
                                <?php		
									}
								}
	
							}
							
						}
						
						
						
						

					}else{
		?>
    
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

