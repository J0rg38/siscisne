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


require_once($InsProyecto->MtdRutLibrerias().'fpdf17/fpdf.php');


$GET_id = $_GET['Id'];
$GET_ImprimirCodigo = $_GET['ImprimirCodigo'];

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoFoto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

$InsCotizacionVehiculo = new ClsCotizacionVehiculo();
$InsVehiculoCaracteristicaSeccion = new ClsVehiculoCaracteristicaSeccion();

$InsCotizacionVehiculo->CveId = $GET_id;
$InsCotizacionVehiculo->MtdObtenerCotizacionVehiculo();

$ResVehiculoCaracteristicaSeccion = $InsVehiculoCaracteristicaSeccion->MtdObtenerVehiculoCaracteristicaSecciones(NULL,NULL,'VcsId','ASC',NULL);
$ArrVehiculoCaracteristicaSecciones = $ResVehiculoCaracteristicaSeccion['Datos'];


class PDF extends FPDF
{
	// Cabecera de página
	function Header(){
		// Logo
		global $InsCotizacionVehiculo;

 //deb($InsCotizacionVehiculo->VmaId);
	  switch($InsCotizacionVehiculo->VmaId){
		  case "VMA-10017":
			$this->Image('../../../imagenes/cabecera_chevrolet.png',10,8,190);
		  break;
		  
		  case "VMA-10018":
			$this->Image('../../../imagenes/cabecera_isuzu.png',10,8,190);
		  break;
		  
		  default:
			$this->Image('../../../imagenes/cabecera_cyc.png',10,8,190);
		  break;
	  }
	  
		
		// Arial bold 15
		$this->SetFont('Arial','B',8);
		
		$this->Ln(15);
		$this->Cell(0,5,date("d/m/Y").' '.date("H:i:s").' '.date("a").' '.$_SESSION['SesionUsuario'],0,0,'R');
		
		
		// Movernos a la derecha
		//$this->Cell(80);
		// Título
		//$this->Cell(30,10,'Title',1,0,'C');
		// Salto de línea
		$this->Ln(7);
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
		$this->Ln(5);
		$this->Cell(0,5,'Tacna - Urb. Los Cedros Mz. B Lte. 10 Av. Manuel A. Odria Via Panamericana Sur (Costado Grifo Municipal)',0,0,'C');
		$this->Ln(5);
		$this->Cell(0,5,'Cusco - Urb. Versalles L-23 - San Jeronimo',0,0,'C');
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



$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,0,'PROFORMA',$Borde,0,'C');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,0,$InsCotizacionVehiculo->CveId,$Borde,0,'C');


list($Dia,$Mes,$Ano) = explode("/",$InsCotizacionVehiculo->CveFecha);;
	
$pdf->Ln(5);
     
