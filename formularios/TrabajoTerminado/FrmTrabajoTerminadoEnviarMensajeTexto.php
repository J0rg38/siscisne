<?php
session_start();
	
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}

////ARCHIVOS PRINCIPALES
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

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
/*
*Control de Lista de Acceso
*/
require_once($InsPoo->MtdPaqAcceso().'ClsACL.php');
require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');
//INSTANCIAS
$InsSesion = new ClsSesion();
$InsMensaje = new ClsMensaje();

$InsACL = new ClsACL();

require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');

$GET_FinId = $_GET['FinId'];

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoManoObra.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoHerramienta.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoSuministro.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoMantenimiento.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTempario.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSuministro.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');


$InsFichaIngreso = new ClsFichaIngreso();
$InsFichaIngreso->FinId = $GET_FinId;
$InsFichaIngreso->MtdObtenerFichaIngreso(false);

$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
$ResFichaIngresoModalidad = $InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidades(NULL,NULL,'FimId','ASC',NULL,$InsFichaIngreso->FinId,NULL);
$ArrFichaIngresoModalidades = $ResFichaIngresoModalidad['Datos'];

$ModalidaIngresoMantenimiento = false;

$TallerPedidoId = "";
$ManoDeObra = 0;
$TotalMantenimiento = 0;
$TotalServicio = 0;

if(!empty($ArrFichaIngresoModalidades)){
	foreach($ArrFichaIngresoModalidades as $DatFichaIngresoModalidad){
		
		//if($DatFichaIngresoModalidad->MinSigla == "MA"){
			
			//$ModalidaIngresoMantenimiento = true;
			
			$InsFichaAccion = new ClsFichaAccion();
			$ResFichaAccion = $InsFichaAccion->MtdObtenerFichaAcciones(NULL,NULL,NULL,'FccId','ASC','1',$DatFichaIngresoModalidad->FimId,NULL,NULL,NULL);
			$ArrFichaAcciones = $ResFichaAccion['Datos'];
					
			if(!empty($ArrFichaAcciones)){
				foreach($ArrFichaAcciones as $DatFichaAccion){
					
					$ManoDeObra  = (empty($DatFichaAccion->FccManoObra)?0:$DatFichaAccion->FccManoObra);
					
					$InsTallerPedido = new ClsTallerPedido();
					$ResTallerPedido = $InsTallerPedido->MtdObtenerTallerPedidos(NULL,NULL,NULL,'AmoFecha','DESC','1',NULL,NULL,NULL,$DatFichaAccion->FccId);
					$ArrTallerPedidos = $ResTallerPedido['Datos'];
					
					if(!empty($ArrTallerPedidos)){
						foreach($ArrTallerPedidos as $DatTallerPedido){
	
							$TallerPedidoId = $DatTallerPedido->AmoId;
							
						}
					}
					
					if(!empty($TallerPedidoId)){
						
						$InsTallerPedido = new ClsTallerPedido();
						$InsTallerPedido->AmoId = $TallerPedidoId;
						$InsTallerPedido->MtdObtenerTallerPedido();
						
						$MonedaSimbolo = $InsTallerPedido->MonSimbolo;
						
						$TotalServicio += $InsTallerPedido->AmoTotal - $InsTallerPedido->AmoDescuento + $ManoDeObra;;
						//$MonedaSimbolo = $InsTallerPedido->MonSimbolo;

					}

						
				}
			}
					
			//break;
		//}
		
		
	}
}

//deb($ModalidaIngresoMantenimiento);
//deb($TallerPedidoId);

//$TotalMantenimiento = 0;
//$MonedaSimbolo = "";
//
//if($ModalidaIngresoMantenimiento){
//	if(!empty($TallerPedidoId)){
//		
//		$InsTallerPedido = new ClsTallerPedido();
//		$InsTallerPedido->AmoId = $TallerPedidoId;
//		$InsTallerPedido->MtdObtenerTallerPedido();
//		
//		$TotalMantenimiento = $InsTallerPedido->AmoTotal - $InsTallerPedido->AmoDescuento + $ManoDeObra;;
//		$MonedaSimbolo = $InsTallerPedido->MonSimbolo;
//									
//	}
//}

$Mensaje = "";
$Celular = "";
$Referencia = "";

//if($TotalMantenimiento>0){
	//CYC TACNA, le informamos que su vehiculo Z3E-578 se encuentra listo para recoger en 30 minutos. Su cuenta es de  S/.245.00
