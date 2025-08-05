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

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');

$InsVehiculoIngreso = new ClsVehiculoIngreso();

$GET_Campo = empty($_GET['Campo'])?"EinVIN":$_GET['Campo'];

$q = strtolower($_GET["q"]);
if (!$q) return;

//MtdObtenerVehiculoIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oCliente=NULL)
$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos($GET_Campo,"contiene",$q,$GET_Campo,"ASC",NULL,"1",NULL,NULL);
	
	$ArrVehiculoIngresos = $ResVehiculoIngreso['Datos'];
	$VehiculoIngresosTotal = $ResVehiculoIngreso['Total'];
		
	if(empty($ArrVehiculoIngresos)){
		
	}else{
		foreach($ArrVehiculoIngresos as $DatVehiculoIngreso){			
			echo $DatVehiculoIngreso->EinVIN."|";
			echo $DatVehiculoIngreso->EinId."|";
			echo $DatVehiculoIngreso->EinPlaca."|";
		  	echo $DatVehiculoIngreso->EinMarca."|";
			echo $DatVehiculoIngreso->EinModelo."|";
			echo $DatVehiculoIngreso->EinColor."|";
			echo $DatVehiculoIngreso->EinAnoFabricacion."|";			
			echo $SucursalStock."|";			
			echo $DatVehiculoIngreso->VmaId."|";						
			echo $DatVehiculoIngreso->VmoId."|";						
			echo $DatVehiculoIngreso->VtiId."\n";
		}
	}

?>