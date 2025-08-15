<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsReporteProducto
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReporteProducto {

   
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
	
	public function MtdObtenerReporteProductoVentasMensual($oProductoId,$oAno,$oMes,$oVehiculoMarca,$oSucursal=NULL){
		
		$TotalMensual = 0;
		
		//MtdObtenerReporteProductoVentas($oProductoId,$oFechaInicio=NULL,$oFechaFin=NULL,$oAno=NULL,$oMes=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL)
		$ResReporteProductoVenta = $this->MtdObtenerReporteProductoVentas($oProductoId,NULL,NULL,$oAno,$oMes,"ProId","ASC","1",$oVehiculoMarca,$oSucursal);
		$ArrReporteProductoVentas = $ResReporteProductoVenta['Datos'];
		
		if(!empty($ArrReporteProductoVentas)){
			foreach($ArrReporteProductoVentas as $DatReporteProductoVenta){
				$TotalMensual = $DatReporteProductoVenta->RprCantidad;
			}
		}
		
		return $TotalMensual;
	}
	
   public function MtdObtenerReporteProductoVentasPerdidas($oProductoId,$oFechaInicio=NULL,$oFechaFin=NULL,$oAno=NULL,$oMes=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL){
	   
	   
	   if(!empty($oProductoId)){
			$producto = ' AND (crd.ProId) = "'.$oProductoId.'"';		
		}	
		
		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cpr.CprFecha)>="'.$oFechaInicio.'" AND DATE(cpr.CprFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(cpr.CprFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cpr.CprFecha)<="'.$oFechaFin.'"';		
			}			
		}
		
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND pro.VmaId = "'.$oVehiculoMarca.'"';		
		}	
		
		if(!empty($oSucursal)){
			$sucursal = ' AND cpr.SucId = "'.$oSucursal.'"';		
		}			


		if(!empty($oAno)){
			$ano = ' AND YEAR(cpr.CprFecha) = "'.$oAno.'"';		
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(cpr.CprFecha) = "'.$oMes.'"';		
		}	
			
			$sql = 'SELECT
					SQL_CALC_FOUND_ROWS 
					pro.ProId,
					pro.ProCodigoOriginal,
					pro.ProNombre,
					pro.ProMarca,
					pro.ProReferencia,
					MONTH(cpr.CprFecha) AS RprMes,
					crd.CrdPrecio AS RprPrecio,
					crd.CrdCantidad AS RprCantidad,
					crd.CrdImporte AS RprImporte,
					crd.CrdObservacion,
					
					vma.VmaNombre,
			vmo.VmoNombre,
			vve.VveNombre,
			
			ein.EinVIN,
			
			cpr.CprVIN,
			cpr.CprMarca,
			cpr.CprModelo,
			cpr.CprPlaca,
			cpr.CprAnoModelo	,
			
			suc.SucNombre,
			
			cpr.CprTipoCambio,
				DATE_FORMAT(cpr.CprFecha, "%d/%m/%Y") AS "NCprFecha",
				
				mon.MonNombre,
				mon.MonSimbolo,
				
				crd.CprId,
				
				cpr.FinId
					
					FROM tblcrdcotizacionproductodetalle crd
					
						LEFT JOIN tblcprcotizacionproducto cpr
						ON crd.CprId = cpr.CprId
						
						LEFT JOIN tblmonmoneda mon
						ON cpr.MonId = mon.MonId
						
						LEFT JOIN tblproproducto pro
						ON crd.ProId = pro.ProId
						
						LEFT JOIN tblumeunidadmedida ume
						ON pro.UmeId = ume.UmeId
							
							LEFT JOIN tblrtiproductotipo rti
							ON pro.RtiId = rti.RtiId
								
								LEFT JOIN tblsucsucursal suc
								ON cpr.SucId = suc.SucId
									
									LEFT JOIN tbleinvehiculoingreso ein
				ON cpr.EinId = ein.EinId
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
									
				WHERE cpr.CprEstado <> 6
				AND NOT EXISTS(
					SELECT 
					vdd.VddId
					FROM tblvddventadirectadetalle vdd
					WHERE vdd.CrdId = crd.CrdId
					LIMIT 1
				)
				AND pro.ProValidarStock = 1
				
				'.$producto.$fecha.$vmarca.$ano.$sucursal.$mes."  ".$orden."   ".$paginacion;
				
				
			
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsReporteProductoVenta = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReporteProducto = new $InsReporteProductoVenta();
                    $ReporteProducto->ProId = $fila['ProId'];
					$ReporteProducto->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$ReporteProducto->ProNombre = $fila['ProNombre'];
					$ReporteProducto->ProMarca = $fila['ProMarca'];
					$ReporteProducto->ProReferencia = $fila['ProReferencia'];
					
					$ReporteProducto->UmeNombre = $fila['UmeNombre'];
					$ReporteProducto->UmeAbreviacion = $fila['UmeAbreviacion'];
					
					$ReporteProducto->RtiNombre = $fila['RtiNombre'];
					
					$ReporteProducto->RprMes = $fila['RprMes'];
					$ReporteProducto->RprPrecio = $fila['RprPrecio'];
					$ReporteProducto->RprCantidad = $fila['RprCantidad'];
					$ReporteProducto->RprImporte = $fila['RprImporte'];
					$ReporteProducto->CrdObservacion = $fila['CrdObservacion'];
					
					
					$ReporteProducto->VmaNombre = $fila['VmaNombre'];
					$ReporteProducto->VmoNombre = $fila['VmoNombre'];
					$ReporteProducto->VveNombre = $fila['VveNombre'];
					
					$ReporteProducto->EinVIN = $fila['EinVIN'];
					
					$ReporteProducto->CprVIN = $fila['CprVIN'];
					$ReporteProducto->CprMarca = $fila['CprMarca'];
					$ReporteProducto->CprModelo = $fila['CprModelo'];
					$ReporteProducto->CprPlaca = $fila['CprPlaca'];
					$ReporteProducto->CprAnoModelo = $fila['CprAnoModelo'];
					$ReporteProducto->SucNombre = $fila['SucNombre'];
					$ReporteProducto->CprTipoCambio = $fila['CprTipoCambio'];
					$ReporteProducto->CprFecha = $fila['NCprFecha'];
				
		$ReporteProducto->MonNombre = $fila['MonNombre'];
		$ReporteProducto->MonSimbolo = $fila['MonSimbolo'];
		
			$ReporteProducto->CprId = $fila['CprId'];
		$ReporteProducto->FinId = $fila['FinId'];
		
		
                    $ReporteProducto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ReporteProducto;
			
				}
				
				$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
   }
   
   
    public function MtdObtenerReporteProductoVentas($oProductoId,$oFechaInicio=NULL,$oFechaFin=NULL,$oAno=NULL,$oMes=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL,$oTipo=NULL) {
		
		if(!empty($oProductoId)){
			$producto = ' AND (amd.ProId) = "'.$oProductoId.'"';		
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



			if(!empty($oVehiculoMarca)){
				$vmarca = ' AND pro.VmaId = "'.$oVehiculoMarca.'"';		
			}			


		if(!empty($oTipo)){
			$tipo = ' AND (pro.RtiId) = "'.$oTipo.'"';		
		}	
		
if(!empty($oSucursal)){
			$sucursal = ' AND (amo.SucId) = "'.$oSucursal.'"';		
		}	
		

		if(!empty($oAno)){
			$ano = ' AND YEAR(amo.AmoFecha) = "'.$oAno.'"';		
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(amo.AmoFecha) = "'.$oMes.'"';		
		}	
			
			

		$sql = 'SELECT
					SQL_CALC_FOUND_ROWS 
					pro.ProId,
					pro.ProCodigoOriginal,
					pro.ProNombre,
					pro.ProMarca,
					pro.ProReferencia,
					SUM(IFNULL(amo.FccId,amd.AmdCantidad)) as RprCantidadVentaDirecta,
					SUM(IFNULL(amo.VdiId,amd.AmdCantidad)) as RprCantidadFichaIngreso,
					
					
					SUM(amd.AmdCantidad) AS RprCantidad2,
					
						(
						SELECT 
						umc.UmcEquivalente
						FROM tblumcunidadmedidaconversion umc
						WHERE umc.UmeId1 = pro.UmeIdIngreso
						AND  umc.UmeId2 = pro.UmeId
						LIMIT 1
						) AS UmcEquivalente,
						
						SUM(
						IF(pro.UmeId<>pro.UmeIdIngreso,
						(
						
						amd.AmdCantidadReal / 
							IFNULL((
							SELECT 
							umc.UmcEquivalente
							FROM tblumcunidadmedidaconversion umc
							WHERE umc.UmeId1 = pro.UmeIdIngreso
							AND  umc.UmeId2 = pro.UmeId
							LIMIT 1
							),1)
						)
						,
						amd.AmdCantidadReal)
					
					) AS RprCantidad,
					
					pro.ProABCInterno,
					
					IF(pro.UmeId<>pro.UmeIdIngreso,ume2.UmeAbreviacion,ume.UmeNombre) AS UmeNombre,
					IF(pro.UmeId<>pro.UmeIdIngreso,ume2.UmeAbreviacion,ume.UmeAbreviacion) AS UmeAbreviacion 
					
					FROM tblamdalmacenmovimientodetalle amd					
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId						
							LEFT JOIN tblproproducto pro
							ON amd.ProId = pro.ProId
								LEFT JOIN tblumeunidadmedida ume
								ON pro.UmeId = ume.UmeId
									LEFT JOIN tblrtiproductotipo rti
									ON pro.RtiId = rti.RtiId
										LEFT JOIN tblumeunidadmedida ume2
										ON pro.UmeIdIngreso = ume2.UmeId
				WHERE amd.AmdEstado = 3
				AND amo.AmoTipo = 2 
				AND amo.AmoSubTipo <> 6
				AND pro.ProValidarStock = 1
				
				'.$producto.$fecha.$sucursal.$vmarca.$tipo.$ano.$mes." GROUP BY amd.ProId HAVING RprCantidad>0 ".$orden."   ".$paginacion;
				
					
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsReporteProductoVenta = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReporteProducto = new $InsReporteProductoVenta();
                    $ReporteProducto->ProId = $fila['ProId'];
					$ReporteProducto->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$ReporteProducto->ProNombre = $fila['ProNombre'];
					$ReporteProducto->ProMarca = $fila['ProMarca'];
					$ReporteProducto->ProReferencia = $fila['ProReferencia'];
					
					$ReporteProducto->RprCantidadVentaDirecta = $fila['RprCantidadVentaDirecta'];
					$ReporteProducto->RprCantidadFichaIngreso = $fila['RprCantidadFichaIngreso'];
					$ReporteProducto->RprCantidad = $fila['RprCantidad'];
					
					$ReporteProducto->UmeNombre = $fila['UmeNombre'];
					$ReporteProducto->UmeAbreviacion = $fila['UmeAbreviacion'];
					
					$ReporteProducto->RtiNombre = $fila['RtiNombre'];
					$ReporteProducto->ProABCInterno = $fila['ProABCInterno'];
					
					$ReporteProducto->UmeNombre = $fila['UmeNombre'];
					$ReporteProducto->UmeAbreviacion = $fila['UmeAbreviacion'];
					
					
                    $ReporteProducto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ReporteProducto;
			
				}
				
				$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
				
		}
		
		
		
	
	
	
	
	 public function MtdObtenerReporteProductoVentasPromedio($oProductoId,$oFecha=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oVehiculoMarca=NULL,$oDiasAtras=365,$oSucursal=NULL,$oAno){
	   
	   
	   if(!empty($oProductoId)){
			$producto = ' AND (pro.ProId) = "'.$oProductoId.'"';		
		}	
		
		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}		
		
		
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND pro.VmaId = "'.$oVehiculoMarca.'"';		
		}			
	
		if(!empty($oSucursal)){
			$sucursal = ' AND amo.SucId = "'.$oSucursal.'"';		
		}	

			$sql = 'SELECT
					SQL_CALC_FOUND_ROWS 
					pro.ProId,
					pro.ProCodigoOriginal,
					pro.ProNombre,
					pro.ProMarca,
					pro.ProReferencia,
					
					pro.ProSalidaTotalSemestral,
					pro.ProSalidaTotalTrimestral,
					
					
					@ventas:=SUM(amd.AmdCantidad)  AS RprVentaTotal,	
									
					ROUND(((IFNULL(SUM(amd.AmdCantidad),0) / 365)),2) AS RprPromedioDiario2,
					ROUND(((IFNULL(SUM(amd.AmdCantidad),0) / 12)),2) AS RprPromedioMensual2,
					ROUND(((IFNULL(SUM(amd.AmdCantidad),0) / 4)),2) AS RprPromedioTrimestral2,
					ROUND(((IFNULL(SUM(amd.AmdCantidad),0) / 2)),2) AS RprPromedioSemestral2,
					
					
					
					
					
					
					
					
					
						ROUND(((IFNULL(SUM(
						IF(pro.UmeId<>pro.UmeIdIngreso,
						(
						
						amd.AmdCantidadReal / 
							IFNULL((
							SELECT 
							umc.UmcEquivalente
							FROM tblumcunidadmedidaconversion umc
							WHERE umc.UmeId1 = pro.UmeIdIngreso
							AND  umc.UmeId2 = pro.UmeId
							LIMIT 1
							),1)
						)
						,
						amd.AmdCantidadReal)
					
					),0) / 365)),2) AS RprPromedioDiario,
					
					
					ROUND(((IFNULL(SUM(
						IF(pro.UmeId<>pro.UmeIdIngreso,
						(
						
						amd.AmdCantidadReal / 
							IFNULL((
							SELECT 
							umc.UmcEquivalente
							FROM tblumcunidadmedidaconversion umc
							WHERE umc.UmeId1 = pro.UmeIdIngreso
							AND  umc.UmeId2 = pro.UmeId
							LIMIT 1
							),1)
						)
						,
						amd.AmdCantidadReal)
					
					),0) / 12)),2) AS RprPromedioMensual,
					
					ROUND(((IFNULL(SUM(
						IF(pro.UmeId<>pro.UmeIdIngreso,
						(
						
						amd.AmdCantidadReal / 
							IFNULL((
							SELECT 
							umc.UmcEquivalente
							FROM tblumcunidadmedidaconversion umc
							WHERE umc.UmeId1 = pro.UmeIdIngreso
							AND  umc.UmeId2 = pro.UmeId
							LIMIT 1
							),1)
						)
						,
						amd.AmdCantidadReal)
					
					),0) / 4)),2) AS RprPromedioTrimestral,
					
					
					ROUND(((IFNULL(SUM(
						IF(pro.UmeId<>pro.UmeIdIngreso,
						(
						
						amd.AmdCantidadReal / 
							IFNULL((
							SELECT 
							umc.UmcEquivalente
							FROM tblumcunidadmedidaconversion umc
							WHERE umc.UmeId1 = pro.UmeIdIngreso
							AND  umc.UmeId2 = pro.UmeId
							LIMIT 1
							),1)
						)
						,
						amd.AmdCantidadReal)
					
					),0) / 2)),2) AS RprPromedioSemestral,
					
					
					rti.RtiNombre,
					
					
				
				/*
				
				@IngresosReal:=(
					SELECT 
					SUM(IFNULL(amd2.AmdCantidadReal,0))
					FROM tblamdalmacenmovimientodetalle amd2
						LEFT JOIN tblamoalmacenmovimiento amo2
						ON amd2.AmoId = amo2.AmoId
							WHERE amo2.AmoEstado = 3 
							AND amo2.AmoTipo = 1
							AND amd2.ProId = pro.ProId
							AND amd2.AmdEstado = 3 
							
							'.(!empty($oSucursal)?' AND amo2.AmoSubTipo <> 6 ':'').'
							'.(!empty($oSucursal)?' AND (amo2.SucId) = "'.$oSucursal.'"':'').'
							
							AND YEAR(amd2.AmdFecha) = '.$oAno.'
						
						
				) AS AstIngresoReales,
				
				@SalidasReal:=(
					SELECT 
					SUM(IFNULL(amd.AmdCantidadReal,0))
					FROM tblamdalmacenmovimientodetalle amd2
						LEFT JOIN tblamoalmacenmovimiento amo2
						ON amd2.AmoId = amo2.AmoId
							WHERE amo2.AmoEstado = 3 
							AND amo2.AmoTipo = 2
							AND amd2.ProId = pro.ProId
							AND amd2.AmdEstado = 3 
							
							'.(!empty($oSucursal)?' AND amo2.AmoSubTipo <> 6 ':'').'
							'.(!empty($oSucursal)?' AND (amo2.SucId) = "'.$oSucursal.'"':'').'
							
							AND YEAR(amd2.AmdFecha) = '.$oAno.'
						
				) AS AstSalidaReales,

				(
				IFNULL(@IngresosReal,0) - IFNULL(@SalidasReal,0)
				) AS RprStock,
				*/
			
				
					
					IF(pro.UmeId<>pro.UmeIdIngreso,ume2.UmeAbreviacion,ume.UmeNombre) AS UmeNombre,
					IF(pro.UmeId<>pro.UmeIdIngreso,ume2.UmeAbreviacion,ume.UmeAbreviacion) AS UmeAbreviacion 
					
					FROM tblamdalmacenmovimientodetalle amd
					
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId
							LEFT JOIN tblumeunidadmedida ume
							ON amd.UmeId = ume.UmeId
								LEFT JOIN tblrtiproductotipo rti
								ON pro.RtiId = rti.RtiId
									LEFT JOIN tblumeunidadmedida ume2
									ON pro.UmeIdIngreso = ume2.UmeId
									
									
					WHERE amo.AmoTipo = 2
					AND (amo.AmoSubTipo = 2 OR amo.AmoSubTipo = 3)
					
					AND DATE(DATE_ADD(NOW(), INTERVAL -'.$oDiasAtras.' DAY)) <= amo.AmoFecha
					
					AND pro.ProValidarStock = 1
					
				
				'.$producto.$fecha.$vmarca.$sucursal.$ano.$mes."  GROUP BY amd.ProId ".$orden."    ".$paginacion;
				
				
			
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsReporteProductoVenta = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReporteProducto = new $InsReporteProductoVenta();
                    $ReporteProducto->ProId = $fila['ProId'];
					$ReporteProducto->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$ReporteProducto->ProNombre = $fila['ProNombre'];
					$ReporteProducto->ProMarca = $fila['ProMarca'];
					$ReporteProducto->ProReferencia = $fila['ProReferencia'];
					
					$ReporteProducto->ProSalidaTotalSemestral = $fila['ProSalidaTotalSemestral'];
					$ReporteProducto->ProSalidaTotalTrimestral = $fila['ProSalidaTotalTrimestral'];
					
					
					$ReporteProducto->RprVentaTotal = $fila['RprVentaTotal'];
					$ReporteProducto->RprPromedioDiario = $fila['RprPromedioDiario'];					
					$ReporteProducto->RprPromedioMensual = $fila['RprPromedioMensual'];
					$ReporteProducto->RprPromedioTrimestral = $fila['RprPromedioTrimestral'];
					$ReporteProducto->RprPromedioSemestral = $fila['RprPromedioSemestral'];
					
					$ReporteProducto->RprStock = $fila['RprStock'];
					
					$ReporteProducto->RtiNombre = $fila['RtiNombre'];
					
					$ReporteProducto->UmeNombre = $fila['UmeNombre'];
					$ReporteProducto->UmeAbreviacion = $fila['UmeAbreviacion'];
					
                    $ReporteProducto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ReporteProducto;
			
				}
				
				$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
   }
   
	
	
	
	
	public function MtdObtenerReporteProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL,$oFecha=NULL,$oTieneSock=0,$oProductoCategoria=NULL) {

		if(!empty($oCampo) and !empty($oFiltro)){
			
			//$oFiltro = str_replace("*","%",$oFiltro);
			//$oFiltro = str_replace(" ","%",$oFiltro);
			
			$elementos_buscar = explode(",",$oFiltro);///
			
			$elementos_campo = explode(",",$oCampo);

				$i=1;
				$filtrar .= '  AND (';
				foreach($elementos_campo as $elemento_campo){
					if(!empty($elemento_campo)){	
					
					
								
						if($i==count($elementos_campo)){	

							$filtrar .= ' (';
							
							$j = 1;
							foreach($elementos_buscar as $elemento_buscar){
								
								if(!empty($elemento_buscar)){	
									
									if($j==count($elementos_buscar)){	
										
										$filtrar .= ' (';
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										$filtrar .= ' )';
										
									}else{
										
										$filtrar .= ' (';
										
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										
										$filtrar .= ' ) OR';
									}
									
								}
								
								$j++;
							}
										
							$filtrar .= ' )';
							
						}else{
							
							
							$filtrar .= ' (';
							
							$j = 1;
							foreach($elementos_buscar as $elemento_buscar){
								if(!empty($elemento_buscar)){	
									
									if($j==count($elementos_buscar)){	
										
										$filtrar .= ' (';
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										$filtrar .= ' )';
										
									}else{
										
										$filtrar .= ' (';
										
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										
										$filtrar .= ' ) OR';
									}
									
								}
								
								$j++;
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

		if(!empty($oEstado)){
			$estado = ' AND pro.ProEstado = '.$oEstado.' ';
		}
		
		if(!empty($oTipo)){
			$tipo = ' AND pro.RtiId = "'.$oTipo.'"';
		}
		
		if(!empty($oValidarStock)){
			$vstock = ' AND pro.ProValidarStock = '.$oValidarStock.' ';
		}


		if(!empty($oVehiculoMarca)){
			
			$vmarca = ' AND (
			
				EXISTS (
					SELECT 
						pvv.PvvId
					FROM tblpvvproductovehiculoversion pvv
						LEFT JOIN tblvvevehiculoversion vve
						ON pvv.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
					WHERE vmo.VmaId = "'.$oVehiculoMarca.'"
					AND pvv.ProId = pro.ProId
				)
				OR pro.ProValidarUso = 2
			) ';
			
		}
		
		if(!empty($oVehiculoModelo)){
			
			$vmodelo = ' AND 
			(
				EXISTS (
					SELECT 
						pvv.PvvId
					FROM tblpvvproductovehiculoversion pvv
						LEFT JOIN tblvvevehiculoversion vve
						ON pvv.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
					WHERE vve.VmoId = "'.$oVehiculoModelo.'"
					AND pvv.ProId = pro.ProId
				)  
				OR pro.ProValidarUso = 2
			)
			';
			
		}	
		
		if(!empty($oVehiculoVersion)){
			
			$vversion = ' AND 
			(
				EXISTS (
					SELECT 
					pvv.PvvId
					FROM tblpvvproductovehiculoversion pvv
						LEFT JOIN tblvvevehiculoversion vve
						ON pvv.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
					WHERE vve.VveId = "'.$oVehiculoVersion.'"
						AND pvv.ProId = pro.ProId
				)
				OR pro.ProValidarUso = 2  
			)
			';
			
		}			

		
		if(!empty($oVehiculoAno)){
			
			$vano = ' AND 
				(
					EXISTS (
						SELECT 
						pan.PanId
						FROM tblpanproductoano pan
						WHERE pan.PanAno = "'.$oVehiculoAno.'"
							AND pan.ProId = pro.ProId
					)  
					
					OR pro.ProValidarUso = 2
				)
			';
			
		}			


		if($oTieneIngreso){
			
			$tingreso = ' AND EXISTS (

				SELECT 
				amd.AmdId
				FROM tblamdalmacenmovimientodetalle amd
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
				WHERE amd.ProId = pro.ProId
				AND amd.AmdEstado = 3

			)  ';
			
		}			


		if(!empty($oReferencia)){
			$referencia = ' AND pro.ProReferencia LIKE "%'.$oReferencia.'%"';
		}


		if(!empty($oTieneSock)){
			
			switch($oTieneSock){
				case "1":
					$tstock = ' AND pro.ProStockReal > 0 ';
				break;
				
				case "2":
					$tstock = ' AND pro.ProStockReal <= 0 ';
				break;
				
				default:
					$tstock = '';
				break;
				
			}
			
		}


		if(!empty($oProductoCategoria)){
			$pcategoria = ' AND pro.PcaId = "'.$oProductoCategoria.'"';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				pro.ProId,
				pro.PcaId,
				
				pro.RtiId,
				pro.ProCodigoAlternativo,
				pro.ProCodigoOriginal,
				pro.ProNombre,
				pro.ProUbicacion,
				
				pro.ProMarca,
		
				pro.ProPeso,
				pro.ProLargo,
				pro.ProAncho,
				pro.ProAlto,
				pro.ProVolumen,
				
				pro.ProReferencia,
				pro.ProNota,
				pro.ProDimension,
				pro.AmdId,
       			pro.ProPrecio,
				pro.ProPrecioMercado,
				pro.ProCosto,
				pro.ProCostoIngreso,
				pro.ProCostoIngresoNeto,
				
				pro.ProListaPrecioCosto,
				pro.ProListaPromocionCosto,
				pro.ProListaPrecioCostoReal,
				pro.ProListaPromocionCostoReal,
				
				pro.MonIdListaPrecio,
				pro.MonIdListaPromocion,
				pro.ProTieneReemplazoGM,
				pro.ProTieneDisponibilidadGM,
				pro.ProDisponibilidadCantidadGM,
				
				pro.UmeId,
				pro.UmeIdIngreso,
				pro.ProCodigoBarra,

				pro.RtiId,
				pro.ProFoto,
				pro.ProStock,
				pro.ProStockReal,
				pro.ProStockMinimo,
				pro.ProValidarStock,
				pro.ProValidarUso,
				
				pro.ProRevisado,
				DATE_FORMAT(pro.ProRevisadoFecha, "%d/%m/%Y") AS "NProRevisadoFecha",
				pro.ProStockVerificado,
				
				( 
				SELECT 
				lpr.LprPrecio
				FROM tbllprlistaprecio lpr
					WHERE lpr.ProId = pro.ProId
					AND lpr.LtiId = "LTI-10012"
					LIMIT 1
				) AS ProListaPrecioPrecio,
				
				pro.ProProcedencia,
				pro.ProRotacion,
						
				pro.LtiId,
				pro.ProCalcularPrecio,
				pro.ProPorcentajeAdicional,
				pro.ProPorcentajeDescuento,
				
				pro.MonId,
				pro.ProTipoCambio,
		
				pro.ProDiasInmovilizado,
				pro.ProPromedioMensual,
				pro.ProPromedioDiario,
				
				pro.ProEstado,
				DATE_FORMAT(pro.ProTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NProTiempoCreacion",
                DATE_FORMAT(pro.ProTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NProTiempoModificacion",
				
				rti.RtiNombre,
				ume.UmeNombre,
				ume.UmeAbreviacion,
				
				pca.PcaNombre,
				
				@AmoFechaUltimaSalida:=( 
					SELECT DATE_FORMAT(amo2.AmoFecha, "%d/%m/%Y") 
					FROM tblamdalmacenmovimientodetalle amd2 
					LEFT JOIN tblamoalmacenmovimiento amo2 ON amd2.AmoId = amo2.AmoId 
					WHERE amo2.AmoTipo = 2 
						AND amd2.ProId = pro.ProId 
					ORDER BY amo2.AmoFecha DESC LIMIT 1 
				) AS RprFechaUltimaSalida, 
				
				(TIMESTAMPDIFF(DAY, (IFNULL( (
				
				( 
					SELECT (amo2.AmoFecha) 
					FROM tblamdalmacenmovimientodetalle amd2 
					LEFT JOIN tblamoalmacenmovimiento amo2 ON amd2.AmoId = amo2.AmoId 
					WHERE amo2.AmoTipo = 2 
						AND amd2.ProId = pro.ProId 
					ORDER BY amo2.AmoFecha DESC LIMIT 1 
				)
				
				),(DATE_ADD(DATE(NOW()), INTERVAL 2 DAY) ))), NOW() ) ) AS RprUltimaSalidaDiaTranscurridos,
				
				
				
				
				
				
				
				@SalidaAnual:=ROUND((
				
					SELECT 
					SUM(amd.AmdCantidad)
					FROM tblamdalmacenmovimientodetalle amd
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
					WHERE amd.ProId = pro.ProId
					AND amo.AmoTipo = 2
					AND (amo.AmoSubtipo =  3 OR amo.AmoSubtipo =  2)
				
					AND amd.ProId = pro.ProId
					AND amo.AmoFecha >= DATE(DATE_ADD(NOW(), INTERVAL -365 DAY))
				
				),2) AS ProSalidaTotalAnual,
				
				@SalidaSemestral:=ROUND((
				
					SELECT 
					SUM(amd.AmdCantidad)
					FROM tblamdalmacenmovimientodetalle amd
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
					WHERE amd.ProId = pro.ProId
					AND amo.AmoTipo = 2
					AND (amo.AmoSubtipo =  3 OR amo.AmoSubtipo =  2)
				
					AND amd.ProId = pro.ProId
					AND  amo.AmoFecha >= DATE(DATE_ADD(NOW(), INTERVAL -183 DAY)) 
				
				),2) AS ProSalidaTotalSemestral,
				
				@SalidaTrimestral:=ROUND((
				
					SELECT 
					SUM(amd.AmdCantidad)
					FROM tblamdalmacenmovimientodetalle amd
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
					WHERE amd.ProId = pro.ProId
					AND amo.AmoTipo = 2
					AND (amo.AmoSubtipo =  3 OR amo.AmoSubtipo =  2)
				
					AND amd.ProId = pro.ProId
					AND amo.AmoFecha >= DATE(DATE_ADD(NOW(), INTERVAL -92 DAY))
				
				),2) AS ProSalidaTotalTrimestral,
				
				
				
				@SalidaMensual:=ROUND((
				
					SELECT 
					SUM(amd.AmdCantidad)
					FROM tblamdalmacenmovimientodetalle amd
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
					WHERE amd.ProId = pro.ProId
					AND amo.AmoTipo = 2
					AND (amo.AmoSubtipo =  3 OR amo.AmoSubtipo =  2)
				
					AND amd.ProId = pro.ProId
					AND amo.AmoFecha >= DATE(DATE_ADD(NOW(), INTERVAL -30 DAY))
				
				),2) AS ProSalidaTotalMensual,
				
				
				
				
				
					
		
				@SalidaAnualMonto:=ROUND((
				
					SELECT 
					SUM(amd.AmdImporte)
					FROM tblamdalmacenmovimientodetalle amd
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
					WHERE amd.ProId = pro.ProId
					AND amo.AmoTipo = 2
					AND (amo.AmoSubtipo =  3 OR amo.AmoSubtipo =  2)
				
					AND amd.ProId = pro.ProId
					AND amo.AmoFecha >= DATE(DATE_ADD(NOW(), INTERVAL -365 DAY))
				
				),2) AS ProSalidaTotalAnualMonto,			
					
					
					
					
					
					
				ROUND((
				@SalidaAnual/365
				),2) AS RprPromedioDiario,
				
				
				ROUND((
				@SalidaAnual/12
				),2) AS RprPromedioMensual,
				
				ROUND((
				@SalidaAnual/2
				),2) AS RprPromedioSemestral,
				
				ROUND((
				@SalidaAnual/4
				),2) AS RprPromedioTrimestral


				FROM tblproproducto pro		
					LEFT JOIN tblrtiproductotipo rti
					ON pro.RtiId = rti.RtiId
						LEFT JOIN tblumeunidadmedida ume
						ON pro.UmeId = ume.UmeId
							LEFT JOIN tblpcaproductocategoria pca
							ON pro.PcaId = pca.PcaId
							
				WHERE    pro.ProValidarStock = 1 '.$filtrar.$categoria.$referencia.$estado.$tipo.$vstock.$vmarca.$vmodelo.$vversion.$vano.$tingreso.$tstock.$pcategoria.$orden.$paginacion;
							
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsProducto = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Producto = new $InsProducto();
                    $Producto->ProId = $fila['ProId'];
					$Producto->RtiId = $fila['RtiId']; 
					$Producto->ProCodigoOriginal = ($fila['ProCodigoOriginal']);
					$Producto->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
                    $Producto->ProNombre= ($fila['ProNombre']);
                    $Producto->ProUbicacion= ($fila['ProUbicacion']);
					
					
					$Producto->ProMarca= ($fila['ProMarca']);
					
					$Producto->ProPeso= ($fila['ProPeso']);
					$Producto->ProLargo= ($fila['ProLargo']);
					$Producto->ProAncho= ($fila['ProAncho']);
					$Producto->ProAlto= ($fila['ProAlto']);
					$Producto->ProVolumen= ($fila['ProVolumen']);
					
					$Producto->ProReferencia= ($fila['ProReferencia']);
					$Producto->ProNota = ($fila['ProNota']);
					$Producto->ProDimension= ($fila['ProDimension']);
					$Producto->AmdId= $fila['AmdId'];
					$Producto->ProPrecio= $fila['ProPrecio'];
					$Producto->ProPrecioMercado= $fila['ProPrecioMercado'];
					$Producto->ProCosto = $fila['ProCosto'];
					$Producto->ProCostoIngreso = $fila['ProCostoIngreso'];
					$Producto->ProCostoIngresoNeto = $fila['ProCostoIngresoNeto'];
					
					$Producto->ProListaPrecioCosto = $fila['ProListaPrecioCosto'];
					$Producto->ProListaPromocionCosto = $fila['ProListaPromocionCosto'];	
					$Producto->ProListaPrecioCostoReal = $fila['ProListaPrecioCostoReal'];
					$Producto->ProListaPromocionCostoReal = $fila['ProListaPromocionCostoReal'];	
									
					$Producto->MonIdListaPrecio = ($fila['MonIdListaPrecio']);
					$Producto->MonIdListaPromocion = ($fila['MonIdListaPromocion']);
					$Producto->ProTieneDisponibilidadGM = ($fila['ProTieneDisponibilidadGM']);
					$Producto->ProTieneReemplazoGM = ($fila['ProTieneReemplazoGM']);
					$Producto->ProDisponibilidadCantidadGM = ($fila['ProDisponibilidadCantidadGM']);
					
					$Producto->UmeId= ($fila['UmeId']);
					$Producto->UmeIdIngreso= ($fila['UmeIdIngreso']);
					
					$Producto->PcaNombre= ($fila['PcaNombre']);
					
					$Producto->ProCodigoBarra= $fila['ProCodigoBarra'];	

					$Producto->RtiId= $fila['RtiId'];
					$Producto->ProFoto = $fila['ProFoto'];
					$Producto->ProStock = $fila['ProStock'];
					$Producto->ProStockReal = $fila['ProStockReal'];

					$Producto->ProStockMinimo = $fila['ProStockMinimo'];
					$Producto->ProValidarStock = $fila['ProValidarStock'];
					$Producto->ProValidarUso = $fila['ProValidarUso'];
					
					
					$Producto->ProRevisado = $fila['ProRevisado'];	
					$Producto->ProRevisadoFecha = $fila['NProRevisadoFecha'];	
					
					$Producto->ProStockVerificado = $fila['ProStockVerificado'];
					
					
					$Producto->ProListaPrecioPrecio = $fila['ProListaPrecioPrecio'];	
		
	
					$Producto->ProProcedencia = $fila['ProProcedencia'];	
					$Producto->ProRotacion = $fila['ProRotacion'];	
					
		
					$Producto->LtiId = $fila['LtiId'];	
					$Producto->ProCalcularPrecio = $fila['ProCalcularPrecio'];	
					$Producto->ProPorcentajeAdicional = $fila['ProPorcentajeAdicional'];
					$Producto->ProPorcentajeDescuento = $fila['ProPorcentajeDescuento'];		
					
					
					$Producto->MonId = $fila['MonId'];	
					$Producto->ProTipoCambio = $fila['ProTipoCambio'];	
					
					$Producto->ProDiasInmovilizado = $fila['ProDiasInmovilizado'];
					$Producto->ProPromedioMensual = $fila['ProPromedioMensual'];
					$Producto->ProPromedioDiario = $fila['ProPromedioDiario'];
					
					
					$Producto->ProEstado = $fila['ProEstado'];	
                    $Producto->ProTiempoCreacion = $fila['NProTiempoCreacion'];
                    $Producto->ProTiempoModificacion = $fila['NProTiempoModificacion'];
					
					$Producto->RtiNombre = $fila['RtiNombre'];
					$Producto->UmeNombre = $fila['UmeNombre'];
					$Producto->UmeAbreviacion = $fila['UmeAbreviacion'];
					
					$Producto->RprFechaUltimaSalida = $fila['RprFechaUltimaSalida'];
					$Producto->RprUltimaSalidaDiaTranscurridos = $fila['RprUltimaSalidaDiaTranscurridos'];
					
					$Producto->ProSalidaTotalAnual = $fila['ProSalidaTotalAnual'];
					$Producto->ProSalidaTotalSemestral = $fila['ProSalidaTotalSemestral'];
					$Producto->ProSalidaTotalTrimestral = $fila['ProSalidaTotalTrimestral'];
					$Producto->ProSalidaTotalMensual = $fila['ProSalidaTotalMensual'];
					
					
					$Producto->ProSalidaTotalAnualMonto = $fila['ProSalidaTotalAnualMonto'];
				
				
					$Producto->RprPromedioDiario = $fila['RprPromedioDiario'];
					$Producto->RprPromedioMensual = $fila['RprPromedioMensual'];
					$Producto->RprPromedioSemestral = $fila['RprPromedioSemestral'];
					$Producto->RprPromedioTrimestral = $fila['RprPromedioTrimestral'];
	
					$Producto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Producto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
   
  
  
  
  
  
	
	public function MtdObtenerReporteProductoStockMinimos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProductoTipo=NULL,$oProductoCategoria=NULL,$oProductoCritico=NULL,$oConStockMinimo=false,$oAlmacen=NULL,$oSucursal=NULL) {

		if(!empty($oCampo) and !empty($oFiltro)){
			
			//$oFiltro = str_replace("*","%",$oFiltro);
			//$oFiltro = str_replace(" ","%",$oFiltro);
			
			$elementos_buscar = explode(",",$oFiltro);///
			
			$elementos_campo = explode(",",$oCampo);

				$i=1;
				$filtrar .= '  AND (';
				foreach($elementos_campo as $elemento_campo){
					if(!empty($elemento_campo)){	
					
					
								
						if($i==count($elementos_campo)){	

							$filtrar .= ' (';
							
							$j = 1;
							foreach($elementos_buscar as $elemento_buscar){
								
								if(!empty($elemento_buscar)){	
									
									if($j==count($elementos_buscar)){	
										
										$filtrar .= ' (';
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										$filtrar .= ' )';
										
									}else{
										
										$filtrar .= ' (';
										
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										
										$filtrar .= ' ) OR';
									}
									
								}
								
								$j++;
							}
										
							$filtrar .= ' )';
							
						}else{
							
							
							$filtrar .= ' (';
							
							$j = 1;
							foreach($elementos_buscar as $elemento_buscar){
								if(!empty($elemento_buscar)){	
									
									if($j==count($elementos_buscar)){	
										
										$filtrar .= ' (';
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										$filtrar .= ' )';
										
									}else{
										
										$filtrar .= ' (';
										
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										
										$filtrar .= ' ) OR';
									}
									
								}
								
								$j++;
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


		if(!empty($oProductoTipo)){
			$ptipo = ' AND pro.RtiId  = "'.($oProductoTipo).'"';
		}
		
			if(!empty($oProductoCategoria)){
			$pcategoria = ' AND pro.PcaId  = "'.($oProductoCategoria).'"';
		}
		
		
		if(!empty($oProductoCritico)){
			$pcritico = ' AND pro.ProCritico  = "'.($oProductoCritico).'"';
		}
		
		
		if(($oConStockMinimo)){
			$csminimo = ' AND pro.ProStockMinimo IS NOT NULL AND ProStockMinimo > 1 ';
		}
		
		
		
		if(!empty($oAlmacen)){
			$almacen = '

				(
				@ProStockRealFinal:= SELECT 
				SUM(apr.AprStockReal )
				FROM tblapralmacenproducto apr
					WHERE apr.ProId = pro.ProId
				AND apr.AlmId = "'.$oAlmacen.'"
				AND apr.AprAno = 1900
				) AS AstStockReal,
				
				
				(
				SELECT 
				(apr.AprStockMinimo )
				FROM tblapralmacenproducto apr
					WHERE apr.ProId = pro.ProId
				AND apr.AlmId = "'.$oAlmacen.'"
				AND apr.AprAno = 1900
				) AS AstStockMinimo,
				
					(
				SELECT 
				(apr.AprStockMaximo )
				FROM tblapralmacenproducto apr
					WHERE apr.ProId = pro.ProId
				AND apr.AlmId = "'.$oAlmacen.'"
				AND apr.AprAno = 1900
				) AS AstStockMaximo,
				
					(
				SELECT 
				(apr.AprObservacion )
				FROM tblapralmacenproducto apr
					WHERE apr.ProId = pro.ProId
				AND apr.AlmId = "'.$oAlmacen.'"
				AND apr.AprAno = 1900
				) AS AstObservacion,
				

			';	
		}else{
			/*$almacen = '
				pro.ProStockReal AS AstStockReal,
			';	*/
			
			
				if(!empty($oSucursal)){
					
					$almacen = '
						 @ProStockRealFinal:=(
						SELECT 
						SUM(apr.AprStockReal )
						FROM tblapralmacenproducto apr
							LEFT JOIN tblalmalmacen alm
							ON apr.AlmId = alm.AlmId
		
						WHERE apr.ProId = pro.ProId
						AND alm.SucId = "'.$oSucursal.'"
						AND apr.AprAno =  1900
						) AS AstStockReal,
						
						
						0 AS AstStockMinimo,
						0 AS AstStockMaximo,
						"" AS AstObservacion,
						
					';	
				}else{
					
					
					$almacen = '
						@ProStockRealFinal:= (
						SELECT 
						SUM(apr.AprStockReal)
						FROM tblapralmacenproducto apr
						
						WHERE apr.ProId = pro.ProId
						AND apr.AprAno =  1900
						) AS AstStockReal,
						
						0 AS AstStockMinimo,
						0 AS AstStockMaximo,
						"" AS AstObservacion,
						
					';	
			
				}
				
				
			
			
		}
		
		
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				pro.ProId,
				pro.ProCodigoOriginal,
				pro.ProNombre,
				pro.ProReferencia,
				pro.ProStockMinimo,
				
				'
				.$almacen.
				'
				pro.ProPromedioAnual,
				pro.ProPromedioMensual,
				pro.ProPromedioTrimestral,
				pro.ProPromedioSemestral,
				
				pro.ProSalidaTotalAnual,
				pro.ProSalidaTotalSemestral,
				pro.ProSalidaTotalTrimestral,
				
				pro.ProUbicacion,
				/*
				@ProStockRealFinal:=IFNULL((
				
					SELECT 
					SUM(apr.AprStockReal)
					FROM tblapralmacenproducto apr
					WHERE apr.ProId = pro.ProId
							AND (apr.AprAno) = YEAR(NOW())
				
					LIMIT 1
				
				),0) AS ProStockRealFinal,*/
				
				
				rti.RtiNombre,
				pca.PcaNombre,
				ume.UmeNombre,
				
				
				CASE
				WHEN  (@ProStockRealFinal = 0) THEN "Agotado"
				WHEN  (@ProStockRealFinal > pro.ProStockMinimo) THEN "Normal"
				WHEN  (@ProStockRealFinal < pro.ProStockMinimo AND @ProStockRealFinal>0) THEN "Agotandose"
			
				WHEN  (@ProStockRealFinal < 0) THEN "Negativo"
				ELSE "-"
				END AS RprStockMinimoEstado
				

				FROM tblproproducto pro		
					LEFT JOIN tblrtiproductotipo rti
					ON pro.RtiId = rti.RtiId
						LEFT JOIN tblumeunidadmedida ume
						ON pro.UmeId = ume.UmeId
							LEFT JOIN tblpcaproductocategoria pca
							ON pro.PcaId = pca.PcaId
							
				WHERE  
				-- AND pro.ProEstado = 1
				 
				  pro.ProValidarStock = 1
				  AND pro.ProStockMinimo> 0
			
				'.$filtrar.$pcategoria.$csminimo.$ptipo.$estado.$tipo.$vstock.$pcritico.$vmarca.$vmodelo.$vversion.$vano.$tingreso.$tstock.$pcategoria.' '.$orden.$paginacion;
						//IF( @ProStockRealFinal < pro.ProStockMinimo ,"Agotandose","Normal") AS RprStockMinimoEstado,
					
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsProducto = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					
					$Producto = new $InsProducto();
                    $Producto->ProId = $fila['ProId'];
					$Producto->ProCodigoOriginal = $fila['ProCodigoOriginal']; 
					$Producto->ProNombre = ($fila['ProNombre']);
					$Producto->ProReferencia = $fila['ProReferencia'];
                    $Producto->ProStockMinimo= ($fila['ProStockMinimo']);
					
					  $Producto->ProUbicacion= ($fila['ProUbicacion']);
					
					$Producto->ProPromedioAnual= ($fila['ProPromedioAnual']);
					$Producto->ProPromedioMensual= ($fila['ProPromedioMensual']);
					$Producto->ProPromedioTrimestral= ($fila['ProPromedioTrimestral']);
					$Producto->ProPromedioSemestral= ($fila['ProPromedioSemestral']);
					
					$Producto->ProSalidaTotalAnual= ($fila['ProSalidaTotalAnual']);
					$Producto->ProSalidaTotalSemestral= ($fila['ProSalidaTotalSemestral']);
					$Producto->ProSalidaTotalTrimestral= ($fila['ProSalidaTotalTrimestral']);
			
                    $Producto->ProStockRealFinal= ($fila['ProStockRealFinal']);
					
					 $Producto->RprStockMinimoEstado= ($fila['RprStockMinimoEstado']);
					
					$Producto->RtiNombre= ($fila['RtiNombre']);
					$Producto->PcaNombre= ($fila['PcaNombre']);
					$Producto->UmeNombre= ($fila['UmeNombre']);
				
					$Producto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Producto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
   
   
   
   
	public function MtdObtenerReporteProductoMaximo($oCampo=NULL,$oProductoTipo=NULL,$oProductoCategoria=NULL) {


		if(!empty($oProductoTipo)){
			$ptipo = ' AND pro.RtiId  = "'.($oProductoTipo).'"';
		}
		
		if(!empty($oProductoCategoria)){
			$pcategoria = ' AND pro.PcaId  = "'.($oProductoCategoria).'"';
		}
		
			$sql = 'SELECT
				MAX('.$oCampo.') AS RESULTADO

				FROM tblproproducto pro		
					LEFT JOIN tblrtiproductotipo rti
					ON pro.RtiId = rti.RtiId
						LEFT JOIN tblumeunidadmedida ume
						ON pro.UmeId = ume.UmeId
							LEFT JOIN tblpcaproductocategoria pca
							ON pro.PcaId = pca.PcaId
							
				WHERE 1 = 1
			
				'.$filtrar.$pcategoria.$ptipo.$estado.$tipo.$vstock.$vmarca.$vmodelo.$vversion.$vano.$tingreso.$tstock.$pcategoria.$orden.$paginacion;

			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];	
			
						
		}
   
  
  
  
  
  
	public function MtdObtenerReporteProductoValorInventarios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProductoTipo=NULL,$oProductoCategoria=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oProductoId=NULL,$oAno) {

		if(!empty($oCampo) and !empty($oFiltro)){
			
			//$oFiltro = str_replace("*","%",$oFiltro);
			//$oFiltro = str_replace(" ","%",$oFiltro);
			
			$elementos_buscar = explode(",",$oFiltro);///
			
			$elementos_campo = explode(",",$oCampo);

				$i=1;
				$filtrar .= '  AND (';
				foreach($elementos_campo as $elemento_campo){
					if(!empty($elemento_campo)){	
					
					
								
						if($i==count($elementos_campo)){	

							$filtrar .= ' (';
							
							$j = 1;
							foreach($elementos_buscar as $elemento_buscar){
								
								if(!empty($elemento_buscar)){	
									
									if($j==count($elementos_buscar)){	
										
										$filtrar .= ' (';
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										$filtrar .= ' )';
										
									}else{
										
										$filtrar .= ' (';
										
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										
										$filtrar .= ' ) OR';
									}
									
								}
								
								$j++;
							}
										
							$filtrar .= ' )';
							
						}else{
							
							
							$filtrar .= ' (';
							
							$j = 1;
							foreach($elementos_buscar as $elemento_buscar){
								if(!empty($elemento_buscar)){	
									
									if($j==count($elementos_buscar)){	
										
										$filtrar .= ' (';
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										$filtrar .= ' )';
										
									}else{
										
										$filtrar .= ' (';
										
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										
										$filtrar .= ' ) OR';
									}
									
								}
								
								$j++;
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


		if(!empty($oProductoTipo)){
			$ptipo = ' AND pro.RtiId  = "'.($oProductoTipo).'"';
		}
		
			if(!empty($oProductoCategoria)){
			$pcategoria = ' AND pro.PcaId  = "'.($oProductoCategoria).'"';
		}
		
		
		
		if(!empty($oSucursal)){
			$sucursal = ' AND alm.SucId  = "'.($oSucursal).'"';
		}
		
		
		if(($oAlmacen)){
			$almacen = ' AND apr.AlmId  = "'.($oAlmacen).'"';
		}
		
		
		if(($oProductoId)){
			$producto = ' AND apr.ProId  = "'.($oProductoId).'"';
		}
		
			
		if(($oAno)){
			$ano = ' AND apr.AprAno  = "'.($oAno).'"';
		}
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				
				pro.ProId,
				pro.ProNombre ,
				pro.ProCodigoOriginal,
				pro.ProReferencia,
				
				SUM(apr.AprStockReal) AS RpcStock2,
				
				SUM(
				
					IF(pro.UmeId<>pro.UmeIdIngreso,
					(
					
					apr.AprStockReal / 
						IFNULL((
						SELECT 
						umc.UmcEquivalente
						FROM tblumcunidadmedidaconversion umc
						WHERE umc.UmeId1 = pro.UmeIdIngreso
						AND  umc.UmeId2 = pro.UmeId
						LIMIT 1
						),1)
					)
					,
					apr.AprStockReal) 
						
				) AS RpcStock,
				
				pro.ProCosto AS RpcCostoUnitario,
				
				SUM(apr.AprStockReal) * pro.ProCosto AS RpcValorInventario2,
				
				SUM(
				
					IF(pro.UmeId<>pro.UmeIdIngreso,
					(
					
					apr.AprStockReal / 
						IFNULL((
						SELECT 
						umc.UmcEquivalente
						FROM tblumcunidadmedidaconversion umc
						WHERE umc.UmeId1 = pro.UmeIdIngreso
						AND  umc.UmeId2 = pro.UmeId
						LIMIT 1
						),1)
					)
					,
					apr.AprStockReal) 
						
				) * pro.ProCosto AS RpcValorInventario,
				
				
				
							
					IF(pro.UmeId<>pro.UmeIdIngreso,ume2.UmeAbreviacion,ume.UmeNombre) AS UmeNombre,
					IF(pro.UmeId<>pro.UmeIdIngreso,ume2.UmeAbreviacion,ume.UmeAbreviacion) AS UmeAbreviacion ,
					
								
				rti.RtiNombre,
				pca.PcaNombre
				
				FROM tblapralmacenproducto apr
					LEFT JOIN tblproproducto pro
					ON apr.ProId = pro.ProId
						LEFT JOIN tblrtiproductotipo rti
						ON pro.RtiId = rti.RtiId
							LEFT JOIN tblumeunidadmedida ume
							ON pro.UmeId = ume.UmeId
								LEFT JOIN tblumeunidadmedida ume2
								ON pro.UmeIdIngreso = ume2.UmeId
								LEFT JOIN tblpcaproductocategoria pca
								ON pro.PcaId = pca.PcaId
				WHERE 			
				  pro.ProValidarStock = 1
				'.$filtrar.$pcategoria.$csminimo.$ptipo.$estado.$tipo.$ano.$vstock.$pcritico.$vmarca.$vmodelo.$vversion.$vano.$tingreso.$tstock.$pcategoria." 	GROUP BY pro.ProId ".$orden.$paginacion;
						//IF( @ProStockRealFinal < pro.ProStockMinimo ,"Agotandose","Normal") AS RprStockMinimoEstado,
					//ORDER BY RpcValorInventario DESC
					 
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsProducto = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					
					$Producto = new $InsProducto();
                    $Producto->ProId = $fila['ProId'];
					$Producto->ProCodigoOriginal = $fila['ProCodigoOriginal']; 
					$Producto->ProNombre = ($fila['ProNombre']);
					$Producto->ProReferencia = $fila['ProReferencia'];
					$Producto->RpcStock = $fila['RpcStock'];
					$Producto->RpcCostoUnitario = $fila['RpcCostoUnitario'];
                    $Producto->RpcValorInventario = $fila['RpcValorInventario'];
					
					$Producto->RtiNombre= ($fila['RtiNombre']);
					$Producto->PcaNombre= ($fila['PcaNombre']);
					$Producto->UmeNombre= ($fila['UmeNombre']);
				
					$Producto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Producto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		} 
	
 
}
?>