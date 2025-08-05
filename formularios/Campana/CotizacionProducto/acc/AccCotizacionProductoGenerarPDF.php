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
$GET_ImprimirPedido = $_GET['ImprimirPedido'];

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProducto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoFoto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoPlanchadoPintado.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');

$InsCotizacionProducto = new ClsCotizacionProducto();

$InsCotizacionProducto->CprId = $GET_id;
$InsCotizacionProducto->MtdObtenerCotizacionProducto();




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
$pdf->Cell(0,0,'COTIZACION',$Borde,0,'C');
$pdf->Ln(4);
$pdf->SetFont('Courier','B',14);
$pdf->Cell(0,0,$InsCotizacionProducto->CprId,$Borde,0,'C');



$pdf->Ln(5);


	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(15,5,'FECHA:',$Borde,0,'L');
	$pdf->SetFont('Courier','',10);
	$pdf->Cell(110,5,utf8_decode($InsCotizacionProducto->CprFecha),$Borde,0,'L');
	







$pdf->Ln(5);

if(!empty($InsCotizacionProducto->CliIdSeguro)){
	
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(15,5,'SEGURO:',$Borde,0,'L');
	$pdf->SetFont('Courier','',10);
	$pdf->Cell(110,5,utf8_decode($InsCotizacionProducto->CliNombreSeguro).' '.utf8_decode($InsCotizacionProducto->CliApellidoPaternoSeguro).' '.utf8_decode($InsCotizacionProducto->CliApellidoMaternoSeguro),$Borde,0,'L');
	
}else{
	
	$pdf->Cell(15,5,'',$Borde,0,'L');
	$pdf->Cell(110,5,'',$Borde,0,'L');
	
}


//
//$pdf->SetFont('Courier','B',8);
//$pdf->Cell(18,5,'FECHA:',$Borde,0,'L');
//$pdf->SetFont('Courier','',10);
//$pdf->Cell(48,5,$InsCotizacionProducto->CprFecha,$Borde,0,'L');

$pdf->Ln(5);

$pdf->SetFont('Courier','B',8);
$pdf->Cell(15,5,'CLIENTE:',$Borde,0,'L');
$pdf->SetFont('Courier','',10);
$pdf->Cell(110,5,utf8_decode($InsCotizacionProducto->CliNombre).' '.utf8_decode($InsCotizacionProducto->CliApellidoPaterno).' '.utf8_decode($InsCotizacionProducto->CliApellidoMaterno),$Borde,0,'L');


$pdf->SetFont('Courier','B',8);
$pdf->Cell(18,5,'VIN:',$Borde,0,'L');
$pdf->SetFont('Courier','',10);
$pdf->Cell(48,5,$InsCotizacionProducto->EinVIN,$Borde,0,'L');  

$pdf->Ln(5);

$pdf->SetFont('Courier','B',8);
$pdf->Cell(15,5,'NUM. DOC.:',$Borde,0,'L');
$pdf->SetFont('Courier','',10);
$pdf->Cell(110,5,$InsCotizacionProducto->TdoNombre."/".$InsCotizacionProducto->CliNumeroDocumento,$Borde,0,'L');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(18,5,'MARCA:',$Borde,0,'L');
$pdf->SetFont('Courier','',10);
$pdf->Cell(48,5,$InsCotizacionProducto->CprMarca,$Borde,0,'L');


$pdf->Ln(5);

$pdf->SetFont('Courier','B',8);
$pdf->Cell(15,5,'CELULAR:',$Borde,0,'L');
$pdf->SetFont('Courier','',10);
$pdf->Cell(110,5,$InsCotizacionProducto->CprTelefono,$Borde,0,'L');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(18,5,'MODELO:',$Borde,0,'L');
$pdf->SetFont('Courier','',10);
$pdf->Cell(48,5,$InsCotizacionProducto->CprModelo,$Borde,0,'L');

$pdf->Ln(5);

$pdf->SetFont('Courier','B',8);
$pdf->Cell(15,5,'EMAIL:',$Borde,0,'L');
$pdf->SetFont('Courier','',10);
$pdf->Cell(110,5,$InsCotizacionProducto->CprEmail,$Borde,0,'L');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(18,5,'PLACA:',$Borde,0,'L');
$pdf->SetFont('Courier','',10);
$pdf->Cell(48,5,$InsCotizacionProducto->CprPlaca,$Borde,0,'L');












////SECCION REPUESTOS
$pdf->Ln(7);

$pdf->SetFont('Courier','B',8);
$pdf->Cell(100,5,'REPUESTOS',$Borde,0,'L');

//DETALLE CABECERA REPUESTOS
$pdf->Ln(7);

$pdf->SetFont('Courier','B',8);
$pdf->Cell(5,5,'#',1,0,'C');

