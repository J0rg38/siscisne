<?php
session_start();
require_once('../proyecto/ClsProyecto.php');
require_once('../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../';
$InsPoo->Ruta = '../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
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

require_once($InsPoo->MtdPaqAcceso().'ClsUsuario.php');

$InsUsuario = new ClsUsuario();
$InsUsuario->UsuId = $_SESSION['SesionId'];
$InsUsuario->UsuUltimaActividad = date("Y-m-d H:i:s");		
$InsUsuario->MtdActualizarUltimaActividadUsuario();

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaSesion" >

<tr>
  <td width="2%"><?php            
if(!empty($_SESSION['SesionFoto'])){
	
	$extension = strtolower(pathinfo($_SESSION['SesionFoto'], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesionFoto'], '.'.$extension);  
?>
    <a href="principal.php?Mod=Usuario&amp;Form=Editar&amp;Id=<?php echo $_SESSION['SesionId'];?>" > <img border="0"  src="subidos/usuario_fotos/<?php echo $nombre_base."_thumb2.".$extension;?>"  /></a>
    <?php	
}
?></td>
<td width="98%">
  <span class="EstTablaSesionEtiqueta">Usuario: </span> 
    
    <a title="Editar mis datos" class="EstSesionUsuarioUsuario" href="principal.php?Mod=Usuario&Form=Editar&Id=<?php echo $_SESSION['SesionId'];?>"><?php echo $_SESSION['SesionNombre'];?>
      [<?php echo $_SESSION['SesionUsuario'];?>]</a>
      
      [<?php echo FncObtenerIp();?>]
      
     <!-- [<?php //echo gethostbyaddr(FncObtenerIp());?><?php //echo php_uname('n');?>]-->
     

      <br />
    
    <span class="EstTablaSesionEtiqueta">Ultima Sesion:</span> <?php echo $_SESSION['SesionUltimaSesion'];?> |
    <span class="EstTablaSesionEtiqueta">Sucursal:</span> <?php echo $_SESSION['SesionSucursalNombre'];?>

</td>
</tr>
</table>