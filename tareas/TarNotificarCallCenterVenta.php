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


//$Destinatarios = "j.blanco@cisne.com.pe,c.callcenter@cisne.com.pe,p.regente@cisne.com.pe,p.barahona@cisne.com.pe,p.guerra@cisne.com.pe";

$Destinatarios = $TarNotificarCallCenterVenta;


$POST_FechaInicio = isset($_GET['FechaInicio'])?$_GET['FechaInicio']:"01/01/".date("Y");
$POST_FechaFin = isset($_GET['FechaFin'])?$_GET['FechaFin']:date("d/m/Y");
$POST_Sucursal = ($_GET['Sucursal']);
$POST_Dias = ((empty($_GET['Dias'])?20:$_GET['Dias']));
$POST_Nota = $_GET['Nota'];

require_once($InsPoo->MtdPaqReporte().'ClsReporteOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');

require_once($InsPoo->MtdPaqLogistica().'ClsEncuesta.php');



$InsReporteOrdenVentaVehiculo = new ClsReporteOrdenVentaVehiculo();


//MtdObtenerReporteOrdenVentaVehiculoClientes($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL,$oIncluirCSI=NULL,$oDiasTranscurridosTipo="Mayor",$oDiasTranscurridos=0,$oFecha="IFNULL(ovv.OvvActaEntregaFecha,ovv.OvvActaEntregaFechaPDS)") 
$ResReporteOrdenVentaVehiculo = $InsReporteOrdenVentaVehiculo->MtdObtenerReporteOrdenVentaVehiculoClientes(NULL,NULL,NULL,$POST_ord ,$POST_sen,NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_VehiculoMarca,$POST_SucursalId,$POST_IncluirCSI,"Igual",$POST_Dias,"IFNULL(ovv.OvvActaEntregaFecha,ovv.OvvActaEntregaFechaPDS)");
$ArrReporteOrdenVentaVehiculos = $ResReporteOrdenVentaVehiculo['Datos'];



$mensaje .= "<b><u>SEGUIMIENTO DE ORDENES DE VENTA DE VEHICULOS  - CALLCENTER</u></b>";
$mensaje .= "<br>";	
$mensaje .= "<br>";	

$mensaje .= "<b>Fecha de aviso:</b> ".date("d/m/Y")."";	
$mensaje .= "<br>";
$mensaje .= "<b>Descripcion:</b> Ordenes de Venta de vehiculos con ".$POST_Dias." dias posteriores de entrega";
$mensaje .= "<br>";	

if(!empty($POST_Nota)){
	
	$mensaje .= "".$POST_Nota."";
	$mensaje .= "<br>";	
}
  