if($GET_ImprimirPedido==1){
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(10,5,'TIPO',1,0,'C');
}else{
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(10,5,'',1,0,'C');
}

if($GET_ImprimirCodigo==1){
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(20,5,'CODIGO',1,0,'C');
}else{
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(20,5,'',1,0,'C');
}


$pdf->SetFont('Courier','B',8);
$pdf->Cell(10,5,'CANT.',1,0,'C');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(10,5,'UND.',1,0,'C');


$pdf->SetFont('Courier','B',8);
$pdf->Cell(100,5,'NOMBRE',1,0,'C');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(15,5,'P/UNIT',1,0,'C');	



$pdf->SetFont('Courier','B',8);
$pdf->Cell(15,5,'P/FINAL',1,0,'C');	

//}

//DETALLE REPUESTOS
$pdf->SetFont('Courier','',8);		

$TotalRepuesto = 0;
$TotalDescuento = 0;

if( ($InsCotizacionProducto->CprVerificar == 2 and $InsCotizacionProducto->CprRepuesto == "Si") or ($InsCotizacionProducto->CprVerificar == 1 and $InsCotizacionProducto->CprRepuestoVerificado== "Si" ) ){

	$i=1;
	if(!empty($InsCotizacionProducto->CotizacionProductoDetalle)){
		foreach($InsCotizacionProducto->CotizacionProductoDetalle as $DatCotizacionProductoDetalle){
	
			if( $InsCotizacionProducto->CprVerificar == 2 or ( $InsCotizacionProducto->CprVerificar == 1 and $DatCotizacionProductoDetalle->CrdEstado == 1)){
				
				if($InsCotizacionProducto->MonId<>$EmpresaMonedaId){
					
						$DatCotizacionProductoDetalle->CrdPrecioBruto = round($DatCotizacionProductoDetalle->CrdPrecioBruto / $InsCotizacionProducto->CprTipoCambio,2);
						
					$DatCotizacionProductoDetalle->CrdImporte = round($DatCotizacionProductoDetalle->CrdImporte / $InsCotizacionProducto->CprTipoCambio,2);
					$DatCotizacionProductoDetalle->CrdPrecio = round($DatCotizacionProductoDetalle->CrdPrecio  / $InsCotizacionProducto->CprTipoCambio,2);
				
			}
	
	
	
			
if(!empty($InsCotizacionProducto->CprPorcentajeDescuento)){
	
	$DetallePrecioBruto = ($DatCotizacionProductoDetalle->CrdPrecioBruto);
	$DetallePrecio = $DetallePrecioBruto;
	$DetalleImporte = ($DetallePrecio * $DatCotizacionProductoDetalle->CrdCantidad);
		
	$DetallePrecioDescuento =  $DetallePrecio - ($DetallePrecio * ($InsCotizacionProducto->CprPorcentajeDescuento/100));
	
	//$DetalleDescuento = ($DetalleImporte * ($InsCotizacionProducto->CprPorcentajeDescuento/100));
	$DetalleDescuento = round(($DetalleImporte * ( $InsCotizacionProducto->CprPorcentajeDescuento/100) ),2);
	
	$DetalleImporteFinal = $DetalleImporte - $DetalleDescuento;

}else{

	$DetallePrecioBruto = ($DatCotizacionProductoDetalle->CrdPrecioBruto);
	$DetallePrecio = $DetallePrecioBruto;
	$DetalleImporte = ($DetallePrecio *  $DatCotizacionProductoDetalle->CrdCantidad);
	
	$DetallePrecioDescuento =  $DetallePrecio;
	
	$DetalleDescuento = 0;
	$DetalleImporteFinal = $DetalleImporte - $DetalleDescuento;

}




			
			$pdf->Ln(5);
			
			$pdf->Cell(5,5,$i,$Borde,0,'C');
			
		
			if($GET_ImprimirPedido==1){
				 $pdf->Cell(10,5,trim($DatCotizacionProductoDetalle->CrdTipoPedido),$Borde,0,'R');
			}else{
				 $pdf->Cell(10,5,'',$Borde,0,'R');
			}
			
			if($GET_ImprimirCodigo==1){
				 $pdf->Cell(20,5,trim($DatCotizacionProductoDetalle->ProCodigoOriginal),$Borde,0,'R');
			}else{
				 $pdf->Cell(20,5,'',$Borde,0,'R');
			}
			
			$pdf->Cell(10,5,round($DatCotizacionProductoDetalle->CrdCantidad,2),$Borde,0,'C');
			$pdf->Cell(10,5,($DatCotizacionProductoDetalle->UmeAbreviacion),$Borde,0,'C');
			
			
			$pdf->Cell(100,5,utf8_decode($DatCotizacionProductoDetalle->ProNombre),$Borde,0,'L');
			$pdf->Cell(15,5,number_format($DetallePrecio ,2),$Borde,0,'R');

			$pdf->Cell(15,5,number_format($DetalleImporteFinal,2),$Borde,0,'R');
	
			//}
			
			$TotalRepuesto += $DetalleImporteFinal;
			$TotalDescuento += $DetalleDescuento;
			
			$i++;
			
			
			}
	
			
		}
		
	}

	
}



