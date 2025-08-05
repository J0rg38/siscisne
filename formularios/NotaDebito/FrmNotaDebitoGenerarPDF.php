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
	
	case "2": //FACTURA
		$TipoDocumento = "Factura";
	break;
	
	case "3"://BOLETA
		$TipoDocumento = "NotaDebito";
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
		$this->Cell(70,5,"NOTA DE DEBITO ELECTRONICA",$lineas,1,'C');

		$this->SetFont('times', '', 10);
		$this->Cell(45,5,'',$lineas,0,'C',0);
		$this->SetFont('times', '', 6);
		$this->Cell(85,5,"",$lineas,0,'C');
//		
//		
			$this->SetFont('times', 'B', 10);
			$this->Cell(70,5,"N°. ".$InsNotaDebito->NdtNumero."-".$InsNotaDebito->NdbId,$lineas,1,'C');
			
			
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
		global $InsNotaDebito;
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

$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->RoundedRect(130, 7, 70, 25, 0, '1111', NULL);



$NombreCliente = $InsNotaDebito->CliNombre." ".$InsNotaDebito->CliApellidoPaterno." ".$InsNotaDebito->CliApellidoMaterno;

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



$DireccionCliente = $InsNotaDebito->NdbDireccion;


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
$pdf->Cell(170,5,$InsNotaDebito->CliNumeroDocumento,$lineas,1);


$pdf->SetFont('times', 'B', 8);
$pdf->Cell(30,5,"",$lineas,0,"C");
$pdf->Cell(45,5,"FECHA",1,0,"C");
$pdf->Cell(45,5,"MONEDA",1,0,"C");
$pdf->Cell(45,5,"USUARIO",1,1,"C");

$pdf->SetFont('times', 'N', 8);
$pdf->Cell(30,5,"",$lineas,0,"C");
$pdf->Cell(45,5,(!empty($GET_Fecha)?$GET_Fecha:$InsNotaDebito->NdbFechaEmision),1,0,"C");
$pdf->Cell(45,5,$InsNotaDebito->MonSimbolo,1,0,"C");
$pdf->Cell(45,5,$InsNotaDebito->UsuUsuario,1,1,"C");


$pdf->Ln(5);
$pdf->SetLeftMargin(10);


