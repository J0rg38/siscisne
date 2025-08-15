<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsResumenVenta
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReporteFacturacion {


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


//MtdObtenerTallerPedidoDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTallerPedido=NULL,$oEstado=NULL,$oProducto=NULL,$oTallerPedidoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL) {
	
	public function MtdObtenerFacturacionTallerFacturas($oFuncion="SUM",$oParametro="FacTotal",$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFichaIngresoModalidadIngreso=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oSucursal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oDia=NULL) {

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(fac.FacFechaEmision)>="'.$oFechaInicio.'" AND DATE(fac.FacFechaEmision)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(fac.FacFechaEmision)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(fac.FacFechaEmision)<="'.$oFechaFin.'"';		
			}			
		}
		
		
		  
		if(!empty($oAno)){
			$ano = ' AND YEAR(fac.FacFechaEmision) = ('.$oAno.') ';
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(fac.FacFechaEmision) = '.$oMes.' ';
		}
		
		if(!empty($oDia)){
			$dia = ' AND DAY(fac.FacFechaEmision) = '.$oDia.' ';
		}	
		
		
		if(!empty($oVehiculoMarca)){
			
			$vmarca = '
			AND 
			(
				EXISTS (
					
					SELECT
					pvv.PvvId
					FROM tblpvvproductovehiculoversion pvv
						LEFT JOIN tblvvevehiculoversion vve
						ON pvv.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
					WHERE vmo.VmaId = "'.$oVehiculoMarca.'"
					AND amd.ProId = pvv.ProId
				)
				
				OR
				
				pro.VmaId = "'.$oVehiculoMarca.'"
			)
			';
		}
		
		if(!empty($oProductoTipo)){
			$ptipo = ' AND ( pro.RtiId = "'.$oProductoTipo.'" ) ';
		}	
		
		if(!empty($oFichaIngresoModalidadIngreso)){

			$elementos = explode(",",$oFichaIngresoModalidadIngreso);

			$i=1;
			$mingreso .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$mingreso .= '  (fim.MinId = "'.($elemento).'")';
				if($i<>count($elementos)){						
					$mingreso .= ' OR ';	
				}
			$i++;		
			}

			$mingreso .= ' ) 
			)
			';

		}
		
	//	if(!empty($oVehiculoMarca)){
//			$vmarca = ' AND ( pro.VmaId = "'.$oVehiculoMarca.'" ) ';
//		}	
		

		if(!empty($oSucursal)){
			$sucursal = ' AND ( fac.SucId = "'.$oSucursal.'" ) ';
		}	

				
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
			$sql = 'SELECT
					'.$funcion.' AS "RESULTADO"

				FROM tblfdefacturadetalle fde
					LEFT JOIN tblfacfactura fac
					ON (fde.FacId = fac.FacId  AND fde.FtaId = fac.FtaId)
				
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
							
					LEFT JOIN tblamdalmacenmovimientodetalle amd
					ON fde.AmdId = amd.AmdId
						
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							
							LEFT JOIN tblfccfichaaccion fcc
							ON amo.FccId = fcc.FccId
							
								LEFT JOIN tblfimfichaingresomodalidad fim
								ON fcc.FimId = fim.FimId
								
									LEFT JOIN tblfinfichaingreso fin
									ON fim.FinId = fin.FinId
						
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId
						
					

				WHERE amo.FccId IS NOT NULL  '.$sucursal.$vmarca.$dia.$ptipo.$ano.$mes.$mingreso.$vmarca.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];		
			
		}
		
		
		public function MtdObtenerFacturacionTallerBoletas($oFuncion="SUM",$oParametro="BolTotal",$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFichaIngresoModalidadIngreso=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oSucursal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oDia=NULL) {

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(bol.BolFechaEmision)>="'.$oFechaInicio.'" AND DATE(bol.BolFechaEmision)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(bol.BolFechaEmision)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(bol.BolFechaEmision)<="'.$oFechaFin.'"';		
			}			
		}
		
		
		  
		if(!empty($oAno)){
			$ano = ' AND YEAR(bol.BolFechaEmision) = ('.$oAno.') ';
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(bol.BolFechaEmision) = '.$oMes.' ';
		}
		
		if(!empty($oDia)){
			$dia = ' AND DAY(bol.BolFechaEmision) = '.$oDia.' ';
		}	
		
		
		if(!empty($oVehiculoMarca)){
			
			$vmarca = '
			AND 
			(
				EXISTS (
					
					SELECT
					pvv.PvvId
					FROM tblpvvproductovehiculoversion pvv
						LEFT JOIN tblvvevehiculoversion vve
						ON pvv.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
					WHERE vmo.VmaId = "'.$oVehiculoMarca.'"
					AND amd.ProId = pvv.ProId
				)
				
				OR
				
				pro.VmaId = "'.$oVehiculoMarca.'"
			)
			';
		}
		
		if(!empty($oProductoTipo)){
			$ptipo = ' AND ( pro.RtiId = "'.$oProductoTipo.'" ) ';
		}	
		
		if(!empty($oFichaIngresoModalidadIngreso)){

			$elementos = explode(",",$oFichaIngresoModalidadIngreso);

			$i=1;
			$mingreso .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$mingreso .= '  (fim.MinId = "'.($elemento).'")';
				if($i<>count($elementos)){						
					$mingreso .= ' OR ';	
				}
			$i++;		
			}

			$mingreso .= ' ) 
			)
			';

		}
		
	//	if(!empty($oVehiculoMarca)){
