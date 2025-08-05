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


//require_once('../librerias/nusoap-0.9.5/lib/nusoap.php');
require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');
//require_once('../librerias/JSON2.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON.php');

require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');


require_once($InsProyecto->MtdRutLibrerias().'fpdf17/fpdf.php');

//50.62.8.12
$client = new nusoap_client('http://50.62.8.123/ventas/webservice/WsVentaDirecta.php?wsdl','wsdl');

$err = $client->getError();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

</head>

<body>
<?php

$GET_Accion = $_GET['Accion'];

$client = new nusoap_client('http://50.62.8.123/ventas/webservice/WsVentaDirecta.php?wsdl','wsdl');

$err = $client->getError();

if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}



require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaTalonario.php');

$FechaInicio = "01/01/".date("Y");
$FechaFin = date("d/m/Y");

$InsFactura = new ClsFactura();
//MtdObtenerFacturas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oCredito=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oDiaVencer=NULL,$oPagado=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL,$oTieneCodigoExterno=NULL) {
	
$ResFactura = $InsFactura->MtdObtenerFacturas(NULL,NULL,NULL,"FacFechaEmision","DESC","10",NULL,5,FncCambiaFechaAMysql($FechaInicio),FncCambiaFechaAMysql($FechaFin),NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1);
$ArrFacturas = $ResFactura['Datos'];

$TotalComprobantes = 0;

$fila = 1;
if(!empty($ArrFacturas)){
	foreach($ArrFacturas as $DatFactura){
		
		$Respuesta  = 0;
		
		echo "[Fila ".$fila."]>";		
		echo "Id Local: ".$DatFactura->FtaNumero."-".$DatFactura->FacId."<br />";
		echo "Fecha Local: ".$DatFactura->FacFechaEmision."<br />";
		echo "Talonario Id: ".$DatFactura->FtaId."<br />";
		echo "Comision: ".$DatFactura->FacPorcentajeComision."<br />";
		echo "Cliente Id: ".$DatFactura->CliId."<br />";
		
			$Trama['Fecha'] = $DatFactura->FacFechaEmision;
			$Trama['Numero'] = $DatFactura->FtaNumero."-".$DatFactura->FacId;
			$Trama['Cliente'] = $DatFactura->CliNombre." ".$DatFactura->CliApellidoPaterno." ".$DatFactura->CliApellidoMaterno;
			$Trama['MonedaId'] = $DatFactura->MonId;
			$Trama['TipoCambio'] = $DatFactura->FacTipoCambio;

			$Trama['SubTotal'] = $DatFactura->FacSubTotal;
			$Trama['Impuesto'] = $DatFactura->FacImpuesto;
			$Trama['Total'] = $DatFactura->FacTotal;
			
			$Trama['PorcentajeComision'] = $DatFactura->FacPorcentajeComision;
			$Trama['Pagado'] = $DatFactura->FacCancelado;
			$Trama['CodigoExterno'] = $DatFactura->VdiCodigoExterno;
			$Trama['Estado'] = $DatFactura->FacEstado;
						
			$Trama['FacturaId'] = $DatFactura->FacId;
			$Trama['FacturaTalonarioId'] = $DatFactura->FtaId;
			
			$param = array(	
				'oTrama' => json_encode($Trama)			
			);
//			
			//$Aux = json_encode($Trama);
//			$Array = json_decode($Aux);
			//deb($Array);
			
			//deb($Array->Fecha);
			$Respuesta = $client->call('MtdRecibirComprobantes', $param);
			
			echo "RESPUESTA: ".$Respuesta;
			echo "<br>";

			switch($Respuesta ){
				
				case 1:
				
				break;
				
				case 2:
				
				break;
				
				case 3:
				
				break;
				
				case 4:
				
				break;
			}
//			
		echo "<br>";
		$TotalComprobantes++;
?>

<?php		
		$fila++;
	}
	
}else{
?>
No se encontraron comprobantes<br />
<?php	
}
	
?>






------------------------------------------<br />
Comprobantes: <?php echo $TotalComprobantes;?><br />
<br />

------------------------------------------<br />
Proceso Terminado<br />
<?php echo date("d/m/Y H:i:s")?><br />
------------------------------------------<br />


</body>
</html>
