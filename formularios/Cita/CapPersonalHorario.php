<?php
session_start();
////PRINCIPALES
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

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



$POST_FechaProgramada = $_POST['FechaProgramada'];
$POST_HoraProgramada = $_POST['HoraProgramada'];
$POST_PersonalMecanico = $_POST['PersonalMecanico'];


//CLASES
require_once($InsPoo->MtdPaqActividad().'ClsCita.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');


//INSTANCIAS
$InsPersonal = new ClsPersonal();
$InsCita = new ClsCita();

//$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,'PmaId','ASC',1,NULL,$POST_VehiculoVersion,$POST_VehiculoModelo) ;
$ResCita = $InsCita->MtdObtenerCitas(NULL,NULL,NULL,"CitHoraProgramada","ASC",NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_FechaProgramada),(FncCambiaFechaAMysql($POST_FechaProgramada)),"CitTiempoCreacion",false,NULL,$POST_PersonalMecanico);
$ArrCitas = $ResCita['Datos'];


if(!empty($ArrCitas)){
?>
<table width="100%">
    <thead>
        <th>
        Hora
        </th>
    </thead>
    <tbody>
        <?php
        foreach($ArrCitas as $DatCita){
    ?>
    	<tr>
        	<td>
            <?php echo $DatCita->CitHoraProgramada;?>
            </td>
		</tr>
    <?php	
        }
        ?>
    </tbody>
</table>
<?php	
}
?>

       
           


            
            
            





</body>
</html>