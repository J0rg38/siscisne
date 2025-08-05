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
require_once($InsProyecto->MtdRutLibrerias().'TCPDF-master/tcpdf_barcodes_2d.php');

require_once($InsProyecto->MtdRutLibrerias().'phpqrcode/qrlib.php');


$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];
$GET_TiempoImpresion = $_GET['TiempoImpresion'];
$GET_Fecha = $_GET['Fecha'];

require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');

$InsBoleta = new ClsBoleta();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//echo "adsfadfs";
//Obteniendo datos de factura
$InsBoleta->BolId = $GET_id;
$InsBoleta->BtaId = $GET_ta;
$InsBoleta = $InsBoleta->MtdObtenerBoleta();

$NOMBRE = $EmpresaCodigo.'-03-'.$InsBoleta->BtaNumero.'-'.$InsBoleta->BolId;

if($InsBoleta->MonId<>$EmpresaMonedaId){
	
	$InsBoleta->BolTotalGravado = round($InsBoleta->BolTotalGravado/$InsBoleta->BolTipoCambio,2);
	$InsBoleta->BolTotalExonerado = round($InsBoleta->BolTotalExonerado/$InsBoleta->BolTipoCambio,2);
	$InsBoleta->BolTotalGratuito = round($InsBoleta->BolTotalGratuito/$InsBoleta->BolTipoCambio,2);
	$InsBoleta->BolTotalDescuento = round($InsBoleta->BolTotalDescuento/$InsBoleta->BolTipoCambio,2);
	$InsBoleta->BolTotalImpuestoSelectivo = round($InsBoleta->BolTotalImpuestoSelectivo/$InsBoleta->BolTipoCambio,2);
	
	$InsBoleta->BolTotalPagar = round($InsBoleta->BolTotalPagar/$InsBoleta->BolTipoCambio,2);
	//$InsBoleta->BolTotalDescuento = round($InsBoleta->BolTotalDescuento/$InsBoleta->BolTipoCambio,2);
	
	$InsBoleta->BolSubTotal = round($InsBoleta->BolSubTotal/$InsBoleta->BolTipoCambio,2);	
	$InsBoleta->BolImpuesto = round($InsBoleta->BolImpuesto/$InsBoleta->BolTipoCambio,2);
	$InsBoleta->BolTotal = round($InsBoleta->BolTotal/$InsBoleta->BolTipoCambio,2);	
 
}
	
     
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
		global $InsBoleta;
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
			$this->Cell(70,5,"BOLETA ELECTRONICA",$lineas,1,'C');

		$this->SetFont('times', '', 10);
		$this->Cell(45,5,'',$lineas,0,'C',0);
		$this->SetFont('times', '', 6);
		$this->Cell(75,5,$EmpresaProvincia." - ".$EmpresaDistrito." - ".$EmpresaDepartamento,$lineas,0,'C');
//		
//		
			$this->SetFont('times', 'B', 10);
			$this->Cell(70,5,"N°. ".$InsBoleta->BtaNumero."-".$InsBoleta->BolId,$lineas,1,'C');
			
			
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
		global $InsBoleta;
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
//			<td style="width:150px; padding: 2px; text-align:left;"><img src="'.$RutaBoletaCodigoQR.'" border="0" align="top" alt="Nexnet" /></td>
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
//		$this->write2DBarcode($InsBoleta->BtaNumero."-".$InsBoleta->BolId, 'QRCODE', 0, 0, 0, 30, $style, 'N');
		
	}
}


$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf = new TCPDF();

//$pdf->SetHeaderData('logotipo.png', PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));

// set document information
$pdf->SetCreator($EmpresaNombre);
$pdf->SetAuthor($EmpresaNombre);
$pdf->SetTitle($InsBoleta->BtaNumero."-".$InsBoleta->BolId);
$pdf->SetSubject("Boleta Electronica");
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
//	$pdf->Cell(90,5,"No. ".$InsBoleta->BtaNumero."-".$InsBoleta->BolId,$lineas,1,'C');
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
//$pdf->RoundedRect(10, 30, 190, 20, 2, '1111', NULL);
$pdf->RoundedRect(140, 7, 50, 25, 2, '1111', NULL);

