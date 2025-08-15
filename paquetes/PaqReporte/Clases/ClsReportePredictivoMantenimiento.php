<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsReportePredictivoMantenimiento
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReportePredictivoMantenimiento {

   
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
	
	
   public function MtdObtenerReportePredictivoMantenimientos($oFechaInicio=NULL,$oFechaFin=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oSucursal=NULL){
	   
		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ein.EinFichaIngresoFechaPredecida)>="'.$oFechaInicio.'" AND DATE(ein.EinFichaIngresoFechaPredecida)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(ein.EinFichaIngresoFechaPredecida)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ein.EinFichaIngresoFechaPredecida)<="'.$oFechaFin.'"';		
			}			
		}
		
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND vmo.VmaId = "'.$oVehiculoMarca.'"';		
		}			

		if(!empty($oVehiculoModelo)){
			$vmodelo = ' AND vve.VmoId = "'.$oVehiculoModelo.'"';		
		}	
		
		if(!empty($oSucursal)){
			//$sucursal = ' AND ein.SucId = "'.$oSucursal.'"';		
			
			$sucursal = ' 
			AND EXISTS (
				SELECT 
				fin.FinId
				FROM tblfinfichaingreso fin
				WHERE fin.EinId = ein.EinId
				AND fin.SucId = "'.$oSucursal.'"
				ORDER BY fin.FinFecha DESC				
				LIMIT 1
			)
			';	
				
		}			

			$sql = 'SELECT
					SQL_CALC_FOUND_ROWS 
					
					ein.EinId,
					
					ein.EinVIN,
					ein.EinPlaca,
					vma.VmaNombre,
					vmo.VmoNombre,
				
					DATE_FORMAT(ein.EinFichaIngresoFechaUltimo, "%d/%m/%Y") AS "NEinFichaIngresoFechaUltimo",
					ein.EinFichaIngresoMantenimientoKilometrajeUltimo,
					
					DATE_FORMAT(ein.EinFichaIngresoFechaPredecida, "%d/%m/%Y") AS "NEinFichaIngresoFechaPredecida",
					IF(ein.EinFichaIngresoMantenimientoKilometrajeUltimo="1500","5000",(IF(ein.EinFichaIngresoMantenimientoKilometrajeUltimo="1000","5000",(ein.EinFichaIngresoMantenimientoKilometrajeUltimo+5000)))) AS EinFichaIngresoProximoMantenimientoKilometraje,
					
					CONCAT(IFNULL(cli.CliNombre,""),"",IFNULL(cli.CliApellidoPaterno,""),"",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombreCompleto,
					lti.LtiNombre,
					cli.CliTelefono,
					cli.CliCelular,
					cli.CliContactoCelular1,
					cli.CliContactoCelular2,
					cli.CliContactoCelular3,
					
					suc.SucNombre,
					
						ein.EinPredictivoObservacion,
				DATE_FORMAT(ein.EinPredictivoFecha, "%d/%m/%Y") AS "NEinPredictivoFecha"
		
		
					
					FROM tbleinvehiculoingreso ein
						LEFT JOIN tblvvevehiculoversion vve
						ON ein.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId	
								LEFT JOIN tblvmavehiculomarca vma
								ON vmo.VmaId = vma.VmaId
									LEFT JOIN tblclicliente cli
									ON ein.CliId = cli.CliId
										LEFT JOIN tbllticlientetipo lti
									ON cli.LtiId = lti.LtiId
				
LEFT JOIN tblsucsucursal suc
ON ein.SucId = suc.SucId

				WHERE 1 = 1 
				'.$producto.$fecha.$sucursal.$vmarca.$vmodelo.$ano.$mes."  ".$orden."   ".$paginacion;
				
				
			
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsReportePredictivoMantenimientoVenta = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReportePredictivoMantenimiento = new $InsReportePredictivoMantenimientoVenta();
                    
					
					$ReportePredictivoMantenimiento->EinId = $fila['EinId'];
					
					$ReportePredictivoMantenimiento->EinVIN = $fila['EinVIN'];
					$ReportePredictivoMantenimiento->EinPlaca = $fila['EinPlaca'];
					$ReportePredictivoMantenimiento->VmaNombre = $fila['VmaNombre'];
					$ReportePredictivoMantenimiento->VmoNombre = $fila['VmoNombre'];
					$ReportePredictivoMantenimiento->EinFichaIngresoFechaUltimo = $fila['NEinFichaIngresoFechaUltimo'];
					$ReportePredictivoMantenimiento->EinFichaIngresoMantenimientoKilometrajeUltimo = $fila['EinFichaIngresoMantenimientoKilometrajeUltimo'];
					$ReportePredictivoMantenimiento->EinFichaIngresoFechaPredecida = $fila['NEinFichaIngresoFechaPredecida'];
					$ReportePredictivoMantenimiento->EinFichaIngresoProximoMantenimientoKilometraje = $fila['EinFichaIngresoProximoMantenimientoKilometraje'];
					
					$ReportePredictivoMantenimiento->CliNombreCompleto = $fila['CliNombreCompleto'];
					$ReportePredictivoMantenimiento->LtiNombre = $fila['LtiNombre'];
					$ReportePredictivoMantenimiento->CliTelefono = $fila['CliTelefono'];
					$ReportePredictivoMantenimiento->CliCelular = $fila['CliCelular'];
					
					$ReportePredictivoMantenimiento->SucNombre = $fila['SucNombre'];
					
					$ReportePredictivoMantenimiento->EinPredictivoObservacion = $fila['EinPredictivoObservacion'];
					$ReportePredictivoMantenimiento->EinPredictivoFecha = $fila['NEinPredictivoFecha'];
					
					
					
                    $ReportePredictivoMantenimiento->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ReportePredictivoMantenimiento;
			
				}
				
				$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
   }
   
}
?>