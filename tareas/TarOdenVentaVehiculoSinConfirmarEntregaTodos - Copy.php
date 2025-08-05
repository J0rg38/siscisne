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



require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsPersonal = new ClsPersonal();

$FechaInicio = "01/01/".date("Y");
$FechaFin = date("d/m/Y");

//$Destinatarios = "jblanco@cyc.com.pe,scanepam@cyc.com.pe,pcondori@cyc.com.pe,aliendo@cyc.com.pe";//
$Destinatarios = "j.blanco@cisne.com.pe,m.apaza@cisne.com.pe,d.flores@cisne.com.pe";

$Enviar = false;
		
		
//MtdObtenerOrdenVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oCliente=NULL,$oConCotizacion=0,$oFacturable=NULL,$oCotizacionVehiculo=NULL,$oVehiculoIngreso=NULL,$oSucursal=NULL,$oAprobacion1=NULL,$oAprobacion2=NULL,$oAprobacion3=NULL,$oTieneActaFechaEntrega=0,$oTieneComprobante=false)
$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculos(NULL,NULL,NULL,"OvvFecha","ASC",NULL,FncCambiaFechaAMysql($FechaInicio),FncCambiaFechaAMysql($FechaFin),NULL,$POST_Moneda,NULL,NULL,0,NULL,NULL,NULL,$POST_Sucursal,1,NULL,NULL,2,true);
$ArrOrdenVentaVehiculos = $ResOrdenVentaVehiculo['Datos'];

		
		
$i = 1;	
if(!empty($ArrOrdenVentaVehiculos)){
	
	
	$mensaje = "";
	$mensaje .= "<b>NOTIFICACION DE ORDENES DE VENTA DE VEHICULO SIN CONFIRMAR ENTREGA</b>";	
	$mensaje .= "<br>";	
	$mensaje .= "<br>";	
	
	$mensaje .= "<b>Fecha de notificacion:</b> ".date("d/m/Y")."";	
	$mensaje .= "<br>";	
	$mensaje .= "<b>Descripcion:</b> Ordenes de ventas de vehiculos sin confirmacion de entrega.";	
	$mensaje .= "<br>";	
	
	$mensaje .= "<hr>";
	$mensaje .= "<br>";
	
	$mensaje .= "<table cellpadding='4' cellspacing='0' width='100%' border='1'>";
	
	$mensaje .= "<tr>";
	
		$mensaje .= "<td width='2%'>";
		$mensaje .= "<b>#</b>";
		$mensaje .= "</td>";

		$mensaje .= "<td width='10%' align='center'>";
		$mensaje .= "<b>Id</b>";
		$mensaje .= "</td>";
		
		$mensaje .= "<td  align='center'>";
		$mensaje .= "<b>Fecha</b>";
		$mensaje .= "</td>";
		
		$mensaje .= "<td  align='center'>";
		$mensaje .= "<b>Cliente</b>";
		$mensaje .= "</td>";
		
		$mensaje .= "<td width='5%'  align='center'>";
		$mensaje .= "<b>Comprobante</b>";
		$mensaje .= "</td>";

		$mensaje .= "<td width='10%'  align='center'>";
		$mensaje .= "<b>VIN</b>";
		$mensaje .= "</td>";

		$mensaje .= "<td width='10%'  align='center'>";
		$mensaje .= "<b>Vehiculo</b>";
		$mensaje .= "</td>";
		
		$mensaje .= "<td width='10%'  align='center'>";
		$mensaje .= "<b>Telefono</b>";
		$mensaje .= "</td>";
		
		$mensaje .= "<td width='10%'  align='center'>";
		$mensaje .= "<b>Celular</b>";
		$mensaje .= "</td>";
		
		$mensaje .= "<td width='5%'  align='center'>";
		$mensaje .= "<b>Email</b>";
		$mensaje .= "</td>";
		
		$mensaje .= "<td width='5%'  align='center'>";
		$mensaje .= "<b>Asesor de Ventas</b>";
		$mensaje .= "</td>";

		$mensaje .= "<td width='5%'  align='center'>";
		$mensaje .= "<b>Dias Transc.</b>";
		$mensaje .= "</td>";

	$mensaje .= "</tr>";


	foreach($ArrOrdenVentaVehiculos as $DatOrdenVentaVehiculo){

			
			$mensaje .= "<tr>";
							
					$mensaje .= "<td>";
					$mensaje .= $i;
					$mensaje .= "</td>";
	
					$mensaje .= "<td>";
					$mensaje .= $DatOrdenVentaVehiculo->OvvId;
					$mensaje .= "</td>";
	
					$mensaje .= "<td>";
					$mensaje .= $DatOrdenVentaVehiculo->OvvFecha;
					$mensaje .= "</td>";
					
					$mensaje .= "<td>";
					$mensaje .= $DatOrdenVentaVehiculo->CliNombre." ".$DatOrdenVentaVehiculo->CliApellidoPaterno." ".$DatOrdenVentaVehiculo->CliApellidoMaterno;
					$mensaje .= "</td>";
					
					$mensaje .= "<td>";
					$mensaje .= $DatOrdenVentaVehiculo->OvvFacturaNumero."". $DatOrdenVentaVehiculo->OvvBoletaNumero;
					$mensaje .= "</td>";
					
					
					$mensaje .= "<td>";
					$mensaje .= $DatOrdenVentaVehiculo->EinVIN;
					$mensaje .= "</td>";
	
					$mensaje .= "<td>";
					$mensaje .= ("Marca: ".$DatOrdenVentaVehiculo->VmaNombre." Modelo: ".$DatOrdenVentaVehiculo->VmoNombre." Version: ".$DatOrdenVentaVehiculo->VveNombre);
					$mensaje .= "</td>";
					
					$mensaje .= "<td>";
					$mensaje .= ($DatOrdenVentaVehiculo->CliTelefono);
					$mensaje .= "</td>";
					
					$mensaje .= "<td>";
					$mensaje .= ($DatOrdenVentaVehiculo->CliCelular);
					$mensaje .= "</td>";					
					
					$mensaje .= "<td>";
					$mensaje .= ($DatOrdenVentaVehiculo->CliEmail);
					$mensaje .= "</td>";
					
					$mensaje .= "<td>";
					$mensaje .= ($DatOrdenVentaVehiculo->PerNombre." ".$DatOrdenVentaVehiculo->PerApellidoPaterno." ".$DatOrdenVentaVehiculo->PerApellidoMaterno);
					$mensaje .= "</td>";
					
					$mensaje .= "<td>";
					$mensaje .= ($DatOrdenVentaVehiculo->OvvFechaDiaTranscurrido." dias");
					$mensaje .= "</td>";
					
					
					
				$mensaje .= "</tr>";
			
			$i++;				
			
			$Enviar = true;
			
							
	}
}


$mensaje .= "</table>";

$mensaje .= "<br>";
$mensaje .= "<br>";
$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');

if($Enviar){

	echo $mensaje;

	$InsCorreo = new ClsCorreo();	
	$InsCorreo->MtdEnviarCorreo($Destinatarios,$SistemaCorreoUsuario, $SistemaCorreoRemitente,"ORD. VENTA VEH. SIN CONFIRMACION DE ENTREGA ",$mensaje,"","");

}

		
		



			
				
				
?>