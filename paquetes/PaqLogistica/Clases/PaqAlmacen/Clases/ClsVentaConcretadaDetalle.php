<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVentaConcretadaDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVentaConcretadaDetalle {

    public $VcdId;
	public $AmoId;
	public $ProId;
	public $UmeId;
	
	public $VddId;
	
    public $VcdCantidad;	
	public $VcdCantidadReal;
	public $VcdCosto;

	public $VcdValorTotal;
	public $VcdUtilidad;
	public $VcdPrecioVenta;
	
	public $VcdImporte;	
	public $VcdReingreso;
	public $VcdEstado;	
	public $VcdTiempoCreacion;
	public $VcdTiempoModificacion;
    public $VcdEliminado;
	

	public $ProCodigoOriginal;
	public $ProCodigoAlternativo;
	public $ProNombre;
	public $RtiId;
	public $UmeIdOrigen;
	
	public $UmeNombre;
	public $UmeAbreviacion;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarVentaConcretadaDetalleId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(AmdId,5),unsigned)) AS "MAXIMO"
			FROM tblamdalmacenmovimientodetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VcdId = "VCD-10000";
			}else{
				$fila['MAXIMO']++;
				$this->VcdId = "VCD-".$fila['MAXIMO'];					
			}
				
		}
		

    public function MtdObtenerVentaConcretadaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaConcretada=NULL,$oEstado=NULL,$oProducto=NULL,$oVentaDirectaDetalleId=NULL,$oVentaConcretadaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) {

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
		
		if(!empty($oVentaConcretada)){
			$vconcretada = ' AND amd.AmoId = "'.$oVentaConcretada.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND amd.AmdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (amd.ProId = "'.$oProducto.'") ';
		}
	
		if(!empty($oVentaDirectaDetalleId)){
			$vddetalle = ' AND (amd.VddId = "'.$oVentaDirectaDetalleId.'") ';
		}

		if(!empty($oVentaConcretadaEstado)){
			$vcestado = ' AND (amo.AmoEstado = "'.$oVentaConcretadaEstado.'") ';
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
			$ptipo = ' AND (pro.RtiId = "'.$oProductoTipo.'") ';
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
		
				
		 $sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			amd.AmdId,			
			amd.AmoId,
			amd.ProId,
			amd.UmeId,
			
			amd.VddId,
			
			amd.AmdCosto,
			amd.AmdCantidad,
			amd.AmdCantidadReal,

			amd.AmdValorTotal,
			amd.AmdUtilidad,
			amd.AmdPrecioVenta,

			amd.AmdImporte,

			amd.AmdReingreso,
			amd.AmdCompraOrigen,
			amd.AmdCierre,
			amd.AmdEstado,
			DATE_FORMAT(amd.AmdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAmdTiempoCreacion",
	        DATE_FORMAT(amd.AmdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAmdTiempoModificacion",
			
			vdd.VdiId,
			
			


(
		

				IFNULL(
					(
						SELECT 
						CONCAT(fta.FtaNumero,"-",fac.FacId) 
						FROM tblfacfactura fac
							LEFT JOIN tblftafacturatalonario fta
							ON fac.FtaId = fta.FtaId
						WHERE amd.AmoId = fac.AmoId
						AND fac.FacEstado <> 6 LIMIT 1
					),
						IFNULL(
						(
							SELECT 
							CONCAT(fta.FtaNumero,"-",fac.FacId) 
							FROM tblfacfactura fac
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
									LEFT JOIN tblfdefacturadetalle fde
									ON (fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId)
									
							WHERE amd.AmdId = fde.AmdId
							AND fac.FacEstado <> 6 LIMIT 1
						),
						""
						)
					)
				
			) AS VcdFactura,
			
			
			
			
			
			
					(
		

				IFNULL(
					(
						SELECT 
						CONCAT(bta.BtaNumero,"-",bol.BolId) 
						FROM tblbolboleta bol
							LEFT JOIN tblbtaboletatalonario bta
							ON bol.BtaId = bta.BtaId
						WHERE amd.AmoId = bol.AmoId
						AND bol.BolEstado <> 6 LIMIT 1
					),
						IFNULL(
						(
							SELECT 
							CONCAT(bta.BtaNumero,"-",bol.BolId) 
							FROM tblbolboleta bol
								LEFT JOIN tblbtaboletatalonario bta
								ON bol.BtaId = bta.BtaId
									LEFT JOIN tblbdeboletadetalle bde
									ON (bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId)
									
							WHERE amd.AmdId = bde.AmdId
							AND bol.BolEstado <> 6 LIMIT 1
						),
						""
						)
					)
				
			) AS VcdBoleta,
			
			
			
			
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume.UmeNombre,
			ume.UmeAbreviacion,
			
	        DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
			
			cli.CliNombreCompleto,
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			
			vdd.ProId AS ProIdReemplazo,
			pro2.ProCodigoOriginal AS ProCodigoOriginalReemplazo,
			
			IF(vdd.ProId<>amd.ProId,"Si","No") AS AmdReemplazo,
			
			
			
			@AmdFacturado:=(
			
				SELECT 
				SUM(fde.FdeCantidad)
				FROM tblfdefacturadetalle fde
					
						LEFT JOIN tblfacfactura fac
						ON (fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId)

				WHERE fde.AmdId = amd.AmdId
				
					AND fac.FacEstado <> 6
					
					AND NOT EXISTS(
														SELECT 	
														ncr.NcrId
														FROM tblncrnotacredito ncr
														WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
														AND ncr.NcrEstado <> 6
AND ncr.NcrMotivoCodigo<> "04"
													)
					
					
				LIMIT 1

			) AS AmdFacturado,
			
			
			@AmdFacturado2:=(
			
				SELECT 
				SUM(bde.BdeCantidad)
				FROM tblbdeboletadetalle bde
				
					LEFT JOIN tblbolboleta bol
					ON (bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId)
						
				WHERE bde.AmdId = amd.AmdId
					AND bol.BolEstado <> 6
					
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
						)
						
				LIMIT 1

			) AS AmdFacturado2,

			(
			amd.AmdCantidad - IFNULL(@AmdFacturado,0) - IFNULL(@AmdFacturado2,0)
			) AS AmdCantidadFacturar			
			
			FROM tblamdalmacenmovimientodetalle amd
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON amd.UmeId = ume.UmeId				
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							LEFT JOIN tblclicliente cli
							ON amo.CliId = cli.CliId
								LEFT JOIN tblvddventadirectadetalle vdd
								ON amd.VddId = vdd.VddId
									LEFT JOIN tblproproducto pro2
									ON vdd.ProId = pro2.ProId
			WHERE amo.AmoTipo = 2 
			AND amo.AmoSubTipo = 3 
			'.$vconcretada.$estado.$producto.$filtrar.$vddetalle.$vcestado.$vmarca.$fecha.$ptipo .$orden.$paginacion;	

			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();

            $InsVentaConcretadaDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VentaConcretadaDetalle = new $InsVentaConcretadaDetalle();
                    $VentaConcretadaDetalle->VcdId = $fila['AmdId'];
                    $VentaConcretadaDetalle->VcoId = $fila['AmoId'];
					$VentaConcretadaDetalle->UmeId = $fila['UmeId'];
					
					$VentaConcretadaDetalle->VddId = $fila['VddId'];
					
					$VentaConcretadaDetalle->VcdCosto = $fila['AmdCosto'];  
			        $VentaConcretadaDetalle->VcdCantidad = $fila['AmdCantidad'];  
					$VentaConcretadaDetalle->VcdCantidadReal = $fila['AmdCantidadReal'];  
					
					$VentaConcretadaDetalle->VcdValorTotal = $fila['AmdValorTotal'];  
					$VentaConcretadaDetalle->VcdUtilidad = $fila['AmdUtilidad'];  					
					$VentaConcretadaDetalle->VcdPrecioVenta = $fila['AmdPrecioVenta'];  					

					$VentaConcretadaDetalle->VcdImporte = $fila['AmdImporte'];
					$VentaConcretadaDetalle->VcdReingreso = $fila['AmdReingreso'];
					$VentaConcretadaDetalle->VcdCompraOrigen = $fila['AmdCompraOrigen'];
					
					
					$VentaConcretadaDetalle->VcdCierre = $fila['AmdCierre'];
					$VentaConcretadaDetalle->VcdEstado = $fila['AmdEstado'];
					$VentaConcretadaDetalle->VcdTiempoCreacion = $fila['NAmdTiempoCreacion'];  
					$VentaConcretadaDetalle->VcdTiempoModificacion = $fila['NAmdTiempoModificacion']; 					
				
					
					$VentaConcretadaDetalle->VdiId = $fila['VdiId'];
					
					$VentaConcretadaDetalle->VcdFactura = $fila['VcdFactura'];
					$VentaConcretadaDetalle->VcdBoleta = $fila['VcdBoleta'];
					
					
					$VentaConcretadaDetalle->ProId = $fila['ProId'];
					$VentaConcretadaDetalle->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$VentaConcretadaDetalle->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
                    $VentaConcretadaDetalle->ProNombre = (($fila['ProNombre']));
					$VentaConcretadaDetalle->RtiId = (($fila['RtiId']));
					$VentaConcretadaDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					
					$VentaConcretadaDetalle->UmeNombre = (($fila['UmeNombre']));
					$VentaConcretadaDetalle->UmeAbreviacion = (($fila['UmeAbreviacion']));
					
					
					//$VentaConcretadaDetalle->AmoFecha = (($fila['NAmoFecha']));
					$VentaConcretadaDetalle->VcoFecha = (($fila['NAmoFecha']));
					
					$VentaConcretadaDetalle->CliNombreCompleto = (($fila['CliNombreCompleto']));
					$VentaConcretadaDetalle->CliNombre = (($fila['CliNombre']));
					$VentaConcretadaDetalle->CliApellidoPaterno = (($fila['CliApellidoPaterno']));
					$VentaConcretadaDetalle->CliApellidoMaterno = (($fila['CliApellidoMaterno']));
					
					$VentaConcretadaDetalle->ProIdReemplazo = (($fila['ProIdReemplazo']));
					$VentaConcretadaDetalle->ProCodigoOriginalReemplazo = (($fila['ProCodigoOriginalReemplazo']));
					$VentaConcretadaDetalle->AmdReemplazo = (($fila['AmdReemplazo']));
					
					$VentaConcretadaDetalle->VcdCantidadFacturar = (($fila['AmdCantidadFacturar']));
	
			
                    $VentaConcretadaDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VentaConcretadaDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
	 public function MtdObtenerVentaConcretadaDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaConcretada=NULL,$oEstado=NULL,$oProducto=NULL,$oVentaDirectaDetalleId=NULL,$oVentaConcretadaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL) {

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
		
		if(!empty($oVentaConcretada)){
			$vconcretada = ' AND amd.AmoId = "'.$oVentaConcretada.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND amd.AmdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (amd.ProId = "'.$oProducto.'") ';
		}
	
		if(!empty($oVentaDirectaDetalleId)){
			$vddetalle = ' AND (amd.VddId = "'.$oVentaDirectaDetalleId.'") ';
		}

		if(!empty($oVentaConcretadaEstado)){
			$vcestado = ' AND (amo.AmoEstado = "'.$oVentaConcretadaEstado.'") ';
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
			$ptipo = ' AND (pro.RtiId = "'.$oProductoTipo.'") ';
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
							LEFT JOIN tblclicliente cli
							ON amo.CliId = cli.CliId
							
			WHERE  amo.AmoTipo = 2  AND amo.AmoSubTipo = 3 '.$ano.$mes.$vconcretada.$estado.$producto.$filtrar.$vddetalle.$vcestado.$vmarca.$ptipo.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];		
		}	
		
	//Accion eliminar	 
	
	public function MtdEliminarVentaConcretadaDetalle($oElementos) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (AmdId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (AmdId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblamdalmacenmovimientodetalle 
				WHERE '.$eliminar;
							
				$error = false;
	
				$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
				
				if(!$resultado) {						
					$error = true;
				} 	
				
	
			
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	
	
	
		public function MtdActualizarEstadoVentaConcretadaDetalle($oElementos,$oEstado) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$actualizar .= '  (AmdId = "'.($elemento).'")';	
					}else{
						$actualizar .= '  (AmdId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'UPDATE tblamdalmacenmovimientodetalle SET 
				AmdEstado = '.$oEstado.'
				WHERE '.$actualizar;
							
				$error = false;
	
				$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
				
				if(!$resultado) {						
					$error = true;
				} 	
				
	
			
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	
	
	public function MtdRegistrarVentaConcretadaDetalle() {
	
			$this->MtdGenerarVentaConcretadaDetalleId();
			
			$sql = 'INSERT INTO tblamdalmacenmovimientodetalle (
			AmdId,
			AmoId,	
			ProId,
			UmeId,
			
			FaaId,
			FapId,
			VddId,
			
			PcdId,
			
			TadId,
			PpdId,
			
			AmdIdAnterior,
			AmdIdOrigen,
			
			AmdCosto,
			AmdCostoAnterior,
			AmdCostoExtraTotal,
			AmdCantidad,
			AmdCantidadReal,
			
			AmdValorTotal,
			AmdUtilidad,
			AmdPrecioVenta,
			
			AmdImporte,
			AmdCostoPromedio,

			AmdInternacionalTotalAduana,
			AmdInternacionalTotalTransporte,
			AmdInternacionalTotalDesestiba,
			AmdInternacionalTotalAlmacenaje,
			AmdInternacionalTotalAdValorem,
			AmdInternacionalTotalAduanaNacional,
			AmdInternacionalTotalGastoAdministrativo,
			AmdInternacionalTotalOtroCosto1,
			AmdInternacionalTotalOtroCosto2,
		
			AmdNacionalTotalRecargo,
			AmdNacionalTotalFlete,
			AmdNacionalTotalOtroCosto,
			
			AlmId,
			AmdFecha,
			AmdReingreso,	
			AmdCompraOrigen,
			
			AmdCierre,		
			AmdEstado,
			AmdTiempoCreacion,
			AmdTiempoModificacion
			) 
			VALUES (
			"'.($this->VcdId).'", 
			"'.($this->VcoId).'", 
			"'.($this->ProId).'", 
			"'.($this->UmeId).'", 
			
			NULL,
			NULL,
			'.(empty($this->VddId)?'NULL, ':'"'.$this->VddId.'",').'
			
			NULL,
			
			NULL,
			NULL,
			
			NULL,
			NULL,
			
			'.($this->VcdCosto).', 
			0,
			'.($this->VcdCostoExtraTotal).', 
			'.($this->VcdCantidad).',
			'.($this->VcdCantidadReal).',
			
			'.($this->VcdValorTotal).',
			'.($this->VcdUtilidad).',
			'.($this->VcdPrecioVenta).',
			
			'.($this->VcdImporte).', 
			0,
			0,
			0,
			0,
			0,
			0,
			0,
			0,
			0,
			0,
			0,
			0,
			0,
			
			"'.($this->AlmId).'",
			"'.($this->VcdFecha).'",
			"'.($this->VcdReingreso).'",
			"'.($this->VcdCompraOrigen).'",
			
			2,
			'.($this->VcdEstado).',
			"'.($this->VcdTiempoCreacion).'",
			"'.($this->VcdTiempoModificacion).'");';
		
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 	
		
			if($error) {						
				return false;
			} else {				
				return true;
			}			
			
	}
	
	public function MtdEditarVentaConcretadaDetalle() {

			$sql = 'UPDATE tblamdalmacenmovimientodetalle SET 	
			ProId = "'.($this->ProId).'",
			UmeId = "'.($this->UmeId).'",
			AmdCosto = '.($this->VcdCosto).',
			AmdCostoExtraTotal = '.($this->VcdCostoExtraTotal).',
			AmdCantidad = '.($this->VcdCantidad).',
			AmdCantidadReal = '.($this->VcdCantidadReal).',
			
			AmdValorTotal = '.($this->VcdValorTotal).',
			AmdUtilidad = '.($this->VcdUtilidad).',
			AmdPrecioVenta = '.($this->VcdPrecioVenta).',	
			
			AlmId = "'.($this->AlmId).'",
			AmdCompraOrigen = "'.($this->VcdCompraOrigen).'",
			
			AmdFecha = "'.($this->VcdFecha).'",
			AmdImporte = '.($this->VcdImporte).',
			
			AmdEstado = '.($this->VcdEstado).',
			AmdTiempoModificacion = "'.($this->VcdTiempoModificacion).'"
					
			WHERE AmdId = "'.($this->VcdId).'";';
					
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {						
				return false;
			} else {				
				return true;
			}						
				
		}	
	
//	
	
}
?>