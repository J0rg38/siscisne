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
		
		$image_file = '../../imagenes/comprobantes/comprobante_logotipo.png';
		$this->Image($image_file, 10, 10, 115, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		
		$this->SetFont('times', 'B', 12);
		$this->Cell(8,5,"",$lineas,0,'C',0);
		
		$this->SetFont('times', 'B', 10);
		$this->Cell(70,5,"R.U.C.: ".$EmpresaCodigo,$lineas,1,'C',0);

		$this->SetFont('times', '', 10);
		$this->Cell(45,5,'',$lineas,0,'C',0);
		
		$this->SetFont('times', '', 6);
		$this->Cell(85,5,"",$lineas,0,'C',0);

		$this->SetFont('times', 'B', 10);
		$this->Cell(70,5,"GUIA REMISION ELECTRONICA",$lineas,1,'C');

		$this->SetFont('times', '', 10);
		$this->Cell(45,5,'',$lineas,0,'C',0);
		$this->SetFont('times', '', 6);
		$this->Cell(85,5,"",$lineas,0,'C');
//		
//		
			$this->SetFont('times', 'B', 10);
			$this->Cell(70,5,"N°. ".$InsGuiaRemision->GrtNumero."-".$InsGuiaRemision->GreId,$lineas,1,'C');
			
			
		$this->SetFont('times', '', 10);
		$this->Cell(45,5,'',$lineas,0,'C',0);
		$this->SetFont('times', '', 6);
		$this->Cell(75,5,"",$lineas,0,'C');
		
		
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
$pdf->SetSubject("Guia Remision Electronica");
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

//$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
//$pdf->RoundedRect(10, 60, 190, 50, 2, '1111', NULL);


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

$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->RoundedRect(135, 7, 62, 25, 0, '1111', NULL);




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
		$pdf->Cell(5,5,"",$lineas,0,"R");
		$pdf->Cell(35,5,"DESTINATARIO: ",$lineas,0,"R");
		$pdf->SetFont('times', 'N', 8);
		$pdf->Cell(150,5,$afila[$j],$lineas,1,"L");

	}else{

		$pdf->SetFont('times', 'B', 8);
		$pdf->Cell(5,5,"",$lineas,0,"R");
		$pdf->Cell(35,5,"",$lineas,0,"R");
		$pdf->SetFont('times', 'N', 8);
		$pdf->Cell(150,5,$afila[$j],$lineas,1,"L");
		
	}
	
}

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(5,5,"",$lineas,0,"R");
$pdf->Cell(35,5,"DOC. IDENT.: ",$lineas,0,"R");
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(150,5,$InsGuiaRemision->TdoNombre."/".$InsGuiaRemision->CliNumeroDocumento,$lineas,1);


//$pdf->SetFont('times', 'N', 8);
//$pdf->Cell(190,5,'',$lineas,1);
//
//

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(5,5,"",$lineas,0,"R");
$pdf->Cell(35,5,"TERCERO: ",$lineas,0,"R");
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(150,5,$InsGuiaRemision->GreDestinatarioNombre,$lineas,1);

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(5,5,"",$lineas,0,"R");
$pdf->Cell(35,5,"DOC. IDENT.: ",$lineas,0,"R");
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(150,5,$InsGuiaRemision->GreDestinatarioNumeroDocumento1,$lineas,1);


$pdf->SetFont('times', 'N', 8);
$pdf->Cell(190,5,'',$lineas,1);






$pdf->SetFont('times', 'B', 8);
$pdf->Cell(5,5,"",$lineas,0,"R");
$pdf->Cell(35,5,"PUNTO PARTIDA: ",$lineas,0,"R");
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(105,5,$InsGuiaRemision->GrePuntoPartida,$lineas,1);	

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(5,5,"",$lineas,0,"R");
$pdf->Cell(35,5,"COD UBIGEO.",$lineas,0,"R");	
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(20,5,$InsGuiaRemision->GrePuntoPartidaCodigoUbigeo,$lineas,1);	

 
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(5,5,"",$lineas,0,"R");
$pdf->Cell(35,5,"PUNTO LLEGADA: ",$lineas,0,"R");
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(105,5,$InsGuiaRemision->GrePuntoLlegada,$lineas,1);	

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(5,5,"",$lineas,0,"R");
$pdf->Cell(35,5,"COD. UBIGEO",$lineas,0,"R");	
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(20,5,$InsGuiaRemision->GrePuntoLlegadaCodigoUbigeo,$lineas,1);	