if($InsCotizacionProducto->CprRepuesto == "Si" or $InsCotizacionProducto->CprPlanchado=="Si" or $InsCotizacionProducto->CprPintado=="Si" or $InsCotizacionProducto->CprCentrado == "Si" or $InsCotizacionProducto->CprTarea == "Si"){
	//TOTAL REPUESTOS
$pdf->Ln(7);

$pdf->SetFont('Courier','B',8);
$pdf->Cell(155,5,'TOTAL REPUESTOS:',$Borde,0,'R');
$pdf->SetFont('Courier','',8);
$pdf->Cell(35,5,number_format($TotalRepuesto,2),0,0,'R');
}


/*	if(!empty($InsCotizacionProducto->CprPorcentajeDescuento)){
		$TotalDescuento = $TotalRepuesto * ($InsCotizacionProducto->CprPorcentajeDescuento/100);
		$TotalRepuesto = $TotalRepuesto - $TotalDescuento;
	}
*/



//deb($InsCotizacionProducto->CprManoObra);
//if(!empty($InsCotizacionProducto->CprManoObra) and $InsCotizacionProducto->CprManoObra <> "0.00"){
	if(!empty($InsCotizacionProducto->CprManoObra) and $InsCotizacionProducto->CprManoObra <> "0.00"){

//deb($InsCotizacionProducto->CprManoObra);

	if($InsCotizacionProducto->MonId<>$EmpresaMonedaId){
						
		$InsCotizacionProducto->CprManoObra = round($InsCotizacionProducto->CprManoObra / $InsCotizacionProducto->CprTipoCambio,2);
					
					
					
					
	}


//deb($InsCotizacionProducto->CprManoObra);

//	////SECCION MANO DE OBRA
//	$pdf->Ln(7);
//	
//	$pdf->SetFont('Courier','B',8);
//	$pdf->Cell(100,5,'MANO DE OBRA',$Borde,0,'L');
//	
//	//TOTAL MANO DE OBRA
//	$pdf->Ln(7);
//	
//	$pdf->SetFont('Courier','B',8);
//	$pdf->Cell(157,5,'TOTAL:',$Borde,0,'R');
//	$pdf->SetFont('Courier','',10);
//	$pdf->Cell(20,5,number_format($InsCotizacionProducto->CprManoObra,2),0,0,'R');


	////SECCION MANO DE OBRA
//	$pdf->Ln(7);
//	
//	$pdf->SetFont('Courier','B',8);
//	$pdf->Cell(100,5,'',$Borde,0,'L');
//	
//	//TOTAL MANO DE OBRA
//	//$pdf->Ln(7);
//	
//	$pdf->SetFont('Courier','B',8);
//	$pdf->Cell(155,5,'MANO DE OBRA:',$Borde,0,'R');
//	$pdf->SetFont('Courier','',8);
//	$pdf->Cell(35,5,number_format($InsCotizacionProducto->CprManoObra,2),0,0,'R');
//	
	
		//TOTAL PLANCHADO
	$pdf->Ln(7);
	
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(155,5,'MANO DE OBRA:',$Borde,0,'R');
	$pdf->SetFont('Courier','',8);
	$pdf->Cell(35,5,number_format($InsCotizacionProducto->CprManoObra,2),0,0,'R');


}else{
	
}


