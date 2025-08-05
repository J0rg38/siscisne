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
	
    public function __construct(){
		$this->InsMysql = new ClsMysql();
		$this->Transaccion = false;
    }
	
	public function __destruct(){

	}

	

    public function MtdObtenerReporteFichaIngresos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oModalidadIngreso=NULL,$oAgrupar=NULL,$oCSIIncluir=NULL,$oCliente=NULL,$oUnicos=false,$oVehiculoMarca=NULL,$oModalidadIngresoUnico=false,$oSucursal=NULL,$oFecha="FinTiempoTrabajoTerminado",$oComprobanteFechaInicio=NULL,$oComprobanteFechaFin=NULL,$oPersonal=NULL,$oVehiculoModelo=NULL) {

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
					$fecha = ' AND DATE(fin.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(fin.'.$oFecha.')<="'.$oFechaFin.'"';
				}else{
					$fecha = ' AND DATE(fin.'.$oFecha.')>="'.$oFechaInicio.'"';
				}
				
			}else{
				if(!empty($oFechaFin)){
					$fecha = ' AND DATE(fin.'.$oFecha.')<="'.$oFechaFin.'"';		
				}			
			}
		
		
		
	
			if(!empty($oComprobanteFechaInicio)){
				
				if(!empty($oComprobanteFechaFin)){
					
					$cfecha = ' AND (DATE(fac.FacFechaEmision)>="'.$oComprobanteFechaInicio.'" AND DATE(fac.FacFechaEmision)<="'.$oComprobanteFechaFin.'" 
					OR DATE(bol.BolFechaEmision)>="'.$oComprobanteFechaInicio.'" AND DATE(bol.BolFechaEmision)<="'.$oComprobanteFechaFin.'")';
					
				}else{
					
					$cfecha = ' AND (DATE(fac.FacFechaEmision)>="'.$oComprobanteFechaInicio.'" OR DATE(bol.BolFechaEmision)>="'.$oComprobanteFechaInicio.'")';
					
				}
				
			}else{
				if(!empty($oComprobanteFechaFin)){
					$cfecha = ' AND (DATE(fac.FacFechaEmision)<="'.$oComprobanteFechaInicio.'" OR DATE(bol.BolFechaEmision)<="'.$oComprobanteFechaInicio.'")';		
				}			
			}
		
			/*if(!empty($oModalidadIngreso)){
				$mingreso = ' AND fim.MinId = "'.$oModalidadIngreso.'"';		
			}*/
			
			if(!empty($oModalidadIngreso)){
				
				if($oModalidadIngresoUnico){
					
					$mingreso .= ' AND fim.MinId = "'.$oModalidadIngreso.'"';
					
				}else{
					
					
						
		//cli.LtiId = "'.($elemento).'"
		
		
		$elementos = explode(",",$oModalidadIngreso);
			
						$i=1;
						$mingreso .= ' AND (
						(';
						$elementos = array_filter($elementos);
						foreach($elementos as $elemento){
							$mingreso .= '  (
							
								 fim.MinId = "'.$elemento.'"
							
							)';
							if($i<>count($elementos)){						
								$mingreso .= ' OR ';	
							}
						$i++;		
						}
			
						$mingreso .= ' ) 
						)
						';
						
						/*$elementos = explode(",",$oModalidadIngreso);
			
						$i=1;
						$mingreso .= ' AND (
						(';
						$elementos = array_filter($elementos);
						foreach($elementos as $elemento){
							$mingreso .= '  (
							
								EXISTS (
									SELECT fim.FimId
										FROM tblfimfichaingresomodalidad fim
										WHERE fim.MinId = "'.$elemento.'"
										AND fim.FinId = fin.FinId
									LIMIT 1
								)
							
							)';
							if($i<>count($elementos)){						
								$mingreso .= ' OR ';	
							}
						$i++;		
						}
			
						$mingreso .= ' ) 
						)
						';*/
					
				}
				
				
					
					
			}
		
		
	
		
			if(!empty($oAgrupar)){
				$agrupar = ' GROUP BY '.$oAgrupar.'';		
			}
			
			if(!empty($oCSIIncluir)){
				$csiincluir = ' AND cli.CliCSIIncluir = '.$oCSIIncluir.'';		
			}
			
			if(!empty($oCliente)){
				$cliente = ' AND cli.CliId = "'.$oCliente.'"';		
			}	
	
	
			if(($oUnicos)){
				$unicos = 'DISTINCT (fin.FinId),';
			}	else{
				$unicos = ' (fin.FinId),';
			}
			
			if(!empty($oVehiculoMarca)){
				$vmarca = ' AND vmo.VmaId = "'.$oVehiculoMarca.'"';		
			}	
			
			
			if(!empty($oVehiculoModelo)){
				$vmodelo = ' AND vve.VmoId = "'.$oVehiculoModelo.'"';		
			}	
			
			
			if(!empty($oSucursal)){
				$sucursal = ' AND fin.SucId = "'.$oSucursal.'"';		
			}	
			
			
			if(!empty($oPersonal)){
				$personal = ' AND fin.PerId = "'.$oPersonal.'"';		
			}	

			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				'.$unicos.'
				
				fin.FinId,
				fin.CliId,
				DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",
				
				cli.CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				cli.CliTelefono,
				cli.CliCelular,
				
				cli.CliCelular,
				
				cli.CliEmail,
				
				cli.CliContactoEmail1,
				cli.CliContactoEmail2,
				cli.CliContactoEmail3,

				cli.CliEmailFacturacion,
				
				cli.CliDepartamento,
				cli.CliProvincia,
				cli.CliDireccion,
				
				cli.CliCSIIncluir,
				cli.CliCSIExcluirMotivo,
				DATE_FORMAT(cli.CliCSIExcluirFecha, "%d/%m/%Y") AS "NCliCSIExcluirFecha",
				
				min.MinNombre,
				vma.VmaNombre,
				vmo.VmoNombre,
				
				min.MinId,
				fin.FinMantenimientoKilometraje,
				fin.FinVehiculoKilometraje,
				
				per.PerNumeroDocumento,
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
				fac.FacSubTotal,
				DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y") AS "NFacFechaEmision",
				
				bta.BtaNumero,				
				bol.BolId,
				bol.BolTotal,
				bol.BolSubTotal,
				DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y") AS "NBolFechaEmision",
				
				
				(
				
					IFNULL(
						(
						(
						SELECT
						SUM(fde.FdeImporte)
						FROM tblfdefacturadetalle fde
						WHERE fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId
						AND (fde.FdeDescripcion LIKE "%MANO DE OBRA%" OR fde.FdeUnidadMedida LIKE "%ZZ%")
						LIMIT 1
						)/IF(fac.FacIncluyeImpuesto=1,((fac.FacPorcentajeImpuestoVenta)/100)+1,1)
						),
							IFNULL(
							
							(
							(
							SELECT
							SUM(bde.BdeImporte)
							FROM tblbdeboletadetalle bde
							WHERE bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId
							AND (bde.BdeDescripcion LIKE "%MANO DE OBRA%" OR bde.BdeUnidadMedida LIKE "%ZZ%")
							LIMIT 1
							)/IF(1=1,((bol.BolPorcentajeImpuestoVenta)/100)+1,1)
							)
							
							,0)
					)
					
				) AS RfiManoObra,
				
				
				
				
				(
				
					IFNULL(
						(
						(
						SELECT
						SUM(fde.FdeImporte)
						FROM tblfdefacturadetalle fde
						WHERE fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId
						AND fde.FdeDescripcion NOT LIKE "%MANO DE OBRA%"
						AND fde.FdeUnidadMedida = "UND"
						LIMIT 1
						)/IF(fac.FacIncluyeImpuesto=1,((fac.FacPorcentajeImpuestoVenta)/100)+1,1)
						)
						,
							IFNULL(
							(
							(
							SELECT
							SUM(bde.BdeImporte)
							FROM tblbdeboletadetalle bde
							WHERE bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId
							AND bde.BdeDescripcion NOT LIKE "%MANO DE OBRA%"
							AND bde.BdeUnidadMedida = "UND"
							LIMIT 1
							)/IF(1=1,((bol.BolPorcentajeImpuestoVenta)/100)+1,1)
							)
							
							,0)
					)
					
				) AS RfiRepuestos,
				
			 
				
				(
				
					IFNULL(
						(
						(
						SELECT
						SUM(fde.FdeImporte)
						FROM tblfdefacturadetalle fde
						WHERE fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId
						AND fde.FdeDescripcion NOT LIKE "%MANO DE OBRA%"
						AND fde.FdeUnidadMedida <> "UND"
						LIMIT 1
						)/IF(fac.FacIncluyeImpuesto=1,((fac.FacPorcentajeImpuestoVenta)/100)+1,1)
						),
							IFNULL(
							(
							(
							SELECT
							SUM(bde.BdeImporte)
							FROM tblbdeboletadetalle bde
							WHERE bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId
							-- AND (bde.BdeDescripcion NOT LIKE "%MANO DE OBRA%" AND bde.BdeUnidadMedida NOT LIKE "%ZZ%")
							AND bde.BdeUnidadMedida <> "UND"
							AND bde.BdeUnidadMedida <> "ZZ"
							AND bde.BdeUnidadMedida <> ""
							LIMIT 1
							)/IF(1=1,((bol.BolPorcentajeImpuestoVenta)/100)+1,1)
							)
							
							,0)
					)
					
				) AS RfiLubricantes,
				
			
				
				ein.EinVIN,
				ein.EinPlaca,
				
				
						per2.PerNombre AS PerNombreAsesor,
					per2.PerApellidoPaterno AS PerApellidoPaternoAsesor,
					per2.PerApellidoMaterno AS PerApellidoMaternoAsesor,
					
					fin.FinTelefono,
					fin.FinTallerObservacion,
					fin.FinSalidaObservacion,
					
					onc.OncCodigoDealer,
					onc.OncNombre,
					
					min.MinSigla,
					
					
					amo.AmoTotal,
					lti.LtiNombre,
					lti.LtiAbreviatura,
					fcc.FccFacturable,
					fcc.FccCausa,
					fcc.FccId,
					
					suc.SucNombre,
					suc.SucDepartamento,
					suc.SucDistrito,
					fin.FinVehiculoKilometraje,
					
					fin.FinIndicacionTecnico,
					
					cli.CliNumeroDocumento,
					
					fin.FinNota,
					
					ein.EinAnoModelo,
					
					suc.SucNombre
					
		
			
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
									
										LEFT JOIN tblvvevehiculoversion vve
										ON ein.VveId = vve.VveId
										
											LEFT JOIN tblvmovehiculomodelo vmo
											ON vve.VmoId = vmo.VmoId
											
												LEFT JOIN tblvmavehiculomarca vma
												ON vmo.VmaId = vma.VmaId
											
				
							LEFT JOIN tblclicliente cli
							ON	fin.CliId = cli.CliId
								LEFT JOIN tbllticlientetipo lti
								ON cli.LtiId = lti.LtiId
								
								LEFT JOIN tblperpersonal per
								ON fin.PerId = per.PerId
							
												LEFT JOIN tblperpersonal per2
												ON fin.PerIdAsesor = per2.PerId
												
												LEFT JOIN tbloncconcesionario onc
												ON ein.OncId = onc.OncId
												
												LEFT JOIN tblsucsucursal suc
												ON fin.SucId = suc.SucId
				WHERE fin.FinTipo = 1 '.$filtrar.$fecha.$mingreso.$sucursal .$personal.$csiincluir.$vmarca.$vmodelo.$personal.$cfecha .$cliente.$agrupar.$orden."  ".$paginacion;

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
					$ReporteFichaIngreso->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					
					$ReporteFichaIngreso->CliTelefono = $fila['CliTelefono'];
					$ReporteFichaIngreso->CliCelular = $fila['CliCelular'];
					$ReporteFichaIngreso->CliDireccion = $fila['CliDireccion'];
					
					$ReporteFichaIngreso->CliEmail = $fila['CliEmail'];
					
					$ReporteFichaIngreso->CliContactoEmail1 = $fila['CliContactoEmail1'];
					$ReporteFichaIngreso->CliContactoEmail2 = $fila['CliContactoEmail2'];
					$ReporteFichaIngreso->CliContactoEmail3 = $fila['CliContactoEmail3'];
					
					$ReporteFichaIngreso->CliEmailFacturacion = $fila['CliEmailFacturacion'];
					
					
					$ReporteFichaIngreso->CliDepartamento = $fila['CliDepartamento'];
					$ReporteFichaIngreso->CliProvincia = $fila['CliProvincia'];
					$ReporteFichaIngreso->CliCSIIncluir = $fila['CliCSIIncluir'];
					$ReporteFichaIngreso->CliCSIExcluirMotivo = $fila['CliCSIExcluirMotivo'];
					$ReporteFichaIngreso->CliCSIExcluirFecha = $fila['NCliCSIExcluirFecha'];
					
			
				
					$ReporteFichaIngreso->MinNombre = $fila['MinNombre'];
					$ReporteFichaIngreso->VmaNombre = $fila['VmaNombre'];
					$ReporteFichaIngreso->VmoNombre = $fila['VmoNombre'];
					
					
					$ReporteFichaIngreso->MinId = $fila['MinId'];
					$ReporteFichaIngreso->FinMantenimientoKilometraje = $fila['FinMantenimientoKilometraje'];
					$ReporteFichaIngreso->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje'];				
						
	$ReporteFichaIngreso->PerNumeroDocumento = $fila['PerNumeroDocumento'];
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
					$ReporteFichaIngreso->FacSubTotal = $fila['FacSubTotal'];
					
					
					
					$ReporteFichaIngreso->BolId = $fila['BolId'];
					$ReporteFichaIngreso->BtaNumero = $fila['BtaNumero'];
					$ReporteFichaIngreso->BolFechaEmision = $fila['NBolFechaEmision'];					
					$ReporteFichaIngreso->BolTotal = $fila['BolTotal'];
					$ReporteFichaIngreso->BolSubTotal = $fila['BolSubTotal'];
					
					$ReporteFichaIngreso->EinVIN = $fila['EinVIN'];
					$ReporteFichaIngreso->EinPlaca = $fila['EinPlaca'];

					$ReporteFichaIngreso->PerNombreAsesor = $fila['PerNombreAsesor'];
					$ReporteFichaIngreso->PerApellidoPaternoAsesor = $fila['PerApellidoPaternoAsesor'];
					$ReporteFichaIngreso->PerApellidoMaternoAsesor = $fila['PerApellidoMaternoAsesor'];
					
					$ReporteFichaIngreso->FinTelefono = $fila['FinTelefono'];
					$ReporteFichaIngreso->FinTallerObservacion = $fila['FinTallerObservacion'];
					$ReporteFichaIngreso->FinSalidaObservacion = $fila['FinSalidaObservacion'];

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
				
					$ReporteFichaIngreso->AmoTotal = $fila['AmoTotal'];
					$ReporteFichaIngreso->LtiNombre = $fila['LtiNombre'];
					$ReporteFichaIngreso->LtiAbreviatura = $fila['LtiAbreviatura'];
	$ReporteFichaIngreso->FccFacturable = $fila['FccFacturable'];
	
	$ReporteFichaIngreso->FccCausa = $fila['FccCausa'];
	$ReporteFichaIngreso->FccId = $fila['FccId'];
			
			$ReporteFichaIngreso->SucNombre = $fila['SucNombre'];
			$ReporteFichaIngreso->SucDepartamento = $fila['SucDepartamento'];
			
			$ReporteFichaIngreso->SucDistrito = $fila['SucDistrito'];
		
		$ReporteFichaIngreso->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje'] + 1 - 1;
			$ReporteFichaIngreso->FinIndicacionTecnico = $fila['FinIndicacionTecnico'];
			
			$ReporteFichaIngreso->CliNumeroDocumento = $fila['CliNumeroDocumento'];
			
			$ReporteFichaIngreso->RfiLubricantes = $fila['RfiLubricantes'];
			$ReporteFichaIngreso->RfiRepuestos = $fila['RfiRepuestos'];
			$ReporteFichaIngreso->RfiManoObra = $fila['RfiManoObra'];
			
			
			
			//$ReporteFichaIngreso->RfiOtros = $ReporteFichaIngreso->FacTotal - $ReporteFichaIngreso->BolTotal -   $ReporteFichaIngreso->RfiLubricantes  -   $ReporteFichaIngreso->RfiRepuestos  -   $ReporteFichaIngreso->RfiManoObra;
			$ReporteFichaIngreso->RfiOtros = 0;
			
			$ReporteFichaIngreso->FinNota = $fila['FinNota'];
			
			$ReporteFichaIngreso->RfiTotales = $ReporteFichaIngreso->RfiLubricantes  +   $ReporteFichaIngreso->RfiRepuestos +  $ReporteFichaIngreso->RfiManoObra;
			
			
			
			$ReporteFichaIngreso->EinAnoModelo = $fila['EinAnoModelo'];
			
			$ReporteFichaIngreso->SucNombre = $fila['SucNombre'];
			
			
			
			
                    $ReporteFichaIngreso->InsMysql = NULL;                    
	
					$Respuesta['Datos'][]= $ReporteFichaIngreso;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		

	
	
	public function MtdObtenerReporteFichaIngresoClientes($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oModalidadIngreso=NULL,$oAgrupar=NULL,$oSucursal=NULL,$oVehiculoMarca=NULL) {

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
			
			
			if(!empty($oSucursal)){
				$sucursal = ' AND fin.SucId = "'.$oSucursal.'"';		
			}
			
			if(!empty($oVehiculoMarca)){
				$vmarca = ' AND vmo.VmaId = "'.$oVehiculoMarca.'"';		
			}

			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				
				fin.FinId,
				fin.CliId,
				DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",
				
				cli.CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.CliDepartamento,
				cli.CliProvincia,
				
				cli.CliCSIIncluir,
				cli.CliCSIExcluirMotivo,
				DATE_FORMAT(cli.CliCSIExcluirFecha, "%d/%m/%Y") AS "NCliCSIExcluirFecha",
				cli.CliCSIExcluirUsuario,
				
				cli.CliTelefono,
				cli.CliCelular,
				cli.CliEmail,
				
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
					fin.FinObservacionCallcenter,
					
					onc.OncCodigoDealer,
					onc.OncNombre,
					
					min.MinSigla,
					
					lti.LtiAbreviatura,
					
					suc.SucNombre
		
		
			
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
												
												LEFT JOIN tblsucsucursal suc
												ON fin.SucId = suc.SucId
				WHERE 1 = 1 '.$filtrar.$sucursal.$fecha.$vmarca.$mingreso.$agrupar." GROUP BY fin.CliId ".$orden.$paginacion;

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
					$ReporteFichaIngreso->CliApellidoMaterno = $fila['CliApellidoMaterno'];

				
					$ReporteFichaIngreso->CliDepartamento = $fila['CliDepartamento'];
					$ReporteFichaIngreso->CliProvincia = $fila['CliProvincia'];
					$ReporteFichaIngreso->CliCSIIncluir = $fila['CliCSIIncluir'];
					$ReporteFichaIngreso->CliCSIExcluirMotivo = $fila['CliCSIExcluirMotivo'];
					$ReporteFichaIngreso->CliCSIExcluirFecha = $fila['NCliCSIExcluirFecha'];
					$ReporteFichaIngreso->CliCSIExcluirUsuario = $fila['CliCSIExcluirUsuario'];
					
					
					
					$ReporteFichaIngreso->CliTelefono = $fila['CliTelefono'];
					$ReporteFichaIngreso->CliCelular = $fila['CliCelular'];
					$ReporteFichaIngreso->CliEmail = $fila['CliEmail'];
					
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
  $ReporteFichaIngreso->FinObservacionCallcenter = $fila['FinObservacionCallcenter'];



					$ReporteFichaIngreso->OncCodigoDealer = $fila['OncCodigoDealer'];

					$ReporteFichaIngreso->OncNombre = $fila['OncNombre'];
					
					$ReporteFichaIngreso->MinSigla = $fila['MinSigla'];
					
					$ReporteFichaIngreso->LtiAbreviatura = $fila['LtiAbreviatura'];

$ReporteFichaIngreso->SucNombre = $fila['SucNombre'];





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





	
	public function MtdObtenerReporteFichaIngresoPendientes($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oModalidadIngreso=NULL,$oDiaTranscurrido=NULL,$oEstado=NULL,$oTipo=NULL,$oSucursal=NULL) {

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
			
		
			
			if(!empty($oDiaTranscurrido)){
				$dtranscurrido = ' AND  DATEDIFF(DATE(NOW()),fin.FinFecha) > '.$oDiaTranscurrido;		
			}
			
			
		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

			$i=1;
			$estado .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$estado .= '  (fin.FinEstado = '.($elemento).')';
				if($i<>count($elementos)){						
					$estado .= ' OR ';	
				}
			$i++;		
			}

			$estado .= ' ) 

			)
			';

		}
		if(!empty($oTipo)){
				$tipo = ' AND fin.FinTipo = '.$oTipo.'';		
			}
			
			if(!empty($oSucursal)){
				$sucursal = ' AND fin.SucId = "'.$oSucursal.'"';		
			}

			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				
				fin.FinId,
				fin.CliId,
				DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",
				
				cli.CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.CliDepartamento,
				cli.CliProvincia,
				cli.CliCSIIncluir,
				
				vma.VmaNombre,
				vmo.VmoNombre,
			
				fin.FinMantenimientoKilometraje,
				fin.FinVehiculoKilometraje,
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				DATEDIFF(DATE(NOW()),fin.FinFecha) AS FinDiaTranscurrido,
				
				DATE_FORMAT(fin.FinTiempoTallerRevisando, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTallerRevisando",
				DATE_FORMAT(fin.FinTiempoTrabajoTerminado, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTrabajoTerminado",
				DATE_FORMAT(fin.FinTiempoTallerConcluido, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTallerConcluido",
				
			
				ein.EinVIN,
				ein.EinPlaca,
				
					per2.PerNombre AS PerNombreAsesor,
					per2.PerApellidoPaterno AS PerApellidoPaternoAsesor,
					per2.PerApellidoMaterno AS PerApellidoMaternoAsesor,
					
					fin.FinTelefono,
					fin.FinNota,
					
					onc.OncCodigoDealer,
					onc.OncNombre,
					
					lti.LtiAbreviatura,
					
					suc.SucNombre
				
					
		
		
			
				FROM tblfinfichaingreso fin

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
												
												LEFT JOIN tblsucsucursal suc
												ON fin.SucId = suc.SucId
												
												
				WHERE 1 = 1 '.$filtrar.$fecha.$mingreso.$sucursal.$agrupar.$tipo.$estado.$dtranscurrido.$orden.$paginacion;

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
					$ReporteFichaIngreso->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					$ReporteFichaIngreso->FinDiaTranscurrido = $fila['FinDiaTranscurrido'];

				
					$ReporteFichaIngreso->CliDepartamento = $fila['CliDepartamento'];
					$ReporteFichaIngreso->CliProvincia = $fila['CliProvincia'];
					$ReporteFichaIngreso->CliCSIIncluir = $fila['CliCSIIncluir'];
					
				
					$ReporteFichaIngreso->VmaNombre = $fila['VmaNombre'];
					$ReporteFichaIngreso->VmoNombre = $fila['VmoNombre'];
					
					$ReporteFichaIngreso->FinMantenimientoKilometraje = $fila['FinMantenimientoKilometraje'];
					$ReporteFichaIngreso->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje'];				
						
	
					$ReporteFichaIngreso->PerNombre = $fila['PerNombre'];
					$ReporteFichaIngreso->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$ReporteFichaIngreso->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					$ReporteFichaIngreso->FinDiaTranscurrido = $fila['FinDiaTranscurrido'];
					
					$ReporteFichaIngreso->FinTiempoTallerRevisando = $fila['NFinTiempoTallerRevisando'];
					$ReporteFichaIngreso->FinTiempoTrabajoTerminado = $fila['NFinTiempoTrabajoTerminado'];
					$ReporteFichaIngreso->FinTiempoTallerConcluido = $fila['NFinTiempoTallerConcluido'];
					
					$ReporteFichaIngreso->FinTiempoTranscurrido = $fila['FinTiempoTranscurrido'];
					$ReporteFichaIngreso->FinTiempoTranscurrido2 = $fila['FinTiempoTranscurrido2'];
					
				
					
					$ReporteFichaIngreso->EinVIN = $fila['EinVIN'];
					$ReporteFichaIngreso->EinPlaca = $fila['EinPlaca'];

					$ReporteFichaIngreso->PerNombreAsesor = $fila['PerNombreAsesor'];
					$ReporteFichaIngreso->PerApellidoPaternoAsesor = $fila['PerApellidoPaternoAsesor'];
					$ReporteFichaIngreso->PerApellidoMaternoAsesor = $fila['PerApellidoMaternoAsesor'];
					
					$ReporteFichaIngreso->FinTelefono = $fila['FinTelefono'];
					$ReporteFichaIngreso->FinNota = $fila['FinNota'];

					$ReporteFichaIngreso->OncCodigoDealer = $fila['OncCodigoDealer'];
					$ReporteFichaIngreso->OncNombre = $fila['OncNombre'];
					
					$ReporteFichaIngreso->LtiAbreviatura = $fila['LtiAbreviatura'];

					$ReporteFichaIngreso->SucNombre = $fila['SucNombre'];


                    $ReporteFichaIngreso->InsMysql = NULL;                    
	
					$Respuesta['Datos'][]= $ReporteFichaIngreso;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
		 public function MtdObtenerReporteFichaIngresoSeguimientoLlamadas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oFichaIngreso=NULL,$oDiasTranscurridos=0,$oSucursal=NULL,$oModalidadIngreso=NULL,$oConLlamada=false,$oVehiculoMarca=NULL,$oIncluirCSI=NULL,$oDiasTranscurridosTipo="Mayor",$oFecha="FinFecha") {

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
				$fecha = ' AND DATE('.$oFecha.')>="'.$oFechaInicio.'" AND DATE('.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE('.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE('.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}
		
			
			if(!empty($oCliente)){
				$cliente = ' AND cli.CliId = "'.$oCliente.'"';		
			}
			
			if(!empty($oFichaIngreso)){
				$fingreso = ' AND fin.FinId = "'.$oFichaIngreso.'"';		
			}	
			
			
			
			if(!empty($oDiasTranscurridos)){
				
				switch($oDiasTranscurridosTipo){
					
					case "Mayor":
						$dtranscurrido = ' AND DATEDIFF(DATE("'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).'"),'.$oFecha.') > '.$oDiasTranscurridos.' ';		
					break;
					
					case "Menor":
						$dtranscurrido = ' AND DATEDIFF(DATE("'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).'"),'.$oFecha.') < '.$oDiasTranscurridos.' ';	
					break;
					
					case "MayorIgual":
						$dtranscurrido = ' AND DATEDIFF(DATE("'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).'"),'.$oFecha.') >= '.$oDiasTranscurridos.' ';	
					break;
					
					case "MenorIgual":
						$dtranscurrido = ' AND DATEDIFF(DATE("'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).'"),'.$oFecha.') <= '.$oDiasTranscurridos.' ';	
					break;
					
					case "Igual":
						$dtranscurrido = ' AND DATEDIFF(DATE("'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).'"),'.$oFecha.') = '.$oDiasTranscurridos.' ';	
					break;
					
					default:
					$dtranscurrido = ' AND DATEDIFF(DATE("'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).'"),'.$oFecha.') > '.$oDiasTranscurridos.' ';		
					
					break;
					
				}
				
				
				
				
			}	
			
			if(!empty($oSucursal)){
				$sucursal = ' AND fin.SucId = "'.$oSucursal.'"';		
			}
			
			if(!empty($oModalidadIngreso)){
		//cli.LtiId = "'.($elemento).'"
				$elementos = explode(",",$oModalidadIngreso);
	
				$i=1;
				$mingreso .= ' AND (
				(';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
					$mingreso .= '  (
					
						EXISTS (
							SELECT fim.FimId
								FROM tblfimfichaingresomodalidad fim
								WHERE fim.MinId = "'.$elemento.'"
								AND fim.FinId = fin.FinId
							LIMIT 1
						)
					
					)';
					if($i<>count($elementos)){						
						$mingreso .= ' OR ';	
					}
				$i++;		
				}
	
				$mingreso .= ' ) 
				)
				';
		
			}
		
			if($oConLlamada){
				
				$cllamada = ' 	AND NOT EXISTS(
						SELECT 
						fll.FllId
						FROM tblfllfichaingresollamada fll
						WHERE fll.FinId = fin.FinId
						AND fll.FllEstado = 3
					)
				';		
				
			}
			
			
			if($oVehiculoMarca){
				
				$vmarca = ' 	
					AND vmo.VmaId = "'.$oVehiculoMarca.'"
				';		
				
			}
			
			
				
			if($oIncluirCSI){
				
				$icsi = ' 	
					AND cli.CliCSIIncluir = "'.$oIncluirCSI.'"
				';		
				
			}
			
			
			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				fin.SucId,
				
				fin.FinId,
				fin.CliId,
				DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",
				
				cli.CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.CliDepartamento,
				cli.CliProvincia,
				cli.CliCSIIncluir,
				
				cli.CliTelefono,
				cli.CliCelular,
				cli.CliEmail,
			
				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre,
			
				fin.FinMantenimientoKilometraje,
				fin.FinVehiculoKilometraje,
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				DATEDIFF(DATE(NOW()),fin.FinFecha) AS FinDiaTranscurrido,
				DATEDIFF(DATE("'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).'"),fin.FinTiempoTrabajoTerminado) AS FinDiaTranscurridoTerminado,
				
				DATE_FORMAT(fin.FinTiempoTallerRevisando, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTallerRevisando",
				DATE_FORMAT(fin.FinTiempoTrabajoTerminado, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTrabajoTerminado",
				
				DATE_FORMAT(fin.FinTiempoTallerConcluido, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTallerConcluido",
				
				(TIMESTAMPDIFF(SECOND, FinTiempoTallerRevisando, FinTiempoTrabajoTerminado) /3600) AS FinTiempoTranscurrido,
				(TIMESTAMPDIFF(SECOND, FinTiempoTallerRevisando, FinTiempoTallerConcluido) /3600) AS FinTiempoTranscurrido2,
								
				ein.EinVIN,
				ein.EinPlaca,
				
				ein.EinColor,
				
				
					per2.PerNombre AS PerNombreAsesor,
					per2.PerApellidoPaterno AS PerApellidoPaternoAsesor,
					per2.PerApellidoMaterno AS PerApellidoMaternoAsesor,
					
					suc.SucNombre,
					
					DATE_FORMAT(cli.CliCSIExcluirFecha, "%d/%m/%Y") AS "NCliCSIExcluirFecha",	
					cli.CliCSIExcluirUsuario,
					cli.CliCSIExcluirMotivo
					
					
					
		
							FROM tblfinfichaingreso fin
							LEFT JOIN tblclicliente cli
							ON fin.CliId = cli.CliId
							LEFT JOIN tbleinvehiculoingreso ein
							ON fin.EinId = ein.EinId
							LEFT JOIN tblvvevehiculoversion vve
							ON ein.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
								LEFT JOIN tblperpersonal per2
								ON fin.PerIdAsesor = per2.PerId
									LEFT JOIN tblperpersonal per
									ON fin.PerId = per.PerId
										LEFT JOIN tblsucsucursal suc
										ON fin.SucId = suc.SucId
												
				WHERE 
				 1 = 1
				 
				

				 '.$filtrar.$fecha.$fingreso.$sucursal.$cllamada.$icsi.$vmarca.$csiincluir.$mingreso.$sucursal.$cliente.$dtranscurrido.$agrupar.$orden."  ".$paginacion;
				 
				  /* AND
				
				EXISTS(
				
					SELECT 
					fim.FimId 
					FROM tblfimfichaingresomodalidad fim
					WHERE fim.FinId = fin.FinId 
					AND (fim.MinId = "MIN-10003" OR fim.MinId = "MIN-10019" OR fim.MinId = "MIN-10020" OR fim.MinId = "MIN-10021")
				
				
				)*/
				
				/*
				AND NOT EXISTS(
					SELECT 
					fll.FllId
					FROM tblfllfichaingresollamada fll
					WHERE fll.FinId = fin.FinId
					AND fll.FllEstado = 3
				)
				*/

			$resultado = $this->InsMysql->MtdConsultar($sql);            

//IF(IFNULL(fac.AmoId
//				,IFNULL(bol.AmoId,"F")) AS FinComprobanteVentaTipo,
				
			$Respuesta['Datos'] = array();

            $InsReporteFichaIngreso = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReporteFichaIngreso = new $InsReporteFichaIngreso();
					
					 $ReporteFichaIngreso->SucId = $fila['SucId'];
					 
                    $ReporteFichaIngreso->FinId = $fila['FinId'];
					$ReporteFichaIngreso->CliId = $fila['CliId'];
					
					$ReporteFichaIngreso->FinFecha = $fila['NFinFecha'];
					
					
					
					
					$ReporteFichaIngreso->CliNombreCompleto = $fila['CliNombreCompleto'];
					
					$ReporteFichaIngreso->CliNombre = $fila['CliNombre'];
					$ReporteFichaIngreso->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$ReporteFichaIngreso->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					
					$ReporteFichaIngreso->FinDiaTranscurrido = $fila['FinDiaTranscurrido'];
					$ReporteFichaIngreso->FinDiaTranscurridoTerminado = $fila['FinDiaTranscurridoTerminado'];


					$ReporteFichaIngreso->CliDepartamento = $fila['CliDepartamento'];
					$ReporteFichaIngreso->CliProvincia = $fila['CliProvincia'];
					$ReporteFichaIngreso->CliCSIIncluir = $fila['CliCSIIncluir'];
					
					$ReporteFichaIngreso->CliTelefono = $fila['CliTelefono'];
					$ReporteFichaIngreso->CliCelular = $fila['CliCelular'];
					$ReporteFichaIngreso->CliEmail = $fila['CliEmail'];
				
					$ReporteFichaIngreso->CliWhatsapp = "51".$fila['CliCelular'];
				
					$ReporteFichaIngreso->VmaNombre = $fila['VmaNombre'];
					$ReporteFichaIngreso->VmoNombre = $fila['VmoNombre'];
					$ReporteFichaIngreso->VveNombre = $fila['VveNombre'];
					
					
					
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
					
					
					$ReporteFichaIngreso->EinVIN = $fila['EinVIN'];
					$ReporteFichaIngreso->EinPlaca = $fila['EinPlaca'];
					$ReporteFichaIngreso->EinColor = $fila['EinColor'];




					$ReporteFichaIngreso->PerNombreAsesor = $fila['PerNombreAsesor'];
					$ReporteFichaIngreso->PerApellidoPaternoAsesor = $fila['PerApellidoPaternoAsesor'];
					$ReporteFichaIngreso->PerApellidoMaternoAsesor = $fila['PerApellidoMaternoAsesor'];
					
					$ReporteFichaIngreso->SucNombre = $fila['SucNombre'];
										
							$ReporteFichaIngreso->CliCSIExcluirFecha = $fila['NCliCSIExcluirFecha'];
					$ReporteFichaIngreso->CliCSIExcluirUsuario = $fila['CliCSIExcluirUsuario'];
					$ReporteFichaIngreso->CliCSIExcluirMotivo = $fila['CliCSIExcluirMotivo'];
									
							
							
										
										
										
                    $ReporteFichaIngreso->InsMysql = NULL;                    
	
					$Respuesta['Datos'][]= $ReporteFichaIngreso;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		

		
		
		
		
		public function MtdObtenerReporteFichaIngresoPromedioTiempoTallerConcluido($oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oFichaIngresoModalidadIngreso=NULL,$oSucursal=NULL,$oDia=NULL) {

		if(!empty($oAno)){
			$ano = ' AND YEAR(fin.FinFecha) = "'.$oAno.'" ';
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(fin.FinFecha) = "'.$oMes.'" ';
		}
		
			
		if(!empty($oDia)){
			$dia = ' AND DAY(fin.FinFecha) = "'.$oDia.'" ';
		}
		
	
		if(!empty($oVehiculoMarca)){
			
			$vmarca = ' AND vmo.VmaId = "'.$oVehiculoMarca.'" ';
			
		}
		
		
		if(!empty($oSucursal)){
			
			$sucursal = ' AND fin.SucId = "'.$oSucursal.'" ';
			
		}
		
		if(!empty($oFichaIngresoModalidadIngreso)){
			
			$mingreso = ' AND 
			EXISTS(
			SELECT * FROM tblfimfichaingresomodalidad fim
			WHERE fim.FinId = fin.FinId
			AND fim.MinId = "'.$oFichaIngresoModalidadIngreso.'"
			)
			 ';
			
		}
		
		$sql = 'SELECT
		AVG(
		(	

	(
		(
			IF(

				(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTallerConcluido)/86400)>1,

				TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTallerConcluido) - (50400) * ((TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTallerConcluido)/86400)),

					IF(
						(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTallerConcluido))>25200,
						(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTallerConcluido)) - 7200,
						(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTallerConcluido))

					)

				) 
			)/60

		)/60

	)
		) AS "RESULTADO"
		
		FROM tblfinfichaingreso fin
			LEFT JOIN tbleinvehiculoingreso ein
			ON fin.EinId = ein.EinId
				LEFT JOIN tblvvevehiculoversion vve
				ON ein.VveId = vve.VveId
					LEFT JOIN tblvmovehiculomodelo vmo
					ON vve.VmoId = vmo.VmoId
						LEFT JOIN tblvmavehiculomarca vma
						ON vmo.VmaId = vma.VmaId
		
		WHERE  fin.FinTiempoCreacion IS NOT NULL
		AND fin.FinTiempoTallerConcluido IS NOT NULL '.$vmarca.$sucursal.$dia.$ptipo.$ano.$mes.$mingreso.$vmarca.$orden.$paginacion;
								
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			//settype($fila['RESULTADO'],"float");
			
			//return $fila['RESULTADO'];		
			
			//$hoursminsandsecs = date('H:i:s',$fila['RESULTADO']);
			
			//return $hoursminsandsecs;		
			return $fila['RESULTADO'];		
			
		}
		
	public function MtdObtenerReporteFichaIngresoPromedioTiempoTrabajoTerminado($oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oFichaIngresoModalidadIngreso=NULL) {

		if(!empty($oAno)){
			$ano = ' AND YEAR(fin.FinFecha) = ('.$oAno.') ';
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(fin.FinFecha) = '.$oMes.' ';
		}
		
	
		if(!empty($oVehiculoMarca)){
			
			$vmarca = ' AND vmo.VmaId = "'.$oVehiculoMarca.'" ';
			
		}
		
		if(!empty($oVehiculoMarca)){
			
			$mingreso = ' AND 
			EXISTS(
			SELECT * FROM tblfimfichaingresomodalidad fim
			WHERE fim.FinId = fin.FinId
			AND fim.MinId = "'.$oFichaIngresoModalidadIngreso.'"
			)
			 ';
			
		}
		
		$sql = 'SELECT
				AVG(
		(	

	(
		(
			IF(

				(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado)/86400)>1,

				TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado) - (50400) * ((TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado)/86400)),

					IF(
						(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado))>25200,
						(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado)) - 7200,
						(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado))

					)

				) 
			)/60

		)/60

	)
		) AS "RESULTADO"
		
		FROM tblfinfichaingreso fin
			LEFT JOIN tbleinvehiculoingreso ein
			ON fin.EinId = ein.EinId
				LEFT JOIN tblvvevehiculoversion vve
				ON ein.VveId = vve.VveId
					LEFT JOIN tblvmovehiculomodelo vmo
					ON vve.VmoId = vmo.VmoId
						LEFT JOIN tblvmavehiculomarca vma
						ON vmo.VmaId = vma.VmaId
		
		WHERE  fin.FinTiempoCreacion IS NOT NULL
		AND fin.FinTiempoTrabajoTerminado IS NOT NULL '.$vmarca.$ptipo.$ano.$mes.$mingreso.$vmarca.$orden.$paginacion;
								
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			//settype($fila['RESULTADO'],"float");
			
			//return $fila['RESULTADO'];		
			
		//	$hoursminsandsecs = date('H:i:s',$fila['RESULTADO']);
			
			//return $hoursminsandsecs;		
			return $fila['RESULTADO'];		
			
			
		}
		
		
		
		
		
		
		public function MtdObtenerReporteFichaIngresoPromedioTiempoTrabajoTerminadoBruto($oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oFichaIngresoModalidadIngreso=NULL,$oSucursal=NULL,$oDia=NULL) {

		if(!empty($oAno)){
			$ano = ' AND YEAR(fin.FinFecha) = ('.$oAno.') ';
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(fin.FinFecha) = '.$oMes.' ';
		}
		
			
		if(!empty($oDia)){
			$dia = ' AND DAY(fin.FinFecha) = '.$oDia.' ';
		}
		
	
		if(!empty($oSucursal)){
			
			$sucursal = ' AND fin.SucId = "'.$oSucursal.'" ';
			
		}
		
		if(!empty($oFichaIngresoModalidadIngreso)){
			
			$mingreso = ' AND 
			EXISTS(
			SELECT * FROM tblfimfichaingresomodalidad fim
			WHERE fim.FinId = fin.FinId
			AND fim.MinId = "'.$oFichaIngresoModalidadIngreso.'"
			)
			 ';
			
		}
		
		if(!empty($oVehiculoMarca)){
			
			$vmarca = ' AND vmo.VmaId = "'.$oVehiculoMarca.'" ';
			
		}
		
		
		$sql = 'SELECT
		
		AVG(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado))
		
		 AS "RESULTADO"
		
		FROM tblfinfichaingreso fin
			LEFT JOIN tbleinvehiculoingreso ein
			ON fin.EinId = ein.EinId
				LEFT JOIN tblvvevehiculoversion vve
				ON ein.VveId = vve.VveId
					LEFT JOIN tblvmovehiculomodelo vmo
					ON vve.VmoId = vmo.VmoId
						LEFT JOIN tblvmavehiculomarca vma
						ON vmo.VmaId = vma.VmaId
		
		WHERE  fin.FinTiempoCreacion IS NOT NULL
		AND fin.FinTiempoTrabajoTerminado IS NOT NULL '.$vmarca.$sucursal.$dia .$ptipo.$ano.$mes.$mingreso.$vmarca.$orden.$paginacion;
								
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			//settype($fila['RESULTADO'],"float");
			
			//return $fila['RESULTADO'];		
			
		//	$hoursminsandsecs = date('H:i:s',$fila['RESULTADO']);
			
			//return $hoursminsandsecs;		
			return $fila['RESULTADO'];		
			
			
		}
		
		
		
		
		
		
		
		
		
	public function MtdObtenerReporteFichaIngresoSumaTiempoTrabajoTerminado($oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oFichaIngresoModalidadIngreso=NULL) {

		if(!empty($oAno)){
			$ano = ' AND YEAR(fin.FinFecha) = ('.$oAno.') ';
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(fin.FinFecha) = '.$oMes.' ';
		}
		
	
		if(!empty($oVehiculoMarca)){
			
			$vmarca = ' AND vmo.VmaId = "'.$oVehiculoMarca.'" ';
			
		}
		
		if(!empty($oVehiculoMarca)){

			$mingreso = ' AND 
				EXISTS(
				SELECT * FROM tblfimfichaingresomodalidad fim
				WHERE fim.FinId = fin.FinId
				AND fim.MinId = "'.$oFichaIngresoModalidadIngreso.'"
			)
			 ';

		}
		
		$sql = 'SELECT
			SUM(	

					(
						(
								IF(
					
									(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado)/86400)>1,
					
									TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado) - (50400) * ((TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado)/86400)),
					
										IF(
											(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado))>25200,
											(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado)) - 7200,
											(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado)
										)
					
								)
					
						) 
					)/60
					
				)/60

		) AS "RESULTADO"
		
		
		
		FROM tblfinfichaingreso fin
			LEFT JOIN tbleinvehiculoingreso ein
			ON fin.EinId = ein.EinId
				LEFT JOIN tblvvevehiculoversion vve
				ON ein.VveId = vve.VveId
					LEFT JOIN tblvmovehiculomodelo vmo
					ON vve.VmoId = vmo.VmoId
						LEFT JOIN tblvmavehiculomarca vma
						ON vmo.VmaId = vma.VmaId
		
		WHERE   fin.FinTiempoCreacion IS NOT NULL
		AND fin.FinTiempoTrabajoTerminado IS NOT NULL '.$vmarca.$ptipo.$ano.$mes.$mingreso.$vmarca.$orden.$paginacion;
								
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			///settype($fila['RESULTADO'],"float");
			$hoursminsandsecs = date('H:i:s',$fila['RESULTADO']);
			
			return $hoursminsandsecs;		
			
		}
		
		
		
		
		
	//OK
	public function MtdObtenerReporteFichaIngresoSumaTiempoConcluido($oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oFichaIngresoModalidadIngreso=NULL,$oSucursal=NULL,$oDia=NULL) {

		if(!empty($oAno)){
			$ano = ' AND YEAR(fin.FinFecha) = ('.$oAno.') ';
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(fin.FinFecha) = '.$oMes.' ';
		}
		
			
		if(!empty($oDia)){
			$dia = ' AND DAY(fin.FinFecha) = '.$oDia.' ';
		}
		
	
		if(!empty($oVehiculoMarca)){
			
			$vmarca = ' AND vmo.VmaId = "'.$oVehiculoMarca.'" ';
			
		}
		
		if(!empty($oSucursal)){
			
			$sucursal = ' AND fin.SucId = "'.$oSucursal.'" ';
			
		}
		
		
		if(!empty($oFichaIngresoModalidadIngreso)){

			$mingreso = ' AND 
				EXISTS(
				SELECT * FROM tblfimfichaingresomodalidad fim
				WHERE fim.FinId = fin.FinId
				AND fim.MinId = "'.$oFichaIngresoModalidadIngreso.'"
			)
			 ';

		}
		
		$sql = 'SELECT
		
		SUM(	

					(
						(
								IF(
					
									(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTallerConcluido)/86400)>1,
					
									TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTallerConcluido) - (50400) * ((TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTallerConcluido)/86400)),
					
										IF(
											(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTallerConcluido))>25200,
											(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTallerConcluido)) - 7200,
											(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTallerConcluido)
										)
					
								)
					
						) 
					)/60
					
				)/60

		) AS "RESULTADO"
		
		FROM tblfinfichaingreso fin
			LEFT JOIN tbleinvehiculoingreso ein
			ON fin.EinId = ein.EinId
				LEFT JOIN tblvvevehiculoversion vve
				ON ein.VveId = vve.VveId
					LEFT JOIN tblvmovehiculomodelo vmo
					ON vve.VmoId = vmo.VmoId
						LEFT JOIN tblvmavehiculomarca vma
						ON vmo.VmaId = vma.VmaId
		
		WHERE   fin.FinTiempoCreacion IS NOT NULL
		AND fin.FinTiempoTallerConcluido IS NOT NULL '.$vmarca.$sucursal.$dia.$sucursal.$ptipo.$ano.$mes.$mingreso.$vmarca.$orden.$paginacion;
								
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			///settype($fila['RESULTADO'],"float");
		//	$hoursminsandsecs = date('H:i:s',$fila['RESULTADO']);
			
			//return $hoursminsandsecs;	
			return $fila['RESULTADO'];	
			
		}
		
	
	
	
	

    public function MtdObtenerFichaIngresoGastos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FigId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oMoneda=NULL,$oFecha="GasFecha",$oSucursal=NULL) {

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
				
				

				$filtrar .= '   ';
					
									
				$filtrar .= '  ) ';

			

				
					
					
		}

		

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oFichaIngreso)){
			$fingreso = ' AND fig.FinId = "'.$oFichaIngreso.'"';
		}
	
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(gas.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(gas.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(gas.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(gas.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}
		
		if(!empty($oEstado)){
			$estado = ' AND gas.GasEstado = '.$oEstado;
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND gas.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND gas.SucId = "'.$oSucursal.'"';
		}
		
		$sql = '
		
		
			SELECT
			SQL_CALC_FOUND_ROWS 
			fig.FigId,			
			fig.FinId,
			fig.GasId,
			
			fig.FigEstado,
			DATE_FORMAT(fig.FigTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFigTiempoCreacion",
	        DATE_FORMAT(fig.FigTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFigTiempoModificacion",
			
			gas.GasComprobanteNumero,
			DATE_FORMAT(gas.GasComprobanteFecha, "%d/%m/%Y") AS "NGasComprobanteFecha",
			gas.GasTotal,
			gas.GasTipoCambio,
			
			gas.GasConcepto,
			gas.MonId,
			
			mon.MonSimbolo,
			mon.MonNombre,
			
			prv.PrvNombre,
			prv.PrvApellidoPaterno,
			prv.PrvApellidoMaterno,
			
			DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",
			
			suc.SucNombre,
			
			ein.EinPlaca,
			ein.EinVIN,
			ein.EinColor,
			
			vma.VmaNombre,
			vmo.VmoNombre,
			vve.VveNombre,
			
			
			per2.PerNombre AS PerNombreAsesor,
			per2.PerApellidoPaterno AS PerApellidoPaternoAsesor,
			per2.PerApellidoMaterno AS PerApellidoMaternoAsesor
			
			
			
			FROM tblfigfichaingresogasto fig
				
				LEFT JOIN tblgasgasto gas
				ON fig.GasId = gas.GasId
					LEFT JOIN tblprvproveedor prv
					ON gas.PrvId = prv.PrvId
						LEFT JOIN tblmonmoneda mon
						ON gas.MonId = mon.MonId
							LEFT JOIN tblfinfichaingreso fin
							ON fig.FinId = fin.FinId
								LEFT JOIN tblsucsucursal suc
								ON fin.SucId = suc.SucId
									LEFT JOIN tbleinvehiculoingreso ein
									ON fin.EinId = ein.EinId
										LEFT JOIN tblvvevehiculoversion vve
										ON ein.VveId = vve.VveId
											LEFT JOIN tblvmovehiculomodelo vmo
											ON vve.VmoId = vmo.VmoId
												LEFT JOIN tblvmavehiculomarca vma
												ON vmo.VmaId = vma.VmaId
													LEFT JOIN tblperpersonal per2
													ON fin.PerIdAsesor = per2.PerId
													
			WHERE  1 = 1 '.$fingreso.$estado.$filtrar.$sucursal.$moneda.$sucursal.$$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFichaIngresoGasto = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$FichaIngresoGasto = new $InsFichaIngresoGasto();
                    $FichaIngresoGasto->FigId = $fila['FigId'];
                    $FichaIngresoGasto->FinId = $fila['FinId'];					
					$FichaIngresoGasto->GasId = $fila['GasId'];
					
					$FichaIngresoGasto->FigEstado = $fila['FigEstado'];
					$FichaIngresoGasto->FigTiempoCreacion = $fila['NFigTiempoCreacion'];  
					$FichaIngresoGasto->FigTiempoModificacion = $fila['NFigTiempoModificacion']; 
					
					$FichaIngresoGasto->GasComprobanteNumero = $fila['GasComprobanteNumero']; 
					$FichaIngresoGasto->GasComprobanteFecha = $fila['NGasComprobanteFecha']; 
					$FichaIngresoGasto->GasTotal = $fila['GasTotal'];
					$FichaIngresoGasto->GasTipoCambio = $fila['GasTipoCambio'];
					
					
					$FichaIngresoGasto->GasConcepto = $fila['GasConcepto'];
					$FichaIngresoGasto->MonId = $fila['MonId'];
					
					$FichaIngresoGasto->MonSimbolo = $fila['MonSimbolo'];
					$FichaIngresoGasto->MonNombre = $fila['MonNombre'];
					
					$FichaIngresoGasto->PrvNombre = $fila['PrvNombre']; 
					$FichaIngresoGasto->PrvApellidoPaterno = $fila['PrvApellidoPaterno']; 		
					$FichaIngresoGasto->PrvApellidoMaterno = $fila['PrvApellidoMaterno']; 
					
					$FichaIngresoGasto->FinFecha = $fila['NFinFecha']; 	
						
					$FichaIngresoGasto->SucNombre = $fila['SucNombre'];
					
					
					$FichaIngresoGasto->EinPlaca = $fila['EinPlaca']; 
					$FichaIngresoGasto->EinVIN = $fila['EinVIN']; 
					$FichaIngresoGasto->EinColor = $fila['EinColor']; 
					
					$FichaIngresoGasto->VmaNombre = $fila['VmaNombre']; 
					$FichaIngresoGasto->VmoNombre = $fila['VmoNombre']; 
					$FichaIngresoGasto->VveNombre = $fila['VveNombre']; 
					
					
					$FichaIngresoGasto->PerNombreAsesor = $fila['PerNombreAsesor']; 
					$FichaIngresoGasto->PerApellidoPaternoAsesor = $fila['PerApellidoPaternoAsesor']; 
					$FichaIngresoGasto->PerApellidoMaternoAsesor = $fila['PerApellidoMaternoAsesor'];  
					
					
				
                    $FichaIngresoGasto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $FichaIngresoGasto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
				
}
?>