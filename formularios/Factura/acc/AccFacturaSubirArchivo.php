<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsPoo->Ruta= '../../../';
$InsProyecto->Ruta= '../../../';

$Identificador = $_GET['Identificador'];

?>
<?php require_once($InsProyecto->MtdRutLibrerias().'class.thumb.php');?>
<?php require_once($InsProyecto->MtdRutLibrerias().'class.random.php');?>
<?php
$random = new Random();
$FotoIdentificador = $random->random_text(10, false, false, true);
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td align="left" valign="top"><form method="post" enctype="multipart/form-data">
    <input type="file" id="CmpArchivoFoto" name="CmpArchivoFoto" />
    <input type="submit" value="Subir Foto" />
  </form></td>
  </tr>
<tr>
<td align="left" valign="top">
  <?php
if (!empty($_FILES)) {
	$tempFile = $_FILES['CmpArchivoFoto']['tmp_name'];
	$file_name = strtolower($_FILES['CmpArchivoFoto']['name']);	
	
	$file_name = $FotoIdentificador.$file_name;
	
	$targetPath = '../../../subidos/factura_orden_fotos/';
	$targetFile =  str_replace('//','/',$targetPath) . ($file_name);	
	
	$extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
	$nombre_base = basename($file_name, '.'.$extension);  
	
	if($extension=="jpg" || $extension == "png" || $extension == "gif" || $extension == "jpeg"){
		if (move_uploaded_file($tempFile,$targetFile)){
			
			$_SESSION['SesFacOrdenFoto'.$Identificador] = $file_name;
			
			$mythumb = new thumb();
			$mythumb->loadImage('../../../subidos/factura_orden_fotos/'.$file_name);
			$mythumb->crop(250, 250,'bottom');
			$mythumb->save('../../../subidos/factura_orden_fotos/'.$nombre_base.'_thumb.'.$extension, 100);
			
			
//			$mythumb = new thumb();
//			$mythumb->loadImage('../../../subidos/factura_orden_fotos/'.$file_name);
//			$mythumb->crop(21, 20,'bottom');
//			$mythumb->save('../../../subidos/factura_orden_fotos/'.$nombre_base.'_thumb2.'.$extension, 20);

?>
Vista Previa:<br />
  
  <img  src="../../../subidos/factura_orden_fotos/<?php echo $nombre_base.".".$extension;?>" title="<?php echo $nombre_base.".".$extension;?>" />
  <!--<img  src="../../../subidos/factura_orden_fotos/<?php echo $nombre_base."_thumb.".$extension;?>" title="<?php echo $nombre_base."_thumb.".$extension;?>" />-->
  <?php
		} else {
?>
  Hubo un error al subir la FOTO
  <?php		
		}
	}else{
?>
  Solo se permiten FOTOS de imagen con extension: jpg, jpeg, png y gif.
  <?php
	}
	
}elseif(!empty($_SESSION['SesFacOrdenFoto'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesFacOrdenFoto'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesFacOrdenFoto'.$Identificador], '.'.$extension);  
?>

Vista Previa:<br />
<!--  <img  src="../../../subidos/factura_orden_fotos/<?php echo $nombre_base."_thumb.".$extension;?>" title="<?php echo $nombre_base."_thumb.".$extension;?>" />-->
  
	<img  src="../../../subidos/factura_orden_fotos/<?php echo $nombre_base.".".$extension;?>" title="<?php echo $nombre_base."_thumb.".$extension;?>" />
<?php	
}else{
?>
No hay FOTO
<?php	
}
?></td>
</tr>
</table>