if($TotalServicio>0){
	
	$Mensaje = "CYC TACNA, le informamos que su vehiculo ".$InsFichaIngreso->EinPlaca." se encuentra listo para recoger en 30 minutos. Su cuenta es de ".$MonedaSimbolo." ".number_format($TotalServicio,2);
	
}else{
	
	$Mensaje = "CYC TACNA, le informamos que su vehiculo ".$InsFichaIngreso->EinPlaca." se encuentra listo para recoger.";
	
}

if(empty($InsFichaIngreso->FinCelular)){
	$Celular = $InsFichaIngreso->CliCelular;
}else{
	$Celular = $InsFichaIngreso->FinCelular;	
}

if(!empty($InsFichaIngreso->CliContactoCelular1)){
	$Celular .= ",".$InsFichaIngreso->CliContactoCelular1;
}


if(!empty($InsFichaIngreso->CliContactoCelular2)){
	$Celular .= ",".$InsFichaIngreso->CliContactoCelular2;
}


if(!empty($InsFichaIngreso->CliContactoCelular3)){
	$Celular .= ",".$InsFichaIngreso->CliContactoCelular3;
}

//Jose Luis
//950309755

//Diego
//950312564

//$Celular  .= ",950309755,950312564,950312623,974799856";
$Celular  .= ",950312623";
$Celular  .= ",950309755";

//$Celular  = "973253092,950312623";
$Referencia = "OT: ".$InsFichaIngreso->FinId." TERMINADA VIN: ".$InsFichaIngreso->EinVIN;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TRANSFIRIENDO MENSAJE DE TEXTO</title>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<!--
Funciones Generales
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutFunciones();?>FncGeneral.js"></script>

<!--
Nombre: DHTMLX MESSAGES
Descripcion:
-->
<script src="<?php echo $InsProyecto->MtdRutLibrerias();?>dhtmlxSuite_v50_std/codebase/dhtmlx.js"></script>
<link rel="stylesheet" href="<?php echo $InsProyecto->MtdRutLibrerias();?>dhtmlxSuite_v50_std/codebase/dhtmlx.css">


</head>
<body>

<img src="../../imagenes/sms.png" alt="[SMS]" title="SMS" width="45" height="45" border="0" /><br />
<img src="../../imagenes/cargando.gif" alt="[Cargando...]" title="Cargando..." width="80"  border="0" /><br /><br />

<script type="text/javascript">

$().ready(function() {

	$('#CapTrabajoTerminadoAccion').html('Esperando confirmacion...');	
	
	dhtmlx.confirm("¿Realmente desea enviar el mensaje: <?php echo $Mensaje;?>?", function(result){
		if(result==true){
		
		$('#CapTrabajoTerminadoAccion').html('Enviando mensaje de texto...');	
		
			$.ajax({
				type: 'GET',
				dataType: 'json',
				url: 'acc/AccTrabajoTerminadoEnviarMensajeTexto.php',
				data: 'Mensaje=<?php echo $Mensaje;?>&Referencia=<?php echo $Referencia;?>&Celular=<?php echo $Celular;?>',
				success: function(resultado){
					
					switch(resultado['Respuesta']){
						case "1":
							
							$('#CapTrabajoTerminadoAccion').html(resultado['Mensaje']);
							window.setTimeout("window.close();",1500);
		
						break;
						
						case "2":
							
							$('#CapTrabajoTerminadoAccion').html(resultado['Mensaje']);
							window.setTimeout("window.close();",4500);
		
						break;
						
						case "3":
							
							$('#CapTrabajoTerminadoAccion').html(resultado['Mensaje']);
							window.setTimeout("window.close();",4500);
		
						break;
						
						case "4":
							
							$('#CapTrabajoTerminadoAccion').html(resultado['Mensaje']);
							window.setTimeout("window.close();",4500);
		
						break;
						
						default:
						
							$('#CapTrabajoTerminadoAccion').html('Ha ocurrido un error interno: '+resultado['Mensaje']);
							//setTimeout("window.close();",2500);
							
						break;
					}
					
											
				}
			});
			
		  
		}else{
			$('#CapTrabajoTerminadoAccion').html('Envio de mensaje de texto cancelado...');	
			window.setTimeout("window.close();",1500);
		}
		
});

															
	

});




</script>

<div id="CapTrabajoTerminadoAccion"></div>

</body>
</html>