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



$POST_finicio = "";
$POST_ffin = date("d/m/Y");
$Destinatarios = $CorreosNotificacionCotizacionVehiculoPendientes;


$Destinatarios = "m.apaza@cisne.com.pe,j.blanco@cisne.com.pe,jba80@hotmail.com";

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculo.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonalTipo.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');


$InsPersonal = new ClsPersonal();
$InsCotizacionVehiculo = new ClsCotizacionVehiculo();

//MtdObtenerCotizacionVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oSucursal=NULL,$oDiasTranscurridos=0)
$ResCotizacionVehiculo = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculos(NULL,NULL,NULL,"PerNombre,CveTiempoCreacion","ASC","10",FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),3,$POST_Moneda,NULL,"2,3",$POST_Sucursal,3);
$ArrCotizacionVehiculos = $ResCotizacionVehiculo['Datos'];

//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL)
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC","",NULL,3,NULL,NULL,NULL,NULL,NULL,$POST_Sucursal);
$ArrPersonales = $ResPersonal['Datos'];


$mensaje .= "<b><u>SEGUIMIENTO DE COTIZACIONES DE VEHICULO</u></b>";
$mensaje .= "<br>";	
$mensaje .= "<br>";	

$mensaje .= "<b>Fecha y hora de notificacion: </b> ".date("d/m/Y")." ".date("H:i:s")."";	
$mensaje .= "<br>";
$mensaje .= "<b>Descripcion:</b> <i>Cotizaciones de vehiculos con mas de 3 días sin seguimiento</i>";
$mensaje .= "<br>";	

  
$mensaje .= "<hr>";
$mensaje .= "<br>";
  
	  $mensaje .= "<br>";
	  
	  
	  
	  
	  

	  if(!empty($ArrCotizacionVehiculos)){	  
		  
		  $mensaje .= "<table cellpadding='2' cellspacing='0' width='100%' border='1'>";
		  
		  $mensaje .= "<tr>";
		  
			  $mensaje .= "<td width='2%'  align='center'>";
			  $mensaje .= "<b>#</b>";
			  $mensaje .= "</td>";

			  $mensaje .= "<td width='5%'  align='center'>";
			  $mensaje .= "<b>ID</b>";
			  $mensaje .= "</td>";
			  
			   $mensaje .= "<td width='10%'  align='center' >";
			  $mensaje .= "<b>FECHA</b>";
			  $mensaje .= "</td>";
			  
			  $mensaje .= "<td  width='5%'  align='center' >";
			  $mensaje .= "<b>DIAS TRANSC.</b>";
			  $mensaje .= "</td >";
			
				$mensaje .= "<td  width='5%'  align='center' >";
			  $mensaje .= "<b>NIV. INTERES</b>";
			  $mensaje .= "</td>";
			  
			  $mensaje .= "<td  width='5%'  align='center' >";
			  $mensaje .= "<b>CLIENTE</b>";
			  $mensaje .= "</td>";

			  $mensaje .= "<td  width='31%'  align='center' >";
			  $mensaje .= "<b>CONTACTO</b>";
			  $mensaje .= "</td>";
			  
			  $mensaje .= "<td  width='5%'  align='center' >";
			  $mensaje .= "<b>VEHICULO</b>";
			  $mensaje .= "</td>";
			  
				$mensaje .= "<td  width='15%'  align='center' >";
				$mensaje .= "<b>ASESOR</b>";
				$mensaje .= "</td>";
				
				$mensaje .= "<td  width='17%'  align='center' >";
				$mensaje .= "<b>OBSERVACIONES</b>";
				$mensaje .= "</td>";
			  
		  $mensaje .= "</tr>";
		  
		  
				  
	  $c = 1;	
	  
  foreach($ArrCotizacionVehiculos as $DatCotizacionVehiculo){

			  $mensaje .= "<tr>";
						  
				  $mensaje .= "<td>";
				  $mensaje .= $c;
				  $mensaje .= "</td>";
  
				  $mensaje .= "<td>";
				  $mensaje .= $DatCotizacionVehiculo->CveId;
				  $mensaje .= "</td>";
			
				  $mensaje .= "<td>";
				  $mensaje .= $DatCotizacionVehiculo->CveFecha;
				  $mensaje .= "</td >";

				  $mensaje .= "<td>";
				  $mensaje .= $DatCotizacionVehiculo->CveDiaTranscurridos;
				  $mensaje .= "</td>";
				  
				    $mensaje .= "<td>";
				  $mensaje .= $DatCotizacionVehiculo->CveNivelInteresDescripcion;
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatCotizacionVehiculo->CliNombre." ".$DatCotizacionVehiculo->CliApellidoPaterno." ".$DatCotizacionVehiculo->CliApellidoMaterno;
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  
				  if(!empty($DatCotizacionVehiculo->CliCelular)){
					  $mensaje .= "/ Cel.: ".$DatCotizacionVehiculo->CliCelular;
				  }
				  
				    if(!empty($DatCotizacionVehiculo->CliTelefono)){
					  $mensaje .= "/ Telef.: ".$DatCotizacionVehiculo->CliTelefono;
				  }
				  
				    if(!empty($DatCotizacionVehiculo->CliEmail)){
					  $mensaje .= "/ Email.: ".$DatCotizacionVehiculo->CliEmail;
				  }
				  
				  
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatCotizacionVehiculo->VmaNombre." ".$DatCotizacionVehiculo->VmoNombre." ".$DatCotizacionVehiculo->VveNombre;
				  $mensaje .= "</td>";
				  
				   $mensaje .= "<td>";
				   $mensaje .= $DatCotizacionVehiculo->PerNombre." ".$DatCotizacionVehiculo->PerApellidoPaterno." ".$DatCotizacionVehiculo->PerApellidoMaterno;
					$mensaje .= "</td>";


				  $mensaje .= "<td>";
				  $mensaje .= $DatCotizacionVehiculo->CveObservacion;
				  $mensaje .= "</td>";

					  
			  $mensaje .= "</tr>";

		  $c++;			
		  
	  
		  $Enviar = true;
	  
		  
				  
  }
	  

		  
			  
		  $mensaje .= "</table>";
		  
		  
	  }
	  
  
  
  $mensaje .= "<br>";
  $mensaje .= "<br>";
  $mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
  
  
  echo $mensaje;
  
  if($Enviar){
	  
	  $InsCorreo = new ClsCorreo();	
	  //MtdEnviarCorreo($CorDestinatario,$CorRemitenteCorreo,$CorRemitenteNombre,$CorAsunto,$CorContenido,$oCorRutaAdjunto=NULL,$oCorAdjunto=NULL)
	  $InsCorreo->MtdEnviarCorreo($Destinatarios,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: SEGUIMIENTO DE COTIZACIONES DE VEHICULOS",$mensaje);
	  
  }
				
				
				
//		}


?>