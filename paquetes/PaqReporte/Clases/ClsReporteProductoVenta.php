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

class ClsReporteProductoVenta {

	
	
	
    public $InsMysql;

	
    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}


public function MtdObtenerReporteProductoHistoriaPrecios($oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oMoneda=NULL,$oSucursal=NULL) {

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

		if(!empty($oProducto)){
			$producto = ' AND amd.ProId = "'.$oProducto.'" ';
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND amo.MonId = "'.$oMoneda.'" ';
		}

		if(!empty($oSucursal)){
			$sucursal = ' AND amo.SucId = "'.$oSucursal.'" ';
		}
			$sql = 'SELECT
					SQL_CALC_FOUND_ROWS 
					amd.AmdId,
					pro.ProId,
					pro.ProCodigoOriginal,
					pro.ProNombre,
					
					pro.ProMarca,
					pro.ProReferencia,
					DATE_FORMAT(amd.AmdFecha, "%d/%m/%Y") AS "NAmdFecha",
					
					IF(amo.AmoIncluyeImpuesto=1,(amd.AmdPrecioVenta/((amo.AmoPorcentajeImpuestoVenta/100)+1)),amd.AmdPrecioVenta) AS AmdPrecioVenta,
					amo.MonId,
					amo.AmoTipoCambio,
					amo.AmoIncluyeImpuesto,

					mon.MonSimbolo
					
					FROM tblamdalmacenmovimientodetalle amd
					
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
						
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId
						
						LEFT JOIN tblumeunidadmedida ume
						ON pro.UmeId = ume.UmeId
							
							LEFT JOIN tblrtiproductotipo rti
							ON pro.RtiId = rti.RtiId
									
									LEFT JOIN tblmonmoneda mon
									ON amo.MonId = mon.MonId
				WHERE amo.AmoEstado = 3 
				AND amo.AmoTipo = 2 
				AND (amo.AmoSubTipo = 3 OR amo.AmoSubTipo = 2)
				AND amd.AmdPrecioVenta > 0				
				'.$filtrar.$fecha.$producto.$moneda.$sucursal.$cliente.$cfingreso.$orden.$paginacion;
									
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsReporteProductoVenta = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReporteProductoVenta = new $InsReporteProductoVenta();
					$ReporteProductoVenta->AmdId = $fila['AmdId'];
                    $ReporteProductoVenta->ProId = $fila['ProId'];
					$ReporteProductoVenta->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$ReporteProductoVenta->ProNombre = $fila['ProNombre'];
					$ReporteProductoVenta->ProMarca = $fila['ProMarca'];
					$ReporteProductoVenta->ProReferencia = $fila['ProReferencia'];
					$ReporteProductoVenta->AmdFecha = $fila['NAmdFecha'];
						
					$ReporteProductoVenta->AmdPrecioVenta = $fila['AmdPrecioVenta'];
					$ReporteProductoVenta->MonId = $fila['MonId'];
					$ReporteProductoVenta->AmoTipoCambio = $fila['AmoTipoCambio'];
					$ReporteProductoVenta->AmoIncluyeImpuesto = $fila['AmoIncluyeImpuesto'];
					
					$ReporteProductoVenta->MonSimbolo = $fila['MonSimbolo'];
					
					
                    $ReporteProductoVenta->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ReporteProductoVenta;
            }
			
		
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
    public function MtdObtenerReporteProductoVentas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oProductoTipo=NULL,$oConVentaDirecta=0,$oConFichaIngreso=0,$oCliente=NULL) {

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


		if(!empty($oProductoTipo)){
			$ptipo = ' AND pro.RtiId = "'.$oProductoTipo.'"';
		}
		
		
		
		if(!empty($oConVentaDirecta)){
			$cvdirecta = ' AND amo.VdiId IS NOT NULL ';
		
		}


		if(!empty($oConFichaIngreso)){
			$cfingreso = ' AND amo.FccId IS NOT NULL ';
		}

		if(!empty($oCliente)){
			$cliente = ' AND amo.CliId = "'.$oCliente.'" ';
		}

		
			$sql = 'SELECT
					SQL_CALC_FOUND_ROWS 
					pro.ProId,
					pro.ProCodigoOriginal,
					pro.ProNombre,
					
					pro.ProMarca,
					pro.ProReferencia,
					
					SUM(IFNULL(amo.FccId,amd.AmdCantidad)) as PveCantidadVentaDirecta,
					SUM(IFNULL(amo.VdiId,amd.AmdCantidad)) as PveCantidadFichaIngreso,
					
					SUM(amd.AmdCantidad) AS PveCantidad,
					
					ume.UmeNombre,
					ume.UmeAbreviacion,
					
					rti.RtiNombre,
					
					DATEDIFF(IFNULL("'.$oFechaFin.'",NOW()),IFNULL("'.$oFechaInicio.'",NOW())) AS PveDiferenciaDia
					
				
					FROM tblamdalmacenmovimientodetalle amd
					
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
						
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId
						
						LEFT JOIN tblumeunidadmedida ume
						ON pro.UmeId = ume.UmeId
							
							LEFT JOIN tblrtiproductotipo rti
							ON pro.RtiId = rti.RtiId
									
				WHERE amo.AmoEstado = 3 AND amo.AmoTipo = 2 '.$filtrar.$fecha.$ptipo.$cvdirecta.$cliente.$cfingreso." GROUP BY amd.ProId ".$orden." ".$paginacion;
									
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsReporteProductoVenta = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReporteProductoVenta = new $InsReporteProductoVenta();
                    $ReporteProductoVenta->ProId = $fila['ProId'];
					$ReporteProductoVenta->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$ReporteProductoVenta->ProNombre = $fila['ProNombre'];
					$ReporteProductoVenta->ProMarca = $fila['ProMarca'];
					$ReporteProductoVenta->ProReferencia = $fila['ProReferencia'];
					
					
					$ReporteProductoVenta->PveCantidadVentaDirecta = $fila['PveCantidadVentaDirecta'];
					$ReporteProductoVenta->PveCantidadFichaIngreso = $fila['PveCantidadFichaIngreso'];
					
						
					
					$ReporteProductoVenta->PveCantidad = $fila['PveCantidad'];
					
					$ReporteProductoVenta->UmeNombre = $fila['UmeNombre'];
					$ReporteProductoVenta->UmeAbreviacion = $fila['UmeAbreviacion'];
					
					$ReporteProductoVenta->RtiNombre = $fila['RtiNombre'];
					
					$ReporteProductoVenta->PveDiferenciaDia = $fila['PveDiferenciaDia'];
					
                    $ReporteProductoVenta->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ReporteProductoVenta;
            }
			
		
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		  /*  public function MtdObtenerReporteProductoVentas2($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oProductoTipo=NULL,$oConVentaDirecta=0,$oConFichaIngreso=0) {

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


		if(!empty($oProductoTipo)){
			$ptipo = ' AND pro.RtiId = "'.$oProductoTipo.'"';
		}
		
		
		
		if(!empty($oConVentaDirecta)){
			$cvdirecta = ' AND amo.VdiId IS NOT NULL';
		
		}


		if(!empty($oConFichaIngreso)){
			$cfingreso = ' AND amo.FccId IS NOT NULL';
		}

		
			$sql = 'SELECT
					SQL_CALC_FOUND_ROWS 
					pro.ProId,
					pro.ProCodigoOriginal,
					pro.ProNombre,
					
					IFNULL(amo.VdiId,SUM(amd.AmdCantidad)) AS PveVentaDirecta,
					
					SUM(amd.AmdCantidad) AS PveCantidad,
					
					ume.UmeNombre,
					rti.RtiNombre
				
					FROM tblamdalmacenmovimientodetalle amd
					
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
						
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId
						
						LEFT JOIN tblumeunidadmedida ume
						ON pro.UmeId = ume.UmeId
							
							LEFT JOIN tblrtiproductotipo rti
							ON pro.RtiId = rti.RtiId
									
				WHERE amo.AmoEstado = 3 AND amo.AmoTipo = 2 '.$filtrar.$fecha.$ptipo.$cvdirecta.$cfingreso." GROUP BY amd.ProId ".$orden." ".$paginacion;
									
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsReporteProductoVenta = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReporteProductoVenta = new $InsReporteProductoVenta();
                    $ReporteProductoVenta->ProId = $fila['ProId'];
					$ReporteProductoVenta->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$ReporteProductoVenta->ProNombre = $fila['ProNombre'];
					
					$ReporteProductoVenta->PveCantidad = $fila['PveCantidad'];
					
					$ReporteProductoVenta->UmeNombre = $fila['UmeNombre'];
					$ReporteProductoVenta->RtiNombre = $fila['RtiNombre'];
					
                    $ReporteProductoVenta->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ReporteProductoVenta;
            }
			
		
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		*/
		
	 public function MtdObtenerReporteProductoVentaPendienteEntregas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VddId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaDirecta=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oMoneda=NULL,$oCliente=NULL,$oConOrdenCompraReferencia=NULL,$oConDespacho=NULL,$oConPendiente=false,$oPersonal=NULL,$oSucursal=NULL,$oTieneAbono=NULL) {

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
		
		if(!empty($oVentaDirecta)){
			$amovimiento = ' AND vdd.VdiId = "'.$oVentaDirecta.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND vdd.VddEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (vdd.ProId = "'.$oProducto.'") ';
		}
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vdi.VdiFecha)>="'.$oFechaInicio.'" AND DATE(vdi.VdiFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(vdi.VdiFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vdi.VdiFecha)<="'.$oFechaFin.'"';		
			}			
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND vdi.MonId = "'.$oMoneda.'"';
		}
		
		
		if(!empty($oCliente)){
			$cliente = ' AND vdi.CliId = "'.$oCliente.'"';
		}
		
		
		switch($oConOrdenCompraReferencia){
			
			case 1:
				$coreferencia = ' AND (vdi.VdiOrdenCompraNumero IS NOT NULL AND vdi.VdiOrdenCompraNumero <> "") ';
			break;
			
			case 2:
				$coreferencia = ' AND (vdi.VdiOrdenCompraNumero IS NULL OR vdi.VdiOrdenCompraNumero = "") ';
			break;
			
			default:
			
			break;
		}
		
		
		switch($oConDespacho){
			
			case 1:
				$cdespacho = ' AND EXISTS (
				
				SELECT 
				(pld.PldId)
				FROM tblpldpedidocomprallegadadetalle pld
						
						LEFT JOIN tblplepedidocomprallegada ple
						ON pld.PleId = ple.PleId
						
						LEFT JOIN tblpcdpedidocompradetalle pcd
						ON pld.PcdId = pcd.PcdId
					
							LEFT JOIN tblpcopedidocompra pco
							ON pcd.PcoId = pco.PcoId
						
					WHERE 
						pco.PcoEstado = 3
					AND pcd.VddId = vdd.VddId
					LIMIT 1	
				
				) ';
			break;
			
			case 2:
				$cdespacho = ' AND NOT EXISTS (
						
						SELECT 
				(pld.PldId)
				FROM tblpldpedidocomprallegadadetalle pld
						
						LEFT JOIN tblplepedidocomprallegada ple
						ON pld.PleId = ple.PleId
						
						LEFT JOIN tblpcdpedidocompradetalle pcd
						ON pld.PcdId = pcd.PcdId
					
							LEFT JOIN tblpcopedidocompra pco
							ON pcd.PcoId = pco.PcoId
						
					WHERE 
						pco.PcoEstado = 3
					AND pcd.VddId = vdd.VddId
					LIMIT 1	
					
				) ';
			break;
			
			default:
			
			break;
		}
		
		
		if(($oConPendiente)){
			
			$cpendiente = ' AND 
			
			IFNULL((

				SELECT 
				SUM(amd.AmdCantidad)
				FROM tblamdalmacenmovimientodetalle amd
				
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						
				WHERE amd.VddId = vdd.VddId
					AND amd.AmdEstado = 3
				LIMIT 1

			),0) < vdd.VddCantidad 
			
			';
		}
		
		if(!empty($oPersonal)){
			$personal = ' AND vdi.PerId = "'.$oPersonal.'"';
		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND vdi.SucId = "'.$oSucursal.'"';
		}
	
		if(!empty($oTieneAbono)){
			
			switch($oTieneAbono){
				
				case 1:
			
					$tabono = ' AND EXISTS (
							SELECT 
							
							pag.PagId
							
							FROM tblpagpago pag
							
								LEFT JOIN tblpacpagocomprobante pac
								ON	pac.PagId = pag.PagId
									
								WHERE pac.VdiId = vdi.VdiId
								AND pag.PagEstado <> 6
								
							LIMIT 1
							
									
						)
					
					';
				
				break;
				
				case 2:
				
					$tabono = ' AND NOT EXISTS (
					
							SELECT 
							
							pag.PagId
							
							FROM tblpagpago pag
								LEFT JOIN tblpacpagocomprobante pac
								ON	pac.PagId = pag.PagId
									
								WHERE pac.VdiId = vdi.VdiId
								AND pag.PagEstado <> 6
								
							LIMIT 1
									
						)
					
					';
	
				
				break;
				
				default:
				break;
				
			}
			
			
			
		}
	
	
	 
			
		 $sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			vdd.VddId,			
			vdd.VdiId,
			vdd.ProId,
			vdd.UmeId,
			vdd.CrdId,

			vdd.VddCantidad,
			vdd.VddCosto,
			vdd.VddValorTotal,
			vdd.VddUtilidad,
			
			vdd.VddPrecioBruto,
			vdd.VddDescuento,
			vdd.VddPrecioVenta,

			vdd.VddImporte,
			vdd.VddCodigoExterno,
			
			vdd.VddCantidadPedir,
			DATE_FORMAT(vdd.VddCantidadPedirFecha, "%d/%m/%Y") AS "NVddCantidadPedirFecha",
			
			vdd.VddTipoPedido,
			vdd.VddNota,
			vdd.VddAtendido,
			vdd.VddEstado,
			DATE_FORMAT(vdd.VddTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVddTiempoCreacion",
	        DATE_FORMAT(vdd.VddTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVddTiempoModificacion",
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume.UmeNombre,
	        DATE_FORMAT(vdi.VdiFecha, "%d/%m/%Y") AS "NVdiFecha",

			ein.VveId,

			(
				SELECT 
				pcd.PcdId 
				FROM tblpcdpedidocompradetalle pcd
				WHERE pcd.VddId = vdd.VddId
				LIMIT 1
			) AS PcdId,
			

			(
				SELECT 
				pcd.PcdBOEstado 
				FROM tblpcdpedidocompradetalle pcd
				WHERE pcd.VddId = vdd.VddId
				LIMIT 1
			) AS PcdBOEstado,
			
			(
				SELECT 
				DATE_FORMAT(pcd.PcdBOFecha, "%d/%m/%Y")
				FROM tblpcdpedidocompradetalle pcd
				WHERE pcd.VddId = vdd.VddId
				LIMIT 1
			) AS PcdBOFecha,

			(
				SELECT 
				amd.AmdId 
				FROM tblamdalmacenmovimientodetalle amd
				
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						
				WHERE amd.VddId = vdd.VddId
					AND amo.AmoEstado = 3
				LIMIT 1
			) AS AmdId,



			@ProIdPedido:=(
				SELECT 
				amd.ProId
				FROM tblpcdpedidocompradetalle pcd
					LEFT JOIN tblamdalmacenmovimientodetalle amd
					ON amd.PcdId = pcd.PcdId
					
					WHERE pcd.VddId = vdd.VddId
					
				LIMIT 1
			) AS ProIdPedido,

			@ProCodigoOriginalPedido:=(
				SELECT 
				pro.ProCodigoOriginal
				FROM tblpcdpedidocompradetalle pcd
					LEFT JOIN tblamdalmacenmovimientodetalle amd
					ON amd.PcdId = pcd.PcdId
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId
						
					WHERE pcd.VddId = vdd.VddId
					
				LIMIT 1
			) AS ProCodigoOriginalPedido,

			IF(IFNULL(@ProIdPedido,vdd.ProId)<>vdd.ProId,"Si","No") AS VddReemplazo,


			@AmdCantidad:=(

				SELECT 
				SUM(amd.AmdCantidad)
				FROM tblamdalmacenmovimientodetalle amd
				
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						
				WHERE amd.VddId = vdd.VddId
					AND amd.AmdEstado = 3
				LIMIT 1

			) AS AmdCantidad,
			
			@AmdCantidadEntrada:=(
			
				SELECT 
				SUM(amd.AmdCantidad)
				FROM tblamdalmacenmovimientodetalle amd
					
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON amd.PcdId = pcd.PcdId
					
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId

				WHERE pcd.VddId = vdd.VddId
					AND amd.AmdEstado = 3
				LIMIT 1

			) AS AmdCantidadEntrada,
			
			
			@PcdCantidad:=(
			
				SELECT 
				SUM(pcd.PcdCantidad)
				FROM tblpcdpedidocompradetalle pcd
				
					LEFT JOIN tblpcopedidocompra pco
					ON pcd.PcoId = pco.PcoId
						
				WHERE pcd.VddId = vdd.VddId
					AND pco.PcoEstado = 3
					AND pcd.PcdEstado <> 10
				LIMIT 1

			) AS PcdCantidad,


			(
			IFNULL(vdd.VddCantidad,0) - IFNULL(@AmdCantidad,0) - IFNULL(@PcdCantidad,0) 				
			) AS VddCantidadPendiente,
		
			(
			IFNULL(vdd.VddCantidad,0) - IFNULL(@AmdCantidad,0)
			) AS VddCantidadPendiente2,
			

			
			(SELECT 
			SUM(amd.AmdCantidad)
			FROM tblamdalmacenmovimientodetalle amd

				LEFT JOIN tblamoalmacenmovimiento amo
				ON amd.AmoId = amo.AmoId
			
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON amd.PcdId = pcd.PcdId
					
						LEFT JOIN tblpcopedidocompra pco
						ON pcd.PcoId = pco.PcoId

				WHERE amo.AmoTipo = 1
					AND amd.AmdEstado = 3
					AND pco.PcoEstado = 3

				AND pcd.VddId = vdd.VddId
				
			) AS VddCantidadLlegada,
			
			
			(
			SELECT 
			SUM(pld.PldCantidad)
			FROM tblpldpedidocomprallegadadetalle pld
						
				LEFT JOIN tblplepedidocomprallegada ple
				ON pld.PleId  = ple.PleId

					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON pld.PcdId = pcd.PcdId
				
						LEFT JOIN tblpcopedidocompra pco
						ON pcd.PcoId = pco.PcoId

				WHERE 
					ple.PleEstado = 3
				AND pcd.VddId = vdd.VddId
				
			) AS VddCantidadPorLlegar,
			
		
			(
			SELECT 
			SUM(pld.PldCantidad)
			FROM tblpldpedidocomprallegadadetalle pld
						
				LEFT JOIN tblplepedidocomprallegada ple
				ON pld.PleId  = ple.PleId

					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON pld.PcdId = pcd.PcdId
				
						LEFT JOIN tblpcopedidocompra pco
						ON pcd.PcoId = pco.PcoId

				WHERE 
					pld.PldEstado = 3
				AND pcd.VddId = vdd.VddId
				
			) AS VddCantidadPorLlegarReal,
		
		
			(SELECT 
			DATE_FORMAT(ple.PleFecha, "%d/%m/%Y")
			FROM tblpldpedidocomprallegadadetalle pld
					
					LEFT JOIN tblplepedidocomprallegada ple
					ON pld.PleId = ple.PleId
					
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON pld.PcdId = pcd.PcdId
				
						LEFT JOIN tblpcopedidocompra pco
						ON pcd.PcoId = pco.PcoId
					
				WHERE 
					pco.PcoEstado = 3
				AND pcd.VddId = vdd.VddId
				LIMIT 1					
			) AS VddFechaPorLlegar,
			
			
			(
				SELECT 
				(amd.AmdEstado)
				FROM tblamdalmacenmovimientodetalle amd
					
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON amd.PcdId = pcd.PcdId
					
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId

				WHERE pcd.VddId = vdd.VddId

					AND amo.AmoEstado = 3
					ORDER BY amd.AmdTiempoCreacion DESC
				LIMIT 1

			) AS AmdEstado,
			
			
			cli.CliNombreCompleto,
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			cli.CliNumeroDocumento,
			
			cli.CliTelefono,
			cli.CliCelular,
			cli.CliEmail,
			cli.CliDepartamento,
			
			cli.TdoId,
			tdo.TdoNombre,
			
			mon.MonNombre,
			mon.MonSimbolo,
			
			vdi.VdiTipoCambio,
			vdi.VdiTotal,
			DATE_FORMAT(vdi.VdiOrdenCompraFecha, "%d/%m/%Y") AS "NVdiOrdenCompraFecha",
			vdi.VdiOrdenCompraNumero,
			
			lti.LtiNombre,
			lti.LtiAbreviatura,
			
			vdi.VdiIncluyeImpuesto,
			vdi.VdiTipoPedido,
			
			pro.ProUbicacion,
			
			(
				SELECT 
				DATEDIFF(DATE(NOW()),oco.OcoFecha) 
				FROM tblpcdpedidocompradetalle pcd				
					LEFT JOIN tblpcopedidocompra pco
					ON pcd.PcoId = pco.PcoId					
						LEFT JOIN tblocoordencompra oco
						ON pco.OcoId = oco.OcoId
						
				WHERE pcd.VddId = vdd.VddId
					AND pco.PcoEstado = 3
					AND pcd.PcdEstado <> 10
				LIMIT 1

			) AS OcoDiaTranscurrido,
			
			
			
			(
				SELECT 
				oco.OcoId
			
				FROM tblpcdpedidocompradetalle pcd				
					LEFT JOIN tblpcopedidocompra pco
					ON pcd.PcoId = pco.PcoId					
						LEFT JOIN tblocoordencompra oco
						ON pco.OcoId = oco.OcoId
						
				WHERE pcd.VddId = vdd.VddId
					AND pco.PcoEstado = 3
					AND pcd.PcdEstado <> 10
				LIMIT 1

			) AS OcoId,
			
			
			(
				SELECT 
				DATE_FORMAT(oco.OcoFecha, "%d/%m/%Y")
			
				FROM tblpcdpedidocompradetalle pcd				
					LEFT JOIN tblpcopedidocompra pco
					ON pcd.PcoId = pco.PcoId					
						LEFT JOIN tblocoordencompra oco
						ON pco.OcoId = oco.OcoId
						
				WHERE pcd.VddId = vdd.VddId
					AND pco.PcoEstado = 3
					AND pcd.PcdEstado <> 10
				LIMIT 1

			) AS OcoFecha,
			
			suc.SucNombre,
			
			CASE
			WHEN EXISTS (
				SELECT 
				pag.PagId
				FROM tblpagpago pag
					LEFT JOIN tblpacpagocomprobante pac
					ON	pac.PagId = pag.PagId
						
					WHERE pac.VdiId = vdi.VdiId
					AND pag.PagEstado <> 6
						
			) THEN "Si"
			ELSE "No"
			END AS RpvTieneAbono,
			
			
				(
					SELECT 
					pco.PcoId
					FROM tblpcopedidocompra pco
					WHERE pco.VdiId = vdi.VdiId
					LIMIT 1
				) PcoId

			
			
			FROM tblvddventadirectadetalle vdd

				LEFT JOIN tblproproducto pro
				ON vdd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON vdd.UmeId = ume.UmeId				
						LEFT JOIN tblvdiventadirecta vdi
						ON vdd.VdiId = vdi.VdiId
								LEFT JOIN tbleinvehiculoingreso ein
								ON vdi.EinId = ein.EinId
								
								LEFT JOIN tblclicliente cli
								ON vdi.CliId = cli.CliId
								
									LEFT JOIN tbllticlientetipo lti
									ON cli.LtiId = lti.LtiId
									
									LEFT JOIN tbltdotipodocumento tdo
									ON cli.TdoId = tdo.TdoId
									
										LEFT JOIN tblmonmoneda mon
										ON vdi.MonId = mon.MonId
										
										LEFT JOIN tblsucsucursal suc
										ON vdi.SucId = suc.SucId
										
			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$tabono.$fecha.$sucursal.$cpendiente.$moneda.$cliente.$coreferencia.$cdespacho.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVentaDirectaDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VentaDirectaDetalle = new $InsVentaDirectaDetalle();
                    $VentaDirectaDetalle->VddId = $fila['VddId'];
                    $VentaDirectaDetalle->VdiId = $fila['VdiId'];
					$VentaDirectaDetalle->UmeId = $fila['UmeId'];
					$VentaDirectaDetalle->CrdId = $fila['CrdId'];
					
			        $VentaDirectaDetalle->VddCantidad = $fila['VddCantidad'];  
					$VentaDirectaDetalle->VddCosto = $fila['VddCosto'];  					
					$VentaDirectaDetalle->VddValorTotal = $fila['VddValorTotal'];  
					$VentaDirectaDetalle->VddUtilidad = $fila['VddUtilidad'];  					
					
					$VentaDirectaDetalle->VddPrecioBruto = $fila['VddPrecioBruto'];  	
					$VentaDirectaDetalle->VddDescuento = $fila['VddDescuento'];  	
					$VentaDirectaDetalle->VddPrecioVenta = $fila['VddPrecioVenta'];  	
				
					$VentaDirectaDetalle->VddImporte = $fila['VddImporte'];
					$VentaDirectaDetalle->VddCodigoExterno = $fila['VddCodigoExterno'];

					$VentaDirectaDetalle->VddCantidadPedir = $fila['VddCantidadPedir'];  
					$VentaDirectaDetalle->VddCantidadPedirFecha = $fila['NVddCantidadPedirFecha'];  

					$VentaDirectaDetalle->VddTipoPedido = $fila['VddTipoPedido'];  
					$VentaDirectaDetalle->VddNota = $fila['VddNota'];  
					$VentaDirectaDetalle->VddNotaResumen = substr($VentaDirectaDetalle->VddNota, 0, 50);
					
					
					$VentaDirectaDetalle->VddAtendido = $fila['VddAtendido'];  
					$VentaDirectaDetalle->VddEstado = $fila['VddEstado'];  
					$VentaDirectaDetalle->VddTiempoCreacion = $fila['NVddTiempoCreacion'];  
					$VentaDirectaDetalle->VddTiempoModificacion = $fila['NVddTiempoModificacion']; 					
					$VentaDirectaDetalle->ProId = $fila['ProId'];
					$VentaDirectaDetalle->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$VentaDirectaDetalle->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
                    $VentaDirectaDetalle->ProNombre = (($fila['ProNombre']));
					$VentaDirectaDetalle->RtiId = (($fila['RtiId']));
					$VentaDirectaDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					
					$VentaDirectaDetalle->UmeNombre = (($fila['UmeNombre']));
					
					$VentaDirectaDetalle->VdiFecha = (($fila['NVdiFecha']));
					
					$VentaDirectaDetalle->VveId = (($fila['VveId']));
					
					$VentaDirectaDetalle->PcdId = (($fila['PcdId']));
					
					$VentaDirectaDetalle->PcdBOEstado = (($fila['PcdBOEstado']));
					$VentaDirectaDetalle->PcdBOFecha = (($fila['PcdBOFecha']));

					$VentaDirectaDetalle->PcdCantidad = (($fila['PcdCantidad']));
					
					$VentaDirectaDetalle->ProIdPedido = (($fila['ProIdPedido']));
					$VentaDirectaDetalle->ProCodigoOriginalPedido = (($fila['ProCodigoOriginalPedido']));
					$VentaDirectaDetalle->VddReemplazo = (($fila['VddReemplazo']));
					//deb($VentaDirectaDetalle->VddReemplazo);

			
					$VentaDirectaDetalle->AmdId = (($fila['AmdId']));
					$VentaDirectaDetalle->AmdCantidad = (($fila['AmdCantidad']));
					$VentaDirectaDetalle->AmdCantidadEntrada = (($fila['AmdCantidadEntrada']));
					
					
					$VentaDirectaDetalle->VddCantidadPendiente = (($fila['VddCantidadPendiente']));
					$VentaDirectaDetalle->VddCantidadPendiente2 = (($fila['VddCantidadPendiente2']));
					//$VentaDirectaDetalle->VddCantidadConcretar = (($fila['VddCantidadConcretar']));
					$VentaDirectaDetalle->AmdEstado = (($fila['AmdEstado']));
					
					$VentaDirectaDetalle->VddCantidadLlegada = (($fila['VddCantidadLlegada']));
					$VentaDirectaDetalle->VddCantidadPorLlegar = (($fila['VddCantidadPorLlegar']));
					$VentaDirectaDetalle->VddCantidadPorLlegarReal = (($fila['VddCantidadPorLlegarReal']));

					$VentaDirectaDetalle->VddFechaPorLlegar = (($fila['VddFechaPorLlegar']));
					$VentaDirectaDetalle->AmdEstado = (($fila['AmdEstado']));

					$VentaDirectaDetalle->CliNombreCompleto = (($fila['CliNombreCompleto']));
					$VentaDirectaDetalle->CliNombre = (($fila['CliNombre']));
					$VentaDirectaDetalle->CliApellidoPaterno = (($fila['CliApellidoPaterno']));
					$VentaDirectaDetalle->CliApellidoMaterno = (($fila['CliApellidoMaterno']));
					$VentaDirectaDetalle->CliNumeroDocumento = (($fila['CliNumeroDocumento']));
					
					$VentaDirectaDetalle->CliTelefono = (($fila['CliTelefono']));
					$VentaDirectaDetalle->CliCelular = (($fila['CliCelular']));
					$VentaDirectaDetalle->CliEmail = (($fila['CliEmail']));
					$VentaDirectaDetalle->CliDepartamento = (($fila['CliDepartamento']));
					
					
					
					$VentaDirectaDetalle->TdoId = (($fila['TdoId']));
					$VentaDirectaDetalle->TdoNombre = (($fila['TdoNombre']));
					
					$VentaDirectaDetalle->MonNombre = (($fila['MonNombre']));
					$VentaDirectaDetalle->MonSimbolo = (($fila['MonSimbolo']));
					
					$VentaDirectaDetalle->VdiTipoCambio = (($fila['VdiTipoCambio']));
					$VentaDirectaDetalle->VdiTotal = (($fila['VdiTotal']));
					
					$VentaDirectaDetalle->VdiOrdenCompraFecha = (($fila['NVdiOrdenCompraFecha']));
					$VentaDirectaDetalle->VdiOrdenCompraNumero = (($fila['VdiOrdenCompraNumero']));
					
						
					$VentaDirectaDetalle->LtiNombre = (($fila['LtiNombre']));
					$VentaDirectaDetalle->LtiAbreviatura = (($fila['LtiAbreviatura']));
					
					$VentaDirectaDetalle->VdiIncluyeImpuesto = (($fila['VdiIncluyeImpuesto']));
$VentaDirectaDetalle->VdiTipoPedido = (($fila['VdiTipoPedido']));

					$VentaDirectaDetalle->ProUbicacion = (($fila['ProUbicacion']));
					$VentaDirectaDetalle->OcoDiaTranscurrido = (($fila['OcoDiaTranscurrido']));
					$VentaDirectaDetalle->OcoId = (($fila['OcoId']));
					$VentaDirectaDetalle->OcoFecha = (($fila['OcoFecha']));

					$VentaDirectaDetalle->SucNombre = (($fila['SucNombre']));
					
					$VentaDirectaDetalle->RpvTieneAbono = (($fila['RpvTieneAbono']));

$VentaDirectaDetalle->PcoId = (($fila['PcoId']));
					

                    $VentaDirectaDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VentaDirectaDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
public function MtdObtenerReporteProductoVentaValor($oFuncion="SUM",$oParametro="AmdId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL){

		if(!empty($oCampo) && !empty($oFiltro)){
			$oFiltro = str_replace("*","%",$oFiltro);
			switch($oCondicion){
				case "esigual":
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'"';	
				break;

				case "noesigual":
					$filtrar = ' AND '.($oCampo).' <> "'.($oFiltro).'"';
				break;
				
				case "comienza":
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
				break;
				
				case "termina":
					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'"';
				break;
				
				case "contiene":
					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
				break;
				
				case "nocontiene":
					$filtrar = ' AND '.($oCampo).' NOT LIKE "%'.($oFiltro).'%"';
				break;
				
				default:
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
				break;
				
			}
			

		}
		
		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amd.AmdFecha)>="'.$oFechaInicio.'" AND DATE(amd.AmdFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(amd.AmdFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amd.AmdFecha)<="'.$oFechaFin.'"';		
			}			
		}

		
		if(!empty($oSucursal)){
				$sucursal = ' AND (amo.SucId) = "'.$oSucursal.'"';		
			}
			
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
	
		if(!empty($oMes)){
			$mes = ' AND MONTH(amd.AmdFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(amd.AmdFecha) ="'.($oAno).'"';
		}
		
		
		$sql = 'SELECT
		'.$funcion.' AS "RESULTADO"
		FROM tblamdalmacenmovimientodetalle amd
			LEFT JOIN tblamoalmacenmovimiento amo
			ON amd.AmoId = amo.AmoId
		
		WHERE amo.AmoTipo =2
		AND amd.AmdEstado = 3
		
		'.$filtrar.$sucursal.$estado.$fecha.$credito.$talonario.$regimen.$npago.$vendedor.$moneda.$mes.$ano.$amovimiento.$cliente.$clasificacion.$ctipo.$sucursal.$mkilometraje.$vmarca.$vmodelo.$tecnico.$mingreso.$origen.$orden.$paginacion;
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];
		}



}
?>