$NombreCliente = $InsBoleta->CliNombre." ".$InsBoleta->CliApellidoPaterno." ".$InsBoleta->CliApellidoMaterno;

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
		$pdf->Cell(15,5,"CLIENTE: ",$lineas,0,"L");
		$pdf->SetFont('times', 'N', 7);
		$pdf->Cell(170,5,$afila[$j],$lineas,1,"L");

	}else{

		$pdf->SetFont('times', 'B', 8);
		$pdf->Cell(15,5,"",$lineas,0,"L");
		$pdf->SetFont('times', 'N', 7);
		$pdf->Cell(170,5,$afila[$j],$lineas,1,"L");
		
	}
	
}

$ArrPalabras = explode(" ",$InsBoleta->BolDireccion);

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
		$pdf->Cell(15,5,"DIRECCION: ",$lineas,0);
		$pdf->SetFont('times', 'N', 7);
		$pdf->Cell(170,5,$afila[$j],$lineas,1,"L");

	}else{

		$pdf->SetFont('times', 'B', 7);
		$pdf->Cell(15,5,"",$lineas,0);
		$pdf->SetFont('times', 'N', 7);
		$pdf->Cell(170,5,$afila[$j],$lineas,1,"L");
		
	}
	
}

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(15,5,"D.N.I: ",$lineas,0);
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(170,5,$InsBoleta->CliNumeroDocumento,$lineas,1);








$pdf->SetFont('times', 'B', 8);
$pdf->Cell(10,5,"",$lineas,0,"C");
$pdf->Cell(25,5,"FECHA",1,0,"C");
$pdf->Cell(25,5,"MONEDA",1,0,"C");
$pdf->Cell(25,5,"VENDEDOR",1,0,"C");
$pdf->Cell(25,5,"VENCIMIENTO",1,0,"C");
$pdf->Cell(25,5,"N° PEDIDO",1,0,"C");
$pdf->Cell(25,5,"USUARIO",1,0,"C");
$pdf->Cell(25,5,"TIPO PAGO",1,1,"C");

$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,"",$lineas,0,"C");
$pdf->Cell(25,5,(!empty($GET_Fecha)?$GET_Fecha:$InsBoleta->BolFechaEmision),1,0,"C");
$pdf->Cell(25,5,$InsBoleta->MonSimbolo,1,0,"C");
$pdf->Cell(25,5,$InsBoleta->BolVendedor,1,0,"C");
$pdf->Cell(25,5,$InsBoleta->BolFechaVencimiento,1,0,"C");
$pdf->Cell(25,5,$InsBoleta->BolNumeroPedido,1,0,"C");
$pdf->Cell(25,5,$InsBoleta->UsuUsuario,1,0,"C");
$pdf->Cell(25,5,$InsBoleta->NpaNombre,1,1,"C");

$pdf->Ln(5);
$pdf->SetLeftMargin(10);


/*
* DETALLE
*/

$pdf->Cell(10,5,"CODIGO",1,0,"C");
$pdf->Cell(10,5,"CANTIDAD",1,0,"C");
$pdf->Cell(30,5,"U/M",1,0,"C");
$pdf->Cell(100,5,"DESCRIPCION",1,0,"C");
$pdf->Cell(15,5,"PRECIO UNITARIO",1,0,"C");
$pdf->Cell(15,5,"VALOR UNITARIO",1,0,"C");
$pdf->Cell(15,5,"VALOR TOTAL",1,1,"C");

$ArrMateriales = array();

$pdf->SetFont('times', 'N', 8);

