<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

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



require_once($InsProyecto->MtdRutLibrerias().'class.random.php');


require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');

$random = new Random();
$Identificador = $random->random_text(10, false, false, true);

$InsFichaIngreso = new ClsFichaIngreso();
//MtdObtenerFichaIngresos( $oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oCliente=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oTipo=NULL,$oSalidaExterna=0,$oConCampana=NULL,$oVehiculoIngreso=NULL,$oConConcluido=0,$oTipoReparacion=NULL,$oPersonalIdAsesor=NULL,$oVehiculoMarca=NULL,$oCodigoOriginal=NULL,$oSucursal=NULL,$oMigrado=true)
$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos(NULL,NULL,NULL,"FinTiempoCreacion","ASC",NULL,(date("Y")."-01-01"),(date("Y-m-d")),"4,5,6,7",NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,0,NULL,NULL,1,NULL,NULL,NULL,NULL,$_SESSION['SesionSucursal'],true);
$ArrFichaIngresos = $ResFichaIngreso['Datos'];
$FichaIngresosTotal = $ResFichaIngreso['Total'];

if($FichaIngresosTotal>0){
	
	echo "Hay (".$FichaIngresosTotal.") Orden(es) de Trabajo pendiente(s) por atender: <br><br>";
	
	foreach($ArrFichaIngresos as $DatFichaIngreso){
		
		echo "- OT: <a target='_blank' href='principal.php?Mod=TallerPedido&Form=Registrar&FinId=".$DatFichaIngreso->FinId."'>".$DatFichaIngreso->FinId."</a><br>";	
		
	}

	echo "<small>".$Identificador."</small>";

}else{
	echo "";	
}



?>