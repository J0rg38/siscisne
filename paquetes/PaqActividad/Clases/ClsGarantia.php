<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsGarantia
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsGarantia {

    public $GarId;
	public $GarAno;
	public $GarMes;
	
	public $FccId;
	public $CliId;
	
	public $GarFechaEmision;
	public $GarFechaVenta;
	
	public $GarDireccion;
	public $GarCiudad;
	public $GarTelefono;
	public $GarCelular;
	
	public $MonId;
	public $GarTipoCambio;
	
	public $GarPorcentajeImpuestoVenta;
	
	public $GarSubTotalRepuestoStock;
	public $GarFactorPorcentaje1;
	public $GarSubTotalRepuestoOtro;
	public $GarFactorPorcentaje2;

	public $GarTotalRepuesto;
	public $GarTotalManoObra;
	
	public $GarSubTotal;
	public $GarImpuesto;
	public $GarTotal;
	
	public $GarTarifaAutorizada;
	public $GarModelo;
	public $GarCausa;
	public $GarSolucion;
	public $GarObservacion;
	public $GarObservacionImpresa;
	
	public $GarTransaccionFecha;
	public $GarTransaccionNumero;
	public $GarObservacionFinal;
	
	public $GarNumeroComprobante;
	public $GarFechaPago;
	public $CueId;
	
	public $GarEstado;
	public $GarTiempoCreacion;
	public $GarTiempoModificacion;
    public $GarEliminado;
	
	
	public $CliNombre;
	public $CliApellidoPaterno;
	public $CliApellidoMaterno;
	public $CliNumeroDocumento;
	public $TdoId;
	
	public $EinId;
	public $EinVIN;
	public $FinVehiculoKilometraje;
	public $VmaId;
	public $VmoId;
	public $EinPlaca;

	public $EinAnoFabricacion;
	public $EinNumeroMotor;
	public $EinColor;
	public $EinPoliza;
	
	public $VmaNombre;
	public $VmoNombre;
	public $VmaAbreviatura;
	
	public $FinId;
	public $MinId;
	public $MinNombre;
	
	public $LtiNombre;
	public $PerNombre;
	public $PerApellidoPaterno;
	public $PerApellidoMaterno;
	public $MonNombre;
	public $MonSimbolo;

	public $FinFecha;
	public $FinTiempoTrabajoTerminado;
	public $FinFotoVIN;
	public $FinFotoFrontal;
	public $FinFotoCupon;
	public $FinFotoMantenimiento;
				
	public $FccCausa;
	public $CamBoletinCodigo;
	public $AmoId;
	public $GarEstadoDescripcion;
				
	public $GarantiaDetalle;
	public $GarantiaOperacion;

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarGarantiaId() {

		$InsFichaAccion = new ClsFichaAccion();
		$InsFichaAccion->FccId = $this->FccId;
		$InsFichaAccion->MtdObtenerFichaAccion();
		


		if( $InsFichaAccion->MinSigla == "IF" or $InsFichaAccion->MinSigla == "PP"){
			$InsFichaAccion->MinSigla = "PDI";
		}
		
		switch(count($InsFichaAccion->MinSigla)){
			
			case 3:
			
					$sql = 'SELECT	
							MAX(CONVERT(SUBSTR(gar.GarId,19),unsigned)) AS "MAXIMO"
							FROM tblgargarantia gar
								LEFT JOIN tblfccfichaaccion fcc
								ON gar.FccId = fcc.FccId
									LEFT JOIN tblfimfichaingresomodalidad fim
									ON fcc.FimId = fim.FimId
										LEFT JOIN tblminmodalidadingreso min
										ON fim.MinId = min.MinId
											
											LEFT JOIN tblfinfichaingreso fin
											ON fim.FinId = fin.FinId
											
												LEFT JOIN tbleinvehiculoingreso ein
												ON fin.EinId = ein.EinId
				
							WHERE YEAR(gar.GarFechaEmision) = ("'.$this->GarAno.'")
							AND MONTH(gar.GarFechaEmision) = ("'.$this->GarMes.'")
							AND min.MinSigla = ("'.$InsFichaAccion->MinSigla.'")
							AND ein.VmaId = ("'.$this->VmaId.'")
							
				';
							
			
						
			break;
			
			default:

				$sql = 'SELECT	
						MAX(CONVERT(SUBSTR(gar.GarId,18),unsigned)) AS "MAXIMO"
						FROM tblgargarantia gar
							LEFT JOIN tblfccfichaaccion fcc
							ON gar.FccId = fcc.FccId
								LEFT JOIN tblfimfichaingresomodalidad fim
								ON fcc.FimId = fim.FimId
									LEFT JOIN tblminmodalidadingreso min
									ON fim.MinId = min.MinId
										
										LEFT JOIN tblfinfichaingreso fin
										ON fim.FinId = fin.FinId
										
											LEFT JOIN tbleinvehiculoingreso ein
											ON fin.EinId = ein.EinId
			
						WHERE YEAR(gar.GarFechaEmision) = ("'.$this->GarAno.'")
						AND MONTH(gar.GarFechaEmision) = ("'.$this->GarMes.'")
						AND min.MinSigla = ("'.$InsFichaAccion->MinSigla.'")
						AND ein.VmaId = ("'.$this->VmaId.'")
						
			';
						
			
			break;
		}
		
	 
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				//$this->GarId = "GAR-".$this->GarAno."-".$this->GarMes."-00001";
				
				
				$this->GarId = $InsFichaAccion->MinSigla."-".$InsFichaAccion->VmaAbreviatura."-".$this->GarAno."-".$this->GarMes."-00001";
			}else{
				$fila['MAXIMO']++;
				//$this->GarId = "GAR-".$this->GarAno."-".$this->GarMes."-".str_pad($fila['MAXIMO'], 5, "0", STR_PAD_LEFT);	
				$this->GarId = $InsFichaAccion->MinSigla."-".$InsFichaAccion->VmaAbreviatura."-".$this->GarAno."-".$this->GarMes."-".str_pad($fila['MAXIMO'], 5, "0", STR_PAD_LEFT);	
			}
				//MAX(CONVERT(SUBSTR(VmaId,5),unsigned)) AS "MAXIMO"
		}
		
    public function MtdObtenerGarantia($oCompleto=true){

        $sql = 'SELECT 
        gar.GarId,
		
		gar.FccId,
		gar.CliId,
		
		DATE_FORMAT(gar.GarFechaEmision, "%d/%m/%Y") AS "NGarFechaEmision",
		DATE_FORMAT(gar.GarFechaVenta, "%d/%m/%Y") AS "NGarFechaVenta",
	
		gar.GarDireccion,
		gar.GarCiudad,
		gar.GarTelefono,
		gar.GarCelular,
		
		gar.MonId,
		gar.GarTipoCambio,

		gar.GarPorcentajeImpuestoVenta,
		
		gar.GarSubTotalRepuestoStock,
		gar.GarFactorPorcentaje1,
		gar.GarSubTotalRepuestoOtro,
		gar.GarFactorPorcentaje2,

		gar.GarTotalRepuesto,
		gar.GarTotalManoObra,

		gar.GarSubTotal,
		gar.GarImpuesto,
		gar.GarTotal,
	
		gar.GarTarifaAutorizada,
		gar.GarModelo,
		gar.GarSolucion,
		gar.GarCausa,
		gar.GarObservacion,
		gar.GarObservacionImpresa,
		
		DATE_FORMAT(gar.GarTransaccionFecha, "%d/%m/%Y") AS "NGarTransaccionFecha",
		gar.GarTransaccionNumero,
		gar.GarObservacionFinal,
		
		gar.GarNumeroComprobante,
		DATE_FORMAT(gar.GarFechaPago, "%d/%m/%Y") AS "NGarFechaPago",
		gar.CueId,
		
		gar.GarEstado,
		DATE_FORMAT(gar.GarTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NGarTiempoCreacion",
        DATE_FORMAT(gar.GarTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NGarTiempoModificacion",
		
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				cli.CliNumeroDocumento,
				cli.TdoId,
				
				ein.EinId,
				ein.EinVIN,
				fin.FinVehiculoKilometraje,
				
				ein.VmaId,
				ein.VmoId,
				ein.EinPlaca,
				
				ein.EinAnoFabricacion,
				ein.EinNumeroMotor,
				ein.EinColor,
				ein.EinPoliza,

				vma.VmaNombre,
				vmo.VmoNombre,
				
				fin.FinId,
				fim.MinId,
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				mon.MonNombre,
				mon.MonSimbolo,
				
				DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",
				DATE_FORMAT(fin.FinTiempoTrabajoTerminado, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTrabajoTerminado",
				
				
				min.MinNombre,
				
				cam.CamBoletinCodigo,
				
				fcc.FccCausa,
				
				fin.FinFotoVIN,
				fin.FinFotoFrontal,
				fin.FinFotoCupon,
				fin.FinFotoMantenimiento,
				
				amo.AmoId
				
				

        FROM tblgargarantia gar
			LEFT JOIN tblclicliente cli
			ON gar.CliId = cli.CliId
				LEFT JOIN tblfccfichaaccion fcc
				ON gar.FccId = fcc.FccId
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amo.FccId = fcc.FccId
					
					LEFT JOIN tblfimfichaingresomodalidad fim
					ON fcc.FimId = fim.FimId
						
						LEFT JOIN tblminmodalidadingreso min
						ON fim.MinId = min.MinId
						
						LEFT JOIN tblfinfichaingreso fin
						ON fim.FinId = fin.FinId
							LEFT JOIN tbleinvehiculoingreso ein
							ON fin.EinId = ein.EinId
								LEFT JOIN tblvmavehiculomarca vma
								ON ein.VmaId = vma.VmaId
									LEFT JOIN tblvmovehiculomodelo vmo
									ON ein.VmoId = vmo.VmoId
										
										LEFT JOIN tblcamcampana cam
										ON fin.CamId = cam.CamId
										
										
										
										
			LEFT JOIN tblperpersonal per
			ON fin.PerId = per.PerId
			
			LEFT JOIN tblmonmoneda mon
			ON gar.MonId = mon.MonId
			
        WHERE gar.GarId = "'.$this->GarId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			$this->GarId = $fila['GarId'];
			$this->FccId = $fila['FccId'];
			$this->CliId = $fila['CliId'];
			
			$this->GarFechaEmision = $fila['NGarFechaEmision'];
			$this->GarFechaVenta = $fila['NGarFechaVenta'];
			
			$this->GarDireccion = $fila['GarDireccion'];
			$this->GarCiudad = $fila['GarCiudad'];
			$this->GarTelefono = $fila['GarTelefono'];
			$this->GarCelular = $fila['GarCelular'];
			
			$this->MonId = $fila['MonId'];
			$this->GarTipoCambio = $fila['GarTipoCambio'];

			$this->GarPorcentajeImpuestoVenta = $fila['GarPorcentajeImpuestoVenta'];

			$this->GarSubTotalRepuestoStock = $fila['GarSubTotalRepuestoStock'];
			$this->GarFactorPorcentaje1 = $fila['GarFactorPorcentaje1'];
			$this->GarSubTotalRepuestoOtro = $fila['GarSubTotalRepuestoOtro'];
			$this->GarFactorPorcentaje2 = $fila['GarFactorPorcentaje2'];
			
			$this->GarTotalRepuesto = $fila['GarTotalRepuesto'];
			$this->GarTotalManoObra = $fila['GarTotalManoObra'];
			
			$this->GarSubTotal = $fila['GarSubTotal'];
			$this->GarImpuesto = $fila['GarImpuesto'];
			$this->GarTotal = $fila['GarTotal'];
			
			
			$this->GarTarifaAutorizada = $fila['GarTarifaAutorizada'];
			$this->GarModelo = $fila['GarModelo'];
			$this->GarCausa = $fila['GarCausa'];
			$this->GarSolucion = $fila['GarSolucion'];
			$this->GarObservacion = $fila['GarObservacion'];
			$this->GarObservacionImpresa = $fila['GarObservacionImpresa'];
			
			
			$this->GarTransaccionFecha = $fila['NGarTransaccionFecha'];
			$this->GarTransaccionNumero = $fila['GarTransaccionNumero'];
			$this->GarObservacionFinal = $fila['GarObservacionFinal'];
			

			$this->GarNumeroComprobante = $fila['GarNumeroComprobante'];
			$this->GarFechaPago = $fila['NGarFechaPago'];
			$this->CueId = $fila['CueId'];
		
		
			$this->GarEstado = $fila['GarEstado'];
			$this->GarTiempoCreacion = $fila['NGarTiempoCreacion']; 
			$this->GarTiempoModificacion = $fila['NGarTiempoModificacion'];
			
			$this->CliNombre = $fila['CliNombre'];
			$this->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$this->CliApellidoMaterno = $fila['CliApellidoMaterno'];
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento'];
			$this->TdoId = $fila['TdoId'];
			
			
			$this->EinId = $fila['EinId'];
			$this->EinVIN = $fila['EinVIN'];
			$this->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje'];
			
			$this->VmaId = $fila['VmaId'];
			$this->VmoId = $fila['VmoId'];
			$this->EinPlaca = $fila['EinPlaca'];
			$this->EinAnoFabricacion = $fila['EinAnoFabricacion'];
			$this->EinNumeroMotor = $fila['EinNumeroMotor'];
			$this->EinColor = $fila['EinColor'];
			$this->EinPoliza = $fila['EinPoliza'];
			
			$this->VmaNombre = $fila['VmaNombre'];
			$this->VmoNombre = $fila['VmoNombre'];
			
			$this->FinId = $fila['FinId'];
			$this->MinId = $fila['MinId'];
			
			$this->PerNombre = $fila['PerNombre'];
			$this->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$this->PerApellidoMaterno = $fila['PerApellidoMaterno'];
			
			$this->MonNombre = $fila['MonNombre'];
			$this->MonSimbolo = $fila['MonSimbolo'];
			
			$this->MonSimbolo = $fila['MonSimbolo'];
			$this->MonSimbolo = $fila['MonSimbolo'];
			
			$this->FinFecha = $fila['NFinFecha'];
			$this->FinTiempoTrabajoTerminado = $fila['NFinTiempoTrabajoTerminado'];
			
			$this->MinNombre = $fila['MinNombre'];
			
			$this->CamBoletinCodigo = $fila['CamBoletinCodigo'];
			
			$this->FccCausa = $fila['FccCausa'];	
			
			$this->FinFotoVIN = $fila['FinFotoVIN'];	
			$this->FinFotoFrontal = $fila['FinFotoFrontal'];
			$this->FinFotoCupon = $fila['FinFotoCupon'];
			$this->FinFotoMantenimiento = $fila['FinFotoMantenimiento'];			
			
			$this->AmoId = $fila['AmoId'];	
			
			switch($this->GarEstado){
				
				case 1:
					$this->GarEstadoDescripcion =  "Pendiente";
				break;
				
				case 5:
					$this->GarEstadoDescripcion =  "Entregado";
				break;
				
				case 6:
					$this->GarEstadoDescripcion =  "Anulado";
				break;
                
				case 7:
					$this->GarEstadoDescripcion =  "C/ Transaccion";
				break;
                
				case 8:
					$this->GarEstadoDescripcion =  "Pagado";
				break;
				
				case 9:
					$this->GarEstadoDescripcion =  "Facturado";
				break;
				
			}
                    
			if($oCompleto){
				
				$InsGarantiaDetalle = new ClsGarantiaDetalle();
				$ResGarantiaDetalle =  $InsGarantiaDetalle->MtdObtenerGarantiaDetalles(NULL,NULL,"GdeId","ASC",NULL,$this->GarId,NULL,NULL);
				$this->GarantiaDetalle = 	$ResGarantiaDetalle['Datos'];	
	
				$InsGarantiaOperacion = new ClsGarantiaOperacion();
				$ResGarantiaOperacion =  $InsGarantiaOperacion->MtdObtenerGarantiaOperaciones(NULL,NULL,"GopId","ASC",NULL,$this->GarId,NULL);
				$this->GarantiaOperacion = 	$ResGarantiaOperacion['Datos'];	
				
				$InsFichaAccionFoto = new ClsFichaAccionFoto();
				$ResFichaAccionFoto = $InsFichaAccionFoto->MtdObtenerFichaAccionFotos(NULL,NULL,'FafId','Desc',NULL,$this->FccId,NULL);
				$this->FichaAccionFoto = $ResFichaAccionFoto['Datos'];
				
				
				$InsGarantiaLlamada = new ClsGarantiaLlamada();
				$ResGarantiaLlamada =  $InsGarantiaLlamada->MtdObtenerGarantiaLlamadas(NULL,NULL,"GllId","ASC",NULL,$this->GarId,NULL);
				$this->GarantiaLlamada = 	$ResGarantiaLlamada['Datos'];	
				
			}                       
			
		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerGarantias($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'GarId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oFichaIngreso=NULL,$oFichaAccion=NULL) {

		// Inicializar variables de filtro para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$fecha = '';
		$estado = '';
		$moneda = '';
		$fingreso = '';
		$faccion = '';

		if(!empty($oCampo) and !empty($oFiltro)){
			
			$oFiltro = str_replace(" ","%",$oFiltro);
			
			$elementos = explode(",",$oCampo);

				$i=1;
				$filtrar .= '  AND (';
				foreach($elementos as $elemento){
					if(!empty($elemento)){				
						if($i==count($elementos)){	

						$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' )';
							
						}else{
							
							
							$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' ) OR';
							
						}
					}
				$i++;
		
				}
				
				$filtrar .= '  ) ';

			
	
		}




		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(gar.GarFechaEmision)>="'.$oFechaInicio.'" AND DATE(gar.GarFechaEmision)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(gar.GarFechaEmision)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(gar.GarFechaEmision)<="'.$oFechaFin.'"';		
			}			
		}


		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

			$i=1;
			$estado .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$estado .= '  (gar.GarEstado = '.($elemento).')';
				if($i<>count($elementos)){						
					$estado .= ' OR ';	
				}
			$i++;		
			}
			
			$estado .= ' ) 
			)
			';

		}
		
		
		//if(!empty($oEstado)){
