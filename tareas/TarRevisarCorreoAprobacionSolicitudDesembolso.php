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


require_once($InsProyecto->MtdRutLibrerias().'excel/OLERead.php');
require_once($InsProyecto->MtdRutLibrerias().'excel/reader.php');
require_once($InsProyecto->MtdRutLibrerias().'simplexlsx.class.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');

echo "BUSCANDO APROBACION DE PEDIDO DE COMPRA";
echo "<br>";
echo "<br>";


require_once($InsPoo->MtdPaqLogistica().'ClsSolicitudDesembolso.php');

$InsSolicitudDesembolso = new ClsSolicitudDesembolso();

	$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
	$username = 'sistema@cyc.com.pe';
	$password = '980767388';
	
	$inbox = imap_open($hostname,$username,$password) or die('Ha fallado la conexión: ' . imap_last_error());
	
//	echo "Asunto: ";
//	echo 'FROM "gcanepam@cyc.com.pe" SINCE "'.date("j").' '.date("F").' '.date("Y").'"';
//	echo "<br>";
//	$emails   = imap_search($inbox, 'FROM "jblanco@cyc.com.pe" SUBJECT "Informe Despacho" SINCE "'.date("j").' '.date("F").' '.date("Y").'"', SE_UID);
//	$emails = imap_search($inbox, 'FROM "jblanco@cyc.com.pe" SINCE "'.date("j").' '.date("F").' '.date("Y").'"');

	echo "Asunto: ";
	echo "Buscando en correo gcanepam";
	echo "<br>";

	//$imap =  'FROM "gcanepam@cyc.com.pe" SINCE "'.date("j").' '.date("F").' '.date("Y").'"';
	$imap =  'SINCE "'.date("j").' '.date("F").' '.date("Y").'"';
	
	$emails = imap_search($inbox, $imap);
	//$emails = imap_search($inbox, 'FROM "jblanco@cyc.com.pe" SINCE "'.date("j").' '.date("F").' '.date("Y").'"');

//	if($emails === false){
//		echo "Buscando en otro correo jblanco";
//		echo "<br>";
//		$emails = imap_search($inbox, 'FROM "jblanco@cyc.com.pe" SINCE "'.date("j").' '.date("F").' '.date("Y").'"');
//	}
	
	
//deb($emails);
	echo "Correos encontrados: ".count($emails);
	echo "<br>";
	
//	$destino = "../subidos/pedidocomprallegada_excel/";
//	$adjunto = "";
//	$TieneAdjuntoDespacho = false;
//	
	if($emails) {

		$count = 1;
	  //   put the newest emails on top 
		rsort($emails);
	
	   //  for every email... 
		foreach($emails as $email_number){
	
			// get information specific to this email 
			$overview = imap_fetch_overview($inbox,$email_number,0);
	
			$message = imap_fetchbody($inbox,$email_number,2);
	
			// get mail structure 
			$structure = imap_fetchstructure($inbox, $c);
	
			$asunto = $overview[0]->subject;
			
			//$mensaje = imap_fetchbody($inbox,$email_number, 1.2);
		//	$mensaje = quoted_printable_decode(imap_fetchbody($inbox,$email_number,1.2)); 
			$mensaje = imap_fetchbody($inbox,$email_number,1.2);
			if(!strlen($bodyText)>0){
				$mensaje = imap_fetchbody($inbox,$email_number,1);
			}
			
			$MensajeOriginal = $mensaje;
			
			//$mensaje = get_part($inbox, $email_number, "TEXT/PLAIN"); 
			//$mensaje_original = $mensaje;
			//$mensaje = strtoupper($mensaje);
			//$mensaje = preg_replace("/ /", "", $mensaje);
		
			echo "<h1>CORREO ".$count."</h1>";
			echo "<br>";
			echo "<b>ASUNTO:</b> ".$asunto;
			echo "<br>";
			echo "<b>MENSAJE:</b> ".$mensaje;	
			echo "<br>";	
			
			$asunto = strtoupper($asunto);
			
			$pos_orden = strpos($asunto, "SDS-");
		
			$VarCorreoAutorizacion = "";
			$SolicitudDesembolsoId = "";
			
			if($pos_orden !== false){
				$SolicitudDesembolsoId = substr($asunto,$pos_orden,9);
				$VarCorreoAutorizacion = "SI";
			}else{
				$VarCorreoAutorizacion = "NO";
			}
			
			echo "<b>CORREO AUTORIZACION:</b> ".$VarCorreoAutorizacion;	
			echo "<br>";
			
			echo "<b>SOLICITUD DE DESEMBOLSO:</b> ".$SolicitudDesembolsoId;	
			echo "<br>";
			
			
			$mensaje = strtoupper($mensaje);
			
			$pos_orden = strpos($mensaje, "OK");
			
			$VarRespuestaAutorizacion = "";
			
			if($pos_orden !== false){
				$VarRespuestaAutorizacion = "SI";	
			}else{
				$VarRespuestaAutorizacion = "NO";	
			}
			
			echo "<b>CORREO RESPUESTA:</b> ".$Respuesta;	
			echo "<br>";
			
			if(!empty($SolicitudDesembolsoId)){
				
				//MtdEditarSolicitudDesembolsoDato
				$InsSolicitudDesembolso = new ClsSolicitudDesembolso();
				
				if($InsSolicitudDesembolso->MtdEditarSolicitudDesembolsoDato("SdsAprobado",(($VarRespuestaAutorizacion=="SI")?1:2),$SolicitudDesembolsoId)){
					echo "Se actualizado estado APROBADO";
					echo "<br>";
				}else{
					echo "No se pudo actualizar el estado APROBADO";
					echo "<br>";
				}
				
				if($InsSolicitudDesembolso->MtdEditarSolicitudDesembolsoDato("SdsSolicitudAprobacionRespuesta",addslashes($MensajeOriginal),$SolicitudDesembolsoId)){
					echo "Se actualizado  la respuesta de aprobacion";
					echo "<br>";
				}else{
					echo "No se pudo actualizar  la respuesta de aprobacion";
					echo "<br>";
				}
				
			}
			
			$count++;
		}
		
	} 
	

	imap_close($inbox);
	
?>