!<?php
session_start();
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}

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


//require_once('../librerias/nusoap-0.9.5/lib/nusoap.php');
require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');
//require_once('../librerias/JSON2.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON.php');

require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');


//require_once($InsProyecto->MtdRutLibrerias().'fpdf17/fpdf.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');



$wsdl = 'http://192.168.10.6:8080/sissms/webservice/WsMensajeTexto.php?wsdl';

$l_oClient = new nusoap_client($wsdl,'wsdl');
$l_oProxy = $l_oClient->getProxy();
	
$err = $l_oClient->getError();

if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

	if ($l_oProxy->fault) {
		echo 'Error1: ';
		print_r($result);
		echo "<br>";	
	} else {
		// check result
		$err_msg = $l_oProxy->getError();
		if ($err_msg) {
			// Print error msg
			echo 'Error2: '.$err_msg;
			echo "<br>";
		} else {
		   // Print result
		   // echo 'Result: ';
		   // print_r($result);
		   //echo "<br>";
		}
	}
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

</head>

<body>
<?php
require_once($InsPoo->MtdPaqActividad().'ClsCita.php');


 

//$FechaInicio = date("d/m/Y");
$Fecha = (empty($_GET['Fecha'])?date("d/m/Y"):$_GET['Fecha']);


$fechaFFase = FncCambiaFechaAMysql($Fecha );
// podes sumar 1 dia o su equivalente en segundos (tenes que borrar una de las 2 lineas):
$Fecha1Dia = date('Y-m-d', strtotime($fechaFFase) + 86400);
$Fecha1Dia = date('Y-m-d', strtotime("$fechaFFase + 1 day"));

//$fecha = date('Y-m-j');
//$Fecha1Dia = strtotime ( '+2 day' , strtotime ( $fecha ) ) ;
//$Fecha1Dia = date ( 'Y-m-j' , $Fecha1Dia );
// 
//
// 
//echo $Fecha1Dia;


$InsCita = new ClsCita();
//MtdObtenerCitas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CitId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oCliente=NULL,$oPersonal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="CitFecha",$oSinFichaIngreso=false,$oVehiculoIngresoId=NULL,$oPersonalMecanico=NULL,$oHora=NULL) {
$ResCita = $InsCita->MtdObtenerCitas(NULL,NULL,NULL,"CitFechaProgramada","ASC",NULL,NULL,NULL,NULL,$Fecha1Dia,$Fecha1Dia,"CitFechaProgramada",false,NULL,NULL);
$ArrCitas = $ResCita['Datos'];



if(!empty($ArrCitas)){
	$fila = 1;
	foreach($ArrCitas as $DatCita){
		
	
		echo "[Fila ".$fila."]> ";
		echo "<br>";

		echo " CitFechaProgramada: ".$DatCita->CitFechaProgramada;
		echo "<br>";
		
		echo " CitHoraProgramada: ".$DatCita->CitHoraProgramada;
		echo "<br>";
				
		echo " EinVIN: ".$DatCita->EinVIN;
		echo "<br>";
		
		echo " CliNombre: ".$DatCita->CliNombre;
		echo "<br>";
		
			
		$DatCita->CitHoraProgramada = substr($DatCita->CitHoraProgramada,0,5);
		
		
		$DatCita->CliCelular = trim($DatCita->CliCelular);
		$DatCita->CliContactoCelular1 = trim($DatCita->CliContactoCelular1);
		$DatCita->CliContactoCelular2 = trim($DatCita->CliContactoCelular2);
		$DatCita->CliContactoCelular3 = trim($DatCita->CliContactoCelular3);
		
		$DatCita->CliCelular = str_replace(" ","",$DatCita->CliCelular);
		$DatCita->CliContactoCelular1 = str_replace(" ","",$DatCita->CliContactoCelular1);
		$DatCita->CliContactoCelular2 = str_replace(" ","",$DatCita->CliContactoCelular2);
		$DatCita->CliContactoCelular3 = str_replace(" ","",$DatCita->CliContactoCelular3);
		
		$DatCita->CliCelular = substr($DatCita->CliCelular,0,9);
		$DatCita->CliContactoCelular1 = substr($DatCita->CliContactoCelular1,0,9);
		$DatCita->CliContactoCelular2 = substr($DatCita->CliContactoCelular2,0,9);
		$DatCita->CliContactoCelular3 = substr($DatCita->CliContactoCelular3,0,9);
		
		echo " CliCelular: ".$DatCita->CliCelular;
		echo "<br>";
		
		echo " CliContactoCelular1: ".$DatCita->CliContactoCelular1;
		echo "<br>";
		
		echo " CliContactoCelular2: ".$DatCita->CliContactoCelular2;
		echo "<br>";
		
		echo " CliContactoCelular3: ".$DatCita->CliContactoCelular3;
		echo "<br>";	
		
		$Destinatarios = $DatCita->CliCelular;
		
		if(!empty($DatCita->CliContactoCelular1)){
			$Destinatarios .= $DatCita->CliContactoCelular1;
		}
		
		if(!empty($DatCita->CliContactoCelular2)){
			$Destinatarios .= $DatCita->CliContactoCelular2;
		}
		
		if(!empty($DatCita->CliContactoCelular3)){
			$Destinatarios .= $DatCita->CliContactoCelular3;
		}
		
		$currentDateTime = FncCambiaFechaAMysql($DatCita->CitFechaProgramada)." ".$DatCita->CitHoraProgramada.":00";
		
		$AMFM = date('A', strtotime($currentDateTime));

		//$Destinatarios = "950312623";
		
		$Contenido = "CHEVROLET CANEPA TACNA, Le recuerda que su cita es el dia de mañana a las ".$DatCita->CitHoraProgramada." ".$AMFM.".";
		
		echo "Destinatarios: ".$Destinatarios;
		echo "<br>";
		echo "Contenido: ".$Contenido;
		echo "<br>";
		
		$MensajeTexto['MteId'] = "";
		$MensajeTexto['MteFecha'] = date("d/m/Y");
		$MensajeTexto['MteReferencia'] = "CIT:".$DatCita->CitId;
		$MensajeTexto['MteDestino'] = $Destinatarios;
		$MensajeTexto['MteContenido'] = $Contenido;
		$MensajeTexto['MtePrioridad'] = "3";
		$MensajeTexto['MteEstado'] = "1";
		
		$json = new Services_JSON();

		echo "<br>";
		echo "Procesando...";
		echo "<br>";
	
		$l_stResult = $l_oProxy->MtdRegistrarMensajeTexto(json_encode($MensajeTexto));

		if($_SESSION['MysqlDeb']){
			
			deb($l_stResult);
			
		}
		
		switch($l_stResult){
			case 1:
				echo "Se registro correctamente el mensaje de texto";
				echo "<br>";
			break;
			
			case 2:
				echo "No se pudo registrar el mensaje de texto";
				echo "<br>";
			break;
			
			
			default:
			
			break;
		}
		
		$fila++;	
		
		echo "<br>";		
	}
	
}else{
	
	echo "No se encontraron citas<br />";
	
}

//				$param = array(
//				'oId' => $DatVentaDirectaExterna->VdiId,
//				'oCampo' => "VdiResultado",
//				'oDato' => $Resultado);
//				$EditoVentaDirectaDato  = $client->call('MtdEditarVentaDirectaDato', $param);

echo "------------------------------------------<br />";
echo "Proceso Terminado<br />";
echo date("d/m/Y H:i:s")."<br />";
echo "------------------------------------------<br />";
?>


</body>
</html>