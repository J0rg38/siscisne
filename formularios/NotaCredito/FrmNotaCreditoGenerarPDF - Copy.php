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

//require_once($InsProyecto->MtdRutLibrerias().'fpdf181/fpdf.php');
require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');
require_once($InsProyecto->MtdRutLibrerias().'TCPDF-master/config/tcpdf_config.php');
require_once($InsProyecto->MtdRutLibrerias().'TCPDF-master/tcpdf.php');
//require_once($InsProyecto->MtdRutLibrerias().'phpqrcode/qrlib.php');
require_once($InsProyecto->MtdRutLibrerias().'TCPDF-master/tcpdf_barcodes_2d.php');


$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];
$GET_TiempoImpresion = $_GET['TiempoImpresion'];

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');
//
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');

$InsNotaCredito = new ClsNotaCredito();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//echo "adsfadfs";
//Obteniendo datos de factura
$InsNotaCredito->NcrId = $GET_id;
$InsNotaCredito->NctId = $GET_ta;
$InsNotaCredito = $InsNotaCredito->MtdObtenerNotaCredito();

$NOMBRE = $EmpresaCodigo.'-07-'.$InsNotaCredito->NctNumero.'-'.$InsNotaCredito->NcrId;



if($InsNotaCredito->MonId<>$EmpresaMonedaId){
	
	$InsNotaCredito->NcrTotalGravado = round($InsNotaCredito->NcrTotalGravado/$InsNotaCredito->NcrTipoCambio,2);
	$InsNotaCredito->NcrTotalExonerado = round($InsNotaCredito->NcrTotalExonerado/$InsNotaCredito->NcrTipoCambio,2);
	$InsNotaCredito->NcrTotalGratuito = round($InsNotaCredito->NcrTotalGratuito/$InsNotaCredito->NcrTipoCambio,2);
	$InsNotaCredito->NcrTotalDescuento = round($InsNotaCredito->NcrTotalDescuento/$InsNotaCredito->NcrTipoCambio,2);
	
	$InsNotaCredito->NcrTotalPagar = round($InsNotaCredito->NcrTotalPagar/$InsNotaCredito->NcrTipoCambio,2);
	$InsNotaCredito->NcrTotalDescuento = round($InsNotaCredito->NcrTotalDescuento/$InsNotaCredito->NcrTipoCambio,2);
	
	$InsNotaCredito->NcrSubTotal = round($InsNotaCredito->NcrSubTotal/$InsNotaCredito->NcrTipoCambio,2);	
	$InsNotaCredito->NcrImpuesto = round($InsNotaCredito->NcrImpuesto/$InsNotaCredito->NcrTipoCambio,2);
	$InsNotaCredito->NcrTotal = round($InsNotaCredito->NcrTotal/$InsNotaCredito->NcrTipoCambio,2);	
	
}
	
switch($InsNotaCredito->NcrTipo){
	
	case "2": //FACTURA
		$TipoDocumento = "Factura";
	break;
	
	case "3"://BOLETA
		$TipoDocumento = "Boleta";
	break;
	
}

/*
GENERAR CODIGO QR
*/
//$ArchivoNotaCreditoCodigoQR = $InsNotaCredito->NctNumero."-".$InsNotaCredito->NcrId.'_QR.png'; 
//$RutaNotaCreditoCodigoQR = "../../generados/comprobantes/".$ArchivoNotaCreditoCodigoQR; 
//// generating 
//if (!file_exists($RutaNotaCreditoCodigoQR)) { 
//  QRcode::png($InsNotaCredito->NctNumero."-".$InsNotaCredito->NcrId, $RutaNotaCreditoCodigoQR); 
//}
//     
//    echo 'Server PNG File: '.$pngAbsoluteFilePath; 
//    echo '<hr />'; 
//     
//    // displaying 
//    echo '<img src="'.$urlRelativeFilePath.'" />'; 
//    
	

//class PDF extends FPDF
//{
//// Cabecera de página
//function Header()
//{
//    // Logo
//    $this->Image('../../imagenes/logotipo.png',10,8,33);
//    // Arial bold 15
//    $this->SetFont('Arial','B',15);
//    // Movernos a la derecha
//    $this->Cell(80);
//    // Título
//  //  $this->Cell(30,10,'Title',1,0,'C');
////    // Salto de línea
//    $this->Ln(10);
//}
//
//// Pie de página
//function Footer()
//{
////     Posición: a 1,5 cm del final
//     $this->SetY(-15);
//    // Arial italic 8
//    $this->SetFont('Arial','B',8);
//    // Número de página
//    //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
//	//$this->Cell(0,10,"Su comprobante electronico podra ser consultado en nuestra pagina web http://www.cyc.com.pe/comprobantes",0,0,'L');
//	
//	
//	
//}
//}

$lineas = 0;