//if($InsCotizacionProducto->CprPlanchado=="Si"){
if( ($InsCotizacionProducto->CprVerificar == 2 and $InsCotizacionProducto->CprPlanchado == "Si") or ($InsCotizacionProducto->CprVerificar == 1 and $InsCotizacionProducto->CprPlanchadoVerificado == "Si" ) ){
	
	////SECCION PLANCHADO
	$pdf->Ln(7);
	
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(100,5,'PLANCHADO',$Borde,0,'L');
	
	
	//DETALLE CABECERA PLANCHADO
	$pdf->Ln(7);
	
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(5,5,'#',1,0,'C');
	
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(169,5,'Nombre',1,0,'C');
	
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(15,5,'Importe',1,0,'C');		
			
	//DETALLE PLANCHADO
	$pdf->SetFont('Courier','',8);		
	
	$TotalPlanchado = 0;
	$i=1;
	if(!empty($InsCotizacionProducto->CotizacionProductoPlanchado)){
		foreach($InsCotizacionProducto->CotizacionProductoPlanchado as $DatCotizacionProductoPlanchado){
	
			if( $InsCotizacionProducto->CprVerificar == 2 or ( $InsCotizacionProducto->CprVerificar == 1 and $DatCotizacionProductoPlanchado->CppEstado == 1)){
				
		
		
				if($InsCotizacionProducto->MonId<>$EmpresaMonedaId){
					if(!empty($InsCotizacionProducto->CprTipoCambio)){
						$DatCotizacionProductoPlanchado->CppImporte = round($DatCotizacionProductoPlanchado->CppImporte / $InsCotizacionProducto->CprTipoCambio,2);
					}else{
						$DatCotizacionProductoPlanchado->CppImporte = 0;
					}
				}
	
			
			$pdf->Ln(5);
			
			$pdf->Cell(5,5,$i,$Borde,0,'C');
			$pdf->Cell(169,5,utf8_decode($DatCotizacionProductoPlanchado->CppDescripcion),$Borde,0,'L');
			$pdf->Cell(15,5,number_format($DatCotizacionProductoPlanchado->CppImporte,2),$Borde,0,'R');
			
			$TotalPlanchado += $DatCotizacionProductoPlanchado->CppImporte;
			$i++;
			}
		}
	}
	
	//TOTAL PLANCHADO
	$pdf->Ln(7);
	
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(155,5,'TOTAL PLANCHADO:',$Borde,0,'R');
	$pdf->SetFont('Courier','',8);
	$pdf->Cell(35,5,number_format($TotalPlanchado,2),0,0,'R');


}



//if($InsCotizacionProducto->CprPintado=="Si"){
if( ($InsCotizacionProducto->CprVerificar == 2 and $InsCotizacionProducto->CprPintado == "Si") or ($InsCotizacionProducto->CprVerificar == 1 and $InsCotizacionProducto->CprPintadoVerificado == "Si" ) ){
		
	////SECCION PINTADO
	$pdf->Ln(7);
	
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(100,5,'PINTADO',$Borde,0,'L');
	
	
	//DETALLE CABECERA PINTADO
	$pdf->Ln(7);
	
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(5,5,'#',1,0,'C');
	
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(169,5,'Nombre',1,0,'C');
	
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(15,5,'Importe',1,0,'C');		
			
	//DETALLE PINTADO
	$pdf->SetFont('Courier','',8);		
	
	$TotalPintado = 0;
	$i=1;
	if(!empty($InsCotizacionProducto->CotizacionProductoPintado)){
		foreach($InsCotizacionProducto->CotizacionProductoPintado as $DatCotizacionProductoPintado){
			
			if( $InsCotizacionProducto->CprVerificar == 2 or ( $InsCotizacionProducto->CprVerificar == 1 and $DatCotizacionProductoPintado->CppEstado == 1)){

				
				if($InsCotizacionProducto->MonId<>$EmpresaMonedaId){

						$DatCotizacionProductoPintado->CppImporte = round($DatCotizacionProductoPintado->CppImporte / $InsCotizacionProducto->CprTipoCambio,2);
					
				}
	
			
			$pdf->Ln(5);
			
			$pdf->Cell(5,5,$i,$Borde,0,'C');
			$pdf->Cell(169,5,utf8_decode($DatCotizacionProductoPintado->CppDescripcion),$Borde,0,'L');
			$pdf->Cell(15,5,number_format($DatCotizacionProductoPintado->CppImporte,2),$Borde,0,'R');
			
			$TotalPintado += $DatCotizacionProductoPintado->CppImporte;
			$i++;
			

			}
		}
	}
	
	//TOTAL PINTADO
	$pdf->Ln(7);
	
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(155,5,'TOTAL PINTADO:',$Borde,0,'R');
	$pdf->SetFont('Courier','',8);
	$pdf->Cell(35,5,number_format($TotalPintado,2),0,0,'R');

 }