$pdf->SetFont('Arial','B',8);
$pdf->Cell(120,5,'',$Borde,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(70,5,''.$Dia.' de '.FncConvertirMes($Mes).' de '.$Ano,$Borde,0,'L');

$pdf->Ln(5);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(21,5,utf8_decode('SEÑOR(A):'),$Borde,0,'L');

$pdf->Ln(5);

$pdf->SetFont('Arial','',10);
$pdf->Cell(190,5,rtrim(utf8_decode($InsCotizacionVehiculo->CliNombre).' '.utf8_decode($InsCotizacionVehiculo->CliApellidoPaterno).' '.utf8_decode($InsCotizacionVehiculo->CliApellidoMaterno)),$Borde,0,'L');

$pdf->Ln(5);

$pdf->SetFont('Arial','',8);
$pdf->Cell(190,5,$InsCotizacionVehiculo->TdoNombre.': '.$InsCotizacionVehiculo->CliNumeroDocumento,$Borde,0,'L');


$pdf->Ln(5);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(190,5,'PRESENTE.- ',$Borde,0,'L');

$pdf->Ln(5);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(190,5,'ESTIMADO CLIENTE: ',$Borde,0,'L');

$pdf->Ln(6);


$pdf->SetFont('Arial','',10);
$pdf->Cell(190,5,'La presente tiene por objeto saludarle y a la vez adjuntar el detalle de la cotizacion  nuestro nuevo modelo',$Borde,0,'L');

$pdf->Ln(5);

 $pdf->SetFont('Arial','',10);
$pdf->Cell(190,5,''.$InsCotizacionVehiculo->VmaNombre.' '.$InsCotizacionVehiculo->VmoNombre.' '.$InsCotizacionVehiculo->VveNombre.utf8_decode(' - AÑO ').$InsCotizacionVehiculo->CveAnoModelo,$Borde,0,'L');
 

$pdf->Ln(10);	

if(!empty($InsCotizacionVehiculo->CveFoto)){
	
	
	//$pdf->Image('../../../subidos/vehiculo_version_fotos/'.utf8_decode($InsCotizacionVehiculo->VveFoto),70,null,70,45,'jpg');
	$pdf->Image('../../../subidos/cotizacion_vehiculo_fotos/'.utf8_decode($InsCotizacionVehiculo->CveFoto),70,null,70);
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(70,5,'',$Borde,0,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(60,5,'* Foto referencial',$Borde,0,'L');
	
}else if(!empty($InsCotizacionVehiculo->VveFoto)){


	//$pdf->Image('../../../subidos/vehiculo_version_fotos/'.utf8_decode($InsCotizacionVehiculo->VveFoto),70,null,70,45,'jpg');
	$pdf->Image('../../../subidos/vehiculo_version_fotos/'.utf8_decode($InsCotizacionVehiculo->VveFoto),70,null,70);
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(70,5,'',$Borde,0,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(60,5,'* Foto referencial',$Borde,0,'L');

}



$pdf->Ln(5);

$pdf->SetFont('Arial','',10);
$pdf->Cell(190,5,''.$InsCotizacionVehiculo->VmaNombre.' '.$InsCotizacionVehiculo->VmoNombre.' '.$InsCotizacionVehiculo->VveNombre." ".$InsCotizacionVehiculo->CveAdicional." ".(' - FABRICACION ').$InsCotizacionVehiculo->CveAnoFabricacion." - ".utf8_decode(' - MODELO ').$InsCotizacionVehiculo->CveAnoModelo,$Borde,0,'C');
 




if($InsCotizacionVehiculo->MonId<>$EmpresaMonedaId){
				if(!empty($InsCotizacionVehiculo->CveTipoCambio)){
					
					$InsCotizacionVehiculo->CveTotal = round($InsCotizacionVehiculo->CveTotal / $InsCotizacionVehiculo->CveTipoCambio,2);
					$InsCotizacionVehiculo->CvePrecio = round($InsCotizacionVehiculo->CvePrecio / $InsCotizacionVehiculo->CveTipoCambio,2);
					$InsCotizacionVehiculo->CveDescuento = round($InsCotizacionVehiculo->CveDescuento / $InsCotizacionVehiculo->CveTipoCambio,2);
					
				}else{
					
					$InsCotizacionVehiculo->CveTotal = 0;
					$InsCotizacionVehiculo->CvePrecio = 0;
					$InsCotizacionVehiculo->CveDescuento = 0;
					
				}
			}
			
			
$pdf->Ln(5);




$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,5,'--------------------------------------------------------------------------------------------------------',$Borde,1,'C');



$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,5,'',$Borde,0,'R');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(90,5,'PRECIO LISTA:'.$InsCotizacionVehiculo->MonSimbolo." ".number_format($InsCotizacionVehiculo->CvePrecio,2),$Borde,0,'L');	
$pdf->SetFont('Arial','B',12);
$pdf->Cell(25,5,'Inc. IGV ',$Borde,1,'C');




if(!empty($InsCotizacionVehiculo->CveDescuento)){
	
	//$pdf->Ln(1);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(40,5,'',$Borde,0,'R');
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(90,5,'PRECIO C/ DSCTO. : '.$InsCotizacionVehiculo->MonSimbolo." ".number_format($InsCotizacionVehiculo->CveTotal,2),$Borde,0,'L');	
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(25,5,'',$Borde,1,'R');

}	

$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,5,'--------------------------------------------------------------------------------------------------------',$Borde,1,'C');



			
	$pdf->Ln(5);		