class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		global $lineas;
		global $EmpresaNombre;
		global $EmpresaCodigo;
		global $EmpresaDireccion;
		global $EmpresaProvincia;
		global $EmpresaDistrito;
		global $EmpresaDepartamento;
		global $InsNotaCredito;
		global $EmpresaTelefono;
		
		// Logo
		$image_file = '../../imagenes/comprobantes/comprobante_logotipo.png';
		$this->Image($image_file, 10, 10, 115, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		//$this->SetFont('helvetica', 'B', 20);
		// Title
		//$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		
		//
		
		//$this->SetLeftMargin(10);
		
//		$this->SetFont('times', 'B', 10);
//		$this->Cell(5,5,'',$lineas,0,'C',0);
		$this->SetFont('times', 'B', 12);
		$this->Cell(8,5,"",$lineas,0,'C',0);
		
			$this->SetFont('times', 'B', 10);
			$this->Cell(70,5,"R.U.C.: ".$EmpresaCodigo,$lineas,1,'C',0);
//		
		
		$this->SetFont('times', '', 10);
		$this->Cell(45,5,'',$lineas,0,'C',0);
		
		$this->SetFont('times', '', 6);
		$this->Cell(85,5,"",$lineas,0,'C',0);


		$this->SetFont('times', 'B', 10);
		$this->Cell(70,5,"NOTA DE CREDITO ELECTRONICA",$lineas,1,'C');

		$this->SetFont('times', '', 10);
		$this->Cell(45,5,'',$lineas,0,'C',0);
		$this->SetFont('times', '', 6);
		$this->Cell(85,5,"",$lineas,0,'C');
//		
//		
			$this->SetFont('times', 'B', 10);
			$this->Cell(70,5,"N°. ".$InsNotaCredito->NctNumero."-".$InsNotaCredito->NcrId,$lineas,1,'C');
			
			
		$this->SetFont('times', '', 10);
		$this->Cell(45,5,'',$lineas,0,'C',0);
		$this->SetFont('times', '', 6);
		$this->Cell(75,5,"",$lineas,0,'C');
		
		
//		
//		
//		$this->SetFont('times', 'B', 8);
//		$this->Cell(50,5,$EmpresaTelefono,$lineas,1,'C');




	}

	// Page footer
	public function Footer() {
		
		global $lineas;
		global $InsNotaCredito;
		// Position at 15 mm from bottom
		
		
		
		
		$this->SetY(-15);
		// Set font
		//$this->SetFont('helvetica', 'I', 8);
		// Page number
		///$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		
		//$image_file = '../../imagenes/logotipo.png';
//		$this->Image($image_file, 10, 10, 45, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
//		
//
//		$html = '
//		<table align="center">
//			<tr> 
//			<td style="width:150px; padding: 2px; text-align:left;"><img src="'.$RutaNotaCreditoCodigoQR.'" border="0" align="top" alt="Nexnet" /></td>
//			</td>
//			</tr>
//		</table>
//		';
//		$this->writeHTML($html, true, false, true, false, '');
//		
		
		
		//$this->SetFont('times', 'B', 10);
		//$this->Cell(10,5,"",$lineas,0,'L');
		//$this->Cell(190,5,"Su comprobante electronico podra ser consultado en nuestra pagina web http://www.cyc.com.pe/comprobantes",$lineas,1,'L');
		
	//	
//		$style = array(
//			'border' => 1,
//			'vpadding' => '1',
//			'hpadding' => '1',
//			'fgcolor' => array(0,0,0),
//			'bgcolor' => false, //array(255,255,255)
//			'module_width' => 1, // width of a single module in points
//			'module_height' => 1 // height of a single module in points
//		);
//		
//		$this->write2DBarcode($InsNotaCredito->NctNumero."-".$InsNotaCredito->NcrId, 'QRCODE', 0, 0, 0, 30, $style, 'N');
		
	}
}


$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf = new TCPDF();

//$pdf->SetHeaderData('logotipo.png', PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));

// set document information
$pdf->SetCreator($EmpresaNombre);
$pdf->SetAuthor($EmpresaNombre);
$pdf->SetTitle($InsNotaCredito->NctNumero."-".$InsNotaCredito->NcrId);
$pdf->SetSubject("Nota de Credito Electronica");
$pdf->SetKeywords($EmpresaNombre);

//// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
//
//// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//
//// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//
//// set margins
$pdf->SetMargins(0, 55, 0);
//$pdf->SetHeaderMargin(15);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->AddPage();
//
//$pdf->SetFont('times', 'B', 10);
//$pdf->Cell(100,5,$EmpresaNombre,$lineas,0,'C');
//
//	$pdf->SetFont('times', 'B', 12);
//	$pdf->Cell(90,5,"R.U.C.: ".$EmpresaCodigo,$lineas,1,'C');
//
//
//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(100,5,$EmpresaDireccion,$lineas,0,'C');
//
//	$pdf->SetFont('times', 'B', 12);
//	$pdf->Cell(90,5,"NOTA DE CREDITO ELECTRONICA",$lineas,1,'C');
//
//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(100,5,$EmpresaProvincia." ".$EmpresaDistrito." ".$EmpresaDepartamento,$lineas,0,'C');
//
//
//	$pdf->SetFont('times', 'B', 12);
//	$pdf->Cell(90,5,"No. ".$InsNotaCredito->NctNumero."-".$InsNotaCredito->NcrId,$lineas,1,'C');
//
//
//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(100,5,$EmpresaTelefono,$lineas,1,'C');


//$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 4, 'color' => array(255, 0, 0)));
//$pdf->SetFillColor(255,255,128);
//$pdf->SetTextColor(0,0,128);

$pdf->SetFont('times', 'B', 8);

$pdf->Ln(5);
$pdf->SetLeftMargin(10);

$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->RoundedRect(130, 7, 70, 25, 0, '1111', NULL);



$NombreCliente = $InsNotaCredito->CliNombre." ".$InsNotaCredito->CliApellidoPaterno." ".$InsNotaCredito->CliApellidoMaterno;

$ArrPalabras = explode(" ",$NombreCliente);

$afila = array();
$fila = 1;

for($i=0;$i<=count($ArrPalabras);$i++){			
						
	if(strlen($afila[$fila]." ".$ArrPalabras[$i])<120){											
		$afila[$fila].=" ".$ArrPalabras[$i];										
	}else{										
		$fila++;
		$afila[$fila].=" ".$ArrPalabras[$i];
	}
	
}


for($j=1;$j<=$fila;$j++){
	
	if($j==1){
	
		$pdf->SetFont('times', 'B', 8);
		$pdf->Cell(15,5,"",$lineas,0,"R");
		$pdf->Cell(15,5,"CLIENTE: ",$lineas,0,"R");
		$pdf->SetFont('times', 'N', 8);
		$pdf->Cell(170,5,$afila[$j],$lineas,1,"L");

	}else{

		$pdf->SetFont('times', 'B', 8);
		$pdf->Cell(15,5,"",$lineas,0,"R");
		$pdf->Cell(15,5,"",$lineas,0,"R");
		$pdf->SetFont('times', 'N', 8);
		$pdf->Cell(170,5,$afila[$j],$lineas,1,"L");
		
	}
	
}



