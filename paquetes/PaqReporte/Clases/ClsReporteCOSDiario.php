<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsReporteCOSDiario
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReporteCOSDiario {

	public $RcdId;
	public $VmaId;
	public $RcdMes;
	public $RcdAno;
	
	public $RcdPersonalMecanicos;
	public $RcdPersonalAsesores;
	public $RcdPersonalOtros;
	public $RcdDiasLaborados;
	public $RcdHoraDisponibles;
	public $RcdHoraLaboradas;
	public $RcdHoraMOVendidas;
	public $RcdVentaManoObra;
	public $RcdVentaRepuestos;
	public $RcdTicketPromedio;
	public $RcdVentaGarantiaFA;

	public $RcdTiempoCreacion;
	public $RcdTiempoModificacion;
		
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	
	
	
	public function MtdGenerarReporteCOSDiarioId() {
	
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(RcdId,5),unsigned)) AS "MAXIMO"
			FROM tblrcdreportecosdiario';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->RcdId = "RCD-10000";

			}else{
				$fila['MAXIMO']++;
				$this->RcdId = "RCD-".$fila['MAXIMO'];					
			}	
			
				
		}
		
		
		
    public function MtdObtenerReporteCOSDiarios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'RcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL,$oDia=NULL) {

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
			$mes = ' AND rcd.RcdMes = "'.$oMes.'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND rcd.RcdAno = "'.$oAno.'"';
		}	
		
		
		if(!empty($oDia)){
			$dia = ' AND rcd.RcdDia = "'.$oDia.'"';
		}	
		
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND rcd.VmaId = "'.$oVehiculoMarca.'"';
		}	
		
			if(!empty($oSucursal)){
			$sucursal = ' AND rcd.SucId = "'.$oSucursal.'"';
		}	
		
	
		
		
		
		$sql = 'SELECT
		SQL_CALC_FOUND_ROWS 
		rcd.RcdId,
		rcd.SucId,
		
		rcd.VmaId,
		rcd.RcdMes,
		rcd.RcdAno,
		rcd.RcdDia,
		
		rcd.RcdNumeroCitas,
		rcd.RcdClientesParticulares,
		rcd.RcdClientesFlotas,
		rcd.RcdPromedioPermanencia,
		rcd.RcdParalizados,

		rcd.RcdPersonalMecanicos,
		rcd.RcdPersonalAsesores,
		rcd.RcdPersonalOtros,
		rcd.RcdDiasLaborados,
		rcd.RcdHoraDisponibles,
		rcd.RcdTarifaMO,
		
		rcd.RcdHoraMOVendidas,
		rcd.RcdVentaManoObra,
		rcd.RcdVentaRepuestos,
		rcd.RcdTicketPromedio,
		rcd.RcdVentaGarantiaFA,
		
		DATE_FORMAT(rcd.RcdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRcdTiempoCreacion",
        DATE_FORMAT(rcd.RcdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NRcdTiempoModificacion"
		
        FROM tblrcdreportecosdiario rcd
		WHERE 1 = 1 '.$mes.$ano.$sucursal.$dia.$vmarca.$orden.$paginacion;
					
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsReporteCOSDiario = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReporteCOSDiario = new $InsReporteCOSDiario();				
					
                    $ReporteCOSDiario->RcdId = $fila['RcdId'];
					$ReporteCOSDiario->SucId = $fila['SucId'];
					
					$ReporteCOSDiario->VmaId = $fila['VmaId'];
					$ReporteCOSDiario->RcdMes = $fila['RcdMes'];
					$ReporteCOSDiario->RcdAno = $fila['RcdAno'];
					$ReporteCOSDiario->RcdDia = $fila['RcdDia'];
					
					$ReporteCOSDiario->RcdNumeroCitas = $fila['RcdNumeroCitas'];
					$ReporteCOSDiario->RcdClientesParticulares = $fila['RcdClientesParticulares'];
					$ReporteCOSDiario->RcdClientesFlotas = $fila['RcdClientesFlotas'];
					$ReporteCOSDiario->RcdPromedioPermanencia = $fila['RcdPromedioPermanencia'];
					$ReporteCOSDiario->RcdParalizados = $fila['RcdParalizados'];

					$ReporteCOSDiario->RcdPersonalMecanicos = $fila['RcdPersonalMecanicos'];
					$ReporteCOSDiario->RcdPersonalAsesores = $fila['RcdPersonalAsesores'];
					$ReporteCOSDiario->RcdPersonalOtros = $fila['RcdPersonalOtros'];
					$ReporteCOSDiario->RcdDiasLaborados = $fila['RcdDiasLaborados'];
					$ReporteCOSDiario->RcdHoraDisponibles = $fila['RcdHoraDisponibles'];
					$ReporteCOSDiario->RcdTarifaMO = $fila['RcdTarifaMO'];
					
					$ReporteCOSDiario->RcdHoraMOVendidas = $fila['RcdHoraMOVendidas'];
					$ReporteCOSDiario->RcdVentaManoObra = $fila['RcdVentaManoObra'];
					$ReporteCOSDiario->RcdVentaRepuestos = $fila['RcdVentaRepuestos'];
					$ReporteCOSDiario->RcdTicketPromedio = $fila['RcdTicketPromedio'];
					$ReporteCOSDiario->RcdVentaGarantiaFA = $fila['RcdVentaGarantiaFA'];
					
                    $ReporteCOSDiario->RcdTiempoCreacion = $fila['NRcdTiempoCreacion'];
                    $ReporteCOSDiario->RcdTiempoModificacion = $fila['NRcdTiempoModificacion'];    
					
                    $ReporteCOSDiario->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ReporteCOSDiario;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
   
 
 	public function MtdRegistrarReporteCOSDiario() {
	
		global $Resultado;
		$error = false;
		
			$this->MtdGenerarReporteCOSDiarioId();
				
			$sql = 'INSERT INTO tblrcdreportecosdiario (
			RcdId,
			SucId,
			VmaId,
			RcdMes,
			RcdAno,
			RcdDia,
			
			RcdNumeroCitas,
			RcdClientesParticulares,
			RcdClientesFlotas,
			RcdPromedioPermanencia,
			RcdParalizados,
		
			RcdPersonalMecanicos,
			RcdPersonalAsesores,
			RcdPersonalOtros,
			RcdDiasLaborados,
			RcdHoraDisponibles,
			RcdHoraLaboradas,
			RcdHoraMOVendidas,
			RcdVentaManoObra,
			RcdVentaRepuestos,
			RcdTicketPromedio,
			RcdVentaGarantiaFA,			
			RcdTiempoCreacion,
			RcdTiempoModificacion
			) 
			VALUES (
			"'.($this->RcdId).'",
			"'.($this->SucId).'",
			"'.($this->VmaId).'",	
			"'.($this->RcdMes).'",
			"'.($this->RcdAno).'",
			"'.($this->RcdDia).'",
			
			"'.($this->RcdNumeroCitas).'",
			"'.($this->RcdClientesParticulares).'",
			"'.($this->RcdClientesFlotas).'",
			"'.($this->RcdPromedioPermanencia).'",
			"'.($this->RcdParalizados).'",
			
			'.($this->RcdPersonalMecanicos).',
			'.($this->RcdPersonalAsesores).',
			'.($this->RcdPersonalOtros).',
			'.($this->RcdDiasLaborados).',
			'.($this->RcdHoraDisponibles).',
			'.($this->RcdHoraLaboradas).', 
			'.($this->RcdHoraMOVendidas).', 
			'.($this->RcdVentaManoObra).', 
			'.($this->RcdVentaRepuestos).', 
			'.($this->RcdTicketPromedio).', 
			'.($this->RcdVentaGarantiaFA).', 
			"'.($this->RcdTiempoCreacion).'", 
			"'.($this->RcdTiempoModificacion).'");';					

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
	
	
	public function MtdEditarReporteCOSDiarioDato($oCampo,$oDato,$oId) {
	
		$sql = 'UPDATE tblrcdreportecosdiario SET 
		'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
		RcdTiempoModificacion = NOW()
		WHERE RcdId = "'.($oId).'";';
		
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