//			$estado = ' AND gar.GarEstado = '.$oEstado;
//		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND gar.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oFichaIngreso)){
			$fingreso = ' AND fim.FinId = "'.$oFichaIngreso.'"';
		}	


		if(!empty($oFichaAccion)){
			$faccion = ' AND gar.FccId = "'.$oFichaAccion.'"';
		}	
		
		
		
		
			$sql = 'SELECT
					SQL_CALC_FOUND_ROWS 
					gar.GarId,
					gar.FccId,
					
					gar.CliId,
					
					DATE_FORMAT(gar.GarFechaEmision, "%d/%m/%Y") AS "NGarFechaEmision",
					DATE_FORMAT(gar.GarFechaVenta, "%d/%m/%Y") AS "NGarFechaVenta",
					
					gar.GarDireccion,
					gar.GarCiudad,
					gar.GarTelefono,
					gar.GarCelular,
					
					gar.MonId,
					gar.GarTipoCambio,
					
					gar.GarPorcentajeImpuestoVenta,
					
					gar.GarSubTotalRepuestoStock,
					gar.GarFactorPorcentaje1,
					gar.GarSubTotalRepuestoOtro,
					gar.GarFactorPorcentaje2,
			
					gar.GarTotalRepuesto,
					gar.GarTotalManoObra,
					
					gar.GarSubTotal,
					gar.GarImpuesto,
					gar.GarTotal,
					
					gar.GarTarifaAutorizada,
					gar.GarModelo,
					gar.GarCausa,
					gar.GarSolucion,
					
					gar.GarObservacion,
					gar.GarObservacionImpresa,
					
					
					DATE_FORMAT(gar.GarTransaccionFecha, "%d/%m/%Y") AS "NGarTransaccionFecha",
					gar.GarTransaccionNumero,
					gar.GarObservacionFinal,
					
					gar.GarNumeroComprobante,
					
					DATE_FORMAT(gar.GarFechaPago, "%d/%m/%Y") AS "NGarFechaPago",
					gar.CueId,
					
					gar.GarEstado,
					DATE_FORMAT(gar.GarTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NGarTiempoCreacion",
					DATE_FORMAT(gar.GarTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NGarTiempoModificacion",
					
					cli.CliNombre,
					cli.CliApellidoPaterno,
					cli.CliApellidoMaterno,
					cli.CliNumeroDocumento,
					cli.TdoId,
					
					ein.EinId,
					ein.EinVIN,
					fin.FinVehiculoKilometraje,
					
					ein.VmaId,
					ein.VmoId,
					ein.EinPlaca,
					
					ein.EinAnoFabricacion,
					ein.EinNumeroMotor,
					ein.EinColor,
					ein.EinPoliza,
					
					vma.VmaNombre,
					vmo.VmoNombre,
					
					fin.FinId,
					
					lti.LtiNombre,
					lti.LtiAbreviatura,
					
					DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",
					DATE_FORMAT(fin.FinTiempoTrabajoTerminado, "%d/%m/%Y") AS "NFinTiempoTrabajoTerminado",
					
					cam.CamBoletinCodigo,
					cam.CamNombre,
				
					(SELECT 
					COUNT(gll.GllId) 
					FROM tblgllgarantiallamada gll 
					WHERE gll.GarId = gar.GarId
					AND gll.GllEstado = 3) AS "GarTotalLlamadas",
					
					amo.AmoId
					
					
	
					FROM tblgargarantia gar
					
				LEFT JOIN tblclicliente cli
				ON gar.CliId = cli.CliId
					
					LEFT JOIN tblfccfichaaccion fcc
					ON gar.FccId = fcc.FccId
					
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amo.FccId = fcc.FccId
					
						
						LEFT JOIN tblfimfichaingresomodalidad fim
						ON fcc.FimId = fim.FimId
							LEFT JOIN tblfinfichaingreso fin
							ON fim.FinId = fin.FinId
								LEFT JOIN tbleinvehiculoingreso ein
								ON fin.EinId = ein.EinId
									LEFT JOIN tblvmavehiculomarca vma
									ON ein.VmaId = vma.VmaId
										LEFT JOIN tblvmovehiculomodelo vmo
										ON ein.VmoId = vmo.VmoId
											LEFT JOIN tbllticlientetipo lti
											ON cli.LtiId = lti.LtiId
									
									LEFT JOIN tblcamcampana cam
									ON fin.CamId = cam.CamId
										
				WHERE 1 = 1 '.$filtrar.$fecha.$estado.$moneda.$fingreso.$faccion.$orden.$paginacion;											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsGarantia = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$Garantia = new $InsGarantia();
                    $Garantia->GarId = $fila['GarId'];
					$Garantia->FccId = $fila['FccId'];
					$Garantia->CliId = $fila['CliId'];
					
					$Garantia->GarFechaEmision = $fila['NGarFechaEmision'];
					$Garantia->GarFechaVenta = $fila['NGarFechaVenta'];
					
					$Garantia->GarDireccion = $fila['GarDireccion'];
					$Garantia->GarCiudad = $fila['GarCiudad'];
					$Garantia->GarTelefono = $fila['GarTelefono'];
					$Garantia->GarCelular = $fila['GarCelular'];
					
					$Garantia->MonId = $fila['MonId'];
					$Garantia->GarTipoCambio = $fila['GarTipoCambio'];
					
					
					
					$Garantia->GarPorcentajeImpuestoVenta = $fila['GarPorcentajeImpuestoVenta'];
					$Garantia->GarSubTotalRepuestoStock = $fila['GarSubTotalRepuestoStock'];
					$Garantia->GarFactorPorcentaje1 = $fila['GarFactorPorcentaje1'];
					$Garantia->GarSubTotalRepuestoOtro = $fila['GarSubTotalRepuestoOtro'];
					$Garantia->GarFactorPorcentaje2 = $fila['GarFactorPorcentaje2'];
					
					$Garantia->GarTotalRepuesto = $fila['GarTotalRepuesto'];
					$Garantia->GarTotalManoObra = $fila['GarTotalManoObra'];
					
					$Garantia->GarSubTotal = $fila['GarSubTotal'];
					$Garantia->GarImpuesto = $fila['GarImpuesto'];
					$Garantia->GarTotal = $fila['GarTotal'];
			
			
					$Garantia->GarTarifaAutorizada = $fila['GarTarifaAutorizada'];
					$Garantia->GarModelo = $fila['GarModelo'];
					$Garantia->GarCausa = $fila['GarCausa'];
					$Garantia->GarObservacion = $fila['GarObservacion'];
					$Garantia->GarObservacionImpresa = $fila['GarObservacionImpresa'];
					
					$Garantia->GarTransaccionFecha = $fila['NGarTransaccionFecha'];
					$Garantia->GarTransaccionNumero = $fila['GarTransaccionNumero'];
					$Garantia->GarObservacionFinal = $fila['GarObservacionFinal'];

					$Garantia->GarNumeroComprobante = $fila['GarNumeroComprobante'];
					$Garantia->GarFechaPago = $fila['NGarFechaPago'];
					$Garantia->CueId = $fila['CueId'];
				
					$Garantia->GarEstado = $fila['GarEstado'];
					$Garantia->GarTiempoCreacion = $fila['NGarTiempoCreacion'];  
					$Garantia->GarTiempoModificacion = $fila['NGarTiempoModificacion']; 
					
			$Garantia->CliNombre = $fila['CliNombre'];
			$Garantia->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$Garantia->CliApellidoMaterno = $fila['CliApellidoMaterno'];
			$Garantia->CliNumeroDocumento = $fila['CliNumeroDocumento'];
			$Garantia->TdoId = $fila['TdoId'];
			
			
			$Garantia->EinId = $fila['EinId'];
			$Garantia->EinVIN = $fila['EinVIN'];
			$Garantia->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje'];
			
			$Garantia->VmaId = $fila['VmaId'];
			$Garantia->VmoId = $fila['VmoId'];
			$Garantia->EinPlaca = $fila['EinPlaca'];
			
			$Garantia->EinAnoFabricacion = $fila['EinAnoFabricacion'];
			$Garantia->EinNumeroMotor = $fila['EinNumeroMotor'];
			$Garantia->EinColor = $fila['EinColor'];
			$Garantia->EinPoliza = $fila['EinPoliza'];

				
			$Garantia->VmaNombre = $fila['VmaNombre'];
			$Garantia->VmoNombre = $fila['VmoNombre'];
			
			$Garantia->FinId = $fila['FinId'];
			
			$Garantia->LtiNombre = $fila['LtiNombre'];
			$Garantia->LtiAbreviatura = $fila['LtiAbreviatura'];
				
			$Garantia->FinFecha = $fila['NFinFecha'];
			$Garantia->FinTiempoTrabajoTerminado = $fila['NFinTiempoTrabajoTerminado'];
			
			$Garantia->CamBoletinCodigo = $fila['CamBoletinCodigo'];
			$Garantia->CamNombre = $fila['CamNombre'];
			
			$Garantia->GarTotalLlamadas = $fila['GarTotalLlamadas'];
		 
		 $Garantia->AmoId = $fila['AmoId'];
		 
		 
		 
			switch($Garantia->GarEstado){
				
				case 1:
					$Garantia->GarEstadoDescripcion =  "Pendiente";
				break;
				
				case 5:
					$Garantia->GarEstadoDescripcion =  "Entregado";
				break;
				
				case 6:
					$Garantia->GarEstadoDescripcion =  "Anulado";
				break;
                
				case 7:
					$Garantia->GarEstadoDescripcion =  "C/ Transaccion";
				break;
                
				case 8:
					$Garantia->GarEstadoDescripcion =  "Pagado";
				break;
				
				case 9:
					$Garantia->GarEstadoDescripcion =  "Facturado";
				break;
				
			}
			
			
                    $Garantia->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Garantia;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		


	
	//Accion eliminar	 
	public function MtdEliminarGarantia($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsGarantiaDetalle = new ClsGarantiaDetalle();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){
					$aux = explode("%",$elemento);	
					
					$ResGarantiaDetalle = $InsGarantiaDetalle->MtdObtenerGarantiaDetalles(NULL,NULL,'GdeId','Desc',NULL,$aux[0]);
					$ArrGarantiaDetalles = $ResGarantiaDetalle['Datos'];

					if(!empty($ArrGarantiaDetalles)){
						$amdetalle = '';

						foreach($ArrGarantiaDetalles as $DatGarantiaDetalle){
							$amdetalle .= '#'.$DatGarantiaDetalle->GdeId;
						}

						if(!$InsGarantiaDetalle->MtdEliminarGarantiaDetalle($amdetalle)){								
							$error = true;
						}
							
					}
					
					if(!$error) {		
						$sql = 'DELETE FROM tblgargarantia WHERE  (GarId = "'.($aux[0]).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarGarantia(3,"Se elimino la Garantia",$aux);		
						}
					}
					
				}
			$i++;

			}

			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}							
	}
	
	
	//Accion eliminar	 
	public function MtdActualizarEstadoGarantia($oElementos,$oEstado,$oTransaccion=true) {

		$error = false;

		if($oTransaccion){
			$this->InsMysql->MtdTransaccionIniciar();
		}

		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){

					$sql = 'UPDATE tblgargarantia SET GarEstado = '.$oEstado.' WHERE GarId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						
							$Auditoria = "Se actualizo el Estado de la Garantia";
						

						$this->GarId = $elemento;						
						$this->MtdAuditarGarantia(2,$Auditoria,$elemento);

					}
				}
			$i++;
	
			}

		if($error){
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionDeshacer();			
			}
			return false;
		}else{	
			if($oTransaccion){	
				$this->InsMysql->MtdTransaccionHacer();			
			}
			return true;
		}									
	}
	
	
	
	public function MtdGenerarGarantia($oElementos,$oTransaccion = true,$oCambiarEstado = true) {
		
		global $EmpresaImpuestoVenta;
		global $EmpresaMonedaId;
		global $InsConfiguracionEmpresa;
		
		$InsConfiguracionEmpresa = new ClsConfiguracionEmpresa();
		$InsConfiguracionEmpresa->CemId = "CEM-10000";
		$InsConfiguracionEmpresa->MtdObtenerConfiguracionEmpresa();	

		$error = false;

		if($oTransaccion){
			$this->InsMysql->MtdTransaccionIniciar();
		}

		//deb($oElementos);
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
					

					$InsFichaIngreso = new ClsFichaIngreso();
					$InsFichaIngreso->FinId = $elemento;
					$InsFichaIngreso->MtdObtenerFichaIngreso();
					$validar = 0;
					
					
					$modalidades= 0;	

					if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
						foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
							$InsFichaAccion = $DatFichaIngresoModalidad->FichaAccion;
							if($InsFichaAccion->MinSigla == "CA" or $InsFichaAccion->MinSigla == "GA" or $InsFichaAccion->MinSigla == "PO" or $InsFichaAccion->MinSigla == "IF" or $InsFichaAccion->MinSigla == "PP" or $InsFichaAccion->MinSigla == "GR" ){
								
								$modalidades++;
									
							}
							
						}
					}
					

								if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
									foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
										
										$GuardarFichaAccion = true;
										
										$InsFichaAccion = $DatFichaIngresoModalidad->FichaAccion;
										$InsTallerPedido = $DatFichaIngresoModalidad->FichaAccion->TallerPedido;
										
											//deb($InsFichaAccion->MinSigla);
											
											/*
											if(oModalidadIngresoSigla == "GA" 
											|| oModalidadIngresoSigla == "CA" 
											|| oModalidadIngresoSigla == "PO"  
											|| oModalidadIngresoSigla == "IF" 
											|| oModalidadIngresoSigla == "AD" 
											|| oModalidadIngresoSigla == "PP" 
											|| oModalidadIngresoSigla == "OB" 
											){
											
											*/
											if($InsFichaAccion->MinSigla == "CA" 
											or $InsFichaAccion->MinSigla == "GA" 
											or $InsFichaAccion->MinSigla == "PO" 
											or $InsFichaAccion->MinSigla == "IF" 
											or $InsFichaAccion->MinSigla == "PP"
											or $InsFichaAccion->MinSigla == "GR" ){
												
												
												$GarantiaId = $this->MtdVerificarExisteGarantia("FccId",$InsFichaAccion->FccId);
											
												//if(!$ExisteGarantia){		
												if(empty($GarantiaId)){		
												
														$InsFichaIngreso = new ClsFichaIngreso();
														$InsFichaIngreso->FinId = $InsFichaAccion->FinId;
														$InsFichaIngreso->MtdObtenerFichaIngreso();
						
						
														$this->FinId = $InsFichaIngreso->FinId;
														$this->FinVehiculoKilometraje = $InsFichaIngreso->FinVehiculoKilometraje;
														
														$this->GarFechaEmision = FncCambiaFechaAMysql($InsFichaIngreso->FinFecha);//date("d/m/Y");
														
														list($this->GarAno,$this->GarMes,$aux) = explode("-",$this->GarFechaEmision);
														
														$this->EinVIN = $InsFichaIngreso->EinVIN;
														$this->VmaNombre = $InsFichaIngreso->VmaNombre;
														$this->VmoNombre = $InsFichaIngreso->VmaNombre;
														$this->GarModelo = $InsFichaIngreso->VmaNombre." ".$InsFichaIngreso->VmoNombre." ".$InsFichaIngreso->VveNombre;
														$this->EinPlaca = $InsFichaIngreso->EinPlaca;
													
														$this->VmaId = $InsFichaIngreso->VmaId;
														$this->VmoId = $InsFichaIngreso->VmoId;
														$this->VmoId = $InsFichaIngreso->VmoId;
														
														$this->FccId = $InsFichaAccion->FccId;
														
														$this->CliId = $InsFichaIngreso->CliId;
														$this->CliNombre = $InsFichaIngreso->CliNombre;
														$this->CliApellidoPaterno = $InsFichaIngreso->CliApellidoPaterno;
														$this->CliApellidoMaterno = $InsFichaIngreso->CliApellidoMaterno;
														$this->TdoId = $InsFichaIngreso->TdoId;
														$this->CliNumeroDocumento = $InsFichaIngreso->CliNumeroDocumento;
														$this->GarDireccion = $InsFichaIngreso->CliDireccion."".$InsFichaIngreso->CliDistrito." - ".$InsFichaIngreso->CliProvincia." - ".$InsFichaIngreso->CliProvincia;
														$this->GarCiudad = "Tacna";
														$this->GarTelefono = $InsFichaIngreso->FinTelefono;
														$this->GarCelular = $InsFichaIngreso->FinCelular;
														
														$this->MonId = "MON-10001";
														$this->GarTarifaAutorizada = 50;
														
														
														if($InsFichaAccion->MinSigla == "PP"){
				
																$causa = 1;
																if(!empty($InsFichaAccion->FichaAccionTarea)){
																	foreach($InsFichaAccion->FichaAccionTarea as $DatFichaAccionTarea){
																		
																		
																		$this->GarCausa .= " ".$causa.".- ".$DatFichaAccionTarea->FatDescripcion.chr(13);
																		$causa++;
																		
																	}
																}	
																
																
																$solucion = 1;
																if(!empty($InsFichaAccion->FichaAccionTarea)){
																	foreach($InsFichaAccion->FichaAccionTarea as $DatFichaAccionTarea){
																		
																		
																		switch($DatFichaAccionTarea->FatAccion){
																			case "L":
																				$this->GarSolucion .= "PLANCHADO/".$DatFichaAccionTarea->FatDescripcion.chr(13);											
																			break;
																			
																			case "N":
																				$this->GarSolucion .= "PINTADO/".$DatFichaAccionTarea->FatDescripcion.chr(13);													
																			break;
																			
																			case "E":
																					$this->GarSolucion .= "CENTRADO/".$DatFichaAccionTarea->FatDescripcion.chr(13);																									
																			break;
																			
																			case "Z":
																				$this->GarSolucion .= "REPARACION/".$DatFichaAccionTarea->FatDescripcion.chr(13);												
																			break;
																		}
																		
																		$solucion++;
																		
																	}
																}	
																
								
														}else{
															$this->GarCausa = addslashes(strip_tags($InsFichaAccion->FccCausa));
															$this->GarSolucion = addslashes(strip_tags($InsFichaAccion->FccSolucion));	
															
																							
														}
														
		
														$InsTipoCambio = new ClsTipoCambio();
														$InsTipoCambio->MonId = "MON-10001";
														$InsTipoCambio->TcaFecha = date("Y-m-d");
												
														$InsTipoCambio->MtdObtenerTipoCambioActual();
												
														if(empty($InsTipoCambio->TcaId)){
															$InsTipoCambio->MtdObtenerTipoCambioUltimo();
														}
															
														$this->GarTipoCambio = $InsTipoCambio->TcaMontoComercial;
														$this->GarPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
														
														$this->GarObservacion = chr(13).date("d/m/Y H:i:s")." - Garantia Generada de Ord. Trab.:".$InsFichaIngreso->FinId;
						
														$this->GarEstado = 1;
														$this->GarTiempoCreacion = date("Y-m-d H:i:s");
														$this->GarTiempoModificacion = date("Y-m-d H:i:s");
							
														$this->GarSubTotalRepuestoStock = 0;
														$this->GarFactorPorcentaje1 = 0;
														$this->GarSubTotalRepuestoOtro = 0;
														$this->GarFactorPorcentaje2 = 0;
														
														$this->GarTotalRepuesto = 0;
														$this->GarTotalManoObra = 0;
														
														$this->GarSubTotal = 0;
														$this->GarImpuesto = 0;
														$this->GarTotal = 0;
														
														
														$InsTallerPedido = new ClsTallerPedido();
														
														$ResTallerPedido = $InsTallerPedido->MtdObtenerTallerPedidos(NULL,NULL,NULL,'AmoTiempoCreacion','DESC','',NULL,NULL,NULL,$InsFichaAccion->FccId,NULL,0,0,NULL,NULL,false,NULL);
														$ArrTallerPedidos = $ResTallerPedido['Datos'];
														
														if(!empty($ArrTallerPedidos)){	
															foreach($ArrTallerPedidos as $DatTallerPedido){
												
																$InsTallerPedido->AmoId = $DatTallerPedido->AmoId; 
																$InsTallerPedido->MtdObtenerTallerPedido();	
																
																
																if(!empty($InsTallerPedido->TallerPedidoDetalle)){
																	foreach($InsTallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){	
		
																		$ProductoListaPrecio = 0;
		
																		if(!empty($DatTallerPedidoDetalle->ProCodigoOriginal)){
																			
																			$InsProductoListaPrecio = new ClsProductoListaPrecio();
																			$RepProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatTallerPedidoDetalle->ProCodigoOriginal,"PlpId","ASC","1",NULL);
																			$ArrProductoListaPrecios = $RepProductoListaPrecio['Datos'];
																			
																			foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){
																				
																				if($this->MonId <> $EmpresaMonedaId){						
																					if($DatProductoListaPrecio->MonId == $this->MonId){
																						$ProductoListaPrecio = $DatProductoListaPrecio->PlpPrecioReal;
																					}else{
																						$ProductoListaPrecio = ($DatProductoListaPrecio->PlpPrecio/$this->GarTipoCambio);
																					}					
																				}else{
																					$ProductoListaPrecio = $DatProductoListaPrecio->PlpPrecio;
																				}
																			}
																			
																			if(empty($ProductoListaPrecio)){
																				
																				$InsListaPrecio = new ClsListaPrecio();//MtdObtenerListaPrecios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'LprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oClienteTipo=NULL,$oUnidadMedida=NULL);
																				$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,'LprId', 'ASC',"1",$DatTallerPedidoDetalle->ProId,"LTI-10015",$DatTallerPedidoDetalle->UmeId);
																				$ArrListaPrecios = $ResListaPrecio['Datos'];
																				
																				foreach($ArrListaPrecios as $DatListaPrecio){
																					
																					if($this->MonId == $EmpresaMonedaId){	
																						
																						$ProductoListaPrecio = $DatListaPrecio->LprCosto;
																										
																					}else{
																						
																						//deb($DatTallerPedidoDetalle->ProId." - ".$EmpresaMonedaId." - ".$this->MonId);
																						if($DatListaPrecio->MonId == $this->MonId){
																							$ProductoListaPrecio = ($DatListaPrecio->LprCosto/$DatListaPrecio->ProTipoCambio);
																						}else{
																							$ProductoListaPrecio = ($DatListaPrecio->LprCosto/$this->GarTipoCambio);
																						}	
																						
																					}
																					
																					
																					//if($this->MonId <> $EmpresaMonedaId){		
		//																			
		//																				//deb($DatTallerPedidoDetalle->ProId." - ".$EmpresaMonedaId." - ".$this->MonId);
		//																				if($EmpresaMonedaId == $this->MonId){
		//																					$ProductoListaPrecio = $DatListaPrecio->LprCosto;
		//																				}else{
		//																					$ProductoListaPrecio = ($DatListaPrecio->LprCosto/$this->GarTipoCambio);
		//																				}					
		//																			}else{
		//																				$ProductoListaPrecio = $DatListaPrecio->LprCosto;
		//																			}
																				}
																			
																			}
																			
																		}
																		
																		$CostoTotal = $ProductoListaPrecio * $DatTallerPedidoDetalle->AmdCantidad;
																		$MargenUtilidad = empty($InsConfiguracionEmpresa->CalMargen)?0:$InsConfiguracionEmpresa->CalMargen;
		
																		$InsGarantiaDetalle1 = new ClsGarantiaDetalle();
																		$InsGarantiaDetalle1->GdeId = NULL;
																		$InsGarantiaDetalle1->AmdId = $DatTallerPedidoDetalle->AmdId;
																		$InsGarantiaDetalle1->ProId = $DatTallerPedidoDetalle->ProId;
																		$InsGarantiaDetalle1->UmeId = $DatTallerPedidoDetalle->UmeId;
																		
																		$InsGarantiaDetalle1->GdeCodigo = $DatTallerPedidoDetalle->ProCodigoOriginal;
																		$InsGarantiaDetalle1->GdeDescripcion = $DatTallerPedidoDetalle->ProNombre;
															
																		if($this->MonId<>$EmpresaMonedaId ){
																			$InsGarantiaDetalle1->GdeCosto = $ProductoListaPrecio * $this->GarTipoCambio;
																		}else{
																			$InsGarantiaDetalle1->GdeCosto = $ProductoListaPrecio;
																		}
															
																		$InsGarantiaDetalle1->GdeCantidad = $DatTallerPedidoDetalle->AmdCantidad;
																		
																		if($this->MonId<>$EmpresaMonedaId ){
																			$InsGarantiaDetalle1->GdeCostoTotal = $CostoTotal * $this->GarTipoCambio;
																		}else{
																			$InsGarantiaDetalle1->GdeCostoTotal = $CostoTotal;
																		}		
																		
																		$InsGarantiaDetalle1->GdeMargen = $MargenUtilidad;
																		
																		if($this->MonId<>$EmpresaMonedaId ){
																			$InsGarantiaDetalle1->GdeCostoMargen = (( ($MargenUtilidad/100) * $CostoTotal)+ $CostoTotal) * $this->GarTipoCambio;
																		}else{
																			$InsGarantiaDetalle1->GdeCostoMargen = ( ( ($MargenUtilidad/100) * $CostoTotal)+ $CostoTotal );
																		}
															
																		$InsGarantiaDetalle1->GdeEstado = 1;
																		$InsGarantiaDetalle1->GdeTiempoCreacion = date("Y-m-d H:i:s");
																		$InsGarantiaDetalle1->GdeTiempoModificacion = date("Y-m-d H:i:s");
																		$InsGarantiaDetalle1->GdeEliminado = 1;				
																		$InsGarantiaDetalle1->InsMysql = NULL;
																		
																		$this->GarantiaDetalle[] = $InsGarantiaDetalle1;		
																		//$this->GarSubTotalRepuestoStock += $InsGarantiaDetalle1->GdeCostoMargen;	
																		$this->GarSubTotalRepuestoStock += $InsGarantiaDetalle1->GdeCostoTotal;	
						
																	}
																}
																
																
																
									
															}
														}
		
														
														
														if(!empty($InsConfiguracionEmpresa->CalId)){
						
															if($this->MonId <> $InsConfiguracionEmpresa->MonId){
																
																$InsConfiguracionEmpresa->CalCosto = $InsConfiguracionEmpresa->CalCosto / $InsConfiguracionEmpresa->CalTipoCambio;
															}
						
														}
														
														if(!empty($InsFichaAccion->FichaAccionTempario)){
															foreach($InsFichaAccion->FichaAccionTempario as $DatFichaAccionTempario){					
													
																$Costo = $InsConfiguracionEmpresa->CalCosto * $DatFichaAccionTempario->FaeTiempo;
																
																$InsGarantiaOperacion1 = new ClsGarantiaOperacion();
																$InsGarantiaOperacion1->GopId = NULL;
																$InsGarantiaOperacion1->FaeId = $DatFichaAccionTempario->FaeId;

																$InsGarantiaOperacion1->GopNumero = $DatFichaAccionTempario->FaeCodigo;
													
																if($this->MonId<>$EmpresaMonedaId ){
																	$InsGarantiaOperacion1->GopCosto = $Costo * $this->GarTipoCambio;
																}else{
																	$InsGarantiaOperacion1->GopCosto = $Costo;
																}
																
																$InsGarantiaOperacion1->GopTiempo = $DatFichaAccionTempario->FaeTiempo;
													
																if($this->MonId<>$EmpresaMonedaId ){
																	$InsGarantiaOperacion1->GopValor = $InsConfiguracionEmpresa->CalCosto * $this->GarTipoCambio;
																}else{
																	$InsGarantiaOperacion1->GopValor = $InsConfiguracionEmpresa->CalCosto;
																}
															
																$InsGarantiaOperacion1->GopEstado = 1;
																$InsGarantiaOperacion1->GopTiempoCreacion = date("Y-m-d H:i:s");
																$InsGarantiaOperacion1->GopTiempoModificacion = date("Y-m-d H:i:s");
																$InsGarantiaOperacion1->GopEliminado = 1;				
																$InsGarantiaOperacion1->InsMysql = NULL;
																
																$this->GarantiaOperacion[] = $InsGarantiaOperacion1;		
																			
																$this->GarTotalManoObra += $InsGarantiaOperacion1->GopCosto;	
																			
		
													
															}
														}		
														
							
							
														$this->GarTotalRepuesto = $this->GarSubTotalRepuestoStock;
														$this->GarSubTotal = $this->GarTotalRepuesto + $this->GarTotalManoObra;
														$this->GarImpuesto = $this->GarSubTotal * ($this->GarPorcentajeImpuestoVenta/100);
														$this->GarTotal = $this->GarSubTotal + $this->GarImpuesto;
					
			
													if($this->MtdRegistrarGarantia(false)){
														
														if($oCambiarEstado){
															
																
															//switch($InsFichaIngreso->FinEstado){
//																case 73:
//																	$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,74,false);
//																	$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,75,false);
//																	$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,9,false);
//																break;
//																
//																case 74:
//																	$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,75,false);
//																	$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,9,false);
//																break;
//																
//																case 75:
//																	$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,9,false);
//																break;
//															}
															
														}
														
														$validar++;
														
													}
													
													
												}else{
													
														$this->GarId = $GarantiaId;
														$this->MtdObtenerGarantia();
														
														if(!empty($this->GarantiaDetalle)){
															foreach($this->GarantiaDetalle as $DatGarantiaDetalle){										
															$InsGarantiaDetalle = new ClsGarantiaDetalle();
															$InsGarantiaDetalle->MtdEliminarGarantiaDetalle($DatGarantiaDetalle->GdeId);
																
															}
															
															$this->GarantiaDetalle = NULL;
														}
														
														if(!empty($this->GarantiaOperacion)){
															foreach($this->GarantiaOperacion as $DatGarantiaDetalle){										
															
																$InsClsGarantiaOperacion = new ClsGarantiaOperacion();
																$InsClsGarantiaOperacion->MtdEliminarGarantiaOperacion($DatGarantiaDetalle->GopId);
																
															}
															
															$this->GarantiaOperacion = NULL;
														}
														
														$InsFichaIngreso = new ClsFichaIngreso();
														$InsFichaIngreso->FinId = $InsFichaAccion->FinId;
														$InsFichaIngreso->MtdObtenerFichaIngreso();
						
						
														$this->FinId = $InsFichaIngreso->FinId;
														$this->FinVehiculoKilometraje = $InsFichaIngreso->FinVehiculoKilometraje;
														
														$this->GarFechaEmision = FncCambiaFechaAMysql($InsFichaIngreso->FinFecha);//date("d/m/Y");
														
														list($this->GarAno,$this->GarMes,$aux) = explode("-",$this->GarFechaEmision);
														
														$this->EinVIN = $InsFichaIngreso->EinVIN;
														$this->VmaNombre = $InsFichaIngreso->VmaNombre;
														$this->VmoNombre = $InsFichaIngreso->VmaNombre;
														$this->GarModelo = $InsFichaIngreso->VmaNombre." ".$InsFichaIngreso->VmoNombre." ".$InsFichaIngreso->VveNombre;
														$this->EinPlaca = $InsFichaIngreso->EinPlaca;
													
														$this->VmaId = $InsFichaIngreso->VmaId;
														$this->VmoId = $InsFichaIngreso->VmoId;
														$this->VmoId = $InsFichaIngreso->VmoId;
														
														$this->FccId = $InsFichaAccion->FccId;
														
														$this->CliId = $InsFichaIngreso->CliId;
														$this->CliNombre = $InsFichaIngreso->CliNombre;
														$this->CliApellidoPaterno = $InsFichaIngreso->CliApellidoPaterno;
														$this->CliApellidoMaterno = $InsFichaIngreso->CliApellidoMaterno;
														$this->TdoId = $InsFichaIngreso->TdoId;
														$this->CliNumeroDocumento = $InsFichaIngreso->CliNumeroDocumento;
														$this->GarDireccion = $InsFichaIngreso->FinDireccion;
														$this->GarCiudad = "Tacna";
														$this->GarTelefono = $InsFichaIngreso->FinTelefono;
														$this->GarCelular = $InsFichaIngreso->FinCelular;
														
														$this->MonId = "MON-10001";
														$this->GarTarifaAutorizada = 50;

														if($InsFichaAccion->MinSigla == "PP"){
				
																$causa = 1;
																if(!empty($InsFichaAccion->FichaAccionTarea)){
																	foreach($InsFichaAccion->FichaAccionTarea as $DatFichaAccionTarea){
																		
																		$this->GarCausa .= " ".$causa.".- ".$DatFichaAccionTarea->FatDescripcion.chr(13);
																		$causa++;
																		
																	}
																}	
																
																$solucion = 1;
																if(!empty($InsFichaAccion->FichaAccionTarea)){
																	foreach($InsFichaAccion->FichaAccionTarea as $DatFichaAccionTarea){
																		
																		
																		switch($DatFichaAccionTarea->FatAccion){
																			case "L":
																				$this->GarSolucion .= "PLANCHADO/".$DatFichaAccionTarea->FatDescripcion.chr(13);											
																			break;
																			
																			case "N":
																				$this->GarSolucion .= "PINTADO/".$DatFichaAccionTarea->FatDescripcion.chr(13);													
																			break;
																			
																			case "E":
																					$this->GarSolucion .= "CENTRADO/".$DatFichaAccionTarea->FatDescripcion.chr(13);																									
																			break;
																			
																			case "Z":
																				$this->GarSolucion .= "REPARACION/".$DatFichaAccionTarea->FatDescripcion.chr(13);												
																			break;
																		}
																		
																		$solucion++;
																		
																	}
																}	
								
														}else{
															//$this->GarCausa = addslashes($InsFichaAccion->FccCausa);
															//$this->GarSolucion = addslashes($InsFichaAccion->FccSolucion);	
															$this->GarCausa = addslashes(strip_tags($InsFichaAccion->FccCausa));
															$this->GarSolucion = addslashes(strip_tags($InsFichaAccion->FccSolucion));	
//																								
														}
														
														
														$InsTipoCambio = new ClsTipoCambio();
														$InsTipoCambio->MonId = "MON-10001";
														$InsTipoCambio->TcaFecha = date("Y-m-d");
												
														$InsTipoCambio->MtdObtenerTipoCambioActual();
												
														if(empty($InsTipoCambio->TcaId)){
															$InsTipoCambio->MtdObtenerTipoCambioUltimo();
														}
															
														$this->GarTipoCambio = $InsTipoCambio->TcaMontoComercial;
														$this->GarPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
														
														$this->GarObservacion = chr(13).date("d/m/Y H:i:s")." - Garantia Generada de Ord. Trab.:".$InsFichaIngreso->FinId;
														$this->GarEstado = 1;
														$this->GarTiempoCreacion = date("Y-m-d H:i:s");
														$this->GarTiempoModificacion = date("Y-m-d H:i:s");
	
														$this->GarSubTotalRepuestoStock = 0;
														$this->GarFactorPorcentaje1 = 0;
														$this->GarSubTotalRepuestoOtro = 0;
														$this->GarFactorPorcentaje2 = 0;
														
														$this->GarTotalRepuesto = 0;
														$this->GarTotalManoObra = 0;
														
														$this->GarSubTotal = 0;
														$this->GarImpuesto = 0;
														$this->GarTotal = 0;
							
														
														
														$InsTallerPedido = new ClsTallerPedido();
														
														$ResTallerPedido = $InsTallerPedido->MtdObtenerTallerPedidos(NULL,NULL,NULL,'AmoTiempoCreacion','DESC','',NULL,NULL,NULL,$InsFichaAccion->FccId,NULL,0,0,NULL,NULL,false,NULL);
														$ArrTallerPedidos = $ResTallerPedido['Datos'];
														
														if(!empty($ArrTallerPedidos)){	
															foreach($ArrTallerPedidos as $DatTallerPedido){
												
																$InsTallerPedido->AmoId = $DatTallerPedido->AmoId; 
																$InsTallerPedido->MtdObtenerTallerPedido();	
																
																//deb($InsTallerPedido->TallerPedidoDetalle);
																if(!empty($InsTallerPedido->TallerPedidoDetalle)){
																	foreach($InsTallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){	
		
																		$ProductoListaPrecio = 0;
															
																		if(!empty($DatTallerPedidoDetalle->ProCodigoOriginal)){
																			
																			$InsProductoListaPrecio = new ClsProductoListaPrecio();
																			$RepProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatTallerPedidoDetalle->ProCodigoOriginal,"PlpId","ASC","1",NULL);
																			$ArrProductoListaPrecios = $RepProductoListaPrecio['Datos'];
		
																			foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){
																				
																				if($this->MonId <> $EmpresaMonedaId){	
																					
																					if($DatProductoListaPrecio->MonId == $this->MonId){
																						$ProductoListaPrecio = $DatProductoListaPrecio->PlpPrecioReal;
																					}else{
																						$ProductoListaPrecio = ($DatProductoListaPrecio->PlpPrecio/$this->GarTipoCambio);
																					}		
																				
																				}else{
																					$ProductoListaPrecio = $DatProductoListaPrecio->PlpPrecio;
																				}
																				
																			}
																			
																			
																			
																			
																			
																			if(empty($ProductoListaPrecio)){
																				
																				$InsListaPrecio = new ClsListaPrecio();//MtdObtenerListaPrecios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'LprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oClienteTipo=NULL,$oUnidadMedida=NULL);
																				$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,'LprId', 'ASC',"1",$DatTallerPedidoDetalle->ProId,"LTI-10015",$DatTallerPedidoDetalle->UmeId);
																				$ArrListaPrecios = $ResListaPrecio['Datos'];
																				
																				foreach($ArrListaPrecios as $DatListaPrecio){
																					
																					if($this->MonId == $EmpresaMonedaId){	
																						
																						$ProductoListaPrecio = $DatListaPrecio->LprCosto;
																										
																					}else{
																						
																						//deb($DatTallerPedidoDetalle->ProId." - ".$EmpresaMonedaId." - ".$this->MonId);
																						if($DatListaPrecio->MonId == $this->MonId){
																							$ProductoListaPrecio = ($DatListaPrecio->LprCosto/$DatListaPrecio->ProTipoCambio);
																						}else{
																							$ProductoListaPrecio = ($DatListaPrecio->LprCosto/$this->GarTipoCambio);
																						}	
																						
																					}
																					
																					
																					//if($this->MonId <> $EmpresaMonedaId){		
		//																			
		//																				//deb($DatTallerPedidoDetalle->ProId." - ".$EmpresaMonedaId." - ".$this->MonId);
		//																				if($EmpresaMonedaId == $this->MonId){
		//																					$ProductoListaPrecio = $DatListaPrecio->LprCosto;
		//																				}else{
		//																					$ProductoListaPrecio = ($DatListaPrecio->LprCosto/$this->GarTipoCambio);
		//																				}					
		//																			}else{
		//																				$ProductoListaPrecio = $DatListaPrecio->LprCosto;
		//																			}
																				}
																			
																			}
																			
																			
																		}
																		
																		//deb($ProductoListaPrecio);			
																		
																		
																		$CostoTotal = $ProductoListaPrecio * $DatTallerPedidoDetalle->AmdCantidad;
																		$MargenUtilidad = empty($InsConfiguracionEmpresa->CalMargen)?0:$InsConfiguracionEmpresa->CalMargen;
								
																		$InsGarantiaDetalle1 = new ClsGarantiaDetalle();
																		$InsGarantiaDetalle1->GdeId = NULL;
																		$InsGarantiaDetalle1->AmdId = $DatTallerPedidoDetalle->AmdId;
																		$InsGarantiaDetalle1->ProId = $DatTallerPedidoDetalle->ProId;
																		$InsGarantiaDetalle1->UmeId = $DatTallerPedidoDetalle->UmeId;
																		
																		$InsGarantiaDetalle1->GdeCodigo = $DatTallerPedidoDetalle->ProCodigoOriginal;
																		$InsGarantiaDetalle1->GdeDescripcion = $DatTallerPedidoDetalle->ProNombre;
															
																		if($this->MonId<>$EmpresaMonedaId ){
																			$InsGarantiaDetalle1->GdeCosto = $ProductoListaPrecio * $this->GarTipoCambio;
																		}else{
																			$InsGarantiaDetalle1->GdeCosto = $ProductoListaPrecio;
																		}
															
																		$InsGarantiaDetalle1->GdeCantidad = $DatTallerPedidoDetalle->AmdCantidad;
																		
																		if($this->MonId<>$EmpresaMonedaId ){
																			$InsGarantiaDetalle1->GdeCostoTotal = $CostoTotal * $this->GarTipoCambio;
																		}else{
																			$InsGarantiaDetalle1->GdeCostoTotal = $CostoTotal;
																		}		
																		
																		$InsGarantiaDetalle1->GdeMargen = $MargenUtilidad;
																		
																		if($this->MonId<>$EmpresaMonedaId ){
																			$InsGarantiaDetalle1->GdeCostoMargen = (( ($MargenUtilidad/100) * $CostoTotal)+ $CostoTotal) * $this->GarTipoCambio;
																		}else{
																			$InsGarantiaDetalle1->GdeCostoMargen = ( ( ($MargenUtilidad/100) * $CostoTotal)+ $CostoTotal );
																		}
															
																		$InsGarantiaDetalle1->GdeEstado = 1;
																		$InsGarantiaDetalle1->GdeTiempoCreacion = date("Y-m-d H:i:s");
																		$InsGarantiaDetalle1->GdeTiempoModificacion = date("Y-m-d H:i:s");
																		$InsGarantiaDetalle1->GdeEliminado = 1;				
																		$InsGarantiaDetalle1->InsMysql = NULL;
																		
																		$this->GarantiaDetalle[] = $InsGarantiaDetalle1;		
																		//$this->GarSubTotalRepuestoStock += $InsGarantiaDetalle1->GdeCostoMargen;	
																		$this->GarSubTotalRepuestoStock += $InsGarantiaDetalle1->GdeCostoTotal;	
						
																	}
																}
									
									
									
															}
														}
														
														
														
														if(!empty($InsConfiguracionEmpresa->CalId)){
						
															if($this->MonId <> $InsConfiguracionEmpresa->MonId){
																$InsConfiguracionEmpresa->CalCosto = $InsConfiguracionEmpresa->CalCosto / $InsConfiguracionEmpresa->CalTipoCambio;
															}
						
														}
														
													
														if(!empty($InsFichaAccion->FichaAccionTempario)){
															foreach($InsFichaAccion->FichaAccionTempario as $DatFichaAccionTempario){					
													
																$Costo = $InsConfiguracionEmpresa->CalCosto * $DatFichaAccionTempario->FaeTiempo;
																
																$InsGarantiaOperacion1 = new ClsGarantiaOperacion();
																$InsGarantiaOperacion1->GopId = NULL;
																$InsGarantiaOperacion1->FaeId = $DatFichaAccionTempario->FaeId;
																
																$InsGarantiaOperacion1->GopNumero = $DatFichaAccionTempario->FaeCodigo;
													
																if($this->MonId<>$EmpresaMonedaId ){
																	$InsGarantiaOperacion1->GopCosto = $Costo * $this->GarTipoCambio;
																}else{
																	$InsGarantiaOperacion1->GopCosto = $Costo;
																}
																
																$InsGarantiaOperacion1->GopTiempo = $DatFichaAccionTempario->FaeTiempo;
													
																if($this->MonId<>$EmpresaMonedaId ){
																	$InsGarantiaOperacion1->GopValor = $InsConfiguracionEmpresa->CalCosto * $this->GarTipoCambio;
																}else{
																	$InsGarantiaOperacion1->GopValor = $InsConfiguracionEmpresa->CalCosto;
																}
															
																$InsGarantiaOperacion1->GopEstado = 1;
																$InsGarantiaOperacion1->GopTiempoCreacion = date("Y-m-d H:i:s");
																$InsGarantiaOperacion1->GopTiempoModificacion = date("Y-m-d H:i:s");
																$InsGarantiaOperacion1->GopEliminado = 1;				
																$InsGarantiaOperacion1->InsMysql = NULL;
																
																$this->GarantiaOperacion[] = $InsGarantiaOperacion1;		
																			
																$this->GarTotalManoObra += $InsGarantiaOperacion1->GopCosto;	
																			
		
													
															}
														}		
														
							
							
														$this->GarTotalRepuesto = $this->GarSubTotalRepuestoStock;
														$this->GarSubTotal = $this->GarTotalRepuesto + $this->GarTotalManoObra;
														$this->GarImpuesto = $this->GarSubTotal * ($this->GarPorcentajeImpuestoVenta/100);
														$this->GarTotal = $this->GarSubTotal + $this->GarImpuesto;
					
														
														if($this->MtdEditarGarantia(false)){
															
														}
												
			
			
			
											
													$validar++;	
												}
							
					
												
											}//else{
											//	$validar++;	
											//}
										
										
										
							
									}
								}
							
					
							
							


					//deb($validar." - ".$modalidades);
					if($validar <> $modalidades ){
						$error = true;
					}else{
						
					}
					
	
					

	
					
				}
			$i++;
	
			}

		//deb($validar." - ".count($InsFichaIngreso->FichaIngresoModalidad));
		
		//if($validar <> count($InsFichaIngreso->FichaIngresoModalidad) ){
