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
require_once($InsProyecto->MtdRutLibrerias().'phpqrcode/qrlib.php');
require_once($InsProyecto->MtdRutLibrerias().'TCPDF-master/tcpdf_barcodes_2d.php');


$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];
$GET_TiempoImpresion = $_GET['TiempoImpresion'];

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');

$InsFactura = new ClsFactura();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//echo "adsfadfs";
//Obteniendo datos de factura
$InsFactura->FacId = $GET_id;
$InsFactura->FtaId = $GET_ta;
$InsFactura = $InsFactura->MtdObtenerFactura();

$NOMBRE = $EmpresaCodigo.'-01-'.$InsFactura->FtaNumero.'-'.$InsFactura->FacId;

if($InsFactura->MonId<>$EmpresaMonedaId){
	
	$InsFactura->FacTotalGravado = round($InsFactura->FacTotalGravado/$InsFactura->FacTipoCambio,2);
	$InsFactura->FacTotalExonerado = round($InsFactura->FacTotalExonerado/$InsFactura->FacTipoCambio,2);
	$InsFactura->FacTotalGratuito = round($InsFactura->FacTotalGratuito/$InsFactura->FacTipoCambio,2);
	$InsFactura->FacTotalDescuento = round($InsFactura->FacTotalDescuento/$InsFactura->FacTipoCambio,2);

	
	$InsFactura->FacTotalPagar = round($InsFactura->FacTotalPagar/$InsFactura->FacTipoCambio,2);
	$InsFactura->FacTotalDescuento = round($InsFactura->FacTotalDescuento/$InsFactura->FacTipoCambio,2);
	
	$InsFactura->FacSubTotal = round($InsFactura->FacSubTotal/$InsFactura->FacTipoCambio,2);	
	$InsFactura->FacImpuesto = round($InsFactura->FacImpuesto/$InsFactura->FacTipoCambio,2);
	$InsFactura->FacTotal = round($InsFactura->FacTotal/$InsFactura->FacTipoCambio,2);	
	
}
	
	
/*
GENERAR CODIGO QR
*/
//$ArchivoFacturaCodigoQR = $InsFactura->FtaNumero."-".$InsFactura->FacId.'_QR.png'; 
//$RutaFacturaCodigoQR = "../../generados/comprobantes/".$ArchivoFacturaCodigoQR; 
// generating 
//if (!file_exists($RutaFacturaCodigoQR)) { 
//  QRcode::png($InsFactura->FtaNumero."-".$InsFactura->FacId, $RutaFacturaCodigoQR); 
//}
     
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
		global $InsFactura;
		global $EmpresaTelefono;
		
		// Logo
		$image_file = '../../imagenes/comprobante_logotipo.png';
		$this->Image($image_file, 10, 10, 45, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		//$this->SetFont('helvetica', 'B', 20);
		// Title
		//$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		
		//
		
		$this->SetLeftMargin(10);
		
//		$this->SetFont('times', 'B', 10);
//		$this->Cell(5,5,'',$lineas,0,'C',0);
		$this->SetFont('times', 'B', 12);
		$this->Cell(75,5,$EmpresaNombre,$lineas,0,'C',0);
		
			$this->SetFont('times', 'B', 10);
			$this->Cell(70,5,"R.U.C.: ".$EmpresaCodigo,$lineas,1,'C',0);
//		
		
		$this->SetFont('times', '', 10);
		$this->Cell(45,5,'',$lineas,0,'C',0);
		$this->SetFont('times', '', 6);
		$this->Cell(75,5,$EmpresaDireccion,$lineas,0,'C',0);
//		
			$this->SetFont('times', 'B', 10);
			$this->Cell(70,5,"FACTURA ELECTRONICA",$lineas,1,'C');

		$this->SetFont('times', '', 10);
		$this->Cell(45,5,'',$lineas,0,'C',0);
		$this->SetFont('times', '', 6);
		$this->Cell(75,5,$EmpresaProvincia." - ".$EmpresaDistrito." - ".$EmpresaDepartamento,$lineas,0,'C');
//		
//		
			$this->SetFont('times', 'B', 10);
			$this->Cell(70,5,"N°. ".$InsFactura->FtaNumero."-".$InsFactura->FacId,$lineas,1,'C');
			
			
		$this->SetFont('times', '', 10);
		$this->Cell(45,5,'',$lineas,0,'C',0);
		$this->SetFont('times', '', 6);
		$this->Cell(75,5,"Telef. ".$EmpresaTelefono,$lineas,0,'C');
		
		
//		
//		
//		$this->SetFont('times', 'B', 8);
//		$this->Cell(50,5,$EmpresaTelefono,$lineas,1,'C');

	}

	// Page footer
	public function Footer() {
		
		global $lineas;
		global $InsFactura;
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
//			<td style="width:150px; padding: 2px; text-align:left;"><img src="'.$RutaFacturaCodigoQR.'" border="0" align="top" alt="Nexnet" /></td>
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
//		$this->write2DBarcode($InsFactura->FtaNumero."-".$InsFactura->FacId, 'QRCODE', 0, 0, 0, 30, $style, 'N');
		
	}
}

