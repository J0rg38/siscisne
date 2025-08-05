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



echo "BUSCANDO DISPONIBILIDAD";
echo "<br>";
echo "<br>";

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');

$InsProducto = new ClsProducto();
$InsProductoDisponibilidad = new ClsProductoDisponibilidad();



$FechaDisponibilidad = "";

$ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades(NULL,NULL,NULL ,"PdiId","ASC","1",1);
$ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];

if(!empty($ArrProductoDisponibilidades)){
	foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
		
		$TiempoDisponibilidad = $DatProductoDisponibilidad->PdiTiempoCreacion;
		list($FechaDisponibilidad,$HoraReemplazo ) = explode(" ",$TiempoDisponibilidad);
	
	}
}


	
echo "Comparando ".$FechaDisponibilidad." - ".date("d/m/Y");
echo "<br>";

if($FechaDisponibilidad."" == date("d/m/Y")){
	
	echo "Disponibilidad ya se cargo el dia de hoy";
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
					
					$pos = strpos($filename, "Disponibilidad");

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
		
	
		
						$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
						
						//if(!$InsProductoDisponibilidad->MtdEliminarTodoProductoDisponibilidad()){
//							echo "No se pudo vaciar la tabla de disponibilidad.";
//							echo "<br>";
//						}
				
					
						echo "Leyendo...";				
						echo $descargar;
						echo "<br>";
							$xlsx = new SimpleXLSX($adjunto); 
		
						list($num_cols, $num_rows) = $xlsx->dimension(); 
		
						$fila = 0;
						$inicio_fila = 0;
						$inicio_columna = 0;
						
						echo "Columnas: ";
						echo $num_cols;
						echo "<br>";
						echo "Filas: ";
						echo $num_rows;
						echo "<br>";

						foreach( $xlsx->rows() as $r ) { 
							
							//deb($r);
							
							for( $i = 0; $i < $num_cols; $i++ ) {
								
								if( strtoupper($r[$i]) == "MATERIAL NUMBER" ){
									$inicio_columna = $i;
									$inicio_fila = $fila;
									break;
								}
		
							}
							
							
							$fila++;
						}

						echo "Ubicacion: ".$inicio_columna." - ".$inicio_fila;
						echo "<br>";
		
						$fila = 1;
						foreach( $xlsx->rows() as $r ) { 
							
							if($inicio_fila <= $fila){
								
								$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
								
								for( $i=0; $i < $num_cols; $i++ ) {
							
									if($i==$inicio_columna){
										$InsProductoDisponibilidad->PdiCodigo  = ( (!empty($r[$i])) ? $r[$i] : '' );
										$InsProductoDisponibilidad->PdiCodigo = trim($InsProductoDisponibilidad->PdiCodigo);	
									}
									
									if($i == $inicio_columna + 1){
										$InsProductoDisponibilidad->PdiNombre  = ( (!empty($r[$i])) ? $r[$i] : '' );	
										$InsProductoDisponibilidad->PdiNombre = trim($InsProductoDisponibilidad->PdiNombre);
									}
									
									if($_POST['CmpTipo']=="1"){
		
										if($i == $inicio_columna + 2){
											$InsProductoDisponibilidad->PdiCantidad  = ( (!empty($r[$i])) ? $r[$i] : '' );	
											
											if($InsProductoDisponibilidad->PdiCantidad>0){
												$InsProductoDisponibilidad->PdiDisponible = 1;
											}else{
												$InsProductoDisponibilidad->PdiDisponible = 2;
											}	
		
										}
																	
									}else{
										
										if($i == $inicio_columna + 2){
											
											$InsProductoDisponibilidad->PdiDisponible  = ( (!empty($r[$i])) ? $r[$i] : '' );	
											
											$InsProductoDisponibilidad->PdiDisponible = substr($InsProductoDisponibilidad->PdiDisponible, 0, 1);
											
											if(strtoupper($InsProductoDisponibilidad->PdiDisponible) == "S"){
												$InsProductoDisponibilidad->PdiDisponible = 1;
												
											}else if(strtoupper($InsProductoDisponibilidad->PdiDisponible) == "N"){
												$InsProductoDisponibilidad->PdiDisponible = 2;			
																
											}else{
												$InsProductoDisponibilidad->PdiDisponible = 0;
											}
											
										}
		
										$InsProductoDisponibilidad->PdiCantidad = 0;
		
									}
									
		
								
								}
								
		
								
								$InsProductoDisponibilidad->PdiEstado = 1;
								$InsProductoDisponibilidad->PdiTiempoCreacion = date("Y-m-d H:i:s");
								
								if(!empty($InsProductoDisponibilidad->PdiCodigo)){
						
									if($InsProductoDisponibilidad->MtdRegistrarProductoDisponibilidad()){
										echo "[Fila".$fila."]> ".$InsProductoDisponibilidad->PdiCodigo.", Se registro correctamente.";
										echo "<br>";
									}else{
										echo "[Fila".$fila."]> ".$InsProductoDisponibilidad->PdiCodigo.", No se pudo registrar.";
										echo "<br>";
									}
												
								}else{
									
									echo "[Fila".$fila."]> , No se pudo registrar, codigo vacio";
										echo "<br>";
						
								}
							
								
					
							
							}
							
							
							 $fila++;
						}
				
		
					
					
	}
	
	
	
	
}
	
?>