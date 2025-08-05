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


require_once($InsProyecto->MtdRutLibrerias().'excel/OLERead.php');
require_once($InsProyecto->MtdRutLibrerias().'excel/reader.php');
require_once($InsProyecto->MtdRutLibrerias().'simplexlsx.class.php');



echo "BUSCANDO CADENAS DE REEMPLAZO";
echo "<br>";
echo "<br>";

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');

$InsProducto = new ClsProducto();
$InsProductoReemplazo = new ClsProductoReemplazo();



$FechaReemplazo = "";
$ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos(NULL,NULL,NULL ,"PreId","ASC","1",1);
$ArrProductoReemplazos = $ResProductoReemplazo['Datos'];

if(!empty($ArrProductoReemplazos)){
	foreach($ArrProductoReemplazos as $DatProductoReemplazo){
		
		$TiempoReemplazo = $DatProductoReemplazo->PreTiempoCreacion;
		list($FechaReemplazo,$HoraReemplazo ) = explode(" ",$TiempoReemplazo);

	}
}
	
echo "Comparando ".$FechaReemplazo." - ".date("d/m/Y");
echo "<br>";

if($FechaReemplazo."-" == date("d/m/Y")){
	
	echo "Cadena de reemplazos ya se cargo el dia de hoy";
	echo "<br>";
	
}else{
		
	$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
	$username = 'sistema@cyc.com.pe';
	$password = '980767388';
	
	$inbox = imap_open($hostname,$username,$password) or die('Ha fallado la conexión: ' . imap_last_error());
	
	echo "Asunto: ";
	echo 'FROM "scanepam@cyc.com.pe" SINCE "'.date("j").' '.date("F").' '.date("Y").'"';
	echo "<br>";
	
		//$emails   = imap_search($inbox, 'FROM "jblanco@cyc.com.pe" SUBJECT "Informe Despacho" SINCE "'.date("j").' '.date("F").' '.date("Y").'"', SE_UID);
//	$emails = imap_search($inbox, 'FROM "jblanco@cyc.com.pe" SINCE "'.date("j").' '.date("F").' '.date("Y").'"');
	echo "Buscnado en correo scanepam";
	echo "<br>";
	$emails = imap_search($inbox, 'FROM "scanepam@cyc.com.pe" SINCE "'.date("j").' '.date("F").' '.date("Y").'"');
	
	if($emails === false){
		echo "Buscnado en otro correo jblanco";
		echo "<br>";
		$emails = imap_search($inbox, 'FROM "jblanco@cyc.com.pe" SINCE "'.date("j").' '.date("F").' '.date("Y").'"');
	}
	
	
	if($emails === false){
		echo "Buscnado en otro correo pcondori";
		echo "<br>";
		$emails = imap_search($inbox, 'FROM "pcondori@cyc.com.pe" SINCE "'.date("j").' '.date("F").' '.date("Y").'"');
	}
	
	
	
	if($emails === false){
		echo "Buscnado en otro correo aliendo";
		echo "<br>";
		$emails = imap_search($inbox, 'FROM "aliendo@cyc.com.pe" SINCE "'.date("j").' '.date("F").' '.date("Y").'"');
	}
	
	if($emails === false){
		echo "Buscnado en otro correo iquezada";
		echo "<br>";
		$emails = imap_search($inbox, 'FROM "iquezada@cyc.com.pe" SINCE "'.date("j").' '.date("F").' '.date("Y").'"');
	}
	
	
	
	
	echo "Correos encontrados: ".count($emails);
	echo "<br>";
	
	
	$destino = "../subidos/producto_excel/";
	$adjunto = "";
	$TieneAdjuntoDespacho = false;
	
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
			$structure = imap_fetchstructure($inbox, $email_number);
	
			$asunto = $overview[0]->subject;
		
			echo "<h1>CORREO ".$count."</h1>";
			echo "ASUNTO: ".$asunto;
	
			$attachments = array();
	
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
					
					$pos = strpos($filename, "Reemplazo");

					if ($pos === false) {
						
						//echo "La cadena '$findme' no fue encontrada en la cadena '$mystring'";
						
					}else {
						//echo "La cadena '$findme' fue encontrada en la cadena '$mystring'";
						//echo " y existe en la posición $pos";
						$folder = "attachment";
						$folder = $destino;
						
						$adjunto =  $destino."".$email_number . "-" . $filename;
						
						$fp = fopen("". $folder ."/". $email_number . "-" . $filename, "w+");	
						fwrite($fp, $attachment['attachment']);
						fclose($fp);
						
						$TieneAdjuntoDespacho = true;
						
					}
					
					
				}
			}
			
			$count++;
		}
		
	} 

	imap_close($inbox);
	
	
	if($TieneAdjuntoDespacho){
		
		echo "Procesando archivo...";
		echo "<br>";
		
		$InsProductoReemplazo = new ClsProductoReemplazo();
		
		//if(!$InsProductoReemplazo->MtdEliminarTodoProductoReemplazo()){
//			echo "No se pudo vaciar la tabla de cadenas de reemplazo.";
//			echo "<br>";
//		}
		
		echo "Leyendo...";				
		echo $descargar;
		echo "<br>";
		$xlsx = new SimpleXLSX($adjunto); 
		
		list($num_cols, $num_rows) = $xlsx->dimension(); 
		
		$fila = 0;
		$inicio_fila = 0;
		
		$inicio_columna = 0;
		
		foreach( $xlsx->rows() as $r ) { 
		
			for( $i = 0; $i < $num_cols; $i++ ) {
		
				if( strtoupper($r[$i]) == "MATERIAL ANTIGUO" ){
					$inicio_columna = $i;
					$inicio_fila = $fila;
					break;
				}
		
			}
			$fila++;
		}
		
		$fila = 1;
		foreach( $xlsx->rows() as $r ) { 
		
			if($inicio_fila <= $fila){
				
				$InsProductoReemplazo = new ClsProductoReemplazo();
				
				for( $i=0; $i < $num_cols; $i++ ) {
					
					if($i==$inicio_columna){
						$InsProductoReemplazo->PreCodigo1  = ( (!empty($r[$i])) ? $r[$i] : '' );
						$InsProductoReemplazo->PreCodigo1 = trim($InsProductoReemplazo->PreCodigo1);		
					}
					
					if($i == $inicio_columna + 1){
						$InsProductoReemplazo->PreCodigo2  = ( (!empty($r[$i])) ? $r[$i] : '' );
						$InsProductoReemplazo->PreCodigo2 = trim($InsProductoReemplazo->PreCodigo2);	
					}
				
					if($i == $inicio_columna + 2){
						$InsProductoReemplazo->PreCodigo3  = ( (!empty($r[$i])) ? $r[$i] : '' );
						$InsProductoReemplazo->PreCodigo3 = trim($InsProductoReemplazo->PreCodigo3);		
					}
					
					if($i == $inicio_columna + 3){
						$InsProductoReemplazo->PreCodigo4  = ( (!empty($r[$i])) ? $r[$i] : '' );
						$InsProductoReemplazo->PreCodigo4 = trim($InsProductoReemplazo->PreCodigo4);		
					}
					
					
					if($i == $inicio_columna + 4){
						$InsProductoReemplazo->PreCodigo5  = ( (!empty($r[$i])) ? $r[$i] : '' );	
						$InsProductoReemplazo->PreCodigo5 = trim($InsProductoReemplazo->PreCodigo5);
					}
					
					
					if($i == $inicio_columna + 5){
						$InsProductoReemplazo->PreCodigo6  = ( (!empty($r[$i])) ? $r[$i] : '' );	
						$InsProductoReemplazo->PreCodigo6 = trim($InsProductoReemplazo->PreCodigo6);
					}
					
					if($i == $inicio_columna + 6){
						$InsProductoReemplazo->PreCodigo7  = ( (!empty($r[$i])) ? $r[$i] : '' );
						$InsProductoReemplazo->PreCodigo7 = trim($InsProductoReemplazo->PreCodigo7);	
					}
					
					if($i == $inicio_columna + 7){
						$InsProductoReemplazo->PreCodigo8  = ( (!empty($r[$i])) ? $r[$i] : '' );	
						$InsProductoReemplazo->PreCodigo8 = trim($InsProductoReemplazo->PreCodigo8);
					}
					
					if($i == $inicio_columna + 8){
						$InsProductoReemplazo->PreCodigo9  = ( (!empty($r[$i])) ? $r[$i] : '' );
						$InsProductoReemplazo->PreCodigo9 = trim($InsProductoReemplazo->PreCodigo9);	
					}
					
					if($i == $inicio_columna + 9){
						$InsProductoReemplazo->PreCodigo10  = ( (!empty($r[$i])) ? $r[$i] : '' );	
						$InsProductoReemplazo->PreCodigo10 = trim($InsProductoReemplazo->PreCodigo10);	
					}		
		
				}
				
				$InsProductoReemplazo->PreEstado = 1;
				$InsProductoReemplazo->PreTiempoCreacion = date("Y-m-d H:i:s");
				
				if(!empty($InsProductoReemplazo->PreCodigo1)){
		
					if($InsProductoReemplazo->MtdRegistrarProductoReemplazo()){
						echo "[Fila".$fila."]> ".$InsProductoReemplazo->PreCodigo1.", Se registro correctamente.";
						echo "<br>";
					}else{
						echo "[Fila".$fila."]> ".$InsProductoReemplazo->PreCodigo1.", No se pudo registrar.";
						echo "<br>";
					}
								
				}else{
		
					echo "[Fila".$fila."]> ".$InsProductoReemplazo->PreCodigo1.", No se pudo registrar, codigo vacio";
					echo "<br>";
		
				}
			
		
			}
			 $fila++;
		} 
		
					
					
	}
	
	
	
	
	
}
	
?>