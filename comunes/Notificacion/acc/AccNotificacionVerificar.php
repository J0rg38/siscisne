<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsPoo->Ruta = "../../../";
$InsProyecto->Ruta = "../../../";

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


?>

<?php
$GET_Usuario = $_GET['Usuario'];
$GET_FechaInicio = isset($_POST['FechaInicio'])?$_POST['FechaInicio']:"01/".date("m/Y");
$GET_FechaFin = isset($_POST['FechaFin'])?$_POST['FechaFin']:date("d/m/Y");

require_once($InsPoo->MtdPaqActividad().'ClsNotificacion.php');

$InsNotificacion = new ClsNotificacion();
//MtdObtenerNotificacions($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NfnId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oUsuario=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL) 
$ResNotificacion = $InsNotificacion->MtdObtenerNotificacions(NULL,NULL,NULL,'NfnId','DESC','','1',$GET_Usuario,FncCambiaFechaAMysql($GET_FechaInicio),FncCambiaFechaAMysql($GET_FechaFin)) ;
$ArrNotificaciones = $ResNotificacion['Datos'];

echo json_encode($ArrNotificaciones);

//
//$notificacion = "";
//if(!empty($ArrNotificaciones)){
//	foreach($ArrNotificaciones as $DatNotificacion){
//			
//		//$InsNotificacion->MtdActualizarEstadoNotificacion($DatNotificacion->NfnId,"1",false);
//		$notificacion .= '<div class="EstNotificacion">';
//		$notificacion .= '<div class="EstNotificacionBody">';
//						
//			$notificacion .= '<div class="EstNotificacionFila">';
//			
//				$notificacion .= '<div class="EstNotificacionIcono">';
//				$notificacion .= '<img src="imagenes/mensajes/aviso.png" width="25" height="25" alt="Aviso" title="Aviso" align="absmiddle">';	
//				$notificacion .= '</div>';
//		
//				$notificacion .= '<div class="EstNotificacionContenido">';
//				$notificacion .= $DatNotificacion->NfnDescripcion;
//				$notificacion .= '</div>';
//				
//			$notificacion .= '</div>';
//			
//			$notificacion .= '<div class="EstNotificacionFila">';
//				
//				$notificacion .= '<div class="EstNotificacionBotones">';		
//				$notificacion .= '</div>';
//				
//				$notificacion .= '<div class="EstNotificacionBotones">';		
//				$notificacion .= '<a href="'.$DatNotificacion->NfnEnlace.'&NfnId='.$DatNotificacion->NfnId.'">Mostrar</a>';				
//				//$notificacion .= '<a href="'.$DatNotificacion->NfnEnlace.'">Cerrar</a>';
//				$notificacion .= '</div>';
//			
//			$notificacion .= '</div>';
//			
//		$notificacion .= '</div>';			
//		$notificacion .= '</div>';
//
//	}	
//}

echo $notificacion;
?>