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

///CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');




//if(!empty($POST_Sucursal)){

//	$Destinatarios = $CorreosNotificacionFichaIngresoSinFacturarSucursal;

//}else{

	$Destinatarios = $CorreosNotificacionTrasladoVehiculoGeneral;

//}


//$Destinatarios  = "j.blanco@cisne.com.pe";

echo "Destinatarios: ";
echo $Destinatarios;
echo "<br>";


$POST_FechaInicio = isset($_GET['FechaInicio'])?$_GET['FechaInicio']:"01/".date("m")."/".date("Y");
$POST_FechaFin = isset($_GET['FechaFin'])?$_GET['FechaFin']:date("d/m/Y");

$POST_ord = isset($_GET['Orden'])?$_GET['Orden']:"TveFecha";
$POST_sen = isset($_GET['Sentido'])?$_GET['Sentido']:"DESC";

$POST_Sucursal = ($_GET['Sucursal']);
$POST_pag  = "";

require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoVehiculo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoVehiculoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsTrasladoVehiculo = new ClsTrasladoVehiculo();
$InsMoneda = new ClsMoneda();
$InsAlmacen = new ClsAlmacen();
$InsSucursal = new ClsSucursal();

//MtdObtenerTrasladoVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'TveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFecha="TveFecha",$oSucursal=NULL)																							
$ResTrasladoVehiculo = $InsTrasladoVehiculo->MtdObtenerTrasladoVehiculos(NULL,NULL,NULL,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),3,"TveTiempoCreacion",$POST_Sucursal,$POST_Almacen);
$ArrTrasladoVehiculos = $ResTrasladoVehiculo['Datos'];

$Titulo  = "";

if($POST_FechaFin == $POST_FechaInicio){
	$Titulo = " ".$POST_FechaInicio;
}else{
	$Titulo = " ".$POST_FechaInicio." al ".$POST_FechaFin;	
}


$mensaje .= "<b><u>TRASLADOS DE VEHICULOS REGISTRADOS</u></b>";
$mensaje .= "<br>";	
$mensaje .= "<br>";	

$mensaje .= "<b>Fecha de aviso:</b> ".date("d/m/Y")."";	
$mensaje .= "<br>";

$mensaje .= "<b>Rango de Fechas:</b> ".$POST_FechaInicio." al ".$POST_FechaFin;	
//$mensaje .= "<b>Rango de Fechas:</b> ".$POST_Fecha;	
$mensaje .= "<br>";

$mensaje .= "<b>Descripcion:</b> Traslados de vehiculos entre sucurales ";
$mensaje .= "<br>";	

  
$mensaje .= "<hr>";
$mensaje .= "<br>";
  
	  $mensaje .= "<br>";

	  if(!empty($ArrTrasladoVehiculos)){	  
		  
		  $mensaje .= "<table cellpadding='2' cellspacing='0' width='100%' border='1'>";
		  
		  $mensaje .= "<tr>";
		  
			  $mensaje .= "<td width='2%'  align='center'>";
			  $mensaje .= "<b>#</b>";
			  $mensaje .= "</td>";

 $mensaje .= "<td width='5%'  align='center'>";
			  $mensaje .= "<b>ID</b>";
			  $mensaje .= "</td>";
			  
			  $mensaje .= "<td width='5%'  align='center'>";
			  $mensaje .= "<b>FECHA</b>";
			  $mensaje .= "</td>";
			  
			  $mensaje .= "<td width='5%'  align='center'>";
			  $mensaje .= "<b>SUCURSAL ORIGEN</b>";
			  $mensaje .= "</td>";
			  
			   $mensaje .= "<td width='10%'  align='center' >";
			  $mensaje .= "<b>SUCURSAL DESTINO</b>";
			  $mensaje .= "</td>";
			  
			  $mensaje .= "<td  width='5%'  align='center' >";
			  $mensaje .= "<b>RESPONSABLE</b>";
			  $mensaje .= "</td >";

			  $mensaje .= "<td   align='center' >";
			  $mensaje .= "<b>DOC. REF.</b>";
			  $mensaje .= "</td>";


			 $mensaje .= "<td   align='center' >";
			  $mensaje .= "<b>FECHA REGISTRO</b>";
			  $mensaje .= "</td>";
			  
			   $mensaje .= "<td  width='17%'  align='center' >";
			  $mensaje .= "<b>OBSERVACION</b>";
			  $mensaje .= "</td>";
			  
		  $mensaje .= "</tr>";
		  
		  
				  
	  $c = 1;	
	  
  foreach($ArrTrasladoVehiculos as $DatTrasladoVehiculo){


	$InsTrasladoVehiculoDetalle = new ClsTrasladoVehiculoDetalle();
	//MtdObtenerTrasladoVehiculoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'TvdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTrasladoVehiculo=NULL,$oEstado=NULL,$oVehiculo=NULL)
	$ResTrasladoVehiculoDetalle =  $InsTrasladoVehiculoDetalle->MtdObtenerTrasladoVehiculoDetalles(NULL,NULL,NULL,"TveId","ASC",NULL,$DatTrasladoVehiculo->TveId);				
	$ArrTrasladoVehiculoDetalle = 	$ResTrasladoVehiculoDetalle['Datos'];	

	$Vines = "";
	
	if(!empty($ArrTrasladoVehiculoDetalle)){
		foreach($ArrTrasladoVehiculoDetalle as $DatTrasladoVehiculoDetalle){
			
			$Vines = "".$DatTrasladoVehiculoDetalle->EinVIN.", ";
			
		}
	}


			  $mensaje .= "<tr>";
						  
				  $mensaje .= "<td>";
				  $mensaje .= $c;
				  $mensaje .= "</td>";
  
				  $mensaje .= "<td>";
				  $mensaje .= $DatTrasladoVehiculo->TveId;
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatTrasladoVehiculo->TveFecha;
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatTrasladoVehiculo->SucNombre;
				  $mensaje .= "</td >";

				  $mensaje .= "<td>";
				  $mensaje .= $DatTrasladoVehiculo->SucNombreDestino;
				  $mensaje .= "</td>";
				  
				
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatTrasladoVehiculo->PerNombre." ".$DatTrasladoVehiculo->PerApellidoPaterno." ".$DatTrasladoVehiculo->PerApellidoMaterno;
				  $mensaje .= "</td>";
				  
				   $mensaje .= "<td>";
				  $mensaje .= $DatTrasladoVehiculo->TveReferencia;
				  $mensaje .= "</td>";
				  
				   $mensaje .= "<td>";
				  $mensaje .= $DatTrasladoVehiculo->TveTiempoCreacion;
				  $mensaje .= "</td>";
				  
				   $mensaje .= "<td>";
				  $mensaje .= $Vines;
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


		
//	 $Enviar = true;			
echo $mensaje;

if($Enviar){
	
	 
	
	//if($POST_Enviar<>"2"){
		$InsCorreo = new ClsCorreo();	
		$InsCorreo->MtdEnviarCorreo($Destinatarios,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: TRASLADOS DE VEHICULOS REGISTRADOS ".$Titulo,$mensaje);
	//}
	
}
	

?>