//			$vmarca = ' AND ( pro.VmaId = "'.$oVehiculoMarca.'" ) ';
//		}	
		

		if(!empty($oSucursal)){
			$sucursal = ' AND ( bol.SucId = "'.$oSucursal.'" ) ';
		}	

				
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
			$sql = 'SELECT
					'.$funcion.' AS "RESULTADO"

				FROM tblbdeboletadetalle bde
					LEFT JOIN tblbolboleta bol
					ON (bde.BolId = bol.BolId  AND bde.BtaId = bol.BtaId)
				
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
							
					LEFT JOIN tblamdalmacenmovimientodetalle amd
					ON bde.AmdId = amd.AmdId
						
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							
							LEFT JOIN tblfccfichaaccion fcc
							ON amo.FccId = fcc.FccId
							
								LEFT JOIN tblfimfichaingresomodalidad fim
								ON fcc.FimId = fim.FimId
								
									LEFT JOIN tblfinfichaingreso fin
									ON fim.FinId = fin.FinId
						
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId
						
					

				WHERE amo.FccId IS NOT NULL  '.$sucursal.$vmarca.$dia.$ptipo.$ano.$mes.$mingreso.$vmarca.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];		
			
		}
		
		
		/*public function MtdObtenerFacturacionMostrador($oFuncion="SUM",$oParametro="FacTotal",$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL) {

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(fac.FacFechaEmision) = ('.$oAno.') ';
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(fac.FacFechaEmision) = '.$oMes.' ';
		}
		
			
		if(!empty($oVehiculoMarca)){
			
			$vmarca = '
			AND 
			(
				EXISTS (
					
					SELECT
					pvv.PvvId
					FROM tblpvvproductovehiculoversion pvv
						LEFT JOIN tblvvevehiculoversion vve
						ON pvv.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
					WHERE vmo.VmaId = "'.$oVehiculoMarca.'"
					AND amd.ProId = pvv.ProId
				)
				
				OR
				
				pro.VmaId = "'.$oVehiculoMarca.'"
			)
			';
		}
		
		if(!empty($oProductoTipo)){
			$ptipo = ' AND ( pro.RtiId = "'.$oProductoTipo.'" ) ';
		}	
		
				
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
			$sql = 'SELECT
					'.$funcion.' AS "RESULTADO"

				FROM tblfdefacturadetalle fde
					LEFT JOIN tblfacfactura fac
					ON (fde.FacId = fac.FacId  AND fde.FtaId = fac.FtaId)
				
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
							
					LEFT JOIN tblamdalmacenmovimientodetalle amd
					ON fde.AmdId = amd.AmdId
						
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
						
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId
						

				WHERE amo.FccId IS  NULL  '.$factura.$ptipo.$ano.$mes.$vmarca.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];		
			
		}
	*/
	
	
	public function MtdObtenerFacturacionMostradorFacturas($oFuncion="SUM",$oParametro="FacTotal",$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oSucursal=NULL) {

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(fac.FacFechaEmision) = ('.$oAno.') ';
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(fac.FacFechaEmision) = '.$oMes.' ';
		}
		
			
		if(!empty($oVehiculoMarca)){
			
			$vmarca = '
			AND 
			(
				EXISTS (
					
					SELECT
					pvv.PvvId
					FROM tblpvvproductovehiculoversion pvv
						LEFT JOIN tblvvevehiculoversion vve
						ON pvv.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
					WHERE vmo.VmaId = "'.$oVehiculoMarca.'"
					AND amd.ProId = pvv.ProId
				)
				
				OR
				
				pro.VmaId = "'.$oVehiculoMarca.'"
			)
			';
		}
		
		if(!empty($oProductoTipo)){
			$ptipo = ' AND ( pro.RtiId = "'.$oProductoTipo.'" ) ';
		}	
		
		if(!empty($oSucursal)){
			$sucursal = ' AND ( fac.SucId = "'.$oSucursal.'" ) ';
		}	

				
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
			$sql = 'SELECT
					'.$funcion.' AS "RESULTADO"

				FROM tblfdefacturadetalle fde
					LEFT JOIN tblfacfactura fac
					ON (fde.FacId = fac.FacId  AND fde.FtaId = fac.FtaId)
				
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
							
					LEFT JOIN tblamdalmacenmovimientodetalle amd
					ON fde.AmdId = amd.AmdId
						
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
						
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId
						

				WHERE amo.FccId IS  NULL  '.$factura.$ptipo.$ano.$mes.$vmarca.$sucursal.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];		
			
		}
	
	
	public function MtdObtenerFacturacionMostradorBoletas($oFuncion="SUM",$oParametro="BolTotal",$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oSucursal=NULL) {

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(bol.BolFechaEmision) = ('.$oAno.') ';
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(bol.BolFechaEmision) = '.$oMes.' ';
		}
		
			
		if(!empty($oVehiculoMarca)){
			
			$vmarca = '
			AND 
			(
				EXISTS (
					
					SELECT
					pvv.PvvId
					FROM tblpvvproductovehiculoversion pvv
						LEFT JOIN tblvvevehiculoversion vve
						ON pvv.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
					WHERE vmo.VmaId = "'.$oVehiculoMarca.'"
					AND amd.ProId = pvv.ProId
				)
				
				OR
				
				pro.VmaId = "'.$oVehiculoMarca.'"
			)
			';
		}
		
		if(!empty($oProductoTipo)){
			$ptipo = ' AND ( pro.RtiId = "'.$oProductoTipo.'" ) ';
		}	
		
		if(!empty($oSucursal)){
			$sucursal = ' AND ( bol.SucId = "'.$oSucursal.'" ) ';
		}	
				
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
			$sql = 'SELECT
					'.$funcion.' AS "RESULTADO"

				FROM tblbdeboletadetalle bde
					LEFT JOIN tblbolboleta bol
					ON (bde.BolId = bol.BolId  AND bde.BtaId = bol.BtaId)
				
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
							
					LEFT JOIN tblamdalmacenmovimientodetalle amd
					ON bde.AmdId = amd.AmdId
						
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
						
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId
						

				WHERE amo.FccId IS  NULL  '.$boltura.$ptipo.$sucursal.$ano.$mes.$vmarca.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];		
			
		}
	
	
		/*
		*
		*/
		
		
	  public function MtdObtenerFacturaVehiculos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'RfaComprobanteFecha',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oCliente=NULL,$oOrdenVentaVehiculo=NULL,$oVehiculoMarca=NULL,$oObservado=NULL) {
	
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
				
				
			/*	$filtrar .= '  OR EXISTS( 
					
					SELECT 
					fde.FdeId
					FROM tblfdefacturadetalle fde
						
					WHERE 
						fde.FacId = fac.FacId AND
						fde.FtaId = fac.FtaId AND
						
						(
						fde.FdeDescripcion LIKE "%'.$oFiltro.'%" 
						
						)
						
					) ';
					
					
				$filtrar .= '  ) ';*/




		}
		
		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$ffecha = ' AND DATE(fac.FacFechaEmision)>="'.$oFechaInicio.'" AND DATE(fac.FacFechaEmision)<="'.$oFechaFin.'"';
				$bfecha = ' AND DATE(bol.BolFechaEmision)>="'.$oFechaInicio.'" AND DATE(bol.BolFechaEmision)<="'.$oFechaFin.'"';
			}else{
				$ffecha = ' AND DATE(fac.FacFechaEmision)>="'.$oFechaInicio.'"';
				$bfecha = ' AND DATE(bol.BolFechaEmision)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$ffecha = ' AND DATE(fac.FacFechaEmision)<="'.$oFechaFin.'"';
				$bfecha = ' AND DATE(bol.BolFechaEmision)<="'.$oFechaFin.'"';		
			}			
		}
				
		if(!empty($oCondicionPago)){
			$fnpago = ' AND fac.NpaId = "'.$oCondicionPago.'"';
			$bnpago = ' AND bol.NpaId = "'.$oCondicionPago.'"';
		}
		
		if(!empty($oMoneda)){
			$fmoneda = ' AND fac.MonId = "'.$oMoneda.'"';
			$bmoneda = ' AND bol.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oCliente)){
			$fcliente = ' AND fac.CliId = "'.$oCliente.'"';
			$bcliente = ' AND bol.CliId = "'.$oCliente.'"';
		}
		
		if(!empty($oOrdenVentaVehiculo)){
			$fovvehiculo = ' AND fac.OvvId = "'.$oOrdenVentaVehiculo.'"';
			$bovvehiculo = ' AND bol.OvvId = "'.$oOrdenVentaVehiculo.'"';
		}
		
		if(!empty($oSucursal)){
			$fsucursal = ' AND fac.SucId = "'.$oSucursal.'"';
			$bsucursal = ' AND bol.SucId = "'.$oSucursal.'"';
		}
		
		if(!empty($oVehiculoMarca)){

			$vmarca = ' AND vmo.VmaId = "'.$oVehiculoMarca.'"';
			
		}
		
		
		if(!empty($oObservado)){
			$fobservado = ' AND fac.FacObservado = "'.$oObservado.'"';
			$bobservado = ' AND bol.BolObservado = "'.$oObservado.'"';
		}
		
		
			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				
