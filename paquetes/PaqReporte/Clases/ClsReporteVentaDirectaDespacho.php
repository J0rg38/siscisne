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

class ClsReporteVentaDirectaDespacho {

	public $VddId;
	public $VdiId;
	public $VdiFecha;
	public $VdiOrdenCompraNumero;
	public $VdiOrdenCompraFecha;
	public $ProCodigoOriginal;
	public $ProNombre;
	public $CliNombre;
	public $RvdDespacho;
	
    public $InsMysql;

	
    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

    public function MtdObtenerReporteVentaDirectaDespachos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFecha=NULL,$oCliente=NULL) {

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
		
		if(!empty($oFecha)){
			$fecha = '
			
				AND
				EXISTS(
					
					SELECT 	
					pld.PldId
					FROM tblpldpedidocomprallegadadetalle pld
				
							LEFT JOIN tblplepedidocomprallegada ple
							ON pld.PleId = ple.PleId
				
								LEFT JOIN tblpcdpedidocompradetalle pcd
								ON pld.PcdId = pcd.PcdId
				
									LEFT JOIN tblvddventadirectadetalle vdd2
									ON pcd.VddId = vdd2.VddId
				
					WHERE ple.PleFecha = "'.$oFecha.'"
						AND vdd2.VdiId = vdi.VdiId
						
				)
			';		
		}



		if(!empty($oCliente)){
			$cliente = ' AND vdi.CliId = "'.$oCliente.'" ';
		}

			$sql = 'SELECT
					SQL_CALC_FOUND_ROWS 
					vdd.VddId,
					vdd.VdiId,
					
					DATE_FORMAT(vdi.VdiFecha, "%d/%m/%Y") AS "NVdiFecha",
					vdi.VdiOrdenCompraNumero,
					DATE_FORMAT(vdi.VdiOrdenCompraFecha, "%d/%m/%Y") AS "NVdiOrdenCompraFecha",
					
					pro.ProCodigoOriginal,
					pro.ProNombre,
					cli.CliNombre,
					
							CASE
							WHEN EXISTS (
								
					(
						
						SELECT 	
						ple.PleFecha
						FROM tblpldpedidocomprallegadadetalle pld
					
								LEFT JOIN tblplepedidocomprallegada ple
								ON pld.PleId = ple.PleId
					
									LEFT JOIN tblpcdpedidocompradetalle pcd
									ON pld.PcdId = pcd.PcdId
					
									
					
						WHERE pcd.VddId = vdd.VddId
						
						'.(empty($oFecha)?'':' AND ple.PleFecha = "'.$oFecha.'" ').'
						
					
					LIMIT 1
					) 
					
							) THEN "Si"
							ELSE "No"
							END AS RvdDespacho,

					(
						SELECT 
						pco.OcoId
						FROM tblpcdpedidocompradetalle pcd
							LEFT JOIN tblpcopedidocompra pco
							ON pcd.PcoId = pco.PcoId
							
						WHERE pcd.VddId = vdd.VddId
						
						LIMIT 1
					
					) AS OcoId
							
					FROM tblvddventadirectadetalle vdd
					
						LEFT JOIN tblvdiventadirecta vdi
						ON vdd.VdiId = vdi.VdiId
							LEFT JOIN tblclicliente cli
							ON vdi.CliId = cli.CliId	
								LEFT JOIN tblproproducto pro
								ON vdd.ProId = pro.ProId
									
				WHERE 1 = 1 '.$filtrar.$fecha.$cliente.$orden.$paginacion;
									
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsReporteVentaDirectaDespacho = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReporteVentaDirectaDespacho = new $InsReporteVentaDirectaDespacho();
					
					
					$ReporteVentaDirectaDespacho->VddId = $fila['VddId'];
					$ReporteVentaDirectaDespacho->VdiId = $fila['VdiId'];
					$ReporteVentaDirectaDespacho->VdiFecha = $fila['NVdiFecha'];
					$ReporteVentaDirectaDespacho->VdiOrdenCompraNumero = $fila['VdiOrdenCompraNumero'];
					$ReporteVentaDirectaDespacho->VdiOrdenCompraFecha = $fila['NVdiOrdenCompraFecha'];
					$ReporteVentaDirectaDespacho->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$ReporteVentaDirectaDespacho->ProNombre = $fila['ProNombre'];
					$ReporteVentaDirectaDespacho->CliNombre = $fila['CliNombre'];
					$ReporteVentaDirectaDespacho->RvdDespacho = $fila['RvdDespacho'];
					
					$ReporteVentaDirectaDespacho->OcoId = $fila['OcoId'];
		
                    $ReporteVentaDirectaDespacho->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ReporteVentaDirectaDespacho;
            }
			
		
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		    public function MtdObtenerReporteVentaDirectaDespachos2($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oProductoTipo=NULL,$oConVentaDirecta=0,$oConFichaIngreso=0) {

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
					
					IFNULL(amo.VdiId,SUM(amd.AmdCantidad)) AS VdpVentaDirecta,
					
					SUM(amd.AmdCantidad) AS VdpCantidad,
					
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
			
            $InsReporteVentaDirectaDespacho = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReporteVentaDirectaDespacho = new $InsReporteVentaDirectaDespacho();
                    $ReporteVentaDirectaDespacho->ProId = $fila['ProId'];
					$ReporteVentaDirectaDespacho->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$ReporteVentaDirectaDespacho->ProNombre = $fila['ProNombre'];
					
					$ReporteVentaDirectaDespacho->VdpCantidad = $fila['VdpCantidad'];
					
					$ReporteVentaDirectaDespacho->UmeNombre = $fila['UmeNombre'];
					$ReporteVentaDirectaDespacho->RtiNombre = $fila['RtiNombre'];
					
                    $ReporteVentaDirectaDespacho->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ReporteVentaDirectaDespacho;
            }
			
		
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
	

}
?>