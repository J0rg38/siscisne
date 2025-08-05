<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsOrdenCompraDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsOrdenCompraDetalle {

    public $OcdId;
	public $OcoId;
	public $PcdId;
	
	public $ProId;
	public $UmeId;
	public $OcdCodigoOtro;	
	public $OcdAno;
	public $OcdModelo;
	
    public $OcdCantidad;
	public $OcdSaldo;
	public $OcdPrecio;
	public $OcdImporte;	

	public $OcdEstado;	
	public $OcdTiempoCreacion;
	public $OcdTiempoModificacion;
    public $OcdEliminado;
	
	public $ProNombre;
	public $RtiId;
	public $UmeNombre;
	public $ProCosto;	

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}


	public function MtdObtenerOrdenCompraDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oOrdenCompra=NULL,$oEstado=NULL,$oProducto=NULL) {

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
		
		if(!empty($oOrdenCompra)){
			$ocompra = ' AND pco.OcoId = "'.$oOrdenCompra.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND pcd.PcdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (pcd.ProId = "'.$oProducto.'") ';
		}
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			pcd.PcdId,			
			pcd.PcoId,
			pcd.ProId,
			pcd.UmeId,
			pcd.VddId,
			
			pcd.PcdPrecio,
			
			SUM(pcd.PcdCantidad) AS NPcdCantidad,
			pcd.PcdCantidad,
			
			pcd.PcdAno,
			pcd.PcdModelo,
			pcd.PcdCodigo,

			(pcd.PcdPrecio * IFNULL(SUM(pcd.PcdCantidad),0)) AS NPcdImporte		,	
			pcd.PcdImporte,
			
			DATE_FORMAT(pcd.PcdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPcdTiempoCreacion",
	        DATE_FORMAT(pcd.PcdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPcdTiempoModificacion",
			
			DATE_FORMAT(pco.PcoFecha, "%d/%m/%Y") AS "NPcoFecha",
			
			cli.CliNombreCompleto,			
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			
			pro.ProNombre,
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.RtiId,
			ume.UmeNombre,
			
			pro.UmeId AS "UmeIdOrigen",
			
			pco.PcoTipoCambio
			
			FROM tblpcdpedidocompradetalle pcd
				LEFT JOIN tblpcopedidocompra pco
				ON pcd.PcoId = pco.PcoId
					LEFT JOIN tblclicliente cli
					ON pco.CliId = cli.CliId
					
					LEFT JOIN tblproproducto pro
					ON pcd.ProId = pro.ProId
						LEFT JOIN tblumeunidadmedida ume
						ON pcd.UmeId = ume.UmeId
			WHERE  1 = 1 '.$ocompra.$estado.$producto.$filtrar.' GROUP BY pcd.ProId  '.$orden.' '.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsOrdenCompraDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$OrdenCompraDetalle = new $InsOrdenCompraDetalle();
                    $OrdenCompraDetalle->OcdId = $fila['PcdId'];
                    $OrdenCompraDetalle->PcoId = $fila['PcoId'];
					$OrdenCompraDetalle->UmeId = $fila['UmeId'];
					$OrdenCompraDetalle->VddId = $fila['VddId'];
					

					$OrdenCompraDetalle->OcdAno = $fila['PcdAno'];  
					$OrdenCompraDetalle->OcdModelo = $fila['PcdModelo'];  
					$OrdenCompraDetalle->OcdCodigo = $fila['PcdCodigo'];  
			
					$OrdenCompraDetalle->OcdPrecio = $fila['PcdPrecio'];  
			        $OrdenCompraDetalle->OcdCantidad = $fila['NPcdCantidad'];  
					$OrdenCompraDetalle->OcdImporte = $fila['NPcdImporte'];
					$OrdenCompraDetalle->OcdTiempoCreacion = $fila['NPcdTiempoCreacion'];  
					$OrdenCompraDetalle->OcdTiempoModificacion = $fila['NPcdTiempoModificacion']; 	
					
					$OrdenCompraDetalle->PcoFecha = $fila['NPcoFecha']; 	
					$OrdenCompraDetalle->CliNombreCompleto = $fila['CliNombreCompleto']; 	
					
					$OrdenCompraDetalle->CliNombre = $fila['CliNombre']; 	
					$OrdenCompraDetalle->CliApellidoPaterno = $fila['CliApellidoPaterno']; 	
					$OrdenCompraDetalle->CliApellidoMaterno = $fila['CliApellidoMaterno']; 	
					
							
					$OrdenCompraDetalle->ProId = $fila['ProId'];	
                    $OrdenCompraDetalle->ProNombre = (($fila['ProNombre']));
					$OrdenCompraDetalle->ProCodigoOriginal = (($fila['ProCodigoOriginal']));
					$OrdenCompraDetalle->ProCodigoAlternativo = (($fila['ProCodigoAlternativo']));
					$OrdenCompraDetalle->RtiId = (($fila['RtiId']));
					
					$OrdenCompraDetalle->UmeNombre = (($fila['UmeNombre']));
					
					$OrdenCompraDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					
					$OrdenCompraDetalle->PcoTipoCambio = $fila['PcoTipoCambio'];
					
                    $OrdenCompraDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $OrdenCompraDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
				
//
//    public function MtdObtenerOrdenCompraDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'OcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oOrdenCompra=NULL,$oEstado=NULL,$oProducto=NULL) {
//
//		if(!empty($oCampo) and !empty($oFiltro)){
//
//			$oFiltro = str_replace(" ","%",$oFiltro);			
//			$elementos = explode(",",$oCampo);
//
//			$i=1;
//			$filtrar .= '  AND (';
//			foreach($elementos as $elemento){
//					if(!empty($elemento)){				
//						if($i==count($elementos)){	
//
//						$filtrar .= ' (';
//							switch($oCondicion){
//					
//								case "esigual":
//									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
//								break;
//				
//								case "noesigual":
//									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
//								break;
//								
//								case "comienza":
//									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
//								break;
//								
//								case "termina":
//									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
//								break;
//								
//								case "contiene":
//									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
//								break;
//								
//								case "nocontiene":
//									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
//								break;
//								
//								default:
//									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
//								break;
//							
//							}
//							
//							$filtrar .= ' )';
//							
//						}else{
//							
//							$filtrar .= ' (';
//							switch($oCondicion){
//					
//								case "esigual":
//									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
//								break;
//				
//								case "noesigual":
//									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
//								break;
//								
//								case "comienza":
//									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
//								break;
//								
//								case "termina":
//									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
//								break;
//								
//								case "contiene":
//									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
//								break;
//								
//								case "nocontiene":
//									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
//								break;
//								
//								default:
//									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
//								break;
//							
//							}
//							
//							$filtrar .= ' ) OR';
//							
//						}
//					}
//				$i++;
//		
//				}
//				
//				$filtrar .= '  ) ';
//
//		}
//		
//		
//		
//
//		if(!empty($oOrden)){
//			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
//		}
//
//		if(!empty($oPaginacion)){
//			$paginacion = ' LIMIT '.($oPaginacion);
//		}
//		
//		if(!empty($oOrdenCompra)){
//			$amovimiento = ' AND ocd.OcoId = "'.$oOrdenCompra.'"';
//		}
//		
//		if(!empty($oEstado)){
//			$estado = ' AND ocd.OcdEstado = '.$oEstado.' ';
//		}
//		
//		if(!empty($oProducto)){
//			$producto = ' AND (ocd.ProId = "'.$oProducto.'") ';
//		}
//		
//		$sql = '
//			SELECT
//			SQL_CALC_FOUND_ROWS 
//			ocd.OcdId,			
//			ocd.OcoId,
//			ocd.PcdId,
//			
//			pcd.ProId,
//			pcd.UmeId,
//			ocd.OcdCodigoOtro,
//			ocd.OcdAno,
//			ocd.OcdModelo,
//			ocd.OcdPrecio,
//			ocd.OcdCantidad,			
//			ocd.OcdSaldo,
//			ocd.OcdImporte,
//			DATE_FORMAT(ocd.OcdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NOcdTiempoCreacion",
//	        DATE_FORMAT(ocd.OcdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NOcdTiempoModificacion",
//			pro.ProNombre,
//			pro.RtiId,
//			ume.UmeNombre,
//			pro.ProCosto
//			
//			FROM tblocdordencompradetalle ocd
//				LEFT JOIN tblpcdpedidocompradetalle pcd
//				ON ocd.PcdId = pcd.PcdId
//					LEFT JOIN tblproproducto pro
//					ON pcd.ProId = pro.ProId
//						LEFT JOIN tblumeunidadmedida ume
//						ON pcd.UmeId = ume.UmeId
//			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$filtrar.$orden.$paginacion;	
//		
//			$resultado = $this->InsMysql->MtdConsultar($sql);            
//
//			$Respuesta['Datos'] = array();
//			
//            $InsOrdenCompraDetalle = get_class($this);
//				
//				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
//
//					$OrdenCompraDetalle = new $InsOrdenCompraDetalle();
//                    $OrdenCompraDetalle->OcdId = $fila['OcdId'];
//                    $OrdenCompraDetalle->OcoId = $fila['OcoId'];
//					$OrdenCompraDetalle->OcdId = $fila['PcdId'];
//					
//					
//					$OrdenCompraDetalle->UmeId = $fila['UmeId'];
//					$OrdenCompraDetalle->OcdCodigoOtro = $fila['OcdCodigoOtro'];
//					$OrdenCompraDetalle->OcdAno = $fila['OcdAno'];
//					$OrdenCompraDetalle->OcdModelo = $fila['OcdModelo'];
//					$OrdenCompraDetalle->OcdPrecio = $fila['OcdPrecio'];  
//			        $OrdenCompraDetalle->OcdCantidad = $fila['OcdCantidad'];
//					$OrdenCompraDetalle->OcdSaldo = $fila['OcdSaldo'];
//					
//					$OrdenCompraDetalle->OcdImporte = $fila['OcdImporte'];
//					$OrdenCompraDetalle->OcdTiempoCreacion = $fila['NOcdTiempoCreacion'];  
//					$OrdenCompraDetalle->OcdTiempoModificacion = $fila['NOcdTiempoModificacion']; 					
//					
//					$OrdenCompraDetalle->ProId = $fila['ProId'];	
//                    $OrdenCompraDetalle->ProNombre = (($fila['ProNombre']));
//					$OrdenCompraDetalle->RtiId = (($fila['RtiId']));
//					$OrdenCompraDetalle->UmeNombre = (($fila['UmeNombre']));					
//					$OrdenCompraDetalle->ProCosto = (($fila['ProCosto']));
//					
//                    $OrdenCompraDetalle->InsMysql = NULL;                    
//					$Respuesta['Datos'][]= $OrdenCompraDetalle;
//                }
//			
//			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
//			 				
//			$Respuesta['Total'] = $filaTotal['TOTAL'];
//			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
//			
//			return $Respuesta;			
//		}
		
		
		
		
	
}
?>