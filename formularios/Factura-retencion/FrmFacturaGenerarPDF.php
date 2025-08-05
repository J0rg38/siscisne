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
$GET_Fecha = $_GET['Fecha'];

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
	$InsFactura->FacTotalImpuestoSelectivo = round($InsFactura->FacTotalImpuestoSelectivo/$InsFactura->FacTipoCambio,2);
	
	$InsFactura->FacTotalPagar = round($InsFactura->FacTotalPagar/$InsFactura->FacTipoCambio,2);
//	$InsFactura->FacTotalDescuento = round($InsFactura->FacTotalDescuento/$InsFactura->FacTipoCambio,2);
	
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
		$this->Cell(70,5,"FACTURA ELECTRONICA",$lineas,1,'C');

		$this->SetFont('times', '', 10);
		$this->Cell(45,5,'',$lineas,0,'C',0);
		$this->SetFont('times', '', 6);
		$this->Cell(85,5,"",$lineas,0,'C');
//		
//		
			$this->SetFont('times', 'B', 10);
			$this->Cell(70,5,"N°. ".$InsFactura->FtaNumero."-".$InsFactura->FacId,$lineas,1,'C');
			
			
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
		global $InsFactura;
		// Position at 15 mm from bottom
		
		
		
		
		
		$this->SetY(-20);
		
		
		$image_file = '../../imagenes/comprobantes/logo_ose.png';
		$this->Image($image_file, 160, '', 45, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

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

$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->RoundedRect(140, 7, 50, 25, 0, '1111', NULL);

$NombreCliente = $InsFactura->CliNombre." ".$InsFactura->CliApellidoPaterno." ".$InsFactura->CliApellidoMaterno;

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

$DireccionCliente = $InsFactura->FacDireccion;

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
$pdf->Cell(170,5,$InsFactura->CliNumeroDocumento,$lineas,1);




$pdf->SetFont('times', 'B', 8);
$pdf->Cell(5,5,"",$lineas,0,"C");
$pdf->Cell(25,5,"FECHA",1,0,"C");
$pdf->Cell(25,5,"MONEDA",1,0,"C");
$pdf->Cell(25,5,"VENDEDOR",1,0,"C");
$pdf->Cell(25,5,"VENCIMIENTO",1,0,"C");
$pdf->Cell(25,5,"N° PEDIDO",1,0,"C");
$pdf->Cell(25,5,"USUARIO",1,0,"C");
$pdf->Cell(25,5,"TIPO PAGO",1,1,"C");

$pdf->SetFont('times', 'N', 8);
$pdf->Cell(5,5,"",$lineas,0,"C");
$pdf->Cell(25,5,(!empty($GET_Fecha)?$GET_Fecha:$InsFactura->FacFechaEmision),1,0,"C");
$pdf->Cell(25,5,$InsFactura->MonSimbolo,1,0,"C");
$pdf->Cell(25,5,$InsFactura->FacVendedor,1,0,"C");
$pdf->Cell(25,5,$InsFactura->FacFechaVencimiento,1,0,"C");
//$pdf->Cell(25,5,$InsFactura->BolNumeroPedido,1,0,"C");
$pdf->SetFont('times', 'N', 6);
//$pdf->Cell(25,5,$InsFactura->FinId." ".$InsFactura->VdiId." ".$InsFactura->OvvId,1,0,"C");
$pdf->Cell(25,5,$InsFactura->FacNumeroPedido,1,0,"C");
$pdf->SetFont('times', 'N', 8);

$pdf->Cell(25,5,$InsFactura->UsuUsuario,1,0,"C");
$pdf->Cell(25,5,$InsFactura->NpaNombre,1,1,"C");

$pdf->Ln(5);
$pdf->SetLeftMargin(10);

/*
* DETALLE
*/

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(20,5,"COD.",1,0,"C");
$pdf->Cell(10,5,"CANT.",1,0,"C");
$pdf->Cell(25,5,"U/M",1,0,"C");
$pdf->Cell(70,5,"DESCRIPCION",1,0,"C");
$pdf->Cell(20,5,"P. UNITARIO",1,0,"C");
$pdf->Cell(20,5,"V. UNITARIO",1,0,"C");
$pdf->Cell(20,5,"V. TOTAL",1,1,"C");

$ArrMateriales = array();

$pdf->SetFont('times', 'N', 8);

if(!empty($InsFactura->FacturaDetalle)){
	foreach($InsFactura->FacturaDetalle as $DatFacturaDetalle){

		if($InsFactura->MonId<>$EmpresaMonedaId and (!empty($InsFactura->FacTipoCambio) )){
		
			$DatFacturaDetalle->FdeImporte = ($DatFacturaDetalle->FdeImporte / $InsFactura->FacTipoCambio);
			$DatFacturaDetalle->FdePrecio = ($DatFacturaDetalle->FdePrecio  / $InsFactura->FacTipoCambio);
			
			$DatFacturaDetalle->FdeValorVenta = ($DatFacturaDetalle->FdeValorVenta / $InsFactura->FacTipoCambio);
			$DatFacturaDetalle->FdeValorVentaUnitario = ($DatFacturaDetalle->FdeValorVentaUnitario  / $InsFactura->FacTipoCambio);
			
		}
					
			if(empty($InsFactura->OvvId)){
				
				$pos = strrpos($DatFacturaDetalle->FdeDescripcion, "|");
				
				if ($pos === false) { // nota: tres signos de igual
					// no encontrado...
					
					$ArrPalabras = explode(" ",$DatFacturaDetalle->FdeDescripcion);
					
					$afila = array();
					$fila = 1;
					
					for($i=0;$i<=count($ArrPalabras);$i++){									
						if(strlen($afila[$fila]." ".$ArrPalabras[$i])<45){											
							$afila[$fila].=" ".$ArrPalabras[$i];										
						}else{										
							$fila++;
							$afila[$fila].=" ".$ArrPalabras[$i];
						}
						
					}
					
					for($j=1;$j<=$fila;$j++){
						
						if($j==1){
							
							if($DatFacturaDetalle->FdeTipo<>"T"){
								$pdf->Cell(20,5,$DatFacturaDetalle->FdeCodigo,$lineas,0);	
							}else{
								$pdf->Cell(20,5,"",$lineas,0);	
							}
							
							if($DatFacturaDetalle->FdeTipo<>"T"){
								$pdf->Cell(10,5,$DatFacturaDetalle->FdeCantidad,$lineas,0);	
							}else{
								$pdf->Cell(10,5,"",$lineas,0);	
							}

							$pdf->Cell(25,5,$DatFacturaDetalle->FdeUnidadMedida,$lineas,0);
							
							$pdf->Cell(70,5,($afila[$j])."",$lineas,0);
							
							if($DatFacturaDetalle->FdeTipo<>"T"){
								$pdf->Cell(20,5,number_format($DatFacturaDetalle->FdePrecio,2),$lineas,0,"R");
							}else{
								$pdf->Cell(20,5,'',$lineas,0,"R");
							}
							
							if($DatFacturaDetalle->FdeTipo<>"T"){
								$pdf->Cell(20,5,number_format($DatFacturaDetalle->FdeValorVentaUnitario,2),$lineas,0,"R");
							}else{
								$pdf->Cell(20,5,'',$lineas,0,"R");
							}
							
							if($DatFacturaDetalle->FdeTipo<>"T"){
								$pdf->Cell(20,5,number_format($DatFacturaDetalle->FdeValorVenta,2),$lineas,1,"R");
							}else{
								$pdf->Cell(20,5,'',$lineas,1,"R");
							}
				
						}else{
							
							if(!empty($afila[$j])){
								$pdf->Cell(20,5,"",$lineas,0);	
							$pdf->Cell(10,5,"",$lineas,0);								
							$pdf->Cell(25,5,"",$lineas,0);
							$pdf->Cell(70,5,$afila[$j],$lineas,0);
							$pdf->Cell(20,5,"",$lineas,0,"R");
							$pdf->Cell(20,5,"",$lineas,0,"R");
							$pdf->Cell(20,5,"",$lineas,1,"R");
							}
							
							
						}
						
						
					}
					
					
					

					
				}else{
					
					
					$filas_adicionales = 0;
					
					unset($ArrRepuestos);		
				
					$ArrRepuestos = explode("|",$DatFacturaDetalle->FdeDescripcion);
					
					if(!empty($ArrRepuestos)){
						
						$repuestos = 1;
						foreach($ArrRepuestos as $DatRepuesto){
							
							if($repuestos == 1){
								
								$ArrPalabras = explode(" ",$DatRepuesto);
							
								$afila = array();
								$fila = 1;
								
								for($i=0;$i<=count($ArrPalabras);$i++){									
									if(strlen($afila[$fila]." ".$ArrPalabras[$i])<50){											
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
										$pdf->Cell(70,5,$afila[$j],$lineas,0);
										$pdf->Cell(20,5,number_format($DatFacturaDetalle->FdePrecio,2),$lineas,0,"R");
										$pdf->Cell(20,5,number_format($DatFacturaDetalle->FdeValorVentaUnitario,2),$lineas,0,"R");
										$pdf->Cell(20,5,number_format($DatFacturaDetalle->FdeValorVenta,2),$lineas,1,"R");
				
									}else{
										$pdf->Cell(20,5,"",$lineas,0);	
										$pdf->Cell(10,5,"",$lineas,0);								
										$pdf->Cell(25,5,"",$lineas,0);
										$pdf->Cell(70,5,$afila[$j],$lineas,0);
										$pdf->Cell(20,5,"",$lineas,0,"R");
										$pdf->Cell(20,5,"",$lineas,0,"R");
										$pdf->Cell(20,5,"",$lineas,1,"R");
									}
									
									
								}

								
							}else{
								
								$pdf->Cell(20,5,"",$lineas,0);	
								$pdf->Cell(10,5,"",$lineas,0);								
								$pdf->Cell(25,5,"",$lineas,0);
								$pdf->Cell(70,5,"- ".$DatRepuesto,$lineas,0);
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
				
				$DatFacturaDetalle->FdeDescripcion;		
	$DatFacturaDetalle->FdeDescripcion .= "|";	
	
  if(!empty($InsFactura->FacDatoAdicional13) or !empty($InsFactura->FacDatoAdicional7) or !empty($InsFactura->FacDatoAdicional1)){
	
	$DatFacturaDetalle->FdeDescripcion .= "( ";

  }

  if(!empty($InsFactura->FacDatoAdicional13)){
	
	$DatFacturaDetalle->FdeDescripcion .= "Nro. VIN o CHASIS: ".$InsFactura->FacDatoAdicional13.", ";
	
  }

  
  

  if(!empty($InsFactura->FacDatoAdicional7)){
 
		$DatFacturaDetalle->FdeDescripcion .= "Nro. Motor: ".$InsFactura->FacDatoAdicional7.", ";
	
  }
  
  

  if(!empty($InsFactura->FacDatoAdicional1)){
 
		$DatFacturaDetalle->FdeDescripcion .= "Marca: ".$InsFactura->FacDatoAdicional1.", ";
 
  }

  if(!empty($InsFactura->FacDatoAdicional13) or !empty($InsFactura->FacDatoAdicional7) or !empty($InsFactura->FacDatoAdicional1)){
	
   $DatFacturaDetalle->FdeDescripcion .= " )";
   
  }
					
					unset($ArrPalabras);		
				
					list($Vehiculo,$Accesorios) = explode("|",$DatFacturaDetalle->FdeDescripcion);
					
					$ArrPalabras = explode(" ",$Vehiculo);
					
					$afila = array();
					$fila = 1;
					
					for($i=0;$i<=count($ArrPalabras);$i++){									
						if(strlen($afila[$fila]." ".$ArrPalabras[$i])<50){											
							$afila[$fila].=" ".$ArrPalabras[$i];										
						}else{										
							$fila++;
							$afila[$fila].=" ".$ArrPalabras[$i];
						}
					}
					
					for($j=1;$j<=$fila;$j++){
						
						if($j==1){
							
							if($DatFacturaDetalle->FdeTipo<>"T"){
								$pdf->Cell(20,5,$DatFacturaDetalle->FdeCodigo,$lineas,0);	
							}else{
								$pdf->Cell(20,5,"",$lineas,0);	
							}
							
							if($DatFacturaDetalle->FdeTipo<>"T"){
								$pdf->Cell(10,5,$DatFacturaDetalle->FdeCantidad,$lineas,0);	
							}else{
								$pdf->Cell(10,5,"",$lineas,0);	
							}
							
							$pdf->Cell(25,5,$DatFacturaDetalle->FdeUnidadMedida,$lineas,0);
							
							$pdf->Cell(70,5,$afila[$j],$lineas,0);
							
							if($DatFacturaDetalle->FdeTipo<>"T"){
								$pdf->Cell(20,5,number_format($DatFacturaDetalle->FdePrecio,2),$lineas,0,"R");
							}else{
								$pdf->Cell(20,5,'',$lineas,0,"R");
							}
							
							if($DatFacturaDetalle->FdeTipo<>"T"){
								$pdf->Cell(20,5,number_format($DatFacturaDetalle->FdeValorVentaUnitario,2),$lineas,0,"R");
							}else{
								$pdf->Cell(20,5,'',$lineas,0,"R");
							}
							
							if($DatFacturaDetalle->FdeTipo<>"T"){
								$pdf->Cell(20,5,number_format($DatFacturaDetalle->FdeValorVenta,2),$lineas,1,"R");
							}else{
								$pdf->Cell(20,5,'',$lineas,1,"R");
							}
							
						}else{
							
							$pdf->Cell(20,5,"",$lineas,0);	
							$pdf->Cell(10,5,"",$lineas,0);								
							$pdf->Cell(25,5,"",$lineas,0);
							$pdf->Cell(70,5,$afila[$j],$lineas,0);
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
						if(strlen($afila[$fila]." ".$ArrPalabras[$i])<50){											
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
							$pdf->Cell(70,5,$afila[$j],$lineas,0);
							$pdf->Cell(20,5,'',$lineas,0,"R");
							$pdf->Cell(20,5,'',$lineas,0,"R");
							$pdf->Cell(20,5,'',$lineas,1,"R");
							
							
						}else{
							
							$pdf->Cell(20,5,"",$lineas,0);
							$pdf->Cell(10,5,"",$lineas,0);								
							$pdf->Cell(25,5,"",$lineas,0);
							$pdf->Cell(70,5,$afila[$j],$lineas,0);
							$pdf->Cell(20,5,"",$lineas,0,"R");
							$pdf->Cell(20,5,"",$lineas,0,"R");
							$pdf->Cell(20,5,"",$lineas,1,"R");
							
						}
						
						
					}
				
			}
			
			
		
	}
}

$TotalLineas = count($InsFactura->FacturaDetalle) + $filas_adicionales;

if($TotalLineas<10 and empty($InsFactura->OvvId)){

	$TotalLineasFaltantes = 14 - $TotalLineas;
	
	for($i=1;$i<=$TotalLineasFaltantes;$i++){
			
		$pdf->Cell(20,5,"",$lineas,0);
		$pdf->Cell(10,5,"",$lineas,0);								
		$pdf->Cell(25,5,"",$lineas,0);
		$pdf->Cell(70,5,"",$lineas,0);
		$pdf->Cell(20,5,"",$lineas,0,"R");
		$pdf->Cell(20,5,"",$lineas,0,"R");
		$pdf->Cell(20,5,"",$lineas,1,"R");
		
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
	
}

if(!empty($InsFactura->EinPlaca)){
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"Placa: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->EinPlaca,$lineas,1);
}

if(!empty($InsFactura->VmaNombre)){
	
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
	
	$pdf->Ln(5);
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
	$pdf->Cell(20,5,"Año Mod.: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsFactura->FacDatoAdicional27,$lineas,0);
	
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
	
	for($i=1;$i<=2;$i++){
			
		$pdf->Cell(10,5,"",$lineas,0,"C");
		$pdf->Cell(30,5,"",$lineas,0,"C");
		$pdf->Cell(100,5,"",$lineas,0,"C");
		$pdf->Cell(25,5,"",$lineas,0,"C");
		$pdf->Cell(25,5,"",$lineas,1,"C");
		
	}
	
}


$pdf->Line(10,170,190,170);


$pdf->SetFont('times', 'N', 8);
$pdf->Cell(190,5,"",$lineas,1);


$pdf->Cell(20,5,"PREPARADO",1,0,"C");
$pdf->Cell(10,5,"V°B°",1,0,"C");

$pdf->Cell(5,5,"",$lineas,0,"C");

$pdf->SetFont('times', 'N', 6);
$pdf->Cell(30,5,"RECIBIDO POR EL CLIENTE",1,0,"C");

$pdf->Cell(5,5,"",$lineas,0,"C");

$pdf->Cell(30,5,"CANCELADO",1,1,"C");



$pdf->Cell(20,15,"",1,0,"C");
$pdf->Cell(10,15,"",1,0,"C");

$pdf->Cell(5,5,"",$lineas,0,"C");

$pdf->SetFont('times', 'N', 6);
$pdf->Cell(30,15,"",1,0,"C");

$pdf->Cell(5,15,"",$lineas,0,"C");

$pdf->Cell(30,15,"",1,0,"C");




//$pdf->SetAlpha(0.6);
//$pdf->Image('../../imagenes/retencion.png', 45,'', 110, 35, 'PNG', '', '', true, 150, '', false, false, 0, true, false, false);
//$pdf->SetAlpha(1);



if($InsFactura->FacObsequio==1){
	
	$pdf->SetAlpha(0.3);
	
	$pdf->Image('../../imagenes/transferencia_gratuita.png', 65, 60, 80, 70, 'PNG', '', '', true, 150, '', false, false, 0, true, false, false);

	$pdf->SetAlpha(1);

	$pdf->Ln(5);
	$pdf->SetLeftMargin(10);

	$pdf->Cell(110,5,$InsFactura->FacLeyenda." ".number_format($InsFactura->FacTotalGratuito,2),$lineas,1);
	
}



$pdf->Ln(15);


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

//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(190,5,"SON: ".$numalet->letra()." CON ".$parte_decimal."/100"." ".$InsFactura->MonNombre,$lineas,1,'L');


$pdf->SetFont('times', 'B', 8);
$pdf->Cell(20,5,"SON: ",$lineas,0,'L');
$pdf->SetFont('times', '', 8);
$pdf->Cell(170,5,$numalet->letra()." CON ".$parte_decimal."/100"." ".$InsFactura->MonNombre,$lineas,1,'L');




if(!empty($InsFactura->FacObservacionImpresa)){
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(190,5,"OBSERVACIONES",$lineas,0,'L');
	
	$pdf->SetFont('times', '', 8);
	
	$pdf->Ln(5);
	$pdf->SetLeftMargin(10);	
	
	$pos = strrpos($InsFactura->FacObservacionImpresa, "|");
	
	if ($pos === false) { // nota: tres signos de igual
		// no encontrado...
		
			$pdf->Cell(190,5,$InsFactura->FacObservacionImpresa,$lineas,1);
		
	}else{
		
		$ArrPalabras = explode("|",$InsFactura->FacObservacionImpresa);
		
		$pdf->Cell(190,5,($ArrPalabras[0])."",$lineas,1);
		$pdf->Cell(190,5,($ArrPalabras[1])."",$lineas,0);
	}
		
}

$pdf->Cell(190,1,"",$lineas,1,'L');

/*
* TOTALES
*/

$pdf->SetFont('times', 'B', 8);
//FILA
$pdf->SetFont('times', 'B', 12);
$pdf->Cell(120,5,"",$lineas,0,'L');

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"OP. GRAVADAS",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsFactura->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsFactura->FacTotalGravado,2),1,1,'R');
//FILA
$pdf->SetFont('times', 'B', 12);
$pdf->Cell(120,5,"",$lineas,0,'L');

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"OP. INAFECTAS",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsFactura->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsFactura->FacTotalInafecta,2),1,1,'R');

//FILA
$pdf->SetFont('times', 'B', 12);
$pdf->Cell(120,5,"",$lineas,0,'L');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"OP. EXONERADAS",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsFactura->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsFactura->FacTotalExonerado,2),1,1,'R');

//FILA
$pdf->SetFont('times', 'B', 12);
$pdf->Cell(120,5,"",$lineas,0,'L');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"OP. GRATUITAS",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsFactura->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsFactura->FacTotalGratuita,2),1,1,'R');