$pdf->SetFont('times', 'N', 8);
$pdf->Cell(190,5,'',$lineas,1);


$pdf->SetFont('times', 'B', 8);
$pdf->Cell(5,5,"",$lineas,0,"R");
$pdf->Cell(35,5,"PESO TOTAL:",$lineas,0,"R");
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(55,5,number_format($InsGuiaRemision->GrePesoTotal,2),$lineas,0);

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(5,5,"",$lineas,0,"R");
$pdf->Cell(35,5,"CANT. PAQUETES:",$lineas,0,"R");
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(55,5,number_format($InsGuiaRemision->GreTotalPaquetes,2),$lineas,1);

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(5,5,"",$lineas,0,"R");
$pdf->Cell(35,5,"MOTIVO TRASLADO:",$lineas,0,"R");
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(185,5,$InsGuiaRemision->GreMotivoTrasladoCodigo." - ".$InsGuiaRemision->ScaNombre,$lineas,1);

$pdf->SetFont('times', 'N', 8);
$pdf->Cell(190,5,'',$lineas,1);


$pdf->SetFont('times', 'B', 8);
$pdf->Cell(5,5,"",$lineas,0,"R");
$pdf->Cell(35,5,"EMP. TRANSPORTE:",$lineas,0,"R");
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(55,5,($InsGuiaRemision->PrvNombre." ".$InsGuiaRemision->PrvApellidoPaterno." ".$InsGuiaRemision->PrvApellidoMaterno),$lineas,0);

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"DOC. IDENT:",$lineas,0,"R");
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(55,5,($InsGuiaRemision->TdoNombreProveedor."/".$InsGuiaRemision->PrvNumeroDocumento),$lineas,1);


$pdf->SetFont('times', 'B', 8);
$pdf->Cell(5,5,"",$lineas,0,"R");
$pdf->Cell(35,5,"CHOFER:",$lineas,0,"R");
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(55,5,($InsGuiaRemision->GreChofer),$lineas,0);
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(35,5,"D.N.I.:",$lineas,0,"R");
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(55,5,($InsGuiaRemision->GreChoferNumeroDocumento),$lineas,1);


$pdf->SetFont('times', 'B', 8);
$pdf->Cell(5,5,"",$lineas,0,"R");
$pdf->Cell(35,5,"PLACA:",$lineas,0,"R");
$pdf->SetFont('times', 'N', 8);
$pdf->Cell(55,5,($InsGuiaRemision->GrePlaca),$lineas,1);



$pdf->SetFont('times', 'B', 8);
$pdf->Cell(5,5,"",$lineas,0,"C");
$pdf->Cell(35,5,"FECHA EMISION",1,0,"C");
$pdf->Cell(35,5,"FECHA TRASLADO",1,0,"C");
$pdf->Cell(35,5,"VENDEDOR",1,0,"C");
$pdf->Cell(35,5,"N° PEDIDO",1,0,"C");
$pdf->Cell(35,5,"USUARIO",1,1,"C");

$pdf->SetFont('times', 'N', 8);
$pdf->Cell(5,5,"",$lineas,0,"C");
$pdf->Cell(35,5,(!empty($GET_Fecha)?$GET_Fecha:$InsGuiaRemision->GreFechaEmision),1,0,"C");
$pdf->Cell(35,5,(!empty($GET_Fecha)?$GET_Fecha:$InsGuiaRemision->GreFechaInicioTraslado),1,0,"C");
$pdf->Cell(35,5,$InsGuiaRemision->GreVendedor,1,0,"C");
$pdf->Cell(35,5,$InsGuiaRemision->GreNumeroPedido,1,0,"C");
$pdf->Cell(35,5,$InsGuiaRemision->UsuUsuario,1,1,"C");





$pdf->Ln(5);
$pdf->SetLeftMargin(10);