fta.FtaNumero AS "RfaComprobanteSerie",
fac.FacId AS "RfaComprobanteId",
DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y") AS "RfaComprobanteFecha",
fac.FacObservado  AS RfaObservado,

mon.MonSimbolo,
ROUND(fac.FacTotal/IFNULL(fac.FacTipoCambio,1),2) AS "RfaComprobanteTotal",

fac.OvvId,
cli.CliNumeroDocumento,
cli.CliNombre,
cli.CliApellidoPaterno,
cli.CliApellidoMaterno,
cli.CliDireccion,
cli.CliDistrito,
cli.CliProvincia,
cli.CliDepartamento,
cli.CliCelular,
cli.CliEmail,
cli.CliSexo,

vma.VmaNombre,
vmo.VmoNombre,
vve.VveNombre,
ein.EinVIN,
ein.EinColor,
ein.EinAnoFabricacion,
ein.EinAnoModelo,

ein.EinComprobanteCompraNumero,
DATE_FORMAT(ein.EinComprobanteCompraFecha, "%d/%m/%Y") AS "NEinComprobanteCompraFecha",
ein.EinCostoIngresoReal,
mon2.MonNombre AS MonNombreIngreso,
mon2.MonSimbolo AS MonSimboloIngreso,

per.PerNombre,
per.PerApellidoPaterno,
per.PerApellidoMaterno,