/*
* NOTA DE DEBITO DETALLE
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

if(!empty($InsNotaDebito->NotaDebitoDetalle)){
	foreach($InsNotaDebito->NotaDebitoDetalle as $DatNotaDebitoDetalle){
		
		//if($DatNotaDebitoDetalle->NddTipo <> "M"){
		    
			if($InsNotaDebito->MonId<>$EmpresaMonedaId and (!empty($InsNotaDebito->NdbTipoCambio) )){

				$DatNotaDebitoDetalle->NddImporte = ($DatNotaDebitoDetalle->NddImporte / $InsNotaDebito->NdbTipoCambio);
				$DatNotaDebitoDetalle->NddPrecio = ($DatNotaDebitoDetalle->NddPrecio  / $InsNotaDebito->NdbTipoCambio);

				$DatNotaDebitoDetalle->NddValorVenta = ($DatNotaDebitoDetalle->NddValorVenta / $InsNotaDebito->NdbTipoCambio);
				$DatNotaDebitoDetalle->NddValorVentaUnitario = ($DatNotaDebitoDetalle->NddValorVentaUnitario  / $InsNotaDebito->NdbTipoCambio);

			}

		  	 if(empty($InsNotaDebito->OvvId)){
				
				$pos = strrpos($DatNotaDebitoDetalle->NddDescripcion, "|");
				
				if ($pos === false) { // nota: tres signos de igual
					// no encontrado...
					
					$ArrPalabras = explode(" ",$DatNotaDebitoDetalle->NddDescripcion);
					
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
							
							if($DatNotaDebitoDetalle->NddTipo<>"T"){
								$pdf->Cell(20,5,$DatNotaDebitoDetalle->NddCodigo,$lineas,0);	
							}else{
								$pdf->Cell(20,5,"",$lineas,0);	
							}
							
							if($DatNotaDebitoDetalle->NddTipo<>"T"){
								$pdf->Cell(10,5,$DatNotaDebitoDetalle->NddCantidad,$lineas,0);	
							}else{
								$pdf->Cell(10,5,"",$lineas,0);	
							}

							$pdf->Cell(25,5,$DatNotaDebitoDetalle->NddUnidadMedida,$lineas,0);
							
							$pdf->Cell(75,5,($afila[$j])."",$lineas,0);
							
							if($DatNotaDebitoDetalle->NddTipo<>"T"){
								$pdf->Cell(20,5,number_format($DatNotaDebitoDetalle->NddPrecio,2),$lineas,0,"R");
							}else{
								$pdf->Cell(20,5,'',$lineas,0,"R");
							}
							
							if($DatNotaDebitoDetalle->NddTipo<>"T"){
								$pdf->Cell(20,5,number_format($DatNotaDebitoDetalle->NddValorVentaUnitario,2),$lineas,0,"R");
							}else{
								$pdf->Cell(20,5,'',$lineas,0,"R");
							}
							
							if($DatNotaDebitoDetalle->NddTipo<>"T"){
								$pdf->Cell(20,5,number_format($DatNotaDebitoDetalle->NddValorVenta,2),$lineas,1,"R");
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
				
					$ArrRepuestos = explode("|",$DatNotaDebitoDetalle->NddDescripcion);
					
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
										$pdf->Cell(20,5,number_format($DatNotaDebitoDetalle->NddPrecio,2),$lineas,0,"R");
										$pdf->Cell(20,5,number_format($DatNotaDebitoDetalle->NddValorVentaUnitario,2),$lineas,0,"R");
										$pdf->Cell(20,5,number_format($DatNotaDebitoDetalle->NddValorVenta,2),$lineas,1,"R");
				
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
				
					
					
					$DatNotaDebitoDetalle->NddDescripcion;		
	$DatNotaDebitoDetalle->NddDescripcion .= "|";	
	
  if(!empty($InsNotaDebito->NdbDatoAdicional13) or !empty($InsNotaDebito->NdbDatoAdicional7) or !empty($InsNotaDebito->NdbDatoAdicional1)){
	
	$DatNotaDebitoDetalle->NddDescripcion .= "( ";

  }

  if(!empty($InsNotaDebito->NdbDatoAdicional13)){
	
	$DatNotaDebitoDetalle->NddDescripcion .= "Nro. VIN o CHASIS: ".$InsNotaDebito->NdbDatoAdicional13.", ";
	
  }

  
  

  if(!empty($InsNotaDebito->NdbDatoAdicional7)){
 
		$DatNotaDebitoDetalle->NddDescripcion .= "Nro. Motor: ".$InsNotaDebito->NdbDatoAdicional7.", ";
	
  }
  
  

  if(!empty($InsNotaDebito->NdbDatoAdicional1)){
 
		$DatNotaDebitoDetalle->NddDescripcion .= "Marca: ".$InsNotaDebito->NdbDatoAdicional1.", ";
 
  }

  if(!empty($InsNotaDebito->NdbDatoAdicional13) or !empty($InsNotaDebito->NdbDatoAdicional7) or !empty($InsNotaDebito->NdbDatoAdicional1)){
	
   $DatNotaDebitoDetalle->NddDescripcion .= " )";
   
  }
  
  
					unset($ArrPalabras);		
				
					list($Vehiculo,$Accesorios) = explode("|",$DatNotaDebitoDetalle->NddDescripcion);
					
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
							
							if($DatNotaDebitoDetalle->NddTipo<>"T"){
								$pdf->Cell(20,5,$DatNotaDebitoDetalle->NddCodigo,$lineas,0);	
							}else{
								$pdf->Cell(20,5,"",$lineas,0);	
							}
							
							if($DatNotaDebitoDetalle->NddTipo<>"T"){
								$pdf->Cell(10,5,$DatNotaDebitoDetalle->NddCantidad,$lineas,0);	
							}else{
								$pdf->Cell(10,5,"",$lineas,0);	
							}
							
							$pdf->Cell(25,5,$DatNotaDebitoDetalle->NddUnidadMedida,$lineas,0);
							
							$pdf->Cell(75,5,$afila[$j],$lineas,0);
							
							if($DatNotaDebitoDetalle->NddTipo<>"T"){
								$pdf->Cell(20,5,number_format($DatNotaDebitoDetalle->NddPrecio,2),$lineas,0,"R");
							}else{
								$pdf->Cell(20,5,'',$lineas,0,"R");
							}
							
							if($DatNotaDebitoDetalle->NddTipo<>"T"){
								$pdf->Cell(20,5,number_format($DatNotaDebitoDetalle->NddValorVentaUnitario,2),$lineas,0,"R");
							}else{
								$pdf->Cell(20,5,'',$lineas,0,"R");
							}
							
							if($DatNotaDebitoDetalle->NddTipo<>"T"){
								$pdf->Cell(20,5,number_format($DatNotaDebitoDetalle->NddValorVenta,2),$lineas,1,"R");
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
//			if($InsNotaDebito->MonId<>$EmpresaMonedaId and (!empty($InsNotaDebito->NdbTipoCambio) )){
//				
//				$DatNotaDebitoDetalle->NddImporte = ($DatMaterial->NddImporte / $InsNotaDebito->NdbTipoCambio);
//				$DatNotaDebitoDetalle->NddPrecio = ($DatMaterial->NddPrecio  / $InsNotaDebito->NdbTipoCambio);
//				
//			}
//						
//			if($DatNotaDebitoDetalle->NddTipo<>"T"){
//				$pdf->Cell(10,5,$DatMaterial->NddCantidad,$lineas,0);	
//			}else{
//				$pdf->Cell(10,5,"",$lineas,0);	
//			}
//			
//			
//			$pdf->Cell(30,5,$DatMaterial->NddUnidadMedida,$lineas,0);
//			$pdf->Cell(100,5,stripslashes( $DatMaterial->NddDescripcion),$lineas,0);
//			
//			if($DatNotaDebitoDetalle->NddTipo<>"T"){
//				$pdf->Cell(2,5,number_format($DatMaterial->NddPrecio,2),$lineas,0,"R");
//			}
//			
//			if($DatNotaDebitoDetalle->NddTipo<>"T"){
//				$pdf->Cell(25,5,number_format($DatMaterial->NddImporte,2),$lineas,1,"R");
//			}
//			
//			$TotalBruto = $TotalBruto + $DatMaterial->NddImporte;		
//		
//		$MaterialImporte += $DatMaterial->NddImporte;
//	}
//	
//		
//}

$TotalLineas = count($InsNotaDebito->NotaDebitoDetalle);

//if($TotalLineas<15 and empty($InsNotaDebito->OvvId)){
if($TotalLineas<15 ){
	
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
	$pdf->Cell(70,5,$InsNotaDebito->VmaNombre." ".$InsNotaDebito->VmoNombre." ".$InsNotaDebito->VveNombre,$lineas,1);


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
	$pdf->Cell(30,5,$InsNotaDebito->FinVehiculoKilometraje." ".(!empty($InsNotaDebito->FinVehiculoKilometraje))?'KM':'',$lineas,0);
	
}

if(!empty($InsNotaDebito->AmoId)){
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"Ficha: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(30,5,$InsNotaDebito->AmoId,$lineas,0);

	$pdf->Ln(5);
	
}

if(!empty($InsNotaDebito->OvvId)){
	
	//$pdf->Cell(40,5,"",$lineas,0);		
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(20,5,"Marca: ",$lineas,0);	
//	$pdf->SetFont('times', 'N', 8);
//	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional1,$lineas,0);
//	
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(20,5,"Tracción: ",$lineas,0);	
//	$pdf->SetFont('times', 'N', 8);
//	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional2,$lineas,1);
//	
//	$pdf->Cell(40,5,"",$lineas,0);	
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(20,5,"Modelo: ",$lineas,0);	
//	 $pdf->SetFont('times', 'N', 8);
//	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional3,$lineas,0);
//	
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(20,5,"Carroceria: ",$lineas,0);	
//	$pdf->SetFont('times', 'N', 8);
//	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional4,$lineas,1);
//	
//	$pdf->Cell(40,5,"",$lineas,0);	
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(20,5,"Año Fabric.: ",$lineas,0);	
//	$pdf->SetFont('times', 'N', 8);
//	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional5,$lineas,0);
//	
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(20,5,"No. Puertas: ",$lineas,0);	
//	$pdf->SetFont('times', 'N', 8);
//	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional6,$lineas,1);
//	
//	
//	$pdf->Cell(40,5,"",$lineas,0);	
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(20,5,"No. Motor: ",$lineas,0);	
//	$pdf->SetFont('times', 'N', 8);
//	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional7,$lineas,0);
//	
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(20,5,"Combustible: ",$lineas,0);	
//	$pdf->SetFont('times', 'N', 8);
//	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional8,$lineas,1);
//	
//	$pdf->Cell(40,5,"",$lineas,0);	
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(20,5,"No. Cilindros: ",$lineas,0);	
//	$pdf->SetFont('times', 'N', 8);
//	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional9,$lineas,0);
//	
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(20,5,"Peso Bruto: ",$lineas,0);	
//	$pdf->SetFont('times', 'N', 8);
//	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional10,$lineas,1);
//	
//	
//	$pdf->Cell(40,5,"",$lineas,0);	
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(20,5,"No. Ejes: ",$lineas,0);	
//	$pdf->SetFont('times', 'N', 8);
//	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional11,$lineas,0);
//	
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(20,5,"Carga Util: ",$lineas,0);	
//	$pdf->SetFont('times', 'N', 8);
//	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional12,$lineas,1);
//	
//	
//	$pdf->Cell(40,5,"",$lineas,0);	
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(20,5,"No. Chasis: ",$lineas,0);	
//	$pdf->SetFont('times', 'N', 8);
//	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional13,$lineas,0);
//	
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(20,5,"Peso Seco: ",$lineas,0);	
//	$pdf->SetFont('times', 'N', 8);
//	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional14,$lineas,1);
//	
//	$pdf->Cell(40,5,"",$lineas,0);	
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(20,5,"Color: ",$lineas,0);	
//	$pdf->SetFont('times', 'N', 8);
//	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional15,$lineas,0);
//	
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(20,5,"Alto: ",$lineas,0);	
//	$pdf->SetFont('times', 'N', 8);
//	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional16,$lineas,1);
//	
//	$pdf->Cell(40,5,"",$lineas,0);	
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(20,5,"Cilindrada: ",$lineas,0);	
//	$pdf->SetFont('times', 'N', 8);
//	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional17,$lineas,0);
//	
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(20,5,"Largo: ",$lineas,0);	
//	$pdf->SetFont('times', 'N', 8);
//	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional18,$lineas,1);
//	
//
//
//	$pdf->Cell(40,5,"",$lineas,0);	
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(20,5,"No. Asientos: ",$lineas,0);	
//	$pdf->SetFont('times', 'N', 8);
//	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional19,$lineas,0);
//	
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(20,5,"Ancho: ",$lineas,0);	
//	$pdf->SetFont('times', 'N', 8);
//	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional20,$lineas,1);
//	
//	
//	$pdf->Cell(40,5,"",$lineas,0);	
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(20,5,"Cap. Pasajeros: ",$lineas,0);	
//	$pdf->SetFont('times', 'N', 8);
//	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional21,$lineas,0);
//	
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(20,5,"Dist. Ejes: ",$lineas,0);	
//	$pdf->SetFont('times', 'N', 8);
//	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional22,$lineas,1);
//	
//	
//	$pdf->Cell(40,5,"",$lineas,0);	
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(20,5,"No. Poliza: ",$lineas,0);	
//	$pdf->SetFont('times', 'N', 8);
//	$pdf->Cell(45,5,$InsNotaDebito->NdbDatoAdicional23,$lineas,0);
	
	
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

/*
* MONTO EN LETRAS
*/

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
$pdf->Cell(10,5,$InsNotaDebito->MonSimbolo,$lineas,0,"L");
$pdf->Cell(25,5,number_format($InsNotaDebito->NdbTotalGravado,2),1,1,"R");


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
$pdf->Cell(10,5,$InsNotaDebito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaDebito->NdbTotalInafecta,2),1,1,'R');