//
//$NombreCliente = $InsGuiaRemision->CliNombre." ".$InsGuiaRemision->CliApellidoPaterno." ".$InsGuiaRemision->CliApellidoMaterno;
//
//$ArrPalabras = explode(" ",$NombreCliente);
//
//$afila = array();
//$fila = 1;
//
//for($i=0;$i<=count($ArrPalabras);$i++){			
//						
//	if(strlen($afila[$fila]." ".$ArrPalabras[$i])<120){											
//		$afila[$fila].=" ".$ArrPalabras[$i];										
//	}else{										
//		$fila++;
//		$afila[$fila].=" ".$ArrPalabras[$i];
//	}
//	
//}
//
//for($j=1;$j<=$fila;$j++){
//	
//	if($j==1){
//	
//		$pdf->SetFont('times', 'B', 8);
//		$pdf->Cell(25,5,"Señor(es): ",$lineas,0,"L");
//		$pdf->SetFont('times', 'N', 7);
//		$pdf->Cell(175,5,$afila[$j],$lineas,1,"L");
//
//	}else{
//
//		$pdf->SetFont('times', 'B', 8);
//		$pdf->Cell(25,5,"",$lineas,0,"L");
//		$pdf->SetFont('times', 'N', 7);
//		$pdf->Cell(175,5,$afila[$j],$lineas,1,"L");
//		
//	}
//	
//}
//
//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(25,5,"R.U.C.: ",$lineas,0);
//$pdf->SetFont('times', 'N', 8);
//$pdf->Cell(70,5,$InsGuiaRemision->CliNumeroDocumento,$lineas,0);






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
	
//$pdf->Ln(5);
//$pdf->SetLeftMargin(10);



//$pdf->Ln(5);
//$pdf->SetLeftMargin(10);
//
//$pdf->SetFont('times', 'B', 8);
//$pdf->Cell(40,5,"Datos de los bienes",$lineas,1);

/*
* GUIA REMISION DETALLE
*/
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(10,5,"CANT.",1,0,"C");
$pdf->Cell(20,5,"UNIDAD",1,0,"C");
$pdf->Cell(30,5,"CODIGO",1,0,"C");
$pdf->Cell(130,5,"DESCRIPCION",1,1,"C");
//$pdf->Cell(25,5,"PESO NETO",1,0,"C");
//$pdf->Cell(25,5,"PESO BRUTO",1,1,"C");
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
							$pdf->Cell(20,5,$DatGuiaRemisionDetalle->GrdUnidadMedida,$lineas,0);
							$pdf->Cell(30,5,$DatGuiaRemisionDetalle->GrdCodigo,$lineas,0);							
							$pdf->Cell(130,5,($afila[$j])."",$lineas,1);						
							//$pdf->Cell(25,5,number_format($DatGuiaRemisionDetalle->GrdPesoNeto,2),$lineas,0,"R");
							//$pdf->Cell(25,5,number_format($DatGuiaRemisionDetalle->GrdPesoTotal,2),$lineas,1,"R");
				
						}else{
							
							$pdf->Cell(10,5,"",$lineas,0);								
							$pdf->Cell(20,5,"",$lineas,0);
							$pdf->Cell(30,5,"",$lineas,0);	
							$pdf->Cell(130,5,$afila[$j],$lineas,1);
							//$pdf->Cell(25,5,"",$lineas,0,"R");
							//$pdf->Cell(25,5,"",$lineas,1,"R");
							
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
									$pdf->Cell(20,5,"",$lineas,0);
									$pdf->Cell(30,5,"",$lineas,0);	
									$pdf->Cell(130,5,$afila[$j],$lineas,1);
									//$pdf->Cell(25,5,number_format($DatGuiaRemisionDetalle->GrdPesoNeto,2),$lineas,0,"R");
									//$pdf->Cell(25,5,number_format($DatGuiaRemisionDetalle->GrdPesoTotal,2),$lineas,1,"R");
			
									}else{
										$pdf->Cell(10,5,"",$lineas,0);								
										$pdf->Cell(20,5,"",$lineas,0);
										$pdf->Cell(30,5,"",$lineas,0);	
										$pdf->Cell(130,5,$afila[$j],$lineas,1);
										//$pdf->Cell(25,5,"",$lineas,0,"R");
										//$pdf->Cell(25,5,"",$lineas,1,"R");
									}
									
									
								}

								
							}else{
								
								$pdf->Cell(10,5,"",$lineas,0);								
								$pdf->Cell(20,5,"",$lineas,0);
								$pdf->Cell(30,5,"",$lineas,0);	
								$pdf->Cell(130,5,"- ".$DatRepuesto,$lineas,1);
								//$pdf->Cell(25,5,"",$lineas,0,"R");
								//$pdf->Cell(25,5,"",$lineas,1,"R");
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
							$pdf->Cell(20,5,$DatGuiaRemisionDetalle->GrdUnidadMedida,$lineas,0);
							$pdf->Cell(30,5,$DatGuiaRemisionDetalle->GrdCodigo,$lineas,1);	
							$pdf->Cell(130,5,$afila[$j],$lineas,0);
							//$pdf->Cell(25,5,number_format($DatGuiaRemisionDetalle->GrdPesoNeto,2),$lineas,0,"R");
							//$pdf->Cell(25,5,number_format($DatGuiaRemisionDetalle->GrdPesoTotal,2),$lineas,1,"R");
							
						}else{
							
							$pdf->Cell(10,5,"",$lineas,0);								
							$pdf->Cell(20,5,"",$lineas,0);
							$pdf->Cell(30,5,"",$lineas,0);
							$pdf->Cell(130,5,$afila[$j],$lineas,1);
							//$pdf->Cell(25,5,"",$lineas,0,"R");
							//$pdf->Cell(25,5,"",$lineas,1,"R");
							
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
						$pdf->Cell(20,5,"",$lineas,0);
						$pdf->Cell(30,5,"",$lineas,0);
						$pdf->Cell(130,5,$afila[$j],$lineas,1);
						//$pdf->Cell(25,5,"",$lineas,0,"R");
						//$pdf->Cell(25,5,"",$lineas,1,"R");
						
					}


			}
		
	}
}