if(!empty($InsBoleta->BoletaDetalle)){
	foreach($InsBoleta->BoletaDetalle as $DatBoletaDetalle){

			if($InsBoleta->MonId<>$EmpresaMonedaId and (!empty($InsBoleta->BolTipoCambio) )){
		
				$DatBoletaDetalle->BdeImporte = ($DatBoletaDetalle->BdeImporte / $InsBoleta->BolTipoCambio);
				$DatBoletaDetalle->BdePrecio = ($DatBoletaDetalle->BdePrecio  / $InsBoleta->BolTipoCambio);
				
				$DatBoletaDetalle->BdeValorVenta = ($DatBoletaDetalle->BdeValorVenta / $InsBoleta->BolTipoCambio);
				$DatBoletaDetalle->BdeValorVentaUnitario = ($DatBoletaDetalle->BdeValorVentaUnitario  / $InsBoleta->BolTipoCambio);
				
			}
					
			if(empty($InsBoleta->OvvId)){
				
				$pos = strrpos($DatBoletaDetalle->BdeDescripcion, "|");
				
				if ($pos === false) { // nota: tres signos de igual
					// no encontrado...
					
					$ArrPalabras = explode(" ",$DatBoletaDetalle->BdeDescripcion);
					
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
							
							if($DatBoletaDetalle->BdeTipo<>"T"){
								$pdf->Cell(10,5,$DatBoletaDetalle->BdeCodigo,$lineas,0);	
							}else{
								$pdf->Cell(10,5,"",$lineas,0);	
							}
							
							if($DatBoletaDetalle->BdeTipo<>"T"){
								$pdf->Cell(10,5,$DatBoletaDetalle->BdeCantidad,$lineas,0);	
							}else{
								$pdf->Cell(10,5,"",$lineas,0);	
							}

							$pdf->Cell(30,5,$DatBoletaDetalle->BdeUnidadMedida,$lineas,0);
							
							$pdf->Cell(100,5,($afila[$j])."",$lineas,0);
							
							if($DatBoletaDetalle->BdeTipo<>"T"){
								$pdf->Cell(15,5,number_format($DatBoletaDetalle->BdePrecioUnitario,2),$lineas,0,"R");
							}else{
								$pdf->Cell(15,5,'',$lineas,0,"R");
							}
							
							if($DatBoletaDetalle->BdeTipo<>"T"){
								$pdf->Cell(15,5,number_format($DatBoletaDetalle->BdeValorVentaUnitario,2),$lineas,0,"R");
							}else{
								$pdf->Cell(15,5,'',$lineas,0,"R");
							}
							
							if($DatBoletaDetalle->BdeTipo<>"T"){
								$pdf->Cell(15,5,number_format($DatBoletaDetalle->BdeValorVenta,2),$lineas,1,"R");
							}else{
								$pdf->Cell(15,5,'',$lineas,1,"R");
							}
				
						}else{
							
							$pdf->Cell(10,5,"",$lineas,0);	
							$pdf->Cell(10,5,"",$lineas,0);								
							$pdf->Cell(30,5,"",$lineas,0);
							$pdf->Cell(100,5,$afila[$j],$lineas,0);
							$pdf->Cell(15,5,"",$lineas,0,"R");
							$pdf->Cell(15,5,"",$lineas,1,"R");
							$pdf->Cell(15,5,"",$lineas,0,"R");
							
						}
						
						
					}
					
					
					

					
				}else{
					
					
					$filas_adicionales = 0;
					
					unset($ArrRepuestos);		
				
					$ArrRepuestos = explode("|",$DatBoletaDetalle->BdeDescripcion);
					
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

										$pdf->Cell(10,5,"1",$lineas,0);	
										$pdf->Cell(10,5,"",$lineas,0);								
										$pdf->Cell(30,5,"",$lineas,0);
										$pdf->Cell(100,5,$afila[$j],$lineas,0);
										$pdf->Cell(15,5,number_format($DatBoletaDetalle->BdePrecioUnitario,2),$lineas,0,"R");
										$pdf->Cell(15,5,number_format($DatBoletaDetalle->BdeValorVentaUnitario,2),$lineas,0,"R");
										$pdf->Cell(15,5,number_format($DatBoletaDetalle->BdeValorVenta,2),$lineas,1,"R");
				
									}else{
										$pdf->Cell(10,5,"",$lineas,0);	
										$pdf->Cell(10,5,"",$lineas,0);								
										$pdf->Cell(30,5,"",$lineas,0);
										$pdf->Cell(100,5,$afila[$j],$lineas,0);
										$pdf->Cell(15,5,"",$lineas,0,"R");
										$pdf->Cell(15,5,"",$lineas,0,"R");
										$pdf->Cell(15,5,"",$lineas,1,"R");
									}
									
									
								}

								
							}else{
								
								$pdf->Cell(10,5,"",$lineas,0);	
								$pdf->Cell(10,5,"",$lineas,0);								
								$pdf->Cell(30,5,"",$lineas,0);
								$pdf->Cell(100,5,"- ".$DatRepuesto,$lineas,0);
								$pdf->Cell(15,5,"",$lineas,0,"R");
								$pdf->Cell(15,5,"",$lineas,0,"R");
								$pdf->Cell(15,5,"",$lineas,1,"R");
								$filas_adicionales++;
								
							}
							
							$repuestos ++;
						}
						
					}
					
					
				}
				
				
			
			}else{
				
					
					unset($ArrPalabras);		
				
					list($Vehiculo,$Accesorios) = explode("|",$DatBoletaDetalle->BdeDescripcion);
					
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
							

							if($DatBoletaDetalle->BdeTipo<>"T"){
								$pdf->Cell(10,5,$DatBoletaDetalle->BdeCodigo,$lineas,0);	
							}else{
								$pdf->Cell(10,5,"",$lineas,0);	
							}
							
							if($DatBoletaDetalle->BdeTipo<>"T"){
								$pdf->Cell(10,5,$DatBoletaDetalle->BdeCantidad,$lineas,0);	
							}else{
								$pdf->Cell(10,5,"",$lineas,0);	
							}
							
							$pdf->Cell(30,5,$DatBoletaDetalle->BdeUnidadMedida,$lineas,0);
							
							$pdf->Cell(100,5,$afila[$j],$lineas,0);
							
							if($DatBoletaDetalle->BdeTipo<>"T"){
								$pdf->Cell(15,5,number_format($DatBoletaDetalle->BdePrecioUnitario,2),$lineas,0,"R");
							}else{
								$pdf->Cell(15,5,'',$lineas,0,"R");
							}
							
							if($DatBoletaDetalle->BdeTipo<>"T"){
								$pdf->Cell(15,5,number_format($DatBoletaDetalle->BdeValorVentaUnitario,2),$lineas,0,"R");
							}else{
								$pdf->Cell(15,5,'',$lineas,0,"R");
							}
							
							if($DatBoletaDetalle->BdeTipo<>"T"){
								$pdf->Cell(15,5,number_format($DatBoletaDetalle->BdeValorVenta,2),$lineas,1,"R");
							}else{
								$pdf->Cell(15,5,'',$lineas,1,"R");
							}
							
						}else{
							
							$pdf->Cell(10,5,"",$lineas,0);	
							$pdf->Cell(10,5,"",$lineas,0);								
							$pdf->Cell(30,5,"",$lineas,0);
							$pdf->Cell(100,5,$afila[$j],$lineas,0);
							$pdf->Cell(15,5,"",$lineas,0,"R");
							$pdf->Cell(15,5,"",$lineas,0,"R");
							$pdf->Cell(15,5,"",$lineas,1,"R");
							
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
							
							$pdf->Cell(10,5,"",$lineas,0);
							$pdf->Cell(10,5,"",$lineas,0);	
							$pdf->Cell(30,5,"",$lineas,0);
							$pdf->Cell(100,5,$afila[$j],$lineas,0);
							$pdf->Cell(15,5,'',$lineas,0,"R");
							$pdf->Cell(15,5,'',$lineas,0,"R");
							$pdf->Cell(15,5,'',$lineas,1,"R");
							
							
						}else{
							
							$pdf->Cell(10,5,"",$lineas,0);
							$pdf->Cell(10,5,"",$lineas,0);								
							$pdf->Cell(30,5,"",$lineas,0);
							$pdf->Cell(100,5,$afila[$j],$lineas,0);
							$pdf->Cell(15,5,"",$lineas,0,"R");
							$pdf->Cell(15,5,"",$lineas,0,"R");
							$pdf->Cell(15,5,"",$lineas,1,"R");
							
						}
						
						
					}
				
			}
			
			
		
	}
}

