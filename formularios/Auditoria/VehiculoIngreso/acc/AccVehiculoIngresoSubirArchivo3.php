<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

$Identificador = $_GET['Identificador'];

require_once($InsProyecto->MtdRutLibrerias().'class.thumb.php');
require_once($InsProyecto->MtdRutLibrerias().'class.random.php');

$random = new Random();
$FotoIdentificador = $random->random_text(10, false, false, true);

$POST_Borrar = $_POST['CmpBorrar'];
?>


<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td width="91%" align="left" valign="top">
  
	<form method="post" enctype="multipart/form-data">
		<input type="file" id="CmpArchivoFoto" name="CmpArchivoFoto" />
		<input type="submit" value="Subir Foto" />
	</form>
	

	</td>
  <td width="9%" align="left" valign="top"><?php
	if($POST_Borrar=="1"){
	?>
    <?php $_SESSION['SesEinArchivoDAM3'.$Identificador] = ""; ?>
    <?php	
	}
?>
    <form method="post" enctype="multipart/form-data">
<input type="hidden" name="CmpBorrar" id="CmpBorrar" value="1" />
    <input type="submit" value="Borrar Archivo" />
  
  </form></td>
  </tr>
<tr>
<td colspan="2" align="left" valign="top">

<?php
if (!empty($_FILES)) {
	$tempFile = $_FILES['CmpArchivoFoto']['tmp_name'];
	$file_name = strtolower($_FILES['CmpArchivoFoto']['name']);	
	
	$file_name = $FotoIdentificador.$file_name;
	
	$targetPath = '../../../subidos/vehiculo_ingreso_archivos/';
	$targetFile =  str_replace('//','/',$targetPath) . ($file_name);	
	
	$extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
	$nombre_base = basename($file_name, '.'.$extension);  
	
	if($extension=="jpg" || $extension == "png" || $extension == "gif" || $extension == "jpeg"){
		if (move_uploaded_file($tempFile,$targetFile)){
			
			$_SESSION['SesEinArchivoDAM3'.$Identificador] = $file_name;
			
			$mythumb = new thumb();
			$mythumb->loadImage('../../../subidos/vehiculo_ingreso_archivos/'.$file_name);
			$mythumb->crop(250, 250,'bottom');
			$mythumb->save('../../../subidos/vehiculo_ingreso_archivos/'.$nombre_base.'_thumb.'.$extension, 100);
			
?>
	Vista Previa:<br />
    <a href="../../../subidos/vehiculo_ingreso_archivos/<?php echo $nombre_base.".".$extension;?>" target="_blank">
	<img  src="../../../subidos/vehiculo_ingreso_archivos/<?php echo $nombre_base."_thumb.".$extension;?>" width="100" height="120" border="0" title="<?php echo $nombre_base.".".$extension;?>" />
    </a>
  
  <?php
		} else {
?>
  Hubo un error al subir la ARCHIVO ADJUNTO
  <?php		
		}
	}else{
?>
  Solo se permiten FOTOS de imagen con extension: jpg, jpeg, png y gif.
  <?php
	}
	
}elseif(!empty($_SESSION['SesEinArchivoDAM3'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesEinArchivoDAM3'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesEinArchivoDAM3'.$Identificador], '.'.$extension);  
?>

	Vista Previa:<br />
    <a href="../../../subidos/vehiculo_ingreso_archivos/<?php echo $nombre_base.".".$extension;?>" target="_blank">
	<img  src="../../../subidos/vehiculo_ingreso_archivos/<?php echo $nombre_base."_thumb.".$extension;?>" width="100" height="120" border="0" title="<?php echo $nombre_base."_thumb.".$extension;?>" />
    </a>
    
<?php	
}else{
?>
No hay ARCHIVO ADJUNTO
<?php	
}
?>

</td>
</tr>
</table>