$pdf->Cell(120,5,"",$lineas,0,"C");

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"OP. EXONERADAS",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaDebito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaDebito->NdbTotalExonerado,2),1,1,'R');


$pdf->Cell(120,5,"",$lineas,0,"C");

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"OP. GRATUITAS",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaDebito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaDebito->NdbTotalGratuita,2),1,1,'R');


//FILA
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(20,5,"SON:",$lineas,0,"L");
$pdf->SetFont('times', '', 8);
$pdf->Cell(100,5,$numalet->letra()." CON ".$parte_decimal."/100"." ".$InsNotaDebito->MonNombre,$lineas,0,'L');

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"OTROS CARGOS",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaDebito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaDebito->NdbTotalOtrosCargos,2),1,1,'R');


//FILA
$pdf->Cell(120,5,"",$lineas,0,'C');

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"OTROS TRIBUTOS",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaDebito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaDebito->NdbTotalOtrosTributos,2),1,1,'R');

//FILA
$pdf->Cell(120,5,"",$lineas,0,'C');

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"DESCUENTO",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaDebito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaDebito->NdbTotalDescuento,2),1,1,'R');

if($InsNotaDebito->NdbTotalImpuestoSelectivo>0){
	
		//FILA

	$pdf->Cell(120,5,"",$lineas,0,'L');
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(35,5,"Total ISC ".number_format($InsNotaDebito->NdbPorcentajeImpuestoSelectivo,2)."%",$lineas,0,'R');
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(10,5,$InsNotaDebito->MonSimbolo,$lineas,0,'L');
	$pdf->Cell(25,5,number_format($InsNotaDebito->NdbTotalImpuestoSelectivo,2),1,1,'R');

}

