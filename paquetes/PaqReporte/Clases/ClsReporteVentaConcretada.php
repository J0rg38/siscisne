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

class ClsReporteVentaConcretada {

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

  
    public function MtdObtenerReporteVentaConcretadas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConFactura=0,$oConBoleta=0,$oConGuiaRemision=0,$oVentaDirectaId=NULL,$oMoneda=NULL,$oIgnorarTotalVacio=false,$oGenerarFactura=false,$oFacturable=NULL) {

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
				
				
					$filtrar .= '  OR EXISTS( 
					
					SELECT 
					amd.AmdId
					FROM tblamdalmacenmovimientodetalle amd
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId
						
					WHERE 
						amd.AmoId = amo.AmoId AND 
						(
						pro.ProNombre LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoOriginal  LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoAlternativo  LIKE "%'.$oFiltro.'%" 
						)
						
						
						
					) ';
				
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
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';		
			}			
		}


		if(!empty($oEstado)){
			$estado = ' AND amo.AmoEstado = '.$oEstado;
		}
		


		if(($oConFactura==1)){
			$confactura = ' AND  EXISTS ( 
				SELECT fac.FacId FROM tblfacfactura fac WHERE fac.AmoId = amo.AmoId AND fac.FacEstado <> 6 LIMIT 1
			 )';
		}elseif($oConFactura==2){
			$confactura = ' AND  NOT EXISTS ( 
				SELECT fac.FacId FROM tblfacfactura fac WHERE fac.AmoId = amo.AmoId AND fac.FacEstado <> 6 LIMIT 1
			 )';
		}

		if(($oConBoleta==1)){
			$conboleta = ' AND  EXISTS ( 
				SELECT bol.BolId FROM tblbolboleta bol WHERE bol.AmoId = amo.AmoId AND bol.BolEstado <> 6 LIMIT 1
			 )';
		}elseif($oConBoleta==2){
			$conboleta = ' AND  NOT EXISTS ( 
				SELECT bol.BolId FROM tblbolboleta bol WHERE bol.AmoId = amo.AmoId AND bol.BolEstado <> 6 LIMIT 1
			 )';
		}
		
		if(($oConGuiaRemision==1)){
			$conguiaremision = ' AND  EXISTS ( 
				SELECT gam.GamId FROM tblgamguiaremisionalmacenmovimiento gam 
					LEFT JOIN tblgreguiaremision gre
					ON gam.GreId = gre.GreId
				WHERE gam.AmoId = amo.AmoId 
				AND gre.GreEstado <> 6
				LIMIT 1
			 )';
		}elseif($oConGuiaRemision==2){
			$conguiaremision = ' AND  NOT EXISTS ( 
				SELECT gam.GamId FROM tblgamguiaremisionalmacenmovimiento gam 
					LEFT JOIN tblgreguiaremision gre
					ON gam.GreId = gre.GreId
				WHERE gam.AmoId = amo.AmoId 
				AND gre.GreEstado <> 6
				LIMIT 1
			 )';
		}
		
		

		if(!empty($oVentaDirectaId)){
			$vdirecta = ' AND amo.VdiId = "'.$oVentaDirectaId.'"';
		}

		if(!empty($oMoneda)){
			$moneda = ' AND amo.MonId = "'.$oMoneda.'"';
		}
				
		if(($oIgnorarTotalVacio)){
			$itvacio = ' AND amo.AmoTotal <> 0 ';
		}

		if($oGenerarFactura){
			
			$gfactura = '
			
			AND IF (

		( 
			
			
			IFNULL(( 
			SELECT 
				SUM((amd.AmdCantidad)) 
			FROM tblamdalmacenmovimientodetalle amd 
			WHERE amd.AmoId = amo.AmoId LIMIT 1 
			),0)

			- IFNULL((
					SELECT 
					SUM(bde.BdeCantidad) 
					FROM tblbdeboletadetalle bde
						LEFT JOIN tblbolboleta bol
						ON bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId
							LEFT JOIN tblamdalmacenmovimientodetalle amd 
							ON bde.AmdId = amd.AmdId

					WHERE amd.AmoId = amo.AmoId 
					AND bol.BolEstado <> 6
					LIMIT 1 
				),0)
		
				- IFNULL((
				SELECT 
				SUM(fde.FdeCantidad) 
				FROM tblfdefacturadetalle fde
					LEFT JOIN tblfacfactura fac
					ON fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId
						LEFT JOIN tblamdalmacenmovimientodetalle amd 
						ON fde.AmdId = amd.AmdId

				WHERE amd.AmoId = amo.AmoId 
				AND fac.FacEstado <> 6
				LIMIT 1 
			),0)

		)>0,"SI","NO"

) = "SI" 
				
			';
			
		}
			
	
		if(($oFacturable)){
			$facturable = ' AND amo.AmoFacturable =  '.$oFacturable;
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				amo.AmoId,	
				amo.CliId,			
				
				amo.AlmId,
				DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
				
				amo.MonId,
				amo.AmoTipoCambio,

			
				amo.VdiId,
				
				amo.TopId,
				
				amo.AmoDireccion,
				amo.AmoObservacion,
				amo.AmoPorcentajeImpuestoVenta,
				amo.AmoMargenUtilidad,
				
					amo.AmoEmpresaTransporte,
		amo.AmoEmpresaTransporteDocumento,
		amo.AmoEmpresaTransporteClave,
		amo.AmoEmpresaTransporteTipoEnvio,
		DATE_FORMAT(amo.AmoEmpresaTransporteFecha, "%d/%m/%Y") AS "NAmoEmpresaTransporteFecha",
		amo.AmoEmpresaTransporteDestino,
			
				amo.AmoManoObra,
				amo.AmoDescuento,
				amo.AmoSubTotal,
				amo.AmoImpuesto,
				amo.AmoTotal,
								

				CASE
				WHEN EXISTS (
					SELECT 
					fac.FacId 
					FROM tblfacfactura fac 
						
					WHERE fac.AmoId = amo.AmoId
					AND fac.FacEstado <> 6
					 LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS AmoFactura,
				
				
				CASE
				WHEN EXISTS (
					SELECT 
					bol.BolId 
					FROM tblbolboleta bol
					WHERE bol.AmoId = amo.AmoId 
						AND bol.BolEstado <> 6 LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS AmoBoleta,
				
				
				CASE
				WHEN EXISTS (
					SELECT 
					gam.GamId
					FROM tblgamguiaremisionalmacenmovimiento gam
						LEFT JOIN tblgreguiaremision gre
						ON (gam.GreId = gre.GreId AND gam.GrtId = gre.GrtId)
							
					WHERE gam.AmoId = amo.AmoId 
						AND gre.GreEstado <> 6
						LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS AmoGuiaRemision,
				
				


	
				CASE
				WHEN EXISTS (
					SELECT 

						(
							IFNULL(amd.AmdCantidad,0) 
							
							- IFNULL(

								(
									SELECT 
									SUM(bde.BdeCantidad)
									FROM tblbdeboletadetalle bde
									
										LEFT JOIN tblbolboleta bol
										ON (bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId)
											
									WHERE bde.AmdId = amd.AmdId
										AND bol.BolEstado <> 6
									LIMIT 1
								)
													
							,0)
							
							- IFNULL(
	
									(
										SELECT 
										SUM(fde.FdeCantidad)
										FROM tblfdefacturadetalle fde
										
											LEFT JOIN tblfacfactura fac
											ON (fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId)
												
										WHERE fde.AmdId = amd.AmdId
											AND fac.FacEstado <> 6
										LIMIT 1
									)

							,0)
							
						)  AS AmdCantidadPendiente

					FROM tblamdalmacenmovimientodetalle amd
						
					WHERE amd.AmoId = amo.AmoId
						
						HAVING AmdCantidadPendiente > 0
					
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS AmoGenerarComprobante,
				
				
				
				
				
				amo.AmoIncluyeImpuesto,	
				amo.AmoCierre AS VcoCierre,		
				amo.AmoEstado,
				DATE_FORMAT(amo.AmoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAmoTiempoCreacion",
	        	DATE_FORMAT(amo.AmoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAmoTiempoModificacion",
				(SELECT COUNT(amd.AmdId) FROM tblamdalmacenmovimientodetalle amd WHERE amd.AmoId = amo.AmoId ) AS "AmoTotalItems",
				
				CONCAT(IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")," ",IFNULL(cli.CliNombre,"")) AS CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.TdoId,
				cli.LtiId,
				cli.CliNumeroDocumento,
				cli.CliTelefono,
				cli.CliEmail,
				cli.CliCelular,
				cli.CliFax,
				
				cli.CliDireccion,
				cli.CliDepartamento,
				cli.CliProvincia,
				cli.CliDistrito,
				
				tdo.TdoNombre,
				lti.LtiNombre,
				lti.LtiAbreviatura,
				
				vdi.CprId,
				vdi.VdiOrdenCompraNumero,
				DATE_FORMAT(vdi.VdiOrdenCompraFecha, "%d/%m/%Y") AS "NVdiOrdenCompraFecha",
				vdi.VdiArchivo,
			
				DATE_FORMAT(vdi.VdiFecha, "%d/%m/%Y") AS "NVdiFecha",
	        	
				mon.MonSimbolo	,
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				per.PerEmail
				
				FROM tblamoalmacenmovimiento amo
					LEFT JOIN tblvdiventadirecta vdi
					ON amo.VdiId = vdi.VdiId
						LEFT JOIN tblperpersonal per
						ON vdi.PerId = per.PerId
			
					LEFT JOIN tblclicliente cli
					ON amo.Cliid = cli.CliId
						LEFT JOIN tbltdotipodocumento tdo
						ON cli.TdoId = tdo.TdoId
							LEFT JOIN tbllticlientetipo lti
							ON cli.LtiId = lti.LtiId	
								LEFT JOIN tblmonmoneda mon
								ON amo.MonId = mon.MonId
								
				WHERE 
				amo.VdiId IS NOT NULL 
				AND amo.AmoTipo = 2 
				AND amo.AmoSubTipo = 3 '.$filtrar.$fecha.$tipo.$stipo.$estado.$faccion.$fingreso.$confactura.$conficha.$fiestado.$conboleta.$concrepuesto.$conguiaremision.$crestado.$vdirecta.$moneda.$dvencer.$pagado.$itvacio.$gfactura.$facturable.$orden.$paginacion;

			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVentaConcretada = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VentaConcretada = new $InsVentaConcretada();
                    $VentaConcretada->VcoId = $fila['AmoId'];
					$VentaConcretada->CliId = $fila['CliId'];
					
					$VentaConcretada->AlmId = $fila['AlmId'];
					$VentaConcretada->VcoFecha = $fila['NAmoFecha'];
					$VentaConcretada->MonId = $fila['MonId'];
					$VentaConcretada->VcoTipoCambio = $fila['AmoTipoCambio'];

					$VentaConcretada->CprId = $fila['CprId'];
					$VentaConcretada->VdiId = $fila['VdiId'];
					
					$VentaConcretada->TopId = $fila['TopId'];

					$VentaConcretada->VcoDireccion = $fila['AmoDireccion'];
					$VentaConcretada->VcoObservacion = $fila['AmoObservacion'];
					$VentaConcretada->VcoPorcentajeImpuestoVenta = $fila['AmoPorcentajeImpuestoVenta'];
					$VentaConcretada->VcoMargenUtilidad = $fila['AmoMargenUtilidad'];

					$VentaConcretada->VcoEmpresaTransporte = $fila['AmoEmpresaTransporte'];
					$VentaConcretada->VcoEmpresaTransporteDocumento = $fila['AmoEmpresaTransporteDocumento'];
					$VentaConcretada->VcoEmpresaTransporteClave = $fila['AmoEmpresaTransporteClave'];
					$VentaConcretada->VcoEmpresaTransporteTipoEnvio = $fila['AmoEmpresaTransporteTipoEnvio'];
					$VentaConcretada->VcoEmpresaTransporteFecha = $fila['NAmoEmpresaTransporteFecha'];
					$VentaConcretada->VcoEmpresaTransporteDestino = $fila['AmoEmpresaTransporteDestino'];
					
					$VentaConcretada->VcoManoObra = $fila['AmoManoObra'];
					$VentaConcretada->VcoDescuento = $fila['AmoDescuento'];
					$VentaConcretada->VcoSubTotal = $fila['AmoSubTotal'];
					$VentaConcretada->VcoImpuesto = $fila['AmoImpuesto'];
					$VentaConcretada->VcoTotal = $fila['AmoTotal'];
				
				
					$VentaConcretada->VcoFactura = $fila['AmoFactura'];
					$VentaConcretada->VcoBoleta = $fila['AmoBoleta'];
					$VentaConcretada->VcoGuiaRemision = $fila['AmoGuiaRemision'];
					
					$VentaConcretada->VcoGenerarComprobante = $fila['AmoGenerarComprobante'];
					
					
					$VentaConcretada->VcoIncluyeImpuesto = $fila['AmoIncluyeImpuesto'];
					$VentaConcretada->VcoCierre = $fila['VcoCierre'];
					$VentaConcretada->VcoEstado = $fila['AmoEstado'];
					$VentaConcretada->VcoTiempoCreacion = $fila['NAmoTiempoCreacion'];  
					$VentaConcretada->VcoTiempoModificacion = $fila['NAmoTiempoModificacion']; 

					$VentaConcretada->VcoTotalItems = $fila['AmoTotalItems']; 
					
					$VentaConcretada->CliNombreCompleto = $fila['CliNombreCompleto'];
					$VentaConcretada->CliNombre = $fila['CliNombre'];
					$VentaConcretada->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$VentaConcretada->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					
					
					$VentaConcretada->TdoId = $fila['TdoId'];
					$VentaConcretada->LtiId = $fila['LtiId'];
					$VentaConcretada->CliNumeroDocumento = $fila['CliNumeroDocumento'];					
					$VentaConcretada->CliTelefono = $fila['CliTelefono'];
					$VentaConcretada->CliEmail = $fila['CliEmail'];
					$VentaConcretada->CliCelular = $fila['CliCelular'];
					$VentaConcretada->CliFax = $fila['CliFax'];
					$VentaConcretada->LtiAbreviatura = $fila['LtiAbreviatura'];
					
					$VentaConcretada->CliDireccion = $fila['CliDireccion'];
					$VentaConcretada->CliDepartamento = $fila['CliDepartamento'];
					$VentaConcretada->CliProvincia = $fila['CliProvincia'];
					$VentaConcretada->CliDistrito = $fila['CliDistrito'];
	
					
					$VentaConcretada->TdoNombre = $fila['TdoNombre'];
					$VentaConcretada->LtiNombre = $fila['LtiNombre'];
					
					$VentaConcretada->MonSimbolo = $fila['MonSimbolo'];
					
					$VentaConcretada->VdiOrdenCompraNumero = $fila['VdiOrdenCompraNumero'];
					$VentaConcretada->VdiOrdenCompraFecha = $fila['NVdiOrdenCompraFecha'];
					
					
					$VentaConcretada->VdiArchivo = $fila['VdiArchivo'];
					$VentaConcretada->VdiFecha = $fila['NVdiFecha'];
					
					$VentaConcretada->PerNombre = $fila['PerNombre'];
					$VentaConcretada->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$VentaConcretada->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					$VentaConcretada->PerEmail = $fila['PerEmail'];
				
					switch($VentaConcretada->VcoEstado){
						case 1:
							$VentaConcretada->VcoEstadoDescripcion = "No Realizado";
						break;

						
						case 3:
							$VentaConcretada->VcoEstadoDescripcion = "Realizado";					
						break;
					}
					
					
								switch($VentaConcretada->VcoEstado){
					case 1:
						$VentaConcretada->VcoEstadoIcono = '<img width="15" height="15" alt="[No Realizado]" title="No Realizado" src="imagenes/estado/no_realizado.png" />';
					break;

					
					case 3:
						$VentaConcretada->VcoEstadoIcono = '<img width="15" height="15" alt="[Realizado]" title="Realizado" src="imagenes/estado/realizado.gif" />';					
					break;
			}
			
			
                    $VentaConcretada->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VentaConcretada;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
	

}
?>