//		if($validar <> count($InsFichaIngreso->FichaIngresoModalidad) ){
//		if($validar <> $modalidades ){
//			$error = true;
//		}
					
					
		if($error){
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionDeshacer();			
			}
			return false;
		}else{	
			if($oTransaccion){	
				$this->InsMysql->MtdTransaccionHacer();			
			}
			return true;
		}									
	}
	
	
	public function MtdRegistrarGarantia($oTransaccion=true) {
	
		global $Resultado;
		$error = false;

		$this->MtdGenerarGarantiaId();
		
		if($oTransaccion){
			$this->InsMysql->MtdTransaccionIniciar();
		}
		

			if(!empty($this->GarFechaVenta)){
				
				$InsFichaAccion = new ClsFichaAccion();
				$InsFichaAccion->FccId = $this->FccId;
				$InsFichaAccion->MtdObtenerFichaAccion();
				
				$InsVehiculoIngreso = new ClsVehiculoIngreso();
				$InsVehiculoIngreso->MtdEditarClienteDato("CliDireccion",$this->GarFechaVenta,$InsFichaAccion->EinId);

			}

			$sql = 'INSERT INTO tblgargarantia (
			GarId,
			FccId,
			CliId,
			
			GarFechaEmision,
			GarFechaVenta,					
			
			GarDireccion,
			GarCiudad,
			GarTelefono,
			GarCelular,
			
			MonId,
			GarTipoCambio,
			
			GarPorcentajeImpuestoVenta,
			GarSubTotalRepuestoStock,
			GarFactorPorcentaje1,
			GarSubTotalRepuestoOtro,
			GarFactorPorcentaje2,
			
			GarTotalRepuesto,
			GarTotalManoObra,
			
			GarSubTotal,
			GarImpuesto,
			GarTotal,
			
			GarTarifaAutorizada,
			GarModelo,
			GarCausa,
			GarSolucion,
			
			GarObservacion,
			GarObservacionImpresa,
			
			

			GarTransaccionFecha,
			GarTransaccionNumero,
			GarObservacionFinal,

		
			CueId,
			
			GarEstado,			
			GarTiempoCreacion,
			GarTiempoModificacion) 
			VALUES (
			"'.($this->GarId).'", 
			"'.($this->FccId).'", 
			"'.($this->CliId).'", 

			"'.($this->GarFechaEmision).'", 
			'.(empty($this->GarFechaVenta)?"NULL,":'"'.$this->GarFechaVenta.'",').'
			
			"'.($this->GarDireccion).'",
			"'.($this->GarCiudad).'",
			"'.($this->GarTelefono).'",
			"'.($this->GarCelular).'",
			
			"'.($this->MonId).'",
			'.(empty($this->GarTipoCambio)?"NULL,":'"'.$this->GarTipoCambio.'",').'

			'.($this->GarPorcentajeImpuestoVenta).',
			'.($this->GarSubTotalRepuestoStock).',
			'.($this->GarFactorPorcentaje1).',
			'.($this->GarSubTotalRepuestoOtro).',
			'.($this->GarFactorPorcentaje2).',

			'.($this->GarTotalRepuesto).',
			'.($this->GarTotalManoObra).',

			'.($this->GarSubTotal).',
			'.($this->GarImpuesto).',
			'.($this->GarTotal).',

			'.($this->GarTarifaAutorizada).',
			"'.($this->GarModelo).'",
			"'.($this->GarCausa).'",
			"'.($this->GarSolucion).'",
			
			"'.($this->GarObservacion).'",
			"'.($this->GarObservacionImpresa).'",

			'.(empty($this->GarTransaccionFecha)?"NULL,":'"'.$this->GarTransaccionFecha.'",').'
			"'.($this->GarTransaccionNumero).'",
			"'.($this->GarObservacionFinal).'",
			
		
			NULL,
			
			'.($this->GarEstado).',
			"'.($this->GarTiempoCreacion).'",
			"'.($this->GarTiempoModificacion).'");';			

			if(!$error){
				$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
	
				if(!$resultado) {							
					$error = true;
				} 
			}

			if(!$error){			
			
				if (!empty($this->GarantiaDetalle)){		
						
					$validar = 0;				

					foreach ($this->GarantiaDetalle as $DatGarantiaDetalle){
						
						$InsGarantiaDetalle = new ClsGarantiaDetalle();
						$InsGarantiaDetalle->GarId = $this->GarId;
						
						$InsGarantiaDetalle->AmdId = $DatGarantiaDetalle->AmdId;
						$InsGarantiaDetalle->ProId = $DatGarantiaDetalle->ProId;
						$InsGarantiaDetalle->UmeId = $DatGarantiaDetalle->UmeId;
						
						$InsGarantiaDetalle->GdeCodigo = $DatGarantiaDetalle->GdeCodigo;
						$InsGarantiaDetalle->GdeDescripcion = $DatGarantiaDetalle->GdeDescripcion;
						
						$InsGarantiaDetalle->GdeCosto = $DatGarantiaDetalle->GdeCosto;
						$InsGarantiaDetalle->GdeCantidad = $DatGarantiaDetalle->GdeCantidad;
						$InsGarantiaDetalle->GdeCostoTotal = $DatGarantiaDetalle->GdeCostoTotal;
						$InsGarantiaDetalle->GdeMargen = $DatGarantiaDetalle->GdeMargen;
						$InsGarantiaDetalle->GdeCostoMargen = $DatGarantiaDetalle->GdeCostoMargen;
						

						$InsGarantiaDetalle->GdeEstado = $DatGarantiaDetalle->GdeEstado;
						$InsGarantiaDetalle->GdeTiempoCreacion = $DatGarantiaDetalle->GdeTiempoCreacion;
						$InsGarantiaDetalle->GdeTiempoModificacion = $DatGarantiaDetalle->GdeTiempoModificacion;						
						$InsGarantiaDetalle->GdeEliminado = $DatGarantiaDetalle->GdeEliminado;

						if($InsGarantiaDetalle->MtdRegistrarGarantiaDetalle()){
							$validar++;	
						}else{
							$Resultado.='#ERR_GAR_201';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->GarantiaDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			if(!$error){			

				if (!empty($this->GarantiaOperacion)){		

					$validar = 0;					
					$InsGarantiaOperacion = new ClsGarantiaOperacion();		
											
					foreach ($this->GarantiaOperacion as $DatGarantiaOperacion){

						$InsGarantiaOperacion->GarId = $this->GarId;
						$InsGarantiaOperacion->FaeId = $DatGarantiaOperacion->FaeId;
						
						$InsGarantiaOperacion->GopNumero = $DatGarantiaOperacion->GopNumero;
						$InsGarantiaOperacion->GopTiempo = $DatGarantiaOperacion->GopTiempo;
						$InsGarantiaOperacion->GopValor = $DatGarantiaOperacion->GopValor;
						$InsGarantiaOperacion->GopCosto = $DatGarantiaOperacion->GopCosto;
						
						$InsGarantiaOperacion->GopTransaccionNumero = $DatGarantiaOperacion->GopTransaccionNumero;
						$InsGarantiaOperacion->GopTransaccionFecha = $DatGarantiaOperacion->GopTransaccionFecha;
						$InsGarantiaOperacion->GopFechaAprobacion = $DatGarantiaOperacion->GopFechaAprobacion;
						$InsGarantiaOperacion->GopFechaPago = $DatGarantiaOperacion->GopFechaPago;
						$InsGarantiaOperacion->GopComprobanteNumero = $DatGarantiaOperacion->GopComprobanteNumero;
						
						$InsGarantiaOperacion->GopEstado = $DatGarantiaOperacion->GopEstado;							
						$InsGarantiaOperacion->GopTiempoCreacion = $DatGarantiaOperacion->GopTiempoCreacion;
						$InsGarantiaOperacion->GopTiempoModificacion = $DatGarantiaOperacion->GopTiempoModificacion;						
						$InsGarantiaOperacion->GopEliminado = $DatGarantiaOperacion->GopEliminado;
						
						if($InsGarantiaOperacion->MtdRegistrarGarantiaOperacion()){
							
							if(empty($InsGarantiaOperacion->FaeId)){
											
								//$InsFichaAccionTempario = new ClsFichaAccionTempario();
//								$InsFichaAccionTempario->FaeCodigo = 	$InsGarantiaOperacion->GopNumero;
//								$InsFichaAccionTempario->FaeTiempo = $InsGarantiaOperacion->GopTiempo;
//								$InsFichaAccionTempario->FaeEstado = 3;
//								$InsFichaAccionTempario->FaeTiempoCreacion = date("Y-m-d H:i:s");
//								$InsFichaAccionTempario->FaeTiempoModificacion = date("Y-m-d H:i:s");
//								$InsFichaAccionTempario->MtdRegistrarFichaAccionTempario();

$FichaAccionTemparioId = "";
											
											$InsFichaAccionTempario = new ClsFichaAccionTempario();

											$FichaAccionTemparioId = $InsFichaAccionTempario->MtdVerificarExisteFichaAccionTemparios("FaeCodigo",$InsGarantiaOperacion->GopNumero,$this->FccId);
											
											if(empty($FichaAccionTemparioId)){
												
												$InsFichaAccionTempario = new ClsFichaAccionTempario();
												$InsFichaAccionTempario->FccId = $this->FccId;
												$InsFichaAccionTempario->FaeCodigo = 	$InsGarantiaOperacion->GopNumero;
												$InsFichaAccionTempario->FaeTiempo = $InsGarantiaOperacion->GopTiempo;
												$InsFichaAccionTempario->FaeEstado = 3;
												$InsFichaAccionTempario->FaeTiempoCreacion = date("Y-m-d H:i:s");
												$InsFichaAccionTempario->FaeTiempoModificacion = date("Y-m-d H:i:s");
												$InsFichaAccionTempario->MtdRegistrarFichaAccionTempario();
												
											}else{
												
												$InsGarantiaOperacion = new ClsGarantiaOperacion();
												$InsGarantiaOperacion->MtdEditarGarantiaOperacionDato("FaeId",$FichaAccionTemparioId,$InsGarantiaOperacion->GopId);
													
											}
											
											
											
							}
										
										
							$validar++;	
						}else{
							$Resultado.='#ERR_GAR_301';
							$Resultado.='#Item Numero: '.($validar+1);
						}

					}					
					
					if(count($this->GarantiaOperacion) <> $validar ){
						$error = true;
					}					
								
				}				
			}
				
		if($error) {	
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionDeshacer();			
			}
			return false;
		} else {				
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionHacer();		
			}
			$this->MtdAuditarGarantia(1,"Se registro la Garantia",$this);			
			return true;
		}
					
	}
	
	public function MtdEditarGarantia($oTransaccion=true) {

		global $Resultado;
		$error = false;
			
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionIniciar();
			}
			
	
	
			if(!empty($this->GarFechaVenta)){
				
				$InsFichaAccion = new ClsFichaAccion();
				$InsFichaAccion->FccId = $this->FccId;
				$InsFichaAccion->MtdObtenerFichaAccion();
				
				$InsVehiculoIngreso = new ClsVehiculoIngreso();
				$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinFechaVenta",$this->GarFechaVenta,$InsFichaAccion->EinId);

			}
			
			
			$sql = 'UPDATE tblgargarantia SET
							
			GarFechaEmision = "'.($this->GarFechaEmision).'",
			CliId = "'.($this->CliId).'",
			'.(empty($this->GarFechaVenta)?'GarFechaVenta = NULL, ':'GarFechaVenta = "'.$this->GarFechaVenta.'",').'

			GarDireccion = "'.($this->GarDireccion).'",
			GarCiudad = "'.($this->GarCiudad).'",
			GarTelefono = "'.($this->GarTelefono).'",
			GarCelular = "'.($this->GarCelular).'",
			
			MonId = "'.($this->MonId).'",			
			'.(empty($this->GarTipoCambio)?'GarTipoCambio = NULL, ':'GarTipoCambio = '.$this->GarTipoCambio.',').'
			
			GarPorcentajeImpuestoVenta = '.($this->GarPorcentajeImpuestoVenta).',
			
			GarSubTotalRepuestoStock = '.($this->GarSubTotalRepuestoStock).',
			GarFactorPorcentaje1 = '.($this->GarFactorPorcentaje1).',	
			GarSubTotalRepuestoOtro = '.($this->GarSubTotalRepuestoOtro).',	
			GarFactorPorcentaje2 = '.($this->GarFactorPorcentaje2).',	
			
			GarTotalRepuesto = '.($this->GarTotalRepuesto).',	
			GarTotalManoObra = '.($this->GarTotalManoObra).',	
			
			
			GarTarifaAutorizada = '.($this->GarTarifaAutorizada).',
			GarModelo = "'.($this->GarModelo).'",
			GarCausa = "'.($this->GarCausa).'",
			GarSolucion = "'.($this->GarSolucion).'",
			GarObservacion = "'.($this->GarObservacion).'",
			GarObservacionImpresa = "'.($this->GarObservacionImpresa).'",

			GarSubTotal = '.($this->GarSubTotal).',
			GarImpuesto = '.($this->GarImpuesto).',
			GarTotal = '.($this->GarTotal).',	
		
			'.(empty($this->GarTransaccionFecha)?'GarTransaccionFecha = NULL, ':'GarTransaccionFecha = "'.$this->GarTransaccionFecha.'",').'
			GarTransaccionNumero = "'.($this->GarTransaccionNumero).'",
			GarObservacionFinal = "'.($this->GarObservacionFinal).'",
			
			GarEstado = '.($this->GarEstado).',
			GarTiempoModificacion = "'.($this->GarTiempoModificacion).'"

			WHERE GarId = "'.($this->GarId).'";';			
		
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 		
			
			if(!$error){

				if (!empty($this->GarantiaDetalle)){		
						
					$validar = 0;
					foreach ($this->GarantiaDetalle as $DatGarantiaDetalle){
	
						$InsGarantiaDetalle = new ClsGarantiaDetalle();
						$InsGarantiaDetalle->GdeId = $DatGarantiaDetalle->GdeId;
						$InsGarantiaDetalle->GarId = $this->GarId;
						
						$InsGarantiaDetalle->AmdId = $DatGarantiaDetalle->AmdId;
						$InsGarantiaDetalle->ProId = $DatGarantiaDetalle->ProId;
						$InsGarantiaDetalle->UmeId = $DatGarantiaDetalle->UmeId;
						
						$InsGarantiaDetalle->GdeCodigo = $DatGarantiaDetalle->GdeCodigo;
						$InsGarantiaDetalle->GdeDescripcion = $DatGarantiaDetalle->GdeDescripcion;						
						$InsGarantiaDetalle->GdeCosto = $DatGarantiaDetalle->GdeCosto;
						$InsGarantiaDetalle->GdeCantidad = $DatGarantiaDetalle->GdeCantidad;
						$InsGarantiaDetalle->GdeCostoTotal = $DatGarantiaDetalle->GdeCostoTotal;
						$InsGarantiaDetalle->GdeMargen = $DatGarantiaDetalle->GdeMargen;
						$InsGarantiaDetalle->GdeCostoMargen = $DatGarantiaDetalle->GdeCostoMargen;

					


						$InsGarantiaDetalle->GdeEstado = $DatGarantiaDetalle->GdeEstado;
						$InsGarantiaDetalle->GdeTiempoCreacion = $DatGarantiaDetalle->GdeTiempoCreacion;
						$InsGarantiaDetalle->GdeTiempoModificacion = $DatGarantiaDetalle->GdeTiempoModificacion;
						$InsGarantiaDetalle->GdeEliminado = $DatGarantiaDetalle->GdeEliminado;

						if(empty($InsGarantiaDetalle->GdeId)){
							if($InsGarantiaDetalle->GdeEliminado<>2){
								if($InsGarantiaDetalle->MtdRegistrarGarantiaDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_GAR_201';
									$Resultado.='#Item Numero: '.($validar+1);
								}
			 				}else{
								$validar++;
							}
						}else{						
							if($InsGarantiaDetalle->GdeEliminado==2){
								if($InsGarantiaDetalle->MtdEliminarGarantiaDetalle($InsGarantiaDetalle->GdeId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_GAR_203';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsGarantiaDetalle->MtdEditarGarantiaDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_GAR_202';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->GarantiaDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			

			if(!$error){

				if (!empty($this->GarantiaOperacion)){		
						
					$validar = 0;				
					
					$InsGarantiaOperacion = new ClsGarantiaOperacion();

					foreach ($this->GarantiaOperacion as $DatGarantiaOperacion){


						$InsGarantiaOperacion->GopId = $DatGarantiaOperacion->GopId;
						$InsGarantiaOperacion->GarId = $this->GarId;
						$InsGarantiaOperacion->FaeId = $DatGarantiaOperacion->FaeId;
						
						$InsGarantiaOperacion->GopNumero = $DatGarantiaOperacion->GopNumero;
						$InsGarantiaOperacion->GopTiempo = $DatGarantiaOperacion->GopTiempo;
						$InsGarantiaOperacion->GopValor = $DatGarantiaOperacion->GopValor;
						$InsGarantiaOperacion->GopCosto = $DatGarantiaOperacion->GopCosto;	
						
						$InsGarantiaOperacion->GopTransaccionNumero = $DatGarantiaOperacion->GopTransaccionNumero;
						$InsGarantiaOperacion->GopTransaccionFecha = $DatGarantiaOperacion->GopTransaccionFecha;
						$InsGarantiaOperacion->GopFechaAprobacion = $DatGarantiaOperacion->GopFechaAprobacion;
						$InsGarantiaOperacion->GopFechaPago = $DatGarantiaOperacion->GopFechaPago;
						$InsGarantiaOperacion->GopComprobanteNumero = $DatGarantiaOperacion->GopComprobanteNumero;
						
						$InsGarantiaOperacion->GopEstado = $DatGarantiaOperacion->GopEstado;
						$InsGarantiaOperacion->GopTiempoCreacion = $DatGarantiaOperacion->GopTiempoCreacion;
						$InsGarantiaOperacion->GopTiempoModificacion = $DatGarantiaOperacion->GopTiempoModificacion;
						$InsGarantiaOperacion->GopEliminado = $DatGarantiaOperacion->GopEliminado;
						
			
						if(empty($InsGarantiaOperacion->GopId)){
							if($InsGarantiaOperacion->GopEliminado<>2){
								if($InsGarantiaOperacion->MtdRegistrarGarantiaOperacion()){
									
										if(empty($InsGarantiaOperacion->FaeId)){
											
											$FichaAccionTemparioId = "";
											
											$InsFichaAccionTempario = new ClsFichaAccionTempario();

											$FichaAccionTemparioId = $InsFichaAccionTempario->MtdVerificarExisteFichaAccionTemparios("FaeCodigo",$InsGarantiaOperacion->GopNumero,$this->FccId);
											
											if(empty($FichaAccionTemparioId)){
												
												$InsFichaAccionTempario = new ClsFichaAccionTempario();
												$InsFichaAccionTempario->FccId = $this->FccId;
												$InsFichaAccionTempario->FaeCodigo = 	$InsGarantiaOperacion->GopNumero;
												$InsFichaAccionTempario->FaeTiempo = $InsGarantiaOperacion->GopTiempo;
												$InsFichaAccionTempario->FaeEstado = 3;
												$InsFichaAccionTempario->FaeTiempoCreacion = date("Y-m-d H:i:s");
												$InsFichaAccionTempario->FaeTiempoModificacion = date("Y-m-d H:i:s");
												$InsFichaAccionTempario->MtdRegistrarFichaAccionTempario();
												
											}else{
												
												$InsGarantiaOperacion = new ClsGarantiaOperacion();
												$InsGarantiaOperacion->MtdEditarGarantiaOperacionDato("FaeId",$FichaAccionTemparioId,$InsGarantiaOperacion->GopId);
												
													
											}
											
											
											
										}										
										
									$validar++;	
								}else{
									$Resultado.='#ERR_GAR_301';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsGarantiaOperacion->GopEliminado==2){
								if($InsGarantiaOperacion->MtdEliminarGarantiaOperacion($InsGarantiaOperacion->GopId)){
									
									
									if(!empty($InsGarantiaOperacion->FaeId)){
									
										$InsFichaAccionTempario = new ClsFichaAccionTempario();
										$InsFichaAccionTempario->MtdEliminarFichaAccionTempario($InsGarantiaOperacion->FaeId);
									
									}
									
									
									
									$validar++;					
								}else{
									$Resultado.='#ERR_GAR_303';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsGarantiaOperacion->MtdEditarGarantiaOperacion()){
									
										if(!empty($InsGarantiaOperacion->FaeId)){
											
											$InsFichaAccionTempario = new ClsFichaAccionTempario();
											$InsFichaAccionTempario->FaeId = $InsGarantiaOperacion->FaeId;
											$InsFichaAccionTempario->FaeCodigo = $InsGarantiaOperacion->GopNumero;
											$InsFichaAccionTempario->FaeTiempo = $InsGarantiaOperacion->GopTiempo;
											$InsFichaAccionTempario->FaeEstado = 3;
											$InsFichaAccionTempario->FaeTiempoCreacion = date("Y-m-d H:i:s");
											$InsFichaAccionTempario->FaeTiempoModificacion = date("Y-m-d H:i:s");
											$InsFichaAccionTempario->MtdEditarFichaAccionTempario();
											
										}else{
											
											$FichaAccionTemparioId = "";
											
											$InsFichaAccionTempario = new ClsFichaAccionTempario();

											$FichaAccionTemparioId = $InsFichaAccionTempario->MtdVerificarExisteFichaAccionTemparios("FaeCodigo",$InsGarantiaOperacion->GopNumero,$this->FccId);
											
											if(empty($FichaAccionTemparioId)){
												
												$InsFichaAccionTempario = new ClsFichaAccionTempario();
												$InsFichaAccionTempario->FccId = $this->FccId;
												$InsFichaAccionTempario->FaeCodigo = 	$InsGarantiaOperacion->GopNumero;
												$InsFichaAccionTempario->FaeTiempo = $InsGarantiaOperacion->GopTiempo;
												$InsFichaAccionTempario->FaeEstado = 3;
												$InsFichaAccionTempario->FaeTiempoCreacion = date("Y-m-d H:i:s");
												$InsFichaAccionTempario->FaeTiempoModificacion = date("Y-m-d H:i:s");
												$InsFichaAccionTempario->MtdRegistrarFichaAccionTempario();
												
											}else{
												
												$InsGarantiaOperacion = new ClsGarantiaOperacion();
												$InsGarantiaOperacion->MtdEditarGarantiaOperacionDato("FaeId",$FichaAccionTemparioId,$InsGarantiaOperacion->GopId);
												
													
											}
											
											
										//	$InsFichaAccionTempario = new ClsFichaAccionTempario();
//											$InsFichaAccionTempario->FccId = $this->FccId;
//											$InsFichaAccionTempario->FaeCodigo = 	$InsGarantiaOperacion->GopNumero;
//											$InsFichaAccionTempario->FaeTiempo = $InsGarantiaOperacion->GopTiempo;
//											$InsFichaAccionTempario->FaeEstado = 3;
//											$InsFichaAccionTempario->FaeTiempoCreacion = date("Y-m-d H:i:s");
//											$InsFichaAccionTempario->FaeTiempoModificacion = date("Y-m-d H:i:s");
//											$InsFichaAccionTempario->MtdRegistrarFichaAccionTempario();
//											
										}
										
		
									$validar++;	
								}else{
									$Resultado.='#ERR_GAR_302';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->GarantiaOperacion) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
					
				
			if($error) {		
			
				if($oTransaccion){
					$this->InsMysql->MtdTransaccionDeshacer();					
				}
			
				return false;
			} else {			

				if($oTransaccion){
					$this->InsMysql->MtdTransaccionHacer();
				}

				$this->MtdAuditarGarantia(2,"Se edito la Garantia",$this);		
				return true;
			}	
				
		}	
		
	
	
		private function MtdAuditarGarantia($oAccion,$oDescripcion,$oDatos){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->GarId;

			$InsAuditoria->UsuId = $this->UsuId;
			$InsAuditoria->SucId = $this->SucId;
			$InsAuditoria->AudAccion = $oAccion;
			$InsAuditoria->AudDescripcion = $oDescripcion;
			$InsAuditoria->AudDatos = $oDatos;
			$InsAuditoria->AudTiempoCreacion = date("Y-m-d H:i:s");
			
			if($InsAuditoria->MtdAuditoriaRegistrar()){
				return true;
			}else{
				return false;	
			}
			
		}
		
		public function MtdVerificarExisteGarantia($oCampo,$oDato){

		$Respuesta =   NULL;
			
		$sql = 'SELECT 
        GarId
        FROM tblgargarantia gar
        WHERE '.$oCampo.' = "'.$oDato.'" LIMIT 1;';

        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);
			
			if(!empty($fila['GarId'])){
				$Respuesta = $fila['GarId'];
			}

		}
        
		return $Respuesta;

    }			
	
		public function MtdEditarGarantiaDato($oCampo,$oDato,$oId) {
	
		global $Resultado;
		$error = false;		
		
		$sql = 'UPDATE tblgargarantia SET
		'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
		GarTiempoModificacion = NOW()
		WHERE GarId = "'.($oId).'";';			
		
		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
		
		if(!$resultado) {							
			$error = true;
		} 			
		
		if($error) {		
			return false;
		} else {			
			return true;
		}	
	
	}	





	public function MtdSeguimientoClienteGarantia($oTransaccion=true) {

		global $Resultado;
		$error = false;
			
			
		
			
			if(!$error){

				if (!empty($this->GarantiaLlamada)){		
						
					$validar = 0;				
					
					$InsGarantiaLlamada = new ClsGarantiaLlamada();

					foreach ($this->GarantiaLlamada as $DatGarantiaLlamada){

						$InsGarantiaLlamada->GllId = $DatGarantiaLlamada->GllId;
						$InsGarantiaLlamada->GarId = $this->GarId;
					
						$InsGarantiaLlamada->GllFecha = $DatGarantiaLlamada->GllFecha;						
						$InsGarantiaLlamada->GllObservacion = $DatGarantiaLlamada->GllObservacion;						
						$InsGarantiaLlamada->GllEstado = $DatGarantiaLlamada->GllEstado;
						$InsGarantiaLlamada->GllTiempoCreacion = $DatGarantiaLlamada->GllTiempoCreacion;
						$InsGarantiaLlamada->GllTiempoModificacion = $DatGarantiaLlamada->GllTiempoModificacion;
						$InsGarantiaLlamada->GllEliminado = $DatGarantiaLlamada->GllEliminado;
						
						if(empty($InsGarantiaLlamada->GllId)){
							if($InsGarantiaLlamada->GllEliminado<>2){
								if($InsGarantiaLlamada->MtdRegistrarGarantiaLlamada()){
									$validar++;	
								}else{
									$Resultado.='#ERR_GAR_401';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsGarantiaLlamada->GllEliminado==2){
								if($InsGarantiaLlamada->MtdEliminarGarantiaLlamada($InsGarantiaLlamada->GllId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_GAR_403';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsGarantiaLlamada->MtdEditarGarantiaLlamada()){
									$validar++;	
								}else{
									$Resultado.='#ERR_GAR_402';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->GarantiaLlamada) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
					
				
			if($error) {		
			
				if($oTransaccion){
					$this->InsMysql->MtdTransaccionDeshacer();					
				}
			
				return false;
			} else {			

				if($oTransaccion){
					$this->InsMysql->MtdTransaccionHacer();
				}

				$this->MtdAuditarGarantia(2,"Se edito el seguimiento de la Garantia",$this);		
				return true;
			}	
				
		}	
		

}
?>