//FILA

$pdf->Cell(120,5,"",$lineas,0,'L');

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"IGV ".number_format($InsNotaDebito->NdbPorcentajeImpuestoVenta,2)."%",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaDebito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaDebito->NdbImpuesto,2),1,1,'R');

//FILA
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(120,5,"OBSERVACIONES:",$lineas,0,'L');

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"TOTAL",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaDebito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaDebito->NdbTotal,2),1,1,'R');

//$pdf->Ln(15);

/*
* OBSERVACIONES
*/
if(!empty($InsNotaDebito->NdbObservacionImpresa)){
//	
//	$pdf->SetFont('times', 'B', 8);
//	$pdf->Cell(190,5,"OBSERVACIONES:",$lineas,1,'L');

	$pdf->SetFont('times', '', 8);

	$pos = strrpos($InsNotaDebito->NdbObservacionImpresa, "|");
	
	if ($pos === false) { // nota: tres signos de igual
		// no encontrado...
		
			$pdf->Cell(190,5,$InsNotaDebito->NdbObservacionImpresa,$lineas,1);
		
	}else{
		
		$ArrPalabras = explode("|",$InsNotaDebito->NdbObservacionImpresa);
		
		$pdf->Cell(190,5,($ArrPalabras[0])."",$lineas,1);
		$pdf->Cell(190,5,($ArrPalabras[1])."",$lineas,1);
	}
	
	
}

