<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

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

$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];
$GET_Nombre = $_GET['Nombre'];
$GET_Procesar = $_GET['Procesar'];
$GET_EnviarSUNAT = $_GET['EnviarSUNAT'];

require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');

$InsBoleta = new ClsBoleta();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de boleta
$InsBoleta->BolId = $GET_id;
$InsBoleta->BtaId = $GET_ta;
$InsBoleta->MtdObtenerBoleta();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FIRMAR XML</title>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<!--
Funciones Generales
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutFunciones();?>FncGeneral.js"></script>

</head>
<body>

<img src="../../imagenes/sunat.gif" alt="[SUNAT]" title="SUNAT" width="45" height="45" border="0" />
<img src="../../imagenes/cargando_sunat.gif" alt="[Cargando...]" title="Cargando..." width="80"  border="0" />

<script type="text/javascript">
$().ready(function() {

	$('#CapBoletaAccion').html('Firmando archivo xml...');	
	
	$.ajax({
		type: 'POST',		
		crossDomain: true,
		contentType: 'application/x-www-form-urlencoded',
		 xhrFields: { withCredentials: true },
		url: 'http://<?php echo $SistemaIpFacturador;?>:8090/FacturadorSunat/index.htm',
		data: '',
		complete: function(response) {
			
			//$('#CapBoletaAccion').html('Procesando...');	
			window.setTimeout("FncBoletaFirmarBajaXML();",5000);
			
		},
		success: function(respuesta){
								
		}
	});
	
});

function FncBoletaFirmarBajaXML(){
	
	<?php
	//20410705878-RA-20161104-4
	list ($ruc,$ti,$fecha,$cor) = explode("-",$GET_Nombre);;
	?>
	
	$.ajax({
		type: 'POST',		
		crossDomain: true,
		contentType: 'application/x-www-form-urlencoded',
		 xhrFields: { withCredentials: true },
		url: 'http://<?php echo $SistemaIpFacturador;?>:8090/FacturadorSunat/generarXml.htm',
		data: 'hddNumRuc=<?php echo $EmpresaCodigo;?>&hddTipDoc=RA&hddNumDoc=<?php echo $ti."-".$fecha."-".$cor;?>&hddNomArc=<?php echo $GET_Nombre;?>&hddEstArc=07',
		complete: function(response) {
	
			//window.setTimeout("window.close();",5000);
//			window.setTimeout("FncBoletaRecibirBajaZIP();",5000);
			

			<?php
			if($GET_EnviarSUNAT==1 or $GET_EnviarSUNAT=="1"){
			?>
				$('#CapBoletaAccion').html('Archivo xml firmado correctamente, se enviara a SUNAT...');	
				window.setTimeout("FncBoletaProcesarBajaXML();",5000);
			<?php	
			}else{
			?>	
				$('#CapBoletaAccion').html('Archivo xml firmado correctamente...');	
				window.setTimeout("window.close();",2500);
			<?php	
			}
			?>
			
			
		},
		success: function(respuesta){
			console.log("b");
								
		}
	});
	
}

function FncBoletaProcesarBajaXML(){
	
	FncPopUp('FrmBoletaProcesarBajaXML.php?Nombre=<?php echo $GET_Nombre;?>&Id=<?php echo $InsBoleta->BolId;?>&Ta=<?php echo $InsBoleta->BtaId;?>&Procesar=<?php echo $GET_Procesar?>&EnviarSUNAT=<?php echo $GET_EnviarSUNAT;?>&P=1',0,0,1,0,0,1,0,350,150);

}

</script>

<div id="CapBoletaAccion"></div>

</body>
</html>