$DireccionCliente = $InsNotaCredito->NcrDireccion;


$ArrPalabras = explode(" ",$DireccionCliente);

$afila = array();
$fila = 1;

for($i=0;$i<=count($ArrPalabras);$i++){			
						
	if(strlen($afila[$fila]." ".$ArrPalabras[$i])<120){											
		$afila[$fila].=" ".$ArrPalabras[$i];										
	}else{										
		$fila++;
		$afila[$fila].=" ".$ArrPalabras[$i];
	}
	
}

for($j=1;$j<=$fila;$j++){
	
	if($j==1){
	
		$pdf->SetFont('times', 'B', 8);
		$pdf->Cell(15,5,"",$lineas,0,"R");
		$pdf->Cell(15,5,"DIRECCION: ",$lineas,0,"R");
		$pdf->SetFont('times', 'N', 8);
		$pdf->Cell(170,5,$afila[$j],$lineas,1,"L");

	}else{

		$pdf->SetFont('times', 'B', 8);
		$pdf->Cell(15,5,"",$lineas,0,"R");
		$pdf->Cell(15,5,"",$lineas,0,"R");
		$pdf->SetFont('times', 'N', 8);
		$pdf->Cell(170,5,$afila[$j],$lineas,1,"L");
		
	}
	
}


$pdf->SetFont('times', 'B', 8);
$pdf->Cell(15,5,"",$lineas,0,"R");
$pdf->Cell(15,5,"R.U.C.: ",$lineas,0,"R");
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(170,5,$InsNotaCredito->CliNumeroDocumento,$lineas,1);


$pdf->SetFont('times', 'B', 8);
$pdf->Cell(30,5,"",$lineas,0,"C");
$pdf->Cell(45,5,"FECHA",1,0,"C");
$pdf->Cell(45,5,"MONEDA",1,0,"C");
$pdf->Cell(45,5,"USUARIO",1,1,"C");

$pdf->SetFont('times', 'N', 8);
$pdf->Cell(30,5,"",$lineas,0,"C");
$pdf->Cell(45,5,(!empty($GET_Fecha)?$GET_Fecha:$InsNotaCredito->NcrFechaEmision),1,0,"C");
$pdf->Cell(45,5,$InsNotaCredito->MonSimbolo,1,0,"C");
$pdf->Cell(45,5,$InsNotaCredito->UsuUsuario,1,1,"C");


$pdf->Ln(5);
$pdf->SetLeftMargin(10);


/*
* NOTA DE CREDITO DETALLE
*/
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(20,5,"COD.",1,0,"C");
$pdf->Cell(10,5,"CANT.",1,0,"C");
$pdf->Cell(25,5,"U/M",1,0,"C");
$pdf->Cell(75,5,"DESCRIPCION",1,0,"C");
$pdf->Cell(20,5,"P. UNITARIO",1,0,"C");
$pdf->Cell(20,5,"V. UNITARIO",1,0,"C");
$pdf->Cell(20,5,"V. TOTAL",1,1,"C");

$ArrMateriales = array();

$pdf->SetFont('times', 'N', 8);

