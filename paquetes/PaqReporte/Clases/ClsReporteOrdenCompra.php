<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsReporteFichaIngreso
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReporteOrdenCompra {


    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	 public function MtdObtenerReporteOrdenCompra($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oMoneda=NULL,$oOrdenCompraTipo=NULL,$oTipoPedido=NULL,$oProveedor=NULL) {

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
				$fecha = ' AND DATE(oco.OcoFecha)>="'.$oFechaInicio.'" AND DATE(oco.OcoFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(oco.OcoFecha)>="'.$oFechaInicio.'"';
			}
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(oco.OcoFecha)<="'.$oFechaFin.'"';		
			}			
		}
		
		if(!empty($oOrdenCompra)){
			$ocompra = ' AND (pco.OcoId = "'.$oOrdenCompra.'") ';
		}

		if(!empty($oCliente)){
			$cliente = ' AND (pco.CliId = "'.$oCliente.'") ';
		}

		if(!empty($oMoneda)){
			$moneda = ' AND (pco.MonId = "'.$oMoneda.'") ';
		}	
		

		if(!empty($oOrdenCompraTipo)){
			$octipo = ' AND (oco.OcoTipo = "'.$oOrdenCompraTipo.'") ';
		}	
		
		if(!empty($oProveedor)){
			$proveedor = ' AND (oco.PrvId = "'.$oProveedor.'") ';
		}	
		
		if(!empty($oTipoPedido)){
			$tpedido = ' AND (oco.OcoTipo = "'.$oTipoPedido.'") ';
		}	
		//$POST_OrdenCompraTipo
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			pco.OcoId,
			DATE_FORMAT(oco.OcoFecha, "%d/%m/%Y") AS "NOcoFecha",
			DATE_FORMAT(oco.OcoFechaLlegadaEstimada, "%d/%m/%Y") AS "NOcoFechaLlegadaEstimada",
			oco.OcoTipo,
			
			pco.MonId,
			pco.PcoTipoCambio,
			pco.PcoTotal,
		
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			
			IF(ROUND((
				SELECT 
				SUM(fac.FacTotal)
				FROM tblfacfactura fac
			
					WHERE EXISTS(
						SELECT 
						fam.FamId
						FROM tblfamfacturaalmacenmovimiento fam
							LEFT JOIN tblamoalmacenmovimiento amo
							ON fam.AmoId = amo.AmoId
								LEFT JOIN tblvdiventadirecta vdi
								ON amo.VdiId = vdi.VdiId
						WHERE fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId	
						AND pco.VdiId = vdi.VdiId
						
					)
			
			LIMIT 1
			),0)>0,"SI","NO") AS RocFacturado,

			IF(ROUND((
				SELECT 
				SUM(fac.FacTotal)
				FROM tblfacfactura fac
			
					WHERE EXISTS(
						SELECT 
						fam.FamId
						FROM tblfamfacturaalmacenmovimiento fam
							LEFT JOIN tblamoalmacenmovimiento amo
							ON fam.AmoId = amo.AmoId
								LEFT JOIN tblvdiventadirecta vdi
								ON amo.VdiId = vdi.VdiId
						WHERE fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId	
						AND pco.VdiId = vdi.VdiId
						
					)
					AND fac.FacCancelado = 1
			
			LIMIT 1
			),0)>0,"SI","NO") AS RocCancelado,

			IF((
			SELECT
			SUM(pag.PagMonto)
			FROM tblpagpago pag
				WHERE EXISTS(
					SELECT 
					pac.PacId
					FROM tblpacpagocomprobante pac
						LEFT JOIN tblvdiventadirecta vdi 
						ON pac.VdiId = vdi.VdiId
					WHERE pac.PagId = pag.PagId
					AND pco.VdiId = vdi .VdiId
				)
			)>0,"SI","NO") AS RocAdelanto


			FROM tblpcopedidocompra pco
				LEFT JOIN tblocoordencompra oco
				ON pco.OcoId = oco.OcoId
					LEFT JOIN tblclicliente cli
					ON pco.CliId = cli.CliId

			WHERE 1 = 1 '.$amovimiento.$estado.$producto.$tpedido.$proveedor.$filtrar.$octipo.$vddestado.$moneda.$fecha.$ocompra.$cocompra.$cliente.$vddetalle.$pcestado.$recibida.$dtranscurrido.$fingreso.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPedidoCompraDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$PedidoCompraDetalle = new $InsPedidoCompraDetalle();
                    $PedidoCompraDetalle->OcoId = $fila['OcoId'];
                    $PedidoCompraDetalle->OcoFecha = $fila['NOcoFecha'];
					$PedidoCompraDetalle->OcoFechaLlegadaEstimada = $fila['NOcoFechaLlegadaEstimada'];
					
					$PedidoCompraDetalle->OcoTipo = $fila['OcoTipo'];					
					$PedidoCompraDetalle->MonId = $fila['MonId'];					
					$PedidoCompraDetalle->PcoTipoCambio = $fila['PcoTipoCambio'];
					$PedidoCompraDetalle->PcoTotal = $fila['PcoTotal'];
					
					$PedidoCompraDetalle->CliNombre = $fila['CliNombre'];
					$PedidoCompraDetalle->CliApellidoPaterno = $fila['CliApellidoPaterno'];  
					$PedidoCompraDetalle->CliApellidoMaterno = $fila['CliApellidoMaterno'];  
					
					$PedidoCompraDetalle->RocFacturado = $fila['RocFacturado'];  
					$PedidoCompraDetalle->RocCancelado = $fila['RocCancelado'];  
					$PedidoCompraDetalle->RocAdelanto = $fila['RocAdelanto'];  
					
				
				     $PedidoCompraDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $PedidoCompraDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		

}
?>