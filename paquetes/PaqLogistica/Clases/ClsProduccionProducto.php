<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsProduccionProducto
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsProduccionProducto {

    public $PprId;
	
	public $AlmId;
	public $PprFecha;
	
    public $PprObservacion;
	
	public $PprCierre;
	public $PprEstado;
	public $PprTiempoCreacion;
	public $PprTiempoModificacion;
    public $PprEliminado;
	
	public $PprTotalItems;
	public $ProduccionProductoDetalle;

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

	public function MtdGenerarProduccionProductoId() {


		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(ppr.PprId,9),unsigned)) AS "MAXIMO"
		FROM tblpprproduccionproducto ppr
			WHERE YEAR(ppr.PprFecha) = '.$this->PprAno.';';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
		if(empty($fila['MAXIMO'])){			
			$this->PprId = "PR-".$this->PprAno."-00001";
		}else{
			$fila['MAXIMO']++;
			$this->PprId = "PR-".$this->PprAno."-".str_pad($fila['MAXIMO'], 5, "0", STR_PAD_LEFT);	
		}
				
	}
		
    public function MtdObtenerProduccionProducto(){

        $sql = 'SELECT 
        ppr.PprId,
		ppr.PerId,
		
		ppr.AlmId,
	
			
		DATE_FORMAT(ppr.PprFecha, "%d/%m/%Y") AS "NPprFecha",
	
		ppr.MonId,
		ppr.PprTipoCambio,
		ppr.PprPorcentajeImpuestoVenta,
		
		ppr.PprObservacion,
		ppr.PprCierre,
		ppr.PprEstado,
		DATE_FORMAT(ppr.PprTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPprTiempoCreacion",
        DATE_FORMAT(ppr.PprTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPprTiempoModificacion",
		
		(
			SELECT 
			amo.AmoId
			FROM tblamoalmacenmovimiento amo
			WHERE amo.PprId = ppr.PprId AND amo.AmoTipo = 1
			ORDER BY amo.AmoTiempoCreacion DESC
			LIMIT 1
		) AS AmoIdIngreso,
		
		
		(
			SELECT 
			amo.AmoId
			FROM tblamoalmacenmovimiento amo
			WHERE amo.PprId = ppr.PprId AND amo.AmoTipo = 2
			ORDER BY amo.AmoTiempoCreacion DESC
			LIMIT 1
		) AS AmoIdSalida,
				
				
		(SELECT COUNT(ppd.PpdId) FROM tblppdproduccionproductodetalle ppd WHERE ppd.PprId = ppr.PprId ) AS "PprTotalItems",
		
		alm.AlmNombre,
		alm.AlmDireccion,
		alm.AlmDistrito,
		alm.AlmProvincia,
		alm.AlmDepartamento

        FROM tblpprproduccionproducto ppr
			
			LEFT JOIN tblalmalmacen alm
			ON ppr.AlmId = alm.AlmId
				
        WHERE ppr.PprId = "'.$this->PprId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$InsProduccionProductoDetalle = new ClsProduccionProductoDetalle();
			
			$this->PprId = $fila['PprId'];
			$this->PerId = $fila['PerId'];

			$this->AlmId = $fila['AlmId'];
			$this->AlmIdDestino = $fila['AlmIdDestino'];
			
			$this->PprFecha = $fila['NPprFecha'];
			$this->PprFechaLlegada = $fila['NPprFechaLlegada'];
			
			$this->MonId = $fila['MonId'];
			$this->PprTipoCambio = $fila['PprTipoCambio'];
			$this->PprPorcentajeImpuestoVenta = $fila['PprPorcentajeImpuestoVenta'];

			$this->PprObservacion = $fila['PprObservacion'];

			$this->PprCierre = $fila['PprCierre'];
			$this->PprEstado = $fila['PprEstado'];
			$this->PprTiempoCreacion = $fila['NPprTiempoCreacion']; 
			$this->PprTiempoModificacion = $fila['NPprTiempoModificacion']; 
			
			$this->AmoIdIngreso = $fila['AmoIdIngreso']; 	
			$this->AmoIdSalida = $fila['AmoIdSalida']; 		

			$this->PprTotalItems = $fila['PprTotalItems'];

			$this->AlmNombre = $fila['AlmNombre'];
			$this->AlmDireccion = $fila['AlmDireccion'];
			$this->AlmDistrito = $fila['AlmDistrito'];
			$this->AlmProvincia = $fila['AlmProvincia'];
			$this->AlmDepartamento = $fila['AlmDepartamento'];

		
			//MtdObtenerProduccionProductoDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PpdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTrasladoAlmacen=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTipo=NULL)
				
			$ResProduccionProductoDetalle =  $InsProduccionProductoDetalle->MtdObtenerProduccionProductoDetalles(NULL,NULL,"PpdId","ASC",NULL,$this->PprId,NULL,NULL,NULL,NULL,"1");
			$this->ProduccionProductoDetalleEntrada = $ResProduccionProductoDetalle['Datos'];	
			
			
			$ResProduccionProductoDetalle =  $InsProduccionProductoDetalle->MtdObtenerProduccionProductoDetalles(NULL,NULL,"PpdId","ASC",NULL,$this->PprId,NULL,NULL,NULL,NULL,"2");
			$this->ProduccionProductoDetalleSalida = $ResProduccionProductoDetalle['Datos'];	


		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}

		return $Respuesta;

    }

	public function MtdObtenerProduccionProductoes($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'PprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL) {

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
				
				
				$filtrar .= '  OR EXISTS( 
					
					SELECT 
					ppd.PpdId
					
					FROM tblppdproduccionproductodetalle ppd
						
						LEFT JOIN tblproproducto pro
						ON ppd.ProId = pro.ProId
						
							
								
								
					WHERE 
					
						ppd.PprId = ppr.PprId
						AND
						(
							pro.ProNombre LIKE "%'.$oFiltro.'%" OR
							pro.ProCodigoOriginal LIKE "%'.$oFiltro.'%"  OR
							pro.ProCodigoAlternativo LIKE "%'.$oFiltro.'%" 
						)
						

					) ';
					
					
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
				$fecha = ' AND DATE(ppr.PprFecha)>="'.$oFechaInicio.'" AND DATE(ppr.PprFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(ppr.PprFecha)>="'.$oFechaInicio.'"';
			}
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ppr.PprFecha)<="'.$oFechaFin.'"';		
			}			
		}

		if(!empty($oEstado)){
			$esppdo = ' AND ppr.PprEstado = '.$oEstado;
		}


			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				ppr.PprId,
				ppr.PerId,
				
				DATE_FORMAT(ppr.PprFecha, "%d/%m/%Y") AS "NPprFecha",
							
				ppr.MonId,
				ppr.PprTipoCambio,
				ppr.PprPorcentajeImpuestoVenta,
				
				ppr.PprObservacion,
				ppr.PprCierre,
				ppr.PprEstado,
				DATE_FORMAT(ppr.PprTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPprTiempoCreacion",
	        	DATE_FORMAT(ppr.PprTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPprTiempoModificacion",
				
				(
					SELECT 
					amo.AmoId
					FROM tblamoalmacenmovimiento amo
					WHERE amo.PprId = ppr.PprId AND amo.AmoTipo = 1
					ORDER BY amo.AmoTiempoCreacion DESC
					LIMIT 1
				) AS AmoIdIngreso,
				
				
				(
					SELECT 
					amo.AmoId
					FROM tblamoalmacenmovimiento amo
					WHERE amo.PprId = ppr.PprId AND amo.AmoTipo = 2
					ORDER BY amo.AmoTiempoCreacion DESC
					LIMIT 1
				) AS AmoIdSalida,
				
				(SELECT COUNT(ppd.PpdId) FROM tblppdproduccionproductodetalle ppd WHERE ppd.PprId = ppr.PprId ) AS "PprTotalItems",
				
				alm.AlmNombre,
			
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno

				FROM tblpprproduccionproducto ppr
				
					LEFT JOIN tblalmalmacen alm
					ON ppr.AlmId = alm.AlmId
					
						
							LEFT JOIN tblperpersonal per
							ON ppr.PerId = per.PerId
							
				WHERE 1 = 1 '.$filtrar.$fecha.$tipo.$stipo.$esppdo.$moneda.$cocompra.$vdirecta.$ocompra.$faccion.$fingreso.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsProduccionProducto = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ProduccionProducto = new $InsProduccionProducto();
                    $ProduccionProducto->PprId = $fila['PprId'];
					$ProduccionProducto->PerId = $fila['PerId'];

					$ProduccionProducto->AlmId = $fila['AlmId'];
					
					$ProduccionProducto->PprFecha = $fila['NPprFecha'];
					
					$ProduccionProducto->MonId = $fila['MonId'];
					$ProduccionProducto->PprTipoCambio = $fila['PprTipoCambio'];
					$ProduccionProducto->PprPorcentajeImpuestoVenta = $fila['PprPorcentajeImpuestoVenta'];

					$ProduccionProducto->PprObservacion = $fila['PprObservacion'];
					$ProduccionProducto->PprCierre = $fila['PprCierre'];
					$ProduccionProducto->PprEstado = $fila['PprEstado'];
					$ProduccionProducto->PprTiempoCreacion = $fila['NPprTiempoCreacion'];  
					$ProduccionProducto->PprTiempoModificacion = $fila['NPprTiempoModificacion']; 
					
					$ProduccionProducto->AmoIdIngreso = $fila['AmoIdIngreso']; 
					$ProduccionProducto->AmoIdSalida = $fila['AmoIdSalida']; 

					$ProduccionProducto->PprTotalItems = $fila['PprTotalItems']; 

					$ProduccionProducto->AlmNombre = $fila['AlmNombre'];
				
					$ProduccionProducto->PerNombre = $fila['PerNombre'];
					$ProduccionProducto->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$ProduccionProducto->PerApellidoMaterno = $fila['PerApellidoMaterno'];

					switch($ProduccionProducto->PprEstado){

						case 1:
							$ProduccionProducto->PprEstadoDescripcion = "Pendiente";
						break;

						case 3:
							$ProduccionProducto->PprEstadoDescripcion = "Realizado";
						break;	

						default:
							$ProduccionProducto->PprEstadoDescripcion = "";
						break;

					}

                    $ProduccionProducto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ProduccionProducto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOPPR',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOPPR'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		


	
	//Accion eliminar	 
	public function MtdEliminarProduccionProducto($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsProduccionProductoDetalle = new ClsProduccionProductoDetalle();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){
					
					$ResProduccionProductoDetalle = $InsProduccionProductoDetalle->MtdObtenerProduccionProductoDetalles(NULL,NULL,'PpdId','ASC',NULL,$elemento);
					$ArrProduccionProductoDetalles = $ResProduccionProductoDetalle['Datos'];

					if(!empty($ArrProduccionProductoDetalles)){
						$amdetalle = '';

						foreach($ArrProduccionProductoDetalles as $DatProduccionProductoDetalle){
							$amdetalle .= '#'.$DatProduccionProductoDetalle->PpdId;
						}

						if(!$InsProduccionProductoDetalle->MtdEliminarProduccionProductoDetalle($amdetalle)){								
							$error = true;
						}
							
					}
					
					if(!$error) {		
						$sql = 'DELETE FROM tblpprproduccionproducto WHERE  (PprId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarProduccionProducto(3,"Se elimino la Conversion de Producto",$aux);		
						}
					}
					
				}
			$i++;

			}

			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}							
	}
	
	
	//Accion eliminar	 
	public function MtdActualizarEstadoProduccionProducto($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		$InsProduccionProducto = new ClsProduccionProducto();
		$InsProduccionProductoDetalles = new ClsProduccionProductoDetalle();

			$i=1;
			foreach($elementos as $elemento){

				if(!empty($elemento)){

					$sql = 'UPDATE tblpprproduccionproducto SET PprEstado = '.$oEstado.' WHERE PprId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarProduccionProducto(2,"Se actualizo el Estado de la Conversion de Producto",$elemento);
					}

					
				}
			$i++;
	
			}

			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}									
	}
	
	
	public function MtdRegistrarProduccionProducto($oTransaccion=true) {
	
		global $Resultado;
		$error = false;

		$this->MtdGenerarProduccionProductoId();
		
		if($oTransaccion){
			$this->InsMysql->MtdTransaccionIniciar();	
		}
			
		$sql = 'INSERT INTO tblpprproduccionproducto (
		PprId,
		PerId,
		
		PrvId,
		CliId,
		
		AlmId,
		
		CtiId,
		TopId,
		
		PprFecha,
		
		PprObservacion,

		MonId,
		PprTipoCambio,
		
		PprIncluyeImpuesto,		
		PprPorcentajeImpuestoVenta,
		PprCierre,
		PprEstado,			
		PprTiempoCreacion,
		PprTiempoModificacion) 
		VALUES (
		"'.($this->PprId).'", 
		'.(empty($this->PerId)?"NULL,":'"'.$this->PerId.'",').'
		
		"'.($this->PrvId).'", 
		"'.($this->CliId).'", 
		
		'.(empty($this->AlmId)?"NULL,":'"'.$this->AlmId.'",').'
		
		"'.($this->CtiId).'", 
		"'.($this->TopId).'", 
		
		"'.($this->PprFecha).'", 
		
		"'.($this->PprObservacion).'",

		"'.($this->MonId).'",
		'.(empty($this->PprTipoCambio)?"NULL,":'"'.$this->PprTipoCambio.'",').'

		'.($this->PprIncluyeImpuesto).',	
		'.($this->PprPorcentajeImpuestoVenta).',	
		2,
		'.($this->PprEstado).',
		"'.($this->PprTiempoCreacion).'", 				
		"'.($this->PprTiempoModificacion).'");';			

		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

		if(!$resultado) {							
			$error = true;
		} 
		
