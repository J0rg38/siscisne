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

require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemision.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemisionAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemisionDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');

$InsGuiaRemision = new ClsGuiaRemision();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsGuiaRemision->GreId = $GET_id;
$InsGuiaRemision->GrtId = $GET_ta;
$InsGuiaRemision = $InsGuiaRemision->MtdObtenerGuiaRemision();

$NOMBRE = $EmpresaCodigo.'-09-'.$InsGuiaRemision->GrtNumero.'-'.$InsGuiaRemision->GreId;


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
		global $InsGuiaRemision;
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
			$this->Cell(70,5,"GUIA REMISION ELECTRONICA",$lineas,1,'C');

		$this->SetFont('times', '', 10);
		$this->Cell(45,5,'',$lineas,0,'C',0);
		$this->SetFont('times', '', 6);
		$this->Cell(75,5,$EmpresaProvincia." - ".$EmpresaDistrito." - ".$EmpresaDepartamento,$lineas,0,'C');
//		
//		
			$this->SetFont('times', 'B', 10);
			$this->Cell(70,5,"N°. ".$InsGuiaRemision->GrtNumero."-".$InsGuiaRemision->GreId,$lineas,1,'C');
			
			
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
		global $InsGuiaRemision;
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
//			<td style="width:150px; padding: 2px; text-align:left;"><img src="'.$RutaGuiaRemisionCodigoQR.'" border="0" align="top" alt="Nexnet" /></td>
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
//		$this->write2DBarcode($InsGuiaRemision->GrtNumero."-".$InsGuiaRemision->GreId, 'QRCODE', 0, 0, 0, 30, $style, 'N');
		
	}
}

//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $pagelayout, true, 'UTF-8', false);
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf = new TCPDF();
//$pdf->SetHeaderData('logotipo.png', PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
// set document information
$pdf->SetCreator($EmpresaNombre);
$pdf->SetAuthor($EmpresaNombre);
$pdf->SetTitle($InsGuiaRemision->GrtNumero."-".$InsGuiaRemision->GreId);
$pdf->SetSubject("GuiaRemision Electronica");
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
//	$pdf->Cell(90,5,"GUIA REMISION ELECTRONICA",$lineas,1,'C');
//
//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(100,5,$EmpresaProvincia." ".$EmpresaDistrito." ".$EmpresaDepartamento,$lineas,0,'C');
//
//
//	$pdf->SetFont('times', 'B', 12);
//	$pdf->Cell(90,5,"No. ".$InsGuiaRemision->GrtNumero."-".$InsGuiaRemision->GreId,$lineas,1,'C');
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

//$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
//$pdf->RoundedRect(10, 35, 190, 10, 2, '1111', NULL);
//
//$pdf->SetFont('times', 'B', 10);
//$pdf->Cell(40,5,"DESTINATARIO",$lineas,1);

$NombreCliente = $InsGuiaRemision->CliNombre." ".$InsGuiaRemision->CliApellidoPaterno." ".$InsGuiaRemision->CliApellidoMaterno;

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
		$pdf->Cell(25,5,"Señor(es): ",$lineas,0,"L");
		$pdf->SetFont('times', 'N', 7);
		$pdf->Cell(175,5,$afila[$j],$lineas,1,"L");

	}else{

		$pdf->SetFont('times', 'B', 8);
		$pdf->Cell(25,5,"",$lineas,0,"L");
		$pdf->SetFont('times', 'N', 7);
		$pdf->Cell(175,5,$afila[$j],$lineas,1,"L");
		
	}
	
}

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(25,5,"R.U.C.: ",$lineas,0);
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(70,5,$InsGuiaRemision->CliNumeroDocumento,$lineas,0);


$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"Fecha de Emision: ",$lineas,0);
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(20,5,$InsGuiaRemision->GreFechaEmision,$lineas,1);

/*	
$pdf->Ln(5);
$pdf->SetLeftMargin(10);	*/	
			
$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->RoundedRect(10, 30, 190, 50, 2, '1111', NULL);


