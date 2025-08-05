<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta  = '../../../';

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


require_once($InsProyecto->MtdRutLibrerias().'fpdf17/fpdf.php');


$GET_id = $_GET['Id'];
$GET_ImprimirCodigo = $_GET['ImprimirCodigo'];
$GET_ImprimirPrecio = $_GET['ImprimirPrecio'];
$GET_GuiaSalida = $_GET['GuiaSalida'];


require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaTarea.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaFoto.php');


$InsVentaDirecta = new ClsVentaDirecta();

$InsVentaDirecta->VdiId = $GET_id;
$InsVentaDirecta->MtdObtenerVentaDirecta();


class PDF extends FPDF
{
	// Cabecera de página
	function Header(){
		// Logo
		$this->Image('../../../imagenes/cabecera_cyc.png',10,8,190);
		// Courier bold 15
		$this->SetFont('Courier','B',8);
		
		$this->Ln(15);
		$this->Cell(0,5,date("d/m/Y").' '.date("H:i:s").' '.date("a").' '.$_SESSION['SesionUsuario'],0,0,'R');
		
		
		// Movernos a la derecha
		//$this->Cell(80);
		// Título
		//$this->Cell(30,10,'Title',1,0,'C');
		// Salto de línea
		$this->Ln(20);
	}
	
	// Pie de página
	function Footer(){
		// Posición: a 1,5 cm del final
		$this->SetY(-25);
		// Courier italic 8
		$this->SetFont('Courier','I',8);
		// Movernos a la derecha
		//$this->Cell(80);
		// Número de página		
		//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		
		// Título
		$this->Ln(5);
		$this->Cell(0,5,'Urb. Los Cedros Mz. B Lte. 10 Av. Manuel A. Odria Via Panamericana Sur (Costado Grifo Municipal)',0,0,'C');
		$this->Ln(5);
		$this->Cell(0,5,'Telefono 51-52 315216 Anexo 210 Fono Fax: 851-52 315207 E-mail: canepa@cyc.com.pe',0,0,'C');
		$this->Ln(5);
		$this->Cell(0,5,'Inscritos en los Registros Publicos de Tacna Ficha 2986',0,0,'C');

		// Salto de línea
		$this->Ln(20);		
		
		
		
		
	}
	
	
}

$Borde = 0;

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();



$pdf->SetFont('Courier','B',12);
$pdf->Cell(0,0,(($GET_GuiaSalida=="1")?'GUIA DE SALIDA':'ORDEN DE VENTA'),$Borde,0,'C');
$pdf->Ln(4);
$pdf->SetFont('Courier','B',14);
$pdf->Cell(0,0,$InsVentaDirecta->VdiId,$Borde,0,'C');

$pdf->Ln(5);

$pdf->Cell(21,5,'REF.:',$Borde,0,'L');
$pdf->Cell(100,5,$InsVentaDirecta->VdiOrdenCompraNumero,$Borde,0,'L');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(21,5,'FECHA:',$Borde,0,'L');
$pdf->SetFont('Courier','',10);
$pdf->Cell(48,5,$InsVentaDirecta->VdiFecha,$Borde,0,'L');

$pdf->Ln(5);

$pdf->SetFont('Courier','B',8);
$pdf->Cell(21,5,'CLIENTE:',$Borde,0,'L');
$pdf->SetFont('Courier','',10);
$pdf->Cell(100,5,utf8_decode($InsVentaDirecta->CliNombre).' '.utf8_decode($InsVentaDirecta->CliApellidoPaterno).' '.utf8_decode($InsVentaDirecta->CliApellidoMaterno),$Borde,0,'L');

  
      
$pdf->SetFont('Courier','B',8);
$pdf->Cell(21,5,'NUM. DOC.:',$Borde,0,'L');
$pdf->SetFont('Courier','',10);
$pdf->Cell(48,5,$InsVentaDirecta->TdoNombre.'/'.$InsVentaDirecta->CliNumeroDocumento,$Borde,0,'L');

$pdf->Ln(5);

$pdf->SetFont('Courier','B',8);
$pdf->Cell(21,5,'CELULAR:',$Borde,0,'L');
$pdf->SetFont('Courier','',10);
$pdf->Cell(100,5,$InsVentaDirecta->VdiCelular,$Borde,0,'L');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(21,5,'TELEFONO:',$Borde,0,'L');
$pdf->SetFont('Courier','',10);
$pdf->Cell(48,5,$InsVentaDirecta->VdiTelefono,$Borde,0,'L');



$pdf->Ln(5);

