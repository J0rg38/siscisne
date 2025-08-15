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

class ClsReporteFichaIngreso {

	public $FinId;
	public $CliNombreCompleto;
	public $MinNombre;
	public $VmaNombre;
	public $VmoNombre;
	
	public $CliCSIIncluir;
	
	public $MinId;
	public $FinMantenimientoKilometraje;
	public $FinVehiculoKilometraje;
	
	public $PerNombre;
	public $PerApellidoPaterno;
	public $PerApellidoMaterno;
	
	public $FinTiempoTallerRevisando;
	public $FinTiempoTrabajoTerminado;
	public $FinTiempoTallerConcluido;
	
	public $FinTiempoTranscurrido;
	public $FinTiempoTranscurrido2;
	
	public $FacId;
	public $FacFechaEmision;
	public $FacTotal;
	public $FtaNumero;
	
	public $BolId;
	public $BolFechaEmision;
	public $BolTotal;
	public $BtaNumero;
	
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

	

    public function MtdObtenerReporteFichaIngresos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oModalidadIngreso=NULL,$oAgrupar=NULL) {

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
					
					min.MinSigla
		
		
			
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
							
												LEFT JOIN tblperpersonal per2
												ON fin.PerIdAsesor = per2.PerId
												
												LEFT JOIN tbloncconcesionario onc
												ON ein.OncId = onc.OncId
												
				WHERE 1 = 1 '.$filtrar.$fecha.$mingreso.$agrupar.$orden."  ".$paginacion;

			$resultado = $this->InsMysql->MtdConsultar($sql);            

//IF(IFNULL(fac.AmoId
//				,IFNULL(bol.AmoId,"F")) AS FinComprobanteVentaTipo,
				
			$Respuesta['Datos'] = array();

            $InsReporteFichaIngreso = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReporteFichaIngreso = new $InsReporteFichaIngreso();

                    $ReporteFichaIngreso->FinId = $fila['FinId'];
					$ReporteFichaIngreso->CliId = $fila['CliId'];
					
					$ReporteFichaIngreso->FinFecha = $fila['NFinFecha'];
					
					$ReporteFichaIngreso->CliNombreCompleto = $fila['CliNombreCompleto'];
					
					$ReporteFichaIngreso->CliNombre = $fila['CliNombre'];
					$ReporteFichaIngreso->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$ReporteFichaIngreso->CliapellidoMaterno = $fila['CliapellidoMaterno'];

				
					$ReporteFichaIngreso->CliDepartamento = $fila['CliDepartamento'];
					$ReporteFichaIngreso->CliProvincia = $fila['CliProvincia'];
					$ReporteFichaIngreso->CliCSIIncluir = $fila['CliCSIIncluir'];
					
					$ReporteFichaIngreso->MinNombre = $fila['MinNombre'];
					$ReporteFichaIngreso->VmaNombre = $fila['VmaNombre'];
					$ReporteFichaIngreso->VmoNombre = $fila['VmoNombre'];
					
					
					$ReporteFichaIngreso->MinId = $fila['MinId'];
					$ReporteFichaIngreso->FinMantenimientoKilometraje = $fila['FinMantenimientoKilometraje'];
					$ReporteFichaIngreso->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje'];				
						
	
					$ReporteFichaIngreso->PerNombre = $fila['PerNombre'];
					$ReporteFichaIngreso->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$ReporteFichaIngreso->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					
					$ReporteFichaIngreso->FinTiempoTallerRevisando = $fila['NFinTiempoTallerRevisando'];
					$ReporteFichaIngreso->FinTiempoTrabajoTerminado = $fila['NFinTiempoTrabajoTerminado'];
					$ReporteFichaIngreso->FinTiempoTallerConcluido = $fila['NFinTiempoTallerConcluido'];
					
					$ReporteFichaIngreso->FinTiempoTranscurrido = $fila['FinTiempoTranscurrido'];
					$ReporteFichaIngreso->FinTiempoTranscurrido2 = $fila['FinTiempoTranscurrido2'];
					
					$ReporteFichaIngreso->FacId = $fila['FacId'];
					$ReporteFichaIngreso->FtaNumero = $fila['FtaNumero'];
					$ReporteFichaIngreso->FacFechaEmision = $fila['NFacFechaEmision'];
					$ReporteFichaIngreso->FacTotal = $fila['FacTotal'];
					
					$ReporteFichaIngreso->BolId = $fila['BolId'];
					$ReporteFichaIngreso->BtaNumero = $fila['BtaNumero'];
					$ReporteFichaIngreso->BolFechaEmision = $fila['NBolFechaEmision'];					
					$ReporteFichaIngreso->BolTotal = $fila['BolTotal'];
					
					$ReporteFichaIngreso->EinVIN = $fila['EinVIN'];
					$ReporteFichaIngreso->EinPlaca = $fila['EinPlaca'];

					$ReporteFichaIngreso->PerNombreAsesor = $fila['PerNombreAsesor'];
					$ReporteFichaIngreso->PerApellidoPaternoAsesor = $fila['PerApellidoPaternoAsesor'];
					$ReporteFichaIngreso->PerApellidoMaternoAsesor = $fila['PerApellidoMaternoAsesor'];
					
					$ReporteFichaIngreso->FinTelefono = $fila['FinTelefono'];

					$ReporteFichaIngreso->OncCodigoDealer = $fila['OncCodigoDealer'];

					$ReporteFichaIngreso->OncNombre = $fila['OncNombre'];
					
					$ReporteFichaIngreso->MinSigla = $fila['MinSigla'];

					if(empty($ReporteFichaIngreso->FacId)){
						if(empty($ReporteFichaIngreso->BolId)){
							$ReporteFichaIngreso->FinComprobanteVentaTipo = "";		
						}else{
							$ReporteFichaIngreso->FinComprobanteVentaTipo = "B";
						}
					}else{
						$ReporteFichaIngreso->FinComprobanteVentaTipo = "F";
					}

                    $ReporteFichaIngreso->InsMysql = NULL;                    
	
					$Respuesta['Datos'][]= $ReporteFichaIngreso;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		

	
	
	



}
?>