//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $pagelayout, true, 'UTF-8', false);
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf = new TCPDF();
//$pdf->SetHeaderData('logotipo.png', PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
// set document information
$pdf->SetCreator($EmpresaNombre);
$pdf->SetAuthor($EmpresaNombre);
$pdf->SetTitle($InsFactura->FtaNumero."-".$InsFactura->FacId);
$pdf->SetSubject("Factura Electronica");
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
$pdf->SetMargins(0, 25, 0);
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
//	$pdf->Cell(90,5,"FACTURA ELECTRONICA",$lineas,1,'C');
//
//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(100,5,$EmpresaProvincia." ".$EmpresaDistrito." ".$EmpresaDepartamento,$lineas,0,'C');
//
//
//	$pdf->SetFont('times', 'B', 12);
//	$pdf->Cell(90,5,"No. ".$InsFactura->FtaNumero."-".$InsFactura->FacId,$lineas,1,'C');
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

//$complex_cell_border = array(
//   'TB' => array('width' => 1, 'color' => array(0,255,0), 'dash' => 4, 'cap' => 'butt'),
//   'RL' => array('width' => 2, 'color' => array(255,0,255), 'dash' => '1,3', 'cap' => 'round'),
//);

//$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0));
//$pdf->Text(5, 249, 'Rounded rectangle examples');

$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->RoundedRect(10, 30, 190, 20, 2, '1111', NULL);

//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(20,5,"Señor(es): ",$lineas,0);
//$pdf->SetFont('times', 'N', 8);
//$pdf->Cell(170,5,$InsFactura->CliNombre." ".$InsFactura->CliApellidoPaterno." ".$InsFactura->CliApellidoMaterno,$lineas,1);
//



$NombreCliente = $InsFactura->CliNombre." ".$InsFactura->CliApellidoPaterno." ".$InsFactura->CliApellidoMaterno;

$ArrNombreClientePalabras = explode(" ",$NombreCliente);

$palabra = 0;
$nombre1 = "";
$nombre2 = "";
$nombre3=  "";

foreach($ArrNombreClientePalabras as $DatNombreClientePalabra){
	
	if($palabra<9){
		$nombre1 .= $DatNombreClientePalabra." ";
	}else if($palabra<19){
		$nombre2 .= $DatNombreClientePalabra." ";
	}else{
		$nombre3 .= $DatNombreClientePalabra." ";
	}
	
	$palabra++;
}

$nombre1 = trim($nombre1);
$nombre2 = trim($nombre2);
$nombre3 = trim($nombre3);

//if(!empty($nombre1)){

	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"Señor(es): ",$lineas,0,"L");
	$pdf->SetFont('times', 'N', 7);
	$pdf->Cell(175,5,$nombre1,$lineas,1,"L");

//}

if(!empty($nombre2)){

	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"",$lineas,0);
	$pdf->SetFont('times', 'N', 7);
	$pdf->Cell(175,5,$nombre2,$lineas,1,"L");

}

if(!empty($nombre3)){
		
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"",$lineas,0);
	$pdf->SetFont('times', 'N', 7);
	$pdf->Cell(175,5,$nombre3,$lineas,1,"L");

}

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(15,5,"R.U.C.: ",$lineas,0);
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(80,5,$InsFactura->CliNumeroDocumento,$lineas,0);

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(20,5,"No. Guia: ",$lineas,0);
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(20,5,"-",$lineas,0);

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(20,5,"Fecha: ",$lineas,0);
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(20,5,$InsFactura->FacFechaEmision,$lineas,1);




