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


$Destinatarios = "j.blanco@cisne.com.pe";

$POST_FechaInicio = isset($_GET['FechaInicio'])?$_GET['FechaInicio']:"01/01/".date("Y");
$POST_FechaFin = isset($_GET['FechaFin'])?$_GET['FechaFin']:date("d/m/Y");
$POST_Sucursal = ($_GET['Sucursal']);


require_once($InsPoo->MtdPaqReporte().'ClsReporteFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');

require_once($InsPoo->MtdPaqLogistica().'ClsEncuesta.php');


$InsReporteFichaIngreso = new ClsReporteFichaIngreso();

//MtdObtenerReporteFichaIngresoSeguimientoLlamadas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oFichaIngreso=NULL,$oDiasTranscurridos=0,$oSucursal=NULL,$oModalidadIngreso=NULL,$oConLlamada=false,$oVehiculoMarca=NULL,$oIncluirCSI=NULL,$oDiasTranscurridosTipo="Mayor",$oFecha="FinFecha")
$ResReporteFichaIngreso = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresoSeguimientoLlamadas(NULL,NULL,NULL,"FinTiempoTrabajoTerminado","DESC",NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_ClienteId,$POST_FichaIngresoId,1,$POST_SucursalId,$POST_Modalidad,false,$POST_VehiculoMarca,NULL,"Igual","FinTiempoTrabajoTerminado");		
$ArrReporteFichaIngresos = $ResReporteFichaIngreso['Datos'];



$mensaje .= "<b><u>SEGUIMIENTO DE ORDENES DE TRABAJO  - CALLCENTER</u></b>";
$mensaje .= "<br>";	
$mensaje .= "<br>";	

$mensaje .= "<b>Fecha de aviso:</b> ".date("d/m/Y")."";	
$mensaje .= "<br>";
$mensaje .= "<b>Descripcion:</b> Ordenes de trabajo con 3 dias de haberse culminado";
$mensaje .= "<br>";	

  
$mensaje .= "<hr>";
$mensaje .= "<br>";
  
	  $mensaje .= "<br>";

	  if(!empty($ArrReporteFichaIngresos)){	  
		  
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
			  
		
			    $mensaje .= "<td  width='17%'  align='center' >";
			  $mensaje .= "<b>TRABAJO REALIZADO</b>";
			  $mensaje .= "</td>";
			  
			   $mensaje .= "<td  width='17%'  align='center' >";
			  $mensaje .= "<b>OBSERVACIONES</b>";
			  $mensaje .= "</td>";
			  
		  $mensaje .= "</tr>";
		  
		  
				  
	  $c = 1;	
	  
  foreach($ArrReporteFichaIngresos as $DatReporteFichaIngreso){

			  $mensaje .= "<tr>";
						  
				  $mensaje .= "<td>";
				  $mensaje .= $c;
				  $mensaje .= "</td>";
  
				  $mensaje .= "<td>";
				  $mensaje .= $DatReporteFichaIngreso->SucNombre;
				  $mensaje .= "</td>";
				  
				    $mensaje .= "<td>";
				  $mensaje .= $DatReporteFichaIngreso->FinId;
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatReporteFichaIngreso->FinTiempoTrabajoTerminado;
				  $mensaje .= "</td >";
				  
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatReporteFichaIngreso->FinDiaTranscurridoTerminado;
				  $mensaje .= "</td>";
				  
				  	  
				  $mensaje .= "<td>";
				  $mensaje .= $DatReporteFichaIngreso->CliNombre." ".$DatReporteFichaIngreso->CliApellidoPaterno." ".$DatReporteFichaIngreso->CliApellidoMaterno;
				  $mensaje .= "</td>";
				  
				   
				  $mensaje .= "<td>";
				  $mensaje .= $DatReporteFichaIngreso->CliTelefono;
				  $mensaje .= "</td>";
				  
				   
				  $mensaje .= "<td>";
				  $mensaje .= $DatReporteFichaIngreso->CliCelular;
				  $mensaje .= "</td>";
				    
				   
				  $mensaje .= "<td>";
				  $mensaje .= $DatReporteFichaIngreso->CliEmail;
				  $mensaje .= "</td>";
				  
				 $mensaje .= "<td>";
				  $mensaje .= $DatReporteFichaIngreso->EinPlaca;
				  $mensaje .= "</td>";
				  
				   $mensaje .= "<td>";
				  $mensaje .= $DatReporteFichaIngreso->VmaNombre;
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatReporteFichaIngreso->VmoNombre;
				  $mensaje .= "</td>";
				  
				   
				  $mensaje .= "<td>";
				  $mensaje .= $DatReporteFichaIngreso->EinColor;
				  $mensaje .= "</td>";
				  
				   
				   $mensaje .= "<td>";
				   $mensaje .= $DatReporteFichaIngreso->PerNombreAsesor." ".$DatReporteFichaIngreso->PerApellidoPaternoAsesor." ".$DatReporteFichaIngreso->PerApellidoMaternoAsesor;
					$mensaje .= "</td>";
				  
				  
				  
				   $mensaje .= "<td>";
				   
					//$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
			  		
					$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
			  //function MtdObtenerFichaIngresoModalidades($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FimId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oEstado=NULL
					$ResFichaIngresoModalidad = $InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidades(NULL,NULL,'FimId','ASC',NULL,$DatReporteFichaIngreso->FinId,NULL);
					$ArrFichaIngresoModalidades = $ResFichaIngresoModalidad['Datos'];
					 
					if(!empty($ArrFichaIngresoModalidades)){						
						foreach($ArrFichaIngresoModalidades as $DatFichaIngresoModalidad){
						
	//						echo $DatFichaIngresoModalidad->MinNombre;
							$mensaje .= $DatFichaIngresoModalidad->MinNombre;
							$mensaje .= "<br>";
							
						}						
					}
					
					$mensaje .= "</td>";
		
				

			
				   $mensaje .= "<td>";
				   $mensaje .= $DatReporteFichaIngreso->FinNota;
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
	  $InsCorreo->MtdEnviarCorreo( $Destinatarios,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"AVISO: SEGUIMIENTO DE ORDENES DE TRABAJO - CALLCENTER",$mensaje);
	  
  }
				
				
				
//		}


?>