//if($InsCotizacionProducto->CprCentrado=="Si"){
if( ($InsCotizacionProducto->CprVerificar == 2 and $InsCotizacionProducto->CprCentrado == "Si") or ($InsCotizacionProducto->CprVerificar == 1 and $InsCotizacionProducto->CprCentradoVerificado == "Si" ) ){
		
	////SECCION CENTRADO
	$pdf->Ln(7);
	
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(100,5,'CENTRADO',$Borde,0,'L');
	
	
	//DETALLE CABECERA PINTADO
	$pdf->Ln(7);
	
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(5,5,'#',1,0,'C');
	
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(169,5,'Nombre',1,0,'C');
	
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(15,5,'Importe',1,0,'C');		
			
	//DETALLE PINTADO
	$pdf->SetFont('Courier','',8);		
	
	$TotalCentrado = 0;
	$i=1;
	if(!empty($InsCotizacionProducto->CotizacionProductoCentrado)){
		foreach($InsCotizacionProducto->CotizacionProductoCentrado as $DatCotizacionProductoCentrado){
	
			if( $InsCotizacionProducto->CprVerificar == 2 or ( $InsCotizacionProducto->CprVerificar == 1 and $DatCotizacionProductoCentrado->CppEstado == 1)){
	
		
					if($InsCotizacionProducto->MonId<>$EmpresaMonedaId){
						$DatCotizacionProductoCentrado->CppImporte = round($DatCotizacionProductoCentrado->CppImporte / $InsCotizacionProducto->CprTipoCambio,2);
					}
		
				
				$pdf->Ln(5);
				
				$pdf->Cell(5,5,$i,$Borde,0,'C');
				$pdf->Cell(169,5,utf8_decode($DatCotizacionProductoCentrado->CppDescripcion),$Borde,0,'L');
				$pdf->Cell(15,5,number_format($DatCotizacionProductoCentrado->CppImporte,2),$Borde,0,'R');
				
				$TotalCentrado += $DatCotizacionProductoCentrado->CppImporte;
				$i++;
				
			}
		}
	}
	
	//TOTAL PINTADO
	$pdf->Ln(7);
	
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(155,5,'TOTAL CENTRADO:',$Borde,0,'R');
	$pdf->SetFont('Courier','',8);
	$pdf->Cell(35,5,number_format($TotalCentrado,2),0,0,'R');

 }





//if($InsCotizacionProducto->CprTarea=="Si"){
if( ($InsCotizacionProducto->CprVerificar == 2 and $InsCotizacionProducto->CprTarea == "Si") or ($InsCotizacionProducto->CprVerificar == 1 and $InsCotizacionProducto->CprTareaVerificado == "Si" ) ){
		
	////SECCION TAREAS/REPARACION
	$pdf->Ln(7);
	
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(100,5,'TAREAS/REPARACION',$Borde,0,'L');
	
	
	//DETALLE CABECERA TAREAS/REPARACION
	$pdf->Ln(7);
	
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(5,5,'#',1,0,'C');
	
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(169,5,'Nombre',1,0,'C');
	
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(15,5,'Importe',1,0,'C');		
			
	//DETALLE PINTADO
	$pdf->SetFont('Courier','',8);		
	
	$TotalTarea = 0;
	$i=1;
	if(!empty($InsCotizacionProducto->CotizacionProductoTarea)){
		foreach($InsCotizacionProducto->CotizacionProductoTarea as $DatCotizacionProductoTarea){
	
			if( $InsCotizacionProducto->CprVerificar == 2 or ( $InsCotizacionProducto->CprVerificar == 1 and $DatCotizacionProductoTarea->CppEstado == 1)){
	
		
					if($InsCotizacionProducto->MonId<>$EmpresaMonedaId){
						$DatCotizacionProductoTarea->CppImporte = round($DatCotizacionProductoTarea->CppImporte / $InsCotizacionProducto->CprTipoCambio,2);
					}
		
				
				$pdf->Ln(5);
				
				$pdf->Cell(5,5,$i,$Borde,0,'C');
				$pdf->Cell(169,5,utf8_decode($DatCotizacionProductoTarea->CppDescripcion),$Borde,0,'L');
				$pdf->Cell(15,5,number_format($DatCotizacionProductoTarea->CppImporte,2),$Borde,0,'R');
				
				$TotalTarea += $DatCotizacionProductoTarea->CppImporte;
				$i++;
				
			}
		}
	}
	
	//TOTAL TAREAS/REPARACION
	$pdf->Ln(7);
	
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(155,5,'TOTAL TAREA/REPARACION:',$Borde,0,'R');
	$pdf->SetFont('Courier','',8);
	$pdf->Cell(35,5,number_format($TotalTarea,2),0,0,'R');

 }

//
//	if($InsCotizacionProducto->CprIncluyeImpuesto == 1){
//		
//		$Total = $TotalRepuesto + $TotalPlanchado + $TotalPintado + $TotalCentrado + $TotalTarea + $InsCotizacionProducto->CprManoObra;
//		$SubTotal = $Total / (($InsCotizacionProducto->CprPorcentajeImpuestoVenta/100)+1);
//		$Impuesto = $Total - $SubTotal;	
//		
//	}else{
//		
//		$SubTotal = $TotalRepuesto + $TotalPlanchado + $TotalPintado + $TotalCentrado + $TotalTarea + $InsCotizacionProducto->CprManoObra;
//		$Impuesto = $SubTotal * (($InsCotizacionProducto->CprPorcentajeImpuestoVenta/100));
//		$Total = $SubTotal + $Impuesto;	
//		
//	}
	
	if($InsCotizacionProducto->CprIncluyeImpuesto == 1){
    
    $Total = $TotalRepuesto + $TotalPlanchado + $TotalPintado + $TotalCentrado + $TotalTarea + $InsCotizacionProducto->CprManoObra;
    $SubTotal = $Total / (($InsCotizacionProducto->CprPorcentajeImpuestoVenta/100)+1);
    $Impuesto = $Total - $SubTotal;	
    
}else{
    
    $SubTotal = $TotalRepuesto + $TotalPlanchado + $TotalPintado + $TotalCentrado + $TotalTarea + $InsCotizacionProducto->CprManoObra;
    $Impuesto = $SubTotal * (($InsCotizacionProducto->CprPorcentajeImpuestoVenta/100));
    $Total = $SubTotal + $Impuesto;	
    
}


	
//	$Total = $TotalRepuesto + $TotalPlanchado + $TotalPintado + $TotalCentrado + $TotalTarea + $InsCotizacionProducto->CprManoObra;
//	$SubTotal = $Total / (($InsCotizacionProducto->CprPorcentajeImpuestoVenta/100)+1);
//	$Impuesto = $Total - $SubTotal;	


