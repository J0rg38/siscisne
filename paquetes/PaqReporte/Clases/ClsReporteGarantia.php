<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsReporteFichaIngreso
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReporteGarantia {

	 public $GarId;
	public $GarAno;
	public $GarMes;
	
	public $FccId;
	public $CliId;
	
	public $GarFechaEmision;
	public $GarFechaVenta;
	
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
	public $GarObservacion;
	public $GarObservacionImpresa;
	
	public $GarTransaccionFecha;
	public $GarTransaccionNumero;
	public $GarObservacionFinal;
	
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
	
	public $FinId;
	public $MinId;
	
	public $LtiNombre;

	public $FinFecha;
	public $FinTiempoTrabajoTerminado;
				
				
				
	public $GarantiaDetalle;
	public $GarantiaOperacion;

    public $InsMysql;
	
	public $Transaccion;
	
    public function __construct(){
		$this->InsMysql = new ClsMysql();
		$this->Transaccion = false;
    }
	
	public function __destruct(){

	}

    public function MtdObtenerReporteGarantias($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'GarId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL) {

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
			$estado = ' AND gar.GarEstado = '.$oEstado;
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND gar.MonId = "'.$oMoneda.'"';
		}
		
		
			$sql = 'SELECT
					SQL_CALC_FOUND_ROWS 
					gar.GarId,
					gar.FccId,
					
					gar.CliId,
					
					DATE_FORMAT(gar.GarFechaEmision, "%d/%m/%Y") AS "NGarFechaEmision",
					DATE_FORMAT(gar.GarFechaVenta, "%d/%m/%Y") AS "NGarFechaVenta",
					
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
					gar.GarObservacion,
					gar.GarObservacionImpresa,
					
					
					DATE_FORMAT(gar.GarTransaccionFecha, "%d/%m/%Y") AS "NGarTransaccionFecha",
					gar.GarTransaccionNumero,
					gar.GarObservacionFinal,
					
		
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
				
				DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",
				DATE_FORMAT(fin.FinTiempoTrabajoTerminado, "%d/%m/%Y") AS "NFinTiempoTrabajoTerminado",
				
				onc.OncNombre

				FROM tblgargarantia gar
				
			LEFT JOIN tblclicliente cli
			ON gar.CliId = cli.CliId
				LEFT JOIN tblfccfichaaccion fcc
				ON gar.FccId = fcc.FccId
					LEFT JOIN tblfimfichaingresomodalidad fim
					ON fcc.FimId = fim.FimId
						LEFT JOIN tblfinfichaingreso fin
						ON fim.FinId = fin.FinId
							LEFT JOIN tbleinvehiculoingreso ein
							ON fin.EinId = ein.EinId
								
								LEFT JOIN tbloncconcesionario onc
								ON ein.OncId = onc.OncId
								
								LEFT JOIN tblvmavehiculomarca vma
								ON ein.VmaId = vma.VmaId
									LEFT JOIN tblvmovehiculomodelo vmo
									ON ein.VmoId = vmo.VmoId
										LEFT JOIN tbllticlientetipo lti
										ON cli.LtiId = lti.LtiId
										
										LEFT JOIN tblgdegarantiadetalle gde
										ON gde.GarId = gar.GarId
											LEFT JOIN tblgopgarantiaoperacion gop
											ON gop.GarId = gar.GarId
								
				WHERE 1 = 1 '.$filtrar.$fecha.$estado.$moneda." GROUP BY gar.GarId ".$orden." ".$paginacion;
											
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
				
			$Garantia->FinFecha = $fila['NFinFecha'];
			$Garantia->FinTiempoTrabajoTerminado = $fila['NFinTiempoTrabajoTerminado'];
			
			$Garantia->OncNombre = $fila['OncNombre'];
				
                    $Garantia->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Garantia;
            }
			
		
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
	

}
?>