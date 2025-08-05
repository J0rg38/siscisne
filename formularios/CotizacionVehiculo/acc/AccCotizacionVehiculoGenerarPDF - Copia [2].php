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
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');

$InsCotizacionVehiculo = new ClsCotizacionVehiculo();
$InsVehiculoCaracteristicaSeccion = new ClsVehiculoCaracteristicaSeccion();
$InsVehiculoModelo = new ClsVehiculoModelo();
$InsVehiculoVersion = new ClsVehiculoVersion();

$InsCotizacionVehiculo->CveId = $GET_id;
$InsCotizacionVehiculo->MtdObtenerCotizacionVehiculo();

///MtdObtenerVehiculoCaracteristicaSecciones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VcsId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL)
$ResVehiculoCaracteristicaSeccion = $InsVehiculoCaracteristicaSeccion->MtdObtenerVehiculoCaracteristicaSecciones(NULL,NULL,'VcsId','ASC',NULL,1);
$ArrVehiculoCaracteristicaSecciones = $ResVehiculoCaracteristicaSeccion['Datos'];

//MtdObtenerVehiculoVersiones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVigenciaVenta=NULL,$oEstado=NULL)
$RepVehiculoVersion = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,"VveNombre","ASC",NULL,NULL,$InsCotizacionVehiculo->VmoId,1,1);
$ArrVehiculoVersiones = $RepVehiculoVersion['Datos'];

if($InsCotizacionVehiculo->MonId<>$EmpresaMonedaId){
	
	if(!empty($InsCotizacionVehiculo->CveTipoCambio)){
		
		$InsCotizacionVehiculo->CveTotalUnitario = round($InsCotizacionVehiculo->CveTotalUnitario / $InsCotizacionVehiculo->CveTipoCambio,2);
		$InsCotizacionVehiculo->CveTotal = round($InsCotizacionVehiculo->CveTotal / $InsCotizacionVehiculo->CveTipoCambio,2);
		$InsCotizacionVehiculo->CvePrecio = round($InsCotizacionVehiculo->CvePrecio / $InsCotizacionVehiculo->CveTipoCambio,2);
		$InsCotizacionVehiculo->CveDescuento = round($InsCotizacionVehiculo->CveDescuento / $InsCotizacionVehiculo->CveTipoCambio,2);
		
	}else{
		
		$InsCotizacionVehiculo->CveTotal = 0;
		$InsCotizacionVehiculo->CveTotalUnitario = 0;
		$InsCotizacionVehiculo->CvePrecio = 0;
		$InsCotizacionVehiculo->CveDescuento = 0;
		
	}
}
	



class PDF extends FPDF
{
	// Cabecera de página
	function Header(){
		// Logo
		global $InsCotizacionVehiculo;

 //deb($InsCotizacionVehiculo->VmaId);
	  switch($InsCotizacionVehiculo->VmaId){
		  case "VMA-10017":
			$this->Image('../../../imagenes/membretes/cabecera_chevrolet.png',10,8,190);
		  break;
		  
		  case "VMA-10018":
			$this->Image('../../../imagenes/membretes/cabecera_isuzu.png',10,8,190);
		  break;
		  
		  default:
			$this->Image('../../../imagenes/membretes/cabecera_simple.png',10,8,190);
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
		$this->SetFont('Arial','',6);
	
		global $EmpresaNombre;
  		global $EmpresaCodigo;
       
		// Título
		$this->Ln(5);
		$this->Cell(0,3,utf8_decode($EmpresaNombre." - R.U.C.: ".$EmpresaCodigo),0,1,'R');
		
		$this->Cell(0,3,utf8_decode($_SESSION['SesionSucursalDepartamento'].": ".$_SESSION['SesionSucursalDireccion']." ".$_SESSION['SesionSucursalProvincia']." -  ".$_SESSION['SesionSucursalDistrito']),0,1,'R');
	
		if(!empty($_SESSION['SesionSucursalTelefono'])){
			$this->Cell(0,3,"Telefono: ".$_SESSION['SesionSucursalTelefono'],0,0,'R');
		}
        
        if(!empty($_SESSION['SesionSucursalEmail'])){
			$this->Cell(0,3,"Email: ".$_SESSION['SesionSucursalEmail'],0,0,'R');
		}
         
		// Salto de línea
		$this->Ln(20);		
		
	}
	
}

$Borde = 1;

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,0,"COTIZACION ".$InsCotizacionVehiculo->CveId,$Borde,0,'C');