if(!empty($InsNotaCredito->NotaCreditoDetalle)){
	foreach($InsNotaCredito->NotaCreditoDetalle as $DatNotaCreditoDetalle){
		
		//if($DatNotaCreditoDetalle->NcdTipo <> "M"){
		    
			if($InsNotaCredito->MonId<>$EmpresaMonedaId and (!empty($InsNotaCredito->NcrTipoCambio) )){

				$DatNotaCreditoDetalle->NcdImporte = ($DatNotaCreditoDetalle->NcdImporte / $InsNotaCredito->NcrTipoCambio);
				$DatNotaCreditoDetalle->NcdPrecio = ($DatNotaCreditoDetalle->NcdPrecio  / $InsNotaCredito->NcrTipoCambio);

				$DatNotaCreditoDetalle->NcdValorVenta = ($DatNotaCreditoDetalle->NcdValorVenta / $InsNotaCredito->NcrTipoCambio);
				$DatNotaCreditoDetalle->NcdValorVentaUnitario = ($DatNotaCreditoDetalle->NcdValorVentaUnitario  / $InsNotaCredito->NcrTipoCambio);

			}

		  	 if(empty($InsNotaCredito->OvvId)){
				
				$pos = strrpos($DatNotaCreditoDetalle->NcdDescripcion, "|");
				
				if ($pos === false) { // nota: tres signos de igual
					// no encontrado...
					
					$ArrPalabras = explode(" ",$DatNotaCreditoDetalle->NcdDescripcion);
					
					$afila = array();
					$fila = 1;
					
					for($i=0;$i<=count($ArrPalabras);$i++){									
						if(strlen($afila[$fila]." ".$ArrPalabras[$i])<55){											
							$afila[$fila].=" ".$ArrPalabras[$i];										
						}else{										
							$fila++;
							$afila[$fila].=" ".$ArrPalabras[$i];
						}
						
					}
					
					for($j=1;$j<=$fila;$j++){
						
						if($j==1){
							
							if($DatNotaCreditoDetalle->NcdTipo<>"T"){
								$pdf->Cell(20,5,$DatNotaCreditoDetalle->NcdCodigo,$lineas,0);	
							}else{
								$pdf->Cell(20,5,"",$lineas,0);	
							}
							
							if($DatNotaCreditoDetalle->NcdTipo<>"T"){
								$pdf->Cell(10,5,$DatNotaCreditoDetalle->NcdCantidad,$lineas,0);	
							}else{
								$pdf->Cell(10,5,"",$lineas,0);	
							}

							$pdf->Cell(25,5,$DatNotaCreditoDetalle->NcdUnidadMedida,$lineas,0);
							
							$pdf->Cell(75,5,($afila[$j])."",$lineas,0);
							
							if($DatNotaCreditoDetalle->NcdTipo<>"T"){
								$pdf->Cell(20,5,number_format($DatNotaCreditoDetalle->NcdPrecio,2),$lineas,0,"R");
							}else{
								$pdf->Cell(20,5,'',$lineas,0,"R");
							}
							
							if($DatNotaCreditoDetalle->NcdTipo<>"T"){
								$pdf->Cell(20,5,number_format($DatNotaCreditoDetalle->NcdValorVentaUnitario,2),$lineas,0,"R");
							}else{
								$pdf->Cell(20,5,'',$lineas,0,"R");
							}
							
							if($DatNotaCreditoDetalle->NcdTipo<>"T"){
								$pdf->Cell(20,5,number_format($DatNotaCreditoDetalle->NcdValorVenta,2),$lineas,1,"R");
							}else{
								$pdf->Cell(20,5,'',$lineas,1,"R");
							}
				
						}else{
							
							$pdf->Cell(20,5,"",$lineas,0);	
							$pdf->Cell(10,5,"",$lineas,0);								
							$pdf->Cell(25,5,"",$lineas,0);
							$pdf->Cell(75,5,$afila[$j],$lineas,0);
							$pdf->Cell(20,5,"",$lineas,0,"R");
							$pdf->Cell(20,5,"",$lineas,1,"R");
							$pdf->Cell(20,5,"",$lineas,0,"R");
							
						}
						
						
					}
					
					
					

					
				}else{
					
					
					$filas_adicionales = 0;
					
					unset($ArrRepuestos);		
				
					$ArrRepuestos = explode("|",$DatNotaCreditoDetalle->NcdDescripcion);
					
					if(!empty($ArrRepuestos)){
						
						$repuestos = 1;
						foreach($ArrRepuestos as $DatRepuesto){
							
							if($repuestos == 1){
								
								$ArrPalabras = explode(" ",$DatRepuesto);
							
								$afila = array();
								$fila = 1;
								
								for($i=0;$i<=count($ArrPalabras);$i++){									
									if(strlen($afila[$fila]." ".$ArrPalabras[$i])<55){											
										$afila[$fila].=" ".$ArrPalabras[$i];										
									}else{										
										$fila++;
										$afila[$fila].=" ".$ArrPalabras[$i];
									}
									
								}
								
								for($j=1;$j<=$fila;$j++){
									
									if($j==1){

										$pdf->Cell(20,5,"1",$lineas,0);	
										$pdf->Cell(10,5,"",$lineas,0);								
										$pdf->Cell(25,5,"",$lineas,0);
										$pdf->Cell(75,5,$afila[$j],$lineas,0);
										$pdf->Cell(20,5,number_format($DatNotaCreditoDetalle->NcdPrecio,2),$lineas,0,"R");
										$pdf->Cell(20,5,number_format($DatNotaCreditoDetalle->NcdValorVentaUnitario,2),$lineas,0,"R");
										$pdf->Cell(20,5,number_format($DatNotaCreditoDetalle->NcdValorVenta,2),$lineas,1,"R");
				
									}else{
										$pdf->Cell(20,5,"",$lineas,0);	
										$pdf->Cell(10,5,"",$lineas,0);								
										$pdf->Cell(25,5,"",$lineas,0);
										$pdf->Cell(75,5,$afila[$j],$lineas,0);
										$pdf->Cell(20,5,"",$lineas,0,"R");
										$pdf->Cell(20,5,"",$lineas,0,"R");
										$pdf->Cell(20,5,"",$lineas,1,"R");
									}
									
									
								}

								
							}else{
								
								$pdf->Cell(20,5,"",$lineas,0);	
								$pdf->Cell(10,5,"",$lineas,0);								
								$pdf->Cell(25,5,"",$lineas,0);
								$pdf->Cell(75,5,"- ".$DatRepuesto,$lineas,0);
								$pdf->Cell(20,5,"",$lineas,0,"R");
								$pdf->Cell(20,5,"",$lineas,0,"R");
								$pdf->Cell(20,5,"",$lineas,1,"R");
								$filas_adicionales++;
								
							}
							
							$repuestos ++;
						}
						
					}
					
					
				}
				
				
			
			}else{
				
					
					
					$DatBoletaDetalle->BdeDescripcion;		
	$DatBoletaDetalle->BdeDescripcion .= "|";	
	
  if(!empty($InsBoleta->BolDatoAdicional13) or !empty($InsBoleta->BolDatoAdicional7) or !empty($InsBoleta->BolDatoAdicional1)){
	
	$DatBoletaDetalle->BdeDescripcion .= "( ";

  }

  if(!empty($InsBoleta->BolDatoAdicional13)){
	
	$DatBoletaDetalle->BdeDescripcion .= "Nro. VIN o CHASIS: ".$InsBoleta->BolDatoAdicional13.", ";
	
  }

  
  

  if(!empty($InsBoleta->BolDatoAdicional7)){
 
		$DatBoletaDetalle->BdeDescripcion .= "Nro. Motor: ".$InsBoleta->BolDatoAdicional7.", ";
	
  }
  
  

  if(!empty($InsBoleta->BolDatoAdicional1)){
 
		$DatBoletaDetalle->BdeDescripcion .= "Marca: ".$InsBoleta->BolDatoAdicional1.", ";
 
  }

  if(!empty($InsBoleta->BolDatoAdicional13) or !empty($InsBoleta->BolDatoAdicional7) or !empty($InsBoleta->BolDatoAdicional1)){
	
   $DatBoletaDetalle->BdeDescripcion .= " )";
   
  }
  
  
					unset($ArrPalabras);		
				
					list($Vehiculo,$Accesorios) = explode("|",$DatNotaCreditoDetalle->NcdDescripcion);
					
					$ArrPalabras = explode(" ",$Vehiculo);
					
					$afila = array();
					$fila = 1;
					
					for($i=0;$i<=count($ArrPalabras);$i++){									
						if(strlen($afila[$fila]." ".$ArrPalabras[$i])<60){											
							$afila[$fila].=" ".$ArrPalabras[$i];										
						}else{										
							$fila++;
							$afila[$fila].=" ".$ArrPalabras[$i];
						}
					}
					
					for($j=1;$j<=$fila;$j++){
						
						if($j==1){
							
							if($DatNotaCreditoDetalle->NcdTipo<>"T"){
								$pdf->Cell(20,5,$DatNotaCreditoDetalle->NcdCodigo,$lineas,0);	
							}else{
								$pdf->Cell(20,5,"",$lineas,0);	
							}
							
							if($DatNotaCreditoDetalle->NcdTipo<>"T"){
								$pdf->Cell(10,5,$DatNotaCreditoDetalle->NcdCantidad,$lineas,0);	
							}else{
								$pdf->Cell(10,5,"",$lineas,0);	
							}
							
							$pdf->Cell(25,5,$DatNotaCreditoDetalle->NcdUnidadMedida,$lineas,0);
							
							$pdf->Cell(75,5,$afila[$j],$lineas,0);
							
							if($DatNotaCreditoDetalle->NcdTipo<>"T"){
								$pdf->Cell(20,5,number_format($DatNotaCreditoDetalle->NcdPrecio,2),$lineas,0,"R");
							}else{
								$pdf->Cell(20,5,'',$lineas,0,"R");
							}
							
							if($DatNotaCreditoDetalle->NcdTipo<>"T"){
								$pdf->Cell(20,5,number_format($DatNotaCreditoDetalle->NcdValorVentaUnitario,2),$lineas,0,"R");
							}else{
								$pdf->Cell(20,5,'',$lineas,0,"R");
							}
							
							if($DatNotaCreditoDetalle->NcdTipo<>"T"){
								$pdf->Cell(20,5,number_format($DatNotaCreditoDetalle->NcdValorVenta,2),$lineas,1,"R");
							}else{
								$pdf->Cell(20,5,'',$lineas,1,"R");
							}
							
						}else{
							
							$pdf->Cell(20,5,"",$lineas,0);	
							$pdf->Cell(10,5,"",$lineas,0);								
							$pdf->Cell(25,5,"",$lineas,0);
							$pdf->Cell(75,5,$afila[$j],$lineas,0);
							$pdf->Cell(20,5,"",$lineas,0,"R");
							$pdf->Cell(20,5,"",$lineas,0,"R");
							$pdf->Cell(20,5,"",$lineas,1,"R");
							
						}
						
						
					}
				
				
					unset($ArrPalabras);		
				
					$ArrPalabras = explode(" ",$Accesorios);
					
					//$ArrPalabras = explode(" ",$Vehiculo);
					
					$afila = array();
					$fila = 1;
					
					for($i=0;$i<=count($ArrPalabras);$i++){									
						if(strlen($afila[$fila]." ".$ArrPalabras[$i])<60){											
							$afila[$fila].=" ".$ArrPalabras[$i];										
						}else{										
							$fila++;
							$afila[$fila].=" ".$ArrPalabras[$i];
						}
					}
					
					for($j=1;$j<=$fila;$j++){
						
						if($j==1){
							
							$pdf->Cell(20,5,"",$lineas,0);
							$pdf->Cell(10,5,"",$lineas,0);	
							$pdf->Cell(25,5,"",$lineas,0);
							$pdf->Cell(75,5,$afila[$j],$lineas,0);
							$pdf->Cell(20,5,'',$lineas,0,"R");
							$pdf->Cell(20,5,'',$lineas,0,"R");
							$pdf->Cell(20,5,'',$lineas,1,"R");
							
							
						}else{
							
							$pdf->Cell(20,5,"",$lineas,0);
							$pdf->Cell(10,5,"",$lineas,0);								
							$pdf->Cell(25,5,"",$lineas,0);
							$pdf->Cell(75,5,$afila[$j],$lineas,0);
							$pdf->Cell(20,5,"",$lineas,0,"R");
							$pdf->Cell(20,5,"",$lineas,0,"R");
							$pdf->Cell(20,5,"",$lineas,1,"R");
							
						}
						
						
					}
				
			}
		
	}
}