//$pdf->SetFont('times', 'B', 10);
//$pdf->Cell(40,5,"UNIDAD DE TRANSPORTE Y CONDUCTOR(ES)",$lineas,1);
//	
//
//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(40,5,"Razon Social:",$lineas,0);
//$pdf->SetFont('times', 'N', 8);
//$pdf->Cell(40,5,$InsGuiaRemision->PrvNombre,$lineas,0);	
//
//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(40,5,"Chofer: ",$lineas,0);
//$pdf->SetFont('times', 'N', 8);
//$pdf->Cell(40,5,$InsGuiaRemision->GreChofer,$lineas,1);	
//
//
//
//
//	
//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(40,5,"RUC: ",$lineas,0);
//$pdf->SetFont('times', 'N', 8);
//$pdf->Cell(40,5,$InsGuiaRemision->PrvNumeroDocumento,$lineas,0);	
//
//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(40,5,"Nro. Licencia Conducir: ",$lineas,0);
//$pdf->SetFont('times', 'N', 8);
//$pdf->Cell(40,5,$InsGuiaRemision->GreNumeroLicenciaConducir,$lineas,1);	
//
//
//
//
//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(40,5,"Numero de Registro: ",$lineas,0);
//$pdf->SetFont('times', 'N', 8);
//$pdf->Cell(40,5,$InsGuiaRemision->GreNumeroRegistro,$lineas,0);	
//
//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(40,5,"Marca Unid. Transp.: ",$lineas,0);
//$pdf->SetFont('times', 'N', 8);
//$pdf->Cell(40,5,$InsGuiaRemision->GreMarca,$lineas,1);	
//
//	
//	
//	
//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(40,5,"Constancia de Inscripcion Nro.: ",$lineas,0);
//$pdf->SetFont('times', 'N', 8);
//$pdf->Cell(40,5,$InsGuiaRemision->GreNumeroConstanciaInscripcion,$lineas,0);	
//
//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(40,5,"Placa: ",$lineas,0);
//$pdf->SetFont('times', 'N', 8);
//$pdf->Cell(40,5,$InsGuiaRemision->GrePlaca,$lineas,1);	


$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(30,5,"Razon Social:",$lineas,0);
$pdf->Cell(30,5,"Emp. Transporte:",$lineas,0);
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(65,5,$InsGuiaRemision->PrvNombre,$lineas,0);	

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(30,5,"Chofer: ",$lineas,0);
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(65,5,$InsGuiaRemision->GreChofer,$lineas,1);	

	
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(30,5,"R.U.C.: ",$lineas,0);
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(65,5,$InsGuiaRemision->PrvNumeroDocumento,$lineas,0);	

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(30,5,"D.N.I.: ",$lineas,0);
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(65,5,$InsGuiaRemision->GreChoferNumeroDocumento,$lineas,1);	

	
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(30,5,"",$lineas,0);
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(65,5,"",$lineas,0);	

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(30,5,"Placa: ",$lineas,0);
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(65,5,$InsGuiaRemision->GrePlaca,$lineas,1);	





//
//$pdf->Ln(5);
//$pdf->SetLeftMargin(10);
////
//$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
//$pdf->RoundedRect(10, 50, 190, 40, 2, '1111', NULL);
//
//
//$pdf->SetFont('times', 'B', 10);
//$pdf->Cell(40,5,"UNIDAD DE TRANSPORTE Y CONDUCTOR(ES)",$lineas,1);
	
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(40,5,"Fecha de Inicio de Traslado: ",$lineas,0);
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(20,5,$InsGuiaRemision->GreFechaInicioTraslado,$lineas,1);		

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(40,5,"Punto Partida: ",$lineas,0);
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(95,5,$InsGuiaRemision->GrePuntoPartida,$lineas,0);	

$pdf->SetFont('times', 'N', 8);
$pdf->Cell(20,5,"Ubig.",$lineas,0);	
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(20,5,$InsGuiaRemision->GrePuntoPartidaCodigoUbigeo,$lineas,1);	

 
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(40,5,"Punto Llegada: ",$lineas,0);
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(95,5,$InsGuiaRemision->GrePuntoLlegada,$lineas,0);	

