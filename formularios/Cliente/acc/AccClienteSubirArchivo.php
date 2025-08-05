<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';
$Identificador = $_GET['Identificador'];
?>

<?php require_once($InsProyecto->MtdRutLibrerias().'class.thumb.php');?>
<?php require_once($InsProyecto->MtdRutLibrerias().'class.random.php');?>

<?php
$random = new Random();
$FotoIdentificador = $random->random_text(10, false, false, true);
?>

<?php
$POST_Borrar = $_POST['CmpBorrar'];
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td width="91%" align="left" valign="top">
  
  
  <form method="post" enctype="multipart/form-data">
    <input type="file" id="CmpArchivoFoto" name="CmpArchivoFoto" />
    <input type="submit" value="Subir Foto" />
  
  </form>


<?php
	if($POST_Borrar=="1"){
	?>
    <?php $_SESSION['SesCliArchivo'.$Identificador] = ""; ?>
    <?php	
	}
?>
    
  </td>
  <td width="9%" align="left" valign="top"><form method="post" enctype="multipart/form-data">
<input type="hidden" name="CmpBorrar" id="CmpBorrar" value="1" />
    <input type="submit" value="Borrar Foto" />
  
  </form></td>
  </tr>
<tr>
<td colspan="2" align="left" valign="top">
  <?php
if (!empty($_FILES)) {
	$tempFile = $_FILES['CmpArchivoFoto']['tmp_name'];
	$file_name = strtolower($_FILES['CmpArchivoFoto']['name']);	
	
	$file_name = $FotoIdentificador.$file_name;
	
	$targetPath = '../../../subidos/cliente_fotos/';
	$targetFile =  str_replace('//','/',$targetPath) . ($file_name);	
	
	$extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
	$nombre_base = basename($file_name, '.'.$extension);  
	

	if($extension=="jpg" || $extension == "png" || $extension == "gif" || $extension == "jpeg" || $extension == "pdf" ){
		if (move_uploaded_file($tempFile,$targetFile)){
			
			 $_SESSION['SesCliArchivo'.$Identificador] = $file_name;
			
?>

Archivo Adjunto:<br />


  <a target="_blank" href="../../../subidos/cliente_fotos/<?php echo $nombre_base.".".$extension;?>">
		<img  src="../../../subidos/cliente_fotos/<?php echo $nombre_base.".".$extension;?>" width="300" height="177" border="0" title="<?php echo $nombre_base.".".$extension;?>" />
  </a>
  
  
<?php
		} else {
?>
  Hubo un error al subir la FOTO
  <?php		
		}
	}else{
?>
  Solo se permiten FOTOS de imagen con extension: pdf, jpg, jpeg, png y gif.
  <?php
	}
	
}elseif(!empty($_SESSION['SesCliArchivo'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesCliArchivo'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesCliArchivo'.$Identificador], '.'.$extension);  
?>

Archivo Adjunto:<br />

  <a target="_blank" href="../../../subidos/cliente_fotos/<?php echo $nombre_base.".".$extension;?>">
		<img  src="../../../subidos/cliente_fotos/<?php echo $nombre_base.".".$extension;?>" width="300" height="177" border="0" title="<?php echo $nombre_base.".".$extension;?>" />
  </a>
  
<!--<a target="_blank" href="../../../subidos/cliente_fotos/<?php echo $nombre_base.".".$extension;?>"><?php echo $nombre_base.".".$extension;?></a>
-->


<?php	
}else{
?>
No hay FOTO
<?php	
}
?></td>
</tr>
</table>