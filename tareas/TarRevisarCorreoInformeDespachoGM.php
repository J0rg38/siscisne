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

echo "BUSCANDO INFORME DESPACHO";
echo "<br>";
echo "<br>";

$GET_Fecha = (empty($_GET['Fecha'])?date("d/m/Y"):$_GET['Fecha']);
$FechaCambiada  = FncCambiaFechaAMysql($GET_Fecha);



require_once($InsPoo->MtdPaqReporte().'ClsReporteOrdenCompraPorLlegar.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsPedidoCompraLlegada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsPedidoCompraLlegadaDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');
require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsPedidoCompraLlegada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsPedidoCompraLlegadaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteOrdenCompraPorLlegar.php');


$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoReemplazo = new ClsProductoReemplazo();

$InsReporteOrdenCompraPorLlegar = new ClsReporteOrdenCompraPorLlegar();
$InsPedidoCompraLlegadaDetalle = new ClsPedidoCompraLlegadaDetalle();

$InsCliente = new ClsCliente();

/*
VARIABLES
*/	
$Destinatarios = "jblanco@cyc.com.pe,aliendo@cyc.com.pe,iquezada@cyc.com.pe,scanepam@cyc.com.pe,anace@cyc.com.pe,pcondori@cyc.com.pe,dvercelone@cyc.com.pe,jmaquera@cyc.com.pe";
$FechaDespacho= "";

$FechaEncontradaDespacho = "";
$FechaUltimoDespacho = "";

//$InsPedidoCompraLlegada = new ClsPedidoCompraLlegada();
////MtdObtenerPedidoCompraLlegadas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'PleId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oOrdenCompra=NULL)
//$ResPedidoCompraLlegada = $InsPedidoCompraLlegada->MtdObtenerPedidoCompraLlegadas(NULL,NULL,NULL,"PleTiempoCreacion","DESC","1",NULL,NULL,NULL,NULL,NULL);
//$ArrPedidoCompraLlegadas = $ResPedidoCompraLlegada['Datos'];
//
////deb($ArrPedidoCompraLlegadas);
//if(!empty($ArrPedidoCompraLlegadas)){
//	foreach($ArrPedidoCompraLlegadas as $DatPedidoCompraLlegada){
//		
//		$FechaUltimoDespacho = $DatPedidoCompraLlegada->PleFecha;
//		//$TiempoDespacho = $DatPedidoCompraLlegada->PleTiempoCreacion;
////		list($FechaDespacho,$HoraDespacho ) = explode(" ",$TiempoDespacho);
//	
//	}
//}

//echo "Comparando ".$FechaDespacho." - ".date("d/m/Y");
//echo "<br>";
//
//if($FechaDespacho."" == date("d/m/Y")){
//
//	echo "Despacho ya se cargo el dia de hoy";
//	echo "<br>";
//
//}else{
		
	$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
	$username = 'sistema@cyc.com.pe';
	$password = '980767388';
	
	echo "FechaCambiada: ".$FechaCambiada;
	echo "<br>";

	$NuevaFecha = date("j F Y", strtotime($FechaCambiada));
	$NuevaFechaAux = date("d-m-Y", strtotime($FechaCambiada));

	//Incrementando 2 dias
	$mod_date = strtotime($NuevaFechaAux."+ 1 days");
	$NuevaFecha2 = date("j F Y",$mod_date) . "\n";

	$inbox = imap_open($hostname,$username,$password) or die('Ha fallado la conexión: ' . imap_last_error());
	
	echo "Asunto: ";
	//echo 'FROM "scanepam@cyc.com.pe" SINCE "'.date("j").' '.date("F").' '.date("Y").'"';
	//echo 'FROM "scanepam@cyc.com.pe" SUBJECT "Despacho" SINCE "'.$NuevaFecha.'" BEFORE "'.$NuevaFecha2.'"';
	
	$imap =  ' SUBJECT "Informe Despacho" SINCE "'.$NuevaFecha.'"';
	
	echo $imap;
	echo "<br>";
	
	//$emails   = imap_search($inbox, 'FROM "jblanco@cyc.com.pe" SUBJECT "Informe Despacho" SINCE "'.date("j").' '.date("F").' '.date("Y").'"', SE_UID);
//	$emails = imap_search($inbox, 'FROM "jblanco@cyc.com.pe" SINCE "'.date("j").' '.date("F").' '.date("Y").'"');
	//echo "Buscando en correo scanepam";
	//echo "<br>";
	//$emails = imap_search($inbox, 'FROM "scanepam@cyc.com.pe" SINCE "'.date("j").' '.date("F").' '.date("Y").'"');
	
	//$emails = imap_search($inbox, 'FROM "scanepam@cyc.com.pe" SUBJECT "Despacho" SINCE "'.$NuevaFecha.'"  BEFORE "'.$NuevaFecha2.'"');
	$emails = imap_search($inbox, $imap);
	
