<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsAsignacionVentaVehiculo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsAsignacionVentaVehiculo {

    public $AvvId;
	
	public $OvvId;
	public $AvvFecha;
	public $AvvHora;
	
	public $EinId;
	public $AvvSolicitante;
	public $AvvVehiculoMarca;
	public $AvvVehiculoModelo;
	public $AvvVehiculoVersion;
	
	public $AvvColor;
	public $AvvAnoModelo;
	
	public $AvvObservacion;
	public $AvvEstado;
	public $AvvTiempoCreacion;
	public $AvvTiempoModificacion;
    public $AvvEliminado;
	
	public $VmaNombre;
	public $VmoNombre;
	public $VveNombre;
	public $EinVIN;

	
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

	public function MtdGenerarAsignacionVentaVehiculoId() {


		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(avv.AvvId,10),unsigned)) AS "MAXIMO"
		FROM tblavvasignacionventavehiculo avv
			WHERE YEAR(avv.AvvFecha) = '.$this->AvvAno.';';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
		if(empty($fila['MAXIMO'])){			
			$this->AvvId = "AVV-".$this->AvvAno."-00001";
		}else{
			$fila['MAXIMO']++;
			$this->AvvId = "AVV-".$this->AvvAno."-".str_pad($fila['MAXIMO'], 5, "0", STR_PAD_LEFT);	
		}
				
	}
		
    public function MtdObtenerAsignacionVentaVehiculo($oCompleto=true){

        $sql = 'SELECT 
        avv.AvvId,
		avv.PerId,
		
		avv.OvvId,
		avv.EinId,
		
		DATE_FORMAT(avv.AvvFecha, "%d/%m/%Y") AS "NAvvFecha",
		avv.AvvHora,

		avv.AvvSolicitante,
		avv.AvvVehiculoMarca,		
		avv.AvvVehiculoModelo,
		avv.AvvVehiculoVersion,
		avv.AvvColor,
		avv.AvvAnoModelo,
		avv.AvvObservacion,
		
		avv.AvvAprobacion,
		avv.AvvEstado,
		DATE_FORMAT(avv.AvvTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAvvTiempoCreacion",
        DATE_FORMAT(avv.AvvTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAvvTiempoModificacion",

		ein.EinVIN,
		ein.EinNumeroMotor,
		ein.EinColor,
		ein.EinAnoFabricacion,
		ein.EinAnoModelo,
		ein.EinEstadoVehicular,
		
		ein.VveId,
		vve.VmoId,
		vmo.VmaId,
		
		vma.VmaNombre,
		vmo.VmoNombre,
		vve.VveNombre,
		
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno,
		per.PerEmail,
		
		ovv.PerId AS PerIdVendedor,
		per2.PerNombre AS PerNombreVendedor,
		per2.PerApellidoPaterno AS PerApellidoPaternoVendedor,
		per2.PerApellidoMaterno AS PerApellidoMaternoVendedor,
		per2.PerEmail AS PerEmailVendedor,
		
		suc.SucNombre,
		suc2.SucNombre AS EinUbicacion,
		
		cli.CliNumeroDocumento,
		cli.CliNombre,
		cli.CliApellidoPaterno,
		cli.CliApellidoMaterno,
		
		tdo.TdoNombre,
		
		DATE_FORMAT(ovv.OvvFecha, "%d/%m/%Y") AS "NOvvFecha",
		DATE_FORMAT(ovv.OvvFechaEntrega, "%d/%m/%Y") AS "NOvvFechaEntrega",
		ovv.OvvObservacion,
		ovv.MonId,
		ovv.OvvTipoCambio,
		
		ovv.OvvAprobacion1,
		ovv.OvvAprobacion2,
		ovv.OvvAprobacion3,
		
		ovv.OvvPrecio,
		ovv.OvvTotal,
		ovv.OvvDescuento,
		ovv.OvvDescuentoGerencia,
		ovv.OvvSubTotal,
		ovv.OvvImpuesto
		
        FROM tblavvasignacionventavehiculo avv
			
			LEFT JOIN tblovvordenventavehiculo ovv
			ON avv.OvvId = ovv.OvvId		
				LEFT JOIN tblclicliente cli
				ON ovv.CliId = cli.CliId
					LEFT JOIN tbltdotipodocumento tdo
					ON cli.TdoId = tdo.TdoId
					
				LEFT JOIN tbleinvehiculoingreso ein
				ON avv.EinId = ein.EinId				
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
						
					LEFT JOIN tblperpersonal per
					ON avv.PerId = per.PerId
					
					LEFT JOIN tblperpersonal per2
					ON ovv.PerId = per2.PerId
					
						LEFT JOIN tblsucsucursal suc
						ON ovv.SucId = suc.SucId
							LEFT JOIN tblsucsucursal suc2
							ON ein.SucId = suc2.SucId
					
        WHERE avv.AvvId = "'.$this->AvvId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
		
			$this->AvvId = $fila['AvvId'];
			$this->PerId = $fila['PerId'];
			$this->OvvId = $fila['OvvId'];
			$this->EinId = $fila['EinId'];
			
			$this->AvvFecha = $fila['NAvvFecha'];
			$this->AvvHora = $fila['AvvHora'];

			$this->AvvObservacion = $fila['AvvObservacion'];
			$this->AvvSolicitante = $fila['AvvSolicitante'];
			$this->AvvVehiculoMarca = $fila['AvvVehiculoMarca'];
			$this->AvvVehiculoModelo = $fila['AvvVehiculoModelo'];
			$this->AvvVehiculoVersion = $fila['AvvVehiculoVersion'];
			$this->AvvColor = $fila['AvvColor'];
			$this->AvvAnoModelo = $fila['AvvAnoModelo'];		
			
			
			$this->AvvAprobacion = $fila['AvvAprobacion'];
			$this->AvvEstado = $fila['AvvEstado'];
			$this->AvvTiempoCreacion = $fila['NAvvTiempoCreacion']; 
			$this->AvvTiempoModificacion = $fila['NAvvTiempoModificacion']; 
			
			$this->VveId = $fila['VveId']; 
			$this->VmoId = $fila['VmoId']; 
			$this->VmaId = $fila['VmaId']; 	
	
		
			$this->VmaNombre = $fila['VmaNombre'];		
			$this->VmoNombre = $fila['VmoNombre'];
			$this->VveNombre = $fila['VveNombre'];
			
			$this->EinVIN = $fila['EinVIN'];
			$this->EinNumeroMotor = $fila['EinNumeroMotor'];
			$this->EinColor = $fila['EinColor'];
			$this->EinAnoFabricacion = $fila['EinAnoFabricacion'];
			$this->EinAnoModelo = $fila['EinAnoModelo'];
			$this->EinEstadoVehicular = $fila['EinEstadoVehicular'];
		
			$this->PerNombre = $fila['PerNombre'];
			$this->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$this->PerApellidoMaterno = $fila['PerApellidoMaterno'];
			$this->PerEmail = $fila['PerEmail'];
			
			
			$this->PerIdVendedor = $fila['PerIdVendedor'];
			$this->PerNombreVendedor = $fila['PerNombreVendedor'];
			$this->PerApellidoPaternoVendedor = $fila['PerApellidoPaternoVendedor'];
			$this->PerApellidoMaternoVendedor = $fila['PerApellidoMaternoVendedor'];
			$this->PerEmailVendedor = $fila['PerEmailVendedor'];
			
			$this->SucNombre = $fila['SucNombre'];		
			$this->EinUbicacion = $fila['EinUbicacion'];			
			
			
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento'];
			$this->CliNombre = $fila['CliNombre'];
			$this->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$this->CliApellidoMaterno = $fila['CliApellidoMaterno'];
			$this->TdoNombre = $fila['TdoNombre'];
			
			$this->OvvFecha = $fila['NOvvFecha'];
			$this->OvvFechaEntrega = $fila['NOvvFechaEntrega'];
			$this->OvvObservacion = $fila['OvvObservacion'];
			$this->MonId = $fila['MonId'];
			$this->OvvTipoCambio = $fila['OvvTipoCambio'];
			
			
			$this->OvvAprobacion1 = $fila['OvvAprobacion1'];
			$this->OvvAprobacion2 = $fila['OvvAprobacion2'];
			$this->OvvAprobacion3 = $fila['OvvAprobacion3'];
		
		
			$this->OvvPrecio = $fila['OvvPrecio'];
			$this->OvvTotal = $fila['OvvTotal'];
			$this->OvvDescuento = $fila['OvvDescuento'];
			$this->OvvDescuentoGerencia = $fila['OvvDescuentoGerencia'];
			$this->OvvSubTotal = $fila['OvvSubTotal'];
			$this->OvvImpuesto = $fila['OvvImpuesto'];

			if($oCompleto){
	
				$InsOrdenVentaVehiculoPropietario = new ClsOrdenVentaVehiculoPropietario($this->InsMysql);
				$ResOrdenVentaVehiculoPropietario = $InsOrdenVentaVehiculoPropietario->MtdObtenerOrdenVentaVehiculoPropietarios(NULL,NULL,'OvpId','ASC',NULL,$this->OvvId);
			$this->AsignacionVentaVehiculoPropietario = $ResOrdenVentaVehiculoPropietario['Datos'];
	
			}
			
			
			switch($this->AvvEstado){

				case 1:
					$this->AvvEstadoDescripcion = "Pendiente";
				break;

				case 3:
					$this->AvvEstadoDescripcion = "Revisado";
				break;	
				
				case 6:
					$this->AvvEstadoDescripcion = "Anulado";
				break;	

				default:
					$this->AvvEstadoDescripcion = "";
				break;

			}	
				

		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

	//MtdObtenerAsignacionVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrdenVentaVehiculo=NULL,$oConFechaEntrega=false,$oTipoFecha="avv.AvvFecha",$oSucursal=NULL)
	
    public function MtdObtenerAsignacionVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrdenVentaVehiculo=NULL,$oConFechaEntrega=false,$oTipoFecha="avv.AvvFecha",$oSucursal=NULL) {

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
				
				//
//				$filtrar .= '  OR EXISTS( 
//					
//					SELECT 
//					ood.OodId
//					
//					FROM tbloodordencotizaciondetalle ood
//						
//						LEFT JOIN tblproproducto pro
//						ON ood.ProId = pro.ProId
//						
//							
//								
//								
//					WHERE 
//					
//						ood.AvvId = avv.AvvId
//						AND
//						(
//							pro.ProNombre LIKE "%'.$oFiltro.'%" OR
//							pro.ProCodigoOriginal LIKE "%'.$oFiltro.'%"  OR
//							pro.ProCodigoAlternativo LIKE "%'.$oFiltro.'%" 
//						)
//						
//
//					) ';
					
					
				$filtrar .= '  ) ';

			
	
		}

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		//if(!empty($oFechaInicio)){
//			if(!empty($oFechaFin)){
//				$fecha = ' AND DATE(avv.'.$oTipoFecha.')>="'.$oFechaInicio.'" AND DATE(avv.'.$oTipoFecha.')<="'.$oFechaFin.'"';
//			}else{
//				$fecha = ' AND DATE(avv.'.$oTipoFecha.')>="'.$oFechaInicio.'"';
//			}
//		}else{
//			if(!empty($oFechaFin)){
//				$fecha = ' AND DATE(avv.'.$oTipoFecha.')<="'.$oFechaFin.'"';		
//			}			
//		}
		
		if(!empty($oTipoFecha)){
			
			 if($oTipoFecha=="Comprobante"){
			
				if(!empty($oFechaInicio)){
					if(!empty($oFechaFin)){
						
						$fecha = ' AND  
					(
					
						IFNULL(
						
						(
							SELECT 
							fac.FacFechaEmision
							FROM tblfacfactura fac
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
							WHERE fac.OvvId = avv.OvvId 
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
						,IFNULL(
							(
							SELECT 
							bol.BolFechaEmision
							FROM tblbolboleta bol
								LEFT JOIN tblbtaboletatalonario bta
								ON bol.BtaId = bta.BtaId
							WHERE bol.OvvId = avv.OvvId
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
							),""
							)
						)
					 
						
	
					
					) >="'.$oFechaInicio.'" 
					
					AND 
					
					
					(
					
						IFNULL(
						
						(
							SELECT 
							fac.FacFechaEmision
							FROM tblfacfactura fac
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
							WHERE fac.OvvId = avv.OvvId 
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
						,IFNULL(
							(
							SELECT 
							bol.BolFechaEmision
							FROM tblbolboleta bol
								LEFT JOIN tblbtaboletatalonario bta
								ON bol.BtaId = bta.BtaId
							WHERE bol.OvvId = avv.OvvId
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
							),""
							)
						)
					 
						
	
					
					)
					
					<="'.$oFechaFin.'"';
					
					
					
					}else{
						$fecha = ' AND  
						
						
						
						(
					
						IFNULL(
						
						(
							SELECT 
							fac.FacFechaEmision
							FROM tblfacfactura fac
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
							WHERE fac.OvvId = avv.OvvId 
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
						,IFNULL(
							(
							SELECT 
							bol.BolFechaEmision
							FROM tblbolboleta bol
								LEFT JOIN tblbtaboletatalonario bta
								ON bol.BtaId = bta.BtaId
							WHERE bol.OvvId = avv.OvvId
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
							),""
							)
						)
					 
						
	
					
					)
						
	
					
					)
					
						
						>="'.$oFechaInicio.'"';
					}
				}else{
					if(!empty($oFechaFin)){
						$fecha = ' AND  (
					
						 (
					
						IFNULL(
						
						(
							SELECT 
							fac.FacFechaEmision
							FROM tblfacfactura fac
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
							WHERE fac.OvvId = avv.OvvId 
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
						,IFNULL(
							(
							SELECT 
							bol.BolFechaEmision
							FROM tblbolboleta bol
								LEFT JOIN tblbtaboletatalonario bta
								ON bol.BtaId = bta.BtaId
							WHERE bol.OvvId = avv.OvvId
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
							),""
							)
						)
					 
						
	
					
					)
	
					
					)  <="'.$oFechaFin.'"';		
					}			
				}
				
			}else{
				
				if(!empty($oFechaInicio)){
					if(!empty($oFechaFin)){
						
						$fecha = ' AND DATE('.$oTipoFecha.')>="'.$oFechaInicio.'" AND DATE('.$oTipoFecha.')<="'.$oFechaFin.'"';
					}else{
						$fecha = ' AND DATE('.$oTipoFecha.')>="'.$oFechaInicio.'"';
					}
				}else{
					if(!empty($oFechaFin)){
						$fecha = ' AND DATE('.$oTipoFecha.')<="'.$oFechaFin.'"';		
					}			
				}
				
			}
			
		}
		
		
//		IFNULL(, (SELECT fin.FinFecha FROM tblfinfichaingreso WHERE fin.FinEstado <> 777 AND fin.FinTipo)	)
		
		
		if(!empty($oEstado)){
			$estado = ' AND avv.AvvEstado = '.$oEstado;
		}
		
		if(!empty($oOrdenVentaVehiculo)){
			$ovvehiculo = ' AND avv.OvvId = "'.$oOrdenVentaVehiculo.'"';
		}

	
		if(($oConFechaEntrega)){
			$entrega = ' AND ovv.OvvActaEntregaFecha IS NOT NULL AND ovv.OvvActaEntregaFecha != "0000-00-00" ';
		}

	if(!empty($oSucursal)){
			$sucursal = ' AND ovv.SucId = "'.$oSucursal.'"';
		}
		
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				avv.AvvId,
				avv.PerId,
				
				avv.OvvId,	
				ovv.EinId,
				
				DATE_FORMAT(avv.AvvFecha, "%d/%m/%Y") AS "NAvvFecha",
				avv.AvvHora,
				
				avv.AvvObservacion,
				avv.AvvSolicitante,
				avv.AvvVehiculoMarca,				
				avv.AvvVehiculoModelo,
				avv.AvvVehiculoVersion,
				avv.AvvColor,
				avv.AvvAnoModelo,				
				
				AvvAprobacion,
				avv.AvvEstado,
				DATE_FORMAT(avv.AvvTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAvvTiempoCreacion",
	        	DATE_FORMAT(avv.AvvTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAvvTiempoModificacion",
				
				
				CASE
				WHEN EXISTS (
					SELECT 
					pac.PacId
					FROM tblpacpagocomprobante pac 
						LEFT JOIN tblpagpago pag
						ON pac.PagId = pag.PagId
					
					WHERE pac.OvvId = ovv.OvvId 
					AND pag.PagEstado = 3
					LIMIT 1
					
				) THEN "Si"
				ELSE "No"
				END AS OvvPago,
				
				
				
				
				(
					SELECT 
					(pag.PagMonto/IFNULL(pag.PagTipoCambio,1))
					FROM tblpacpagocomprobante pac 
						LEFT JOIN tblpagpago pag
						ON pac.PagId = pag.PagId
					
					WHERE pac.OvvId = ovv.OvvId 
					AND pag.PagEstado = 3
					
					ORDER BY pag.PagFechaTransaccion ASC
					LIMIT 1
				
				) AS OvvPagoInicial,
				
				(
					SELECT 
					mon.MonSimbolo
					FROM tblpacpagocomprobante pac 
						LEFT JOIN tblpagpago pag
						ON pac.PagId = pag.PagId
							LEFT JOIN tblmonmoneda mon
							ON pag.MonId = mon.MonId
					WHERE pac.OvvId = ovv.OvvId 
					AND pag.PagEstado = 3
					
					ORDER BY pag.PagFechaTransaccion ASC
					LIMIT 1
				
				) AS OvvPagoInicialMonedaSimbolo,
				
				
				
				(
					SELECT 
					CONCAT(fac.FacId)
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = avv.OvvId 
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
					WHERE fac.OvvId = avv.OvvId 
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
					WHERE bol.OvvId = avv.OvvId
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
					WHERE bol.OvvId = avv.OvvId
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
			IF(IFNULL((SELECT 
			
			SUM(pag.PagMonto)
			
			FROM tblpagpago pag
			WHERE 
				
				EXISTS(
					SELECT
					pac.PacId
					FROM tblpacpagocomprobante pac
						WHERE pac.PagId = pag.PagId
						AND pac.OvvId = avv.OvvId
						AND pag.PagEstado = 3
						
				)
				
			ORDER BY pag.PagId ASC LIMIT 1
			),0)>=ovv.OvvTotal,"Si","No")
			
		) AS AvvCancelado,
		
		
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
								AND pac.OvvId = avv.OvvId
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
					WHERE fac.OvvId = avv.OvvId
					AND fac.FacEstado <>  6
					)
					,0)
					
					+
					
					IFNULL(
					(
					SELECT
					SUM(bol.BolTotal)
					FROM tblbolboleta bol
					WHERE bol.OvvId = avv.OvvId
					AND bol.BolEstado <>  6
					)
					,0)
					
					 >=  ovv.OvvTotal,"Si","No")
					
				) AS AvvCancelado2,
				
				
				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre,

				ein.EinVIN,
				ein.EinNumeroMotor,
				ein.EinAnoModelo,
				ein.EinAnoFabricacion,
				ein.EinColor,
				ein.EinCancelado,
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				per.PerEmail,
				
				per2.PerNombre AS PerNombreVendedor,
				per2.PerApellidoPaterno AS PerApellidoPaternoVendedor,
				per2.PerApellidoMaterno AS PerApellidoMaternoVendedor,
				per2.PerEmail AS PerEmailVendedor,
				
				suc.SucNombre,
				
				ovv.CliId,
				
				
				DATE_FORMAT(ovv.OvvActaEntregaFecha, "%d/%m/%Y") AS "NOvvActaEntregaFecha",
				DATE_FORMAT(ovv.OvvFecha, "%d/%m/%Y") AS "NOvvFecha",
				
				ovv.OvvAprobacion1,
				ovv.OvvAprobacion2,
				ovv.OvvAprobacion3,
				
				ovv.OvvTotal,
				ovv.OvvTipoCambio,
				ovv.MonId,
				
				
				DATE_FORMAT(ovv.OvvTiempoSolicitudEnvio, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoSolicitudEnvio",
				DATE_FORMAT(ovv.OvvTiempoAprobacion1Envio, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoAprobacion1Envio",
				DATE_FORMAT(ovv.OvvTiempoAprobacion2Envio, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoAprobacion2Envio",
				DATE_FORMAT(ovv.OvvTiempoEmitido, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoEmitido",
				DATE_FORMAT(ovv.OvvTiempoAnulado, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoAnulado",
				DATE_FORMAT(ovv.OvvTiempoPorFacturar, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoPorFacturar",
				DATE_FORMAT(ovv.OvvTiempoFacturado, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoFacturado",
				
				
				
								cli.CliNumeroDocumento,
		cli.CliNombre,
		cli.CliApellidoPaterno,
		cli.CliApellidoMaterno,
		cli.CliTelefono,
		cli.CliCelular,
		cli.CliEmail,
		cli.CliDireccion,
		
		tdo.TdoNombre,
		
		mon.MonNombre,
		mon.MonSimbolo
		
		
				FROM tblavvasignacionventavehiculo avv
			
					LEFT JOIN tblovvordenventavehiculo ovv
					ON avv.OvvId = ovv.OvvId	
									
						LEFT JOIN tblclicliente cli
						ON ovv.CliId = cli.CliId
							LEFT JOIN tbltdotipodocumento tdo
							ON cli.TdoId = tdo.TdoId
					
					
						LEFT JOIN tbleinvehiculoingreso ein
						ON avv.EinId = ein.EinId				
							LEFT JOIN tblvvevehiculoversion vve
							ON ein.VveId = vve.VveId
								LEFT JOIN tblvmovehiculomodelo vmo
								ON vve.VmoId = vmo.VmoId
									LEFT JOIN tblvmavehiculomarca vma
									ON vmo.VmaId = vma.VmaId
								
							LEFT JOIN tblperpersonal per
							ON avv.PerId = per.PerId
							LEFT JOIN tblperpersonal per2
							ON ovv.PerId = per2.PerId
								LEFT JOIN tblsucsucursal suc
								ON ovv.SucId = suc.SucId
					
					LEFT JOIN tblmonmoneda mon
					ON ovv.MonId = mon.MonId
				WHERE 1 = 1 '.$filtrar.$fecha.$ovvehiculo.$sucursal.$tipo.$stipo.$entrega.$estado.$moneda.$cocompra.$vdirecta.$ocompra.$faccion.$fingreso.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsAsignacionVentaVehiculo = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$AsignacionVentaVehiculo = new $InsAsignacionVentaVehiculo();
                    $AsignacionVentaVehiculo->AvvId = $fila['AvvId'];
					
					$AsignacionVentaVehiculo->PerId = $fila['PerId'];
					$AsignacionVentaVehiculo->OvvId = $fila['OvvId'];
					$AsignacionVentaVehiculo->EinId = $fila['EinId'];
					
					$AsignacionVentaVehiculo->AvvFecha = $fila['NAvvFecha'];
					$AsignacionVentaVehiculo->AvvHora = $fila['AvvHora'];
					
					$AsignacionVentaVehiculo->AvvObservacion = $fila['AvvObservacion'];
					
					$AsignacionVentaVehiculo->AvvSolicitante = $fila['AvvSolicitante'];
					$AsignacionVentaVehiculo->AvvVehiculoMarca = $fila['AvvVehiculoMarca'];					
					$AsignacionVentaVehiculo->AvvVehiculoModelo = $fila['AvvVehiculoModelo'];
					$AsignacionVentaVehiculo->AvvVehiculoVersion = $fila['AvvVehiculoVersion'];										
					$AsignacionVentaVehiculo->AvvColor = $fila['AvvColor'];
					$AsignacionVentaVehiculo->AvvAnoModelo = $fila['AvvAnoModelo'];



					$AsignacionVentaVehiculo->AvvAprobacion = $fila['AvvAprobacion'];
					$AsignacionVentaVehiculo->AvvEstado = $fila['AvvEstado'];
					$AsignacionVentaVehiculo->AvvTiempoCreacion = $fila['NAvvTiempoCreacion'];  
					$AsignacionVentaVehiculo->AvvTiempoModificacion = $fila['NAvvTiempoModificacion']; 
					
					$AsignacionVentaVehiculo->OvvPago = $fila['OvvPago']; 
					$AsignacionVentaVehiculo->OvvPagoInicial = $fila['OvvPagoInicial']; 
					$AsignacionVentaVehiculo->OvvPagoInicialMonedaSimbolo = $fila['OvvPagoInicialMonedaSimbolo']; 
					
						
					$AsignacionVentaVehiculo->FacId = $fila['FacId'];
					$AsignacionVentaVehiculo->FtaId = $fila['FtaId'];
					
					$AsignacionVentaVehiculo->BolId = $fila['BolId'];
					$AsignacionVentaVehiculo->BtaId = $fila['BtaId'];
					
					$AsignacionVentaVehiculo->AvvCancelado = $fila['AvvCancelado'];
					$AsignacionVentaVehiculo->AvvCancelado2 = $fila['AvvCancelado2'];
					
					if(!empty($AsignacionVentaVehiculo->FacId ) || !empty($AsignacionVentaVehiculo->BolId )){
						$AsignacionVentaVehiculo->AvvFacturado = "Si";
					}else{
						$AsignacionVentaVehiculo->AvvFacturado = "No";
					}
					
					
					$AsignacionVentaVehiculo->VmaNombre = $fila['VmaNombre'];
					$AsignacionVentaVehiculo->VmoNombre = $fila['VmoNombre'];
					$AsignacionVentaVehiculo->VveNombre = $fila['VveNombre'];
					
					$AsignacionVentaVehiculo->EinVIN = $fila['EinVIN'];
					$AsignacionVentaVehiculo->EinNumeroMotor = $fila['EinNumeroMotor'];
					$AsignacionVentaVehiculo->EinAnoModelo = $fila['EinAnoModelo'];
					$AsignacionVentaVehiculo->EinAnoFabricacion = $fila['EinAnoFabricacion'];
					$AsignacionVentaVehiculo->EinColor = $fila['EinColor'];
					$AsignacionVentaVehiculo->EinCancelado = $fila['EinCancelado'];
					
					
				
				$AsignacionVentaVehiculo->TdoId = $fila['TdoId'];
					$AsignacionVentaVehiculo->PerNombre = $fila['PerNombre'];
					$AsignacionVentaVehiculo->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$AsignacionVentaVehiculo->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					$AsignacionVentaVehiculo->PerEmail = $fila['PerEmail'];
					
					
					$AsignacionVentaVehiculo->PerNombreVendedor = $fila['PerNombreVendedor'];
					$AsignacionVentaVehiculo->PerApellidoPaternoVendedor = $fila['PerApellidoPaternoVendedor'];
					$AsignacionVentaVehiculo->PerApellidoMaternoVendedor = $fila['PerApellidoMaternoVendedor'];
					$AsignacionVentaVehiculo->PerEmailVendedor = $fila['PerEmailVendedor'];
					
					$AsignacionVentaVehiculo->SucNombre = $fila['SucNombre'];
					
					$AsignacionVentaVehiculo->OvvActaEntregaFecha = $fila['NOvvActaEntregaFecha'];
					$AsignacionVentaVehiculo->OvvFecha = $fila['NOvvFecha'];
					
					
					$AsignacionVentaVehiculo->OvvAprobacion1 = $fila['OvvAprobacion1'];
					$AsignacionVentaVehiculo->OvvAprobacion2 = $fila['OvvAprobacion2'];
					$AsignacionVentaVehiculo->OvvAprobacion3 = $fila['OvvAprobacion3'];
					
					$AsignacionVentaVehiculo->OvvTotal = $fila['OvvTotal'];
					$AsignacionVentaVehiculo->OvvTipoCambio = $fila['OvvTipoCambio'];
					$AsignacionVentaVehiculo->MonId = $fila['MonId'];
					
					$AsignacionVentaVehiculo->OvvTiempoSolicitudEnvio = $fila['NOvvTiempoSolicitudEnvio']; 
					$AsignacionVentaVehiculo->OvvTiempoAprobacion1Envio = $fila['NOvvTiempoAprobacion1Envio'];
					$AsignacionVentaVehiculo->OvvTiempoAprobacion2Envio = $fila['NOvvTiempoAprobacion2Envio'];
					$AsignacionVentaVehiculo->OvvTiempoEmitido = $fila['NOvvTiempoEmitido'];
					$AsignacionVentaVehiculo->OvvTiempoAnulado = $fila['NOvvTiempoAnulado'];
					$AsignacionVentaVehiculo->OvvTiempoPorFacturar = $fila['NOvvTiempoPorFacturar'];
					$AsignacionVentaVehiculo->OvvTiempoFacturado = $fila['NOvvTiempoFacturado'];
					
					$AsignacionVentaVehiculo->CliId = $fila['CliId'];
					$AsignacionVentaVehiculo->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					$AsignacionVentaVehiculo->CliNombre = $fila['CliNombre'];
					$AsignacionVentaVehiculo->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$AsignacionVentaVehiculo->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					
					$AsignacionVentaVehiculo->CliTelefono = $fila['CliTelefono'];
					$AsignacionVentaVehiculo->CliCelular = $fila['CliCelular'];
					$AsignacionVentaVehiculo->CliEmail = $fila['CliEmail'];
					$AsignacionVentaVehiculo->CliDireccion = $fila['CliDireccion'];
					
					
					
					$AsignacionVentaVehiculo->TdoNombre = $fila['TdoNombre'];
					
					$AsignacionVentaVehiculo->MonNombre = $fila['MonNombre'];
					$AsignacionVentaVehiculo->MonSimbolo = $fila['MonSimbolo'];
			
					switch($AsignacionVentaVehiculo->AvvEstado){
					
					case 1:
							$AsignacionVentaVehiculo->AvvEstadoDescripcion = "Pendiente";
						break;
					
						case 3:
							$AsignacionVentaVehiculo->AvvEstadoDescripcion = "Revisado";
						break;	
					
						case 6:
							$AsignacionVentaVehiculo->AvvEstadoDescripcion = "Anulado";
						break;	
					
						default:
							$AsignacionVentaVehiculo->AvvEstadoDescripcion = "";
						break;
					
					}
						

                    $AsignacionVentaVehiculo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $AsignacionVentaVehiculo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}

	//Accion eliminar	 
	public function MtdEliminarAsignacionVentaVehiculo($oElementos) {
	
		echo "MtdEliminarAsignacionVentaVehiculo";
	
		$this->InsMysql->MtdTransaccionIniciar();


		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			$AsignacionVentaVehiculoId = "";
			
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){
						
						
						//$this->MtdObtenerAsignacionVentaVehiculo(false);
					
						//echo "AsignacionVentaVehiculoId1: ".$AsignacionVentaVehiculoId;
						//echo "<br>";
						
						$sql = 'DELETE FROM tblavvasignacionventavehiculo WHERE  (AvvId = "'.($elemento).'" ) ';
										
						//echo "AsignacionVentaVehiculoId2: ".$AsignacionVentaVehiculoId;
						//echo "<br>";
									
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
						
						if(!$resultado) {						
							$error = true;
						}else{
							$this->AvvId = $elemento;
							$this->MtdAuditarAsignacionVentaVehiculo(3,"Se elimino la Asignacion Venta de Vehiculo",$elemento);		
						}
						
						//if(!$error){
//						
//							$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo($this->InsMysql);	
//							$InsOrdenVentaVehiculo->MtdEditarOrdenVentaVehiculoDato("OvvAprobacion1",3,$this->OvvId);
//							
//							$InsVehiculoIngreso = new ClsVehiculoIngreso();
//							$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinEstadoVehicular","STOCK",$this->EinId);
//							
//						}
						
						
					
				}
			$i++;

			}

			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}							
	}
	
	
	//Accion eliminar	 
	public function MtdActualizarEstadoAsignacionVentaVehiculo($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		$InsAsignacionVentaVehiculo = new ClsAsignacionVentaVehiculo();
		

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				
				//$aux = explode("%",$elemento);	

					//$sql = 'UPDATE tblavvasignacionventavehiculo SET AvvEstado = '.$oEstado.' WHERE AvvId = "'.$aux[0].'"';
					$sql = 'UPDATE tblavvasignacionventavehiculo SET AvvEstado = '.$oEstado.' WHERE AvvId = "'.$elemento.'"';
					
					
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						
						$this->AvvId = $elemento;
						$this->MtdAuditarAsignacionVentaVehiculo(2,"Se actualizo el Estado de la Asignacion Venta de Vehiculo",$elemento);
				
					}
					
					if(!$error){
						
						//$this->AvvId = $elemento;
						//$this->MtdObtenerAsignacionVentaVehiculo(false);
					
						//if($oEstado == 6){
//							
//							$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo($this->InsMysql);	
//							$InsOrdenVentaVehiculo->MtdEditarOrdenVentaVehiculoDato("OvvAprobacion1",3,$this->OvvId);
//							
//						}else if($oEstado == 1){
//	
//							$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo($this->InsMysql);	
//							$InsOrdenVentaVehiculo->MtdEditarOrdenVentaVehiculoDato("OvvAprobacion1",3,$this->OvvId);
//							
//						}else if($oEstado == 3){
//							
//							if($this->AvvAprobacion == 1){
//								
//								$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo($this->InsMysql);	
//								$InsOrdenVentaVehiculo->MtdEditarOrdenVentaVehiculoDato("OvvAprobacion1",1,$this->OvvId);
//								
//							}else if($this->AvvAprobacion == 2){
//								
//								$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo($this->InsMysql);	
//								$InsOrdenVentaVehiculo->MtdEditarOrdenVentaVehiculoDato("OvvAprobacion1",2,$this->OvvId);
//								
//							}else{
//							
//								$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo($this->InsMysql);	
//								$InsOrdenVentaVehiculo->MtdEditarOrdenVentaVehiculoDato("OvvAprobacion1",3,$this->OvvId);
//								
//							}
//							
//						}
			
			
					}

					
				}
			$i++;
	
			}

			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}									
	}
	
	
	public function MtdRegistrarAsignacionVentaVehiculo($oTransaccion=true) {
	
		global $Resultado;
		$error = false;

			$this->MtdGenerarAsignacionVentaVehiculoId();
			
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionIniciar();	
			}
				
			
			$sql = 'INSERT INTO tblavvasignacionventavehiculo (
			AvvId,
			PerId,
			
			OvvId,
			EinId,
			
			AvvFecha,
			AvvHora,
			
			AvvObservacion,
			AvvSolicitante,
			AvvVehiculoMarca,
			AvvVehiculoModelo,
			AvvVehiculoVersion,
			
			AvvColor,
			AvvAnoModelo,
			
			
			AvvAprobacion,
			AvvEstado,			
			AvvTiempoCreacion,
			AvvTiempoModificacion) 
			VALUES (
			"'.($this->AvvId).'", 
			'.(empty($this->PerId)?"NULL,":'"'.$this->PerId.'",').'
			
			'.(empty($this->OvvId)?"NULL,":'"'.$this->OvvId.'",').'
			'.(empty($this->EinId)?"NULL,":'"'.$this->EinId.'",').'
			
			"'.($this->AvvFecha).'", 
			"'.($this->AvvHora).'", 
			
			"'.($this->AvvObservacion).'",
			"'.($this->AvvSolicitante).'", 
			"'.($this->AvvVehiculoMarca).'", 
			"'.($this->AvvVehiculoModelo).'",
			"'.($this->AvvVehiculoVersion).'",
			"'.($this->AvvColor).'",
			"'.($this->AvvAnoModelo).'",
					
					
			'.($this->AvvAprobacion).',
			'.($this->AvvEstado).',
			"'.($this->AvvTiempoCreacion).'", 				
			"'.($this->AvvTiempoModificacion).'");';			
				
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
				
			//	deb($this->InsMysql->MtdObtenerErrorCodigo());
				
				switch($this->InsMysql->MtdObtenerErrorCodigo()){
				
						case 1452:
							
							$cadena_error = $this->InsMysql->MtdObtenerError();
							$pos = strpos($cadena_error, "tblovvordenventavehiculo");

							if ($pos !== false) {
								$Resultado.="#ERR_OOT_1000";	
							}
							
						break;

				}
					
			} 
					
				
			if($error) {	
				if($oTransaccion){
					$this->InsMysql->MtdTransaccionDeshacer();			
				}
				return false;
			} else {		
				if($oTransaccion){		
					$this->InsMysql->MtdTransaccionHacer();		
				}
				$this->MtdAuditarAsignacionVentaVehiculo(1,"Se registro la Asignacion Venta de Vehiculo",$this);			
				return true;
			}			
					
	}
	
	public function MtdEditarAsignacionVentaVehiculo() {

		global $Resultado;
		$error = false;

			$sql = 'UPDATE tblavvasignacionventavehiculo SET
			'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
			
			'.(empty($this->OvvId)?'OvvId = NULL, ':'OvvId = "'.$this->OvvId.'",').'
			'.(empty($this->EinId)?'EinId = NULL, ':'EinId = "'.$this->EinId.'",').'
			
			AvvFecha = "'.($this->AvvFecha).'",
			AvvHora = "'.($this->AvvHora).'",
			
			AvvObservacion = "'.($this->AvvObservacion).'",		
			AvvSolicitante = "'.($this->AvvSolicitante).'",
			AvvVehiculoMarca = "'.($this->AvvVehiculoMarca).'",
			AvvVehiculoModelo = "'.($this->AvvVehiculoModelo).'",
			AvvVehiculoVersion = "'.($this->AvvVehiculoVersion).'",	
			
			AvvColor = "'.($this->AvvColor).'",
			AvvAnoModelo = "'.($this->AvvAnoModelo).'",
			
			AvvAprobacion = '.($this->AvvAprobacion).',
			AvvEstado = '.($this->AvvEstado).',
			AvvTiempoModificacion = "'.($this->AvvTiempoModificacion).'"
			WHERE AvvId = "'.($this->AvvId).'";';			
		
			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 		
			
			

			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarAsignacionVentaVehiculo(2,"Se edito la Asignacion Venta de Vehiculo",$this);		
				return true;
			}	
				
		}	
		
		
		public function MtdEditarAsignacionVentaVehiculoDato($oCampo,$oDato,$oAsignacionVentaVehiculoId) {

			$error = false;

			$sql = 'UPDATE tblavvasignacionventavehiculo SET
			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
			AvvTiempoModificacion = NOW()
			WHERE AvvId = "'.($oAsignacionVentaVehiculoId).'";';			

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
		
	
	
		private function MtdAuditarAsignacionVentaVehiculo($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria($this->InsMysql);
			$InsAuditoria->AudCodigo = $this->AvvId;

			$InsAuditoria->UsuId = $this->UsuId;
			$InsAuditoria->SucId = $this->SucId;
			$InsAuditoria->AudAccion = $oAccion;
			$InsAuditoria->AudDescripcion = $oDescripcion;
$InsAuditoria->AudUsuario = $oUsuario;
		$InsAuditoria->AudPersonal = $oPersonal;
			$InsAuditoria->AudDatos = $oDatos;
			$InsAuditoria->AudTiempoCreacion = date("Y-m-d H:i:s");
			
			if($InsAuditoria->MtdAuditoriaRegistrar()){
				return true;
			}else{
				return false;	
			}
			
		}
		
		
		
		
		
		 
		
		public function MtdNotificarAsignacionVentaVehiculoRegistro($oAsignacionVentaVehiculo,$oDestinatario,$oRuta="",$oRemitente=NULL){
			
		global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->AvvId = $oAsignacionVentaVehiculo;
			$this->MtdObtenerAsignacionVentaVehiculo();

			$mensaje = "";
			
			$mensaje .= "<b><u>ASIGNACION DE VIN</u></b>";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<i>Asignacion de VIN aprobada para Orden de Venta de Vehiculo.</i>";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	

			$mensaje .= "<b>Codigo Interno:</b> ".$this->OvvId."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Fecha de Aprobacion:</b> ".$this->AvvFecha."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Revisado por:</b> ".$this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PerApellidoMaterno."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Vendedor:</b> ".$this->PerNombreVendedor." ".$this->PerApellidoPaternoVendedor." ".$this->PerApellidoMaternoVendedor."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Cliente:</b>";
			
			$clientes = "";
			
			$clientes .= $this->TdoNombre." ".$this->CliNumeroDocumento." / ".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno;
			
			if(!empty($this->AsignacionVentaVehiculoPropietario)){
				foreach($this->AsignacionVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
					
					if($this->CliId<>$DatOrdenVentaVehiculoPropietario->CliId){
						$clientes .= $DatOrdenVentaVehiculoPropietario->TdoNombre." ".$DatOrdenVentaVehiculoPropietario->CliNumeroDocumento." / ".$DatOrdenVentaVehiculoPropietario->CliNombre." ".$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno." ".$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;
					}
					
				}
			}
			
		
			$mensaje .= $clientes;
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Sucursal:</b> ".$this->SucNombre."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
				$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%'>";
					
					
						$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>VIN</b>:";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinVIN;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Vehiculo:</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->VmaNombre." ".$this->VmoNombre." ".$this->VveNombre;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Color:</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinColor;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Año Fabricacion:</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinAnoFabricacion;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Año Modelo:</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinAnoModelo;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Estado:</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinEstadoVehicular;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";

					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Ubicacion del vehiculo</b>:";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinUbicacion;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
									
					
			$mensaje .= "</table>";
			$mensaje .= "<br>";
		
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
				
			//	echo $mensaje;
			$InsCorreo = new ClsCorreo();	
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"ASIGNACION VIN: ORD. VEN. VEH. Nro.: ".$this->OvvId." - ".$this->EinVIN." - ".$this->VmaNombre." ".$this->VmoNombre." ".$this->VveNombre,$mensaje,NULL);
			
		}




		
		
	//Accion eliminar	 
	public function MtdRechazarAsignacionVentaVehiculo($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		$InsAsignacionVentaVehiculo = new ClsAsignacionVentaVehiculo();
		

			$i=1;
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){
				
					$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo($this->InsMysql);	
					//$InsOrdenVentaVehiculo->OvvId = $elemento;
					
					$InsOrdenVentaVehiculo->MtdEditarOrdenVentaVehiculoDato("EinId",NULL,$elemento);
					
					if(!$InsOrdenVentaVehiculo->MtdActualizarEstadoOrdenVentaVehiculo($elemento,1)){
						
						$error = true;
						
						//$Resultado .= "#SAS_AVV_110";
					}else{
						//$Resultado .= "#ERR_AVV_110";
					}
					
				}
			$i++;
	
			}

			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}									
	}
		
		
}
?>