//		deb($this->ProduccionProductoDetalleEntrada);
		if(!$error){			
			if (!empty($this->ProduccionProductoDetalleEntrada)){		
				
				$item = 1;
				$validar = 0;	
				foreach ($this->ProduccionProductoDetalleEntrada as $DatProduccionProductoDetalle){
					
						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $DatProduccionProductoDetalle->ProId;
						$InsProducto->MtdObtenerProducto(false);
						
						
						$InsProduccionProductoDetalle = new ClsProduccionProductoDetalle();		
						$InsProduccionProductoDetalle->PpdId = NULL;
						$InsProduccionProductoDetalle->PprId = $this->PprId;
						$InsProduccionProductoDetalle->ProId = $DatProduccionProductoDetalle->ProId;
						$InsProduccionProductoDetalle->UmeId = $DatProduccionProductoDetalle->UmeId;
	
						$InsProduccionProductoDetalle->PpdCantidad = $DatProduccionProductoDetalle->PpdCantidad;
						$InsProduccionProductoDetalle->PpdCantidadReal = $DatProduccionProductoDetalle->PpdCantidadReal;
	
						$InsProduccionProductoDetalle->PpdCosto = $DatProduccionProductoDetalle->PpdCosto;
						$InsProduccionProductoDetalle->PpdPrecio = $DatProduccionProductoDetalle->PpdPrecio;
						$InsProduccionProductoDetalle->PpdImporte = $DatProduccionProductoDetalle->PpdImporte;
						$InsProduccionProductoDetalle->PpdTipo = 1;	
					
					
						$InsProduccionProductoDetalle->PpdEstado = $DatProduccionProductoDetalle->PpdEstado;									
						$InsProduccionProductoDetalle->PpdTiempoCreacion = $DatProduccionProductoDetalle->PpdTiempoCreacion;
						$InsProduccionProductoDetalle->PpdTiempoModificacion = $DatProduccionProductoDetalle->PpdTiempoModificacion;						
						$InsProduccionProductoDetalle->PpdEliminado = $DatProduccionProductoDetalle->PpdEliminado;
						
												
												
					if($InsProduccionProductoDetalle->MtdRegistrarProduccionProductoDetalle()){
						$validar++;					
					}else{

						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $DatProduccionProductoDetalle->ProId;
						$InsProducto->MtdObtenerProducto(false);

						$Resultado.='#ERR_PPR_201';
						$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
						//$Resultado.='#Item Numero: '.($validar+1);

					}
					
					$item++;
				}	
				
				if(count($this->ProduccionProductoDetalleEntrada) <> $validar ){
						$error = true;
				}					
						
			}
		}
		