$pdf->SetFont('times', 'N', 8);
$pdf->Cell(20,5,"Ubig.",$lineas,0);	
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(20,5,$InsGuiaRemision->GrePuntoLlegadaCodigoUbigeo,$lineas,1);	

//$pdf->Ln(5);
//$pdf->SetLeftMargin(10);

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(40,5,"Peso Total:",$lineas,0);
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(55,5,number_format($InsGuiaRemision->GrePesoTotal,2),$lineas,0);

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(40,5,"Cant. Paquetes",$lineas,0);
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(55,5,number_format($InsGuiaRemision->GreTotalPaquetes,2),$lineas,1);



//$pdf->Ln(5);
//$pdf->SetLeftMargin(10);

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(40,5,"En la fecha estamos remitiendo a Ud. lo siguiente ",$lineas,1);

/*
* GUIA REMISION DETALLE
*/
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(10,5,"CANT.",1,0,"C");
$pdf->Cell(30,5,"UNIDAD",1,0,"C");
$pdf->Cell(100,5,"DESCRIPCION",1,0,"C");
$pdf->Cell(25,5,"PESO NETO",1,0,"C");
$pdf->Cell(25,5,"PESO BRUTO",1,1,"C");
$pdf->SetFont('times', 'N', 8);

$ArrMateriales = array();

