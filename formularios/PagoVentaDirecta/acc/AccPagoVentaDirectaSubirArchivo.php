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
require_once($InsProyecto->MtdRutMensajes() . 'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases() . 'ClsSesion.php');
require_once($InsProyecto->MtdRutClases() . 'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases() . 'ClsMensaje.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones() . 'ClsConexion.php');
require_once($InsProyecto->MtdRutClases() . 'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones() . 'FncGeneral.php');

 $Identificador = $_GET['Identificador'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Subir archivos</title>

<!--
Estilos
-->
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssPrincipal.css">
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssGeneral.css">
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<?php require_once($InsProyecto->MtdRutLibrerias().'class.thumb.php');?>
<?php require_once($InsProyecto->MtdRutLibrerias().'class.random.php');?>



<?php
$random = new Random();
$FotoIdentificador = $random->random_text(10, false, false, true);

$POST_Borrar = $_POST['CmpBorrar'];

?>


</head>
<body>
<?php
if($POST_Borrar=="1"){
?>
<?php $_SESSION['SesPagFoto1'.$Identificador] = ""; ?>
<?php	
}
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td width="13%" align="left" valign="middle"><form method="post" enctype="multipart/form-data">
    <input type="hidden" name="CmpBorrar" id="CmpBorrar" value="1" />
    <input type="submit" value="Borrar Archivo" class="EstFormularioBoton" />
  </form></td>
  <td width="73%" align="left" valign="middle">
    
    
    
    <form method="post" enctype="multipart/form-data">
    <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td valign="middle">&nbsp;</td>
    <td valign="middle">
      <input class="EstFormularioBoton" type="submit" value="Subir Archivo" />
</td>
<td valign="middle">      
      <input name="CmpArchivoFoto" type="file" class="EstFormularioUpload" id="CmpArchivoFoto" size="10" maxlength="10" />
     </td>
     </tr>
     </table> 
      
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
      <img  src="../../../subidos/pago_fotos/<?php echo $nombre_base.".".$extension;?>" width="100" border="0" title="<?php echo $nombre_base.".".$extension;?>" />
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
      <img  src="../../../subidos/pago_fotos/<?php echo $nombre_base.".".$extension;?>" width="100" border="0" title="<?php echo $nombre_base."_thumb.".$extension;?>" /></a>
    
    
  <?php	
}else{
?>
    No hay FOTO
  <?php	
}
?></td>
</tr>
</table>
</body>
</html>