$TotalLineas = count($InsBoleta->BoletaDetalle) + $filas_adicionales;

if($TotalLineas<10 and empty($InsBoleta->OvvId)){

	$TotalLineasFaltantes = 15 - $TotalLineas;
	
	for($i=1;$i<=$TotalLineasFaltantes;$i++){
			
		$pdf->Cell(10,5,"",$lineas,0,"C");
		$pdf->Cell(30,5,"",$lineas,0,"C");
		$pdf->Cell(100,5,"",$lineas,0,"C");
		$pdf->Cell(25,5,"",$lineas,0,"C");
		$pdf->Cell(25,5,"",$lineas,1,"C");
		
	}

}

//$pdf->SetLeftMargin(10);
if(!empty($InsBoleta->BolFechaVencimiento)){
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(30,5,"FECHA DE VENCIMIENTO: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(30,5,$InsBoleta->BolFechaVencimiento,$lineas,0);	

}

if(!empty($InsBoleta->EinVIN)){

	//$pdf->Ln(5);
	//$pdf->SetLeftMargin(10);

	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"VIN: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->EinVIN,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"Placa: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->EinPlaca,$lineas,1);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(35,5,"Marca/Modelo/Version: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(70,5,$InsBoleta->VmaNombre." ".$InsBoleta->VmoNombre." ".$InsBoleta->VveNombre,$lineas,1);

}


if(!empty($InsBoleta->FinId)){

	//$pdf->Ln(5);
//$pdf->SetLeftMargin(10);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"O.T.: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(30,5,$InsBoleta->FinId,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"Kilom.: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(30,5,($InsBoleta->FinVehiculoKilometraje." ".(!empty($InsBoleta->FinVehiculoKilometraje)?'KM':'')),$lineas,0);
	
}
		
//$pdf->Ln(5);
//$pdf->SetLeftMargin(10);
if(!empty($InsBoleta->AmoId)){
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"Ficha: ",$lineas,0);
	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(30,5,$InsBoleta->AmoId,$lineas,0);
	
}