if(!empty($ArrVehiculoCaracteristicaSecciones)){
	$secciones=0;
	foreach($ArrVehiculoCaracteristicaSecciones as $DatVehiculoCaracteristicaSeccion){
		
	
	
				if(!empty($InsCotizacionVehiculo->VehiculoVersionCaracteristica)){	
					foreach($InsCotizacionVehiculo->VehiculoVersionCaracteristica as $DatVehiculoVersionCaracteristica ){

						if($DatVehiculoVersionCaracteristica->VcsId == $DatVehiculoCaracteristicaSeccion->VcsId){
							$secciones++;
							break;
						}
					}
				}
				
	}
}

if(!empty($ArrVehiculoCaracteristicaSecciones)){
	$i=1;
	foreach($ArrVehiculoCaracteristicaSecciones as $DatVehiculoCaracteristicaSeccion){
		
	$MostrarSeccion = false;
	
				if(!empty($InsCotizacionVehiculo->VehiculoVersionCaracteristica)){	
					foreach($InsCotizacionVehiculo->VehiculoVersionCaracteristica as $DatVehiculoVersionCaracteristica ){

						if($DatVehiculoVersionCaracteristica->VcsId == $DatVehiculoCaracteristicaSeccion->VcsId){
							$MostrarSeccion = true;
							break;
						}
					}
				}

	if($MostrarSeccion){

	
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(3,7,'',$Borde,0,'R');
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell((($InsCotizacionVehiculo->VmaId=="VMA-10018")?65:125),7,stripslashes(($DatVehiculoCaracteristicaSeccion->VcsNombre)),1,0,'L');	
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell((($InsCotizacionVehiculo->VmaId=="VMA-10018")?125:65),7,stripslashes(($InsCotizacionVehiculo->VveNombre)),1,1,'C');
			
			
			
							
							
				if(!empty($InsCotizacionVehiculo->VehiculoVersionCaracteristica)){	
					foreach($InsCotizacionVehiculo->VehiculoVersionCaracteristica as $DatVehiculoVersionCaracteristica ){

						if($DatVehiculoVersionCaracteristica->VcsId == $DatVehiculoCaracteristicaSeccion->VcsId){
							
							//$palabras = explode(" ",$DatVehiculoVersionCaracteristica->VvcValor);
							
							//if(strlen($DatVehiculoVersionCaracteristica->VvcValor)>50){
								
							$DatVehiculoVersionCaracteristica->VvcValor = stripslashes($DatVehiculoVersionCaracteristica->VvcValor);
							$DatVehiculoVersionCaracteristica->VvcValor = utf8_decode($DatVehiculoVersionCaracteristica->VvcValor);
							
							$DatVehiculoVersionCaracteristica->VvcDescripcion = stripslashes($DatVehiculoVersionCaracteristica->VvcDescripcion);
							$DatVehiculoVersionCaracteristica->VvcDescripcion = utf8_decode($DatVehiculoVersionCaracteristica->VvcDescripcion);
											
							if(strlen(trim($DatVehiculoVersionCaracteristica->VvcValor))>130){
								
								$valor1 = "";
								$valor2 = "";
								$valor3 = "";
								$valor4 = "";
								
								$pdf->SetFont('Arial','',6);
								$pdf->Cell(3,5,'',$Borde,0,'R');
								$pdf->SetFont('Arial','',6);
								$pdf->Cell((($InsCotizacionVehiculo->VmaId=="VMA-10018")?65:125),5,(($DatVehiculoVersionCaracteristica->VvcDescripcion)),1,0,'L');	
								
								
								
								$valor1 = substr($DatVehiculoVersionCaracteristica->VvcValor,0,130);
								$valor2 = substr($DatVehiculoVersionCaracteristica->VvcValor,130,230);
								$valor3 = substr($DatVehiculoVersionCaracteristica->VvcValor,230,330);
								$valor4 = substr($DatVehiculoVersionCaracteristica->VvcValor,330,430);
									
									
								$pdf->SetFont('Arial','',6);
								$pdf->Cell((($InsCotizacionVehiculo->VmaId=="VMA-10018")?65:125),5,$valor1,1,1,'C');


								if(!empty($valor2)){
									$pdf->SetFont('Arial','',6);
									$pdf->Cell(3,5,'',$Borde,0,'R');
									$pdf->SetFont('Arial','',6);
									$pdf->Cell((($InsCotizacionVehiculo->VmaId=="VMA-10018")?65:125),5,'',1,0,'L');	
									$pdf->SetFont('Arial','',6);
									$pdf->Cell((($InsCotizacionVehiculo->VmaId=="VMA-10018")?125:65),5,stripslashes(($valor2)),1,1,'C');
								}
								
								
								if(!empty($valor3)){
									$pdf->SetFont('Arial','',6);
									$pdf->Cell(3,5,'',$Borde,0,'R');
									$pdf->SetFont('Arial','',6);
									$pdf->Cell((($InsCotizacionVehiculo->VmaId=="VMA-10018")?65:125),5,'',1,0,'L');	
									$pdf->SetFont('Arial','',6);
									$pdf->Cell((($InsCotizacionVehiculo->VmaId=="VMA-10018")?125:65),5,stripslashes(($valor3)),1,1,'C');
								}
								
								
								if(!empty($valor4)){
									$pdf->SetFont('Arial','',6);
									$pdf->Cell(3,5,'',$Borde,0,'R');
									$pdf->SetFont('Arial','',6);
									$pdf->Cell((($InsCotizacionVehiculo->VmaId=="VMA-10018")?65:125),5,'',1,0,'L');	
									$pdf->SetFont('Arial','',6);
									$pdf->Cell((($InsCotizacionVehiculo->VmaId=="VMA-10018")?125:65),5,stripslashes(($valor4)),1,1,'C');
								}
								
								
							}else{
								
											
								$pdf->SetFont('Arial','',6);
								$pdf->Cell(3,5,'',$Borde,0,'R');
								$pdf->SetFont('Arial','',6);
								$pdf->Cell((($InsCotizacionVehiculo->VmaId=="VMA-10018")?65:125),5,stripslashes(($DatVehiculoVersionCaracteristica->VvcDescripcion)),1,0,'L');	
								$pdf->SetFont('Arial','',6);
								$pdf->Cell((($InsCotizacionVehiculo->VmaId=="VMA-10018")?125:65),5,stripslashes(($DatVehiculoVersionCaracteristica->VvcValor)),1,1,'C');


							}
							
if($InsCotizacionVehiculo->VmaId=="VMA-10018"){
			$Garantia = $DatVehiculoVersionCaracteristica->VvcValor;
		}else{
			$Garantia = "";
		}
						}	
					}
				}	

	   if($secciones <> $i){
		   
			$pdf->Ln(3);
			
	   }


		$i++;
	}


	}
}

        
		
		
		
		

