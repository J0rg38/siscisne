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

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}


//MtdObtenerTallerPedidoDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTallerPedido=NULL,$oEstado=NULL,$oProducto=NULL,$oTallerPedidoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL) {
	
	public function MtdObtenerFacturacionTaller($oFuncion="SUM",$oParametro="FacTotal",$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFichaIngresoModalidadIngreso=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL) {

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
						
					

				WHERE amo.FccId IS NOT NULL  '.$factura.$ptipo.$ano.$mes.$mingreso.$vmarca.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];		
			
		}
		
		
		public function MtdObtenerFacturacionMostrador($oFuncion="SUM",$oParametro="FacTotal",$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL) {

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
		
}
?>