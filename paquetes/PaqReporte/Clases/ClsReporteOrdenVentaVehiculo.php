<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsReporteOrdenVentaVehiculo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReporteOrdenVentaVehiculo {

	  public $OvvId;
	public $OvvAno;
	public $OvvMes;
	
	public $PerId;
	public $CliId;
	public $OvvFecha;
	public $OvvFechaVigencia;
	public $OvvFechaEntrega;
	
	public $CveId;
	
	public $MonId;
	public $OvvTipoCambio;
	
	public $MpaId;
	
	public $OvvIncluyeImpuesto;
	public $OvvPorcentajeImpuestoVenta;
	
    public $OvvObservacion;
	
	public $OvvTelefono;
	public $OvvCelular;
	public $OvvDireccion;
	public $OvvEmail;
	public $OvvColor;
	
	public $OvvAnoModelo;
	public $OvvAnoFabricacion;
	
	public $VveId;
	public $EinId;

		
	public $OvvSubTotal;
	public $OvvImpuesto;
	public $OvvTotal;
	
	public $OvvCondicionVentaOtro;
	public $OvvObsequioOtro;
	
	public $OvvComprobanteVenta;
	
	public $OvvActaEntregaFecha;
	public $OvvActaEntregaDescripcion;
	
	public $OvvNota;
	public $OvvPlaca;
	public $OvvEstado;
	public $OvvTiempoCreacion;
	public $OvvTiempoModificacion;
    public $OvvEliminado;


	public $OvvFactura;
	public $OvvBoleta;
	
	public $TdoId;
	public $CliNombre;
	public $CliApellidoPaterno;
	public $CliApellidoMaterno;
	
	public $CliNumeroDocumento;
	public $TdoNombre;

	public $VmaNombre;
	public $VmoNombre;
	public $VveNombre;
	public $VtiNombre;
	
	public $MonSimbolo;
	public $MonNombre;
	
	public $VveFoto;
	
	public $LtiNombre;
	
	public $EinVIN;
	public $EinNombre;
	
	public $PerNombre;
	public $PerApellidoPaterno;
	public $PerApellidoMaterno;
	
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
	
	public function MtdObtenerReporteOrdenVentaVehiculoClientes($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL,$oIncluirCSI=NULL,$oDiasTranscurridosTipo="Mayor",$oDiasTranscurridos=0,$oFecha="IFNULL(ovv.OvvActaEntregaFecha,ovv.OvvActaEntregaFechaPDS)") {

		// Inicializar variables
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$fechainicio = '';
		$fechafin = '';
		$vehiculoMarca = '';
		$sucursal = '';
		$incluirCSI = '';
		$diasTranscurridosTipo = '';
		$diasTranscurridos = '';
		$fecha = '';

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
		
		if(!empty($oVehiculoMarca)){
				$vmarca = ' AND (vmo.VmaId) = "'.$oVehiculoMarca.'"';		
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
		
		if(!empty($oSucursal)){
			$sucursal = ' AND (ovv.SucId) = "'.$oSucursal.'"';		
		}	
		
		
			if(!empty($oDiasTranscurridos)){
				
				switch($oDiasTranscurridosTipo){
					
					case "Mayor":
						$dtranscurrido = ' AND DATEDIFF(DATE("'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).'"), DATE('.$oFecha.')) > '.$oDiasTranscurridos.' ';		
					break;
					
					case "Menor":
						$dtranscurrido = ' AND DATEDIFF(DATE("'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).'"), DATE('.$oFecha.')) < '.$oDiasTranscurridos.' ';	
					break;
					
					case "MayorIgual":
						$dtranscurrido = ' AND DATEDIFF(DATE("'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).'"), DATE('.$oFecha.')) >= '.$oDiasTranscurridos.' ';	
					break;
					
					case "MenorIgual":
						$dtranscurrido = ' AND DATEDIFF(DATE("'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).'"), DATE('.$oFecha.')) <= '.$oDiasTranscurridos.' ';	
					break;
					
					case "Igual":
						$dtranscurrido = ' AND DATEDIFF(DATE("'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).'"), DATE('.$oFecha.')) = '.$oDiasTranscurridos.' ';	
					break;
					
					default:
						$dtranscurrido = ' AND DATEDIFF(DATE("'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).'"), DATE('.$oFecha.')) > '.$oDiasTranscurridos.' ';		
					
					break;
					
				}
				
				
				
				
			}	
			
				if($oIncluirCSI){
				
				$icsi = ' 	
					AND cli.CliCSIIncluir = "'.$oIncluirCSI.'"
				';		
				
			}	

			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				
				ovv.OvvId,	
			
				ovv.PerId,
				ovv.CliId,

				DATE_FORMAT(ovv.OvvFecha, "%d/%m/%Y") AS "NOvvFecha",
				DATE_FORMAT(ovv.OvvFechaEntrega, "%d/%m/%Y") AS "NOvvFechaEntrega2",
				
			
				DATE_FORMAT(IFNULL(ovv.OvvActaEntregaFecha,ovv.OvvActaEntregaFechaPDS), "%d/%m/%Y") 	 AS "NOvvFechaEntrega",
				
				DATEDIFF(DATE("'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).'"),IFNULL(ovv.OvvActaEntregaFecha,ovv.OvvActaEntregaFechaPDS)) AS OvvDiaTranscurridoEntrega,
				
				
				
				
				ovv.CveId,
				
				ovv.MonId,
				ovv.OvvTipoCambio,
				
				ovv.MpaId,
				
				ovv.OvvIncluyeImpuesto,
				ovv.OvvPorcentajeImpuestoVenta,
		
				ovv.OvvObservacion,

				ovv.OvvTelefono,
				ovv.OvvCelular,
				ovv.OvvDireccion,
				ovv.OvvEmail,
		
				ovv.VveId,
				ovv.OvvAnoModelo,
				ovv.OvvAnoFabricacion,
				ovv.OvvColor,
				ovv.EinId,
				
				ovv.OvvPrecio,
				ovv.OvvDescuento,
				ovv.OvvDescuentoGerencia,
				
				ovv.OvvSubTotal,
				ovv.OvvImpuesto,				
				ovv.OvvTotal,

				ovv.OvvCondicionVentaOtro,

				ovv.OvvObsequioOtro,
				
				ovv.OvvComprobanteVenta,
				
				ovv.OvvNota,
				ovv.OvvPlaca,
				ovv.OvvEstado,
				DATE_FORMAT(ovv.OvvTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoCreacion",
	        	DATE_FORMAT(ovv.OvvTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoModificacion",
				
				
				DATE_FORMAT(ovv.OvvActaEntregaFecha, "%d/%m/%Y") AS "NOvvActaEntregaFecha",
				DATE_FORMAT(ovv.OvvActaEntregaFechaPDS, "%d/%m/%Y") AS "NOvvActaEntregaFechaPDS",
				
				
				
				ovv.OvvActaEntregaDescripcion,
						
				CASE
				WHEN EXISTS (
					SELECT 
					fac.FacId
					FROM tblfacfactura fac
					WHERE fac.OvvId = ovv.OvvId 
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS OvvFactura,
		
		
							
				CASE
				WHEN EXISTS (
					SELECT 
					bol.BolId
					FROM tblbolboleta bol
					WHERE bol.OvvId = ovv.OvvId 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
						
						
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS OvvBoleta,



				(
					SELECT 
					CONCAT(fta.FtaNumero,"-",fac.FacId)
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6 
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					LIMIT 1
				)  AS OvvFacturaNumero,
		
		
								
				(
					SELECT 
					CONCAT(bta.BtaNumero,"-",bol.BolId)
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
						
					LIMIT 1
				) AS OvvBoletaNumero,	
				
				


				(
					SELECT 
					DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y")
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
								
					 LIMIT 1
				)  AS OvvFacturaFecha,
				
		
				(
					SELECT 
					DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y")
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
						
					 LIMIT 1
				) AS OvvBoletaFecha,	
				




				(
					SELECT 
					fac.FacTipoCambio
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
								
					 LIMIT 1
				)  AS OvvFacturaTipoCambio,

				(
					SELECT 
					bol.BolTipoCambio
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
						
					 LIMIT 1
				) AS OvvBoletaTipoCambio,
				
				


				(
					SELECT 
					fac.FacTotal
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6 
					
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
								
					LIMIT 1
				)  AS OvvFacturaTotal,

				(
					SELECT 
					bol.BolTotal
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
						
					LIMIT 1
				) AS OvvBoletaTotal,
				
				
						
						
				(
					SELECT 
					fac.FacEstado
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					
					 LIMIT 1
				)  AS OvvFacturaEstado,

				(
					SELECT 
					bol.BolEstado
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					
					 LIMIT 1
				) AS OvvBoletaEstado,
				
				
				
								
	
				cli.TdoId,
				CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.CliNumeroDocumento,
				cli.CliTelefono,
				cli.CliCelular,
				cli.CliEmail,
				
				cli.CliContactoEmail1,
				cli.CliContactoEmail2,
				cli.CliContactoEmail3,
				
				cli.CliEmailFacturacion,
				
				cli.CliDireccion,
				cli.CliDepartamento,
				cli.CliProvincia,
				cli.CliDistrito,
				cli.CliPais,
				cli.CliActividadEconomica,
				
				cli.CliRepresentanteNombre,
				cli.CliRepresentanteNumeroDocumento,
				cli.CliRepresentanteNacionalidad,
				cli.CliRepresentanteActividadEconomica,
				
				
				(
					SELECT 
					COUNT(ovp.OvpId) 
					FROM tblovpordenventavehiculopropietario ovp 
					WHERE ovp.OvvId = ovv.OvvId
				
				) AS OvvPropietarioCantidad,
				
				

		(SELECT 
		
		(pag.PagMonto)
		
		FROM tblpagpago pag
		WHERE 
			
			EXISTS(
				SELECT
				pac.PacId
				FROM tblpacpagocomprobante pac
					WHERE pac.PagId = pag.PagId
					AND pac.Ovvid = ovv.Ovvid
			)
			
		ORDER BY pag.PagId ASC LIMIT 1
		) AS OvvAbonoInicial,
		
		
		
		
		(SELECT 
		
		(pag.FpaId)
		
		FROM tblpagpago pag
		WHERE 
			
			EXISTS(
				SELECT
				pac.PacId
				FROM tblpacpagocomprobante pac
					WHERE pac.PagId = pag.PagId
					AND pac.Ovvid = ovv.Ovvid
			)
			
		ORDER BY pag.PagId ASC LIMIT 1
		) AS FpaId,
		
		
			(SELECT 
		
		(fpa.FpaAbreviatura)
		
		FROM tblpagpago pag
			LEFT JOIN tblfpaformapago fpa
			ON pag.FpaId = fpa.FpaId
		WHERE 
			
			EXISTS(
				SELECT
				pac.PacId
				FROM tblpacpagocomprobante pac
					WHERE pac.PagId = pag.PagId
					AND pac.Ovvid = ovv.Ovvid
			)
			
		ORDER BY pag.PagId ASC LIMIT 1
		) AS FpaAbreviatura,
		
				
				tdo.TdoNombre,
				
				mon.MonNombre,
				mon.MonSimbolo,

				vmo.VmaId,
				vma.VmaNombre,
		
				vve.VmoId,
				vmo.VmoNombre,
				
				vmo.VtiId,
				vti.VtiNombre,
				
				vve.VveNombre,
				
				vve.VveFoto,
				
				lti.LtiNombre,
				
				ein.EinVIN,
				ein.EinColor,
				ein.EinPlaca,
				
				per.PerNumeroDocumento,
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				mpa.MpaNombre,
				mpa.MpaAbreviatura,
				
				suc.SucNombre,
				suc.SucDistrito,
				suc.SucDepartamento
		
				FROM tblovvordenventavehiculo ovv
				
					LEFT JOIN tblmpamodalidadpago mpa
					ON ovv.MpaId = mpa.MpaId
						
						LEFT JOIN tblclicliente cli
						ON ovv.CliId = cli.CliId
						
						LEFT JOIN tbltdotipodocumento tdo
						ON cli.TdoId = tdo.TdoId
						
							LEFT JOIN tbllticlientetipo lti
							ON cli.LtiId = lti.LtiId
							
							LEFT JOIN tbleinvehiculoingreso ein
							ON ovv.EinId = ein.EinId
							
							LEFT JOIN tblmonmoneda mon
							ON ovv.MonId = mon.MonId

							LEFT JOIN tblvvevehiculoversion vve
							ON ovv.VveId = vve.VveId
								LEFT JOIN tblvmovehiculomodelo vmo
								ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvtivehiculotipo vti
							ON vmo.VtiId = vti.VtiId	
									LEFT JOIN tblvmavehiculomarca vma
									ON vmo.VmaId = vma.VmaId

									LEFT JOIN tblperpersonal per
									ON ovv.PerId = per.PerId
										LEFT JOIN tblsucsucursal suc
										ON ovv.SucId = suc.SucId
												
				WHERE ovv.OvvAprobacion1 = 1  '.$filtrar.$icsi.$dtranscurrido.$fecha.$vmarca.$sucursal.$mingreso.$agrupar." GROUP BY ovv.CliId ".$orden.$paginacion;

			$resultado = $this->InsMysql->MtdConsultar($sql);            

//IF(IFNULL(fac.AmoId
//				,IFNULL(bol.AmoId,"F")) AS OvvComprobanteVentaTipo,
				
				
			$Respuesta['Datos'] = array();

            $InsReporteOrdenVentaVehiculo = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReporteOrdenVentaVehiculo = new $InsReporteOrdenVentaVehiculo();

                    $ReporteOrdenVentaVehiculo->OvvId = $fila['OvvId'];
					
					$ReporteOrdenVentaVehiculo->PerId = $fila['PerId'];	
					$ReporteOrdenVentaVehiculo->CliId = $fila['CliId'];	
					$ReporteOrdenVentaVehiculo->OvvFecha = $fila['NOvvFecha'];
					$ReporteOrdenVentaVehiculo->OvvFechaEntrega = $fila['NOvvFechaEntrega'];
					$ReporteOrdenVentaVehiculo->OvvDiaTranscurridoEntrega = $fila['OvvDiaTranscurridoEntrega'];
					
					$ReporteOrdenVentaVehiculo->CveId = $fila['CveId'];
					
					$ReporteOrdenVentaVehiculo->MonId = $fila['MonId'];
					$ReporteOrdenVentaVehiculo->OvvTipoCambio = $fila['OvvTipoCambio'];
					
					$ReporteOrdenVentaVehiculo->MpaId = $fila['MpaId'];
					
					$ReporteOrdenVentaVehiculo->OvvIncluyeImpuesto = $fila['OvvIncluyeImpuesto'];
					$ReporteOrdenVentaVehiculo->OvvPorcentajeImpuestoVenta = $fila['OvvPorcentajeImpuestoVenta'];					
					$ReporteOrdenVentaVehiculo->OvvObservacion = $fila['OvvObservacion'];
					
					$ReporteOrdenVentaVehiculo->OvvTelefono = $fila['OvvTelefono'];
					$ReporteOrdenVentaVehiculo->OvvCelular = $fila['OvvCelular'];
					$ReporteOrdenVentaVehiculo->OvvDireccion = $fila['OvvDireccion'];
					$ReporteOrdenVentaVehiculo->OvvEmail = $fila['OvvEmail'];
					
					$ReporteOrdenVentaVehiculo->CliContactoEmail1 = $fila['CliContactoEmail1'];
					$ReporteOrdenVentaVehiculo->CliContactoEmail2 = $fila['CliContactoEmail2'];
					$ReporteOrdenVentaVehiculo->CliContactoEmail3 = $fila['CliContactoEmail3'];
					
					$ReporteOrdenVentaVehiculo->CliEmailFacturacion = $fila['CliEmailFacturacion'];
					
					
					$ReporteOrdenVentaVehiculo->CliDireccion = $fila['CliDireccion'];
					$ReporteOrdenVentaVehiculo->CliDepartamento = $fila['CliDepartamento'];
					$ReporteOrdenVentaVehiculo->CliProvincia = $fila['CliProvincia'];
					$ReporteOrdenVentaVehiculo->CliDistrito = $fila['CliDistrito'];
					$ReporteOrdenVentaVehiculo->CliPais = $fila['CliPais'];
					$ReporteOrdenVentaVehiculo->CliActividadEconomica = $fila['CliActividadEconomica'];
					
					
					$ReporteOrdenVentaVehiculo->CliRepresentanteNombre = $fila['CliRepresentanteNombre'];
					$ReporteOrdenVentaVehiculo->CliRepresentanteNumeroDocumento = $fila['CliRepresentanteNumeroDocumento'];
					$ReporteOrdenVentaVehiculo->CliRepresentanteNacionalidad = $fila['CliRepresentanteNacionalidad'];
					$ReporteOrdenVentaVehiculo->CliRepresentanteActividadEconomica = $fila['CliRepresentanteActividadEconomica'];

				
				
				
					$ReporteOrdenVentaVehiculo->VveId = $fila['VveId'];
					$ReporteOrdenVentaVehiculo->OvvAnoModelo = $fila['OvvAnoModelo'];	
					$ReporteOrdenVentaVehiculo->OvvAnoFabricacion = $fila['OvvAnoFabricacion'];
					
					
					$ReporteOrdenVentaVehiculo->OvvColor = $fila['OvvColor'];	
					$ReporteOrdenVentaVehiculo->EinId = $fila['EinId'];			

					$ReporteOrdenVentaVehiculo->OvvPrecio = $fila['OvvPrecio'];			
					$ReporteOrdenVentaVehiculo->OvvDescuento = $fila['OvvDescuento'];			
					$ReporteOrdenVentaVehiculo->OvvDescuentoGerencia = $fila['OvvDescuentoGerencia'];	
				
				
					$ReporteOrdenVentaVehiculo->OvvSubTotal = $fila['OvvSubTotal'];			
					$ReporteOrdenVentaVehiculo->OvvImpuesto = $fila['OvvImpuesto'];
					$ReporteOrdenVentaVehiculo->OvvTotal = $fila['OvvTotal'];
					
					$ReporteOrdenVentaVehiculo->OvvCondicionVentaOtro = $fila['OvvCondicionVentaOtro'];
					$ReporteOrdenVentaVehiculo->OvvObsequioOtro = $fila['OvvObsequioOtro'];
					
					$ReporteOrdenVentaVehiculo->OvvComprobanteVenta = $fila['OvvComprobanteVenta'];
					
					$ReporteOrdenVentaVehiculo->OvvFactura = $fila['OvvFactura'];
					$ReporteOrdenVentaVehiculo->OvvBoleta = $fila['OvvBoleta'];
					
					$ReporteOrdenVentaVehiculo->OvvFacturaNumero = $fila['OvvFacturaNumero'];
					$ReporteOrdenVentaVehiculo->OvvBoletaNumero = $fila['OvvBoletaNumero'];
					
					$ReporteOrdenVentaVehiculo->OvvFacturaFecha = $fila['OvvFacturaFecha'];
					$ReporteOrdenVentaVehiculo->OvvBoletaFecha = $fila['OvvBoletaFecha'];

					$ReporteOrdenVentaVehiculo->OvvFacturaTotal = $fila['OvvFacturaTotal'];
					$ReporteOrdenVentaVehiculo->OvvBoletaTotal = $fila['OvvBoletaTotal'];
					
					$ReporteOrdenVentaVehiculo->OvvFacturaEstado = $fila['OvvFacturaEstado'];
					$ReporteOrdenVentaVehiculo->OvvBoletaEstado = $fila['OvvBoletaEstado'];	
					
				
					$ReporteOrdenVentaVehiculo->OvvFacturaTipoCambio = $fila['OvvFacturaTipoCambio'];
					$ReporteOrdenVentaVehiculo->OvvBoletaTipoCambio = $fila['OvvBoletaTipoCambio'];				
					
					
					$ReporteOrdenVentaVehiculo->OvvNota = $fila['OvvNota'];
					$ReporteOrdenVentaVehiculo->OvvPlaca = $fila['OvvPlaca'];
					$ReporteOrdenVentaVehiculo->OvvEstado = $fila['OvvEstado'];
					$ReporteOrdenVentaVehiculo->OvvTiempoCreacion = $fila['NOvvTiempoCreacion'];  
					$ReporteOrdenVentaVehiculo->OvvTiempoModificacion = $fila['NOvvTiempoModificacion']; 
					
					
					$ReporteOrdenVentaVehiculo->OvvActaEntregaFecha = $fila['NOvvActaEntregaFecha']; 
					$ReporteOrdenVentaVehiculo->OvvActaEntregaDescripcion = $fila['OvvActaEntregaDescripcion']; 
					$ReporteOrdenVentaVehiculo->OvvActaEntregaFechaPDS = $fila['NOvvActaEntregaFechaPDS']; 
					
		
					$ReporteOrdenVentaVehiculo->TdoId = $fila['TdoId']; 
					$ReporteOrdenVentaVehiculo->CliNombreCompleto = $fila['CliNombreCompleto']; 
					$ReporteOrdenVentaVehiculo->CliNombre = $fila['CliNombre']; 
					$ReporteOrdenVentaVehiculo->CliApellidoPaterno = $fila['CliApellidoPaterno']; 
					$ReporteOrdenVentaVehiculo->CliApellidoMaterno = $fila['CliApellidoMaterno']; 
					$ReporteOrdenVentaVehiculo->CliNumeroDocumento = $fila['CliNumeroDocumento']; 
					
					$ReporteOrdenVentaVehiculo->CliTelefono = $fila['CliTelefono']; 
					$ReporteOrdenVentaVehiculo->CliCelular = $fila['CliCelular']; 
					$ReporteOrdenVentaVehiculo->CliEmail = $fila['CliEmail']; 

					$ReporteOrdenVentaVehiculo->OvvPropietarioCantidad = $fila['OvvPropietarioCantidad']; 
					
					$ReporteOrdenVentaVehiculo->OvvAbonoInicial = $fila['OvvAbonoInicial'];
					$ReporteOrdenVentaVehiculo->FpaId = $fila['FpaId']; 
					$ReporteOrdenVentaVehiculo->FpaAbreviatura = $fila['FpaAbreviatura']; 
				
					$ReporteOrdenVentaVehiculo->TdoNombre = $fila['TdoNombre']; 
					
					$ReporteOrdenVentaVehiculo->MonNombre = $fila['MonNombre']; 
					$ReporteOrdenVentaVehiculo->MonSimbolo = $fila['MonSimbolo']; 
				
		
					$ReporteOrdenVentaVehiculo->VmaId = $fila['VmaId'];
					$ReporteOrdenVentaVehiculo->VmaNombre = $fila['VmaNombre'];
					
					$ReporteOrdenVentaVehiculo->VmoId = $fila['VmoId'];
					$ReporteOrdenVentaVehiculo->VmoNombre = $fila['VmoNombre'];
					
					$ReporteOrdenVentaVehiculo->VveId = $fila['VveId'];
					$ReporteOrdenVentaVehiculo->VveNombre = $fila['VveNombre'];
					
					$ReporteOrdenVentaVehiculo->VveFoto = $fila['VveFoto'];
					
					$ReporteOrdenVentaVehiculo->LtiNombre = $fila['LtiNombre'];
					
					$ReporteOrdenVentaVehiculo->EinVIN = $fila['EinVIN'];
					$ReporteOrdenVentaVehiculo->EinColor = $fila['EinColor'];
					$ReporteOrdenVentaVehiculo->EinPlaca = $fila['EinPlaca'];
					
					
					$ReporteOrdenVentaVehiculo->PerNumeroDocumento = $fila['PerNumeroDocumento'];
					$ReporteOrdenVentaVehiculo->PerNombre = $fila['PerNombre'];
					$ReporteOrdenVentaVehiculo->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$ReporteOrdenVentaVehiculo->PerApellidoMaterno = $fila['PerApellidoMaterno'];

					$ReporteOrdenVentaVehiculo->MpaNombre = $fila['MpaNombre'];
					$ReporteOrdenVentaVehiculo->MpaAbreviatura = $fila['MpaAbreviatura'];		
					
					$ReporteOrdenVentaVehiculo->SucNombre = $fila['SucNombre'];					
					$ReporteOrdenVentaVehiculo->SucDistrito = $fila['SucDistrito'];		
					$ReporteOrdenVentaVehiculo->SucDepartamento = $fila['SucDepartamento'];		


					switch($ReporteOrdenVentaVehiculo->OvvEstado){
					
					  case 1:
						  $Estado = "Pendiente";
					  break;
					
					  case 3:
						  $Estado = "Emitido";
					  break;	
						
					case 4:
							$Estado = "Por Facturar";
					break;
					
					 case 5:
						  $Estado = "Facturado";			  	
					  break;
					
					 case 6:
						  $Estado = "Anulado";			  	
					  break;
			
					  default:
						  $Estado = "";
					  break;					
					
					}
					
					$ReporteOrdenVentaVehiculo->OvvEstadoDescripcion = $Estado;           

					$Respuesta['Datos'][]= $ReporteOrdenVentaVehiculo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}




	public function MtdObtenerOrdenVentaVehiculoCliente1Unidad($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL) {

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
		
		
		if(!empty($oVehiculoMarca)){
				$vmarca = ' AND (vmo.VmaId) = "'.$oVehiculoMarca.'"';		
		}	
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE((ovv.OvvFecha))>="'.$oFechaInicio.'" AND DATE((ovv.OvvFecha))<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE((ovv.OvvFecha))>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE((ovv.OvvFecha))<="'.$oFechaFin.'"';		
			}			
		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND (ovv.SucId) = "'.$oSucursal.'"';		
		}		

			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				
				cli.CliNumeroDocumento,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.CliTelefono,
				cli.CliCelular,
				cli.CliDireccion,
				cli.CliEmail,
				
				@Total:=COUNT(ovv.OvvId) AS RovTotalUnidades,
				
				suc.SucNombre
				
				FROM tblovvordenventavehiculo ovv
					LEFT JOIN tblclicliente cli
					ON ovv.CliId = cli.CliId
						LEFT JOIN tblvvevehiculoversion vve
						ON ovv.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
								LEFT JOIN tblvmavehiculomarca vma
								ON vmo.VmaId = vma.VmaId
									LEFT JOIN tblsucsucursal suc
									ON ovv.SucId = suc.SucId
				WHERE ovv.OvvEstado = 5
												
				  '.$filtrar.$fecha.$vmarca.$sucursal.$mingreso.$agrupar." GROUP BY cli.CliNumeroDocumento ".$orden.$paginacion;

			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();

            $InsReporteOrdenVentaVehiculo = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReporteOrdenVentaVehiculo = new $InsReporteOrdenVentaVehiculo();

                    $ReporteOrdenVentaVehiculo->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					$ReporteOrdenVentaVehiculo->CliNombre = $fila['CliNombre'];	
					$ReporteOrdenVentaVehiculo->CliApellidoPaterno = $fila['CliApellidoPaterno'];	
					$ReporteOrdenVentaVehiculo->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					
					$ReporteOrdenVentaVehiculo->CliTelefono = $fila['CliTelefono'];
					$ReporteOrdenVentaVehiculo->CliCelular = $fila['CliCelular'];	
					$ReporteOrdenVentaVehiculo->CliDireccion = $fila['CliDireccion'];	
					$ReporteOrdenVentaVehiculo->CliEmail = $fila['CliEmail'];
					
					$ReporteOrdenVentaVehiculo->RovTotalUnidades = $fila['RovTotalUnidades'];
					
					$ReporteOrdenVentaVehiculo->SucNombre = $fila['SucNombre'];
					
					$Respuesta['Datos'][]= $ReporteOrdenVentaVehiculo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}





    public function MtdObtenerOrdenVentaVehiculoSinEntregas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oCliente=NULL,$oConCotizacion=0,$oFacturable=NULL,$oCotizacionVehiculo=NULL,$oVehiculoIngreso=NULL,$oSucursal=NULL,$oAprobacion1=NULL,$oAprobacion2=NULL,$oAprobacion3=NULL,$oTieneActaFechaEntrega=0,$oTieneComprobante=false,$oFechaTipo="OvvFecha",$oTiempoTranscurrido=NULL) {



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
					ovp.OvpId
					FROM tblovpordenventavehiculopropietario ovp
						LEFT JOIN tblclicliente cli
						ON ovp.CliId = cli.CliId
					WHERE 
						ovp.OvvId = ovv.OvvId AND
						(
							cli.CliNombre  LIKE "%'.$oFiltro.'%" OR
							cli.CliApellidoPaterno  LIKE "%'.$oFiltro.'%" OR
							cli.CliApellidoMaterno  LIKE "%'.$oFiltro.'%"  OR
							cli.CliNombreCompleto  LIKE "%'.$oFiltro.'%" 
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
				
				
				
			
				
		
				 
				
				$fecha = ' AND DATE(
				
				IFNULL(	
			
				(
					SELECT 
					(fac.FacFechaEmision)
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6 
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					LIMIT 1
				),
				
				IFNULL((
					SELECT 
					(bol.BolFechaEmision)
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
				),"")
				
				
				
				 )
				
				
				)>="'.$oFechaInicio.'" AND DATE(
				
				IFNULL(	
			
				(
					SELECT 
					(fac.FacFechaEmision)
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6 
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					LIMIT 1
				),
				
				IFNULL((
					SELECT 
					(bol.BolFechaEmision)
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
				),"")
				
				
				
				 )
				 
				 )<="'.$oFechaFin.'"';
			}else{
				
				$fecha = ' AND DATE(IFNULL(	
			
				(
					SELECT 
					(fac.FacFechaEmision)
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6 
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					LIMIT 1
				),
				
				IFNULL((
					SELECT 
					(bol.BolFechaEmision)
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
				),"")
				
				
				
				 ))>="'.$oFechaInicio.'"';
				
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(IFNULL(	
			
				(
					SELECT 
					(fac.FacFechaEmision)
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6 
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					LIMIT 1
				),
				
				IFNULL((
					SELECT 
					(bol.BolFechaEmision)
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
				),"")
				
				
				
				 ))<="'.$oFechaFin.'"';		
			}			
		}


		//if(!empty($oEstado)){