ncr.NcrId AS "RfaNotaCreditoId", 
nct.NctNumero AS "RfaNotaCreditoSerie",
ncr.NcrMotivo AS "RfaNotaCreditoMotivo",

lti.LtiNombre,
lti.LtiAbreviatura,
tblsucsucursal.SucNombre

FROM tblfacfactura fac
LEFT JOIN tblftafacturatalonario fta
ON fac.FtaId = fta.FtaId
LEFT JOIN tblclicliente cli
ON fac.CliId = cli.CliId
LEFT JOIN tbllticlientetipo lti
ON cli.LtiId = lti.LtiId

LEFT JOIN tblovvordenventavehiculo ovv
ON fac.OvvId = ovv.OvvId
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
LEFT JOIN tblncrnotacredito ncr
ON ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
LEFT JOIN tblnctnotacreditotalonario nct
ON ncr.NctId = nct.NctId
LEFT JOIN tblmonmoneda mon
ON fac.MonId = mon.MonId
LEFT JOIN tblmonmoneda mon2
ON ein.MonIdIngreso = mon2.MonId
INNER JOIN tblsucsucursal
ON fac.SucId = tblsucsucursal.SucId

WHERE fac.OvvId IS NOT NULL AND fac.OvvId != ""

/*AND YEAR(fac.FacFechaEmision) = 2018
AND MONTH(fac.FacFechaEmision) = 8*/


