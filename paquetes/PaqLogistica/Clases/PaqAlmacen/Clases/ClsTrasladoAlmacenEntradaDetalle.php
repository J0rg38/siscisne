<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsTrasladoAlmacenEntradaDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsTrasladoAlmacenEntradaDetalle {

	public $TedId;
	public $AmoId;
	public $ProId;
	public $UmeId;
    public $TedCantidad;	
	public $TedCantidadReal;
	public $TedIdAnterior;
	public $TedCosto;
	public $TedCostoAnterior;
	public $TedCostoExtraTotal;
	public $TedCostoExtraUnitario;
	public $TedImporte;	
	public $TedCostoPromedio;

	public $TedEstado;	
	public $TedTiempoCreacion;
	public $TedTiempoModificacion;
	public $TedEliminado;

	public $ProNombre;
	public $ProCodigoOriginal;
	public $ProCodigoAlternativo;
	public $RtiId;
	public $UmeIdOrigen;
	public $UmeNombre;
	public $UmeAbreviacion;

	public $AmoFecha;
	public $AmoComprobanteNumero;
	public $AmoComprobanteFecha;
	public $CtiNombre;
	
	public $AmoTotalNacional;
	public $AmoTotalInternacional;
	
	public $AmoSubTotal;
	
	public $PrvNombreCompleto;
	public $PrvNumeroDocumento;
	
	public $TopNombre;
	

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarTrasladoAlmacenEntradaDetalleId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(AmdId,5),unsigned)) AS "MAXIMO"
		FROM tblamdalmacenmovimientodetalle';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->TedId = "TED-10000";
		}else{
			$fila['MAXIMO']++;
			$this->TedId = "TED-".$fila['MAXIMO'];					
		}
				
	}
		
    public function MtdObtenerTrasladoAlmacenEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'TedId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oTrasladoAlmacenEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oAlmacenId=NULL) {

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
		
		if(!empty($oTrasladoAlmacenEntrada)){
			$amovimiento = ' AND amd.AmoId = "'.$oTrasladoAlmacenEntrada.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND amd.AmdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (amd.ProId = "'.$oProducto.'") ';
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
			amd.AmdId AS TedId,			
			amd.AmoId AS TaeId,
			amd.ProId,
			amd.UmeId,
			amd.AmdIdAnterior AS TedIdAnterior,

			amd.AmdCantidad AS TedCantidad,
			amd.AmdCantidadReal AS TedCantidadReal,
			
			amd.AmdUbicacion AS TedUbicacion,
			amd.AmdEstado AS TedEstado,
			DATE_FORMAT(amd.AmdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "TedTiempoCreacion",
	        DATE_FORMAT(amd.AmdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "TedTiempoModificacion",
			pro.ProNombre,
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.RtiId,
			pro.UmeId AS UmeIdOrigen,
			ume2.UmeNombre AS UmeNombreOrigen,

			ume.UmeNombre,
			ume.UmeAbreviacion,

			DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "TaeFecha",
			amo.AmoComprobanteNumero AS "TaeComprobanteNumero",
			DATE_FORMAT(amo.AmoComprobanteFecha, "%d/%m/%Y") AS "TaeComprobanteFecha",
			cti.CtiNombre,

			prv.PrvNombreCompleto,
			prv.PrvNumeroDocumento,

			top.TopNombre,

			amo.TopId,

			amo.AmoTipo AS TaeTipo,
			amo.AmoSubTipo AS TaeSubTipo
			
			


			FROM tblamdalmacenmovimientodetalle amd

				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON amd.UmeId = ume.UmeId	
						LEFT JOIN tblumeunidadmedida ume2
						ON pro.UmeId = ume2.UmeId
									
						LEFT  JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							LEFT JOIN tbltoptipooperacion top
							ON amo.TopId = top.TopId
							
							LEFT JOIN tblprvproveedor prv
							ON amo.PrvId = prv.PrvId
							
							LEFT JOIN tblcticomprobantetipo cti
							ON amo.CtiId = cti.CtiId
			WHERE  amo.AmoTipo = 1 '.$amovimiento.$estado.$producto.$filtrar.$fecha.$cliente.$cocompra.$ocompra.$pcdetalle.$vddetalle.$almacen .$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsTrasladoAlmacenEntradaDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$TrasladoAlmacenEntradaDetalle = new $InsTrasladoAlmacenEntradaDetalle();
                    $TrasladoAlmacenEntradaDetalle->TedId = $fila['TedId'];
                    $TrasladoAlmacenEntradaDetalle->TaeId = $fila['TaeId'];
					$TrasladoAlmacenEntradaDetalle->UmeId = $fila['UmeId'];
					$TrasladoAlmacenEntradaDetalle->TedIdAnterior = $fila['TedIdAnterior'];
					
			        $TrasladoAlmacenEntradaDetalle->TedCantidad = $fila['TedCantidad'];  
					$TrasladoAlmacenEntradaDetalle->TedCantidadReal = $fila['TedCantidadReal'];  
					
					$TrasladoAlmacenEntradaDetalle->TedUbicacion = $fila['TedUbicacion'];	
					$TrasladoAlmacenEntradaDetalle->TedEstado = $fila['TedEstado'];  
					$TrasladoAlmacenEntradaDetalle->TedTiempoCreacion = $fila['TedTiempoCreacion'];  
					$TrasladoAlmacenEntradaDetalle->TedTiempoModificacion = $fila['TedTiempoModificacion']; 					
					$TrasladoAlmacenEntradaDetalle->ProId = $fila['ProId'];	
					
					
					$TrasladoAlmacenEntradaDetalle->TaeFecha = $fila['TaeFecha'];	
					$TrasladoAlmacenEntradaDetalle->TaeComprobanteNumero = $fila['TaeComprobanteNumero'];	
					$TrasladoAlmacenEntradaDetalle->TaeComprobanteFecha = $fila['TaeComprobanteFecha'];	
					$TrasladoAlmacenEntradaDetalle->CtiNombre = $fila['CtiNombre'];
		
                    $TrasladoAlmacenEntradaDetalle->ProNombre = (($fila['ProNombre']));
					$TrasladoAlmacenEntradaDetalle->ProCodigoOriginal = (($fila['ProCodigoOriginal']));
					$TrasladoAlmacenEntradaDetalle->ProCodigoAlternativo = (($fila['ProCodigoAlternativo']));					
					$TrasladoAlmacenEntradaDetalle->RtiId = (($fila['RtiId']));
					$TrasladoAlmacenEntradaDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					$TrasladoAlmacenEntradaDetalle->UmeNombreOrigen = (($fila['UmeNombreOrigen']));
					$TrasladoAlmacenEntradaDetalle->UmeNombre = (($fila['UmeNombre']));
					$TrasladoAlmacenEntradaDetalle->UmeAbreviacion = (($fila['UmeAbreviacion']));
					
					$TrasladoAlmacenEntradaDetalle->PrvNombreCompleto = (($fila['PrvNombreCompleto']));
					$TrasladoAlmacenEntradaDetalle->PrvNumeroDocumento = (($fila['PrvNumeroDocumento']));

					$TrasladoAlmacenEntradaDetalle->TopNombre = (($fila['TopNombre']));

					$TrasladoAlmacenEntradaDetalle->TopId = (($fila['TopId']));
					
					$TrasladoAlmacenEntradaDetalle->TaeTipo = (($fila['TaeTipo']));
					$TrasladoAlmacenEntradaDetalle->TaeSubTipo = (($fila['TaeSubTipo']));
					
				
			
                    $TrasladoAlmacenEntradaDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $TrasladoAlmacenEntradaDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;					
			
		}
		
		
  public function MtdObtenerTrasladoAlmacenEntradaDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'TedId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oTrasladoAlmacenEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL,$oVentaDirectaDetalleId=NULL,$oTrasladoAlmacenEntradaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oDiasInactivoInicio=NULL,$oDiasInactivoFin=NULL) {

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
		
		if(!empty($oTrasladoAlmacenEntrada)){
			$amovimiento = ' AND amd.AmoId = "'.$oTrasladoAlmacenEntrada.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND amd.AmdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (amd.ProId = "'.$oProducto.'") ';
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

		if(!empty($oTrasladoAlmacenEntradaEstado)){
			$amestado = ' AND (amo.AmoEstado = "'.$oTrasladoAlmacenEntradaEstado.'") ';
		}
	
		if(!empty($oProductoTipo)){

			$elementos = explode(",",$oProductoTipo);

				$i=1;
				$ptipo .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$ptipo .= '  (pro.RtiId = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$ptipo .= ' OR ';	
						}
				$i++;		
				}
				
				$ptipo .= ' ) ';

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
		
	/*	@AmoFechaUltimaSalida :=(
				SELECT 
				amo2.AmoFecha
				FROM tblamdalmacenmovimientodetalle amd2
					LEFT JOIN tblamoalmacenmovimiento amo2
					ON amd2.AmoId = amo2.AmoId
						WHERE amo2.AmoTipo = 2
						AND amd2.ProId = amd.ProId
				ORDER BY amo2.AmoFecha DESC
				LIMIT 1

			),
			
			
			(TIMESTAMPDIFF(DAY, @AmoFechaUltimaSalida, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) ) AS AmoUltimaSalidaDiaTranscurridos*/
			$sql = '
			SELECT
			'.$funcion.' AS "RESULTADO"
			
			
			
			FROM tblamdalmacenmovimientodetalle amd
				LEFT JOIN tblpcdpedidocompradetalle pcd
				ON amd.PcdId = pcd.PcdId
					
					LEFT JOIN tblpcopedidocompra pco
					ON pcd.PcoId = pco.PcoId
					
						LEFT JOIN tblclicliente cli
						ON pco.CliId = cli.CliId
				
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON amd.UmeId = ume.UmeId	
						LEFT JOIN tblumeunidadmedida ume2
						ON pro.UmeId = ume2.UmeId
									
						LEFT  JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							LEFT JOIN tbltoptipooperacion top
							ON amo.TopId = top.TopId
							
							LEFT JOIN tblprvproveedor prv
							ON amo.PrvId = prv.PrvId
							
							LEFT JOIN tblcticomprobantetipo cti
							ON amo.CtiId = cti.CtiId

			WHERE  amo.AmoTipo = 1 '.$ano.$mes.$amovimiento.$estado.$producto.$filtrar.$fecha.$cliente.$cocompra.$ocompra.$pcdetalle.$vddetalle.$amestado.$vmarca.$ptipo.$dinactivo.$orden.$paginacion;	
					
					
//							(
//				SELECT 
//				DATE_FORMAT(amo2.AmoFecha, "%d/%m/%Y") 
//				FROM tblamdalmacenmovimientodetalle amd2
//					LEFT JOIN tblamoalmacenmovimiento amo2
//					ON amd2.AmoId = amo2.AmoId
//						WHERE amo2.AmoTipo = 2
//						AND amd2.ProId = amd.ProId
//				ORDER BY amo2.AmoFecha DESC
//				LIMIT 1
//
//			) AS AmoFechaUltimaSalida,
//			
//
//
//
//			IFNULL(
//				(SELECT 
//				DATE_FORMAT(amo2.AmoFecha, "%d/%m/%Y") 
//				FROM tblamdalmacenmovimientodetalle amd2
//					LEFT JOIN tblamoalmacenmovimiento amo2
//					ON amd2.AmoId = amo2.AmoId
//						WHERE amo2.AmoTipo = 2
//						AND amd2.ProId = amd.ProId
//				ORDER BY amo2.AmoFecha DESC
//				LIMIT 1),NOW()
//			) 
//			
//						
//			(TIMESTAMPDIFF(DAY, @AmoFechaUltimaSalida, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) ) AS AmoUltimaSalidaDiaTranscurridos
//			
//			
//			
//			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];		
		}		
		
	//Accion eliminar	 
	
	public function MtdEliminarTrasladoAlmacenEntradaDetalle($oElementos) {
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
//					if($i==count($elementos)){						
//						$eliminar .= '  (TedId = "'.($elemento).'")';	
//					}else{
//						$eliminar .= '  (TedId = "'.($elemento).'")  OR';	
//					}	

					if(!$error) {		
						$sql = 'DELETE FROM tblamdalmacenmovimientodetalle WHERE  (AmdId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}
					}

				}
			$i++;
	
			}
		
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	


	public function MtdRegistrarTrasladoAlmacenEntradaDetalle() {
	
			$this->MtdGenerarTrasladoAlmacenEntradaDetalleId();
			
			$sql = 'INSERT INTO tblamdalmacenmovimientodetalle (
			AmdId,
			AmoId,	
			ProId,
			UmeId,
			
			FaaId,
			FapId,
			VddId,
			PcdId,
			
			AmdIdAnterior,
			AmdIdOrigen,
			
			AmdCantidad,
			AmdCantidadReal,
			AmdUbicacion,
		
			AlmId,
			AmdFecha,
			AmdEstado,
			AmdTiempoCreacion,
			AmdTiempoModificacion
			) 
			VALUES (
			"'.($this->TedId).'", 
			"'.($this->TaeId).'", 
			"'.($this->ProId).'",
			"'.trim($this->UmeId).'",
			
			NULL,
			NULL,
			NULL,
			NULL,
			
			NULL,
			'.(empty($this->TedIdOrigen)?'NULL, ':'"'.$this->TedIdOrigen.'",').'
		
			'.($this->TedCantidad).',
			'.($this->TedCantidadReal).',
			"'.($this->TedUbicacion).'",
			
			"'.($this->AlmId).'",
			"'.($this->TedFecha).'",
			'.($this->TedEstado).',
			"'.($this->TedTiempoCreacion).'",
			"'.($this->TedTiempoModificacion).'");';					
		
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
	
	public function MtdEditarTrasladoAlmacenEntradaDetalle() {

			$sql = 'UPDATE tblamdalmacenmovimientodetalle SET 	
			UmeId = "'.trim($this->UmeId).'",
			ProId = "'.trim($this->ProId).'",
			AmdCantidad = '.($this->TedCantidad).',
			AmdCantidadReal = '.($this->TedCantidadReal).',
			AmdUbicacion = "'.($this->TedUbicacion).'",
			
			AlmId = "'.($this->AlmId).'",
			AmdFecha = "'.($this->TedFecha).'",			
			AmdEstado = '.($this->TedEstado).'
			WHERE AmdId = "'.($this->TedId).'";';
					
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
		
		
	//public function MtdEditarProductoDato($oCampo,$oDato,$oProductoId) {


	public function MtdEditarTrasladoAlmacenEntradaDetalleDato($oCampo,$oDato,$oTrasladoAlmacenEntradaDetalleId) {

			$sql = 'UPDATE tblamdalmacenmovimientodetalle SET 	
			'.(empty($oDato)?$oCampo.' = NULL ':$oCampo.' = "'.$oDato.'"').'
			 WHERE TedId = "'.($oTrasladoAlmacenEntradaDetalleId).'";';
					
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
			
		
		 public function MtdObtenerUltimoTrasladoAlmacenEntradaDetalleId($oProductoId,$oFecha){

		$sql = 'SELECT
			 
			amd.AmdId,			
			amd.AmoId,
			amd.ProId,
			amd.UmeId,
			
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume.UmeNombre,
	        DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha"
			
			FROM tblamdalmacenmovimientodetalle amd
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON amd.UmeId = ume.UmeId				
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							LEFT JOIN tblfaafichaaccionmantenimiento faa
							ON amd.FaaId = faa.FaaId

		WHERE amd.ProId = "'.$oProductoId.'" 
		AND amo.AmoTipo = 1
		AND amo.AmoFecha < "'.$oFecha.'"
		ORDER BY amo.AmoFecha DESC LIMIT 1';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);
			
			$Respuesta = $fila['TedId'];

		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
		
		
	 public function MtdVerificarExisteUltimoTrasladoAlmacenEntradaDetalleId($oTrasladoAlmacenEntradaDetalleId){
		
		$Existe = false;
		
		$sql = 'SELECT
			 
			amd.AmdId,			
			amd.AmoId,
			amd.ProId,
			amd.UmeId,
			
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume.UmeNombre,
	        DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha"
			
			FROM tblamdalmacenmovimientodetalle amd
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON amd.UmeId = ume.UmeId				
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							LEFT JOIN tblfaafichaaccionmantenimiento faa
							ON amd.FaaId = faa.FaaId

		WHERE amd.AmdId = "'.$oTrasladoAlmacenEntradaDetalleId.'" 
	
		';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);
			
			if(!empty($fila['TedId'])){
				$Existe = true;		
			}

		}
		
        
		return $Existe;

    }
		
		/*public function MtdEditarTrasladoAlmacenEntradaDetalleDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblamdalmacenmovimientodetalle SET 
			'.(empty($oDato)?$oCampo.' = NULL  ':$oCampo.' = "'.$oDato.'" ').'
		
			WHERE TedId = "'.($oId).'";';
			
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
*/
}
?>