//	if($emails === false){
//		echo "Buscando en otro correo jblanco";
//		echo "<br>";
//		//$emails = imap_search($inbox, 'FROM "jblanco@cyc.com.pe" SUBJECT "Despacho" SINCE "'.$NuevaFecha.'"  BEFORE "'.$NuevaFecha2.'"');
//		$emails = imap_search($inbox, 'FROM "jblanco@cyc.com.pe" SUBJECT "Despacho" SINCE "'.$NuevaFecha.'"');
//	}
//	
//	
//	if($emails === false){
//		echo "Buscando en otro correo pcondori";
//		echo "<br>";
//		//$emails = imap_search($inbox, 'FROM "pcondori@cyc.com.pe" SUBJECT "Despacho" SINCE "'.$NuevaFecha.'" BEFORE "'.$NuevaFecha2.'"');
//		$emails = imap_search($inbox, 'FROM "pcondori@cyc.com.pe" SUBJECT "Despacho" SINCE "'.$NuevaFecha.'"');
//	}
//	
//	if($emails === false){
//		echo "Buscando en otro correo aliendo";
//		echo "<br>";
//		//$emails = imap_search($inbox, 'FROM "aliendo@cyc.com.pe" SUBJECT "Despacho" SINCE "'.$NuevaFecha.'"  BEFORE "'.$NuevaFecha2.'"');
//		$emails = imap_search($inbox, 'FROM "aliendo@cyc.com.pe" SUBJECT "Despacho" SINCE "'.$NuevaFecha.'"');
//	}
//	
//	if($emails === false){
//		echo "Buscando en otro correo iquezada";
//		echo "<br>";
//		//$emails = imap_search($inbox, 'FROM "iquezada@cyc.com.pe" SUBJECT "Despacho" SINCE "'.$NuevaFecha.'" BEFORE "'.$NuevaFecha2.'"');
//		$emails = imap_search($inbox, 'FROM "iquezada@cyc.com.pe" SUBJECT "Despacho" SINCE "'.$NuevaFecha.'"');
//	}