$TotalLineas = count($InsGuiaRemision->GuiaRemisionDetalle)+$filas_adicionales;

if($TotalLineas<15 and empty($InsGuiaRemision->OvvId)){
	
	$TotalLineasFaltantes = 15 - $TotalLineas;
	
	for($i=1;$i<=$TotalLineasFaltantes;$i++){
			
		$pdf->Cell(10,5,"",$lineas,0);								
		$pdf->Cell(20,5,"",$lineas,0);
		$pdf->Cell(30,5,"",$lineas,0);
		$pdf->Cell(130,5,"",$lineas,1,"C");
		//$pdf->Cell(25,5,"",$lineas,0,"C");
		//$pdf->Cell(25,5,"",$lineas,1,"C");
		
	}

}else{
	

}


//if(!empty($InsGuiaRemision->GreObservacionImpresa)){

	$pdf->Ln(5);	
	$pdf->SetLeftMargin(10);	
	
	$pdf->SetFont('times', 'B', 8);
	$pdf->Cell(190,5,"OBSERVACIONES",$lineas,0,'L');
	
	$pdf->SetFont('times', '', 8);
	
	$pdf->Ln(5);
	$pdf->SetLeftMargin(10);	
	
	$pdf->Cell(190,5,$InsGuiaRemision->GreObservacionImpresa,$lineas,1);
		
		
	

$pdf->SetAlpha(0.4);
$pdf->Image('../../imagenes/comprobantes/comprobante_fondo.png', 76, 150, 70, 60, 'PNG', '', '', true, 150, '', false, false, 0, true, false, false);
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







/*
GENERAR CODIGO QR
*/

$ArchivoFacturaCodigoQR = $InsFactura->GrtNumero."-".$InsFactura->GreId.'_QR.png'; 
$RutaFacturaCodigoQR = "../../generados/comprobantes/".$ArchivoFacturaCodigoQR; 
// generating 

if (file_exists($RutaFacturaCodigoQR)) { 
	unlink($RutaFacturaCodigoQR); 
}

// QRcode::png($InsFactura->FtaNumero."-".$InsFactura->FacId, $RutaFacturaCodigoQR); 
$CodigoQR = $EmpresaCodigo.'|9|'.$InsGuiaRemision->GrtNumero.'|'.$InsGuiaRemision->GreId.'|'.FncCambiaFechaAMysql($InsGuiaRemision->GreFechaEmision).'|1|'.$InsGuiaRemision->CliNumeroDocumento.'|'.$InsGuiaRemision->GreSunatRespuestaEnvioDigestValue.'|'.$InsGuiaRemision->GreSunatRespuestaEnvioSignatureValue;

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
//$pdf->Cell(190,3,"Esta es una representación impresa de la Factura electrónica, Puede verificarlo utilizando su clave SOL en www.sunat.gob.pe o en",0,1,'C',0,0);
//$pdf->Cell(190,3,"http://app.facturaonline.pe/invitado",0,1,'C',0,0);
$pdf->Cell(190,3,"Esta es una representación impresa de la Factura electrónica, Puede verificarlo utilizando su clave SOL en www.sunat.gob.pe",0,1,'C',0,0);




	
$pdf->Output('../../generados/comprobantes_pdf/'.$NOMBRE.'.pdf', 'F');

$pdf->Output($NOMBRE.".pdf");

?>