<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsComprobanteVenta
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsComprobanteVenta {

    public $FccId;
	public $FimId;
	public $FccFecha;
    public $FccObservacion;	
	public $FccManoObra;
	
	public $FccCausa;
	public $FccPedido;
	public $FccSolucion;
	public $FccManoObraDetalle;
	
	public $FccComprobanteNumero;
	public $FccComprobanteFecha;
	
	public $FccFacturable;
	public $FccEstado;
	public $FccTiempoCreacion;
	public $FccTiempoModificacion;
    public $FccEliminado;
	
	public $FinId;
	public $FinFecha;
	public $FinTiempoTrabajoTerminado;
	public $LtiNombre;
	public $EinVIN;
	public $VmaId;
	public $VmoId;
	public $VveId;
	public $EinAnoFabricacion;
	public $EinPlaca;
	public $EinColor;

	public $VmaNombre;
	public $VmoNombre;
	public $VveNombre;

				
				
				
	public $MinSigla;
	public $MinNombre;
	public $CliNumeroDocumento;
	public $CliNombre;

	public $AmoId;
	
	public $FccAlmacenMovimientoSalida;
	
	public $FimObsequio;
	
    public $InsMysql;

	public $ComprobanteVentaTarea;
	public $ComprobanteVentaTempario;
	public $FichaIngresoProducto;
	public $FichaAccioSuministro;
	public $ComprobanteVentaFoto;
	public $ComprobanteVentaSalidaExterna;
	
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

    public function MtdObtenerFichaIngresoxFacturar($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FccId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngresoModalidad=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaIngresoEstado=NULL,$oPorFacturar=false,$oPorGenerarGarantia=false,$oFichaIngresoModalidadIngreso=NULL,$oIgnorarTotalVacio=false,$oFacturable=NULL,$oGenerarFactura=false,$oTipoFecha="fcc.FccFecha",$oSucursal=NULL,$oMoneda=NULL) {

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
				
				
				//$filtrar .= '  OR EXISTS( 
//					
//					SELECT 
//					bde.BdeId
//					FROM tblbdeboletadetalle bde
//						
//					WHERE 
//						bde.BolId = bol.BolId AND
//						bde.BtaId = bol.BtaId AND
//						
//						(
//						bde.BdeDescripcion LIKE "%'.$oFiltro.'%" 
//						
//						)
//						
//					) ';
//					
//					
					
				$filtrar .= '  ) ';

			
	
		}




		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		
		
		/*if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFcc)){
				$fecha = ' AND DATE(fcc.FccFecha)>="'.$oFechaInicio.'" AND DATE(fcc.FccFecha)<="'.$oFechaFcc.'"';
			}else{
				$fecha = ' AND DATE(fcc.FccFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFcc)){
				$fecha = ' AND DATE(fcc.FccFecha)<="'.$oFechaFcc.'"';		
			}			
		}*/
		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE('.$oTipoFecha.')>="'.$oFechaInicio.'" AND DATE('.$oTipoFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE('.$oTipoFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFcc)){
				$fecha = ' AND DATE('.$oTipoFecha.')<="'.$oFechaFin.'"';		
			}			
		}
		


		if(!empty($oEstado)){
			$estado = ' AND fcc.FccEstado = '.$oEstado;
		}
		
		if(!empty($oFichaIngresoModalidad)){
			$fimodalidad = ' AND fcc.FimId = "'.$oFichaIngresoModalidad.'"';
		}		
		
//		if(!empty($oFichaIngresoEstado)){
//			$festado = ' AND fin.FinEstado = '.$oFichaIngresoEstado;
//		}
		
		if(!empty($oFichaIngresoEstado)){

			$elementos = explode(",",$oFichaIngresoEstado);

			$i=1;
			$festado .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$festado .= '  (fin.FinEstado = '.($elemento).')';
				if($i<>count($elementos)){						
					$festado .= ' OR ';	
				}
			$i++;		
			}

			$festado .= ' ) 
			)
			';

		}
		
		//$festado = '';
		if(($oPorFacturar)){
			$pfacturar = ' AND (

					(	
						fin.FinEstado = 75
					) 

					OR (fin.FinEstado = 9 
						AND NOT EXISTS ( 
							SELECT 
							bol.BolId 
							FROM tblbolboleta bol 
							WHERE bol.AmoId = amo.AmoId 
							AND bol.BolEstado <> 6
							LIMIT 1
						)
						AND NOT EXISTS ( 
							SELECT fac.FacId 
							FROM tblfacfactura fac 
							WHERE fac.AmoId = amo.AmoId 
							AND fac.FacEstado <> 6
							LIMIT 1
						)
				 	)
				)
			';
		}
		
		if(($oPorGenerarGarantia)){
			$pgarantia = ' AND (
					
					 ( 
					 	(fin.FinEstado = 73 OR fin.FinEstado = 74 OR fin.FinEstado = 75 OR fin.FinEstado = 9  )
						AND NOT EXISTS ( 
							SELECT gar.GarId FROM tblgargarantia gar WHERE gar.FccId = fcc.FccId LIMIT 1
						)
				 	)
				)
			';
		}
		