$DireccionCliente = $InsFactura->FacDireccion;

$ArrDireccionClientePalabras = explode(" ",$DireccionCliente);

$palabra = 0;
$direccion1 = "";
$direccion2 = "";
$direccion3 =  "";

foreach($ArrDireccionClientePalabras as $DatDireccionClientePalabra){
	
	if($palabra<17){
		$direccion1 .= $DatDireccionClientePalabra." ";
	}else if($palabra<34){
		$direccion2 .= $DatDireccionClientePalabra." ";
	}else{
		$direccion3 .= $DatDireccionClientePalabra." ";
	}
	
	$palabra++;
}

$direccion1 = trim($direccion1);
$direccion2 = trim($direccion2);
$direccion3 = trim($direccion3);


$pdf->SetFont('times', 'B', 8);
$pdf->Cell(15,5,"Direccion: ",$lineas,0);
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(170,5,$direccion1,$lineas,1);

if(!empty($direccion2)){

	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"",$lineas,0);
	$pdf->SetFont('times', 'N', 7);
	$pdf->Cell(170,5,$direccion2,$lineas,1,"L");

}

if(!empty($direccion3)){
		
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"",$lineas,0);
	$pdf->SetFont('times', 'N', 7);
	$pdf->Cell(170,5,$direccion3,$lineas,1,"L");

}






$pdf->Ln(5);
$pdf->SetLeftMargin(10);



/*
* FACTURA DETALLE
*/
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(10,5,"CANT.",1,0,"C");
$pdf->Cell(30,5,"UNIDAD",1,0,"C");
$pdf->Cell(100,5,"DESCRIPCION",1,0,"C");
$pdf->Cell(25,5,"V. UNIT.",1,0,"C");
$pdf->Cell(25,5,"VALOR TOTAL",1,1,"C");
$pdf->SetFont('times', 'N', 8);

$ArrMateriales = array();