list($Dia,$Mes,$Ano) = explode("/",$InsCotizacionVehiculo->CveFecha);;
	



$pdf->Ln(5);
//utf8_decode
$pdf->SetFont('Arial','B',8);
$pdf->Cell(28,5,('Fecha de Cotizacion:'),$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(67,5,($InsCotizacionVehiculo->CveFecha),$Borde,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(28,5,(''),$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(67,5,(''),$Borde,0,'L');

$pdf->Ln(5);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(190,5,('VEHICULO'),1,0,'L');


$pdf->Ln(5);

$Anos = '';
if(!empty($InsCotizacionVehiculo->CveAnoFabricacion)){
	$Anos .= '- Fabricacion '.$InsCotizacionVehiculo->CveAnoFabricacion;
}

if(!empty($InsCotizacionVehiculo->CveAnoModelo)){
	$Anos .= '- Modelo '.$InsCotizacionVehiculo->CveAnoModelo;	
}
		
		
$pdf->SetFont('Arial','B',8);
$pdf->Cell(28,5,('Modelo/Año:'),$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(67,5,($InsCotizacionVehiculo->VmaNombre.' '.$InsCotizacionVehiculo->VmoNombre.' '.$InsCotizacionVehiculo->VveNombre.' '.$Anos),$Borde,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(28,5,(''),$Borde,0,'L');


$pdf->Ln(5);

$Adicionales = '';

if(!empty($InsCotizacionVehiculo->CotizacionVehiculoObsequio)){
	foreach($InsCotizacionVehiculo->CotizacionVehiculoObsequio as $DatCotizacionVehiculoObsequio){
 
	$Adicionales .= $DatCotizacionVehiculoObsequio->ObsNombre.'';

	}
}
			
$Adicionales .= $InsCotizacionVehiculo->CveAdicional;

if($InsCotizacionVehiculo->CveGLP=="Si"){

	$Adicionales .= 'Incluye GLP';

}else{

}
			
//utf8_decode
$pdf->SetFont('Arial','B',8);
$pdf->Cell(28,5,('Adicionales:'),$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(67,5,($Adicionales),$Borde,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(28,5,(''),$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(67,5,(''),$Borde,0,'L');




$pdf->Ln(5);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(95,5,('CLIENTE'),1,0,'L');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(95,5,('ASESOR DE VENTAS'),1,0,'L');


$pdf->Ln(5);
//utf8_decode
$pdf->SetFont('Arial','B',8);
$pdf->Cell(28,5,('RUC/DNI:'),$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(67,5,($InsCotizacionVehiculo->TdoNombre." - ".$InsCotizacionVehiculo->CliNumeroDocumento),$Borde,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(28,5,('Nombres:'),$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(67,5,($InsCotizacionVehiculo->PerNombre." ".$InsCotizacionVehiculo->PerApellidoPaterno." ".$InsCotizacionVehiculo->PerApellidoMaterno),$Borde,0,'L');

$pdf->Ln(5);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(28,5,('Nombres:'),$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(67,5,($InsCotizacionVehiculo->CliNombre." ".$InsCotizacionVehiculo->CliApellidoPaterno." ".$InsCotizacionVehiculo->CliApellidoMaterno),$Borde,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(28,5,('Contacto:'),$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(67,5,("Tel.: ".$InsCotizacionVehiculo->PerTelefono." / Cel.:".$InsCotizacionVehiculo->PerCelular),$Borde,0,'L');

$pdf->Ln(5);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(28,5,('Celular:'),$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(67,5,($InsCotizacionVehiculo->CliCelular),$Borde,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(28,5,('Email:'),$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(67,5,($InsCotizacionVehiculo->PerEmail),$Borde,0,'L');


$pdf->Ln(5);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(95,5,('PRECIO'),1,0,'L');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(95,5,('FOTOS'),1,0,'L');

$pdf->Ln(5);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(28,5,('Precio Base:'),$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(67,5,($InsCotizacionVehiculo->MonSimbolo.' '.number_format($InsCotizacionVehiculo->CvePrecio,2)),$Borde,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(28,5,(''),$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(67,5,(''),$Borde,0,'L');

$pdf->Ln(5);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(28,5,('Precio Unitario:'),$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(67,5,($InsCotizacionVehiculo->MonSimbolo.' '.number_format($InsCotizacionVehiculo->CveTotalUnitario,2)),$Borde,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(28,5,(''),$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(67,5,(''),$Borde,0,'L');

$pdf->Ln(5);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(28,5,('Cantidad:'),$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(67,5,(number_format($InsCotizacionVehiculo->CveCantidad,2)),$Borde,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(28,5,(''),$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(67,5,(''),$Borde,0,'L');

$pdf->Ln(5);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(28,5,('PRECIO TOTAL:'),$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(67,5,($InsCotizacionVehiculo->MonSimbolo.' '.number_format($InsCotizacionVehiculo->CveTotal,2)),$Borde,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(28,5,(''),$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(67,5,(''),$Borde,0,'L');

$pdf->Ln(5);	

$FotoAX = 30;
$FotoAY = 75;

$FotoBX = 80;
$FotoBY = 75;

$FotoCX = 130;
$FotoCY = 75;

$Saltar1=0;
$Saltar2=0;
$Saltar3=0;

$EspacioFotoReferenciasTexto = 60;

//$InsCotizacionVehiculo->VveFotoLateral="";
//$InsCotizacionVehiculo->VveFotoPosterior="";

if(!empty($InsCotizacionVehiculo->CveFoto) or !empty($InsCotizacionVehiculo->VveFoto)){
	
	if(!empty($InsCotizacionVehiculo->VveFotoLateral)){
		
		if(!empty($InsCotizacionVehiculo->VveFotoPosterior)){
			
			$Saltar1 = 0;
			$Saltar2 = 0;
			$Saltar3 = 1;
			
			$FotoAX = 30;
			$FotoAY = 75;
			
			$FotoBX = 90;
			$FotoBY = 75;
			
			$FotoCX = 140;
			$FotoCY = 75;

			$EspacioFotoReferenciasTexto = 50;
			
		}else{
			
			$Saltar1=0;
			$Saltar2=1;
			$Saltar3=0;
			
			$FotoAX = 60;
			$FotoAY = 75;
			
			$FotoBX = 110;
			$FotoBY = 75;
			
			$FotoCX = 0;
			$FotoCY = 0;
			
			$EspacioFotoReferenciasTexto = 60;
			
		}
		
	}else{
		
		if(!empty($InsCotizacionVehiculo->VveFotoPosterior)){
			
			$Saltar1=0;
			$Saltar2=0;
			$Saltar3=1;

			$FotoAX = 60;
			$FotoAY = 75;
			
			$FotoBX = 0;
			$FotoBY = 0;
			
			$FotoCX = 110;
			$FotoCY = 75;
			
			$EspacioFotoReferenciasTexto = 60;
			
		}else{
			
			$Saltar1=1;
			$Saltar2=0;
			$Saltar3=0;
			
			$FotoAX = 85;
			$FotoAY = 75;
			
			$FotoBX = 0;
			$FotoBY = 0;
			
			$FotoCX = 0;
			$FotoCY = 0;
			
			$EspacioFotoReferenciasTexto = 80;
			
		}
		
	}
	
	
}else{
	
	if(!empty($InsCotizacionVehiculo->VveFotoLateral)){
		
		if(!empty($InsCotizacionVehiculo->VveFotoPosterior)){
			
			$Saltar1=0;
			$Saltar2=0;
			$Saltar3=1;
			
			
			$FotoAX = 0;
			$FotoAY = 0;
			
			$FotoBX = 60;
			$FotoBY = 75;
			
			$FotoCX = 110;
			$FotoCY = 75;
			
			$EspacioFotoReferenciasTexto = 60;
			
		}else{
			
			$Saltar1=0;
			$Saltar2=1;
			$Saltar3=0;
			
			$FotoAX = 0;
			$FotoAY = 0;
			
			$FotoBX = 85;
			$FotoBY = 75;
			
			$FotoCX = 0;
			$FotoCY = 0;
			
			$EspacioFotoReferenciasTexto = 80;
			
		}
		
	}else{
	
		if(!empty($InsCotizacionVehiculo->VveFotoPosterior)){
			
			$Saltar1=0;
			$Saltar2=0;
			$Saltar3=1;
			
			$FotoAX = 0;
			$FotoAY = 0;
			
			$FotoBX = 0;
			$FotoBY = 0;
			
			$FotoCX = 85;
			$FotoCY = 75;
			
			$EspacioFotoReferenciasTexto = 80;
			
		}else{
			
			$Saltar1=0;
			$Saltar2=0;
			$Saltar3=0;
			
			$FotoAX = 0;
			$FotoAY = 0;
			
			$FotoBX = 0;
			$FotoBY = 0;
			
			$FotoCX = 0;
			$FotoCY = 0;
			
		}
		
	}
}
/*
$FotoAX = 30;
$FotoAY = 70;

$FotoBX = 80;
$FotoBY = 70;

$FotoCX = 130;
$FotoCY = 70;*/

if(!empty($InsCotizacionVehiculo->CveFoto)){
	
	//Image($file, $x=null, $y=null, $w=0, $h=0, $type='', $link='')
	$pdf->Image('../../../subidos/vehiculo_version_fotos/'.utf8_decode($InsCotizacionVehiculo->CveFoto),130,85,NULL,18);
	
}else if(!empty($InsCotizacionVehiculo->VveFoto)){

	$pdf->Image('../../../subidos/vehiculo_version_fotos/'.utf8_decode($InsCotizacionVehiculo->VveFoto),130,85,NULL,18);

}
//
//if(!empty($InsCotizacionVehiculo->VveFotoLateral)){
//
//	$pdf->Image('../../../subidos/vehiculo_version_fotos/'.utf8_decode($InsCotizacionVehiculo->VveFotoLateral),$FotoBX,$FotoBY,NULL,18);
//	
//}
//
//if(!empty($InsCotizacionVehiculo->VveFotoPosterior)){
//	
//	$pdf->Image('../../../subidos/vehiculo_version_fotos/'.utf8_decode($InsCotizacionVehiculo->VveFotoPosterior),$FotoCX,$FotoCY,NULL,18);
//	
//}

//$pdf->SetFont('Arial','',8);
//$pdf->Cell(190,30,'',$Borde,1,'L');
/////$pdf->Ln(10);
//
//$pdf->SetFont('Arial','',8);
//$pdf->Cell($EspacioFotoReferenciasTexto,3,'',$Borde,0,'L');

if(!empty($InsCotizacionVehiculo->CveFoto) or !empty($InsCotizacionVehiculo->VveFoto)){

	$pdf->SetFont('Arial','',6);
	$pdf->Cell(120,3,'* Foto referencial',$Borde,$Saltar1,'C');
	
}

if(!empty($InsCotizacionVehiculo->VveFotoLateral)){

	$pdf->SetFont('Arial','',6);
	$pdf->Cell(30,3,'* Foto Lateral',$Borde,$Saltar2,'C');

}

if(!empty($InsCotizacionVehiculo->VveFotoPosterior)){

	$pdf->SetFont('Arial','',6);
	$pdf->Cell(30,3,'* Foto Posterior',$Borde,$Saltar3,'C');

}

//$pdf->Ln(10);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(190,3,'',$Borde,1,'L');
//	
	
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
			
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(190,3,$DatVehiculoCaracteristicaSeccion->VcsNombre,1,1,'C');

			if(!empty($InsCotizacionVehiculo->VehiculoVersionCaracteristica)){	
					foreach($InsCotizacionVehiculo->VehiculoVersionCaracteristica as $DatVehiculoVersionCaracteristica ){
						
						if($DatVehiculoVersionCaracteristica->VcsId == $DatVehiculoCaracteristicaSeccion->VcsId){
							
							$pdf->SetFont('Arial','',6);
							$pdf->Cell(100,3,utf8_decode(stripslashes($DatVehiculoVersionCaracteristica->VvcDescripcion)),1,0,'R');
							
							if($InsCotizacionVehiculo->VmaId=="VMA-10018"){
								$Garantia = $DatVehiculoVersionCaracteristica->VvcValor;
							}else{
								$Garantia = "";
							}
						
							$pdf->SetFont('Arial','',6);
							$pdf->Cell(90,3,utf8_decode(stripslashes($DatVehiculoVersionCaracteristica->VvcValor)),1,1,'L');
							
				
						}	
					}
				}	
				
	$i++;
	}
	
	
		}
}			

//deb($ArrVehiculoVersiones);

if(!empty($InsCotizacionVehiculo->CveAnoModelo)){
	
	if(!empty($ArrVehiculoVersiones)){

		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(190,3,'',$Borde,1,'L');
	
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(190,5,'Versiones:',$Borde,1,'L');

	}
	
	$AnchoAplicar = 0;
	$TotalAnchoPagina = 190;
	$AnchoActual = 0;
	$Diferencia = 0;
	
	$Versiones = count($ArrVehiculoVersiones);
	$AnchoActual = ($Versiones * 40) + 50;
	
	
	$Diferencia = $TotalAnchoPagina - $AnchoActual;
	$AnchoAplicar = $Diferencia/2;
	$AnchoAplicar = round($AnchoAplicar,0);
	
	$ArrCaracteristicas = array();
	

	
	$TotalVersiones = 1;
	
	$pdf->SetFont('Arial','',6);
	$pdf->Cell($AnchoAplicar,5,"",$Borde,0,'L');	
	
	
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(50,5,utf8_decode("Características"),1,0,'R');
			
	 if(!empty($ArrVehiculoVersiones)){
        foreach($ArrVehiculoVersiones as $DatVehiculoVersion){
			
	
			
	$VehiculoVersionCategoria = "";
	 
	switch($InsCotizacionVehiculo->VmaId){
		  case "VMA-10017":
		  	$VehiculoVersionCategoria = "VCS-10002";
			
		  break;
		  
		  case "VMA-10018":
				$VehiculoVersionCategoria = "VCS-10010";
		  break;
		  
		  default:
			$VehiculoVersionCategoria = "VCS-10002";
		  break;
	  }
			$InsVehiculoVersionCaracteristica = new ClsVehiculoVersionCaracteristica();
            $ResVehiculoVersionCaracteristica = $InsVehiculoVersionCaracteristica->MtdObtenerVehiculoVersionCaracteristicas(NULL,NULL,'VvcId','Desc',NULL,$DatVehiculoVersion->VveId,$InsCotizacionVehiculo->CveAnoModelo,$VehiculoVersionCategoria);
            $ArrVehiculoVersionCaracteristicas = $ResVehiculoVersionCaracteristica['Datos'];
			
			$registro = 1;
			$caracteristicas = 1;
			if(!empty($ArrVehiculoVersionCaracteristicas)){
				
				foreach($ArrVehiculoVersionCaracteristicas as $DatVehiculoVersionCaracteristica){
					
					$ArrCaracteristicas[$DatVehiculoVersion->VveId][$registro] = $DatVehiculoVersionCaracteristica->VvcValor;
					$ArrCaracteristicasDescripcion[$registro]['Campo'] = $DatVehiculoVersionCaracteristica->VvcDescripcion;
					
					$registro++;
					$caracteristicas++;
					
				}
				
				//if($DatVehiculoVersion->VveId==$InsCotizacionVehiculo->VveId){
			   	$pdf->SetFont('Arial','B',6);
				$pdf->Cell(40,5,$DatVehiculoVersion->VveNombre,1,((count($ArrVehiculoVersiones)==$TotalVersiones)?1:0),'C');
				//<img src="../../imagenes/icon_pin45.png" width="15" height="15" valing="absmiddle" />
				//}
       
			}
			$TotalVersiones++;
			
        }
    }
	
	$pdf->Ln(1);
	
	for($i=1;$i<($registro);$i++){
		
		$TotalVersiones = 1;
		
		$pdf->SetFont('Arial','',6);
		$pdf->Cell($AnchoAplicar,3,"",$Borde,0,'L');	
			
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(50,3,utf8_decode($ArrCaracteristicasDescripcion[$i]['Campo']),0,0,'R');	
			
				
		 if(!empty($ArrVehiculoVersiones)){
			foreach($ArrVehiculoVersiones as $DatVehiculoVersion){
				
				//MtdObtenerVehiculoVersionCaracteristicas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VvcId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoVersion=NULL,$oAnoModelo=NULL,$oSeccion=NULL,$oVehiculoModelo=NULL) 
//				$InsVehiculoVersionCaracteristica = new ClsVehiculoVersionCaracteristica();
//				$ResVehiculoVersionCaracteristica = $InsVehiculoVersionCaracteristica->MtdObtenerVehiculoVersionCaracteristicas(NULL,NULL,'VvcId','Desc',NULL,$DatVehiculoVersion->VveId,$InsCotizacionVehiculo->CveAnoModelo,"VCS-10002");
//				$ArrVehiculoVersionCaracteristicas = $ResVehiculoVersionCaracteristica['Datos'];
				
				$pdf->SetFont('Arial','',6);
				$pdf->Cell(40,3, (($ArrCaracteristicas[$DatVehiculoVersion->VveId][$i]=="X")?"Si":$ArrCaracteristicas[$DatVehiculoVersion->VveId][$i]),0,((count($ArrVehiculoVersiones)==$TotalVersiones
				)?1:0),'C');
				
				//if($DatVehiculoVersion->VveId == $InsCotizacionVehiculo->VveId){
	//				
	//				if(!empty($ArrVehiculoVersionCaracteristicas)){
	//					foreach( $ArrVehiculoVersionCaracteristicas as $DatVehiculoVersionCaracteristica){
	//	
	//						$pdf->Cell(65,5,$DatVehiculoVersionCaracteristica->VvcDescripcion.": ".(($DatVehiculoVersionCaracteristica->VvcValor=="X")?"Si":$DatVehiculoVersionCaracteristica->VvcValor),$Borde,1,'L');
	//						
	//							
	//					}
	//	
	//				}
	//				
	//			}
	
				$TotalVersiones++;
			}
		}
		
	}
	
}

//$pdf->Ln(5);

//PRECIO INCLUYE

if(!empty($InsCotizacionVehiculo->CotizacionVehiculoCondicionVenta) or !empty($InsCotizacionVehiculo->CveCondicionVentaOtro) ){	
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(190,5,(''),$Borde,1,'L');

	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(190,5,'Precio Incluye:',$Borde,1,'L');
	
	if(!empty($InsCotizacionVehiculo->CotizacionVehiculoCondicionVenta)){	
		foreach($InsCotizacionVehiculo->CotizacionVehiculoCondicionVenta as $DatCotizacionVehiculoCondicionVenta ){
	
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(190,3,' - '.utf8_decode($DatCotizacionVehiculoCondicionVenta->CovNombre),$Borde,1,'L');
					
		}
	}				
	
	if(!empty($InsCotizacionVehiculo->CveCondicionVentaOtro)){
		
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(190,3,' - '.utf8_decode($InsCotizacionVehiculo->CveCondicionVentaOtro),$Borde,1,'L');
		
	}


}

//OBSERVACIONES

$InsCotizacionVehiculo->CveObservacion = strip_tags($InsCotizacionVehiculo->CveObservacion,"");

if(!empty($InsCotizacionVehiculo->CveObservacion)){
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(190,5,(''),$Borde,1,'L');
	
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(28,5,'Observaciones:',$Borde,1,'L');
				
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
	
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(100,5,utf8_decode($InsCotizacionVehiculo->CveObservacion),$Borde,0,'L');
		
	}
	

}

$pdf->SetFont('Arial','B',8);
$pdf->Cell(190,3,(''),$Borde,1,'L');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(190,5,'Entrega:',$Borde,1,'L');

/*$Entrega = "- La entrega esta sujeta a la disponibilidad de stock y colores al momento de su decisión de compra. Confirmada la disponibilidad de stock asignado el vehículo solicitado, el cliente deberá proporcionar a ".$EmpresaNombre." los documentos necesarios a fin de iniciar ante Registros Públicos el registro vehicular de su propiedad. ".$EmpresaNombre." le brindará el detalle oportuno de los documentos que se requiere para dicho propósito. El registro vehicular demora alrededor de 15 (quince) dias útiles para la entrega de la tarjeta de propiedad y placas de rodaje, este plazo rige luego de presentar el expediente ante Registros Públicos. Si existiera alguna observación de Registros Públicos durante el trámite del registro vehicular que ocasione demora en la entrega del vehiculo, este retraso no sera imputable a ".$EmpresaNombre.".";

$Entrega = strip_tags($Entrega,"");
$Entrega = utf8_decode($Entrega);*/


$pdf->SetFont('Arial','',6);
$pdf->Cell(190,3,utf8_decode("- La entrega esta sujeta a la  disponibilidad de stock y colores al momento de su decisión de compra. Confirmada la disponibilidad de stock asignado el vehículo solicitado, el cliente deberá proporcionar"),$Borde,1,'L');
$pdf->Cell(190,3,utf8_decode("a ".$EmpresaNombre." los  documentos  necesarios  a  fin de iniciar ante  Registros  Públicos  el registro vehicular de su propiedad. ".$EmpresaNombre." le brindará el detalle  oportuno"),$Borde,1,'L');		
$pdf->Cell(190,3,utf8_decode("de los documentos que se requiere para dicho propósito. El registro vehicular demora alrededor de 15 (quince) dias útiles  para la  entrega  de  la tarjeta de  propiedad y placas de rodaje, este plazo rige "),$Borde,1,'L');			
$pdf->Cell(190,3,utf8_decode("luego  de  presentar  el  expediente  ante  Registros  Públicos. Si  existiera alguna observación de Registros Públicos durante el trámite del  registro  vehicular  que  ocasione  demora  en  la entrega del "),$Borde,1,'L');	
$pdf->Cell(190,3,utf8_decode("vehiculo, este retraso no sera imputable a ".$EmpresaNombre."."),$Borde,1,'L');	
		
		
/*	$LimitePalabras = 30;
	
	$ArrObservacion = explode(" ",$Entrega);
	$TotalPalabras = count($ArrObservacion);
	
	if($TotalPalabras>$LimitePalabras){

		$Observacion = "";
		$Contador = $LimitePalabras;
		
		for($i=0;$i<=$TotalPalabras;$i++){
			
			$Observacion .= $ArrObservacion[$i]." ";
			
			if($i == $Contador){

				$pdf->SetFont('Arial','',6);
				$pdf->Cell(190,5,($Observacion),$Borde,1,'L');
			
				$Contador = $Contador + $LimitePalabras;
				
				$Observacion = "";
				
			}
			
		}
		
	}else{
	
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(190,5,utf8_decode($Entrega),$Borde,0,'L');
		
	}*/
	
	
	
	
if(!empty($Garantia)){
	
	//$pdf->Ln(5);
	$pdf->Cell(190,5,utf8_decode($Garantia),$Borde,1,'L');
	
}else{
	
	//$pdf->Ln(5);
	$pdf->Cell(190,5,utf8_decode("- Garantía 05 años ó 100,000 kilómetros, lo que ocurra primero"),$Borde,1,'L');
	
}

//$pdf->Ln(5);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(190,3,(''),$Borde,1,'L');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(190,5,'Numeros de Cuenta:',$Borde,1,'L');

$pdf->SetFont('Arial','',6);
$pdf->Cell(38,3,'BANCO DE CREDITO DEL PERU',$Borde,0,'L');
$pdf->SetFont('Arial','',6);
$pdf->Cell(38,3,'BANCO CONTINENTAL',$Borde,0,'L');
$pdf->SetFont('Arial','',6);
$pdf->Cell(38,3,'BANCO SCOTIABANK',$Borde,0,'L');
$pdf->SetFont('Arial','',6);
$pdf->Cell(38,3,'INTERBANK',$Borde,0,'L');
$pdf->SetFont('Arial','',6);
$pdf->Cell(38,3,'CAJA AREQUIPA',$Borde,1,'L');

$pdf->SetFont('Arial','',6);
$pdf->Cell(38,3,'SOLES	215-1603833-0-49',$Borde,0,'L');
$pdf->SetFont('Arial','',6);
$pdf->Cell(38,3,'SOLES	226-01000214118',$Borde,0,'L');
$pdf->SetFont('Arial','',6);
$pdf->Cell(38,3,'DOLARES	3037125',$Borde,0,'L');
$pdf->SetFont('Arial','',6);
$pdf->Cell(38,3,'DOLARES	325-300046878-8',$Borde,0,'L');
$pdf->SetFont('Arial','',6);
$pdf->Cell(38,3,'DOLARES	00053010602110102003',$Borde,1,'L');

$pdf->SetFont('Arial','',6);
$pdf->Cell(38,3,'DOLARES	215-1611248-1-58',$Borde,0,'L');
$pdf->SetFont('Arial','',6);
$pdf->Cell(38,3,'DOLARES	220-150100081187',$Borde,0,'L');
$pdf->SetFont('Arial','',6);
$pdf->Cell(38,3,'',$Borde,0,'L');
$pdf->SetFont('Arial','',6);
$pdf->Cell(38,3,'CODIGO RECAUDO	07621',$Borde,0,'L');
$pdf->SetFont('Arial','',6);
$pdf->Cell(38,3,'SOLES	004-102-00202026695',$Borde,1,'L');

$pdf->SetFont('Arial','',6);
$pdf->Cell(38,3,'RECAUDADORA	215-1637703-1-80',$Borde,0,'L');
$pdf->SetFont('Arial','',6);
$pdf->Cell(38,3,'',$Borde,0,'L');
$pdf->SetFont('Arial','',6);
$pdf->Cell(38,3,'',$Borde,0,'L');
$pdf->SetFont('Arial','',6);
$pdf->Cell(38,3,'',$Borde,0,'L');
$pdf->SetFont('Arial','',6);
$pdf->Cell(38,3,'',$Borde,1,'L');

if(!empty($InsCotizacionVehiculo->CveFechaVigencia)){
	
	$pdf->Ln(3);
	
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(190,5,'Vigencia:',$Borde,1,'L');
	
	$pdf->Ln(2);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(190,5,utf8_decode('- Cotización válida hasta el '.$InsCotizacionVehiculo->CveFechaVigencia),$Borde,1,'L');

}

if(!empty($InsCotizacionVehiculo->CotizacionVehiculoFoto)){
 
 	$pdf->Ln(3);
	
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(190,5,'Fotos Adicionales:',$Borde,1,'L');
	
	foreach($InsCotizacionVehiculo->CotizacionVehiculoFoto as $DatCotizacionVehiculoFoto){
		$pdf->Ln(3);
		//$this->Image($img, $x, $y, $w, $h);
		$pdf->Image('../../../subidos/cotizacion_vehiculo_fotos/'.utf8_decode($DatCotizacionVehiculoFoto->CvfArchivo),null,null,NULL,20,NULL,NULL,NULL,true,NULL,NULL,NULL,NULL,0,0);
		
			
	}
		
}


   

          
$pdf->Output($InsCotizacionVehiculo->CveId.".pdf","D");
//$pdf->Output($InsCotizacionVehiculo->CveId.".pdf","D");
//$pdf->Output();

?>