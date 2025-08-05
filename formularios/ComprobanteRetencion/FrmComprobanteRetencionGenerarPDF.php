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

require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencionDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');


$InsComprobanteRetencion = new ClsComprobanteRetencion();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//echo "adsfadfs";
//Obteniendo datos de factura
$InsComprobanteRetencion->CrnId = $GET_id;
$InsComprobanteRetencion->CrtId = $GET_ta;
$InsComprobanteRetencion = $InsComprobanteRetencion->MtdObtenerComprobanteRetencion();

$NOMBRE = $EmpresaCodigo.'-01-'.$InsComprobanteRetencion->CrtNumero.'-'.$InsComprobanteRetencion->CrnId;

if($InsComprobanteRetencion->MonId<>$EmpresaMonedaId){
	
	$InsComprobanteRetencion->CrnTotalRetenido = round($InsComprobanteRetencion->CrnTotalRetenido/$InsComprobanteRetencion->CrnTipoCambio,2);
	
}
	
	
/*
GENERAR CODIGO QR
*/
//$ArchivoComprobanteRetencionCodigoQR = $InsComprobanteRetencion->CrtNumero."-".$InsComprobanteRetencion->CrnId.'_QR.png'; 
//$RutaComprobanteRetencionCodigoQR = "../../generados/comprobantes/".$ArchivoComprobanteRetencionCodigoQR; 
// generating 
//if (!file_exists($RutaComprobanteRetencionCodigoQR)) { 
//  QRcode::png($InsComprobanteRetencion->CrtNumero."-".$InsComprobanteRetencion->CrnId, $RutaComprobanteRetencionCodigoQR); 
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
		global $InsComprobanteRetencion;
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
			$this->Cell(70,5,"COMPROBANTE DE RETENCION ELECTRONICA",$lineas,1,'C');

		$this->SetFont('times', '', 10);
		$this->Cell(45,5,'',$lineas,0,'C',0);
		$this->SetFont('times', '', 6);
		$this->Cell(75,5,$EmpresaProvincia." - ".$EmpresaDistrito." - ".$EmpresaDepartamento,$lineas,0,'C');
//		
//		
			$this->SetFont('times', 'B', 10);
			$this->Cell(70,5,"N°. ".$InsComprobanteRetencion->CrtNumero."-".$InsComprobanteRetencion->CrnId,$lineas,1,'C');
			
			
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
		global $InsComprobanteRetencion;
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
//			<td style="width:150px; padding: 2px; text-align:left;"><img src="'.$RutaComprobanteRetencionCodigoQR.'" border="0" align="top" alt="Nexnet" /></td>
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
//		$this->write2DBarcode($InsComprobanteRetencion->CrtNumero."-".$InsComprobanteRetencion->CrnId, 'QRCODE', 0, 0, 0, 30, $style, 'N');
		
	}
}

//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $pagelayout, true, 'UTF-8', false);
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf = new TCPDF();
//$pdf->SetHeaderData('logotipo.png', PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
// set document information
$pdf->SetCreator($EmpresaNombre);
$pdf->SetAuthor($EmpresaNombre);
$pdf->SetTitle($InsComprobanteRetencion->CrtNumero."-".$InsComprobanteRetencion->CrnId);
$pdf->SetSubject("ComprobanteRetencion Electronica");
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
//	$pdf->Cell(90,5,"COMPROBANTE DE RETENCION ELECTRONICA",$lineas,1,'C');
//
//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(100,5,$EmpresaProvincia." ".$EmpresaDistrito." ".$EmpresaDepartamento,$lineas,0,'C');
//
//
//	$pdf->SetFont('times', 'B', 12);
//	$pdf->Cell(90,5,"No. ".$InsComprobanteRetencion->CrtNumero."-".$InsComprobanteRetencion->CrnId,$lineas,1,'C');
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
//$pdf->Cell(170,5,$InsComprobanteRetencion->CliNombre." ".$InsComprobanteRetencion->CliApellidoPaterno." ".$InsComprobanteRetencion->CliApellidoMaterno,$lineas,1);
//