//FILA
$pdf->SetFont('times', 'B', 12);
$pdf->Cell(120,5,"",$lineas,0,'L');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"OTROS CARGOS",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsFactura->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsFactura->FacTotalOtrosCargos,2),1,1,'R');

//FILA
$pdf->SetFont('times', 'B', 12);
$pdf->Cell(120,5,"",$lineas,0,'L');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"OTROS TRIBUTOS",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsFactura->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsFactura->FacTotalOtrosTributos,2),1,1,'R');


//FILA
$pdf->Cell(90,5,"",$lineas,0,'L');
$pdf->Cell(30,5,"",$lineas,0,'R');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"DESCUENTO",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsFactura->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsFactura->FacTotalDescuento,2),1,1,'R');


//
////FILA
//$pdf->SetFont('times', 'B', 12);
//$pdf->Cell(120,5,"",$lineas,0,'L');
//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(35,5,"Total No Gravado: ",$lineas,0,'R');
//$pdf->SetFont('times', 'N', 8);
//$pdf->Cell(10,5,$InsFactura->MonSimbolo,$lineas,0,'L');
//$pdf->Cell(25,5,number_format($InsFactura->FacTotalNoGravado,2),1,1,'R');


if($InsFactura->FacTotalImpuestoSelectivo>0){
	
		//FILA
	$pdf->SetFont('times', 'B', 12);
	$pdf->Cell(120,5,"",$lineas,0,'L');
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(35,5,"Total ISC ".number_format($InsFactura->FacPorcentajeImpuestoSelectivo,2)."%",$lineas,0,'R');
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(10,5,$InsFactura->MonSimbolo,$lineas,0,'L');
	$pdf->Cell(25,5,number_format($InsFactura->FacTotalImpuestoSelectivo,2),1,1,'R');

}

