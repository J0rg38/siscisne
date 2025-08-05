<?php
session_start();
	
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}

////ARCHIVOS PRINCIPALES
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../../';
$InsProyecto->Ruta = '../../../';

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
/*
*Control de Lista de Acceso
*/
require_once($InsPoo->MtdPaqAcceso().'ClsACL.php');
require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');
//INSTANCIAS
$InsSesion = new ClsSesion();
$InsMensaje = new ClsMensaje();

$InsACL = new ClsACL();

require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');


$GET_id = $_GET['Id'];
$GET_Email = $_GET['Email'];
$GET_Actualizar = $_GET['Actualizar'];

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoFoto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
require_once($InsPoo->MtdPaqLogistica().'ClsObsequio.php');

$InsCotizacionVehiculo = new ClsCotizacionVehiculo();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsVehiculoMarca = new ClsVehiculoMarca();

$InsPersonal = new ClsPersonal();
$InsCondicionVenta = new ClsCondicionVenta();
$InsCondicionPago = new ClsCondicionPago();
$InsObsequio = new ClsObsequio();
//Obteniendo datos de factura
$InsCotizacionVehiculo->CveId = $GET_id;
$InsCotizacionVehiculo->MtdObtenerCotizacionVehiculo();	


	$oRemitente = $InsCotizacionVehiculo->PerNombre." ".$InsCotizacionVehiculo->PerApellidoPaterno." ".$InsCotizacionVehiculo->PerApellidoMaterno;
	$Ruta = '../../../generados/';
	$Archivo = $InsCotizacionVehiculo->CveId.".pdf";
	$Adjunto = $Ruta .$Archivo;
	
	//echo "aaaa";
	$mensaje = "";
	
	if(date("A") == "PM"){
		$mensaje .= "Buenas tardes";
	}else{
		$mensaje .= "Buenos dias";
	}

	$mensaje .= "<br>";
	$mensaje .= "<br>";
	
	$mensaje .= "<b>Sr(es).</b>";
	$mensaje .= "<br>";
	
	$mensaje .= "".$InsCotizacionVehiculo->CliNombre." ".$InsCotizacionVehiculo->CliApellidoPaterno." ".$InsCotizacionVehiculo->CliApellidoMaterno;
	$mensaje .= "<br>";
	
	$mensaje .= "Le enviamos la cotizacion de vehiculo solicitada <b>".$InsCotizacionVehiculo->CveId."</b>";
	$mensaje .= "<br>";
	$mensaje .= "<b>Fecha:</b> ".$InsCotizacionVehiculo->CveFecha."";
	$mensaje .= "<br>";

	$mensaje .= "<br>";
	$mensaje .= "<b>Marca:</b> ".$InsCotizacionVehiculo->VmaNombre."";
	$mensaje .= "<br>";
	$mensaje .= "<b>Modelo:</b> ".$InsCotizacionVehiculo->VmoNombre."";
	$mensaje .= "<br>";
	$mensaje .= "<b>Version:</b> ".$InsCotizacionVehiculo->VveNombre."";
	$mensaje .= "<br>";
	
	$mensaje .= "<br>";
	$mensaje .= "<br>";
	$mensaje .= "Estaremos a la espera de su pronta respuesta.";
	$mensaje .= "<br>";
	$mensaje .= "<br>";
	//$mensaje .= "Saludos";
	
	if(!empty($oRemitente)){
	
		$mensaje .= "<br>";
		$mensaje .= "<br>";
		$mensaje .= "Atte.";
		
		$mensaje .= "<br>";
		$mensaje .= "<br>";
		$mensaje .= $oRemitente;
	
	}
	
	$mensaje .= "<br>";
	$mensaje .= "<br>";
	$mensaje .= "Gracias";
	$mensaje .= "<br>";
	$mensaje .= "<br>";
	
	$mensaje .= "<br>";
	$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
	
	
	if(!empty($GET_Email)){
		
		
		if($GET_Actualizar=="1"){
			
			$InsCliente = new ClsCliente();
			$InsCliente->MtdEditarClienteDato("CliEmail",$GET_Email,$InsCotizacionVehiculo->CliId);
			
		}

		if(file_exists($Adjunto)){
			
			$Destinatario = $GET_Email.",".$InsCotizacionVehiculo->PerEmail;
			//deb($oAdjunto);
			$InsCorreo = new ClsCorreo();	
			//MMtdEnviarCorreo($CorDestinatario,$CorRemitenteCorreo,$CorRemitenteNombre,$CorAsunto,$CorContenido,$oCorRutaAdjunto=NULL,$oCorAdjunto=NULL)
			$InsCorreo->MtdEnviarCorreo($Destinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"COTIZACION DE VEHICULO: ".$InsCotizacionVehiculo->CveId." ",$mensaje,$Ruta,$Archivo);
		
			$Envio = true;
			
			$Resultado['Respuesta'] = '1';
			$Resultado['Mensaje'] = 'Se envio correctamente el correo electronico';
			
		}else{
			
			$Resultado['Respuesta'] = '4';
			$Resultado['Mensaje'] = 'No se encontro archivo adjunto';

		}
		
		
		
	}else{
		
		$Resultado['Respuesta'] = '3';
		$Resultado['Mensaje'] = 'No se encontro correo electronico';
		
	}
	

echo json_encode($Resultado);
?>

