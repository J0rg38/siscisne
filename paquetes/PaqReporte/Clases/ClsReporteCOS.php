<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsReporteCOS
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReporteCOS {

	public $RcoId;
	public $VmaId;
	public $RcoMes;
	public $RcoAno;
	
	public $RcoPersonalMecanicos;
	public $RcoPersonalAsesores;
	public $RcoPersonalOtros;
	public $RcoDiasLaborados;
	public $RcoHoraDisponibles;
	public $RcoHoraLaboradas;
	public $RcoHoraMOVendidas;
	public $RcoVentaManoObra;
	public $RcoVentaRepuestos;
	public $RcoTicketPromedio;
	public $RcoVentaGarantiaFA;

	public $RcoTiempoCreacion;
	public $RcoTiempoModificacion;
		
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
	
	
	
	public function MtdGenerarReporteCOSId() {
	
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(RcoId,5),unsigned)) AS "MAXIMO"
			FROM tblrcoreportecos';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->RcoId = "RCO-10000";

			}else{
				$fila['MAXIMO']++;
				$this->RcoId = "RCO-".$fila['MAXIMO'];					
			}	
			
				
		}
		
		
		
    public function MtdObtenerReporteCOSs($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'RcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL) {

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
			$mes = ' AND rco.RcoMes = "'.$oMes.'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND rco.RcoAno = "'.$oAno.'"';
		}	
		
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND rco.VmaId = "'.$oVehiculoMarca.'"';
		}	
		
			if(!empty($oSucursal)){
			$sucursal = ' AND rco.SucId = "'.$oSucursal.'"';
		}	
		
		$sql = 'SELECT
		SQL_CALC_FOUND_ROWS 
		rco.RcoId,
		rco.SucId,
		
		rco.VmaId,
		rco.RcoMes,
		rco.RcoAno,
		
rco.RcoIngresoSparkLite,
rco.RcoIngresoSparkGT,
rco.RcoIngresoN300MoveMax,
rco.RcoIngresoN300Work,
rco.RcoIngresoCorsaChevyTaxi,
rco.RcoIngresoSail,
rco.RcoIngresoOnix,
rco.RcoIngresoPrisma,
rco.RcoIngresoNuevoSail,
rco.RcoIngresoAveo,
rco.RcoIngresoOptra,
rco.RcoIngresoSonic,
rco.RcoIngresoCruze,
rco.RcoIngresoSpin,
rco.RcoIngresoTracker,
rco.RcoIngresoVivant,
rco.RcoIngresoOrlando,
rco.RcoIngresoCaptiva,
rco.RcoIngresoS10,
rco.RcoIngresoTrailblazer,
rco.RcoIngresoTraverse,
rco.RcoIngresoTahoeSuburban,

rco.RcoIngresoOtrasUnidades,
rco.RcoTotalIngresosUnidades,
rco.RcoTotalIngresosUnidadesMantenimiento,