AND fac.FacEstado <> 6
/*AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) */

'.$ffecha.$fcliente.$fnpago.$fmoneda.$fobservado.$vmarca.$fovvehiculo.$fsucursal.'

UNION ALL


SELECT
bta.BtaNumero AS "RfaComprobanteSerie",
bol.BolId AS "RfaComprobanteId",
DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y") AS "RfaComprobanteFecha",
bol.BolObservado  AS RfaObservado,

mon.MonSimbolo,
ROUND(bol.BolTotal/IFNULL(bol.BolTipoCambio,1),2) AS "RfaComprobanteTotal",

bol.OvvId,
cli.CliNumeroDocumento,

cli.CliNombre,
cli.CliApellidoPaterno,
cli.CliApellidoMaterno,
cli.CliDireccion,
cli.CliDistrito,
cli.CliProvincia,
cli.CliDepartamento,
cli.CliCelular,
cli.CliEmail,
cli.CliSexo,

vma.VmaNombre,
vmo.VmoNombre,
vve.VveNombre,
ein.EinVIN,
ein.EinColor,
ein.EinAnoFabricacion,
ein.EinAnoModelo,

ein.EinComprobanteCompraNumero,
DATE_FORMAT(ein.EinComprobanteCompraFecha, "%d/%m/%Y") AS "NEinComprobanteCompraFecha",
ein.EinCostoIngresoReal,
mon2.MonNombre AS MonNombreIngreso,
mon2.MonSimbolo AS MonSimboloIngreso,

per.PerNombre,
per.PerApellidoPaterno,
per.PerApellidoMaterno,

ncr.NcrId AS "RfaNotaCreditoId", 
nct.NctNumero AS "RfaNotaCreditoSerie",
ncr.NcrMotivo AS "RfaNotaCreditoMotivo",

lti.LtiNombre,
lti.LtiAbreviatura,
tblsucsucursal.SucNombre

FROM tblbolboleta bol
LEFT JOIN tblbtaboletatalonario bta
ON bol.BtaId = bta.BtaId
LEFT JOIN tblclicliente cli
ON bol.CliId = cli.CliId
LEFT JOIN tbllticlientetipo lti
ON cli.LtiId = lti.LtiId

LEFT JOIN tblovvordenventavehiculo ovv
ON bol.OvvId = ovv.OvvId
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
LEFT JOIN tblncrnotacredito ncr
ON ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
LEFT JOIN tblnctnotacreditotalonario nct
ON ncr.NctId = nct.NctId
LEFT JOIN tblmonmoneda mon
ON bol.MonId = mon.MonId
LEFT JOIN tblmonmoneda mon2
ON ein.MonIdIngreso = mon2.MonId
INNER JOIN tblsucsucursal
ON bol.SucId = tblsucsucursal.SucId