//deb($emails);
	echo "Correos encontrados: ".count($emails);
	echo "<br>";
	
	$ruta_total = "../subidos/pedidocomprallegada_excel/";
	$adjunto = "";
	
	//$TieneAdjuntoDespacho = false;
	
	$DespachoEncontrado = false;
	$RutaArchivoEncontrado = "";
	
	if($emails) {

		$count = 1;
		//put the newest emails on top 
		rsort($emails);
		//for every email... 
		foreach($emails as $email_number){
	
	
			// get information specific to this email 
			$overview = imap_fetch_overview($inbox,$email_number,0);	
			$message = imap_fetchbody($inbox,$email_number,2);
	
			// get mail structure 
			$structure = imap_fetchstructure($inbox, $email_number);	
			$asunto = $overview[0]->subject;
		
			echo "<h1>CORREO ".$count."</h1>";
			echo "ASUNTO: ".$asunto;
			echo "<br>";
	
			$attachments = array();
			
			echo "structure->parts: ".count($structure->parts);
			echo "<br>";
		
			// if any attachments found... 
			if(isset($structure->parts) && count($structure->parts))   {
				
				echo "if any attachments found... ";
				echo "<br>";
				
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

			echo "attachments: ".count($attachments);
			echo "<br>";

			// iterate through each attachment and save it 
			foreach($attachments as $attachment){
				
				echo "is_attachment: ".$attachment['is_attachment'];
				echo "<br>";
				echo "name: ".$attachment['name'];
				echo "<br>";

				if($attachment['is_attachment'] == 1){

					$filename = $attachment['name'];

					if(empty($filename)) $filename = $attachment['filename'];

					if(empty($filename)) $filename = time() . ".dat";

					$pos = strpos(strtoupper($filename), "DESPACHO");

					if ($pos === false) {
						
						echo "No se encontro Despacho";
						echo "<br>";
						//echo "La cadena '$findme' no fue encontrada en la cadena '$mystring'";
						
					}else {
						//echo "La cadena '$findme' fue encontrada en la cadena '$mystring'";
						//echo " y existe en la posición $pos";
						//$folder = "attachment";
						//$folder = $ruta_total;
						
						$adjunto =  $ruta_total."".$email_number . "-" . $filename;
						
						echo "adjunto: ".$adjunto;
						echo "<br>";
						
						//Informe Despacho C y C del 07022017						
						$nombre_archivos = explode(" ",$filename);

						$ArrAsuntos = explode(" ",$asunto);
						
						$FechaEncontradaDespacho = "";
						if(!empty($ArrAsuntos)){
							foreach($ArrAsuntos as $DatAsunto){
								
								$FechaEncontradaDespacho = $DatAsunto;
								
							}
						}
						
						$dia = substr($FechaEncontradaDespacho,0,2);
						$mes = substr($FechaEncontradaDespacho,2,2);
						$ano = substr($FechaEncontradaDespacho,4,4);

						$FechaEncontradaDespacho = $ano."-".$mes."-".$dia;

						echo "FechaEncontradaDespacho: ".$FechaEncontradaDespacho;
						echo "<br>";
						
						echo "dia: ".$dia;
						echo "<br>";
						echo "mes: ".$mes;
						echo "<br>";
						echo "ano: ".$ano;
						echo "<br>";
						
						echo "Comparando fechas ".$FechaCambiada." = ".$FechaEncontradaDespacho;
						echo "<br>";
						
						if($FechaCambiada == $FechaEncontradaDespacho){	
							
							//$fp = fopen("". $folder ."/". $email_number . "-" . $filename, "w+");	
							$fp = fopen("". $ruta_total ."/". $email_number . "-" . $filename, "w+");	
							fwrite($fp, $attachment['attachment']);
							fclose($fp);
							
//							$TieneAdjuntoDespacho = true;
							$DespachoEncontrado = true;
							$RutaArchivoEncontrado = $adjunto;
							
						}
						
						//if($FechaUltimoDespacho!=$FechaEncontradaDespacho){
//							$TieneAdjuntoDespacho = true;
//						}
						
					}
					
					
				}
			}
		
			$count++;
			
		}
		
	} 

	imap_close($inbox);
	
	echo "<br>";
	echo "Cerrando inbox...";
	echo "<br>";
	
	echo "FechaCambiada: ".$FechaCambiada;
	echo "<br>";
	//if($TieneAdjuntoDespacho){
	if($DespachoEncontrado){

		echo "<br>";
		
		//MtdObtenerOrdenCompraPorLLegar($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PldId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oPedidoCompraLlegada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oPedidoCompraDetalle=NULL,$oPedidoCompraLlegadaEstado =NULL) {
		$ResReporteOrdenCompraPorLlegar = $InsReporteOrdenCompraPorLlegar->MtdObtenerOrdenCompraPorLLegar(NULL,NULL,"PcdTiempoCreacion","DESC",1,NULL,NULL,NULL,NULL,($FechaCambiada),($FechaCambiada),NULL,NULL,1,NULL,"3,31");
		$ArrReporteOrdenCompraPorLlegar = $ResReporteOrdenCompraPorLlegar['Datos'];
	
		$PedidoCompraLlegadaDetalleId = "";
		
		if(!empty($ArrReporteOrdenCompraPorLlegar)){
			foreach($ArrReporteOrdenCompraPorLlegar as $DatReporteOrdenCompraPorLlegar){
				
				$PedidoCompraLlegadaDetalleId = $DatReporteOrdenCompraPorLlegar->PleId;
				
			}
		}
		
		echo "PedidoCompraLlegadaDetalleId: ".$PedidoCompraLlegadaDetalleId;
		echo "<br>";
		echo "<br>";
		
		if(empty($PedidoCompraLlegadaDetalleId)){
			
			$InsPedidoCompraLlegada = new ClsPedidoCompraLlegada();
			//$InsPedidoCompraLlegada->PleFecha = date("Y-m-d");
//			$InsPedidoCompraLlegada->PleFecha = FncCambiaFechaAMysql($FechaEncontradaDespacho);
			$InsPedidoCompraLlegada->PleFecha = ($FechaEncontradaDespacho);
			$InsPedidoCompraLlegada->PerId = NULL;
			$InsPedidoCompraLlegada->PleObservacion = "Despacho cargado automaticamente el ".date("d/m/Y H:i:s");
			$InsPedidoCompraLlegada->PleEstado = 3;
			$InsPedidoCompraLlegada->PleTiempoCreacion = date("Y-m-d H:i:s");
			$InsPedidoCompraLlegada->PleTiempoModificacion = date("Y-m-d H:i:s");
			
			$xlsx = new SimpleXLSX($RutaArchivoEncontrado ); 
			
			list($num_cols, $num_rows) = $xlsx->dimension(); 
			
			$fila = 0;
			$inicio_filaA = 0;
			$inicio_columnaA = 0;
			
			foreach( $xlsx->rows() as $r ) { 
			
				for( $columna = 0; $columna < $num_cols; $columna++ ) {
					
					//deb(strtoupper($r[$columna]));
					
					if( ($r[$columna]) == "Número de Parte" ){
						$inicio_columnaA = $columna;
						$inicio_filaA = $fila;
						break;
					}
			
				}
				
				$fila++;
			}
			
			//deb($inicio_columnaA ." - ".$inicio_filaA);
			
			$fila = 0;
			$inicio_filaB = 0;
			$inicio_columnaB = 0;
			
			foreach( $xlsx->rows() as $r ) { 
			
				for( $columna = 0; $columna < $num_cols; $columna++ ) {
			
					if( ($r[$columna]) == "Nombre de Pedido" ){
						$inicio_columnaB = $columna;
						$inicio_filaB = $fila;
						break;
					}
			
				}
				$fila++;
			}
			
			
			
			$fila = 0;
			$inicio_filaC = 0;
			$inicio_columnaC = 0;
			
			foreach( $xlsx->rows() as $r ) { 
			
				for( $columna = 0; $columna < $num_cols; $columna++ ) {
			
					if( ($r[$columna]) == "Unidades Facturadas" ){
						$inicio_columnaC = $columna;
						$inicio_filaC = $fila;
						break;
					}
			
				}
				$fila++;
			}
			
			
			$fila = 0;
			$inicio_filaD = 0;
			$inicio_columnaD = 0;
			
			foreach( $xlsx->rows() as $r ) { 
			
				for( $columna = 0; $columna < $num_cols; $columna++ ) {
			
					if( ($r[$columna]) == "Factura Electrónica" ){
						$inicio_columnaD = $columna;
						$inicio_filaD = $fila;
						break;
					}
			
				}
				$fila++;
			}
			
			
			$fila = 0;
			$inicio_filaE = 0;
			$inicio_columnaE = 0;
			
			foreach( $xlsx->rows() as $r ) { 
			
				for( $columna = 0; $columna < $num_cols; $columna++ ) {
			
					if( ($r[$columna]) == "Fecha de Factura" ){
						$inicio_columnaE = $columna;
						$inicio_filaE = $fila;
						break;
					}
			
				}
				$fila++;
			}
			
			$fila = 0;
			$inicio_filaF = 0;
			$inicio_columnaF = 0;
			
			foreach( $xlsx->rows() as $r ) { 
			
				for( $columna = 0; $columna < $num_cols; $columna++ ) {
			
					if( ($r[$columna]) == "Total" or ($r[$columna]) == "TOTAL" ){
						$inicio_columnaF = $columna;
						$inicio_filaF = $fila;
						break;
					}
			
				}
				$fila++;
			}
			
			$fila = 0;
			$inicio_filaG = 0;
			$inicio_columnaG = 0;
			
			foreach( $xlsx->rows() as $r ) { 
			
				for( $columna = 0; $columna < $num_cols; $columna++ ) {
			
					if( ($r[$columna]) == "Descripción" ){
						$inicio_columnaG = $columna;
						$inicio_filaG = $fila;
						break;
					}
			
				}
				$fila++;
			}
			
			$fila = 0;
			$inicio_filaH = 0;
			$inicio_columnaH = 0;
			
			foreach( $xlsx->rows() as $r ) { 
			
				for( $columna = 0; $columna < $num_cols; $columna++ ) {
			
					if( ($r[$columna]) == "Guia Remisión" ){
						$inicio_columnaH = $columna;
						$inicio_filaH = $fila;
						break;
					}
			
				}
				$fila++;
			}
			
			$fila = 0;
			$inicio_filaI = 0;
			$inicio_columnaI = 0;
			
			foreach( $xlsx->rows() as $r ) { 
			
				for( $columna = 0; $columna < $num_cols; $columna++ ) {
			
					if( ($r[$columna]) == "Despacho" ){
						$inicio_columnaI = $columna;
						$inicio_filaI = $fila;
						break;
					}
			
				}
				$fila++;
			}
			
			$fila = 0;
			$inicio_filaJ = 0;
			$inicio_columnaJ = 0;
			
			foreach( $xlsx->rows() as $r ) { 
			
				for( $columna = 0; $columna < $num_cols; $columna++ ) {
			
					if( ($r[$columna]) == "Observación" ){
						$inicio_columnaJ = $columna;
						$inicio_filaJ = $fila;
						break;
					}
			
				}
				$fila++;
			}				
			
			
			$ProductoCodigoOriginalImportado = "";
			$OrdenCompraId = "";
			$PedidoCompraLlegadaDetalleCantidad = 0;
			$ProductoNombre = "";
			
			$GuiaRemisionNumero = "";
			$GuiaRemisionFecha = "";
			
			$ComprobanteNumero = "";
			$ComprobanteFecha = "";
			$Observacion = "";				
			
			$Importe = 0;
			
			$fila = 1;
			
			foreach( $xlsx->rows() as $r ) { 
			
				$ProductoCodigoOriginalImportado = "";
				$OrdenCompraId = "";
				$PedidoCompraLlegadaDetalleCantidad = 0;
				$ProductoNombre = "";
				
				$GuiaRemisionNumero = "";
				$GuiaRemisionFecha = "";
				
				$ComprobanteNumero = "";
				$ComprobanteFecha = "";
				$Observacion = "";	
			
					for( $columna=0; $columna < $num_cols; $columna++ ) {
			
						if($columna == $inicio_columnaA){
							$ProductoCodigoOriginalImportado  =  trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
						}
						
						if($columna == $inicio_columnaB){
							$OrdenCompraId  = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
						}
						
						if($columna == $inicio_columnaC){
							$PedidoCompraLlegadaDetalleCantidad = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
						}
						
						if($columna == $inicio_columnaD){
							$ComprobanteNumero = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							//$ComprobanteNumero = substr ($ComprobanteNumero,5);
							//$ComprobanteNumero = "004-".$ComprobanteNumero;
						}
						
						if($columna == $inicio_columnaE){
							$ComprobanteFecha = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							
							$ComprobanteFechaDia = substr ($ComprobanteFecha,6,2);
							$ComprobanteFechaMes = substr ($ComprobanteFecha,4,2);
							$ComprobanteFechaAno = substr ($ComprobanteFecha,0,4);
							
							$ComprobanteFecha = $ComprobanteFechaAno."-".$ComprobanteFechaMes."-".$ComprobanteFechaDia;
						}
			
						if($columna == $inicio_columnaF){
			
							$Importe = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							
						}
						
						if($columna == $inicio_columnaG){
			
							$ProductoNombre = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							
						}
						
						if($columna == $inicio_columnaH){
			
							$GuiaRemisionNumero = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							
						}
											
						if($columna == $inicio_columnaI){
			
							$GuiaRemisionFecha = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
			
						}
						
						if($columna == $inicio_columnaJ){
			
							$Observacion = trim(( (!empty($r[$columna])) ? $r[$columna] : '' ));	
							
						}
			
					}
					
					echo "[Fila ".$fila."]>";
					echo "<br>";
					
					if(!empty($ProductoCodigoOriginalImportado) and !empty($OrdenCompraId) and !empty($PedidoCompraLlegadaDetalleCantidad)){
						
						$EncontroCodigo = false;
						//$EncontroReemplazo = false;
						//$RegistroNuevoProducto = false;
			
						$InsOrdenCompra = new ClsOrdenCompra();
						$InsOrdenCompra->OcoId = $OrdenCompraId;
						$InsOrdenCompra->MtdObtenerOrdenCompra();
			
						if(!empty($InsOrdenCompra->OrdenCompraPedido)){
							foreach($InsOrdenCompra->OrdenCompraPedido as $DatOrdenCompraPedido){
			
								$InsPedidoCompra = new ClsPedidoCompra();
								$InsPedidoCompra->PcoId = $DatOrdenCompraPedido->PcoId;
								$InsPedidoCompra->MtdObtenerPedidoCompra();
			
								if(!empty($InsPedidoCompra->PedidoCompraDetalle)){
									foreach($InsPedidoCompra->PedidoCompraDetalle as $DatPedidoCompraDetalle){
										
										//deb($DatPedidoCompraDetalle->PcdCantidadPendiente."aas");
										//if($ProductoCodigoOriginalImportado == trim($DatPedidoCompraDetalle->ProCodigoOriginal) and $DatPedidoCompraDetalle->PcdCantidadPendiente>0){
										if( $ProductoCodigoOriginalImportado == trim($DatPedidoCompraDetalle->ProCodigoOriginal) ){												
											
											if($DatPedidoCompraDetalle->PcdCantidadPendiente<$PedidoCompraLlegadaDetalleCantidad){
												$PedidoCompraLlegadaDetalleCantidad = $PedidoCompraLlegadaDetalleCantidad - $DatPedidoCompraDetalle->PcdCantidadPendiente;
											}
			
											$InsPedidoCompraLlegadaDetalle1 = new ClsPedidoCompraLlegadaDetalle();	
											$InsPedidoCompraLlegadaDetalle1->PcdId = $DatPedidoCompraDetalle->PcdId;
											$InsPedidoCompraLlegadaDetalle1->ProId = $DatPedidoCompraDetalle->ProId;
											
											$InsPedidoCompraLlegadaDetalle1->PldOrdenCompraId = $OrdenCompraId;
											$InsPedidoCompraLlegadaDetalle1->PldOrdenCompraFecha = NULL;
											
											$InsPedidoCompraLlegadaDetalle1->PldCantidad = $PedidoCompraLlegadaDetalleCantidad;		
											$InsPedidoCompraLlegadaDetalle1->PldCantidadEntregada = $PedidoCompraLlegadaDetalleCantidad;		
											$InsPedidoCompraLlegadaDetalle1->PldComprobanteNumero = $ComprobanteNumero;			
											$InsPedidoCompraLlegadaDetalle1->PldComprobanteFecha = $ComprobanteFecha;	
											
											$InsPedidoCompraLlegadaDetalle1->PldGuiaRemisionNumero = $GuiaRemisionNumero;			
											$InsPedidoCompraLlegadaDetalle1->PldGuiaRemisionFecha = FncCambiaFechaAMysql($GuiaRemisionFecha);		
																
											$InsPedidoCompraLlegadaDetalle1->PldImporte = $Importe;		
											$InsPedidoCompraLlegadaDetalle1->PldObservacion = $Observacion;									
			
											$InsPedidoCompraLlegadaDetalle1->PldEstado = 1;									
											$InsPedidoCompraLlegadaDetalle1->PldTiempoCreacion = date("Y-m-d H:i:s");
											$InsPedidoCompraLlegadaDetalle1->PldTiempoModificacion = date("Y-m-d H:i:s");					
											$InsPedidoCompraLlegadaDetalle1->PldEliminado = 1;
											
											$InsPedidoCompraLlegada->PedidoCompraLlegadaDetalle[] = $InsPedidoCompraLlegadaDetalle1;
			?>
			
			<span class="EstImportarFila">
			
			<b>Producto:</b> <?php echo $DatPedidoCompraDetalle->ProCodigoOriginal;?> - <?php echo $DatPedidoCompraDetalle->ProNombre;?><br />
			<b>Orden Venta:</b> <?php echo $InsPedidoCompra->VdiId;?> - <?php echo $InsPedidoCompra->CliNombre;?><br />
			<b>O.C. Ref.: </b> <?php echo $InsPedidoCompra->VdiOrdenCompraNumero;?>
			
			</span>
			
			<br />
			<br />
			
			<?php										
											$EncontroCodigo = true;
											//break;
										}
										
			
									} 
								}
								
							}
							
						}
			
						if(!$EncontroCodigo){
							
							echo "No se pudo encontrar el codigo original ".$ProductoCodigoOriginalImportado.", se buscara codigos de reemplazo en la lista...";
							echo "<br>";
			
							//BUSCANDO REEMPLAZOS								
							$InsProductoReemplazo = new ClsProductoReemplazo();
							$ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10,PreCodigo11,PreCodigo12","esigual",$ProductoCodigoOriginalImportado ,"PreId","ASC",NULL,"1");
							$ArrProductoReemplazos = $ResProductoReemplazo['Datos'];
			
							//REEMPLAZOS ENCONTRADOS
							if(!empty($ArrProductoReemplazos)){
								
								echo "Se encontro posible codigo de reemplazo";
								echo "<br>";
											
								$ReemplazoConfirmado = false;
								$PedidoCompraDetalleId = "";
												
								$VentaDirectaId = "";
								$ClienteNombre = "";
								$VentaDirectaOrdenCompraNumero = "";
								$ProductoNombre  = "";
								$ProductoCodigoOriginal = "";
			
								$InsOrdenCompra = new ClsOrdenCompra();
								$InsOrdenCompra->OcoId = $OrdenCompraId;
								$InsOrdenCompra->MtdObtenerOrdenCompra();
			
								if(!empty($InsOrdenCompra->OrdenCompraPedido)){
									foreach($InsOrdenCompra->OrdenCompraPedido as $DatOrdenCompraPedido){
			
										$InsPedidoCompra = new ClsPedidoCompra();
										$InsPedidoCompra->PcoId = $DatOrdenCompraPedido->PcoId;
										$InsPedidoCompra->MtdObtenerPedidoCompra();
			
										if(!empty($InsPedidoCompra->PedidoCompraDetalle)){
											foreach($InsPedidoCompra->PedidoCompraDetalle as $DatPedidoCompraDetalle){
												
												foreach($ArrProductoReemplazos as $DatProductoReemplazo){
												
													  if(
													  $DatProductoReemplazo->PreCodigo1 == $DatPedidoCompraDetalle->ProCodigoOriginal or
													  $DatProductoReemplazo->PreCodigo2 == $DatPedidoCompraDetalle->ProCodigoOriginal or
													  $DatProductoReemplazo->PreCodigo3 == $DatPedidoCompraDetalle->ProCodigoOriginal or
													  $DatProductoReemplazo->PreCodigo4 == $DatPedidoCompraDetalle->ProCodigoOriginal or
													  $DatProductoReemplazo->PreCodigo5 == $DatPedidoCompraDetalle->ProCodigoOriginal or
													  $DatProductoReemplazo->PreCodigo6 == $DatPedidoCompraDetalle->ProCodigoOriginal or
													  $DatProductoReemplazo->PreCodigo7 == $DatPedidoCompraDetalle->ProCodigoOriginal or
													  $DatProductoReemplazo->PreCodigo8 == $DatPedidoCompraDetalle->ProCodigoOriginal or
													  $DatProductoReemplazo->PreCodigo9 == $DatPedidoCompraDetalle->ProCodigoOriginal or
													  $DatProductoReemplazo->PreCodigo10 == $DatPedidoCompraDetalle->ProCodigoOriginal 
													  
													  ){
														
														$ReemplazoConfirmado = true;
														$PedidoCompraDetalleId = $DatPedidoCompraDetalle->PcdId;
														$VentaDirectaId =  $InsPedidoCompra->VdiId;
														$ClienteNombre = $InsPedidoCompra->CliNombre." ".$InsPedidoCompra->CliApellidoPaterno." ".$InsPedidoCompra->CliApellidoMaterno;
														$VentaDirectaOrdenCompraNumero = $InsPedidoCompra->VdiOrdenCompraNumero;
														$ProductoNombre = $DatPedidoCompraDetalle->ProNombre;
														$ProductoCodigoOriginal = $DatPedidoCompraDetalle->ProCodigoOriginal;
														
														break;
														 
													  }
												
												}
												
											}
										}
										
									}
								}
			
								if($ReemplazoConfirmado){
			?>					
									<span class="EstImportarRegistrarNo">Codigo de reemplazo identificado <?php echo $ProductoCodigoOriginalImportado;?> </span><br />
			
			<?php
									$InsProducto = new ClsProducto();
									$ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$ProductoCodigoOriginalImportado,'ProId','Desc',"1",NULL,NULL,1,NULL,NULL,NULL,NULL,false);
									$ArrProductos = $ResProducto['Datos'];
			
									$ProductoId = "";
			
									if(empty($ArrProductos)){
			
			?>
										<span class="EstImportarRegistrarSi">No se encontro el codigo de reemplazo registrado en sistema, se procedera a registrar automaticamente... </span><br />
			
			<?php
										$InsProducto = new ClsProducto();
										$InsProducto->UsuId = $_SESSION['SesionId'];
										$InsProducto->ProCodigoAlternativo = "";
										$InsProducto->ProCodigoOriginal = $ProductoCodigoOriginalImportado;
										$InsProducto->ProNombre = $ProductoNombre;
										$InsProducto->ProUbicacion = "-";
										$InsProducto->ProReferencia = "Producto registrado automaticamente por despacho ".date("d/m/Y");
										$InsProducto->ProEspecificacion = "";
										
										$InsProducto->UmeId = "UME-10007";
										$InsProducto->UmeIdIngreso = "UME-10007";
									
										$InsProducto->ProCodigoBarra = $ProductoCodigoOriginalImportado;
										$InsProducto->ProStockMinimo = 1;
										$InsProducto->ProValidarUso = 1;
									
										$InsProducto->ProPeso = 0;
																	
										$InsProducto->ProLargo= 0;
										$InsProducto->ProAncho = 0;
										$InsProducto->ProAlto = 0;
										$InsProducto->ProVolumen = 0;
			
			
			
															$InsProducto->RtiId = "RTI-10000";	
															$InsProducto->ProFoto = "";
															$InsProducto->ProValidarStock = 1;	
															$InsProducto->ProTienePromocion = 2;	
										$InsProducto->ProCalcularPrecio = 2;	
										
															$InsProducto->ProEstado = 1;	
															$InsProducto->ProTiempoCreacion = date("Y-m-d H:i:s");
															$InsProducto->ProTiempoModificacion = date("Y-m-d H:i:s");
															$InsProducto->ProEliminado = 1;
			
			
			
			$Disponible = 0;
			$Cantidad = 0;
			
			if(!empty($InsProducto->ProCodigoOriginal)){
			
			$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
			$ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",trim($InsProducto->ProCodigoOriginal) ,"PdiId","ASC","1",1);
			$ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
			
			//$Disponibilidad = "";
			if(!empty($ArrProductoDisponibilidades)){
			foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
			
				$Disponible =  ($DatProductoDisponibilidad->PdiDisponible);
				$Cantidad =  ($DatProductoDisponibilidad->PdiCantidad);
			
			}
			}
			
			}
			
			$InsProducto->ProTieneDisponibilidadGM = $Disponible;
			$InsProducto->ProDisponibilidadCantidadGM = $Cantidad;
			
			
			$Reemplazo = "NO";
			
			if(!empty($InsProducto->ProCodigoOriginal)){
			
			$ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10,PreCodigo11,PreCodigo12","esigual",trim($InsProducto->ProCodigoOriginal) ,"PreId","ASC",NULL,1);
			$ArrProductoReemplazos = $ResProductoReemplazo['Datos'];
			
			if(!empty($ArrProductoReemplazos)){
			$Reemplazo= "SI";
			}
			
			}
			
			$InsProducto->ProTieneReemplazoGM = $Reemplazo;
			$InsProducto->ProCritico = 2;		
			$InsProducto->ProDescontinuado = 2;
			
			
										if($InsProducto->MtdRegistrarProducto()){
			
											$ProductoId = $InsProducto->ProId;
			?>
											<span class="EstImportarRegistrarSi">Se registro correctamente el producto nuevo</span><br />
			
			<?php
										}else{
			?>																
											<span class="EstImportarRegistrarNo">No se pudo registrar el producto nuevo. PROCESO CANCELADO </span><br />
			
			<?php
										}
			
									}else{
										
										foreach($ArrProductos as $DatProducto){
											
											$ProductoId  = $DatProducto->ProId;
											
										}
									
									}
																
									if(!empty($ProductoId)){
			
										$InsPedidoCompraLlegadaDetalle1 = new ClsPedidoCompraLlegadaDetalle();	
										$InsPedidoCompraLlegadaDetalle1->PcdId = $PedidoCompraDetalleId;
										$InsPedidoCompraLlegadaDetalle1->ProId = $ProductoId;
										$InsPedidoCompraLlegadaDetalle1->PldCantidad = $PedidoCompraLlegadaDetalleCantidad;	
										$InsPedidoCompraLlegadaDetalle1->PldCantidadEntregada = $PedidoCompraLlegadaDetalleCantidad;	
										
										$InsPedidoCompraLlegadaDetalle1->PldComprobanteNumero = $ComprobanteNumero;			
										$InsPedidoCompraLlegadaDetalle1->PldComprobanteFecha = $ComprobanteFecha;	
										$InsPedidoCompraLlegadaDetalle1->PldImporte = $Importe;
										
										$InsPedidoCompraLlegadaDetalle1->PldEstado = 1;									
										$InsPedidoCompraLlegadaDetalle1->PldTiempoCreacion = date("Y-m-d H:i:s");
										$InsPedidoCompraLlegadaDetalle1->PldTiempoModificacion = date("Y-m-d H:i:s");					
										$InsPedidoCompraLlegadaDetalle1->PldEliminado = 1;
										
										$InsPedidoCompraLlegada->PedidoCompraLlegadaDetalle[] = $InsPedidoCompraLlegadaDetalle1;
										
			?>
										<span class="EstImportarFila">
																   
										<b>Producto:</b> <?php echo $ProductoCodigoOriginal;?> reemplazado por <?php echo $ProductoCodigoOriginalImportado;?> - <?php echo $ProductoNombre;?><br />
										<b>Orden Venta:</b> <?php echo $VentaDirectaId;?> - <?php echo $ClienteNombre;?><br />
										<b>O.C. Ref.: </b> <?php echo $VentaDirectaOrdenCompraNumero;?>
										
										</span>
			
										<br />
										<br />
			
			<?php
									}
			
								}else{
									
									echo "Codigo de reemplazo NO identificado ".$ProductoCodigoOriginalImportado.". PROCESO CANCELADO";
								
									$InsProducto = new ClsProducto();
									$ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$ProductoCodigoOriginalImportado,'ProId','Desc',"1",NULL,NULL,1,NULL,NULL,NULL,NULL,false);
									$ArrProductos = $ResProducto['Datos'];
			
									$ProductoId = "";
									
									if(empty($ArrProductos)){
			
										$InsProducto = new ClsProducto();
										$InsProducto->ProCodigoAlternativo = "";
										$InsProducto->ProCodigoOriginal = $ProductoCodigoOriginalImportado;
										$InsProducto->ProNombre = "CODIGO NO IDENTIFICADO";
										$InsProducto->ProUbicacion = "-";
										$InsProducto->ProReferencia = "Producto registrado automaticamente por despacho ".date("d/m/Y");
										$InsProducto->ProEspecificacion = "";
										
										$InsProducto->UmeId = "UME-10007";
										$InsProducto->UmeIdIngreso = "UME-10007";
									
										$InsProducto->ProCodigoBarra = $ProductoCodigoOriginalImportado;
										$InsProducto->ProStockMinimo = 1;
										$InsProducto->ProValidarUso = 1;
									
										$InsProducto->ProPeso = 0;
																	
										$InsProducto->ProLargo= 0;
										$InsProducto->ProAncho = 0;
										$InsProducto->ProAlto = 0;
										$InsProducto->ProVolumen = 0;
			
										$InsProducto->RtiId = "RTI-10000";	
										$InsProducto->ProFoto = "";
										$InsProducto->ProValidarStock = 1;	
										
										$InsProducto->ProTienePromocion = 2;	
										$InsProducto->ProCalcularPrecio = 2;	
										
												$InsProducto->ProCritico = 2;		
			$InsProducto->ProDescontinuado = 2;
			
										$InsProducto->ProEstado = 1;	
										$InsProducto->ProTiempoCreacion = date("Y-m-d H:i:s");
										$InsProducto->ProTiempoModificacion = date("Y-m-d H:i:s");
										$InsProducto->ProEliminado = 1;
															
										if($InsProducto->MtdRegistrarProducto()){
			
											$ProductoId = $InsProducto->ProId;
			?>
											<span class="EstImportarRegistrarSi">Se registro correctamente el producto nuevo</span><br />
			
			<?php
										}else{
			?>																
											<span class="EstImportarRegistrarNo">No se pudo registrar el producto nuevo. PROCESO CANCELADO </span><br />
			
			<?php
										}
										
									}
										
									  if(!empty($ProductoId)){
										  
										  $InsPedidoCompraLlegadaDetalle1 = new ClsPedidoCompraLlegadaDetalle();	
										  $InsPedidoCompraLlegadaDetalle1->PcdId = NULL;
										  $InsPedidoCompraLlegadaDetalle1->ProId = $ProductoId;
										  
										  $InsPedidoCompraLlegadaDetalle1->PldOrdenCompraId = $OrdenCompraId;
										  $InsPedidoCompraLlegadaDetalle1->PldOrdenCompraFecha = NULL;
										  
										  $InsPedidoCompraLlegadaDetalle1->PldCantidad = $PedidoCompraLlegadaDetalleCantidad;			
										  $InsPedidoCompraLlegadaDetalle1->PldCantidadEntregada = $PedidoCompraLlegadaDetalleCantidad;			
										  $InsPedidoCompraLlegadaDetalle1->PldComprobanteNumero = $ComprobanteNumero;			
										  $InsPedidoCompraLlegadaDetalle1->PldComprobanteFecha = $ComprobanteFecha;						
										  $InsPedidoCompraLlegadaDetalle1->PldImporte = $Importe;									
			
										  $InsPedidoCompraLlegadaDetalle1->PldEstado = 1;									
										  $InsPedidoCompraLlegadaDetalle1->PldTiempoCreacion = date("Y-m-d H:i:s");
										  $InsPedidoCompraLlegadaDetalle1->PldTiempoModificacion = date("Y-m-d H:i:s");					
										  $InsPedidoCompraLlegadaDetalle1->PldEliminado = 1;
										  
										  $InsPedidoCompraLlegada->PedidoCompraLlegadaDetalle[] = $InsPedidoCompraLlegadaDetalle1;
										  
									  }
									  
										
										
										
					
								}
												
							}
			
						}
			
					}else{
						
						echo "No se pudo registrar, codigo original u orden de compra no identificada";
						echo "<br>";
			
					}
					
			
				 $fila++;
			} 
			
			if(!empty($InsPedidoCompraLlegada->PedidoCompraLlegadaDetalle)){
				
				if($InsPedidoCompraLlegada->MtdRegistrarPedidoCompraLlegada()){
					
					echo " Se registro la llegada de repuestos.";
					echo "<br>";
			
				}else{
					echo " No se pudo registrar la llegada de repuestos.";
					echo "<br>";
			
				}
				
			}
				
		}else{
			echo "El informe ya se encuentra registrado.";
			echo "<br>";
		}
				
	}
	
	echo "<hr>";

