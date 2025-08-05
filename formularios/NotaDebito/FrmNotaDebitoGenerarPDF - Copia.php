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
require_once($InsProyecto->MtdRutLibrerias().'phpqrcode/qrlib.php');
require_once($InsProyecto->MtdRutLibrerias().'TCPDF-master/tcpdf_barcodes_2d.php');


$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];
$GET_TiempoImpresion = $_GET['TiempoImpresion'];

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebito.php');
//
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebitoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');

$InsNotaDebito = new ClsNotaDebito();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//echo "adsfadfs";
//Obteniendo datos de factura
$InsNotaDebito->NdbId = $GET_id;
$InsNotaDebito->NdtId = $GET_ta;
$InsNotaDebito = $InsNotaDebito->MtdObtenerNotaDebito();

$NOMBRE = $EmpresaCodigo.'-08-'.$InsNotaDebito->NdtNumero.'-'.$InsNotaDebito->NdbId;



if($InsNotaDebito->MonId<>$EmpresaMonedaId){
	
	$InsNotaDebito->NdbTotalGravado = round($InsNotaDebito->NdbTotalGravado/$InsNotaDebito->NdbTipoCambio,2);
	$InsNotaDebito->NdbTotalExonerado = round($InsNotaDebito->NdbTotalExonerado/$InsNotaDebito->NdbTipoCambio,2);
	$InsNotaDebito->NdbTotalGratuito = round($InsNotaDebito->NdbTotalGratuito/$InsNotaDebito->NdbTipoCambio,2);
	$InsNotaDebito->NdbTotalDescuento = round($InsNotaDebito->NdbTotalDescuento/$InsNotaDebito->NdbTipoCambio,2);
	
	$InsNotaDebito->NdbTotalPagar = round($InsNotaDebito->NdbTotalPagar/$InsNotaDebito->NdbTipoCambio,2);
	$InsNotaDebito->NdbTotalDescuento = round($InsNotaDebito->NdbTotalDescuento/$InsNotaDebito->NdbTipoCambio,2);
	
	$InsNotaDebito->NdbSubTotal = round($InsNotaDebito->NdbSubTotal/$InsNotaDebito->NdbTipoCambio,2);	
	$InsNotaDebito->NdbImpuesto = round($InsNotaDebito->NdbImpuesto/$InsNotaDebito->NdbTipoCambio,2);
	$InsNotaDebito->NdbTotal = round($InsNotaDebito->NdbTotal/$InsNotaDebito->NdbTipoCambio,2);	
	
}
	
switch($InsNotaDebito->NdbTipo){
	
	case "2": //NOTA DE DEBITO
		$TipoDocumento = "Factura";
	break;
	
	case "3"://BOLETA
		$TipoDocumento = "Boleta";
	break;
	
}

/*
GENERAR CODIGO QR
*/
//$ArchivoNotaDebitoCodigoQR = $InsNotaDebito->NdtNumero."-".$InsNotaDebito->NdbId.'_QR.png'; 
//$RutaNotaDebitoCodigoQR = "../../generados/comprobantes/".$ArchivoNotaDebitoCodigoQR; 
//// generating 
//if (!file_exists($RutaNotaDebitoCodigoQR)) { 
//  QRcode::png($InsNotaDebito->NdtNumero."-".$InsNotaDebito->NdbId, $RutaNotaDebitoCodigoQR); 
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
		global $InsNotaDebito;
		global $EmpresaTelefono;
		
		// Logo
		$image_file = '../../imagenes/comprobantes/comprobante_logotipo.png';
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
			$this->Cell(70,5,"NOTA DE DEBITO ELECTRONICA",$lineas,1,'C');

		$this->SetFont('times', '', 10);
		$this->Cell(45,5,'',$lineas,0,'C',0);
		$this->SetFont('times', '', 6);
		$this->Cell(75,5,$EmpresaProvincia." - ".$EmpresaDistrito." - ".$EmpresaDepartamento,$lineas,0,'C');