if(!empty($InsFactura->FacturaDetalle)){
	foreach($InsFactura->FacturaDetalle as $DatFacturaDetalle){
		
		
//		deb($DatFacturaDetalle->FdeCantidad);
	//	if($DatFacturaDetalle->FdeTipo <> "M"){
		    
			if($InsFactura->MonId<>$EmpresaMonedaId and (!empty($InsFactura->FacTipoCambio) )){

				$DatFacturaDetalle->FdeImporte = ($DatFacturaDetalle->FdeImporte / $InsFactura->FacTipoCambio);
				$DatFacturaDetalle->FdePrecio = ($DatFacturaDetalle->FdePrecio  / $InsFactura->FacTipoCambio);

				$DatFacturaDetalle->FdeValorVenta = ($DatFacturaDetalle->FdeValorVenta / $InsFactura->FacTipoCambio);
				$DatFacturaDetalle->FdeValorVentaUnitario = ($DatFacturaDetalle->FdeValorVentaUnitario  / $InsFactura->FacTipoCambio);

			}

						
			if(empty($InsFactura->OvvId)){
				
				unset($ArrRepuestos);		
				
				$ArrRepuestos = explode("|",$DatFacturaDetalle->FdeDescripcion);
				
				//deb($ArrRepuestos);
				
				if(!empty($ArrRepuestos)){
					
					$repuestos = 1;
					foreach($ArrRepuestos as $DatRepuesto){
						
						if($repuestos == 1){
							
							$pdf->Cell(10,5,"1",$lineas,0);								
							$pdf->Cell(30,5,"",$lineas,0);
							$pdf->Cell(100,5,$DatRepuesto,$lineas,0);
							$pdf->Cell(25,5,number_format($DatFacturaDetalle->FdeValorVentaUnitario,2),$lineas,0,"R");
							$pdf->Cell(25,5,number_format($DatFacturaDetalle->FdeValorVenta,2),$lineas,1,"R");
							
						}else{
							
							$pdf->Cell(10,5,"",$lineas,0);								
							$pdf->Cell(30,5,"",$lineas,0);
							$pdf->Cell(100,5,"- ".$DatRepuesto,$lineas,0);
							$pdf->Cell(25,5,"",$lineas,0,"R");
							$pdf->Cell(25,5,"",$lineas,1,"R");
							
						}
						
						$repuestos ++;
					}
					
				}else{
					
					unset($ArrNombreProductoPalabras);		
				
					$ArrNombreProductoPalabras = explode(" ",stripslashes( $DatFacturaDetalle->FdeDescripcion));
		
						$palabra = 1;
						$detalle1 = "";
						$detalle2 = "";
						$detalle3 =  "";
						
						foreach($ArrNombreProductoPalabras as $DatNombreProductoPalabra){
												
							if($palabra<10){						
								$detalle1 .= $DatNombreProductoPalabra." ";
								
							}else if($palabra<20){						
								$detalle2 .= $DatNombreProductoPalabra." ";
								
							}else{						
								$detalle3 .= $DatNombreProductoPalabra." ";
								
							}
							
							$palabra++;
							
						}
						
					$detalle1 = trim($detalle1);
					$detalle2 = trim($detalle2);
					$detalle3 = trim($detalle3);
					
					
					if($DatFacturaDetalle->FdeTipo<>"T"){
						$pdf->Cell(10,5,$DatFacturaDetalle->FdeCantidad,$lineas,0);	
					}else{
						$pdf->Cell(10,5,"",$lineas,0);	
					}
					
					
					$pdf->Cell(30,5,$DatFacturaDetalle->FdeUnidadMedida,$lineas,0);
					$pdf->Cell(100,5,($detalle1)."",$lineas,0);
					
					if($DatFacturaDetalle->FdeTipo<>"T"){
						$pdf->Cell(25,5,number_format($DatFacturaDetalle->FdeValorVentaUnitario,2),$lineas,0,"R");
					}
					
					if($DatFacturaDetalle->FdeTipo<>"T"){
						$pdf->Cell(25,5,number_format($DatFacturaDetalle->FdeValorVenta,2),$lineas,1,"R");
					}
		
					if(!empty($detalle2)){
			
						$pdf->Cell(10,5,"",$lineas,0);				
						$pdf->Cell(30,5,"",$lineas,0);
						$pdf->Cell(100,5,($detalle2),$lineas,0);
						$pdf->Cell(25,5,"",$lineas,0,"R");
						$pdf->Cell(25,5,"",$lineas,1,"R");
						
					}
					
					if(!empty($detalle3)){
		
						$pdf->Cell(10,5,"",$lineas,0);				
						$pdf->Cell(30,5,"",$lineas,0);
						$pdf->Cell(100,5,($detalle3),$lineas,0);
						$pdf->Cell(25,5,"",$lineas,0,"R");
						$pdf->Cell(25,5,"",$lineas,1,"R");
		
					}
					
				
				
				}
				
				
				
				
				
			
			}else{
				
				//PRIMERA SEPARACION
				list($Vehiculo,$Accesorios) = explode("c/",$DatFacturaDetalle->FdeDescripcion);
				
			
		
					$pdf->Cell(10,5,"",$lineas,0);				
					$pdf->Cell(30,5,"",$lineas,0);
					$pdf->Cell(100,5,($Vehiculo),$lineas,0);
					$pdf->Cell(25,5,"",$lineas,0,"R");
					$pdf->Cell(25,5,"",$lineas,1,"R");
					
			
				
				unset($ArrNombreProductoPalabras);		
				$ArrNombreProductoPalabras = explode(" ",stripslashes( $Accesorios));
	
					$palabra = 1;
					$detalle1 = "";
					$detalle2 = "";
					$detalle3 =  "";
					
					foreach($ArrNombreProductoPalabras as $DatNombreProductoPalabra){
											
						if($palabra<10){						
							$detalle1 .= $DatNombreProductoPalabra." ";
							
						}else if($palabra<20){						
							$detalle2 .= $DatNombreProductoPalabra." ";
							
						}else{						
							$detalle3 .= $DatNombreProductoPalabra." ";
							
						}
						
						$palabra++;
						
					}
					
				$detalle1 = trim($detalle1);
				$detalle2 = trim($detalle2);
				$detalle3 = trim($detalle3);
				
				
				if($DatFacturaDetalle->FdeTipo<>"T"){
					$pdf->Cell(10,5,$DatFacturaDetalle->FdeCantidad,$lineas,0);	
				}else{
					$pdf->Cell(10,5,"",$lineas,0);	
				}
				
				$pdf->Cell(30,5,$DatFacturaDetalle->FdeUnidadMedida,$lineas,0);
				$pdf->Cell(100,5,$detalle1,$lineas,0);
				
				if($DatFacturaDetalle->FdeTipo<>"T"){
					$pdf->Cell(25,5,number_format($DatFacturaDetalle->FdeValorVentaUnitario,2),$lineas,0,"R");
				}
				
				if($DatFacturaDetalle->FdeTipo<>"T"){
					$pdf->Cell(25,5,number_format($DatFacturaDetalle->FdeValorVenta,2),$lineas,1,"R");
				}
	
				if(!empty($detalle2)){
		
					$pdf->Cell(10,5,"",$lineas,0);				
					$pdf->Cell(30,5,"",$lineas,0);
					$pdf->Cell(100,5,($detalle2),$lineas,0);
					$pdf->Cell(25,5,"",$lineas,0,"R");
					$pdf->Cell(25,5,"",$lineas,1,"R");
					
				}
				
				if(!empty($detalle3)){
	
					$pdf->Cell(10,5,"",$lineas,0);				
					$pdf->Cell(30,5,"",$lineas,0);
					$pdf->Cell(100,5,($detalle3),$lineas,0);
					$pdf->Cell(25,5,"",$lineas,0,"R");
					$pdf->Cell(25,5,"",$lineas,1,"R");
	
				}
				
			}
			
			
			//$TotalBruto = $TotalBruto + $DatFacturaDetalle->FdeImporte;		
			
//		  }else{
//                    $ArrMateriales[] = $DatFacturaDetalle;
//			}
		 
		
	}
}