//if(!empty($ArrMateriales )){
//	
//	$MaterialImporte = 0;
//            
//	foreach($ArrMateriales as $DatMaterial){
//	
//			if($InsNotaCredito->MonId<>$EmpresaMonedaId and (!empty($InsNotaCredito->NcrTipoCambio) )){
//				
//				$DatNotaCreditoDetalle->NcdImporte = ($DatMaterial->NcdImporte / $InsNotaCredito->NcrTipoCambio);
//				$DatNotaCreditoDetalle->NcdPrecio = ($DatMaterial->NcdPrecio  / $InsNotaCredito->NcrTipoCambio);
//				
//			}
//						
//			if($DatNotaCreditoDetalle->NcdTipo<>"T"){
//				$pdf->Cell(10,5,$DatMaterial->NcdCantidad,$lineas,0);	
//			}else{
//				$pdf->Cell(10,5,"",$lineas,0);	
//			}
//			
//			
//			$pdf->Cell(30,5,$DatMaterial->NcdUnidadMedida,$lineas,0);
//			$pdf->Cell(100,5,stripslashes( $DatMaterial->NcdDescripcion),$lineas,0);
//			
//			if($DatNotaCreditoDetalle->NcdTipo<>"T"){
//				$pdf->Cell(2,5,number_format($DatMaterial->NcdPrecio,2),$lineas,0,"R");
//			}
//			
//			if($DatNotaCreditoDetalle->NcdTipo<>"T"){
//				$pdf->Cell(25,5,number_format($DatMaterial->NcdImporte,2),$lineas,1,"R");
//			}
//			
//			$TotalBruto = $TotalBruto + $DatMaterial->NcdImporte;		
//		
//		$MaterialImporte += $DatMaterial->NcdImporte;
//	}
//	
//		
//}

