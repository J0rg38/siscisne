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
//deb($_SESSION['SesPrcArchivo1'.$Identificador]);
?>

<?php
if(empty($_SESSION['SesPrcArchivo1Procesado'.$Identificador])){
?>
No se encontro archivo
<?php
}else{
?>
    <table class="EstTablaListado" cellpadding="0" cellspacing="0" border="0">
   
        <tbody class="EstTablaListadoBody">
        <tr>
            <td align="left" valign="top">
            

			
          
			<!--<?php echo $_SESSION['SesPrcArchivo1Procesado'.$Identificador];?> 
            -->
            
              <a target="_blank" href="generados/procesadores/<?php echo $_SESSION['SesPrcArchivo1Procesado'.$Identificador];?>">
			
            
            Descargar Archivo Procesado
            
            </a> 
              
           
              
            </td>
        
       
        </tr>
        </tbody>
        
    </table>
    

    
<?php
}
?>
