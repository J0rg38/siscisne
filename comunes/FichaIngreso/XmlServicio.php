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

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');

$InsFichaIngreso = new ClsFichaIngreso();

$q = strtolower($_GET["q"]);
if (!$q) return;

// MtdObtenerFichaIngresos( $oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oTipo=NULL,$oSalidaExterna=NULL)
$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos("fin.FinId","contiene",$q,"FinId","ASC",NULL,NULL,NULL,NULL);

	$ArrFichaIngresos = $ResFichaIngreso['Datos'];
	$FichaIngresosTotal = $ResFichaIngreso['Total'];
		
	if(empty($ArrFichaIngresos)){
		
	}else{
		foreach($ArrFichaIngresos as $DatFichaIngreso){			
			echo $DatFichaIngreso->FinId."|".
			$DatFichaIngreso->FinFecha."|".
			$DatFichaIngreso->FinKilometraje."|".
			$DatFichaIngreso->FinConductor."|".
			$DatFichaIngreso->CliNombre."|".
			$DatFichaIngreso->EinVIN."|".
			"\n";	
		}
	}

?>