$pdf->Ln(3);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(190,5,'PRECIO INCLUYE:',$Borde,1,'L');

if(!empty($InsCotizacionVehiculo->CotizacionVehiculoCondicionVenta)){	
	foreach($InsCotizacionVehiculo->CotizacionVehiculoCondicionVenta as $DatCotizacionVehiculoCondicionVenta ){

		$pdf->SetFont('Arial','',10);
		$pdf->Cell(190,5,' - '.utf8_decode($DatCotizacionVehiculoCondicionVenta->CovNombre),$Borde,1,'L');
				
	}
}				

if(!empty($InsCotizacionVehiculo->CveCondicionVentaOtro)){
	
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(190,5,' - '.utf8_decode($InsCotizacionVehiculo->CveCondicionVentaOtro),$Borde,1,'L');
	
}




//OBSERVACIONES
$pdf->Ln(5);

//$InsCotizacionVehiculo->CveObservacion =str_replace("</p>",chr(13),$InsCotizacionVehiculo->CveObservacion);
$InsCotizacionVehiculo->CveObservacion = strip_tags($InsCotizacionVehiculo->CveObservacion,"");
//$InsCotizacionVehiculo->CveObservacion =str_replace("\n",' ',$InsCotizacionVehiculo->CveObservacion);
		
