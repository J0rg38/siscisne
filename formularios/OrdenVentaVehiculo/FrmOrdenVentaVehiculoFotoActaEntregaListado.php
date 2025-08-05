<?php
session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');

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

$Identificador = $_POST['Identificador'];

$POST_Eliminar = $_POST['Eliminar'];
//deb($Identificador);
//deb($Identificador);
//deb($_SESSION['SesOvvFotoActaEntrega'.$Identificador]);
?>

<?php
if(empty($_SESSION['SesOvvFotoActaEntrega'.$Identificador])){
?>
No se encontro archivo
<?php
}else{
?>
    <table class="EstTablaListado" cellpadding="0" cellspacing="0" border="0">
   
        <tbody class="EstTablaListadoBody">
        <tr>
            <td align="left" valign="top">
            
           <!-- <img src="subidos/orden_venta_vehiculo_fotos/<?php echo $_SESSION['SesOvvFotoActaEntrega'.$Identificador];?>" width="30" height="30" alt="<?php echo $_SESSION['SesOvvFotoActaEntrega'.$Identificador];?>"  border="0"  />-->
        	
            <?php
			$path = $_FILES['image']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			
			if($ext=="pdf"){
			?>
                <a  target="_blank" class="thickbox"  href="subidos/orden_venta_vehiculo_fotos/<?php echo $_SESSION['SesOvvFotoActaEntrega'.$Identificador];?>">
                <img src="imagenes/estado/archivo_pdf.png" title="<?php echo $_SESSION['SesOvvFotoActaEntrega'.$Identificador];?>"  height="45" /></a> 
            <?php	
			}else{
			?>
                <a title="<?php echo $_SESSION['SesOvvFotoActaEntrega'.$Identificador];?>" class="thickbox"  href="subidos/orden_venta_vehiculo_fotos/<?php echo $_SESSION['SesOvvFotoActaEntrega'.$Identificador];?>">
                  <img src="subidos/orden_venta_vehiculo_fotos/<?php echo $_SESSION['SesOvvFotoActaEntrega'.$Identificador];?>" title="<?php echo $_SESSION['SesOvvFotoActaEntrega'.$Identificador];?>"  height="45" /></a> 
            <?php	
			}
			?>
			
              
            <?php
            if($POST_Eliminar==1){
            ?> - 
                <a href="javascript:FncOrdenVentaVehiculoFotoEliminar();" >
                <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
              <?php
            }
            ?>
              
            </td>
        
       
        </tr>
        </tbody>
        
    </table>
    

    
<?php
}
?>