//TOTALES
$pdf->Ln(7);

if(!empty($TotalDescuento) and $TotalDescuento<>"0.00"){
		
//$pdf->Ln(5);
$pdf->SetFont('Courier','B',8);
$pdf->Cell(155,5,'DESCUENTO ('.number_format($InsCotizacionProducto->CprPorcentajeDescuento,2).' %):',$Borde,0,'R');
$pdf->SetFont('Courier','',8);
$pdf->Cell(35,5,$InsCotizacionProducto->MonSimbolo." ".number_format($TotalDescuento,2),$Borde,1,'R');

}



//$pdf->Ln(5);
$pdf->SetFont('Courier','B',8);
$pdf->Cell(155,5,'SUBTOTAL:',$Borde,0,'R');
$pdf->SetFont('Courier','',8);
$pdf->Cell(35,5,$InsCotizacionProducto->MonSimbolo." ".number_format($SubTotal,2),$Borde,1,'R');

//$pdf->Ln(5);
$pdf->SetFont('Courier','B',8);
$pdf->Cell(155,5,'I.G.V. ('.$InsCotizacionProducto->CprPorcentajeImpuestoVenta.'%):',$Borde,0,'R');
$pdf->SetFont('Courier','',8);
$pdf->Cell(35,5,$InsCotizacionProducto->MonSimbolo." ".number_format($Impuesto,2),$Borde,1,'R');

//$pdf->Ln(5);
//$pdf->SetFont('Courier','B',8);
//$pdf->Cell(147,5,'',$Borde,0,'R');
//$pdf->SetFont('Courier','',10);
//$pdf->Cell(35,5,"",$Borde,1,'R');
//
////$pdf->Ln(5);
//$pdf->SetFont('Courier','B',8);
//$pdf->Cell(147,5,"",$Borde,0,'R');
//$pdf->SetFont('Courier','',10);
//$pdf->Cell(35,5,"",$Borde,1,'R');



//$pdf->Ln(5);
$pdf->SetFont('Courier','B',8);
$pdf->Cell(155,5,'TOTAL:',$Borde,0,'R');
$pdf->SetFont('Courier','',8);
$pdf->Cell(35,5,$InsCotizacionProducto->MonSimbolo." ".number_format($Total,2),1,1,'R');


//OBSERVACIONES
$pdf->Ln(1);

//$InsCotizacionProducto->CprObservacion =str_replace("</p>",chr(13),$InsCotizacionProducto->CprObservacion);
$InsCotizacionProducto->CprObservacion = strip_tags($InsCotizacionProducto->CprObservacion,"");
//$InsCotizacionProducto->CprObservacion =str_replace("\n",' ',$InsCotizacionProducto->CprObservacion);
		
if(!empty($InsCotizacionProducto->CprObservacion)){

	$Observacion = "";

	if(strlen($InsCotizacionProducto->CprObservacion)>70){

		$vueltas = round(strlen($InsCotizacionProducto->CprObservacion)/70)+1;

		$primera = 0;
		for($i=0;$i<$vueltas;$i++){

			$Observacion = substr($InsCotizacionProducto->CprObservacion,$primera,70);
			$pdf->SetFont('Courier','B',8);
			$pdf->Cell(25,5,($primera==0)?'OBSERVACIONES:':'',$Borde,0,'L');
			$pdf->SetFont('Courier','',10);
			$pdf->Cell(152,5,utf8_decode($Observacion),$Borde,1,'L');
			$primera = $primera + 70;

		}

	}else{

		$pdf->SetFont('Courier','B',8);
		$pdf->Cell(25,5,'OBSERVACIONES:',$Borde,0,'L');
		$pdf->SetFont('Courier','',10);
		$pdf->Cell(100,5,utf8_decode($InsCotizacionProducto->CprObservacion),$Borde,0,'L');
		$InsCotizacionProducto->CprObservacion=str_replace("\n",' ',$InsCotizacionProducto->CprObservacion);
		
	}

	$pdf->Ln(7);
}


