<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';
$Identificador = $_GET['Identificador'];

require_once($InsProyecto->MtdRutLibrerias().'class.random.php');

$random = new Random();
$EspecificacionIdentificador = $random->random_text(10, false, false, true);
?>


<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td align="left" valign="top">
  
	<form method="post" enctype="multipart/form-data">
		<input type="file" id="CmpArchivoEspecificacion" name="CmpArchivoEspecificacion" />
		<input type="submit" value="Subir Archivo de Especificaciones" />
	</form>
	
	</td>
  </tr>
<tr>
<td align="left" valign="top">

<?php
if (!empty($_FILES)) {
	$tempFile = $_FILES['CmpArchivoEspecificacion']['tmp_name'];
	$file_name = strtolower($_FILES['CmpArchivoEspecificacion']['name']);	
	
	$file_name = $EspecificacionIdentificador.$file_name;
	
	$targetPath = '../../../subidos/vehiculo_especificaciones/';
	$targetFile =  str_replace('//','/',$targetPath) . ($file_name);	
	
	$extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
	$nombre_base = basename($file_name, '.'.$extension);  
	
	if($extension=="jpg" || $extension == "png" || $extension == "gif" || $extension == "jpeg" || $extension=="pdf" || $extension=="doc" || $extension=="docx" || $extension=="xls" || $extension=="xlsx"){
	
		if (move_uploaded_file($tempFile,$targetFile)){
			
			$_SESSION['SesVehEspecificacion'.$Identificador] = $file_name;
?>
Vista Previa:<br />

<a target="_blank" href="../../../subidos/vehiculo_especificaciones/<?php echo $nombre_base.".".$extension;?>"><?php echo $nombre_base.".".$extension;?><a/>


  <?php
		} else {
?>
  Hubo un error al subir el archivo de ESPECIFICACIONES
  <?php		
		}
	}else{
?>
  Solo se permiten archivos de ESPECIFICACIONES con extension: jpg, jpeg, png, gif, pdf, doc, docx, xls y xlsx.
  <?php
	}
	
}elseif(!empty($_SESSION['SesVehEspecificacion'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesVehEspecificacion'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesVehEspecificacion'.$Identificador], '.'.$extension);  
?>

Vista Previa:<br />
<a target="_blank" href="../../../subidos/vehiculo_especificaciones/<?php echo $nombre_base.".".$extension;?>"><?php echo $nombre_base.".".$extension;?><a/>

<?php	
}else{
?>
No hay archivo de ESPECIFICACIONES
<?php	
}
?>

</td>
</tr>
</table>