//			$estado = ' AND ovv.OvvEstado = '.$oEstado;
//		}
		
		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

			$i=1;
			$estado .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$estado .= '  (ovv.OvvEstado = '.($elemento).' )';
				if($i<>count($elementos)){						
					$estado .= ' OR ';	
				}
			$i++;		
			}

			$estado .= ' ) 
			)
			';

		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND ovv.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oPersonal)){
			$personal = ' AND ovv.PerId = "'.$oPersonal.'"';
		}
		if(!empty($oCliente)){
			$cliente = ' AND ovv.CliId = "'.$oCliente.'"';
		}
		
		switch($oConCotizacion){
			case 1:
				$ccotizacion = ' AND ovv.CveId IS NOT NULL ';
			break;
			
			case 2:
				$ccotizacion = ' AND ovv.CveId IS NULL ';
			break;
			
			default:
				$ccotizacion = '';
			break;	
		}
		
		switch($oFacturable){			
		
			case "FacturableSi":
				$facturable = ' 
				
				AND NOT EXISTS (
					SELECT fac.FacId FROM tblfacfactura fac
					WHERE fac.OvvId = ovv.OvvId
					AND fac.FacEstado <> 6 
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					LIMIT 1
				)
				
				AND NOT EXISTS(
					SELECT bol.BolId FROM tblbolboleta bol
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
				)
				
				AND (
				ovv.OvvEstado <> 6
				AND ovv.OvvEstado <> 3
				)
				
				';
			break;
			
			case "FacturableNo":
				$facturable = '
				
				AND  (
				
					EXISTS (
					SELECT fac.FacId FROM tblfacfactura fac
					WHERE fac.OvvId = ovv.OvvId
					AND fac.FacEstado <> 6
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					 LIMIT 1
					)
				
					OR  EXISTS(
					SELECT bol.BolId FROM tblbolboleta bol
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
					)
					
					OR (ovv.OvvEstado = 6 OR ovv.OvvEstado = 3)
				)
				
				';
			break;
			
			default:
				$facturable = "";
			break;
			
		}
			
		if(!empty($oCotizacionVehiculo)){
			$cvehiculo = ' AND ovv.CveId = "'.$oCotizacionVehiculo.'"';
		}
		
		if(!empty($oVehiculoIngreso)){
			$vingreso = ' AND ovv.EinId = "'.$oVehiculoIngreso.'"';
		}
		
		
		if(!empty($oSucursal)){
			$sucursal = ' AND ovv.SucId = "'.$oSucursal.'"';
		}
		
		if(!empty($oAprobacion1)){
			$aprobacion1 = ' AND ovv.OvvAprobacion1 = "'.$oAprobacion1.'"';
		}
		
		if(!empty($oAprobacion2)){
			$aprobacion2 = ' AND ovv.OvvAprobacion2 = "'.$oAprobacion2.'"';
		}
		
			if(!empty($oAprobacion3)){
			$aprobacion3 = ' AND ovv.OvvAprobacion3 = "'.$oAprobacion3.'"';
		}
		
		
		if(!empty($oTieneActaFechaEntrega)){

			switch($oTieneActaFechaEntrega){

				case 1:
			
					$taentrega = ' AND (ovv.OvvActaEntregaFecha IS NOT NULL AND ovv.OvvActaEntregaFecha != "0000-00-00")';				
						
				break;
				
				case 2:
				
					$taentrega = ' AND (ovv.OvvActaEntregaFecha IS  NULL OR ovv.OvvActaEntregaFecha =  "0000-00-00")';				
										
				break;
					
			}
			

		}
		
		if($oTieneComprobante){
			$tcomprobante = '
				AND 
				(
					EXISTS (
					SELECT fac.FacId FROM tblfacfactura fac
					WHERE fac.OvvId = ovv.OvvId
					AND fac.FacEstado <> 6
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					 LIMIT 1
					)
					
					OR  EXISTS(
					SELECT bol.BolId FROM tblbolboleta bol
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
					)
					
				)
			';
		}
		
		
		if(!empty($oTiempoTranscurrido)){
			
			
			
			
			
			$ttrasncurrido = ' AND 
			DATEDIFF(DATE(NOW()), 
			
			
			DATE(
				
				IFNULL(	
			
					(
						SELECT 
						(fac.FacFechaEmision)
						FROM tblfacfactura fac
							LEFT JOIN tblftafacturatalonario fta
							ON fac.FtaId = fta.FtaId
						WHERE fac.OvvId = ovv.OvvId 
						AND fac.FacEstado <> 6 
						AND NOT EXISTS(
										SELECT 	
										ncr.NcrId
										FROM tblncrnotacredito ncr
										WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
										AND ncr.NcrEstado <> 6
										AND ncr.NcrMotivoCodigo<> "04"
										AND ncr.NcrMotivoCodigo<> "05"
										AND ncr.NcrMotivoCodigo<> "09"
										
									) 
						LIMIT 1
					),
				
						IFNULL((
							SELECT 
							(bol.BolFechaEmision)
							FROM tblbolboleta bol
								LEFT JOIN tblbtaboletatalonario bta
								ON bol.BtaId = bta.BtaId
							WHERE bol.OvvId = ovv.OvvId
							AND bol.BolEstado <> 6 
							AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
								)
							LIMIT 1
						),"")
						
						
						
					 )
				
				
				)
				
				
				 )   >=  '.$oTiempoTranscurrido.' '; 
				
		}
		
		
		
		
		
		
		
	
			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				ovv.OvvId,	
			
							
				ovv.PerId,