if(!empty($InsNotaDebito->NdbMotivoCodigo)){
 
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
$pdf->Cell(30,5,$InsNotaDebito->DtaNumero."-".$InsNotaDebito->DocId,1,0,'C');
$pdf->Cell(30,5,$InsNotaDebito->DocFechaEmision,1,0,'C');
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
$pdf->Cell(10,5,$InsNotaDebito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaDebito->NdbTotalGratuita,2),1,1,'R');

//FILA
$pdf->Cell(120,5,"",$lineas,0,'C');

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"OTROS CARGOS",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaDebito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaDebito->NdbTotalOtrosCargos,2),1,1,'R');

//FILA
$pdf->Cell(120,5,"",$lineas,0,'C');

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"OTROS TRIBUTOS",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaDebito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaDebito->NdbTotalOtrosTributos,2),1,1,'R');

//FILA
$pdf->Cell(120,5,"",$lineas,0,'C');

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"DESCUENTO",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaDebito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaDebito->NdbTotalDescuento,2),1,1,'R');

if($InsNotaDebito->NdbTotalImpuestoSelectivo>0){
	
		//FILA
	$pdf->SetFont('times', 'B', 12);
	$pdf->Cell(120,5,"",$lineas,0,'L');
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(35,5,"Total ISC ".number_format($InsNotaDebito->NdbPorcentajeImpuestoSelectivo,2)."%",$lineas,0,'R');
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(10,5,$InsNotaDebito->MonSimbolo,$lineas,0,'L');
	$pdf->Cell(25,5,number_format($InsNotaDebito->NdbTotalImpuestoSelectivo,2),1,1,'R');

}

