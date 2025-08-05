<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsAlmacenMovimientoSalida
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsAlmacenMovimientoSalida {

    public $AmoId;
	public $AmoTipo;
	public $FccId;
	
	public $AlmId;
	public $AmoFecha;
	public $TopId;

	public $VdiId;
	public $CprId;
	public $LtiId;
	
	public $AmoComprobanteNumero;
	public $AmoResponsable;
	
    public $AmoObservacion;
	public $AmoDescuento;
	public $AmoTotal;
	
	public $AmoFactura;
	public $AmoGuiaRemision;
	
	

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
	
	public $FimObsequio;
	
	public $AlmacenMovimientoSalidaDetalle;
		
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarAlmacenMovimientoSalidaId() {

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
		
    public function MtdObtenerAlmacenMovimientoSalida(){

		$sql = 'SELECT 
        amo.AmoId,  
		amo.FccId,
		
		amo.AlmId,
		DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
		amo.TopId,
		
		amo.VdiId,
		amo.CprId,
		
		amo.LtiId,

		amo.MonId,
		amo.AmoTipoCambio,
				
	
		amo.AmoComprobanteNumero,
		amo.AmoResponsable,
	
		amo.AmoObservacion,
		amo.AmoDescuento,
		
		amo.AmoIncluyeImpuesto,
		amo.AmoPorcentajeImpuestoVenta,
		
		amo.AmoSubTotal,
		amo.AmoImpuesto,
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
								
				
		amo.AmoEstado,
		DATE_FORMAT(amo.AmoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAmoTiempoCreacion",
        DATE_FORMAT(amo.AmoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAmoTiempoModificacion"
		
		FROM tblamoalmacenmovimiento amo

		WHERE amo.AmoId = "'.$this->AmoId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {

			$this->AmoId = $fila['AmoId'];
			$this->FccId = $fila['FccId'];
			
			$this->AlmId = $fila['AlmId'];
			$this->AmoFecha = $fila['NAmoFecha'];
			$this->TopId = $fila['TopId'];

			$this->VdiId = $fila['VdiId'];
			$this->CprId = $fila['CprId'];
			$this->LtiId = $fila['LtiId'];

			$this->MonId = $fila['MonId'];
			$this->AmoTipoCambio = $fila['AmoTipoCambio'];
			
			
			$this->AmoComprobanteNumero = $fila['AmoComprobanteNumero'];
			$this->AmoResponsable = $fila['AmoResponsable'];

			$this->AmoObservacion = $fila['AmoObservacion'];
			$this->AmoDescuento = $fila['AmoDescuento'];

			$this->AmoIncluyeImpuesto = $fila['AmoIncluyeImpuesto'];
			$this->AmoPorcentajeImpuestoVenta = $fila['AmoPorcentajeImpuestoVenta'];
			
			$this->AmoSubTotal = $fila['AmoSubTotal'];
			$this->AmoImpuesto = $fila['AmoImpuesto'];
			$this->AmoTotal = $fila['AmoTotal'];
			
			$this->AmoFactura = $fila['AmoFactura'];
			$this->AmoBoleta = $fila['AmoBoleta'];
			$this->AmoGuiaRemision = $fila['AmoGuiaRemision'];
			
			$this->AmoEstado = $fila['AmoEstado'];
			$this->AmoTiempoCreacion = $fila['NAmoTiempoCreacion']; 
			$this->AmoTiempoModificacion = $fila['NAmoTiempoModificacion']; 	

			
			
			
			switch($this->AmoEstado){
			
				case 1:
					$Estado = "No Realizado";
				break;
			
				case 3:
					$Estado = "Realizado";						
				break;	

				default:
					$Estado = "";
				break;
			
			}
				
			$this->AmoEstadoDescripcion = $Estado;
			
			
			switch($this->AmoEstado){
			
				case 1:
					$Estado = '<img width="15" height="15" alt="[No Realizado]" title="No Realizado" src="imagenes/estado/no_realizado.png" />';
				break;
			
				case 3:
					$Estado = '<img width="15" height="15" alt="[Enviado]" title="Enviado" src="imagenes/estado/realizado.gif" />';						
				break;	
				
				default:
					$Estado = "";
				break;
			
			}
				
			$this->AmoEstadoIcono = $Estado;




			$InsAlmacenMovimientoSalidaDetalle = new ClsAlmacenMovimientoSalidaDetalle();
			$ResAlmacenMovimientoSalidaDetalle =  $InsAlmacenMovimientoSalidaDetalle->MtdObtenerAlmacenMovimientoSalidaDetalles(NULL,NULL,NULL,"PmtOrden,AmdId","ASC",NULL,$this->AmoId);
			$this->AlmacenMovimientoSalidaDetalle = 	$ResAlmacenMovimientoSalidaDetalle['Datos'];	

		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerAlmacenMovimientoSalidas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaAccion=NULL,$oFichaIngreso=NULL,$oConFactura=0,$oConFicha=0,$oFichaIngresoEstado=NULL,$oConBoleta=NULL,$oPorFacturar=false,$oModalidad=NULL,$oSubTipo=NULL,$oSucursal=NULL) {

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
				amo.FccId,	
				
				amo.AmoTipo,
				
				amo.AlmId,
				DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
				amo.TopId,
					
				amo.VdiId,
				amo.CprId,
					
				amo.LtiId,
				
				amo.MonId,
				amo.AmoTipoCambio,
				
				
		

				
				amo.AmoComprobanteNumero,
				amo.AmoResponsable,

				amo.AmoObservacion,
				amo.AmoDescuento,
				
				amo.AmoSubTotal,
				amo.AmoImpuesto,
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
				
				min.MinNombre,
				
				mon.MonNombre,
				mon.MonSimbolo
				
				FROM tblamoalmacenmovimiento amo
					LEFT JOIN tbltoptipooperacion top
					ON amo.TopId = top.TopId
						LEFT JOIN tblfccfichaaccion fcc
						ON amo.FccId = fcc.FccId
							LEFT JOIN tblfimfichaingresomodalidad fim
							ON fcc.FimId = fim.FimId
								LEFT JOIN tblfinfichaingreso fin
								ON fim.FinId = fin.FinId
									LEFT JOIN tblminmodalidadingreso min
									ON fim.MinId = min.MinId
										LEFT JOIN tblmonmoneda mon
										ON amo.MonId = mon.MonId
				WHERE amo.AmoTipo = 2 
			
				'.$filtrar.$fecha.$tipo.$stipo.$estado.$faccion.$fingreso.$confactura.$conficha.$fiestado.$conboleta.$concrepuesto.$crestado.$pfacturar.$modalidad.$amsubtipo.$orden.$paginacion;


			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsAlmacenMovimientoSalida = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$AlmacenMovimientoSalida = new $InsAlmacenMovimientoSalida();
                    $AlmacenMovimientoSalida->AmoId = $fila['AmoId'];
					$AlmacenMovimientoSalida->FccId = $fila['FccId'];
					
					$AlmacenMovimientoSalida->AlmId = $fila['AlmId'];
					$AlmacenMovimientoSalida->AmoFecha = $fila['NAmoFecha'];
					$AlmacenMovimientoSalida->TopId = $fila['TopId'];
					
					$AlmacenMovimientoSalida->VdiId = $fila['VdiId'];
					$AlmacenMovimientoSalida->CprId = $fila['CprId'];
					$AlmacenMovimientoSalida->LtiId = $fila['NLtiId'];
					
					$AlmacenMovimientoSalida->MonId = $fila['MonId'];
					$AlmacenMovimientoSalida->AmoTipoCambio = $fila['AmoTipoCambio'];
			
						
					$AlmacenMovimientoSalida->AmoComprobanteNumero = $fila['AmoComprobanteNumero'];
					$AlmacenMovimientoSalida->AmoResponsable = $fila['AmoResponsable'];
			
					$AlmacenMovimientoSalida->AmoObservacion = $fila['AmoObservacion'];
					$AlmacenMovimientoSalida->AmoDescuento = $fila['AmoDescuento'];
					$AlmacenMovimientoSalida->AmoSubTotal = $fila['AmoSubTotal'];
					$AlmacenMovimientoSalida->AmoImpuesto = $fila['AmoImpuesto'];
					$AlmacenMovimientoSalida->AmoTotal = $fila['AmoTotal'];
					
					$AlmacenMovimientoSalida->AmoFichaIngreso = $fila['AmoFichaIngreso'];
					$AlmacenMovimientoSalida->AmoFactura = $fila['AmoFactura'];	
					$AlmacenMovimientoSalida->AmoBoleta = $fila['AmoBoleta'];	
									
					$AlmacenMovimientoSalida->AmoGuiaRemision = $fila['AmoGuiaRemision'];					
					
					$AlmacenMovimientoSalida->AmoCierre = $fila['AmoCierre'];
					$AlmacenMovimientoSalida->AmoEstado = $fila['AmoEstado'];
					$AlmacenMovimientoSalida->AmoTiempoCreacion = $fila['NAmoTiempoCreacion'];  
					$AlmacenMovimientoSalida->AmoTiempoModificacion = $fila['NAmoTiempoModificacion']; 

					$AlmacenMovimientoSalida->AmoTotalItems = $fila['AmoTotalItems']; 
					$AlmacenMovimientoSalida->AmoSinPrecio = $fila['AmoSinPrecio']; 
					
					$AlmacenMovimientoSalida->TopNombre = $fila['TopNombre']; 
					$AlmacenMovimientoSalida->FinId = $fila['FinId']; 
					$AlmacenMovimientoSalida->FinFecha = $fila['NFinFecha']; 
					$AlmacenMovimientoSalida->MinId = $fila['MinId']; 
					$AlmacenMovimientoSalida->MinSigla = $fila['MinSigla']; 
					$AlmacenMovimientoSalida->MinNombre = $fila['MinNombre']; 
					
					$AlmacenMovimientoSalida->FccManoObra = $fila['FccManoObra']; 
				
				
				
	
				
					$AlmacenMovimientoSalida->TdoId = $fila['TdoId']; 
					
					$AlmacenMovimientoSalida->CliNombreCompleto = $fila['CliNombreCompleto'];
					$AlmacenMovimientoSalida->CliNombre = $fila['CliNombre'];
					$AlmacenMovimientoSalida->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$AlmacenMovimientoSalida->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					
				
 
					$AlmacenMovimientoSalida->CliNumeroDocumento = $fila['CliNumeroDocumento'];

					$AlmacenMovimientoSalida->LtiUtilidad = $fila['LtiUtilidad']; 
					$AlmacenMovimientoSalida->LtiNombre = $fila['LtiNombre']; 
					
				
					$AlmacenMovimientoSalida->EinVIN = $fila['EinVIN'];
					$AlmacenMovimientoSalida->VmaId = $fila['VmaId'];
					$AlmacenMovimientoSalida->VmoId = $fila['VmoId'];
					$AlmacenMovimientoSalida->VveId = $fila['VveId'];
					$AlmacenMovimientoSalida->EinAnoFabricacion = $fila['EinAnoFabricacion'];
					$AlmacenMovimientoSalida->EinPlaca = $fila['EinPlaca'];
					$AlmacenMovimientoSalida->EinColor = $fila['EinColor'];
					
					$AlmacenMovimientoSalida->VmaNombre = $fila['VmaNombre'];
					$AlmacenMovimientoSalida->VmoNombre = $fila['VmoNombre'];
					$AlmacenMovimientoSalida->VveNombre = $fila['VveNombre'];
					
					$AlmacenMovimientoSalida->CliId = $fila['CliId'];
					$AlmacenMovimientoSalida->TdoId = $fila['TdoId'];
					$AlmacenMovimientoSalida->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					$AlmacenMovimientoSalida->CliDireccion = $fila['CliDireccion'];
					
					$AlmacenMovimientoSalida->FimObsequio = $fila['FimObsequio'];
					
					$AlmacenMovimientoSalida->FinId = $fila['FinId'];
					$AlmacenMovimientoSalida->FinFecha = $fila['NFinFecha'];
					$AlmacenMovimientoSalida->MinNombre = $fila['MinNombre'];
					
					$AlmacenMovimientoSalida->MonNombre = $fila['MonNombre'];
					$AlmacenMovimientoSalida->MonSimbolo = $fila['MonSimbolo'];

				
				
				
			switch($AlmacenMovimientoSalida->AmoEstado){
			
				case 1:
					$Estado = "No Realizado";
				break;
			
				case 3:
					$Estado = "Realizado";						
				break;	

				default:
					$Estado = "";
				break;
			
			}
				
			$AlmacenMovimientoSalida->AmoEstadoDescripcion = $Estado;
			
			
			switch($AlmacenMovimientoSalida->AmoEstado){
			
				case 1:
					$Estado = '<img width="15" height="15" alt="[No Realizado]" title="No Realizado" src="imagenes/estado/no_realizado.png" />';
				break;
			
				case 3:
					$Estado = '<img width="15" height="15" alt="[Enviado]" title="Enviado" src="imagenes/estado/realizado.gif" />';						
				break;	
				
				default:
					$Estado = "";
				break;
			
			}
				
			$AlmacenMovimientoSalida->AmoEstadoIcono = $Estado;



                    $AlmacenMovimientoSalida->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $AlmacenMovimientoSalida;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
			
			

	
		}
		




   public function MtdObtenerAlmacenMovimientoSalidasValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaAccion=NULL,$oFichaIngreso=NULL,$oConFactura=0,$oConFicha=0,$oFichaIngresoEstado=NULL,$oConBoleta=NULL,$oPorFacturar=false,$oModalidad=NULL,$oSubTipo=NULL) {

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
				WHERE amo.AmoTipo = 2 '.$ano.$mes.$filtrar.$fecha.$tipo.$stipo.$estado.$faccion.$fingreso.$confactura.$conficha.$fiestado.$conboleta.$concrepuesto.$crestado.$pfacturar.$modalidad.$amsubtipo.$orden.$paginacion;
			
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];
			
		}
		
		
	
	//Accion eliminar	 
	public function MtdEliminarAlmacenMovimientoSalida($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsAlmacenMovimientoSalidaDetalle = new ClsAlmacenMovimientoSalidaDetalle();

		$error = false;
		
		$elementos = explode("#",$oElementos);

		$i=1;
		foreach($elementos as $elemento){
			
			if(!empty($elemento)){
				
				
				$this->AmoId = $elemento;
				
				$ResAlmacenMovimientoSalidaDetalle = $InsAlmacenMovimientoSalidaDetalle->MtdObtenerAlmacenMovimientoSalidaDetalles(NULL,NULL,NULL,'AmdId','Desc',NULL,$this->AmoId);
				$ArrAlmacenMovimientoSalidaDetalles = $ResAlmacenMovimientoSalidaDetalle['Datos'];

				if(!empty($ArrAlmacenMovimientoSalidaDetalles)){
					$amdetalle = '';

					foreach($ArrAlmacenMovimientoSalidaDetalles as $DatAlmacenMovimientoSalidaDetalle){
						$amdetalle .= '#'.$DatAlmacenMovimientoSalidaDetalle->AmdId;
					}

					if(!$InsAlmacenMovimientoSalidaDetalle->MtdEliminarAlmacenMovimientoSalidaDetalle($amdetalle)){								
						$error = true;
					}
						
				}
				
				$this->MtdObtenerAlmacenMovimientoSalida();

				if(!empty($this->FinId)){
					$InsFichaIngreso = new ClsFichaIngreso();
					$InsFichaIngreso->FinId = $this->FinId;
					
					if(!$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,3,false)){
						$error = false;
					}
				}
						
				
				if(!$error) {		
				
					$sql = 'DELETE FROM tblamoalmacenmovimiento WHERE  (AmoId = "'.($this->AmoId).'" ) ';
												
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
				
					if(!$resultado) {						
						$error = true;
					}else{
						
						
						$this->MtdAuditarAlmacenMovimientoSalida(3,"Se elimino el Movimiento de Almacen",$aux);		
					}
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
	
	
	//Accion eliminar	 
	public function MtdActualizarEstadoAlmacenMovimientoSalida($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		$InsAlmacenMovimientoSalida = new ClsAlmacenMovimientoSalida();
		$InsAlmacenMovimientoSalidaDetalle = new ClsAlmacenMovimientoSalidaDetalle();

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
		

					$ResAlmacenMovimientoSalidaDetalle = $InsAlmacenMovimientoSalidaDetalle->MtdObtenerAlmacenMovimientoSalidaDetalles(NULL,NULL,NULL,'AmdId','Desc',NULL,$elemento);
					$ArrAlmacenMovimientoSalidaDetalles = $ResAlmacenMovimientoSalidaDetalle['Datos'];
	
					if(!empty($ArrAlmacenMovimientoSalidaDetalles)){
						$amdetalle = '';
	
						foreach($ArrAlmacenMovimientoSalidaDetalles as $DatAlmacenMovimientoSalidaDetalle){
							$amdetalle .= '#'.$DatAlmacenMovimientoSalidaDetalle->AmdId;
						}
	
						if(!$InsAlmacenMovimientoSalidaDetalle->MtdActualizarEstadoAlmacenMovimientoSalidaDetalle($amdetalle,$oEstado)){								
							$error = true;
						}
							
					}
				
				
					if(!$error){

						$sql = 'UPDATE tblamoalmacenmovimiento SET AmoEstado = '.$oEstado.' WHERE AmoId = "'.$elemento.'"';
			
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
						
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarAlmacenMovimientoSalida(2,"Se actualizo el Estado del Movimiento de Almacen",$elemento);
					
						}
												
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
	
	
	public function MtdRegistrarAlmacenMovimientoSalida() {

		global $Resultado;

		$error = false;

			$this->MtdGenerarAlmacenMovimientoSalidaId();
//LtiId,
			$sql = 'INSERT INTO tblamoalmacenmovimiento (
			AmoId,				
			PerId,
			FccId,
			TopId,
			
			CprId,
			VdiId,
			
			NpaId,
			AmoCantidadDia,
				
			LtiId,
			
			AmoTipo,
			AmoSubTipo,
			
			TalId,
			PprId,
			
			AlmId,
			AmoIdOrigen,
			
			AmoFecha,
			MonId,
			AmoTipoCambio,
			AmoGuiaRemisionNumero,
			AmoGuiaRemisionFecha,
			
			AmoComprobanteNumero,
			AmoResponsable,
			
			AmoObservacion,
			AmoDescuento,
			AmoSubTotal,
			AmoImpuesto,
			AmoTotal,
			
			AmoCancelado,
			AmoRevisado,
			AmoFacturable,
			
			AmoCierre,
			AmoEstado,			
			AmoTiempoCreacion,
			AmoTiempoModificacion) 
			VALUES (
			"'.($this->AmoId).'", 
			NULL,
			NULL,
			'.(empty($this->TopId)?'NULL, ':'"'.$this->TopId.'",').'
			NULL,
			NULL,
			
			NULL,
			0,
			
			'.(empty($this->LtiId)?'NULL, ':'"'.$this->LtiId.'",').'
			
			2,
			'.($this->AmoSubTipo).',
			
			NULL,
			NULL,
			
			'.(empty($this->AlmId)?'NULL, ':'"'.$this->AlmId.'",').'
			NULL,
			
			"'.($this->AmoFecha).'", 
			'.(empty($this->MonId)?'NULL, ':'"'.$this->MonId.'",').'
			0, 			
			NULL, 
			NULL,
			
			"'.($this->AmoComprobanteNumero).'",
			"'.($this->AmoResponsable).'",
			
			"'.($this->AmoObservacion).'",
			0,
			'.($this->AmoSubTotal).',
			'.($this->AmoImpuesto).',	
			'.($this->AmoTotal).',
			2,
			0,
			1,
			
			2,
			'.($this->AmoEstado).',
			"'.($this->AmoTiempoCreacion).'", 				
			"'.($this->AmoTiempoModificacion).'");';			
//'.($this->AmoSubTipo).',
			$this->InsMysql->MtdTransaccionIniciar();
//NULL,

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
					
			if(!$error){			

				if (!empty($this->AlmacenMovimientoSalidaDetalle)){		
						
					$validar = 0;				
					$InsAlmacenMovimientoSalidaDetalle = new ClsAlmacenMovimientoSalidaDetalle();		
					
					foreach ($this->AlmacenMovimientoSalidaDetalle as $DatAlmacenMovimientoSalidaDetalle){
					
						$InsAlmacenMovimientoSalidaDetalle->AmoId = $this->AmoId;
						$InsAlmacenMovimientoSalidaDetalle->ProId = $DatAlmacenMovimientoSalidaDetalle->ProId;
						$InsAlmacenMovimientoSalidaDetalle->UmeId = $DatAlmacenMovimientoSalidaDetalle->UmeId;

						$InsAlmacenMovimientoSalidaDetalle->FaaId = $DatAlmacenMovimientoSalidaDetalle->FaaId;

						$InsAlmacenMovimientoSalidaDetalle->AmdCosto = $DatAlmacenMovimientoSalidaDetalle->AmdCosto;
						$InsAlmacenMovimientoSalidaDetalle->AmdCostoExtraTotal = $DatAlmacenMovimientoSalidaDetalle->AmdCostoExtraTotal;
						$InsAlmacenMovimientoSalidaDetalle->AmdCantidad = $DatAlmacenMovimientoSalidaDetalle->AmdCantidad;
						$InsAlmacenMovimientoSalidaDetalle->AmdCantidadReal = $DatAlmacenMovimientoSalidaDetalle->AmdCantidadReal;
						$InsAlmacenMovimientoSalidaDetalle->AmdCantidadRealAnterior = $DatAlmacenMovimientoSalidaDetalle->AmdCantidadRealAnterior;
						
						$InsAlmacenMovimientoSalidaDetalle->AmdValorTotal = $DatAlmacenMovimientoSalidaDetalle->AmdValorTotal;
						$InsAlmacenMovimientoSalidaDetalle->AmdUtilidad = $DatAlmacenMovimientoSalidaDetalle->AmdUtilidad;
						$InsAlmacenMovimientoSalidaDetalle->AmdPrecioVenta = $DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta;
						
						$InsAlmacenMovimientoSalidaDetalle->AmdImporte = $DatAlmacenMovimientoSalidaDetalle->AmdImporte;
						$InsAlmacenMovimientoSalidaDetalle->AmdEstado = $DatAlmacenMovimientoSalidaDetalle->AmdEstado;							
						$InsAlmacenMovimientoSalidaDetalle->AmdTiempoCreacion = $DatAlmacenMovimientoSalidaDetalle->AmdTiempoCreacion;
						$InsAlmacenMovimientoSalidaDetalle->AmdTiempoModificacion = $DatAlmacenMovimientoSalidaDetalle->AmdTiempoModificacion;						
						$InsAlmacenMovimientoSalidaDetalle->AmdEliminado = $DatAlmacenMovimientoSalidaDetalle->AmdEliminado;
						
						$InsAlmacenMovimientoSalidaDetalle->AlmId = $DatAlmacenMovimientoSalidaDetalle->AlmId;
						$InsAlmacenMovimientoSalidaDetalle->AmdFecha = $DatAlmacenMovimientoSalidaDetalle->AmdFecha;
						
						$StockReal = 0;
						$Fecha = explode("/",$this->AmoFecha);
						$Ano = $Fecha[2];
						
						$InsAlmacenProducto = new ClsAlmacenProducto();
						//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
						$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsTallerPedidoDetalle->ProId,$this->AlmId,$Ano);
						
						if( ($StockReal + $InsAlmacenMovimientoSalidaDetalle->AmdCantidadRealAnterior) < $InsAlmacenMovimientoSalidaDetalle->AmdCantidadReal and $InsAlmacenMovimientoSalidaDetalle->AmdEliminado == 1 and $InsAlmacenMovimientoSalidaDetalle->AmdEstado == 3){
//							
							$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
							$Resultado.='#ERR_AMO_208';												 
							
						}else{
							
							if($InsAlmacenMovimientoSalidaDetalle->MtdRegistrarAlmacenMovimientoSalidaDetalle()){
								$validar++;	
							}else{
								$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
								$Resultado.='#ERR_AMO_201';
								//$Resultado.='#Item Numero: '.($validar+1);
							}
							
						}
																
																
						//if($InsAlmacenMovimientoSalidaDetalle->MtdRegistrarAlmacenMovimientoSalidaDetalle()){
//							$validar++;	
//						}else{
//							$Resultado.='#ERR_AMO_201';
//							$Resultado.='#Item Numero: '.($validar+1);
//						}
					}					
					
					if(count($this->AlmacenMovimientoSalidaDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
						
			//if(!$error){			
//			
//				if (!empty($this->AlmacenMovimientoSalidaDetalle)){		
//						
//					$validar = 0;				
//					$InsAlmacenMovimientoSalidaDetalle = new ClsAlmacenMovimientoSalidaDetalle();		
//					
//					foreach ($this->AlmacenMovimientoSalidaDetalle as $DatAlmacenMovimientoSalidaDetalle){
//					
//						$InsAlmacenMovimientoSalidaDetalle->AmoId = $this->AmoId;
//						$InsAlmacenMovimientoSalidaDetalle->ProId = $DatAlmacenMovimientoSalidaDetalle->ProId;
//						$InsAlmacenMovimientoSalidaDetalle->UmeId = $DatAlmacenMovimientoSalidaDetalle->UmeId;
//						$InsAlmacenMovimientoSalidaDetalle->AmdCosto = $DatAlmacenMovimientoSalidaDetalle->AmdCosto;
//						$InsAlmacenMovimientoSalidaDetalle->AmdCantidad = $DatAlmacenMovimientoSalidaDetalle->AmdCantidad;
//						$InsAlmacenMovimientoSalidaDetalle->AmdCantidadReal = $DatAlmacenMovimientoSalidaDetalle->AmdCantidadReal;
//						$InsAlmacenMovimientoSalidaDetalle->AmdImporte = $DatAlmacenMovimientoSalidaDetalle->AmdImporte;
//						$InsAlmacenMovimientoSalidaDetalle->AmdEstado = $this->AmoEstado;									
//						$InsAlmacenMovimientoSalidaDetalle->AmdTiempoCreacion = $DatAlmacenMovimientoSalidaDetalle->AmdTiempoCreacion;
//						$InsAlmacenMovimientoSalidaDetalle->AmdTiempoModificacion = $DatAlmacenMovimientoSalidaDetalle->AmdTiempoModificacion;						
//						$InsAlmacenMovimientoSalidaDetalle->AmdEliminado = $DatAlmacenMovimientoSalidaDetalle->AmdEliminado;
//						
//						if($InsAlmacenMovimientoSalidaDetalle->MtdRegistrarAlmacenMovimientoSalidaDetalle()){
//							$validar++;	
//						}else{
//							$Resultado.='#ERR_AMO_201';
//							$Resultado.='#Item Numero: '.($validar+1);
//						}
//					}					
//					
//					if(count($this->AlmacenMovimientoSalidaDetalle) <> $validar ){
//						$error = true;
//					}					
//								
//				}				
//			}
			
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();		
				$this->MtdAuditarAlmacenMovimientoSalida(1,"Se registro el Movimiento de Almacen",$this);			
				return true;
			}			
					
	}
	
	public function MtdEditarAlmacenMovimientoSalida() {

		global $Resultado;
		$error = false;

		$sql = 'UPDATE tblamoalmacenmovimiento SET
		'.(empty($this->TopId)?'TopId = NULL, ':'TopId = "'.$this->TopId.'",').'
		'.(empty($this->LtiId)?'LtiId = NULL, ':'LtiId = "'.$this->LtiId.'",').'
		
		'.(empty($this->AlmId)?'AlmId = NULL, ':'AlmId = "'.$this->AlmId.'",').'
		
		AmoFecha = "'.($this->AmoFecha).'",
		'.(empty($this->MonId)?'MonId = NULL, ':'MonId = "'.$this->MonId.'",').'
		'.(empty($this->AlmId)?'AmoTipoCambio = NULL, ':'AmoTipoCambio = "'.$this->AmoTipoCambio.'",').'
		
		AmoComprobanteNumero = "'.($this->AmoComprobanteNumero).'",
		AmoResponsable = "'.($this->AmoResponsable).'",
		
		AmoObservacion = "'.($this->AmoObservacion).'",
		
		AmoDescuento = '.($this->AmoDescuento).',
		
		AmoSubTotal = '.($this->AmoSubTotal).',
		AmoImpuesto = '.($this->AmoImpuesto).',
		AmoTotal = '.($this->AmoTotal).',
		
		AmoTiempoModificacion = "'.($this->AmoTiempoModificacion).'",
		AmoEstado = '.($this->AmoEstado).'
		WHERE AmoId = "'.($this->AmoId).'";';			

		$this->InsMysql->MtdTransaccionIniciar();

		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

		if(!$resultado) {							
			$error = true;
		} 			

		if(!$error){
			
				if (!empty($this->AlmacenMovimientoSalidaDetalle)){		

					$validar = 0;	
					$item = 1;			
					$InsAlmacenMovimientoSalidaDetalle = new ClsAlmacenMovimientoSalidaDetalle();
							
					foreach ($this->AlmacenMovimientoSalidaDetalle as $DatAlmacenMovimientoSalidaDetalle){
										
						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $DatAlmacenMovimientoSalidaDetalle->ProId;
						$InsProducto->MtdObtenerProducto(false);
						
						
						$InsAlmacenMovimientoSalidaDetalle->AmdId = $DatAlmacenMovimientoSalidaDetalle->AmdId;
						$InsAlmacenMovimientoSalidaDetalle->AmoId = $this->AmoId;
						$InsAlmacenMovimientoSalidaDetalle->ProId = $DatAlmacenMovimientoSalidaDetalle->ProId;
						$InsAlmacenMovimientoSalidaDetalle->UmeId = $DatAlmacenMovimientoSalidaDetalle->UmeId;

						$InsAlmacenMovimientoSalidaDetalle->FaaId = $DatAlmacenMovimientoSalidaDetalle->FaaId;

						$InsAlmacenMovimientoSalidaDetalle->AmdCosto = $DatAlmacenMovimientoSalidaDetalle->AmdCosto;
						$InsAlmacenMovimientoSalidaDetalle->AmdCostoExtraTotal = $DatAlmacenMovimientoSalidaDetalle->AmdCostoExtraTotal;
						$InsAlmacenMovimientoSalidaDetalle->AmdCantidad = $DatAlmacenMovimientoSalidaDetalle->AmdCantidad;
						$InsAlmacenMovimientoSalidaDetalle->AmdCantidadReal = $DatAlmacenMovimientoSalidaDetalle->AmdCantidadReal;
						$InsAlmacenMovimientoSalidaDetalle->AmdCantidadRealAnterior = $DatAlmacenMovimientoSalidaDetalle->AmdCantidadRealAnterior;

						$InsAlmacenMovimientoSalidaDetalle->AmdValorTotal = $DatAlmacenMovimientoSalidaDetalle->AmdValorTotal;
						$InsAlmacenMovimientoSalidaDetalle->AmdUtilidad = $DatAlmacenMovimientoSalidaDetalle->AmdUtilidad;
						$InsAlmacenMovimientoSalidaDetalle->AmdPrecioVenta = $DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta;
						
						$InsAlmacenMovimientoSalidaDetalle->AmdImporte = $DatAlmacenMovimientoSalidaDetalle->AmdImporte;
						$InsAlmacenMovimientoSalidaDetalle->AmdEstado = $DatAlmacenMovimientoSalidaDetalle->AmdEstado;
						$InsAlmacenMovimientoSalidaDetalle->AmdTiempoCreacion = $DatAlmacenMovimientoSalidaDetalle->AmdTiempoCreacion;
						$InsAlmacenMovimientoSalidaDetalle->AmdTiempoModificacion = $DatAlmacenMovimientoSalidaDetalle->AmdTiempoModificacion;
						$InsAlmacenMovimientoSalidaDetalle->AmdEliminado = $DatAlmacenMovimientoSalidaDetalle->AmdEliminado;
						
						$InsAlmacenMovimientoSalidaDetalle->AlmId = $DatAlmacenMovimientoSalidaDetalle->AlmId;
						$InsAlmacenMovimientoSalidaDetalle->AmdFecha = $DatAlmacenMovimientoSalidaDetalle->AmdFecha;
						
						if(empty($InsAlmacenMovimientoSalidaDetalle->AmdId)){
							if($InsAlmacenMovimientoSalidaDetalle->AmdEliminado<>2){
								

											if(!empty($InsAlmacenMovimientoSalidaDetalle->ProId)){
												if(!empty($InsAlmacenMovimientoSalidaDetalle->UmeId)){
													if(!empty($InsAlmacenMovimientoSalidaDetalle->AmdCantidad)){
														if(!empty($InsAlmacenMovimientoSalidaDetalle->AmdCantidadReal)){
														
															//if($InsAlmacenMovimientoSalidaDetalle->AmdEstado == 3){
																
																$StockReal = 0;
																$Fecha = explode("/",$this->AmoFecha);
																$Ano = $Fecha[2];
																
																$InsAlmacenProducto = new ClsAlmacenProducto();
																//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
																$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsTallerPedidoDetalle->ProId,$this->AlmId,$Ano);
																
																if( ($StockReal + $InsAlmacenMovimientoSalidaDetalle->AmdCantidadRealAnterior) < $InsAlmacenMovimientoSalidaDetalle->AmdCantidadReal and $InsAlmacenMovimientoSalidaDetalle->AmdEliminado == 1 and $InsAlmacenMovimientoSalidaDetalle->AmdEstado == 3){
				//							
																	$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
																	$Resultado.='#ERR_AMO_208';												 
																	
																}else{
																	
																	if($InsAlmacenMovimientoSalidaDetalle->MtdRegistrarAlmacenMovimientoSalidaDetalle()){
																		$validar++;	
																	}else{
																		$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
																		$Resultado.='#ERR_AMO_201';
																	}
																	
																}
																
															//}
												
															/*if($InsAlmacenMovimientoSalidaDetalle->MtdRegistrarAlmacenMovimientoSalidaDetalle()){
																$validar++;	
															}else{
																$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
																$Resultado.='#ERR_AMO_201';
																//$Resultado.='#\n';
															}*/
											
														}else{
															$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
															$Resultado.='#ERR_AMO_205';
															//$Resultado.='#\n';
														}
													}else{
															$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
															$Resultado.='#ERR_AMO_207';
															//$Resultado.='#\n';
													}
												}else{
													$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
													$Resultado.='#ERR_AMO_207';
													//$Resultado.='#\n';
												}
											}else{
												$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
												$Resultado.='#ERR_AMO_206';
												//$Resultado.='#\n';
											}
											
							}else{
								$validar++;
							}
						}else{						
							if($InsAlmacenMovimientoSalidaDetalle->AmdEliminado==2){
								if($InsAlmacenMovimientoSalidaDetalle->MtdEliminarAlmacenMovimientoSalidaDetalle($InsAlmacenMovimientoSalidaDetalle->AmdId)){
									$validar++;					
								}else{
									$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
									$Resultado.='#ERR_AMO_203';
									//$Resultado.='#\n';
								}
							}else{
								
											if(!empty($InsAlmacenMovimientoSalidaDetalle->ProId)){
												if(!empty($InsAlmacenMovimientoSalidaDetalle->UmeId)){
													if(!empty($InsAlmacenMovimientoSalidaDetalle->AmdCantidad)){
														if(!empty($InsAlmacenMovimientoSalidaDetalle->AmdCantidadReal)){
							
															/*if($InsAlmacenMovimientoSalidaDetalle->MtdEditarAlmacenMovimientoSalidaDetalle()){
																$validar++;	
															}else{
																$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
																$Resultado.='#ERR_AMO_202';
																//$Resultado.='#\n';	
															}*/
															
															//if($InsAlmacenMovimientoSalidaDetalle->AmdEstado == 3){
																
																$StockReal = 0;
																$Fecha = explode("/",$this->AmoFecha);
																$Ano = $Fecha[2];
																
																$InsAlmacenProducto = new ClsAlmacenProducto();
																//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
																$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsTallerPedidoDetalle->ProId,$this->AlmId,$Ano);
																
																
																if( ($StockReal + $InsAlmacenMovimientoSalidaDetalle->AmdCantidadRealAnterior) < $InsAlmacenMovimientoSalidaDetalle->AmdCantidadReal and $InsAlmacenMovimientoSalidaDetalle->AmdEliminado == 1 and $InsAlmacenMovimientoSalidaDetalle->AmdEstado == 3){
				//							
																	$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
																	$Resultado.='#ERR_AMO_208';												 
																	
																}else{
																	
																	if($InsAlmacenMovimientoSalidaDetalle->MtdEditarAlmacenMovimientoSalidaDetalle()){
																		$validar++;	
																	}else{
																		$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
																		$Resultado.='#ERR_AMO_202';
																		//$Resultado.='#\n';	
																	}
																	
																}
															
															//}
											
														}else{
															$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
															$Resultado.='#ERR_AMO_205';
															//$Resultado.='#\n';
														}
													}else{
															$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
															$Resultado.='#ERR_AMO_207';
															//$Resultado.='#\n';
													}
												}else{
													$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
													$Resultado.='#ERR_AMO_207';
													//$Resultado.='#\n';
												}
											}else{
												$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
												$Resultado.='#ERR_AMO_206';
												//$Resultado.='#\n';
											}

							}
						}	
						
						$item++;								
					}
					
					if(count($this->AlmacenMovimientoSalidaDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
		
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarAlmacenMovimientoSalida(2,"Se edito el Movimiento de Almacen",$this);		
				return true;
			}	
				
		}	
		
	
	
		private function MtdAuditarAlmacenMovimientoSalida($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria();
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