$TotalLineas = count($InsNotaCredito->NotaCreditoDetalle);

if($TotalLineas<15 and empty($InsNotaCredito->OvvId)){
	
	$TotalLineasFaltantes = 15 - $TotalLineas;
	
	for($i=1;$i<=$TotalLineasFaltantes;$i++){
			
		$pdf->Cell(20,5,"",$lineas,0);
		$pdf->Cell(10,5,"",$lineas,0);								
		$pdf->Cell(25,5,"",$lineas,0);
		$pdf->Cell(75,5,"",$lineas,0);
		$pdf->Cell(20,5,"",$lineas,0,"R");
		$pdf->Cell(20,5,"",$lineas,0,"R");
		$pdf->Cell(20,5,"",$lineas,1,"R");
		
	}

}


//$pdf->Ln(5);
//$pdf->SetLeftMargin(10);


if(!empty($InsNotaCredito->NcrFechaVencimiento)){
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(40,5,"Fecha de Vencimiento: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(30,5,$InsNotaCredito->NcrFechaVencimiento,$lineas,0);
	

}

//$pdf->Ln(5);
//$pdf->SetLeftMargin(10);

if(!empty($InsNotaCredito->EinVIN)){
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"VIN: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->EinVIN,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"Placa: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->EinPlaca,$lineas,1);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(35,5,"Marca/Modelo/Version: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(70,5,$InsNotaCredito->VmaNombre." ".$InsNotaCredito->VmoNombre." ".$InsNotaCredito->VveNombre,$lineas,1);


}

//$pdf->Ln(5);
//$pdf->SetLeftMargin(10);

if(!empty($InsNotaCredito->FinId)){
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"O.T.: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(30,5,$InsNotaCredito->FinId,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"Kilom.: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(30,5,$InsNotaCredito->FinVehiculoKilometraje." ".(!empty($InsNotaCredito->FinVehiculoKilometraje))?'KM':'',$lineas,0);
	
}

if(!empty($InsNotaCredito->AmoId)){
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"Ficha: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(30,5,$InsNotaCredito->AmoId,$lineas,0);

	$pdf->Ln(5);
	
}

if(!empty($InsNotaCredito->OvvId)){
	
	$pdf->Cell(40,5,"",$lineas,0);		
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Marca: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->NcrDatoAdicional1,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Tracción: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->NcrDatoAdicional2,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Modelo: ",$lineas,0);	
	 $pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->NcrDatoAdicional3,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Carroceria: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->NcrDatoAdicional4,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Año Fabric.: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->NcrDatoAdicional5,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Puertas: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->NcrDatoAdicional6,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Motor: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->NcrDatoAdicional7,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Combustible: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->NcrDatoAdicional8,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Cilindros: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->NcrDatoAdicional9,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Peso Bruto: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->NcrDatoAdicional10,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Ejes: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->NcrDatoAdicional11,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Carga Util: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->NcrDatoAdicional12,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Chasis: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->NcrDatoAdicional13,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Peso Seco: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->NcrDatoAdicional14,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Color: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->NcrDatoAdicional15,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Alto: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->NcrDatoAdicional16,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Cilindrada: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->NcrDatoAdicional17,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Largo: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->NcrDatoAdicional18,$lineas,1);
	


	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Asientos: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->NcrDatoAdicional19,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Ancho: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->NcrDatoAdicional20,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Cap. Pasajeros: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->NcrDatoAdicional21,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Dist. Ejes: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->NcrDatoAdicional22,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Poliza: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaCredito->NcrDatoAdicional23,$lineas,0);
	
	
	if(count($InsNotaCredito->OrdenVentaVehiculoPropietario)>1){

			$pdf->Cell(10,5,"",$lineas,0);
					
			$pdf->SetFont('times', 'B', 8);
			$pdf->Cell(20,5,"",$lineas,0);	
				
			$pdf->SetFont('times', 'N', 8);
			$pdf->Cell(45,5,"",$lineas,1);
			
			
			$Propietarios = "";
	
			$pdf->Cell(10,5,"",$lineas,0);
					
			$pdf->SetFont('times', 'B', 8);
			$pdf->Cell(20,5,"Copropietario(s): ",$lineas,1);	
				
			//$pdf->SetFont('times', 'N', 8);
			//$pdf->Cell(45,5,"",$lineas,1);
				
			foreach($InsNotaCredito->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
				
				if($InsNotaCredito->CliId<> $DatOrdenVentaVehiculoPropietario->CliId){	
	
					$pdf->Cell(10,5,"",$lineas,0);
						
					$pdf->SetFont('times', 'B', 8);
					$pdf->Cell(15,5,$DatOrdenVentaVehiculoPropietario->TdoNombre.": ",$lineas,0);	
					
					$pdf->SetFont('times', 'N', 8);
					$pdf->Cell(15,5,$DatOrdenVentaVehiculoPropietario->CliNumeroDocumento."",$lineas,0);	
					
					
					$pdf->SetFont('times', 'B', 8);
					$pdf->Cell(15,5,"Señor(es):",$lineas,0);
	
					$pdf->SetFont('times', 'N', 8);
					$pdf->Cell(45,5,$DatOrdenVentaVehiculoPropietario->CliNombre." ".$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno." ".$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno,$lineas,1);
	
	
				}			
			}		
	
		}
		
		
	
}

/*
* MONTO EN LETRAS
*/

$Total = round($InsNotaCredito->NcrTotal,2);
list($parte_entero,$parte_decimal) = explode(".",$Total);