//FILA
$pdf->SetFont('times', 'B', 12);
$pdf->Cell(120,5,"",$lineas,0,'L');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"IGV ".number_format($InsNotaDebito->NdbPorcentajeImpuestoVenta,2)."%",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaDebito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaDebito->NdbImpuesto,2),1,1,'R');

//FILA
$pdf->Cell(120,5,"",$lineas,0,'C');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"TOTAL",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsNotaDebito->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsNotaDebito->NdbTotal,2),1,1,'R');
*/

/*
GENERAR CODIGO QR
*/

$ArchivoFacturaCodigoQR = $InsNotaDebito->NdtNumero."-".$InsNotaDebito->NdbId.'_QR.png'; 
$RutaFacturaCodigoQR = "../../generados/comprobantes/".$ArchivoFacturaCodigoQR; 
// generating 

if (file_exists($RutaFacturaCodigoQR)) { 
	unlink($RutaFacturaCodigoQR); 
}

// QRcode::png($InsNotaDebito->NdtNumero."-".$InsNotaDebito->NdbId, $RutaFacturaCodigoQR); 
$CodigoQR = $EmpresaCodigo.'|8|'.$InsNotaDebito->NdtNumero.'|'.$InsNotaDebito->NdbId.'|'.number_format($Impuesto,2, '.', '').'|'.number_format($Total,2, '.', '').'|'.FncCambiaFechaAMysql($InsNotaDebito->NdbFechaEmision).'|1|'.$InsNotaDebito->CliNumeroDocumento.'|'.$InsNotaDebito->NdbSunatRespuestaEnvioDigestValue.'|'.$InsNotaDebito->NdbSunatRespuestaEnvioSignatureValue;

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
//$pdf->Cell(80,3,"Sistema de Facturacion Electrónica CREATIVA AQP - www.creativa.com.pe",$lineas,1,'C',0,0);
$pdf->Cell(80,3,"Sistema de Facturacion Electrónica",$lineas,1,'C',0,0);

$pdf->Ln(2);
$pdf->SetLeftMargin(10);


$pdf->SetFont('times', 'B', 6);
//$pdf->Cell(190,3,"Esta es una representación impresa de la Factura electrónica, Pede verificarlo utilizando su clave SOL en www.sunat.gob.pe o en",0,1,'C',0,0);
//$pdf->Cell(190,3,"http://app.facturaonline.pe/invitado",0,1,'C',0,0);
$pdf->Cell(190,3,"Esta es una representación impresa de la Nota de Debito electrónica, Pede verificarlo utilizando su clave SOL en www.sunat.gob.pe",0,1,'C',0,0);

	
$pdf->Output('../../generados/comprobantes_pdf/'.$NOMBRE.'.pdf', 'F');

$pdf->Output($NOMBRE.".pdf");



?>