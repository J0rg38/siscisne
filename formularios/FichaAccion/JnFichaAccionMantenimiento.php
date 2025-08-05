<?php
//header('Content-type: text/json');
//header('Content-type: application/json');

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

require_once($InsProyecto->MtdRutLibrerias().'JSON.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');

//require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');

$POST_PlanMantenimientoTareaId = $_POST['PlanMantenimientoTareaId'];



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

$ArrProductosPredeterminados = array(

	array("ACEITE MOBIL SUPER 1000","PMT-10000","UME-10002"),//Filtro de aceite
	array("FILTRO DE ACEITE","PMT-10001","UME-10007"),//Filtro de aceite
	array("FILTRO DE AIRE","PMT-10002","UME-10007"),//Filtro de aire del motor
	array("BUJIA","PMT-10003","UME-10007"),//Bujias

	array("FAJA DE DISTRIBUCION","PMT-10005","UME-10007"),//	Fajas y correas accesorias
	array("FILTRO DE COMBUSTIBLE","PMT-10039","UME-10007"),//	Filtro de combustible integrado a la bomba
	array("CADENA DE DISTRIBUCION","PMT-10040","UME-10007"),//	Cadena de distribución
	array("EMPAQUE CARTER","PMT-10057","UME-10007"),//	Empaque de tapón de cárter
	array("ACEITE MOBIL SUPER 1000","PMT-10009","UME-10002"),//	Aceite de caja de transmisión mecánica

	array("DISCO DE FRENO","PMT-10058","UME-10007"),//	Estado de frenos de disco
	array("TAMBOR DE FRENO","PMT-10059","UME-10007"),// Estado de frenos de tambor

	array("AMORTIGUADOR DELANTERO LH","PMT-10060","UME-10007"),// Suspensión delantera / amortiguador RH
	array("AMORTIGUADOR DELANTERO RH","PMT-10061","UME-10007"),// Suspensión delantera / amortiguador LH
	array("AMORTIGUADOR POSTERIOR","PMT-10062","UME-10007"),// Suspensión posterior / amortiguador RH y LH
	array("ROTULA DE SUSPENSIÓN RH","PMT-10063","UME-10007"),// Suspensión delantera / rotula RH
	array("ROTULA DE SUSPENSIÓN LH","PMT-10064","UME-10007")//  Suspensión delantera / rotula LH

); 
	
	foreach($ArrProductosPredeterminados as $DatProductoPredeterminado){
		
		if($DatProductoPredeterminado[0] == $POST_PlanMantenimientoTareaId){

			$ProductoId = "";
			$ProductoNombre = "";
			$ProductoUnidadMedida = "";
			$ProductoUnidadMedidaNombre = "";
			$ProductoUnidadMedidaOrigen = "";
			$ProductoTipo = "";

			$RepFichaAccionMantenimiento = $_SESSION['InsFichaAccionMantenimiento'.$ModalidadIngreso.$Identificador]->MtdVerificarExisteSesionObjeto2($DatProductoPredeterminado[1]);
			$ExisteFichaAccionMantenimiento = $RepFichaAccionMantenimiento['Existe'];
			$InsFichaAccionMantenimiento = $RepFichaAccionMantenimiento['Datos'];

			if($ExisteFichaAccionMantenimiento and $InsFichaAccionMantenimiento->Parametro4 == "C"){

				$ResProducto = $InsProducto->MtdObtenerProductos("ProNombre","contiene",$DatProductoPredeterminado[0],"ProNombre","ASC",1,1,NULL,NULL,$POST_VehiculoMarca,$POST_VehiculoModelo,$POST_VehiculoVersion,$POST_VehiculoAnoFabricacion);
				$ArrProductos = $ResProducto['Datos'];

				$InsUnidadMedida = new ClsUnidadMedida();
				$InsUnidadMedida->UmeId = $DatProductoPredeterminado[2];

				foreach($ArrProductos as $DatProducto){

					$ProductoId = $DatProducto->ProId;
					$ProductoNombre = $DatProducto->ProNombre;
					$ProductoUnidadMedida = $InsUnidadMedida->UmeId;
					$ProductoUnidadMedidaNombre = $InsUnidadMedida->UmeNombre;
					$ProductoUnidadMedidaOrigen = $DatProducto->UmeId;
					$ProductoTipo = $DatProducto->RtiId;

				}
				
				if(!empty($ProductoId)){
					
					$_SESSION['InsFichaAccionMantenimiento'.$ModalidadIngreso.$Identificador]->MtdEditarSesionObjeto($InsFichaAccionMantenimiento->Item,1,
					$InsFichaAccionMantenimiento->Parametro1,
					NULL,
					$InsFichaAccionMantenimiento->Parametro3,
					$InsFichaAccionMantenimiento->Parametro4,
					$InsFichaAccionMantenimiento->Parametro5,
					date("d/m/Y H:i:s"),
					$InsFichaAccionMantenimiento->Parametro7,
					$InsFichaAccionMantenimiento->Parametro8,
					$InsFichaAccionMantenimiento->Parametro9,
					$InsFichaAccionMantenimiento->Parametro10,
					
					NULL,
					$ProductoId,
					$ProductoNombre,
					2,
					2,
					$ProductoUnidadMedida,
					date("d/m/Y H:i:s"),
					date("d/m/Y H:i:s"),
					0,
					0,
					$ProductoTipo,
					$ProductoUnidadMedidaNombre,
					$ProductoUnidadMedidaOrigen,
					2);
					
				}	
		
		
		
			}
						
		}
		


	}

	
	


//$json = new Services_JSON();
//echo $json->encode($InsListaPrecio);


$json = new JSON;
//$var = $json->serialize( $ArrListaPrecios );
$var = $json->serialize( $InsListaPrecio );
$json->unserialize( $var );
echo $var;
	
?>


	