if(empty($parte_decimal)){
	$parte_decimal = 0;
}

$parte_decimal = str_pad($parte_decimal, 2, "0", STR_PAD_RIGHT);


$numalet= new CNumeroaletra;
$numalet->setNumero($parte_entero);
$numalet->setMayusculas(1);
$numalet->setGenero(1);
$numalet->setMoneda("");
$numalet->setPrefijo("");
$numalet->setSufijo("");





$pdf->Line(10,185,195,185);

//$pdf->SetFont('times', 'N', 8);
//$pdf->Cell(190,5,"",$lineas,1);

$pdf->Cell(20,5,"PREPARADO",1,0,"C");
$pdf->Cell(10,5,"V°B°",1,0,"C");

$pdf->Cell(5,5,"",$lineas,0,"C");

$pdf->SetFont('times', 'N', 6);
$pdf->Cell(30,5,"RECIBIDO POR EL CLIENTE",1,0,"C");

$pdf->Cell(5,5,"",$lineas,0,"C");

$pdf->Cell(30,5,"CANCELADO",1,0,"C");

$pdf->Cell(20,5,"",0,0,"C");

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"OP. GRAVADAS",$lineas,0,"R");
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaCredito->MonSimbolo,$lineas,0,"L");
$pdf->Cell(25,5,number_format($InsNotaCredito->NcrTotalGravado,2),1,1,"R");


$pdf->Cell(20,15,"",1,0,"C");
$pdf->Cell(10,15,"",1,0,"C");

$pdf->Cell(5,5,"",$lineas,0,"C");

$pdf->SetFont('times', 'N', 6);
$pdf->Cell(30,15,"",1,0,"C");

$pdf->Cell(5,15,"",$lineas,0,"C");

$pdf->Cell(30,15,"",1,0,"C");


$pdf->Cell(20,5,"",$lineas,0,"C");

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"OP. INAFECTAS",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaCredito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaCredito->NcrTotalInafecta,2),1,1,'R');



$pdf->Cell(120,5,"",$lineas,0,"C");

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"OP. EXONERADAS",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaCredito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaCredito->NcrTotalExonerado,2),1,1,'R');


$pdf->Cell(120,5,"",$lineas,0,"C");

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"OP. GRATUITAS",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaCredito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaCredito->NcrTotalGratuita,2),1,1,'R');


//FILA
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(20,5,"SON:",$lineas,0,"L");
$pdf->SetFont('times', '', 8);
$pdf->Cell(100,5,$numalet->letra()." CON ".$parte_decimal."/100"." ".$InsNotaCredito->MonNombre,$lineas,0,'L');

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"OTROS CARGOS",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaCredito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaCredito->NcrTotalOtrosCargos,2),1,1,'R');


//FILA
$pdf->Cell(120,5,"",$lineas,0,'C');

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"OTROS TRIBUTOS",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaCredito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaCredito->NcrTotalOtrosTributos,2),1,1,'R');

//FILA
$pdf->Cell(120,5,"",$lineas,0,'C');

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"DESCUENTO",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaCredito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaCredito->NcrTotalDescuento,2),1,1,'R');

if($InsNotaCredito->NcrTotalImpuestoSelectivo>0){
	
		//FILA

	$pdf->Cell(120,5,"",$lineas,0,'L');
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(35,5,"Total ISC ".number_format($InsNotaCredito->NcrPorcentajeImpuestoSelectivo,2)."%",$lineas,0,'R');
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(10,5,$InsNotaCredito->MonSimbolo,$lineas,0,'L');
	$pdf->Cell(25,5,number_format($InsNotaCredito->NcrTotalImpuestoSelectivo,2),1,1,'R');

}

//FILA

$pdf->Cell(120,5,"",$lineas,0,'L');

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"IGV ".number_format($InsNotaCredito->NcrPorcentajeImpuestoVenta,2)."%",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaCredito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaCredito->NcrImpuesto,2),1,1,'R');

//FILA
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(120,5,"OBSERVACIONES:",$lineas,0,'L');

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"TOTAL",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaCredito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaCredito->NcrTotal,2),1,1,'R');

//$pdf->Ln(15);

/*
* OBSERVACIONES
*/
if(!empty($InsNotaCredito->NcrObservacionImpresa)){
//	
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(190,5,"OBSERVACIONES:",$lineas,1,'L');

	$pdf->SetFont('times', '', 8);

	$pos = strrpos($InsNotaCredito->NcrObservacionImpresa, "|");
	
	if ($pos === false) { // nota: tres signos de igual
		// no encontrado...
		
			$pdf->Cell(190,5,$InsNotaCredito->NcrObservacionImpresa,$lineas,1);
		
	}else{
		
		$ArrPalabras = explode("|",$InsNotaCredito->NcrObservacionImpresa);
		
		$pdf->Cell(190,5,($ArrPalabras[0])."",$lineas,1);
		$pdf->Cell(190,5,($ArrPalabras[1])."",$lineas,1);
	}
	
	
}

if(!empty($InsNotaCredito->NcrMotivoCodigo)){
 
	$ArrMotivoPalabras = explode(" ",$InsNotaCredito->NcrMotivo);
	
	$palabra = 0;
	$direccion1 = "";
	$direccion2 = "";
	$direccion3 =  "";
	
	foreach($ArrMotivoPalabras as $DatMotivoPalabra){
		
		if($palabra<17){
			$direccion1 .= $DatMotivoPalabra." ";
		}else if($palabra<34){
			$direccion2 .= $DatMotivoPalabra." ";
		}else{
			$direccion3 .= $DatMotivoPalabra." ";
		}
		
		$palabra++;
	}
	
	$direccion1 = trim($direccion1);
	$direccion2 = trim($direccion2);
	$direccion3 = trim($direccion3);
	

	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(190,5,"MOTIVO:",$lineas,1,'L');
	
	$pdf->SetFont('times', '', 8);
		
	if(!empty($direccion1)){
	
		$pdf->Cell(190,5,$direccion1,$lineas,1,"L");
	
	}
	
	if(!empty($direccion2)){
	
		$pdf->Cell(190,5,$direccion2,$lineas,1,"L");
	
	}
	
	if(!empty($direccion3)){
		
		$pdf->Cell(190,5,$direccion3,$lineas,1,"L");
	
	}
		
}

