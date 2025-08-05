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
	
    public function __construct(){
		$this->InsMysql = new ClsMysql();
		$this->Transaccion = false;
    }
	
	public function __destruct(){

	}
	
	public function MtdObtenerReporteOrdenVentaVehiculoClientes($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL) {

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
				$fecha = ' AND DATE(ovv.OvvFecha)>="'.$oFechaInicio.'" AND DATE(ovv.OvvFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(ovv.OvvFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ovv.OvvFecha)<="'.$oFechaFin.'"';		
			}			
		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND (ovv.SucId) = "'.$oSucursal.'"';		
		}		

			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				
				ovv.OvvId,	
			
				ovv.PerId,
				ovv.CliId,

				DATE_FORMAT(ovv.OvvFecha, "%d/%m/%Y") AS "NOvvFecha",
				DATE_FORMAT(ovv.OvvFechaEntrega, "%d/%m/%Y") AS "NOvvFechaEntrega",
				
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
				ovv.OvvActaEntregaDescripcion,
						
				CASE
				WHEN EXISTS (
					SELECT 
					fac.FacId
					FROM tblfacfactura fac
					WHERE fac.OvvId = ovv.OvvId LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS OvvFactura,
		
		
							
				CASE
				WHEN EXISTS (
					SELECT 
					bol.BolId
					FROM tblbolboleta bol
					WHERE bol.OvvId = ovv.OvvId LIMIT 1
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
					AND fac.FacEstado <> 6 LIMIT 1
				)  AS OvvFacturaNumero,
		
		
								
				(
					SELECT 
					CONCAT(bta.BtaNumero,"-",bol.BolId)
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 LIMIT 1
				) AS OvvBoletaNumero,	
				
				


				(
					SELECT 
					DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y")
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6 LIMIT 1
				)  AS OvvFacturaFecha,
				
		
				(
					SELECT 
					DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y")
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 LIMIT 1
				) AS OvvBoletaFecha,	
				




				(
					SELECT 
					fac.FacTipoCambio
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6 LIMIT 1
				)  AS OvvFacturaTipoCambio,

				(
					SELECT 
					bol.BolTipoCambio
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 LIMIT 1
				) AS OvvBoletaTipoCambio,
				
				


				(
					SELECT 
					fac.FacTotal
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6 LIMIT 1
				)  AS OvvFacturaTotal,

				(
					SELECT 
					bol.BolTotal
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 LIMIT 1
				) AS OvvBoletaTotal,
				
				
						
						
				(
					SELECT 
					fac.FacEstado
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					 LIMIT 1
				)  AS OvvFacturaEstado,

				(
					SELECT 
					bol.BolEstado
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
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
				
				per.PerNumeroDocumento,
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				mpa.MpaNombre,
				mpa.MpaAbreviatura,
				
				suc.SucNombre
		
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
												
				WHERE 1 = 1 '.$filtrar.$fecha.$vmarca.$sucursal.$mingreso.$agrupar." GROUP BY ovv.CliId ".$orden.$paginacion;

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
					
					$ReporteOrdenVentaVehiculo->PerNumeroDocumento = $fila['PerNumeroDocumento'];
					$ReporteOrdenVentaVehiculo->PerNombre = $fila['PerNombre'];
					$ReporteOrdenVentaVehiculo->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$ReporteOrdenVentaVehiculo->PerApellidoMaterno = $fila['PerApellidoMaterno'];

					$ReporteOrdenVentaVehiculo->MpaNombre = $fila['MpaNombre'];
					$ReporteOrdenVentaVehiculo->MpaAbreviatura = $fila['MpaAbreviatura'];		
					
					$ReporteOrdenVentaVehiculo->SucNombre = $fila['SucNombre'];					

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



}
?>