//if(!empty($ArrMateriales )){
//	
//	$MaterialImporte = 0;
//            
//	foreach($ArrMateriales as $DatMaterial){
//	
//			if($InsFactura->MonId<>$EmpresaMonedaId and (!empty($InsFactura->FacTipoCambio) )){
//				
//				$DatFacturaDetalle->FdeImporte = ($DatMaterial->FdeImporte / $InsFactura->FacTipoCambio);
//				$DatFacturaDetalle->FdePrecio = ($DatMaterial->FdePrecio  / $InsFactura->FacTipoCambio);
//				
//			}
//						
//			if($DatFacturaDetalle->FdeTipo<>"T"){
//				$pdf->Cell(10,5,$DatMaterial->FdeCantidad,$lineas,0);	
//			}else{
//				$pdf->Cell(10,5,"",$lineas,0);	
//			}
//			
//			
//			$pdf->Cell(30,5,$DatMaterial->FdeUnidadMedida,$lineas,0);
//			$pdf->Cell(100,5,stripslashes( $DatMaterial->FdeDescripcion),$lineas,0);
//			
//			if($DatFacturaDetalle->FdeTipo<>"T"){
//				$pdf->Cell(2,5,number_format($DatMaterial->FdePrecio,2),$lineas,0,"R");
//			}
//			
//			if($DatFacturaDetalle->FdeTipo<>"T"){
//				$pdf->Cell(25,5,number_format($DatMaterial->FdeImporte,2),$lineas,1,"R");
//			}
//			
//			$TotalBruto = $TotalBruto + $DatMaterial->FdeImporte;		
//		
//		$MaterialImporte += $DatMaterial->FdeImporte;
//	}
//	
//		
//}

$TotalLineas = count($InsFactura->FacturaDetalle);

if($TotalLineas<10 and empty($InsFactura->OvvId)){
	
	$TotalLineasFaltantes = 10 - $TotalLineas;
	
	for($i=1;$i<=$TotalLineasFaltantes;$i++){
			
			
		$pdf->Cell(10,5,"",$lineas,0,"C");
		$pdf->Cell(30,5,"",$lineas,0,"C");
		$pdf->Cell(100,5,"",$lineas,0,"C");
		$pdf->Cell(25,5,"",$lineas,0,"C");
		$pdf->Cell(25,5,"",$lineas,1,"C");
	
		
	}

}