if(!empty($InsBoleta->OvvId)){
	
	$pdf->Cell(40,5,"",$lineas,0);		
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Marca: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->BolDatoAdicional1,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Tracción: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->BolDatoAdicional2,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Modelo: ",$lineas,0);	
	 $pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->BolDatoAdicional3,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Carroceria: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->BolDatoAdicional4,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Año Fabric.: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->BolDatoAdicional5,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Puertas: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->BolDatoAdicional6,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Motor: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->BolDatoAdicional7,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Combustible: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->BolDatoAdicional8,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Cilindros: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->BolDatoAdicional9,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Peso Bruto: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->BolDatoAdicional10,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Ejes: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->BolDatoAdicional11,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Carga Util: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->BolDatoAdicional12,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Chasis: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->BolDatoAdicional13,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Peso Seco: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->BolDatoAdicional14,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Color: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->BolDatoAdicional15,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Alto: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->BolDatoAdicional16,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Cilindrada: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->BolDatoAdicional17,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Largo: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->BolDatoAdicional18,$lineas,1);
	


	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Asientos: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->BolDatoAdicional19,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Ancho: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->BolDatoAdicional20,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Cap. Pasajeros: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->BolDatoAdicional21,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Dist. Ejes: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->BolDatoAdicional22,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Poliza: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsBoleta->BolDatoAdicional23,$lineas,1);
	
	
		if(count($InsBoleta->OrdenVentaVehiculoPropietario)>1){

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
				
			foreach($InsBoleta->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
				
				if($InsBoleta->CliId<> $DatOrdenVentaVehiculoPropietario->CliId){	
	
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

$pdf->SetFont('times', 'N', 8);
$pdf->Cell(170,5,"----------------------------",$lineas,1);

$pdf->Cell(20,5,"PREPARADO",1,0,"C");
$pdf->Cell(10,5,"V°B°",1,0,"C");

$pdf->Cell(5,5,"",$lineas,0,"C");

$pdf->SetFont('times', 'N', 6);
$pdf->Cell(30,5,"RECIBIDO POR EL CLIENTE",1,0,"C");

$pdf->Cell(5,5,"",$lineas,0,"C");

$pdf->Cell(30,5,"CANCELADO",1,1,"C");

$pdf->Cell(20,15,"",1,0,"C");
$pdf->Cell(10,15,"",1,0,"C");

$pdf->Cell(51,5,"",$lineas,0,"C");

$pdf->SetFont('times', 'N', 6);
$pdf->Cell(30,15,"",1,0,"C");

$pdf->Cell(5,15,"",$lineas,0,"C");

$pdf->Cell(30,15,"",1,0,"C");




   //deb($InsBoleta->BolObsequio);
	if($InsBoleta->BolObsequio==1){
		
		$pdf->SetAlpha(0.3);
		//Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false, $alt=false, $altimgs=array()) {
		$pdf->Image('../../imagenes/transferencia_gratuita.png', 65, 60, 80, 70, 'PNG', '', '', true, 150, '', false, false, 0, true, false, false);
//$mask = $pdf->Image('../../imagenes/transferencia_gratuita.png', 50, 140, 100, '', '', '', '', false, 300, '', true);
		$pdf->SetAlpha(1);

		$pdf->Ln(5);
		$pdf->SetLeftMargin(10);
		
		$pdf->Cell(110,5,$InsBoleta->BolLeyenda." ".number_format($InsBoleta->BolTotalGratuito,2),$lineas,1);
		
	//	$pdf->Cell(110,5,"ENTREGA A TITULO GRATUITO.",$lineas,1);
//		$pdf->Cell(110,5,"VALOR REFERENCIAL ".number_format($Total,2),$lineas,0);
//	
//		$SubTotal = 0;
//        $Impuesto = 0;
//        $Total = 0;
//		
	}





$pdf->SetAlpha(0.4);
$pdf->Image('../../imagenes/comprobantes/comprobante_fondo.png', 76, 60, 70, 60, 'PNG', '', '', true, 150, '', false, false, 0, true, false, false);
$pdf->SetAlpha(1);

$pdf->Ln(5);
$pdf->SetLeftMargin(10);
$pdf->SetFont('times', 'B', 8);

$Total = round($InsBoleta->BolTotal,2);
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

$pdf->Cell(190,5,"SON: ".$numalet->letra()." CON ".$parte_decimal."/100"." ".$InsBoleta->MonNombre,$lineas,1,'L');



$pdf->Cell(190,5,"OBSERVACIONES",$lineas,0,'L');

if(!empty($InsBoleta->BolObservacionImpresa)){
	
	$pdf->Ln(5);
	$pdf->SetLeftMargin(10);	
	
	$pos = strrpos($InsBoleta->BolObservacionImpresa, "|");
	
	if ($pos === false) { // nota: tres signos de igual
		// no encontrado...
		
			$pdf->Cell(190,5,$InsBoleta->BolObservacionImpresa,$lineas,1);
		
	}else{
		
		$ArrPalabras = explode("|",$InsBoleta->BolObservacionImpresa);
		
		$pdf->Cell(190,5,($ArrPalabras[0])."",$lineas,1);
		$pdf->Cell(190,5,($ArrPalabras[1])."",$lineas,0);
	}
		
}


$pdf->SetFont('times', 'B', 8);




//FILA
$pdf->Cell(90,5,"",$lineas,0,'L');
$pdf->Cell(30,5,"",$lineas,0,'R');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"Descuento Global: ",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsBoleta->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsBoleta->BolTotalDescuento,2),1,1,'R');

//FILA
$pdf->SetFont('times', 'B', 12);
$pdf->Cell(120,5,"Para una mejor atención comuníquese con nosotros",$lineas,0,'L');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"Total Gravado",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsBoleta->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsBoleta->BolTotalGravado,2),1,1,'R');

