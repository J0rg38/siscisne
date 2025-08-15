<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsReporteTallerPedido
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReporteTallerPedido {

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

public function MtdObtenerTallerPedidoDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTallerPedido=NULL,$oEstado=NULL,$oProducto=NULL,$oTallerPedidoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oModalidadIngreso=NULL,$oPersonal=NULL,$oSucursal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oConComprobante=true) {

	// Inicializar variables para evitar warnings
	$filtrar = '';
	$orden = '';
	$paginacion = '';
	$tallerPedido = '';
	$estado = '';
	$producto = '';
	$tallerPedidoEstado = '';
	$vehiculoMarca = '';
	$productoTipo = '';
	$modalidadIngreso = '';
	$personal = '';
	$sucursal = '';
	$fechaInicio = '';
	$fechaFin = '';
	$conComprobante = '';

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
		
		if(!empty($oTallerPedido)){
			$amovimiento = ' AND amd.AmoId = "'.$oTallerPedido.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND amd.AmdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (amd.ProId = "'.$oProducto.'") ';
		}



		if(!empty($oTallerPedidoEstado)){
			$tpestado = ' AND ( amo.AmoEstado = "'.$oTallerPedidoEstado.'" ) ';
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
		
		
		if(!empty($oModalidadIngreso)){
			$mingreso = ' AND ( fim.MinId = "'.$oModalidadIngreso.'" ) ';
		}	
		
		if(!empty($oPersonal)){
			$personal = ' AND ( fin.PerId = "'.$oPersonal.'" ) ';
		}	
		
		if(!empty($oSucursal)){
			$sucursal = ' AND ( fin.SucId = "'.$oSucursal.'" ) ';
		}	
		
		/*if(($oConComprobante)){
			
			$ccomprobante = ' AND (
			
				EXISTS ( 
					
								SELECT 
								* 
								FROM tblbolboleta bol2
								LEFT JOIN tblbamboletaalmacenmovimiento bam
								ON bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId
									
								WHERE bam.AmoId = amo.AmoId
								AND DATE(bol2.BolFechaEmision)>="'.$oFechaInicio.'" 
								AND DATE(bol2.BolFechaEmision)<="'.$oFechaFin.'"
								AND bol2.BolEstado <> 6
								LIMIT 1
				
				)
			
			) ';
			
		}	
		*/

	
//	if(!empty($oFechaInicio)){
//			
//			if(!empty($oFechaFin)){
//				$fecha = ' AND (
//				
//				( DATE(fac.FacFechaEmision)>="'.$oFechaInicio.'" AND DATE(fac.FacFechaEmision)<="'.$oFechaFin.'" ) OR 
//				( DATE(bol.BolFechaEmision)>="'.$oFechaInicio.'" AND DATE(bol.BolFechaEmision)<="'.$oFechaFin.'" ) 
//				
//				 )';
//			}else{
//				$fecha = ' AND ( 
//				
//				(
//				
//				(DATE(fac.FacFechaEmision)>="'.$oFechaInicio.'" OR  DATE(bol.BolFechaEmision)>="'.$oFechaInicio.'") 
//				
//				)
//				
//				)';
//			}
//			
//		}else{
//			if(!empty($oFechaFin)){
//				$fecha = ' AND ( (
//				
//				(
//				
//				DATE(fac.FacFechaEmision)<="'.$oFechaFin.'" ) OR (DATE(bol.BolFechaEmision)<="'.$oFechaFin.'" ) 
//					
//				)
//				
//				)';		
//			}			
//		}
//		
			/*if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';		
			}			
		}*/
	
	
	/*OR 
				
					( 
						EXISTS(
							SELECT 
							* 
							FROM tblbamboletaalmacenmovimiento bam
								LEFT JOIN tblbolboleta bol2
								ON bam.BolId = bol2.BolId AND bam.BtaId = bol2.BtaId
								
							WHERE bam.AmoId = amo.AmoId
							AND DATE(bol2.BolFechaEmision)>="'.$oFechaInicio.'" 
							AND DATE(bol2.BolFechaEmision)<="'.$oFechaFin.'"
							AND bol2.BolEstado <> 6
							LIMIT 1
						) OR
						
						EXISTS(
							SELECT 
							* 
							FROM tblfamfacturaalmacenmovimiento fam
								LEFT JOIN tblfacfactura fac2
								ON fam.FacId = fac2.FacId AND fam.FtaId = fac2.FtaId
								
							WHERE fam.AmoId = amo.AmoId
							AND DATE(fac2.FacFechaEmision)>="'.$oFechaInicio.'" 
							AND DATE(fac2.FacFechaEmision)<="'.$oFechaFin.'"
							AND fac2.FacEstado <> 6
							LIMIT 1
						)
						
					)*/
					
				
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				
				
				if(($oConComprobante)){
			
					$ccomprobante = ' AND (
					
						EXISTS ( 
							
							SELECT 
							* 
							FROM tblbolboleta bol2
							LEFT JOIN tblbamboletaalmacenmovimiento bam
							ON bam.BolId = bol2.BolId AND bam.BtaId = bol2.BtaId
								
							WHERE bam.AmoId = amo.AmoId
							AND DATE(bol2.BolFechaEmision)>="'.$oFechaInicio.'" 
							AND DATE(bol2.BolFechaEmision)<="'.$oFechaFin.'"
							AND bol2.BolEstado <> 6
							LIMIT 1
						
						)
						
						OR
						
						EXISTS(
							SELECT 
							* 
							FROM tblfacfactura fac2
								LEFT JOIN tblfamfacturaalmacenmovimiento fam
								ON fam.FacId = fac2.FacId AND fam.FtaId = fac2.FtaId
								
							WHERE fam.AmoId = amo.AmoId
							AND DATE(fac2.FacFechaEmision)>="'.$oFechaInicio.'" 
							AND DATE(fac2.FacFechaEmision)<="'.$oFechaFin.'"
							AND fac2.FacEstado <> 6
							LIMIT 1
						)
						
						
						
					
					) ';
					
				}	
				
				
				$fecha = ' AND (
				
					(   DATE(amo.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo.AmoFecha)<="'.$oFechaFin.'" ) 
				
				'.$ccomprobante.'	
				
				 )';
				 /*
				 OR
					( 
						EXISTS(
							SELECT 
							* 
							FROM tblbamboletaalmacenmovimiento bam
								LEFT JOIN tblbolboleta bol2
								ON bam.BolId = bol2.BolId AND bam.BtaId = bol2.BtaId
								
							WHERE bam.AmoId = amo.AmoId
							AND DATE(bol2.BolFechaEmision)>="'.$oFechaInicio.'" AND DATE(bol2.BolFechaEmision)<="'.$oFechaFin.'"
							LIMIT 1
						) OR
						
						EXISTS(
							SELECT 
							* 
							FROM tblfamfacturaalmacenmovimiento fam
								LEFT JOIN tblfacfactura fac2
								ON fam.FacId = fac2.FacId AND fam.FtaId = fac2.FtaId
								
							WHERE fam.AmoId = amo.AmoId
							AND DATE(fac2.FacFechaEmision)>="'.$oFechaInicio.'" AND DATE(fac2.FacFechaEmision)<="'.$oFechaFin.'"
							LIMIT 1
						)
						
					)
				 */
			}else{
				
				if(($oConComprobante)){
			
					$ccomprobante = ' AND (
					
						EXISTS ( 
							
							SELECT 
							* 
							FROM tblbolboleta bol2
							LEFT JOIN tblbamboletaalmacenmovimiento bam
							ON bam.BolId = bol2.BolId AND bam.BtaId = bol2.BtaId
								
							WHERE bam.AmoId = amo.AmoId
							AND DATE(bol2.BolFechaEmision)>="'.$oFechaInicio.'" 
						
							AND bol2.BolEstado <> 6
							LIMIT 1
						
						)
						
						OR
						
						EXISTS(
							SELECT 
							* 
							FROM tblfacfactura fac2
								LEFT JOIN tblfamfacturaalmacenmovimiento fam
								ON fam.FacId = fac2.FacId AND fam.FtaId = fac2.FtaId
								
							WHERE fam.AmoId = amo.AmoId
							AND DATE(fac2.FacFechaEmision)>="'.$oFechaInicio.'" 
						
							AND fac2.FacEstado <> 6
							LIMIT 1
						)
						
						
						
					
					) ';
					
				}	
				
				
				$fecha = ' AND ( 
				
				(
				 DATE(amo.AmoFecha)>="'.$oFechaInicio.'" 
				
				)
				
				'.$ccomprobante.'	
				
				
				)';
			}
			
		}else{
			if(!empty($oFechaFin)){
				
				
				if(($oConComprobante)){
			
					$ccomprobante = ' AND (
					
						EXISTS ( 
							
							SELECT 
							* 
							FROM tblbolboleta bol2
							LEFT JOIN tblbamboletaalmacenmovimiento bam
							ON bam.BolId = bol2.BolId AND bam.BtaId = bol2.BtaId
								
							WHERE bam.AmoId = amo.AmoId
							AND DATE(bol2.BolFechaEmision)<="'.$oFechaFin.'"
							AND bol2.BolEstado <> 6
							LIMIT 1
						
						)
						
						OR
						
						EXISTS(
							SELECT 
							* 
							FROM tblfacfactura fac2
								LEFT JOIN tblfamfacturaalmacenmovimiento fam
								ON fam.FacId = fac2.FacId AND fam.FtaId = fac2.FtaId
								
							WHERE fam.AmoId = amo.AmoId
							
							AND DATE(fac2.FacFechaEmision)<="'.$oFechaFin.'"
							AND fac2.FacEstado <> 6
							LIMIT 1
						)
						
					
					) ';
					
				}	
				
				
				
				$fecha = ' AND ( (
				
				(
				  DATE(amo.AmoFecha)<="'.$oFechaFin.'" 
				)
				
				'.$ccomprobante.'	
				
				
				)';		

			}			
		}
		
		
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(amo.AmoFecha) = "'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(amo.AmoFecha) = "'.($oAno).'"';
		}
		
		
		
			$sql = '
			SELECT
				'.$funcion.' AS "RESULTADO"

			FROM tblamdalmacenmovimientodetalle amd
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON amd.UmeId = ume.UmeId				
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							LEFT JOIN tblfccfichaaccion fcc
							ON amo.FccId = fcc.FccId
								LEFT JOIN tblfimfichaingresomodalidad fim
								ON fcc.FimId = fim.FimId
									LEFT JOIN tblfinfichaingreso fin
									ON fim.FinId = fin.FinId
							LEFT JOIN tblfaafichaaccionmantenimiento faa
							ON amd.FaaId = faa.FaaId
							
									LEFT JOIN tblfapfichaaccionproducto fap
									ON fap.FaaId = faa.FaaId
									
			WHERE  amo.AmoTipo = 2  
				AND amo.AmoSubTipo = 2 
				
			'.$ano.$mes.$amovimiento.$estado.$producto.$mingreso.$fecha.$personal.$sucursal.$filtrar.$tpestado.$vmarca.$ptipo.$orden.$paginacion;	
		
		/*
				LEFT JOIN tblbdeboletadetalle bde
								ON bde.AmdId = amd.AmdId
						
							LEFT JOIN tblbolboleta bol
							ON bde.BolId = bol.BolId = bde.BtaId = bol.BtaId
							
								LEFT JOIN tblfdefacturadetalle fde
								ON fde.AmdId = amd.AmdId
								
							LEFT JOIN tblfacfactura fac
							ON fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId
							
		*/
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];			
		}
		
		

}
?>