<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsTrasladoAlmacen
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsTrasladoAlmacen {

    public $TalId;
	
	public $AlmId;
	public $AlmIdDestino;
	
	public $TalFecha;
	public $TalFechaLlegada;
	
    public $TalObservacion;
	
	public $TalCierre;
	public $TalEstado;
	public $TalTiempoCreacion;
	public $TalTiempoModificacion;
    public $TalEliminado;
	
	public $TalTotalItems;
	public $TrasladoAlmacenDetalle;

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarTrasladoAlmacenId() {


		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(tal.TalId,9),unsigned)) AS "MAXIMO"
		FROM tbltaltrasladoalmacen tal
			WHERE YEAR(tal.TalFecha) = '.$this->TalAno.';';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
		if(empty($fila['MAXIMO'])){			
			$this->TalId = "TA-".$this->TalAno."-00001";
		}else{
			$fila['MAXIMO']++;
			$this->TalId = "TA-".$this->TalAno."-".str_pad($fila['MAXIMO'], 5, "0", STR_PAD_LEFT);	
		}
				
	}
		
    public function MtdObtenerTrasladoAlmacen(){

        $sql = 'SELECT 
        tal.TalId,
		tal.PerId,
		
		tal.AlmId,
		tal.AlmIdDestino,	
			
		DATE_FORMAT(tal.TalFecha, "%d/%m/%Y") AS "NTalFecha",
		DATE_FORMAT(tal.TalFechaLlegada, "%d/%m/%Y") AS "NTalFechaLlegada",
		
		tal.MonId,
		tal.TalTipoCambio,
		tal.TalPorcentajeImpuestoVenta,
		
		tal.TalObservacion,
		tal.TalCierre,
		tal.TalEstado,
		DATE_FORMAT(tal.TalTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NTalTiempoCreacion",
        DATE_FORMAT(tal.TalTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NTalTiempoModificacion",
		
		(
			SELECT 
			amo.AmoId
			FROM tblamoalmacenmovimiento amo
			WHERE amo.TalId = tal.TalId AND amo.AmoTipo = 1
			ORDER BY amo.AmoTiempoCreacion DESC
			LIMIT 1
		) AS AmoIdIngreso,
		
		
		(
			SELECT 
			amo.AmoId
			FROM tblamoalmacenmovimiento amo
			WHERE amo.TalId = tal.TalId AND amo.AmoTipo = 2
			ORDER BY amo.AmoTiempoCreacion DESC
			LIMIT 1
		) AS AmoIdSalida,
				
				
		(SELECT COUNT(tad.TadId) FROM tbltadtrasladoalmacendetalle tad WHERE tad.TalId = tal.TalId ) AS "TalTotalItems",
		
		alm.AlmNombre,
		alm.AlmDireccion,
		alm.AlmDistrito,
		alm.AlmProvincia,
		alm.AlmDepartamento,
		
		alm2.AlmNombre AS AlmNombreDestino,
		alm2.AlmDireccion AS AlmDireccionDestino,
		alm2.AlmDistrito AS AlmDistritoDestino,
		alm2.AlmProvincia AS AlmProvinciaDestino,
		alm2.AlmDepartamento AS AlmDepartamentoDestino

        FROM tbltaltrasladoalmacen tal
			
			LEFT JOIN tblalmalmacen alm
			ON tal.AlmId = alm.AlmId
				
				LEFT JOIN tblalmalmacen alm2
				ON tal.AlmIdDestino = alm2.AlmId
			
        WHERE tal.TalId = "'.$this->TalId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$InsTrasladoAlmacenDetalle = new ClsTrasladoAlmacenDetalle();
			
			$this->TalId = $fila['TalId'];
			$this->PerId = $fila['PerId'];

			$this->AlmId = $fila['AlmId'];
			$this->AlmIdDestino = $fila['AlmIdDestino'];
			
			$this->TalFecha = $fila['NTalFecha'];
			$this->TalFechaLlegada = $fila['NTalFechaLlegada'];
			
			$this->MonId = $fila['MonId'];
			$this->TalTipoCambio = $fila['TalTipoCambio'];
			$this->TalPorcentajeImpuestoVenta = $fila['TalPorcentajeImpuestoVenta'];

			$this->TalObservacion = $fila['TalObservacion'];

			$this->TalCierre = $fila['TalCierre'];
			$this->TalEstado = $fila['TalEstado'];
			$this->TalTiempoCreacion = $fila['NTalTiempoCreacion']; 
			$this->TalTiempoModificacion = $fila['NTalTiempoModificacion']; 
			
			$this->AmoIdIngreso = $fila['AmoIdIngreso']; 	
			$this->AmoIdSalida = $fila['AmoIdSalida']; 		

			$this->TalTotalItems = $fila['TalTotalItems'];

			$this->AlmNombre = $fila['AlmNombre'];
			$this->AlmDireccion = $fila['AlmDireccion'];
			$this->AlmDistrito = $fila['AlmDistrito'];
			$this->AlmProvincia = $fila['AlmProvincia'];
			$this->AlmDepartamento = $fila['AlmDepartamento'];

			$this->AlmNombreDestino = $fila['AlmNombreDestino'];
			$this->AlmDireccionDestino = $fila['AlmDireccionDestino'];
			$this->AlmDistritoDestino = $fila['AlmDistritoDestino'];
			$this->AlmProvinciaDestino = $fila['AlmProvinciaDestino'];
			$this->AlmDepartamentoDestino = $fila['AlmDepartamentoDestino'];

			//MtdObtenerTrasladoAlmacenDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'TadId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPedidoCompra=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) {
			$ResTrasladoAlmacenDetalle =  $InsTrasladoAlmacenDetalle->MtdObtenerTrasladoAlmacenDetalles(NULL,NULL,"TadId","ASC",NULL,$this->TalId);
			$this->TrasladoAlmacenDetalle = $ResTrasladoAlmacenDetalle['Datos'];	

		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}

		return $Respuesta;

    }

	public function MtdObtenerTrasladoAlmacenes($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'TalId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL) {

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
					tad.TadId
					
					FROM tbltadtrasladoalmacendetalle tad
						
						LEFT JOIN tblproproducto pro
						ON tad.ProId = pro.ProId
						
							
								
								
					WHERE 
					
						tad.TalId = tal.TalId
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
				$fecha = ' AND DATE(tal.TalFecha)>="'.$oFechaInicio.'" AND DATE(tal.TalFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(tal.TalFecha)>="'.$oFechaInicio.'"';
			}
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(tal.TalFecha)<="'.$oFechaFin.'"';		
			}			
		}

		if(!empty($oEstado)){
			$estado = ' AND tal.TalEstado = '.$oEstado;
		}


			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				tal.TalId,
				tal.PerId,
				
				DATE_FORMAT(tal.TalFecha, "%d/%m/%Y") AS "NTalFecha",
				DATE_FORMAT(tal.TalFechaLlegada, "%d/%m/%Y") AS "NTalFechaLlegada",
							
				tal.MonId,
				tal.TalTipoCambio,
				tal.TalPorcentajeImpuestoVenta,
				
				tal.TalObservacion,
				tal.TalCierre,
				tal.TalEstado,
				DATE_FORMAT(tal.TalTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NTalTiempoCreacion",
	        	DATE_FORMAT(tal.TalTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NTalTiempoModificacion",
				
				(
					SELECT 
					amo.AmoId
					FROM tblamoalmacenmovimiento amo
					WHERE amo.TalId = tal.TalId AND amo.AmoTipo = 1
					ORDER BY amo.AmoTiempoCreacion DESC
					LIMIT 1
				) AS AmoIdIngreso,
				
				
				(
					SELECT 
					amo.AmoId
					FROM tblamoalmacenmovimiento amo
					WHERE amo.TalId = tal.TalId AND amo.AmoTipo = 2
					ORDER BY amo.AmoTiempoCreacion DESC
					LIMIT 1
				) AS AmoIdSalida,
				
				(SELECT COUNT(tad.TadId) FROM tbltadtrasladoalmacendetalle tad WHERE tad.TalId = tal.TalId ) AS "TalTotalItems",
				
				alm.AlmNombre,
				alm2.AlmNombre AS AlmNombreDestino,
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno

				FROM tbltaltrasladoalmacen tal
				
					LEFT JOIN tblalmalmacen alm
					ON tal.AlmId = alm.AlmId
					
						LEFT JOIN tblalmalmacen alm2
						ON tal.AlmIdDestino = alm2.AlmId
						
							LEFT JOIN tblperpersonal per
							ON tal.PerId = per.PerId
							
				WHERE 1 = 1 '.$filtrar.$fecha.$tipo.$stipo.$estado.$moneda.$cocompra.$vdirecta.$ocompra.$faccion.$fingreso.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsTrasladoAlmacen = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$TrasladoAlmacen = new $InsTrasladoAlmacen();
                    $TrasladoAlmacen->TalId = $fila['TalId'];
					$TrasladoAlmacen->PerId = $fila['PerId'];

					$TrasladoAlmacen->AlmId = $fila['AlmId'];
					$TrasladoAlmacen->AlmIdDestino = $fila['AlmIdDestino'];

					$TrasladoAlmacen->TalFecha = $fila['NTalFecha'];
					$TrasladoAlmacen->TalFechaLlegada = $fila['NTalFechaLlegada'];

					$TrasladoAlmacen->MonId = $fila['MonId'];
					$TrasladoAlmacen->TalTipoCambio = $fila['TalTipoCambio'];
					$TrasladoAlmacen->TalPorcentajeImpuestoVenta = $fila['TalPorcentajeImpuestoVenta'];

					$TrasladoAlmacen->TalObservacion = $fila['TalObservacion'];
					
					$TrasladoAlmacen->TalCierre = $fila['TalCierre'];
					$TrasladoAlmacen->TalEstado = $fila['TalEstado'];					
					$TrasladoAlmacen->TalTiempoCreacion = $fila['NTalTiempoCreacion'];  
					$TrasladoAlmacen->TalTiempoModificacion = $fila['NTalTiempoModificacion']; 
					
					$TrasladoAlmacen->AmoIdIngreso = $fila['AmoIdIngreso']; 
					$TrasladoAlmacen->AmoIdSalida = $fila['AmoIdSalida']; 

					$TrasladoAlmacen->TalTotalItems = $fila['TalTotalItems']; 

					$TrasladoAlmacen->AlmNombre = $fila['AlmNombre'];
					$TrasladoAlmacen->AlmNombreDestino = $fila['AlmNombreDestino'];

					$TrasladoAlmacen->PerNombre = $fila['PerNombre'];
					$TrasladoAlmacen->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$TrasladoAlmacen->PerApellidoMaterno = $fila['PerApellidoMaterno'];

					switch($TrasladoAlmacen->TalEstado){

						case 1:
							$TrasladoAlmacen->TalEstadoDescripcion = "Pendiente";
						break;

						case 3:
							$TrasladoAlmacen->TalEstadoDescripcion = "Realizado";
						break;	

						default:
							$TrasladoAlmacen->TalEstadoDescripcion = "";
						break;

					}

                    $TrasladoAlmacen->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $TrasladoAlmacen;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		


	
	//Accion eliminar	 
	public function MtdEliminarTrasladoAlmacen($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsTrasladoAlmacenDetalle = new ClsTrasladoAlmacenDetalle();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){
					
					$ResTrasladoAlmacenDetalle = $InsTrasladoAlmacenDetalle->MtdObtenerTrasladoAlmacenDetalles(NULL,NULL,'TadId','ASC',NULL,$elemento);
					$ArrTrasladoAlmacenDetalles = $ResTrasladoAlmacenDetalle['Datos'];

					if(!empty($ArrTrasladoAlmacenDetalles)){
						$amdetalle = '';

						foreach($ArrTrasladoAlmacenDetalles as $DatTrasladoAlmacenDetalle){
							$amdetalle .= '#'.$DatTrasladoAlmacenDetalle->TadId;
						}

						if(!$InsTrasladoAlmacenDetalle->MtdEliminarTrasladoAlmacenDetalle($amdetalle)){								
							$error = true;
						}
							
					}
					
					if(!$error) {		
						$sql = 'DELETE FROM tbltaltrasladoalmacen WHERE  (TalId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarTrasladoAlmacen(3,"Se elimino la Transferencia entre Almacenes",$aux);		
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
	public function MtdActualizarEstadoTrasladoAlmacen($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		$InsTrasladoAlmacen = new ClsTrasladoAlmacen();
		$InsTrasladoAlmacenDetalles = new ClsTrasladoAlmacenDetalle();

			$i=1;
			foreach($elementos as $elemento){

				if(!empty($elemento)){

					$sql = 'UPDATE tbltaltrasladoalmacen SET TalEstado = '.$oEstado.' WHERE TalId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarTrasladoAlmacen(2,"Se actualizo el Estado dla Transferencia entre Almacenes",$elemento);
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
	
	
	public function MtdRegistrarTrasladoAlmacen($oTransaccion=true) {
	
		global $Resultado;
		$error = false;

		$this->MtdGenerarTrasladoAlmacenId();
		
		if($oTransaccion){
			$this->InsMysql->MtdTransaccionIniciar();	
		}
			
		$sql = 'INSERT INTO tbltaltrasladoalmacen (
		TalId,
		PerId,
		
		PrvId,
		CliId,
		
		AlmId,
		AlmIdDestino,	
		
		CtiId,
		TopId,
		
		TalFecha,
		TalFechaLlegada,

		TalObservacion,

		MonId,
		TalTipoCambio,
		
		TalIncluyeImpuesto,		
		TalPorcentajeImpuestoVenta,
		TalCierre,
		TalEstado,			
		TalTiempoCreacion,
		TalTiempoModificacion) 
		VALUES (
		"'.($this->TalId).'", 
		'.(empty($this->PerId)?"NULL,":'"'.$this->PerId.'",').'
		
		"'.($this->PrvId).'", 
		"'.($this->CliId).'", 
		
		'.(empty($this->AlmId)?"NULL,":'"'.$this->AlmId.'",').'
		'.(empty($this->AlmIdDestino)?"NULL,":'"'.$this->AlmIdDestino.'",').'
		
		"'.($this->CtiId).'", 
		"'.($this->TopId).'", 
		
		"'.($this->TalFecha).'", 
		'.(empty($this->TalFechaLlegada)?"NULL,":'"'.$this->TalFechaLlegada.'",').'

		"'.($this->TalObservacion).'",

		"'.($this->MonId).'",
		'.(empty($this->TalTipoCambio)?"NULL,":'"'.$this->TalTipoCambio.'",').'

		'.($this->TalIncluyeImpuesto).',	
		'.($this->TalPorcentajeImpuestoVenta).',	
		2,
		'.($this->TalEstado).',
		"'.($this->TalTiempoCreacion).'", 				
		"'.($this->TalTiempoModificacion).'");';			

		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

		if(!$resultado) {							
			$error = true;
		} 
		
		if(!$error){			
			if (!empty($this->TrasladoAlmacenDetalle)){		
				
				$item = 1;
				$validar = 0;	
				foreach ($this->TrasladoAlmacenDetalle as $DatTrasladoAlmacenDetalle){

										
					$InsProducto = new ClsProducto();
					$InsProducto->ProId = $DatTrasladoAlmacenDetalle->ProId;
					$InsProducto->MtdObtenerProducto(false);
						
						
					$InsTrasladoAlmacenDetalle = new ClsTrasladoAlmacenDetalle();		
					$InsTrasladoAlmacenDetalle->TadId = NULL;
					$InsTrasladoAlmacenDetalle->TalId = $this->TalId;
					$InsTrasladoAlmacenDetalle->ProId = $DatTrasladoAlmacenDetalle->ProId;
					$InsTrasladoAlmacenDetalle->UmeId = $DatTrasladoAlmacenDetalle->UmeId;

					$InsTrasladoAlmacenDetalle->TadCantidad = $DatTrasladoAlmacenDetalle->TadCantidad;
					$InsTrasladoAlmacenDetalle->TadCantidadReal = $DatTrasladoAlmacenDetalle->TadCantidadReal;
					$InsTrasladoAlmacenDetalle->TadCantidadRealAnterior = $DatTrasladoAlmacenDetalle->TadCantidadRealAnterior;

					$InsTrasladoAlmacenDetalle->TadCosto = $DatTrasladoAlmacenDetalle->TadCosto;
					$InsTrasladoAlmacenDetalle->TadImporte = $DatTrasladoAlmacenDetalle->TadImporte;

					$InsTrasladoAlmacenDetalle->TadEstado = $DatTrasladoAlmacenDetalle->TadEstado;									
					$InsTrasladoAlmacenDetalle->TadTiempoCreacion = $DatTrasladoAlmacenDetalle->TadTiempoCreacion;
					$InsTrasladoAlmacenDetalle->TadTiempoModificacion = $DatTrasladoAlmacenDetalle->TadTiempoModificacion;						
					$InsTrasladoAlmacenDetalle->TadEliminado = $DatTrasladoAlmacenDetalle->TadEliminado;

					//if($InsTrasladoAlmacenDetalle->TadEstado == 3){
						
						$StockReal = 0;
						$Fecha = explode("/",$this->TalFecha);
						$Ano = $Fecha[2];
						
						$InsAlmacenProducto = new ClsAlmacenProducto();
						//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
						$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsTrasladoAlmacenDetalle->ProId,$this->AlmId,$Ano);
						
						
						//if( ($StockReal + $InsTrasladoAlmacenDetalle->TadCantidadRealAnterior) < $InsTrasladoAlmacenDetalle->TadCantidadReal and $InsTrasladoAlmacenDetalle->TadEliminado == 1 and $InsTrasladoAlmacenDetalle->TadEstado == 3){
													
						//	$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
						//	$Resultado.='#ERR_TAL_208';												 
							
					//	}else{
							
							if($InsTrasladoAlmacenDetalle->MtdRegistrarTrasladoAlmacenDetalle()){
								$validar++;					
							}else{
								 $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
								$Resultado.='#ERR_TAL_201';
							}
							
					//	}
					
					
					$item++;
				}	
				
				if(count($this->TrasladoAlmacenDetalle) <> $validar ){
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
			$this->MtdAuditarTrasladoAlmacen(1,"Se registro la Transferencia entre Almacenes",$this);			
			return true;
		}			
					
	}
	
	public function MtdEditarTrasladoAlmacen() {

		global $Resultado;
		$error = false;

			$sql = 'UPDATE tbltaltrasladoalmacen SET
			'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
			
			CliId = "'.($this->CliId).'",
			PrvId = "'.($this->PrvId).'",
			
			'.(empty($this->AlmId)?'AlmId = NULL, ':'AlmId = "'.$this->AlmId.'",').'
			'.(empty($this->AlmIdDestino)?'AlmIdDestino = NULL, ':'AlmIdDestino = "'.$this->AlmIdDestino.'",').'
			
			CtiId = "'.($this->CtiId).'",
			TopId = "'.($this->TopId).'",
			
			TalObservacion = "'.($this->TalObservacion).'",
			TalFecha = "'.($this->TalFecha).'",
			'.(empty($this->TalFechaLlegada)?'TalFechaLlegada = NULL, ':'TalFechaLlegada = "'.$this->TalFechaLlegada.'",').'

			MonId = "'.($this->MonId).'",
			'.(empty($this->TalTipoCambio)?'TalTipoCambio = NULL, ':'TalTipoCambio = '.$this->TalTipoCambio.',').'
			
			TalIncluyeImpuesto = '.($this->TalIncluyeImpuesto).',
			TalPorcentajeImpuestoVenta = '.($this->TalPorcentajeImpuestoVenta).',
			TalEstado = '.($this->TalEstado).',
			TalTiempoModificacion = "'.($this->TalTiempoModificacion).'"
			WHERE TalId = "'.($this->TalId).'";';			

			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 		
			
				if(!$error){
			
				if (!empty($this->TrasladoAlmacenDetalle)){		

					$validar = 0;	
					$item = 1;			
					$InsTrasladoAlmacenDetalle = new ClsTrasladoAlmacenDetalle();
							
					foreach ($this->TrasladoAlmacenDetalle as $DatTrasladoAlmacenDetalle){
										
						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $DatTrasladoAlmacenDetalle->ProId;
						$InsProducto->MtdObtenerProducto(false);
												
						$InsTrasladoAlmacenDetalle->TadId = $DatTrasladoAlmacenDetalle->TadId;
						$InsTrasladoAlmacenDetalle->TalId = $this->TalId;
						$InsTrasladoAlmacenDetalle->ProId = $DatTrasladoAlmacenDetalle->ProId;
						$InsTrasladoAlmacenDetalle->UmeId = $DatTrasladoAlmacenDetalle->UmeId;

						$InsTrasladoAlmacenDetalle->TadCosto = $DatTrasladoAlmacenDetalle->TadCosto;
						$InsTrasladoAlmacenDetalle->TadCantidad = $DatTrasladoAlmacenDetalle->TadCantidad;
						$InsTrasladoAlmacenDetalle->TadCantidadReal = $DatTrasladoAlmacenDetalle->TadCantidadReal;
						$InsTrasladoAlmacenDetalle->TadCantidadRealAnterior = $DatTrasladoAlmacenDetalle->TadCantidadRealAnterior;
						
						$InsTrasladoAlmacenDetalle->TadImporte = $DatTrasladoAlmacenDetalle->TadImporte;
						$InsTrasladoAlmacenDetalle->TadEstado = $DatTrasladoAlmacenDetalle->TadEstado;		
						$InsTrasladoAlmacenDetalle->TadTiempoCreacion = $DatTrasladoAlmacenDetalle->TadTiempoCreacion;
						$InsTrasladoAlmacenDetalle->TadTiempoModificacion = $DatTrasladoAlmacenDetalle->TadTiempoModificacion;
						$InsTrasladoAlmacenDetalle->TadEliminado = $DatTrasladoAlmacenDetalle->TadEliminado;
						
						if(empty($InsTrasladoAlmacenDetalle->TadId)){
							if($InsTrasladoAlmacenDetalle->TadEliminado<>2){
								
								if(!empty($InsTrasladoAlmacenDetalle->ProId)){
									if(!empty($InsTrasladoAlmacenDetalle->UmeId)){
										if(!empty($InsTrasladoAlmacenDetalle->TadCantidad)){
											if(!empty($InsTrasladoAlmacenDetalle->TadCantidadReal)){
												
												
													$StockReal = 0;
													$Fecha = explode("/",$this->TalFecha);
													$Ano = $Fecha[2];
													
													$InsAlmacenProducto = new ClsAlmacenProducto();
												
													$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsTrasladoAlmacenDetalle->ProId,$this->AlmId,$Ano);
													
													//if( ($StockReal + $InsTrasladoAlmacenDetalle->TadCantidadRealAnterior) < $InsTrasladoAlmacenDetalle->TadCantidadReal and $InsTrasladoAlmacenDetalle->TadEliminado == 1 and $InsTrasladoAlmacenDetalle->TadEstado == 3){
																				
													//	 $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
													//	$Resultado.='#ERR_TAL_208';												 
														
												//	}else{
														
														if($InsTrasladoAlmacenDetalle->MtdRegistrarTrasladoAlmacenDetalle()){
															$validar++;					
														}else{
															 $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
															$Resultado.='#ERR_TAL_201';
															
														}
														
													//}
												
								
											}else{
												$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
												$Resultado.='#ERR_TAL_215';
												//$Resultado.='#\n';
											}
										}else{
												$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
												$Resultado.='#ERR_TAL_217';
												//$Resultado.='#\n';
										}
									}else{
										$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
										$Resultado.='#ERR_TAL_214';
										//$Resultado.='#\n';
									}
								}else{
									$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
									$Resultado.='#ERR_TAL_216';
									//$Resultado.='#\n';
								}
											
							}else{
								$validar++;
							}
							
						}else{						
							if($InsTrasladoAlmacenDetalle->TadEliminado==2){
								if($InsTrasladoAlmacenDetalle->MtdEliminarTrasladoAlmacenDetalle($InsTrasladoAlmacenDetalle->TadId)){
									$validar++;					
								}else{
									$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
									$Resultado.='#ERR_TAL_203';
									//$Resultado.='#\n';
								}
							}else{
								
								if(!empty($InsTrasladoAlmacenDetalle->ProId)){
									if(!empty($InsTrasladoAlmacenDetalle->UmeId)){
										if(!empty($InsTrasladoAlmacenDetalle->TadCantidad)){
											if(!empty($InsTrasladoAlmacenDetalle->TadCantidadReal)){
												
													$StockReal = 0;
													$Fecha = explode("/",$this->TalFecha);
													$Ano = $Fecha[2];
													
													$InsAlmacenProducto = new ClsAlmacenProducto();
													
													$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsTrasladoAlmacenDetalle->ProId,$this->AlmId,$Ano); 
													
													//if( ($StockReal + $InsTrasladoAlmacenDetalle->TadCantidadRealAnterior) < $InsTrasladoAlmacenDetalle->TadCantidadReal and $InsTrasladoAlmacenDetalle->TadEliminado == 1 and $InsTrasladoAlmacenDetalle->TadEstado == 3){
																				
													//	 $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
													//	$Resultado.='#ERR_TAL_208';												 
														
													//}else{
														
														if($InsTrasladoAlmacenDetalle->MtdEditarTrasladoAlmacenDetalle()){
															$validar++;	
														}else{
															$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
															$Resultado.='#ERR_TAL_202';
															
														}
														
													//}
												
								
											}else{
												$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
												$Resultado.='#ERR_TAL_215';
												//$Resultado.='#\n';
											}
										}else{
												$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
												$Resultado.='#ERR_TAL_217';
												//$Resultado.='#\n';
										}
									}else{
										$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
										$Resultado.='#ERR_TAL_214';
										//$Resultado.='#\n';
									}
								}else{
									$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
									$Resultado.='#ERR_TAL_216';
									//$Resultado.='#\n';
								}

							}
						}	
						
						$item++;								
					}
					
					if(count($this->TrasladoAlmacenDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
				
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarTrasladoAlmacen(2,"Se edito la Transferencia entre Almacenes",$this);		
				return true;
			}	
				
		}	
		
		
		public function MtdEditarTrasladoAlmacenDato($oCampo,$oDato,$oTrasladoAlmacenId) {

			$error = false;

			$sql = 'UPDATE tbltaltrasladoalmacen SET
			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
			TalTiempoModificacion = NOW()
			WHERE TalId = "'.($oTrasladoAlmacenId).'";';			

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
		
	
		private function MtdAuditarTrasladoAlmacen($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->TalId;

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