//FILA
$pdf->SetFont('times', 'B', 12);
$pdf->Cell(120,5,"",$lineas,0,'L');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"IGV ".number_format($InsFactura->FacPorcentajeImpuestoVenta,2)."%",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsFactura->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsFactura->FacImpuesto,2),1,1,'R');

//FILA
$pdf->Cell(120,5,"",$lineas,0,'C');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"TOTAL",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsFactura->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsFactura->FacTotal,2),1,1,'R');

//IMPRIMIR RETENCION
if($InsFactura->FacRetencion == '1'){
	$TotalRetencion = $InsFactura->FacTotal*0.03;
//FILA
$pdf->Cell(120,5,"",$lineas,0,'C');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"RETENCION 3.00%",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsFactura->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($TotalRetencion,2),1,1,'R');

//FILA
$pdf->Cell(120,5,"",$lineas,0,'C');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"NETO A PAGAR",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsFactura->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsFactura->FacTotal - $TotalRetencion,2),1,1,'R');
}elseif($InsFactura->FacRetencion == '2'){

}else{

}

/*
GENERAR CODIGO QR
*/

$ArchivoFacturaCodigoQR = $InsFactura->FtaNumero."-".$InsFactura->FacId.'_QR.png'; 
$RutaFacturaCodigoQR = "../../generados/comprobantes/".$ArchivoFacturaCodigoQR; 
// generating 

