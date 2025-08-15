<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVentaDirectaExterno
 *
 * @author Ing. Jonathan Blanco Alave
 */



				
				class PDF extends FPDF
				{
					// Cabecera de página
					function Header(){
						// Logo
						$this->Image('../imagenes/externo/logotipo.png',10,8,50);
						// Arial bold 15
						$this->SetFont('Arial','B',8);
						
						$this->Ln(12);
						$this->Cell(0,5,date("d/m/Y").' '.date("H:i:s").' '.date("a").' '.$_SESSION['SesionUsuario'],0,0,'R');
						
						
						// Movernos a la derecha
						//$this->Cell(80);
						// Título
						//$this->Cell(30,10,'Title',1,0,'C');
						// Salto de línea
						$this->Ln(13);
					}
					
					// Pie de página
					function Footer(){
						// Posición: a 1,5 cm del final
						$this->SetY(-25);
						// Arial italic 8
						$this->SetFont('Arial','I',8);
						// Movernos a la derecha
						//$this->Cell(80);
						// Número de página		
						//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
						
						// Título
						//$this->Ln(5);
				//		$this->Cell(0,5,'Urb. Los Cedros Mz. B Lte. 10 Av. Manuel A. Odria Via Panamericana Sur (Costado Grifo Municipal)',0,0,'C');
				//		$this->Ln(5);
				//		$this->Cell(0,5,'Telefono 51-52 315216 Anexo 210 Fono Fax: 851-52 315207 E-mail: canepa@cyc.com.pe',0,0,'C');
				//		$this->Ln(5);
				//		$this->Cell(0,5,'Inscritos en los Registros Publicos de Tacna Ficha 2986',0,0,'C');
				
						// Salto de línea
						//$this->Ln(20);		
						
						
						
						
					}
					
					
				}
				
				
class ClsVentaDirectaExterno {

    public $InsMysql;

    public function __construct($oInsMysql=NULL)
	{

		if ($oInsMysql) {
			$this->InsMysql = $oInsMysql;
		} else {
			$this->InsMysql = new ClsMysql();
		}

	}
	
	public function __destruct(){

	}



				
				