$NombreCliente = $InsComprobanteRetencion->CliNombre." ".$InsComprobanteRetencion->CliApellidoPaterno." ".$InsComprobanteRetencion->CliApellidoMaterno;

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
		$pdf->Cell(15,5,"Señor(es): ",$lineas,0,"L");
		$pdf->SetFont('times', 'N', 7);
		$pdf->Cell(175,5,$afila[$j],$lineas,1,"L");

	}else{

		$pdf->SetFont('times', 'B', 8);
		$pdf->Cell(15,5,"",$lineas,0,"L");
		$pdf->SetFont('times', 'N', 7);
		$pdf->Cell(175,5,$afila[$j],$lineas,1,"L");
		
	}
	
}


//$NombreCliente = $InsComprobanteRetencion->CliNombre." ".$InsComprobanteRetencion->CliApellidoPaterno." ".$InsComprobanteRetencion->CliApellidoMaterno;
//
//$ArrNombreClientePalabras = explode(" ",$NombreCliente);
//
//$palabra = 0;
//$nombre1 = "";
//$nombre2 = "";
//$nombre3=  "";
//
//foreach($ArrNombreClientePalabras as $DatNombreClientePalabra){
//	
//	if($palabra<9){
//		$nombre1 .= $DatNombreClientePalabra." ";
//	}else if($palabra<19){
//		$nombre2 .= $DatNombreClientePalabra." ";
//	}else{
//		$nombre3 .= $DatNombreClientePalabra." ";
//	}
//	
//	$palabra++;
//}
//
//$nombre1 = trim($nombre1);
//$nombre2 = trim($nombre2);
//$nombre3 = trim($nombre3);
//
////if(!empty($nombre1)){
//
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(15,5,"Señor(es): ",$lineas,0,"L");
//	$pdf->SetFont('times', 'N', 7);
//	$pdf->Cell(175,5,$nombre1,$lineas,1,"L");
//
////}
//
//if(!empty($nombre2)){
//
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(15,5,"",$lineas,0);
//	$pdf->SetFont('times', 'N', 7);
//	$pdf->Cell(175,5,$nombre2,$lineas,1,"L");
//
//}
//
//if(!empty($nombre3)){
//		
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(15,5,"",$lineas,0);
//	$pdf->SetFont('times', 'N', 7);
//	$pdf->Cell(175,5,$nombre3,$lineas,1,"L");
//
//}

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(15,5,"R.U.C.: ",$lineas,0);
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(110,5,$InsComprobanteRetencion->CliNumeroDocumento,$lineas,0);


$pdf->SetFont('times', 'B', 8);
$pdf->Cell(20,5,"Fecha: ",$lineas,0);
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(20,5,$InsComprobanteRetencion->CrnFechaEmision,$lineas,1);


$DireccionCliente = $InsComprobanteRetencion->CrnDireccion;

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
	
		$pdf->SetFont('times', 'B', 7);
		$pdf->Cell(15,5,"Direccion: ",$lineas,0);
		$pdf->SetFont('times', 'N', 7);
		$pdf->Cell(170,5,$afila[$j],$lineas,1,"L");

	}else{

		$pdf->SetFont('times', 'B', 7);
		$pdf->Cell(15,5,"",$lineas,0);
		$pdf->SetFont('times', 'N', 7);
		$pdf->Cell(170,5,$afila[$j],$lineas,1,"L");
		
	}
	
}
						
						
						
				//		