//FILA
$pdf->SetFont('times', 'B', 12);
$pdf->Cell(120,5,"para separar su cita llamando a los teléfonos: ",$lineas,0,'L');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"Total No Gravado: ",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsBoleta->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsBoleta->BolTotalNoGravado,2),1,1,'R');

//FILA
$pdf->SetFont('times', 'B', 12);
$pdf->Cell(120,5,"Diego: 950312564 / Jose Luis 950309755",$lineas,0,'L');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"Total Exonerado: ",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsBoleta->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsBoleta->BolTotalExonerado,2),1,1,'R');

////FILA
//$pdf->Cell(120,5,"",$lineas,0,'C');
//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(35,5,"Total Otros Cargos: ",$lineas,0,'R');
//$pdf->SetFont('times', 'N', 8);
//$pdf->Cell(10,5,$InsNotaCredito->MonSimbolo,$lineas,0,'L');
//$pdf->Cell(25,5,number_format(0,2),1,1,'R');

if($InsBoleta->BolTotalImpuestoSelectivo>0){
	
		//FILA
	$pdf->SetFont('times', 'B', 12);
	$pdf->Cell(120,5,"",$lineas,0,'L');
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(35,5,"Total ISC ".number_format($InsBoleta->BolPorcentajeImpuestoSelectivo,2)."%",$lineas,0,'R');
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(10,5,$InsBoleta->MonSimbolo,$lineas,0,'L');
	$pdf->Cell(25,5,number_format($InsBoleta->BolTotalImpuestoSelectivo,2),1,1,'R');

}

