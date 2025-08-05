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

$POST_Borrar = $_POST['CmpBorrar'];
?>


<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td width="88%" align="left" valign="top"><form method="post" enctype="multipart/form-data">
    <input type="file" id="CmpArchivoFoto" name="CmpArchivoFoto" />
    <input type="submit" value="Subir Foto" />
  </form></td>
  <td width="12%" align="left" valign="top">
  
  <?php
	if($POST_Borrar=="1"){
	?>
    <?php $_SESSION['SesPagFoto1'.$Identificador] = ""; ?>
    <?php	
	}
?>
    <form method="post" enctype="multipart/form-data">
<input type="hidden" name="CmpBorrar" id="CmpBorrar" value="1" />
    <input type="submit" value="Borrar Archivo" />
  
  </form>
  
  </td>
  </tr>
<tr>
<td colspan="2" align="left" valign="top">
  <?php
if (!empty($_FILES)) {
	$tempFile = $_FILES['CmpArchivoFoto']['tmp_name'];
	$file_name = strtolower($_FILES['CmpArchivoFoto']['name']);	
	
	$file_name = $FotoIdentificador.$file_name;
	
	$targetPath = '../../../subidos/pago_fotos/';
	$targetFile =  str_replace('//','/',$targetPath) . ($file_name);	
	
	$extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
	$nombre_base = basename($file_name, '.'.$extension);  
	
	if($extension=="jpg" || $extension == "png" || $extension == "gif" || $extension == "jpeg"){
		if (move_uploaded_file($tempFile,$targetFile)){
			
			$_SESSION['SesPagFoto1'.$Identificador] = $file_name;
			
			$mythumb = new thumb();
			$mythumb->loadImage('../../../subidos/pago_fotos/'.$file_name);
			$mythumb->crop(250, 250,'bottom');
			$mythumb->save('../../../subidos/pago_fotos/'.$nombre_base.'_thumb.'.$extension, 100);
			
?>
Vista Previa:<br />

  <a target="_blank" href="../../../subidos/pago_fotos/<?php echo $nombre_base.".".$extension;?>">
		<img  src="../../../subidos/pago_fotos/<?php echo $nombre_base.".".$extension;?>" width="198" height="255" border="0" title="<?php echo $nombre_base.".".$extension;?>" />
  </a>
 
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
	
}elseif(!empty($_SESSION['SesPagFoto1'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesPagFoto1'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesPagFoto1'.$Identificador], '.'.$extension);  
?>

Vista Previa:<br />

  <a target="_blank" href="../../../subidos/pago_fotos/<?php echo $nombre_base.".".$extension;?>">
	<img  src="../../../subidos/pago_fotos/<?php echo $nombre_base.".".$extension;?>" width="195" height="267" border="0" title="<?php echo $nombre_base."_thumb.".$extension;?>" /></a>
    

<?php	
}else{
?>
No hay FOTO
<?php	
}
?></td>
</tr>
</table>