//$pdf->Ln(5);
//$pdf->SetLeftMargin(10);


if(!empty($InsFactura->FacFechaVencimiento)){
	

	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(40,5,"Fecha de Vencimiento: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(30,5,$InsFactura->FacFechaVencimiento,$lineas,0);	

}

//$pdf->Ln(5);
//$pdf->SetLeftMargin(10);

if(!empty($InsFactura->EinVIN)){
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"VIN: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->EinVIN,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"Placa: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->EinPlaca,$lineas,1);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(35,5,"Marca/Modelo/Version: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(70,5,$InsFactura->VmaNombre." ".$InsFactura->VmoNombre." ".$InsFactura->VveNombre,$lineas,1);


}

//$pdf->Ln(5);
//$pdf->SetLeftMargin(10);

if(!empty($InsFactura->FinId)){
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"O.T.: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(30,5,$InsFactura->FinId,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"Kilom.: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(30,5,$InsFactura->FinVehiculoKilometraje." ".(!empty($InsFactura->FinVehiculoKilometraje)?'KM':''),$lineas,0);
	
}

if(!empty($InsFactura->AmoId)){
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"Ficha: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(30,5,$InsFactura->AmoId,$lineas,0);
	
}



if(!empty($InsFactura->OvvId)){
	
	$pdf->Cell(40,5,"",$lineas,0);		
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Marca: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->FacDatoAdicional1,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Tracción: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->FacDatoAdicional2,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Modelo: ",$lineas,0);	
	 $pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->FacDatoAdicional3,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Carroceria: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->FacDatoAdicional4,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Año Fabric.: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->FacDatoAdicional5,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Puertas: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->FacDatoAdicional6,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Motor: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->FacDatoAdicional7,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Combustible: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->FacDatoAdicional8,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Cilindros: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->FacDatoAdicional9,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Peso Bruto: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->FacDatoAdicional10,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Ejes: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->FacDatoAdicional11,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Carga Util: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->FacDatoAdicional12,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Chasis: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->FacDatoAdicional13,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Peso Seco: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->FacDatoAdicional14,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Color: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->FacDatoAdicional15,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Alto: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->FacDatoAdicional16,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Cilindrada: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->FacDatoAdicional17,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Largo: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->FacDatoAdicional18,$lineas,1);
	


	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Asientos: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->FacDatoAdicional19,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Ancho: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->FacDatoAdicional20,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Cap. Pasajeros: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->FacDatoAdicional21,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Dist. Ejes: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->FacDatoAdicional22,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Poliza: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->FacDatoAdicional23,$lineas,0);
	
}



//$pdf->Ln(5);
//$pdf->SetLeftMargin(10);
//
//$pdf->Cell(190,5,"(*) Productos en oferta con precio especial disponibles hasta agotar stock",1,0);



if(!empty($InsFactura->FacObservacionImpresa)){

	$pdf->Ln(5);
	$pdf->SetLeftMargin(10);	
	$pdf->Cell(110,5,$InsFactura->FacObservacionImpresa,$lineas,0);
	
}

//
//if($InsFactura->FacIncluyeImpuesto==2){
//    
//	$SubTotal = round($TotalBruto,6);
//	$Impuesto = round(($SubTotal * ($InsFactura->FacPorcentajeImpuestoVenta/100)),6);
//	$Total = round($SubTotal + $Impuesto,6);
//
//}else{
//
//	$Total = round($TotalBruto,6);	
//	$SubTotal = round($Total / (($InsFactura->FacPorcentajeImpuestoVenta/100)+1),6);
//	$Impuesto = round(($Total - $SubTotal),6);
//
//}

if($InsFactura->FacObsequio==1){
	
	$pdf->SetAlpha(0.3);
	//Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false, $alt=false, $altimgs=array()) {
	$pdf->Image('../../imagenes/transferencia_gratuita.png', 65, 60, 80, 70, 'PNG', '', '', true, 150, '', false, false, 0, true, false, false);
//$mask = $pdf->Image('../../imagenes/transferencia_gratuita.png', 50, 140, 100, '', '', '', '', false, 300, '', true);
	$pdf->SetAlpha(1);

	$pdf->Ln(5);
	$pdf->SetLeftMargin(10);

	$pdf->Cell(110,5,$InsFactura->FacLeyenda." ".number_format($InsFactura->FacTotalGratuito,2),$lineas,1);
	
	//$pdf->Cell(110,5,"ENTREGA A TITULO GRATUITO.",$lineas,1);
//	$pdf->Cell(110,5,"VALOR REFERENCIAL ".number_format($Total,2),$lineas,1);
//
//	$SubTotal = 0;
//	$Impuesto = 0;
//	$Total = 0;
	
}