ovv.PerIdFirmante,
				ovv.CliId,
				ovv.NpaId,
				
				DATE_FORMAT(ovv.OvvFecha, "%d/%m/%Y") AS "NOvvFecha",
				DATE_FORMAT(ovv.OvvFechaEntrega, "%d/%m/%Y") AS "NOvvFechaEntrega",
				
				DATEDIFF(DATE(NOW()),ovv.OvvFecha) AS OvvFechaDiaTranscurrido,	
					
					
			DATEDIFF(DATE(NOW()),
			
			
			DATE(
				
				IFNULL(	
			
					(
						SELECT 
						(fac.FacFechaEmision)
						FROM tblfacfactura fac
							LEFT JOIN tblftafacturatalonario fta
							ON fac.FtaId = fta.FtaId
						WHERE fac.OvvId = ovv.OvvId 
						AND fac.FacEstado <> 6 
						AND NOT EXISTS(
										SELECT 	
										ncr.NcrId
										FROM tblncrnotacredito ncr
										WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
										AND ncr.NcrEstado <> 6
										AND ncr.NcrMotivoCodigo<> "04"
										AND ncr.NcrMotivoCodigo<> "05"
										AND ncr.NcrMotivoCodigo<> "09"
										
									) 
						LIMIT 1
					),
					
						IFNULL((
							SELECT 
							(bol.BolFechaEmision)
							FROM tblbolboleta bol
								LEFT JOIN tblbtaboletatalonario bta
								ON bol.BtaId = bta.BtaId
							WHERE bol.OvvId = ovv.OvvId
							AND bol.BolEstado <> 6 
							AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
								)
							LIMIT 1
						),"")
					
					
					)
				
				
				)
				
			) AS OvvFechaDiaTranscurridoFacturacion,	
			
			
			
					
				ovv.CveId,
				
				ovv.MonId,
				ovv.OvvTipoCambio,
				
				ovv.MpaId,
				
				ovv.OvvIncluyeImpuesto,
				ovv.OvvPorcentajeImpuestoVenta,
		
				ovv.OvvObservacion,

				ovv.OvvTelefono,
				ovv.OvvCelular,
				ovv.OvvDireccion,
				ovv.OvvEmail,
		
				ovv.VveId,
				ovv.OvvAnoModelo,
				ovv.OvvAnoFabricacion,
				ovv.OvvColor,
				
				ovv.OvvVehiculoMarca,
		ovv.OvvVehiculoModelo,
		ovv.OvvVehiculoVersion,
		ovv.OvvGLP,
		
				ovv.EinId,
				
				ovv.OvvPrecio,
				ovv.OvvDescuento,
				ovv.OvvDescuentoGerencia,
				
				ovv.OvvSubTotal,
				ovv.OvvImpuesto,				
				ovv.OvvTotal,

				ovv.OvvCondicionVentaOtro,

				ovv.OvvObsequioOtro,
				
				ovv.OvvComprobanteVenta,
				
				ovv.OvvNota,
				ovv.OvvPlaca,
				ovv.OvvTarjeta,
				
				ovv.OvvAprobacion1,
				ovv.OvvAprobacion2,
				ovv.OvvAprobacion3,
				
					ovv.OvvReferencia,
		ovv.OvvTipoPlaca,
		ovv.OvvGLPModeloTanque,
		
				ovv.OvvInmediata,
				ovv.OvvEstado,
				
			
				DATE_FORMAT(ovv.OvvTiempoSolicitudEnvio, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoSolicitudEnvio",
		DATE_FORMAT(ovv.OvvTiempoAprobacion1Envio, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoAprobacion1Envio",
		DATE_FORMAT(ovv.OvvTiempoAprobacion2Envio, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoAprobacion2Envio",
		DATE_FORMAT(ovv.OvvTiempoEmitido, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoEmitido",
		DATE_FORMAT(ovv.OvvTiempoAnulado, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoAnulado",
		DATE_FORMAT(ovv.OvvTiempoPorFacturar, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoPorFacturar",
		DATE_FORMAT(ovv.OvvTiempoFacturado, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoFacturado",
		
		
		ovv.OvvObservacionAsignacion,
		
				DATE_FORMAT(ovv.OvvTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoCreacion",
	        	DATE_FORMAT(ovv.OvvTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoModificacion",
				
				
				DATE_FORMAT(ovv.OvvActaEntregaFecha, "%d/%m/%Y") AS "NOvvActaEntregaFecha",
DATE_FORMAT(ovv.OvvActaEntregaHora, "%H:%i") AS "NOvvActaEntregaHora",
				ovv.OvvActaEntregaDescripcion,
				ovv.OvvFotoActaEntrega,
					
				CASE
				WHEN EXISTS (
					SELECT 
					fac.FacId
					FROM tblfacfactura fac
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS OvvFactura,
		
		
							
				CASE
				WHEN EXISTS (
					SELECT 
					bol.BolId
					FROM tblbolboleta bol
					WHERE bol.OvvId = ovv.OvvId 
					AND bol.BolEstado <> 6
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS OvvBoleta,




			(
					SELECT 
					CONCAT(fac.FacId)
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6

								AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					
					
					
					LIMIT 1
				)  AS FacId,
				
				(
					SELECT 
					CONCAT(fac.FtaId)
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6 
					
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					LIMIT 1
				)  AS FtaId,
		
		
								
				(
					SELECT 
					CONCAT(bol.BolId)
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
				) AS BolId,	
				
				(
					SELECT 
					CONCAT(bol.BtaId)
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
				) AS BtaId,	
				
				
				
				
				
				(
					SELECT 
					CONCAT(fta.FtaNumero,"-",fac.FacId)
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6 
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
								
					LIMIT 1
				)  AS OvvFacturaNumero,
		
		
								
				(
					SELECT 
					CONCAT(bta.BtaNumero,"-",bol.BolId)
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
						
					LIMIT 1
				) AS OvvBoletaNumero,	
				
				


				(
					SELECT 
					DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y")
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6 
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					LIMIT 1
				)  AS OvvFacturaFecha,
				
		
				(
					SELECT 
					DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y")
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
						
					 LIMIT 1
				) AS OvvBoletaFecha,	
				




				(
					SELECT 
					fac.FacTipoCambio
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6 
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					LIMIT 1
				)  AS OvvFacturaTipoCambio,

				(
					SELECT 
					bol.BolTipoCambio
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
						
					 LIMIT 1
				) AS OvvBoletaTipoCambio,
				
				


				(
					SELECT 
					fac.FacTotal
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6 
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					LIMIT 1
				)  AS OvvFacturaTotal,

				(
					SELECT 
					bol.BolTotal
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
						
					LIMIT 1
				) AS OvvBoletaTotal,
				
				
						
						
				(
					SELECT 
					fac.FacEstado
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					
					 LIMIT 1
				)  AS OvvFacturaEstado,

				(
					SELECT 
					bol.BolEstado
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					 LIMIT 1
				) AS OvvBoletaEstado,
				
				
				
								
	
				cli.TdoId,
				CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.CliNumeroDocumento,
				cli.CliTelefono,
				cli.CliCelular,
				cli.CliEmail,
				
				cli.CliDireccion,
				cli.CliDepartamento,
				cli.CliProvincia,
				cli.CliDistrito,
				cli.CliPais,
				cli.CliActividadEconomica,
				
				cli.CliRepresentanteNombre,
				cli.CliRepresentanteNumeroDocumento,
				cli.CliRepresentanteNacionalidad,
				cli.CliRepresentanteActividadEconomica,
				
				cli.CliSexo,
				cli.CliEstadoCivil,
				
				
				(
					SELECT 
					COUNT(ovp.OvpId) 
					FROM tblovpordenventavehiculopropietario ovp 
					WHERE ovp.OvvId = ovv.OvvId
				
				) AS OvvPropietarioCantidad,
				
				

		(SELECT 
		
		(pag.PagMonto)
		
		FROM tblpagpago pag
		WHERE 
			
			EXISTS(
				SELECT
				pac.PacId
				FROM tblpacpagocomprobante pac
					WHERE pac.PagId = pag.PagId
					AND pac.OvvId = ovv.OvvId
					AND pag.PagEstado = 3
					
			)
			
		ORDER BY pag.PagId ASC LIMIT 1
		) AS OvvAbonoInicial,
		
		
		(
			IF(IFNULL((SELECT 			
			SUM(pag.PagMonto)			
			FROM tblpagpago pag
			WHERE 
				
				EXISTS(
					SELECT
					pac.PacId
					FROM tblpacpagocomprobante pac
						WHERE pac.PagId = pag.PagId
						AND pac.OvvId = ovv.OvvId
						AND pag.PagEstado = 3
				)
				
			ORDER BY pag.PagId ASC LIMIT 1
			),0)>=ovv.OvvTotal,"Si","No")
			
		) AS OvvCancelado,
		
		
		
		(
					IF(
					
					IFNULL((SELECT 
					
					SUM(pag.PagMonto)
					
					FROM tblpagpago pag
					WHERE 
						
						EXISTS(
							SELECT
							pac.PacId
							FROM tblpacpagocomprobante pac
								WHERE pac.PagId = pag.PagId
								AND pac.OvvId = ovv.OvvId
								AND pag.PagEstado = 3
								
						)
						
					ORDER BY pag.PagId ASC LIMIT 1
					),0) 
					
					+
					
					IFNULL(
					(
					SELECT
					SUM(fac.FacTotal)
					FROM tblfacfactura fac
					WHERE fac.OvvId = ovv.OvvId
					AND fac.FacEstado <>  6
					)
					,0)
					
					+
					
					IFNULL(
					(
					SELECT
					SUM(bol.BolTotal)
					FROM tblbolboleta bol
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <>  6
					)
					,0)
					
					 >=  ovv.OvvTotal,"Si","No")
					
				) AS OvvCancelado2,
				
		
		
		
		
		(SELECT 
		
		(pag.FpaId)
		
		FROM tblpagpago pag
		WHERE 
			
			EXISTS(
				SELECT
				pac.PacId
				FROM tblpacpagocomprobante pac
					WHERE pac.PagId = pag.PagId
					AND pac.OvvId = ovv.OvvId
			)
			
		ORDER BY pag.PagId ASC LIMIT 1
		) AS FpaId,
		
		
			(SELECT 
		
		(fpa.FpaAbreviatura)
		
		FROM tblpagpago pag
			LEFT JOIN tblfpaformapago fpa
			ON pag.FpaId = fpa.FpaId
		WHERE 
			
			EXISTS(
				SELECT
				pac.PacId
				FROM tblpacpagocomprobante pac
					WHERE pac.PagId = pag.PagId
					AND pac.OvvId = ovv.OvvId
			)
			
		ORDER BY pag.PagId ASC LIMIT 1
		) AS FpaAbreviatura,
		
		
				CASE
				WHEN EXISTS (
					SELECT 
					pac.PacId
					FROM tblpacpagocomprobante pac 
						LEFT JOIN tblpagpago pag
						ON pac.PagId = pag.PagId
					
					WHERE pac.OvvId = ovv.OvvId LIMIT 1
				
				) THEN "Si"
				ELSE "No"
				END AS OvvPago,
				
					
				
				tdo.TdoNombre,
				
				mon.MonNombre,
				mon.MonSimbolo,

				vmo.VmaId,
				vma.VmaNombre,
		
				vve.VmoId,
				vmo.VmoNombre,
				
				vmo.VtiId,
				vti.VtiNombre,
				
				vve.VveNombre,
				
				vve.VveFoto,
				
				lti.LtiNombre,
				
				ein.EinVIN,
				
				
				per.PerAbreviatura,
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				mpa.MpaNombre,
				mpa.MpaAbreviatura,
				
				suc.SucNombre,
				
				ein.EinNumeroMotor,
				ein.EinAnoFabricacion,
				ein.EinAnoModelo,
				ein.EinColor
				
				FROM tblovvordenventavehiculo ovv
				
					LEFT JOIN tblmpamodalidadpago mpa
					ON ovv.MpaId = mpa.MpaId
						
						LEFT JOIN tblclicliente cli
						ON ovv.CliId = cli.CliId
						
						LEFT JOIN tbltdotipodocumento tdo
						ON cli.TdoId = tdo.TdoId
						
							LEFT JOIN tbllticlientetipo lti
							ON cli.LtiId = lti.LtiId
							
							LEFT JOIN tbleinvehiculoingreso ein
							ON ovv.EinId = ein.EinId
							
							LEFT JOIN tblmonmoneda mon
							ON ovv.MonId = mon.MonId

							LEFT JOIN tblvvevehiculoversion vve
							ON ovv.VveId = vve.VveId
								LEFT JOIN tblvmovehiculomodelo vmo
								ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvtivehiculotipo vti
							ON vmo.VtiId = vti.VtiId	
									LEFT JOIN tblvmavehiculomarca vma
									ON vmo.VmaId = vma.VmaId
									
									
									LEFT JOIN tblperpersonal per
									ON ovv.PerId = per.PerId
									
									LEFT JOIN tblsucsucursal suc
									ON ovv.SucId = suc.SucId
									
				WHERE 1 = 1 '.$filtrar.$fecha.$tipo.$sucursal.$taentrega.$ttrasncurrido.$tcomprobante.$aprobacion1.$aprobacion2.$aprobacion3.$stipo.$estado.$moneda.$personal.$cliente.$cvehiculo.$ccotizacion.$vingreso.$estado.$facturable.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsOrdenVentaVehiculo = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$OrdenVentaVehiculo = new $InsOrdenVentaVehiculo();
                    $OrdenVentaVehiculo->OvvId = $fila['OvvId'];
					$OrdenVentaVehiculo->SucId = $fila['SucId'];
					
					
					$OrdenVentaVehiculo->PerId = $fila['PerId'];	
					$OrdenVentaVehiculo->PerIdFirmante = $fila['PerIdFirmante'];	
					
					
					$OrdenVentaVehiculo->CliId = $fila['CliId'];
					$OrdenVentaVehiculo->NpaId = $fila['NpaId'];
					$OrdenVentaVehiculo->OvvFecha = $fila['NOvvFecha'];
					$OrdenVentaVehiculo->OvvFechaEntrega = $fila['NOvvFechaEntrega'];
					$OrdenVentaVehiculo->OvvFechaDiaTranscurrido = $fila['OvvFechaDiaTranscurrido'];
					$OrdenVentaVehiculo->OvvFechaDiaTranscurridoFacturacion = $fila['OvvFechaDiaTranscurridoFacturacion'];
					
					
					$OrdenVentaVehiculo->CveId = $fila['CveId'];
					
					$OrdenVentaVehiculo->MonId = $fila['MonId'];
					$OrdenVentaVehiculo->OvvTipoCambio = $fila['OvvTipoCambio'];
					
					$OrdenVentaVehiculo->MpaId = $fila['MpaId'];
					
					$OrdenVentaVehiculo->OvvIncluyeImpuesto = $fila['OvvIncluyeImpuesto'];
					$OrdenVentaVehiculo->OvvPorcentajeImpuestoVenta = $fila['OvvPorcentajeImpuestoVenta'];					
					$OrdenVentaVehiculo->OvvObservacion = $fila['OvvObservacion'];
					
					$OrdenVentaVehiculo->OvvTelefono = $fila['OvvTelefono'];
					$OrdenVentaVehiculo->OvvCelular = $fila['OvvCelular'];
					$OrdenVentaVehiculo->OvvDireccion = $fila['OvvDireccion'];
					$OrdenVentaVehiculo->OvvEmail = $fila['OvvEmail'];
					
					
					
					$OrdenVentaVehiculo->CliDireccion = $fila['CliDireccion'];
					$OrdenVentaVehiculo->CliDepartamento = $fila['CliDepartamento'];
					$OrdenVentaVehiculo->CliProvincia = $fila['CliProvincia'];
					$OrdenVentaVehiculo->CliDistrito = $fila['CliDistrito'];
					$OrdenVentaVehiculo->CliPais = $fila['CliPais'];
					$OrdenVentaVehiculo->CliActividadEconomica = $fila['CliActividadEconomica'];
					
					$OrdenVentaVehiculo->CliSexo = $fila['CliSexo'];
					$OrdenVentaVehiculo->CliEstadoCivil = $fila['CliEstadoCivil'];
					
				
					$OrdenVentaVehiculo->CliRepresentanteNombre = $fila['CliRepresentanteNombre'];
					$OrdenVentaVehiculo->CliRepresentanteNumeroDocumento = $fila['CliRepresentanteNumeroDocumento'];
					$OrdenVentaVehiculo->CliRepresentanteNacionalidad = $fila['CliRepresentanteNacionalidad'];
					$OrdenVentaVehiculo->CliRepresentanteActividadEconomica = $fila['CliRepresentanteActividadEconomica'];

				
				
				
					$OrdenVentaVehiculo->VveId = $fila['VveId'];
					$OrdenVentaVehiculo->OvvAnoModelo = $fila['OvvAnoModelo'];	
					$OrdenVentaVehiculo->OvvAnoFabricacion = $fila['OvvAnoFabricacion'];
					
					
					$OrdenVentaVehiculo->OvvColor = $fila['OvvColor'];	
					
					$OrdenVentaVehiculo->OvvVehiculoMarca = $fila['OvvVehiculoMarca'];	
					$OrdenVentaVehiculo->OvvVehiculoModelo = $fila['OvvVehiculoModelo'];	
					$OrdenVentaVehiculo->OvvVehiculoVersion = $fila['OvvVehiculoVersion'];	
					$OrdenVentaVehiculo->OvvGLP = $fila['OvvGLP'];	
					
					
					$OrdenVentaVehiculo->EinId = $fila['EinId'];			

					$OrdenVentaVehiculo->OvvPrecio = $fila['OvvPrecio'];			
					$OrdenVentaVehiculo->OvvDescuento = $fila['OvvDescuento'];			
					$OrdenVentaVehiculo->OvvDescuentoGerencia = $fila['OvvDescuentoGerencia'];	
				
				
					$OrdenVentaVehiculo->OvvSubTotal = $fila['OvvSubTotal'];			
					$OrdenVentaVehiculo->OvvImpuesto = $fila['OvvImpuesto'];
					$OrdenVentaVehiculo->OvvTotal = $fila['OvvTotal'];
					
					$OrdenVentaVehiculo->OvvCondicionVentaOtro = $fila['OvvCondicionVentaOtro'];
					$OrdenVentaVehiculo->OvvObsequioOtro = $fila['OvvObsequioOtro'];
										
					$OrdenVentaVehiculo->OvvComprobanteVenta = $fila['OvvComprobanteVenta'];
										
					$OrdenVentaVehiculo->OvvFactura = $fila['OvvFactura'];
					$OrdenVentaVehiculo->OvvBoleta = $fila['OvvBoleta'];
					
					$OrdenVentaVehiculo->FacId = $fila['FacId'];
					$OrdenVentaVehiculo->FtaId = $fila['FtaId'];
					
					$OrdenVentaVehiculo->BolId = $fila['BolId'];
					$OrdenVentaVehiculo->BtaId = $fila['BtaId'];
					
					$OrdenVentaVehiculo->OvvBoleta = $fila['OvvBoleta'];
					$OrdenVentaVehiculo->OvvBoleta = $fila['OvvBoleta'];
					
					$OrdenVentaVehiculo->OvvFacturaNumero = $fila['OvvFacturaNumero'];
					$OrdenVentaVehiculo->OvvBoletaNumero = $fila['OvvBoletaNumero'];
					
					$OrdenVentaVehiculo->OvvFacturaFecha = $fila['OvvFacturaFecha'];
					$OrdenVentaVehiculo->OvvBoletaFecha = $fila['OvvBoletaFecha'];

					$OrdenVentaVehiculo->OvvFacturaTotal = $fila['OvvFacturaTotal'];
					$OrdenVentaVehiculo->OvvBoletaTotal = $fila['OvvBoletaTotal'];
					
					$OrdenVentaVehiculo->OvvFacturaEstado = $fila['OvvFacturaEstado'];
					$OrdenVentaVehiculo->OvvBoletaEstado = $fila['OvvBoletaEstado'];	
					
				
				
				
					$OrdenVentaVehiculo->OvvFacturaTipoCambio = $fila['OvvFacturaTipoCambio'];
					$OrdenVentaVehiculo->OvvBoletaTipoCambio = $fila['OvvBoletaTipoCambio'];				
					
					
					$OrdenVentaVehiculo->OvvNota = $fila['OvvNota'];
					$OrdenVentaVehiculo->OvvPlaca = $fila['OvvPlaca'];
					$OrdenVentaVehiculo->OvvTarjeta = $fila['OvvTarjeta'];
					
					$OrdenVentaVehiculo->OvvAprobacion1 = $fila['OvvAprobacion1'];
					$OrdenVentaVehiculo->OvvAprobacion2 = $fila['OvvAprobacion2'];
					$OrdenVentaVehiculo->OvvAprobacion3 = $fila['OvvAprobacion3'];
					
					$OrdenVentaVehiculo->OvvReferencia = $fila['OvvReferencia'];
					$OrdenVentaVehiculo->OvvTipoPlaca = $fila['OvvTipoPlaca'];
					$OrdenVentaVehiculo->OvvGLPModeloTanque = $fila['OvvGLPModeloTanque'];
					
				
					$OrdenVentaVehiculo->OvvInmediata = $fila['OvvInmediata'];
					$OrdenVentaVehiculo->OvvEstado = $fila['OvvEstado'];
			
					
					$OrdenVentaVehiculo->OvvTiempoSolicitudEnvio = $fila['NOvvTiempoSolicitudEnvio']; 
					$OrdenVentaVehiculo->OvvTiempoAprobacion1Envio = $fila['NOvvTiempoAprobacion1Envio'];
					$OrdenVentaVehiculo->OvvTiempoAprobacion2Envio = $fila['NOvvTiempoAprobacion2Envio'];
					$OrdenVentaVehiculo->OvvTiempoEmitido = $fila['NOvvTiempoEmitido'];
					$OrdenVentaVehiculo->OvvTiempoAnulado = $fila['NOvvTiempoAnulado'];
					$OrdenVentaVehiculo->OvvTiempoPorFacturar = $fila['NOvvTiempoPorFacturar'];
					$OrdenVentaVehiculo->OvvTiempoFacturado = $fila['NOvvTiempoFacturado'];
					
					$OrdenVentaVehiculo->OvvObservacionAsignacion = $fila['OvvObservacionAsignacion'];
					
					$OrdenVentaVehiculo->OvvTiempoCreacion = $fila['NOvvTiempoCreacion'];  
					$OrdenVentaVehiculo->OvvTiempoModificacion = $fila['NOvvTiempoModificacion']; 
					
					$OrdenVentaVehiculo->OvvActaEntregaFecha = $fila['NOvvActaEntregaFecha']; 
					$OrdenVentaVehiculo->OvvActaEntregaHora = $fila['NOvvActaEntregaHora']; 
				
					$OrdenVentaVehiculo->OvvActaEntregaDescripcion = $fila['OvvActaEntregaDescripcion']; 
					$OrdenVentaVehiculo->OvvFotoActaEntrega = $fila['OvvFotoActaEntrega']; 
					
					$OrdenVentaVehiculo->TdoId = $fila['TdoId']; 
					$OrdenVentaVehiculo->CliNombreCompleto = $fila['CliNombreCompleto']; 
					$OrdenVentaVehiculo->CliNombre = $fila['CliNombre']; 
					$OrdenVentaVehiculo->CliApellidoPaterno = $fila['CliApellidoPaterno']; 
					$OrdenVentaVehiculo->CliApellidoMaterno = $fila['CliApellidoMaterno']; 
					$OrdenVentaVehiculo->CliNumeroDocumento = $fila['CliNumeroDocumento']; 
					
					$OrdenVentaVehiculo->CliTelefono = $fila['CliTelefono']; 
					$OrdenVentaVehiculo->CliCelular = $fila['CliCelular']; 
					$OrdenVentaVehiculo->CliEmail = $fila['CliEmail']; 

					$OrdenVentaVehiculo->OvvPropietarioCantidad = $fila['OvvPropietarioCantidad']; 
					
					$OrdenVentaVehiculo->OvvAbonoInicial = $fila['OvvAbonoInicial'];
					$OrdenVentaVehiculo->OvvCancelado = $fila['OvvCancelado'];
					$OrdenVentaVehiculo->OvvCancelado2 = $fila['OvvCancelado2'];
					
					
					$OrdenVentaVehiculo->FpaId = $fila['FpaId']; 
					$OrdenVentaVehiculo->FpaAbreviatura = $fila['FpaAbreviatura']; 
					$OrdenVentaVehiculo->OvvPago = $fila['OvvPago']; 
				
					$OrdenVentaVehiculo->TdoNombre = $fila['TdoNombre']; 
					
					$OrdenVentaVehiculo->MonNombre = $fila['MonNombre']; 
					$OrdenVentaVehiculo->MonSimbolo = $fila['MonSimbolo']; 
				
		
					$OrdenVentaVehiculo->VmaId = $fila['VmaId'];
					$OrdenVentaVehiculo->VmaNombre = $fila['VmaNombre'];
					
					$OrdenVentaVehiculo->VmoId = $fila['VmoId'];
					$OrdenVentaVehiculo->VmoNombre = $fila['VmoNombre'];
					
					$OrdenVentaVehiculo->VveId = $fila['VveId'];
					$OrdenVentaVehiculo->VveNombre = $fila['VveNombre'];
					
					$OrdenVentaVehiculo->VveFoto = $fila['VveFoto'];
					
					$OrdenVentaVehiculo->LtiNombre = $fila['LtiNombre'];
					
					$OrdenVentaVehiculo->EinVIN = $fila['EinVIN'];
					
					$OrdenVentaVehiculo->PerAbreviatura = $fila['PerAbreviatura'];
					$OrdenVentaVehiculo->PerNombre = $fila['PerNombre'];
					$OrdenVentaVehiculo->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$OrdenVentaVehiculo->PerApellidoMaterno = $fila['PerApellidoMaterno'];

					$OrdenVentaVehiculo->MpaNombre = $fila['MpaNombre'];
					$OrdenVentaVehiculo->MpaAbreviatura = $fila['MpaAbreviatura'];					

					$OrdenVentaVehiculo->SucNombre = $fila['SucNombre'];
					
					$OrdenVentaVehiculo->EinNumeroMotor = $fila['EinNumeroMotor'];
					$OrdenVentaVehiculo->EinAnoFabricacion = $fila['EinAnoFabricacion'];
					$OrdenVentaVehiculo->EinAnoModelo = $fila['EinAnoModelo'];
					$OrdenVentaVehiculo->EinColor = $fila['EinColor'];

					switch($OrdenVentaVehiculo->OvvEstado){
					
					  case 1:
						  $Estado = "Pendiente";
					  break;
					
					  case 3:
						  $Estado = "Listo";
					  break;	
						
					case 4:
							$Estado = "Por Facturar";
					break;
					
					 case 5:
				 		 $Estado = "Facturado";			  	
					  break;
					
					 case 6:
						  $Estado = "Anulado";			  	
					  break;
					
					  default:
						  $Estado = "";
					  break;					
					
					}
					
			switch($OrdenVentaVehiculo->OvvEstado){
				
				case 1:
					$OrdenVentaVehiculo->OvvEstadoIcono = '<img width="15" height="15" alt="[Pendiente]" title="Pendiente" src="imagenes/estado/pendiente.gif" />';
				break;
				
				case 3:
					$OrdenVentaVehiculo->OvvEstadoIcono = '<img width="15" height="15" alt="[Emitido]" title="Emitido" src="imagenes/estado/realizado.gif" />';
				break;	
				
				case 4:
					$OrdenVentaVehiculo->OvvEstadoIcono = '<img width="15" height="15" alt="[Emitido]" title="Emitido" src="imagenes/estado/por_facturar.png" />';
				break;	
				
				case 5:
					$OrdenVentaVehiculo->OvvEstadoIcono = '<img width="15" height="15" alt="[Facturado]" title="Facturado" src="imagenes/estado/facturado.png" />';
				break;
				
				case 6:
					$OrdenVentaVehiculo->OvvEstadoIcono = '<img width="15" height="15" alt="[Anulado]" title="Anulado" src="imagenes/estado/anulado.png" />';
				break;

				default:
					$OrdenVentaVehiculo->OvvEstadoIcono = "";
				break;
				
			}
			
			
			
					
					$OrdenVentaVehiculo->OvvEstadoDescripcion = $Estado;
			
                    $OrdenVentaVehiculo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $OrdenVentaVehiculo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}






public function MtdObtenerReporteOrdenVentaVehiculoEntregas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL,$oIncluirCSI=NULL,$oDiasTranscurridosTipo="Mayor",$oDiasTranscurridos=0,$oFecha="IFNULL(ovv.OvvActaEntregaFecha,ovv.OvvActaEntregaFechaPDS)") {

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
		
		if(!empty($oVehiculoMarca)){
				$vmarca = ' AND (vmo.VmaId) = "'.$oVehiculoMarca.'"';		
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
		
		if(!empty($oSucursal)){
			$sucursal = ' AND (ovv.SucId) = "'.$oSucursal.'"';		
		}	
		
		
			if(!empty($oDiasTranscurridos)){
				
				switch($oDiasTranscurridosTipo){
					
					case "Mayor":
						$dtranscurrido = ' AND DATEDIFF(DATE("'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).'"), DATE('.$oFecha.')) > '.$oDiasTranscurridos.' ';		
					break;
					
					case "Menor":
						$dtranscurrido = ' AND DATEDIFF(DATE("'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).'"), DATE('.$oFecha.')) < '.$oDiasTranscurridos.' ';	
					break;
					
					case "MayorIgual":
						$dtranscurrido = ' AND DATEDIFF(DATE("'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).'"), DATE('.$oFecha.')) >= '.$oDiasTranscurridos.' ';	
					break;
					
					case "MenorIgual":
						$dtranscurrido = ' AND DATEDIFF(DATE("'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).'"), DATE('.$oFecha.')) <= '.$oDiasTranscurridos.' ';	
					break;
					
					case "Igual":
						$dtranscurrido = ' AND DATEDIFF(DATE("'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).'"), DATE('.$oFecha.')) = '.$oDiasTranscurridos.' ';	
					break;
					
					default:
						$dtranscurrido = ' AND DATEDIFF(DATE("'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).'"), DATE('.$oFecha.')) > '.$oDiasTranscurridos.' ';		
					
					break;
					
				}
				
				
				
				
			}	
			
				if($oIncluirCSI){
				
				$icsi = ' 	
					AND cli.CliCSIIncluir = "'.$oIncluirCSI.'"
				';		
				
			}	

			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				
				ovv.OvvId,	
			
				ovv.PerId,
				ovv.CliId,

				DATE_FORMAT(ovv.OvvFecha, "%d/%m/%Y") AS "NOvvFecha",
				DATE_FORMAT(ovv.OvvFechaEntrega, "%d/%m/%Y") AS "NOvvFechaEntrega2",
				
			
				DATE_FORMAT(IFNULL(ovv.OvvActaEntregaFecha,ovv.OvvActaEntregaFechaPDS), "%d/%m/%Y") 	 AS "NOvvFechaEntrega",
				
				DATEDIFF(DATE("'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).'"),IFNULL(ovv.OvvActaEntregaFecha,ovv.OvvActaEntregaFechaPDS)) AS OvvDiaTranscurridoEntrega,
				
				
				
				
				ovv.CveId,
				
				ovv.MonId,
				ovv.OvvTipoCambio,
				
				ovv.MpaId,
				
				ovv.OvvIncluyeImpuesto,
				ovv.OvvPorcentajeImpuestoVenta,
		
				ovv.OvvObservacion,

				ovv.OvvTelefono,
				ovv.OvvCelular,
				ovv.OvvDireccion,
				ovv.OvvEmail,
		
				ovv.VveId,
				ovv.OvvAnoModelo,
				ovv.OvvAnoFabricacion,
				ovv.OvvColor,
				ovv.EinId,
				
				ovv.OvvPrecio,
				ovv.OvvDescuento,
				ovv.OvvDescuentoGerencia,
				
				ovv.OvvSubTotal,
				ovv.OvvImpuesto,				
				ovv.OvvTotal,

				ovv.OvvCondicionVentaOtro,

				ovv.OvvObsequioOtro,
				
				ovv.OvvComprobanteVenta,
				
				ovv.OvvNota,
				ovv.OvvPlaca,
				ovv.OvvEstado,
				DATE_FORMAT(ovv.OvvTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoCreacion",
	        	DATE_FORMAT(ovv.OvvTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoModificacion",
				
				
				DATE_FORMAT(ovv.OvvActaEntregaFecha, "%d/%m/%Y") AS "NOvvActaEntregaFecha",
				DATE_FORMAT(ovv.OvvActaEntregaFechaPDS, "%d/%m/%Y") AS "NOvvActaEntregaFechaPDS",
				
				
				
				ovv.OvvActaEntregaDescripcion,
						
				CASE
				WHEN EXISTS (
					SELECT 
					fac.FacId
					FROM tblfacfactura fac
					WHERE fac.OvvId = ovv.OvvId 
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS OvvFactura,
		
		
							
				CASE
				WHEN EXISTS (
					SELECT 
					bol.BolId
					FROM tblbolboleta bol
					WHERE bol.OvvId = ovv.OvvId 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
						
						
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS OvvBoleta,



				(
					SELECT 
					CONCAT(fta.FtaNumero,"-",fac.FacId)
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6 
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					LIMIT 1
				)  AS OvvFacturaNumero,
		
		
								
				(
					SELECT 

					CONCAT(bta.BtaNumero,"-",bol.BolId)
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
						
					LIMIT 1
				) AS OvvBoletaNumero,	
				
				


				(
					SELECT 
					DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y")
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					LIMIT 1
				)  AS OvvFacturaFecha,
				
		
				(
					SELECT 
					DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y")
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
						
					 LIMIT 1
				) AS OvvBoletaFecha,	
				




				(
					SELECT 
					fac.FacTipoCambio
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					LIMIT 1
				)  AS OvvFacturaTipoCambio,

				(
					SELECT 
					bol.BolTipoCambio
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
				) AS OvvBoletaTipoCambio,
				
				


				(
					SELECT 
					fac.FacTotal
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6 
					
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
								
					LIMIT 1
				)  AS OvvFacturaTotal,

				(
					SELECT 
					bol.BolTotal
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
				) AS OvvBoletaTotal,
				
				
						
						
				(
					SELECT 
					fac.FacEstado
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					
					 LIMIT 1
				)  AS OvvFacturaEstado,

				(
					SELECT 
					bol.BolEstado
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					
					 LIMIT 1
				) AS OvvBoletaEstado,
				
				
				
								
	
				cli.TdoId,
				CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.CliNumeroDocumento,
				cli.CliTelefono,
				cli.CliCelular,
				cli.CliEmail,
				
				cli.CliContactoEmail1,
				cli.CliContactoEmail2,
				cli.CliContactoEmail3,
				
				cli.CliEmailFacturacion,
				
				cli.CliDireccion,
				cli.CliDepartamento,
				cli.CliProvincia,
				cli.CliDistrito,
				cli.CliPais,
				cli.CliActividadEconomica,
				
				cli.CliRepresentanteNombre,
				cli.CliRepresentanteNumeroDocumento,
				cli.CliRepresentanteNacionalidad,
				cli.CliRepresentanteActividadEconomica,
				
				cli.CliSexo,
				cli.CliEstadoCivil,
				
				
				(
					SELECT 
					COUNT(ovp.OvpId) 
					FROM tblovpordenventavehiculopropietario ovp 
					WHERE ovp.OvvId = ovv.OvvId
				
				) AS OvvPropietarioCantidad,
				
				

		(SELECT 
		
		(pag.PagMonto)
		
		FROM tblpagpago pag
		WHERE 
			
			EXISTS(
				SELECT
				pac.PacId
				FROM tblpacpagocomprobante pac
					WHERE pac.PagId = pag.PagId
					AND pac.OvvId = ovv.OvvId
					AND pag.PagEstado = 3
					
			)
			
		ORDER BY pag.PagId ASC LIMIT 1
		) AS OvvAbonoInicial,
		
		
		(
			IF(IFNULL((SELECT 			
			SUM(pag.PagMonto)			
			FROM tblpagpago pag
			WHERE 
				
				EXISTS(
					SELECT
					pac.PacId
					FROM tblpacpagocomprobante pac
						WHERE pac.PagId = pag.PagId
						AND pac.OvvId = ovv.OvvId
						AND pag.PagEstado = 3
				)
				
			ORDER BY pag.PagId ASC LIMIT 1
			),0)>=ovv.OvvTotal,"Si","No")
			
		) AS OvvCancelado,
		
		
		
		(
					IF(
					
					IFNULL((SELECT 
					
					SUM(pag.PagMonto)
					
					FROM tblpagpago pag
					WHERE 
						
						EXISTS(
							SELECT
							pac.PacId
							FROM tblpacpagocomprobante pac
								WHERE pac.PagId = pag.PagId
								AND pac.OvvId = ovv.OvvId
								AND pag.PagEstado = 3
								
						)
						
					ORDER BY pag.PagId ASC LIMIT 1
					),0) 
					
					+
					
					IFNULL(
					(
					SELECT
					SUM(fac.FacTotal)
					FROM tblfacfactura fac
					WHERE fac.OvvId = ovv.OvvId
					AND fac.FacEstado <>  6
					)
					,0)
					
					+
					
					IFNULL(
					(
					SELECT
					SUM(bol.BolTotal)
					FROM tblbolboleta bol
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <>  6
					)
					,0)
					
					 >=  ovv.OvvTotal,"Si","No")
					
				) AS OvvCancelado2,
				
		
		
		
		
		(SELECT 
		
		(pag.FpaId)
		
		FROM tblpagpago pag
		WHERE 
			
			EXISTS(
				SELECT
				pac.PacId
				FROM tblpacpagocomprobante pac
					WHERE pac.PagId = pag.PagId
					AND pac.OvvId = ovv.OvvId
			)
			
		ORDER BY pag.PagId ASC LIMIT 1
		) AS FpaId,
		
		
			(SELECT 
		
		(fpa.FpaAbreviatura)
		
		FROM tblpagpago pag
			LEFT JOIN tblfpaformapago fpa
			ON pag.FpaId = fpa.FpaId
		WHERE 
			
			EXISTS(
				SELECT
				pac.PacId
				FROM tblpacpagocomprobante pac
					WHERE pac.PagId = pag.PagId
					AND pac.OvvId = ovv.OvvId
			)
			
		ORDER BY pag.PagId ASC LIMIT 1
		) AS FpaAbreviatura,
		
		
				CASE
				WHEN EXISTS (
					SELECT 
					pac.PacId
					FROM tblpacpagocomprobante pac 
						LEFT JOIN tblpagpago pag
						ON pac.PagId = pag.PagId
					
					WHERE pac.OvvId = ovv.OvvId LIMIT 1
				
				) THEN "Si"
				ELSE "No"
				END AS OvvPago,
				
					
				
				tdo.TdoNombre,
				
				mon.MonNombre,
				mon.MonSimbolo,

				vmo.VmaId,
				vma.VmaNombre,
		
				vve.VmoId,
				vmo.VmoNombre,
				
				vmo.VtiId,
				vti.VtiNombre,
				
				vve.VveNombre,
				
				vve.VveFoto,
				
				lti.LtiNombre,
				
				ein.EinVIN,
				
				
				per.PerAbreviatura,
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				mpa.MpaNombre,
				mpa.MpaAbreviatura,
				
				suc.SucNombre,
				
				ein.EinNumeroMotor,
				ein.EinAnoFabricacion,
				ein.EinAnoModelo,
				ein.EinColor
				
				FROM tblovvordenventavehiculo ovv
				
					LEFT JOIN tblmpamodalidadpago mpa
					ON ovv.MpaId = mpa.MpaId
						
						LEFT JOIN tblclicliente cli
						ON ovv.CliId = cli.CliId
						
						LEFT JOIN tbltdotipodocumento tdo
						ON cli.TdoId = tdo.TdoId
						
							LEFT JOIN tbllticlientetipo lti
							ON cli.LtiId = lti.LtiId
							
							LEFT JOIN tbleinvehiculoingreso ein
							ON ovv.EinId = ein.EinId
							
							LEFT JOIN tblmonmoneda mon
							ON ovv.MonId = mon.MonId

							LEFT JOIN tblvvevehiculoversion vve
							ON ovv.VveId = vve.VveId
								LEFT JOIN tblvmovehiculomodelo vmo
								ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvtivehiculotipo vti
							ON vmo.VtiId = vti.VtiId	
									LEFT JOIN tblvmavehiculomarca vma
									ON vmo.VmaId = vma.VmaId
									
									
									LEFT JOIN tblperpersonal per
									ON ovv.PerId = per.PerId
									
									LEFT JOIN tblsucsucursal suc
									ON ovv.SucId = suc.SucId
									
				WHERE 1 = 1 '.$filtrar.$fecha.$tipo.$sucursal.$taentrega.$ttrasncurrido.$tcomprobante.$aprobacion1.$aprobacion2.$aprobacion3.$stipo.$estado.$moneda.$personal.$cliente.$cvehiculo.$ccotizacion.$vingreso.$estado.$facturable.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsOrdenVentaVehiculo = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$OrdenVentaVehiculo = new $InsOrdenVentaVehiculo();
                    $OrdenVentaVehiculo->OvvId = $fila['OvvId'];
					$OrdenVentaVehiculo->SucId = $fila['SucId'];
					
					
					$OrdenVentaVehiculo->PerId = $fila['PerId'];	
					$OrdenVentaVehiculo->PerIdFirmante = $fila['PerIdFirmante'];	
					
					
					$OrdenVentaVehiculo->CliId = $fila['CliId'];
					$OrdenVentaVehiculo->NpaId = $fila['NpaId'];
					$OrdenVentaVehiculo->OvvFecha = $fila['NOvvFecha'];
					$OrdenVentaVehiculo->OvvFechaEntrega = $fila['NOvvFechaEntrega'];
					$OrdenVentaVehiculo->OvvFechaDiaTranscurrido = $fila['OvvFechaDiaTranscurrido'];
					$OrdenVentaVehiculo->OvvFechaDiaTranscurridoFacturacion = $fila['OvvFechaDiaTranscurridoFacturacion'];
					
					
					$OrdenVentaVehiculo->CveId = $fila['CveId'];
					
					$OrdenVentaVehiculo->MonId = $fila['MonId'];
					$OrdenVentaVehiculo->OvvTipoCambio = $fila['OvvTipoCambio'];
					
					$OrdenVentaVehiculo->MpaId = $fila['MpaId'];
					
					$OrdenVentaVehiculo->OvvIncluyeImpuesto = $fila['OvvIncluyeImpuesto'];
					$OrdenVentaVehiculo->OvvPorcentajeImpuestoVenta = $fila['OvvPorcentajeImpuestoVenta'];					
					$OrdenVentaVehiculo->OvvObservacion = $fila['OvvObservacion'];
					
					$OrdenVentaVehiculo->OvvTelefono = $fila['OvvTelefono'];
					$OrdenVentaVehiculo->OvvCelular = $fila['OvvCelular'];
					$OrdenVentaVehiculo->OvvDireccion = $fila['OvvDireccion'];
					$OrdenVentaVehiculo->OvvEmail = $fila['OvvEmail'];
					
					
					
					$OrdenVentaVehiculo->CliDireccion = $fila['CliDireccion'];
					$OrdenVentaVehiculo->CliDepartamento = $fila['CliDepartamento'];
					$OrdenVentaVehiculo->CliProvincia = $fila['CliProvincia'];
					$OrdenVentaVehiculo->CliDistrito = $fila['CliDistrito'];
					$OrdenVentaVehiculo->CliPais = $fila['CliPais'];
					$OrdenVentaVehiculo->CliActividadEconomica = $fila['CliActividadEconomica'];
					
					$OrdenVentaVehiculo->CliSexo = $fila['CliSexo'];
					$OrdenVentaVehiculo->CliEstadoCivil = $fila['CliEstadoCivil'];
					
				
					$OrdenVentaVehiculo->CliRepresentanteNombre = $fila['CliRepresentanteNombre'];
					$OrdenVentaVehiculo->CliRepresentanteNumeroDocumento = $fila['CliRepresentanteNumeroDocumento'];
					$OrdenVentaVehiculo->CliRepresentanteNacionalidad = $fila['CliRepresentanteNacionalidad'];
					$OrdenVentaVehiculo->CliRepresentanteActividadEconomica = $fila['CliRepresentanteActividadEconomica'];

				
				
				
					$OrdenVentaVehiculo->VveId = $fila['VveId'];
					$OrdenVentaVehiculo->OvvAnoModelo = $fila['OvvAnoModelo'];	
					$OrdenVentaVehiculo->OvvAnoFabricacion = $fila['OvvAnoFabricacion'];
					
					
					$OrdenVentaVehiculo->OvvColor = $fila['OvvColor'];	
					
					$OrdenVentaVehiculo->OvvVehiculoMarca = $fila['OvvVehiculoMarca'];	
					$OrdenVentaVehiculo->OvvVehiculoModelo = $fila['OvvVehiculoModelo'];	
					$OrdenVentaVehiculo->OvvVehiculoVersion = $fila['OvvVehiculoVersion'];	
					$OrdenVentaVehiculo->OvvGLP = $fila['OvvGLP'];	
					
					
					$OrdenVentaVehiculo->EinId = $fila['EinId'];			

					$OrdenVentaVehiculo->OvvPrecio = $fila['OvvPrecio'];			
					$OrdenVentaVehiculo->OvvDescuento = $fila['OvvDescuento'];			
					$OrdenVentaVehiculo->OvvDescuentoGerencia = $fila['OvvDescuentoGerencia'];	
				
				
					$OrdenVentaVehiculo->OvvSubTotal = $fila['OvvSubTotal'];			
					$OrdenVentaVehiculo->OvvImpuesto = $fila['OvvImpuesto'];
					$OrdenVentaVehiculo->OvvTotal = $fila['OvvTotal'];
					
					$OrdenVentaVehiculo->OvvCondicionVentaOtro = $fila['OvvCondicionVentaOtro'];
					$OrdenVentaVehiculo->OvvObsequioOtro = $fila['OvvObsequioOtro'];
										
					$OrdenVentaVehiculo->OvvComprobanteVenta = $fila['OvvComprobanteVenta'];
										
					$OrdenVentaVehiculo->OvvFactura = $fila['OvvFactura'];
					$OrdenVentaVehiculo->OvvBoleta = $fila['OvvBoleta'];
					
					$OrdenVentaVehiculo->FacId = $fila['FacId'];
					$OrdenVentaVehiculo->FtaId = $fila['FtaId'];
					
					$OrdenVentaVehiculo->BolId = $fila['BolId'];
					$OrdenVentaVehiculo->BtaId = $fila['BtaId'];
					
					$OrdenVentaVehiculo->OvvBoleta = $fila['OvvBoleta'];
					$OrdenVentaVehiculo->OvvBoleta = $fila['OvvBoleta'];
					
					$OrdenVentaVehiculo->OvvFacturaNumero = $fila['OvvFacturaNumero'];
					$OrdenVentaVehiculo->OvvBoletaNumero = $fila['OvvBoletaNumero'];
					
					$OrdenVentaVehiculo->OvvFacturaFecha = $fila['OvvFacturaFecha'];
					$OrdenVentaVehiculo->OvvBoletaFecha = $fila['OvvBoletaFecha'];

					$OrdenVentaVehiculo->OvvFacturaTotal = $fila['OvvFacturaTotal'];
					$OrdenVentaVehiculo->OvvBoletaTotal = $fila['OvvBoletaTotal'];
					
					$OrdenVentaVehiculo->OvvFacturaEstado = $fila['OvvFacturaEstado'];
					$OrdenVentaVehiculo->OvvBoletaEstado = $fila['OvvBoletaEstado'];	
					
				
				
				
					$OrdenVentaVehiculo->OvvFacturaTipoCambio = $fila['OvvFacturaTipoCambio'];
					$OrdenVentaVehiculo->OvvBoletaTipoCambio = $fila['OvvBoletaTipoCambio'];				
					
					
					$OrdenVentaVehiculo->OvvNota = $fila['OvvNota'];
					$OrdenVentaVehiculo->OvvPlaca = $fila['OvvPlaca'];
					$OrdenVentaVehiculo->OvvTarjeta = $fila['OvvTarjeta'];
					
					$OrdenVentaVehiculo->OvvAprobacion1 = $fila['OvvAprobacion1'];
					$OrdenVentaVehiculo->OvvAprobacion2 = $fila['OvvAprobacion2'];
					$OrdenVentaVehiculo->OvvAprobacion3 = $fila['OvvAprobacion3'];
					
					$OrdenVentaVehiculo->OvvReferencia = $fila['OvvReferencia'];
					$OrdenVentaVehiculo->OvvTipoPlaca = $fila['OvvTipoPlaca'];
					$OrdenVentaVehiculo->OvvGLPModeloTanque = $fila['OvvGLPModeloTanque'];
					
				
					$OrdenVentaVehiculo->OvvInmediata = $fila['OvvInmediata'];
					$OrdenVentaVehiculo->OvvEstado = $fila['OvvEstado'];
			
					
					$OrdenVentaVehiculo->OvvTiempoSolicitudEnvio = $fila['NOvvTiempoSolicitudEnvio']; 
					$OrdenVentaVehiculo->OvvTiempoAprobacion1Envio = $fila['NOvvTiempoAprobacion1Envio'];
					$OrdenVentaVehiculo->OvvTiempoAprobacion2Envio = $fila['NOvvTiempoAprobacion2Envio'];
					$OrdenVentaVehiculo->OvvTiempoEmitido = $fila['NOvvTiempoEmitido'];
					$OrdenVentaVehiculo->OvvTiempoAnulado = $fila['NOvvTiempoAnulado'];
					$OrdenVentaVehiculo->OvvTiempoPorFacturar = $fila['NOvvTiempoPorFacturar'];
					$OrdenVentaVehiculo->OvvTiempoFacturado = $fila['NOvvTiempoFacturado'];
					
					$OrdenVentaVehiculo->OvvObservacionAsignacion = $fila['OvvObservacionAsignacion'];
					
					$OrdenVentaVehiculo->OvvTiempoCreacion = $fila['NOvvTiempoCreacion'];  
					$OrdenVentaVehiculo->OvvTiempoModificacion = $fila['NOvvTiempoModificacion']; 
					
					$OrdenVentaVehiculo->OvvActaEntregaFecha = $fila['NOvvActaEntregaFecha']; 
					$OrdenVentaVehiculo->OvvActaEntregaHora = $fila['NOvvActaEntregaHora']; 
				
					$OrdenVentaVehiculo->OvvActaEntregaDescripcion = $fila['OvvActaEntregaDescripcion']; 
					$OrdenVentaVehiculo->OvvFotoActaEntrega = $fila['OvvFotoActaEntrega']; 
					
					$OrdenVentaVehiculo->TdoId = $fila['TdoId']; 
					$OrdenVentaVehiculo->CliNombreCompleto = $fila['CliNombreCompleto']; 
					$OrdenVentaVehiculo->CliNombre = $fila['CliNombre']; 
					$OrdenVentaVehiculo->CliApellidoPaterno = $fila['CliApellidoPaterno']; 
					$OrdenVentaVehiculo->CliApellidoMaterno = $fila['CliApellidoMaterno']; 
					$OrdenVentaVehiculo->CliNumeroDocumento = $fila['CliNumeroDocumento']; 
					
					$OrdenVentaVehiculo->CliTelefono = $fila['CliTelefono']; 
					$OrdenVentaVehiculo->CliCelular = $fila['CliCelular']; 
					$OrdenVentaVehiculo->CliEmail = $fila['CliEmail']; 

					$OrdenVentaVehiculo->OvvPropietarioCantidad = $fila['OvvPropietarioCantidad']; 
					
					$OrdenVentaVehiculo->OvvAbonoInicial = $fila['OvvAbonoInicial'];
					$OrdenVentaVehiculo->OvvCancelado = $fila['OvvCancelado'];
					$OrdenVentaVehiculo->OvvCancelado2 = $fila['OvvCancelado2'];
					
					
					$OrdenVentaVehiculo->FpaId = $fila['FpaId']; 
					$OrdenVentaVehiculo->FpaAbreviatura = $fila['FpaAbreviatura']; 
					$OrdenVentaVehiculo->OvvPago = $fila['OvvPago']; 
				
					$OrdenVentaVehiculo->TdoNombre = $fila['TdoNombre']; 
					
					$OrdenVentaVehiculo->MonNombre = $fila['MonNombre']; 
					$OrdenVentaVehiculo->MonSimbolo = $fila['MonSimbolo']; 
				
		
					$OrdenVentaVehiculo->VmaId = $fila['VmaId'];
					$OrdenVentaVehiculo->VmaNombre = $fila['VmaNombre'];
					
					$OrdenVentaVehiculo->VmoId = $fila['VmoId'];
					$OrdenVentaVehiculo->VmoNombre = $fila['VmoNombre'];
					
					$OrdenVentaVehiculo->VveId = $fila['VveId'];
					$OrdenVentaVehiculo->VveNombre = $fila['VveNombre'];
					
					$OrdenVentaVehiculo->VveFoto = $fila['VveFoto'];
					
					$OrdenVentaVehiculo->LtiNombre = $fila['LtiNombre'];
					
					$OrdenVentaVehiculo->EinVIN = $fila['EinVIN'];
					
					$OrdenVentaVehiculo->PerAbreviatura = $fila['PerAbreviatura'];
					$OrdenVentaVehiculo->PerNombre = $fila['PerNombre'];
					$OrdenVentaVehiculo->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$OrdenVentaVehiculo->PerApellidoMaterno = $fila['PerApellidoMaterno'];

					$OrdenVentaVehiculo->MpaNombre = $fila['MpaNombre'];
					$OrdenVentaVehiculo->MpaAbreviatura = $fila['MpaAbreviatura'];					

					$OrdenVentaVehiculo->SucNombre = $fila['SucNombre'];
					
					$OrdenVentaVehiculo->EinNumeroMotor = $fila['EinNumeroMotor'];
					$OrdenVentaVehiculo->EinAnoFabricacion = $fila['EinAnoFabricacion'];
					$OrdenVentaVehiculo->EinAnoModelo = $fila['EinAnoModelo'];
					$OrdenVentaVehiculo->EinColor = $fila['EinColor'];

					switch($OrdenVentaVehiculo->OvvEstado){
					
					  case 1:
						  $Estado = "Pendiente";
					  break;
					
					  case 3:
						  $Estado = "Listo";
					  break;	
						
					case 4:
							$Estado = "Por Facturar";
					break;
					
					 case 5:
				 		 $Estado = "Facturado";			  	
					  break;
					
					 case 6:
						  $Estado = "Anulado";			  	
					  break;
					
					  default:
						  $Estado = "";
					  break;					
					
					}
					
			switch($OrdenVentaVehiculo->OvvEstado){
				
				case 1:
					$OrdenVentaVehiculo->OvvEstadoIcono = '<img width="15" height="15" alt="[Pendiente]" title="Pendiente" src="imagenes/estado/pendiente.gif" />';
				break;
				
				case 3:
					$OrdenVentaVehiculo->OvvEstadoIcono = '<img width="15" height="15" alt="[Emitido]" title="Emitido" src="imagenes/estado/realizado.gif" />';
				break;	
				
				case 4:
					$OrdenVentaVehiculo->OvvEstadoIcono = '<img width="15" height="15" alt="[Emitido]" title="Emitido" src="imagenes/estado/por_facturar.png" />';
				break;	
				
				case 5:
					$OrdenVentaVehiculo->OvvEstadoIcono = '<img width="15" height="15" alt="[Facturado]" title="Facturado" src="imagenes/estado/facturado.png" />';
				break;
				
				case 6:
					$OrdenVentaVehiculo->OvvEstadoIcono = '<img width="15" height="15" alt="[Anulado]" title="Anulado" src="imagenes/estado/anulado.png" />';
				break;

				default:
					$OrdenVentaVehiculo->OvvEstadoIcono = "";
				break;
				
			}
			
			
			
					
					$OrdenVentaVehiculo->OvvEstadoDescripcion = $Estado;
			
                    $OrdenVentaVehiculo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $OrdenVentaVehiculo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}


}
?>