//$DireccionCliente = $InsComprobanteRetencion->CrnDireccion;
//
//$ArrDireccionClientePalabras = explode(" ",$DireccionCliente);
//
//$palabra = 0;
//$direccion1 = "";
//$direccion2 = "";
//$direccion3 =  "";
//
//foreach($ArrDireccionClientePalabras as $DatDireccionClientePalabra){
//	
//	if($palabra<17){
//		$direccion1 .= $DatDireccionClientePalabra." ";
//	}else if($palabra<34){
//		$direccion2 .= $DatDireccionClientePalabra." ";
//	}else{
//		$direccion3 .= $DatDireccionClientePalabra." ";
//	}
//	
//	$palabra++;
//}
//
//$direccion1 = trim($direccion1);
//$direccion2 = trim($direccion2);
//$direccion3 = trim($direccion3);
//
//
//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(15,5,"Direccion: ",$lineas,0);
//$pdf->SetFont('times', 'N', 8);
//$pdf->Cell(170,5,$direccion1,$lineas,1);
//
//if(!empty($direccion2)){
//
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(15,5,"",$lineas,0);
//	$pdf->SetFont('times', 'N', 7);
//	$pdf->Cell(170,5,$direccion2,$lineas,1,"L");
//
//}
//
//if(!empty($direccion3)){
//		
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(15,5,"",$lineas,0);
//	$pdf->SetFont('times', 'N', 7);
//	$pdf->Cell(170,5,$direccion3,$lineas,1,"L");
//
//}

$pdf->Ln(5);
$pdf->SetLeftMargin(10);



/*
* COMPROBANTE DE RETENCION DETALLE
*/
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(90,5,"Comprobante de pago que dan origen a la Retención",1,0,"C");
$pdf->Cell(25,5,"MONTO",1,0,"C");
$pdf->Cell(25,5,"PORCENTAJE",1,0,"C");
$pdf->Cell(25,5,"IMPORTE",1,0,"C");
$pdf->Cell(25,5,"MONTO EFECTIVO",1,1,"C");


$pdf->Cell(22.5,5,"TIPO",1,0,"C");
$pdf->Cell(22.5,5,"SERIE",1,0,"C");
$pdf->Cell(22.5,5,"NUMERO",1,0,"C");
$pdf->Cell(22.5,5,"FECHA EMISION",1,0,"C");

$pdf->Cell(25,5,"PAGAR",1,0,"C");
$pdf->Cell(25,5,"RETENCION",1,0,"C");
$pdf->Cell(25,5,"RETENIDO",1,0,"C");
$pdf->Cell(25,5,"PAGADO",1,1,"C");

$pdf->SetFont('times', 'N', 8);

$ArrMateriales = array();

if(!empty($InsComprobanteRetencion->ComprobanteRetencionDetalle)){
	foreach($InsComprobanteRetencion->ComprobanteRetencionDetalle as $DatComprobanteRetencionDetalle){

			if($InsComprobanteRetencion->MonId<>$EmpresaMonedaId and (!empty($InsComprobanteRetencion->CrnTipoCambio) )){

				$DatComprobanteRetencionDetalle->CedTotal = ($DatComprobanteRetencionDetalle->CedTotal / $InsComprobanteRetencion->CrnTipoCambio);
				$DatComprobanteRetencionDetalle->CedRetenido = ($DatComprobanteRetencionDetalle->CedRetenido  / $InsComprobanteRetencion->CrnTipoCambio);
				$DatComprobanteRetencionDetalle->CedPagado = ($DatComprobanteRetencionDetalle->CedPagado / $InsComprobanteRetencion->CrnTipoCambio);

			}

			
			$pdf->Cell(22.5,5,$DatComprobanteRetencionDetalle->CedTipoDocumento,$lineas,0,"L");	
			$pdf->Cell(22.5,5,$DatComprobanteRetencionDetalle->CedSerie,$lineas,0,"L");
			$pdf->Cell(22.5,5,$DatComprobanteRetencionDetalle->CedNumero,$lineas,0,"L");
			$pdf->Cell(22.5,5,$DatComprobanteRetencionDetalle->CedFechaEmision,$lineas,0,"L");
			
			$pdf->Cell(25,5,number_format($DatComprobanteRetencionDetalle->CedTotal,2),$lineas,0,"L");
			$pdf->Cell(25,5,number_format($DatComprobanteRetencionDetalle->CedPorcentajeRetencion,2),$lineas,0,"L");
			$pdf->Cell(25,5,number_format($DatComprobanteRetencionDetalle->CedRetenido,2),$lineas,0,"L");
			$pdf->Cell(25,5,number_format($DatComprobanteRetencionDetalle->CedPagado,2),$lineas,0,"L");
			
		
	}
}


