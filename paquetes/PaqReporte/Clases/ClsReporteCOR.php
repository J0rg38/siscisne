<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsReporteCOR
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReporteCOR {

	public $RcrId;
	public $VmaId;
	public $RcrMes;
	public $RcrAno;
	
	public $RcrTotalVentasRetail;
	public $RcrMargenAporte;
	public $RcrStockMarca;
	public $RcrStockLubricantes;
	public $RcrTotalStock;
	public $RcrHoraLaboradas;
	public $RcrValorRepuestosB;
	public $RcrValorRepuestosC;
	public $RcrValorRepuestosD;
	public $RcrRotationMarca;
	public $RcrValorPreObsoletos;

	public $RcrTiempoCreacion;
	public $RcrTiempoModificacion;
		
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	
	
	
	public function MtdGenerarReporteCORId() {
	
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(RcrId,5),unsigned)) AS "MAXIMO"
			FROM tblrcrreportecor';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->RcrId = "RCR-10000";

			}else{
				$fila['MAXIMO']++;
				$this->RcrId = "RCR-".$fila['MAXIMO'];					
			}	
			
				
		}
		
		
		
    public function MtdObtenerReporteCORs($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'RcrId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL) {

		if(!empty($oCampo) and !empty($oFiltro)){
			
			//$oFiltro = str_replace("*","%",$oFiltro);
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
			
			
		if(!empty($oMes)){
			$mes = ' AND rcr.RcrMes = "'.$oMes.'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND rcr.RcrAno = "'.$oAno.'"';
		}	
		
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND rcr.VmaId = "'.$oVehiculoMarca.'"';
		}	
		
		if(!empty($oSucursal)){
			$sucursal = ' AND rcr.SucId = "'.$oSucursal.'"';
		}	
		
		$sql = 'SELECT
		SQL_CALC_FOUND_ROWS 
		rcr.RcrId,
		rcr.SucId,
		
		rcr.VmaId,
		rcr.RcrMes,
		rcr.RcrAno,

		rcr.RcrVentaTallerMarca,
		rcr.RcrVentaPPMarca,
		rcr.RcrVentaMesonMarca,
		rcr.RcrVentaRatailMarca,
		rcr.RcrVentaRetailLubricantes,

		rcr.RcrTotalVentasRetail,
		rcr.RcrMargenAporte,
		rcr.RcrStockMarca,
		rcr.RcrStockLubricantes,
		rcr.RcrTotalStock,
		rcr.RcrValorRepuestosA,
		
		rcr.RcrValorRepuestosB,
		rcr.RcrValorRepuestosC,
		rcr.RcrValorRepuestosD,
		rcr.RcrRotationMarca,
		rcr.RcrValorPreObsoletos,
		
		rcr.RcrValorObsoletos,
		rcr.RcrPedidosYSTK,
		rcr.RcrPedidosYRUSH,
		rcr.RcrPedidosZVOR,
		rcr.RcrPedidosZGAR,
		rcr.RcrTasaServicioTaller,
		rcr.RcrMontoVentaPedidas,
		rcr.RcrPersonalAsesorRepuestos,
		rcr.RcrPersonalAsistenteAlmacen,
		rcr.RcrDiasLaborados,
		rcr.RcrHorasDisponibles,
		
		DATE_FORMAT(rcr.RcrTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRcrTiempoCreacion",
        DATE_FORMAT(rcr.RcrTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NRcrTiempoModificacion"
		
        FROM tblrcrreportecor rcr
		WHERE 1 = 1 '.$mes.$ano.$sucursal.$vmarca.$orden.$paginacion;
					
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsReporteCOR = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReporteCOR = new $InsReporteCOR();				
					
                    $ReporteCOR->RcrId = $fila['RcrId'];
					$ReporteCOR->SucId = $fila['SucId'];
					
					$ReporteCOR->VmaId = $fila['VmaId'];
					$ReporteCOR->RcrMes = $fila['RcrMes'];
					$ReporteCOR->RcrAno = $fila['RcrAno'];
					
					$ReporteCOR->RcrVentaTallerMarca = $fila['RcrVentaTallerMarca'];
					$ReporteCOR->RcrVentaPPMarca = $fila['RcrVentaPPMarca'];
					$ReporteCOR->RcrVentaMesonMarca = $fila['RcrVentaMesonMarca'];
					$ReporteCOR->RcrVentaRatailMarca = $fila['RcrVentaRatailMarca'];
					$ReporteCOR->RcrVentaRetailLubricantes = $fila['RcrVentaRetailLubricantes'];

					$ReporteCOR->RcrTotalVentasRetail = $fila['RcrTotalVentasRetail'];
					$ReporteCOR->RcrMargenAporte = $fila['RcrMargenAporte'];
					$ReporteCOR->RcrStockMarca = $fila['RcrStockMarca'];
					$ReporteCOR->RcrStockLubricantes = $fila['RcrStockLubricantes'];
					$ReporteCOR->RcrTotalStock = $fila['RcrTotalStock'];
					$ReporteCOR->RcrValorRepuestosA = $fila['RcrValorRepuestosA'];
					
					$ReporteCOR->RcrValorRepuestosB = $fila['RcrValorRepuestosB'];
					$ReporteCOR->RcrValorRepuestosC = $fila['RcrValorRepuestosC'];
					$ReporteCOR->RcrValorRepuestosD = $fila['RcrValorRepuestosD'];
					$ReporteCOR->RcrRotationMarca = $fila['RcrRotationMarca'];
					$ReporteCOR->RcrValorPreObsoletos = $fila['RcrValorPreObsoletos'];
					
					
					$ReporteCOR->RcrValorObsoletos = $fila['RcrValorObsoletos'];
					$ReporteCOR->RcrPedidosYSTK = $fila['RcrPedidosYSTK'];
					$ReporteCOR->RcrPedidosYRUSH = $fila['RcrPedidosYRUSH'];
					$ReporteCOR->RcrPedidosZVOR = $fila['RcrPedidosZVOR'];
					$ReporteCOR->RcrPedidosZGAR = $fila['RcrPedidosZGAR'];
					$ReporteCOR->RcrTasaServicioTaller = $fila['RcrTasaServicioTaller'];
					$ReporteCOR->RcrMontoVentaPedidas = $fila['RcrMontoVentaPedidas'];
					$ReporteCOR->RcrPersonalAsesorRepuestos = $fila['RcrPersonalAsesorRepuestos'];
					$ReporteCOR->RcrPersonalAsistenteAlmacen = $fila['RcrPersonalAsistenteAlmacen'];
					$ReporteCOR->RcrDiasLaborados = $fila['RcrDiasLaborados'];
					$ReporteCOR->RcrHorasDisponibles = $fila['RcrHorasDisponibles'];
		
                    $ReporteCOR->RcrTiempoCreacion = $fila['NRcrTiempoCreacion'];
                    $ReporteCOR->RcrTiempoModificacion = $fila['NRcrTiempoModificacion'];    
					
                    $ReporteCOR->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ReporteCOR;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
   
 
 	public function MtdRegistrarReporteCOR() {
	
		global $Resultado;
		$error = false;
		
			$this->MtdGenerarReporteCORId();
				
			$sql = 'INSERT INTO tblrcrreportecor (
			RcrId,
			SucId,
			
			VmaId,
			RcrMes,
			RcrAno,
			
			RcrVentaTallerMarca,
			RcrVentaPPMarca,
			RcrVentaMesonMarca,
			RcrVentaRatailMarca,
			RcrVentaRetailLubricantes,
		
			RcrTotalVentasRetail,
			RcrMargenAporte,
			RcrStockMarca,
			RcrStockLubricantes,
			RcrTotalStock,
			
			RcrValorRepuestosA,
			RcrValorRepuestosB,
			RcrValorRepuestosC,
			RcrValorRepuestosD,
			RcrRotationMarca,
			RcrValorPreObsoletos,		
			
			RcrValorObsoletos,
			RcrPedidosYSTK,
			RcrPedidosYRUSH,
			RcrPedidosZVOR,
			RcrPedidosZGAR,
			RcrTasaServicioTaller,
			RcrMontoVentaPedidas,
			RcrPersonalAsesorRepuestos,
			RcrPersonalAsistenteAlmacen,
			RcrDiasLaborados,
			RcrHorasDisponibles,
		
			RcrTiempoCreacion,
			RcrTiempoModificacion
			) 
			VALUES (
			"'.($this->RcrId).'",
			"'.($this->SucId).'",
			
			"'.($this->VmaId).'",	
			"'.($this->RcrMes).'",
			"'.($this->RcrAno).'",
			
			"'.($this->RcrVentaTallerMarca).'",
			"'.($this->RcrVentaPPMarca).'",
			"'.($this->RcrVentaMesonMarca).'",
			"'.($this->RcrVentaRatailMarca).'",
			"'.($this->RcrVentaRetailLubricantes).'",
			
			'.($this->RcrTotalVentasRetail).',
			'.($this->RcrMargenAporte).',
			'.($this->RcrStockMarca).',
			'.($this->RcrStockLubricantes).',
			'.($this->RcrTotalStock).',
			
			'.($this->RcrValorRepuestosA).', 
			'.($this->RcrValorRepuestosB).', 
			'.($this->RcrValorRepuestosC).', 
			'.($this->RcrValorRepuestosD).', 
			'.($this->RcrRotationMarca).', 
			'.($this->RcrValorPreObsoletos).', 
			
			'.($this->RcrValorObsoletos).', 
			'.($this->RcrPedidosYSTK).', 
			'.($this->RcrPedidosYRUSH).', 
			'.($this->RcrPedidosZVOR).', 
			'.($this->RcrPedidosZGAR).', 
			'.($this->RcrTasaServicioTaller).', 
			'.($this->RcrMontoVentaPedidas).', 
			'.($this->RcrPersonalAsesorRepuestos).', 
			'.($this->RcrPersonalAsistenteAlmacen).', 
			'.($this->RcrDiasLaborados).', 
			'.($this->RcrHorasDisponibles).', 
			
			"'.($this->RcrTiempoCreacion).'", 
			"'.($this->RcrTiempoModificacion).'");';					

			if(!$error){
				
				$resultado = $this->InsMysql->MtdEjecutar($sql,true);

				if(!$resultado) {						
					$error = true;
				} 	

			}

			if($error) {						
				return false;
			} else {				
				return true;
			}			
			
	}
	
	
	public function MtdEditarReporteCORDato($oCampo,$oDato,$oId) {
	
		$sql = 'UPDATE tblrcrreportecor SET 
		'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
		RcrTiempoModificacion = NOW()
		WHERE RcrId = "'.($oId).'";';
		
		$error = false;
	
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

}
?>