///    public function MtdObtenerOrdenCompraPorLLegar($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PldId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oPedidoCompraLlegada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oPedidoCompraDetalle=NULL,$oPedidoCompraLlegadaEstado =NULL)
	$ResReporteOrdenCompraPorLlegar = $InsReporteOrdenCompraPorLlegar->MtdObtenerOrdenCompraPorLLegar(NULL,NULL,"PcdTiempoCreacion","DESC",1,NULL,NULL,NULL,NULL,($FechaCambiada),($FechaCambiada),NULL,NULL,1,NULL,"3");
	$ArrReporteOrdenCompraPorLlegar = $ResReporteOrdenCompraPorLlegar['Datos'];

	$PedidoCompraLlegadaDetalleId = "";
	
	if(!empty($ArrReporteOrdenCompraPorLlegar)){
		foreach($ArrReporteOrdenCompraPorLlegar as $DatReporteOrdenCompraPorLlegar){
			$PedidoCompraLlegadaDetalleId = $DatReporteOrdenCompraPorLlegar->PleId;
		}
	}
	
	//echo "PedidoCompraLlegadaDetalleId: ".$PedidoCompraLlegadaDetalleId;
	//echo "<br>";
	
	//deb($PedidoCompraLlegadaDetalleId);
	
	if(($PedidoCompraLlegadaDetalleId) != ""){
		
		echo "Enviar correo...";
		echo "<br>";

		$InsPedidoCompraLlegada->MtdActualizarEstadoPedidoCompraLlegada($PedidoCompraLlegadaDetalleId,"31");
	
		///$Destinatarios = "jblanco@cyc.com.pe";
		if($InsPedidoCompraLlegada->MtdEnviarDespachoPedidoCompraLlegada($Destinatarios,$PedidoCompraLlegadaDetalleId,NULL,NULL, "SISTEMA")){		
			
		}
		
	}else{
		
		echo "No enviar correo...";
		echo "<br>";
		
	}
	

//}


	
?>