$pdf->SetAlpha(0.1);
$pdf->Image('../../imagenes/comprobantes/comprobante_fondo.png', 70, 60, 80, 70, 'PNG', '', '', true, 150, '', false, false, 0, true, false, false);
$pdf->SetAlpha(1);

$pdf->Ln(5);
$pdf->SetLeftMargin(10);
$pdf->SetAlpha(0.6);
$pdf->Image('../../imagenes/retencion.png', 65, '', 80, 70, 'PNG', '', '', true, 150, '', false, false, 0, true, false, false);
$pdf->SetAlpha(1);



$pdf->Ln(15);
$pdf->SetLeftMargin(10);

$pdf->SetFont('times', 'B', 8);

$Total = round($InsFactura->FacTotal,2);
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

$pdf->Cell(190,5,"SON: ".$numalet->letra()." CON ".$parte_decimal."/100"." ".$InsFactura->MonNombre,1,1,'L');




$pdf->SetFont('times', 'B', 8);





//FILA
$pdf->Cell(90,5,"",$lineas,0,'L');
$pdf->Cell(30,5,"",$lineas,0,'R');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"Descuento Global: ",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsFactura->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsFactura->FacTotalDescuento,2),1,1,'R');

//FILA
$pdf->SetFont('times', 'B', 12);
$pdf->Cell(120,5,"Para una mejor atención comuníquese con nosotros",$lineas,0,'L');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"Total Gravado",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsFactura->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsFactura->FacTotalGravado,2),1,1,'R');

//FILA
$pdf->SetFont('times', 'B', 12);
$pdf->Cell(120,5,"para separar su cita llamando a los teléfonos: ",$lineas,0,'L');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"Total No Gravado: ",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsFactura->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsFactura->FacTotalNoGravado,2),1,1,'R');

//FILA
$pdf->SetFont('times', 'B', 12);
$pdf->Cell(120,5,"Diego: 950312564",$lineas,0,'L');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"Total Exonerado: ",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsFactura->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsFactura->FacTotalExonerado,2),1,1,'R');

////FILA
//$pdf->Cell(120,5,"",$lineas,0,'C');
//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(35,5,"Total Otros Cargos: ",$lineas,0,'R');
//$pdf->SetFont('times', 'N', 8);
//$pdf->Cell(10,5,$InsNotaCredito->MonSimbolo,$lineas,0,'L');
//$pdf->Cell(25,5,number_format(0,2),1,1,'R');

//FILA
$pdf->SetFont('times', 'B', 12);
$pdf->Cell(120,5,"Jose Luis 950309755",$lineas,0,'L');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"Total IGV ".number_format($InsFactura->FacPorcentajeImpuestoVenta,2)."%",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsFactura->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsFactura->FacImpuesto,2),1,1,'R');

//FILA
$pdf->Cell(120,5,"",$lineas,0,'C');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"Importe Total: ",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsFactura->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsFactura->FacTotal,2),1,1,'R');


/*
$pdf->Cell(120,5,"",$lineas,0,'R');
$pdf->Cell(35,5,"SubTotal: ",$lineas,0,'R');
$pdf->Cell(10,5,$InsFactura->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsFactura->FacSubTotal,2),1,1,'R');

$pdf->Cell(120,5,"",$lineas,0,'R');
$pdf->Cell(35,5,"Impuesto ".$EmpresaImpuestoVenta."%",$lineas,0,'R');
$pdf->Cell(10,5,$InsFactura->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsFactura->FacImpuesto,2),1,1,'R');

$pdf->Cell(120,5,"",$lineas,0,'R');
$pdf->Cell(35,5,"Total: ",$lineas,0,'R');
$pdf->Cell(10,5,$InsFactura->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsFactura->FacTotal,2),1,1,'R');*/