//if(!empty($ArrMateriales )){
//	
//	$MaterialImporte = 0;
//            
//	foreach($ArrMateriales as $DatMaterial){
//	
//			if($InsComprobanteRetencion->MonId<>$EmpresaMonedaId and (!empty($InsComprobanteRetencion->CrnTipoCambio) )){
//				
//				$DatComprobanteRetencionDetalle->CedImporte = ($DatMaterial->CedImporte / $InsComprobanteRetencion->CrnTipoCambio);
//				$DatComprobanteRetencionDetalle->CedPrecio = ($DatMaterial->CedPrecio  / $InsComprobanteRetencion->CrnTipoCambio);
//				
//			}
//						
//			if($DatComprobanteRetencionDetalle->CedTipo<>"T"){
//				$pdf->Cell(10,5,$DatMaterial->CedCantidad,$lineas,0);	
//			}else{
//				$pdf->Cell(10,5,"",$lineas,0);	
//			}
//			
//			
//			$pdf->Cell(30,5,$DatMaterial->CedUnidadMedida,$lineas,0);
//			$pdf->Cell(100,5,stripslashes( $DatMaterial->CedDescripcion),$lineas,0);
//			
//			if($DatComprobanteRetencionDetalle->CedTipo<>"T"){
//				$pdf->Cell(2,5,number_format($DatMaterial->CedPrecio,2),$lineas,0,"R");
//			}
//			
//			if($DatComprobanteRetencionDetalle->CedTipo<>"T"){
//				$pdf->Cell(25,5,number_format($DatMaterial->CedImporte,2),$lineas,1,"R");
//			}
//			
//			$TotalBruto = $TotalBruto + $DatMaterial->CedImporte;		
//		
//		$MaterialImporte += $DatMaterial->CedImporte;
//	}
//	
//		
//}

$TotalLineas = count($InsComprobanteRetencion->ComprobanteRetencionDetalle)+$filas_adicionales;

if($TotalLineas<15 and empty($InsComprobanteRetencion->OvvId)){
	
	$TotalLineasFaltantes = 15 - $TotalLineas;
	
	for($i=1;$i<=$TotalLineasFaltantes;$i++){
			
		$pdf->Cell(10,5,"",$lineas,0,"C");
		$pdf->Cell(30,5,"",$lineas,0,"C");
		$pdf->Cell(100,5,"",$lineas,0,"C");
		$pdf->Cell(25,5,"",$lineas,0,"C");
		$pdf->Cell(25,5,"",$lineas,1,"C");
		
	}

}else{
	

}


if(!empty($InsComprobanteRetencion->CrnObservacionImpresa)){

	$pdf->Ln(5);
	
	$pdf->SetLeftMargin(10);	
	$pdf->Cell(110,5,$InsComprobanteRetencion->CrnObservacionImpresa,$lineas,1);
	
}


$pdf->SetAlpha(0.4);
$pdf->Image('../../imagenes/comprobantes/comprobante_fondo.png', 76, 60, 70, 60, 'PNG', '', '', true, 150, '', false, false, 0, true, false, false);
$pdf->SetAlpha(1);


$pdf->Ln(5);
$pdf->SetLeftMargin(10);
$pdf->SetFont('times', 'B', 8);

$Total = round($InsComprobanteRetencion->CrnTotal,2);
list($parte_entero,$parte_decimal) = explode(".",$Total);

