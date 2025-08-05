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


//CLASES
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');


$InsVehiculoIngreso = new ClsVehiculoIngreso();

$POST_Accion = $_POST['Accion'];

$POST_Filtro = $_POST['Filtro'];
$POST_Campo = $_POST['Campo'];

$POST_VehiculoIngresoVIN = $_POST['VehiculoIngresoVIN'];
$POST_VehiculoIngresoPlaca = $_POST['VehiculoIngresoPlaca'];
$POST_VehiculoMarcaId = $_POST['VehiculoMarcaId'];

switch($POST_Accion){

	case "ConsultaVehicular":
		MtdConsultaVehicular();
	break;
	
	case "ObtenerVehiculoMarcas":
		MtdObtenerVehiculoMarcas();
	break;
	
	case "ObtenerVehiculoModelos":
		MtdObtenerVehiculoModelos();
	break;
	
	

}	
	
function MtdConsultaVehicular(){
	
	global $POST_Accion;
	
	global $POST_Campo;
	global $POST_Filtro;
	
	global $POST_VehiculoIngresoVIN;
	global $POST_VehiculoIngresoPlaca;

	global $InsVehiculo;

	global $Resultado;

	$Resultado = '';
	$JsResultado = array();
	


	$JsResultado['Respuesta'] = '';	
	
	$JsResultado['EinId'] = '';	
	$JsResultado['EinVIN'] = '';		
	$JsResultado['EinPlaca']= '';	
	$JsResultado['EinNumeroMotor'] = '';	
	$JsResultado['EinColor'] = '';	
	$JsResultado['EinAnoFabricacion'] = '';	
	$JsResultado['EinAnoModelo']= '';	
	
	$JsResultado['EinPropietarios']= '';	
	
	$JsResultado['VmaNombre'] = '';	
	$JsResultado['VmoNombre'] = '';	
	$JsResultado['VveNombre'] = '';	
	
	//deb($POST_Campo);
	//deb($POST_Filtro);
	
	if(!empty($POST_Campo) and !empty($POST_Filtro) ){
		
		switch($POST_Campo){
			case "VIN":
				$Campo = "EinVIN";
			break;
			
			case "Placa":
				$Campo = "EinPlaca";
			break;
			
		}
		$InsVehiculoIngreso = new ClsVehiculoIngreso();	
		$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos($Campo,"contiene",$POST_Filtro,"EinTiempoCreacion","DESC","1","",NULL,NULL,NULL,$POST_VehiculoMarcaId,$POST_VehiculoModeloId,$POST_VehiculoVersionId,NULL,NULL,NULL,NULL);
		$ArrVehiculoIngresos = $ResVehiculoIngreso['Datos'];

		if(!empty($ArrVehiculoIngresos)){
			
			foreach($ArrVehiculoIngresos as $DatVehiculoIngreso){
				
				$JsResultado['EinId'] = $DatVehiculoIngreso->EinId;	
				$JsResultado['EinVIN'] = $DatVehiculoIngreso->EinVIN;	
				$JsResultado['EinPlaca'] = $DatVehiculoIngreso->EinPlaca;	
				$JsResultado['EinNumeroMotor'] = $DatVehiculoIngreso->EinNumeroMotor;	
				$JsResultado['EinColor'] = $DatVehiculoIngreso->EinColor;
				$JsResultado['EinAnoFabricacion'] = $DatVehiculoIngreso->EinAnoFabricacion;
				$JsResultado['EinAnoModelo'] = $DatVehiculoIngreso->EinAnoModelo;	
				
				$JsResultado['VmaNombre'] = $DatVehiculoIngreso->VmaNombre;	
				$JsResultado['VmoNombre'] = $DatVehiculoIngreso->VmoNombre;	
				$JsResultado['VveNombre'] = $DatVehiculoIngreso->VveNombre;	
				
				$InsVehiculoIngresoCliente = new ClsVehiculoIngresoCliente();
				//MtdObtenerVehiculoIngresoClientes($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VicId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoIngreso=NULL,$oCliente=NULL)
				$ResVehiculoIngresoCliente =  $InsVehiculoIngresoCliente->MtdObtenerVehiculoIngresoClientes(NULL,NULL,"VicId","ASC",NULL,$DatVehiculoIngreso->EinId);
				$ArrVehiculoIngresoClientes = $ResVehiculoIngresoCliente['Datos'];
				
				$Propietarios = "";
				
				if(!empty($ArrVehiculoIngresoClientes)){
					foreach($ArrVehiculoIngresoClientes as $DatVehiculoIngresoCliente){
						$Propietarios .= " / ".$DatVehiculoIngresoCliente->CliNombre." ".$DatVehiculoIngresoCliente->CliApellidoPaterno." ".$DatVehiculoIngresoCliente->CliApellidoMaterno;		
					}
				}
				
				$JsResultado['EinPropietarios'] = $Propietarios;	
				
			}
			
			$JsResultado['Respuesta'] = 'V001';	
		}else{
			
			
			
			$JsResultado['Respuesta'] = 'V002';	
		}
		
	}else{
		
		$JsResultado['Respuesta'] = 'V003';	
			
	}
	
	$Resultado = json_encode($JsResultado);
}



function MtdObtenerVehiculoMarcas(){
	
	global $POST_Accion;
	
	global $InsVehiculoMarca;

	global $Resultado;

	$Resultado = '';
	$JsResultado = array();
	

	$JsResultado['Respuesta'] = '';	
	$JsResultado['Datos'] = array();	
	
	$InsVehiculoMarca = new ClsVehiculoMarca();
	$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
	$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

	if(!empty($ArrVehiculoMarcas)){
		
		foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
	
			$VehiculoMarca['VmaId'] = (empty($DatVehiculoMarca->VmaId)?'':$DatVehiculoMarca->VmaId);			
			$VehiculoMarca['VmaNombre'] = (empty($DatVehiculoMarca->VmaNombre)?'':$DatVehiculoMarca->VmaNombre);		
			
			$JsResultado['Datos'][] = $VehiculoMarca;
	
		}
		
		$JsResultado['Respuesta'] = 'V004';	
	}else{
		$JsResultado['Respuesta'] = 'V005';	
	}
		

	$Resultado = json_encode($JsResultado);
}


function MtdObtenerVehiculoModelos(){
	
	global $POST_Accion;
	
	global $POST_VehiculoMarcaId;
	
	global $InsVehiculoMarca;

	global $Resultado;

	$Resultado = '';
	$JsResultado = array();
	

	$JsResultado['Respuesta'] = '';	
	$JsResultado['Datos'] = array();	
	
	$InsVehiculoModelo = new ClsVehiculoModelo();
	$RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,"VmoNombre","ASC",NULL,$POST_VehiculoMarcaId);
	$ArrVehiculoModelos = $RepVehiculoModelo['Datos'];

	if(!empty($ArrVehiculoModelos)){
		
		foreach($ArrVehiculoModelos as $DatVehiculoModelo){
	
			$VehiculoModelo['VmoId'] = (empty($DatVehiculoModelo->VmoId)?'':$DatVehiculoModelo->VmoId);			
			$VehiculoModelo['VmoNombre'] = (empty($DatVehiculoModelo->VmoNombre)?'':$DatVehiculoModelo->VmoNombre);		
			
			$JsResultado['Datos'][] = $VehiculoModelo;
	
		}
		
		$JsResultado['Respuesta'] = 'V006';	
	}else{
		$JsResultado['Respuesta'] = 'V007';	
	}
		

	$Resultado = json_encode($JsResultado);
}


echo ($Resultado);
?>