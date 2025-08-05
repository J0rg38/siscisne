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


$FechaInicio = (empty($_GET['FechaInicio'])?date("d/m/Y"):$_GET['FechaInicio']);
$FechaFin = (empty($_GET['FechaFin'])?date("d/m/Y"):$_GET['FechaFin']);



require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsMoneda = new ClsMoneda();


//$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculos(NULL,NULL,NULL,"OvvFecha","ASC",NULL,FncCambiaFechaAMysql($FechaInicio),FncCambiaFechaAMysql($FechaFin),3,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,3,0,0);
$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculos(NULL,NULL,NULL,"OvvFecha","ASC",NULL,NULL,FncCambiaFechaAMysql($FechaFin),3,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,3,0,0);
$ArrOrdenVentaVehiculos = $ResOrdenVentaVehiculo['Datos'];



$mensaje .= "<b><u>ASIGNACIONES DE VIN PENDIENTES</u></b>";
$mensaje .= "<br>";	
$mensaje .= "<br>";	

$mensaje .= "<b>Fecha de aviso:</b> ".date("d/m/Y")."";	
$mensaje .= "<br>";
$mensaje .= "<b>Rango de Fechas:</b> ".$FechaInicio." al ".$FechaFin;	
$mensaje .= "<br>";

$mensaje .= "<b>Descripcion:</b> Asignacion de VIN solicitado por asesores de ventas pendientes de atencion";
$mensaje .= "<br>";	

  
$mensaje .= "<hr>";
$mensaje .= "<br>";
  
	  $mensaje .= "<br>";

	  if(!empty($ArrOrdenVentaVehiculos)){	  
		   
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
			  $mensaje .= "<b>VEHICULO</b>";
			  $mensaje .= "</td >";
			  
			  $mensaje .= "<td  width='5%'  align='center' >";
			  $mensaje .= "<b>COLOR</b>";
			  $mensaje .= "</td >";

			    $mensaje .= "<td  width='5%'  align='center' >";
			  $mensaje .= "<b>UBICACION</b>";
			  $mensaje .= "</td>";

			  $mensaje .= "<td  width='31%'  align='center' >";
			  $mensaje .= "<b>CLIENTE</b>";
			  $mensaje .= "</td>";
			  
			 
			    $mensaje .= "<td  width='5%'  align='center' >";
			  $mensaje .= "<b>ASESOR DE VENTAS</b>";
			  $mensaje .= "</td>";
			
			  
		  $mensaje .= "</tr>";
		  
		  
				  
	  $c = 1;	
	  
  foreach($ArrOrdenVentaVehiculos as $DatOrdenVentaVehiculo){

			  $mensaje .= "<tr>";
						  
				  $mensaje .= "<td>";
				  $mensaje .= $c;
				  $mensaje .= "</td>";
  
				  $mensaje .= "<td>";
				  $mensaje .= $DatOrdenVentaVehiculo->OvvId;
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatOrdenVentaVehiculo->OvvFecha;
				  $mensaje .= "</td >";

				   $mensaje .= "<td>";
				  $mensaje .= $DatOrdenVentaVehiculo->VmaNombre." ".$DatOrdenVentaVehiculo->VmoNombre." ".$DatOrdenVentaVehiculo->VveNombre;
				  $mensaje .= "</td>";
				    
  				  $mensaje .= "<td>";
				  $mensaje .= $DatOrdenVentaVehiculo->OvvColor;
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatOrdenVentaVehiculo->SucNombre;
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatOrdenVentaVehiculo->CliNombre." ".$DatOrdenVentaVehiculo->CliApellidoPaterno." ".$DatOrdenVentaVehiculo->CliApellidoMaterno;
				  $mensaje .= "</td>";
			
				   $mensaje .= "<td>";
				   $mensaje .= $DatOrdenVentaVehiculo->PerNombre." ".$DatOrdenVentaVehiculo->PerApellidoPaterno." ".$DatOrdenVentaVehiculo->PerApellidoMaterno;
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
	  $InsCorreo->MtdEnviarCorreo("j.blanco@cisne.com.pe,d.flores@cisne.com.pe,m.apaza@cisne.com.pe",$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: ASIGNACIONES DE VIN PENDIENTES",$mensaje);
	  
  }
				
				
				
//		}


?>