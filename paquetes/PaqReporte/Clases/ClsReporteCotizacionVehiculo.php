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

class ClsReporteCotizacionVehiculo {

    public $InsMysql;

	
    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

		
	  public function MtdObtenerReporteCotizacionVehiculo($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL) {

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
						
						$fecha = ' AND DATE(cve.CveFecha) >="'.$oFechaInicio.'" AND DATE(cve.CveFecha) <="'.$oFechaFin.'"';
						
					}else{
						$fecha = ' AND  DATE(cve.CveFecha) >="'.$oFechaInicio.'"';
					}
				}else{
					if(!empty($oFechaFin)){
						$fecha = ' AND DATE(cve.CveFecha)<="'.$oFechaFin.'"';		
					}			
				}
				
			
	
		
		
	if(!empty($oSucursal)){
			$sucursal = ' AND cve.SucId = "'.$oSucursal.'"';
		}
		
		 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS
				 
				 cve.CveId,
				suc.SucNombre,
				DATE_FORMAT(cve.CveFecha, "%d/%m/%Y") AS "NCveFecha",
					
				cli.CliNumeroDocumento,
				
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				cli.CliTelefono,
				cli.CliCelular,
				
				cli.CliEmail,
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS "CliNombreCompleto",				
				CONCAT(IFNULL(per.PerNombre,"")," ",IFNULL(per.PerApellidoPaterno,"")," ",IFNULL(per.PerApellidoMaterno,"")) AS "PerNombreCompleto",
				
				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre,
				
				trf.TrfNombre,
				
				cve.CvePrecio,
				cve.CveTotal,
				
				cve.MonId,
				cve.CveTipoCambio,
				
				mon.MonNombre,
				mon.MonSimbolo
				
	
				FROM tblcvecotizacionvehiculo cve
				LEFT JOIN tblvvevehiculoversion vve
				ON cve.VveId = vve.VveId
					LEFT JOIN tblvmovehiculomodelo vmo
					ON vve.VmoId = vmo.VmoId
						LEFT JOIN tblvmavehiculomarca vma
						ON vmo.VmaId = vma.VmaId
							LEFT JOIN tblperpersonal per
							ON cve.PerId = per.PerId
								LEFT JOIN tblsucsucursal suc
								ON cve.SucId = suc.SucId
									LEFT JOIN tblclicliente cli
									ON cve.CliId = cli.CliId
										LEFT JOIN tbltrftiporeferido trf
										ON cli.TrfId = trf.TrfId
					LEFT JOIN tblmonmoneda mon
					ON cve.MonId = mon.MonId

			WHERE cve.CveEstado <> 6 '.$filtrar.$fecha.$ovvehiculo.$sucursal.$tipo.$stipo.$entrega.$estado.$moneda.$cocompra.$vdirecta.$ocompra.$faccion.$fingreso.$orden.$paginacion;
										
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsReporteCotizacionVehiculo = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
		

					$ReporteCotizacionVehiculo = new $InsReporteCotizacionVehiculo();
					
					
					  $ReporteCotizacionVehiculo->CveId = $fila['CveId'];
                    $ReporteCotizacionVehiculo->SucNombre = $fila['SucNombre'];
					
					$ReporteCotizacionVehiculo->CveFecha = $fila['NCveFecha'];
					$ReporteCotizacionVehiculo->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					
					$ReporteCotizacionVehiculo->CliNombre = $fila['CliNombre'];					
					$ReporteCotizacionVehiculo->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$ReporteCotizacionVehiculo->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					$ReporteCotizacionVehiculo->CliTelefono = $fila['CliTelefono'];
					$ReporteCotizacionVehiculo->CliCelular = $fila['CliCelular'];
					$ReporteCotizacionVehiculo->CliEmail = $fila['CliEmail'];
					
					
					
					
					$ReporteCotizacionVehiculo->PerNombre = $fila['PerNombre'];					
					$ReporteCotizacionVehiculo->PerApellidoPaterno = $fila['PerApellidoPaterno'];					
					$ReporteCotizacionVehiculo->PerApellidoMaterno = $fila['PerApellidoMaterno'];	
									
					$ReporteCotizacionVehiculo->AvvVehiculoModelo = $fila['CliNombreCompleto'];
					$ReporteCotizacionVehiculo->AvvVehiculoVersion = $fila['PerNombreCompleto'];										
					
					
					$ReporteCotizacionVehiculo->VmaNombre = $fila['VmaNombre'];
					$ReporteCotizacionVehiculo->VmoNombre = $fila['VmoNombre'];
					$ReporteCotizacionVehiculo->VveNombre = $fila['VveNombre'];

					$ReporteCotizacionVehiculo->TrfNombre = $fila['TrfNombre'];
					
					$ReporteCotizacionVehiculo->CvePrecio = $fila['CvePrecio'];
					$ReporteCotizacionVehiculo->CveTotal = $fila['CveTotal'];
					
					$ReporteCotizacionVehiculo->MonId = $fila['MonId'];
					$ReporteCotizacionVehiculo->CveTipoCambio = $fila['CveTipoCambio'];
					
					
					$ReporteCotizacionVehiculo->MonNombre = $fila['MonNombre'];
					$ReporteCotizacionVehiculo->MonSimbolo = $fila['MonSimbolo'];


                    $ReporteCotizacionVehiculo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ReporteCotizacionVehiculo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}



}
?>