//		
//		
			$this->SetFont('times', 'B', 10);
			$this->Cell(70,5,"N°. ".$InsNotaDebito->NdtNumero."-".$InsNotaDebito->NdbId,$lineas,1,'C');
			
			
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
		global $InsNotaDebito;
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
//			<td style="width:150px; padding: 2px; text-align:left;"><img src="'.$RutaNotaDebitoCodigoQR.'" border="0" align="top" alt="Nexnet" /></td>
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
//		$this->write2DBarcode($InsNotaDebito->NdtNumero."-".$InsNotaDebito->NdbId, 'QRCODE', 0, 0, 0, 30, $style, 'N');
		
	}
}


$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf = new TCPDF();

//$pdf->SetHeaderData('logotipo.png', PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));

// set document information
$pdf->SetCreator($EmpresaNombre);
$pdf->SetAuthor($EmpresaNombre);
$pdf->SetTitle($InsNotaDebito->NdtNumero."-".$InsNotaDebito->NdbId);
$pdf->SetSubject("Nota de Debito Electronica");
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
//	$pdf->Cell(90,5,"NOTA DE DEBITO ELECTRONICA",$lineas,1,'C');
//
//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(100,5,$EmpresaProvincia." ".$EmpresaDistrito." ".$EmpresaDepartamento,$lineas,0,'C');
//
//
//	$pdf->SetFont('times', 'B', 12);
//	$pdf->Cell(90,5,"No. ".$InsNotaDebito->NdtNumero."-".$InsNotaDebito->NdbId,$lineas,1,'C');
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
$pdf->RoundedRect(10, 30, 190, 15, 2, '1111', NULL);

//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(20,5,"Señor(es): ",$lineas,0);
//$pdf->SetFont('times', 'N', 8);
//$pdf->Cell(170,5,$InsNotaDebito->CliNombre." ".$InsNotaDebito->CliApellidoPaterno." ".$InsNotaDebito->CliApellidoMaterno,$lineas,1);
//



$NombreCliente = $InsNotaDebito->CliNombre." ".$InsNotaDebito->CliApellidoPaterno." ".$InsNotaDebito->CliApellidoMaterno;

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
$pdf->Cell(80,5,$InsNotaDebito->CliNumeroDocumento,$lineas,0);

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(20,5,"No. Guia: ",$lineas,0);
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(20,5,"-",$lineas,0);

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(20,5,"Fecha: ",$lineas,0);
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(20,5,$InsNotaDebito->NdbFechaEmision,$lineas,1);




$DireccionCliente = $InsNotaDebito->NdbDireccion;

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
* NOTA DE DEBITO DETALLE
*/
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(10,5,"CANT.",1,0,"C");
$pdf->Cell(30,5,"UNIDAD",1,0,"C");
$pdf->Cell(100,5,"DESCRIPCION",1,0,"C");
$pdf->Cell(25,5,"V. UNIT.",1,0,"C");
$pdf->Cell(25,5,"VALOR TOTAL",1,1,"C");
$pdf->SetFont('times', 'N', 8);


$ArrMateriales = array();

