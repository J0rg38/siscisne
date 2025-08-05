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

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');

$InsPedidoCompra = new ClsPedidoCompra();

$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
$username = 'sistema@cyc.com.pe';
$password = '980767388';

$inbox = imap_open($hostname,$username,$password) or die('Ha fallado la conexión: ' . imap_last_error());
	
//	echo "Asunto: ";
//	echo 'FROM "scanepam@cyc.com.pe" SINCE "'.date("j").' '.date("F").' '.date("Y").'"';
//	echo "<br>";
//	$emails   = imap_search($inbox, 'FROM "jblanco@cyc.com.pe" SUBJECT "Informe Despacho" SINCE "'.date("j").' '.date("F").' '.date("Y").'"', SE_UID);
//	$emails = imap_search($inbox, 'FROM "jblanco@cyc.com.pe" SINCE "'.date("j").' '.date("F").' '.date("Y").'"');
echo "Asunto: ";
echo $imap = 'FROM "gcanepam@cyc.com.pe" SINCE "'.date("j").' '.date("F").' '.date("Y").'"';
echo "<br>";

echo "Buscnado en correo scanepam";
echo "<br>";
	
	$emails = imap_search($inbox, $imap);

//	if($emails === false){
//		echo "Buscnado en otro correo jblanco";
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
			//$mensaje = eregi_replace(" ","",$mensaje);
		
			echo "<h1>CORREO ".$count."</h1>";
			echo "<br>";
			echo "<b>ASUNTO:</b> ".$asunto;
			echo "<br>";
			echo "<b>MENSAJE:</b> ".$mensaje;	
			echo "<br>";	
			
			$asunto = strtoupper($asunto);
			
			
			
			$pos_orden = strpos($asunto, "PC-");
		
			$VarCorreoAutorizacion = "";
			$PedidoCompraId = "";
			
			if($pos_orden !== false){
				
				$PedidoCompraId = substr($asunto,$pos_orden,13);
				$VarCorreoAutorizacion = "SI";
			}else{
				$VarCorreoAutorizacion = "NO";
			}
			
			echo "<b>CORREO AUTORIZACION:</b> ".$VarCorreoAutorizacion;	
			echo "<br>";
			
			echo "<b>PEDIDO COMPRA:</b> ".$PedidoCompraId;	
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
			
			if(!empty($PedidoCompraId)){
				
				//MtdEditarPedidoCompraDato
				$InsPedidoCompra = new ClsPedidoCompra();
				
				
				if($InsPedidoCompra->MtdEditarPedidoCompraDato("PcoAprobado",(($VarRespuestaAutorizacion=="SI")?1:2),$PedidoCompraId)){
					echo "Se actualizado estado APROBADO";
					echo "<br>";
				}else{
					echo "No se pudo actualizar el estado APROBADO";
					echo "<br>";
				}
				
				if($InsPedidoCompra->MtdEditarPedidoCompraDato("PcoSolicitudAprobacionRespuesta",addslashes($MensajeOriginal),$PedidoCompraId)){
					echo "Se actualizado  la respuesta de aprobacion";
					echo "<br>";
				}else{
					echo "No se pudo actualizar  la respuesta de aprobacion";
					echo "<br>";
				}
				
			}
		
			
			/*		$attachments = array();
			
					// if any attachments found... 
					if(isset($structure->parts) && count($structure->parts))   {
						for($i = 0; $i < count($structure->parts); $i++)   {
							$attachments[$i] = array(
								'is_attachment' => false,
								'filename' => '',
								'name' => '',
								'attachment' => ''
							);
			
							if($structure->parts[$i]->ifdparameters)    {
								foreach($structure->parts[$i]->dparameters as $object)   {
									if(strtolower($object->attribute) == 'filename') {
										$attachments[$i]['is_attachment'] = true;
										$attachments[$i]['filename'] = $object->value;
									}
								}
							}
			
							if($structure->parts[$i]->ifparameters) {
								foreach($structure->parts[$i]->parameters as $object)  {
									if(strtolower($object->attribute) == 'name')  {
										$attachments[$i]['is_attachment'] = true;
										$attachments[$i]['name'] = $object->value;
									}
								}
							}
			
							if($attachments[$i]['is_attachment']){
								$attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i+1);
			
							   //  3 = BASE64 encoding 
								if($structure->parts[$i]->encoding == 3){ 
									$attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
								}
							   //  4 = QUOTED-PRINTABLE encoding 
								elseif($structure->parts[$i]->encoding == 4) { 
									$attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
								}
							}
						}
					}
			
					// iterate through each attachment and save it 
					foreach($attachments as $attachment){
						if($attachment['is_attachment'] == 1){
							$filename = $attachment['name'];
							if(empty($filename)) $filename = $attachment['filename'];
			
							if(empty($filename)) $filename = time() . ".dat";
							
							
		//					if(!is_dir($folder)){
		//						 mkdir($folder);
		//					}
							//$fp = fopen("./". $folder ."/". $email_number . "-" . $filename, "w+");
							//$fp = fopen("". $folder ."/". $email_number . "-" . $filename, "w+");
							
							$pos = strpos($filename, "Despacho");
		
							if ($pos === false) {
								
								
								//echo "La cadena '$findme' no fue encontrada en la cadena '$mystring'";
								
							}else {
								//echo "La cadena '$findme' fue encontrada en la cadena '$mystring'";
								//echo " y existe en la posición $pos";
								$folder = "attachment";
								$folder = $destino;
								
								$adjunto =  $destino."".$email_number . "-" . $filename;
								
								//Informe Despacho C y C del 07022017
								
								$nombre_archivos = explode(" ",$filename);
								
								$fecha_bruta = $nombre_archivos[6];
								
								$ano = substr($fecha_bruta,4,4);
								$mes = substr($fecha_bruta,2,2);
								$dia = substr($fecha_bruta,0,2);
								
								$FechaEncontradaDespacho = $dia."/".$mes."/".$ano;
								
								$fp = fopen("". $folder ."/". $email_number . "-" . $filename, "w+");	
								fwrite($fp, $attachment['attachment']);
								fclose($fp);
								
								if($FechaUltimoDespacho!=$FechaEncontradaDespacho){
									$TieneAdjuntoDespacho = true;
								}
								
							}
							
							
						}
					}*/
			
			$count++;
		}
		
	} 
	

	imap_close($inbox);
	
?>