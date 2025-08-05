<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsReporteFichaIngresoConsolidado
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReporteFichaIngresoConsolidado {

	
	public $Transaccion;
	
    public function __construct(){
		$this->InsMysql = new ClsMysql();
		$this->Transaccion = false;
    }
	
	public function __destruct(){

	}

	

    public function MtdObtenerReporteFichaIngresoConsolidados($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden="Total",$oSentido="ASC",$oFechaInicio=NULL,$oFechaFin=NULL,$oAgrupar=NULL,$oModalidadIngreso=NULL,$oMarca=NULL,$oModelo=NULL,$oFichaIngresoTipo=NULL,$oSucursal=NULL) {

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
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(fin.FinFecha)>="'.$oFechaInicio.'" AND DATE(fin.FinFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(fin.FinFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(fin.FinFecha)<="'.$oFechaFin.'"';		
			}			
		}
		
			if(!empty($oModalidadIngreso)){
				
				$mingreso = ' 
				
					AND EXISTS(
						SELECT 
						fim.FimId 
						FROM tblfimfichaingresomodalidad fim
							WHERE fim.FinId = fin.FinId
						AND fim.MinId = "'.$oModalidadIngreso.'"
					)
				
				';
						
			}
			
			
			if(!empty($oMarca)){
				$marca = ' AND vmo.VmaId = "'.$oMarca.'"';		
			}
			
			if(!empty($oModelo)){
				$modelo = ' AND vve.VmoId = "'.$oModelo.'"';		
			}		


		if(!empty($oAgrupar)){
			$agrupar = ' GROUP BY '.($oAgrupar);
		}
		
		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}
		
		if(!empty($oFichaIngresoTipo)){
			$fitipo = ' AND fin.FinTipo = "'.$oFichaIngresoTipo.'"';		
		}
if(!empty($oSucursal)){
				$sucursal = ' AND fin.SucId = "'.$oSucursal.'"';		
			}	

			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vma.VmaNombre,
				vmo.VmoNombre,
				COUNT(fin.FinId) AS RfcTotal,
				
				DATEDIFF(IFNULL("'.$oFechaFin.'",NOW()),IFNULL("'.$oFechaInicio.'",NOW())) AS RfcDiferenciaDia
				
				FROM tblfinfichaingreso fin

					LEFT JOIN tbleinvehiculoingreso ein
					ON fin.EinId = ein.EinId  
						
						LEFT JOIN tblvvevehiculoversion vve
						ON ein.VveId = vve.VveId
						
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId 
							
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
													
				WHERE fin.FinEstado <> 7777 '.$filtrar.$sucursal.$fecha.$mingreso.$marca.$modelo.$fitipo.$agrupar.$orden;

			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();

            $InsReporteFichaIngresoConsolidado = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReporteFichaIngresoConsolidado = new $InsReporteFichaIngresoConsolidado();

                    $ReporteFichaIngresoConsolidado->VmaNombre = $fila['VmaNombre'];
					$ReporteFichaIngresoConsolidado->VmoNombre = $fila['VmoNombre'];					
					$ReporteFichaIngresoConsolidado->RfcTotal = $fila['RfcTotal'];
					$ReporteFichaIngresoConsolidado->RfcDiferenciaDia = $fila['RfcDiferenciaDia'];
					
                    $ReporteFichaIngresoConsolidado->InsMysql = NULL;                    
	
					$Respuesta['Datos'][]= $ReporteFichaIngresoConsolidado;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		

	
	
	public function MtdObtenerReporteFichaIngresoConsolidadoClientes($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oModalidadIngreso=NULL,$oAgrupar=NULL) {

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
				$fecha = ' AND DATE(fin.FinFecha)>="'.$oFechaInicio.'" AND DATE(fin.FinFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(fin.FinFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(fin.FinFecha)<="'.$oFechaFin.'"';		
			}			
		}
		
			if(!empty($oModalidadIngreso)){
				$mingreso = ' AND fim.MinId = "'.$oModalidadIngreso.'"';		
			}
			
			if(!empty($oAgrupar)){
				$agrupar = ' GROUP BY '.$oAgrupar.'';		
			}

			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				
				fin.FinId,
				fin.CliId,
				DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",
				
				cli.CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliapellidoMaterno,
				
				cli.CliDepartamento,
				cli.CliProvincia,
				cli.CliCSIIncluir,
				
				min.MinNombre,
				vma.VmaNombre,
				vmo.VmoNombre,
				
				min.MinId,
				fin.FinMantenimientoKilometraje,
				fin.FinVehiculoKilometraje,
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				DATE_FORMAT(fin.FinTiempoTallerRevisando, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTallerRevisando",
				DATE_FORMAT(fin.FinTiempoTrabajoTerminado, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTrabajoTerminado",
				
				DATE_FORMAT(fin.FinTiempoTallerConcluido, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTallerConcluido",
				
				(TIMESTAMPDIFF(SECOND, FinTiempoTallerRevisando, FinTiempoTrabajoTerminado) /3600) AS FinTiempoTranscurrido,
				(TIMESTAMPDIFF(SECOND, FinTiempoTallerRevisando, FinTiempoTallerConcluido) /3600) AS FinTiempoTranscurrido2,
				
				
				
				fta.FtaNumero,
				fac.FacId,
				fac.FacTotal,
				DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y") AS "NFacFechaEmision",
				
				bta.BtaNumero,				
				bol.BolId,
				bol.BolTotal,
				DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y") AS "NBolFechaEmision",
				
				ein.EinVIN,
				ein.EinPlaca,
				
				
						per2.PerNombre AS PerNombreAsesor,
					per2.PerApellidoPaterno AS PerApellidoPaternoAsesor,
					per2.PerApellidoMaterno AS PerApellidoMaternoAsesor,
					
					fin.FinTelefono,
					
					onc.OncCodigoDealer,
					onc.OncNombre,
					
					min.MinSigla,
					
					lti.LtiAbreviatura
		
		
			
				FROM tblfccfichaaccion fcc

					LEFT JOIN tblamoalmacenmovimiento amo
					ON amo.FccId = fcc.FccId
					
						LEFT JOIN tblfacfactura fac
						ON fac.AmoId = amo.AmoId
							LEFT JOIN tblftafacturatalonario fta
							ON fac.FtaId = fta.FtaId
							
								LEFT JOIN tblbolboleta bol
								ON bol.AmoId = amo.AmoId
									LEFT JOIN tblbtaboletatalonario bta
									ON bol.BtaId = bta.BtaId
																
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
				
							LEFT JOIN tblclicliente cli
							ON	fin.CliId = cli.CliId
								LEFT JOIN tblperpersonal per
								ON fin.PerId = per.PerId
									LEFT JOIN tbllticlientetipo lti
									ON cli.LtiId = lti.LtiId
									
												LEFT JOIN tblperpersonal per2
												ON fin.PerIdAsesor = per2.PerId
												
												LEFT JOIN tbloncconcesionario onc
												ON ein.OncId = onc.OncId
												
				WHERE 1 = 1 '.$filtrar.$fecha.$mingreso.$agrupar." GROUP BY fin.CliId ".$orden.$paginacion;

			$resultado = $this->InsMysql->MtdConsultar($sql);            

//IF(IFNULL(fac.AmoId
//				,IFNULL(bol.AmoId,"F")) AS FinComprobanteVentaTipo,
				
			$Respuesta['Datos'] = array();

            $InsReporteFichaIngresoConsolidado = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReporteFichaIngresoConsolidado = new $InsReporteFichaIngresoConsolidado();

                    $ReporteFichaIngresoConsolidado->FinId = $fila['FinId'];
					$ReporteFichaIngresoConsolidado->CliId = $fila['CliId'];
					
					$ReporteFichaIngresoConsolidado->FinFecha = $fila['NFinFecha'];
					
					$ReporteFichaIngresoConsolidado->CliNombreCompleto = $fila['CliNombreCompleto'];
					
					$ReporteFichaIngresoConsolidado->CliNombre = $fila['CliNombre'];
					$ReporteFichaIngresoConsolidado->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$ReporteFichaIngresoConsolidado->CliapellidoMaterno = $fila['CliapellidoMaterno'];

				
					$ReporteFichaIngresoConsolidado->CliDepartamento = $fila['CliDepartamento'];
					$ReporteFichaIngresoConsolidado->CliProvincia = $fila['CliProvincia'];
					$ReporteFichaIngresoConsolidado->CliCSIIncluir = $fila['CliCSIIncluir'];
					
					$ReporteFichaIngresoConsolidado->MinNombre = $fila['MinNombre'];
					$ReporteFichaIngresoConsolidado->VmaNombre = $fila['VmaNombre'];
					$ReporteFichaIngresoConsolidado->VmoNombre = $fila['VmoNombre'];
					
					
					$ReporteFichaIngresoConsolidado->MinId = $fila['MinId'];
					$ReporteFichaIngresoConsolidado->FinMantenimientoKilometraje = $fila['FinMantenimientoKilometraje'];
					$ReporteFichaIngresoConsolidado->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje'];				
						
	
					$ReporteFichaIngresoConsolidado->PerNombre = $fila['PerNombre'];
					$ReporteFichaIngresoConsolidado->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$ReporteFichaIngresoConsolidado->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					
					$ReporteFichaIngresoConsolidado->FinTiempoTallerRevisando = $fila['NFinTiempoTallerRevisando'];
					$ReporteFichaIngresoConsolidado->FinTiempoTrabajoTerminado = $fila['NFinTiempoTrabajoTerminado'];
					$ReporteFichaIngresoConsolidado->FinTiempoTallerConcluido = $fila['NFinTiempoTallerConcluido'];
					
					$ReporteFichaIngresoConsolidado->FinTiempoTranscurrido = $fila['FinTiempoTranscurrido'];
					$ReporteFichaIngresoConsolidado->FinTiempoTranscurrido2 = $fila['FinTiempoTranscurrido2'];
					
					$ReporteFichaIngresoConsolidado->FacId = $fila['FacId'];
					$ReporteFichaIngresoConsolidado->FtaNumero = $fila['FtaNumero'];
					$ReporteFichaIngresoConsolidado->FacFechaEmision = $fila['NFacFechaEmision'];
					$ReporteFichaIngresoConsolidado->FacTotal = $fila['FacTotal'];
					
					$ReporteFichaIngresoConsolidado->BolId = $fila['BolId'];
					$ReporteFichaIngresoConsolidado->BtaNumero = $fila['BtaNumero'];
					$ReporteFichaIngresoConsolidado->BolFechaEmision = $fila['NBolFechaEmision'];					
					$ReporteFichaIngresoConsolidado->BolTotal = $fila['BolTotal'];
					
					$ReporteFichaIngresoConsolidado->EinVIN = $fila['EinVIN'];
					$ReporteFichaIngresoConsolidado->EinPlaca = $fila['EinPlaca'];

					$ReporteFichaIngresoConsolidado->PerNombreAsesor = $fila['PerNombreAsesor'];
					$ReporteFichaIngresoConsolidado->PerApellidoPaternoAsesor = $fila['PerApellidoPaternoAsesor'];
					$ReporteFichaIngresoConsolidado->PerApellidoMaternoAsesor = $fila['PerApellidoMaternoAsesor'];
					
					$ReporteFichaIngresoConsolidado->FinTelefono = $fila['FinTelefono'];

					$ReporteFichaIngresoConsolidado->OncCodigoDealer = $fila['OncCodigoDealer'];

					$ReporteFichaIngresoConsolidado->OncNombre = $fila['OncNombre'];
					
					$ReporteFichaIngresoConsolidado->MinSigla = $fila['MinSigla'];
					
					$ReporteFichaIngresoConsolidado->LtiAbreviatura = $fila['LtiAbreviatura'];

					if(empty($ReporteFichaIngresoConsolidado->FacId)){
						if(empty($ReporteFichaIngresoConsolidado->BolId)){
							$ReporteFichaIngresoConsolidado->FinComprobanteVentaTipo = "";		
						}else{
							$ReporteFichaIngresoConsolidado->FinComprobanteVentaTipo = "B";
						}
					}else{
						$ReporteFichaIngresoConsolidado->FinComprobanteVentaTipo = "F";
					}

                    $ReporteFichaIngresoConsolidado->InsMysql = NULL;                    
	
					$Respuesta['Datos'][]= $ReporteFichaIngresoConsolidado;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}



}
?>