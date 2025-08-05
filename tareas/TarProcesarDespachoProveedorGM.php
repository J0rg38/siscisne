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






require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaTarea.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaFoto.php');
$InsOrdenCompra = new ClsOrdenCompra();

$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
$username = 'sistema@cyc.com.pe';
$password = '980767388';


$inbox = imap_open($hostname,$username,$password) or die('Ha fallado la conexión: ' . imap_last_error());


$emails = imap_search($inbox,'FROM "chevrolet.carperu@gm.com"');
if($emails) {
  $salida = '';
  foreach($emails as $email_number) {    
    	
		$mensaje = "";
		$asunto = "";
		$mensaje_original = "";
		
		$overview = imap_fetch_overview($inbox,$email_number,0);
		//$mensaje = imap_fetchbody($inbox,$email_number,3);
		
		$mensaje = get_part($inbox, $email_number, "TEXT/PLAIN"); 
		$mensaje_original = $mensaje;
		
		$mensaje = strtoupper($mensaje);
		$mensaje = eregi_replace(" ","",$mensaje);
		
		$asunto = $overview[0]->subject;
		$asunto = eregi_replace(" ","",$asunto);
		$asunto = eregi_replace(":","",$asunto);		
		$asunto = eregi_replace("RE","",$asunto);
		$asunto = eregi_replace("PEDIDO","",$asunto);
//
//$cadena_de_texto = 'Esta es la frase donde haremos la búsqueda';
//$cadena_buscada   = 'la';
//$posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);
		
		//IDENTIFICADO ORDEN
		$pos_orden = strpos($asunto, "CYC-");
		
		if($pos_orden !== false){
			
			$pos1 = strpos($mensaje, "OCPROCESADA");
			$pos2 = strpos($mensaje, "SUPEDIDOHASIDOPROCESADO");
			$pos3 = strpos($mensaje, "SUPEDIDOHASIDOPROCESADA");
			
			if($pos1>0 or $pos2>0 or $pos3>0){
				
				echo "Orden detectada: ".$asunto;
				echo "<br>";
				
				$InsOrdenCompra->OcoId = $asunto;
				$InsOrdenCompra->MtdObtenerOrdenCompra(true);
				
				//if($InsOrdenCompra->OcoProcesadoProveedor == 2 or 1 == 1){
				if($InsOrdenCompra->OcoProcesadoProveedor == 2){
					
					echo "Orden por procesar";	
					echo "<br>";
					
					$InsOrdenCompra->MtdEditarOrdenCompraDato("OcoProcesadoProveedor",1,$InsOrdenCompra->OcoId);
					$InsOrdenCompra->MtdEditarOrdenCompraDato("OcoRespuestaProveedor",$mensaje_original,$InsOrdenCompra->OcoId);
					
					if(!empty($InsOrdenCompra->OrdenCompraPedido)){
						foreach($InsOrdenCompra->OrdenCompraPedido as $DatOrdenCompraPedido){
							
							if(!empty($DatOrdenCompraPedido->VdiId)){
								
								if(!empty($DatOrdenCompraPedido->CliId)){
									
									$InsCliente = new ClsCliente();
									$InsCliente->CliId = $DatOrdenCompraPedido->CliId;
									$InsCliente->MtdObtenerCliente(false);
									
									$Destinatarios = (!empty($InsCliente->CliEmail)?','.$InsCliente->CliEmail:'').(!empty($InsCliente->CliContactoEmail1)?','.$InsCliente->CliContactoEmail1:'').(!empty($InsCliente->CliContactoEmail2)?','.$InsCliente->CliContactoEmail2:'').(!empty($InsCliente->CliContactoEmail3)?','.$InsCliente->CliContactoEmail3:'');
					
					//MtdNotificarVentaDirectaMensaje($oVentaDirecta,$oDestinatario,$oTitulo,$oMensaje)
									
									//$Destinatarios = "";									
									$InsVentaDirecta = new ClsVentaDirecta();
									$InsVentaDirecta->MtdNotificarVentaDirectaMensaje($DatOrdenCompraPedido->VdiId,$Destinatarios.",jblanco@cyc.com.pe,scanepam@cyc.com.pe","ORDEN PROCESADA","Su orden ha sido procesado correctamente");
									
									break;
									
								}
								
							}
							
						}
					}
					
				}else{
					echo "Orden ignorada";	
					echo "<br>";
				}
				
				
//				echo $asunto;
//				echo "<br>";
//				//MtdActualizarEstadoOrdenCompra($oElementos,$oEstado)
				
			}
		
		}


	
  }  
 
} 
imap_close($inbox);

?>