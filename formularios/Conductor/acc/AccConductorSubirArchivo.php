<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');

$InsProyecto->Ruta= '../../../';

$Identificador = $_GET['Identificador'];

?>

<?php require_once($InsProyecto->MtdRutLibrerias().'class.thumb.php');?>
<?php require_once($InsProyecto->MtdRutLibrerias().'class.random.php');?>

<?php require_once($InsProyecto->MtdRutLibrerias().'/thumb/image.class.php');?>
<?php require_once($InsProyecto->MtdRutLibrerias().'/class.thumb.php');?>


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
	
	
	$file_name = ($_FILES['CmpArchivoFoto']['name']);	
	
	$file_name = $FotoIdentificador.$file_name;

	$file_name = (preg_replace("/ /", "-", $file_name));

//var_dump($tempFile);
//echo "<br><br>";

//var_dump($file_name);

//	$file_name = preg_replace("/ /", "", $file_name);
//	$file_name = preg_replace("/. /", "", $file_name);	
	

	$targetPath = '../../../subidos/conductor_fotos/';
	$targetFile =  str_replace('//','/',$targetPath) . (preg_replace("/ /", "-", $file_name));	

//echo "<br><br>";
	
//var_dump($targetFile);


	
	$extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
	$nombre_base = basename($file_name, '.'.$extension);  
	
	if($extension=="jpg" || $extension == "png" || $extension == "gif" || $extension == "jpeg"){
		
		if (move_uploaded_file($tempFile,$targetFile)){
			
			$_SESSION['SesConFoto'.$Identificador] = $file_name;
			
//			$mythumb = new thumb();
//			$mythumb->loadImage('../../../subidos/conductor_fotos/'.$file_name);
//			$mythumb->crop(250, 250,'bottom');
//			$mythumb->save('../../../subidos/conductor_fotos/'.$nombre_base.'_thumb.'.$extension, 100);
//var_dump('../../../subidos/conductor_fotos/'.$file_name);

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
//$img->GenerateThumbFile('../../../subidos/conductor_fotos/'.$file_name, '../../../subidos/conductor_fotos/'.$nombre_base.'_thumb.'.$extension);

$img->GenerateThumbFile($targetFile, '../../../subidos/conductor_fotos/'.$nombre_base.'_thumb.'.$extension);



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


$img->GenerateThumbFile($targetFile, '../../../subidos/conductor_fotos/'.$nombre_base.'_thumb2.'.$extension);

//$img->GenerateThumbFile('../../../subidos/conductor_fotos/'.$file_name, '../../../subidos/conductor_fotos/'.$nombre_base.'_thumb2.'.$extension);
?>
Vista Previa:<br />
  
<!--  <img  src="../../../subidos/conductor_fotos/<?php echo $nombre_base.".".$extension;?>" width="150" height="180" title="<?php echo $nombre_base.".".$extension;?>" />-->
  
  <img  src="../../../subidos/conductor_fotos/<?php echo $nombre_base."_thumb.".$extension;?>" title="<?php echo $nombre_base."_thumb.".$extension;?>" />
  
  
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
	
}elseif(!empty($_SESSION['SesConFoto'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesConFoto'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesConFoto'.$Identificador], '.'.$extension);  
?>

Vista Previa:<br />
<!--  <img  src="../../../subidos/conductor_fotos/<?php echo $nombre_base."_thumb.".$extension;?>" title="<?php echo $nombre_base."_thumb.".$extension;?>" />-->
  
	<img  src="../../../subidos/conductor_fotos/<?php echo $nombre_base.".".$extension;?>" width="150" height="180" title="<?php echo $nombre_base."_thumb.".$extension;?>" />
<?php	
}else{
?>
No hay FOTO
<?php	
}
?></td>
</tr>
</table>