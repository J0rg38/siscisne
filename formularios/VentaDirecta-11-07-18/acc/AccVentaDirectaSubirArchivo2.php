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
  <td align="left" valign="top"> <form method="post" enctype="multipart/form-data">
    <input type="file" id="CmpArchivoFoto" name="CmpArchivoFoto" />
    <input type="submit" value="Subir Foto" />
  
  </form></td>
  <td align="left" valign="top">
  
  
 


<?php
	if($POST_Borrar=="1"){
	?>
    <?php $_SESSION['SesVdiArchivoEntrega'.$Identificador] = ""; ?>
    <?php	
	}
?>
    <form method="post" enctype="multipart/form-data">
<input type="hidden" name="CmpBorrar" id="CmpBorrar" value="1" />
    <input type="submit" value="Borrar Foto" />
  
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
	
	$targetPath = '../../../subidos/venta_directa/';
	$targetFile =  str_replace('//','/',$targetPath) . ($file_name);	
	
	$extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
	$nombre_base = basename($file_name, '.'.$extension);  
	

	if($extension=="jpg" || $extension == "png" || $extension == "gif" || $extension == "jpeg" || $extension == "pdf" ){
		if (move_uploaded_file($tempFile,$targetFile)){
			
			$_SESSION['SesVdiArchivoEntrega'.$Identificador] = $file_name;
			
?>
    
    
    Archivo Adjunto:<br />
    
 
    
    	<?php
	if($extension <> "pdf"){
	?>
         <a target="_blank" href="../../../subidos/venta_directa/<?php echo $nombre_base.".".$extension;?>">
        <img  src="../../../subidos/venta_directa/<?php echo $nombre_base.".".$extension;?>" width="97" height="107" border="0" title="<?php echo $nombre_base.".".$extension;?>" />
        </a>   
    <?php
	}else{
	?>
		 <a target="_blank" href="../../../subidos/venta_directa/<?php echo $nombre_base.".".$extension;?>"><?php echo $nombre_base.".".$extension;?></a>
    
    <?php	
	}
	?>
    
    
    
  <?php
		} else {
?>
    Hubo un error al subir el ARCHIVO ADJUNTO
    <?php		
		}
	}else{
?>
    Solo se permiten ARCHIVOS de imagen con extension: pdf, jpg, jpeg, png y gif.
    <?php
	}
	
}elseif(!empty($_SESSION['SesVdiArchivoEntrega'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesVdiArchivoEntrega'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesVdiArchivoEntrega'.$Identificador], '.'.$extension);  
?>
    
    Archivo Adjunto:<br />
    
   
    
    
    	<?php
	if($extension <> "pdf"){
	?>
          <a target="_blank" href="../../../subidos/venta_directa/<?php echo $nombre_base.".".$extension;?>">
        <img  src="../../../subidos/venta_directa/<?php echo $nombre_base.".".$extension;?>" width="97" height="107" border="0" title="<?php echo $nombre_base.".".$extension;?>" />
        </a>   
    <?php
	}else{
	?>
		  <a target="_blank" href="../../../subidos/venta_directa/<?php echo $nombre_base.".".$extension;?>"><?php echo $nombre_base.".".$extension;?></a>
   
    <?php	
	}
	?>
    
    
    
  <?php	
}else{
?>
    No hay ARCHIVO ADJUNTO
  <?php	
}
?></td>
</tr>
</table>