WHERE bol.OvvId IS NOT NULL AND bol.OvvId != ""
/*
AND YEAR(bol.BolFechaEmision) = 2018
AND MONTH(bol.BolFechaEmision) = 8
*/
AND bol.BolEstado <> 6

'.$bfecha.$bcliente.$bnpago.$bmoneda.$vmarca.$bobservado.$bovvehiculo.$bsucursal.'

				 '.$orden.$paginacion;
				
		
		/*
			IF(

					(IFNULL((
						SELECT 
						ROUND(SUM((pag.PagMonto/pag.PagTipoCambio)),0)
						FROM tblpacpagocomprobante pac
							LEFT JOIN tblpagpago pag
							ON pac.PagId = pag.PagId
						WHERE pac.FacId = fac.FacId AND pac.FtaId = fac.FtaId
						LIMIT 1
					),0)) >= ROUND(fac.FacTotal,0)
					
					,"SI"
					,"NO"
				
				) AS FacPagado
		*/
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFactura = get_class($this);
	
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$Factura = new $InsFactura();
				
                    $Factura->RfaComprobanteSerie = $fila['RfaComprobanteSerie'];
					$Factura->RfaComprobanteId = $fila['RfaComprobanteId'];
					$Factura->RfaComprobanteFecha = $fila['RfaComprobanteFecha'];
                    $Factura->MonSimbolo= $fila['MonSimbolo'];
					$Factura->RfaComprobanteTotal= $fila['RfaComprobanteTotal'];
$Factura->RfaObservado= $fila['RfaObservado'];


					$Factura->OvvId= $fila['OvvId'];
					$Factura->CliNumeroDocumento= $fila['CliNumeroDocumento'];
					
					$Factura->CliNombre= $fila['CliNombre'];
					$Factura->CliApellidoPaterno= $fila['CliApellidoPaterno'];
					$Factura->CliApellidoMaterno= $fila['CliApellidoMaterno'];
					$Factura->CliDireccion= $fila['CliDireccion'];
					$Factura->CliDistrito= $fila['CliDistrito'];
					$Factura->CliProvincia= $fila['CliProvincia'];
					$Factura->CliDepartamento= $fila['CliDepartamento'];
					$Factura->CliCelular= $fila['CliCelular'];
					$Factura->CliEmail= $fila['CliEmail'];
					$Factura->CliSexo= $fila['CliSexo'];
					$Factura->VmaNombre= $fila['VmaNombre'];
					$Factura->VmoNombre = $fila['VmoNombre'];
					$Factura->VveNombre = $fila['VveNombre'];	
					$Factura->EinVIN = $fila['EinVIN'];					
					
					$Factura->EinColor = $fila['EinColor'];
					$Factura->EinAnoFabricacion = $fila['EinAnoFabricacion'];
					$Factura->EinAnoModelo = $fila['EinAnoModelo'];
					
					$Factura->EinComprobanteCompraNumero = $fila['EinComprobanteCompraNumero'];
					$Factura->EinComprobanteCompraFecha = $fila['NEinComprobanteCompraFecha'];
					$Factura->EinCostoIngresoReal = $fila['EinCostoIngresoReal'];
					$Factura->MonNombreIngreso = $fila['MonNombreIngreso'];
					$Factura->MonSimboloIngreso = $fila['MonSimboloIngreso'];
			
					$Factura->PerNombre = $fila['PerNombre'];
					$Factura->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$Factura->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					$Factura->RfaNotaCreditoId = $fila['RfaNotaCreditoId'];
					$Factura->RfaNotaCreditoSerie = $fila['RfaNotaCreditoSerie'];
					$Factura->RfaNotaCreditoMotivo = $fila['RfaNotaCreditoMotivo'];
				

				$Factura->LtiNombre = $fila['LtiNombre'];
				$Factura->LtiAbreviatura = $fila['LtiAbreviatura'];
				$Factura->SucNombre = $fila['SucNombre'];
				
					$Factura->InsMysql = NULL;     
					               
					$Respuesta['Datos'][]= $Factura;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}	
}
?>