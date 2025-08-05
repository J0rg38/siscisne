<?php
session_start();
//header("Content-type: text/plain");
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

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');

$InsVehiculo = new ClsVehiculo();

$GET_Cbu = FncLimpiarVariable($_GET['Cbu']);

$q = strtolower($_GET["q"]);
$t = empty($_GET['t'])?1:$_GET['t'];
if (!$q) return;

//MtdObtenerVehiculos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VehId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoTipo=NULL,$oEstado=NULL)
$ResVehiculo = $InsVehiculo->MtdObtenerVehiculos($GET_Cbu,"contiene",($q),$GET_Cbu,"DESC",NULL,NULL,NULL,NULL,NULL,NULL);
$ArrVehiculos = $ResVehiculo['Datos'];

	if(empty($ArrVehiculos)){
		
	}else{
		
		if($t==1){
			echo "<b><center>CODIGO</center></b>|".
			"<b><center>MARCA</center></b>|".
			"<b><center>MODELO</center></b>|".
			"<b><center>VERSION</center></b>|".
			"<b><center>TIPO</center></b>|".
			"<b><center>COLOR</center></b>|".
			"<b><center>CODIGO</center></b>|".
			"<b><center>PRECIO</center></b>\n";	
		}
		
		foreach($ArrVehiculos as $DatVehiculo){				
			echo $DatVehiculo->VehId."|".
			$DatVehiculo->VmaNombre."|".
			$DatVehiculo->VmoNombre."|".
			$DatVehiculo->VveNombre."|".
			$DatVehiculo->VtiNombre."|".
			$DatVehiculo->VehColor."|".
			$DatVehiculo->VehCodigoIdentificador."|".
			$DatVehiculo->VehPrecio."\n";		
		}
		
	}
	

?>