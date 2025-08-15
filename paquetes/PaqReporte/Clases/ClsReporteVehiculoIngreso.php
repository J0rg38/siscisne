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

class ClsReporteVehiculoIngreso {

    public $InsMysql;
	
	public $Transaccion;
	
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

    public function MtdObtenerVehiculoIngresoPromedioDiaMantenimiento($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'GarId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL) {

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
		
		if(!empty($oSucursal)){
			$sucursal = ' AND ein.SucId = "'.($oSucursal).'" ';
		}
		
		echo	$sql = 'SELECT
					SQL_CALC_FOUND_ROWS 
					
					fin.SucId,
					ein.EinId,
					ein.EinVIN,
				
					(
						SELECT
						fin2.FinFecha
						FROM tblfinfichaingreso fin2
						WHERE fin2.EinId = ein.EinId
						AND EXISTS(
							SELECT fim.FimId 
							FROM tblfimfichaingresomodalidad fim
							WHERE  fim.FinId = fin2.FinId
							AND fim.MinId = "MIN-10001" LIMIT 1
						)
						ORDER BY fin2.FinFecha DESC
						LIMIT 1
					)AS EinFichaIngresoFechaUltimo,
				
					(
						SELECT
						fin2.FinMantenimientoKilometraje
						FROM tblfinfichaingreso fin2
						WHERE fin2.EinId = ein.EinId
						AND EXISTS(
							SELECT fim.FimId 
							FROM tblfimfichaingresomodalidad fim
							WHERE  fim.FinId = fin2.FinId
							AND fim.MinId = "MIN-10001" LIMIT 1
						)
						ORDER BY fin2.FinFecha DESC
						LIMIT 1
					)AS EinFichaIngresoMantenimientoKilometrajeUltimo,


					AVG(DATEDIFF((
						SELECT 
						(fin2.FinFecha)
						FROM tblfinfichaingreso fin2
						WHERE fin2.EinId = fin.EinId
						AND fin2.FinFecha > fin.FinFecha
					
						AND EXISTS(
							SELECT fim.FimId FROM tblfimfichaingresomodalidad fim
							WHERE fim.FinId = fin2.FinId
							AND fim.MinId = "MIN-10001"
						)
					ORDER BY fin2.FinFecha ASC
					LIMIT 1
					),fin.FinFecha)) AS EinPromedioDiaMantenimiento,
					
					
					DATE_ADD(


					(
						SELECT
						fin2.FinFecha
						FROM tblfinfichaingreso fin2
						WHERE fin2.EinId = ein.EinId
						AND EXISTS(
							SELECT fim.FimId 
							FROM tblfimfichaingresomodalidad fim
							WHERE  fim.FinId = fin2.FinId
							AND fim.MinId = "MIN-10001" LIMIT 1
						)
						ORDER BY fin2.FinFecha DESC
						LIMIT 1
					), INTERVAL 
					
						ROUND(
						(
						AVG(DATEDIFF((
												SELECT 
												(fin2.FinFecha)
												FROM tblfinfichaingreso fin2
												WHERE fin2.EinId = fin.EinId
												AND fin2.FinFecha > fin.FinFecha
											
												AND EXISTS(
													SELECT fim.FimId FROM tblfimfichaingresomodalidad fim
													WHERE fim.FinId = fin2.FinId
													AND fim.MinId = "MIN-10001"
												)
											ORDER BY fin2.FinFecha ASC
											LIMIT 1
											),fin.FinFecha))
						)

,0) 
					
					DAY) AS EinFichaIngresoFechaPredecida,
					
					suc.SucNombre,
					suc.SucSiglas
	
					FROM tblfinfichaingreso fin
						LEFT JOIN tbleinvehiculoingreso ein
						ON fin.EinId = ein.EinId
							LEFT JOIN tblsucsucursal suc
							ON ein.SucId = suc.SucId
							
						WHERE  EXISTS(
							SELECT fim.FimId FROM tblfimfichaingresomodalidad fim
							WHERE fim.FinId = fin.FinId
							AND fim.MinId = "MIN-10001"
						)

						AND IFNULL((
							SELECT 
							COUNT(fin2.FinId) 
							FROM tblfinfichaingreso fin2
							WHERE fin.EinId = fin2.EinId
							LIMIT 1
						),0)>3

				 '.$filtrar.$fecha.$sucursal.$estado.$moneda." GROUP BY fin.EinId ".$orden." ".$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoIngreso = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VehiculoIngreso = new $InsVehiculoIngreso();
					
					
					
					$VehiculoIngreso->SucId = $fila['SucId'];
                    $VehiculoIngreso->EinId = $fila['EinId'];
					
					$VehiculoIngreso->EinVIN = $fila['EinVIN'];
					$VehiculoIngreso->EinPromedioDiaMantenimiento = $fila['EinPromedioDiaMantenimiento'];
					$VehiculoIngreso->EinFichaIngresoFechaUltimo = $fila['EinFichaIngresoFechaUltimo'];
					$VehiculoIngreso->EinFichaIngresoMantenimientoKilometrajeUltimo = $fila['EinFichaIngresoMantenimientoKilometrajeUltimo'];
					$VehiculoIngreso->EinFichaIngresoFechaPredecida = $fila['EinFichaIngresoFechaPredecida'];
					  $VehiculoIngreso->SucNombre = $fila['SucNombre'];
					   $VehiculoIngreso->SucSiglas = $fila['SucSiglas'];
				
                    $VehiculoIngreso->InsMysql = NULL;  
					                  
					$Respuesta['Datos'][]= $VehiculoIngreso;
					
            }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
	

}
?>