if(empty($parte_decimal)){
	$parte_decimal = 0;
}

$parte_decimal = str_pad($parte_decimal, 2, "0", STR_PAD_RIGHT);



//FILA
$pdf->Cell(120,5,"",$lineas,0,'C');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"Importe Retenido: ",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsComprobanteRetencion->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsComprobanteRetencion->CrnTotal,2),1,1,'R');


$pdf->Ln(5);
$pdf->SetLeftMargin(10);
$pdf->Image('../../imagenes/comprobante_pie.png', 10, '', 90, 28, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);



/*
GENERAR CODIGO QR
*/
$ArchivoCrnetaCodigoQR = $InsComprobanteRetencion->CrtNumero."-".$InsComprobanteRetencion->CrnId.'_QR.png'; 
$RutaCrnetaCodigoQR = "../../generados/comprobantes/".$ArchivoCrnetaCodigoQR; 
// generating 

if (file_exists($RutaCrnetaCodigoQR)) { 
	unlink($RutaCrnetaCodigoQR); 
}

// QRcode::png($InsComprobanteRetencion->CrtNumero."-".$InsComprobanteRetencion->CrnId, $RutaCrnetaCodigoQR); 
$CodigoQR = $EmpresaCodigo.'|1|'.$InsComprobanteRetencion->CrtNumero.'|'.$InsComprobanteRetencion->CrnId.'|'.number_format($InsComprobanteRetencion->CrnImpuesto,2, '.', '').'|'.number_format($InsComprobanteRetencion->CrnTotal,2, '.', '').'|'.FncCambiaFechaAMysql($InsComprobanteRetencion->CrnFechaEmision).'|1|'.$InsComprobanteRetencion->CliNumeroDocumento.'|'.$InsComprobanteRetencion->CrnSunatRespuestaEnvioDigestValue.'|'.$InsComprobanteRetencion->CrnSunatRespuestaEnvioSignatureValue;

$barcodeobj = new TCPDF2DBarcode($CodigoQR, 'PDF417');
$data = $barcodeobj->getBarcodePngData(10,5,array(0,0,0));
$im = imagecreatefromstring($data);
$resp = imagepng($im, $RutaCrnetaCodigoQR);
imagedestroy($im);


$pdf->Image($RutaCrnetaCodigoQR, 120, '', 75, 25, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);




$pdf->Ln(25);
$pdf->SetLeftMargin(10);

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(125,3,"",$lineas,0,'C',0,0);
$pdf->Cell(50,3,"Timbre Electronico",$lineas,1,'C',0,0);

$pdf->SetFont('times', '', 6);
$pdf->Cell(125,3,"",$lineas,0,'C',0,0);
$pdf->Cell(50,3,"Representación impresa de la Comprobante de Retencion Electrónica",$lineas,1,'C',0,0);

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
//		$pdf->writeHTMLCell(0, 0, 0, 0, 'Lorem ipsum... <img src="'.$RutaComprobanteRetencionCodigoQR.'" /> Curabitur at porta dui...');

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

//$pdf->write2DBarcode($InsComprobanteRetencion->CrtNumero."-".$InsComprobanteRetencion->CrnId, 'QRCODE', 80, 90, 0, 30, $style, 'N');
//$pdf->write2DBarcode($InsComprobanteRetencion->CrtNumero."-".$InsComprobanteRetencion->CrnId, 'QRCODE',10,150,30,30,$style);
//$pdf->Text(10, 150, $InsComprobanteRetencion->CrtNumero."-".$InsComprobanteRetencion->CrnId);

//
//$pdf->SetY(700);
//

//$pdf->Ln(30);
//$pdf->SetLeftMargin(10);
//			
//			

//		
//			
	
	
$pdf->Output('../../generados/comprobantes_pdf/'.$NOMBRE.'.pdf', 'F');

$pdf->Output($NOMBRE.".pdf");

?>