if(!empty($InsGuiaRemision->GuiaRemisionDetalle)){
	foreach($InsGuiaRemision->GuiaRemisionDetalle as $DatGuiaRemisionDetalle){

			if(empty($InsGuiaRemision->OvvId)){
				
				$pos = strrpos($DatGuiaRemisionDetalle->GrdDescripcion, "|");
				
				if ($pos === false) { // nota: tres signos de igual
					// no encontrado...

					$ArrPalabras = explode(" ",$DatGuiaRemisionDetalle->GrdDescripcion);
					
					$afila = array();
					$fila = 1;
					
					for($i=0;$i<=count($ArrPalabras);$i++){									
						if(strlen($afila[$fila]." ".$ArrPalabras[$i])<57){											
							$afila[$fila].=" ".$ArrPalabras[$i];										
						}else{										
							$fila++;
							$afila[$fila].=" ".$ArrPalabras[$i];
						}
						
					}
					
					for($j=1;$j<=$fila;$j++){
						
						if($j==1){
						
							$pdf->Cell(10,5,$DatGuiaRemisionDetalle->GrdCantidad,$lineas,0);	
							$pdf->Cell(30,5,$DatGuiaRemisionDetalle->GrdUnidadMedida,$lineas,0);							
							$pdf->Cell(100,5,($afila[$j])."",$lineas,0);						
							$pdf->Cell(25,5,number_format($DatGuiaRemisionDetalle->GrdPesoNeto,2),$lineas,0,"R");
							$pdf->Cell(25,5,number_format($DatGuiaRemisionDetalle->GrdPesoTotal,2),$lineas,1,"R");
				
						}else{
							
							$pdf->Cell(10,5,"",$lineas,0);								
							$pdf->Cell(30,5,"",$lineas,0);
							$pdf->Cell(100,5,$afila[$j],$lineas,0);
							$pdf->Cell(25,5,"",$lineas,0,"R");
							$pdf->Cell(25,5,"",$lineas,1,"R");
							
						}
						
					}
							
				}else{
					
					$filas_adicionales = 0;
					
					unset($ArrRepuestos);		
				
					$ArrRepuestos = explode("|",$DatGuiaRemisionDetalle->GrdDescripcion);
					
					if(!empty($ArrRepuestos)){
						
						$repuestos = 1;
						foreach($ArrRepuestos as $DatRepuesto){
							
							if($repuestos == 1){
								
								$ArrPalabras = explode(" ",$DatRepuesto);
							
								$afila = array();
								$fila = 1;
								
								for($i=0;$i<=count($ArrPalabras);$i++){									
									if(strlen($afila[$fila]." ".$ArrPalabras[$i])<57){											
										$afila[$fila].=" ".$ArrPalabras[$i];										
									}else{										
										$fila++;
										$afila[$fila].=" ".$ArrPalabras[$i];
									}
									
								}
								
								for($j=1;$j<=$fila;$j++){
									
									if($j==1){
									
									$pdf->Cell(10,5,"1",$lineas,0);								
									$pdf->Cell(30,5,"",$lineas,0);
									$pdf->Cell(100,5,$afila[$j],$lineas,0);
									$pdf->Cell(25,5,number_format($DatGuiaRemisionDetalle->GrdPesoNeto,2),$lineas,0,"R");
									$pdf->Cell(25,5,number_format($DatGuiaRemisionDetalle->GrdPesoTotal,2),$lineas,1,"R");
			
									}else{
										$pdf->Cell(10,5,"",$lineas,0);								
										$pdf->Cell(30,5,"",$lineas,0);
										$pdf->Cell(100,5,$afila[$j],$lineas,0);
										$pdf->Cell(25,5,"",$lineas,0,"R");
										$pdf->Cell(25,5,"",$lineas,1,"R");
									}
									
									
								}

								
							}else{
								
								$pdf->Cell(10,5,"",$lineas,0);								
								$pdf->Cell(30,5,"",$lineas,0);
								$pdf->Cell(100,5,"- ".$DatRepuesto,$lineas,0);
								$pdf->Cell(25,5,"",$lineas,0,"R");
								$pdf->Cell(25,5,"",$lineas,1,"R");
								$filas_adicionales++;
								
							}
							
							$repuestos ++;
						}
						
					}
					
				}
				

			}else{
				
					unset($ArrPalabras);		
				
					list($Vehiculo,$Accesorios) = explode("|",$DatGuiaRemisionDetalle->GrdDescripcion);
					
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
						
							$pdf->Cell(10,5,$DatGuiaRemisionDetalle->GrdCantidad,$lineas,0);	
							$pdf->Cell(30,5,$DatGuiaRemisionDetalle->GrdUnidadMedida,$lineas,0);
							$pdf->Cell(100,5,$afila[$j],$lineas,0);
							$pdf->Cell(25,5,number_format($DatGuiaRemisionDetalle->GrdPesoNeto,2),$lineas,0,"R");
							$pdf->Cell(25,5,number_format($DatGuiaRemisionDetalle->GrdPesoTotal,2),$lineas,1,"R");
							
						}else{
							
							$pdf->Cell(10,5,"",$lineas,0);								
							$pdf->Cell(30,5,"",$lineas,0);
							$pdf->Cell(100,5,$afila[$j],$lineas,0);
							$pdf->Cell(25,5,"",$lineas,0,"R");
							$pdf->Cell(25,5,"",$lineas,1,"R");
							
						}
						
						
					}
					
					
					unset($ArrPalabras);		
				
					$ArrPalabras = explode(" ",$Accesorios);
					
					
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

						$pdf->Cell(10,5,"",$lineas,0);								
						$pdf->Cell(30,5,"",$lineas,0);
						$pdf->Cell(100,5,$afila[$j],$lineas,0);
						$pdf->Cell(25,5,"",$lineas,0,"R");
						$pdf->Cell(25,5,"",$lineas,1,"R");
						
					}


			}
		
	}
}



$TotalLineas = count($InsGuiaRemision->GuiaRemisionDetalle)+$filas_adicionales;

