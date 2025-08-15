<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsTallerPedido
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsTallerPedido {

    public $AmoId;
	public $AmoTipo;
	public $FccId;
	public $AmoFecha;
	public $TopId;

	public $VdiId;
	public $CprId;

	public $AmoPorcentajeImpuestoVenta;
	public $AmoPorcentajeMantenimiento;
	
    public $AmoObservacion;
	public $AmoDescuento;
	
	public $AmoTotal;
	public $AmoFactura;

	public $AmoEstado;
	public $AmoTiempoCreacion;
	public $AmoTiempoModificacion;
    public $AmoEliminado;

	public $TopNombre;
	public $FinId;
	public $FinFecha;

	public $MinId;
	public $MinSigla;
	public $MinNombre;

	public $FccManoObra;
	
	public $FinVehiculoKilometraje;
	public $EinPlaca;
	public $EinVIN;
	public $EinAnoFabricacion;

	
	
	public $VmaNombre;
	public $VmoNombre;
	public $VveNombre;

	public $CliNombre;
//	public $CliApellidoPaterno;
//	public $CliApellidoMaterno;
	
	public $PerNombre;
	public $PerApellidoPaterno;
	public $PerApellidoMaterno;
	
	public $AmoTotalItems;
	public $TallerPedidoDetalle;

	
	
	
	public $FichaAccionMantenimiento;
	
	public $Transaccion;
	
	// Propiedades adicionales para evitar warnings
	public $SucId;
	public $AlmId;
	public $LtiId;
	public $AmoIncluyeImpuesto;
	public $MonId;
	public $AmoTipoCambio;
	public $AmoBoleta;
	public $AmoGuiaRemision;
	public $AmoCierre;
	public $MonNombre;
	
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

	public function MtdGenerarTallerPedidoId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(amo.AmoId,5),unsigned)) AS "MAXIMO"
			FROM tblamoalmacenmovimiento amo
				WHERE amo.AmoTipo = 2';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->AmoId = "AMS-10000";
			}else{
				$fila['MAXIMO']++;
				$this->AmoId = "AMS-".$fila['MAXIMO'];					
			}
				
	}
		
    public function MtdObtenerTallerPedido(){

		$sql = 'SELECT 
        amo.AmoId,  
		amo.SucId,
		
		amo.AlmId,
		
		amo.FccId,
		DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
		amo.TopId,
		
		amo.VdiId,
		amo.CprId,
		amo.AmoIncluyeImpuesto,
		amo.AmoPorcentajeImpuestoVenta,
		amo.AmoPorcentajeMantenimiento,
			
		IFNULL(amo.LtiId,cli.LtiId)  AS "NLtiId",
		
		amo.MonId,
		amo.AmoTipoCambio,
		
		amo.AmoObservacion,
		amo.AmoDescuento,
		amo.AmoTotal,
		
				CASE
				WHEN EXISTS (
					SELECT 
					fac.FacId 
					FROM tblfacfactura fac 
					WHERE fac.AmoId = amo.AmoId LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS AmoFactura,
				
				CASE
				WHEN EXISTS (
					SELECT 
					bol.BolId 
					FROM tblbolboleta bol
				WHERE bol.AmoId = amo.AmoId LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS AmoBoleta,
				
				
			CASE
				WHEN EXISTS (
					SELECT 
					gam.GamId
					FROM tblgamguiaremisionalmacenmovimiento gam
					WHERE gam.AmoId = amo.AmoId LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS AmoGuiaRemision,
								
				
		amo.AmoCierre,
		amo.AmoEstado,
		DATE_FORMAT(amo.AmoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAmoTiempoCreacion",
        DATE_FORMAT(amo.AmoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAmoTiempoModificacion",
		
		mon.MonNombre,
		mon.MonSimbolo,
		
		fim.FinId,
		DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",
		fim.MinId,
		min.MinSigla,
		min.MinNombre,
		
		fcc.FccManoObra,
		fcc.FccManoObraDetalle,
		
		fin.FinVehiculoKilometraje,
		ein.EinPlaca,
		ein.EinVIN,
		ein.EinAnoFabricacion,
		
		vma.VmaNombre,
		vmo.VmoNombre,
		vve.VveNombre,
		
		cli.LtiId,
		
		IFNULL(cli2.CliNombreCompleto,cli.CliNombreCompleto) AS CliNombreCompleto,
		IFNULL(cli2.CliNombre,cli.CliNombre) AS CliNombre,
		IFNULL(cli2.CliApellidoPaterno,cli.CliApellidoPaterno) AS CliApellidoPaterno,
		IFNULL(cli2.CliApellidoMaterno,cli.CliApellidoMaterno) AS CliApellidoMaterno,

		min.MinNombre,
		
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno,
		
		fin.CliId,
		cli.TdoId,
		cli.CliNumeroDocumento,
		cli.CliDireccion,
		
		fim.FimObsequio
		
		

        FROM tblamoalmacenmovimiento amo
			LEFT JOIN tblmonmoneda mon
			ON amo.MonId = mon.MonId
			
			LEFT JOIN tblfccfichaaccion fcc
			ON amo.FccId = fcc.FccId
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
											ON ein.VmaId = vma.VmaId
												
												LEFT JOIN tblclicliente cli
												ON fin.CliId = cli.CliId
												
													LEFT JOIN tblclicliente cli2
													ON amo.CliId = cli2.CliId
													
													

													LEFT JOIN tblperpersonal per
													ON fin.PerId = per.PerId

		WHERE amo.AmoId = "'.$this->AmoId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {

			$this->AmoId = $fila['AmoId'];
			$this->SucId = $fila['SucId'];
			$this->AlmId = $fila['AlmId'];
			
			$this->FccId = $fila['FccId'];
			$this->AmoFecha = $fila['NAmoFecha'];
			$this->TopId = $fila['TopId'];
			
			$this->VdiId = $fila['VdiId'];
			$this->CprId = $fila['CprId'];
			$this->LtiId = $fila['NLtiId'];
			
			$this->AmoIncluyeImpuesto = $fila['AmoIncluyeImpuesto'];
			$this->AmoPorcentajeImpuestoVenta = $fila['AmoPorcentajeImpuestoVenta'];
			$this->AmoPorcentajeMantenimiento = $fila['AmoPorcentajeMantenimiento'];
		
		
			$this->MonId = $fila['MonId'];
			$this->AmoTipoCambio = $fila['AmoTipoCambio'];
			
			$this->AmoObservacion = $fila['AmoObservacion'];
			$this->AmoDescuento = $fila['AmoDescuento'];
			$this->AmoTotal = $fila['AmoTotal'];
			
			$this->AmoFactura = $fila['AmoFactura'];
			$this->AmoBoleta = $fila['AmoBoleta'];
			
			$this->AmoGuiaRemision = $fila['AmoGuiaRemision'];
			
			$this->AmoCierre = $fila['AmoCierre'];
			$this->AmoEstado = $fila['AmoEstado'];
			$this->AmoTiempoCreacion = $fila['NAmoTiempoCreacion']; 
			$this->AmoTiempoModificacion = $fila['NAmoTiempoModificacion']; 
			
			$this->MonNombre = $fila['MonNombre']; 
			$this->MonSimbolo = $fila['MonSimbolo']; 	
			

			$this->FinId = $fila['FinId'];
			$this->FinFecha = $fila['NFinFecha'];
			$this->MinId = $fila['MinId'];
			$this->MinSigla = $fila['MinSigla'];
			$this->MinNombre = $fila['MinNombre'];
			
			$this->FccManoObra = $fila['FccManoObra'];
			$this->FccManoObraDetalle = $fila['FccManoObraDetalle'];
			
			$this->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje'];
			$this->EinPlaca = $fila['EinPlaca'];
			$this->EinVIN = $fila['EinVIN'];
			$this->EinAnoFabricacion = $fila['EinAnoFabricacion'];

			$this->VmaNombre = $fila['VmaNombre'];
			$this->VmoNombre = $fila['VmoNombre'];
			$this->VveNombre = $fila['VveNombre'];


			$this->LtiId = $fila['LtiId'];
			$this->CliNombreCompleto = $fila['CliNombreCompleto'];
			$this->CliNombre = $fila['CliNombre'];
			$this->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$this->CliApellidoMaterno = $fila['CliApellidoMaterno'];
			
	

//			$this->CliApellidoPaterno = $fila['CliApellidoPaterno'];
//			$this->CliApellidoMaterno = $fila['CliApellidoMaterno'];
			
			$this->MinNombre = $fila['MinNombre'];
			
			$this->PerNombre = $fila['PerNombre'];
			$this->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$this->PerApellidoMaterno = $fila['PerApellidoMaterno'];
			
			
			$this->CliId = $fila['CliId'];
			$this->TdoId = $fila['TdoId'];
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento'];
			$this->CliDireccion = $fila['CliDireccion'];
			
			$this->FimObsequio = $fila['FimObsequio'];

			$InsTallerPedidoDetalle = new ClsTallerPedidoDetalle($this->InsMysql);
			//$ResTallerPedidoDetalle =  $InsTallerPedidoDetalle->MtdObtenerTallerPedidoDetalles(NULL,NULL,NULL,NULL,NULL,$this->AmoId);
			$ResTallerPedidoDetalle =  $InsTallerPedidoDetalle->MtdObtenerTallerPedidoDetalles(NULL,NULL,NULL,"PmtOrden ASC,AmdFecha ASC","",NULL,$this->AmoId);
			
			$this->TallerPedidoDetalle = 	$ResTallerPedidoDetalle['Datos'];	

		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerTallerPedidos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaAccion=NULL,$oFichaIngreso=NULL,$oConFactura=0,$oConFicha=0,$oFichaIngresoEstado=NULL,$oConBoleta=NULL,$oPorFacturar=false,$oModalidad=NULL,$oSubTipo=NULL) {

		// Inicializar variables para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$fechainicio = '';
		$fechafin = '';
		$estado = '';
		$fichaaccion = '';
		$fichaIngreso = '';
		$conFactura = '';
		$conFicha = '';
		$fichaIngresoEstado = '';
		$conBoleta = '';
		$porFacturar = '';
		$modalidad = '';
		$subTipo = '';

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

			$elementos = explode(",",$oEstado);

			$i=1;
			$estado .= ' AND (';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$estado .= '  (amo.AmoEstado = '.($elemento).')';
				if($i<>count($elementos)){						
					$estado .= ' OR ';	
				}
			$i++;		
			}

			$estado .= ' ) ';

		}
		
		
//		if(!empty($oEstado)){
//			$estado = ' AND amo.AmoEstado = '.$oEstado;
//		}
		

		if(!empty($oFichaAccion)){
			$faccion = ' AND amo.FccId = "'.$oFichaAccion.'"';
		}
		

		if(!empty($oFichaIngreso)){
			$fingreso = ' AND fim.FinId = "'.$oFichaIngreso.'"';
		}
		
		if(!empty($oFichaIngreso)){
			$fingreso = ' AND fim.FinId = "'.$oFichaIngreso.'"';
		}		


		if(($oConFactura==1)){
			$confactura = ' AND  EXISTS ( 
				SELECT fac.FacId FROM tblfacfactura fac WHERE fac.AmoId = amo.AmoId LIMIT 1
			 )';
		}elseif($oConFactura==2){
			$confactura = ' AND  NOT EXISTS ( 
				SELECT fac.FacId FROM tblfacfactura fac WHERE fac.AmoId = amo.AmoId LIMIT 1
			 )';
		}
		
		if(($oConFicha==1)){
			$conficha = ' AND  amo.FccId IS NOT NULL ';
		}elseif($oConFicha==2){
			$conficha = ' AND  amo.FccId IS NULL ';
		}

		if(!empty($oFichaIngresoEstado)){
			$fiestado = ' AND fin.FinEstado = '.$oFichaIngresoEstado;
		}	
		

		if(($oConBoleta==1)){
			$conboleta = ' AND  EXISTS ( 
				SELECT bol.BolId FROM tblbolboleta bol WHERE bol.AmoId = amo.AmoId LIMIT 1
			 )';
		}elseif($oConBoleta==2){
			$conboleta = ' AND  NOT EXISTS ( 
				SELECT bol.BolId FROM tblbolboleta bol WHERE bol.AmoId = amo.AmoId LIMIT 1
			 )';
		}
		
		if(($oPorFacturar)){
			$pfacturar = ' AND (
					
					(fin.FinEstado = 75) 
					OR (fin.FinEstado = 9 
						AND NOT EXISTS ( 
							SELECT bol.BolId FROM tblbolboleta bol WHERE bol.AmoId = amo.AmoId LIMIT 1
						)
						AND NOT EXISTS ( 
							SELECT fac.FacId FROM tblfacfactura fac WHERE fac.AmoId = amo.AmoId LIMIT 1
						)
				 	)
				)
			';
		}


		if(!empty($oModalidad)){

			$elementos = explode(",",$oModalidad);

			$i=1;
			$modalidad .= ' AND (';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$modalidad .= '  (fim.MinId = "'.($elemento).'")';
				if($i<>count($elementos)){						
					$modalidad .= ' OR ';	
				}
			$i++;		
			}

			$modalidad .= ' ) ';

		}
		
		//deb($oSubTipo);
		if(!empty($oSubTipo)){

			$elementos = explode(",",$oSubTipo);

			$i=1;
			$amsubtipo .= ' AND (';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$amsubtipo .= '  (amo.AmoSubTipo = "'.($elemento).'")';
				if($i<>count($elementos)){						
					$amsubtipo .= ' OR ';	
				}
			$i++;		
			}

			$amsubtipo .= ' ) ';

		}
		
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				amo.AmoId,	
				amo.AlmId,
				
				amo.FccId,	
				
				amo.AmoTipo,
				DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
				amo.TopId,
					
					amo.VdiId,
					amo.CprId,
					
				amo.AmoPorcentajeImpuestoVenta,
				amo.AmoPorcentajeMantenimiento,
		
				IFNULL(amo.LtiId,cli.LtiId) AS "NLtiId",
				
				amo.AmoIncluyeImpuesto,
				amo.MonId,
				amo.AmoTipoCambio,
				
				amo.AmoObservacion,
				amo.AmoDescuento,
				amo.AmoTotal,				
				
				CASE
				WHEN EXISTS (
					SELECT 
					fac.FacId 
					FROM tblfacfactura fac 
					WHERE fac.AmoId = amo.AmoId LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS AmoFactura,
				
								CASE
				WHEN EXISTS (
					SELECT 
					bol.BolId 
					FROM tblbolboleta bol
					WHERE bol.AmoId = amo.AmoId LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS AmoBoleta,
				
				
			CASE
				WHEN EXISTS (
					SELECT 
					gam.GamId
					FROM tblgamguiaremisionalmacenmovimiento gam
					WHERE gam.AmoId = amo.AmoId LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS AmoGuiaRemision,
								
				amo.AmoCierre,			
				amo.AmoEstado,
				DATE_FORMAT(amo.AmoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAmoTiempoCreacion",
	        	DATE_FORMAT(amo.AmoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAmoTiempoModificacion",

				(SELECT COUNT(amd.AmdId) FROM tblamdalmacenmovimientodetalle amd WHERE amd.AmoId = amo.AmoId ) AS "AmoTotalItems",
				
				(SELECT COUNT(amd.AmdId) FROM tblamdalmacenmovimientodetalle amd WHERE amd.AmoId = amo.AmoId AND amd.AmdPrecioVenta<=0 ) AS "AmoSinPrecio",
				
				top.TopNombre,
				fim.FinId,	
				DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",
				fim.MinId,
				min.MinSigla,
				min.MinNombre,
				
				fcc.FccManoObra,
				
				
				
				cli.TdoId,
				
				cli.CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				
				cli.CliNumeroDocumento,
				
				lti.LtiUtilidad,
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
				
		
		fin.CliId,
		cli.TdoId,
		cli.CliNumeroDocumento,
		cli.CliDireccion,
		
		fim.FimObsequio,
		
		alm.AlmNombre,
		
		mon.MonNombre,
		mon.MonSimbolo,
		
		(
		SELECT 
		gam.GreId 
		FROM tblgamguiaremisionalmacenmovimiento gam
		
			LEFT JOIN tblgreguiaremision gre
			ON (gam.GreId = gre.GreId AND gam.GrtId = gre.GrtId)
				LEFT JOIN tblgrtguiaremisiontalonario grt
				ON gre.GrtId = grt.GrtId
				
			WHERE gam.AmoId = amo.AmoId
			ORDER BY gre.GreFechaInicioTraslado DESC
			LIMIT 1
		) AS GreId,
		
		
		(
		SELECT 
		gam.GrtId 
		FROM tblgamguiaremisionalmacenmovimiento gam
		
			LEFT JOIN tblgreguiaremision gre
			ON (gam.GreId = gre.GreId AND gam.GrtId = gre.GrtId)
				LEFT JOIN tblgrtguiaremisiontalonario grt
				ON gre.GrtId = grt.GrtId
				
			WHERE gam.AmoId = amo.AmoId
			ORDER BY gre.GreFechaInicioTraslado DESC
			LIMIT 1
		) AS GrtId,	
		
		(
		SELECT 
		grt.GrtNumero 
		FROM tblgamguiaremisionalmacenmovimiento gam
		
			LEFT JOIN tblgreguiaremision gre
			ON (gam.GreId = gre.GreId AND gam.GrtId = gre.GrtId)
				LEFT JOIN tblgrtguiaremisiontalonario grt
				ON gre.GrtId = grt.GrtId
				
			WHERE gam.AmoId = amo.AmoId
			ORDER BY gre.GreFechaInicioTraslado DESC
			LIMIT 1
		) AS GrtNumero	
						
				
				FROM tblamoalmacenmovimiento amo
					LEFT JOIN tblalmalmacen alm
					ON amo.AlmId = alm.AlmId
						LEFT JOIN tblmonmoneda mon
						ON amo.MonId = mon.MonId
						
					LEFT JOIN tbltoptipooperacion top
					ON amo.TopId = top.TopId
						LEFT JOIN tblfccfichaaccion fcc
						ON amo.FccId = fcc.FccId
							LEFT JOIN tblfimfichaingresomodalidad fim
							ON fcc.FimId = fim.FimId
								LEFT JOIN tblminmodalidadingreso min
								ON fim.MinId = min.MinId
									LEFT JOIN tblfinfichaingreso fin
									ON fim.FinId = fin.FinId
									
						LEFT JOIN tblclicliente cli
						ON fin.CliId = cli.CliId
							LEFT JOIN tbllticlientetipo lti
							ON cli.LtiId = lti.LtiId
							
										LEFT JOIN tbleinvehiculoingreso ein
										ON fin.EinId = ein.EinId
									
											LEFT JOIN tblvvevehiculoversion vve
											ON ein.VveId = vve.VveId
												LEFT JOIN tblvmovehiculomodelo vmo
												ON ein.VmoId = vmo.VmoId
													LEFT JOIN tblvmavehiculomarca vma
													ON vmo.Vmaid = vma.VmaId	
													
										LEFT JOIN tblcprcotizacionproducto cpr
										ON amo.CprId = cpr.CprId
										
									
				WHERE amo.AmoTipo = 2 
			AND amo.AmoSubTipo = 2
				'.$filtrar.$fecha.$tipo.$stipo.$estado.$faccion.$fingreso.$confactura.$conficha.$fiestado.$conboleta.$concrepuesto.$crestado.$pfacturar.$modalidad.$amsubtipo.$orden.$paginacion;


/*
amo.AmoSubTipo = 0 OR 
					amo.AmoSubTipo = 1 OR 
					amo.AmoSubTipo = 2 OR 
					amo.AmoSubTipo = 3
					
					*/
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsTallerPedido = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$TallerPedido = new $InsTallerPedido();
                    $TallerPedido->AmoId = $fila['AmoId'];
					 $TallerPedido->AlmId = $fila['AlmId'];
					 
					$TallerPedido->FccId = $fila['FccId'];
					$TallerPedido->AmoFecha = $fila['NAmoFecha'];
					$TallerPedido->TopId = $fila['TopId'];
					
					$TallerPedido->VdiId = $fila['VdiId'];
					$TallerPedido->CprId = $fila['CprId'];
					$TallerPedido->LtiId = $fila['NLtiId'];
					
					$TallerPedido->AmoPorcentajeImpuestoVenta = $fila['AmoPorcentajeImpuestoVenta'];
					$TallerPedido->AmoPorcentajeMantenimiento = $fila['AmoPorcentajeMantenimiento'];

					
					$TallerPedido->AmoIncluyeImpuesto = $fila['AmoIncluyeImpuesto'];
					$TallerPedido->MonId = $fila['MonId'];
					$TallerPedido->AmoTipoCambio = $fila['AmoTipoCambio'];

					$TallerPedido->AmoObservacion = $fila['AmoObservacion'];
					$TallerPedido->AmoDescuento = $fila['AmoDescuento'];
					$TallerPedido->AmoTotal = $fila['AmoTotal'];
					
					
					$TallerPedido->AmoFactura = $fila['AmoFactura'];	
					$TallerPedido->AmoBoleta = $fila['AmoBoleta'];	
									
					$TallerPedido->AmoGuiaRemision = $fila['AmoGuiaRemision'];					
					
					$TallerPedido->AmoCierre = $fila['AmoCierre'];
					$TallerPedido->AmoEstado = $fila['AmoEstado'];
					$TallerPedido->AmoTiempoCreacion = $fila['NAmoTiempoCreacion'];  
					$TallerPedido->AmoTiempoModificacion = $fila['NAmoTiempoModificacion']; 

					$TallerPedido->AmoTotalItems = $fila['AmoTotalItems']; 
					$TallerPedido->AmoSinPrecio = $fila['AmoSinPrecio']; 
					
					$TallerPedido->TopNombre = $fila['TopNombre']; 
					$TallerPedido->FinId = $fila['FinId']; 
					$TallerPedido->FinFecha = $fila['NFinFecha']; 
					$TallerPedido->MinId = $fila['MinId']; 
					$TallerPedido->MinSigla = $fila['MinSigla']; 
					$TallerPedido->MinNombre = $fila['MinNombre']; 
					
					$TallerPedido->FccManoObra = $fila['FccManoObra']; 
				
				
				
	
				
					$TallerPedido->TdoId = $fila['TdoId']; 
					
					$TallerPedido->CliNombreCompleto = $fila['CliNombreCompleto'];
					$TallerPedido->CliNombre = $fila['CliNombre'];
					$TallerPedido->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$TallerPedido->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					
 
					$TallerPedido->CliNumeroDocumento = $fila['CliNumeroDocumento'];

					$TallerPedido->LtiUtilidad = $fila['LtiUtilidad']; 
					$TallerPedido->LtiNombre = $fila['LtiNombre']; 
					
				
					$TallerPedido->EinVIN = $fila['EinVIN'];
					$TallerPedido->VmaId = $fila['VmaId'];
					$TallerPedido->VmoId = $fila['VmoId'];
					$TallerPedido->VveId = $fila['VveId'];
					$TallerPedido->EinAnoFabricacion = $fila['EinAnoFabricacion'];
					$TallerPedido->EinPlaca = $fila['EinPlaca'];
					$TallerPedido->EinColor = $fila['EinColor'];
					
					$TallerPedido->VmaNombre = $fila['VmaNombre'];
					$TallerPedido->VmoNombre = $fila['VmoNombre'];
					$TallerPedido->VveNombre = $fila['VveNombre'];
					
					$TallerPedido->CliId = $fila['CliId'];
					$TallerPedido->TdoId = $fila['TdoId'];
					$TallerPedido->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					$TallerPedido->CliDireccion = $fila['CliDireccion'];
					
					$TallerPedido->FimObsequio = $fila['FimObsequio'];
					$TallerPedido->AlmNombre = $fila['AlmNombre'];
					
					$TallerPedido->MonNombre = $fila['MonNombre'];
					$TallerPedido->MonSimbolo = $fila['MonSimbolo'];
					
					$TallerPedido->GreId = $fila['GreId'];
					$TallerPedido->GrtId = $fila['GrtId'];
					$TallerPedido->GrtNumero = $fila['GrtNumero'];

                    $TallerPedido->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $TallerPedido;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		

   public function MtdObtenerTallerPedidosValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaAccion=NULL,$oFichaIngreso=NULL,$oConFactura=0,$oConFicha=0,$oFichaIngresoEstado=NULL,$oConBoleta=NULL,$oPorFacturar=false,$oModalidad=NULL,$oPersonal=NULL,$oSucursal=NULL) {

		// Inicializar variables para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$fechaInicio = '';
		$fechaFin = '';
		$estado = '';
		$fichaAccion = '';
		$fichaIngreso = '';
		$conFactura = '';
		$conFicha = '';
		$fichaIngresoEstado = '';
		$conBoleta = '';
		$porFacturar = '';
		$modalidad = '';
		$personal = '';
		$sucursal = '';

//echo "test";
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

			$elementos = explode(",",$oEstado);

			$i=1;
			$estado .= ' AND (';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$estado .= '  (amo.AmoEstado = '.($elemento).')';
				if($i<>count($elementos)){						
					$estado .= ' OR ';	
				}
			$i++;		
			}

			$estado .= ' ) ';

		}
		
		
//		if(!empty($oEstado)){
//			$estado = ' AND amo.AmoEstado = '.$oEstado;
//		}
		

		if(!empty($oFichaAccion)){
			$faccion = ' AND amo.FccId = "'.$oFichaAccion.'"';
		}
		

		//if(!empty($oFichaIngreso)){
//			$fingreso = ' AND fim.FinId = "'.$oFichaIngreso.'"';
//		}
//		
		if(!empty($oFichaIngreso)){
			$fingreso = ' AND fim.FinId = "'.$oFichaIngreso.'"';
		}		


		if(($oConFactura==1)){
			$confactura = ' AND  EXISTS ( 
				SELECT fac.FacId FROM tblfacfactura fac WHERE fac.AmoId = amo.AmoId LIMIT 1
			 )';
		}elseif($oConFactura==2){
			$confactura = ' AND  NOT EXISTS ( 
				SELECT fac.FacId FROM tblfacfactura fac WHERE fac.AmoId = amo.AmoId LIMIT 1
			 )';
		}
		
		if(($oConFicha==1)){
			$conficha = ' AND  amo.FccId IS NOT NULL ';
		}elseif($oConFicha==2){
			$conficha = ' AND  amo.FccId IS NULL ';
		}

		if(!empty($oFichaIngresoEstado)){
			$fiestado = ' AND fin.FinEstado = '.$oFichaIngresoEstado;
		}	
		

		if(($oConBoleta==1)){
			$conboleta = ' AND  EXISTS ( 
				SELECT bol.BolId FROM tblbolboleta bol WHERE bol.AmoId = amo.AmoId LIMIT 1
			 )';
		}elseif($oConBoleta==2){
			$conboleta = ' AND  NOT EXISTS ( 
				SELECT bol.BolId FROM tblbolboleta bol WHERE bol.AmoId = amo.AmoId LIMIT 1
			 )';
		}
		
		if(($oPorFacturar)){
			$pfacturar = ' AND (
					
					(fin.FinEstado = 75) 
					OR (fin.FinEstado = 9 
						AND NOT EXISTS ( 
							SELECT bol.BolId FROM tblbolboleta bol WHERE bol.AmoId = amo.AmoId LIMIT 1
						)
						AND NOT EXISTS ( 
							SELECT fac.FacId FROM tblfacfactura fac WHERE fac.AmoId = amo.AmoId LIMIT 1
						)
				 	)
				)
			';
		}			


		if(!empty($oModalidad)){

			$elementos = explode(",",$oModalidad);

			$i=1;
			$modalidad .= ' AND (';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$modalidad .= '  (fim.MinId = "'.($elemento).'")';
				if($i<>count($elementos)){						
					$modalidad .= ' OR ';	
				}
			$i++;		
			}

			$modalidad .= ' ) ';

		}
		
		
		if(!empty($oPersonal)){
			$personal = ' AND fin.PerId = "'.$oPersonal.'"';
		}	
		
		
		if(!empty($oSucursal)){
			$sucursal = ' AND fin.SucId = "'.$oSucursal.'"';
		}	
		
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(amo.AmoFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(amo.AmoFecha) ="'.($oAno).'"';
		}
		
		
			$sql = 'SELECT
				'.$funcion.' AS "RESULTADO"
				
				FROM tblamoalmacenmovimiento amo
					LEFT JOIN tbltoptipooperacion top
					ON amo.TopId = top.TopId
						LEFT JOIN tblfccfichaaccion fcc
						ON amo.FccId = fcc.FccId
							LEFT JOIN tblfimfichaingresomodalidad fim
							ON fcc.FimId = fim.FimId
								LEFT JOIN tblminmodalidadingreso min
								ON fim.MinId = min.MinId
									LEFT JOIN tblfinfichaingreso fin
									ON fim.FinId = fin.FinId
									
						LEFT JOIN tblclicliente cli
						ON fin.CliId = cli.CliId
							LEFT JOIN tbllticlientetipo lti
							ON cli.LtiId = lti.LtiId
							
										LEFT JOIN tbleinvehiculoingreso ein
										ON fin.EinId = ein.EinId
									
											LEFT JOIN tblvvevehiculoversion vve
											ON ein.VveId = vve.VveId
												LEFT JOIN tblvmovehiculomodelo vmo
												ON ein.VmoId = vmo.VmoId
													LEFT JOIN tblvmavehiculomarca vma
													ON vmo.Vmaid = vma.VmaId	
													
										LEFT JOIN tblcprcotizacionproducto cpr
										ON amo.CprId = cpr.CprId
				WHERE 
				amo.AmoTipo = 2  
				AND amo.AmoSubTipo = 2
				'.$filtrar.$fecha.$tipo.$stipo.$estado.$faccion.$sucursal .$fingreso.$confactura.$personal.$conficha.$fiestado.$conboleta.$concrepuesto.$crestado.$pfacturar.$modalidad.$orden.$paginacion;


			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];
			
		}
		

	
	//Accion eliminar	 
	public function MtdEliminarTallerPedido($oElementos,$oTransaccion=true) {
		
		if($oTransaccion){
			$this->InsMysql->MtdTransaccionIniciar();	
		}
		
		$InsTallerPedidoDetalle = new ClsTallerPedidoDetalle($this->InsMysql);

		$error = false;
		
		$elementos = explode("#",$oElementos);

		$i=1;
		foreach($elementos as $elemento){
			
			if(!empty($elemento)){
				
				$aux = explode("%",$elemento);	
				$this->AmoId = $aux[0];
				
				//MtdObtenerTallerPedidoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTallerPedido=NULL,$oEstado=NULL,$oProducto=NULL,$oTallerPedidoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) {
				$ResTallerPedidoDetalle = $InsTallerPedidoDetalle->MtdObtenerTallerPedidoDetalles(NULL,NULL,NULL,'AmdId','Desc',NULL,$this->AmoId);
				$ArrTallerPedidoDetalles = $ResTallerPedidoDetalle['Datos'];

				if(!empty($ArrTallerPedidoDetalles)){
					$amdetalle = '';

					foreach($ArrTallerPedidoDetalles as $DatTallerPedidoDetalle){
						$amdetalle .= '#'.$DatTallerPedidoDetalle->AmdId;
					}

					if(!$InsTallerPedidoDetalle->MtdEliminarTallerPedidoDetalle($amdetalle)){								
						$error = true;
					}
						
				}
				
				//$this->MtdObtenerTallerPedido();
//
//				if(!empty($this->FinId)){
//
//					$InsFichaIngreso = new ClsFichaIngreso();
//					$InsFichaIngreso->FinId = $this->FinId;
//
//					if(!$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,3,false)){
//						$error = false;
//					}
//
//				}
						
				
				if(!$error) {		
					$sql = 'DELETE FROM tblamoalmacenmovimiento WHERE  (AmoId = "'.($this->AmoId).'" ) ';
												
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
				
					if(!$resultado) {						
						$error = true;
					}else{
						
						
						$this->MtdAuditarTallerPedido(3,"Se elimino el PEDIDO DE TALLER",$aux);		
					}
				}
				
			}
		$i++;

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
			return true;
		}							
	}
	
	
	//Accion eliminar	 
	public function MtdActualizarEstadoTallerPedido($oElementos,$oEstado,$oTransaccion=true) {

		$error = false;
		
		if($oTransaccion){
			$this->InsMysql->MtdTransaccionIniciar();	
		}
	
		$elementos = explode("#",$oElementos);

		$InsTallerPedido = new ClsTallerPedido($this->InsMysql);
		$InsTallerPedidoDetalles = new ClsTallerPedidoDetalle($this->InsMysql);

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				//$aux = explode("%",$elemento);	

					$sql = 'UPDATE tblamoalmacenmovimiento SET AmoEstado = '.$oEstado.' WHERE AmoId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->AmoId = $elemento;
						$this->MtdAuditarTallerPedido(2,"Se actualizo el Estado del PEDIDO DE TALLER",$elemento);
					}
					
				}
			$i++;
	
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
				return true;
			}									

	}
	
	
	public function MtdRegistrarTallerPedido() {

		global $Resultado;

		$error = false;

		if($this->Transaccion){
			$this->InsMysql->MtdTransaccionIniciar();			
		}
			
			$InsAlmacenStock = new ClsAlmacenStock();
			
			$this->MtdGenerarTallerPedidoId();

			$sql = 'INSERT INTO tblamoalmacenmovimiento (
			AmoId,		
			SucId,
					
			PerId,
			
			CliId,
			
			FccId,
			TopId,
			
			CprId,
			VdiId,
			
			AmoIncluyeImpuesto,
			AmoPorcentajeImpuestoVenta,
			AmoPorcentajeMantenimiento,
				
			NpaId,
			AmoCantidadDia,
			
			LtiId,

			AmoTipo,
			AmoSubTipo,

			TalId,
			
			AlmId,
			AmoIdOrigen,
			
			AmoFecha,
			MonId,
			AmoTipoCambio,
			AmoGuiaRemisionNumero,
			AmoGuiaRemisionFecha,
			AmoObservacion,
			AmoDescuento,
			AmoSubTotal,
			AmoImpuesto,
			AmoTotal,
			
			AmoCancelado,
			AmoRevisado,
			AmoFacturable,
			AmoEstado,	
					
			AmoTiempoCreacion,
			AmoTiempoModificacion) 
			VALUES (
			"'.($this->AmoId).'", 
			'.(empty($this->SucId)?'NULL, ':'"'.$this->SucId.'",').'
			
			NULL,
			
			'.(empty($this->CliId)?'NULL, ':'"'.$this->CliId.'",').'
			
			'.(empty($this->FccId)?'NULL, ':'"'.$this->FccId.'",').'
			'.(empty($this->TopId)?'NULL, ':'"'.$this->TopId.'",').'
			
			NULL,
			NULL,		
			
			'.($this->AmoIncluyeImpuesto).',
			'.($this->AmoPorcentajeImpuestoVenta).',
			'.($this->AmoPorcentajeMantenimiento).',
			
			
			NULL,
			0,
			
			'.(empty($this->LtiId)?'NULL, ':'"'.$this->LtiId.'",').'
			
			2,
			2,
			
			NULL,
			
			'.(empty($this->AlmId)?'NULL, ':'"'.$this->AlmId.'",').'
			NULL,
			
			"'.($this->AmoFecha).'", 
			"'.($this->MonId).'", 
			'.(empty($this->AmoTipoCambio)?'NULL, ':'"'.$this->AmoTipoCambio.'",').'
			NULL, 
			NULL,
			"'.($this->AmoObservacion).'",
			'.($this->AmoDescuento).',
			0,
			0,
			'.($this->AmoTotal).',
			
			2,
			0,
			1,
			'.($this->AmoEstado).',
			
			"'.($this->AmoTiempoCreacion).'", 				
			"'.($this->AmoTiempoModificacion).'");';
				
