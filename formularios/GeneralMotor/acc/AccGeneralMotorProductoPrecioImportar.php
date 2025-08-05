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
	$file_name = strtolower($_FILES['CmpArchivo']['name']);	
	$targetPath = '../../../subidos/proveedor_excel/';
	$targetFile =  str_replace('//','/',$targetPath) . date("d-m-Y").'_P_'.($file_name);	
?>
    Nombre de Archivo: <?php echo $file_name;?><br />
  <?php
	if (move_uploaded_file($tempFile,$targetFile)){

			$data = new Spreadsheet_Excel_Reader();	
			$data->setOutputEncoding('CP1251');				
			$data->read($targetFile);

			$fila = 1;
			for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {	
				$InsArticulo = new ClsArticulo();
				$InsProveedorArticulo = new ClsProveedorArticulo();

				$InsArticulo->ArtId  = $data->sheets[0]['cells'][$i][1];
				$InsArticulo->ArtId  = str_replace("'", "&#8217;", $InsArticulo->ArtId);	
				$InsArticulo->ArtId = trim($InsArticulo->ArtId);
				
				$InsArticulo->MtdObtenerArticulo();

				if(!empty($InsArticulo->ArtTipo)){

					$InsProveedorArticulo->PrvId = $InsProveedor->PrvId;
					$InsProveedorArticulo->ArtId  = $InsArticulo->ArtId;

					$InsProveedorArticulo->MtdIdentificarProveedorArticulo(NULL,NULL,"ParId","DESC",1,$InsProveedorArticulo->PrvId,NULL,$InsProveedorArticulo->ArtId);

					$InsProveedorArticulo->ArtNombre  = $InsArticulo->ArtNombre;
					$InsProveedorArticulo->ArtDescripcion  = $InsArticulo->ArtDescripcion;
					$InsProveedorArticulo->ArtUnidadMedida  = $InsArticulo->ArtUnidadMedida;
					$InsProveedorArticulo->ParTipo  = $InsArticulo->ArtTipo;

					$InsProveedorArticulo->ParNombre  = $data->sheets[0]['cells'][$i][2];
					$InsProveedorArticulo->ParNombre  = str_replace("'", "&#8217;", $InsProveedorArticulo->ParNombre);	

					$InsProveedorArticulo->ParMarca  = $data->sheets[0]['cells'][$i][3];
					$InsProveedorArticulo->ParMarca  = str_replace("'", "&#8217;", $InsProveedorArticulo->ParMarca);	

					$InsProveedorArticulo->ParCodigo  = $data->sheets[0]['cells'][$i][4];
					$InsProveedorArticulo->ParCodigo  = str_replace("'", "&#8217;", $InsProveedorArticulo->ParCodigo);	

					$InsProveedorArticulo->ParTiempoCreacion = date("Y-m-d H:i:s");	
					$InsProveedorArticulo->ParTiempoModificacion = date("Y-m-d H:i:s");	

					if(!empty($InsProveedorArticulo->ParId)){

						if(!$InsProveedorArticulo->MtdEditarProveedorArticulo()){
?>
	<b>No se pudo actualizar el ARTICULO de PROVEEDOR: [<?php echo $InsProveedorArticulo->ArtId;?>] <?php echo $InsProveedorArticulo->ArtNombre;?> en la fila <?php echo $fila;?></b><br />
<?php
						}else{
?>
	Se actualizo correctamente el ARTICULO de PROVEEDOR: [<?php echo $InsProveedorArticulo->ArtId;?>] <?php echo $InsProveedorArticulo->ArtNombre;?> <br />
<?php							
						}

					}else{

						if(!$InsProveedorArticulo->MtdRegistrarProveedorArticulo()){
?>
	<b>No se pudo registrar el ARTICULO de PROVEEDOR: [<?php echo $InsProveedorArticulo->ArtId;?>] <?php echo $InsProveedorArticulo->ArtNombre;?> en la fila <?php echo $fila;?></b><br />
<?php
						}else{
?>
	Se registro correctamente el ARTICULO de PROVEEDOR: [<?php echo $InsProveedorArticulo->ArtId;?>] <?php echo $InsProveedorArticulo->ArtNombre;?><br />
<?php	
						}

					}

				}else{
?>
					CODIGO de ARTICULO no identificado, la fila <?php echo $fila;?> ha sido ignorada. <br />
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