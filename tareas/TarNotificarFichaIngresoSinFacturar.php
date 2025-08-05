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

	$Destinatarios = $CorreosNotificacionFichaIngresoSinFacturarGeneral;

//}


//$Destinatarios  = "j.blanco@cisne.com.pe";

echo "Destinatarios: ";
echo $Destinatarios;
echo "<br>";



$POST_FechaInicio = isset($_GET['FechaInicio'])?$_GET['FechaInicio']:"01/".date("m")."/".date("Y");
$POST_FechaFin = isset($_GET['FechaFin'])?$_GET['FechaFin']:date("d/m/Y");

$POST_ord = isset($_GET['Orden'])?$_GET['Orden']:"FinFecha";
$POST_sen = isset($_GET['Sentido'])?$_GET['Sentido']:"DESC";

$POST_Sucursal = ($_GET['Sucursal']);

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteVenta.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');



$InsFichaAccion = new ClsFichaAccion();
$InsComprobanteVenta = new ClsComprobanteVenta();
$InsSucursal = new ClsSucursal();
$InsMoneda = new ClsMoneda();


$ResComprobanteVenta = $InsComprobanteVenta->MtdObtenerFichaIngresoxFacturar(NULL,NULL,NULL,$POST_ord,$POST_sen,$POST_pag,NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),NULL,"75,8,9",false,false,"MIN-10016,MIN-10016,MIN-10001,MIN-10002,MIN-10003,MIN-10004,MIN-10005,MIN-10007,MIN-10009,MIN-10015,MIN-10013,MIN-10006,MIN-10017,MIN-10018,MIN-10028,MIN-10024,MIN-10019,MIN-10020,MIN-10021,MIN-10023,MIN-10026,MIN-10029",true,$POST_Facturable,true,"fcc.FccFecha",$POST_Sucursal,$POST_Moneda);//73,74,75,8,9
$ArrComprobanteVentas = $ResComprobanteVenta['Datos'];

$Titulo  = "";

if($POST_FechaFin == $POST_FechaInicio){
	$Titulo = " ".$POST_FechaInicio;
}else{
	$Titulo = " ".$POST_FechaInicio." al ".$POST_FechaFin;	
}


$mensaje .= "<b><u>ORDENES DE TRABAJO SIN FACTURAR</u></b>";
$mensaje .= "<br>";	
$mensaje .= "<br>";	

$mensaje .= "<b>Fecha de aviso:</b> ".date("d/m/Y")."";	
$mensaje .= "<br>";

$mensaje .= "<b>Rango de Fechas:</b> ".$POST_FechaInicio." al ".$POST_FechaFin;	
//$mensaje .= "<b>Rango de Fechas:</b> ".$POST_Fecha;	
$mensaje .= "<br>";

$mensaje .= "<b>Descripcion:</b> Ordenes de trabajo que no se han facturado y se encuentran pendientes de emitir comprobante";
$mensaje .= "<br>";	

  
$mensaje .= "<hr>";
$mensaje .= "<br>";
  
	  $mensaje .= "<br>";

	  if(!empty($ArrComprobanteVentas)){	  
		  
		  $mensaje .= "<table cellpadding='2' cellspacing='0' width='100%' border='1'>";
		  
		  $mensaje .= "<tr>";
		  
			  $mensaje .= "<td width='2%'  align='center'>";
			  $mensaje .= "<b>#</b>";
			  $mensaje .= "</td>";


			  $mensaje .= "<td width='5%'  align='center'>";
			  $mensaje .= "<b>SUCURSAL</b>";
			  $mensaje .= "</td>";
			  
			  $mensaje .= "<td width='5%'  align='center'>";
			  $mensaje .= "<b>O.T.</b>";
			  $mensaje .= "</td>";
			  
			   $mensaje .= "<td width='10%'  align='center' >";
			  $mensaje .= "<b>FICHA SALIDA</b>";
			  $mensaje .= "</td>";
			  
			  $mensaje .= "<td  width='5%'  align='center' >";
			  $mensaje .= "<b>FECHA</b>";
			  $mensaje .= "</td >";

			  $mensaje .= "<td   align='center' >";
			  $mensaje .= "<b>CLIENTE</b>";
			  $mensaje .= "</td>";

			  $mensaje .= "<td  width='31%'  align='center' >";
			  $mensaje .= "<b>VIN</b>";
			  $mensaje .= "</td>";
			  
			  
			   $mensaje .= "<td  width='5%'  align='center' >";
			  $mensaje .= "<b>PLACA</b>";
			  $mensaje .= "</td>";
			  
				$mensaje .= "<td  width='15%'  align='center' >";
			  $mensaje .= "<b>MARCA</b>";
			  $mensaje .= "</td>";
			  
			   	$mensaje .= "<td  width='15%'  align='center' >";
			  $mensaje .= "<b>MODELO</b>";
			  $mensaje .= "</td>";
		
			  
			    $mensaje .= "<td  width='17%'  align='center' >";
			  $mensaje .= "<b>ASESOR DE SERVICIO</b>";
			  $mensaje .= "</td>";
			  
			   $mensaje .= "<td  width='17%'  align='center' >";
			  $mensaje .= "<b>OBSERVACION</b>";
			  $mensaje .= "</td>";
			  
		  $mensaje .= "</tr>";
		  
		  
				  
	  $c = 1;	
	  
  foreach($ArrComprobanteVentas as $DatComprobanteVenta){

			  $mensaje .= "<tr>";
						  
				  $mensaje .= "<td>";
				  $mensaje .= $c;
				  $mensaje .= "</td>";
  
				  $mensaje .= "<td>";
				  $mensaje .= $DatComprobanteVenta->SucNombre;
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatComprobanteVenta->FinId;
				  $mensaje .= "</td >";

				  $mensaje .= "<td>";
				  $mensaje .= $DatComprobanteVenta->AmoId;
				  $mensaje .= "</td>";
				  
				  
				    $mensaje .= "<td>";
				  $mensaje .= $DatComprobanteVenta->FinTiempoCreacion;
				  $mensaje .= "</td>";
				  
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatComprobanteVenta->CliNombre." ".$DatComprobanteVenta->CliApellidoPaterno." ".$DatComprobanteVenta->CliApellidoMaterno;
				  $mensaje .= "</td>";
				  
				   $mensaje .= "<td>";
				  $mensaje .= $DatComprobanteVenta->EinVIN;
				  $mensaje .= "</td>";
				  
				   $mensaje .= "<td>";
				  $mensaje .= $DatComprobanteVenta->EinPlaca;
				  $mensaje .= "</td>";
				  
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatComprobanteVenta->VmaNombre;
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatComprobanteVenta->VmoNombre;
				  $mensaje .= "</td>";
				  
				 
				  
				   $mensaje .= "<td>";
				   $mensaje .= $DatComprobanteVenta->PerNombreAsesor." ".$DatComprobanteVenta->PerApellidoPaternoAsesor." ".$DatComprobanteVenta->PerApellidoMaternoAsesor;
					$mensaje .= "</td>";

  $mensaje .= "<td>";
				  $mensaje .= "";
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
	
	 
	
	//if($POST_Enviar<>"2"){
		$InsCorreo = new ClsCorreo();	
		$InsCorreo->MtdEnviarCorreo($Destinatarios,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: O.T. SIN FACTURAR ".$Titulo,$mensaje);
	//}
	
}
	

?>