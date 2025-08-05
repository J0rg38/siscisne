<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsTrasladoAlmacenSalidaDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsTrasladoAlmacenSalidaDetalle {

    public $TsdId;
	public $AmoId;
	public $ProId;
	public $UmeId;
	
	public $FaaId;
	public $FapId;
	
    public $TsdCantidad;	
	public $TsdCantidadReal;
	public $TsdCosto;

	public $TsdValorTotal;
	public $TsdUtilidad;
	public $TsdPrecioVenta;
	
	public $TsdImporte;	
	public $TsdEstado;	
	public $TsdTiempoCreacion;
	public $TsdTiempoModificacion;
    public $TsdEliminado;
	

	public $ProCodigoOriginal;
	public $ProCodigoAlternativo;
	public $ProNombre;
	public $RtiId;
	public $UmeIdOrigen;
	
	public $UmeNombre;
	public $UmeAbreviacion;
	
	public $FaaAccion;
	public $FaaNivel;
	public $FaaVerificar1;
	public $FaaVerificar2;

				
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarTrasladoAlmacenSalidaDetalleId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(AmdId,5),unsigned)) AS "MAXIMO"
			FROM tblamdalmacenmovimientodetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->TsdId = "TSD-10000";
			}else{
				$fila['MAXIMO']++;
				$this->TsdId = "TSD-".$fila['MAXIMO'];					
			}
				
		}
		
		
   public function MtdObtenerTrasladoAlmacenSalidaDetalle(){

		$sql = 'SELECT
			 
			amd.AmdId AS TsdId,			
			amd.AmoId AS TasId,
			amd.ProId,
			amd.UmeId,
			
			amd.AmdCosto AS TsdCosto,
			amd.AmdCantidad AS TsdCantidad,
			amd.AmdCantidadReal AS TsdCantidadReal,

			amd.AmdValorTotal AS TsdValorTotal,
			amd.AmdUtilidad AS TsdUtilidad,
			amd.AmdPrecioVenta AS TsdPrecioVenta,

			amd.AmdImporte AS TsdImporte,
			DATE_FORMAT(amd.AmdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "TsdTiempoCreacion",
	        DATE_FORMAT(amd.AmdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "TsdTiempoModificacion",

			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume.UmeNombre,
			ume.UmeAbreviacion,
			
	        DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "TasFecha"
			
			FROM tblamdalmacenmovimientodetalle amd
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON amd.UmeId = ume.UmeId				
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId

		WHERE amd.AmdId = "'.$this->TsdId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {

			$this->TsdId = $fila['TsdId'];
			$this->TasId = $fila['TasId'];
			$this->UmeId = $fila['UmeId'];
			
			$this->TsdCosto = $fila['TsdCosto'];  
			$this->TsdCantidad = $fila['TsdCantidad'];  
			$this->TsdCantidadReal = $fila['TsdCantidadReal'];  
			
			$this->TsdValorTotal = $fila['TsdValorTotal'];  
			$this->TsdUtilidad = $fila['TsdUtilidad'];  					
			$this->TsdPrecioVenta = $fila['TsdPrecioVenta'];  					
			
			$this->TsdImporte = $fila['TsdImporte'];
			$this->TsdTiempoCreacion = $fila['TsdTiempoCreacion'];  
			$this->TsdTiempoModificacion = $fila['TsdTiempoModificacion']; 					
			$this->ProId = $fila['ProId'];
			$this->ProCodigoOriginal = $fila['ProCodigoOriginal'];
			$this->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
			$this->ProNombre = (($fila['ProNombre']));
			$this->RtiId = (($fila['RtiId']));
			$this->UmeIdOrigen = (($fila['UmeIdOrigen']));
			
			$this->UmeNombre = (($fila['UmeNombre']));
			$this->UmeAbreviacion = (($fila['UmeAbreviacion']));
			
			$this->TasFecha = (($fila['TasFecha']));
			
			$this->PmtId = (($fila['PmtId']));
			
		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	

    public function MtdObtenerTrasladoAlmacenSalidaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTrasladoAlmacenSalida=NULL,$oEstado=NULL,$oProducto=NULL,$oTrasladoAlmacenSalidaEstado=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oAlmacenId=NULL) {

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
		
		if(!empty($oTrasladoAlmacenSalida)){
			$amovimiento = ' AND amd.AmoId = "'.$oTrasladoAlmacenSalida.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND amd.AmdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (amd.ProId = "'.$oProducto.'") ';
		}
		
		if(!empty($oTrasladoAlmacenSalidaEstado)){
			$amestado = ' AND (amo.AmoEstado = '.$oTrasladoAlmacenSalidaEstado.') ';
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
		
		
		if(!empty($oAlmacenId)){
			$almacen = ' AND (amo.AlmId = "'.$oAlmacenId.'") ';
		}	
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			amd.AmdId AS TsdId,			
			amd.AmoId AS TasId,
			amd.ProId,
			amd.UmeId,
			
			amd.AmdCosto AS TadId,
			amd.AmdCantidad AS TsdCantidad,
			amd.AmdCantidadReal AS TsdCantidadReal,

			amd.AmdEstado AS TsdEstado,
			DATE_FORMAT(amd.AmdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "TsdTiempoCreacion",
	        DATE_FORMAT(amd.AmdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "TsdTiempoModificacion",
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume2.UmeNombre  AS "UmeNombreOrigen",
			ume.UmeNombre,
			ume.UmeAbreviacion,
			
	        DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "TasFecha",
			
			cli.CliNombreCompleto,
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			
			cli.CliNumeroDocumento,
			
			top.TopNombre,
			
			pro.ProUbicacion,
			
			
			@AmdCantidadAtendida:=(

				SELECT 
				SUM(amd2.AmdCantidad)
				FROM tblamdalmacenmovimientodetalle amd2
				
						
				WHERE amd2.AmdIdOrigen = amd.AmdId
					AND amd2.AmdEstado = 3
				LIMIT 1

			) AS TasCantidadAtendida,
			
			(
			IFNULL(amd.AmdCantidad,0) - IFNULL(@AmdCantidadAtendida,0)
			) AS TasCantidadPendiente
			
			
			
			
			FROM tblamdalmacenmovimientodetalle amd
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
				
			
					LEFT JOIN tblumeunidadmedida ume
					ON amd.UmeId = ume.UmeId		

						LEFT JOIN tblumeunidadmedida ume2
						ON pro.UmeId = ume2.UmeId

							LEFT JOIN tblamoalmacenmovimiento amo
							ON amd.AmoId = amo.AmoId
							
											LEFT JOIN tblclicliente cli
											ON amo.CliId = cli.CliId
								
								LEFT JOIN tbltoptipooperacion top
								ON amo.TopId = top.TopId
	
			WHERE   amo.AmoTipo = 2 
		
			'.$amovimiento.$fecha.$estado.$producto.$filtrar.$amestado.$vmarca.$almacen.$ptipo.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsTrasladoAlmacenSalidaDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$TrasladoAlmacenSalidaDetalle = new $InsTrasladoAlmacenSalidaDetalle();
                    $TrasladoAlmacenSalidaDetalle->TsdId = $fila['TsdId'];
                    $TrasladoAlmacenSalidaDetalle->TasId = $fila['TasId'];
					$TrasladoAlmacenSalidaDetalle->UmeId = $fila['UmeId'];
					
			        $TrasladoAlmacenSalidaDetalle->TsdCantidad = $fila['TsdCantidad'];    
					$TrasladoAlmacenSalidaDetalle->TsdCantidadReal = $fila['TsdCantidadReal'];  
									
					$TrasladoAlmacenSalidaDetalle->TsdEstado = $fila['TsdEstado'];
					$TrasladoAlmacenSalidaDetalle->TsdTiempoCreacion = $fila['TsdTiempoCreacion'];  
					$TrasladoAlmacenSalidaDetalle->TsdTiempoModificacion = $fila['TsdTiempoModificacion']; 					
					$TrasladoAlmacenSalidaDetalle->ProId = $fila['ProId'];
					$TrasladoAlmacenSalidaDetalle->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$TrasladoAlmacenSalidaDetalle->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
                    $TrasladoAlmacenSalidaDetalle->ProNombre = (($fila['ProNombre']));
					$TrasladoAlmacenSalidaDetalle->RtiId = (($fila['RtiId']));
					$TrasladoAlmacenSalidaDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					$TrasladoAlmacenSalidaDetalle->UmeNombreOrigen = (($fila['UmeNombreOrigen']));
					
					$TrasladoAlmacenSalidaDetalle->UmeNombre = (($fila['UmeNombre']));
					$TrasladoAlmacenSalidaDetalle->UmeAbreviacion = (($fila['UmeAbreviacion']));
					
					$TrasladoAlmacenSalidaDetalle->TasFecha = (($fila['TasFecha']));
					
					$TrasladoAlmacenSalidaDetalle->CliNombreCompleto = (($fila['CliNombreCompleto']));
					$TrasladoAlmacenSalidaDetalle->CliNombre = (($fila['CliNombre']));
					$TrasladoAlmacenSalidaDetalle->CliApellidoPaterno = (($fila['CliApellidoPaterno']));
					$TrasladoAlmacenSalidaDetalle->CliApellidoMaterno = (($fila['CliApellidoMaterno']));
					$TrasladoAlmacenSalidaDetalle->CliNumeroDocumento = (($fila['CliNumeroDocumento']));
					
					$TrasladoAlmacenSalidaDetalle->TopNombre = (($fila['TopNombre']));
					$TrasladoAlmacenSalidaDetalle->ProUbicacion = (($fila['ProUbicacion']));
			  
				  	$TrasladoAlmacenSalidaDetalle->TasCantidadPendiente = (($fila['TasCantidadPendiente']));
					$TrasladoAlmacenSalidaDetalle->TasCantidadAtendida = (($fila['TasCantidadAtendida']));


					$Respuesta['Datos'][]= $TrasladoAlmacenSalidaDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		




    public function MtdObtenerTrasladoAlmacenSalidaDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTrasladoAlmacenSalida=NULL,$oEstado=NULL,$oProducto=NULL,$oTrasladoAlmacenSalidaEstado=NULL,$oProductoTipo=NULL) {

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
		
		if(!empty($oTrasladoAlmacenSalida)){
			$amovimiento = ' AND amd.AmoId = "'.$oTrasladoAlmacenSalida.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND amd.AmdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (amd.ProId = "'.$oProducto.'") ';
		}

		if(!empty($oTrasladoAlmacenSalidaEstado)){
			$amestado = ' AND (amo.AmoEstado = '.$oTrasladoAlmacenSalidaEstado.') ';
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
				
					LEFT JOIN tblvddventadirectadetalle vdd
					ON amd.VddId = vdd.VddId
					
					LEFT JOIN tblumeunidadmedida ume
					ON amd.UmeId = ume.UmeId		

						LEFT JOIN tblumeunidadmedida ume2
						ON pro.UmeId = ume2.UmeId

							LEFT JOIN tblamoalmacenmovimiento amo
							ON amd.AmoId = amo.AmoId
							
							LEFT JOIN tblfccfichaaccion fcc
							ON amo.FccId = fcc.FccId
								
								LEFT JOIN tblfimfichaingresomodalidad fim
								ON fcc.FimId = fim.FimId
								
									LEFT JOIN tblfinfichaingreso fin
									ON fim.FinId = fin.FinId
									
										LEFT JOIN tblminmodalidadingreso min
										ON fim.MinId = min.MinId
				
											LEFT JOIN tblclicliente cli
											ON fin.CliId = cli.CliId
								
								LEFT JOIN tbltoptipooperacion top
								ON amo.TopId = top.TopId
	
								LEFT JOIN tblfaafichaaccionmantenimiento faa
								ON amd.FaaId = faa.FaaId
									LEFT JOIN tblpmtplanmantenimientotarea pmt
									ON faa.PmtId = pmt.PmtId
			WHERE   amo.AmoTipo = 2 '.$ano.$mes.$amovimiento.$estado.$producto.$filtrar.$amestado.$vmarca.$ptipo.$orden.$paginacion;	
			
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];
		}
				
		
	//Accion eliminar	 
	
	public function MtdEliminarTrasladoAlmacenSalidaDetalle($oElementos) {

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
	public function MtdActualizarEstadoTrasladoAlmacenSalidaDetalle($oElementos,$oEstado) {

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
	
	public function MtdRegistrarTrasladoAlmacenSalidaDetalle() {
	
			$this->MtdGenerarTrasladoAlmacenSalidaDetalleId();
			
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
			AmdEstado,
			AmdTiempoCreacion,
			AmdTiempoModificacion
			) 
			VALUES (
			"'.($this->TsdId).'", 
			"'.($this->TasId).'", 
			"'.($this->ProId).'", 
			"'.trim($this->UmeId).'", 
			
			'.(empty($this->FaaId)?'NULL, ':'"'.$this->FaaId.'",').'
			'.(empty($this->FapId)?'NULL, ':'"'.$this->FapId.'",').'
			'.(empty($this->VddId)?'NULL, ':'"'.$this->VddId.'",').'
			
			NULL,
				NULL,
			NULL,
		
		
			0,
			
			0,
			0,
			'.($this->TsdCantidad).',
			'.($this->TsdCantidadReal).',
			
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
			0,
			0,
			0,
			0,
			
			"'.($this->AlmId).'",
			"'.($this->TsdFecha).'",
			'.($this->TsdEstado).',
			"'.($this->TsdTiempoCreacion).'",
			"'.($this->TsdTiempoModificacion).'");';
		
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
	
	public function MtdEditarTrasladoAlmacenSalidaDetalle() {

			$sql = 'UPDATE tblamdalmacenmovimientodetalle SET 	
			ProId = "'.($this->ProId).'",
			UmeId = "'.trim($this->UmeId).'",
			
			AmdCantidad = '.($this->TsdCantidad).',
			AmdCantidadReal = '.($this->TsdCantidadReal).',
			
			
			AlmId = "'.trim($this->AlmId).'",
			AmdFecha = "'.trim($this->TsdFecha).'",
			AmdEstado = "'.trim($this->TsdEstado).'",
			AmdTiempoModificacion  = "'.($this->TsdTiempoModificacion).'"
			WHERE AmdId = "'.($this->TsdId).'";';
					
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
	
	
	
		public function MtdEditarTrasladoAlmacenSalidaDetalleDato($oCampo,$oDato,$oTrasladoAlmacenSalidaDetalleId) {

			$sql = 'UPDATE tblamdalmacenmovimientodetalle SET 	
			'.(empty($oDato)?$oCampo.' = NULL ':$oCampo.' = "'.$oDato.'"').'
			 WHERE AmdId = "'.($oTrasladoAlmacenSalidaDetalleId).'";';
					
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
		
		
}
?>