$mensaje .= "<hr>";
$mensaje .= "<br>";
  
	  $mensaje .= "<br>";

	  if(!empty($ArrReporteOrdenVentaVehiculos)){	  
		  
		  $mensaje .= "<table cellpadding='2' cellspacing='0' width='100%' border='1'>";
		  
		  $mensaje .= "<tr>";
		  
			  $mensaje .= "<td width='2%'  align='center'>";
			  $mensaje .= "<b>#</b>";
			  $mensaje .= "</td>";
			
				 $mensaje .= "<td width='5%'  align='center'>";
			  $mensaje .= "<b>SUCURSAL</b>";
			  $mensaje .= "</td>";
			  
			  
			//  $mensaje .= "<td width='5%'  align='center'>";
			//  $mensaje .= "<b>ORDEN</b>";
			 // $mensaje .= "</td>";
			  
			   $mensaje .= "<td  width='5%'  align='center' >";
			  $mensaje .= "<b>FECHA</b>";
			  $mensaje .= "</td >";
			
			
			  $mensaje .= "<td  width='5%'  align='center' >";
			  $mensaje .= "<b>DIAS TRANSC.</b>";
			  $mensaje .= "</td>";
  
    		$mensaje .= "<td  width='31%'  align='center' >";
			  $mensaje .= "<b>CLIENTE</b>";
			  $mensaje .= "</td>";
			  
				$mensaje .= "<td  width='31%'  align='center' >";
			  $mensaje .= "<b>TELEFONO</b>";
			  $mensaje .= "</td>";

			  	$mensaje .= "<td  width='31%'  align='center' >";
			  $mensaje .= "<b>CELULAR</b>";
			  $mensaje .= "</td>";


			  	$mensaje .= "<td  width='31%'  align='center' >";
			  $mensaje .= "<b>EMAIL</b>";
			  $mensaje .= "</td>";

			//VIN
			
			   $mensaje .= "<td width='10%'  align='center' >";
			  $mensaje .= "<b>PLACA</b>";
			  $mensaje .= "</td>";
			  
			
			    $mensaje .= "<td  width='5%'  align='center' >";
			  $mensaje .= "<b>MARCA</b>";
			  $mensaje .= "</td>";
			  
			   $mensaje .= "<td  width='5%'  align='center' >";
			  $mensaje .= "<b>MODELO</b>";
			  $mensaje .= "</td>";
			  
			  //VERSION
			  
			    $mensaje .= "<td  width='5%'  align='center' >";
			  $mensaje .= "<b>COLOR</b>";
			  $mensaje .= "</td>";
			  
				$mensaje .= "<td  width='15%'  align='center' >";
			  $mensaje .= "<b>ASESOR</b>";
			  $mensaje .= "</td>";
			  
		
			  //$mensaje .= "<td  width='17%'  align='center' >";
			  //$mensaje .= "<b>TRABAJO REALIZADO</b>";
			 // $mensaje .= "</td>";
			  
//			   $mensaje .= "<td  width='17%'  align='center' >";
//			  $mensaje .= "<b>OBSERVACIONES</b>";
//			  $mensaje .= "</td>";
			  
		  $mensaje .= "</tr>";
		  
		  
				  
	  $c = 1;	
	  
  foreach($ArrReporteOrdenVentaVehiculos as $DatReporteOrdenVentaVehiculo){

			  $mensaje .= "<tr>";
						  
				  $mensaje .= "<td>";
				  $mensaje .= $c;
				  $mensaje .= "</td>";
  
				  $mensaje .= "<td>";
				  $mensaje .= $DatReporteOrdenVentaVehiculo->SucNombre;
				  $mensaje .= "</td>";
				  
				  //$mensaje .= "<td>";
				  //$mensaje .= $DatReporteOrdenVentaVehiculo->OvvId;
				 // $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatReporteOrdenVentaVehiculo->OvvFechaEntrega;
				  $mensaje .= "</td >";
				  
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatReporteOrdenVentaVehiculo->OvvDiaTranscurridoEntrega." dia(s)";
				  $mensaje .= "</td>";
				  
				  	  
				  $mensaje .= "<td>";
				  $mensaje .= $DatReporteOrdenVentaVehiculo->CliNombre." ".$DatReporteOrdenVentaVehiculo->CliApellidoPaterno." ".$DatReporteOrdenVentaVehiculo->CliApellidoMaterno;
				  $mensaje .= "</td>";
				  
				   
				  $mensaje .= "<td>";
				  $mensaje .= $DatReporteOrdenVentaVehiculo->CliTelefono;
				  $mensaje .= "</td>";
				  
				   
				  $mensaje .= "<td>";
				  $mensaje .= $DatReporteOrdenVentaVehiculo->CliCelular;
				  $mensaje .= "</td>";
				    
				   
				  $mensaje .= "<td>";
				  $mensaje .= $DatReporteOrdenVentaVehiculo->CliEmail;
				  $mensaje .= "</td>";
				  
				 $mensaje .= "<td>";
				  $mensaje .= $DatReporteOrdenVentaVehiculo->EinPlaca;
				  $mensaje .= "</td>";
				  
				   $mensaje .= "<td>";
				  $mensaje .= $DatReporteOrdenVentaVehiculo->VmaNombre;
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatReporteOrdenVentaVehiculo->VmoNombre;
				  $mensaje .= "</td>";
				  
				   
				  $mensaje .= "<td>";
				  $mensaje .= $DatReporteOrdenVentaVehiculo->EinColor;
				  $mensaje .= "</td>";
				  
				   
				   $mensaje .= "<td>";
				   $mensaje .= $DatReporteOrdenVentaVehiculo->PerNombreAsesor." ".$DatReporteOrdenVentaVehiculo->PerApellidoPaternoAsesor." ".$DatReporteOrdenVentaVehiculo->PerApellidoMaternoAsesor;
					$mensaje .= "</td>";
				  
				  
				  
//				   $mensaje .= "<td>";
//				   
//					//$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
//			  		
//					$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
//			  //function MtdObtenerFichaIngresoModalidades($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FimId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oEstado=NULL
//					$ResFichaIngresoModalidad = $InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidades(NULL,NULL,'FimId','ASC',NULL,$DatReporteOrdenVentaVehiculo->FinId,NULL);
//					$ArrFichaIngresoModalidades = $ResFichaIngresoModalidad['Datos'];
//					 
//					if(!empty($ArrFichaIngresoModalidades)){						
//						foreach($ArrFichaIngresoModalidades as $DatFichaIngresoModalidad){
//						
//	//						echo $DatFichaIngresoModalidad->MinNombre;
//							$mensaje .= $DatFichaIngresoModalidad->MinNombre;
//							$mensaje .= "<br>";
//							
//						}						
//					}
//					
//					$mensaje .= "</td>";
		
//				
//			
//				   $mensaje .= "<td>";
//				   $mensaje .= $DatReporteOrdenVentaVehiculo->FinNota;
//					$mensaje .= "</td>";
				  
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
  $InsCorreo->MtdEnviarCorreo( $Destinatarios,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"AVISO: SEGUIMIENTO DE ORDENES DE VENTA DE VEHICULOS - CALLCENTER",$mensaje);
  
}
			
				
				
//		}


?>