if (file_exists($RutaFacturaCodigoQR)) { 
	unlink($RutaFacturaCodigoQR); 
}

// QRcode::png($InsFactura->FtaNumero."-".$InsFactura->FacId, $RutaFacturaCodigoQR); 
$CodigoQR = $EmpresaCodigo.'|3|'.$InsFactura->FtaNumero.'|'.$InsFactura->FacId.'|'.number_format($Impuesto,2, '.', '').'|'.number_format($Total,2, '.', '').'|'.FncCambiaFechaAMysql($InsFactura->FacFechaEmision).'|1|'.$InsFactura->CliNumeroDocumento.'|'.$InsFactura->FacSunatRespuestaEnvioDigestValue.'|'.$InsFactura->FacSunatRespuestaEnvioSignatureValue;

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

$pdf->write2DBarcode($CodigoQR, 'QRCODE,Q', 10, 250, 20, 20, $style, 'N');





$pdf->Ln(2);


$pdf->SetFont('times', 'B', 6);
//$pdf->Cell(190,3,"Esta es una representación impresa de la Factura electrónica, Puede verificarlo utilizando su clave SOL en www.sunat.gob.pe o en",0,1,'C',0,0);
//$pdf->Cell(190,3,"http://app.facturaonline.pe/invitado",0,1,'C',0,0);
$pdf->Cell(190,3,"Esta es una representación impresa de la Factura electrónica, Puede verificarlo utilizando su clave SOL en www.sunat.gob.pe",0,1,'L',0,0);



ob_end_clean();	
$pdf->Output('../../generados/comprobantes_pdf/'.$NOMBRE.'.pdf', 'F');
ob_end_clean();
$pdf->Output($NOMBRE.".pdf");

?>