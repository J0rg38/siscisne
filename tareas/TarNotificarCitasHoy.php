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

//$Destinatarios = "j.blanco@cisne.com.pe";
$GET_FechaInicio = (empty($_GET['FechaInicio'])?date("d/m/Y"):$_GET['FechaInicio']);
$GET_FechaFin = (empty($_GET['FechaFin'])?date("d/m/Y"):$_GET['FechaFin']);
$GET_Sucursal = $_GET['Sucursal'];

if(!empty($GET_Sucursal)){

	$Destinatarios = $CorreosNotificacionCitasSucursal;

}else{

	$Destinatarios = $CorreosNotificacionCitasGeneral;

}

require_once($InsPoo->MtdPaqActividad().'ClsCita.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsCita = new ClsCita();
$InsSucursal = new ClsSucursal();
//MtdObtenerProductoDisponibilidades($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oDisponible=NULL)
if(empty($GET_FechaInicio)){
	exit("Ingrese una fecha de inicio");
}

if(empty($GET_FechaFin)){
	exit("Ingrese una fecha de termino");
}

$SucursalNombre = "";
	
if(!empty($GET_Sucursal)){
	
	$InsSucursal = new ClsSucursal();
	$InsSucursal->SucId = $GET_Sucursal;
	$InsSucursal->MtdObtenerSucursal();
	
	$SucursalNombre = $InsSucursal->SucNombre;
	
}

//MtdObtenerCitas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CitId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oCliente=NULL,$oPersonal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="CitFecha",$oSinFichaIngreso=false,$oVehiculoIngresoId=NULL,$oPersonalMecanico=NULL,$oHora=NULL,$oSucursal=NULL)
$ResCita = $InsCita->MtdObtenerCitas(NULL,NULL,NULL,"CitFechaProgramada","ASC",NULL,1,NULL,$POST_Personal,FncCambiaFechaAMysql($GET_FechaInicio),FncCambiaFechaAMysql($GET_FechaFin),"CitFechaProgramada",true,NULL,NULL,NULL,$GET_Sucursal);
$ArrCitas = $ResCita['Datos'];


$ColorFondoCabecera = "#336699";
$ColorCabeceraTexto = "";

$mensaje .= "<style type='text/css'>";
$mensaje .= ".EstNegativo{	color:#F00;}";	
$mensaje .= ".EstCabecera{ background-color:#336699;	color:#FFFFFF;}";	
$mensaje .= "</style>";	



$mensaje .= "<b><u>CITAS DEL DIA ".(!empty($SucursalNombre)?"- ".$SucursalNombre:"".$SucursalNombre)."</u></b>";
$mensaje .= "<br>";	
$mensaje .= "<br>";	

$mensaje .= "<b>Fecha de aviso:</b> ".date("d/m/Y")."";	
$mensaje .= "<br>";
$mensaje .= "<b>Descripcion:</b> Estas son las citas registradas para el dia de hoy";
$mensaje .= "<br>";	

  
$mensaje .= "<hr>";
$mensaje .= "<br>";
  
	  $mensaje .= "<br>";

	  if(!empty($ArrCitas)){	  
		  
		  $mensaje .= "<table cellpadding='5' cellspacing='0' width='100%' border='1'>";
		  
		  $mensaje .= "<thead>";
			  
			  $mensaje .= "<tr>";
			  
					$mensaje .= "<th class='EstCabecera'>";
					$mensaje .= "<b>#</b>";
					$mensaje .= "</th>";
					
					$mensaje .= "<th class='EstCabecera'>";
					$mensaje .= "<b>SUCURSAL</b>";
					$mensaje .= "</th>";
					
					$mensaje .= "<th class='EstCabecera'>";
					$mensaje .= "<b>FECHA</b>";
					$mensaje .= "</th>";
					
					$mensaje .= "<th class='EstCabecera'>";
					$mensaje .= "<b>HORA</b>";
					$mensaje .= "</th>";
					
					$mensaje .= "<th class='EstCabecera'>";
					$mensaje .= "<b>CLIENTE</b>";
					$mensaje .= "</th>";
					
					$mensaje .= "<th class='EstCabecera'>";
					$mensaje .= "<b>CONTACTO</b>";
					$mensaje .= "</th>";
					
					$mensaje .= "<th class='EstCabecera'>";
					$mensaje .= "<b>PLACA</b>";
					$mensaje .= "</th>";
					
					$mensaje .= "<th class='EstCabecera'>";
					$mensaje .= "<b>VEHICULO</b>";
					$mensaje .= "</th>";
					
					$mensaje .= "<th class='EstCabecera'>";
					$mensaje .= "<b>ASESOR</b>";
					$mensaje .= "</th>";
					
					$mensaje .= "<th class='EstCabecera'>";
					$mensaje .= "<b>OBS.</b>";
					$mensaje .= "</th>";
				  
			  $mensaje .= "</tr>";
		  
			$mensaje .= "</thead>";
				  
			$c = 1;	
				  
			foreach($ArrCitas as $DatCita){

				$mensaje .= "<tr>";
				  
				$mensaje .= "<td>";
				$mensaje .= $c;
				$mensaje .= "</td>";
				
				$mensaje .= "<td>";
				$mensaje .= $DatCita->SucNombre;
				$mensaje .= "</td>";
				
				$mensaje .= "<td>";
				$mensaje .= $DatCita->CitFechaProgramada;
				$mensaje .= "</td>";
				
				$mensaje .= "<td>";
				$mensaje .= $DatCita->CitHoraProgramada;
				$mensaje .= "</td >";
				
				$mensaje .= "<td>";
				$mensaje .= $DatCita->CliNombre." ".$DatCita->CliApellidoPaterno." ".$DatCita->CliApellidoMaterno;
				$mensaje .= "</td>";
				
				$mensaje .= "<td>";
				$mensaje .= $DatCita->CliTelefono." / ".$DatCita->CliCelular;
				$mensaje .= "</td>";
				
				$mensaje .= "<td>";
				$mensaje .= $DatCita->CitVehiculoPlaca;
				$mensaje .= "</td>";
				
				$mensaje .= "<td>";
				$mensaje .= $DatCita->CitVehiculoMarca. " ".$DatCita->CitVehiculoModelo." ".$DatCita->CitVehiculoVersion;
				$mensaje .= "</td>";
				
				$mensaje .= "<td>";
				$mensaje .= $DatCita->PerNombreAsesor." ".$DatCita->PerApellidoPaternoAsesor." ".$DatCita->PerApellidoMaternoAsesor;
				$mensaje .= "</td>";
				
				$mensaje .= "<td>";
				$mensaje .= $DatCita->CitDescripcion;
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
  
	echo "<br>";
	echo "<br>";
	
	echo $Destinatarios;
	
	echo "<br>";
	echo "<br>";
	
	echo $mensaje;
	
	echo "<br>";
	echo "<br>";
  
  
  if($Enviar){
	  
	  
	  $InsCorreo = new ClsCorreo();	
	  $InsCorreo->MtdEnviarCorreo($Destinatarios,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: CITAS DEL DIA ".(!empty($SucursalNombre)?"- ".$SucursalNombre:"".$SucursalNombre),$mensaje);
	  
	  
	  
  }
				
				
				
//		}


?>