<?php
session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta  = '../../';

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
$GET_ImprimirPedido = $_GET['ImprimirPedido'];

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoManoObra.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoHerramienta.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoSuministro.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoMantenimiento.php');

require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');


require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTempario.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSuministro.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');

require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoTarea.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

require_once($InsPoo->MtdPaqActividad().'ClsTipoReparacion.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');

$InsFichaIngreso = new ClsFichaIngreso();

$InsFichaIngreso->FinId = $GET_id;
$InsFichaIngreso->MtdObtenerFichaIngreso();


class PDF extends FPDF
{
	// Cabecera de página
	function Header(){
		// Logo
		$this->Image('../../imagenes/cabecera_cyc.png',10,8,190);
		// Arial bold 15
		$this->SetFont('Arial','B',8);
		
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
//		$this->SetY(-25);
//		// Arial italic 8
//		$this->SetFont('Arial','I',8);
//		// Movernos a la derecha
//		//$this->Cell(80);
//		// Número de página		
//		//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
//		
//		// Título
//		$this->Ln(5);
//		$this->Cell(0,5,'Urb. Los Cedros Mz. B Lte. 10 Av. Manuel A. Odria Via Panamericana Sur (Costado Grifo Municipal)',0,0,'C');
//		$this->Ln(5);
//		$this->Cell(0,5,'Telefono 51-52 315216 Anexo 210 Fono Fax: 851-52 315207 E-mail: canepa@cyc.com.pe',0,0,'C');
//		$this->Ln(5);
//		$this->Cell(0,5,'Inscritos en los Registros Publicos de Tacna Ficha 2986',0,0,'C');
//
//		// Salto de línea
//		$this->Ln(20);		
//		
		
		
		
	}
	
	
}

$Borde = 0;

// Creación del objeto de la clase heredada
$pdf = new PDF();

$pdf->AliasNbPages();
$pdf->AddPage();



$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,0,'FICHA TECNICA',$Borde,0,'C');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,0,$InsFichaIngreso->FinId,$Borde,0,'C');

$pdf->Ln(5);


$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5,'ASESOR:',$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(80,5,utf8_decode($InsFichaIngreso->PerNombreAsesor.' '.$InsFichaIngreso->PerApellidoPaternoAsesor.' '.$InsFichaIngreso->PerApellidoMaternoAsesor),$Borde,0,'L');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5,'CONTACTO:',$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(80,5,($InsFichaIngreso->PerEmailAsesor.'/'.$InsFichaIngreso->PerCelularAsesor),$Borde,0,'L');


$pdf->Ln(5);


$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5,'NO. DE O/T:',$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(175,5,($InsFichaIngreso->FinId),$Borde,0,'L');

$pdf->Ln(5);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5,'CLIENTE:',$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(110,5,utf8_decode($InsFichaIngreso->CliNombre.' '.$InsFichaIngreso->CliApellidoPaterno.' '.$InsFichaIngreso->CliApellidoMaterno),$Borde,0,'L');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5,'FECHA O/T:',$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(45,5,($InsFichaIngreso->FinFecha),$Borde,0,'L');

$pdf->Ln(5);


$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5,'CONTACTO:',$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(110,5,utf8_decode($InsFichaIngreso->FinContacto),$Borde,0,'L');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5,'RECEP. O/T:',$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(45,5,($InsFichaIngreso->FinTiempoTallerRevisando),$Borde,0,'L');

$pdf->Ln(5);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5,'DIRECCION:',$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(110,5,utf8_decode($InsFichaIngreso->FinContacto),$Borde,0,'L');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5,'TERMI. O/T:',$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(45,5,($InsFichaIngreso->FinTiempoTallerConcluido),$Borde,0,'L');

$pdf->Ln(5);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5,'CELULAR:',$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(110,5,($InsFichaIngreso->FinTelefono),$Borde,0,'L');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5,'NO. CHASIS:',$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(45,5,($InsFichaIngreso->EinVIN),$Borde,0,'L');

$pdf->Ln(5);