if($TotalLineas<15 and empty($InsGuiaRemision->OvvId)){
	
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



if(!empty($InsGuiaRemision->EinVIN)){
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"VIN: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->EinVIN,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"Placa: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->EinPlaca,$lineas,1);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(35,5,"Marca/Modelo/Version: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(70,5,$InsGuiaRemision->VmaNombre." ".$InsGuiaRemision->VmoNombre." ".$InsGuiaRemision->VveNombre,$lineas,1);


}

//$pdf->Ln(5);
//$pdf->SetLeftMargin(10);

if(!empty($InsGuiaRemision->FinId)){
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"O.T.: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(30,5,$InsGuiaRemision->FinId,$lineas,0);
	

	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"Kilom.: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(30,5,$InsGuiaRemision->FinVehiculoKilometraje." ".(!empty($InsGuiaRemision->FinVehiculoKilometraje)?'KM':''),$lineas,0);

}	


if(!empty($InsGuiaRemision->AmoId)){
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(15,5,"Ficha: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(30,5,$InsGuiaRemision->AmoId,$lineas,0);
	
	$pdf->Ln(5);
}



if(!empty($InsGuiaRemision->OvvId)){
	
	$pdf->Cell(40,5,"",$lineas,0);		
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Marca: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->GreDatoAdicional1,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Tracción: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->GreDatoAdicional2,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Modelo: ",$lineas,0);	
	 $pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->GreDatoAdicional3,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Carroceria: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->GreDatoAdicional4,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Año Fabric.: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->GreDatoAdicional5,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Puertas: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->GreDatoAdicional6,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Motor: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->GreDatoAdicional7,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Combustible: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->GreDatoAdicional8,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Cilindros: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->GreDatoAdicional9,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Peso Bruto: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->GreDatoAdicional10,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Ejes: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->GreDatoAdicional11,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Carga Util: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->GreDatoAdicional12,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Chasis: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->GreDatoAdicional13,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Peso Seco: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->GreDatoAdicional14,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Color: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->GreDatoAdicional15,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Alto: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->GreDatoAdicional16,$lineas,1);
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Cilindrada: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->GreDatoAdicional17,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Largo: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->GreDatoAdicional18,$lineas,1);
	


	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Asientos: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->GreDatoAdicional19,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Ancho: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->GreDatoAdicional20,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Cap. Pasajeros: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->GreDatoAdicional21,$lineas,0);
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"Dist. Ejes: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->GreDatoAdicional22,$lineas,1);
	
	
	$pdf->Cell(40,5,"",$lineas,0);	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(20,5,"No. Poliza: ",$lineas,0);	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(45,5,$InsGuiaRemision->GreDatoAdicional23,$lineas,0);
	
	for($i=1;$i<=2;$i++){
			
		$pdf->Cell(10,5,"",$lineas,0,"C");
		$pdf->Cell(30,5,"",$lineas,0,"C");
		$pdf->Cell(100,5,"",$lineas,0,"C");
		$pdf->Cell(25,5,"",$lineas,0,"C");
		$pdf->Cell(25,5,"",$lineas,1,"C");
		
	}
	
}



//
//$pdf->SetLeftMargin(10);
//
//$pdf->Cell(190,5,"(*) Productos en oferta con precio especial disponibles hasta agotar stock",1,0);

	