//FILA
$pdf->SetFont('times', 'B', 12);
$pdf->Cell(120,5,"",$lineas,0,'L');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"Total IGV ".number_format($InsBoleta->BolPorcentajeImpuestoVenta,2)."%",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsBoleta->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsBoleta->BolImpuesto,2),1,1,'R');

//FILA
$pdf->Cell(120,5,"",$lineas,0,'C');
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"Importe Total: ",$lineas,0,'R');
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(10,5,$InsBoleta->MonSimbolo,$lineas,0,'L');
$pdf->Cell(25,5,number_format($InsBoleta->BolTotal,2),1,1,'R');



//$pdf->Cell(120,5,"",$lineas,0,'R');
//$pdf->Cell(35,5,"SubTotal: ",$lineas,0,'R');
//$pdf->Cell(10,5,$InsBoleta->MonSimbolo,$lineas,0,'L');
//$pdf->Cell(25,5,number_format($InsBoleta->BolSubTotal,2),1,1,'R');
//
//$pdf->Cell(120,5,"",$lineas,0,'R');
//$pdf->Cell(35,5,"Impuesto ".$EmpresaImpuestoVenta."%",$lineas,0,'R');
//$pdf->Cell(10,5,$InsBoleta->MonSimbolo,$lineas,0,'L');
//$pdf->Cell(25,5,number_format($InsBoleta->BolImpuesto,2),1,1,'R');
//
//$pdf->Cell(120,5,"",$lineas,0,'R');
//$pdf->Cell(35,5,"Total: ",$lineas,0,'R');
//$pdf->Cell(10,5,$InsBoleta->MonSimbolo,$lineas,0,'L');
//$pdf->Cell(25,5,number_format($InsBoleta->BolTotal,2),1,1,'R');

//$pdf->Cell(120,5,"Para una mejor atencion comuniquese con nosotros para separar su cita. Diego: 950312564 / Jose Luis 950309755",$lineas,0,'L');
//$pdf->Cell(35,5,"",$lineas,0,'R');
//$pdf->Cell(10,5,"",$lineas,0,'L');
//$pdf->Cell(25,5,"",$lineas,1,'R');
//



$pdf->Ln(5);
$pdf->SetLeftMargin(10);
$pdf->Image('../../imagenes/comprobante_pie.png', 10, '', 90, 28, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);

/*
GENERAR CODIGO QR
*/
$ArchivoBoletaCodigoQR = $InsBoleta->BtaNumero."-".$InsBoleta->BolId.'_QR.png'; 
$RutaBoletaCodigoQR = "../../generados/comprobantes/".$ArchivoBoletaCodigoQR; 
// generating 

if (file_exists($RutaBoletaCodigoQR)) { 
	unlink($RutaBoletaCodigoQR); 
}

// QRcode::png($InsBoleta->BtaNumero."-".$InsBoleta->BolId, $RutaBoletaCodigoQR); 
$CodigoQR = $EmpresaCodigo.'|3|'.$InsBoleta->BtaNumero.'|'.$InsBoleta->BolId.'|'.number_format($Impuesto,2, '.', '').'|'.number_format($Total,2, '.', '').'|'.FncCambiaFechaAMysql($InsBoleta->BolFechaEmision).'|1|'.$InsBoleta->CliNumeroDocumento.'|'.$InsBoleta->BolSunatRespuestaEnvioDigestValue.'|'.$InsBoleta->BolSunatRespuestaEnvioSignatureValue;