if(!empty($InsCotizacionVehiculo->CveObservacion)){

$pdf->SetFont('Arial','B',10);
		$pdf->Cell(25,5,'OBSERVACIONES:',$Borde,1,'L');
				
	$LimitePalabras = 15;
	
	
	$ArrObservacion = explode(" ",$InsCotizacionVehiculo->CveObservacion);
	$TotalPalabras = count($ArrObservacion);
	
	if($TotalPalabras>$LimitePalabras){

		$Observacion = "";
		$Contador = $LimitePalabras;
		
		for($i=0;$i<=$TotalPalabras;$i++){
			
			$Observacion .= $ArrObservacion[$i]." ";
			
			if($i == $Contador){

				
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(152,5,($Observacion),$Borde,1,'L');
			
				$Contador = $Contador + $LimitePalabras;
				
				$Observacion = "";
				
			}
			
			
			
		}
		
			
			
		
	}else{
		
		//$pdf->SetFont('Arial','B',10);
		//$pdf->Cell(25,5,'OBSERVACIONES:',$Borde,1,'L');
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(100,5,utf8_decode($InsCotizacionVehiculo->CveObservacion),$Borde,0,'L');
		//$InsCotizacionVehiculo->CveObservacion=str_replace("\n",' ',$InsCotizacionVehiculo->CveObservacion);
		
	}
	
	
	
	
	
//	if(strlen($InsCotizacionVehiculo->CveObservacion)>70){
//
//		$vueltas = round(strlen($InsCotizacionVehiculo->CveObservacion)/75)+1;
//
//		$primera = 0;
//		for($i=0;$i<$vueltas;$i++){
//
//			$Observacion = substr($InsCotizacionVehiculo->CveObservacion,$primera,75);
//			
//			$pdf->SetFont('Arial','B',10);
//			$pdf->Cell(25,5,($primera==0)?'OBSERVACIONES:':'',$Borde,1,'L');
//			$pdf->SetFont('Arial','',8);
//			$pdf->Cell(152,5,($Observacion),$Borde,1,'L');
//			$pdf->Ln(1);
//			$primera = $primera + 75;
//
//		}
//
//	}else{
//
//		$pdf->SetFont('Arial','B',10);
//		$pdf->Cell(25,5,'OBSERVACIONES:',$Borde,1,'L');
//		$pdf->SetFont('Arial','',8);
//		$pdf->Cell(100,5,($InsCotizacionVehiculo->CveObservacion),$Borde,0,'L');
//		$InsCotizacionVehiculo->CveObservacion=str_replace("\n",' ',$InsCotizacionVehiculo->CveObservacion);
//		
//	}

	$pdf->Ln(7);
}





$pdf->Ln(3);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(190,5,'ENTREGA:',$Borde,1,'L');

$pdf->SetFont('Arial','',10);
$pdf->Cell(190,5,utf8_decode('- La entrega   esta  sujeta a  la  disponibilidad  de  stock  y colores al momento de su decisión  de  compra. Confirmada'),$Borde,1,'L');
$pdf->Cell(190,5,utf8_decode('la disponibilidad de stock asignado el vehículo solicitado, el cliente deberá proporcionar a C & C S.A.C los documentos'),$Borde,1,'L');
$pdf->Cell(190,5,utf8_decode('necesarios a  fin de  iniciar  ante   Registros  Públicos  el registro vehicular de su propiedad. C & C S.A.C le brindará el '),$Borde,1,'L');

$pdf->Cell(190,5,utf8_decode('detalle oportuno de los documentos que se requiere para dicho propósito.'),$Borde,1,'L');
$pdf->Cell(190,5,utf8_decode('El registro vehicular  demora  alrededor de 15 (quince) dias útiles para la entrega de la tarjeta de propiedad y placas de'),$Borde,1,'L');
$pdf->Cell(190,5,utf8_decode('rodaje, este plazo  rige  luego  de  presentar el expediente  ante Registros  Públicos. Si existiera alguna observación de'),$Borde,1,'L');
$pdf->Cell(190,5,utf8_decode('Registros  Públicos durante el  trámite del  registro  vehicular  que  ocasione  demora  en  la entrega  del  vehiculo, este'),$Borde,1,'L');
$pdf->Cell(190,5,utf8_decode('retraso no sera imputable a C & C S.A.C. '),$Borde,1,'L');