//'.($this->AmoSubTipo).',
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
					
			if(!$error){			

				if (!empty($this->TallerPedidoDetalle)){		
						
					$validar = 0;				
					$InsTallerPedidoDetalle = new ClsTallerPedidoDetalle($this->InsMysql);		
					
					foreach ($this->TallerPedidoDetalle as $DatTallerPedidoDetalle){
						
						
						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $DatTallerPedidoDetalle->ProId;
						$InsProducto->MtdObtenerProducto(false);
						
						$InsTallerPedidoDetalle->AmoId = $this->AmoId;
						$InsTallerPedidoDetalle->ProId = $DatTallerPedidoDetalle->ProId;
						$InsTallerPedidoDetalle->UmeId = $DatTallerPedidoDetalle->UmeId;
	
						$InsTallerPedidoDetalle->VddId = $DatTallerPedidoDetalle->VddId;
						
						$InsTallerPedidoDetalle->FaaId = $DatTallerPedidoDetalle->FaaId;
						$InsTallerPedidoDetalle->FapId = $DatTallerPedidoDetalle->FapId;

						$InsTallerPedidoDetalle->AmdCosto = $DatTallerPedidoDetalle->AmdCosto;
						$InsTallerPedidoDetalle->AmdCostoExtraTotal = $DatTallerPedidoDetalle->AmdCostoExtraTotal;
						$InsTallerPedidoDetalle->AmdCantidad = $DatTallerPedidoDetalle->AmdCantidad;
						$InsTallerPedidoDetalle->AmdCantidadReal = $DatTallerPedidoDetalle->AmdCantidadReal;
						$InsTallerPedidoDetalle->AmdCantidadRealAnterior = $DatTallerPedidoDetalle->AmdCantidadRealAnterior;
						
						$InsTallerPedidoDetalle->AmdValorTotal = $DatTallerPedidoDetalle->AmdValorTotal;
						$InsTallerPedidoDetalle->AmdUtilidad = $DatTallerPedidoDetalle->AmdUtilidad;
						$InsTallerPedidoDetalle->AmdPrecioVenta = $DatTallerPedidoDetalle->AmdPrecioVenta;
						
						$InsTallerPedidoDetalle->AmdImporte = $DatTallerPedidoDetalle->AmdImporte;
						$InsTallerPedidoDetalle->AmdReingreso = $DatTallerPedidoDetalle->AmdReingreso;
						$InsTallerPedidoDetalle->AmdCompraOrigen = $DatTallerPedidoDetalle->AmdCompraOrigen;
						//$InsTallerPedidoDetalle->AmdEstado = 3;
						$InsTallerPedidoDetalle->AmdValidarStock = $DatTallerPedidoDetalle->AmdValidarStock;			
						$InsTallerPedidoDetalle->AmdEstado = $DatTallerPedidoDetalle->AmdEstado;			
						//$InsTallerPedidoDetalle->AmdEstado = $this->AmoEstado;									
						$InsTallerPedidoDetalle->AmdTiempoCreacion = $DatTallerPedidoDetalle->AmdTiempoCreacion;
						$InsTallerPedidoDetalle->AmdTiempoModificacion = $DatTallerPedidoDetalle->AmdTiempoModificacion;						
						$InsTallerPedidoDetalle->AmdEliminado = $DatTallerPedidoDetalle->AmdEliminado;
						
						$InsTallerPedidoDetalle->AlmId = $DatTallerPedidoDetalle->AlmId;
						$InsTallerPedidoDetalle->AmdFecha = $DatTallerPedidoDetalle->AmdFecha;
						
						$StockReal = 0;
						$Fecha = explode("/",$this->AmoFecha);
						$Ano = $Fecha[2];
						
						
						
						
						$GuardarDetalle = true;
						
						if(empty($InsTallerPedidoDetalle->AlmId)){
							
							$GuardarDetalle = false;
							$Resultado.='#ERR_TPE_209';		
							
						}
						
						
						if( ($InsTallerPedidoDetalle->AmdFecha) == "0000-00-00" or ($InsTallerPedidoDetalle->AmdFecha) == "00/00/0000"){
//
							$GuardarDetalle = false;
							$Resultado.='#ERR_TPE_210';		
//							
						}
						
						//if($InsTallerPedidoDetalle->AmdEstado==3 and $InsTallerPedidoDetalle->AmdEliminado == 1 and ($InsTallerPedidoDetalle->AmdValidarStock == 1 or empty($InsTallerPedidoDetalle->AmdValidarStock))){
//							
//							$StockReal = 0;
//							$Fecha = explode("-",$InsTallerPedidoDetalle->AmdFecha);
//							$Ano = $Fecha[0];
//							
//							$InsAlmacenProducto = new ClsAlmacenProducto();
//							//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
//							$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsTallerPedidoDetalle->ProId,$InsTallerPedidoDetalle->AlmId,$Ano,$InsTallerPedido->SucId);
//							
//							if( ($StockReal + $InsTallerPedidoDetalle->AmdCantidadRealAnterior) < $InsTallerPedidoDetalle->AmdCantidadReal ){
//								$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
//								$Resultado.='#ERR_TPE_208';		
//								$GuardarDetalle = false;
//							}
//							
//						}
						
						if($GuardarDetalle){
							
							$StockReal = $InsAlmacenStock->MtdObtenerAlmacenStockProductoStockReal($this->SucId,$this->AlmId,$Ano,$InsTallerPedidoDetalle->ProId);
							
							if( $StockReal < $InsTallerPedidoDetalle->AmdCantidadReal and $InsTallerPedidoDetalle->AmdEliminado == 1 and $InsTallerPedidoDetalle->AmdEstado == 3){
	
								$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
								$Resultado.='#ERR_TPE_208';												 
								
							}else{
								
								if($InsTallerPedidoDetalle->MtdRegistrarTallerPedidoDetalle()){
									$validar++;	
								}else{
									$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
									$Resultado.='#ERR_TPE_201';
								}
								
							}
							
							
						}
						
						

					}					
					
					if(count($this->TallerPedidoDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
						
	
			if($error) {	
			
				if($this->Transaccion){
					$this->InsMysql->MtdTransaccionDeshacer();			
				}
				return false;
			} else {				
				if($this->Transaccion){
					$this->InsMysql->MtdTransaccionHacer();		
				}
				$this->MtdAuditarTallerPedido(1,"Se registro el PEDIDO DE TALLER",$this);			
				return true;
			}			
					
	}
	
	public function MtdEditarTallerPedido() {

		global $Resultado;
		$error = false;

		if($this->Transaccion){
			$this->InsMysql->MtdTransaccionIniciar();
		}
		
		$InsAlmacenStock = new ClsAlmacenStock();
		
		$InsFichaAccion = new ClsFichaAccion($this->InsMysql);
		$InsFichaAccion->FccId = $this->FccId;
		$InsFichaAccion->MtdObtenerFichaAccion();

		$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad($this->InsMysql);
		$InsFichaIngresoModalidad->FimId = $InsFichaAccion->FimId;
		$InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidad();

		$InsModalidadIngreso = new ClsModalidadIngreso();
		$InsModalidadIngreso->MinId = $InsFichaIngresoModalidad->MinId;
		$InsModalidadIngreso->MtdObtenerModalidadIngreso();

		/**
		'.(empty($this->CliId)?'CliId = NULL, ':'CliId = "'.$this->CliId.'",').'
		'.(empty($this->TopId)?'TopId = NULL, ':'TopId = "'.$this->TopId.'",').'
		AmoFecha = "'.($this->AmoFecha).'",
		AmoObservacion = "'.($this->AmoObservacion).'"		
		AmoEstado = '.($this->AmoEstado).',
		*/
		
		$sql = 'UPDATE tblamoalmacenmovimiento SET
		
		'.(empty($this->AlmId)?'AlmId = NULL, ':'AlmId = "'.$this->AlmId.'",').'
		AmoFecha = "'.($this->AmoFecha).'",
		MonId = "'.($this->MonId).'",
		'.(empty($this->AmoTipoCambio)?'AmoTipoCambio = NULL, ':'AmoTipoCambio = "'.$this->AmoTipoCambio.'",').'

		AmoPorcentajeImpuestoVenta = '.($this->AmoPorcentajeImpuestoVenta).',
		AmoPorcentajeMantenimiento = '.($this->AmoPorcentajeMantenimiento).',

		AmoFecha = "'.($this->AmoFecha).'",
		AmoTotal = '.($this->AmoTotal).',
		AmoDescuento = '.($this->AmoDescuento).',
		
		AmoTiempoModificacion = "'.($this->AmoTiempoModificacion).'"
		WHERE AmoId = "'.($this->AmoId).'";';			


		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

		if(!$resultado) {							
			$error = true;
		} 			
		
//		$Resultado.='#\n';//
//		$Resultado.='#::: Modalidad de Ingreso: '.strtoupper($InsModalidadIngreso->MinNombre);
		//$Resultado.='#Modalidad de Ingreso: '.strtoupper($InsModalidadIngreso->MinNombre);

			
		//deb(count($this->TallerPedidoDetalle));
	  
		if(!$error){
			
		//	deb($this->TallerPedidoDetalle);
				if (!empty($this->TallerPedidoDetalle)){		

					$validar = 0;	
					$item = 1;			
					
							
					//($this->TallerPedidoDetalle);
					foreach ($this->TallerPedidoDetalle as $DatTallerPedidoDetalle){
										
						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $DatTallerPedidoDetalle->ProId;
						$InsProducto->MtdObtenerProducto(false);
						
//							$InsFichaAccionProducto1 = new ClsFichaAccionProducto($this->InsMysql);
//							$InsFichaAccionProducto1->FapId = $DatTallerPedidoDetalle->FapId;
//							$InsFichaAccionProducto1->FccId = $this->FccId;
//							$InsFichaAccionProducto1->ProId = $DatTallerPedidoDetalle->ProId;
//							$InsFichaAccionProducto1->UmeId = $DatTallerPedidoDetalle->UmeId;
//							$InsFichaAccionProducto1->FapAccion = "";
//							$InsFichaAccionProducto1->FapVerificar1 = 1;
//							$InsFichaAccionProducto1->FapVerificar2 = 1;
//							$InsFichaAccionProducto1->FapCantidad = $DatTallerPedidoDetalle->AmdCantidad;
//							$InsFichaAccionProducto1->FapCantidadReal = $DatTallerPedidoDetalle->AmdCantidadReal;
//
//							$InsFichaAccionProducto1->FapEstado = 1;
//							$InsFichaAccionProducto1->FapTiempoCreacion = date("Y-m-d H:i:s");
//							$InsFichaAccionProducto1->FapTiempoModificacion = date("Y-m-d H:i:s");
//							$InsFichaAccionProducto1->FapEliminado = $DatTallerPedidoDetalle->AmdEliminado;				
//						
//							if(empty($InsFichaAccionProducto1->FapId)){
//								
//								$InsFichaAccionProducto1->MtdRegistrarFichaAccionProducto();
//								
//								$InsTallerPedidoDetalle->FapId = $InsFichaAccionProducto1->FapId;								
//								
//							}else{
//								$InsFichaAccionProducto1->MtdEditarFichaAccionProducto();
//								
//								$InsTallerPedidoDetalle->FapId = $DatTallerPedidoDetalle->FapId;
//								
//							}
							
						$InsTallerPedidoDetalle = new ClsTallerPedidoDetalle($this->InsMysql);
						$InsTallerPedidoDetalle->AmdId = $DatTallerPedidoDetalle->AmdId;
						$InsTallerPedidoDetalle->AmoId = $this->AmoId;
						$InsTallerPedidoDetalle->ProId = $DatTallerPedidoDetalle->ProId;
						$InsTallerPedidoDetalle->UmeId = $DatTallerPedidoDetalle->UmeId;

						$InsTallerPedidoDetalle->VddId = $DatTallerPedidoDetalle->VddId;
						$InsTallerPedidoDetalle->FaaId = $DatTallerPedidoDetalle->FaaId;
						$InsTallerPedidoDetalle->FapId = $DatTallerPedidoDetalle->FapId;

						$InsTallerPedidoDetalle->AmdCosto = $DatTallerPedidoDetalle->AmdCosto;
						$InsTallerPedidoDetalle->AmdCostoExtraTotal = $DatTallerPedidoDetalle->AmdCostoExtraTotal;
						$InsTallerPedidoDetalle->AmdCantidad = $DatTallerPedidoDetalle->AmdCantidad;
						$InsTallerPedidoDetalle->AmdCantidadReal = $DatTallerPedidoDetalle->AmdCantidadReal;
						$InsTallerPedidoDetalle->AmdCantidadRealAnterior = $DatTallerPedidoDetalle->AmdCantidadRealAnterior;

						$InsTallerPedidoDetalle->AmdValorTotal = $DatTallerPedidoDetalle->AmdValorTotal;
						$InsTallerPedidoDetalle->AmdUtilidad = $DatTallerPedidoDetalle->AmdUtilidad;
						$InsTallerPedidoDetalle->AmdPrecioVenta = $DatTallerPedidoDetalle->AmdPrecioVenta;
						$InsTallerPedidoDetalle->AmdImporte = $DatTallerPedidoDetalle->AmdImporte;
						//$InsTallerPedidoDetalle->AmdEstado = 3;
						$InsTallerPedidoDetalle->AmdReingreso = $DatTallerPedidoDetalle->AmdReingreso;
						$InsTallerPedidoDetalle->AmdCompraOrigen = $DatTallerPedidoDetalle->AmdCompraOrigen;
						$InsTallerPedidoDetalle->AmdValidarStock = $DatTallerPedidoDetalle->AmdValidarStock;	
						$InsTallerPedidoDetalle->AmdEstado = $DatTallerPedidoDetalle->AmdEstado;						
						//$InsTallerPedidoDetalle->AmdEstado = $DatTallerPedidoDetalle->AmdEstado;
						//$InsTallerPedidoDetalle->AmdEstado = $this->AmoEstado;		
						$InsTallerPedidoDetalle->AmdTiempoCreacion = $DatTallerPedidoDetalle->AmdTiempoCreacion;
						$InsTallerPedidoDetalle->AmdTiempoModificacion = $DatTallerPedidoDetalle->AmdTiempoModificacion;
						$InsTallerPedidoDetalle->AmdEliminado = $DatTallerPedidoDetalle->AmdEliminado;
						
						$InsTallerPedidoDetalle->FichaAccionMantenimiento = $DatTallerPedidoDetalle->FichaAccionMantenimiento;
						
						$InsTallerPedidoDetalle->AlmId = $DatTallerPedidoDetalle->AlmId;
						$InsTallerPedidoDetalle->AmdFecha = $DatTallerPedidoDetalle->AmdFecha;
						
						
						

						//deb($InsTallerPedidoDetalle->AmdEliminado);
						if(empty($InsTallerPedidoDetalle->AmdId)){
							if($InsTallerPedidoDetalle->AmdEliminado<>2){
								
//								deb("a".$InsTallerPedidoDetalle->AmdCantidadReal);
								
								if(!empty($InsTallerPedidoDetalle->ProId)){
									if(!empty($InsTallerPedidoDetalle->UmeId)){
										if(!empty($InsTallerPedidoDetalle->AmdCantidad)){
											if(!empty($InsTallerPedidoDetalle->AmdCantidadReal)){
												
													$GuardarDetalle = true;
													
													if(empty($InsTallerPedidoDetalle->AlmId)){
														$GuardarDetalle = false;
														$Resultado.='#ERR_TPE_209';		
													}
													

													if( ($InsTallerPedidoDetalle->AmdFecha) == "0000-00-00" or ($InsTallerPedidoDetalle->AmdFecha) == "00/00/0000" or ($InsTallerPedidoDetalle->AmdFecha)==""){
							//
														$GuardarDetalle = false;
														$Resultado.='#ERR_TPE_210';		
							//							
													}
													
													
													//if($InsTallerPedidoDetalle->AmdEstado==3 and $InsTallerPedidoDetalle->AmdEliminado == 1 and ($InsTallerPedidoDetalle->AmdValidarStock == 1 or empty($InsTallerPedidoDetalle->AmdValidarStock))){
//														
//														$StockReal = 0;
//														$Fecha = explode("-",$InsTallerPedidoDetalle->AmdFecha);
//														$Ano = $FeScha[0];
//														
//														$InsAlmacenProducto = new ClsAlmacenProducto();
//														//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
//														$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsTallerPedidoDetalle->ProId,$InsTallerPedidoDetalle->AlmId,$Ano,$InsTallerPedido->SucId);
//														
//														if( ($StockReal + $InsTallerPedidoDetalle->AmdCantidadRealAnterior) < $InsTallerPedidoDetalle->AmdCantidadReal ){
//															$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
//															$Resultado.='#ERR_TPE_208';		
//															$GuardarDetalle = false;
//														}
//														
//													}
													
													if($GuardarDetalle){
														
														$StockReal = 0;
														$Fecha = explode("/",$this->AmoFecha);
														$Ano = $Fecha[2];
														
														$StockReal = $InsAlmacenStock->MtdObtenerAlmacenStockProductoStockReal($this->SucId,$this->AlmId,$Ano,$InsTallerPedidoDetalle->ProId);
														$StockReal = 10000;
				
														if( ($StockReal) < $InsTallerPedidoDetalle->AmdCantidadReal and $InsTallerPedidoDetalle->AmdEliminado == 1 and $InsTallerPedidoDetalle->AmdEstado == 3){
								
															$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
															$Resultado.='#ERR_TPE_208';												 
															
														}else{
															
															if($InsTallerPedidoDetalle->MtdRegistrarTallerPedidoDetalle()){
																$validar++;	
															}else{
																$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
																$Resultado.='#ERR_TPE_201';
															}
															
														}
														
													}
						
											}else{
												 $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
												$Resultado.='#ERR_TPE_205';
											}
										}else{
											 $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
											$Resultado.='#ERR_TPE_207';
										}
									}else{
										 $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
										$Resultado.='#ERR_TPE_204';
									}
								}else{
									
									 $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
									$Resultado.='#ERR_TPE_206';
								}
											
							}else{
								$validar++;
							}
						}else{				
								
							if($InsTallerPedidoDetalle->AmdEliminado==2){

								if($InsTallerPedidoDetalle->MtdEliminarTallerPedidoDetalle($InsTallerPedidoDetalle->AmdId)){
									
									if(!empty($DatTallerPedidoDetalle->FapId)){
										
										$InsFichaAccionProducto1 = new ClsFichaAccionProducto($this->InsMysql);
										$InsFichaAccionProducto1->MtdEliminarFichaAccionProducto($DatTallerPedidoDetalle->FapId);	

									}
									
									$validar++;					
								}else{
									 $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
									$Resultado.='#ERR_TPE_203';
								}

							}else{
											
								//deb("b".$InsTallerPedidoDetalle->AmdCantidadReal);
								
								if(!empty($InsTallerPedidoDetalle->ProId)){
									if(!empty($InsTallerPedidoDetalle->UmeId)){
										if(!empty($InsTallerPedidoDetalle->AmdCantidad)){
											if(!empty($InsTallerPedidoDetalle->AmdCantidadReal)){
													
												
											
													$GuardarDetalle = true;
						
													if(empty($InsTallerPedidoDetalle->AlmId)){
														$GuardarDetalle = false;
														$Resultado.='#ERR_TPE_209';		
													}
													

													if( ($InsTallerPedidoDetalle->AmdFecha) == "0000-00-00" or ($InsTallerPedidoDetalle->AmdFecha) == "00/00/0000" or ($InsTallerPedidoDetalle->AmdFecha)==""){
							//
														$GuardarDetalle = false;
														$Resultado.='#ERR_TPE_210';		
							//							
													}
													
													
													
													//if($InsTallerPedidoDetalle->AmdEstado==3 and $InsTallerPedidoDetalle->AmdEliminado == 1 and ($InsTallerPedidoDetalle->AmdValidarStock == 1 or empty($InsTallerPedidoDetalle->AmdValidarStock))){
//														
//														$StockReal = 0;
//														$Fecha = explode("-",$InsTallerPedidoDetalle->AmdFecha);
//														$Ano = $Fecha[0];
//														
//														$InsAlmacenProducto = new ClsAlmacenProducto();
//														//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen=NULL,$oAno=NULL,$oSucursal)
//														$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsTallerPedidoDetalle->ProId,$InsTallerPedidoDetalle->AlmId,$Ano,$InsTallerPedido->SucId);
//														
//														if( ($StockReal + $InsTallerPedidoDetalle->AmdCantidadRealAnterior) < $InsTallerPedidoDetalle->AmdCantidadReal ){
//															$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
//															$Resultado.='#ERR_TPE_208';		
//															$GuardarDetalle = false;
//														}
//														
//													}
													
													if($GuardarDetalle){
														
															
														$StockReal = 0;
														$Fecha = explode("/",$this->AmoFecha);
														$Ano = $Fecha[2];
														
														$StockReal = $InsAlmacenStock->MtdObtenerAlmacenStockProductoStockReal($this->SucId,$this->AlmId,$Ano,$InsTallerPedidoDetalle->ProId);
														$StockReal = 10000;
														
														if( ($StockReal + $InsTallerPedidoDetalle->AmdCantidadRealAnterior) < $InsTallerPedidoDetalle->AmdCantidadReal and $InsTallerPedidoDetalle->AmdEliminado == 1 and $InsTallerPedidoDetalle->AmdEstado == 3){
								
															$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
															$Resultado.='#ERR_TPE_208';												 
															
														}else{
															
															
															if($InsTallerPedidoDetalle->MtdEditarTallerPedidoDetalle()){
																$validar++;	
															}else{
																$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
																$Resultado.='#ERR_TPE_201';
															}
															
														}
														
														
														
													}
													
												
								
											}else{
												 $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
												$Resultado.='#ERR_TPE_205';
											}
										}else{
											 $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
											$Resultado.='#ERR_TPE_207';
										}
	
									}else{
										 $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
										$Resultado.='#ERR_TPE_204';
									}
								}else{
								
									 $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
									$Resultado.='#ERR_TPE_206';
								}
								
							
							}
						}	
						
						$item++;								
					}
					
					if(count($this->TallerPedidoDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
		//deb(count($this->FichaAccionProducto));
			
		 if (!empty($this->FichaAccionProducto)){								

					$validar = 0;	
					$item = 1;			
					$InsFichaAccionProducto = new ClsFichaAccionProducto($this->InsMysql);
							
					foreach ($this->FichaAccionProducto as $DatFichaAccionProducto){
										
						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $DatFichaAccionProducto->ProId;
						$InsProducto->MtdObtenerProducto(false);
						
						$InsFichaAccionProducto->FapId = $DatFichaAccionProducto->FapId;
						$InsFichaAccionProducto->FccId = $this->FccId;
						$InsFichaAccionProducto->ProId = $DatFichaAccionProducto->ProId;
						$InsFichaAccionProducto->UmeId = $DatFichaAccionProducto->UmeId;
						
						$InsFichaAccionProducto->FaaId = $DatFichaAccionProducto->FaaId;
						
						$InsFichaAccionProducto->FapCantidad = ($DatFichaAccionProducto->FapCantidad+0);
						$InsFichaAccionProducto->FapCantidadReal = $DatFichaAccionProducto->FapCantidadReal;
						$InsFichaAccionProducto->FapVerificar1 = $DatFichaAccionProducto->FapVerificar1;
						$InsFichaAccionProducto->FapVerificar2 = $DatFichaAccionProducto->FapVerificar2;
						$InsFichaAccionProducto->FapEstado = $DatFichaAccionProducto->FapEstado;
						$InsFichaAccionProducto->FapTiempoCreacion = $DatFichaAccionProducto->FapTiempoCreacion;
						$InsFichaAccionProducto->FapTiempoModificacion = $DatFichaAccionProducto->FapTiempoModificacion;
						$InsFichaAccionProducto->FapEliminado = $DatFichaAccionProducto->FapEliminado;
						
									
									if(empty($InsFichaAccionProducto->FapId)){
										if($InsFichaAccionProducto->FapEliminado<>2){
											
											if(!empty($InsFichaAccionProducto->ProId)){
												if(!empty($InsFichaAccionProducto->UmeId)){
													if(!empty($InsFichaAccionProducto->FapCantidad)){
														if(!empty($InsFichaAccionProducto->FapCantidadReal)){

															if($InsFichaAccionProducto->MtdRegistrarFichaAccionProducto()){
																$validar++;	
															}else{
																// $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
																//$Resultado.='#ERR_TPE_211';
																/////$Resultado.='#\n';
															}
											
														}else{
															// $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
															//$Resultado.='#ERR_TPE_215';
															////$Resultado.='#\n';
														}
													}else{
															// $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
															//$Resultado.='#ERR_TPE_217';
															////$Resultado.='#\n';
													}
												}else{
													// $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
													//$Resultado.='#ERR_TPE_214';
													////$Resultado.='#\n';
												}
											}else{
												// $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
												//$Resultado.='#ERR_TPE_216';
												////$Resultado.='#\n';
											}
											
										}else{
											$validar++;
										}
										
									}else{	
														
										if($InsFichaAccionProducto->FapEliminado==2){
											if($InsFichaAccionProducto->MtdEliminarFichaAccionProducto($InsFichaAccionProducto->FapId)){
												$validar++;					
											}else{
												// $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
												//$Resultado.='#ERR_TPE_213';
												////$Resultado.='#\n';
												
											}
										}else{
											
											
											if(!empty($InsFichaAccionProducto->ProId)){
												if(!empty($InsFichaAccionProducto->UmeId)){
													if(!empty($InsFichaAccionProducto->FapCantidad)){
														if(!empty($InsFichaAccionProducto->FapCantidadReal)){
															
															if($InsFichaAccionProducto->MtdEditarFichaAccionProductoTaller()){
																$validar++;	
															}else{
																// $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
																//$Resultado.='#ERR_TPE_212';
																////$Resultado.='#\n';
															}
															
														}else{
															// $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
															//$Resultado.='#ERR_TPE_215';
															////$Resultado.='#\n';
														}
													}else{
															// $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
															//$Resultado.='#ERR_TPE_217';
															////$Resultado.='#\n';
													}
												}else{
													// $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
													//$Resultado.='#ERR_TPE_214';
													////$Resultado.='#\n';
												}
											}else{
												// $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
												//$Resultado.='#ERR_TPE_216';
												////$Resultado.='#\n';
											}
												
										}
										
									}
									
								

						$item++;							
					}
					
					if(count($this->FichaAccionProducto) <> $validar ){
						$error = true;
					}					
								
				}			
			
			
			
			
			
		
			if($error) {	
				if($this->Transaccion){
					$this->InsMysql->MtdTransaccionDeshacer();					
				}
				return false;
			} else {		
						
				if($this->Transaccion){	
					$this->InsMysql->MtdTransaccionHacer();				
				}
				$this->MtdAuditarTallerPedido(2,"Se edito el PEDIDO DE TALLER",$this);		
				return true;
			}	
				
		}	
		


	public function MtdVerificarExisteTallerPedido($oCampo,$oDato){

		$Respuesta =   NULL;
			
		 $sql = 'SELECT 
        AmoId
        FROM tblamoalmacenmovimiento 
        WHERE '.$oCampo.' = "'.$oDato.'" LIMIT 1;';

        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);
			
			if(!empty($fila['AmoId'])){
				$Respuesta = $fila['AmoId'];
			}

		}
        
		return $Respuesta;

    }
	
	
	
		private function MtdAuditarTallerPedido($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria($this->InsMysql);
			$InsAuditoria->AudCodigo = $this->AmoId;

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
}
?>