$barcodeobj = new TCPDF2DBarcode($CodigoQR, 'PDF417');
$data = $barcodeobj->getBarcodePngData(10,5,array(0,0,0));
$im = imagecreatefromstring($data);
$resp = imagepng($im, $RutaBoletaCodigoQR);
imagedestroy($im);


$pdf->Image($RutaBoletaCodigoQR, 120, '', 75, 25, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);


//// set style for barcode
//$style = array(
//	'border' => 2,
//	'vpadding' => 'auto',
//	'hpadding' => 'auto',
//	'fgcolor' => array(0,0,0),
//	'bgcolor' => false, //array(255,255,255)
//	'module_width' => 1, // width of a single module in points
//	'module_height' => 1 // height of a single module in points
//);
//
//$pdf->Ln(25);
//$pdf->SetLeftMargin(10);


//$CodigoQR = $EmpresaCodigo.'|1|'.$InsBoleta->BtaNumero.'|'.$InsBoleta->BolId.'|'.$Impuesto.'|'.$Total.'|'.FncCambiaFechaAMysql($InsBoleta->BolFechaEmision).'|1|'.$InsBoleta->CliNumeroDocumento.'||';
//$pdf->write2DBarcode($CodigoQR , 'PDF417', 120, 160, 0, 0, $style, 'N');
//
//$pdf->SetFont('times', 'N', 6);
//$pdf->Text(0, 200, 'Timbre Electronico');
//$pdf->Text(0, 205, 'Representación impresa de la Boleta Electrónica');
//$pdf->Text(0, 210, 'Autorizado mediante la resolución RS N°374 - 2013');


$pdf->Ln(25);
$pdf->SetLeftMargin(10);

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(122,3,"",$lineas,0,'C',0,0);
$pdf->Cell(50,3,"Timbre Electronico",$lineas,1,'C',0,0);

$pdf->SetFont('times', '', 6);
$pdf->Cell(122,3,"",$lineas,0,'C',0,0);
$pdf->Cell(50,3,"Representación impresa de la Boleta Electrónica",$lineas,1,'C',0,0);

$pdf->SetFont('times', '', 6);
$pdf->Cell(125,3,"",$lineas,0,'C',0,0);
//$pdf->Cell(50,3,"Autorizado mediante la resolución RS N°374 - 2013",$lineas,1,'C',0,0);
$pdf->Cell(50,3,"Autorizado mediante la resolución RS Nº 112-005-0000145",$lineas,1,'C',0,0);



$pdf->Ln(2);
$pdf->SetLeftMargin(10);
			
//$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 4, 'color' => array(0, 0, 0)));
//$pdf->SetFillColor(255,255,128);
//$pdf->SetTextColor(0,0,128);

$pdf->SetFont('times', 'B', 6);
$pdf->Cell(190,5,"Su comprobante electronico podra ser consultado en nuestra pagina web http://www.cyc.com.pe/comprobantes",1,1,'L',0,0);
//$pdf->Ln();
		
//		$pdf->writeHTMLCell(0, 0, 0, 0, 'Curabitur at porta dui...');
//		$pdf->writeHTMLCell(0, 0, 0, 0, 'Lorem ipsum... <img src="'.$RutaBoletaCodigoQR.'" /> Curabitur at porta dui...');

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

//$pdf->write2DBarcode($InsBoleta->BtaNumero."-".$InsBoleta->BolId, 'QRCODE', 80, 90, 0, 30, $style, 'N');
//$pdf->write2DBarcode($InsBoleta->BtaNumero."-".$InsBoleta->BolId, 'QRCODE',10,150,30,30,$style);
//$pdf->Text(10, 150, $InsBoleta->BtaNumero."-".$InsBoleta->BolId);

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
//$pdf->Output('../../generados/comprobantes/'.$NOMBRE.'.pdf', 'F');
$pdf->Output($NOMBRE.".pdf");

?>