$pdf->SetFont('Courier','B',8);
$pdf->Cell(21,5,'DIRECCION:',$Borde,0,'L');
$pdf->SetFont('Courier','',10);
$pdf->Cell(100,5,$InsVentaDirecta->VdiDireccion,$Borde,0,'L');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(21,5,'EMAIL:',$Borde,0,'L');
$pdf->SetFont('Courier','',10);
$pdf->Cell(48,5,$InsVentaDirecta->VdiEmail,$Borde,0,'L');







$pdf->Ln(5);
$pdf->SetFont('Courier','B',8);
$pdf->Cell(21,5,'MARCA:',$Borde,0,'L');
$pdf->SetFont('Courier','',10);
$pdf->Cell(100,5,$InsVentaDirecta->VdiMarca,$Borde,0,'L');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(21,5,'MODELO:',$Borde,0,'L');
$pdf->SetFont('Courier','',10);
$pdf->Cell(48,5,$InsVentaDirecta->VdiModelo,$Borde,0,'L');

$pdf->Ln(5);

$pdf->SetFont('Courier','B',8);
$pdf->Cell(21,5,'PLACA:',$Borde,0,'L');
$pdf->SetFont('Courier','',10);
$pdf->Cell(100,5,$InsVentaDirecta->VdiPlaca,$Borde,0,'L');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(21,5,'VIN:',$Borde,0,'L');
$pdf->SetFont('Courier','',10);
$pdf->Cell(48,5,$InsVentaDirecta->EinVIN,$Borde,0,'L');






////SECCION REPUESTOS
$pdf->Ln(7);

$pdf->SetFont('Courier','B',8);
$pdf->Cell(100,5,'REPUESTOS',$Borde,0,'L');

//DETALLE CABECERA REPUESTOS
$pdf->Ln(7);

$pdf->SetFont('Courier','B',8);
$pdf->Cell(5,5,'#',1,0,'C');

if($GET_ImprimirCodigo==1){
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(30,5,'Cod. Original',1,0,'C');
}else{
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(30,5,'',1,0,'C');
}
$pdf->SetFont('Courier','B',8);
$pdf->Cell(17,5,'Cantidad',1,0,'C');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(100,5,'Nombre',1,0,'C');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(15,5,'Precio',1,0,'C');	

$pdf->SetFont('Courier','B',8);
$pdf->Cell(15,5,'Importe',1,0,'C');		
		
//DETALLE REPUESTOS
$pdf->SetFont('Courier','',8);		

$TotalRepuesto = 0;


	$i=1;
	if(!empty($InsVentaDirecta->VentaDirectaDetalle)){
		foreach($InsVentaDirecta->VentaDirectaDetalle as $DatVentaDirectaDetalle){
	
			if($DatVentaDirectaDetalle->VddEstado == 1){
				
					
				
				
					if($InsVentaDirecta->MonId<>$EmpresaMonedaId){
					
						$DatVentaDirectaDetalle->VddImporte = round($DatVentaDirectaDetalle->VddImporte / $InsVentaDirecta->VdiTipoCambio,2);
						$DatVentaDirectaDetalle->VddPrecioVenta = round($DatVentaDirectaDetalle->VddPrecioVenta  / $InsVentaDirecta->VdiTipoCambio,2);
					
					}
		
				
				$pdf->Ln(5);
				
				$pdf->Cell(5,5,$i,$Borde,0,'C');
				
			
				if($GET_ImprimirCodigo==1){
					 $pdf->Cell(30,5,$DatVentaDirectaDetalle->ProCodigoOriginal,$Borde,0,'R');
				}else{
					 $pdf->Cell(30,5,'',$Borde,0,'R');
				}
				
				$pdf->Cell(17,5,round($DatVentaDirectaDetalle->VddCantidad,2),$Borde,0,'C');
				$pdf->Cell(100,5,utf8_decode($DatVentaDirectaDetalle->ProNombre),$Borde,0,'L');
				
				
	
	if($GET_ImprimirPrecio==1){
		$pdf->Cell(15,5,number_format($DatVentaDirectaDetalle->VddPrecioVenta,2),$Borde,0,'R');
	}else{
		$pdf->Cell(15,5,'-',$Borde,0,'R');
	}
	
	
	if($GET_ImprimirPrecio==1){
		$pdf->Cell(15,5,number_format($DatVentaDirectaDetalle->VddImporte,2),$Borde,0,'R');
	}else{
		$pdf->Cell(15,5,'-',$Borde,0,'R');	
	}
	
	
				
				
				
				$TotalRepuesto += $DatVentaDirectaDetalle->VddImporte;
				$i++;
				
				
				}
		
			}
	}










//$Total = $TotalRepuesto - $InsVentaDirecta->VdiDescuento;