if(!empty($Garantia)){
	
	$pdf->Ln(2);
	$pdf->Cell(190,5,utf8_decode($Garantia),$Borde,1,'L');
	
}else{
	
	$pdf->Ln(2);
	$pdf->Cell(190,5,utf8_decode("- Garantía 05 años ó 100,000 kilómetros, lo que ocurra primero"),$Borde,1,'L');
	
}


if(!empty($InsCotizacionVehiculo->CveFechaVigencia)){
	
	$pdf->Ln(3);
	
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(190,5,'VIGENCIA:',$Borde,1,'L');
	
	$pdf->Ln(2);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(190,5,utf8_decode('- Cotización válida hasta el '.$InsCotizacionVehiculo->CveFechaVigencia),$Borde,1,'L');

}

if(!empty($InsCotizacionVehiculo->CotizacionVehiculoFoto)){
 
 	$pdf->Ln(3);
	
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(190,5,'FOTOS ADICIONALES:',$Borde,1,'L');
	
	foreach($InsCotizacionVehiculo->CotizacionVehiculoFoto as $DatCotizacionVehiculoFoto){
		$pdf->Ln(3);
		//$this->Image($img, $x, $y, $w, $h);
		$pdf->Image('../../../subidos/cotizacion_vehiculo_fotos/'.utf8_decode($DatCotizacionVehiculoFoto->CvfArchivo),null,null,NULL,20,NULL,NULL,NULL,true,NULL,NULL,NULL,NULL,0,0);
		
			
	}
		
}




$pdf->Ln(3);

$pdf->SetFont('Arial','',10);
$pdf->Cell(190,5,utf8_decode('Agradeciendo de antemano la atención a la presente, quedamos de usted.'),$Borde,1,'L');









$pdf->Ln(3);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(190,5,'ATENTAMENTE:',$Borde,1,'L');




$pdf->Ln(2);

//$pdf->Write(5,'A continuación mostramos una imagen ');

//if($InsCotizacionVehiculo->CveFirmaDigital==1){
$pdf->Ln(20);	
	  if(!empty($InsCotizacionVehiculo->PerFirma)){
		//$pdf->Cell(40,20);  
	  $pdf->Image('../../../subidos/personal_firmas/'.$InsCotizacionVehiculo->PerFirma,120,null,50,50,'JPG');
//	  $pdf->Image('leon.jpg' , 80 ,22, 35 , 38,'JPG', 
	  }
  
//}

$pdf->Ln(1);		

$pdf->SetFont('Arial','B',10);
$pdf->Cell(90,5,'' ,$Borde,0,'L'); 	
$pdf->Cell(100,5,'___________________________________' ,$Borde,1,'C'); 	

$pdf->Cell(90,5,'' ,$Borde,0,'L'); 	
$pdf->Cell(100,5,utf8_decode($InsCotizacionVehiculo->PerNombre.' '.$InsCotizacionVehiculo->PerApellidoPaterno.' '.$InsCotizacionVehiculo->PerApellidoMaterno),$Borde,1,'C'); 	

$pdf->Cell(90,5,'' ,$Borde,0,'L'); 
$pdf->Cell(100,5,'Asesor de Ventas' ,$Borde,1,'C'); 

$pdf->Cell(90,5,'' ,$Borde,0,'L'); 
$pdf->Cell(100,5,'Telefono: '.$InsCotizacionVehiculo->PerTelefono ,$Borde,1,'C'); 

$pdf->Cell(90,5,'' ,$Borde,0,'L'); 
$pdf->Cell(100,5,'Celular: '.$InsCotizacionVehiculo->PerCelular ,$Borde,1,'C'); 

$pdf->Cell(90,5,'' ,$Borde,0,'L'); 
$pdf->Cell(100,5,'Email: '.$InsCotizacionVehiculo->PerEmail ,$Borde,1,'C'); 



          

//$pdf->Output($InsCotizacionVehiculo->CveId.".pdf","D");
$pdf->Output($InsCotizacionVehiculo->CveId.".pdf");
//$pdf->Output();

?>