if(!empty($InsNotaDebito->NotaDebitoDetalle)){
	foreach($InsNotaDebito->NotaDebitoDetalle as $DatNotaDebitoDetalle){
		
		if($DatNotaDebitoDetalle->NddTipo <> "M"){
		    
			if($InsNotaDebito->MonId<>$EmpresaMonedaId and (!empty($InsNotaDebito->NdbTipoCambio) )){

				$DatNotaDebitoDetalle->NddImporte = ($DatNotaDebitoDetalle->NddImporte / $InsNotaDebito->NdbTipoCambio);
				$DatNotaDebitoDetalle->NddPrecio = ($DatNotaDebitoDetalle->NddPrecio  / $InsNotaDebito->NdbTipoCambio);

				$DatNotaDebitoDetalle->NddValorVenta = ($DatNotaDebitoDetalle->NddValorVenta / $InsNotaDebito->NdbTipoCambio);
				$DatNotaDebitoDetalle->NddValorVentaUnitario = ($DatNotaDebitoDetalle->NddValorVentaUnitario  / $InsNotaDebito->NdbTipoCambio);

			}

						
			if(empty($InsNotaDebito->OvvId)){
				
				unset($ArrNombreProductoPalabras);		
				$ArrNombreProductoPalabras = explode(" ",stripslashes( $DatNotaDebitoDetalle->NddDescripcion));
	
					$palabra = 1;
					$detalle1 = "";
					$detalle2 = "";
					$detalle3 =  "";
					
					foreach($ArrNombreProductoPalabras as $DatNombreProductoPalabra){
											
						if($palabra<15){						
							$detalle1 .= $DatNombreProductoPalabra." ";
							
						}else if($palabra<30){						
							$detalle2 .= $DatNombreProductoPalabra." ";
							
						}else{						
							$detalle3 .= $DatNombreProductoPalabra." ";
							
						}
						
						$palabra++;
						
					}
					
				$detalle1 = trim($detalle1);
				$detalle2 = trim($detalle2);
				$detalle3 = trim($detalle3);
				
				
				if($DatNotaDebitoDetalle->NddTipo<>"T"){
					$pdf->Cell(10,5,$DatNotaDebitoDetalle->NddCantidad,$lineas,0);	
				}else{
					$pdf->Cell(10,5,"",$lineas,0);	
				}
				
				
				$pdf->Cell(30,5,$DatNotaDebitoDetalle->NddUnidadMedida,$lineas,0);
				$pdf->Cell(100,5,($detalle1)."",$lineas,0);
				
				if($DatNotaDebitoDetalle->NddTipo<>"T"){
					$pdf->Cell(25,5,number_format($DatNotaDebitoDetalle->NddValorVentaUnitario,2),$lineas,0,"R");
				}
				
				if($DatNotaDebitoDetalle->NddTipo<>"T"){
					$pdf->Cell(25,5,number_format($DatNotaDebitoDetalle->NddValorVenta,2),$lineas,1,"R");
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
				
			}else{
				
				//PRIMERA SEPARACION
				list($Vehiculo,$Accesorios) = explode("c/",$DatNotaDebitoDetalle->NddDescripcion);
		
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
				
				
				if($DatNotaDebitoDetalle->NddTipo<>"T"){
					$pdf->Cell(10,5,$DatNotaDebitoDetalle->NddCantidad,$lineas,0);	
				}else{
					$pdf->Cell(10,5,"",$lineas,0);	
				}
				
				$pdf->Cell(30,5,$DatNotaDebitoDetalle->NddUnidadMedida,$lineas,0);
				$pdf->Cell(100,5,$detalle1,$lineas,0);
				
				if($DatNotaDebitoDetalle->NddTipo<>"T"){
					$pdf->Cell(25,5,number_format($DatNotaDebitoDetalle->NddValorVentaUnitario,2),$lineas,0,"R");
				}
				
				if($DatNotaDebitoDetalle->NddTipo<>"T"){
					$pdf->Cell(25,5,number_format($DatNotaDebitoDetalle->NddValorVenta,2),$lineas,1,"R");
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
			
			
			//$TotalBruto = $TotalBruto + $DatNotaDebitoDetalle->NddImporte;		
			
		  }else{
                    $ArrMateriales[] = $DatNotaDebitoDetalle;
			}
		 
		
	}
}

if(!empty($ArrMateriales )){
	
	$MaterialImporte = 0;
            
	foreach($ArrMateriales as $DatMaterial){
	
			if($InsNotaDebito->MonId<>$EmpresaMonedaId and (!empty($InsNotaDebito->NdbTipoCambio) )){
				
				$DatNotaDebitoDetalle->NddImporte = ($DatMaterial->NddImporte / $InsNotaDebito->NdbTipoCambio);
				$DatNotaDebitoDetalle->NddPrecio = ($DatMaterial->NddPrecio  / $InsNotaDebito->NdbTipoCambio);
				
			}
						
			if($DatNotaDebitoDetalle->NddTipo<>"T"){
				$pdf->Cell(10,5,$DatMaterial->NddCantidad,$lineas,0);	
			}else{
				$pdf->Cell(10,5,"",$lineas,0);	
			}
			
			
			$pdf->Cell(30,5,$DatMaterial->NddUnidadMedida,$lineas,0);
			$pdf->Cell(100,5,stripslashes( $DatMaterial->NddDescripcion),$lineas,0);
			
			if($DatNotaDebitoDetalle->NddTipo<>"T"){
				$pdf->Cell(2,5,number_format($DatMaterial->NddPrecio,2),$lineas,0,"R");
			}
			
			if($DatNotaDebitoDetalle->NddTipo<>"T"){
				$pdf->Cell(25,5,number_format($DatMaterial->NddImporte,2),$lineas,1,"R");
			}
			
			$TotalBruto = $TotalBruto + $DatMaterial->NddImporte;		
		
		$MaterialImporte += $DatMaterial->NddImporte;
	}
	
		
}

$TotalLineas = count($InsNotaDebito->NotaDebitoDetalle);

if($TotalLineas<15 and empty($InsNotaDebito->OvvId)){
	
	$TotalLineasFaltantes = 15 - $TotalLineas;
	
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


if(!empty($InsNotaDebito->NdbFechaVencimiento)){
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(40,5,"Fecha de Vencimiento: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(30,5,$InsNotaDebito->NdbFechaVencimiento,$lineas,0);
	

}

//$pdf->Ln(5);
//$pdf->SetLeftMargin(10);

if(!empty($InsNotaDebito->EinVIN)){
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"VIN: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->EinVIN,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"Placa: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->EinPlaca,$lineas,1);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(35,5,"Marca/Modelo/Version: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(70,5,$InsNotaDebito->VmaNombre." ".$InsNotaDebito->VmoNombre." ".$InsNotaDebito->VveNombre,$lineas,0);


}

//$pdf->Ln(5);
//$pdf->SetLeftMargin(10);

if(!empty($InsNotaDebito->FinId)){
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"O.T.: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(30,5,$InsNotaDebito->FinId,$lineas,0);
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"Kilom.: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(30,5,$InsNotaDebito->FinVehiculoKilometraje." ".(!empty($InsNotaDebito->FinVehiculoKilometraje))?'KM':'',$lineas,1);
	
}



//$pdf->Ln(5);
//$pdf->SetLeftMargin(10);

if(!empty($InsNotaDebito->AmoId)){
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"Ficha: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(30,5,$InsNotaDebito->AmoId,$lineas,0);
	
}

//$pdf->Ln(5);
//$pdf->SetLeftMargin(10);
//$pdf->Cell(190,5,"(*) Productos en oferta con precio especial disponibles hasta agotar stock",1,0);






if(!empty($InsNotaDebito->OvvId)){
	
	$pdf->Cell(40,5,"",$lineas,0);		
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Marca: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional1,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Tracción: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional2,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Modelo: ",$lineas,0);	
	 $pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional3,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Carroceria: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional4,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Año Fabric.: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional5,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Puertas: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional6,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Motor: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional7,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Combustible: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional8,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Cilindros: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional9,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Peso Bruto: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional10,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Ejes: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional11,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Carga Util: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional12,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Chasis: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional13,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Peso Seco: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional14,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Color: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional15,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Alto: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional16,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Cilindrada: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional17,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Largo: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional18,$lineas,1);
	


	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Asientos: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional19,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Ancho: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional20,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Cap. Pasajeros: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional21,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Dist. Ejes: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional22,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Poliza: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional23,$lineas,0);
	
	
	if(count($InsNotaDebito->OrdenVentaVehiculoPropietario)>1){

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
				
			foreach($InsNotaDebito->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
				
				if($InsNotaDebito->CliId<> $DatOrdenVentaVehiculoPropietario->CliId){	
	
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




if(!empty($InsNotaDebito->NdbMotivoCodigo)){

 
	$pdf->Ln(5);
	$pdf->SetLeftMargin(10);
	
	$ArrMotivoPalabras = explode(" ",$InsNotaDebito->NdbMotivo);
	
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
	$pdf->Cell(15,5,"Sustento: ",$lineas,0);
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
	

//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(20,5,"Sustento: ",$lineas,0);	
//	$pdf->SetFont('times', 'N', 8);
//	$pdf->Cell(110,5,$InsNotaDebito->NdbMotivo,$lineas,0);

	
}

if(!empty($InsNotaDebito->NdbObservacionImpresa)){
		
	$pdf->Ln(5);
	$pdf->SetLeftMargin(10);
	$pdf->Cell(110,5,$InsNotaDebito->NdbObservacionImpresa,$lineas,1);
	
}

//
//if($InsNotaDebito->NdbIncluyeImpuesto==2){
//    
//	$SubTotal = round($TotalBruto,6);
//	$Impuesto = round(($SubTotal * ($InsNotaDebito->NdbPorcentajeImpuestoVenta/100)),6);
//	$Total = round($SubTotal + $Impuesto,6);
//
//}else{
//
//	$Total = round($TotalBruto,6);	
//	$SubTotal = round($Total / (($InsNotaDebito->NdbPorcentajeImpuestoVenta/100)+1),6);
//	$Impuesto = round(($Total - $SubTotal),6);
//
//}



$pdf->SetAlpha(0.1);
//Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false, $alt=false, $altimgs=array()) {
$pdf->Image('../../imagenes/comprobantes/comprobante_fondo.png', 70, 60, 80, 70, 'PNG', '', '', true, 150, '', false, false, 0, true, false, false);
//$mask = $pdf->Image('../../imagenes/transferencia_gratuita.png', 50, 140, 100, '', '', '', '', false, 300, '', true);
$pdf->SetAlpha(1);


//$pdf->Ln(25);
//$pdf->SetLeftMargin(10);
//
//$pdf->SetAlpha(0.4);
//$pdf->Image('../../imagenes/retencion.png', 30,122, 150, 70, 'PNG', '', '', true, 150, '', false, false, 0, true, false, false);
//
//$pdf->SetAlpha(1);

//$pdf->Ln(15);
//$pdf->SetLeftMargin(10);

$pdf->SetFont('times', 'B', 8);


$Total = round($InsNotaDebito->NdbTotal,2);
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

$pdf->Cell(190,5,"SON: ".$numalet->letra()." CON ".$parte_decimal."/100"." ".$InsNotaDebito->MonNombre,1,1,'L');



//FILA
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(90,5,"DOCUMENTO(S) DE REFERENCIA:",$lineas,0,'L');
$pdf->Cell(30,5,"",$lineas,0,'R');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"Descuento Global: ",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaDebito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaDebito->NdbTotalDescuento,2),1,1,'R');

//FILA
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(30,5,"Tipo Doc.",1,0,'C');
$pdf->Cell(30,5,"Numero",1,0,'C');
$pdf->Cell(30,5,"Fecha",1,0,'C');
$pdf->Cell(30,5,"",$lineas,0,'C');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"Total Gravado",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaDebito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaDebito->NdbTotalGravado,2),1,1,'R');

//FILA
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(30,5,$TipoDocumento,1,0,'C');
$pdf->Cell(30,5,$InsNotaDebito->DtaNumero."-".$InsNotaDebito->DocId,1,0,'C');
$pdf->Cell(30,5,$InsNotaDebito->DocFechaEmision,1,0,'C');
$pdf->Cell(30,5,"",$lineas,0,'C');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"Total No Gravado: ",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaDebito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaDebito->NdbTotalNoGravado,2),1,1,'R');

//FILA
$pdf->Cell(120,5,"",$lineas,0,'C');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"Total Exonerado: ",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaDebito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaDebito->NdbTotalExonerado,2),1,1,'R');

