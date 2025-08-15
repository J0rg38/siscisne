<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsReporteCORDiario
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReporteCORDiario {

	public $RrcId;
	public $VmaId;
	public $RrcMes;
	public $RrcAno;
	
	public $RrcTotalVentasRetail;
	public $RrcMargenAporte;
	public $RrcStockMarca;
	public $RrcStockLubricantes;
	public $RrcTotalStock;
	public $RrcHoraLaboradas;
	public $RrcValorRepuestosB;
	public $RrcValorRepuestosC;
	public $RrcValorRepuestosD;
	public $RrcRotationMarca;
	public $RrcValorPreObsoletos;

	public $RrcTiempoCreacion;
	public $RrcTiempoModificacion;
		
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
	
	
	
	public function MtdGenerarReporteCORDiarioId() {
	
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(RrcId,5),unsigned)) AS "MAXIMO"
			FROM tblrrrceportecordiario';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->RrcId = "RRC-10000";

			}else{
				$fila['MAXIMO']++;
				$this->RrcId = "RRC-".$fila['MAXIMO'];					
			}	
			
				
		}
		
		
		
    public function MtdObtenerReporteCORDiarios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'RrcId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL) {

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
			$mes = ' AND rrc.RrcMes = "'.$oMes.'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND rrc.RrcAno = "'.$oAno.'"';
		}	
		
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND rrc.VmaId = "'.$oVehiculoMarca.'"';
		}	
		
		if(!empty($oSucursal)){
			$sucursal = ' AND rrc.SucId = "'.$oSucursal.'"';
		}	
		
		$sql = 'SELECT
		SQL_CALC_FOUND_ROWS 
		rrc.RrcId,
		rrc.SucId,
		
		rrc.VmaId,
		rrc.RrcMes,
		rrc.RrcAno,
		rrc.RrcDia,
		
		rrc.RrcVentaTallerMarca,
		rrc.RrcVentaPPMarca,
		rrc.RrcVentaMesonMarca,
		rrc.RrcVentaRatailMarca,
		rrc.RrcVentaRetailLubricantes,

		rrc.RrcTotalVentasRetail,
		rrc.RrcMargenAporte,
		rrc.RrcStockMarca,
		rrc.RrcStockLubricantes,
		rrc.RrcTotalStock,
		rrc.RrcValorRepuestosA,
		
		rrc.RrcValorRepuestosB,
		rrc.RrcValorRepuestosC,
		rrc.RrcValorRepuestosD,
		rrc.RrcRotationMarca,
		rrc.RrcValorPreObsoletos,
		
		rrc.RrcValorObsoletos,
		rrc.RrcPedidosYSTK,
		rrc.RrcPedidosYRUSH,
		rrc.RrcPedidosZVOR,
		rrc.RrcPedidosZGAR,
		rrc.RrcTasaServicioTaller,
		rrc.RrcMontoVentaPedidas,
		rrc.RrcPersonalAsesorRepuestos,
		rrc.RrcPersonalAsistenteAlmacen,
		rrc.RrcDiasLaborados,
		rrc.RrcHorasDisponibles,
		
		DATE_FORMAT(rrc.RrcTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRrcTiempoCreacion",
        DATE_FORMAT(rrc.RrcTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NRrcTiempoModificacion"
		
        FROM tblrrrceportecordiario rrc
		WHERE 1 = 1 '.$mes.$ano.$sucursal.$vmarca.$orden.$paginacion;
					
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsReporteCORDiario = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReporteCORDiario = new $InsReporteCORDiario();				
					
                    $ReporteCORDiario->RrcId = $fila['RrcId'];
					$ReporteCORDiario->SucId = $fila['SucId'];
					
					$ReporteCORDiario->VmaId = $fila['VmaId'];
					$ReporteCORDiario->RrcMes = $fila['RrcMes'];
					$ReporteCORDiario->RrcAno = $fila['RrcAno'];
					$ReporteCORDiario->RrcDia = $fila['RrcDia'];
					
					$ReporteCORDiario->RrcVentaTallerMarca = $fila['RrcVentaTallerMarca'];
					$ReporteCORDiario->RrcVentaPPMarca = $fila['RrcVentaPPMarca'];
					$ReporteCORDiario->RrcVentaMesonMarca = $fila['RrcVentaMesonMarca'];
					$ReporteCORDiario->RrcVentaRatailMarca = $fila['RrcVentaRatailMarca'];
					$ReporteCORDiario->RrcVentaRetailLubricantes = $fila['RrcVentaRetailLubricantes'];

					$ReporteCORDiario->RrcTotalVentasRetail = $fila['RrcTotalVentasRetail'];
					$ReporteCORDiario->RrcMargenAporte = $fila['RrcMargenAporte'];
					$ReporteCORDiario->RrcStockMarca = $fila['RrcStockMarca'];
					$ReporteCORDiario->RrcStockLubricantes = $fila['RrcStockLubricantes'];
					$ReporteCORDiario->RrcTotalStock = $fila['RrcTotalStock'];
					$ReporteCORDiario->RrcValorRepuestosA = $fila['RrcValorRepuestosA'];
					
					$ReporteCORDiario->RrcValorRepuestosB = $fila['RrcValorRepuestosB'];
					$ReporteCORDiario->RrcValorRepuestosC = $fila['RrcValorRepuestosC'];
					$ReporteCORDiario->RrcValorRepuestosD = $fila['RrcValorRepuestosD'];
					$ReporteCORDiario->RrcRotationMarca = $fila['RrcRotationMarca'];
					$ReporteCORDiario->RrcValorPreObsoletos = $fila['RrcValorPreObsoletos'];
					
					
					$ReporteCORDiario->RrcValorObsoletos = $fila['RrcValorObsoletos'];
					$ReporteCORDiario->RrcPedidosYSTK = $fila['RrcPedidosYSTK'];
					$ReporteCORDiario->RrcPedidosYRUSH = $fila['RrcPedidosYRUSH'];
					$ReporteCORDiario->RrcPedidosZVOR = $fila['RrcPedidosZVOR'];
					$ReporteCORDiario->RrcPedidosZGAR = $fila['RrcPedidosZGAR'];
					$ReporteCORDiario->RrcTasaServicioTaller = $fila['RrcTasaServicioTaller'];
					$ReporteCORDiario->RrcMontoVentaPedidas = $fila['RrcMontoVentaPedidas'];
					$ReporteCORDiario->RrcPersonalAsesorRepuestos = $fila['RrcPersonalAsesorRepuestos'];
					$ReporteCORDiario->RrcPersonalAsistenteAlmacen = $fila['RrcPersonalAsistenteAlmacen'];
					$ReporteCORDiario->RrcDiasLaborados = $fila['RrcDiasLaborados'];
					$ReporteCORDiario->RrcHorasDisponibles = $fila['RrcHorasDisponibles'];
		
                    $ReporteCORDiario->RrcTiempoCreacion = $fila['NRrcTiempoCreacion'];
                    $ReporteCORDiario->RrcTiempoModificacion = $fila['NRrcTiempoModificacion'];    
					
                    $ReporteCORDiario->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ReporteCORDiario;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
   
 
 	public function MtdRegistrarReporteCORDiario() {
	
		global $Resultado;
		$error = false;
		
			$this->MtdGenerarReporteCORDiarioId();
				
			$sql = 'INSERT INTO tblrrrceportecordiario (
			RrcId,
			SucId,
			
			VmaId,
			RrcMes,
			RrcAno,
			RrcDia,
			
			RrcVentaTallerMarca,
			RrcVentaPPMarca,
			RrcVentaMesonMarca,
			RrcVentaRatailMarca,
			RrcVentaRetailLubricantes,
		
			RrcTotalVentasRetail,
			RrcMargenAporte,
			RrcStockMarca,
			RrcStockLubricantes,
			RrcTotalStock,
			
			RrcValorRepuestosA,
			RrcValorRepuestosB,
			RrcValorRepuestosC,
			RrcValorRepuestosD,
			RrcRotationMarca,
			RrcValorPreObsoletos,		
			
			RrcValorObsoletos,
			RrcPedidosYSTK,
			RrcPedidosYRUSH,
			RrcPedidosZVOR,
			RrcPedidosZGAR,
			RrcTasaServicioTaller,
			RrcMontoVentaPedidas,
			RrcPersonalAsesorRepuestos,
			RrcPersonalAsistenteAlmacen,
			RrcDiasLaborados,
			RrcHorasDisponibles,
		
			RrcTiempoCreacion,
			RrcTiempoModificacion
			) 
			VALUES (
			"'.($this->RrcId).'",
			"'.($this->SucId).'",
			
			"'.($this->VmaId).'",	
			"'.($this->RrcMes).'",
			"'.($this->RrcAno).'",
			"'.($this->RrcDia).'",
			
			"'.($this->RrcVentaTallerMarca).'",
			"'.($this->RrcVentaPPMarca).'",
			"'.($this->RrcVentaMesonMarca).'",
			"'.($this->RrcVentaRatailMarca).'",
			"'.($this->RrcVentaRetailLubricantes).'",
			
			'.($this->RrcTotalVentasRetail).',
			'.($this->RrcMargenAporte).',
			'.($this->RrcStockMarca).',
			'.($this->RrcStockLubricantes).',
			'.($this->RrcTotalStock).',
			
			'.($this->RrcValorRepuestosA).', 
			'.($this->RrcValorRepuestosB).', 
			'.($this->RrcValorRepuestosC).', 
			'.($this->RrcValorRepuestosD).', 
			'.($this->RrcRotationMarca).', 
			'.($this->RrcValorPreObsoletos).', 
			
			'.($this->RrcValorObsoletos).', 
			'.($this->RrcPedidosYSTK).', 
			'.($this->RrcPedidosYRUSH).', 
			'.($this->RrcPedidosZVOR).', 
			'.($this->RrcPedidosZGAR).', 
			'.($this->RrcTasaServicioTaller).', 
			'.($this->RrcMontoVentaPedidas).', 
			'.($this->RrcPersonalAsesorRepuestos).', 
			'.($this->RrcPersonalAsistenteAlmacen).', 
			'.($this->RrcDiasLaborados).', 
			'.($this->RrcHorasDisponibles).', 
			
			"'.($this->RrcTiempoCreacion).'", 
			"'.($this->RrcTiempoModificacion).'");';					

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
	
	
	public function MtdEditarReporteCORDiarioDato($oCampo,$oDato,$oId) {
	
		$sql = 'UPDATE tblrrrceportecordiario SET 
		'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
		RrcTiempoModificacion = NOW()
		WHERE RrcId = "'.($oId).'";';
		
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