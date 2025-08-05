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

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');




$Identificador = $_POST['Identificador'];
$VehiculoIngresoId = $_POST['VehiculoIngresoId'];

unset($_SESSION['InsPreEntregaCliente'.$Identificador]);
	
session_start();
$_SESSION['InsPreEntregaCliente'.$Identificador] = new ClsSesionObjeto();	



//deb($Identificador);

//session_start();

//if (!isset($_SESSION['InsPreEntregaCliente'.$ModalidadIngreso.$Identificador])){
//	$_SESSION['InsPreEntregaCliente'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
//}

$Mensaje = "";	

//deb($VehiculoIngresoId);

if(!empty($VehiculoIngresoId )){
	
	$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
	//MtdObtenerOrdenVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oCliente=NULL,$oConCotizacion=0,$oFacturable=NULL,$oCotizacionVehiculo=NULL,$oVehiculoIngreso=NULL,$oSucursal=NULL,$oAprobacion1=NULL,$oAprobacion2=NULL,$oAprobacion3=NULL,$oTieneActaFechaEntrega=0,$oTieneComprobante=false,$oFechaTipo="OvvFecha")
	$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculos(NULL,NULL,NULL,"OvvFecha","ASC","",NULL,NULL,$POST_estado,NULL,NULL,NULL,0,NULL,NULL,$VehiculoIngresoId,NULL,NULL,NULL,NULL,NULL);
	$ArrOrdenVentaVehiculos = $ResOrdenVentaVehiculo['Datos'];
	
//	deb($ArrOrdenVentaVehiculos);
	
	$OrdenVentaVehiculoId = "";
	
	if(!empty($ArrOrdenVentaVehiculos)){
		foreach($ArrOrdenVentaVehiculos as $DatOrdenVentaVehiculo){
		
			if($DatOrdenVentaVehiculo->OvvEstado <> 6 and $DatOrdenVentaVehiculo->OvvEstdo<>1){
					$OrdenVentaVehiculoId = $DatOrdenVentaVehiculo->OvvId;
			}
		
		}
	}
	
	if(!empty($OrdenVentaVehiculoId )){
		
		$InsOrdenVentaVehiculo->OvvId = $OrdenVentaVehiculoId ;
		$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();
		
	
		if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario)){
			
			foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
			
				
				//
	//			SesionObjeto-PreEntregaCliente
	//			Parametro1 = 
	//			Parametro2 = CliId
	//			Parametro3 = CliNombre
	//			Parametro4 = CliNumeroDocumento
	//			Parametro5 = CliApellidoPaterno
	//			Parametro6 = CliApellidoMaterno
	//			Parametro7 = 
	//			Parametro8 = 
	//			
	
				$_SESSION['InsPreEntregaCliente'.$Identificador]->MtdAgregarSesionObjeto(1,
				NULL,
				$DatOrdenVentaVehiculoPropietario->CliId,
				$DatOrdenVentaVehiculoPropietario->CliNombre,
				$DatOrdenVentaVehiculoPropietario->CliNumeroDocumento,
				$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno,
				$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno
				);
			   
			   
				
			}
			
		}else{
				$Mensaje = "No se encontraron propietarios";	
		}
		
		
	}else{
		
		$Mensaje = "No se encontro orden de venta de vehiculo";
		
	}
	
	
	//$InsVehiculoIngresoCliente = new ClsVehiculoIngresoCliente();
//	$ResVehiculoIngresoCliente =  $InsVehiculoIngresoCliente->MtdObtenerVehiculoIngresoClientes(NULL,NULL,"VicId","ASC",NULL,$VehiculoIngresoId );
//	$ArrVehiculoIngresoClientes = $ResVehiculoIngresoCliente['Datos'];
//	

/*	if(!empty($ArrVehiculoIngresoClientes)){
    	foreach($ArrVehiculoIngresoClientes as $DatVehiculoIngresoCliente){

			//
//			SesionObjeto-PreEntregaCliente
//			Parametro1 = 
//			Parametro2 = CliId
//			Parametro3 = CliNombre
//			Parametro4 = CliNumeroDocumento
//			Parametro5 = CliApellidoPaterno
//			Parametro6 = CliApellidoMaterno
//			Parametro7 = 
//			Parametro8 = 
//			

			$_SESSION['InsPreEntregaCliente'.$Identificador]->MtdAgregarSesionObjeto(1,
			NULL,
			$DatVehiculoIngresoCliente->CliId,
			$DatVehiculoIngresoCliente->CliNombre,
			$DatVehiculoIngresoCliente->CliNumeroDocumento,
			$DatVehiculoIngresoCliente->CliApellidoPaterno,
			$DatVehiculoIngresoCliente->CliApellidoMaterno
			);
           
		}
	}*/
 
 
}else{
	
	$Mensaje = "No se identifico el vehiculo";
	
}


$Respuesta['Mensaje'] = $Mensaje;
	
echo json_encode($Respuesta);

?>