if(!empty($InsGuiaRemision->GreObservacionImpresa)){

	$pdf->Ln(5);	
	$pdf->SetLeftMargin(10);	
	
	//$pdf->Cell(110,5,$InsGuiaRemision->GreObservacionImpresa,$lineas,1);

	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(25,5,"Obs.: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(110,5,$InsGuiaRemision->GreObservacionImpresa,$lineas,1);
		
}

if($InsGuiaRemision->GreObsequio==1){
	
	$pdf->SetAlpha(0.3);
	//Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false, $alt=false, $altimgs=array()) {
	$pdf->Image('../../imagenes/transferencia_gratuita.png', 65, 60, 80, 70, 'PNG', '', '', true, 150, '', false, false, 0, true, false, false);
//$mask = $pdf->Image('../../imagenes/transferencia_gratuita.png', 50, 140, 100, '', '', '', '', false, 300, '', true);
	$pdf->SetAlpha(1);

	
}

if(!empty($InsGuiaRemision->GreComprobantePagoNumero)){

	$pdf->Ln(5);
	
	$pdf->SetLeftMargin(10);	
	
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(25,5,"Doc. Ref.: ",$lineas,0);
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(110,5,$InsGuiaRemision->GreComprobantePagoNumero,$lineas,1);
	
	
}


$pdf->SetFont('times', 'B', 8);
$pdf->Cell(55,5,"[a] Venta",$lineas,0);	

if( $InsGuiaRemision->GreMotivoTraslado==1){
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[X]",$lineas,0);
}else{
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[ ]",$lineas,0);
}
	
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(55,5,"[f ]Entre establecimientos de la misma Emp.",$lineas,0);	

if( $InsGuiaRemision->GreMotivoTraslado==6){
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[X]",$lineas,0);
}else{
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[ ]",$lineas,0);
}		

		
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(55,5,"[k] Importación",$lineas,0);	

if( $InsGuiaRemision->GreMotivoTraslado==11){
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[X]",$lineas,1);
}else{
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[ ]",$lineas,1);
}	

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(55,5,"[b] Venta sujeto a confirmar",$lineas,0);	

if( $InsGuiaRemision->GreMotivoTraslado==2){
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[X]",$lineas,0);
}else{
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[ ]",$lineas,0);
}
	
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(55,5,"[g] Para Transformación",$lineas,0);	

if( $InsGuiaRemision->GreMotivoTraslado==7){
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[X]",$lineas,0);
}else{
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[ ]",$lineas,0);
}
		
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(55,5,"[l] Exportación",$lineas,0);	

if( $InsGuiaRemision->GreMotivoTraslado==12){
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[X]",$lineas,11);
}else{
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[ ]",$lineas,1);
}	

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(55,5,"[c] Compra",$lineas,0);	

if( $InsGuiaRemision->GreMotivoTraslado==3){
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[X]",$lineas,0);
}else{
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[ ]",$lineas,0);
}
	
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(55,5,"[h] Recojo de Bienes transformados",$lineas,0);	

if( $InsGuiaRemision->GreMotivoTraslado==7){
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[X]",$lineas,0);
}else{
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[ ]",$lineas,0);
}
	
		
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(55,5,"[m] Venta con Entrega a Terceros",$lineas,0);	

if( $InsGuiaRemision->GreMotivoTraslado==13){
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[X]",$lineas,1);
}else{
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[ ]",$lineas,1);
}	


$pdf->SetFont('times', 'B', 8);
$pdf->Cell(55,5,"[d] Consignacion",$lineas,0);	

if( $InsGuiaRemision->GreMotivoTraslado==4){
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[X]",$lineas,0);
}else{
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[ ]",$lineas,0);
}
	
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(55,5,"[i] Emisor Itinerante",$lineas,0);
	
if( $InsGuiaRemision->GreMotivoTraslado==8){
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[X]",$lineas,0);
}else{
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[ ]",$lineas,0);
}	
		
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(55,5,"[n] Otros",$lineas,0);	

if( $InsGuiaRemision->GreMotivoTraslado==14){
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[X]",$lineas,1);
}else{
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[ ]",$lineas,1);
}		


$pdf->SetFont('times', 'B', 8);
$pdf->Cell(55,5,"[e] Devolución",$lineas,0);

if( $InsGuiaRemision->GreMotivoTraslado==5){
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[X]",$lineas,0);
}else{
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[ ]",$lineas,0);
}
	
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(55,5,"[j] Zona Primaria",$lineas,0);	

if( $InsGuiaRemision->GreMotivoTraslado==10){
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[X]",$lineas,0);
}else{
	$pdf->SetFont('times', 'N', 8);
	$pdf->Cell(7,5,"[ ]",$lineas,0);
}		
		
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(60,5,"",$lineas,0);	
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(5,5,$InsGuiaRemision->GreMotivoTrasladoOtro,$lineas,1);	



$pdf->SetAlpha(0.4);
$pdf->Image('../../imagenes/comprobantes/comprobante_fondo.png', 76, 100, 70, 60, 'PNG', '', '', true, 150, '', false, false, 0, true, false, false);
$pdf->SetAlpha(1);




//$pdf->Ln(5);
//$pdf->SetLeftMargin(10);
//$pdf->SetFont('times', 'B', 8);
//
//$Total = round($InsGuiaRemision->GreTotal,2);
//list($parte_entero,$parte_decimal) = explode(".",$Total);
//
//if(empty($parte_decimal)){
//	$parte_decimal = 0;
//}
//
//$parte_decimal = str_pad($parte_decimal, 2, "0", STR_PAD_RIGHT);
//
//
//$numalet= new CNumeroaletra;
//$numalet->setNumero($parte_entero);
//$numalet->setMayusculas(1);
//$numalet->setGenero(1);
//$numalet->setMoneda("");
//$numalet->setPrefijo("");
//$numalet->setSufijo("");
//
//$pdf->Cell(190,5,"SON: ".$numalet->letra()." CON ".$parte_decimal."/100"." ".$InsGuiaRemision->MonNombre,1,1,'L');
//
//





$pdf->Ln(5);
$pdf->SetLeftMargin(10);
$pdf->Image('../../imagenes/comprobante_pie.png', 10, '', 90, 28, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);



/*
GENERAR CODIGO QR
*/
$ArchivoGreetaCodigoQR = $InsGuiaRemision->GrtNumero."-".$InsGuiaRemision->GreId.'_QR.png'; 
$RutaGreetaCodigoQR = "../../generados/comprobantes/".$ArchivoGreetaCodigoQR; 
// generating 

if (file_exists($RutaGreetaCodigoQR)) { 
	unlink($RutaGreetaCodigoQR); 
}


// QRcode::png($InsGuiaRemision->GrtNumero."-".$InsGuiaRemision->GreId, $RutaGreetaCodigoQR); 
$CodigoQR = $EmpresaCodigo.'|9|'.$InsGuiaRemision->GrtNumero.'|'.$InsGuiaRemision->GreId.'|'.FncCambiaFechaAMysql($InsGuiaRemision->GreFechaEmision).'|1|'.$InsGuiaRemision->CliNumeroDocumento.'|'.$InsGuiaRemision->GreSunatRespuestaEnvioDigestValue.'|'.$InsGuiaRemision->GreSunatRespuestaEnvioSignatureValue;

$barcodeobj = new TCPDF2DBarcode($CodigoQR, 'PDF417');
$data = $barcodeobj->getBarcodePngData(10,5,array(0,0,0));
$im = imagecreatefromstring($data);
$resp = imagepng($im, $RutaGreetaCodigoQR);
imagedestroy($im);


$pdf->Image($RutaGreetaCodigoQR, 120, '', 75, 25, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);




$pdf->Ln(25);
$pdf->SetLeftMargin(10);

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(125,3,"",$lineas,0,'C',0,0);
$pdf->Cell(50,3,"Timbre Electronico",$lineas,1,'C',0,0);

$pdf->SetFont('times', '', 6);
$pdf->Cell(125,3,"",$lineas,0,'C',0,0);
$pdf->Cell(50,3,"Representación impresa de la GuiaRemision Electrónica",$lineas,1,'C',0,0);

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
//		$pdf->writeHTMLCell(0, 0, 0, 0, 'Lorem ipsum... <img src="'.$RutaGuiaRemisionCodigoQR.'" /> Curabitur at porta dui...');

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

//$pdf->write2DBarcode($InsGuiaRemision->GrtNumero."-".$InsGuiaRemision->GreId, 'QRCODE', 80, 90, 0, 30, $style, 'N');
//$pdf->write2DBarcode($InsGuiaRemision->GrtNumero."-".$InsGuiaRemision->GreId, 'QRCODE',10,150,30,30,$style);
//$pdf->Text(10, 150, $InsGuiaRemision->GrtNumero."-".$InsGuiaRemision->GreId);

//
//$pdf->SetY(700);
//

//$pdf->Ln(30);
//$pdf->SetLeftMargin(10);
//			
//			
	
$pdf->Output('../../generados/comprobantes_pdf/'.$NOMBRE.'.pdf', 'F');

$pdf->Output($NOMBRE.".pdf");

?>