/*
* TOTALES
*/

//FILA
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(90,5,"DOCUMENTO(S) DE REFERENCIA:",$lineas,0,'L');
$pdf->Cell(30,5,"",$lineas,0,'R');

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,"",$lineas,0,'L');
$pdf->Cell(25,5,"",$lineas,1,'R');

//FILA
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(30,5,"Tipo Doc.",1,0,'C');
$pdf->Cell(30,5,"Numero",1,0,'C');
$pdf->Cell(30,5,"Fecha",1,0,'C');
$pdf->Cell(30,5,"",$lineas,0,'C');

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,"",$lineas,0,'L');
$pdf->Cell(25,5,"",$lineas,1,'R');

//FILA
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(30,5,$TipoDocumento,1,0,'C');
$pdf->Cell(30,5,$InsNotaCredito->DtaNumero."-".$InsNotaCredito->DocId,1,0,'C');
$pdf->Cell(30,5,$InsNotaCredito->DocFechaEmision,1,0,'C');
$pdf->Cell(30,5,"",$lineas,0,'C');

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,"",$lineas,0,'L');
$pdf->Cell(25,5,"",$lineas,1,'R');

/*
//FILA
$pdf->Cell(120,5,"",$lineas,0,'C');

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"OP. GRATUITAS",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaCredito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaCredito->NcrTotalGratuita,2),1,1,'R');

//FILA
$pdf->Cell(120,5,"",$lineas,0,'C');

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"OTROS CARGOS",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaCredito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaCredito->NcrTotalOtrosCargos,2),1,1,'R');

//FILA
$pdf->Cell(120,5,"",$lineas,0,'C');

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"OTROS TRIBUTOS",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaCredito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaCredito->NcrTotalOtrosTributos,2),1,1,'R');

//FILA
$pdf->Cell(120,5,"",$lineas,0,'C');

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"DESCUENTO",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaCredito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaCredito->NcrTotalDescuento,2),1,1,'R');

if($InsNotaCredito->NcrTotalImpuestoSelectivo>0){
	
		//FILA
	$pdf->SetFont('times', 'B', 12);
	$pdf->Cell(120,5,"",$lineas,0,'L');
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(35,5,"Total ISC ".number_format($InsNotaCredito->NcrPorcentajeImpuestoSelectivo,2)."%",$lineas,0,'R');
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(10,5,$InsNotaCredito->MonSimbolo,$lineas,0,'L');
	$pdf->Cell(25,5,number_format($InsNotaCredito->NcrTotalImpuestoSelectivo,2),1,1,'R');

}

//FILA
$pdf->SetFont('times', 'B', 12);
$pdf->Cell(120,5,"",$lineas,0,'L');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"IGV ".number_format($InsNotaCredito->NcrPorcentajeImpuestoVenta,2)."%",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaCredito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaCredito->NcrImpuesto,2),1,1,'R');

//FILA
$pdf->Cell(120,5,"",$lineas,0,'C');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"TOTAL",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaCredito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaCredito->NcrTotal,2),1,1,'R');
*/

/*
GENERAR CODIGO QR
*/

$ArchivoFacturaCodigoQR = $InsNotaCredito->NctNumero."-".$InsNotaCredito->NcrId.'_QR.png'; 
$RutaFacturaCodigoQR = "../../generados/comprobantes/".$ArchivoFacturaCodigoQR; 
// generating 

if (file_exists($RutaFacturaCodigoQR)) { 
	unlink($RutaFacturaCodigoQR); 
}

// QRcode::png($InsNotaCredito->NctNumero."-".$InsNotaCredito->NcrId, $RutaFacturaCodigoQR); 
$CodigoQR = $EmpresaCodigo.'|3|'.$InsNotaCredito->NctNumero.'|'.$InsNotaCredito->NcrId.'|'.number_format($Impuesto,2, '.', '').'|'.number_format($Total,2, '.', '').'|'.FncCambiaFechaAMysql($InsNotaCredito->NcrFechaEmision).'|1|'.$InsNotaCredito->CliNumeroDocumento.'|'.$InsNotaCredito->NcrSunatRespuestaEnvioDigestValue.'|'.$InsNotaCredito->NcrSunatRespuestaEnvioSignatureValue;

// set style for barcode
$style = array(
    'border' => 2,
    'vpadding' => 'auto',
    'hpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255)
    'module_width' => 1, // width of a single module in points
    'module_height' => 1 // height of a single module in points
);

$pdf->write2DBarcode($CodigoQR, 'QRCODE,Q', 95, 230, 25, 25, $style, 'N');





$pdf->Ln(10);
$pdf->SetLeftMargin(10);

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(60,3,"",$lineas,0,'C',0,0);
$pdf->Cell(80,3,"Sistema de Facturacion Electrónica CREATIVA AQP - www.creativa.com.pe",$lineas,1,'C',0,0);

$pdf->Ln(2);
$pdf->SetLeftMargin(10);


$pdf->SetFont('times', 'B', 6);
$pdf->Cell(190,3,"Esta es una representación impresa de la Factura electrónica, Pede verificarlo utiliznado su clave SOL en www.sunat.gob.pe o en",0,1,'C',0,0);
$pdf->Cell(190,3,"http://app.facturaonline.pe/invitado",0,1,'C',0,0);

	
$pdf->Output('../../generados/comprobantes_pdf/'.$NOMBRE.'.pdf', 'F');

$pdf->Output($NOMBRE.".pdf");



?>