//		deb($this->ProduccionProductoDetalleSalida);
		
		if(!$error){			
			if (!empty($this->ProduccionProductoDetalleSalida)){		
				
				$item = 1;
				$validar = 0;	
				foreach ($this->ProduccionProductoDetalleSalida as $DatProduccionProductoDetalle){

					$InsProduccionProductoDetalle = new ClsProduccionProductoDetalle();		
					$InsProduccionProductoDetalle->PpdId = NULL;
					$InsProduccionProductoDetalle->PprId = $this->PprId;
					$InsProduccionProductoDetalle->ProId = $DatProduccionProductoDetalle->ProId;
					$InsProduccionProductoDetalle->UmeId = $DatProduccionProductoDetalle->UmeId;

					$InsProduccionProductoDetalle->PpdCantidad = $DatProduccionProductoDetalle->PpdCantidad;
					$InsProduccionProductoDetalle->PpdCantidadReal = $DatProduccionProductoDetalle->PpdCantidadReal;

					$InsProduccionProductoDetalle->PpdCosto = $DatProduccionProductoDetalle->PpdCosto;
					$InsProduccionProductoDetalle->PpdPrecio = $DatProduccionProductoDetalle->PpdPrecio;
					$InsProduccionProductoDetalle->PpdImporte = $DatProduccionProductoDetalle->PpdImporte;
					$InsProduccionProductoDetalle->PpdTipo = 2;	
				
					$InsProduccionProductoDetalle->PpdEstado = $DatProduccionProductoDetalle->PpdEstado;									
					$InsProduccionProductoDetalle->PpdTiempoCreacion = $DatProduccionProductoDetalle->PpdTiempoCreacion;
					$InsProduccionProductoDetalle->PpdTiempoModificacion = $DatProduccionProductoDetalle->PpdTiempoModificacion;						
					$InsProduccionProductoDetalle->PpdEliminado = $DatProduccionProductoDetalle->PpdEliminado;


					//if($InsProduccionProductoDetalle->PpdEstado == 3){
						
						$StockReal = 0;
						$Fecha = explode("-",$this->TalFecha);
						$Ano = $Fecha[0];
						
						$InsAlmacenProducto = new ClsAlmacenProducto();
						//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
						$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsTallerPedidoDetalle->ProId,$this->AlmId,$Ano);
						
						if( ($StockReal + $InsProduccionProductoDetalle->PpdCantidadRealAnterior) < $InsProduccionProductoDetalle->PpdCantidadReal and $InsProduccionProductoDetalle->PpdEliminado == 1 and $InsProduccionProductoDetalle->PpdEstado == 3){
						//							
							$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
							$Resultado.='#ERR_PPR_208';												 
							
						}else{
							
							if($InsProduccionProductoDetalle->MtdRegistrarProduccionProductoDetalle()){
								$validar++;					
							}else{
								
								$InsProducto = new ClsProducto();
								$InsProducto->ProId = $DatProduccionProductoDetalle->ProId;
								$InsProducto->MtdObtenerProducto(false);
								
								$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
								$Resultado.='#ERR_PPR_301';
								
								//$Resultado.='#Item Numero: '.($validar+1);
							}
							
						}
					//}
					
					
					
					/*if($InsProduccionProductoDetalle->MtdRegistrarProduccionProductoDetalle()){
						$validar++;					
					}else{
						
						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $DatProduccionProductoDetalle->ProId;
						$InsProducto->MtdObtenerProducto(false);
						
						$Resultado.='#ERR_PPR_301';
						$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
						//$Resultado.='#Item Numero: '.($validar+1);
					}*/
					
					$item++;
				}	
				
				if(count($this->ProduccionProductoDetalleSalida) <> $validar ){
						$error = true;
				}					
						
			}
		}



		if($error) {	
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionDeshacer();			
			}
			return false;
		} else {		
			if($oTransaccion){		
				$this->InsMysql->MtdTransaccionHacer();		
			}
			$this->MtdAuditarProduccionProducto(1,"Se registro la Conversion de Producto",$this);			
			return true;
		}			
					
	}
	
	public function MtdEditarProduccionProducto() {

		global $Resultado;
		$error = false;

			$sql = 'UPDATE tblpprproduccionproducto SET
			'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
			
			CliId = "'.($this->CliId).'",
			PrvId = "'.($this->PrvId).'",
			
			'.(empty($this->AlmId)?'AlmId = NULL, ':'AlmId = "'.$this->AlmId.'",').'
		
			CtiId = "'.($this->CtiId).'",
			TopId = "'.($this->TopId).'",
			
			PprObservacion = "'.($this->PprObservacion).'",
			PprFecha = "'.($this->PprFecha).'",
			
			MonId = "'.($this->MonId).'",
			'.(empty($this->PprTipoCambio)?'PprTipoCambio = NULL, ':'PprTipoCambio = '.$this->PprTipoCambio.',').'
			
			PprIncluyeImpuesto = '.($this->PprIncluyeImpuesto).',
			PprPorcentajeImpuestoVenta = '.($this->PprPorcentajeImpuestoVenta).',
			PprEstado = '.($this->PprEstado).',
			PprTiempoModificacion = "'.($this->PprTiempoModificacion).'"
			WHERE PprId = "'.($this->PprId).'";';			

			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 		
			
			if(!$error){
			
				if (!empty($this->ProduccionProductoDetalleEntrada)){		

					$validar = 0;	
					$item = 1;			
					$InsProduccionProductoDetalle = new ClsProduccionProductoDetalle();
							
					foreach ($this->ProduccionProductoDetalleEntrada as $DatProduccionProductoDetalle){
										
						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $DatProduccionProductoDetalle->ProId;
						$InsProducto->MtdObtenerProducto(false);
												
						$InsProduccionProductoDetalle->PpdId = $DatProduccionProductoDetalle->PpdId;
						$InsProduccionProductoDetalle->PprId = $this->PprId;
						$InsProduccionProductoDetalle->ProId = $DatProduccionProductoDetalle->ProId;
						$InsProduccionProductoDetalle->UmeId = $DatProduccionProductoDetalle->UmeId;

						$InsProduccionProductoDetalle->PpdCosto = $DatProduccionProductoDetalle->PpdCosto;
						$InsProduccionProductoDetalle->PpdCantidad = $DatProduccionProductoDetalle->PpdCantidad;
						$InsProduccionProductoDetalle->PpdCantidadReal = $DatProduccionProductoDetalle->PpdCantidadReal;
						
						$InsProduccionProductoDetalle->PpdCosto = $DatProduccionProductoDetalle->PpdCosto;
						$InsProduccionProductoDetalle->PpdImporte = $DatProduccionProductoDetalle->PpdImporte;
						$InsProduccionProductoDetalle->PpdPrecio = $DatProduccionProductoDetalle->PpdPrecio;
						$InsProduccionProductoDetalle->PpdTipo = 1;		
						
						$InsProduccionProductoDetalle->PpdEstado = $DatProduccionProductoDetalle->PpdEstado;		
						$InsProduccionProductoDetalle->PpdTiempoCreacion = $DatProduccionProductoDetalle->PpdTiempoCreacion;
						$InsProduccionProductoDetalle->PpdTiempoModificacion = $DatProduccionProductoDetalle->PpdTiempoModificacion;
						$InsProduccionProductoDetalle->PpdEliminado = $DatProduccionProductoDetalle->PpdEliminado;
						
						if(empty($InsProduccionProductoDetalle->PpdId)){
							if($InsProduccionProductoDetalle->PpdEliminado<>2){
								
								if(!empty($InsProduccionProductoDetalle->ProId)){
									if(!empty($InsProduccionProductoDetalle->UmeId)){
										if(!empty($InsProduccionProductoDetalle->PpdCantidad)){
											if(!empty($InsProduccionProductoDetalle->PpdCantidadReal)){
				
												if($InsProduccionProductoDetalle->MtdRegistrarProduccionProductoDetalle()){
													$validar++;	
												}else{
													$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
													$Resultado.='#ERR_PPR_201';
													//$Resultado.='#\n';
												}
								
											}else{
												$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
												$Resultado.='#ERR_PPR_215';
												//$Resultado.='#\n';
											}
										}else{
												$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
												$Resultado.='#ERR_PPR_217';
												//$Resultado.='#\n';
										}
									}else{
										$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
										$Resultado.='#ERR_PPR_214';
										//$Resultado.='#\n';
									}
								}else{
									$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
									$Resultado.='#ERR_PPR_216';
									//$Resultado.='#\n';
								}
											
							}else{
								$validar++;
							}
							
						}else{						
							if($InsProduccionProductoDetalle->PpdEliminado==2){
								if($InsProduccionProductoDetalle->MtdEliminarProduccionProductoDetalle($InsProduccionProductoDetalle->PpdId)){
									$validar++;					
								}else{
									$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
									$Resultado.='#ERR_PPR_203';
									//$Resultado.='#\n';
								}
							}else{
								
								if(!empty($InsProduccionProductoDetalle->ProId)){
									if(!empty($InsProduccionProductoDetalle->UmeId)){
										if(!empty($InsProduccionProductoDetalle->PpdCantidad)){
											if(!empty($InsProduccionProductoDetalle->PpdCantidadReal)){
								
												if($InsProduccionProductoDetalle->MtdEditarProduccionProductoDetalle()){
													$validar++;	
												}else{
													$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
													$Resultado.='#ERR_PPR_202';
													//$Resultado.='#\n';	
												}
								
											}else{
												$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
												$Resultado.='#ERR_PPR_215';
												//$Resultado.='#\n';
											}
										}else{
												$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
												$Resultado.='#ERR_PPR_217';
												//$Resultado.='#\n';
										}
									}else{
										$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
										$Resultado.='#ERR_PPR_214';
										//$Resultado.='#\n';
									}
								}else{
									$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
									$Resultado.='#ERR_PPR_216';
									//$Resultado.='#\n';
								}

							}
						}	
						
						$item++;								
					}
					
					if(count($this->ProduccionProductoDetalleEntrada) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			
			
			
			if(!$error){
			
				if (!empty($this->ProduccionProductoDetalleSalida)){		

					$validar = 0;	
					$item = 1;			
					$InsProduccionProductoDetalle = new ClsProduccionProductoDetalle();
							
					foreach ($this->ProduccionProductoDetalleSalida as $DatProduccionProductoDetalle){
										
						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $DatProduccionProductoDetalle->ProId;
						$InsProducto->MtdObtenerProducto(false);
												
						$InsProduccionProductoDetalle->PpdId = $DatProduccionProductoDetalle->PpdId;
						$InsProduccionProductoDetalle->PprId = $this->PprId;
						$InsProduccionProductoDetalle->ProId = $DatProduccionProductoDetalle->ProId;
						$InsProduccionProductoDetalle->UmeId = $DatProduccionProductoDetalle->UmeId;

						$InsProduccionProductoDetalle->PpdCosto = $DatProduccionProductoDetalle->PpdCosto;
						$InsProduccionProductoDetalle->PpdCantidad = $DatProduccionProductoDetalle->PpdCantidad;
						$InsProduccionProductoDetalle->PpdCantidadReal = $DatProduccionProductoDetalle->PpdCantidadReal;
						
						$InsProduccionProductoDetalle->PpdPrecio = $DatProduccionProductoDetalle->PpdPrecio;
						$InsProduccionProductoDetalle->PpdCosto = $DatProduccionProductoDetalle->PpdCosto;
						$InsProduccionProductoDetalle->PpdImporte = $DatProduccionProductoDetalle->PpdImporte;
						$InsProduccionProductoDetalle->PpdTipo = 2;		
						
						$InsProduccionProductoDetalle->PpdEstado = $DatProduccionProductoDetalle->PpdEstado;		
						$InsProduccionProductoDetalle->PpdTiempoCreacion = $DatProduccionProductoDetalle->PpdTiempoCreacion;
						$InsProduccionProductoDetalle->PpdTiempoModificacion = $DatProduccionProductoDetalle->PpdTiempoModificacion;
						$InsProduccionProductoDetalle->PpdEliminado = $DatProduccionProductoDetalle->PpdEliminado;
						
						if(empty($InsProduccionProductoDetalle->PpdId)){
							if($InsProduccionProductoDetalle->PpdEliminado<>2){
								
								if(!empty($InsProduccionProductoDetalle->ProId)){
									if(!empty($InsProduccionProductoDetalle->UmeId)){
										if(!empty($InsProduccionProductoDetalle->PpdCantidad)){
											if(!empty($InsProduccionProductoDetalle->PpdCantidadReal)){
												
												//if($InsProduccionProductoDetalle->PpdEstado == 3){
						
													$StockReal = 0;
													$Fecha = explode("-",$this->TalFecha);
													$Ano = $Fecha[0];
													
													$InsAlmacenProducto = new ClsAlmacenProducto();
													//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
													$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsTallerPedidoDetalle->ProId,$this->AlmId,$Ano);
													
													if( ($StockReal + $InsProduccionProductoDetalle->PpdCantidadRealAnterior) < $InsProduccionProductoDetalle->PpdCantidadReal and $InsProduccionProductoDetalle->PpdEliminado == 1 and $InsProduccionProductoDetalle->PpdEstado == 3){
													//							
														$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
														$Resultado.='#ERR_PPR_208';												 
														
													}else{
														
														if($InsProduccionProductoDetalle->MtdRegistrarProduccionProductoDetalle()){
															$validar++;	
														}else{
															$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
															$Resultado.='#ERR_PPR_201';
															//$Resultado.='#\n';
														}
														
													}
												//}
												
												
												/*if($InsProduccionProductoDetalle->MtdRegistrarProduccionProductoDetalle()){
													$validar++;	
												}else{
													$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
													$Resultado.='#ERR_PPR_201';
													//$Resultado.='#\n';
												}*/
								
											}else{
												$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
												$Resultado.='#ERR_PPR_215';
												//$Resultado.='#\n';
											}
										}else{
												$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
												$Resultado.='#ERR_PPR_217';
												//$Resultado.='#\n';
										}
									}else{
										$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
										$Resultado.='#ERR_PPR_214';
										//$Resultado.='#\n';
									}
								}else{
									$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
									$Resultado.='#ERR_PPR_216';
									//$Resultado.='#\n';
								}
											
							}else{
								$validar++;
							}
							
						}else{						
							if($InsProduccionProductoDetalle->PpdEliminado==2){
								if($InsProduccionProductoDetalle->MtdEliminarProduccionProductoDetalle($InsProduccionProductoDetalle->PpdId)){
									$validar++;					
								}else{
									$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
									$Resultado.='#ERR_PPR_203';
									//$Resultado.='#\n';
								}
							}else{
								
								if(!empty($InsProduccionProductoDetalle->ProId)){
									if(!empty($InsProduccionProductoDetalle->UmeId)){
										if(!empty($InsProduccionProductoDetalle->PpdCantidad)){
											if(!empty($InsProduccionProductoDetalle->PpdCantidadReal)){
												
												
													$StockReal = 0;
													$Fecha = explode("-",$this->TalFecha);
													$Ano = $Fecha[0];
													
													$InsAlmacenProducto = new ClsAlmacenProducto();
													//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
													$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsTallerPedidoDetalle->ProId,$this->AlmId,$Ano);
													
													if( ($StockReal + $InsProduccionProductoDetalle->PpdCantidadRealAnterior) < $InsProduccionProductoDetalle->PpdCantidadReal and $InsProduccionProductoDetalle->PpdEliminado == 1 and $InsProduccionProductoDetalle->PpdEstado == 3){
													//							
														$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
														$Resultado.='#ERR_PPR_208';												 
														
													}else{
														
														if($InsProduccionProductoDetalle->MtdEditarProduccionProductoDetalle()){
															$validar++;	
														}else{
															$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
															$Resultado.='#ERR_PPR_202';
															//$Resultado.='#\n';	
														}
														
													}
								/*
												if($InsProduccionProductoDetalle->MtdEditarProduccionProductoDetalle()){
													$validar++;	
												}else{
													$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
													$Resultado.='#ERR_PPR_202';
													//$Resultado.='#\n';	
												}*/
								
											}else{
												$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
												$Resultado.='#ERR_PPR_215';
												//$Resultado.='#\n';
											}
										}else{
												$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
												$Resultado.='#ERR_PPR_217';
												//$Resultado.='#\n';
										}
									}else{
										$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
										$Resultado.='#ERR_PPR_214';
										//$Resultado.='#\n';
									}
								}else{
									$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
									$Resultado.='#ERR_PPR_216';
									//$Resultado.='#\n';
								}

							}
						}	
						
						$item++;								
					}
					
					if(count($this->ProduccionProductoDetalleSalida) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
				
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarProduccionProducto(2,"Se edito la Conversion de Producto",$this);		
				return true;
			}	
				
		}	
		
		
		public function MtdEditarProduccionProductoDato($oCampo,$oDato,$oProduccionProductoId) {

			$error = false;

			$sql = 'UPDATE tblpprproduccionproducto SET
			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
			PprTiempoModificacion = NOW()
			WHERE PprId = "'.($oProduccionProductoId).'";';			

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
		
	
		private function MtdAuditarProduccionProducto($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria($this->InsMysql);
			$InsAuditoria->AudCodigo = $this->PprId;

			$InsAuditoria->UsuId = $this->UsuId;
			$InsAuditoria->SucId = $this->SucId;
			$InsAuditoria->AudAccion = $oAccion;
			$InsAuditoria->AudDescripcion = $oDescripcion;
$InsAuditoria->AudUsuario = $oUsuario;
		$InsAuditoria->AudPersonal = $oPersonal;
			$InsAuditoria->AudDatos = $oDatos;
			$InsAuditoria->AudTiempoCreacion = date("Y-m-d H:i:s");
			
			if($InsAuditoria->MtdAuditoriaRegistrar()){
				return true;
			}else{
				return false;	
			}
			
		}
}
?>