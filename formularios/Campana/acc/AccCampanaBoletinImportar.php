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

<?php
$Identificador = $_GET['Identificador'];
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
    
    
	<input  name="BtnEnviar" id="BtnEnviar" type="submit" value="Importar Archivo" />

    </td>
</tr>
<tr>
  <td align="left" valign="top">
    <?php
if (!empty($_FILES)) {
	//$file_name = iconv("UTF-8","WINDOWS-1251",$_FILES['CmpArchivo']['name']);
	
	
	$tempFile = $_FILES['CmpArchivo']['tmp_name'];
	$file_name = strtolower($_FILES['CmpArchivo']['name']);	
	$targetPath = '../../../subidos/campana/';


	$targetFile =  str_replace('//','/',$targetPath) . ($file_name);	

	$ext = pathinfo($targetFile, PATHINFO_EXTENSION);
	$file_name = date("d-m-Y")."_BOLETIN_".$Identificador.".".$ext;

	$targetFile =  str_replace('//','/',$targetPath) . $file_name;	

?>
	
    Nombre de Archivo: <b><?php echo $file_name;?></b>. <br />

	<?php
	if (move_uploaded_file($tempFile,$targetFile)){
		$_SESSION['CampanaBoletin'.$Identificador] = $file_name;
	?>

    Se subio correctamente: <b><?php echo $file_name;?></b>.

	<hr /><hr />

    <?php
	} else {
		$_SESSION['CampanaBoletin'.$Identificador] = "";
?>
    Hubo un error al subir el archivo
<?php		
	}
	
}
?>

</td>
</tr>
</table>

	</form>
    
<?php
//name="BtnEnviar"
if(!isset($_POST['BtnEnviar'])){
?>

	<hr />
	Boletin Actual: <b><a target="_blank" href="../../../subidos/campana/<?php echo $_SESSION['CampanaBoletin'.$Identificador];?>"><?php echo $_SESSION['CampanaBoletin'.$Identificador];?></a></b>
    <hr />

<?php
}
?>
  