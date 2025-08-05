<?php
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


$Identificador = $_POST['Identificador'];
$ModalidadIngreso = $_POST['ModalidadIngreso'];

session_start();
if (!isset($_SESSION['InsFichaIngresoSuministro'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaIngresoSuministro'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();
}



require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');

$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

$InsUnidadMedida->UmeId = $_POST['SuministroUnidadMedidaConvertir'];
$InsUnidadMedida->MtdObtenerUnidadMedida();

$InsProducto->ProId = $_POST['SuministroId'];
$InsProducto->MtdObtenerProducto(false);

$VerificarStock = 1;



if(!empty($InsProducto->ProId)){
	
	if(!empty($InsUnidadMedida->UmeId)){

			
			
			if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
				$InsUnidadMedidaConversion->UmcEquivalente = 1;	
			}else{
				$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
				$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
				
				foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
					$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
				}	
			}
			
			if(!empty($InsUnidadMedidaConversion->UmcEquivalente)){
				
				$Cantidad = round($_POST['SuministroCantidad'],3);
				$Importe = round($_POST['SuministroImporte'],2);
				$Precio = round(($Importe/$Cantidad),2);		
				$CantidadReal = round($Cantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
					
				//SesionObjeto-FichaIngresoSuministro
				//Parametro1 = FapId
				//Parametro2 = ProId
				//Parametro3 = ProNombre
				//Parametro4 = 
				//Parametro5 = 
				//Parametro6 = UmeId
				//Parametro7 = FapTiempoCreacion
				//Parametro8 = FapTiempoModificacion
				//Parametro9 = FapCantidad
				//Parametro10 = FapCantidadReal	
				//Parametro11 = RtiId
				//Parametro12 = UmeNombre
				//Parametro13 = UmeIdOrigen
				//Parametro14 = FapEstado
				
				$InsFichaIngresoSuministro1 = array();
				$InsFichaIngresoSuministro1 = $_SESSION['InsFichaIngresoSuministro'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);
				
				
				$_SESSION['InsFichaIngresoSuministro'.$ModalidadIngreso.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
				$InsFichaIngresoSuministro1->Parametro1,
				$_POST['SuministroId'],
				(stripslashes($_POST['SuministroNombre'])),
				NULL,
				NULL,
				$InsUnidadMedida->UmeId,
				$InsFichaIngresoSuministro1->Parametro7,
				date("d/m/Y H:i:s"),
				$Cantidad,
				$CantidadReal,
				$InsFichaIngresoSuministro1->Parametro11,
				$InsUnidadMedida->UmeNombre,
				$InsFichaIngresoSuministro1->Parametro13,
				$InsFichaIngresoSuministro1->Parametro14
				);
				
			
			
			}else{
				echo "No se encontro la UNIDAD DE MEDIDA equivalente, revise la tabla de CONVERSIONES, y si esta correctamente llenado en el PADRON de PRODUCTOS.";	
			}
			
	
	}else{
		echo "No ingreso una UNIDAD DE MEDIDA.";	
	}

	
}else{
	echo "No se identifico el SUMINISTRO";
}




?>