//NOTAS
$pdf->Ln(0);
$pdf->SetFont('Courier','B',8);
$pdf->Cell(40,5,'Notas:',$Borde,0,'L');
$pdf->Cell(60,5,'' ,$Borde,0,'L');

$pdf->Ln(5);
$pdf->SetFont('Courier','',8);

//if($InsCotizacionProducto->CprIncluyeImpuesto==1){
//	$pdf->Cell(100,5,'- Los precios incluyen el I.G.V.' ,$Borde,0,'L');
//	$pdf->Cell(70,5,'' ,$Borde,1,'L');	
//}else{
//	$pdf->Cell(100,5,'- Los precios no incluyen el I.G.V.' ,$Borde,0,'L');
//	$pdf->Cell(70,5,'' ,$Borde,1,'L');
//}

$pdf->Cell(100,5,'- Precios Validos por '.($InsCotizacionProducto->CprVigencia).' dias.' ,$Borde,0,'L');
$pdf->Cell(70,5,'' ,$Borde,1,'L');

if(!empty($InsCotizacionProducto->CprTiempoEntrega)){
	
	$pdf->Cell(100,5,'- El tiempo de entrega estimado es de '.$InsCotizacionProducto->CprTiempoEntrega.' dias habiles.' ,$Borde,0,'L');   
	
	//$pdf->Cell(100,5,'- El tiempo de entrega estimado es de '.($InsCotizacionProducto->CprTiempoEntrega).'dias. ('.$InsCotizacionProducto->CprFechaEntrega.')' ,$Borde,0,'L');
	$pdf->Cell(70,5,'' ,$Borde,1,'L');
}             
                 
$pdf->Cell(100,5,'- Los precios estan expresados en '.($InsCotizacionProducto->MonNombre).'.' ,$Borde,0,'L');               
$pdf->Cell(70,5,'' ,$Borde,1,'L');

//if(!empty($InsCotizacionProducto->CprTipoCambio)){
//	
//	$pdf->Cell(100,5,'- Tipo de Cambio '.($InsCotizacionProducto->CprTipoCambio).'.' ,$Borde,0,'L');               
//	$pdf->Cell(70,5,'' ,$Borde,1,'L');
//	
//}

$pdf->Cell(100,5,'- Repuestos originales.' ,$Borde,0,'L'); 
$pdf->Cell(70,5,'' ,$Borde,1,'L');              

//$pdf->Cell(100,5,'- Repuestos disponibles en 7 dias habiles.' ,$Borde,2,'L');               
//
$pdf->Cell(100,5,'- Repuestos no incluyen mano de obra.' ,$Borde,0,'L');               
$pdf->Cell(70,5,'' ,$Borde,1,'L');
            



//$pdf->Write(5,'A continuación mostramos una imagen ');

if($InsCotizacionProducto->CprFirmaDigital==1){
$pdf->Ln(-25);	
	  if(!empty($InsCotizacionProducto->PerFirma)){
		//$pdf->Cell(40,20);  
	  $pdf->Image('../../../subidos/personal_firmas/'.$InsCotizacionProducto->PerFirma,140,null,29,29,'JPG');
//	  $pdf->Image('leon.jpg' , 80 ,22, 35 , 38,'JPG', 
	  }
  
}

$pdf->Ln(2);		

$pdf->SetFont('Courier','',10);
$pdf->Cell(90,5,'' ,$Borde,0,'L'); 	
$pdf->Cell(100,5,'___________________________________' ,$Borde,1,'C'); 	

$pdf->Cell(90,5,'' ,$Borde,0,'L'); 	
$pdf->Cell(100,5,'Almacen - Ventas',$Borde,1,'C'); 	


$pdf->Cell(90,5,'' ,$Borde,0,'L'); 	
$pdf->Cell(100,5,$InsCotizacionProducto->PerNombre.' '.$InsCotizacionProducto->PerApellidoPaterno.' '.$InsCotizacionProducto->PerApellidoMaterno ,$Borde,1,'C'); 	

$pdf->SetFont('Courier','',8);

$pdf->Cell(90,5,'' ,$Borde,0,'L'); 
$pdf->Cell(100,5,'Telefono: '.$InsCotizacionProducto->PerTelefono ,$Borde,1,'C'); 

$pdf->Cell(90,5,'' ,$Borde,0,'L'); 
$pdf->Cell(100,5,'Celular: '.$InsCotizacionProducto->PerCelular ,$Borde,1,'C'); 

$pdf->Cell(90,5,'' ,$Borde,0,'L'); 
$pdf->Cell(100,5,'Email: '.$InsCotizacionProducto->PerEmail ,$Borde,1,'C'); 