////FILA
//$pdf->Cell(120,5,"",$lineas,0,'C');
//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(35,5,"Total Otros Cargos: ",$lineas,0,'R');
//$pdf->SetFont('times', 'N', 8);
//$pdf->Cell(10,5,$InsNotaDebito->MonSimbolo,$lineas,0,'L');
//$pdf->Cell(25,5,number_format(0,2),1,1,'R');

//FILA
$pdf->Cell(120,5,"",$lineas,0,'C');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"Total IGV ".$EmpresaImpuestoVenta."%",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaDebito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaDebito->NdbImpuesto,2),1,1,'R');

//FILA
$pdf->Cell(120,5,"",$lineas,0,'C');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"Importe Total: ",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaDebito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaDebito->NdbTotal,2),1,1,'R');


$pdf->Ln(5);
$pdf->SetLeftMargin(10);
$pdf->Image('../../imagenes/comprobante_pie.png', 10, '', 90, 28, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);

/*
GENERAR CODIGO QR
*/
$ArchivoFacetaCodigoQR = $InsNotaDebito->NdtNumero."-".$InsNotaDebito->NdbId.'_QR.png'; 
$RutaFacetaCodigoQR = "../../generados/comprobantes/".$ArchivoFacetaCodigoQR; 
// generating 

if (file_exists($RutaFacetaCodigoQR)) { 
	unlink($RutaFacetaCodigoQR); 
}