$pdf->Ln(5);
$pdf->SetLeftMargin(10);
$pdf->Image('../../imagenes/comprobante_pie.png', 10, '', 90, 28, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);



/*
GENERAR CODIGO QR
*/
$ArchivoFacetaCodigoQR = $InsFactura->FtaNumero."-".$InsFactura->FacId.'_QR.png'; 
$RutaFacetaCodigoQR = "../../generados/comprobantes/".$ArchivoFacetaCodigoQR; 
// generating 

if (file_exists($RutaFacetaCodigoQR)) { 
	unlink($RutaFacetaCodigoQR); 
}

// QRcode::png($InsFactura->FtaNumero."-".$InsFactura->FacId, $RutaFacetaCodigoQR); 
$CodigoQR = $EmpresaCodigo.'|1|'.$InsFactura->FtaNumero.'|'.$InsFactura->FacId.'|'.number_format($InsFactura->FacImpuesto,2, '.', '').'|'.number_format($InsFactura->FacTotal,2, '.', '').'|'.FncCambiaFechaAMysql($InsFactura->FacFechaEmision).'|1|'.$InsFactura->CliNumeroDocumento.'|'.$InsFactura->FacSunatRespuestaEnvioDigestValue.'|'.$InsFactura->FacSunatRespuestaEnvioSignatureValue;

$barcodeobj = new TCPDF2DBarcode($CodigoQR, 'PDF417');
$data = $barcodeobj->getBarcodePngData(10,5,array(0,0,0));
$im = imagecreatefromstring($data);
$resp = imagepng($im, $RutaFacetaCodigoQR);
imagedestroy($im);


$pdf->Image($RutaFacetaCodigoQR, 120, '', 75, 25, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);




$pdf->Ln(25);
$pdf->SetLeftMargin(10);

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(125,3,"",$lineas,0,'C',0,0);
$pdf->Cell(50,3,"Timbre Electronico",$lineas,1,'C',0,0);

$pdf->SetFont('times', '', 6);
$pdf->Cell(125,3,"",$lineas,0,'C',0,0);
$pdf->Cell(50,3,"Representación impresa de la Factura Electrónica",$lineas,1,'C',0,0);

//$pdf->SetFont('times', '', 6);
//$pdf->Cell(125,3,"",$lineas,0,'C',0,0);
//$pdf->Cell(50,3,"Autorizado mediante la resolución RS N°374 - 2013",$lineas,1,'C',0,0);
//

$pdf->Ln(2);
$pdf->SetLeftMargin(10);
			
//$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 4, 'color' => array(0, 0, 0)));
//$pdf->SetFillColor(255,255,128);
//$pdf->SetTextColor(0,0,128);

$pdf->SetFont('times', 'B', 6);
$pdf->Cell(190,5,"Su comprobante electronico podra ser consultado en nuestra pagina web http://www.cyc.com.pe/comprobantes",1,1,'L',0,0);
//$pdf->Ln();
		
//		$pdf->writeHTMLCell(0, 0, 0, 0, 'Curabitur at porta dui...');
//		$pdf->writeHTMLCell(0, 0, 0, 0, 'Lorem ipsum... <img src="'.$RutaFacturaCodigoQR.'" /> Curabitur at porta dui...');

// set style for barcode
//$style = array(
//    'border' => 1,
//    'vpadding' => '1',
//    'hpadding' => '1',
//    'fgcolor' => array(0,0,0),
//    'bgcolor' => false, //array(255,255,255)
//    'module_width' => 1, // width of a single module in points
//    'module_height' => 1 // height of a single module in points
//);

//$pdf->write2DBarcode($InsFactura->FtaNumero."-".$InsFactura->FacId, 'QRCODE', 80, 90, 0, 30, $style, 'N');
//$pdf->write2DBarcode($InsFactura->FtaNumero."-".$InsFactura->FacId, 'QRCODE',10,150,30,30,$style);
//$pdf->Text(10, 150, $InsFactura->FtaNumero."-".$InsFactura->FacId);

//
//$pdf->SetY(700);
//

//$pdf->Ln(30);
//$pdf->SetLeftMargin(10);
//			
//			

//		
//			
			
			
			
$pdf->Output($NOMBRE.".pdf");



?>