	public function MtdGenerarVentaDirectaExternoPDF($oVentaDirectaExternaId,$oRuta=NULL) {
		
		
		$PDFGenerado = true;
		
		$client = new nusoap_client('http://50.62.8.123/pedidos/webservice/WsOrdenCompra.php?wsdl','wsdl');
		$err = $client->getError();	
		
		if ($err) {
			echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
		}
		
		$param = array(	'oId' => $oVentaDirectaExternaId );
		$InsOrdenCompra = $client->call('MtdObtenerOrdenCompra', $param);
		
		$json = new Services_JSON();
		$InsOrdenCompra = $json->decode($InsOrdenCompra);
		
		if(!empty($InsOrdenCompra->VdiId)){

				
			$param = array('oId' => $InsOrdenCompra->VdiId);
			$ArrOrdenCompraDetalles  = $client->call('MtdObtenerOrdenCompraDetalles', $param);
			
			$json = new Services_JSON();
			$ArrOrdenCompraDetalles = $json->decode($ArrOrdenCompraDetalles);
			
			if(!empty($ArrOrdenCompraDetalles)){
				
				

					
				
					
					$Borde = 0;
					
					// Creación del objeto de la clase heredada
					$pdf = new PDF();
					$pdf->AliasNbPages();
					$pdf->AddPage();
					
					$pdf->SetFont('Arial','B',12);
					$pdf->Cell(0,0,('ORDEN DE COMPRA'),$Borde,0,'C');
					$pdf->Ln(4);
					$pdf->SetFont('Arial','B',14);
					//$pdf->Cell(0,0,$InsOrdenCompra->VdiId,$Borde,0,'C');
					$pdf->Cell(0,0,'',$Borde,0,'C');
					
					$pdf->Ln(5);
					
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(21,5,'Serie - Nro:',$Borde,0,'L');
					$pdf->Cell(100,5,$InsOrdenCompra->VdiOrdenCompraNumero,$Borde,0,'L');
					
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(21,5,'',$Borde,0,'L');
					$pdf->SetFont('Arial','',10);
					$pdf->Cell(48,5,'',$Borde,0,'L');
					
					$pdf->Ln(5);
					
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(21,5,'Proveedor:',$Borde,0,'L');
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(130,5,'C&C S.A.C',$Borde,0,'L');
					
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(21,5,'Fecha O/C:',$Borde,0,'L');
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(48,5,$InsOrdenCompra->VdiFecha,$Borde,0,'L');
					
					$pdf->Ln(5);
					
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(21,5,'Direccion:',$Borde,0,'L');
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(130,5,'URB. LOS CEDROS MZ B LOTE 10 A COSTADO DEL GRIFO MUNICIPAL',$Borde,0,'L');
					
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(21,5,'Entrega',$Borde,0,'L');
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(48,5,'',$Borde,0,'L');
					
					$pdf->Ln(5);
					
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(21,5,'Auto:',$Borde,0,'L');
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(70,5,$InsOrdenCompra->VdiMarca.' / '.$InsOrdenCompra->VdiModelo,$Borde,0,'L');
					
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(15,5,'Placa:',$Borde,0,'L');
					$pdf->SetFont('Arial','',10);
					$pdf->Cell(15,5,$InsOrdenCompra->VdiPlaca,$Borde,0,'L');
					
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(15,5,utf8_decode('Año:'),$Borde,0,'L');
					$pdf->SetFont('Arial','',10);
					$pdf->Cell(15,5,$InsOrdenCompra->VdiAnoModelo,$Borde,0,'L');
					
					
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(21,5,'Moneda:',$Borde,0,'L');
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(48,5,$InsOrdenCompra->MonSimbolo,$Borde,0,'L');
					
					$pdf->Ln(5);
					
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(21,5,'Responsable:',$Borde,0,'L');
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(100,5,$InsOrdenCompra->PerNombre." ".$InsOrdenCompra->PerApellidoPaterno." ".$InsOrdenCompra->PerApellidoMaterno,$Borde,0,'L');
					
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(21,5,'',$Borde,0,'L');
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(48,5,'',$Borde,0,'L');
					
					
					
					
					
					
					
					
					////SECCION REPUESTOS
					$pdf->Ln(7);
					
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(100,5,'REPUESTOS',$Borde,0,'L');
					
					//DETALLE CABECERA REPUESTOS
					$pdf->Ln(7);
					
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(5,5,'#',1,0,'C');
					
					
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(30,5,utf8_decode('Código'),1,0,'C');
					
					
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(100,5,'Producto',1,0,'C');
					
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(17,5,'Cantidad',1,0,'C');
					
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(15,5,'Precio',1,0,'C');	
					
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(15,5,'Importe',1,0,'C');		
							
					//DETALLE REPUESTOS
					$pdf->SetFont('Arial','',8);		
					
					$TotalRepuesto = 0;
					
					
						$i=1;
						if(!empty($ArrOrdenCompraDetalles)){
							foreach($ArrOrdenCompraDetalles as $DatVentaDirectaDetalle){
						
								$pdf->Ln(5);
								
								$pdf->Cell(5,5,$i,$Borde,0,'C');
								$pdf->Cell(30,5,$DatVentaDirectaDetalle->ProCodigoOriginal,$Borde,0,'R');
								$pdf->Cell(100,5,utf8_decode($DatVentaDirectaDetalle->ProNombre),$Borde,0,'L');
								$pdf->Cell(17,5,round($DatVentaDirectaDetalle->VddCantidad,2),$Borde,0,'C');
								$pdf->Cell(15,5,number_format($DatVentaDirectaDetalle->VddPrecioVenta,2),$Borde,0,'R');
								$pdf->Cell(15,5,number_format($DatVentaDirectaDetalle->VddImporte,2),$Borde,0,'R');
					
								
								$TotalRepuesto += $DatVentaDirectaDetalle->VddImporte;
								$i++;
								
								
								}
								
						}
					
					
					
					
					$TotalBruto = $TotalRepuesto;
					
					if($InsOrdenCompra->VdiIncluyeImpuesto == 2){
						
						$SubTotal = $TotalBruto - $POST_Descuento;
						$Impuesto = $SubTotal * ($InsOrdenCompra->VdiPorcentajeImpuestoVenta/100);	
						$Total = $SubTotal + $Impuesto;
						
					}else{
						
						$Total = $TotalBruto - $POST_Descuento;
						$SubTotal = $Total / (($InsOrdenCompra->VdiPorcentajeImpuestoVenta/100)+1);
						$Impuesto = $Total - $SubTotal;	
					
					}
					
						
					
					
					//TOTALES
					$pdf->Ln(7);
					
					
					$pdf->Ln(5);
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(147,5,'Sub Total:',$Borde,0,'R');
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(35,5,$InsOrdenCompra->MonSimbolo." ".number_format($SubTotal,2),$Borde,1,'R');
					
					//$pdf->Ln(5);
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(147,5,'I.G.V. ('.$InsCotizacionProducto->VdiPorcentajeImpuestoVenta.'%):',$Borde,0,'R');
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(35,5,$InsOrdenCompra->MonSimbolo." ".number_format($Impuesto,2),$Borde,1,'R');
					
					$pdf->Ln(5);
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(147,5,'Total:',$Borde,0,'R');
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(35,5,$InsOrdenCompra->MonSimbolo." ".number_format($Total,2),1,1,'R');
					
					
					
					
					
					//OBSERVACIONES
					$pdf->Ln(1);
					
					
					if(!empty($InsOrdenCompra->VdiObservacion)){
						
						$Observacion = "";
						
						if(strlen($InsOrdenCompra->VdiObservacion)>70){
							
							$vueltas = round(strlen($InsOrdenCompra->VdiObservacion)/70)+1;
							
							$primera = 0;
							for($i=0;$i<$vueltas;$i++){
								
								$Observacion = substr($InsOrdenCompra->VdiObservacion,$primera,70);
								$pdf->SetFont('Arial','B',8);
								$pdf->Cell(25,5,($primera==0)?'OBSERVACIONES:':'',$Borde,0,'L');
								$pdf->SetFont('Arial','',10);
								$pdf->Cell(152,5,($Observacion),$Borde,1,'L');
							
						
								$primera = $primera + 70;
							}
						
						}else{
							
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(25,5,'OBSERVACIONES:',$Borde,0,'L');
							$pdf->SetFont('Arial','',10);
							$pdf->Cell(100,5,($InsOrdenCompra->VdiObservacion),$Borde,0,'L');
						}
						
						$pdf->Ln(7);
					
					
					}
					
					
					
					
					
				
				
				
				
				   
					
				//
				//	$pdf->Ln(10);
				//	
				//	$pdf->SetFont('Arial','B',10);
				//	$pdf->Cell(180,5,'_____________________________',$Borde,0,'R');
				//	
				//	$pdf->Ln(5);
				//	$pdf->SetFont('Arial','B',10);
				//	$pdf->Cell(180,5,''.$InsOrdenCompra->PerNombre." ".$InsOrdenCompra->PerApellidoPaterno." ".$InsOrdenCompra->PerApellidoMaterno,$Borde,0,'R');  
				
						 // deb($InsOrdenCompra->VdiId);
				
				$pdf->Output($oRuta."".$InsOrdenCompra->VdiId."_".$InsOrdenCompra->VdiOrdenCompraNumero.".pdf","F");
				//$pdf->Output();
				
				
			}else{
				
				$PDFGenerado = false;	
				
			}

				
		}else{
			
			$PDFGenerado = false;
			
		}	
		
		return $PDFGenerado;
				

	}
		
}
?>