<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsPoo->Ruta= '../../../';
$InsProyecto->Ruta= '../../../';



?>
<?php require_once($InsProyecto->MtdRutLibrerias().'/thumb/image.class.php');?>
<?php require_once($InsProyecto->MtdRutLibrerias().'/class.thumb.php');?>



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
	$targetPath = '../../../subidos/personal_fotos/';
	$targetFile =  str_replace('//','/',$targetPath) . ($file_name);	
	
	$extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
	$nombre_base = basename($file_name, '.'.$extension);  
	
	if($extension=="jpg" || $extension == "png" || $extension == "gif" || $extension == "jpeg"){
		if (move_uploaded_file($tempFile,$targetFile)){
			
			$_SESSION['SesPerFoto'] = $file_name;
			


$img = new Zubrag_image;

// initialize
$img->max_x        = 100;
$img->max_y        = 100;
$img->cut_x        = 0;
$img->cut_y        = 0;
$img->quality      = 100;
$img->save_to_file = true;
$img->image_type   = -1;

// generate thumbnail
$img->GenerateThumbFile('../../../subidos/personal_fotos/'.$file_name, '../../../subidos/personal_fotos/'.$nombre_base.'_thumb.'.$extension);



$img = new Zubrag_image;

// initialize
$img->max_x        = 50;
$img->max_y        = 50;
$img->cut_x        = 0;
$img->cut_y        = 0;
$img->quality      = 100;
$img->save_to_file = true;
$img->image_type   = -1;

// generate thumbnail
$img->GenerateThumbFile('../../../subidos/personal_fotos/'.$file_name, '../../../subidos/personal_fotos/'.$nombre_base.'_thumb2.'.$extension);


//			$mythumb = new thumb();
//			$mythumb->loadImage('../../../subidos/personal_fotos/'.$file_name);
//			$mythumb->crop(80, 80,'center');
//			$mythumb->save('../../../subidos/personal_fotos/'.$nombre_base.'_thumb.'.$extension, 80);
//			
//			$mythumb = new thumb();
//			$mythumb->loadImage('../../../subidos/personal_fotos/'.$file_name);
//			$mythumb->crop(20, 60,'center');
//			$mythumb->save('../../../subidos/personal_fotos/'.$nombre_base.'_thumb2.'.$extension, 20);

?>
Vista Previa:<br />

<!-- <img  src="../../../subidos/personal_fotos/<?php echo $nombre_base.".".$extension;?>" title="<?php echo $nombre_base.".".$extension;?>" /><br />
 -->
 
  <img  src="../../../subidos/personal_fotos/<?php echo $nombre_base."_thumb.".$extension;?>" title="<?php echo $nombre_base."_thumb.".$extension;?>" /><br />
  
<!--    <img  src="../../../subidos/personal_fotos/<?php echo $nombre_base."_thumb2.".$extension;?>" title="<?php echo $nombre_base."_thumb2.".$extension;?>" />-->
    
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
	
}elseif(!empty($_SESSION['SesPerFoto'])){
	
	$extension = strtolower(pathinfo($_SESSION['SesPerFoto'], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesPerFoto'], '.'.$extension);  
?>

Vista Previa:<br />
  <img  src="../../../subidos/personal_fotos/<?php echo $nombre_base."_thumb.".$extension;?>" title="<?php echo $nombre_base."_thumb.".$extension;?>" />
  
  
<?php	
}else{
?>
No hay FOTO
<?php	
}
?></td>
</tr>
</table>