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


//$FechaInicio = (empty($_GET['FechaInicio'])?"01/".date("m")."/".date("Y"):$_GET['FechaInicio']);
$FechaInicio = (empty($_GET['FechaInicio'])?date("d/m/Y"):$_GET['FechaInicio']);
$FechaFin = (empty($_GET['FechaFin'])?date("d/m/Y"):$_GET['FechaFin']);

$GET_Sucursal = $_GET['Sucursal'];


if(!empty($GET_Sucursal)){

	$Destinatarios = $TarNotificarEntregaVentaVehiculoPendienteSucursal;

}else{

	$Destinatarios = $TarNotificarEntregaVentaVehiculoPendiente;

}

require_once($InsPoo->MtdPaqLogistica().'ClsEntregaVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');



$InsEntregaVentaVehiculo = new ClsEntregaVentaVehiculo();
$InsMoneda = new ClsMoneda();
$InsSucursal = new ClsSucursal();

$ResEntregaVentaVehiculo = $InsEntregaVentaVehiculo->MtdObtenerEntregaVentaVehiculos(NULL,NULL,NULL,"EvvFechaProgramada","ASC",NULL,FncCambiaFechaAMysql($FechaInicio),FncCambiaFechaAMysql($FechaFin),1,NULL);
$ArrEntregaVentaVehiculos = $ResEntregaVentaVehiculo['Datos'];


$mensaje .= "<b><u>PROGRAMACION DE ENTREGAS DE VEHICULOS</u></b>";
$mensaje .= "<br>";	
$mensaje .= "<br>";	

$mensaje .= "<b>Fecha de aviso:</b> ".date("d/m/Y")."";	
$mensaje .= "<br>";
$mensaje .= "<b>Rango de Fechas:</b> ".$FechaInicio." al ".$FechaFin;	
$mensaje .= "<br>";


$mensaje .= "<b>Descripcion:</b> Entrega de vehiculos programadas pendientes de atencion";
$mensaje .= "<br>";	

  
$mensaje .= "<hr>";
$mensaje .= "<br>";
  
	  $mensaje .= "<br>";

	  if(!empty($ArrEntregaVentaVehiculos)){	  
		  
		  $mensaje .= "<table cellpadding='2' cellspacing='0' width='100%' border='1'>";
		  
		  $mensaje .= "<tr>";
		  
			  $mensaje .= "<td width='2%'  align='center'>";
			  $mensaje .= "<b>#</b>";
			  $mensaje .= "</td>";
			
			 $mensaje .= "<td align='center' >";
			  $mensaje .= "<b>SUCURSAL</b>";
			  $mensaje .= "</td >";

			  $mensaje .= "<td width='5%'  align='center'>";
			  $mensaje .= "<b>FECHA PROG.</b>";
			  $mensaje .= "</td>";
			  
			   $mensaje .= "<td width='10%'  align='center' >";
			  $mensaje .= "<b>HORA PROG.</b>";
			  $mensaje .= "</td>";
			  
			 
			  $mensaje .= "<td   align='center' >";
			  $mensaje .= "<b>VIN</b>";
			  $mensaje .= "</td>";

			  $mensaje .= "<td  width='5%'  align='center' >";
			  $mensaje .= "<b>VEHICULO</b>";
			  $mensaje .= "</td>";
			  
			  $mensaje .= "<td align='center' >";
			  $mensaje .= "<b>COLOR</b>";
			  $mensaje .= "</td>";
			  

			  $mensaje .= "<td align='center' >";
			  $mensaje .= "<b>CLIENTE</b>";
			  $mensaje .= "</td>";
			  
			   $mensaje .= "<td  align='center' >";
			  $mensaje .= "<b>OBSERVACION</b>";
			  $mensaje .= "</td>";
			  
			    $mensaje .= "<td   align='center' >";
			  $mensaje .= "<b>ASESOR DE VENTAS</b>";
			  $mensaje .= "</td>";
			
			  
		  $mensaje .= "</tr>";
		  
		  
				  
	  $c = 1;	
	  
  foreach($ArrEntregaVentaVehiculos as $DatEntregaVentaVehiculo){

			  $mensaje .= "<tr>";
						  
				  $mensaje .= "<td>";
				  $mensaje .= $c;
				  $mensaje .= "</td>";
  				
				 $mensaje .= "<td>";
				  $mensaje .= $DatEntregaVentaVehiculo->SucNombre;
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatEntregaVentaVehiculo->EvvFechaProgramada;
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatEntregaVentaVehiculo->EvvHoraProgramada;
				  $mensaje .= "</td >";

				  $mensaje .= "<td>";
				  $mensaje .= $DatEntregaVentaVehiculo->EinVIN;
				  $mensaje .= "</td>";
				  
				   $mensaje .= "<td>";
				  $mensaje .= $DatEntregaVentaVehiculo->VmaNombre." ".$DatEntregaVentaVehiculo->VmoNombre." ".$DatEntregaVentaVehiculo->VveNombre;
				  $mensaje .= "</td>";
				    
					 $mensaje .= "<td>";
				  $mensaje .= $DatEntregaVentaVehiculo->EinColor;
				  $mensaje .= "</td>";
				  
				 
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatEntregaVentaVehiculo->CliNombre." ".$DatEntregaVentaVehiculo->CliApellidoPaterno." ".$DatEntregaVentaVehiculo->CliApellidoMaterno;
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatEntregaVentaVehiculo->OvvObservacion;
				  $mensaje .= "</td>";
				  
				   $mensaje .= "<td>";
				   $mensaje .= $DatEntregaVentaVehiculo->PerNombreVendedor." ".$DatEntregaVentaVehiculo->PerApellidoPaternoVendedor." ".$DatEntregaVentaVehiculo->PerApellidoMaternoVendedor;
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
	  $InsCorreo->MtdEnviarCorreo($Destinatarios,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: PROGRAMACION DE ENTREGAS DE VEHICULOS",$mensaje);
	  
  }
				
				
				
//		}


?>