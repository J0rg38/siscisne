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
require_once($InsProyecto->MtdRutClases().'ClsPropietario.php');
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
			
				$InsPropietario = new ClsPropietario();
							
						$InsPropietario->ProId  = $data->sheets[0]['cells'][$i][1];
						$InsPropietario->ProId  = str_replace("'", "&#8217;", $InsPropietario->ProId);	
						$InsPropietario->ProId = trim($InsPropietario->ProId);
						
						$InsPropietario->MtdObtenerPropietario();
							
						$InsPropietario->ProOtroCodigo  = $data->sheets[0]['cells'][$i][2];
						$InsPropietario->ProOtroCodigo  = str_replace("'", "&#8217;", $InsPropietario->ProOtroCodigo);	
						
						$InsPropietario->ProNumeroDocumento  = $data->sheets[0]['cells'][$i][3];
						$InsPropietario->ProNumeroDocumento  = str_replace("'", "&#8217;", $InsPropietario->ProNumeroDocumento);	
		
						$InsPropietario->ProNombre  = $data->sheets[0]['cells'][$i][4];
						$InsPropietario->ProNombre  = str_replace("'", "&#8217;", $InsPropietario->ProNombre);	

						$InsPropietario->ProApellido  = $data->sheets[0]['cells'][$i][5];
						$InsPropietario->ProApellido  = str_replace("'", "&#8217;", $InsPropietario->ProApellido);	
											
						$InsPropietario->ProTelefono  = $data->sheets[0]['cells'][$i][6];
						$InsPropietario->ProTelefono  = str_replace("'", "&#8217;", $InsPropietario->ProTelefono);	

						$InsPropietario->ProCelular  = $data->sheets[0]['cells'][$i][7];
						$InsPropietario->ProCelular  = str_replace("'", "&#8217;", $InsPropietario->ProCelular);	

						$InsPropietario->ProDreccion  = $data->sheets[0]['cells'][$i][8];
						$InsPropietario->ProDreccion  = str_replace("'", "&#8217;", $InsPropietario->ProDreccion);										

						$InsPropietario->ProGarantia  = $data->sheets[0]['cells'][$i][9];
						$InsPropietario->ProGarantia  = str_replace("'", "&#8217;", $InsPropietario->ProGarantia);	
						
						$InsPropietario->ProDeudaPendiente  = $data->sheets[0]['cells'][$i][10];
						$InsPropietario->ProDeudaPendiente  = str_replace("'", "&#8217;", $InsPropietario->ProDeudaPendiente);	

						$InsPropietario->ProFechaRecibo  = $data->sheets[0]['cells'][$i][11];
						$InsPropietario->ProFechaRecibo  = str_replace("'", "&#8217;", $InsPropietario->ProFechaRecibo);										
						$InsPropietario->ProFechaRecibo = FncCambiaFechaAMysql($InsPropietario->ProFechaRecibo,true);	
						
						$InsPropietario->ProFechaReingreso  = $data->sheets[0]['cells'][$i][12];
						$InsPropietario->ProFechaReingreso  = str_replace("'", "&#8217;", $InsPropietario->ProFechaReingreso);										
						$InsPropietario->ProFechaReingreso = FncCambiaFechaAMysql($InsPropietario->ProFechaReingreso,true);	

						$InsPropietario->ProTiempoCreacion = date("Y-m-d H:i:s");
						$InsPropietario->ProTiempoModificacion = date("Y-m-d H:i:s");
						
						if(!empty($InsPropietario->ProNombre)){
							if(!empty($InsPropietario->ProId)){		
	
								if($InsPropietario->MtdEditarPropietario()){
	?>
									<?php echo $fila;?>=> <?php echo $InsPropietario->ProId;?> - <?php echo $InsPropietario->ProNombre;?> <?php echo $InsPropietario->ProApellido;?>: Se actualizo correctamente <br />
	<?php		
								}else{
	?>
									<?php echo $fila;?>=> <?php echo $InsPropietario->ProId;?> - <?php echo $InsPropietario->ProNombre;?> <?php echo $InsPropietario->ProApellido;?>: <b>No se pudo actualizar</b> <br />
	<?php								
								}
	
							}else{
								
								$InsPropietario->ProEstado  = 1;		
								
								if($InsPropietario->MtdRegistrarPropietario()){
	?>
									<?php echo $fila;?>=> <?php echo $InsPropietario->ProId;?> - <?php echo $InsPropietario->ProNombre;?> <?php echo $InsPropietario->ProApellido;?>: Se registro correctamente <br />
	<?php		
								}else{
	?>
									<?php echo $fila;?>=> <?php echo $InsPropietario->ProId;?> - <?php echo $InsPropietario->ProNombre;?> <?php echo $InsPropietario->ProApellido;?>: <b>No se pudo registrar</b> <br />
	<?php	
								}
								
							}
						}else{
?>
									<?php echo $fila;?>=> <?php echo $InsPropietario->ProId;?> - <?php echo $InsPropietario->ProNombre;?> <?php echo $InsPropietario->ProApellido;?>: <b>Los campos NOMBRE son obligatorios</b> <br />
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