/*
$pdf->SetFont('Courier','B',10);
$pdf->Cell(90,5,'Notas:' ,$Borde,0,'L'); 	

$pdf->SetFont('Courier','',10);
$pdf->Cell(10,5,'' ,$Borde,1,'C'); 	


if(!empty($InsCotizacionProducto->CprTiempoEntrega)){

//	$pdf->Cell(90,5,'- Tiempo de entrega estimado de '.($InsCotizacionProducto->CprTiempoEntrega).'dias. ('.$InsCotizacionProducto->CprFechaEntrega.')' ,$Borde,0,'L'); 
	$pdf->SetFont('Courier','',10);
	$pdf->Cell(90,5,'- Tiempo de entrega estimado de '.($InsCotizacionProducto->CprTiempoEntrega).'dias.' ,$Borde,0,'L'); 
	
	$pdf->SetFont('Courier','',10);
	$pdf->Cell(10,5,'' ,$Borde,1,'L'); 

}  

if(!empty($InsCotizacionProducto->CprTipoCambio)){

	$pdf->SetFont('Courier','',10);
	$pdf->Cell(90,5,'- Tipo de Cambio '.($InsCotizacionProducto->CprTipoCambio).'.' ,$Borde,0,'L'); 
	
	$pdf->SetFont('Courier','',10);
	$pdf->Cell(10,5,'' ,$Borde,1,'L'); 
	 
}
	

//***********

$pdf->SetFont('Courier','',10);
$pdf->Cell(90,5,'- Repuestos no incluyen mano de obra.',$Borde,0,'L'); 	

$pdf->SetFont('Courier','B',6);
$pdf->Cell(100,5,'___________________________________' ,$Borde,1,'C'); 	




$pdf->SetFont('Courier','',10);
$pdf->Cell(90,5,'- Los precios estan expresados en '.($InsCotizacionProducto->MonNombre).'.' ,$Borde,0,'L'); 	

$pdf->SetFont('Courier','B',6);
$pdf->Cell(100,5,$InsCotizacionProducto->PerNombre.' '.$InsCotizacionProducto->PerApellidoPaterno.' '.$InsCotizacionProducto->PerApellidoMaterno ,$Borde,1,'C'); 	




$pdf->SetFont('Courier','',10);
$pdf->Cell(90,5,'- Precios Validos por '.($InsCotizacionProducto->CprVigencia).' dias.',$Borde,0,'L'); 

$pdf->SetFont('Courier','B',6);
$pdf->Cell(100,5,'Telefono: '.$InsCotizacionProducto->PerTelefono ,$Borde,1,'C'); 




$pdf->SetFont('Courier','',10);
$pdf->Cell(90,5,'- Repuestos originales.',$Borde,0,'L'); 

$pdf->SetFont('Courier','B',6);
$pdf->Cell(100,5,'Celular: '.$InsCotizacionProducto->PerCelular ,$Borde,1,'C'); 



$pdf->SetFont('Courier','',10);
$pdf->Cell(90,5,'- Repuestos disponibles en 7 dias habiles.',$Borde,0,'L'); 

$pdf->SetFont('Courier','B',6);
$pdf->Cell(100,5,'Email: '.$InsCotizacionProducto->PerEmail ,$Borde,1,'C'); 
*/





//NOTAS
//$pdf->Ln(0);
//$pdf->SetFont('Courier','B',8);
//$pdf->Cell(40,5,'Notas:',$Borde,0,'L');
//$pdf->Cell(60,5,'' ,$Borde,0,'L');
//
//$pdf->Ln(5);
//$pdf->SetFont('Courier','',8);
//
//$pdf->Cell(100,5,'- Precios Validos por '.($InsCotizacionProducto->CprVigencia).' dias.' ,$Borde,2,'L');
//
//if(!empty($InsCotizacionProducto->CprTiempoEntrega)){
//	
//	$pdf->Cell(100,5,'- El tiempo de entrega estimado es de '.($InsCotizacionProducto->CprTiempoEntrega).'dias. ('.$InsCotizacionProducto->CprFechaEntrega.')' ,$Borde,2,'L');
//	
//}             
//                 
//$pdf->Cell(100,5,'- Los precios estan expresados en '.($InsCotizacionProducto->MonNombre).'.' ,$Borde,2,'L');               
//
//if(!empty($InsCotizacionProducto->CprTipoCambio)){
//	
//	$pdf->Cell(100,5,'- Tipo de Cambio '.($InsCotizacionProducto->CprTipoCambio).'.' ,$Borde,2,'L');               
//	
//}
//
//$pdf->Cell(100,5,'- Repuestos originales.' ,$Borde,2,'L');               
//$pdf->Cell(100,5,'- Repuestos disponibles en 7 dias habiles.' ,$Borde,2,'L');               
//$pdf->Cell(100,5,'- Repuestos no incluyen mano de obra.' ,$Borde,2,'L');               

          

$pdf->Output($InsCotizacionProducto->CprId.".pdf","D");
//$pdf->Output();

?>