//if($InsVentaDirecta->VdiIncluyeImpuesto == 1){
//	
//	$Total = $TotalRepuesto + $TotalPlanchado + $TotalPintado + $TotalCentrado + $TotalTarea + $InsVentaDirecta->VdiManoObra;
//	$SubTotal = $Total / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
//	$Impuesto = $Total - $SubTotal;	
//	
//}else{
//	
//	$SubTotal = $TotalRepuesto + $TotalPlanchado + $TotalPintado + $TotalCentrado + $TotalTarea + $InsVentaDirecta->VdiManoObra;
//	$Impuesto = $SubTotal * (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100));
//	$Total = $SubTotal + $Impuesto;	
//	
//}


	if($InsVentaDirecta->VdiIncluyeImpuesto == 1){
		
		$Total = $TotalRepuesto + $TotalPlanchado + $TotalPintado + $TotalCentrado + $TotalTarea + $InsVentaDirecta->VdiManoObra;
		$SubTotal = $Total / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
		$Impuesto = $Total - $SubTotal;	
		
	}else{
		
		$SubTotal = $TotalRepuesto + $TotalPlanchado + $TotalPintado + $TotalCentrado + $TotalTarea + $InsVentaDirecta->VdiManoObra;
		$Impuesto = $SubTotal * (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100));
		$Total = $SubTotal + $Impuesto;	
		
	}
	
	


//TOTALES
$pdf->Ln(7);

if($GET_ImprimirPrecio == 1){
	
	if(!empty($InsVentaDirecta->VdiDescuento) and $InsVentaDirecta->VdiDescuento <> "0.00"){

		$pdf->Ln(5);
		$pdf->SetFont('Courier','B',8);
		$pdf->Cell(147,5,'DESCUENTO:',$Borde,0,'R');
		$pdf->SetFont('Courier','',10);
		$pdf->Cell(35,5,$InsVentaDirecta->MonSimbolo." ".number_format($InsVentaDirecta->VdiDescuento,2),$Borde,1,'R');
		
	}



	$pdf->Ln(1);
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(147,5,'SUB TOTAL:',$Borde,0,'R');
	$pdf->SetFont('Courier','',10);
	$pdf->Cell(35,5,$InsVentaDirecta->MonSimbolo." ".number_format($SubTotal,2),0,1,'R');


	$pdf->Ln(1);
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(147,5,'IMPUESTO:',$Borde,0,'R');
	$pdf->SetFont('Courier','',10);
	$pdf->Cell(35,5,$InsVentaDirecta->MonSimbolo." ".number_format($Impuesto,2),0,1,'R');



	$pdf->Ln(1);
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(147,5,'TOTAL:',$Borde,0,'R');
	$pdf->SetFont('Courier','',10);
	$pdf->Cell(35,5,$InsVentaDirecta->MonSimbolo." ".number_format($Total,2),1,1,'R');

}

//OBSERVACIONES
$pdf->Ln(1);


if(!empty($InsVentaDirecta->VdiObservacion)){
	
	$Observacion = "";
	
	if(strlen($InsVentaDirecta->VdiObservacion)>70){
		
		$vueltas = round(strlen($InsVentaDirecta->VdiObservacion)/70)+1;
		
		$primera = 0;
		for($i=0;$i<$vueltas;$i++){
			
			$Observacion = substr($InsVentaDirecta->VdiObservacion,$primera,70);
			$pdf->SetFont('Courier','B',8);
			$pdf->Cell(25,5,($primera==0)?'OBSERVACIONES:':'',$Borde,0,'L');
			$pdf->SetFont('Courier','',10);
			$pdf->Cell(152,5,($Observacion),$Borde,1,'L');
		
	
			$primera = $primera + 70;
		}
	
	}else{
		
		$pdf->SetFont('Courier','B',8);
		$pdf->Cell(25,5,'OBSERVACIONES:',$Borde,0,'L');
		$pdf->SetFont('Courier','',10);
		$pdf->Cell(100,5,($InsVentaDirecta->VdiObservacion),$Borde,0,'L');
	}
	
	$pdf->Ln(7);


}









 	$pdf->Ln(5);
	$pdf->SetFont('Courier','B',14);
	$pdf->Cell(147,5,'DOCUMENTO NO VALIDO PARA EFECTOS TRIBUTARIOS',$Borde,0,'R');

   
	$pdf->Ln(10);
	$pdf->SetFont('Courier','B',10);
	$pdf->Cell(140,5,'Recibido por: ',$Borde,0,'R');

	$pdf->Ln(10);
	$pdf->SetFont('Courier','B',10);
	$pdf->Cell(180,5,'_____________________________',$Borde,0,'R');
	$pdf->Ln(5);
	$pdf->SetFont('Courier','B',10);
	$pdf->Cell(147,5,'DNI: ',$Borde,0,'R');  

          

$pdf->Output($InsVentaDirecta->VdiId.".pdf","D");
//$pdf->Output();

?>