$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5,'TECNICO:',$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(110,5,utf8_decode($InsFichaIngreso->PerNombre.' '.$InsFichaIngreso->PerApellidoPaterno.' '.$InsFichaIngreso->PerApellidoMaterno),$Borde,0,'L');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5,'NO. PLACA:',$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(45,5,($InsFichaIngreso->EinPlaca),$Borde,0,'L');

$pdf->Ln(5);


$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5,'FECHA CITA:',$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(60,5,($InsFichaIngreso->FinFechaCita),$Borde,0,'L');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5,'FECHA ENT:',$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(60,5,($InsFichaIngreso->FinFechaEntrega.' '.$InsFichaIngreso->FinHoraEntrega),$Borde,0,'L');

$pdf->Ln(5);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,5,utf8_decode('MODELO/AÑO:'),$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(160,5,($InsFichaIngreso->VmaNombre.'/'.$InsFichaIngreso->VmoNombre.'/'.$InsFichaIngreso->VveNombre.'/'.$InsFichaIngreso->EinAnoFabricacion),$Borde,0,'L');

$pdf->Ln(5);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,5,utf8_decode('KILOMETRAJE:'),$Borde,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(160,5,($InsFichaIngreso->FinVehiculoKilometraje),$Borde,0,'L');

$pdf->Ln(5);


foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
	
	switch($DatFichaIngresoModalidad->MinSigla){
		
		default:
		
			$pdf->Ln(5);

			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(60,5,strtoupper(quitar_tildes($DatFichaIngresoModalidad->MinNombre)),$Borde,0,'L');

$pdf->Ln(5);
			if($DatFichaIngresoModalidad->MinSigla = "CA"){
				
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(125,5,quitar_tildes(($InsFichaIngreso->CamCodigo.' - '.$InsFichaIngreso->CamNombre)),$Borde,0,'L');

			}
				
			$pdf->Ln(5);

			$i=1;
			if(!empty($DatFichaIngresoModalidad->FichaIngresoTarea)){
				
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(185,5,utf8_encode('PRE - DIAGNOSTICO'),$Borde,0,'C');
					
				$pdf->Ln(5);
			
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(5,5,('#'),1,0,'L');
				$pdf->Cell(180,5,'TAREA',1,0,'C');
				
				$pdf->Ln(5);
				
				foreach($DatFichaIngresoModalidad->FichaIngresoTarea as $DatFichaIngresoTarea){
					
					  $pdf->SetFont('Arial','',10);
					  $pdf->Cell(5,5,($i.'.-'),$Borde,0,'L');
					 $pdf->SetFont('Arial','',10);
					  $pdf->Cell(180,5,$DatFichaIngresoTarea->FitDescripcion,$Borde,0,'L');
					  
					  $pdf->Ln(5);
					
					 $i++;
		
				}
				
			} 
	
			$pdf->Ln(5);

			
		
			$i=1;
			if(!empty($DatFichaIngresoModalidad->FichaIngresoTarea)){
				
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(185,5,utf8_encode('TRABAJO Realizado'),$Borde,0,'C');
				
				$pdf->Ln(5);
				
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(5,5,('#'),1,0,'L');
				$pdf->Cell(160,5,'TAREA',1,0,'C');
				$pdf->Cell(20,5,'ACCION',1,0,'L');
				
				$pdf->Ln(5);
				
				foreach($DatFichaIngresoModalidad->FichaIngresoTarea as $DatFichaIngresoTarea){
					
					if($DatFichaAccionTarea->FatEstado == 1){
						
					  $pdf->SetFont('Arial','',10);	
					  $pdf->Cell(5,5,($i.'.-'),$Borde,0,'L');
					  $pdf->Cell(160,5,$DatFichaIngresoTarea->FitDescripcion,$Borde,0,'L');
					  
						switch($DatFichaAccionTarea->FatAccion){
							case "I":
								$pdf->SetFont('Arial','',10);	
								$pdf->Cell(20,5,'INSPECCIONAR',$Borde,0,'L');
							break;
							
							case "R":
								$pdf->SetFont('Arial','',10);	
							  $pdf->Cell(20,5,'REALIZAR',$Borde,0,'L');
							break;
							default:
								$pdf->SetFont('Arial','',10);	
								$pdf->Cell(20,5,'-',$Borde,0,'L');
							break;
						}
							
					  $pdf->Ln(5);
					
					}
					 $i++;
		
				}
				
			} 	
			
			
			
			
			
			$pdf->Ln(5);

			
		
			$i=1;
			if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionProducto)){
				
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(185,5,utf8_encode('CAMBIOS REALIZADOS'),$Borde,0,'C');
			
				$pdf->Ln(5);
			
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(5,5,('#'),1,0,'L');
				$pdf->Cell(140,5,'PRODUCTO',1,0,'C');
				$pdf->Cell(20,5,'ACTIVIDAD',1,0,'L');
				$pdf->Cell(20,5,'ACCION',1,0,'L');
				
				$pdf->Ln(5);
				
				foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionProducto as $DatFichaAccionProducto){
					
						
					  $pdf->SetFont('Arial','',10);
					  $pdf->Cell(5,5,($i.'.-'),$Borde,0,'L');
					  $pdf->Cell(140,5,$DatFichaAccionProducto->ProNombre,$Borde,0,'L');
					  $pdf->Cell(20,5,'Cambiar',$Borde,0,'L');
					  
					  switch($DatFichaAccionProducto->FapVerificar1){
						  	
							case 1:		
								$pdf->SetFont('Arial','',10);					
								$pdf->Cell(20,5,'Realizado',$Borde,0,'L');					
							break;
						
							case 2:			
								$pdf->SetFont('Arial','',10);				
								$pdf->Cell(20,5,'No Realizado',$Borde,0,'L');					
							break;
						
							default:
									$pdf->Cell(20,5,'-',$Borde,0,'L');
							break;
					  }
  
					  $pdf->Ln(5);
					
					
					 $i++;
		
				}
				
			} 
			
			
				
		break;
		
		case "MA":
		
			$pdf->Ln(5);

			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(60,5,utf8_encode(strtoupper($DatFichaIngresoModalidad->MinNombre)),$Borde,0,'L');

				switch($InsFichaIngreso->VmaId){
						
						default:
						
						$pdf->Ln(5);
				
							$pdf->SetFont('Arial','B',10);
							$pdf->Cell(5,5,(('#')),1,0,'L');
							$pdf->Cell(130,5,utf8_encode(('Detalle del trabajo a realizado')),1,0,'L');
							$pdf->Cell(25,5,utf8_encode(('Actividad')),1,0,'L');
							$pdf->Cell(25,5,utf8_encode(('Accion')),1,0,'L');
				
						$pdf->Ln(5);
						
									
				  $i=1;
					if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionMantenimiento)){
						foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionMantenimiento as $DatFichaAccionMantenimiento){
					
							if(($DatFichaAccionMantenimiento->FaaAccion<>"X" and !empty($DatFichaAccionMantenimiento->FaaAccion))){
						
								$pdf->SetFont('Arial','',10);
								$pdf->Cell(5,5,(($i.'.-')),$Borde,0,'L');
								$pdf->Cell(130,5,quitar_tildes(($DatFichaAccionMantenimiento->PmtNombre)),$Borde,0,'L');
								
								switch($DatFichaAccionMantenimiento->FaaAccion){
									
									case "I":
										$pdf->SetFont('Arial','',10);
										$pdf->Cell(25,5,utf8_encode(('Inspeccionar')),$Borde,0,'L'); 
									break;
									
									case "R":
										$pdf->SetFont('Arial','',10);
										$pdf->Cell(25,5,utf8_encode(('Realizar')),$Borde,0,'L');   
									break;
									
									case "C":
										$pdf->SetFont('Arial','B',10);
										$pdf->Cell(25,5,utf8_encode(('Cambiar')),$Borde,0,'L');
									break;
									
									case "U":
										$pdf->SetFont('Arial','B',10);
										$pdf->Cell(25,5,utf8_encode(('Agregar')),$Borde,0,'L');
									break;
									
									case "P":
										$pdf->SetFont('Arial','',10);
										$pdf->Cell(25,5,utf8_encode(('Consultivo')),$Borde,0,'L');
									break;
								
									default:
										$pdf->SetFont('Arial','',10);
										$pdf->Cell(25,5,utf8_encode(('-')),$Borde,0,'L');
									break;
								}
					
								 switch($DatFichaAccionMantenimiento->FaaVerificar1){
					
									case 1:
										$pdf->SetFont('Arial','',10);
										$pdf->Cell(2,5,utf8_encode(('Realizado')),$Borde,0,'L');
									break;
								
									case 2:
										$pdf->SetFont('Arial','',10);
										$pdf->Cell(25,5,utf8_encode(('No Realizado')),$Borde,0,'L');
									break;
								
									default:
										$pdf->SetFont('Arial','',10);
										$pdf->Cell(25,5,utf8_encode(('-')),$Borde,0,'L');
									break;
								}
								
								$pdf->Ln(5);
							
							 $i++;
							}
						}
					
					} 
					
						break;
		
		
		case "VMA-10018":
		
		$pdf->Ln(5);

			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(5,5,(('#')),1,0,'L');
			$pdf->Cell(130,5,utf8_encode(('Detalle del trabajo a realizado')),1,0,'L');
			$pdf->Cell(25,5,utf8_encode(('Actividad')),1,0,'L');
			$pdf->Cell(25,5,utf8_encode(('Accion')),1,0,'L');

		$pdf->Ln(5);
		
			  $i=1;
				if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionMantenimiento)){
					foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionMantenimiento as $DatFichaAccionMantenimiento){
				
						if(($DatFichaAccionMantenimiento->FaaAccion<>"X" and !empty($DatFichaAccionMantenimiento->FaaAccion))){
					
							$pdf->SetFont('Arial','',10);
							$pdf->Cell(5,5,(($i.'.-')),$Borde,0,'L');
							$pdf->SetFont('Arial','',10);
							$pdf->Cell(130,5,( quitar_tildes($DatFichaAccionMantenimiento->PmtNombre)),$Borde,0,'L');
							
							switch($DatFichaAccionMantenimiento->FaaAccion){
								case "R":
									$pdf->SetFont('Arial','B',10);
									$pdf->Cell(25,5,utf8_encode(('Reemplazar')),$Borde,0,'L');
								break;
								
								case "I":
									$pdf->SetFont('Arial','',10);
									$pdf->Cell(25,5,utf8_encode(('Inspeccionar')),$Borde,0,'L');
								break;
								
								case "A":
									$pdf->SetFont('Arial','',10);
									$pdf->Cell(25,5,utf8_encode(('Ajustar')),$Borde,0,'L');
								break;
								
								case "T":
									$pdf->SetFont('Arial','',10);
									$pdf->Cell(25,5,utf8_encode(('Apretar')),$Borde,0,'L');
								break;
								
								case "L":
									$pdf->SetFont('Arial','',10);
									$pdf->Cell(25,5,utf8_encode(('Lubricar')),$Borde,0,'L');
								break;  
								
								case "U":
									$pdf->SetFont('Arial','B',10);
									$pdf->Cell(25,5,utf8_encode(('Agregar')),$Borde,0,'L');
								break;
								
								case "P":
									$pdf->SetFont('Arial','',10);
									$pdf->Cell(25,5,utf8_encode(('Consultivo')),$Borde,0,'L');
								break;
								
								default:
									$pdf->SetFont('Arial','',10);
									$pdf->Cell(25,5,utf8_encode(('-')),$Borde,0,'L');
								break;
							}
				
							 switch($DatFichaAccionMantenimiento->FaaVerificar1){
				
								case 1:
									$pdf->SetFont('Arial','',10);
									$pdf->Cell(25,5,utf8_encode(('Realizado')),$Borde,0,'L');
								break;
							
								case 2:
									$pdf->SetFont('Arial','',10);
									$pdf->Cell(25,5,utf8_encode(('No Realizado')),$Borde,0,'L');
								break;
							
								default:
									$pdf->SetFont('Arial','',10);
									$pdf->Cell(25,5,utf8_encode(('-')),$Borde,0,'L');
								break;
							}
							
							$pdf->Ln(5);
							
						
						 $i++;
						}
					}
				
				} 
    
	

		break;
		
}


		break;
		
		case "LI":
		
			$pdf->Ln(5);

			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(60,5,utf8_encode(strtoupper($DatFichaIngresoModalidad->MinNombre)),$Borde,0,'L');

			$pdf->Ln(5);
			
			
				$i=1;
				if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionTarea)){
					foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionTarea as $DatFichaAccionTarea){
									
						$pdf->SetFont('Arial','',10);
						$pdf->Cell(5,5,(($i.'.-')),$Borde,0,'L');
						
						 switch($DatFichaAccionTarea->FatAccion){
						  
							case "L":		
								$pdf->SetFont('Arial','',10);
								$pdf->Cell(20,5,(('Planchado')),$Borde,0,'L');    
							break;
							
							case "N":
								$pdf->SetFont('Arial','',10);
								$pdf->Cell(20,5,(('Pintado')),$Borde,0,'L');   
							break;
							
							case "E":
								$pdf->SetFont('Arial','',10);
								$pdf->Cell(20,5,(('Centrado')),$Borde,0,'L');					
							break;
							
							case "Z":
								$pdf->SetFont('Arial','',10);
								$pdf->Cell(20,5,(('Tarea/Reparacion')),$Borde,0,'L');				
							break;
							
							default:
								$pdf->SetFont('Arial','',10);
								$pdf->Cell(20,5,(('-')),$Borde,0,'L');			   
							break;
							
						  }
						  
						  $pdf->SetFont('Arial','',10);
						  $pdf->Cell(5,5,(($DatFichaAccionTarea->FatDescripcion)),$Borde,0,'L');
						  
						  $pdf->Ln(5);
						  
						  $i++;
						 
					}
				} 
				
			$pdf->Ln(5);	
				
				
				$i=1;
			if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionProducto)){
				
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(185,5,utf8_encode('CAMBIOS REALIZADOS'),$Borde,0,'C');
			
				$pdf->Ln(5);
			
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(5,5,('#'),1,0,'L');
				$pdf->Cell(140,5,'PRODUCTO',1,0,'C');
				$pdf->Cell(20,5,'ACTIVIDAD',1,0,'L');
				$pdf->Cell(20,5,'ACCION',1,0,'L');
				
				$pdf->Ln(5);
				
				foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionProducto as $DatFichaAccionProducto){
					
						
					  $pdf->SetFont('Arial','',10);
					  $pdf->Cell(5,5,($i.'.-'),$Borde,0,'L');
					  $pdf->Cell(140,5,$DatFichaAccionProducto->ProNombre,$Borde,0,'L');
					  $pdf->Cell(20,5,'Cambiar',$Borde,0,'L');
					  
					  switch($DatFichaAccionProducto->FapVerificar1){
						  	
							case 1:		
								$pdf->SetFont('Arial','',10);					
								$pdf->Cell(20,5,'Realizado',$Borde,0,'L');					
							break;
						
							case 2:			
								$pdf->SetFont('Arial','',10);				
								$pdf->Cell(20,5,'No Realizado',$Borde,0,'L');					
							break;
						
							default:
									$pdf->Cell(20,5,'-',$Borde,0,'L');
							break;
					  }
  
					  $pdf->Ln(5);
					
					
					 $i++;
		
				}
				
			} 
			
			
			
		break;
		
		
		case "SI":
		
		
			$pdf->Ln(5);

			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(60,5,utf8_encode(strtoupper($DatFichaIngresoModalidad->MinNombre)),$Borde,0,'L');

			$pdf->Ln(5);
			
			
				$i=1;
				if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionTarea)){
					foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionTarea as $DatFichaAccionTarea){
									
						$pdf->SetFont('Arial','',10);
						$pdf->Cell(5,5,(($i.'.-')),$Borde,0,'L');
						
						 switch($DatFichaAccionTarea->FatAccion){
						  
							case "L":		
								$pdf->SetFont('Arial','',10);
								$pdf->Cell(20,5,(('Planchado')),$Borde,0,'L');    
							break;
							
							case "N":
								$pdf->SetFont('Arial','',10);
								$pdf->Cell(20,5,(('Pintado')),$Borde,0,'L');   
							break;
							
							case "E":
								$pdf->SetFont('Arial','',10);
								$pdf->Cell(20,5,(('Centrado')),$Borde,0,'L');					
							break;
							
							case "Z":
								$pdf->SetFont('Arial','',10);
								$pdf->Cell(20,5,(('Tarea/Reparacion')),$Borde,0,'L');				
							break;
							
							default:
								$pdf->SetFont('Arial','',10);
								$pdf->Cell(20,5,(('-')),$Borde,0,'L');			   
							break;
							
						  }
						  
						  $pdf->SetFont('Arial','',10);
						  $pdf->Cell(5,5,(($DatFichaAccionTarea->FatDescripcion)),$Borde,0,'L');
						  
						  $pdf->Ln(5);
						  
						  $i++;
						 
					}
				} 
				
			$pdf->Ln(5);	
				
				
			$i=1;
			if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionProducto)){
				
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(185,5,utf8_encode('CAMBIOS REALIZADOS'),$Borde,0,'C');
			
				$pdf->Ln(5);
			
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(5,5,('#'),1,0,'L');
				$pdf->Cell(140,5,'PRODUCTO',1,0,'C');
				$pdf->Cell(20,5,'ACTIVIDAD',1,0,'L');
				$pdf->Cell(20,5,'ACCION',1,0,'L');
				
				$pdf->Ln(5);
				
				foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionProducto as $DatFichaAccionProducto){
					
						
					  $pdf->SetFont('Arial','',10);
					  $pdf->Cell(5,5,($i.'.-'),$Borde,0,'L');
					  $pdf->Cell(140,5,$DatFichaAccionProducto->ProNombre,$Borde,0,'L');
					  $pdf->Cell(20,5,'Cambiar',$Borde,0,'L');
					  
					  switch($DatFichaAccionProducto->FapVerificar1){
						  	
							case 1:		
								$pdf->SetFont('Arial','',10);					
								$pdf->Cell(20,5,'Realizado',$Borde,0,'L');					
							break;
						
							case 2:			
								$pdf->SetFont('Arial','',10);				
								$pdf->Cell(20,5,'No Realizado',$Borde,0,'L');					
							break;
						
							default:
									$pdf->Cell(20,5,'-',$Borde,0,'L');
							break;
					  }
  
					  $pdf->Ln(5);
					
					
					 $i++;
		
				}
				
			} 
			
			
			
		$Adicional = false;
		if(!empty($DatFichaIngresoModalidad->FichaAccion->TallerPedido->TallerPedidoDetalle)){
			foreach($DatFichaIngresoModalidad->FichaAccion->TallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){
				if(empty($DatTallerPedidoDetalle->FapId) and empty($DatTallerPedidoDetalle->FaaId)){
					$Adicional = true;
				break;
				}
			}
		}


		$i=1;
			if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionProducto)){
				
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(185,5,utf8_encode('ADICIONALES'),$Borde,0,'C');
			
				$pdf->Ln(5);
			
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(5,5,('#'),1,0,'L');
				$pdf->Cell(140,5,'PRODUCTO',1,0,'C');
				$pdf->Cell(20,5,'ACTIVIDAD',1,0,'L');
				$pdf->Cell(20,5,'ACCION',1,0,'L');
				
				$pdf->Ln(5);
				
				foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionProducto as $DatFichaAccionProducto){
					
						
					  $pdf->SetFont('Arial','',10);
					  $pdf->Cell(5,5,($i.'.-'),$Borde,0,'L');
					  $pdf->Cell(140,5,$DatFichaAccionProducto->ProNombre,$Borde,0,'L');
					  $pdf->Cell(20,5,'Cambiar',$Borde,0,'L');
					  
					 $pdf->SetFont('Arial','',10);					
					 $pdf->Cell(20,5,'Realizado',$Borde,0,'L');					
							
  
					  $pdf->Ln(5);
					
					
					 $i++;
		
				}
				
			} 
			
		break;

	}
	
	
	$pdf->Ln(5);
	$pdf->Ln(5);
	
	
			if(!empty($DatFichaIngresoModalidad->FichaAccion->FccCausa)){
				
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(185,5,utf8_encode('CAUSA DEL PROBLEMA'),$Borde,0,'C');
					
				$pdf->Ln(5);
				
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(185,5,$DatFichaIngresoModalidad->FichaAccion->FccCausa,$Borde,0,'C');
				
				$pdf->Ln(5);
				
				
			}
				

	
}


			if(!empty($InsFichaIngreso->FinObservacion)){
				
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(185,5,utf8_encode('OBSERVACION/RECEPCION:'),$Borde,0,'C');
					
				$pdf->Ln(5);
				
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(185,5,$InsFichaIngreso->FinObservacion,$Borde,0,'C');
				
				$pdf->Ln(5);
				
			}
			
			if(!empty($InsFichaIngreso->FinSalidaObservacion)){
				
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(185,5,utf8_encode('OBSERVACION/TRABAJO TERMINADO:'),$Borde,0,'C');
					
				$pdf->Ln(5);
				
				
								
				$FinSalidaObservacion = strip_tags($InsFichaIngreso->FinSalidaObservacion);
				
				$ArrPalabras = explode(" ",$FinSalidaObservacion);
				
				$afila = array();
				$fila = 1;
				
				for($i=0;$i<=count($ArrPalabras);$i++){			
										
					if(strlen($afila[$fila]." ".$ArrPalabras[$i])<100){											
						$afila[$fila].=" ".$ArrPalabras[$i];										
					}else{										
						$fila++;
						$afila[$fila].=" ".$ArrPalabras[$i];
					}
					
				}
				
				for($j=1;$j<=$fila;$j++){
					
					if($j==1){
					
						$pdf->SetFont('times', '', 10);
						$pdf->Cell(185,5,utf8_encode($afila[$j]),$Borde,0,'L');
						
					}else{
				
						$pdf->SetFont('times', '', 10);
						$pdf->Cell(185,5,utf8_encode($afila[$j]),$Borde,0,'L');
					}
					$pdf->Ln(5);
				}


				
			}
			$pdf->Ln(5);
			$pdf->Ln(5);
			
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(90,5,utf8_encode('FIRMA DE JEFE DE TALLER:'),1,0,'C');
				$pdf->Cell(90,5,utf8_encode('FIRMA DE CONFORMIDAD DEL CLIENTE:'),1,0,'C');
				
				$pdf->Ln(5);
				
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(90,5,'',$Borde,0,'C');
				$pdf->Cell(90,5,'',$Borde,0,'C');
				
				$pdf->Ln(5);
				
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(90,5,'',$Borde,0,'C');
				$pdf->Cell(90,5,'',$Borde,0,'C');
					
				$pdf->Ln(5);
				
				
				
				
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(90,5,utf8_encode('FIRMA DE MECANICO ASIGNADO:'),1,0,'C');
				$pdf->Cell(90,5,'',1,0,'C');
				
				$pdf->Ln(5);
				
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(90,5,'',$Borde,0,'C');
				$pdf->Cell(90,5,'',$Borde,0,'C');
				
				$pdf->Ln(5);
				
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(90,5,'',$Borde,0,'C');
				$pdf->Cell(90,5,'',$Borde,0,'C');
				
				$pdf->Ln(5);
				
				
				

$pdf->Output($InsFichaIngreso->FinId.".pdf","D");
//$pdf->Output();

?>