// QRcode::png($InsNotaDebito->NdtNumero."-".$InsNotaDebito->NdbId, $RutaFacetaCodigoQR); 
$CodigoQR = $EmpresaCodigo.'|1|'.$InsNotaDebito->NdtNumero.'|'.$InsNotaDebito->NdbId.'|'.number_format($InsNotaDebito->NdbImpuesto,2, '.', '').'|'.number_format($InsNotaDebito->NdbTotal,2, '.', '').'|'.FncCambiaFechaAMysql($InsNotaDebito->NdbFechaEmision).'|1|'.$InsNotaDebito->CliNumeroDocumento.'|'.$InsNotaDebito->NdbSunatRespuestaEnvioDigestValue.'|'.$InsNotaDebito->NdbSunatRespuestaEnvioSignatureValue;

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
$pdf->Cell(50,3,"Representación impresa de la Nota de Crédito Electrónica",$lineas,1,'C',0,0);

$pdf->SetFont('times', '', 6);
$pdf->Cell(125,3,"",$lineas,0,'C',0,0);
//$pdf->Cell(50,3,"Autorizado mediante la resolución RS N°374 - 2013",$lineas,1,'C',0,0);
$pdf->Cell(50,3,"Autorizado mediante la resolución RS Nº 112-005-0000145",$lineas,1,'C',0,0);


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

//$pdf->write2DBarcode($InsNotaDebito->NdtNumero."-".$InsNotaDebito->NdbId, 'QRCODE', 80, 90, 0, 30, $style, 'N');
//$pdf->write2DBarcode($InsNotaDebito->NdtNumero."-".$InsNotaDebito->NdbId, 'QRCODE',10,150,30,30,$style);
//$pdf->Text(10, 150, $InsNotaDebito->NdtNumero."-".$InsNotaDebito->NdbId);

//
//$pdf->SetY(700);
//

//$pdf->Ln(30);
//$pdf->SetLeftMargin(10);
//			
//			

//		
//			
			
			
//$pdf->Output('../../generados/comprobantes/'.$NOMBRE.'.pdf', 'F');
$pdf->Output($NOMBRE.".pdf");



?>