rco.RcoIngresoNLR3TON,
rco.RcoIngresoREWARD400DT,
rco.RcoIngresoREWARD400NMR,
rco.RcoIngresoNPR4TON,
rco.RcoIngresoREWARD500,
rco.RcoIngresoFTR10TON,
rco.RcoIngresoFORWARD800,
rco.RcoIngresoFORWARD1300,
rco.RcoIngresoFORWARD2000,



		rco.RcoIngresoPrimeraRevision,
		rco.RcoIngresoServicio1000,
		rco.RcoIngresoServicio1500,
		rco.RcoIngresoServicio5000,
		rco.RcoIngresoServicio10000,
		rco.RcoIngresoServicio15000,
		rco.RcoIngresoServicio20000,
		rco.RcoIngresoServicio25000,
		rco.RcoIngresoServicio30000,
		rco.RcoIngresoServicio35000,
		rco.RcoIngresoServicio40000,
		rco.RcoIngresoServicio45000,
		rco.RcoIngresoServicio50000,
		rco.RcoIngresoServicio50000Mas,
		rco.RcoIngresoServicioReparaciones,
		rco.RcoIngresoServicioPlanchadoPintado,
		rco.RcoIngresoServicioTrabajoInterno,
		rco.RcoIngreseServicioGarantias,
		rco.RcoIngresoServicioInstalacionAccesorios,
		rco.RcoIngresoServicioInstalacionGLP,
		rco.RcoIngresoServicioSuperCambio99,
		rco.RcoIngresoServicioReingresos,
		
		

		rco.RcoNumeroCitas,
		rco.RcoCitasEfectivas,
		rco.RcoClientesParticulares,
		rco.RcoClientesFlotas,
		rco.RcoPromedioPermanencia,
		rco.RcoParalizados,

		rco.RcoPersonalMecanicos,
		rco.RcoPersonalAsesores,
		rco.RcoPersonalOtros,
		rco.RcoDiasLaborados,
		rco.RcoHoraDisponibles,
		rco.RcoHoraLaboradas,
		
		
		rco.RcoTarifaMO,
		
		rco.RcoHoraMOVendidas,
		rco.RcoVentaManoObra,
		rco.RcoVentaRepuestos,
		rco.RcoTicketPromedio,
		
		rco.RcoVentaMecanica,
		rco.RcoVentaGarantiaFA,
		
		DATE_FORMAT(rco.RcoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRcoTiempoCreacion",
        DATE_FORMAT(rco.RcoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NRcoTiempoModificacion"
		
        FROM tblrcoreportecos rco
		WHERE 1 = 1 '.$mes.$ano.$sucursal.$vmarca.$orden.$paginacion;
					
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsReporteCOS = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReporteCOS = new $InsReporteCOS();				
					
                    $ReporteCOS->RcoId = $fila['RcoId'];
					$ReporteCOS->SucId = $fila['SucId'];
					
					$ReporteCOS->VmaId = $fila['VmaId'];
					$ReporteCOS->RcoMes = $fila['RcoMes'];
					$ReporteCOS->RcoAno = $fila['RcoAno'];
					
					
					$ReporteCOS->RcoIngresoSparkLite = $fila['RcoIngresoSparkLite'];
					$ReporteCOS->RcoIngresoSparkGT = $fila['RcoIngresoSparkGT'];
					$ReporteCOS->RcoIngresoN300MoveMax = $fila['RcoIngresoN300MoveMax'];
					$ReporteCOS->RcoIngresoN300Work = $fila['RcoIngresoN300Work'];
					$ReporteCOS->RcoIngresoCorsaChevyTaxi = $fila['RcoIngresoCorsaChevyTaxi'];
					$ReporteCOS->RcoIngresoSail = $fila['RcoIngresoSail'];
					$ReporteCOS->RcoIngresoOnix = $fila['RcoIngresoOnix'];
					$ReporteCOS->RcoIngresoPrisma = $fila['RcoIngresoPrisma'];
					$ReporteCOS->RcoIngresoNuevoSail = $fila['RcoIngresoNuevoSail'];
					$ReporteCOS->RcoIngresoAveo = $fila['RcoIngresoAveo'];
					$ReporteCOS->RcoIngresoOptra = $fila['RcoIngresoOptra'];
					$ReporteCOS->RcoIngresoSonic = $fila['RcoIngresoSonic'];
					$ReporteCOS->RcoIngresoCruze = $fila['RcoIngresoCruze'];
					$ReporteCOS->RcoIngresoSpin = $fila['RcoIngresoSpin'];
					$ReporteCOS->RcoIngresoTracker = $fila['RcoIngresoTracker'];
					$ReporteCOS->RcoIngresoVivant = $fila['RcoIngresoVivant'];
					$ReporteCOS->RcoIngresoOrlando = $fila['RcoIngresoOrlando'];
					$ReporteCOS->RcoIngresoCaptiva = $fila['RcoIngresoCaptiva'];
					$ReporteCOS->RcoIngresoS10 = $fila['RcoIngresoS10'];
					$ReporteCOS->RcoIngresoTrailblazer = $fila['RcoIngresoTrailblazer'];
					$ReporteCOS->RcoIngresoTraverse = $fila['RcoIngresoTraverse'];
					$ReporteCOS->RcoIngresoTahoeSuburban = $fila['RcoIngresoTahoeSuburban'];
					
					$ReporteCOS->RcoIngresoOtrasUnidades = $fila['RcoIngresoOtrasUnidades'];
					$ReporteCOS->RcoTotalIngresosUnidades = $fila['RcoTotalIngresosUnidades'];
					$ReporteCOS->RcoTotalIngresosUnidadesMantenimiento = $fila['RcoTotalIngresosUnidadesMantenimiento'];
			
			
			
			$ReporteCOS->RcoIngresoNLR3TON = $fila['RcoIngresoNLR3TON'];
					$ReporteCOS->RcoIngresoREWARD400DT = $fila['RcoIngresoREWARD400DT'];
					$ReporteCOS->RcoIngresoREWARD400NMR = $fila['RcoIngresoREWARD400NMR'];
					$ReporteCOS->RcoIngresoNPR4TON = $fila['RcoIngresoNPR4TON'];
					$ReporteCOS->RcoIngresoREWARD500 = $fila['RcoIngresoREWARD500'];
					$ReporteCOS->RcoIngresoFTR10TON = $fila['RcoIngresoFTR10TON'];
					$ReporteCOS->RcoIngresoFORWARD800 = $fila['RcoIngresoFORWARD800'];
					$ReporteCOS->RcoIngresoFORWARD1300 = $fila['RcoIngresoFORWARD1300'];
			$ReporteCOS->RcoIngresoFORWARD2000 = $fila['RcoIngresoFORWARD2000'];


					$ReporteCOS->RcoIngresoPrimeraRevision = $fila['RcoIngresoPrimeraRevision'];
					
					$ReporteCOS->RcoIngresoServicio1000 = $fila['RcoIngresoServicio1000'];
					$ReporteCOS->RcoIngresoServicio1500 = $fila['RcoIngresoServicio1500'];
					$ReporteCOS->RcoIngresoServicio5000 = $fila['RcoIngresoServicio5000'];
					$ReporteCOS->RcoIngresoServicio10000 = $fila['RcoIngresoServicio10000'];
					$ReporteCOS->RcoIngresoServicio15000 = $fila['RcoIngresoServicio15000'];
					$ReporteCOS->RcoIngresoServicio20000 = $fila['RcoIngresoServicio20000'];
					$ReporteCOS->RcoIngresoServicio25000 = $fila['RcoIngresoServicio25000'];
					$ReporteCOS->RcoIngresoServicio30000 = $fila['RcoIngresoServicio30000'];
					$ReporteCOS->RcoIngresoServicio35000 = $fila['RcoIngresoServicio35000'];
					$ReporteCOS->RcoIngresoServicio40000 = $fila['RcoIngresoServicio40000'];
					$ReporteCOS->RcoIngresoServicio45000 = $fila['RcoIngresoServicio45000'];
					$ReporteCOS->RcoIngresoServicio50000 = $fila['RcoIngresoServicio50000'];
					$ReporteCOS->RcoIngresoServicio50000Mas = $fila['RcoIngresoServicio50000Mas'];
					$ReporteCOS->RcoIngresoServicioReparaciones = $fila['RcoIngresoServicioReparaciones'];
					$ReporteCOS->RcoIngresoServicioPlanchadoPintado = $fila['RcoIngresoServicioPlanchadoPintado'];
					$ReporteCOS->RcoIngresoServicioTrabajoInterno = $fila['RcoIngresoServicioTrabajoInterno'];
					$ReporteCOS->RcoIngreseServicioGarantias = $fila['RcoIngreseServicioGarantias'];
					$ReporteCOS->RcoIngresoServicioInstalacionAccesorios = $fila['RcoIngresoServicioInstalacionAccesorios'];
					$ReporteCOS->RcoIngresoServicioInstalacionGLP = $fila['RcoIngresoServicioInstalacionGLP'];
					$ReporteCOS->RcoIngresoServicioSuperCambio99 = $fila['RcoIngresoServicioSuperCambio99'];
					$ReporteCOS->RcoIngresoServicioReingresos = $fila['RcoIngresoServicioReingresos'];
		
					$ReporteCOS->RcoNumeroCitas = $fila['RcoNumeroCitas'];
					$ReporteCOS->RcoCitasEfectivas = $fila['RcoCitasEfectivas'];
					
					$ReporteCOS->RcoClientesParticulares = $fila['RcoClientesParticulares'];
					$ReporteCOS->RcoClientesFlotas = $fila['RcoClientesFlotas'];
					$ReporteCOS->RcoPromedioPermanencia = $fila['RcoPromedioPermanencia'];
					$ReporteCOS->RcoParalizados = $fila['RcoParalizados'];

					$ReporteCOS->RcoPersonalMecanicos = $fila['RcoPersonalMecanicos'];
					$ReporteCOS->RcoPersonalAsesores = $fila['RcoPersonalAsesores'];
					$ReporteCOS->RcoPersonalOtros = $fila['RcoPersonalOtros'];
					$ReporteCOS->RcoDiasLaborados = $fila['RcoDiasLaborados'];
					$ReporteCOS->RcoHoraDisponibles = $fila['RcoHoraDisponibles'];
					$ReporteCOS->RcoHoraLaboradas = $fila['RcoHoraLaboradas'];
					
					
					$ReporteCOS->RcoTarifaMO = $fila['RcoTarifaMO'];
					
					$ReporteCOS->RcoHoraMOVendidas = $fila['RcoHoraMOVendidas'];
					$ReporteCOS->RcoVentaManoObra = $fila['RcoVentaManoObra'];
					$ReporteCOS->RcoVentaRepuestos = $fila['RcoVentaRepuestos'];
					$ReporteCOS->RcoTicketPromedio = $fila['RcoTicketPromedio'];
					
					$ReporteCOS->RcoVentaMecanica = $fila['RcoVentaMecanica'];
					$ReporteCOS->RcoVentaGarantiaFA = $fila['RcoVentaGarantiaFA'];
					
                    $ReporteCOS->RcoTiempoCreacion = $fila['NRcoTiempoCreacion'];
                    $ReporteCOS->RcoTiempoModificacion = $fila['NRcoTiempoModificacion'];    
					
                    $ReporteCOS->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ReporteCOS;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
   
 
 	public function MtdRegistrarReporteCOS() {
	
		global $Resultado;
		$error = false;
		
			$this->MtdGenerarReporteCOSId();
				
			$sql = 'INSERT INTO tblrcoreportecos (
			RcoId,
			SucId,
			VmaId,
			RcoMes,
			RcoAno,
			
			
			RcoIngresoSparkLite,
			RcoIngresoSparkGT,
			RcoIngresoN300MoveMax,
			RcoIngresoN300Work,
			RcoIngresoCorsaChevyTaxi,
			RcoIngresoSail,
			RcoIngresoOnix,
			RcoIngresoPrisma,
			RcoIngresoNuevoSail,
			RcoIngresoAveo,
			RcoIngresoOptra,
			RcoIngresoSonic,
			RcoIngresoCruze,
			RcoIngresoSpin,
			RcoIngresoTracker,
			RcoIngresoVivant,
			RcoIngresoOrlando,
			RcoIngresoCaptiva,
			RcoIngresoS10,
			RcoIngresoTrailblazer,
			RcoIngresoTraverse,
			RcoIngresoTahoeSuburban,
			
			RcoIngresoNLR3TON,
			RcoIngresoREWARD400DT,
			RcoIngresoREWARD400NMR,
			RcoIngresoNPR4TON,
			RcoIngresoREWARD500,
			RcoIngresoFTR10TON,
			RcoIngresoFORWARD800,
			RcoIngresoFORWARD1300,
			RcoIngresoFORWARD2000,
			
			RcoIngresoOtrasUnidades,
			RcoTotalIngresosUnidades,
			RcoTotalIngresosUnidadesMantenimiento,
			
			RcoIngresoPrimeraRevision,
			
			RcoIngresoServicio1000,
			RcoIngresoServicio1500,
			RcoIngresoServicio5000,
			RcoIngresoServicio10000,
			RcoIngresoServicio15000,
			RcoIngresoServicio20000,
			RcoIngresoServicio25000,
			RcoIngresoServicio30000,
			RcoIngresoServicio35000,
			RcoIngresoServicio40000,
			RcoIngresoServicio45000,
			RcoIngresoServicio50000,
			RcoIngresoServicio50000Mas,
			RcoIngresoServicioReparaciones,
			RcoIngresoServicioPlanchadoPintado,
			RcoIngresoServicioTrabajoInterno,
			RcoIngreseServicioGarantias,
			RcoIngresoServicioInstalacionAccesorios,
			RcoIngresoServicioInstalacionGLP,
			RcoIngresoServicioSuperCambio99,
			RcoIngresoServicioReingresos,
		
			RcoNumeroCitas,
			RcoCitasEfectivas,
			
			RcoClientesParticulares,
			RcoClientesFlotas,
			RcoPromedioPermanencia,
			RcoParalizados,
		
			RcoPersonalMecanicos,
			RcoPersonalAsesores,
			RcoPersonalOtros,
			RcoDiasLaborados,
			RcoHoraDisponibles,
			RcoHoraLaboradas,
			RcoHoraMOVendidas,
			RcoVentaManoObra,
			RcoVentaRepuestos,
			RcoTicketPromedio,
			
			RcoVentaMecanica,
			RcoVentaGarantiaFA,	
					
			RcoTiempoCreacion,
			RcoTiempoModificacion
			) 
			VALUES (
			"'.($this->RcoId).'",
			"'.($this->SucId).'",
			"'.($this->VmaId).'",	
			"'.($this->RcoMes).'",
			"'.($this->RcoAno).'",
			
			
			'.($this->RcoIngresoSparkLite).',
			'.($this->RcoIngresoSparkGT).',
			'.($this->RcoIngresoN300MoveMax).',
			'.($this->RcoIngresoN300Work).',
			'.($this->RcoIngresoCorsaChevyTaxi).',
			'.($this->RcoIngresoSail).',
			'.($this->RcoIngresoOnix).',
			'.($this->RcoIngresoPrisma).',
			'.($this->RcoIngresoNuevoSail).',
			'.($this->RcoIngresoAveo).',
			'.($this->RcoIngresoOptra).',
			'.($this->RcoIngresoSonic).',
			'.($this->RcoIngresoCruze).',
			'.($this->RcoIngresoSpin).',
			'.($this->RcoIngresoTracker).',
			'.($this->RcoIngresoVivant).',
			'.($this->RcoIngresoOrlando).',
			'.($this->RcoIngresoCaptiva).',
			'.($this->RcoIngresoS10).',
			'.($this->RcoIngresoTrailblazer).',
			'.($this->RcoIngresoTraverse).',
			'.($this->RcoIngresoTahoeSuburban).',
			
			'.($this->RcoIngresoNLR3TON).',
			'.($this->RcoIngresoREWARD400DT).',
			'.($this->RcoIngresoREWARD400NMR).',
			'.($this->RcoIngresoNPR4TON).',
			'.($this->RcoIngresoREWARD500).',
			'.($this->RcoIngresoFTR10TON).',
			'.($this->RcoIngresoFORWARD800).',
			'.($this->RcoIngresoFORWARD1300).',
			'.($this->RcoIngresoFORWARD2000).',
			
			'.($this->RcoIngresoOtrasUnidades).',
			'.($this->RcoTotalIngresosUnidades).',
			'.($this->RcoTotalIngresosUnidadesMantenimiento).',
			
			'.($this->RcoIngresoPrimeraRevision).',
			
			'.($this->RcoIngresoServicio1000).',
			'.($this->RcoIngresoServicio1500).',
			'.($this->RcoIngresoServicio5000).',
			'.($this->RcoIngresoServicio10000).',
			'.($this->RcoIngresoServicio15000).',
			'.($this->RcoIngresoServicio20000).',
			'.($this->RcoIngresoServicio25000).',
			'.($this->RcoIngresoServicio30000).',
			'.($this->RcoIngresoServicio35000).',
			'.($this->RcoIngresoServicio40000).',
			'.($this->RcoIngresoServicio45000).',
			'.($this->RcoIngresoServicio50000).',
			'.($this->RcoIngresoServicio50000Mas).',
			'.($this->RcoIngresoServicioReparaciones).',
			'.($this->RcoIngresoServicioPlanchadoPintado).',
			'.($this->RcoIngresoServicioTrabajoInterno).',
			'.($this->RcoIngreseServicioGarantias).',
			'.($this->RcoIngresoServicioInstalacionAccesorios).',
			'.($this->RcoIngresoServicioInstalacionGLP).',
			'.($this->RcoIngresoServicioSuperCambio99).',
			'.($this->RcoIngresoServicioReingresos).',
			
			'.($this->RcoNumeroCitas).',
			'.($this->RcoCitasEfectivas).',
			
			"'.($this->RcoClientesParticulares).'",
			"'.($this->RcoClientesFlotas).'",
			"'.($this->RcoPromedioPermanencia).'",
			"'.($this->RcoParalizados).'",
			
			'.($this->RcoPersonalMecanicos).',
			'.($this->RcoPersonalAsesores).',
			'.($this->RcoPersonalOtros).',
			'.($this->RcoDiasLaborados).',
			'.($this->RcoHoraDisponibles).',
			'.($this->RcoHoraLaboradas).', 
			'.($this->RcoHoraMOVendidas).', 
			'.($this->RcoVentaManoObra).', 
			'.($this->RcoVentaRepuestos).', 
			'.($this->RcoTicketPromedio).', 
			
			'.($this->RcoVentaMecanica).', 
			'.($this->RcoVentaGarantiaFA).', 
			
			"'.($this->RcoTiempoCreacion).'", 
			"'.($this->RcoTiempoModificacion).'");';					

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
	
	
	
	
	public function MtdEditarReporteCOS() {
				
		$sql = 'UPDATE tblrcoreportecos SET 
			
			RcoIngresoSparkLite = '.($this->RcoIngresoSparkLite).',
			RcoIngresoSparkGT = '.($this->RcoIngresoSparkGT).',
			RcoIngresoN300MoveMax = '.($this->RcoIngresoN300MoveMax).',
			RcoIngresoN300Work = '.($this->RcoIngresoN300Work).',
			RcoIngresoCorsaChevyTaxi = '.($this->RcoIngresoCorsaChevyTaxi).',
			RcoIngresoSail = '.($this->RcoIngresoSail).',
			RcoIngresoOnix = '.($this->RcoIngresoOnix).',
			RcoIngresoPrisma = '.($this->RcoIngresoPrisma).',
			RcoIngresoNuevoSail = '.($this->RcoIngresoNuevoSail).',
			RcoIngresoAveo = '.($this->RcoIngresoAveo).',
			RcoIngresoOptra = '.($this->RcoIngresoOptra).',
			RcoIngresoSonic = '.($this->RcoIngresoSonic).',
			
			RcoIngresoCruze = '.($this->RcoIngresoCruze).',
			RcoIngresoSpin = '.($this->RcoIngresoSpin).',
			RcoIngresoTracker = '.($this->RcoIngresoTracker).',
			RcoIngresoVivant = '.($this->RcoIngresoVivant).',
			RcoIngresoOrlando = '.($this->RcoIngresoOrlando).',
			RcoIngresoCaptiva = '.($this->RcoIngresoCaptiva).',
			RcoIngresoS10 = '.($this->RcoIngresoS10).',
			
			RcoIngresoTrailblazer = '.($this->RcoIngresoTrailblazer).',
			RcoIngresoTraverse = '.($this->RcoIngresoTraverse).',
			RcoIngresoTahoeSuburban = '.($this->RcoIngresoTahoeSuburban).',
			
			RcoIngresoNLR3TON = '.($this->RcoIngresoNLR3TON).',
			RcoIngresoREWARD400DT = '.($this->RcoIngresoREWARD400DT).',
			RcoIngresoREWARD400NMR = '.($this->RcoIngresoREWARD400NMR).',
			RcoIngresoNPR4TON = '.($this->RcoIngresoNPR4TON).',
			RcoIngresoREWARD500 = '.($this->RcoIngresoREWARD500).',
			RcoIngresoFTR10TON = '.($this->RcoIngresoFTR10TON).',
			RcoIngresoFORWARD800 = '.($this->RcoIngresoFORWARD800).',
			RcoIngresoFORWARD1300 = '.($this->RcoIngresoFORWARD1300).',
			RcoIngresoFORWARD2000 = '.($this->RcoIngresoFORWARD2000).',
		
			RcoIngresoOtrasUnidades = '.($this->RcoIngresoOtrasUnidades).',
			RcoTotalIngresosUnidades = '.($this->RcoTotalIngresosUnidades).',
			RcoTotalIngresosUnidadesMantenimiento = '.($this->RcoTotalIngresosUnidadesMantenimiento).',
			
		
			RcoIngresoPrimeraRevision = '.($this->RcoIngresoPrimeraRevision).',
			RcoIngresoServicio5000 = '.($this->RcoIngresoServicio5000).',
			RcoIngresoServicio10000 = '.($this->RcoIngresoServicio10000).',
			RcoIngresoServicio15000 = '.($this->RcoIngresoServicio15000).',
			RcoIngresoServicio20000 = '.($this->RcoIngresoServicio20000).',
			RcoIngresoServicio25000 = '.($this->RcoIngresoServicio25000).',
			RcoIngresoServicio30000 = '.($this->RcoIngresoServicio30000).',
			RcoIngresoServicio35000 = '.($this->RcoIngresoServicio35000).',
			RcoIngresoServicio40000 = '.($this->RcoIngresoServicio40000).',
			RcoIngresoServicio45000 = '.($this->RcoIngresoServicio45000).',
			RcoIngresoServicio50000 = '.($this->RcoIngresoServicio50000).',
			RcoIngresoServicio50000Mas = '.($this->RcoIngresoServicio50000Mas).',
			RcoIngresoServicioReparaciones = '.($this->RcoIngresoServicioReparaciones).',
			
			RcoIngresoServicioPlanchadoPintado = '.($this->RcoIngresoServicioPlanchadoPintado).',
			RcoIngresoServicioTrabajoInterno = '.($this->RcoIngresoServicioTrabajoInterno).',
			RcoIngreseServicioGarantias = '.($this->RcoIngreseServicioGarantias).',
			RcoIngresoServicioInstalacionAccesorios = '.($this->RcoIngresoServicioInstalacionAccesorios).',
			RcoIngresoServicioInstalacionGLP = '.($this->RcoIngresoServicioInstalacionGLP).',
			
			RcoIngresoServicioSuperCambio99 = '.($this->RcoIngresoServicioSuperCambio99).',
			RcoIngresoServicioReingresos = '.($this->RcoIngresoServicioReingresos).',
				
			RcoNumeroCitas = '.($this->RcoNumeroCitas).',
			RcoCitasEfectivas = '.($this->RcoCitasEfectivas).',
		
			RcoClientesParticulares = '.($this->RcoClientesParticulares).',
			RcoClientesFlotas = '.($this->RcoClientesFlotas).',
			RcoPromedioPermanencia = '.($this->RcoPromedioPermanencia).',
			RcoParalizados = '.($this->RcoParalizados).',
			
		
			RcoPersonalMecanicos = '.($this->RcoPersonalMecanicos).',
			RcoPersonalAsesores = '.($this->RcoPersonalAsesores).',
			RcoPersonalOtros = '.($this->RcoPersonalOtros).',
			RcoDiasLaborados = '.($this->RcoDiasLaborados).',
			
			RcoHoraDisponibles = '.($this->RcoHoraDisponibles).',
			RcoHoraLaboradas = '.($this->RcoHoraLaboradas).',
			RcoHoraMOVendidas = '.($this->RcoHoraMOVendidas).',
			RcoVentaManoObra = '.($this->RcoVentaManoObra).',
			
		
			RcoTarifaMO = '.($this->RcoTarifaMO).',
			RcoVentaRepuestos = '.($this->RcoVentaRepuestos).',
			RcoTicketPromedio = '.($this->RcoTicketPromedio).',
			RcoVentaMecanica = '.($this->RcoVentaMecanica).',
			RcoVentaGarantiaFA = '.($this->RcoVentaGarantiaFA).',
			 
			 RcoEstado = '.($this->RcoEstado).',
			 RcoTiempoModificacion = "'.($this->RcoTiempoModificacion).'"
			 
			 WHERE RcoId = "'.($this->RcoId).'";';
				 
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {						
				return false;
			} else {				
				return true;
			}						
				
		}	
		
		
		
	public function MtdEditarReporteCOSDato($oCampo,$oDato,$oId) {
	
		$sql = 'UPDATE tblrcoreportecos SET 
		'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
		RcoTiempoModificacion = NOW()
		WHERE RcoId = "'.($oId).'";';
		
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