//		if(!empty($oFichaIngresoModalidadIngreso)){
//			$mingreso = ' AND fim.MinId = "'.$oFichaIngresoModalidadIngreso.'"';
//		}	
//		
		//deb($oFichaIngresoModalidadIngreso);
		if(!empty($oFichaIngresoModalidadIngreso)){

			$elementos = explode(",",$oFichaIngresoModalidadIngreso);

			$i=1;
			$mingreso .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$mingreso .= '  (fim.MinId = "'.($elemento).'" )';
				if($i<>count($elementos)){						
					$mingreso .= ' OR ';	
				}
			$i++;		
			}

			$mingreso .= ' ) 
			)
			';

		}

		if($oIgnorarTotalVacio){
		///	$itvacio = '  AND ( amo.AmoTotal <> 0 OR fcc.FccManoObra <> 0) ';
		}
		
		
		
		if($oFacturable){
			$facturable = '  AND fcc.FccFacturable = '.$oFacturable;
		}
				
		if($oGenerarFactura){
			
			
			$gfactura = '
			

	AND
			
				(
				
					(
			
						




					(
							
							
							
								IF((
							  
							  		IFNULL(fcc.FccManoObra,0) 
								
									+ ROUND(IFNULL((											
											SELECT 
											SUM(amd.AmdImporte)
											FROM tblamdalmacenmovimientodetalle amd
												LEFT JOIN tblamoalmacenmovimiento amo		
												ON amd.AmoId = amo.AmoId
											WHERE amo.FccId = fcc.FccId
											AND amd.AmdEstado = 3
											LIMIT 1
										),0) ,2)
									
									- ROUND(IFNULL(
	  
									  (
										  SELECT 
										  SUM(bde.BdeImporte)
										  FROM tblbdeboletadetalle bde
										  
											  LEFT JOIN tblbolboleta bol
											  ON (bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId)
												  
												  LEFT JOIN tblbamboletaalmacenmovimiento bam
												  ON bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId
												  	
													LEFT JOIN tblamoalmacenmovimiento amo
													ON bam.AmoId = amo.AmoId 
												  
										  WHERE amo.FccId = fcc.FccId
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
														AND ncr.NcrMotivoCodigo<> "07"
													)
													
										  LIMIT 1
									  )
														  
								  ,0),2 )
								  
								  - 
ROUND(IFNULL(
		  
										  (
											  SELECT 
											  SUM(fde.FdeImporte)
											  FROM tblfdefacturadetalle fde
											  
												  LEFT JOIN tblfacfactura fac
												  ON (fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId)
													  	
													LEFT JOIN tblfamfacturaalmacenmovimiento fam
													ON fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
														
														LEFT JOIN tblamoalmacenmovimiento amo
														ON fam.AmoId = amo.AmoId
														
											  WHERE amo.FccId = fcc.FccId
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
														AND ncr.NcrMotivoCodigo<> "07"
													)
													
											  LIMIT 1
										  )
	  
								  ,0),2) 
								  
								)>0,"SI","NO") = "SI"							
							
							AND (fin.FinEstado = 75 OR fin.FinEstado = 9) 

					
					)








					)
				
				)
				
			
			';
			
			
			
			
		}
		
		if($oSucursal){
			$sucursal = '  AND fin.SucId = "'.$oSucursal.'"';
		}
		
		
			
		if($oMoneda){
			$moneda = '  AND amo.MonId = "'.$oMoneda.'"';
		}
		
		
	//	$gfactura = '';
		
		 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				fcc.FccId,
				fcc.FimId,				
				DATE_FORMAT(fcc.FccFecha, "%d/%m/%Y") AS "NFccFecha",
				fcc.FccObservacion,	
				fcc.FccCausa,
				fcc.FccPedido,
				fcc.FccSolucion,	
					
				fcc.FccManoObra,	
				fcc.FccManoObraDetalle,
				
				fcc.FccComprobanteNumero,	
				DATE_FORMAT(fcc.FccComprobanteFecha, "%d/%m/%Y") AS "NFccComprobanteFecha",
				
				fcc.FccEstado,
				DATE_FORMAT(fcc.FccTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFccTiempoCreacion",
	        	DATE_FORMAT(fcc.FccTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFccTiempoModificacion",
				fim.FinId,
				fim.MinId,
				DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",
				DATE_FORMAT(fin.FinTiempoTrabajoTerminado, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTrabajoTerminado",

				lti.LtiNombre,

				ein.EinVIN,
				ein.VmaId,
				ein.VmoId,
				ein.VveId,
				ein.EinAnoFabricacion,
				ein.EinPlaca,
				ein.EinColor,

				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre,

				min.MinSigla,
				min.MinNombre,
				cli.CliNumeroDocumento,
				CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombre,
				CASE
				WHEN EXISTS (
					SELECT amo.AmoId FROM tblamoalmacenmovimiento amo WHERE amo.FccId = fcc.FccId
				) THEN "Si"
				ELSE "No"
				END AS FccAlmacenMovimientoSalida,
				
				fin.FinPrioridad,
				fin.FinConductor,
				fin.FinVehiculoKilometraje,
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				DATE_FORMAT(fin.FinTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoCreacion",
				
				fim.FimObsequio,
				
				fin.FinPlaca,
				onc.OncNombre,
				
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				
				
				(
				SELECT 
					cpr.CprId
						FROM tblcprcotizacionproducto cpr
				WHERE cpr.FinId = fin.FinId
				AND cpr.CprEstado <> 6
					ORDER BY cpr.CprTiempoCreacion DESC
				LIMIT 1
				)  AS CveId,
				
		
				(
				SELECT 
				CONCAT(IFNULL(seg.CliNombre,"")," ",IFNULL(seg.CliApellidoPaterno,"")," ",IFNULL(seg.CliApellidoMaterno,""))
				FROM tblcprcotizacionproducto cpr
				
					LEFT JOIN tblclicliente seg
					ON cpr.CliIdSeguro = seg.CliId
								
				WHERE cpr.FinId = fin.FinId
				AND cpr.CprEstado <> 6
					ORDER BY cpr.CprTiempoCreacion DESC
				LIMIT 1
				)  AS CprSeguro,
		
		
				(
				SELECT 
				seg.CliArchivo
				FROM tblcprcotizacionproducto cpr
				
								LEFT JOIN tblclicliente seg
								ON cpr.CliIdSeguro = seg.CliId
								
				WHERE cpr.FinId = fin.FinId
				AND cpr.CprEstado <> 6
					ORDER BY cpr.CprTiempoCreacion DESC
				LIMIT 1
				)  AS CprSeguroFoto,
				
				amo.AmoId,
				amo.AmoTotal,
				amo.AmoTipoCambio,
				amo.MonId,
				
				mon.MonSimbolo,
				mon.MonNombre,
				
				suc.SucNombre,
				
				per.PerNombre AS PerNombreAsesor,
				per.PerApellidoPaterno AS PerApellidoPaternoAsesor,
				per.PerApellidoMaterno AS PerApellidoMaternoAsesor
		
				
				FROM tblfccfichaaccion fcc
					
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amo.FccId = fcc.FccId
						LEFT JOIN tblmonmoneda mon
						ON amo.MonId = mon.MonId
						
						LEFT JOIN tblfimfichaingresomodalidad fim
						ON fcc.FimId = fim.FimId
						
							LEFT JOIN tblminmodalidadingreso min
							ON fim.MinId = min.MinId
							
								LEFT JOIN tblfinfichaingreso fin
								ON fim.FinId = fin.FinId
									
									
										LEFT JOIN tbleinvehiculoingreso ein
										ON fin.EinId = ein.EinId
											LEFT JOIN tblvehvehiculo veh
											ON ein.VehId = veh.VehId
											
												LEFT JOIN tblvvevehiculoversion vve
												ON ein.VveId = vve.VveId
													LEFT JOIN tblvmovehiculomodelo vmo
													ON ein.VmoId = vmo.VmoId
														LEFT JOIN tblvmavehiculomarca vma
														ON vmo.Vmaid = vma.VmaId	
														
										LEFT JOIN tblclicliente cli
										ON fin.CliId = cli.CliId
										
											LEFT JOIN tbllticlientetipo lti
												ON cli.LtiId = lti.LtiId
												
												LEFT JOIN tblperpersonal per
												ON fin.PerId = per.PerId
												
													LEFT JOIN tbloncconcesionario onc
													ON ein.OncId = onc.OncId
													
													LEFT JOIN tblsucsucursal suc
													ON fin.SucId = suc.SucId
							
							
								LEFT JOIN tblperpersonal ase
												ON fin.PerIdAsesor = ase.PerId
												
				WHERE  fin.FinMigrado IS NULL '.$filtrar.$fimodalidad.$moneda.$fecha.$sucursal.$estado.$festado.$pfacturar.$pgarantia.$mingreso.$facturable.$gfactura.$itvacio."  ".$orden.$paginacion;

			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();

            $InsComprobanteVenta = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ComprobanteVenta = new $InsComprobanteVenta();
                    $ComprobanteVenta->FccId = $fila['FccId'];
					$ComprobanteVenta->FimId = $fila['FimId'];
					$ComprobanteVenta->FccFecha = $fila['NFccFecha'];
					$ComprobanteVenta->FccObservacion = $fila['FccObservacion'];
					$ComprobanteVenta->FccCausa = $fila['FccCausa'];
					$ComprobanteVenta->FccPedido = $fila['FccPedido'];
					$ComprobanteVenta->FccSolucion = $fila['FccSolucion'];
					
					$ComprobanteVenta->FccManoObra = $fila['FccManoObra'];
					$ComprobanteVenta->FccManoObraDetalle = $fila['FccManoObraDetalle'];
					
					$ComprobanteVenta->FccComprobanteNumero = $fila['FccComprobanteNumero'];
					$ComprobanteVenta->FccComprobanteFecha = $fila['NFccComprobanteFecha'];
					
					$ComprobanteVenta->FccFacturable = $fila['FccFacturable'];
					$ComprobanteVenta->FccEstado = $fila['FccEstado'];
					$ComprobanteVenta->FccTiempoCreacion = $fila['NFccTiempoCreacion'];  
					$ComprobanteVenta->FccTiempoModificacion = $fila['NFccTiempoModificacion']; 
					
					$ComprobanteVenta->FinId = $fila['FinId']; 
					$ComprobanteVenta->MinId = $fila['MinId']; 
					$ComprobanteVenta->FinFecha = $fila['NFinFecha']; 
					$ComprobanteVenta->FinTiempoTrabajoTerminado = $fila['NFinTiempoTrabajoTerminado']; 
					
					$ComprobanteVenta->LtiNombre = $fila['LtiNombre']; 
					
					$ComprobanteVenta->EinVIN = $fila['EinVIN']; 
					$ComprobanteVenta->VmaId = $fila['VmaId']; 
					$ComprobanteVenta->VmoId = $fila['VmoId']; 
					$ComprobanteVenta->VveId = $fila['VveId']; 
					$ComprobanteVenta->EinAnoFabricacion = $fila['EinAnoFabricacion']; 
					$ComprobanteVenta->EinPlaca = $fila['EinPlaca']; 
					$ComprobanteVenta->EinColor = $fila['EinColor']; 
					$ComprobanteVenta->VmaNombre = $fila['VmaNombre']; 
					$ComprobanteVenta->VmoNombre = $fila['VmoNombre']; 
					$ComprobanteVenta->VveNombre = $fila['VveNombre'];
					
					$ComprobanteVenta->MinSigla = $fila['MinSigla']; 
					$ComprobanteVenta->MinNombre = $fila['MinNombre']; 
					
					$ComprobanteVenta->CliNumeroDocumento = $fila['CliNumeroDocumento']; 
					$ComprobanteVenta->CliNombre = $fila['CliNombre']; 
					
					$ComprobanteVenta->FccAlmacenMovimientoSalida = $fila['FccAlmacenMovimientoSalida']; 
					$ComprobanteVenta->FinPrioridad = $fila['FinPrioridad']; 
					$ComprobanteVenta->FinConductor = $fila['FinConductor']; 
					$ComprobanteVenta->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje']; 
					$ComprobanteVenta->PerNombre = $fila['PerNombre']; 
					$ComprobanteVenta->PerApellidoPaterno = $fila['PerApellidoPaterno']; 
					$ComprobanteVenta->PerApellidoMaterno = $fila['PerApellidoMaterno']; 
					$ComprobanteVenta->FinTiempoCreacion = $fila['NFinTiempoCreacion']; 
					$ComprobanteVenta->FimObsequio = $fila['FimObsequio']; 
					$ComprobanteVenta->FinPlaca = $fila['FinPlaca'];
					$ComprobanteVenta->OncNombre = $fila['OncNombre']; 
					$ComprobanteVenta->CliNombre = $fila['CliNombre']; 
					$ComprobanteVenta->CliApellidoPaterno = $fila['CliApellidoPaterno']; 
					$ComprobanteVenta->CliApellidoMaterno = $fila['CliApellidoMaterno']; 
		
					$ComprobanteVenta->AmoId = $fila['AmoId']; 
					$ComprobanteVenta->AmoFecha = $fila['NAmoFecha']; 
					
					$ComprobanteVenta->CveId = $fila['CveId']; 
					$ComprobanteVenta->CprSeguro = $fila['CprSeguro']; 
					$ComprobanteVenta->CprSeguroFoto = $fila['CprSeguroFoto']; 
					
					$ComprobanteVenta->CprSeguroFoto = $fila['CprSeguroFoto']; 
					
					$ComprobanteVenta->AmoId = $fila['AmoId']; 
					$ComprobanteVenta->AmoTotal = $fila['AmoTotal']; 
					$ComprobanteVenta->AmoTipoCambio = $fila['AmoTipoCambio']; 
					$ComprobanteVenta->MonId = $fila['MonId']; 
					
					$ComprobanteVenta->MonSimbolo = $fila['MonSimbolo']; 
					$ComprobanteVenta->MonNombre = $fila['MonNombre']; 
				
				$ComprobanteVenta->SucNombre = $fila['SucNombre']; 
				
				
					
					$ComprobanteVenta->PerNombreAsesor = $fila['PerNombreAsesor']; 
					$ComprobanteVenta->PerApellidoPaternoAsesor = $fila['PerApellidoPaternoAsesor']; 
					$ComprobanteVenta->PerApellidoMaternoAsesor = $fila['PerApellidoMaternoAsesor']; 
					
					
                    $ComprobanteVenta->InsMysql = NULL;                    
	
					$Respuesta['Datos'][]= $ComprobanteVenta;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
	
	
	public function MtdObtenerVentaConcretadaxFacturar($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConFactura=0,$oConBoleta=0,$oConGuiaRemision=0,$oVentaDirectaId=NULL,$oMoneda=NULL,$oIgnorarTotalVacio=false,$oGenerarFactura=false,$oFacturable=NULL,$oSucursal=NULL) {

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
			WHERE amd.AmoId = amo.AmoId
			AND amd.AmdEstado = 3
			 LIMIT 1 
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
						AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"

AND ncr.NcrMotivoCodigo<> "05"
											AND ncr.NcrMotivoCodigo<> "09"
AND ncr.NcrMotivoCodigo<> "07"
						)
													
													
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
					
					AND NOT EXISTS(
						SELECT 	
						ncr.NcrId
						FROM tblncrnotacredito ncr
						WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
						AND ncr.NcrEstado <> 6
						AND ncr.NcrMotivoCodigo<> "04"

AND ncr.NcrMotivoCodigo<> "05"
											AND ncr.NcrMotivoCodigo<> "09"
AND ncr.NcrMotivoCodigo<> "07"
					)
													
				LIMIT 1 
			),0)

		)>0,"SI","NO"

) = "SI" 
				
			';
			
		}
			
	
		if(($oFacturable)){
			$facturable = ' AND amo.AmoFacturable =  '.$oFacturable;
		}
		
		
		if(($oSucursal)){
			$sucursal = ' AND amo.SucId =  "'.$oSucursal.'"';
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
										
										AND NOT EXISTS(
											SELECT 	
											ncr.NcrId
											FROM tblncrnotacredito ncr
											WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
											AND ncr.NcrEstado <> 6
											AND ncr.NcrMotivoCodigo<> "04"

AND ncr.NcrMotivoCodigo<> "05"
											AND ncr.NcrMotivoCodigo<> "09"
AND ncr.NcrMotivoCodigo<> "07"
										)
						
						
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
											
										AND NOT EXISTS(
											SELECT 	
											ncr.NcrId
											FROM tblncrnotacredito ncr
											WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
											AND ncr.NcrEstado <> 6
											AND ncr.NcrMotivoCodigo<> "04"

AND ncr.NcrMotivoCodigo<> "05"
											AND ncr.NcrMotivoCodigo<> "09"
AND ncr.NcrMotivoCodigo<> "07"
										)
							
							
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
				AND amo.AmoSubTipo = 3 '.$filtrar.$fecha.$sucursal .$tipo.$stipo.$estado.$faccion.$fingreso.$confactura.$conficha.$fiestado.$conboleta.$concrepuesto.$conguiaremision.$crestado.$vdirecta.$moneda.$dvencer.$pagado.$itvacio.$gfactura.$facturable.$orden.$paginacion;

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

					$VentaConcretada->CveId = $fila['CveId'];
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
		
		
		//MtdObtenerOrdenVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oCliente=NULL,$oConCotizacion=0,$oFacturable=NULL,$oCotizacionVehiculo=NULL,$oVehiculoIngreso=NULL) {



    public function MtdObtenerOrdenVentaVehiculoxFacturar($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oCliente=NULL,$oConCotizacion=0,$oFacturable=NULL,$oCotizacionVehiculo=NULL,$oVehiculoIngreso=NULL,$oSucursal=NULL) {

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
				$fecha = ' AND DATE(ovv.OvvFecha)>="'.$oFechaInicio.'" AND DATE(ovv.OvvFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(ovv.OvvFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ovv.OvvFecha)<="'.$oFechaFin.'"';		
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
AND ncr.NcrMotivoCodigo<> "07"
									
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
AND ncr.NcrMotivoCodigo<> "07"
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
				$facturable = "
				
				AND  (
				
					EXISTS (
						SELECT fac.FacId FROM tblfacfactura fac
						WHERE fac.OvvId = ovv.OvvId
						AND fac.FacEstado <> 6 
						
						LIMIT 1
					)
				
					OR  EXISTS(
					SELECT bol.BolId FROM tblbolboleta bol
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 LIMIT 1
					)
					
					OR (ovv.OvvEstado = 6 OR ovv.OvvEstado = 3)
				)
				
				";
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
					CONCAT(fac.FacId)
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6 LIMIT 1
				)  AS FacId,
				
				(
					SELECT 
					CONCAT(fac.FtaId)
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6 LIMIT 1
				)  AS FtaId,
		
		
								
				(
					SELECT 
					CONCAT(bol.BolId)
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 LIMIT 1
				) AS BolId,	
				
				(
					SELECT 
					CONCAT(bol.BtaId)
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 LIMIT 1
				) AS BtaId,	
				
				
				
				
				
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
				
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				mpa.MpaNombre,
				mpa.MpaAbreviatura
		
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
									
				WHERE 1 = 1 '.$filtrar.$fecha.$tipo.$stipo.$sucursal.$estado.$moneda.$personal.$cliente.$cvehiculo.$ccotizacion.$vingreso.$estado.$facturable.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsOrdenVentaVehiculo = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$OrdenVentaVehiculo = new $InsOrdenVentaVehiculo();
                    $OrdenVentaVehiculo->OvvId = $fila['OvvId'];
					
					
					$OrdenVentaVehiculo->PerId = $fila['PerId'];	
					$OrdenVentaVehiculo->CliId = $fila['CliId'];	
					$OrdenVentaVehiculo->OvvFecha = $fila['NOvvFecha'];
					$OrdenVentaVehiculo->OvvFechaEntrega = $fila['NOvvFechaEntrega'];
					
					
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
					
					
					$OrdenVentaVehiculo->CliRepresentanteNombre = $fila['CliRepresentanteNombre'];
					$OrdenVentaVehiculo->CliRepresentanteNumeroDocumento = $fila['CliRepresentanteNumeroDocumento'];
					$OrdenVentaVehiculo->CliRepresentanteNacionalidad = $fila['CliRepresentanteNacionalidad'];
					$OrdenVentaVehiculo->CliRepresentanteActividadEconomica = $fila['CliRepresentanteActividadEconomica'];

				
				
				
					$OrdenVentaVehiculo->VveId = $fila['VveId'];
					$OrdenVentaVehiculo->OvvAnoModelo = $fila['OvvAnoModelo'];	
					$OrdenVentaVehiculo->OvvAnoFabricacion = $fila['OvvAnoFabricacion'];
					
					
					$OrdenVentaVehiculo->OvvColor = $fila['OvvColor'];	
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
					$OrdenVentaVehiculo->OvvEstado = $fila['OvvEstado'];
					$OrdenVentaVehiculo->OvvTiempoCreacion = $fila['NOvvTiempoCreacion'];  
					$OrdenVentaVehiculo->OvvTiempoModificacion = $fila['NOvvTiempoModificacion']; 
					
					
					$OrdenVentaVehiculo->OvvActaEntregaFecha = $fila['NOvvActaEntregaFecha']; 
					$OrdenVentaVehiculo->OvvActaEntregaDescripcion = $fila['OvvActaEntregaDescripcion']; 
					
		
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
					
					$OrdenVentaVehiculo->PerNombre = $fila['PerNombre'];
					$OrdenVentaVehiculo->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$OrdenVentaVehiculo->PerApellidoMaterno = $fila['PerApellidoMaterno'];

					$OrdenVentaVehiculo->MpaNombre = $fila['MpaNombre'];
					$OrdenVentaVehiculo->MpaAbreviatura = $fila['MpaAbreviatura'];					

					switch($OrdenVentaVehiculo->OvvEstado){
					
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
		
		
		
		
	
		public function MtdObtenerVehiculoMovimientoSalidaxFacturar($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VmvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConFactura=0,$oConBoleta=0,$oConGuiaRemision=0,$oVentaDirectaId=NULL,$oMoneda=NULL,$oIgnorarTotalVacio=false,$oGenerarFactura=false,$oFacturable=NULL,$oSucursal=NULL) {

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
					vmd.VmdId
					FROM tblvmdvehiculomovimientodetalle vmd
						LEFT JOIN tbleinvehiculoingreso ein
						ON vmd.EinId = ein.EinId
						
					WHERE 
						vmd.VmvId = vmv.VmvId AND 
						(
						ein.EinVIN LIKE "%'.$oFiltro.'%" OR
						ein.EinNumeroMotor  LIKE "%'.$oFiltro.'%" 

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
				$fecha = ' AND DATE(vmv.VmvFecha)>="'.$oFechaInicio.'" AND DATE(vmv.VmvFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(vmv.VmvFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vmv.VmvFecha)<="'.$oFechaFin.'"';		
			}			
		}


		if(!empty($oEstado)){
			$estado = ' AND vmv.VmvEstado = '.$oEstado;
		}
		


		if(($oConFactura==1)){
			$confactura = ' AND  EXISTS ( 
				SELECT fac.FacId FROM tblfacfactura fac WHERE fac.VmvId = vmv.VmvId AND fac.FacEstado <> 6 LIMIT 1
			 )';
		}elseif($oConFactura==2){
			$confactura = ' AND  NOT EXISTS ( 
				SELECT fac.FacId FROM tblfacfactura fac WHERE fac.VmvId = vmv.VmvId AND fac.FacEstado <> 6 LIMIT 1
			 )';
		}

		if(($oConBoleta==1)){
			$conboleta = ' AND  EXISTS ( 
				SELECT bol.BolId FROM tblbolboleta bol WHERE bol.VmvId = vmv.VmvId AND bol.BolEstado <> 6 LIMIT 1
			 )';
		}elseif($oConBoleta==2){
			$conboleta = ' AND  NOT EXISTS ( 
				SELECT bol.BolId FROM tblbolboleta bol WHERE bol.VmvId = vmv.VmvId AND bol.BolEstado <> 6 LIMIT 1
			 )';
		}
		
		if(($oConGuiaRemision==1)){
			$conguiaremision = ' AND  EXISTS ( 
				SELECT gam.GamId FROM tblgamguiaremisionalmacenmovimiento gam 
					LEFT JOIN tblgreguiaremision gre
					ON gam.GreId = gre.GreId
				WHERE gam.VmvId = vmv.VmvId 
				AND gre.GreEstado <> 6
				LIMIT 1
			 )';
		}elseif($oConGuiaRemision==2){
			$conguiaremision = ' AND  NOT EXISTS ( 
				SELECT gam.GamId FROM tblgamguiaremisionalmacenmovimiento gam 
					LEFT JOIN tblgreguiaremision gre
					ON gam.GreId = gre.GreId
				WHERE gam.VmvId = vmv.VmvId 
				AND gre.GreEstado <> 6
				LIMIT 1
			 )';
		}
		
		

		if(!empty($oVentaDirectaId)){
			$vdirecta = ' AND vmv.OvvId = "'.$oVentaDirectaId.'"';
		}

		if(!empty($oMoneda)){
			$moneda = ' AND vmv.MonId = "'.$oMoneda.'"';
		}
				
		if(($oIgnorarTotalVacio)){
			$itvacio = ' AND vmv.VmvTotal <> 0 ';
		}
		
		
		if($oGenerarFactura){
			
			$gfactura = '
			
			AND 
			
			NOT EXISTS(
				SELECT 
				bam.BamId
				FROM tblbamboletaalmacenmovimiento bam
					LEFT JOIN tblbolboleta bol
					ON bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId
						LEFT JOIN tblovvordenventavehiculo ovv
						ON bol.OvvId = ovv.OvvId
				WHERE bam.VmvId = vmv.VmvId
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
							AND ncr.NcrMotivoCodigo<> "07"
						)
			)
			
			AND 
			
			NOT EXISTS(
				SELECT 
				fam.FamId
				FROM tblfamfacturaalmacenmovimiento fam
					LEFT JOIN tblfacfactura fac
					ON fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
						LEFT JOIN tblovvordenventavehiculo ovv
						ON fac.OvvId = ovv.OvvId
				WHERE fam.VmvId = vmv.VmvId
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
						AND ncr.NcrMotivoCodigo<> "07"
					)
			)
			
			AND vmv.VmvEstado <> 6
			';
			
		}

		/*if($oGenerarFactura){
			
			$gfactura = '
			
			AND IF (

		( 
			
			
			IFNULL(( 
			SELECT 
				SUM((vmd.VmdCantidad)) 
			FROM tblvmdvehiculomovimientodetalle vmd 
			WHERE vmd.VmvId = vmv.VmvId LIMIT 1 
			),0)

			- IFNULL((
					SELECT 
					SUM(bde.BdeCantidad) 
					FROM tblbdeboletadetalle bde
						LEFT JOIN tblbolboleta bol
						ON bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId
							LEFT JOIN tblvmdvehiculomovimientodetalle vmd 
							ON bde.VmdId = vmd.VmdId

					WHERE vmd.VmvId = vmv.VmvId 
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
AND ncr.NcrMotivoCodigo<> "07"
						)
													
													
					LIMIT 1 
				),0)
		
				- IFNULL((
				SELECT 
				SUM(fde.FdeCantidad) 
				FROM tblfdefacturadetalle fde
					LEFT JOIN tblfacfactura fac
					ON fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId
						LEFT JOIN tblvmdvehiculomovimientodetalle vmd 
						ON fde.VmdId = vmd.VmdId

				WHERE vmd.VmvId = vmv.VmvId 
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
AND ncr.NcrMotivoCodigo<> "07"
					)
													
				LIMIT 1 
			),0)

		)>0,"SI","NO"

) = "SI" 
				
			';
			
		}*/
			
	
		if(($oFacturable)){
			$facturable = ' AND vmv.VmvFacturable =  '.$oFacturable;
		}
		
		
		if(($oSucursal)){
			$sucursal = ' AND vmv.SucId =  "'.$oSucursal.'"';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vmv.VmvId,	
				vmv.CliId,			
				
				vmv.AlmId,
				DATE_FORMAT(vmv.VmvFecha, "%d/%m/%Y") AS "NVmvFecha",
				
				vmv.MonId,
				vmv.VmvTipoCambio,

				vmv.OvvId,
				
				vmv.TopId,
				
				
				vmv.VmvObservacion,
				vmv.VmvPorcentajeImpuestoVenta,
				
				vmv.VmvSubTotal,
				vmv.VmvImpuesto,
				vmv.VmvTotal,
				
				CASE
				WHEN EXISTS (
					SELECT 
					fac.FacId 
					FROM tblfacfactura fac 
						
					WHERE fac.VmvId = vmv.VmvId
					AND fac.FacEstado <> 6
					 LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VmvFactura,
				
				
				CASE
				WHEN EXISTS (
					SELECT 
					bol.BolId 
					FROM tblbolboleta bol
					WHERE bol.VmvId = vmv.VmvId 
						AND bol.BolEstado <> 6 LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VmvBoleta,
				
				CASE
				WHEN EXISTS (
					SELECT 
					gam.GamId
					FROM tblgamguiaremisionalmacenmovimiento gam
						LEFT JOIN tblgreguiaremision gre
						ON (gam.GreId = gre.GreId AND gam.GrtId = gre.GrtId)
							
					WHERE gam.VmvId = vmv.VmvId 
						AND gre.GreEstado <> 6
						LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VmvGuiaRemision,
				
				CASE
				WHEN EXISTS (
					SELECT 

						(
							IFNULL(vmd.VmdCantidad,0) 
							
							- IFNULL(

								(
									SELECT 
									SUM(bde.BdeCantidad)
									FROM tblbdeboletadetalle bde
									
										LEFT JOIN tblbolboleta bol
										ON (bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId)
											
									WHERE bde.VmdId = vmd.VmdId
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
AND ncr.NcrMotivoCodigo<> "07"
										)
						
						
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
												
										WHERE fde.VmdId = vmd.VmdId
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
AND ncr.NcrMotivoCodigo<> "07"
										)
							
							
										LIMIT 1
									)

							,0)
							
						)  AS VmdCantidadPendiente

					FROM tblvmdvehiculomovimientodetalle vmd
						
					WHERE vmd.VmvId = vmv.VmvId
						
						HAVING VmdCantidadPendiente > 0
					
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VmvGenerarComprobante,
				
				vmv.VmvIncluyeImpuesto,	
				vmv.VmvCierre AS VmvCierre,		
				vmv.VmvEstado,
				DATE_FORMAT(vmv.VmvTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVmvTiempoCreacion",
	        	DATE_FORMAT(vmv.VmvTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVmvTiempoModificacion",
				(SELECT COUNT(vmd.VmdId) FROM tblvmdvehiculomovimientodetalle vmd WHERE vmd.VmvId = vmv.VmvId ) AS "VmvTotalItems",
				
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
				
				ovv.CveId,
			
				DATE_FORMAT(ovv.OvvFecha, "%d/%m/%Y") AS "NOvvFecha",
	        	
				mon.MonSimbolo	,
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				per.PerEmail,
				
				ein.EinColor,
				ein.EinVIN,
				
				ovv.OvvTipoCambio,
				ovv.OvvTotal,
				ovv.OvvComprobanteVenta,
				ovv.OvvGLP,
				ovv.OvvGLPModeloTanque,
				
				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre,
				
				mon.MonNombre,
				mon.MonSimbolo,
				
				ovv.EinId
				
				
				FROM tblvmvvehiculomovimiento vmv
					
					
					LEFT JOIN tblovvordenventavehiculo ovv
					ON vmv.OvvId = ovv.OvvId
						LEFT JOIN tbleinvehiculoingreso ein
						ON ovv.EinId = ein.EinId
							LEFT JOIN tblvvevehiculoversion vve
							ON ein.VveId = vve.VveId
								LEFT JOIN tblvmovehiculomodelo vmo
								ON vve.VmoId = vmo.VmoId
									LEFT JOIN tblvmavehiculomarca vma
									ON vmo.VmaId = vma.VmaId		
						LEFT JOIN tblperpersonal per
						ON ovv.PerId = per.PerId
			
					LEFT JOIN tblclicliente cli
					ON vmv.Cliid = cli.CliId
						LEFT JOIN tbltdotipodocumento tdo
						ON cli.TdoId = tdo.TdoId
							LEFT JOIN tbllticlientetipo lti
							ON cli.LtiId = lti.LtiId	
								LEFT JOIN tblmonmoneda mon
								ON vmv.MonId = mon.MonId
								
				WHERE 
				vmv.OvvId IS NOT NULL 
				AND vmv.VmvTipo = 2 
				AND vmv.VmvSubTipo = 1 '.$filtrar.$fecha.$sucursal .$tipo.$stipo.$estado.$faccion.$fingreso.$confactura.$conficha.$fiestado.$conboleta.$concrepuesto.$conguiaremision.$crestado.$vdirecta.$moneda.$dvencer.$pagado.$itvacio.$gfactura.$facturable.$orden.$paginacion;

			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoMovimientoSalida = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VehiculoMovimientoSalida = new $InsVehiculoMovimientoSalida();
                    $VehiculoMovimientoSalida->VmvId = $fila['VmvId'];
					$VehiculoMovimientoSalida->CliId = $fila['CliId'];
					
					$VehiculoMovimientoSalida->AlmId = $fila['AlmId'];
					$VehiculoMovimientoSalida->VmvFecha = $fila['NVmvFecha'];
					$VehiculoMovimientoSalida->MonId = $fila['MonId'];
					$VehiculoMovimientoSalida->VmvTipoCambio = $fila['VmvTipoCambio'];

					$VehiculoMovimientoSalida->CveId = $fila['CveId'];
					$VehiculoMovimientoSalida->OvvId = $fila['OvvId'];
					
					$VehiculoMovimientoSalida->TopId = $fila['TopId'];

					$VehiculoMovimientoSalida->VmvDireccion = $fila['VmvDireccion'];
					$VehiculoMovimientoSalida->VmvObservacion = $fila['VmvObservacion'];
					$VehiculoMovimientoSalida->VmvPorcentajeImpuestoVenta = $fila['VmvPorcentajeImpuestoVenta'];
					$VehiculoMovimientoSalida->VmvMargenUtilidad = $fila['VmvMargenUtilidad'];

					$VehiculoMovimientoSalida->VmvEmpresaTransporte = $fila['VmvEmpresaTransporte'];
					$VehiculoMovimientoSalida->VmvEmpresaTransporteDocumento = $fila['VmvEmpresaTransporteDocumento'];
					$VehiculoMovimientoSalida->VmvEmpresaTransporteClave = $fila['VmvEmpresaTransporteClave'];
					$VehiculoMovimientoSalida->VmvEmpresaTransporteTipoEnvio = $fila['VmvEmpresaTransporteTipoEnvio'];
					$VehiculoMovimientoSalida->VmvEmpresaTransporteFecha = $fila['NVmvEmpresaTransporteFecha'];
					$VehiculoMovimientoSalida->VmvEmpresaTransporteDestino = $fila['VmvEmpresaTransporteDestino'];
					
					$VehiculoMovimientoSalida->VmvManoObra = $fila['VmvManoObra'];
					$VehiculoMovimientoSalida->VmvDescuento = $fila['VmvDescuento'];
					$VehiculoMovimientoSalida->VmvSubTotal = $fila['VmvSubTotal'];
					$VehiculoMovimientoSalida->VmvImpuesto = $fila['VmvImpuesto'];
					$VehiculoMovimientoSalida->VmvTotal = $fila['VmvTotal'];
				
				
					$VehiculoMovimientoSalida->VmvFactura = $fila['VmvFactura'];
					$VehiculoMovimientoSalida->VmvBoleta = $fila['VmvBoleta'];
					$VehiculoMovimientoSalida->VmvGuiaRemision = $fila['VmvGuiaRemision'];
					
					$VehiculoMovimientoSalida->VmvGenerarComprobante = $fila['VmvGenerarComprobante'];
					
					
					$VehiculoMovimientoSalida->VmvIncluyeImpuesto = $fila['VmvIncluyeImpuesto'];
					$VehiculoMovimientoSalida->VmvCierre = $fila['VmvCierre'];
					$VehiculoMovimientoSalida->VmvEstado = $fila['VmvEstado'];
					$VehiculoMovimientoSalida->VmvTiempoCreacion = $fila['NVmvTiempoCreacion'];  
					$VehiculoMovimientoSalida->VmvTiempoModificacion = $fila['NVmvTiempoModificacion']; 

					$VehiculoMovimientoSalida->VmvTotalItems = $fila['VmvTotalItems']; 
					
					$VehiculoMovimientoSalida->CliNombreCompleto = $fila['CliNombreCompleto'];
					$VehiculoMovimientoSalida->CliNombre = $fila['CliNombre'];
					$VehiculoMovimientoSalida->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$VehiculoMovimientoSalida->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					
					
					$VehiculoMovimientoSalida->TdoId = $fila['TdoId'];
					$VehiculoMovimientoSalida->LtiId = $fila['LtiId'];
					$VehiculoMovimientoSalida->CliNumeroDocumento = $fila['CliNumeroDocumento'];					
					$VehiculoMovimientoSalida->CliTelefono = $fila['CliTelefono'];
					$VehiculoMovimientoSalida->CliEmail = $fila['CliEmail'];
					$VehiculoMovimientoSalida->CliCelular = $fila['CliCelular'];
					$VehiculoMovimientoSalida->CliFax = $fila['CliFax'];
					$VehiculoMovimientoSalida->LtiAbreviatura = $fila['LtiAbreviatura'];
					
					$VehiculoMovimientoSalida->CliDireccion = $fila['CliDireccion'];
					$VehiculoMovimientoSalida->CliDepartamento = $fila['CliDepartamento'];
					$VehiculoMovimientoSalida->CliProvincia = $fila['CliProvincia'];
					$VehiculoMovimientoSalida->CliDistrito = $fila['CliDistrito'];
	
					
					$VehiculoMovimientoSalida->TdoNombre = $fila['TdoNombre'];
					$VehiculoMovimientoSalida->LtiNombre = $fila['LtiNombre'];
					
					$VehiculoMovimientoSalida->MonSimbolo = $fila['MonSimbolo'];
					
					$VehiculoMovimientoSalida->OvvOrdenCompraNumero = $fila['OvvOrdenCompraNumero'];
					$VehiculoMovimientoSalida->OvvOrdenCompraFecha = $fila['NOvvOrdenCompraFecha'];
					
					
					$VehiculoMovimientoSalida->OvvArchivo = $fila['OvvArchivo'];
					$VehiculoMovimientoSalida->OvvFecha = $fila['NOvvFecha'];
					
					$VehiculoMovimientoSalida->PerNombre = $fila['PerNombre'];
					$VehiculoMovimientoSalida->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$VehiculoMovimientoSalida->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					$VehiculoMovimientoSalida->PerEmail = $fila['PerEmail'];
				
					
						$VehiculoMovimientoSalida->EinColor = $fila['EinColor'];
					$VehiculoMovimientoSalida->EinVIN = $fila['EinVIN'];
					$VehiculoMovimientoSalida->OvvTipoCambio = $fila['OvvTipoCambio'];
					$VehiculoMovimientoSalida->OvvTotal = $fila['OvvTotal'];
					$VehiculoMovimientoSalida->OvvComprobanteVenta = $fila['OvvComprobanteVenta'];
					$VehiculoMovimientoSalida->OvvGLP = $fila['OvvGLP'];
					$VehiculoMovimientoSalida->OvvGLPModeloTanque = $fila['OvvGLPModeloTanque'];
					
						$VehiculoMovimientoSalida->VmaNombre = $fila['VmaNombre'];
					$VehiculoMovimientoSalida->VmoNombre = $fila['VmoNombre'];
				
					$VehiculoMovimientoSalida->VveNombre = $fila['VveNombre'];
					
					$VehiculoMovimientoSalida->MonNombre = $fila['MonNombre'];
				$VehiculoMovimientoSalida->MonSimbolo = $fila['MonSimbolo'];
				
				$VehiculoMovimientoSalida->EinId = $fila['EinId'];
				
					switch($VehiculoMovimientoSalida->VmvEstado){
						case 1:
							$VehiculoMovimientoSalida->VmvEstadoDescripcion = "No Realizado";
						break;

						
						case 3:
							$VehiculoMovimientoSalida->VmvEstadoDescripcion = "Realizado";					
						break;
					}
					
					
								switch($VehiculoMovimientoSalida->VmvEstado){
					case 1:
						$VehiculoMovimientoSalida->VmvEstadoIcono = '<img width="15" height="15" alt="[No Realizado]" title="No Realizado" src="imagenes/estado/no_realizado.png" />';
					break;

					
					case 3:
						$VehiculoMovimientoSalida->VmvEstadoIcono = '<img width="15" height="15" alt="[Realizado]" title="Realizado" src="imagenes/estado/realizado.gif" />';					
					break;
			}
			
			
                    $VehiculoMovimientoSalida->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VehiculoMovimientoSalida;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}	
		

}
?>