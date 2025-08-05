<?php
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
require_once($InsPoo->MtdPaqReporte().'ClsReportePredictivoMantenimiento.php');

$InsReportePredictivoMantenimiento = new ClsReportePredictivoMantenimiento();
 
$Fecha = (empty($_GET['Fecha'])?date("d/m/Y"):$_GET['Fecha']);

$fechaFFase = FncCambiaFechaAMysql($Fecha );
// podes sumar 1 dia o su equivalente en segundos (tenes que borrar una de las 2 lineas):
$Fecha1Dia = date('Y-m-d', strtotime($fechaFFase) + 86400);
$Fecha1Dia = date('Y-m-d', strtotime("$fechaFFase + 7 day"));

$ResReportePredictivoMantenimiento = $InsReportePredictivoMantenimiento->MtdObtenerReportePredictivoMantenimientos(FncCambiaFechaAMysql($Fecha),FncCambiaFechaAMysql($Fecha1Dia),"EinFichaIngresoFechaPredecida","ASC",NULL,NULL,NULL);
$ArrReportePredictivoMantenimientos = $ResReportePredictivoMantenimiento['Datos'];


if(!empty($ArrReportePredictivoMantenimientos)){
	$fila = 1;
	foreach($ArrReportePredictivoMantenimientos as $DatReportePredictivoMantenimientos){
		
	
		echo "[Fila ".$fila."]> ";
		echo "<br>";

		echo " EinVIN: ".$DatReportePredictivoMantenimientos->EinVIN;
		echo "<br>";
		
		echo " EinPlaca: ".$DatReportePredictivoMantenimientos->EinPlaca;
		echo "<br>";
				
		echo " VmoNombre: ".$DatReportePredictivoMantenimientos->VmoNombre;
		echo "<br>";
		
		echo " EinFichaIngresoFechaPredecida: ".$DatReportePredictivoMantenimientos->EinFichaIngresoFechaPredecida;
		echo "<br>";
		
		echo " EinFichaIngresoProximoMantenimientoKilometraje: ".$DatReportePredictivoMantenimientos->EinFichaIngresoProximoMantenimientoKilometraje;
		echo "<br>";
		
		$DatReportePredictivoMantenimientos->CliCelular = trim($DatReportePredictivoMantenimientos->CliCelular);
		$DatReportePredictivoMantenimientos->CliContactoCelular1 = trim($DatReportePredictivoMantenimientos->CliContactoCelular1);
		$DatReportePredictivoMantenimientos->CliContactoCelular2 = trim($DatReportePredictivoMantenimientos->CliContactoCelular2);
		$DatReportePredictivoMantenimientos->CliContactoCelular3 = trim($DatReportePredictivoMantenimientos->CliContactoCelular3);
		
		$DatReportePredictivoMantenimientos->CliCelular = str_replace(" ","",$DatReportePredictivoMantenimientos->CliCelular);
		$DatReportePredictivoMantenimientos->CliContactoCelular1 = str_replace(" ","",$DatReportePredictivoMantenimientos->CliContactoCelular1);
		$DatReportePredictivoMantenimientos->CliContactoCelular2 = str_replace(" ","",$DatReportePredictivoMantenimientos->CliContactoCelular2);
		$DatReportePredictivoMantenimientos->CliContactoCelular3 = str_replace(" ","",$DatReportePredictivoMantenimientos->CliContactoCelular3);
		
		$DatReportePredictivoMantenimientos->CliCelular = substr($DatReportePredictivoMantenimientos->CliCelular,0,9);
		$DatReportePredictivoMantenimientos->CliContactoCelular1 = substr($DatReportePredictivoMantenimientos->CliContactoCelular1,0,9);
		$DatReportePredictivoMantenimientos->CliContactoCelular2 = substr($DatReportePredictivoMantenimientos->CliContactoCelular2,0,9);
		$DatReportePredictivoMantenimientos->CliContactoCelular3 = substr($DatReportePredictivoMantenimientos->CliContactoCelular3,0,9);
		
		echo " CliCelular: ".$DatReportePredictivoMantenimientos->CliCelular;
		echo "<br>";
		
		echo " CliContactoCelular1: ".$DatReportePredictivoMantenimientos->CliContactoCelular1;
		echo "<br>";
		
		echo " CliContactoCelular2: ".$DatReportePredictivoMantenimientos->CliContactoCelular2;
		echo "<br>";
		
		echo " CliContactoCelular3: ".$DatReportePredictivoMantenimientos->CliContactoCelular3;
		echo "<br>";	
		
		$Destinatarios = $DatReportePredictivoMantenimientos->CliCelular;
		
		if(!empty($DatReportePredictivoMantenimientos->CliContactoCelular1)){
			$Destinatarios .= $DatReportePredictivoMantenimientos->CliContactoCelular1;
		}
		
		if(!empty($DatReportePredictivoMantenimientos->CliContactoCelular2)){
			$Destinatarios .= $DatReportePredictivoMantenimientos->CliContactoCelular2;
		}
		
		if(!empty($DatReportePredictivoMantenimientos->CliContactoCelular3)){
			$Destinatarios .= $DatReportePredictivoMantenimientos->CliContactoCelular3;
		}
		
		$Contenido = "CHEVROLET te informa que esta proximo tu mantenimiento de vehiculo, separa tu cita a los numeros 950312564 y 950309755.";
		
		echo "Destinatarios: ".$Destinatarios;
		echo "<br>";
		echo "Contenido: ".$Contenido;
		echo "<br>";
		
		$MensajeTexto['MteId'] = "";
		$MensajeTexto['MteFecha'] = date("d/m/Y");
		$MensajeTexto['MteReferencia'] = "PREDICTIVO:".$DatReportePredictivoMantenimientos->EinVIN;

		$MensajeTexto['MteDestino'] = $Destinatarios;
		$MensajeTexto['MteContenido'] = $Contenido;
		$MensajeTexto['MtePrioridad'] = "3";
		$MensajeTexto['MteEstado'] = "1";
		
		$json = new Services_JSON();

		echo "<br>";
		echo "Procesando...";
		echo "<br>";
	
	//	$l_stResult = $l_oProxy->MtdRegistrarMensajeTexto(json_encode($MensajeTexto));

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
	echo "No se encontraron citas predecidas<br />";
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